<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Job;
use App\Models\Application;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::where('recruiter_id', Auth::id())->get();
        return view('recruiter.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('recruiter.jobs.create');
    }

    public function store(Request $request)  // Only one argument here
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
        ]);

        Job::create([
            'recruiter_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'status' => 'open'
        ]);

        return redirect()->route('recruiter.jobs.index')->with('success', 'Job created successfully.');
    }

    public function availableJobs()
    {
        $jobs = Job::where('status', 'open')->get();
        $applications = Auth::user()->applications()->pluck('job_id')->toArray();
        return view('applicant.jobs.index', compact('jobs', 'applications'));
    }

    public function close(Job $job)
    {
        if ($job->recruiter_id !== Auth::id()) {
            return redirect()->route('recruiter.jobs.index')->with('error', 'Unauthorized access.');
        }

        $job->status = 'closed';
        $job->save();

        return redirect()->route('recruiter.jobs.index')->with('success', 'Job application closed successfully.');
    }
}