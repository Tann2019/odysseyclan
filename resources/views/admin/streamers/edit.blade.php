@extends('Layouts.app')

@section('title', 'Edit Streamer')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="m-0">Edit Streamer</h1>
            <p class="text-muted">Update: {{ $streamer->display_name }}</p>
        </div>
        <div>
            <a href="{{ route('admin.streamers.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Back to Streamers
            </a>
        </div>
    </div>

    <div class="card bg-dark-gray">
        <div class="card-header">
            <h5 class="mb-0">Streamer Details</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.streamers.update', $streamer) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="twitch_username" class="form-label">Twitch Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('twitch_username') is-invalid @enderror" 
                                id="twitch_username" name="twitch_username" value="{{ old('twitch_username', $streamer->twitch_username) }}" 
                                placeholder="e.g., raabbits" required>
                            @error('twitch_username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">The Twitch username (without @)</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="display_name" class="form-label">Display Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('display_name') is-invalid @enderror" 
                                id="display_name" name="display_name" value="{{ old('display_name', $streamer->display_name) }}" 
                                placeholder="e.g., Raabbits" required>
                            @error('display_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Display name for the website</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="priority" class="form-label">Priority <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('priority') is-invalid @enderror" 
                                id="priority" name="priority" value="{{ old('priority', $streamer->priority) }}" 
                                min="0" max="100" required>
                            @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Higher number = higher priority (0-100)</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="is_active" class="form-label">Status</label>
                            <select class="form-select @error('is_active') is-invalid @enderror" id="is_active" name="is_active">
                                <option value="1" {{ old('is_active', $streamer->is_active) ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active', $streamer->is_active) ? '' : 'selected' }}>Inactive</option>
                            </select>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Only active streamers are checked for live status</div>
                        </div>
                    </div>
                </div>

                @if($streamer->stream_data)
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <h6 class="mb-2"><i class="fas fa-info-circle me-2"></i>Current Stream Info</h6>
                                @if($streamer->is_live)
                                    <p class="mb-1"><strong>Status:</strong> <span class="badge bg-danger">LIVE</span></p>
                                    @if($streamer->stream_title)
                                        <p class="mb-1"><strong>Title:</strong> {{ $streamer->stream_title }}</p>
                                    @endif
                                    @if($streamer->game_name)
                                        <p class="mb-1"><strong>Game:</strong> {{ $streamer->game_name }}</p>
                                    @endif
                                    @if($streamer->viewer_count)
                                        <p class="mb-0"><strong>Viewers:</strong> {{ number_format($streamer->viewer_count) }}</p>
                                    @endif
                                @else
                                    <p class="mb-0"><strong>Status:</strong> <span class="badge bg-secondary">Offline</span></p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <div class="mt-4">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-2"></i> Update Streamer
                    </button>
                    <a href="{{ route('admin.streamers.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection