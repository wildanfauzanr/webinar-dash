@extends('layouts.app')

@section('content')
@php
use Illuminate\Support\Str;
@endphp
<div class="container">
    <h1 class="my-4">My Events</h1>
    
    <div class="d-flex justify-content-between mb-4">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createEventModal">
            Create Event
        </button>
        <a href="{{ route('recruiter.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="list-group">
        @foreach($events as $event)
        <div class="list-group-item list-group-item-action mb-3 shadow-sm">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">{{ $event->title }}</h5>
                <small class="text-muted">{{ $event->created_at->format('M d, Y') }}</small>
            </div>
            <p class="mb-1">{{ Str::limit($event->description, 150) }}</p>
            <div class="mt-3">
                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#eventDetailsModal" data-title="{{ $event->title }}" data-description="{{ $event->description }}">View Details</button>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Create Event Modal -->
<div class="modal fade" id="createEventModal" tabindex="-1" aria-labelledby="createEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createEventModalLabel">Create Event</h5>
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
                <form action="{{ route('recruiter.events.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="title">Event Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="description">Event Description</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Create Event</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- View Event Details Modal -->
<div class="modal fade" id="eventDetailsModal" tabindex="-1" aria-labelledby="eventDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventDetailsModalLabel">Event Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 id="eventTitle"></h5>
                <p id="eventDescription"></p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const eventDetailsModal = document.getElementById('eventDetailsModal');
        eventDetailsModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const title = button.getAttribute('data-title');
            const description = button.getAttribute('data-description');

            const modalTitle = eventDetailsModal.querySelector('#eventTitle');
            const modalDescription = eventDetailsModal.querySelector('#eventDescription');

            modalTitle.textContent = title;
            modalDescription.textContent = description;
        });
    });
</script>
@endsection
