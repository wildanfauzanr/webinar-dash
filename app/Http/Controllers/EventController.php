<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use Barryvdh\DomPDF\Facade\Pdf;

class EventController extends Controller
{
    public function applicantIndex()
    {
        $events = Event::all();
        return view('applicant.events.index', compact('events'));
    }
    
    public function recruiterIndex()
    {
        $events = Event::where('recruiter_id', Auth::id())->get();
        return view('recruiter.events.index', compact('events'));
    }
    
    public function create()
    {
        return view('recruiter.events.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
    
        Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'recruiter_id' => Auth::id(),
        ]);
    
        if ($request->ajax()) {
            return response()->json(['success' => 'Event created successfully.']);
        }
    
        return redirect()->route('recruiter.events.index')
            ->with('success', 'Event created successfully.');
    }
    
    public function join(Event $event)
    {
        $event->applicants()->attach(Auth::id());
        return redirect()->route('applicant.events.index')
            ->with('success', 'You have joined the event.');
    }
    
    public function generateCertificate(Event $event)
    {
        $applicant = Auth::user();
    
        // Generate certificate logic here
    
        return response()->download($certificatePath);
    }

    public function downloadCertificate(Event $event)
    {
        $applicant = Auth::user();
        
        if (!$event->applicants()->find($applicant->id)) {
            return redirect()->back()->with('error', 'You have not joined this event.');
        }
    
        $data = [
            'title' => $event->title,
            'applicantName' => $applicant->name,
            'date' => now()->format('F d, Y'),
        ];
    
        $pdf = Pdf::loadView('certificates.template', $data);
        return $pdf->download('certificate-' . $applicant->name . '-' . $event->title . '.pdf');
    }
}
