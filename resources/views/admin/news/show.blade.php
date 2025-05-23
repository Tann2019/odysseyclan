@extends('Layouts.app')

@section('title', $news->title)

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="m-0">News Article</h1>
            <p class="text-muted">{{ $news->title }}</p>
        </div>
        <div>
            <a href="{{ route('admin.news.index') }}" class="btn btn-outline-primary me-2">
                <i class="fas fa-arrow-left"></i> Back to News
            </a>
            <a href="{{ route('admin.news.edit', $news) }}" class="btn btn-accent">
                <i class="fas fa-edit me-2"></i> Edit Article
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card bg-dark-gray">
                <div class="card-header bg-dark-gray">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $news->title }}</h5>
                        @if($news->is_published)
                            <span class="badge bg-success">Published</span>
                        @else
                            <span class="badge bg-warning text-dark">Draft</span>
                        @endif
                    </div>
                </div>
                @if($news->image_url)
                    <img src="{{ $news->image_url }}" class="card-img-top" alt="{{ $news->title }}" style="max-height: 400px; object-fit: cover;">
                @endif
                <div class="card-body">
                    @if($news->excerpt)
                        <div class="mb-3">
                            <h6 class="text-accent">Excerpt</h6>
                            <p class="text-muted fst-italic">{{ $news->excerpt }}</p>
                        </div>
                        <hr class="my-4">
                    @endif
                    
                    <div class="content-display">
                        {!! nl2br(e($news->content)) !!}
                    </div>
                </div>
                <div class="card-footer bg-dark-gray">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-user me-1"></i> {{ $news->author->name }}
                        </small>
                        <small class="text-muted">
                            @if($news->published_at)
                                <i class="fas fa-calendar me-1"></i> Published {{ $news->published_at->format('F d, Y \a\t H:i') }}
                            @else
                                <i class="fas fa-clock me-1"></i> Created {{ $news->created_at->format('F d, Y \a\t H:i') }}
                            @endif
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card bg-dark-gray">
                <div class="card-header bg-dark-gray">
                    <h6 class="mb-0">Article Details</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Status:</strong>
                        @if($news->is_published)
                            <span class="badge bg-success ms-2">Published</span>
                        @else
                            <span class="badge bg-warning text-dark ms-2">Draft</span>
                        @endif
                    </div>
                    
                    <div class="mb-3">
                        <strong>Author:</strong>
                        <div class="mt-1">{{ $news->author->name }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Created:</strong>
                        <div class="mt-1">{{ $news->created_at->format('F d, Y \a\t H:i') }}</div>
                    </div>
                    
                    @if($news->published_at)
                        <div class="mb-3">
                            <strong>Published:</strong>
                            <div class="mt-1">{{ $news->published_at->format('F d, Y \a\t H:i') }}</div>
                        </div>
                    @endif
                    
                    <div class="mb-3">
                        <strong>Last Updated:</strong>
                        <div class="mt-1">{{ $news->updated_at->format('F d, Y \a\t H:i') }}</div>
                    </div>
                    
                    @if($news->image_url)
                        <div class="mb-3">
                            <strong>Featured Image:</strong>
                            <div class="mt-1">
                                <a href="{{ $news->image_url }}" target="_blank" class="text-break">
                                    {{ Str::limit($news->image_url, 40) }}
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card bg-dark-gray mt-4">
                <div class="card-header bg-dark-gray">
                    <h6 class="mb-0">Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.news.edit', $news) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i> Edit Article
                        </a>
                        
                        @if($news->is_published)
                            <button type="button" class="btn btn-outline-secondary" disabled>
                                <i class="fas fa-eye me-2"></i> Published on Site
                            </button>
                        @else
                            <button type="button" class="btn btn-outline-warning" disabled>
                                <i class="fas fa-eye-slash me-2"></i> Not Published
                            </button>
                        @endif
                        
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash me-2"></i> Delete Article
                        </button>
                    </div>
                </div>
            </div>
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