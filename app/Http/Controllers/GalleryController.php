<?php

namespace App\Http\Controllers;

use App\Enums\Visibility;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::where('status', Visibility::PUBLISHED)
            ->with(['media' => function ($query) {
            $query->where('collection_name', 'gallery-images')
                  ->orderBy('id') // Using 'id' instead of 'order'
                  ->limit(1);
            }])
            ->withCount('media')
            ->orderBy('order')
            ->paginate(12);

    
            
        return view('pages.gallery.index', compact('galleries'));
    }
    
    public function show($slug)
    {
        $gallery = Gallery::where('slug', $slug)
            ->where('status', Visibility::PUBLISHED)
            ->firstOrFail();
            
        $media = $gallery->getMedia('gallery-images');
        
        return view('pages.gallery.show', compact('gallery', 'media'));
    }
}
