<?php

// app/Http/Controllers/PageController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    // About Us Page
    public function about()
    {
        return view('pages.about');
    }

    // Contact Us Page
    public function contact()
    {
        return view('pages.contact');
    }

    // Privacy Policy Page
    public function privacy()
    {
        return view('pages.privacy');
    }

    // Terms of Service Page
    public function terms()
    {
        return view('pages.terms');
    }
}
