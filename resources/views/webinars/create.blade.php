@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Webinar</h1>
    <form action="{{ route('webinars.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>
        <div class="mb-3">
            <label for="time" class="form-label">Time</label>
            <input type="time" class="form-control" id="time" name="time" required>
        </div>
        <div class="mb-3">
            <label for="link_meet" class="form-label">Meeting Link</label>
            <input type="url" class="form-control" id="link_meet" name="link_meet" placeholder="https://meet.google.com/xxx-xxxx-xxx">
            <small class="text-muted">Enter the meeting link (Google Meet, Zoom, etc.)</small>
        </div>
        <button type="submit" class="btn btn-primary">Create Webinar</button>
        <a href="{{ route('webinars.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
