<?php

namespace App\Http\Controllers;

use App\Enums\Visibility;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::published()
            ->paginate(9);
            
        return view('pages.blog.index', compact('posts'));
    }
    
    public function show($slug)
    {
        $blog = BlogPost::where('slug', $slug)
            ->where('status', Visibility::PUBLISHED)
            ->firstOrFail();
            
        return view('pages.blog.show', compact('blog'));
    }
} 