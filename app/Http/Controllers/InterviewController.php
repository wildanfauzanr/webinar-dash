<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InterviewController extends Controller
{
    public function schedule(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
        ]);
        
        return redirect()->route('applicant.applications.active')
                         ->with('success', 'Interview scheduled successfully.');
    }
}
