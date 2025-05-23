@extends('Layouts.app')

@section('title', 'Edit Gallery Image')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="m-0">Edit Gallery Image</h1>
            <p class="text-muted">Update: {{ $image->title }}</p>
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
            <form action="{{ route('admin.gallery.update', $image) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">Image Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                id="title" name="title" value="{{ old('title', $image->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image_url" class="form-label">Image URL <span class="text-danger">*</span></label>
                            <input type="url" class="form-control @error('image_url') is-invalid @enderror" 
                                id="image_url" name="image_url" value="{{ old('image_url', $image->image_url) }}" 
                                placeholder="https://example.com/image.jpg" required>
                            @error('image_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Direct URL to the image file</div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                id="description" name="description" rows="4" placeholder="Optional description of the image">{{ old('description', $image->description) }}</textarea>
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
                                            <option value="{{ $category }}" {{ old('category', $image->category) == $category ? 'selected' : '' }}>
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
                                        id="sort_order" name="sort_order" value="{{ old('sort_order', $image->sort_order) }}">
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
                                    name="is_featured" value="1" {{ old('is_featured', $image->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    Featured Image
                                </label>
                            </div>
                            <div class="form-text">Featured images are highlighted in the gallery</div>
                        </div>

                        <div class="card bg-dark border-secondary">
                            <div class="card-header">
                                <h6 class="mb-0">Current Image</h6>
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <img src="{{ $image->image_url }}" alt="{{ $image->title }}" 
                                         class="img-fluid rounded" style="max-height: 200px;">
                                </div>
                            </div>
                        </div>

                        <div class="card bg-dark border-secondary mt-3">
                            <div class="card-header">
                                <h6 class="mb-0">Image Info</h6>
                            </div>
                            <div class="card-body">
                                <small class="text-muted">
                                    <strong>Uploaded by:</strong> {{ $image->uploader->name }}<br>
                                    <strong>Created:</strong> {{ $image->created_at->format('M d, Y H:i') }}<br>
                                    <strong>Last Updated:</strong> {{ $image->updated_at->format('M d, Y H:i') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="fas fa-trash me-2"></i> Delete Image
                    </button>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-accent">
                            <i class="fas fa-save me-2"></i> Update Image
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title">Delete Gallery Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong>{{ $image->title }}</strong>?</p>
                <div class="text-center mb-3">
                    <img src="{{ $image->image_url }}" alt="{{ $image->title }}" 
                         class="img-fluid rounded" style="max-height: 150px;">
                </div>
                <p class="text-muted small">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.gallery.destroy', $image) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Image</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection