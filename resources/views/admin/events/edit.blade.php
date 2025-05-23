@extends('Layouts.app')

@section('title', 'Edit Event')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="m-0">Edit Event</h1>
            <p class="text-muted">Update: {{ $event->title }}</p>
        </div>
        <div>
            <a href="{{ route('admin.events.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Back to Events
            </a>
        </div>
    </div>

    <div class="card bg-dark-gray">
        <div class="card-header bg-dark-gray">
            <h5 class="mb-0">Event Details</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.events.update', $event) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">Event Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                id="title" name="title" value="{{ old('title', $event->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="type" class="form-label">Event Type <span class="text-danger">*</span></label>
                                    <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                        <option value="">Select event type</option>
                                        @foreach($types as $type)
                                            <option value="{{ $type }}" {{ old('type', $event->type) == $type ? 'selected' : '' }}>
                                                {{ ucfirst($type) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="max_participants" class="form-label">Max Participants</label>
                                    <input type="number" class="form-control @error('max_participants') is-invalid @enderror" 
                                        id="max_participants" name="max_participants" value="{{ old('max_participants', $event->max_participants) }}" min="1">
                                    @error('max_participants')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Leave empty for unlimited participants</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="event_date" class="form-label">Event Date & Time <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control @error('event_date') is-invalid @enderror" 
                                        id="event_date" name="event_date" value="{{ old('event_date', $event->event_date->format('Y-m-d\TH:i')) }}" required>
                                    @error('event_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="registration_deadline" class="form-label">Registration Deadline</label>
                                    <input type="datetime-local" class="form-control @error('registration_deadline') is-invalid @enderror" 
                                        id="registration_deadline" name="registration_deadline" 
                                        value="{{ old('registration_deadline', $event->registration_deadline?->format('Y-m-d\TH:i')) }}">
                                    @error('registration_deadline')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Optional deadline for registrations</div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                id="description" name="description" rows="6" required>{{ old('description', $event->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image_url" class="form-label">Event Image URL</label>
                            <input type="url" class="form-control @error('image_url') is-invalid @enderror" 
                                id="image_url" name="image_url" value="{{ old('image_url', $event->image_url) }}" 
                                placeholder="https://example.com/image.jpg">
                            @error('image_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Optional image for the event</div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" 
                                    name="is_active" value="1" {{ old('is_active', $event->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active
                                </label>
                            </div>
                            <div class="form-text">Only active events are displayed on the website</div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_featured" 
                                    name="is_featured" value="1" {{ old('is_featured', $event->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    Featured
                                </label>
                            </div>
                            <div class="form-text">Featured events appear prominently on the homepage</div>
                        </div>

                        <div class="card bg-dark border-secondary">
                            <div class="card-header">
                                <h6 class="mb-0">Event Info</h6>
                            </div>
                            <div class="card-body">
                                <small class="text-muted">
                                    <strong>Created by:</strong> {{ $event->creator->name }}<br>
                                    <strong>Created:</strong> {{ $event->created_at->format('M d, Y H:i') }}<br>
                                    <strong>Last Updated:</strong> {{ $event->updated_at->format('M d, Y H:i') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="fas fa-trash me-2"></i> Delete Event
                    </button>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-accent">
                            <i class="fas fa-save me-2"></i> Update Event
                        </button>
                    </div>
                </div>
            </form>
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
                @if($event->image_url)
                    <div class="text-center mb-3">
                        <img src="{{ $event->image_url }}" alt="{{ $event->title }}" 
                             class="img-fluid rounded" style="max-height: 150px;">
                    </div>
                @endif
                <div class="mb-3">
                    <small class="text-muted">
                        <strong>Event Date:</strong> {{ $event->event_date->format('F d, Y \a\t H:i') }}<br>
                        <strong>Type:</strong> {{ ucfirst($event->type) }}<br>
                        @if($event->max_participants)
                            <strong>Max Participants:</strong> {{ $event->max_participants }}<br>
                        @endif
                    </small>
                </div>
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