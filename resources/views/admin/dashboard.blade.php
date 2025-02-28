@extends('Layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container py-5 my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="m-0">Admin Dashboard</h1>
        <div>
            <a href="{{ route('admin.admins.create') }}" class="btn btn-success me-2">
                <i class="fas fa-user-shield me-2"></i> Create Admin
            </a>
        </div>
    </div>
    
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <!-- Stats Cards -->
    <div class="row mb-5">
        <div class="col-md-4">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="m-0">{{ $totalMembers }}</h3>
                            <p class="m-0">Total Members</p>
                        </div>
                        <div class="fs-1">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="{{ route('admin.members.index') }}" class="text-white stretched-link">View Details</a>
                    <div class="text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-dark mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="m-0">{{ $pendingVerifications }}</h3>
                            <p class="m-0">Pending Verifications</p>
                        </div>
                        <div class="fs-1">
                            <i class="fas fa-user-clock"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="{{ route('admin.verification.index') }}" class="text-dark stretched-link">View Details</a>
                    <div class="text-dark"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="m-0">0</h3>
                            <p class="m-0">New Events</p>
                        </div>
                        <div class="fs-1">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="#" class="text-white stretched-link">View Details</a>
                    <div class="text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Latest Members -->
        <div class="col-lg-6">
            <div class="card bg-dark-gray mb-4">
                <div class="card-header bg-dark-gray">
                    <h4 class="mb-0"><i class="fas fa-user-plus me-2"></i> Latest Members</h4>
                </div>
                <div class="card-body">
                    @if($latestMembers->isEmpty())
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle me-2"></i> No members have joined recently.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-dark table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Discord ID</th>
                                        <th>Joined</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($latestMembers as $member)
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
                                            @if($member->verification_status === 'verified')
                                                <span class="badge bg-success">Verified</span>
                                            @elseif($member->verification_status === 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @elseif($member->verification_status === 'rejected')
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                <div class="card-footer d-flex justify-content-end bg-dark-gray">
                    <a href="{{ route('admin.members.index') }}" class="btn btn-outline-primary btn-sm">
                        View All Members <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Quick Links -->
        <div class="col-lg-6">
            <div class="card bg-dark-gray mb-4">
                <div class="card-header bg-dark-gray">
                    <h4 class="mb-0"><i class="fas fa-link me-2"></i> Quick Actions</h4>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('admin.verification.index') }}" class="btn btn-lg btn-accent">
                            <i class="fas fa-user-check me-2"></i> Manage Verifications
                        </a>
                        <a href="{{ route('admin.members.index') }}" class="btn btn-lg btn-primary">
                            <i class="fas fa-users-cog me-2"></i> Manage Members
                        </a>
                        <a href="{{ route('admin.admins.create') }}" class="btn btn-lg btn-success">
                            <i class="fas fa-user-shield me-2"></i> Create New Admin
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- System Information -->
            <div class="card bg-dark-gray">
                <div class="card-header bg-dark-gray">
                    <h4 class="mb-0"><i class="fas fa-info-circle me-2"></i> System Information</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Laravel Version:</div>
                        <div class="col-md-8">{{ app()->version() }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">PHP Version:</div>
                        <div class="col-md-8">{{ phpversion() }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Database:</div>
                        <div class="col-md-8">{{ config('database.default') }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 fw-bold">Server Time:</div>
                        <div class="col-md-8">{{ now()->format('F d, Y H:i:s') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection