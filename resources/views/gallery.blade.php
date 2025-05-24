@extends('Layouts.app')

@section('title', 'Gallery')

@section('extra-css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
<style>
    .gallery-category {
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
        height: 250px;
        border-radius: 10px;
        cursor: pointer;
    }
    
    .gallery-category img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .gallery-category:hover img {
        transform: scale(1.1);
    }
    
    .gallery-category .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0.3));
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 1.5rem;
    }
    
    .gallery-item {
        overflow: hidden;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        position: relative;
        transition: all 0.3s ease;
    }
    
    .gallery-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    }
    
    .gallery-item img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .gallery-item:hover img {
        transform: scale(1.1);
    }
    
    .gallery-item .overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 1rem;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        transform: translateY(100%);
        transition: transform 0.3s ease;
    }
    
    .gallery-item:hover .overlay {
        transform: translateY(0);
    }
    
    .gallery-filter {
        justify-content: center;
        margin-bottom: 2rem;
    }
    
    .gallery-filter .btn {
        margin: 0 0.25rem;
        padding: 0.5rem 1rem;
        border-radius: 30px;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 1px;
    }
    
    .gallery-filter .btn.active {
        background-color: var(--accent);
        color: var(--dark);
        border-color: var(--accent);
    }
</style>
@endsection

@section('content')
<div class="container py-5 my-5">
    <h1 class="section-title" data-aos="fade-up">MEDIA GALLERY</h1>
    
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
            <p class="lead">Explore photos and videos from our tournaments, training sessions, and community events.</p>
        </div>
    </div>
    
    <!-- Gallery Categories -->
    <div class="row mb-5">
        @foreach($galleries as $gallery)
        <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
            <div class="gallery-category">
                <img src="{{ $gallery['cover'] }}" alt="{{ $gallery['title'] }}">
                <div class="overlay">
                    <h4 class="text-white mb-1">{{ $gallery['title'] }}</h4>
                    <span class="badge bg-accent text-dark mb-2">{{ $gallery['count'] }} items</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <!-- Gallery Filter -->
    <div class="mb-4 text-center" data-aos="fade-up">
        <div class="btn-group gallery-filter">
            <button class="btn btn-outline active" data-filter="all">All</button>
            <button class="btn btn-outline" data-filter="Tournament">Tournaments</button>
            <button class="btn btn-outline" data-filter="Training">Training</button>
            <button class="btn btn-outline" data-filter="Community">Community</button>
            <button class="btn btn-outline" data-filter="Team Building">Team Building</button>
        </div>
    </div>
    
    <!-- Gallery Grid -->
    <div class="row gallery-container" data-aos="fade-up">
        @foreach($images as $image)
        <div class="col-lg-3 col-md-4 col-sm-6 gallery-item" data-category="{{ $image['category'] }}">
            <a href="{{ $image['url'] }}" data-lightbox="odyssey-gallery" data-title="{{ $image['title'] }}">
                <img src="{{ $image['thumbnail'] }}" alt="{{ $image['title'] }}" class="img-fluid">
                <div class="overlay">
                    <h5 class="text-white mb-1">{{ $image['title'] }}</h5>
                    <div class="d-flex justify-content-between">
                        <span class="badge bg-accent text-dark">{{ $image['category'] }}</span>
                        <small class="text-white"><i class="far fa-calendar-alt me-1"></i>{{ $image['date'] }}</small>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    
    <!-- Submit Your Photos -->
    <div class="row mt-5">
        <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
            <div class="card bg-dark-gray border-accent p-4">
                <h3 class="text-accent mb-3">Share Your Moments</h3>
                <p class="text-white">Have amazing screenshots or clips from clan events? Share them with the community!</p>
                <div class="d-flex justify-content-center mt-3">
                    <a href="https://discord.gg/odyssey" class="btn btn-accent me-2">
                        <i class="fab fa-discord me-2"></i> Submit on Discord
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@section('extra-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize lightbox
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'showImageNumberLabel': false,
            'albumLabel': ''
        });
        
        // Gallery filtering
        const filterButtons = document.querySelectorAll('.gallery-filter .btn');
        const galleryItems = document.querySelectorAll('.gallery-item');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Get filter value
                const filterValue = this.getAttribute('data-filter');
                
                // Filter gallery items
                galleryItems.forEach(item => {
                    if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
        
        // For demonstration - replace broken image links with placeholders
        document.querySelectorAll('.gallery-item img, .gallery-category img').forEach(img => {
            img.onerror = function() {
                this.src = 'https://via.placeholder.com/400x300/333333/FFD700?text=Odyssey+Image';
                
                // If this is a lightbox link, update the href as well
                const link = this.closest('a');
                if (link && link.hasAttribute('data-lightbox')) {
                    link.href = 'https://via.placeholder.com/1200x800/333333/FFD700?text=Odyssey+Image';
                }
            };
        });
    });
</script>
@endsection

@endsection