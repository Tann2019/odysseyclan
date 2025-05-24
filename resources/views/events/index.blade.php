@extends('Layouts.app')

@section('title', 'Events')

@section('content')
<div class="container py-5 my-5">
    <!-- Hero Header -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-4 fw-bold text-white mb-3" data-aos="fade-up">
                UPCOMING <span class="text-accent">EVENTS</span>
            </h1>
            <p class="lead text-muted mb-4" data-aos="fade-up" data-aos-delay="100">
                Join your fellow warriors in epic battles, training sessions, and community events
            </p>
            <div class="hero-divider mx-auto" data-aos="fade-up" data-aos-delay="200"></div>
        </div>
    </div>
    
    <!-- Event Type Filter -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="filter-section p-4 bg-dark-gray rounded border border-accent" data-aos="fade-up">
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <button class="btn btn-filter active" data-filter="all">
                        <i class="fas fa-globe me-2"></i> All Events
                    </button>
                    <button class="btn btn-filter" data-filter="tournament">
                        <i class="fas fa-trophy me-2"></i> Tournaments
                    </button>
                    <button class="btn btn-filter" data-filter="training">
                        <i class="fas fa-dumbbell me-2"></i> Training
                    </button>
                    <button class="btn btn-filter" data-filter="special">
                        <i class="fas fa-star me-2"></i> Special
                    </button>
                    <button class="btn btn-filter" data-filter="community">
                        <i class="fas fa-users me-2"></i> Community
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Events Grid -->
    @if($events->count() > 0)
        <div class="row g-4 event-container">
            @foreach($events as $event)
            <div class="col-lg-6 col-xl-4 event-item" data-category="{{ $event->type }}" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="event-card h-100">
                    <!-- Event Image -->
                    <div class="event-image-container">
                        <img src="{{ $event->image_url ?: 'https://images.unsplash.com/photo-1542751371-adc38448a05e?w=400&h=250&fit=crop' }}" 
                             class="event-image" alt="{{ $event->title }}">
                        <div class="event-overlay">
                            <div class="event-badges">
                                @if($event->is_featured)
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-star me-1"></i> Featured
                                    </span>
                                @endif
                                <span class="badge bg-{{ $event->type_color }}">
                                    {{ ucfirst($event->type) }}
                                </span>
                            </div>
                            <div class="event-countdown">
                                @if($event->event_date->isFuture())
                                    @if((int)$event->days_left == 0)
                                        <span class="badge bg-success fs-6">Today!</span>
                                    @elseif((int)$event->days_left <= 7)
                                        <span class="badge bg-danger fs-6">{{ (int)$event->days_left }} days left</span>
                                    @else
                                        <span class="badge bg-info fs-6">{{ (int)$event->days_left }} days left</span>
                                    @endif
                                @else
                                    <span class="badge bg-secondary fs-6">Past Event</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Event Content -->
                    <div class="event-content">
                        <div class="event-header">
                            <h4 class="event-title">{{ $event->title }}</h4>
                            <div class="event-meta">
                                <div class="event-date">
                                    <i class="fas fa-calendar-alt text-accent me-2"></i>
                                    {{ $event->event_date->format('M d, Y') }}
                                </div>
                                <div class="event-time">
                                    <i class="fas fa-clock text-accent me-2"></i>
                                    {{ $event->event_date->format('H:i') }} UTC
                                </div>
                            </div>
                        </div>
                        
                        <div class="event-description">
                            <p>{{ Str::limit($event->description, 120) }}</p>
                        </div>
                        
                        <div class="event-details">
                            @if($event->max_participants)
                                <div class="detail-item">
                                    <i class="fas fa-users text-accent me-2"></i>
                                    <span>Max {{ $event->max_participants }} participants</span>
                                </div>
                            @endif
                            
                            @if($event->registration_deadline)
                                <div class="detail-item">
                                    <i class="fas fa-hourglass-half text-accent me-2"></i>
                                    <span>Register by {{ $event->registration_deadline->format('M d') }}</span>
                                </div>
                            @endif
                            
                            <div class="detail-item">
                                <i class="fas fa-user-crown text-accent me-2"></i>
                                <span>By {{ $event->creator->name }}</span>
                            </div>
                        </div>
                        
                        <div class="event-actions">
                            <a href="{{ route('events.show', $event->id) }}" class="btn btn-accent flex-fill">
                                <i class="fas fa-info-circle me-2"></i> View Details
                            </a>
                            @if($event->event_date->isFuture() && (!$event->registration_deadline || $event->registration_deadline->isFuture()))
                                <a href="https://discord.gg/odyssey" class="btn btn-outline-primary" target="_blank" title="Join Event">
                                    <i class="fab fa-discord"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <!-- No Events -->
        <div class="row">
            <div class="col-12">
                <div class="no-events-container text-center py-5" data-aos="fade-up">
                    <div class="no-events-icon mb-4">
                        <i class="fas fa-calendar-times fa-5x text-muted"></i>
                    </div>
                    <h3 class="text-muted mb-3">No Events Scheduled</h3>
                    <p class="text-muted mb-4">Check back soon for upcoming clan events and activities.</p>
                    <a href="https://discord.gg/odyssey" class="btn btn-accent">
                        <i class="fab fa-discord me-2"></i> Join Our Discord
                    </a>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Call to Action -->
    <div class="row mt-5">
        <div class="col-lg-8 mx-auto">
            <div class="cta-section p-5 bg-dark-gray border border-accent rounded text-center" data-aos="fade-up">
                <div class="cta-icon mb-4">
                    <i class="fab fa-discord fa-4x text-accent"></i>
                </div>
                <h3 class="text-white mb-3">Never Miss an Event</h3>
                <p class="text-muted mb-4">
                    Join our Discord server to receive instant notifications about upcoming events, 
                    participate in discussions, and connect with fellow clan members.
                </p>
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                    <a href="https://discord.gg/odyssey" class="btn btn-accent btn-lg" target="_blank">
                        <i class="fab fa-discord me-2"></i> Join Discord Server
                    </a>
                    <a href="{{ route('join') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-user-plus me-2"></i> Join Odyssey Clan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hero-divider {
    width: 100px;
    height: 4px;
    background: linear-gradient(90deg, var(--accent), var(--primary), var(--accent));
    border-radius: 2px;
}

.filter-section {
    background: linear-gradient(135deg, var(--dark-gray), var(--mid-gray)) !important;
}

.btn-filter {
    background: var(--dark);
    color: var(--text);
    border: 2px solid var(--light-gray);
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn-filter::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: var(--accent);
    transition: left 0.3s ease;
    z-index: -1;
}

.btn-filter:hover::before,
.btn-filter.active::before {
    left: 0;
}

.btn-filter:hover,
.btn-filter.active {
    color: var(--dark);
    border-color: var(--accent);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 215, 0, 0.3);
}

.event-card {
    background: var(--dark-gray);
    border: 1px solid var(--light-gray);
    border-radius: 15px;
    overflow: hidden;
    transition: all 0.3s ease;
    position: relative;
}

.event-card:hover {
    transform: translateY(-10px);
    border-color: var(--accent);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
}

.event-image-container {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.event-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.event-card:hover .event-image {
    transform: scale(1.05);
}

.event-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.7));
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 1rem;
}

.event-badges {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.event-countdown {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
}

.event-content {
    padding: 1.5rem;
    background: var(--dark-gray);
}

.event-title {
    color: var(--accent);
    font-weight: 700;
    margin-bottom: 1rem;
    font-size: 1.25rem;
}

.event-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1rem;
    font-size: 0.9rem;
    color: var(--text);
}

.event-description {
    color: var(--text);
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.event-details {
    margin-bottom: 1.5rem;
}

.detail-item {
    display: flex;
    align-items: center;
    color: var(--text);
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.event-actions {
    display: flex;
    gap: 0.75rem;
}

.cta-section {
    background: linear-gradient(135deg, var(--dark-gray), var(--mid-gray)) !important;
}

.cta-icon {
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.no-events-container {
    padding: 4rem 2rem;
    background: var(--dark-gray);
    border-radius: 15px;
    border: 1px solid var(--light-gray);
}

.no-events-icon {
    opacity: 0.5;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .event-actions {
        flex-direction: column;
    }
    
    .btn-filter {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }
    
    .event-meta {
        flex-direction: column;
        gap: 0.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Event filtering
    const filterButtons = document.querySelectorAll('.btn-filter');
    const eventItems = document.querySelectorAll('.event-item');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Get filter value
            const filterValue = this.getAttribute('data-filter');
            
            // Filter events with animation
            eventItems.forEach((item, index) => {
                if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                    item.style.display = 'block';
                    item.style.animation = `fadeInUp 0.6s ease ${index * 0.1}s both`;
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
});

// Add fadeInUp animation
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;
document.head.appendChild(style);
</script>
@endsection