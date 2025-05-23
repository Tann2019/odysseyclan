@extends('Layouts.app')

@section('title', 'Manage Streamers')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="m-0">Manage Streamers</h1>
            <p class="text-muted">Manage Twitch streamers for homepage display</p>
        </div>
        <div>
            <form action="{{ route('admin.streamers.refresh-all') }}" method="POST" class="d-inline me-2">
                @csrf
                <button type="submit" class="btn btn-info">
                    <i class="fas fa-sync me-2"></i> Refresh All
                </button>
            </form>
            <a href="{{ route('admin.streamers.create') }}" class="btn btn-success">
                <i class="fas fa-plus me-2"></i> Add Streamer
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card bg-dark-gray">
        <div class="card-header">
            <h5 class="mb-0">Streamers</h5>
        </div>
        <div class="card-body">
            @if($streamers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Display Name</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Live Status</th>
                                <th>Last Checked</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($streamers as $streamer)
                            <tr>
                                <td>
                                    <a href="https://www.twitch.tv/{{ $streamer->twitch_username }}" target="_blank" class="text-decoration-none">
                                        <i class="fab fa-twitch me-2 text-purple"></i>
                                        {{ $streamer->twitch_username }}
                                    </a>
                                </td>
                                <td>{{ $streamer->display_name }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $streamer->priority }}</span>
                                </td>
                                <td>
                                    @if($streamer->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    @if($streamer->is_live)
                                        <span class="badge bg-danger">
                                            <i class="fas fa-circle me-1" style="font-size: 0.6em;"></i>
                                            LIVE
                                        </span>
                                        @if($streamer->viewer_count)
                                            <small class="text-muted ms-2">{{ number_format($streamer->viewer_count) }} viewers</small>
                                        @endif
                                    @else
                                        <span class="badge bg-dark">Offline</span>
                                    @endif
                                </td>
                                <td>
                                    @if($streamer->last_checked_at)
                                        <small>{{ $streamer->last_checked_at->diffForHumans() }}</small>
                                    @else
                                        <small class="text-muted">Never</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <form action="{{ route('admin.streamers.refresh', $streamer) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-info" title="Refresh Status">
                                                <i class="fas fa-sync"></i>
                                            </button>
                                        </form>
                                        <a href="{{ route('admin.streamers.edit', $streamer) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" title="Delete" 
                                                data-bs-toggle="modal" data-bs-target="#deleteModal{{ $streamer->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fab fa-twitch fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No streamers found</h5>
                    <p class="text-muted">Add your first streamer to get started.</p>
                    <a href="{{ route('admin.streamers.create') }}" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i> Add Streamer
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Modals -->
@foreach($streamers as $streamer)
<div class="modal fade" id="deleteModal{{ $streamer->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong>{{ $streamer->display_name }}</strong>?</p>
                <p class="text-muted">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.streamers.destroy', $streamer) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Streamer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection