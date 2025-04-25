@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Webinar</h1>
    <form action="{{ route('webinars.update', $webinar->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $webinar->title }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required>{{ $webinar->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ $webinar->date }}" required>
        </div>
        <div class="mb-3">
            <label for="time" class="form-label">Time</label>
            <input type="time" class="form-control" id="time" name="time" value="{{ $webinar->time }}" required>
        </div>
        <div class="mb-3">
            <label for="link_meet" class="form-label">Meeting Link</label>
            <input type="url" class="form-control" id="link_meet" name="link_meet" value="{{ $webinar->link_meet }}" placeholder="https://meet.google.com/xxx-xxxx-xxx">
            <small class="text-muted">Enter the meeting link (Google Meet, Zoom, etc.)</small>
        </div>
        <button type="submit" class="btn btn-primary">Update Webinar</button>
        <a href="{{ route('webinars.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
