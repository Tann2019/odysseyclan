@extends('Layouts.app')

@section('title', 'Verification Rejected')

@section('content')
<div class="container py-5 my-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card bg-dark-gray border-danger" data-aos="fade-up">
                <div class="card-header bg-danger text-white">
                    <h3 class="mb-0"><i class="fas fa-exclamation-circle me-2"></i> Verification Rejected</h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="display-1 text-danger">
                            <i class="fas fa-user-times"></i>
                        </div>
                        <h2 class="mt-4 text-white">Your Verification Request Was Declined</h2>
                        <p class="lead text-white">Unfortunately, your membership verification has not been approved.</p>
                    </div>
                    
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading"><i class="fas fa-info-circle me-2"></i> Reason for Rejection</h4>
                        <p>{{ $member->verification_notes ?? 'No specific reason provided by the administrator.' }}</p>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card bg-dark mb-4">
                                <div class="card-body">
                                    <h4 class="text-accent"><i class="fas fa-redo-alt me-2"></i> What Now?</h4>
                                    <p class="text-white">Here are your options:</p>
                                    <ul class="text-white">
                                        <li>Update your profile with complete and accurate information</li>
                                        <li>Join our Discord server and introduce yourself</li>
                                        <li>Contact an admin to discuss your application</li>
                                        <li>Resubmit your verification request after addressing the issues</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-dark mb-4">
                                <div class="card-body">
                                    <h4 class="text-accent"><i class="fas fa-shield-alt me-2"></i> Common Rejection Reasons</h4>
                                    <ul class="text-white">
                                        <li>Incomplete profile information</li>
                                        <li>Discord ID could not be verified</li>
                                        <li>Age verification requirements not met</li>
                                        <li>Suspicious account activity</li>
                                        <li>Previous community guideline violations</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-warning mt-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>IMPORTANT:</strong> If you believe this rejection was made in error, please contact an administrator on our Discord server for assistance.
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                            <i class="fas fa-user-edit me-2"></i> Update Your Profile
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