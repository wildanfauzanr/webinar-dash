@extends('layouts.app')

@section('content')
@php
use Illuminate\Support\Str;
@endphp
<div class="container">
    <h1 class="my-4">My Job Listings</h1>
    
    <div class="d-flex justify-content-between mb-4">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createJobModal">
            Create Job
        </button>
        <a href="{{ route('recruiter.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @foreach($jobs as $job)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">{{ $job->title }}</h5>
                    <p class="card-text">{{ Str::limit($job->description, 100) }}</p>
                    <p class="card-text"><small class="text-muted">Status: {{ ucfirst($job->status) }}</small></p>
                    <button class="btn btn-outline-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#jobDetailsModal" data-title="{{ $job->title }}" data-description="{{ $job->description }}" data-status="{{ ucfirst($job->status) }}">View Details</button>
                    <a href="{{ route('recruiter.jobs.applications', $job->id) }}" class="btn btn-outline-primary btn-sm mb-2">View Applicants</a>
                    @if($job->status === 'open')
                    <form action="{{ route('recruiter.jobs.close', $job->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outline-danger btn-sm mb-2">Close Application</button>
                    </form>
                    @else
                        <button class="btn btn-secondary btn-sm mb-2" disabled>Application Closed</button>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Create Job Modal -->
<div class="modal fade" id="createJobModal" tabindex="-1" aria-labelledby="createJobModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createJobModalLabel">Create Job</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('recruiter.jobs.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="title">Job Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="description">Job Description</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="location">Job Location</label>
                        <input type="text" class="form-control" id="location" name="location" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Create Job</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- View Job Details Modal -->
<div class="modal fade" id="jobDetailsModal" tabindex="-1" aria-labelledby="jobDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="jobDetailsModalLabel">Job Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 id="jobTitle"></h5>
                <p id="jobDescription"></p>
                <p><strong>Status:</strong> <span id="jobStatus"></span></p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const jobDetailsModal = document.getElementById('jobDetailsModal');
        jobDetailsModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const title = button.getAttribute('data-title');
            const description = button.getAttribute('data-description');
            const status = button.getAttribute('data-status');

            const modalTitle = jobDetailsModal.querySelector('#jobTitle');
            const modalDescription = jobDetailsModal.querySelector('#jobDescription');
            const modalStatus = jobDetailsModal.querySelector('#jobStatus');

            modalTitle.textContent = title;
            modalDescription.textContent = description;
            modalStatus.textContent = status;
        });
    });
</script>
@endsection
