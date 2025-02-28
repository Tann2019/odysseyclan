@extends('Layouts.app')

@section('title', $event['title'])

@section('content')
<div class="container py-5 my-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Event Header -->
            <div class="card mb-4 border-0" data-aos="fade-up">
                <div class="position-relative">
                    <img src="{{ $event['image'] }}" class="card-img-top" alt="{{ $event['title'] }}" style="height: 350px; object-fit: cover;">
                    <div class="position-absolute bottom-0 start-0 w-100 p-3" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                        <div class="d-flex justify-content-between align-items-end">
                            <div>
                                <span class="badge bg-{{ $event['badge_color'] }} mb-2">{{ $event['badge'] }}</span>
                                <h1 class="text-white mb-0" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">{{ $event['title'] }}</h1>
                            </div>
                            <span class="text-white"><i class="far fa-calendar-alt me-2"></i>{{ $event['date'] }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="card-body bg-dark-gray">
                    <div class="event-meta d-flex flex-wrap justify-content-between mb-4">
                        <div class="mb-2">
                            <span class="text-accent"><i class="fas fa-tag me-2"></i>Type:</span>
                            <span>{{ $event['type'] }}</span>
                        </div>
                        <div class="mb-2">
                            <span class="text-accent"><i class="fas fa-map-marker-alt me-2"></i>Location:</span>
                            <span>{{ $event['location'] }}</span>
                        </div>
                        <div class="mb-2">
                            <span class="text-accent"><i class="fas fa-clock me-2"></i>Time:</span>
                            <span>{{ $event['time'] }}</span>
                        </div>
                        <div class="mb-2">
                            <span class="text-accent"><i class="fas fa-hourglass-half me-2"></i>Duration:</span>
                            <span>{{ $event['duration'] }}</span>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h4 class="text-accent mb-3">Description</h4>
                        <p>{{ $event['description'] }}</p>
                    </div>
                    
                    <!-- Dynamic content based on event type -->
                    @if(isset($event['prizes']))
                    <div class="mb-4">
                        <h4 class="text-accent mb-3">Prizes</h4>
                        <ul class="list-group list-group-flush bg-transparent">
                            @foreach($event['prizes'] as $prize)
                            <li class="list-group-item bg-transparent text-white border-light">
                                <i class="fas fa-trophy text-accent me-2"></i> {{ $prize }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                    @if(isset($event['rules']))
                    <div class="mb-4">
                        <h4 class="text-accent mb-3">Rules</h4>
                        <ul class="list-group list-group-flush bg-transparent">
                            @foreach($event['rules'] as $rule)
                            <li class="list-group-item bg-transparent text-white border-light">
                                <i class="fas fa-gavel text-accent me-2"></i> {{ $rule }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                    @if(isset($event['content']))
                    <div class="mb-4">
                        <h4 class="text-accent mb-3">Training Content</h4>
                        <ul class="list-group list-group-flush bg-transparent">
                            @foreach($event['content'] as $item)
                            <li class="list-group-item bg-transparent text-white border-light">
                                <i class="fas fa-book-open text-accent me-2"></i> {{ $item }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                    @if(isset($event['requirements']))
                    <div class="mb-4">
                        <h4 class="text-accent mb-3">Requirements</h4>
                        <ul class="list-group list-group-flush bg-transparent">
                            @foreach($event['requirements'] as $requirement)
                            <li class="list-group-item bg-transparent text-white border-light">
                                <i class="fas fa-check-circle text-accent me-2"></i> {{ $requirement }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                    @if(isset($event['highlights']))
                    <div class="mb-4">
                        <h4 class="text-accent mb-3">Event Highlights</h4>
                        <ul class="list-group list-group-flush bg-transparent">
                            @foreach($event['highlights'] as $highlight)
                            <li class="list-group-item bg-transparent text-white border-light">
                                <i class="fas fa-star text-accent me-2"></i> {{ $highlight }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                    @if(isset($event['process']))
                    <div class="mb-4">
                        <h4 class="text-accent mb-3">Process</h4>
                        <ul class="list-group list-group-flush bg-transparent">
                            @foreach($event['process'] as $step)
                            <li class="list-group-item bg-transparent text-white border-light">
                                <i class="fas fa-arrow-right text-accent me-2"></i> {{ $step }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                    @if(isset($event['format']))
                    <div class="mb-4">
                        <h4 class="text-accent mb-3">Format</h4>
                        <ul class="list-group list-group-flush bg-transparent">
                            @foreach($event['format'] as $format)
                            <li class="list-group-item bg-transparent text-white border-light">
                                <i class="fas fa-gamepad text-accent me-2"></i> {{ $format }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                    @if(isset($event['activities']))
                    <div class="mb-4">
                        <h4 class="text-accent mb-3">Activities</h4>
                        <ul class="list-group list-group-flush bg-transparent">
                            @foreach($event['activities'] as $activity)
                            <li class="list-group-item bg-transparent text-white border-light">
                                <i class="fas fa-play text-accent me-2"></i> {{ $activity }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                    <div class="mt-4">
                        <h4 class="text-accent mb-3">Organizer</h4>
                        <p><i class="fas fa-user-shield text-accent me-2"></i> {{ $event['organizer'] }}</p>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-5">
                        <a href="{{ route('events.index') }}" class="btn btn-outline">
                            <i class="fas fa-arrow-left me-2"></i> Back to Events
                        </a>
                        <a href="https://discord.gg/odyssey" class="btn btn-accent">
                            <i class="fab fa-discord me-2"></i> Join Event
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Related Events -->
            <h3 class="text-center mb-4" data-aos="fade-up">Other Upcoming Events</h3>
            <div class="row" data-aos="fade-up">
                @php
                    $relatedEvents = array_filter($events, function($e) use ($event) {
                        return $e['id'] != $event['id'];
                    });
                    $randomEvents = array_rand($relatedEvents, min(2, count($relatedEvents)));
                    if (!is_array($randomEvents)) $randomEvents = [$randomEvents];
                @endphp
                
                @foreach($randomEvents as $randomEventKey)
                    @php $relatedEvent = $relatedEvents[$randomEventKey]; @endphp
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span>{{ $relatedEvent['type'] }}</span>
                                <span class="badge bg-{{ $relatedEvent['badge_color'] }}">{{ $relatedEvent['badge'] }}</span>
                            </div>
                            <img src="{{ $relatedEvent['image'] }}" class="card-img-top" alt="{{ $relatedEvent['title'] }}" style="height: 150px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $relatedEvent['title'] }}</h5>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span><i class="far fa-calendar-alt me-2"></i>{{ $relatedEvent['date'] }}</span>
                                    <a href="{{ route('events.show', $relatedEvent['id']) }}" class="btn btn-sm btn-outline">Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection