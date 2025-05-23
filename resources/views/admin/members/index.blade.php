@extends('Layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="fw-bold">Manage Members</h1>
            <p class="text-muted">View, edit and manage all clan members</p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary me-2">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <div class="card bg-dark-gray shadow-sm mb-4">
        <div class="card-header bg-dark-gray">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="mb-0">Member List</h5>
                </div>
                <div class="col-md-4">
                    <form action="{{ route('admin.members.index') }}" method="GET" class="d-flex">
                        <input type="text" name="search" class="form-control form-control-sm me-2" 
                            placeholder="Search members..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Avatar</th>
                            <th>Username</th>
                            <th>Discord ID</th>
                            <th>Rank</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members as $member)
                            <tr>
                                <td>{{ $member->id }}</td>
                                <td>
                                    @if($member->avatar_url)
                                        <img src="{{ $member->avatar_url }}" alt="{{ $member->username }}" class="rounded-circle" width="40" height="40">
                                    @else
                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <span class="text-white">{{ substr($member->username, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-medium">{{ $member->username }}</span>
                                    @if($member->user)
                                        <br>
                                        <small class="text-muted">{{ $member->user->name }}</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="text-nowrap">{{ $member->discord_id }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ 
                                        match($member->rank) {
                                            'commander' => 'danger',
                                            'captain' => 'warning',
                                            'veteran' => 'success',
                                            'warrior' => 'primary',
                                            'recruit' => 'info',
                                            default => 'secondary'
                                        }
                                    }} text-uppercase">{{ $member->rank }}</span>
                                </td>
                                <td>
                                    @if($member->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                    <br>
                                    <span class="badge bg-{{ 
                                        match($member->verification_status) {
                                            'verified' => 'success',
                                            'pending' => 'warning',
                                            'rejected' => 'danger',
                                            default => 'secondary'
                                        }
                                    }}">{{ ucfirst($member->verification_status) }}</span>
                                </td>
                                <td>
                                    <div class="text-muted" title="{{ $member->created_at }}">
                                        {{ $member->created_at->diffForHumans() }}
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.members.edit', $member->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                            data-bs-toggle="modal" data-bs-target="#deleteModal{{ $member->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $member->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirm Deactivation</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to deactivate the member <strong>{{ $member->username }}</strong>?</p>
                                                    <p class="text-muted small">This will mark the member as inactive but will not delete their data.</p>
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
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="text-muted">No members found</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-dark-gray">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="text-muted small">
                        Showing {{ $members->firstItem() ?? 0 }} to {{ $members->lastItem() ?? 0 }} of {{ $members->total() ?? 0 }} members
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-end">
                        {{ $members->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-dark-gray shadow-sm">
        <div class="card-header bg-dark-gray">
            <h5 class="mb-0">Filter Options</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.members.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Rank</label>
                    <select name="rank" class="form-select">
                        <option value="">All Ranks</option>
                        @foreach($ranks as $rank)
                            <option value="{{ $rank }}" {{ request('rank') == $rank ? 'selected' : '' }}>
                                {{ ucfirst($rank) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="active" class="form-select">
                        <option value="">All</option>
                        <option value="1" {{ request('active') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('active') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Sort By</label>
                    <select name="sort" class="form-select">
                        <option value="created_at" {{ request('sort', 'created_at') == 'created_at' ? 'selected' : '' }}>Date Created</option>
                        <option value="username" {{ request('sort') == 'username' ? 'selected' : '' }}>Username</option>
                        <option value="rank" {{ request('sort') == 'rank' ? 'selected' : '' }}>Rank</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Direction</label>
                    <select name="direction" class="form-select">
                        <option value="desc" {{ request('direction', 'desc') == 'desc' ? 'selected' : '' }}>Descending</option>
                        <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                    </select>
                </div>
                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter me-1"></i> Apply Filters
                    </button>
                    <a href="{{ route('admin.members.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i> Clear Filters
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection