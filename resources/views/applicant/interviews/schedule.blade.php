@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Schedule Interview for "{{ $application->job->title }}"</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <a href="{{ route('applicant.dashboard') }}" class="btn btn-secondary mb-3">Back to Dashboard</a>
    <form action="{{ route('interview.schedule', ['application' => $application->id]) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>

        <div class="form-group">
            <label for="time">Time</label>
            <input type="time" class="form-control" id="time" name="time" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Schedule Interview</button>
    </form>

</div>
@endsection
