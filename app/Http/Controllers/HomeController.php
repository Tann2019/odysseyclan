<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class HomeController extends Controller
{
    public function index()
    {
        return view('index');
    }
    
    public function events()
    {
        // For demonstration, we'll create some sample events
        $events = [
            [
                'id' => 1,
                'title' => 'Spring Championship 2025',
                'type' => 'Tournament',
                'date' => '2025-02-28',
                'image' => '/images/event1.jpg',
                'description' => 'Join us for our quarterly championship where clan members compete for the title of Odyssey Champion.',
                'badge' => '3 Days Left',
                'badge_color' => 'danger'
            ],
            [
                'id' => 2,
                'title' => 'Strategy Training Sessions',
                'type' => 'Training',
                'date' => 'Every Thursday',
                'image' => '/images/event2.jpg',
                'description' => 'Weekly training sessions focused on improving team coordination and tactical awareness.',
                'badge' => 'Weekly',
                'badge_color' => 'success'
            ],
            [
                'id' => 3,
                'title' => 'Anniversary Community Stream',
                'type' => 'Special',
                'date' => '2025-03-15',
                'image' => '/images/event3.jpg',
                'description' => 'Join us for a special stream celebrating our 5th anniversary with giveaways and special guests.',
                'badge' => 'Featured',
                'badge_color' => 'warning'
            ],
            [
                'id' => 4,
                'title' => 'Recruitment Trial',
                'type' => 'Recruitment',
                'date' => '2025-03-05',
                'image' => '/images/event4.jpg',
                'description' => 'Think you have what it takes to join Odyssey? Prove yourself in our recruitment trials.',
                'badge' => 'Open Registration',
                'badge_color' => 'primary'
            ],
            [
                'id' => 5,
                'title' => 'Clan vs Clan Battle',
                'type' => 'Competition',
                'date' => '2025-03-22',
                'image' => '/images/event5.jpg',
                'description' => 'Epic showdown against our rivals. All members required to participate.',
                'badge' => 'Major Event',
                'badge_color' => 'danger'
            ],
            [
                'id' => 6,
                'title' => 'New Game Release Party',
                'type' => 'Social',
                'date' => '2025-04-10',
                'image' => '/images/event6.jpg',
                'description' => 'Join us as we celebrate and explore the latest game release together.',
                'badge' => 'Upcoming',
                'badge_color' => 'info'
            ]
        ];

        return view('events.index', compact('events'));
    }
    
    public function eventShow($id)
    {
        // For demonstration, we'll create a sample event detail based on ID
        $events = [
            1 => [
                'id' => 1,
                'title' => 'Spring Championship 2025',
                'type' => 'Tournament',
                'date' => '2025-02-28',
                'image' => '/images/event1.jpg',
                'description' => 'Join us for our quarterly championship where clan members compete for the title of Odyssey Champion.',
                'badge' => '3 Days Left',
                'badge_color' => 'danger',
                'location' => 'Main Discord Channel',
                'time' => '18:00 UTC',
                'duration' => '4 hours',
                'prizes' => [
                    '1st Place: Champion Title + $100 Gift Card',
                    '2nd Place: $50 Gift Card',
                    '3rd Place: $25 Gift Card'
                ],
                'rules' => [
                    'All participants must be registered clan members',
                    'Standard tournament rules apply',
                    'Match format: Best of 3',
                    'Finals: Best of 5'
                ],
                'organizer' => 'Commander Phoenix'
            ],
            2 => [
                'id' => 2,
                'title' => 'Strategy Training Sessions',
                'type' => 'Training',
                'date' => 'Every Thursday',
                'image' => '/images/event2.jpg',
                'description' => 'Weekly training sessions focused on improving team coordination and tactical awareness.',
                'badge' => 'Weekly',
                'badge_color' => 'success',
                'location' => 'Training Discord Channel',
                'time' => '20:00 UTC',
                'duration' => '2 hours',
                'content' => [
                    'Map strategy analysis',
                    'Team composition review',
                    'Advanced tactics practice',
                    'Role-specific training'
                ],
                'requirements' => [
                    'All members welcome',
                    'Recommended for all ranks',
                    'Voice communication required'
                ],
                'organizer' => 'Captain Vortex'
            ],
            3 => [
                'id' => 3,
                'title' => 'Anniversary Community Stream',
                'type' => 'Special',
                'date' => '2025-03-15',
                'image' => '/images/event3.jpg',
                'description' => 'Join us for a special stream celebrating our 5th anniversary with giveaways and special guests.',
                'badge' => 'Featured',
                'badge_color' => 'warning',
                'location' => 'Twitch and Discord',
                'time' => '19:00 UTC',
                'duration' => '5 hours',
                'highlights' => [
                    'Special guest appearances',
                    'Exclusive game reveals',
                    'Community game sessions',
                    'Premium giveaways'
                ],
                'giveaways' => [
                    'Gaming peripherals',
                    'Gift cards',
                    'Exclusive merchandise',
                    'Game keys'
                ],
                'organizer' => 'Commander Phoenix and the Leadership Team'
            ],
            4 => [
                'id' => 4,
                'title' => 'Recruitment Trial',
                'type' => 'Recruitment',
                'date' => '2025-03-05',
                'image' => '/images/event4.jpg',
                'description' => 'Think you have what it takes to join Odyssey? Prove yourself in our recruitment trials.',
                'badge' => 'Open Registration',
                'badge_color' => 'primary',
                'location' => 'Recruitment Discord Channel',
                'time' => '18:00 UTC',
                'duration' => '3 hours',
                'requirements' => [
                    'Minimum age: 18+',
                    'Voice communication required',
                    'Previous competitive experience preferred'
                ],
                'process' => [
                    'Skill assessment matches',
                    'Team coordination evaluation',
                    'Communication quality check',
                    'Interview with clan leadership'
                ],
                'organizer' => 'Recruitment Officers'
            ],
            5 => [
                'id' => 5,
                'title' => 'Clan vs Clan Battle',
                'type' => 'Competition',
                'date' => '2025-03-22',
                'image' => '/images/event5.jpg',
                'description' => 'Epic showdown against our rivals. All members required to participate.',
                'badge' => 'Major Event',
                'badge_color' => 'danger',
                'location' => 'Competition Server',
                'time' => '19:00 UTC',
                'duration' => '3 hours',
                'opponent' => 'The Phoenix Legion',
                'format' => [
                    'Map pool: Tournament standard',
                    'Match format: Best of 5',
                    'Team size: 6v6'
                ],
                'prizes' => [
                    'Winning clan receives trophy and bragging rights',
                    'Individual MVP award for best performer'
                ],
                'organizer' => 'Commander Phoenix'
            ],
            6 => [
                'id' => 6,
                'title' => 'New Game Release Party',
                'type' => 'Social',
                'date' => '2025-04-10',
                'image' => '/images/event6.jpg',
                'description' => 'Join us as we celebrate and explore the latest game release together.',
                'badge' => 'Upcoming',
                'badge_color' => 'info',
                'location' => 'Main Discord Channel',
                'time' => '21:00 UTC',
                'duration' => '4 hours',
                'game' => 'Stellar Warfare 2',
                'activities' => [
                    'Group play sessions',
                    'Tips and tricks sharing',
                    'First impressions discussion',
                    'Casual tournaments'
                ],
                'organizer' => 'Social Committee'
            ]
        ];

        $event = $events[$id] ?? abort(404);
        
        return view('events.show', compact('event'));
    }
    
    public function leaderboard()
    {
        // Get members sorted by achievements count (for demonstration)
        $members = Member::all()->sortByDesc(function($member) {
            return count(json_decode($member->achievements ?? '[]', true));
        })->take(20)->values();
        
        return view('leaderboard', compact('members'));
    }
    
    public function gallery()
    {
        // Mock gallery data for demonstration
        $galleries = [
            [
                'id' => 1,
                'title' => 'Tournament Victories',
                'count' => 12,
                'cover' => '/images/gallery1.jpg'
            ],
            [
                'id' => 2,
                'title' => 'Training Sessions',
                'count' => 8,
                'cover' => '/images/gallery2.jpg'
            ],
            [
                'id' => 3,
                'title' => 'Community Events',
                'count' => 15,
                'cover' => '/images/gallery3.jpg'
            ],
            [
                'id' => 4,
                'title' => 'Team Building',
                'count' => 6,
                'cover' => '/images/gallery4.jpg'
            ]
        ];
        
        // For demonstration purposes, we'll create a sample set of images
        $images = [];
        for ($i = 1; $i <= 12; $i++) {
            $images[] = [
                'id' => $i,
                'title' => 'Image ' . $i,
                'url' => '/images/gallery/img' . $i . '.jpg',
                'thumbnail' => '/images/gallery/thumb' . $i . '.jpg',
                'category' => array_rand(['Tournament', 'Training', 'Community', 'Team Building']),
                'date' => date('Y-m-d', strtotime('-' . rand(1, 60) . ' days'))
            ];
        }
        
        return view('gallery', compact('galleries', 'images'));
    }
    
    public function join()
    {
        $requirements = [
            'Age 16+',
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
                'answer' => 'Yes, our members must be at least 16 years old due to the competitive nature of our activities and community standards.'
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
