@extends('layouts.app')

@section('content')

<div class="container">
    <h1 class="my-4">Available Events</h1>
    
    <a href="{{ route('applicant.dashboard') }}" class="btn btn-secondary mb-3">Back to Dashboard</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @foreach($events as $event)
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">{{ $event->title }}</h5>
                    <p class="card-text">{{ \Illuminate\Support\Str::limit($event->description, 100) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        @if($event->applicants->contains(auth()->user()))
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eventDetailsModal{{ $event->id }}">Details</button>
                            <form action="{{ route('applicant.events.certificate', $event->id) }}" method="GET" class="d-inline">
                                <button type="submit" class="btn btn-secondary">Download Certificate</button>
                            </form>
                            <button type="button" class="btn btn-success" disabled>Joined</button>
                        @else
                            <form action="{{ route('applicant.events.join', $event->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success">Join Event</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Event Details Modal -->
        <div class="modal fade" id="eventDetailsModal{{ $event->id }}" tabindex="-1" aria-labelledby="eventDetailsModalLabel{{ $event->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eventDetailsModalLabel{{ $event->id }}">{{ $event->title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Description:</strong> {{ $event->description }}</p>
                        <p><strong>Date:</strong> {{ $event->date }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        @if(!$event->applicants->contains(auth()->user()))
                            <form action="{{ route('applicant.events.join', $event->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success">Join Event</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Include Bootstrap JS if not already included -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

@endsection
