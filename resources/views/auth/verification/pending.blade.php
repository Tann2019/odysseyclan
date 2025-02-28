@extends('Layouts.app')

@section('title', 'Verification Pending')

@section('content')
<div class="container py-5 my-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card bg-dark-gray border-warning" data-aos="fade-up">
                <div class="card-header bg-warning text-dark">
                    <h3 class="mb-0"><i class="fas fa-clock me-2"></i> Verification Pending</h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="display-1 text-warning">
                            <i class="fas fa-user-clock"></i>
                        </div>
                        <h2 class="mt-4 text-white">Your Account is Awaiting Verification</h2>
                        <p class="lead text-white">Thank you for registering with Odyssey Clan!</p>
                    </div>
                    
                    <div class="alert alert-info" role="alert">
                        <h4 class="alert-heading"><i class="fas fa-info-circle me-2"></i> What's Next?</h4>
                        <p>Our admin team needs to verify your membership before you can access all clan features. This typically takes 24-48 hours, but may take longer during weekends or holidays.</p>
                        <hr>
                        <p class="mb-0">Meanwhile, you can complete your profile with accurate information to help speed up the verification process.</p>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card bg-dark mb-4">
                                <div class="card-body">
                                    <h4 class="text-accent"><i class="fas fa-tasks me-2"></i> Next Steps</h4>
                                    <ul class="list-group list-group-flush bg-transparent">
                                        <li class="list-group-item bg-transparent text-white border-light">
                                            <i class="fas fa-check-circle text-success me-2"></i> Join our Discord server
                                        </li>
                                        <li class="list-group-item bg-transparent text-white border-light">
                                            <i class="fas fa-check-circle text-success me-2"></i> Complete your member profile
                                        </li>
                                        <li class="list-group-item bg-transparent text-white border-light">
                                            <i class="fas fa-hourglass-half text-warning me-2"></i> Wait for admin verification
                                        </li>
                                        <li class="list-group-item bg-transparent text-white border-light">
                                            <i class="fas fa-clock text-muted me-2"></i> Get access to members-only content
                                        </li>
                                        <li class="list-group-item bg-transparent text-white border-light">
                                            <i class="fas fa-clock text-muted me-2"></i> Participate in clan events
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-dark mb-4">
                                <div class="card-body">
                                    <h4 class="text-accent"><i class="fas fa-question-circle me-2"></i> Why Verification?</h4>
                                    <p class="text-white">Verification helps us:</p>
                                    <ul class="text-white">
                                        <li>Confirm you're a real person</li>
                                        <li>Ensure you're 18+</li>
                                        <li>Verify your Discord identity</li>
                                        <li>Protect our community from spam and bots</li>
                                        <li>Maintain a high-quality member base</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                            <i class="fas fa-user-edit me-2"></i> Complete Your Profile
                        </a>
                        <a href="https://discord.gg/odyssey" class="btn btn-accent" target="_blank">
                            <i class="fab fa-discord me-2"></i> Join Discord Server
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection