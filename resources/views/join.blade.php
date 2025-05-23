@extends('Layouts.app')

@section('title', 'Join Us')

@section('content')
<div class="container py-5 my-5">
    <h1 class="section-title" data-aos="fade-up">JOIN THE ODYSSEY</h1>
    
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
            <p class="lead">Ready to become part of an elite gaming brotherhood? The Odyssey Clan is always seeking talented and dedicated warriors to join our ranks.</p>
            <div class="alert alert-warning mt-3">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>IMPORTANT:</strong> You must be at least 18 years old to join Odyssey Clan. This requirement is strictly enforced for all members.
            </div>
        </div>
    </div>
    
    <!-- Main Call to Action -->
    <div class="row mb-5" data-aos="fade-up">
        <div class="col-lg-10 mx-auto">
            <div class="card bg-dark-gray border-accent overflow-hidden">
                <div class="row g-0">
                    <div class="col-md-6">
                        <div class="card-body p-4 p-md-5">
                            <h2 class="card-title text-accent mb-4">Become a Warrior</h2>
                            <p class="card-text">Odyssey Clan offers a competitive yet supportive environment where you can hone your skills and rise through the ranks. We compete in tournaments, organize training sessions, and foster a strong sense of community.</p>
                            <div class="d-grid gap-3 mt-4">
                                <a href="{{ route('register') }}" class="btn btn-lg btn-accent">
                                    <i class="fas fa-user-plus me-2"></i> Register as Member
                                </a>
                                <a href="https://discord.gg/odyssey" class="btn btn-lg btn-outline" target="_blank">
                                    <i class="fab fa-discord me-2"></i> Join our Discord
                                </a>
                                <button class="btn btn-outline" type="button" data-bs-toggle="modal" data-bs-target="#requirementsModal">
                                    <i class="fas fa-info-circle me-2"></i> View Requirements
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-none d-md-block">
                        <img src="/images/logo.png" alt="Join Odyssey Clan" class="img-fluid h-100" style="object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Rank Structure -->
    <div class="row mb-5">
        <div class="col-12" data-aos="fade-up">
            <h2 class="text-center mb-4">Clan Rank Structure</h2>
            <div class="card bg-dark-gray">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-4 mb-md-0" data-aos="fade-up">
                            <div class="text-center p-3 h-100" style="border-right: 1px solid var(--light-gray);">
                                <div class="rank-icon mb-3">
                                    <i class="fas fa-crown fa-3x text-warning"></i>
                                </div>
                                <h4 class="text-accent">Leadership</h4>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><span class="badge bg-primary">Commander</span> - Clan leader</li>
                                    <li class="mb-2"><span class="badge bg-primary">Captain</span> - Division leaders</li>
                                </ul>
                                <p class="small text-white">These ranks are earned through dedication, leadership, and consistent contribution to the clan over an extended period.</p>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-4 mb-md-0" data-aos="fade-up" data-aos-delay="100">
                            <div class="text-center p-3 h-100" style="border-right: 1px solid var(--light-gray);">
                                <div class="rank-icon mb-3">
                                    <i class="fas fa-medal fa-3x text-warning"></i>
                                </div>
                                <h4 class="text-accent">Veterans</h4>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><span class="badge bg-danger">Veteran</span> - Senior members</li>
                                </ul>
                                <p class="small text-white">Veterans have proven their worth in multiple tournaments and have been loyal clan members for at least 6 months. They often mentor newer members.</p>
                            </div>
                        </div>
                        
                        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                            <div class="text-center p-3 h-100">
                                <div class="rank-icon mb-3">
                                    <i class="fas fa-shield-alt fa-3x text-warning"></i>
                                </div>
                                <h4 class="text-accent">Core Members</h4>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><span class="badge bg-warning text-dark">Warrior</span> - Established members</li>
                                    <li class="mb-2"><span class="badge bg-secondary">Recruit</span> - New members</li>
                                </ul>
                                <p class="small text-white">All new members join as Recruits and can progress to Warrior status by actively participating in clan events and demonstrating their skills.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Join Process -->
    <div class="row mb-5">
        <div class="col-lg-10 mx-auto" data-aos="fade-up">
            <h2 class="text-center mb-4">Recruitment Process</h2>
            <div class="card bg-dark-gray">
                <div class="card-body p-4">
                    <div class="timeline">
                        @foreach($process as $index => $step)
                        <div class="timeline-item pb-4 {{ !$loop->last ? 'border-start border-warning ms-3 ps-4 position-relative' : '' }}" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                            @if(!$loop->last)
                            <div class="timeline-marker position-absolute bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; left: -15px; top: 0;">
                                {{ $index + 1 }}
                            </div>
                            @else
                            <div class="d-flex">
                                <div class="timeline-marker bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px;">
                                    {{ $index + 1 }}
                                </div>
                            @endif
                            
                            <div class="mb-3">
                                <h4 class="text-accent">Step {{ $index + 1 }}: {{ explode(':', $step)[0] }}</h4>
                                <p>{{ $step }}</p>
                            </div>
                            
                            @if($loop->last)
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- FAQs -->
    <div class="row">
        <div class="col-lg-10 mx-auto" data-aos="fade-up">
            <h2 class="text-center mb-4">Frequently Asked Questions</h2>
            <div class="accordion" id="faqAccordion">
                @foreach($faqs as $index => $faq)
                <div class="accordion-item bg-dark-gray border-light mb-3" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <h2 class="accordion-header" id="heading{{ $index }}">
                        <button class="accordion-button collapsed bg-dark-gray text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="false" aria-controls="collapse{{ $index }}">
                            {{ $faq['question'] }}
                        </button>
                    </h2>
                    <div id="collapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $index }}" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-white">
                            {{ $faq['answer'] }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Requirements Modal -->
<div class="modal fade" id="requirementsModal" tabindex="-1" aria-labelledby="requirementsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-accent" id="requirementsModalLabel">Membership Requirements</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group list-group-flush bg-transparent">
                    @foreach($requirements as $requirement)
                    <li class="list-group-item bg-transparent text-white border-light">
                        <i class="fas fa-check-circle text-accent me-2"></i> {{ $requirement }}
                        @if(str_contains($requirement, '18+'))
                            <div class="mt-1 ps-4 text-warning small fw-bold">
                                Age verification may be required during the application process.
                            </div>
                        @endif
                    </li>
                    @endforeach
                </ul>
                <div class="alert alert-warning mt-3">
                    <i class="fas fa-info-circle me-2"></i> Meeting these requirements doesn't guarantee acceptance. Final decisions are made by clan leadership.
                </div>
                <div class="alert alert-danger mt-3">
                    <i class="fas fa-exclamation-triangle me-2"></i> <strong>NOTE:</strong> The age requirement of 18+ is strictly enforced. Misrepresenting your age will result in immediate removal from the clan.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="https://discord.gg/odyssey" class="btn btn-accent" target="_blank">
                    <i class="fab fa-discord me-2"></i> Apply Now
                </a>
            </div>
        </div>
    </div>
</div>

@section('extra-js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add your JavaScript here if needed
    });
</script>
@endsection

@endsection