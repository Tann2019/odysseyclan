@extends('Layouts.app')

@section('title', 'Leaderboard')

@section('content')
<div class="container py-5 my-5">
    <h1 class="section-title" data-aos="fade-up">CLAN LEADERBOARD</h1>
    
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
            <p class="lead">Track the finest warriors in Odyssey Clan. Rankings are based on achievements, tournament performances, and overall contributions to the clan.</p>
        </div>
    </div>
    
    <!-- Leaderboard Categories -->
    <div class="mb-4 text-center" data-aos="fade-up">
        <div class="btn-group leaderboard-filter">
            <button class="btn btn-outline active" data-filter="achievements">Achievements</button>
            <button class="btn btn-outline" data-filter="tournaments">Tournament Wins</button>
            <button class="btn btn-outline" data-filter="contributions">Clan Contributions</button>
        </div>
    </div>
    
    <!-- Leaderboard Table -->
    <div class="card bg-dark-gray" data-aos="fade-up">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0">
                    <thead>
                        <tr>
                            <th scope="col" width="10%">Rank</th>
                            <th scope="col" width="15%">Avatar</th>
                            <th scope="col" width="25%">Username</th>
                            <th scope="col" width="15%">Clan Rank</th>
                            <th scope="col" width="20%">Achievements</th>
                            <th scope="col" width="15%">Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members as $index => $member)
                        @php
                            $achievements = $member->achievements ?? [];
                            $score = count($achievements) * 100;
                        @endphp
                        <tr class="{{ $index < 3 ? 'table-warning' : '' }}">
                            <td class="align-middle {{ $index < 3 ? 'text-dark' : '' }}">
                                @if($index === 0)
                                    <div class="d-flex justify-content-center">
                                        <span class="badge bg-warning text-dark p-2" style="font-size: 1.2rem;">
                                            <i class="fas fa-trophy"></i> 1
                                        </span>
                                    </div>
                                @elseif($index === 1)
                                    <div class="d-flex justify-content-center">
                                        <span class="badge bg-secondary p-2" style="font-size: 1.1rem;">
                                            <i class="fas fa-trophy"></i> 2
                                        </span>
                                    </div>
                                @elseif($index === 2)
                                    <div class="d-flex justify-content-center">
                                        <span class="badge bg-danger p-2" style="font-size: 1rem;">
                                            <i class="fas fa-trophy"></i> 3
                                        </span>
                                    </div>
                                @else
                                    <div class="text-center">{{ $index + 1 }}</div>
                                @endif
                            </td>
                            <td class="align-middle {{ $index < 3 ? 'text-dark' : '' }}">
                                <img src="{{ $member->avatar_url ?? '/images/default-avatar.png' }}" alt="{{ $member->username }}" class="rounded-circle" width="50" height="50" style="object-fit: cover; {{ $index < 3 ? 'border: 3px solid gold;' : '' }}">
                            </td>
                            <td class="align-middle {{ $index < 3 ? 'text-dark' : '' }}">{{ $member->username }}</td>
                            <td class="align-middle {{ $index < 3 ? 'text-dark' : '' }}">
                                <span class="badge bg-{{ $index < 3 ? 'dark' : 'danger' }} {{ $index < 3 ? 'text-warning' : '' }}">{{ $member->rank }}</span>
                            </td>
                            <td class="align-middle {{ $index < 3 ? 'text-dark' : '' }}">
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach(array_slice($achievements, 0, 3) as $achievement)
                                        <span class="badge bg-success">{{ $achievement }}</span>
                                    @endforeach
                                    @if(count($achievements) > 3)
                                        <span class="badge bg-secondary">+{{ count($achievements) - 3 }} more</span>
                                    @endif
                                </div>
                            </td>
                            <td class="align-middle text-center fw-bold {{ $index < 3 ? 'text-dark' : '' }}">{{ $score }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Leaderboard Info -->
    <div class="row mt-5">
        <div class="col-lg-8 mx-auto" data-aos="fade-up">
            <div class="card bg-dark-gray border-accent">
                <div class="card-body">
                    <h3 class="text-accent mb-3">Leaderboard Information</h3>
                    <p>Our leaderboard tracks the top performers in Odyssey Clan based on various metrics:</p>
                    
                    <div class="mb-3">
                        <h5><i class="fas fa-medal text-warning me-2"></i> Achievement Score</h5>
                        <p>Points awarded for completing specific achievements, milestones, and challenges within games.</p>
                    </div>
                    
                    <div class="mb-3">
                        <h5><i class="fas fa-trophy text-warning me-2"></i> Tournament Performance</h5>
                        <p>Points earned through participation and placement in clan tournaments and external competitions.</p>
                    </div>
                    
                    <div class="mb-3">
                        <h5><i class="fas fa-hands-helping text-warning me-2"></i> Clan Contributions</h5>
                        <p>Recognition for organizing events, training new members, and representing the clan in community activities.</p>
                    </div>
                    
                    <div class="alert alert-warning">
                        <i class="fas fa-info-circle me-2"></i> Rankings are updated weekly. Participate in clan events to improve your standing!
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('extra-js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // For demonstration - in a real application, this would fetch different leaderboard data
        const filterButtons = document.querySelectorAll('.leaderboard-filter .btn');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // In a real application, this would fetch and display different leaderboard data
                // For this demo, we'll just show an alert
                alert('In a complete implementation, this would show the ' + this.getAttribute('data-filter') + ' leaderboard data.');
            });
        });
    });
</script>
@endsection

@endsection