<!-- resources/views/index.blade.php -->
@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="hero-section d-flex align-items-center text-center">
    <div class="container">
        <h1 class="display-2 mb-4" style="font-weight: 700; color: var(--spartan-gold);">ODYSSEY</h1>
        <p class="lead mb-4">Where legends are forged in the heat of battle</p>
        <a href="/join" class="btn btn-lg px-5" style="background-color: var(--spartan-red); color: var(--spartan-gold); border: 2px solid var(--spartan-gold);">
            Join the Legion
        </a>
    </div>
</div>

<div class="container my-5">
    <!-- Featured Members Section -->
    <div class="row mb-5">
        <div class="col-12 text-center mb-4">
            <h2 style="color: var(--spartan-gold)">Elite Warriors</h2>
            <div class="w-25 mx-auto" style="height: 3px; background-color: var(--spartan-red);"></div>
        </div>
        <div class="col-12">
            <div class="row" id="featured-members">
                <!-- JavaScript will populate this section -->
            </div>
        </div>
    </div>

    <!-- Clan Stats Section -->
    <div class="row mb-5">
        <div class="col-md-4 text-center mb-4 mb-md-0">
            <div class="p-4 member-card">
                <h3 class="display-4 text-warning" id="total-members">0</h3>
                <p class="text-uppercase">Active Warriors</p>
            </div>
        </div>
        <div class="col-md-4 text-center mb-4 mb-md-0">
            <div class="p-4 member-card">
                <h3 class="display-4 text-warning" id="total-victories">0</h3>
                <p class="text-uppercase">Victories</p>
            </div>
        </div>
        <div class="col-md-4 text-center">
            <div class="p-4 member-card">
                <h3 class="display-4 text-warning" id="achievements">0</h3>
                <p class="text-uppercase">Achievements</p>
            </div>
        </div>
    </div>

    <!-- Latest News Section -->
    <div class="row mb-5">
        <div class="col-12 text-center mb-4">
            <h2 style="color: var(--spartan-gold)">Battle Reports</h2>
            <div class="w-25 mx-auto" style="height: 3px; background-color: var(--spartan-red);"></div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="member-card p-3 h-100">
                <div class="small text-warning mb-2">2024-04-08</div>
                <h4>Tournament Victory</h4>
                <p class="mb-0">Odyssey clan dominates in the latest championship, securing first place.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="member-card p-3 h-100">
                <div class="small text-warning mb-2">2024-04-07</div>
                <h4>New Recruits Welcome</h4>
                <p class="mb-0">Join our next training session and prove your worth in battle.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="member-card p-3 h-100">
                <div class="small text-warning mb-2">2024-04-06</div>
                <h4>Strategy Meeting</h4>
                <p class="mb-0">Weekly tactical briefing scheduled for all squad leaders.</p>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for dynamic content -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fetch featured members
    fetch('/api/v1/members')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const featuredMembers = data.data.slice(0, 3); // Get first 3 members
                const membersContainer = document.getElementById('featured-members');
                
                featuredMembers.forEach(member => {
                    const memberHtml = `
                        <div class="col-md-4 mb-4">
                            <div class="member-card p-3 text-center">
                                <img src="${member.avatar_url || '/images/default-avatar.png'}" 
                                     alt="${member.username}" 
                                     class="rounded-circle mb-3"
                                     style="width: 120px; height: 120px; object-fit: cover; border: 3px solid var(--spartan-gold);">
                                <h4 style="color: var(--spartan-gold)">${member.username}</h4>
                                <div class="badge bg-danger mb-2">${member.rank}</div>
                                <p class="mb-0">${member.description || 'A mighty warrior of Odyssey'}</p>
                            </div>
                        </div>
                    `;
                    membersContainer.innerHTML += memberHtml;
                });

                // Update total members count
                document.getElementById('total-members').textContent = data.data.length;
            }
        })
        .catch(error => console.error('Error fetching members:', error));

    // Animate stats numbers (for demonstration)
    function animateValue(id, start, end, duration) {
        const obj = document.getElementById(id);
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            obj.textContent = Math.floor(progress * (end - start) + start);
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }

    // Example stat animations
    animateValue("total-victories", 0, 157, 2000);
    animateValue("achievements", 0, 42, 2000);
});
</script>
@endsection