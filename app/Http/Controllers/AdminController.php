<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Job;
use App\Models\Event;
use App\Models\Webinar;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use PDF;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function accounts()
    {
        $users = User::all();
        return view('admin.accounts', compact('users'));
    }

    public function jobs()
    {
        $jobs = Job::all();
        return view('admin.jobs', compact('jobs'));
    }

    public function events()
    {
        $events = Event::all();
        return view('admin.events', compact('events'));
    }

    public function webinars()
    {
        $webinars = Webinar::all();
        return view('admin.webinars', compact('webinars'));
    }

    public function editAccount($id)
    {
        $user = User::findOrFail($id);
        return view('admin.editAccount', compact('user'));
    }

    public function updateAccount(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:applicant,recruiter,admin',
        ]);

        $user->update($request->all());

        return redirect()->route('admin.accounts')->with('success', 'Account updated successfully.');
    }

    public function deleteAccount($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.accounts')->with('success', 'Account deleted successfully.');
    }

    public function editJob($id)
    {
        $job = Job::findOrFail($id);
        return view('admin.editJob', compact('job'));
    }

    public function updateJob(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'status' => 'required|in:open,closed',
        ]);

        $job->update($request->all());

        return redirect()->route('admin.jobs')->with('success', 'Job updated successfully.');
    }

    public function deleteJob($id)
    {
        Job::findOrFail($id)->delete();
        return redirect()->route('admin.jobs')->with('success', 'Job deleted successfully.');
    }

    public function editEvent($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.editEvent', compact('event'));
    }

    public function updateEvent(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $event->update($request->all());

        return redirect()->route('admin.events')->with('success', 'Event updated successfully.');
    }

    public function deleteEvent($id)
    {
        Event::findOrFail($id)->delete();
        return redirect()->route('admin.events')->with('success', 'Event deleted successfully.');
    }

    public function editWebinar($id)
    {
        $webinar = Webinar::findOrFail($id);
        return view('admin.editWebinar', compact('webinar'));
    }

    public function updateWebinar(Request $request, $id)
    {
        $webinar = Webinar::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'link_meet' => 'nullable|url',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'price' => 'required|numeric|min:0'
        ]);

        $data = $request->except('poster');

        if ($request->hasFile('poster')) {
            // Delete old poster if exists
            if ($webinar->poster) {
                Storage::disk('public')->delete($webinar->poster);
            }
            $poster = $request->file('poster');
            $posterPath = $poster->store('webinar-posters', 'public');
            $data['poster'] = $posterPath;
        }

        $webinar->update($data);

        return redirect()->route('admin.webinars')->with('success', 'Webinar updated successfully.');
    }

    public function deleteWebinar($id)
    {
        Webinar::findOrFail($id)->delete();
        return redirect()->route('admin.webinars')->with('success', 'Webinar deleted successfully.');
    }

    public function createWebinar()
    {
        return view('admin.createWebinar');
    }

    public function storeWebinar(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'link_meet' => 'nullable|url',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'price' => 'required|numeric|min:0'
        ]);

        $data = $request->except('poster');
        $data['recruiter_id'] = auth()->id(); // Admin sebagai pembuat webinar

        if ($request->hasFile('poster')) {
            $poster = $request->file('poster');
            $posterPath = $poster->store('webinar-posters', 'public');
            $data['poster'] = $posterPath;
        }

        Webinar::create($data);

        return redirect()->route('admin.webinars')->with('success', 'Webinar created successfully.');
    }

    public function detailWebinar($id)
    {
        $webinar = Webinar::findOrFail($id);
        $totalParticipants = $webinar->applicants()->count();
        $totalRevenue = $totalParticipants * $webinar->price;
        
        return view('admin.detailWebinar', compact('webinar', 'totalParticipants', 'totalRevenue'));
    }

    public function createAccount()
    {
        return view('admin.create-account');
    }

    public function storeAccount(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:applicant,recruiter',
            'company_name' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'company_name' => $request->role === 'recruiter' ? $request->company_name : null,
        ]);

        return redirect()->route('admin.accounts')
            ->with('success', 'User berhasil didaftarkan!');
    }

    public function downloadWebinarPDF($id)
    {
        $webinar = Webinar::findOrFail($id);
        $totalParticipants = $webinar->applicants()->count();
        $totalRevenue = $totalParticipants * $webinar->price;

        $pdf = PDF::loadView('admin.pdf.webinar-summary', compact('webinar', 'totalParticipants', 'totalRevenue'));
        
        return $pdf->download('webinar-summary-' . $webinar->id . '.pdf');
    }
}
