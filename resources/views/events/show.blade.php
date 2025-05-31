@extends('Layouts.app')

@section('title', $event->title)

@section('content')
<div class="container py-5">
    <!-- Header Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-accent">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('events.index') }}" class="text-accent">Events</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $event->title }}</li>
                        </ol>
                    </nav>
                    <h1 class="display-5 fw-bold text-white mb-2">{{ $event->title }}</h1>
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        @if($event->is_featured)
                            <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                                <i class="fas fa-star me-1"></i> Featured Event
                            </span>
                        @endif
                        <span class="badge bg-{{ $event->type_color }} fs-6 px-3 py-2 text-uppercase">
                            <i class="fas fa-tag me-1"></i> {{ $event->type }}
                        </span>
                        @if($event->event_date->isFuture())
                            @if((int)$event->days_left == 0)
                                <span class="badge bg-success fs-6 px-3 py-2">
                                    <i class="fas fa-clock me-1"></i> Today!
                                </span>
                            @elseif((int)$event->days_left <= 7)
                                <span class="badge bg-danger fs-6 px-3 py-2">
                                    <i class="fas fa-hourglass-half me-1"></i> {{ (int)$event->days_left }} days left
                                </span>
                            @else
                                <span class="badge bg-info fs-6 px-3 py-2">
                                    <i class="fas fa-calendar-alt me-1"></i> {{ (int)$event->days_left }} days left
                                </span>
                            @endif
                        @else
                            <span class="badge bg-secondary fs-6 px-3 py-2">
                                <i class="fas fa-history me-1"></i> Past Event
                            </span>
                        @endif
                    </div>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('events.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Back to Events
                    </a>
                    @if($event->event_date->isFuture() && (!$event->registration_deadline || $event->registration_deadline->isFuture()))
                        <a href="https://discord.gg/odyssey" class="btn btn-accent" target="_blank">
                            <i class="fab fa-discord me-2"></i> Join Event
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Event Image -->
            @if($event->image_url)
            <div class="card bg-dark-gray border-accent mb-4">
                <div class="position-relative">
                    <img src="{{ $event->image_url }}" class="card-img-top" alt="{{ $event->title }}" 
                         style="height: 400px; object-fit: cover; border-radius: 0.5rem 0.5rem 0 0;">
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-gradient-overlay"></div>
                    <div class="position-absolute bottom-0 start-0 p-4">
                        <h3 class="text-white mb-2">{{ $event->title }}</h3>
                        <p class="text-light mb-0 opacity-75">
                            <i class="fas fa-calendar me-2"></i>{{ $event->event_date->format('F d, Y \a\t H:i') }} UTC
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Event Details -->
            <div class="card bg-dark-gray border-accent mb-4">
                <div class="card-header bg-primary border-accent">
                    <h4 class="mb-0 text-white">
                        <i class="fas fa-info-circle me-2"></i> Event Details
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-dark rounded border border-accent">
                                <div class="me-3">
                                    <i class="fas fa-calendar-alt fa-2x text-accent"></i>
                                </div>
                                <div>
                                    <h6 class="text-accent mb-1">Event Date & Time</h6>
                                    <p class="text-white mb-0 fw-semibold">{{ $event->event_date->format('F d, Y') }}</p>
                                    <small class="text-white">{{ $event->event_date->format('H:i') }} UTC</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-dark rounded border border-accent">
                                <div class="me-3">
                                    <i class="fas fa-hourglass-half fa-2x text-accent"></i>
                                </div>
                                <div>
                                    <h6 class="text-accent mb-1">Time Until Event</h6>
                                    @if($event->event_date->isPast())
                                        <p class="text-secondary mb-0 fw-semibold">Event Completed</p>
                                        <small class="text-white">{{ (int)$event->event_date->diffForHumans() }}</small>
                                    @else
                                        <p class="text-warning mb-0 fw-semibold">{{ (int)$event->days_left }} {{ Str::plural('day', (int)$event->days_left) }}</p>
                                        <small class="text-white"> &nbsp; </small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($event->registration_deadline)
                    <div class="alert alert-{{ $event->registration_deadline->isPast() ? 'danger' : ($event->registration_deadline->diffInDays() <= 3 ? 'warning' : 'info') }} mb-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-clock me-3 fa-lg"></i>
                            <div>
                                <h6 class="mb-1">Registration Deadline</h6>
                                <p class="mb-0">{{ $event->registration_deadline->format('F d, Y \a\t H:i') }}</p>
                                @if($event->registration_deadline->isPast())
                                    <small class="text-white">Registration has closed</small>
                                @else
                                    <small class="text-white">{{ $event->registration_deadline->diffForHumans() }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($event->max_participants)
                    <div class="d-flex align-items-center p-3 bg-dark rounded border border-accent mb-4">
                        <div class="me-3">
                            <i class="fas fa-users fa-2x text-accent"></i>
                        </div>
                        <div>
                            <h6 class="text-accent mb-1">Participant Limit</h6>
                            <p class="text-white mb-0 fw-semibold">Maximum {{ $event->max_participants }} participants</p>
                        </div>
                    </div>
                    @endif

                    <div class="mb-4">
                        <h5 class="text-accent mb-3">
                            <i class="fas fa-align-left me-2"></i> Event Description
                        </h5>
                        <div class="p-4 bg-dark rounded border border-secondary">
                            <div class="text-light lh-lg" style="font-size: 1.1rem;">
                                {!! nl2br(e($event->description)) !!}
                            </div>
                        </div>
                    </div>

                    @if($event->additional_info && count($event->additional_info) > 0)
                    <div class="mb-4">
                        <h5 class="text-accent mb-3">
                            <i class="fas fa-plus-circle me-2"></i> Additional Information
                        </h5>
                        <div class="row g-3">
                            @foreach($event->additional_info as $key => $value)
                            <div class="col-md-6">
                                <div class="p-3 bg-dark rounded border border-secondary">
                                    <h6 class="text-warning mb-2">{{ ucfirst(str_replace('_', ' ', $key)) }}</h6>
                                    @if(is_array($value))
                                        <ul class="list-unstyled mb-0">
                                            @foreach($value as $item)
                                                <li class="text-light mb-1">
                                                    <i class="fas fa-chevron-right me-2 text-accent"></i>{{ $item }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-light mb-0">{{ $value }}</p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Creator Info -->
            <div class="card bg-dark-gray border-accent">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-user-crown fa-2x text-accent"></i>
                            </div>
                            <div>
                                <h6 class="text-accent mb-1">Event Organizer</h6>
                                <p class="text-white mb-0 fw-semibold">{{ $event->creator->name }}</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <small class="text-white d-block">Created {{ $event->created_at->format('F d, Y') }}</small>
                            @if($event->updated_at != $event->created_at)
                                <small class="text-white d-block">Updated {{ $event->updated_at->diffForHumans() }}</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Event Status -->
            <div class="card bg-dark-gray border-accent mb-4">
                <div class="card-header bg-primary border-accent">
                    <h5 class="mb-0 text-white">
                        <i class="fas fa-chart-line me-2"></i> Event Status
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-dark rounded">
                        <span class="text-light fw-semibold">Current Status</span>
                        @if($event->event_date->isPast())
                            <span class="badge bg-secondary fs-6">Completed</span>
                        @elseif((int)$event->days_left == 0)
                            <span class="badge bg-success fs-6">Today!</span>
                        @elseif((int)$event->days_left <= 7)
                            <span class="badge bg-warning text-dark fs-6">{{ (int)$event->days_left }} days left</span>
                        @else
                            <span class="badge bg-info fs-6">{{ (int)$event->days_left }} days left</span>
                        @endif
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-dark rounded">
                        <span class="text-light fw-semibold">Event Type</span>
                        <span class="badge bg-{{ $event->type_color }} fs-6 text-uppercase">{{ $event->type }}</span>
                    </div>
                    
                    @if($event->is_featured)
                    <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-dark rounded">
                        <span class="text-light fw-semibold">Featured</span>
                        <span class="badge bg-warning text-dark fs-6">
                            <i class="fas fa-star me-1"></i> Yes
                        </span>
                    </div>
                    @endif
                    
                    @if($event->max_participants)
                    <div class="d-flex justify-content-between align-items-center p-3 bg-dark rounded">
                        <span class="text-light fw-semibold">Max Participants</span>
                        <span class="badge bg-primary fs-6">{{ $event->max_participants }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Countdown Card -->
            @if($event->event_date->isFuture())
            <div class="card bg-dark-gray border-accent mb-4">
                <div class="card-header bg-primary border-accent">
                    <h5 class="mb-0 text-white">
                        <i class="fas fa-stopwatch me-2"></i> Countdown
                    </h5>
                </div>
                <div class="card-body text-center py-5">
                    <div class="display-3 text-accent fw-bold mb-3" id="countdown-days">{{ (int)$event->days_left }}</div>
                    <div class="text-white fs-5 mb-3">{{ Str::plural('day', (int)$event->days_left) }} remaining</div>
                    <div class="progress mb-3" style="height: 8px;">
                        @php
                            $totalDays = $event->created_at->diffInDays($event->event_date);
                            $remainingDays = now()->diffInDays($event->event_date);
                            $progress = $totalDays > 0 ? (($totalDays - $remainingDays) / $totalDays) * 100 : 100;
                        @endphp
                        <div class="progress-bar bg-accent" style="width: {{ $progress }}%"></div>
                    </div>
                    <small class="text-white">{{ $event->event_date->diffForHumans() }}</small>
                </div>
            </div>
            @endif

            <!-- Event Registration -->
            @auth
                @if(Auth::user()->member && Auth::user()->member->isVerified())
                    <div class="card bg-dark-gray border-accent mb-4">
                        <div class="card-header bg-primary border-accent">
                            <h5 class="mb-0 text-white">
                                <i class="fas fa-user-check me-2"></i> Event Registration
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($event->max_participants)
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-light">Participants</span>
                                        <span class="text-accent fw-bold">{{ $event->registered_count }}/{{ $event->max_participants }}</span>
                                    </div>
                                    <div class="progress mb-2" style="height: 8px;">
                                        @php $participantProgress = $event->max_participants > 0 ? ($event->registered_count / $event->max_participants) * 100 : 0; @endphp
                                        <div class="progress-bar bg-accent" style="width: {{ min($participantProgress, 100) }}%"></div>
                                    </div>
                                    @if($event->spots_remaining !== null)
                                        <small class="text-light">{{ $event->spots_remaining }} spots remaining</small>
                                    @endif
                                </div>
                            @endif

                            @php $isSignedUp = $event->isUserSignedUp(Auth::user()->member->id); @endphp
                            
                            @if($isSignedUp)
                                <div class="alert alert-success mb-3">
                                    <i class="fas fa-check-circle me-2"></i>
                                    You are registered for this event!
                                </div>
                                @if($event->event_date->isFuture())
                                    <form method="POST" action="{{ route('events.cancel', $event) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-lg w-100" 
                                                onclick="return confirm('Are you sure you want to cancel your registration?')">
                                            <i class="fas fa-times me-2"></i> Cancel Registration
                                        </button>
                                    </form>
                                @endif
                            @else
                                @if($event->canSignUp())
                                    <form method="POST" action="{{ route('events.signup', $event) }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="notes" class="form-label text-light">Additional Notes (Optional)</label>
                                            <textarea name="notes" id="notes" class="form-control bg-dark text-light border-secondary" 
                                                    rows="3" placeholder="Any special requirements or comments..."></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-accent btn-lg w-100">
                                            <i class="fas fa-user-plus me-2"></i> Sign Up for Event
                                        </button>
                                    </form>
                                @else
                                    <div class="btn btn-outline-secondary btn-lg w-100 disabled">
                                        @if($event->isFull())
                                            <i class="fas fa-users me-2"></i> Event Full
                                        @elseif($event->event_date->isPast())
                                            <i class="fas fa-history me-2"></i> Event Completed
                                        @elseif($event->registration_deadline && $event->registration_deadline->isPast())
                                            <i class="fas fa-clock me-2"></i> Registration Closed
                                        @else
                                            <i class="fas fa-ban me-2"></i> Registration Unavailable
                                        @endif
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                @endif
            @endauth

            <!-- Quick Actions -->
            <div class="card bg-dark-gray border-accent mb-4">
                <div class="card-header bg-primary border-accent">
                    <h5 class="mb-0 text-white">
                        <i class="fas fa-bolt me-2"></i> Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="https://discord.gg/odyssey" class="btn btn-outline-primary btn-lg" target="_blank">
                            <i class="fab fa-discord me-2"></i> Join Our Discord
                        </a>
                        
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-accent btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i> Login to Sign Up
                            </a>
                            <a href="{{ route('join') }}" class="btn btn-outline-accent btn-lg">
                                <i class="fas fa-user-plus me-2"></i> Join Odyssey Clan
                            </a>
                        @endguest
                    </div>
                </div>
            </div>

            <!-- Share Event -->
            <div class="card bg-dark-gray border-accent">
                <div class="card-header bg-primary border-accent">
                    <h5 class="mb-0 text-white">
                        <i class="fas fa-share-alt me-2"></i> Share Event
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-info btn-sm" onclick="copyEventLink()">
                            <i class="fas fa-link me-2"></i> Copy Link
                        </button>
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($event->title . ' - Join us for this epic event!') }}&url={{ urlencode(request()->fullUrl()) }}" 
                           class="btn btn-outline-info btn-sm" target="_blank">
                            <i class="fab fa-twitter me-2"></i> Share on Twitter
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Events -->
    @if($relatedEvents->count() > 0)
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="text-accent mb-4">
                <i class="fas fa-calendar-alt me-2"></i> Other Events You Might Like
            </h3>
            <div class="row g-4">
                @foreach($relatedEvents as $relatedEvent)
                <div class="col-md-6">
                    <div class="card bg-dark-gray border-accent h-100">
                        <div class="position-relative">
                            <img src="{{ $relatedEvent->image_url ?: 'https://images.unsplash.com/photo-1542751371-adc38448a05e?w=400&h=200&fit=crop' }}" 
                                 class="card-img-top" alt="{{ $relatedEvent->title }}" style="height: 200px; object-fit: cover;">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-{{ $relatedEvent->type_color }}">{{ ucfirst($relatedEvent->type) }}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-accent">{{ $relatedEvent->title }}</h5>
                            <p class="card-text">{{ Str::limit($relatedEvent->description, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-white">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $relatedEvent->event_date->format('M d, Y') }}
                                </small>
                                <a href="{{ route('events.show', $relatedEvent->id) }}" class="btn btn-sm btn-accent">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.bg-gradient-overlay {
    background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.8));
}

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

.progress-bar {
    transition: width 0.6s ease;
}

.card-header.bg-primary {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark)) !important;
}

.btn-lg {
    padding: 0.75rem 1.5rem;
    font-size: 1.1rem;
}

.btn-outline-accent {
    border: 2px solid var(--accent);
    color: var(--accent);
}

.btn-outline-accent:hover {
    background: var(--accent);
    color: var(--dark);
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

#countdown-days {
    animation: pulse 2s infinite;
}

@media (max-width: 768px) {
    .d-flex.gap-2.flex-wrap {
        flex-direction: column;
        width: 100%;
    }
    
    .d-flex.gap-2.flex-wrap .btn {
        width: 100%;
    }
}
</style>

<script>
function copyEventLink() {
    navigator.clipboard.writeText(window.location.href).then(function() {
        // Create a temporary notification
        const notification = document.createElement('div');
        notification.className = 'alert alert-success position-fixed';
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; max-width: 300px;';
        notification.innerHTML = '<i class="fas fa-check me-2"></i>Event link copied to clipboard!';
        document.body.appendChild(notification);
        
        // Remove notification after 3 seconds
        setTimeout(() => {
            notification.remove();
        }, 3000);
    });
}
</script>
@endsection