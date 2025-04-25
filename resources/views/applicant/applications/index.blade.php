@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Active Applications</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <a href="{{ route('applicant.dashboard') }}" class="btn btn-secondary mb-3">Back to Dashboard</a>
    <table class="table">
        <thead>
            <tr>
                <th>Job Title</th>
                <th>Company</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($applications as $application)
            <tr>
                <td>{{ $application->job->title }}</td>
                <td>{{ $application->job->company }}</td>
                <td>{{ ucfirst($application->status) }}</td>
                <td>
                    @if($application->status == 'accepted')
                        <a href="{{ route('applicant.schedule.interview', $application->id) }}" class="btn btn-primary">Proceed</a>
                    @else
                        <span class="text-danger">-</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
