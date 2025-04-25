@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create a Job</h1>

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
        <a href="{{ route('recruiter.dashboard') }}" class="btn btn-secondary mb-3">Back to Dashboard</a>
        <div class="form-group">
            <label for="title">Job Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="form-group">
            <label for="description">Job Description</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>

        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" class="form-control" id="location" name="location" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Job</button>
    </form>
</div>
@endsection
