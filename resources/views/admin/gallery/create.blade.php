@extends('Layouts.app')

@section('title', 'Add Gallery Image')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="m-0">Add Gallery Image</h1>
            <p class="text-muted">Upload a new image to the clan gallery</p>
        </div>
        <div>
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Back to Gallery
            </a>
        </div>
    </div>

    <div class="card bg-dark-gray">
        <div class="card-header bg-dark-gray">
            <h5 class="mb-0">Image Details</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">Image Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image File <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                id="image" name="image" accept="image/*" required>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Upload an image file (JPG, PNG, GIF, WebP - max 5MB)</div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                id="description" name="description" rows="4" placeholder="Optional description of the image">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                                    <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                        <option value="">Select category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>
                                                {{ ucfirst($category) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sort_order" class="form-label">Sort Order</label>
                                    <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                        id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}">
                                    @error('sort_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Lower numbers appear first (0 = default)</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_featured" 
                                    name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    Featured Image
                                </label>
                            </div>
                            <div class="form-text">Featured images are highlighted in the gallery</div>
                        </div>

                        <div class="card bg-dark border-secondary">
                            <div class="card-header">
                                <h6 class="mb-0">Image Preview</h6>
                            </div>
                            <div class="card-body">
                                <div id="imagePreview" class="text-center text-muted">
                                    <i class="fas fa-image fa-3x mb-2"></i>
                                    <p>Enter an image URL to see preview</p>
                                </div>
                            </div>
                        </div>

                        <div class="card bg-dark border-secondary mt-3">
                            <div class="card-header">
                                <h6 class="mb-0">Upload Info</h6>
                            </div>
                            <div class="card-body">
                                <small class="text-muted">
                                    <strong>Uploaded by:</strong> {{ Auth::user()->name }}<br>
                                    <strong>Date:</strong> {{ now()->format('M d, Y H:i') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-accent">
                        <i class="fas fa-save me-2"></i> Add to Gallery
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('image_url').addEventListener('input', function() {
    const url = this.value;
    const preview = document.getElementById('imagePreview');
    
    if (url && url.match(/\.(jpeg|jpg|gif|png|webp)$/i)) {
        preview.innerHTML = `<img src="${url}" class="img-fluid rounded" style="max-height: 200px;" onerror="showPreviewError()">`;
    } else if (url) {
        preview.innerHTML = `<div class="text-warning"><i class="fas fa-exclamation-triangle fa-2x mb-2"></i><p>Invalid image URL</p></div>`;
    } else {
        preview.innerHTML = `<i class="fas fa-image fa-3x mb-2"></i><p>Enter an image URL to see preview</p>`;
    }
});

function showPreviewError() {
    document.getElementById('imagePreview').innerHTML = `<div class="text-danger"><i class="fas fa-times-circle fa-2x mb-2"></i><p>Failed to load image</p></div>`;
}
</script>
@endsection