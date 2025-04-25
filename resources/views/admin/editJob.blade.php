@extends('layouts.app')

@section('title', 'Edit Job')

@section('content')
<div class="container">
    <h1 class="my-4">Edit Job</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.job.update', $job->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label for="title">Job Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $job->title }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="description">Job Description</label>
            <textarea class="form-control" id="description" name="description" required>{{ $job->description }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label for="location">Location</label>
            <input type="text" class="form-control" id="location" name="location" value="{{ $job->location }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="open" {{ $job->status == 'open' ? 'selected' : '' }}>Open</option>
                <option value="closed" {{ $job->status == 'closed' ? 'selected' : '' }}>Closed</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update Job</button>
    </form>
</div>
@endsection
