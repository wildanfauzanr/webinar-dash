@extends('layouts.app')

@section('title', 'Manage Jobs')

@section('content')
<div class="container">
    <h1 class="my-4">Manage Jobs</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Location</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobs as $job)
            <tr>
                <td>{{ $job->title }}</td>
                <td>{{ $job->description }}</td>
                <td>{{ $job->location }}</td>
                <td>{{ ucfirst($job->status) }}</td>
                <td>
                    <a href="{{ route('admin.job.edit', $job->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.job.delete', $job->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
