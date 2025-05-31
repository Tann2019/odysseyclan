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
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-accent">Admin</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.events.index') }}" class="text-accent">Events</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $event->title }}</li>
                        </ol>
                    </nav>
                    <h1 class="display-5 fw-bold text-white mb-2">{{ $event->title }}</h1>
                    <div class="d-flex align-items-center gap-3">
                        @if($event->is_featured)
                            <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                                <i class="fas fa-star me-1"></i> Featured Event
                            </span>
                        @endif
                        <span class="badge bg-{{ $event->type_color }} fs-6 px-3 py-2 text-uppercase">
                            <i class="fas fa-tag me-1"></i> {{ $event->type }}
                        </span>
                        @if($event->is_active)
                            <span class="badge bg-success fs-6 px-3 py-2">
                                <i class="fas fa-eye me-1"></i> Active
                            </span>
                        @else
                            <span class="badge bg-secondary fs-6 px-3 py-2">
                                <i class="fas fa-eye-slash me-1"></i> Inactive
                            </span>
                        @endif
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Back to Events
                    </a>
                    <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-accent">
                        <i class="fas fa-edit me-2"></i> Edit Event
                    </a>
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
                                    <small class="text-muted">{{ $event->event_date->format('H:i') }} UTC</small>
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
                                        <small class="text-muted">{{ $event->event_date->diffForHumans() }}</small>
                                    @else
                                        <p class="text-warning mb-0 fw-semibold">{{ (int)$event->days_left }} {{ Str::plural('day', (int)$event->days_left) }}</p>
                                        <small class="text-muted">{{ $event->event_date->diffForHumans() }}</small>
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
                                    <small class="text-muted">Registration has closed</small>
                                @else
                                    <small class="text-muted">{{ $event->registration_deadline->diffForHumans() }}</small>
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
                            <i class="fas fa-align-left me-2"></i> Description
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
                                <h6 class="text-accent mb-1">Created by</h6>
                                <p class="text-white mb-0 fw-semibold">{{ $event->creator->name }}</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <small class="text-muted d-block">Created {{ $event->created_at->format('F d, Y') }}</small>
                            @if($event->updated_at != $event->created_at)
                                <small class="text-muted d-block">Updated {{ $event->updated_at->diffForHumans() }}</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Registration Stats -->
            <div class="card bg-dark-gray border-accent mb-4">
                <div class="card-header bg-primary border-accent">
                    <h5 class="mb-0 text-white">
                        <i class="fas fa-users me-2"></i> Event Registrations
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-dark rounded">
                        <span class="text-light fw-semibold">Total Registered</span>
                        <span class="badge bg-accent fs-6">{{ $event->registered_count }}</span>
                    </div>
                    
                    @if($event->max_participants)
                        <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-dark rounded">
                            <span class="text-light fw-semibold">Capacity</span>
                            <span class="badge bg-primary fs-6">{{ $event->registered_count }}/{{ $event->max_participants }}</span>
                        </div>
                        
                        <div class="mb-3">
                            <div class="progress mb-2" style="height: 8px;">
                                @php $participantProgress = $event->max_participants > 0 ? ($event->registered_count / $event->max_participants) * 100 : 0; @endphp
                                <div class="progress-bar bg-accent" style="width: {{ min($participantProgress, 100) }}%"></div>
                            </div>
                            @if($event->spots_remaining !== null)
                                <small class="text-light">{{ $event->spots_remaining }} spots remaining</small>
                            @endif
                        </div>
                    @endif
                    
                    <div class="d-grid">
                        <a href="{{ route('admin.events.signups', $event) }}" class="btn btn-outline-accent text-white">
                            <i class="fas fa-list me-2"></i> Manage Signups
                        </a>
                    </div>
                </div>
            </div>

            <!-- Status Card -->
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
                            <span class="badge bg-secondary fs-6">Past Event</span>
                        @elseif((int)$event->days_left == 0)
                            <span class="badge bg-success fs-6">Today!</span>
                        @elseif((int)$event->days_left <= 7)
                            <span class="badge bg-warning text-dark fs-6">{{ (int)$event->days_left }} days left</span>
                        @else
                            <span class="badge bg-info fs-6">{{ (int)$event->days_left }} days left</span>
                        @endif
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-dark rounded">
                        <span class="text-light fw-semibold">Visibility</span>
                        @if($event->is_active)
                            <span class="badge bg-success fs-6">Public</span>
                        @else
                            <span class="badge bg-secondary fs-6">Hidden</span>
                        @endif
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center p-3 bg-dark rounded">
                        <span class="text-light fw-semibold">Featured</span>
                        @if($event->is_featured)
                            <span class="badge bg-warning text-dark fs-6">Yes</span>
                        @else
                            <span class="badge bg-secondary fs-6">No</span>
                        @endif
                    </div>
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
                    <div class="text-muted fs-5 mb-3">{{ Str::plural('day', (int)$event->days_left) }} remaining</div>
                    <div class="progress mb-3" style="height: 8px;">
                        @php
                            $totalDays = $event->created_at->diffInDays($event->event_date);
                            $remainingDays = now()->diffInDays($event->event_date);
                            $progress = $totalDays > 0 ? (($totalDays - $remainingDays) / $totalDays) * 100 : 100;
                        @endphp
                        <div class="progress-bar bg-accent" style="width: {{ $progress }}%"></div>
                    </div>
                    <small class="text-muted">{{ $event->event_date->diffForHumans() }}</small>
                </div>
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="card bg-dark-gray border-accent">
                <div class="card-header bg-primary border-accent">
                    <h5 class="mb-0 text-white">
                        <i class="fas fa-bolt me-2"></i> Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-accent btn-lg">
                            <i class="fas fa-edit me-2"></i> Edit Event
                        </a>
                        
                        @if($event->is_active)
                            <div class="btn btn-outline-success btn-lg disabled">
                                <i class="fas fa-eye me-2"></i> Visible on Site
                            </div>
                        @else
                            <div class="btn btn-outline-warning btn-lg disabled">
                                <i class="fas fa-eye-slash me-2"></i> Hidden from Site
                            </div>
                        @endif
                        
                        <button type="button" class="btn btn-outline-danger btn-lg" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash me-2"></i> Delete Event
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
                    <i class="fas fa-exclamation-triangle me-2"></i> Delete Event
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                    <h5 class="text-light">Are you sure you want to delete this event?</h5>
                </div>
                <div class="alert alert-danger">
                    <strong>{{ $event->title }}</strong>
                    <p class="mb-0 mt-2">This action cannot be undone. All event data will be permanently removed.</p>
                </div>
            </div>
            <div class="modal-footer border-accent">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i> Cancel
                </button>
                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i> Delete Event
                    </button>
                </form>
            </div>
        </div>
    </div>
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

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

#countdown-days {
    animation: pulse 2s infinite;
}
</style>
@endsection