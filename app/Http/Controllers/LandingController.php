<?php

namespace App\Http\Controllers;

use App\Models\Webinar;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Redirect to dashboard if user is authenticated
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }

        // Get all active webinars ordered by date
        $webinars = Webinar::where('date', '>=', now()->format('Y-m-d'))
                          ->orderBy('date', 'asc')
                          ->orderBy('time', 'asc')
                          ->get()
                          ->map(function($webinar) {
                              $webinar->description = Str::limit($webinar->description, 150);
                              return $webinar;
                          });

        return view('landing', compact('webinars'));
    }
} 