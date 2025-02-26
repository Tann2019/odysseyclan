@extends('Layouts.app')

@section('title', 'Home')

@section('content')
<div class="hero-section">
    <div class="container hero-content">
        <div class="row">
            <div class="col-lg-8 col-md-10" data-aos="fade-up">
                <h1 class="hero-title">WELCOME TO <span>ODYSSEY</span></h1>
                <p class="hero-subtitle">Where legends are forged in the heat of battle</p>
                <div class="hero-btn-container d-flex flex-wrap gap-3">
                    <a href="https://discord.gg/hwkZtRZGJs" class="btn hero-btn" target="_blank">
                        <i class="fas fa-user-plus me-2"></i> Join the Legion
                    </a>
                    <a href="#about" class="btn btn-outline">
                        <i class="fas fa-info-circle me-2"></i> Learn More
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="py-5" id="about">
    <div class="container my-5">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                <h2 class="section-title text-start">WHO WE ARE</h2>
                <p class="lead text-accent mb-4">A brotherhood of elite gamers</p>
                <p>Odyssey is more than just a gaming clan - we are a brotherhood of elite gamers united by our passion for excellence and victory. Founded in 2020, our clan has risen through the ranks to establish itself as a formidable force in competitive gaming.</p>
                <p>Our members are carefully selected based on skill, dedication, and sportsmanship. We compete in various tournaments and leagues across multiple game titles, always striving to uphold our reputation for tactical brilliance and unwavering teamwork.</p>
                <div class="d-flex gap-4 mt-4">
                    <div class="text-center">
                        <h3 class="text-accent">50+</h3>
                        <p class="text-uppercase">Active Members</p>
                    </div>
                    <div class="text-center">
                        <h3 class="text-accent">25+</h3>
                        <p class="text-uppercase">Tournament Wins</p>
                    </div>
                    <div class="text-center">
                        <h3 class="text-accent">4+</h3>
                        <p class="text-uppercase">Game Titles</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <img src="/images/team-photo.jpg" alt="Odyssey Team" class="img-fluid rounded" style="border: 3px solid var(--accent);">
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-dark-gray">
    <div class="container my-5">
        <h2 class="section-title" data-aos="fade-up">FEATURED MEMBERS</h2>
        
        <div class="row" id="featured-members">
            <!-- Will be populated via JavaScript/API -->
        </div>
        
        <div class="text-center mt-4" data-aos="fade-up">
            <a href="/members" class="btn btn-outline">
                <i class="fas fa-users me-2"></i> View All Members
            </a>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container my-5">
        <h2 class="section-title" data-aos="fade-up">UPCOMING EVENTS</h2>
        
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Tournament</span>
                        <span class="badge bg-danger">3 Days Left</span>
                    </div>
                    <img src="/images/event1.jpg" class="card-img-top" alt="Tournament">
                    <div class="card-body">
                        <h5 class="card-title">Spring Championship 2025</h5>
                        <p class="card-text">Join us for our quarterly championship where clan members compete for the title of Odyssey Champion.</p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span><i class="far fa-calendar-alt me-2"></i>Feb 28, 2025</span>
                            <a href="/events/1" class="btn btn-sm btn-outline">Details</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Training</span>
                        <span class="badge bg-success">Weekly</span>
                    </div>
                    <img src="/images/event2.jpg" class="card-img-top" alt="Training">
                    <div class="card-body">
                        <h5 class="card-title">Strategy Training Sessions</h5>
                        <p class="card-text">Weekly training sessions focused on improving team coordination and tactical awareness.</p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span><i class="far fa-calendar-alt me-2"></i>Every Thursday</span>
                            <a href="/events/2" class="btn btn-sm btn-outline">Details</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100 card-highlight">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Special</span>
                        <span class="badge bg-warning text-dark">Featured</span>
                    </div>
                    <img src="/images/event3.jpg" class="card-img-top" alt="Community Stream">
                    <div class="card-body">
                        <h5 class="card-title">Anniversary Community Stream</h5>
                        <p class="card-text">Join us for a special stream celebrating our 5th anniversary with giveaways and special guests.</p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span><i class="far fa-calendar-alt me-2"></i>Mar 15, 2025</span>
                            <a href="/events/3" class="btn btn-sm btn-outline">Details</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4" data-aos="fade-up">
            <a href="/events" class="btn btn-outline">
                <i class="fas fa-calendar-alt me-2"></i> View All Events
            </a>
        </div>
    </div>
</section>

<section class="py-5 bg-dark-gray">
    <div class="container my-5">
        <h2 class="section-title" data-aos="fade-up">LATEST NEWS</h2>
        
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="small text-accent mb-2">February 25, 2025</div>
                        <h5 class="card-title">Tournament Victory</h5>
                        <p class="card-text">Odyssey clan dominates in the latest championship, securing first place against 32 other teams.</p>
                        <a href="/news/1" class="btn btn-sm btn-outline">Read More</a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="small text-accent mb-2">February 20, 2025</div>
                        <h5 class="card-title">New Recruits Welcome</h5>
                        <p class="card-text">Join our next training session and prove your worth in battle. We're looking for new talent to join our ranks.</p>
                        <a href="/news/2" class="btn btn-sm btn-outline">Read More</a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="small text-accent mb-2">February 15, 2025</div>
                        <h5 class="card-title">Strategy Meeting</h5>
                        <p class="card-text">Weekly tactical briefing scheduled for all squad leaders.</p>
                        <a href="/news/3" class="btn btn-sm btn-outline">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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