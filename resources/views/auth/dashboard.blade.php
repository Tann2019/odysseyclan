@extends('Layouts.app')

@section('title', 'Member Dashboard')

@section('content')
<div class="container py-5 my-5">
    <h1 class="section-title" data-aos="fade-up">MEMBER DASHBOARD</h1>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <div class="row">
        <!-- Left Column - Profile Card -->
        <div class="col-lg-4 mb-4" data-aos="fade-up">
            <div class="card bg-dark-gray border-accent overflow-hidden h-100">
                <div class="card-header bg-primary text-white border-bottom border-accent">
                    <h4 class="mb-0">My Profile</h4>
                </div>
                <div class="card-body text-center">
                    <div class="position-relative mx-auto mb-4" style="width: 150px; height: 150px;">
                        <img src="{{ $member->avatar_url ?? 'https://via.placeholder.com/150x150/333/FFD700?text='.substr($user->name, 0, 1) }}" 
                             alt="{{ $user->name }}" class="rounded-circle border border-accent" 
                             style="width: 150px; height: 150px; object-fit: cover;">
                        
                        <span class="position-absolute bottom-0 end-0 bg-accent text-dark rounded-circle p-2" 
                              style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-{{ strtolower($member->rank) === 'commander' ? 'crown' : (strtolower($member->rank) === 'captain' ? 'shield' : 'user') }}"></i>
                        </span>
                    </div>
                    
                    <h3 class="card-title text-accent mb-1">{{ $member->username }}</h3>
                    <p class="text-light mb-3">{{ $user->email }}</p>
                    
                    <div class="mb-3">
                        <span class="badge bg-primary px-3 py-2 rounded-pill text-uppercase">
                            {{ $member->rank }}
                        </span>
                    </div>
                    
                    <p class="card-text mb-4">
                        {{ $member->description ?? 'No description provided yet. Add a description to tell other members about yourself!' }}
                    </p>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline">
                            <i class="fas fa-edit me-2"></i>Edit Profile
                        </a>
                    </div>
                </div>
                <div class="card-footer bg-dark-gray border-top border-accent">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">Joined: {{ $member->created_at->format('M d, Y') }}</small>
                        <small class="text-muted">ID: {{ $member->discord_id }}</small>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column - Dashboard Content -->
        <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-sm-4 mb-3 mb-sm-0">
                    <div class="card bg-dark-gray border-accent h-100">
                        <div class="card-body text-center">
                            <div class="display-4 text-accent mb-2">
                                <i class="fas fa-medal"></i>
                            </div>
                            <h5 class="card-title">Achievements</h5>
                            <p class="card-text display-6">{{ count($member->achievements ?? []) }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 mb-3 mb-sm-0">
                    <div class="card bg-dark-gray border-accent h-100">
                        <div class="card-body text-center">
                            <div class="display-4 text-accent mb-2">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <h5 class="card-title">Events Attended</h5>
                            <p class="card-text display-6">7</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card bg-dark-gray border-accent h-100">
                        <div class="card-body text-center">
                            <div class="display-4 text-accent mb-2">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <h5 class="card-title">Ranking Points</h5>
                            <p class="card-text display-6">520</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Upcoming Events -->
            <div class="card bg-dark-gray border-accent mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Upcoming Events</h5>
                    <a href="{{ route('events.index') }}" class="btn btn-sm btn-outline-light">View All</a>
                </div>
                <div class="card-body p-0 bg-dark-gray">
                    <div class="list-group list-group-flush bg-dark-gray">
                        <div class="list-group-item bg-dark-gray border-light">
                            <div class="d-flex w-100 justify-content-between bg-dark-gray">
                                <h5 class="mb-1 text-accent">Spring Championship 2025</h5>
                                <small class="text-warning">3 days left</small>
                            </div>
                            <p class="mb-1">Join us for our quarterly championship where clan members compete for the title of Odyssey Champion.</p>
                            <small>Feb 28, 2025 • 18:00 UTC</small>
                        </div>
                        <div class="list-group-item bg-dark-gray border-light">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1 text-accent">Strategy Training Sessions</h5>
                                <small class="text-success">Weekly</small>
                            </div>
                            <p class="mb-1">Weekly training sessions focused on improving team coordination and tactical awareness.</p>
                            <small>Every Thursday • 20:00 UTC</small>
                        </div>
                        <div class="list-group-item bg-dark-gray border-light">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1 text-accent">Clan vs Clan Battle</h5>
                                <small class="text-danger">Major Event</small>
                            </div>
                            <p class="mb-1">Epic showdown against our rivals. All members required to participate.</p>
                            <small>Mar 22, 2025 • 19:00 UTC</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Achievements -->
            <div class="card bg-dark-gray border-accent">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">My Achievements</h5>
                </div>
                <div class="card-body">
                    @if(count($member->achievements ?? []) > 0)
                        <div class="row">
                            @foreach($member->achievements ?? [] as $achievement)
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3 text-accent" style="font-size: 2rem;">
                                            <i class="fas fa-{{ $achievement['icon'] ?? 'award' }}"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0">{{ $achievement['name'] }}</h5>
                                            <p class="mb-0 text-muted small">{{ $achievement['description'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="text-muted mb-3">
                                <i class="fas fa-award fa-4x"></i>
                            </div>
                            <h5>No achievements yet</h5>
                            <p class="mb-0">Participate in clan events and tournaments to earn achievements!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection