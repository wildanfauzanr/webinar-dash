@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Available Jobs</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <a href="{{ route('applicant.dashboard') }}" class="btn btn-secondary mb-3">Back to Dashboard</a>

    <div class="row">
        @foreach($jobs as $job)
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">{{ $job->title }}</h5>
                    <p class="card-text">{{ \Illuminate\Support\Str::limit($job->description, 100) }}</p>
                    <p class="card-text">{{ $job->location }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        @if(in_array($job->id, $applications))
                            <button type="button" class="btn btn-secondary" disabled>Applied</button>
                            <p class="text-success">Application Status: {{ optional($job->applications->where('user_id', Auth::id())->first())->status }}</p>
                        @else
                            <form action="{{ route('applicant.jobs.apply', $job->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-primary">Apply</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
