@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(to right, #ffffff, #e0f7fa);
    }
    .welcome-message {
        text-align: center;
        margin-bottom: 30px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }
    .card {
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
</style>
<div class="container mt-5">
    <h2 class="welcome-message">Welcome, {{ $user->name }}</h2>
    <div class="row">
        <!-- Jobs Card -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Jobs</h5>
                    <p class="card-text">Total Jobs: {{ $jobsCount }}</p>
                    <ul class="list-group">
                        @foreach($recentJobs as $job)
                            <li class="list-group-item">
                                <h6>{{ $job->title }}</h6>
                                <p>{{ \Illuminate\Support\Str::limit($job->description, 50) }}</p>
                            </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('recruiter.jobs.index') }}" class="btn btn-primary mt-3">View Jobs</a>
                </div>
            </div>
        </div>
        <!-- Events Card -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Events</h5>
                    <p class="card-text">Total Events: {{ $eventsCount }}</p>
                    <ul class="list-group">
                        @foreach($recentEvents as $event)
                            <li class="list-group-item">
                                <h6>{{ $event->title }}</h6>
                                <p>{{ \Illuminate\Support\Str::limit($event->description, 50) }}</p>
                            </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('recruiter.events.index') }}" class="btn btn-primary mt-3">View Events</a>
                </div>
            </div>
        </div>
        <!-- Webinars Card -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Webinars</h5>
                    <p class="card-text">Total Webinars: {{ $webinarsCount }}</p>
                    <ul class="list-group">
                        @foreach($recentWebinars as $webinar)
                            <li class="list-group-item">
                                <h6>{{ $webinar->title }}</h6>
                                <p>{{ \Illuminate\Support\Str::limit($webinar->description, 50) }}</p>
                            </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('webinars.index') }}" class="btn btn-primary mt-3">View Webinars</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
