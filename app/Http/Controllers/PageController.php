<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }
    
    public function settings()
    {
        return view('pages.settings');
    }
}
