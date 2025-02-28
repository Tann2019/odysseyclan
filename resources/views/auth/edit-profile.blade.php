@extends('Layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container py-5 my-5">
    <h1 class="section-title" data-aos="fade-up">EDIT PROFILE</h1>
    
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card bg-dark-gray border-accent" data-aos="fade-up">
                <div class="card-header bg-primary text-white border-bottom border-accent">
                    <h4 class="mb-0">Update Your Information</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-4">
                            <!-- Current Avatar -->
                            <div class="col-md-4 text-center mb-4 mb-md-0">
                                <div class="position-relative mx-auto" style="width: 150px; height: 150px;">
                                    <img src="{{ $member->avatar_url ?? 'https://via.placeholder.com/150x150/333/FFD700?text='.substr($user->name, 0, 1) }}" 
                                        alt="{{ $user->name }}" class="rounded-circle border border-accent" 
                                        style="width: 150px; height: 150px; object-fit: cover;" id="avatar-preview">
                                </div>
                                <div class="mt-3">
                                    <span class="badge bg-primary px-3 py-2 rounded-pill text-uppercase">
                                        {{ $member->rank }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Personal Info -->
                            <div class="col-md-8">
                                <!-- Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control bg-mid-gray text-white @error('name') is-invalid @enderror" 
                                        id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control bg-mid-gray text-white @error('email') is-invalid @enderror" 
                                        id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Discord ID -->
                                <div class="mb-3">
                                    <label for="discord_id" class="form-label">Discord ID</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-mid-gray text-white @error('discord_id') is-invalid @enderror" 
                                            id="discord_id" name="discord_id" value="{{ old('discord_id', $member->discord_id) }}" required>
                                        <span class="input-group-text bg-dark-gray text-light border-0">
                                            <i class="fab fa-discord"></i>
                                        </span>
                                    </div>
                                    @error('discord_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Username -->
                                <div class="mb-3">
                                    <label for="username" class="form-label">Gaming Username</label>
                                    <input type="text" class="form-control bg-mid-gray text-white @error('username') is-invalid @enderror" 
                                        id="username" name="username" value="{{ old('username', $member->username) }}" required>
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <hr class="border-accent my-4">
                        
                        <!-- Avatar URL -->
                        <div class="mb-3">
                            <label for="avatar_url" class="form-label">Avatar URL</label>
                            <input type="url" class="form-control bg-mid-gray text-white @error('avatar_url') is-invalid @enderror" 
                                id="avatar_url" name="avatar_url" value="{{ old('avatar_url', $member->avatar_url) }}" 
                                placeholder="https://example.com/your-avatar.jpg">
                            @error('avatar_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-muted">
                                Enter a URL to an image that will be used as your profile picture.
                            </div>
                        </div>
                        
                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Biography</label>
                            <textarea class="form-control bg-mid-gray text-white @error('description') is-invalid @enderror" 
                                id="description" name="description" rows="4" 
                                placeholder="Tell other members about yourself...">{{ old('description', $member->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <hr class="border-accent my-4">
                        
                        <h5 class="text-accent mb-3">Change Password (Optional)</h5>
                        
                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control bg-mid-gray text-white @error('password') is-invalid @enderror" 
                                id="password" name="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-muted">
                                Leave blank if you don't want to change your password.
                            </div>
                        </div>
                        
                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control bg-mid-gray text-white" 
                                id="password_confirmation" name="password_confirmation">
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('profile.dashboard') }}" class="btn btn-outline">
                                <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                            </a>
                            <button type="submit" class="btn btn-accent">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('extra-js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Preview avatar URL when entered
        const avatarUrl = document.getElementById('avatar_url');
        const avatarPreview = document.getElementById('avatar-preview');
        
        if (avatarUrl && avatarPreview) {
            avatarUrl.addEventListener('input', function() {
                const url = this.value.trim();
                if (url) {
                    // Save original src in case the new URL fails to load
                    const originalSrc = avatarPreview.src;
                    
                    // Try to load the new image
                    avatarPreview.onerror = function() {
                        this.src = originalSrc; // Restore original on error
                        this.onerror = null;
                    };
                    
                    avatarPreview.src = url;
                }
            });
        }
    });
</script>
@endsection

@endsection