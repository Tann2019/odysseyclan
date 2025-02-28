@extends('Layouts.app')

@section('title', 'Register')

@section('content')
<div class="container py-5 my-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1 class="section-title" data-aos="fade-up">JOIN THE ODYSSEY</h1>
            
            <div class="card bg-dark-gray border-accent" data-aos="fade-up">
                <div class="card-header bg-dark-gray border-bottom border-accent">
                    <h4 class="text-accent mb-0">Create Your Account</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control bg-mid-gray text-white @error('name') is-invalid @enderror" 
                                id="name" name="name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control bg-mid-gray text-white @error('email') is-invalid @enderror" 
                                id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Discord ID -->
                        <div class="mb-3">
                            <label for="discord_id" class="form-label">Discord ID</label>
                            <div class="input-group">
                                <input type="text" class="form-control bg-mid-gray text-white @error('discord_id') is-invalid @enderror" 
                                    id="discord_id" name="discord_id" value="{{ old('discord_id') }}" required
                                    placeholder="e.g. username#1234">
                                <span class="input-group-text bg-dark-gray text-light border-0">
                                    <i class="fab fa-discord"></i>
                                </span>
                            </div>
                            @error('discord_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-muted">
                                This will be used to verify your identity on our Discord server.
                            </div>
                        </div>
                        
                        <!-- Username -->
                        <div class="mb-3">
                            <label for="username" class="form-label">Gaming Username</label>
                            <input type="text" class="form-control bg-mid-gray text-white @error('username') is-invalid @enderror" 
                                id="username" name="username" value="{{ old('username') }}" required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-muted">
                                This is the name that will be displayed on the members list.
                            </div>
                        </div>
                        
                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control bg-mid-gray text-white @error('password') is-invalid @enderror" 
                                id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control bg-mid-gray text-white" 
                                id="password_confirmation" name="password_confirmation" required>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-accent btn-lg">
                                <i class="fas fa-user-plus me-2"></i>Register
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer bg-dark-gray border-top border-accent">
                    <div class="text-center">
                        <p class="mb-0">Already have an account? <a href="{{ route('login') }}" class="text-accent">Login here</a></p>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 text-center" data-aos="fade-up">
                <p class="text-muted">
                    By registering, you agree to our Terms of Service and Privacy Policy.
                </p>
                <p>
                    <a href="{{ route('join') }}" class="text-accent">
                        <i class="fas fa-arrow-left me-1"></i> Back to Join Us page
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection