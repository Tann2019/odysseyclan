@extends('Layouts.app')

@section('title', 'Login')

@section('content')
<div class="container py-5 my-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1 class="section-title" data-aos="fade-up">MEMBER LOGIN</h1>
            
            <div class="card bg-dark-gray border-accent" data-aos="fade-up">
                <div class="card-header bg-dark-gray border-bottom border-accent">
                    <h4 class="text-accent mb-0">Access Your Account</h4>
                </div>
                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success mb-4">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control bg-mid-gray text-white @error('email') is-invalid @enderror" 
                                id="email" name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                        
                        <!-- Remember Me -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-accent btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer bg-dark-gray border-top border-accent">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="#" class="text-accent">Forgot your password?</a>
                        <a href="{{ route('register') }}" class="text-accent">Create an account</a>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 text-center" data-aos="fade-up">
                <p>
                    <a href="{{ route('home') }}" class="text-accent">
                        <i class="fas fa-arrow-left me-1"></i> Back to Home
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection