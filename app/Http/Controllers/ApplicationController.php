<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;


class ApplicationController extends Controller
{
    public function index(Job $job)
    {
        $applications = Application::where('job_id', $job->id)->get();
        return view('recruiter.jobs.applications', compact('job', 'applications'));
    }

    public function store(Request $request, $jobId)
    {
        $user = Auth::user();

        Application::create([
            'user_id' => $user->id,
            'job_id' => $jobId,
            'status' => 'pending'
        ]);

        return redirect()->route('applicant.jobs.index')->with('success', 'You have successfully applied for the job.');
    }

    public function updateStatus(Application $application, Request $request)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        $application->update([
            'status' => $request->status,
        ]);

        return redirect()->route('recruiter.jobs.applications', $application->job_id)
                         ->with('success', 'Application status updated.');
    }

    public function activeApplications()
    {
        $applications = Application::where('applicant_id', Auth::id())
            ->whereIn('status', ['accepted', 'rejected'])
            ->get();
    
        return view('applicant.applications.index', compact('applications'));
    }

    public function scheduleInterview(Application $application)
    {
        return view('applicant.interviews.schedule', compact('application'));
    }

}
