<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image_url' => 'required|url',
            'category' => 'required|string|in:general,tournaments,events,members,training',
            'sort_order' => 'nullable|integer',
            'is_featured' => 'boolean',
        ]);

        $validated['uploaded_by'] = Auth::id();
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

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

    public function update(Request $request, GalleryImage $image)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image_url' => 'required|url',
            'category' => 'required|string|in:general,tournaments,events,members,training',
            'sort_order' => 'nullable|integer',
            'is_featured' => 'boolean',
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;

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