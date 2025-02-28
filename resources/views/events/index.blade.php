@extends('Layouts.app')

@section('title', 'Events')

@section('content')
<div class="container py-5 my-5">
    <h1 class="section-title" data-aos="fade-up">UPCOMING EVENTS</h1>
    
    <!-- Event Type Filter -->
    <div class="mb-4 text-center" data-aos="fade-up">
        <div class="btn-group event-filter">
            <button class="btn btn-outline active" data-filter="all">All Events</button>
            <button class="btn btn-outline" data-filter="Tournament">Tournaments</button>
            <button class="btn btn-outline" data-filter="Training">Training</button>
            <button class="btn btn-outline" data-filter="Special">Special</button>
            <button class="btn btn-outline" data-filter="Recruitment">Recruitment</button>
            <button class="btn btn-outline" data-filter="Social">Social</button>
        </div>
    </div>
    
    <div class="row event-container">
        @foreach($events as $event)
        <div class="col-lg-4 col-md-6 mb-4 event-item" data-category="{{ $event['type'] }}" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ $event['type'] }}</span>
                    <span class="badge bg-{{ $event['badge_color'] }}">{{ $event['badge'] }}</span>
                </div>
                <img src="{{ $event['image'] }}" class="card-img-top" alt="{{ $event['title'] }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $event['title'] }}</h5>
                    <p class="card-text">{{ $event['description'] }}</p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span><i class="far fa-calendar-alt me-2"></i>{{ $event['date'] }}</span>
                        <a href="{{ route('events.show', $event['id']) }}" class="btn btn-sm btn-outline">Details</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <!-- Subscribe to Events -->
    <div class="row mt-5">
        <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
            <div class="card bg-dark-gray border-accent p-4">
                <h3 class="text-accent mb-3">Never Miss an Event</h3>
                <p>Join our Discord server to receive notifications about upcoming events and activities.</p>
                <a href="https://discord.gg/odyssey" class="btn btn-accent mx-auto mt-2 mb-2" style="max-width: 250px;">
                    <i class="fab fa-discord me-2"></i> Join Our Discord
                </a>
            </div>
        </div>
    </div>
</div>

@section('extra-js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Event filtering
        const filterButtons = document.querySelectorAll('.event-filter .btn');
        const eventItems = document.querySelectorAll('.event-item');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Get filter value
                const filterValue = this.getAttribute('data-filter');
                
                // Filter events
                eventItems.forEach(item => {
                    if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
@endsection

@endsection