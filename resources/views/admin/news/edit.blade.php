@extends('Layouts.app')

@section('title', 'Edit News Article')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="m-0">Edit News Article</h1>
            <p class="text-muted">Update: {{ $news->title }}</p>
        </div>
        <div>
            <a href="{{ route('admin.news.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Back to News
            </a>
        </div>
    </div>

    <div class="card bg-dark-gray">
        <div class="card-header bg-dark-gray">
            <h5 class="mb-0">Article Details</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                id="title" name="title" value="{{ old('title', $news->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="excerpt" class="form-label">Excerpt</label>
                            <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                id="excerpt" name="excerpt" rows="3" placeholder="Short summary of the article">{{ old('excerpt', $news->excerpt) }}</textarea>
                            @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Brief description that appears on the homepage (max 500 characters)</div>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                id="content" name="content" rows="10" required>{{ old('content', $news->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image" class="form-label">Featured Image</label>
                            <div class="mb-3">
                                @if($news->image_url)
                                    <div class="current-image mb-3">
                                        <img src="{{ $news->image_url }}" alt="Current featured image" class="img-thumbnail" style="max-width: 200px; max-height: 150px; object-fit: cover;">
                                        <p class="small text-muted mt-1">Current featured image</p>
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                    id="image" name="image" accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Upload a new featured image (JPG, PNG, GIF, WebP - max 5MB). Leave empty to keep current image.</div>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image" value="1">
                                <label class="form-check-label" for="remove_image">
                                    Remove current featured image
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_published" 
                                    name="is_published" value="1" {{ old('is_published', $news->is_published) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_published">
                                    Published
                                </label>
                            </div>
                            <div class="form-text">Control whether this article is visible on the website</div>
                        </div>

                        <div class="card bg-dark border-secondary">
                            <div class="card-header">
                                <h6 class="mb-0">Article Info</h6>
                            </div>
                            <div class="card-body">
                                <small class="text-muted">
                                    <strong>Author:</strong> {{ $news->author->name }}<br>
                                    <strong>Created:</strong> {{ $news->created_at->format('M d, Y H:i') }}<br>
                                    @if($news->published_at)
                                        <strong>Published:</strong> {{ $news->published_at->format('M d, Y H:i') }}<br>
                                    @endif
                                    <strong>Last Updated:</strong> {{ $news->updated_at->format('M d, Y H:i') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="fas fa-trash me-2"></i> Delete Article
                    </button>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-accent">
                            <i class="fas fa-save me-2"></i> Update Article
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
                <h5 class="modal-title">Delete News Article</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong>{{ $news->title }}</strong>?</p>
                @if($news->image_url)
                    <div class="text-center mb-3">
                        <img src="{{ $news->image_url }}" alt="{{ $news->title }}" 
                             class="img-fluid rounded" style="max-height: 150px;">
                    </div>
                @endif
                <p class="text-muted small">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.news.destroy', $news) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Article</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection