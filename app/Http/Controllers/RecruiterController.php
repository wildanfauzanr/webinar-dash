<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Job;
use App\Models\Event;
use App\Models\Webinar;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RecruiterController extends Controller
{
    public function index()
    {
        $recruiterId = Auth::id();
        $user = Auth::user();
        
        $jobsCount = Job::where('recruiter_id', $recruiterId)->count();
        $eventsCount = Event::where('recruiter_id', $recruiterId)->count();
        $webinarsCount = Webinar::where('recruiter_id', $recruiterId)->count();

        $recentJobs = Job::where('recruiter_id', $recruiterId)->latest()->take(3)->get();
        $recentEvents = Event::where('recruiter_id', $recruiterId)->latest()->take(3)->get();
        $recentWebinars = Webinar::where('recruiter_id', $recruiterId)->latest()->take(3)->get();

        return view('recruiter.dashboard', compact('user', 'jobsCount', 'eventsCount', 'webinarsCount', 'recentJobs', 'recentEvents', 'recentWebinars'));
    }

    public function showRegistrationForm()
    {
        return view('recruiter.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'organization' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();
        
        // Verifikasi password
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password is incorrect']);
        }

        // Update user menjadi recruiter
        $user->update([
            'is_recruiter' => true,
            'company_name' => $request->organization,
            'role' => 'recruiter'
        ]);

        return redirect()->route('my.webinars')
            ->with('success', 'You have successfully registered as a recruiter!');
    }
}
