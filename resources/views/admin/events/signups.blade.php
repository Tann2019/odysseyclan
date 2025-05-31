@extends('Layouts.app')

@section('title', 'Event Signups - ' . $event->title)

@section('content')
<div class="container py-5">
    <!-- Header Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-accent">Admin</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.events.index') }}" class="text-accent">Events</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.events.show', $event) }}" class="text-accent">{{ $event->title }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Signups</li>
                        </ol>
                    </nav>
                    <h1 class="display-6 fw-bold text-white mb-2">Event Signups</h1>
                    <p class="text-light mb-0">{{ $event->title }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.events.show', $event) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Back to Event
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-dark-gray border-accent">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-2x text-accent mb-3"></i>
                    <h3 class="text-white mb-1">{{ $event->signups()->where('status', 'registered')->count() }}</h3>
                    <p class="text-light mb-0">Registered</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark-gray border-accent">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-2x text-success mb-3"></i>
                    <h3 class="text-white mb-1">{{ $event->signups()->where('status', 'attended')->count() }}</h3>
                    <p class="text-light mb-0">Attended</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark-gray border-accent">
                <div class="card-body text-center">
                    <i class="fas fa-times-circle fa-2x text-danger mb-3"></i>
                    <h3 class="text-white mb-1">{{ $event->signups()->where('status', 'cancelled')->count() }}</h3>
                    <p class="text-light mb-0">Cancelled</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark-gray border-accent">
                <div class="card-body text-center">
                    <i class="fas fa-user-slash fa-2x text-warning mb-3"></i>
                    <h3 class="text-white mb-1">{{ $event->signups()->where('status', 'no_show')->count() }}</h3>
                    <p class="text-light mb-0">No Show</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Signups Table -->
    <div class="card bg-dark-gray border-accent">
        <div class="card-header bg-primary border-accent">
            <h4 class="mb-0 text-white">
                <i class="fas fa-list me-2"></i> Event Signups ({{ $signups->total() }})
            </h4>
        </div>
        <div class="card-body p-0">
            @if($signups->count() > 0)
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Member</th>
                                <th>Rank</th>
                                <th>Signed Up</th>
                                <th>Status</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($signups as $signup)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($signup->member->avatar_url)
                                            <img src="{{ $signup->member->avatar_url }}" alt="{{ $signup->member->username }}" 
                                                 class="rounded-circle me-3" style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="bg-accent rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 40px; height: 40px;">
                                                <i class="fas fa-user text-dark"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-0 text-white">{{ $signup->member->username }}</h6>
                                            <small class="text-light">{{ $signup->member->discord_id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ ucfirst($signup->member->rank) }}</span>
                                </td>
                                <td>
                                    <div>
                                        <div class="text-white">{{ $signup->signed_up_at->format('M d, Y') }}</div>
                                        <small class="text-light">{{ $signup->signed_up_at->format('H:i') }}</small>
                                    </div>
                                </td>
                                <td>
                                    @switch($signup->status)
                                        @case('registered')
                                            <span class="badge bg-success">Registered</span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                            @break
                                        @case('attended')
                                            <span class="badge bg-info">Attended</span>
                                            @break
                                        @case('no_show')
                                            <span class="badge bg-warning text-dark">No Show</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    @if($signup->notes)
                                        <span class="text-light" title="{{ $signup->notes }}">
                                            {{ Str::limit($signup->notes, 30) }}
                                        </span>
                                    @else
                                        <span class="text-white">No notes</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-accent dropdown-toggle" type="button" 
                                                data-bs-toggle="dropdown">
                                            <i class="fas fa-cog"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-dark">
                                            @if($signup->status !== 'registered')
                                                <li>
                                                    <form action="{{ route('admin.events.signups.update', [$event, $signup]) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="registered">
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fas fa-user-check me-2"></i> Mark Registered
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                            @if($signup->status !== 'attended')
                                                <li>
                                                    <form action="{{ route('admin.events.signups.update', [$event, $signup]) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="attended">
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fas fa-check me-2"></i> Mark Attended
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                            @if($signup->status !== 'no_show')
                                                <li>
                                                    <form action="{{ route('admin.events.signups.update', [$event, $signup]) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="no_show">
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fas fa-user-slash me-2"></i> Mark No Show
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                            @if($signup->status !== 'cancelled')
                                                <li>
                                                    <form action="{{ route('admin.events.signups.update', [$event, $signup]) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="cancelled">
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fas fa-times me-2"></i> Mark Cancelled
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($signups->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $signups->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-3x text-white mb-3"></i>
                    <h5 class="text-light">No signups yet</h5>
                    <p class="text-white">No members have signed up for this event.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.border-accent {
    border-color: var(--accent) !important;
}

.breadcrumb {
    background: none;
    padding: 0;
}

.breadcrumb-item + .breadcrumb-item::before {
    color: var(--accent);
    content: "›";
}

.card-header.bg-primary {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark)) !important;
}

.table-dark {
    --bs-table-bg: transparent;
}

.table-dark th {
    border-color: var(--accent);
    color: var(--accent);
}

.table-dark td {
    border-color: rgba(255, 255, 255, 0.1);
}

.dropdown-menu-dark {
    background-color: var(--dark-gray);
    border: 1px solid var(--accent);
}

.dropdown-item:hover {
    background-color: var(--accent);
    color: var(--dark);
}
</style>
@endsection