@extends('Layouts.app')

@section('title', 'Home')

@section('content')
<div class="hero-section">
    <div class="container hero-content">
        <div class="row">
            <div class="col-lg-8 col-md-10" data-aos="fade-up">
                <h1 class="hero-title">WELCOME TO <span>ODYSSEY</span></h1>
                <p class="hero-subtitle">Where legends are forged in the heat of battle</p>
                <div class="hero-btn-container d-flex flex-wrap gap-3">
                    <a href="https://discord.gg/hwkZtRZGJs" class="btn hero-btn" target="_blank">
                        <i class="fas fa-user-plus me-2"></i> Join the Legion
                    </a>
                    <a href="#about" class="btn btn-outline">
                        <i class="fas fa-info-circle me-2"></i> Learn More
                    </a>
                    <a href="https://exclaim.gg/store/odyssey-clan" target="_blank" class="btn hero-btn">
                        <i class="fas fa-shopping-cart me-2"></i> Official Merch
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@if($liveStreamer)
<section class="py-5 bg-dark-gray" id="live-stream" data-aos="fade-down">
    <div class="container my-5">
        <h2 class="section-title" data-aos="fade-up">
            <i class="fas fa-circle text-danger me-2" style="font-size: 0.5em; animation: pulse 2s infinite;"></i>
            LIVE NOW
        </h2>
        <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="100">
            <div class="col-lg-10 col-xl-8">
                <div class="stream-container bg-dark p-3 rounded position-relative" style="border: 3px solid var(--accent); box-shadow: 0 0 20px rgba(255, 215, 0, 0.3);">
                    <!-- Stream Info Header -->
                    <div class="stream-info mb-3 p-3 bg-primary rounded">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="text-white mb-1">
                                    <i class="fab fa-twitch me-2 text-accent"></i>
                                    {{ $liveStreamer->display_name }}
                                </h5>
                                @if($liveStreamer->stream_title)
                                    <p class="text-white-50 mb-1 small">{{ $liveStreamer->stream_title }}</p>
                                @endif
                                @if($liveStreamer->game_name)
                                    <span class="badge bg-accent text-dark">{{ $liveStreamer->game_name }}</span>
                                @endif
                            </div>
                            <div class="col-md-4 text-md-end">
                                @if($liveStreamer->viewer_count)
                                    <div class="text-white">
                                        <i class="fas fa-eye me-1"></i>
                                        {{ number_format($liveStreamer->viewer_count) }} viewers
                                        {{-- @dd($liveStreamer->twitch_embed_url) --}}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Twitch Embed -->
                    <div class="ratio ratio-16x9">
                        <iframe 
                            id="twitch-embed"
                            src="https://player.twitch.tv/?channel={{$liveStreamer->twitch_username}}&parent={{ request()->getHost() }}" 
                            height="100%" 
                            width="100%" 
                            allowfullscreen="true" 
                            scrolling="no" 
                            frameborder="0">
                        </iframe>
                        
                        <!-- Fallback content if iframe fails to load -->
                        {{-- <div id="embed-fallback" style="display: none;" class="d-flex flex-column align-items-center justify-content-center h-100 bg-dark text-white">
                            <i class="fab fa-twitch fa-4x text-purple mb-3"></i>
                            <h4 class="mb-3">{{ $liveStreamer->display_name }} is Live!</h4>
                            @if($liveStreamer->stream_title)
                                <p class="mb-3 text-center">{{ $liveStreamer->stream_title }}</p>
                            @endif
                            <a href="{{ $liveStreamer->twitch_channel_url }}" target="_blank" class="btn btn-purple btn-lg">
                                <i class="fab fa-twitch me-2"></i> Watch on Twitch
                            </a>
                        </div> --}}
                    </div>
                    
                    <!-- Stream Actions -->
                    <div class="text-center mt-3">
                        <a href="{{ $liveStreamer->twitch_channel_url }}" target="_blank" class="btn btn-accent me-2">
                            <i class="fab fa-twitch me-2"></i> Watch on Twitch
                        </a>
                        <a href="https://discord.gg/hwkZtRZGJs" target="_blank" class="btn btn-outline">
                            <i class="fab fa-discord me-2"></i> Join Chat
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<section class="py-5" id="about">
    <div class="container my-5">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                <h2 class="section-title text-start">WHO WE ARE</h2>
                <p class="lead text-accent mb-4">A brotherhood of elite gamers, forged in the heat of battle and bound by honor.</p>
                 <div class="d-flex gap-4 mt-4">
                    <div class="text-center">
                        <h3 class="text-accent"></h3>
                        <p class="text-uppercase"></p>
                    </div>
                    <div class="text-center">
                        <h3 class="text-accent"></h3>
                        <p class="text-uppercase"></p>
                    </div>
                    <div class="text-center">
                        <h3 class="text-accent"></h3>
                        <p class="text-uppercase"></p>
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-6" data-aos="fade-left">
                <img src="/images/hero.png" alt="Odyssey Team" class="img-fluid rounded" style="border: 3px solid var(--accent);">
            </div> --}}
        </div>
    </div>
</section>

<section class="py-5 bg-dark-gray">
    <div class="container my-5">
        <h2 class="section-title" data-aos="fade-up">FEATURED MEMBERS</h2>
        
        <div class="row" id="featured-members">
            <!-- Display clan captains -->
            @php
            $captains = App\Models\Member::where('rank', 'captain')->where('is_active', true)->get();
            @endphp
            
            @forelse($captains as $captain)
            <div class="col-md-4 mb-4" data-aos="fade-up">
                <div class="member-card p-3 text-center">
                    <img src="{{ $captain->avatar_url ?? '/images/default-avatar.png' }}" 
                         alt="{{ $captain->username }}" 
                         class="rounded-circle mb-3"
                         style="width: 120px; height: 120px; object-fit: cover; border: 3px solid var(--spartan-gold);">
                    <h4 style="color: var(--spartan-gold)">{{ $captain->username }}</h4>
                    <div class="badge bg-danger mb-2">{{ $captain->rank }}</div>
                    <p class="mb-0">{{ $captain->description ?? 'A mighty captain of Odyssey' }}</p>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p>No captains found. Check back soon!</p>
            </div>
            @endforelse
        </div>
        
        <div class="text-center mt-4" data-aos="fade-up">
            <a href="/members" class="btn btn-outline">
                <i class="fas fa-users me-2"></i> View All Members
            </a>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container my-5">
        <h2 class="section-title" data-aos="fade-up">UPCOMING EVENTS</h2>
        
        @if($upcomingEvents->count() > 0)
            <div class="row">
                @foreach($upcomingEvents as $event)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="card h-100 {{ $event->is_featured ? 'card-highlight' : '' }}">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span>{{ ucfirst($event->type) }}</span>
                                @if($event->is_featured)
                                    <span class="badge bg-warning text-dark">Featured</span>
                                @elseif((int)$event->days_left <= 3)
                                    <span class="badge bg-danger">{{ (int)$event->days_left }} Days Left</span>
                                @else
                                    <span class="badge bg-{{ $event->type_color }}">{{ ucfirst($event->type) }}</span>
                                @endif
                            </div>
                            @if($event->image_url)
                                <img src="{{ $event->image_url }}" class="card-img-top" alt="{{ $event->title }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-dark d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="fas fa-calendar-alt fa-3x text-muted"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $event->title }}</h5>
                                <p class="card-text">{{ Str::limit($event->description, 100) }}</p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span><i class="far fa-calendar-alt me-2"></i>{{ $event->event_date->format('M d, Y') }}</span>
                                    <a href="/events/{{ $event->id }}" class="btn btn-sm btn-outline">Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-calendar-plus fa-3x text-white mb-3"></i>
                <h5 class="text-white">No upcoming events</h5>
                <p class="text-white">Check back soon for new clan events and tournaments!</p>
            </div>
        @endif
        
        <div class="text-center mt-4" data-aos="fade-up">
            <a href="/events" class="btn btn-outline">
                <i class="fas fa-calendar-alt me-2"></i> View All Events
            </a>
        </div>
    </div>
</section>

<section class="py-5 bg-primary">
    <div class="container my-5">
        <div class="row align-items-center" data-aos="fade-up">
            <div class="col-lg-8">
                <h2 class="display-5 fw-bold text-white mb-3">
                    <i class="fas fa-tshirt me-3 text-accent"></i>
                    REPRESENT THE CLAN
                </h2>
                <p class="lead text-white mb-4">
                    Show your Odyssey pride with our exclusive merchandise collection. 
                    High-quality apparel designed for warriors, by warriors.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <span class="badge bg-warning text-dark px-3 py-2 fs-6">Premium Quality</span>
                    <span class="badge bg-warning text-dark px-3 py-2 fs-6">Exclusive Designs</span>
                    <span class="badge bg-warning text-dark px-3 py-2 fs-6">Limited Edition</span>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                <a href="https://exclaim.gg/store/odyssey-clan" target="_blank" class="btn btn-accent btn-lg px-5 py-3">
                    <i class="fas fa-shopping-cart me-2"></i> Shop Now
                </a>
                <div class="mt-3">
                    {{-- <small class="text-white opacity-75">Free shipping on orders over $50</small> --}}
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-dark-gray">
    <div class="container my-5">
        <h2 class="section-title" data-aos="fade-up">LATEST NEWS</h2>
        
        @if($latestNews->count() > 0)
            <div class="row">
                @foreach($latestNews as $article)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="card h-100">
                            @if($article->image_url)
                                <img src="{{ $article->image_url }}" class="card-img-top" alt="{{ $article->title }}" style="height: 200px; object-fit: cover;">
                            @endif
                            <div class="card-body">
                                <div class="small text-accent mb-2">{{ $article->published_at->format('F d, Y') }}</div>
                                <h5 class="card-title">{{ $article->title }}</h5>
                                <p class="card-text">{{ $article->excerpt ?? Str::limit($article->content, 120) }}</p>
                                <div class="mt-auto">
                                    <a href="/news/{{ $article->id }}" class="btn btn-sm btn-outline">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-newspaper fa-3x text-white mb-3"></i>
                <h5 class="text-white">No news articles</h5>
                <p class="text-white">Check back soon for the latest clan updates and announcements!</p>
            </div>
        @endif
    </div>
</section>

<!-- JavaScript for dynamic content -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate stats numbers (for demonstration)
    function animateValue(id, start, end, duration) {
        const obj = document.getElementById(id);
        if (!obj) return; // Check if element exists
        
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            obj.textContent = Math.floor(progress * (end - start) + start);
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }

    // Example stat animations
    animateValue("total-victories", 0, 157, 2000);
    animateValue("achievements", 0, 42, 2000);
    
    // Handle Twitch embed fallback
    @if($liveStreamer ?? false)
    const twitchIframe = document.getElementById('twitch-embed');
    const fallbackDiv = document.getElementById('embed-fallback');
    
    // Check if iframe loads successfully after a delay
    setTimeout(() => {
        if (twitchIframe) {
            try {
                // Try to access the iframe's content to see if it loaded
                const iframeDoc = twitchIframe.contentDocument || twitchIframe.contentWindow.document;
                if (!iframeDoc || iframeDoc.location.href === 'about:blank') {
                    showEmbedFallback();
                }
            } catch (e) {
                // Cross-origin restriction means it probably loaded successfully
                console.log('Twitch embed loaded (cross-origin access blocked as expected)');
            }
        }
    }, 3000);
    
    // Listen for CSP violations
    document.addEventListener('securitypolicyviolation', function(e) {
        if (e.blockedURI.includes('twitch.tv')) {
            console.warn('Twitch embed blocked by CSP:', e);
            showEmbedFallback();
        }
    });
    @endif
});

function showEmbedFallback() {
    const twitchIframe = document.getElementById('twitch-embed');
    const fallbackDiv = document.getElementById('embed-fallback');
    
    if (twitchIframe && fallbackDiv) {
        twitchIframe.style.display = 'none';
        fallbackDiv.style.display = 'flex';
    }
}
</script>
@endsection