<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\RecruiterController;
use App\Http\Controllers\WebinarController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\LandingController;

Route::get('/', [LandingController::class, 'index'])->name('landing');

// Authentication
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Search
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/live-search', [SearchController::class, 'liveSearch'])->name('live-search');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->role === 'recruiter') {
            return redirect()->route('recruiter.dashboard');
        } else {
            return redirect()->route('applicant.dashboard');
        }
    })->name('dashboard');

    // Profile for all users
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    
    // Applicant routes
    Route::middleware(['is_applicant'])->group(function () {
        Route::get('/dashboard/applicant', [ApplicantController::class, 'index'])->name('applicant.dashboard');
        Route::post('/webinars/{id}/join', [WebinarController::class, 'join'])->name('webinars.join');
        Route::get('/webinars/joined', [WebinarController::class, 'joinedWebinars'])->name('webinars.joined');
        Route::get('applicant/events', [EventController::class, 'applicantIndex'])->name('applicant.events.index');
        Route::post('applicant/events/{event}/join', [EventController::class, 'join'])->name('applicant.events.join');
        Route::get('applicant/events/{event}/certificate', [EventController::class, 'downloadCertificate'])->name('applicant.events.certificate');
        Route::get('applicant/jobs', [JobController::class, 'availableJobs'])->name('applicant.jobs.index');
        Route::post('applicant/jobs/{job}/apply', [ApplicationController::class, 'store'])->name('applicant.jobs.apply');
        Route::get('applicant/applications/active', [ApplicationController::class, 'activeApplications'])->name('applicant.applications.active');
        Route::get('applicant/applications/{application}/schedule-interview', [ApplicationController::class, 'scheduleInterview'])->name('applicant.schedule.interview');
        Route::post('applications/{application}/interviews/schedule', [InterviewController::class, 'schedule'])->name('interview.schedule');
        
        // Applicant profile
        Route::get('/applicant/profile', [ProfileController::class, 'applicantProfile'])->name('applicant.profile');
        Route::get('/applicant/detailProfile', [ProfileController::class, 'applicantDetailProfile'])->name('applicant.detailProfile');
        Route::put('/applicant/updateProfile', [ProfileController::class, 'updateApplicantProfile'])->name('applicant.updateProfile');
        Route::get('/applicant/educationProfile', [ProfileController::class, 'educationProfile'])->name('applicant.educationProfile');
        Route::post('/applicant/storeEducation', [ProfileController::class, 'storeEducation'])->name('applicant.storeEducation');
        Route::get('/applicant/editEducation/{id}', [ProfileController::class, 'editEducation'])->name('applicant.editEducation');
        Route::put('/applicant/updateEducation/{id}', [ProfileController::class, 'updateEducation'])->name('applicant.updateEducation');
        Route::delete('/applicant/deleteEducation/{id}', [ProfileController::class, 'deleteEducation'])->name('applicant.deleteEducation');
        Route::get('/applicant/experience', [ProfileController::class, 'experienceProfile'])->name('applicant.experienceProfile');
        Route::post('/applicant/experience', [ProfileController::class, 'storeExperience'])->name('applicant.storeExperience');
        Route::get('/applicant/experience/{id}/edit', [ProfileController::class, 'editExperience'])->name('applicant.editExperience');
        Route::put('/applicant/experience/{id}', [ProfileController::class, 'updateExperience'])->name('applicant.updateExperience');
        Route::delete('/applicant/experience/{id}', [ProfileController::class, 'deleteExperience'])->name('applicant.deleteExperience');
    });

    // Recruiter routes
    Route::middleware(['is_recruiter'])->group(function () {
        Route::get('/dashboard/recruiter', [RecruiterController::class, 'index'])->name('recruiter.dashboard');
        Route::get('/webinars/create', [WebinarController::class, 'create'])->name('webinars.create');
        Route::post('/webinars', [WebinarController::class, 'store'])->name('webinars.store');
        Route::get('/webinars/{id}/edit', [WebinarController::class, 'edit'])->name('webinars.edit');
        Route::put('/webinars/{id}', [WebinarController::class, 'update'])->name('webinars.update');
        Route::delete('/webinars/{id}', [WebinarController::class, 'destroy'])->name('webinars.destroy');
        Route::get('/webinars/{id}/applicants', [WebinarController::class, 'applicants'])->name('webinars.applicants');
        Route::get('/webinars/{id}/applicants/download-pdf', [WebinarController::class, 'downloadApplicantsPDF'])->name('webinars.applicants.download.pdf');
        Route::delete('/webinars/{webinarId}/applicants/{applicantId}', [WebinarController::class, 'removeApplicant'])->name('webinars.removeApplicant');
        Route::get('recruiter/events/create', [EventController::class, 'create'])->name('recruiter.events.create');
        Route::post('recruiter/events', [EventController::class, 'store'])->name('recruiter.events.store');
        Route::get('recruiter/events', [EventController::class, 'recruiterIndex'])->name('recruiter.events.index');
        Route::get('recruiter/jobs', [JobController::class, 'index'])->name('recruiter.jobs.index');
        Route::get('recruiter/jobs/create', [JobController::class, 'create'])->name('recruiter.jobs.create');
        Route::post('recruiter/jobs', [JobController::class, 'store'])->name('recruiter.jobs.store');
        Route::get('recruiter/jobs/{job}/applications', [ApplicationController::class, 'index'])->name('recruiter.jobs.applications');
        Route::post('applications/{application}/status', [ApplicationController::class, 'updateStatus'])->name('applications.status.update');
        Route::patch('recruiter/jobs/{job}/close', [JobController::class, 'close'])->name('recruiter.jobs.close');

        
        // Recruiter profile
        Route::get('/profile', [ProfileController::class, 'recruiterProfile'])->name('recruiter.profile');
        Route::get('/detailProfile', [ProfileController::class, 'recruiterDetailProfile'])->name('recruiter.detailProfile');
        Route::put('/updateProfile', [ProfileController::class, 'updateRecruiterProfile'])->name('recruiter.updateProfile');
    });

    // Admin routes
    Route::middleware(['is_admin'])->group(function () {
        Route::get('/dashboard/admin', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/accounts', [AdminController::class, 'accounts'])->name('admin.accounts');
        Route::get('/admin/account/create', [AdminController::class, 'createAccount'])->name('admin.account.create');
        Route::post('/admin/account/store', [AdminController::class, 'storeAccount'])->name('admin.account.store');
        Route::get('/admin/account/edit/{id}', [AdminController::class, 'editAccount'])->name('admin.account.edit');
        Route::put('/admin/account/update/{id}', [AdminController::class, 'updateAccount'])->name('admin.account.update');
        Route::delete('/admin/account/delete/{id}', [AdminController::class, 'deleteAccount'])->name('admin.account.delete');
        Route::get('/admin/jobs', [AdminController::class, 'jobs'])->name('admin.jobs');
        Route::get('/admin/events', [AdminController::class, 'events'])->name('admin.events');
        Route::get('/admin/webinars', [AdminController::class, 'webinars'])->name('admin.webinars');
        Route::get('/admin/webinar/create', [AdminController::class, 'createWebinar'])->name('admin.webinar.create');
        Route::post('/admin/webinar/store', [AdminController::class, 'storeWebinar'])->name('admin.webinar.store');
        Route::get('/admin/webinar/detail/{id}', [AdminController::class, 'detailWebinar'])->name('admin.webinar.detail');
        Route::get('/admin/webinar/detail/{id}/download-pdf', [AdminController::class, 'downloadWebinarPDF'])->name('admin.webinar.download.pdf');

        Route::get('/admin/job/edit/{id}', [AdminController::class, 'editJob'])->name('admin.job.edit');
        Route::put('/admin/job/update/{id}', [AdminController::class, 'updateJob'])->name('admin.job.update');
        Route::delete('/admin/job/delete/{id}', [AdminController::class, 'deleteJob'])->name('admin.job.delete');

        Route::get('/admin/event/edit/{id}', [AdminController::class, 'editEvent'])->name('admin.event.edit');
        Route::put('/admin/event/update/{id}', [AdminController::class, 'updateEvent'])->name('admin.event.update');
        Route::delete('/admin/event/delete/{id}', [AdminController::class, 'deleteEvent'])->name('admin.event.delete');

        Route::get('/admin/webinar/edit/{id}', [AdminController::class, 'editWebinar'])->name('admin.webinar.edit');
        Route::put('/admin/webinar/update/{id}', [AdminController::class, 'updateWebinar'])->name('admin.webinar.update');
        Route::delete('/admin/webinar/delete/{id}', [AdminController::class, 'deleteWebinar'])->name('admin.webinar.delete');
    });

    // Common routes for authenticated users
    Route::get('/webinars', [WebinarController::class, 'index'])->name('webinars.index');
    Route::get('/webinars/{id}', [WebinarController::class, 'show'])->name('webinars.show');
    Route::get('/my-webinars', [WebinarController::class, 'myWebinars'])->name('my.webinars');
    Route::get('/webinars/{id}/download-proof', [WebinarController::class, 'downloadRegistrationProof'])->name('webinar.download.proof');
    
    // Recruiter registration routes
    Route::get('/register-recruiter', [RecruiterController::class, 'showRegistrationForm'])->name('recruiter.register');
    Route::post('/register-recruiter', [RecruiterController::class, 'register'])->name('recruiter.register.submit');
});

Route::patch('/webinars/{webinarId}/applicants/{applicantId}/status', [WebinarController::class, 'updateApplicantStatus'])->name('webinars.applicants.status');
