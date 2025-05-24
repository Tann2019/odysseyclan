@extends('Layouts.app')

@section('title', 'Member Verification')

@section('content')
<div class="container py-5 my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="m-0">Member Verification</h1>
        <a href="{{ route('admin.members.index') }}" class="btn btn-outline">
            <i class="fas fa-users me-2"></i> All Members
        </a>
    </div>
    
    <div class="row mb-5">
        <div class="col-md-4">
            <div class="card bg-warning text-dark mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="m-0">{{ $pendingMembers->count() }}</h3>
                            <p class="m-0">Pending Verification</p>
                        </div>
                        <div class="fs-1">
                            <i class="fas fa-user-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="m-0">{{ $recentlyVerified->count() }}</h3>
                            <p class="m-0">Recently Verified</p>
                        </div>
                        <div class="fs-1">
                            <i class="fas fa-user-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="m-0">{{ $recentlyRejected->count() }}</h3>
                            <p class="m-0">Recently Rejected</p>
                        </div>
                        <div class="fs-1">
                            <i class="fas fa-user-times"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Pending Verification Requests -->
    <div class="card bg-dark-gray mb-5">
        <div class="card-header bg-dark-gray">
            <h4 class="mb-0"><i class="fas fa-clock me-2 text-warning"></i> Pending Verification Requests</h4>
        </div>
        <div class="card-body">
            @if($pendingMembers->isEmpty())
                <div class="alert alert-info mb-0">
                    <i class="fas fa-info-circle me-2"></i> There are no pending verification requests at this time.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Discord ID</th>
                                <th>Registered</th>
                                <th>User Info</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingMembers as $member)
                            <tr>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $member->avatar_url ?? 'https://via.placeholder.com/40x40/333/FFD700?text='.substr($member->username, 0, 1) }}" 
                                            alt="{{ $member->username }}" class="rounded-circle me-2" 
                                            style="width: 40px; height: 40px; object-fit: cover;">
                                        <span>{{ $member->username }}</span>
                                    </div>
                                </td>
                                <td class="align-middle">{{ $member->discord_id }}</td>
                                <td class="align-middle">{{ $member->created_at->diffForHumans() }}</td>
                                <td class="align-middle">
                                    <span class="d-block"><i class="fas fa-user me-1"></i> {{ $member->user->name }}</span>
                                    <span class="d-block small"><i class="fas fa-envelope me-1"></i> {{ $member->user->email }}</span>
                                </td>
                                <td class="align-middle">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.verification.show', $member->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-success approve-btn"
                                                data-member-id="{{ $member->id }}"
                                                data-member-username="{{ $member->username }}"
                                                data-member-discord="{{ $member->discord_id }}">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger reject-btn"
                                                data-member-id="{{ $member->id }}"
                                                data-member-username="{{ $member->username }}"
                                                data-member-discord="{{ $member->discord_id }}">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Recently Verified Members -->
    <div class="card bg-dark-gray mb-5">
        <div class="card-header bg-dark-gray">
            <h4 class="mb-0"><i class="fas fa-user-check me-2 text-success"></i> Recently Verified Members</h4>
        </div>
        <div class="card-body">
            @if($recentlyVerified->isEmpty())
                <div class="alert alert-info mb-0">
                    <i class="fas fa-info-circle me-2"></i> No members have been verified recently.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Discord ID</th>
                                <th>Verified On</th>
                                <th>Verified By</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentlyVerified as $member)
                            <tr>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $member->avatar_url ?? 'https://via.placeholder.com/40x40/333/FFD700?text='.substr($member->username, 0, 1) }}" 
                                            alt="{{ $member->username }}" class="rounded-circle me-2" 
                                            style="width: 40px; height: 40px; object-fit: cover;">
                                        <span>{{ $member->username }}</span>
                                    </div>
                                </td>
                                <td class="align-middle">{{ $member->discord_id }}</td>
                                <td class="align-middle">{{ $member->verified_at->format('M d, Y H:i') }}</td>
                                <td class="align-middle">Admin</td>
                                <td class="align-middle">{{ $member->verification_notes ?? 'No notes' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Recently Rejected Members -->
    <div class="card bg-dark-gray">
        <div class="card-header bg-dark-gray">
            <h4 class="mb-0"><i class="fas fa-user-times me-2 text-danger"></i> Recently Rejected Members</h4>
        </div>
        <div class="card-body">
            @if($recentlyRejected->isEmpty())
                <div class="alert alert-info mb-0">
                    <i class="fas fa-info-circle me-2"></i> No members have been rejected recently.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Discord ID</th>
                                <th>Rejected On</th>
                                <th>Reason</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentlyRejected as $member)
                            <tr>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $member->avatar_url ?? 'https://via.placeholder.com/40x40/333/FFD700?text='.substr($member->username, 0, 1) }}" 
                                            alt="{{ $member->username }}" class="rounded-circle me-2" 
                                            style="width: 40px; height: 40px; object-fit: cover;">
                                        <span>{{ $member->username }}</span>
                                    </div>
                                </td>
                                <td class="align-middle">{{ $member->discord_id }}</td>
                                <td class="align-middle">{{ $member->updated_at->format('M d, Y H:i') }}</td>
                                <td class="align-middle">{{ Str::limit($member->verification_notes, 50) }}</td>
                                <td class="align-middle">
                                    <button type="button" class="btn btn-sm btn-warning reset-btn"
                                            data-member-id="{{ $member->id }}"
                                            data-member-username="{{ $member->username }}">
                                        <i class="fas fa-redo-alt me-1"></i> Reset
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title">Approve Member: <span id="approve-username"></span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="approveForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Are you sure you want to approve this member?</p>
                    <p><strong>Username:</strong> <span id="approve-username-display"></span></p>
                    <p><strong>Discord ID:</strong> <span id="approve-discord-display"></span></p>
                    
                    <div class="mb-3">
                        <label for="approve-notes" class="form-label">Approval Notes (Optional)</label>
                        <textarea class="form-control" id="approve-notes" name="notes" rows="3" placeholder="Add any notes about this approval"></textarea>
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
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title">Reject Member: <span id="reject-username"></span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Are you sure you want to reject this member?</p>
                    <p><strong>Username:</strong> <span id="reject-username-display"></span></p>
                    <p><strong>Discord ID:</strong> <span id="reject-discord-display"></span></p>
                    
                    <div class="mb-3">
                        <label for="reject-reason" class="form-label">Rejection Reason (Required)</label>
                        <textarea class="form-control" id="reject-reason" name="reason" rows="3" placeholder="Provide a reason for rejection" required></textarea>
                        <div class="form-text">This will be shown to the user.</div>
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

<!-- Reset Modal -->
<div class="modal fade" id="resetModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title">Reset to Pending: <span id="reset-username"></span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="resetForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Are you sure you want to reset this member's status to "pending"?</p>
                    <p>This will allow them to be reconsidered for verification.</p>
                    
                    <div class="mb-3">
                        <label for="reset-notes" class="form-label">Notes (Optional)</label>
                        <textarea class="form-control" id="reset-notes" name="notes" rows="3" placeholder="Add any notes about this status reset"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Reset to Pending</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Approve buttons
    document.querySelectorAll('.approve-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const memberId = this.dataset.memberId;
            const username = this.dataset.memberUsername;
            const discord = this.dataset.memberDiscord;
            
            document.getElementById('approve-username').textContent = username;
            document.getElementById('approve-username-display').textContent = username;
            document.getElementById('approve-discord-display').textContent = discord;
            document.getElementById('approveForm').action = `/admin/verification/${memberId}/approve`;
            document.getElementById('approve-notes').value = '';
            
            const modal = new bootstrap.Modal(document.getElementById('approveModal'));
            modal.show();
        });
    });
    
    // Reject buttons
    document.querySelectorAll('.reject-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const memberId = this.dataset.memberId;
            const username = this.dataset.memberUsername;
            const discord = this.dataset.memberDiscord;
            
            document.getElementById('reject-username').textContent = username;
            document.getElementById('reject-username-display').textContent = username;
            document.getElementById('reject-discord-display').textContent = discord;
            document.getElementById('rejectForm').action = `/admin/verification/${memberId}/reject`;
            document.getElementById('reject-reason').value = '';
            
            const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
            modal.show();
        });
    });
    
    // Reset buttons
    document.querySelectorAll('.reset-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const memberId = this.dataset.memberId;
            const username = this.dataset.memberUsername;
            
            document.getElementById('reset-username').textContent = username;
            document.getElementById('resetForm').action = `/admin/verification/${memberId}/reset`;
            document.getElementById('reset-notes').value = '';
            
            const modal = new bootstrap.Modal(document.getElementById('resetModal'));
            modal.show();
        });
    });
});
</script>

@endsection