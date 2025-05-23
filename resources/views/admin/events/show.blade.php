@extends('Layouts.app')

@section('title', $event->title)

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="m-0">Event Details</h1>
            <p class="text-muted">{{ $event->title }}</p>
        </div>
        <div>
            <a href="{{ route('admin.events.index') }}" class="btn btn-outline-primary me-2">
                <i class="fas fa-arrow-left"></i> Back to Events
            </a>
            <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-accent">
                <i class="fas fa-edit me-2"></i> Edit Event
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card bg-dark-gray">
                <div class="card-header bg-dark-gray">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $event->title }}</h5>
                        <div>
                            @if($event->is_featured)
                                <span class="badge bg-warning text-dark me-2">Featured</span>
                            @endif
                            @if($event->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </div>
                    </div>
                </div>
                @if($event->image_url)
                    <img src="{{ $event->image_url }}" class="card-img-top" alt="{{ $event->title }}" style="max-height: 400px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-accent">Event Type</h6>
                            <span class="badge bg-{{ $event->type_color }} text-uppercase">{{ $event->type }}</span>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-accent">Event Date</h6>
                            <p class="mb-0">
                                <i class="fas fa-calendar me-2"></i>{{ $event->event_date->format('F d, Y') }}
                                <br>
                                <i class="fas fa-clock me-2"></i>{{ $event->event_date->format('H:i') }} UTC
                            </p>
                        </div>
                    </div>

                    @if($event->registration_deadline)
                        <div class="mb-4">
                            <h6 class="text-accent">Registration Deadline</h6>
                            <p class="mb-0">
                                <i class="fas fa-calendar-check me-2"></i>{{ $event->registration_deadline->format('F d, Y \a\t H:i') }}
                                @if($event->registration_deadline->isPast())
                                    <span class="badge bg-danger ms-2">Expired</span>
                                @elseif($event->registration_deadline->diffInDays() <= 3)
                                    <span class="badge bg-warning text-dark ms-2">{{ $event->registration_deadline->diffForHumans() }}</span>
                                @endif
                            </p>
                        </div>
                    @endif

                    @if($event->max_participants)
                        <div class="mb-4">
                            <h6 class="text-accent">Participant Limit</h6>
                            <p class="mb-0">
                                <i class="fas fa-users me-2"></i>Maximum {{ $event->max_participants }} participants
                            </p>
                        </div>
                    @endif

                    <div class="mb-4">
                        <h6 class="text-accent">Description</h6>
                        <div class="content-display">
                            {!! nl2br(e($event->description)) !!}
                        </div>
                    </div>

                    @if($event->additional_info && count($event->additional_info) > 0)
                        <div class="mb-4">
                            <h6 class="text-accent">Additional Information</h6>
                            <div class="bg-dark p-3 rounded">
                                @foreach($event->additional_info as $key => $value)
                                    <div class="mb-2">
                                        <strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong>
                                        @if(is_array($value))
                                            <ul class="mb-0 mt-1">
                                                @foreach($value as $item)
                                                    <li>{{ $item }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            {{ $value }}
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-dark-gray">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-user me-1"></i> Created by {{ $event->creator->name }}
                        </small>
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i> Created {{ $event->created_at->format('F d, Y \a\t H:i') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card bg-dark-gray">
                <div class="card-header bg-dark-gray">
                    <h6 class="mb-0">Event Status</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Current Status:</strong>
                        @if($event->event_date->isPast())
                            <span class="badge bg-secondary ms-2">Past Event</span>
                        @elseif($event->days_left == 0)
                            <span class="badge bg-success ms-2">Today</span>
                        @elseif($event->days_left <= 7)
                            <span class="badge bg-warning text-dark ms-2">{{ $event->days_left }} days left</span>
                        @else
                            <span class="badge bg-info ms-2">{{ $event->days_left }} days left</span>
                        @endif
                    </div>
                    
                    <div class="mb-3">
                        <strong>Visibility:</strong>
                        @if($event->is_active)
                            <span class="badge bg-success ms-2">Active</span>
                        @else
                            <span class="badge bg-secondary ms-2">Inactive</span>
                        @endif
                    </div>
                    
                    <div class="mb-3">
                        <strong>Featured:</strong>
                        @if($event->is_featured)
                            <span class="badge bg-warning text-dark ms-2">Yes</span>
                        @else
                            <span class="badge bg-secondary ms-2">No</span>
                        @endif
                    </div>
                    
                    <div class="mb-3">
                        <strong>Created by:</strong>
                        <div class="mt-1">{{ $event->creator->name }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Last Updated:</strong>
                        <div class="mt-1">{{ $event->updated_at->format('F d, Y \a\t H:i') }}</div>
                    </div>
                </div>
            </div>

            <div class="card bg-dark-gray mt-4">
                <div class="card-header bg-dark-gray">
                    <h6 class="mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i> Edit Event
                        </a>
                        
                        @if($event->is_active)
                            <button type="button" class="btn btn-outline-secondary" disabled>
                                <i class="fas fa-eye me-2"></i> Visible on Site
                            </button>
                        @else
                            <button type="button" class="btn btn-outline-warning" disabled>
                                <i class="fas fa-eye-slash me-2"></i> Hidden from Site
                            </button>
                        @endif
                        
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash me-2"></i> Delete Event
                        </button>
                    </div>
                </div>
            </div>

            @if($event->event_date->isFuture())
                <div class="card bg-dark-gray mt-4">
                    <div class="card-header bg-dark-gray">
                        <h6 class="mb-0">Countdown</h6>
                    </div>
                    <div class="card-body text-center">
                        <div class="display-6 text-accent">{{ $event->days_left }}</div>
                        <div class="text-muted">{{ Str::plural('day', $event->days_left) }} remaining</div>
                        <small class="text-muted d-block mt-2">
                            {{ $event->event_date->diffForHumans() }}
                        </small>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title">Delete Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong>{{ $event->title }}</strong>?</p>
                <p class="text-muted small">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Event</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection