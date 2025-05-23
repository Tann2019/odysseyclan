@extends('Layouts.app')

@section('title', 'Members')

@section('content')
<div class="container my-5">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 style="color: var(--spartan-gold)">Our Warriors</h1>
        </div>
        <div class="col-md-6 text-md-end">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-warning active" id="grid-view">
                    <i class="fas fa-th-large"></i>
                </button>
                <button type="button" class="btn btn-outline-warning" id="list-view">
                    <i class="fas fa-list"></i>
                </button>
            </div>
        </div>
    </div>

    <form action="{{ route('members.index') }}" method="GET" class="row mb-4">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control bg-dark text-light border-warning" 
                   placeholder="Search warriors..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="rank" class="form-select bg-dark text-light border-warning">
                <option value="">All Ranks</option>
                @foreach($ranks as $rank)
                    <option value="{{ $rank }}" {{ request('rank') == $rank ? 'selected' : '' }}>
                        {{ ucfirst($rank) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="sort" class="form-select bg-dark text-light border-warning">
                <option value="rank" {{ request('sort') == 'rank' ? 'selected' : '' }}>Sort by Rank</option>
                <option value="username" {{ request('sort') == 'username' ? 'selected' : '' }}>Sort by Name</option>
                <option value="joined" {{ request('sort') == 'joined' ? 'selected' : '' }}>Sort by Join Date</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-warning w-100">Filter</button>
        </div>
    </form>

    @if($members->count() == 0)
        <div class="text-center my-5">
            <h3 class="text-warning">No warriors found</h3>
            <p>Try adjusting your search criteria</p>
        </div>
    @else
        <div id="members-container" class="row g-4">
            @foreach($members as $member)
                <div class="col-md-4 member-item">
                    <div class="member-card p-4 text-center h-100">
                        <img src="{{ $member->avatar_url ?? asset('images/default-avatar.png') }}" 
                             alt="{{ $member->username }}" 
                             class="rounded-circle mb-3"
                             style="width: 150px; height: 150px; object-fit: cover; border: 3px solid var(--spartan-gold);">
                        <h4 style="color: var(--spartan-gold)">{{ $member->username }}</h4>
                        <div class="badge bg-danger mb-2">{{ ucfirst($member->rank) }}</div>
                        <p class="mb-3">{{ $member->description ?? 'A mighty warrior of Odyssey' }}</p>
                        
                        <button type="button" class="btn btn-outline-warning btn-sm view-member-btn"
                                data-member-id="{{ $member->id }}"
                                data-member-username="{{ $member->username }}"
                                data-member-rank="{{ $member->rank }}"
                                data-member-avatar="{{ $member->avatar_url ?? asset('images/default-avatar.png') }}"
                                data-member-description="{{ $member->description ?? 'A mighty warrior of Odyssey' }}"
                                data-member-achievements="{{ $member->achievements ? json_encode($member->achievements) : '[]' }}">
                            View Profile
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
        </div>
    @endif
</div>

<!-- Single Reusable Member Modal -->
<div class="modal fade" id="memberModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark">
            <div class="modal-header border-warning">
                <h5 class="modal-title text-warning">Warrior Profile</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <img id="modal-avatar" src="" alt="" class="rounded-circle mb-3"
                         style="width: 200px; height: 200px; object-fit: cover; border: 4px solid var(--spartan-gold);">
                    <h3 id="modal-username" style="color: var(--spartan-gold)"></h3>
                    <div id="modal-rank" class="badge bg-danger mb-3"></div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="text-warning">About</h5>
                        <p id="modal-description"></p>
                    </div>
                    <div class="col-md-6">
                        <h5 class="text-warning">Achievements</h5>
                        <ul id="modal-achievements" class="list-unstyled"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const gridView = document.getElementById('grid-view');
    const listView = document.getElementById('list-view');
    const container = document.getElementById('members-container');

    gridView.addEventListener('click', function() {
        this.classList.add('active');
        listView.classList.remove('active');
        container.classList.remove('list-view');
        localStorage.setItem('memberView', 'grid');
    });

    listView.addEventListener('click', function() {
        this.classList.add('active');
        gridView.classList.remove('active');
        container.classList.add('list-view');
        localStorage.setItem('memberView', 'list');
    });

    // Restore view preference
    if (localStorage.getItem('memberView') === 'list') {
        listView.click();
    }

    // Handle member modal
    document.querySelectorAll('.view-member-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const memberData = {
                username: this.dataset.memberUsername,
                rank: this.dataset.memberRank,
                avatar: this.dataset.memberAvatar,
                description: this.dataset.memberDescription,
                achievements: JSON.parse(this.dataset.memberAchievements || '[]')
            };

            // Populate modal
            document.getElementById('modal-avatar').src = memberData.avatar;
            document.getElementById('modal-avatar').alt = memberData.username;
            document.getElementById('modal-username').textContent = memberData.username;
            document.getElementById('modal-rank').textContent = memberData.rank.charAt(0).toUpperCase() + memberData.rank.slice(1);
            document.getElementById('modal-description').textContent = memberData.description;

            // Populate achievements
            const achievementsList = document.getElementById('modal-achievements');
            achievementsList.innerHTML = '';
            if (memberData.achievements.length > 0) {
                memberData.achievements.forEach(function(achievement) {
                    const li = document.createElement('li');
                    li.innerHTML = '<i class="fas fa-trophy text-warning me-2"></i>' + achievement;
                    achievementsList.appendChild(li);
                });
            } else {
                const li = document.createElement('li');
                li.textContent = 'No achievements yet';
                achievementsList.appendChild(li);
            }

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('memberModal'));
            modal.show();
        });
    });
});
</script>

<style>
/* Add these styles for list view */
#members-container.list-view {
    display: block;
}

#members-container.list-view .member-item {
    width: 100%;
    max-width: 100%;
    flex: 0 0 100%;
}

#members-container.list-view .member-card {
    display: flex;
    text-align: left;
    align-items: center;
}

#members-container.list-view .member-card img {
    width: 80px;
    height: 80px;
    margin-right: 1rem;
}

/* Style the pagination */
.pagination {
    --bs-pagination-color: var(--spartan-gold);
    --bs-pagination-bg: var(--dark-grey);
    --bs-pagination-border-color: var(--spartan-gold);
    --bs-pagination-hover-color: var(--dark-grey);
    --bs-pagination-hover-bg: var(--spartan-gold);
    --bs-pagination-focus-color: var(--spartan-gold);
    --bs-pagination-active-bg: var(--spartan-red);
    --bs-pagination-active-border-color: var(--spartan-gold);
}
</style>
@endsection