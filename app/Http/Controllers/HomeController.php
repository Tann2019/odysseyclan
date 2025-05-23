<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\News;
use App\Models\Event;
use App\Models\GalleryImage;
use App\Models\Streamer;
use App\Services\TwitchService;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Handle protected routes directly in the methods
     */
    public function __construct()
    {
        // No middleware here
    }
    public function index(TwitchService $twitchService)
    {
        // Get featured/latest content for homepage
        $latestNews = News::published()->latest()->take(3)->get();
        $featuredEvents = Event::active()->featured()->upcoming()->take(3)->get();
        $upcomingEvents = Event::active()->upcoming()->take(3)->get();
        
        // Get current live streamer
        $liveStreamer = $twitchService->getCurrentLiveStreamer();
        // dd($liveStreamer);
        
        return view('index', compact('latestNews', 'featuredEvents', 'upcomingEvents', 'liveStreamer'));
    }
    
    public function news()
    {
        $news = News::published()->latest()->paginate(12);
        return view('news.index', compact('news'));
    }
    
    public function newsShow($id)
    {
        $article = News::published()->findOrFail($id);
        return view('news.show', compact('article'));
    }
    
    public function events(Request $request)
    {
        // Check if user is verified member
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $user = Auth::user();
        if (!$user->isAdmin() && (!$user->member || !$user->member->isVerified())) {
            if (!$user->member) {
                return redirect()->route('profile.edit')
                    ->with('error', 'You must complete your profile first.');
            }
            
            if ($user->member->isPending()) {
                return redirect()->route('verification.pending');
            } elseif ($user->member->isRejected()) {
                return redirect()->route('verification.rejected');
            }
            
            return redirect()->route('verification.pending');
        }
        
        // Get real events from database
        $query = Event::with('creator')->active();
        
        // Filter by type if requested
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }
        
        $events = $query->latest('event_date')->get();

        return view('events.index', compact('events'));
    }
    
    public function eventShow(Request $request, $id)
    {
        // Check if user is verified member
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $user = Auth::user();
        if (!$user->isAdmin() && (!$user->member || !$user->member->isVerified())) {
            if (!$user->member) {
                return redirect()->route('profile.edit')
                    ->with('error', 'You must complete your profile first.');
            }
            
            if ($user->member->isPending()) {
                return redirect()->route('verification.pending');
            } elseif ($user->member->isRejected()) {
                return redirect()->route('verification.rejected');
            }
            
            return redirect()->route('verification.pending');
        }
        
        // Get the actual event from database
        $event = Event::with('creator')->active()->findOrFail($id);
        
        // Get related events for suggestions
        $relatedEvents = Event::active()
            ->where('id', '!=', $id)
            ->where('type', $event->type)
            ->take(2)
            ->get();
            
        // If not enough related events of same type, get any other events
        if ($relatedEvents->count() < 2) {
            $additionalEvents = Event::active()
                ->where('id', '!=', $id)
                ->whereNotIn('id', $relatedEvents->pluck('id'))
                ->take(2 - $relatedEvents->count())
                ->get();
            $relatedEvents = $relatedEvents->merge($additionalEvents);
        }
        
        return view('events.show', compact('event', 'relatedEvents'));
    }
    
    public function leaderboard(Request $request)
    {
        // Check if user is verified member
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $user = Auth::user();
        if (!$user->isAdmin() && (!$user->member || !$user->member->isVerified())) {
            if (!$user->member) {
                return redirect()->route('profile.edit')
                    ->with('error', 'You must complete your profile first.');
            }
            
            if ($user->member->isPending()) {
                return redirect()->route('verification.pending');
            } elseif ($user->member->isRejected()) {
                return redirect()->route('verification.rejected');
            }
            
            return redirect()->route('verification.pending');
        }
        
        // Get members sorted by achievements count (for demonstration)
        $members = Member::all()->sortByDesc(function($member) {
            return count($member->achievements ?? []);
        })->take(20)->values();
        
        return view('leaderboard', compact('members'));
    }
    
    public function gallery(Request $request)
    {
        // Check if user is verified member
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $user = Auth::user();
        if (!$user->isAdmin() && (!$user->member || !$user->member->isVerified())) {
            if (!$user->member) {
                return redirect()->route('profile.edit')
                    ->with('error', 'You must complete your profile first.');
            }
            
            if ($user->member->isPending()) {
                return redirect()->route('verification.pending');
            } elseif ($user->member->isRejected()) {
                return redirect()->route('verification.rejected');
            }
            
            return redirect()->route('verification.pending');
        }
        
        // Get gallery images from database
        $category = $request->input('category');
        $query = GalleryImage::query();
        
        if ($category) {
            $query->where('category', $category);
        }
        
        $images = $query->ordered()->get();
        $categories = GalleryImage::select('category')->distinct()->pluck('category');
        
        // Get category statistics for galleries display
        $galleries = [];
        foreach ($categories as $cat) {
            $count = GalleryImage::where('category', $cat)->count();
            if ($count > 0) {
                // Get a cover image for this category
                $coverImage = GalleryImage::where('category', $cat)->orderBy('is_featured', 'desc')->first();
                $galleries[] = [
                    'id' => $cat,
                    'title' => ucfirst($cat),
                    'count' => $count,
                    'cover' => $coverImage ? $coverImage->image_url : '/images/logo.png'
                ];
            }
        }
        
        // If no images in database, provide sample galleries
        if (empty($galleries)) {
            $galleries = [
                [
                    'id' => 'tournaments',
                    'title' => 'Tournaments',
                    'count' => 0,
                    'cover' => '/images/logo.png'
                ],
                [
                    'id' => 'training',
                    'title' => 'Training',
                    'count' => 0,
                    'cover' => '/images/logo.png'
                ],
                [
                    'id' => 'events',
                    'title' => 'Events',
                    'count' => 0,
                    'cover' => '/images/logo.png'
                ],
                [
                    'id' => 'general',
                    'title' => 'General',
                    'count' => 0,
                    'cover' => '/images/logo.png'
                ]
            ];
        }
        
        // Transform images for the view
        $transformedImages = $images->map(function ($image) {
            return [
                'id' => $image->id,
                'title' => $image->title,
                'url' => $image->image_url,
                'thumbnail' => $image->image_url,
                'category' => ucfirst($image->category),
                'date' => $image->created_at->format('Y-m-d')
            ];
        });
        
        return view('gallery', compact('transformedImages', 'galleries', 'categories', 'category'))->with('images', $transformedImages);
    }
    
    public function join()
    {
        $requirements = [
            'Age 18+ (mandatory)',
            'Active participation in clan events',
            'Positive attitude and teamwork',
            'Discord participation',
            'Skill level appropriate to rank'
        ];
        
        $process = [
            'Submit application through Discord',
            'Initial screening by recruitment team',
            'Tryout matches with clan members',
            'Interview with clan leadership',
            'Probationary period (2 weeks)'
        ];
        
        $faqs = [
            [
                'question' => 'What games does Odyssey Clan primarily play?',
                'answer' => 'We focus on competitive first-person shooters, battle royales, and strategy games. Our current main games include Valorant, Apex Legends, and Counter-Strike 2.'
            ],
            [
                'question' => 'Do I need to be an expert player to join?',
                'answer' => 'Not necessarily. We have different ranks and divisions to accommodate players of various skill levels. We value attitude, teamwork, and willingness to improve as much as raw skill.'
            ],
            [
                'question' => 'How active do I need to be?',
                'answer' => 'We expect members to participate in at least two clan events per month and be active on our Discord server. We understand real-life commitments but value consistent participation.'
            ],
            [
                'question' => 'Is there an age requirement?',
                'answer' => 'Yes, our members must be at least 18 years old due to the competitive nature of our activities and community standards.'
            ],
            [
                'question' => 'Can I join if I play on console instead of PC?',
                'answer' => 'Yes! We have divisions for both PC and console players, though some of our competitive teams are platform-specific.'
            ]
        ];
        
        return view('join', compact('requirements', 'process', 'faqs'));
    }
    
    public function about()
    {
        $history = [
            [
                'year' => '2020',
                'title' => 'Foundation',
                'description' => 'Odyssey Clan was founded by five friends with a passion for competitive gaming and a vision to build an elite gaming community.',
                'icon' => 'fa-flag'
            ],
            [
                'year' => '2021',
                'title' => 'First Tournament Victory',
                'description' => 'The clan secured its first major tournament win, establishing its reputation in the competitive scene.',
                'icon' => 'fa-trophy'
            ],
            [
                'year' => '2022',
                'title' => 'Community Expansion',
                'description' => 'Membership grew significantly, with dedicated divisions for multiple game titles and skill levels.',
                'icon' => 'fa-users'
            ],
            [
                'year' => '2023',
                'title' => 'Partnership Program',
                'description' => 'Odyssey established partnerships with gaming hardware companies and streaming platforms.',
                'icon' => 'fa-handshake'
            ],
            [
                'year' => '2024',
                'title' => 'International Recognition',
                'description' => 'The clan achieved international recognition with members from over 15 countries and participation in global tournaments.',
                'icon' => 'fa-globe'
            ],
            [
                'year' => '2025',
                'title' => '5th Anniversary',
                'description' => 'Celebrating five years of excellence with special events, tournaments, and community initiatives.',
                'icon' => 'fa-cake-candles'
            ]
        ];
        
        $leaders = [
            [
                'username' => 'Phoenix',
                'role' => 'Clan Commander',
                'avatar' => '/images/leaders/phoenix.jpg',
                'description' => 'Founder and visionary leader of Odyssey Clan. Strategic mastermind with over a decade of competitive gaming experience.'
            ],
            [
                'username' => 'Vortex',
                'role' => 'Captain - FPS Division',
                'avatar' => '/images/leaders/vortex.jpg',
                'description' => 'Lead strategist for our first-person shooter teams. Known for innovative tactics and precision training methods.'
            ],
            [
                'username' => 'Midnight',
                'role' => 'Captain - Battle Royale Division',
                'avatar' => '/images/leaders/midnight.jpg',
                'description' => 'Coordinates our battle royale teams with unparalleled map awareness and rotation strategies.'
            ],
            [
                'username' => 'Oracle',
                'role' => 'Training Director',
                'avatar' => '/images/leaders/oracle.jpg',
                'description' => 'Responsible for skill development programs and performance analysis across all divisions.'
            ],
            [
                'username' => 'Titan',
                'role' => 'Community Manager',
                'avatar' => '/images/leaders/titan.jpg',
                'description' => 'Oversees clan communications, events, and member relations. The friendly face of Odyssey leadership.'
            ],
            [
                'username' => 'Spectre',
                'role' => 'Recruitment Officer',
                'avatar' => '/images/leaders/spectre.jpg',
                'description' => 'Heads the recruitment team, identifying and nurturing new talent to join our ranks.'
            ]
        ];
        
        $values = [
            [
                'title' => 'Excellence',
                'description' => 'We strive for mastery in all aspects of gaming, from mechanical skill to strategic thinking.',
                'icon' => 'fa-star'
            ],
            [
                'title' => 'Teamwork',
                'description' => 'Individual glory is secondary to collective success. We win and lose as a team.',
                'icon' => 'fa-people-group'
            ],
            [
                'title' => 'Respect',
                'description' => 'We treat all players, teammates, opponents, and community members with respect.',
                'icon' => 'fa-handshake'
            ],
            [
                'title' => 'Growth',
                'description' => 'Continuous improvement is our path. We learn from victories and defeats alike.',
                'icon' => 'fa-arrow-trend-up'
            ],
            [
                'title' => 'Community',
                'description' => 'Beyond competition, we foster a supportive community where friendships thrive.',
                'icon' => 'fa-heart'
            ],
            [
                'title' => 'Integrity',
                'description' => 'We compete fairly, honestly, and with sportsmanship in all our activities.',
                'icon' => 'fa-shield'
            ]
        ];
        
        return view('about', compact('history', 'leaders', 'values'));
    }
}
