@extends('layouts.app')

@section('title', 'Edit Webinar')

@section('content')
<div class="container">
    <h1 class="my-4">Edit Webinar</h1>
    <a href="{{ route('admin.webinars') }}" class="btn btn-secondary mb-4">Back to Webinars</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <form action="{{ route('admin.webinar.update', $webinar->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                    <label for="title">Webinar Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $webinar->title }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="description">Webinar Description</label>
                    <textarea class="form-control" id="description" name="description" required rows="4">{{ $webinar->description }}</textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="date">Date</label>
                    <input type="date" class="form-control" id="date" name="date" value="{{ $webinar->date }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="time">Time</label>
                    <input type="time" class="form-control" id="time" name="time" value="{{ $webinar->time }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="link_meet">Meeting Link</label>
                    <input type="url" class="form-control" id="link_meet" name="link_meet" value="{{ $webinar->link_meet }}" placeholder="https://meet.google.com/xxx-xxxx-xxx">
                    <small class="text-muted">Enter the meeting link (Google Meet, Zoom, etc.)</small>
                </div>

                <div class="form-group mb-3">
                    <label for="price">Price (IDR)</label>
                    <input type="number" class="form-control" id="price" name="price" value="{{ $webinar->price }}" min="0" step="1000">
                    <small class="text-muted">Enter the webinar price (0 for free webinar)</small>
                </div>


                <button type="submit" class="btn btn-success mb-4">Update Webinar</button>
            </form>
        </div>
        
        <div class="col-md-4">
        </div>
    </div>
</div>
@endsection
