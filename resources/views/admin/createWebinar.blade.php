@extends('layouts.app')

@section('title', 'Create Webinar')

@section('content')
<div class="container">
    <h1 class="my-4">Create New Webinar</h1>
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

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.webinar.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label for="title">Webinar Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="description">Webinar Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" name="date" value="{{ old('date') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="time">Time</label>
                            <input type="time" class="form-control" id="time" name="time" value="{{ old('time') }}" required>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="link_meet">Meeting Link</label>
                    <input type="url" class="form-control" id="link_meet" name="link_meet" value="{{ old('link_meet') }}" 
                           placeholder="https://meet.google.com/xxx-xxxx-xxx">
                    <small class="text-muted">Enter the meeting link (Google Meet, Zoom, etc.)</small>
                </div>

                <div class="form-group mb-3">
                    <label for="price">Price (IDR)</label>
                    <input type="number" class="form-control" id="price" name="price" value="{{ old('price', 0) }}" min="0" step="1000">
                    <small class="text-muted">Enter the webinar price (0 for free webinar)</small>
                </div>


                <button type="submit" class="btn btn-primary">Create Webinar</button>
            </form>
        </div>
    </div>
</div>
@endsection 