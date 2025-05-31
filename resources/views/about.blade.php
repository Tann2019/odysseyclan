@extends('Layouts.app')

@section('title', 'About Us')

@section('extra-css')
<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 50px;
    }
    
    .timeline-item:last-child {
        margin-bottom: 0;
    }
    
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -30px;
        top: 0;
        width: 2px;
        height: 100%;
        background-color: var(--accent);
    }
    
    .timeline-marker {
        position: absolute;
        left: -39px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: var(--accent);
        box-shadow: 0 0 0 4px var(--dark);
    }
    
    .leader-card {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
    }
    
    .leader-card:hover {
        transform: translateY(-2px);
    }
    
    .leader-avatar {
        height: 250px;
        object-fit: cover;
        transition: all 0.5s ease;
    }
    
    .leader-card:hover .leader-avatar {
        transform: scale(1.02);
    }
    
    .leader-info {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 20px;
        background: linear-gradient(to top, rgba(0,0,0,0.9), transparent);
    }
    
    .value-card {
        border-radius: 10px;
        overflow: hidden;
        height: 100%;
        border: 1px solid var(--light-gray);
        transition: all 0.3s ease;
    }
    
    .value-card:hover {
        transform: translateY(-2px);
        border-color: var(--accent);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    
    .value-icon {
        width: 60px;
        height: 60px;
        background-color: var(--primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        border: 2px solid var(--accent);
    }
    
    .value-card:hover .value-icon {
        background-color: var(--accent);
        color: var(--dark);
    }
</style>
@endsection

@section('content')
<div class="container py-5 my-5">
    <h1 class="section-title" data-aos="fade-up">ABOUT ODYSSEY CLAN</h1>
    
    <!-- Clan Mission -->
    <div class="row mb-5 align-items-center">
        <div class="col-lg-6 order-lg-2 mb-4 mb-lg-0" data-aos="fade-left">
            <img src="/images/about-mission.jpg" alt="Odyssey Clan Mission" class="img-fluid rounded" style="border: 3px solid var(--accent);">
        </div>
        <div class="col-lg-6 order-lg-1" data-aos="fade-right">
            <h2 class="text-accent mb-4">Our Mission</h2>
            <p class="lead">To forge an elite community of skilled gamers bound by honor, teamwork, and a relentless pursuit of excellence.</p>
            <p>Odyssey Clan was established with a clear vision: to create more than just a gaming group. We set out to build a brotherhood of like-minded players who share our passion for competitive gaming and our commitment to continuous improvement.</p>
            <p>We emphasize skill development, strategic innovation, and maintaining a positive community where members can thrive. Our structured rank system encourages progression and rewards dedication, while our regular events foster camaraderie and team spirit.</p>
            <div class="d-flex gap-4 mt-4">
                <div class="text-center">
                    <h3 class="text-accent">5+</h3>
                    <p class="text-uppercase">Years Active</p>
                </div>
                <div class="text-center">
                    <h3 class="text-accent">15+</h3>
                    <p class="text-uppercase">Countries</p>
                </div>
                <div class="text-center">
                    <h3 class="text-accent">50+</h3>
                    <p class="text-uppercase">Active Members</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- History Timeline -->
    <div class="row mb-5">
        <div class="col-12" data-aos="fade-up">
            <h2 class="text-center mb-5">Our Journey</h2>
            <div class="timeline">
                @foreach($history as $milestone)
                <div class="timeline-item" data-aos="fade-up">
                    <div class="timeline-marker"></div>
                    <div class="card bg-dark-gray">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3 text-accent fw-bold" style="font-size: 1.5rem;">{{ $milestone['year'] }}</div>
                                <h3 class="mb-0">{{ $milestone['title'] }}</h3>
                                <div class="ms-auto">
                                    <i class="fas {{ $milestone['icon'] }} fa-2x text-accent"></i>
                                </div>
                            </div>
                            <p class="mb-0">{{ $milestone['description'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <!-- Leadership -->
    <div class="row mb-5">
        <div class="col-12" data-aos="fade-up">
            <h2 class="text-center mb-4">Leadership Team</h2>
            <p class="text-center mb-5">Meet the elite warriors who guide our clan to victory.</p>
            
            <div class="row">
                @foreach($leaders as $leader)
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="leader-card">
                        <img src="{{ $leader['avatar'] }}" alt="{{ $leader['username'] }}" class="leader-avatar img-fluid w-100">
                        <div class="leader-info">
                            <h4 class="text-white mb-1">{{ $leader['username'] }}</h4>
                            <div class="badge bg-danger mb-2">{{ $leader['role'] }}</div>
                            <p class="text-white-50 mb-0 small">{{ $leader['description'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <!-- Core Values -->
    <div class="row mb-5">
        <div class="col-12" data-aos="fade-up">
            <h2 class="text-center mb-5">Our Core Values</h2>
            
            <div class="row">
                @foreach($values as $value)
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="value-card p-4 text-center">
                        <div class="value-icon">
                            <i class="fas {{ $value['icon'] }} fa-2x"></i>
                        </div>
                        <h4 class="text-accent mb-3">{{ $value['title'] }}</h4>
                        <p class="mb-0">{{ $value['description'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <!-- Join CTA -->
    <div class="row">
        <div class="col-lg-10 mx-auto" data-aos="fade-up">
            <div class="card bg-dark-gray border-accent overflow-hidden">
                <div class="card-body p-5 text-center">
                    <h2 class="text-accent mb-3">Ready to Join Our Ranks?</h2>
                    <p class="mb-4">Become part of a gaming legacy and push your skills to new heights with Odyssey Clan.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('join') }}" class="btn btn-lg btn-accent">
                            <i class="fas fa-user-plus me-2"></i> Join Odyssey
                        </a>
                        <a href="https://discord.gg/odyssey" class="btn btn-lg btn-outline" target="_blank">
                            <i class="fab fa-discord me-2"></i> Discord Server
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('extra-js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // For demonstration - handle missing images
        document.querySelectorAll('img').forEach(img => {
            if (img.src.includes('/images/about-mission.jpg') || img.src.includes('/images/leaders/')) {
                img.onerror = function() {
                    if (this.src.includes('about-mission')) {
                        this.src = 'https://via.placeholder.com/800x500/333333/FFD700?text=Odyssey+Clan+Mission';
                    } else {
                        const leaderName = this.src.split('/').pop().split('.')[0];
                        this.src = `https://via.placeholder.com/400x500/333333/FFD700?text=${leaderName}`;
                    }
                };
            }
        });
    });
</script>
@endsection

@endsection