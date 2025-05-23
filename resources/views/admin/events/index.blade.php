@extends('Layouts.app')

@section('title', 'Manage Events')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="m-0">Manage Events</h1>
            <p class="text-muted">Create and manage clan events, tournaments, and activities</p>
        </div>
        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary me-2">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
            <a href="{{ route('admin.events.create') }}" class="btn btn-accent">
                <i class="fas fa-plus me-2"></i> Create Event
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card bg-dark-gray">
        <div class="card-header bg-dark-gray">
            <h5 class="mb-0">Events</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Event</th>
                            <th>Type</th>
                            <th>Event Date</th>
                            <th>Status</th>
                            <th>Featured</th>
                            <th>Created By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $event)
                            <tr>
                                <td>
                                    <div>
                                        <h6 class="mb-1">{{ $event->title }}</h6>
                                        <small class="text-muted">{{ Str::limit($event->description, 60) }}</small>
                                        @if($event->max_participants)
                                            <br><small class="text-info">Max participants: {{ $event->max_participants }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $event->type_color }} text-uppercase">
                                        {{ $event->type }}
                                    </span>
                                </td>
                                <td>
                                    <div>
                                        {{ $event->event_date->format('M d, Y') }}
                                        <br><small class="text-muted">{{ $event->event_date->format('H:i') }}</small>
                                        @if($event->days_left > 0)
                                            <br><small class="text-warning">{{ $event->days_left }} days left</small>
                                        @elseif($event->event_date->isPast())
                                            <br><small class="text-muted">Past event</small>
                                        @else
                                            <br><small class="text-success">Today</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($event->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    @if($event->is_featured)
                                        <i class="fas fa-star text-warning" title="Featured"></i>
                                    @else
                                        <i class="far fa-star text-muted" title="Not featured"></i>
                                    @endif
                                </td>
                                <td>{{ $event->creator->name }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.events.show', $event) }}" class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                            data-bs-toggle="modal" data-bs-target="#deleteModal{{ $event->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $event->id }}" tabindex="-1">
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
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-calendar-plus fa-3x mb-3"></i>
                                        <p>No events found. <a href="{{ route('admin.events.create') }}">Create your first event</a>.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($events->hasPages())
            <div class="card-footer bg-dark-gray">
                <div class="d-flex justify-content-center">
                    {{ $events->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection