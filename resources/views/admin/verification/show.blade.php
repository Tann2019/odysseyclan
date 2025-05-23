@extends('Layouts.app')

@section('title', 'Verify Member - ' . $member->username)

@section('content')
<div class="container py-5 my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="m-0">Verify Member: {{ $member->username }}</h1>
            <p class="text-muted">Registration Date: {{ $member->created_at->format('F d, Y H:i') }}</p>
        </div>
        <div>
            <a href="{{ route('admin.verification.index') }}" class="btn btn-outline">
                <i class="fas fa-arrow-left me-2"></i> Back to Verification
            </a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-8">
            <!-- Member Details Card -->
            <div class="card bg-dark-gray mb-4">
                <div class="card-header bg-dark-gray d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-user-shield me-2"></i> Member Details</h4>
                    <span class="badge bg-warning px-3 py-2">Status: Pending</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-4 mb-md-0">
                            <img src="{{ $member->avatar_url ?? 'https://via.placeholder.com/150x150/333/FFD700?text=' . substr($member->username, 0, 1) }}"
                                alt="{{ $member->username }}" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                            <h4 class="mb-1">{{ $member->username }}</h4>
                            <span class="badge bg-primary mb-2">{{ ucfirst($member->rank) }}</span>
                            <p class="mb-0"><i class="fab fa-discord me-1"></i> {{ $member->discord_id }}</p>
                        </div>
                        <div class="col-md-8">
                            <h5 class="border-bottom pb-2 mb-3">Profile Information</h5>
                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Discord ID:</div>
                                <div class="col-md-8">{{ $member->discord_id }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Clan Rank:</div>
                                <div class="col-md-8">{{ ucfirst($member->rank) }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Status:</div>
                                <div class="col-md-8">
                                    @if($member->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Achievements:</div>
                                <div class="col-md-8">
                                    @if(!empty($member->achievements))
                                        @foreach($member->achievements as $achievement)
                                            <span class="badge bg-success me-1 mb-1">{{ $achievement['name'] ?? 'Unknown' }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">No achievements yet</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 fw-bold">Description:</div>
                                <div class="col-md-8">{{ $member->description ?? 'No description provided.' }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Connected User Info -->
                    <div class="mt-4 pt-4 border-top">
                        <h5 class="mb-3"><i class="fas fa-link me-2"></i> Connected User Account</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row mb-2">
                                    <div class="col-md-4 fw-bold">Name:</div>
                                    <div class="col-md-8">{{ $member->user->name }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 fw-bold">Email:</div>
                                    <div class="col-md-8">{{ $member->user->email }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row mb-2">
                                    <div class="col-md-4 fw-bold">Admin:</div>
                                    <div class="col-md-8">
                                        @if($member->user->isAdmin())
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-secondary">No</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4 fw-bold">Joined:</div>
                                    <div class="col-md-8">{{ $member->user->created_at->format('F d, Y') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Verification Checklist -->
            <div class="card bg-dark-gray mb-4">
                <div class="card-header bg-dark-gray">
                    <h4 class="mb-0"><i class="fas fa-tasks me-2"></i> Verification Checklist</h4>
                </div>
                <div class="card-body">
                    <div class="verification-checklist">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="check1">
                            <label class="form-check-label" for="check1">
                                Discord ID format is valid (username#1234 or username)
                            </label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="check2">
                            <label class="form-check-label" for="check2">
                                User is on Discord server (manual check required)
                            </label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="check3">
                            <label class="form-check-label" for="check3">
                                User appears to be 18+ (manual check required)
                            </label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="check4">
                            <label class="form-check-label" for="check4">
                                Profile information is complete and appropriate
                            </label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="check5">
                            <label class="form-check-label" for="check5">
                                No suspicious activity or duplicate accounts detected
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <!-- Verification Actions -->
            <div class="card bg-dark-gray mb-4">
                <div class="card-header bg-dark-gray">
                    <h4 class="mb-0"><i class="fas fa-check-double me-2"></i> Verification Actions</h4>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-success btn-lg" data-bs-toggle="modal" data-bs-target="#approveModal">
                            <i class="fas fa-check-circle me-2"></i> Approve Member
                        </button>
                        <button type="button" class="btn btn-danger btn-lg" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            <i class="fas fa-times-circle me-2"></i> Reject Member
                        </button>
                    </div>
                    
                    <div class="alert alert-info mt-4">
                        <i class="fas fa-info-circle me-2"></i> After verification, the member will gain full access to clan features and content.
                    </div>
                </div>
            </div>
            
            <!-- Verification Notes -->
            <div class="card bg-dark-gray">
                <div class="card-header bg-dark-gray">
                    <h4 class="mb-0"><i class="fas fa-sticky-note me-2"></i> Admin Notes</h4>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="adminNotes" class="form-label">Private Notes (only visible to admins)</label>
                            <textarea class="form-control" id="adminNotes" rows="5" placeholder="Add your notes about this verification..."></textarea>
                        </div>
                        <div class="d-grid">
                            <button type="button" class="btn btn-primary" disabled>
                                <i class="fas fa-save me-2"></i> Save Notes
                            </button>
                            <small class="text-muted mt-2">Note: This feature is not yet implemented</small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="approveModalLabel">Approve Member: {{ $member->username }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.verification.approve', $member->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Are you sure you want to approve this member?</p>
                    <p>This will grant them full access to clan features.</p>
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label">Approval Notes (Optional)</label>
                        <textarea class="form-control bg-dark text-white border-secondary" id="notes" name="notes" rows="3" placeholder="Add any notes about this approval"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Approve Member</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Reject Member: {{ $member->username }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.verification.reject', $member->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Are you sure you want to reject this member?</p>
                    <p><strong>IMPORTANT:</strong> This will prevent them from accessing clan features.</p>
                    
                    <div class="mb-3">
                        <label for="reason" class="form-label">Rejection Reason (Required)</label>
                        <textarea class="form-control bg-dark text-white border-secondary" id="reason" name="reason" rows="3" placeholder="Provide a reason for rejection" required></textarea>
                        <div class="form-text text-muted">This reason will be shown to the user.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Member</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection