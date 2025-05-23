@extends('Layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="fw-bold">Edit Member: {{ $member->username }}</h1>
            <p class="text-muted">Update member details and profile information</p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('admin.members.index') }}" class="btn btn-outline-primary me-2">
                <i class="fas fa-arrow-left"></i> Back to Members
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <!-- Member Edit Form -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Member Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.members.update', $member->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $member->username) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="discord_id" class="form-label">Discord ID</label>
                                <input type="text" class="form-control" id="discord_id" name="discord_id" value="{{ old('discord_id', $member->discord_id) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="rank" class="form-label">Rank</label>
                                <select class="form-select" id="rank" name="rank" required>
                                    @foreach($ranks as $rank)
                                        <option value="{{ $rank }}" {{ old('rank', $member->rank) == $rank ? 'selected' : '' }}>
                                            {{ ucfirst($rank) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="is_active" class="form-label">Status</label>
                                <select class="form-select" id="is_active" name="is_active">
                                    <option value="1" {{ old('is_active', $member->is_active) ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('is_active', $member->is_active) ? '' : 'selected' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="avatar_url" class="form-label">Avatar URL</label>
                                <input type="url" class="form-control" id="avatar_url" name="avatar_url" value="{{ old('avatar_url', $member->avatar_url) }}">
                                <div class="form-text">Leave empty to use the default avatar</div>
                            </div>
                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $member->description) }}</textarea>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Update Member
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Verification Status -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Verification Status</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <h6 class="mb-0 me-3">Current Status:</h6>
                        <span class="badge bg-{{ 
                            match($member->verification_status) {
                                'verified' => 'success',
                                'pending' => 'warning',
                                'rejected' => 'danger',
                                default => 'secondary'
                            }
                        }} px-3 py-2">{{ ucfirst($member->verification_status) }}</span>
                    </div>

                    @if($member->verified_at)
                        <div class="mb-3">
                            <h6>Verified On:</h6>
                            <p>{{ $member->verified_at->format('F d, Y \a\t h:i A') }}</p>
                        </div>
                    @endif

                    @if($member->verification_notes)
                        <div class="mb-3">
                            <h6>Notes:</h6>
                            <p class="mb-0">{{ $member->verification_notes }}</p>
                        </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('admin.verification.show', $member->id) }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-1"></i> Manage Verification Status
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Member Profile Preview -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Profile Preview</h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        @if($member->avatar_url)
                            <img src="{{ $member->avatar_url }}" alt="{{ $member->username }}" class="rounded-circle" width="100" height="100">
                        @else
                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 100px; height: 100px;">
                                <span class="text-white fs-1">{{ substr($member->username, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>
                    <h4 class="mb-1">{{ $member->username }}</h4>
                    <div class="badge bg-{{ 
                        match($member->rank) {
                            'commander' => 'danger',
                            'captain' => 'warning',
                            'veteran' => 'success',
                            'warrior' => 'primary',
                            'recruit' => 'info',
                            default => 'secondary'
                        }
                    }} mb-3">{{ ucfirst($member->rank) }}</div>
                    
                    @if($member->description)
                        <p class="text-muted mb-3">{{ $member->description }}</p>
                    @else
                        <p class="text-muted fst-italic mb-3">No description provided</p>
                    @endif

                    <div class="d-grid">
                        <a href="#" class="btn btn-outline-secondary">
                            <i class="fab fa-discord me-1"></i> Discord ID: {{ $member->discord_id }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- User Account Info -->
            @if($member->user)
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">User Account</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold mb-1">Name</label>
                        <div>{{ $member->user->name }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold mb-1">Email</label>
                        <div>{{ $member->user->email }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold mb-1">Registration Date</label>
                        <div>{{ $member->user->created_at->format('F d, Y') }}</div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold mb-1">Admin Status</label>
                        <div>
                            @if($member->user->isAdmin())
                                <span class="badge bg-success">Administrator</span>
                            @else
                                <span class="badge bg-secondary">Regular User</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Danger Zone -->
            <div class="card shadow-sm border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Danger Zone</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">These actions are irreversible. Please be careful.</p>
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deactivateModal">
                            <i class="fas fa-user-times me-1"></i> Deactivate Member
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Deactivate Modal -->
<div class="modal fade" id="deactivateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deactivation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to deactivate <strong>{{ $member->username }}</strong>?</p>
                <p class="text-muted">This will mark the member as inactive but will not delete their data.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Deactivate Member</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection