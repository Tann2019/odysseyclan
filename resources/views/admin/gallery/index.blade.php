@extends('Layouts.app')

@section('title', 'Manage Gallery')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="m-0">Manage Gallery</h1>
            <p class="text-muted">Upload and manage images for the clan gallery</p>
        </div>
        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary me-2">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
            <a href="{{ route('admin.gallery.create') }}" class="btn btn-accent">
                <i class="fas fa-plus me-2"></i> Add Image
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card bg-dark-gray">
        <div class="card-header bg-dark-gray">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Gallery Images</h5>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" style="width: auto;" onchange="filterByCategory(this.value)">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}">{{ ucfirst($category) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($images->count() > 0)
                <div class="row g-4">
                    @foreach($images as $image)
                        <div class="col-md-6 col-lg-4 col-xl-3" data-category="{{ $image->category }}">
                            <div class="card bg-dark h-100">
                                <div class="position-relative">
                                    <img src="{{ $image->image_url }}" class="card-img-top" alt="{{ $image->title }}" 
                                         style="height: 200px; object-fit: cover;">
                                    @if($image->is_featured)
                                        <span class="position-absolute top-0 end-0 m-2">
                                            <i class="fas fa-star text-warning" title="Featured"></i>
                                        </span>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title">{{ $image->title }}</h6>
                                    @if($image->description)
                                        <p class="card-text small text-muted">{{ Str::limit($image->description, 80) }}</p>
                                    @endif
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-secondary text-uppercase">{{ $image->category }}</span>
                                        <small class="text-muted">{{ $image->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                <div class="card-footer bg-dark-gray border-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">{{ $image->uploader->name }}</small>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.gallery.edit', $image) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger btn-sm delete-btn"
                                                    data-image-id="{{ $image->id }}"
                                                    data-image-title="{{ $image->title }}"
                                                    data-image-url="{{ $image->image_url }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-images fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No images in gallery</h5>
                    <p class="text-muted">Start building your gallery by adding some images.</p>
                    <a href="{{ route('admin.gallery.create') }}" class="btn btn-accent">
                        <i class="fas fa-plus me-2"></i> Add First Image
                    </a>
                </div>
            @endif
        </div>
        @if($images->hasPages())
            <div class="card-footer bg-dark-gray">
                <div class="d-flex justify-content-center">
                    {{ $images->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title">Delete Image</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong id="delete-image-title"></strong>?</p>
                <div class="text-center mb-3">
                    <img id="delete-image-preview" src="" alt="" class="img-fluid rounded" style="max-height: 150px;">
                </div>
                <p class="text-muted small">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Image</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function filterByCategory(category) {
    const cards = document.querySelectorAll('[data-category]');
    cards.forEach(card => {
        if (category === '' || card.dataset.category === category) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const imageId = this.dataset.imageId;
            const imageTitle = this.dataset.imageTitle;
            const imageUrl = this.dataset.imageUrl;
            
            document.getElementById('delete-image-title').textContent = imageTitle;
            document.getElementById('delete-image-preview').src = imageUrl;
            document.getElementById('delete-image-preview').alt = imageTitle;
            document.getElementById('deleteForm').action = `/admin/gallery/${imageId}`;
            
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        });
    });
});
</script>
@endsection