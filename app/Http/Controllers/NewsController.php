<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with('author')
            ->latest()
            ->paginate(15);

        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request, ImageUploadService $imageUploadService)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'is_published' => 'boolean',
        ]);

        // Handle featured image upload
        if ($request->hasFile('image')) {
            $imagePath = $imageUploadService->uploadNewsImage($request->file('image'));
            if (!$imagePath) {
                return back()->withErrors(['image' => 'Failed to upload image.'])->withInput();
            }
            $validated['image_url'] = $imagePath;
        }

        $validated['author_id'] = Auth::id();
        
        if ($validated['is_published'] ?? false) {
            $validated['published_at'] = now();
        }

        // Remove the 'image' key as it's not needed in the database
        unset($validated['image']);

        News::create($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'News article created successfully.');
    }

    public function show(News $news)
    {
        return view('admin.news.show', compact('news'));
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news, ImageUploadService $imageUploadService)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'remove_image' => 'nullable|boolean',
            'is_published' => 'boolean',
        ]);

        // Handle featured image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($news->image_url) {
                $imageUploadService->deleteImage($news->image_url);
            }
            
            // Upload new image
            $imagePath = $imageUploadService->uploadNewsImage($request->file('image'));
            if (!$imagePath) {
                return back()->withErrors(['image' => 'Failed to upload image.'])->withInput();
            }
            
            $validated['image_url'] = $imagePath;
        } elseif ($request->boolean('remove_image')) {
            // Remove current image
            if ($news->image_url) {
                $imageUploadService->deleteImage($news->image_url);
                $validated['image_url'] = null;
            }
        }

        if (($validated['is_published'] ?? false) && !$news->published_at) {
            $validated['published_at'] = now();
        } elseif (!($validated['is_published'] ?? false)) {
            $validated['published_at'] = null;
        }

        // Remove upload-specific fields from validation data
        unset($validated['image'], $validated['remove_image']);

        $news->update($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'News article updated successfully.');
    }

    public function destroy(News $news)
    {
        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'News article deleted successfully.');
    }
}