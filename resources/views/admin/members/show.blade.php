@extends('Layouts.app')

@section('title', $member->username . ' - Member Profile')

@section('content')
<div class="container py-5">
    <!-- Header Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-accent">Admin</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.members.index') }}" class="text-accent">Members</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $member->username }}</li>
                        </ol>
                    </nav>
                    <h1 class="display-5 fw-bold text-white mb-2">{{ $member->username }}</h1>
                    <div class="d-flex align-items-center gap-3">
                        <span class="badge bg-{{ 
                            match($member->rank) {
                                'commander' => 'danger',
                                'captain' => 'warning',
                                'veteran' => 'success',
                                'warrior' => 'primary',
                                'recruit' => 'info',
                                default => 'secondary'
                            }
                        }} fs-6 px-3 py-2 text-uppercase">
                            <i class="fas fa-shield-alt me-1"></i> {{ $member->rank }}
                        </span>
                        @if($member->is_active)
                            <span class="badge bg-success fs-6 px-3 py-2">
                                <i class="fas fa-check-circle me-1"></i> Active
                            </span>
                        @else
                            <span class="badge bg-secondary fs-6 px-3 py-2">
                                <i class="fas fa-pause-circle me-1"></i> Inactive
                            </span>
                        @endif
                        <span class="badge bg-{{ 
                            match($member->verification_status) {
                                'verified' => 'success',
                                'pending' => 'warning',
                                'rejected' => 'danger',
                                default => 'secondary'
                            }
                        }} fs-6 px-3 py-2">
                            <i class="fas fa-{{ 
                                match($member->verification_status) {
                                    'verified' => 'check-shield',
                                    'pending' => 'clock',
                                    'rejected' => 'times-circle',
                                    default => 'question-circle'
                                }
                            }} me-1"></i> {{ ucfirst($member->verification_status ?? 'Unknown') }}
                        </span>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.members.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Back to Members
                    </a>
                    <a href="{{ route('admin.members.edit', $member->id) }}" class="btn btn-accent">
                        <i class="fas fa-edit me-2"></i> Edit Member
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Member Avatar & Basic Info -->
            <div class="card bg-dark-gray border-accent mb-4">
                <div class="card-header bg-primary border-accent">
                    <h4 class="mb-0 text-white">
                        <i class="fas fa-user me-2"></i> Member Profile
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row align-items-center mb-4">
                        <div class="col-md-4 text-center">
                            <div class="position-relative d-inline-block">
                                <img src="{{ $member->avatar_url ?? 'https://via.placeholder.com/200x200/333/FFD700?text='.substr($member->username, 0, 1) }}" 
                                     alt="{{ $member->username }}" 
                                     class="rounded-circle border border-accent"
                                     style="width: 200px; height: 200px; object-fit: cover; border-width: 4px !important;">
                                @if($member->is_active)
                                    <div class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-dark" 
                                         style="width: 40px; height: 40px; right: 15px;">
                                        <i class="fas fa-check text-white position-absolute top-50 start-50 translate-middle"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h2 class="text-white mb-3">{{ $member->username }}</h2>
                            @if($member->user)
                                <div class="mb-3">
                                    <h6 class="text-accent mb-1">Account Information</h6>
                                    <p class="text-light mb-1">
                                        <i class="fas fa-user me-2"></i> {{ $member->user->name }}
                                    </p>
                                    <p class="text-light mb-0">
                                        <i class="fas fa-envelope me-2"></i> {{ $member->user->email }}
                                    </p>
                                </div>
                            @endif
                            <div class="mb-3">
                                <h6 class="text-accent mb-1">Discord Information</h6>
                                <p class="text-light mb-0">
                                    <i class="fab fa-discord me-2"></i> {{ $member->discord_id }}
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($member->description)
                    <div class="mb-4">
                        <h5 class="text-accent mb-3">
                            <i class="fas fa-quote-left me-2"></i> About
                        </h5>
                        <div class="p-4 bg-dark rounded border border-secondary">
                            <p class="text-light mb-0 lh-lg" style="font-size: 1.1rem;">
                                {{ $member->description }}
                            </p>
                        </div>
                    </div>
                    @endif

                    @if($member->achievements && count($member->achievements) > 0)
                    <div class="mb-4">
                        <h5 class="text-accent mb-3">
                            <i class="fas fa-trophy me-2"></i> Achievements
                        </h5>
                        <div class="row g-3">
                            @foreach($member->achievements as $achievement)
                            <div class="col-md-6">
                                <div class="p-3 bg-dark rounded border border-secondary d-flex align-items-center">
                                    <i class="fas fa-medal fa-2x text-warning me-3"></i>
                                    <div>
                                        <h6 class="text-light mb-0">{{ $achievement }}</h6>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <div class="mb-4">
                        <h5 class="text-accent mb-3">
                            <i class="fas fa-trophy me-2"></i> Achievements
                        </h5>
                        <div class="text-center py-4">
                            <i class="fas fa-trophy fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">No achievements yet</h6>
                            <p class="text-muted mb-0">This member is working on earning their first achievement!</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Member Timeline -->
            <div class="card bg-dark-gray border-accent">
                <div class="card-header bg-primary border-accent">
                    <h4 class="mb-0 text-white">
                        <i class="fas fa-history me-2"></i> Member Timeline
                    </h4>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="text-accent">{{ $member->created_at->format('F d, Y') }}</h6>
                                <p class="text-light mb-0">Joined Odyssey Clan</p>
                                <small class="text-muted">{{ $member->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        
                        @if($member->verified_at)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6 class="text-accent">{{ $member->verified_at->format('F d, Y') }}</h6>
                                <p class="text-light mb-0">Member Verification Completed</p>
                                <small class="text-muted">{{ $member->verified_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        @endif
                        
                        @if($member->updated_at != $member->created_at)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-warning"></div>
                            <div class="timeline-content">
                                <h6 class="text-accent">{{ $member->updated_at->format('F d, Y') }}</h6>
                                <p class="text-light mb-0">Profile Last Updated</p>
                                <small class="text-muted">{{ $member->updated_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Stats Card -->
            <div class="card bg-dark-gray border-accent mb-4">
                <div class="card-header bg-primary border-accent">
                    <h5 class="mb-0 text-white">
                        <i class="fas fa-chart-bar me-2"></i> Member Stats
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-dark rounded">
                        <span class="text-light fw-semibold">Rank</span>
                        <span class="badge bg-{{ 
                            match($member->rank) {
                                'commander' => 'danger',
                                'captain' => 'warning',
                                'veteran' => 'success',
                                'warrior' => 'primary',
                                'recruit' => 'info',
                                default => 'secondary'
                            }
                        }} fs-6 text-uppercase">{{ $member->rank }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-dark rounded">
                        <span class="text-light fw-semibold">Status</span>
                        @if($member->is_active)
                            <span class="badge bg-success fs-6">Active</span>
                        @else
                            <span class="badge bg-secondary fs-6">Inactive</span>
                        @endif
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-dark rounded">
                        <span class="text-light fw-semibold">Verification</span>
                        <span class="badge bg-{{ 
                            match($member->verification_status) {
                                'verified' => 'success',
                                'pending' => 'warning',
                                'rejected' => 'danger',
                                default => 'secondary'
                            }
                        }} fs-6">{{ ucfirst($member->verification_status ?? 'Unknown') }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center p-3 bg-dark rounded">
                        <span class="text-light fw-semibold">Achievements</span>
                        <span class="badge bg-warning text-dark fs-6">{{ $member->achievements ? count($member->achievements) : 0 }}</span>
                    </div>
                </div>
            </div>

            <!-- Time in Clan -->
            <div class="card bg-dark-gray border-accent mb-4">
                <div class="card-header bg-primary border-accent">
                    <h5 class="mb-0 text-white">
                        <i class="fas fa-calendar-alt me-2"></i> Time in Clan
                    </h5>
                </div>
                <div class="card-body text-center py-5">
                    <div class="display-4 text-accent fw-bold mb-3">{{ (int)$member->created_at->diffInDays() }}</div>
                    <div class="text-muted fs-5 mb-3">{{ Str::plural('day', (int)$member->created_at->diffInDays()) }} as member</div>
                    <small class="text-muted">Joined {{ $member->created_at->diffForHumans() }}</small>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card bg-dark-gray border-accent">
                <div class="card-header bg-primary border-accent">
                    <h5 class="mb-0 text-white">
                        <i class="fas fa-bolt me-2"></i> Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('admin.members.edit', $member->id) }}" class="btn btn-accent btn-lg">
                            <i class="fas fa-edit me-2"></i> Edit Member
                        </a>
                        
                        @if($member->verification_status === 'pending')
                            <a href="{{ route('admin.verification.show', $member->id) }}" class="btn btn-outline-warning btn-lg">
                                <i class="fas fa-clock me-2"></i> Review Verification
                            </a>
                        @endif
                        
                        @if($member->is_active)
                            <div class="btn btn-outline-success btn-lg disabled">
                                <i class="fas fa-check-circle me-2"></i> Member Active
                            </div>
                        @else
                            <div class="btn btn-outline-secondary btn-lg disabled">
                                <i class="fas fa-pause-circle me-2"></i> Member Inactive
                            </div>
                        @endif
                        
                        <button type="button" class="btn btn-outline-danger btn-lg" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-user-times me-2"></i> Deactivate Member
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-header border-accent">
                <h5 class="modal-title text-accent">
                    <i class="fas fa-exclamation-triangle me-2"></i> Deactivate Member
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="fas fa-user-times fa-3x text-danger mb-3"></i>
                    <h5 class="text-light">Are you sure you want to deactivate this member?</h5>
                </div>
                <div class="alert alert-warning">
                    <strong>{{ $member->username }}</strong>
                    <p class="mb-0 mt-2">This will mark the member as inactive but will not delete their data. They can be reactivated later.</p>
                </div>
            </div>
            <div class="modal-footer border-accent">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i> Cancel
                </button>
                <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-user-times me-2"></i> Deactivate Member
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.border-accent {
    border-color: var(--accent) !important;
}

.breadcrumb {
    background: none;
    padding: 0;
}

.breadcrumb-item + .breadcrumb-item::before {
    color: var(--accent);
    content: "›";
}

.card-header.bg-primary {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark)) !important;
}

.btn-lg {
    padding: 0.75rem 1.5rem;
    font-size: 1.1rem;
}

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: var(--accent);
}

.timeline-item {
    position: relative;
    padding-bottom: 30px;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -23px;
    top: 5px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 2px solid var(--dark-gray);
}

.timeline-content {
    background: var(--dark);
    padding: 15px;
    border-radius: 8px;
    border: 1px solid var(--light-gray);
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card {
    animation: fadeInUp 0.6s ease-out;
}
</style>
@endsection