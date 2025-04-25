<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Webinar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class WebinarController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'recruiter') {
            // Recruiter hanya melihat webinar yang mereka buat
            $webinars = Webinar::where('recruiter_id', auth()->id())
                             ->orderBy('date', 'asc')
                             ->orderBy('time', 'asc')
                             ->get();
        } else {

            $webinars = Webinar::with('applicants')->orderBy('date', 'asc')
                             ->orderBy('time', 'asc')
                             ->get();
        }

        
        return view('webinars.index', compact('webinars'));
    }

    public function create()
    {
        return view('webinars.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'link_meet' => 'nullable|url',
            'price' => 'required|numeric|min:0'
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'time' => $request->time,
            'link_meet' => $request->link_meet,
            'price' => $request->price,
            'recruiter_id' => Auth::id()
        ];

        Webinar::create($data);

        return redirect()->route('webinars.index')->with('success', 'Webinar created successfully!');
    }

    public function show($id)
    {
        $webinar = Webinar::findOrFail($id);
        return view('webinars.show', compact('webinar'));
    }

    public function join(Request $request, $id)
    {
        $webinar = Webinar::findOrFail($id);
        
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('payment_proofs', $filename, 'public');

            $webinar->applicants()->attach(Auth::id(), [
                'payment_proof' => $path,
                'status' => 'pending'
            ]);

            return redirect()->route('webinars.index')
                ->with('success', 'Pendaftaran berhasil! Mohon tunggu verifikasi dari penyelenggara.');
        }


        // echo "<pre>";
        // dd($webinar);
        // echo "<pre>";

        // return redirect()->back()
        //     ->with('error', 'Terjadi kesalahan saat upload bukti pembayaran.');
    }

    public function destroy($id)
    {
        $webinar = Webinar::findOrFail($id);
        if ($webinar->recruiter_id == Auth::id()) {
            $webinar->delete();
            return redirect()->route('webinars.index')->with('success', 'Webinar closed and deleted successfully!');
        }

        return redirect()->route('webinars.index')->with('error', 'You are not authorized to delete this webinar.');
    }

    public function edit($id)
    {
        $webinar = Webinar::findOrFail($id);
        if ($webinar->recruiter_id == Auth::id()) {
            return view('webinars.edit', compact('webinar'));
        }

        return redirect()->route('webinars.index')->with('error', 'You are not authorized to edit this webinar.');
    }

    public function update(Request $request, $id)
    {
        $webinar = Webinar::findOrFail($id);

        if ($webinar->recruiter_id != Auth::id()) {
            return redirect()->route('webinars.index')->with('error', 'You are not authorized to edit this webinar.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'link_meet' => 'nullable|url',
            'price' => 'required|numeric|min:0'
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'time' => $request->time,
            'link_meet' => $request->link_meet,
            'price' => $request->price
        ];

        $webinar->update($data);

        return redirect()->route('webinars.index')->with('success', 'Webinar updated successfully!');
    }

    public function updateApplicantStatus(Request $request, $webinarId, $applicantId)
    {
        $webinar = Webinar::findOrFail($webinarId);
        
        if ($webinar->recruiter_id != Auth::id()) {
            return redirect()->route('webinars.index')
                ->with('error', 'Anda tidak memiliki akses untuk melakukan ini.');
        }

        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        $webinar->applicants()->updateExistingPivot($applicantId, [
            'status' => $request->status
        ]);

        $statusText = $request->status == 'approved' ? 'disetujui' : 'ditolak';
        return redirect()->route('webinars.applicants', $webinarId)
            ->with('success', "Pendaftaran peserta telah $statusText.");
    }

    public function joinedWebinars()
    {
        $webinars = Auth::user()->joinedWebinars()
            ->withPivot('status', 'payment_proof')
            ->with('recruiter')
            ->get();
        return view('webinars.joined', compact('webinars'));
    }

    public function applicants($id)
    {
        $webinar = Webinar::findOrFail($id);
        if ($webinar->recruiter_id != Auth::id()) {
            return redirect()->route('webinars.index')->with('error', 'You are not authorized to view this webinar.');
        }

        $applicants = $webinar->applicants;

        return view('webinars.applicants', compact('webinar', 'applicants'));
    }

    public function removeApplicant($webinarId, $applicantId)
    {
        $webinar = Webinar::findOrFail($webinarId);
        if ($webinar->recruiter_id != Auth::id()) {
            return redirect()->route('webinars.index')->with('error', 'You are not authorized to remove applicants from this webinar.');
        }

        $webinar->applicants()->detach($applicantId);
        return redirect()->route('webinars.applicants', $webinarId)->with('success', 'Applicant removed successfully!');
    }

    public function myWebinars()
    {
        $user = auth()->user();
        
        if ($user->role === 'applicant' && !$user->is_recruiter) {
            return redirect()->route('recruiter.register')
                ->with('info', 'Please register as a recruiter first to access My Webinar feature.');
        }


        $webinars = Webinar::where('recruiter_id', $user->id)
                          ->orderBy('date', 'desc')
                          ->orderBy('time', 'desc')
                          ->get();

        return view('webinars.my-webinars', compact('webinars'));
    }

    public function downloadRegistrationProof($id)
    {
        $user = Auth::user();
        $webinar = Webinar::findOrFail($id);
        
        // Check if user is registered for this webinar
        $isRegistered = $user->joinedWebinars()->where('webinar_id', $id)->exists();
        
        if (!$isRegistered) {
            return redirect()->back()->with('error', 'Anda belum terdaftar di webinar ini.');
        }

        $pdf = Pdf::loadView('pdf.webinar-registration', [
            'webinar' => $webinar,
            'user' => $user
        ]);

        return $pdf->download('bukti-pendaftaran-webinar-' . Str::slug($webinar->title) . '.pdf');
    }

    public function downloadApplicantsPDF($id)
    {
        $webinar = Webinar::findOrFail($id);
        $totalParticipants = $webinar->applicants()->count();
        
        $pdf = Pdf::loadView('webinars.pdf.applicants-summary', compact('webinar', 'totalParticipants'));
        
        return $pdf->download('webinar-summary-' . $webinar->id . '.pdf');
    }
}
