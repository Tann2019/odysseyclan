<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
    public function index()
    {
        $images = GalleryImage::with('uploader')
            ->ordered()
            ->paginate(20);

        $categories = ['general', 'tournaments', 'events', 'members', 'training'];

        return view('admin.gallery.index', compact('images', 'categories'));
    }

    public function create()
    {
        $categories = ['general', 'tournaments', 'events', 'members', 'training'];
        return view('admin.gallery.create', compact('categories'));
    }

    public function store(Request $request, ImageUploadService $imageUploadService)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'category' => 'required|string|in:general,tournaments,events,members,training',
            'sort_order' => 'nullable|integer',
            'is_featured' => 'boolean',
        ]);

        // Upload image
        $imagePath = $imageUploadService->uploadGalleryImage($request->file('image'));
        if (!$imagePath) {
            return back()->withErrors(['image' => 'Failed to upload image.'])->withInput();
        }

        $validated['uploaded_by'] = Auth::id();
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['image_url'] = $imagePath;
        
        // Remove the 'image' key as it's not needed in the database
        unset($validated['image']);

        GalleryImage::create($validated);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Image added to gallery successfully.');
    }

    public function show(GalleryImage $image)
    {
        return view('admin.gallery.show', compact('image'));
    }

    public function edit(GalleryImage $image)
    {
        $categories = ['general', 'tournaments', 'events', 'members', 'training'];
        return view('admin.gallery.edit', compact('image', 'categories'));
    }

    public function update(Request $request, GalleryImage $image, ImageUploadService $imageUploadService)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'category' => 'required|string|in:general,tournaments,events,members,training',
            'sort_order' => 'nullable|integer',
            'is_featured' => 'boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($image->image_url) {
                $imageUploadService->deleteImage($image->image_url);
            }
            
            // Upload new image
            $imagePath = $imageUploadService->uploadGalleryImage($request->file('image'));
            if (!$imagePath) {
                return back()->withErrors(['image' => 'Failed to upload image.'])->withInput();
            }
            
            $validated['image_url'] = $imagePath;
        }

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        
        // Remove the 'image' key as it's not needed in the database
        unset($validated['image']);

        $image->update($validated);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gallery image updated successfully.');
    }

    public function destroy(GalleryImage $image)
    {
        $image->delete();

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gallery image deleted successfully.');
    }
}