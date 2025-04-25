@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>My Webinars</h2>
        <a href="{{ route('webinars.create') }}" class="btn btn-primary">Create New Webinar</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(count($webinars) > 0)
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($webinars as $webinar)
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $webinar->title }}</h5>
                            <p class="card-text">{{ $webinar->description }}</p>
                            <p class="card-text">
                                <small class="text-muted">
                                    <i class="fas fa-calendar"></i> {{ $webinar->date }}<br>
                                    <i class="fas fa-clock"></i> {{ $webinar->time }}
                                </small>
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                @if($webinar->meet_link)
                                    <a href="{{ $webinar->meet_link }}" class="btn btn-primary" target="_blank">Join Meeting</a>
                                @else
                                    <span class="text-muted">Link will be available soon</span>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('webinars.edit', $webinar->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <a href="{{ route('webinars.applicants', $webinar->id) }}" class="btn btn-sm btn-info">View Applicants</a>
                                <form action="{{ route('webinars.destroy', $webinar->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this webinar?')">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">
            You haven't created any webinars yet.
        </div>
    @endif
</div>
@endsection 