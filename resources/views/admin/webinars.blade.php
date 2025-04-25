@php
    use Illuminate\Support\Str;
@endphp

@extends('layouts.app')

@section('title', 'Manage Webinars')

@section('content')
<div class="container">
    <h1 class="my-4">Manage Webinars</h1>
    
    <div class="d-flex justify-content-between mb-4">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
        {{-- <a href="{{ route('admin.webinar.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create Webinar
        </a> --}}
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Harga</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($webinars as $webinar)
                        <tr>
                            <td>{{ $webinar->title }}</td>
                            <td>{{ Str::limit($webinar->description, 100) }}</td>
                            <td>{{ $webinar->date }}</td>
                            <td>{{ $webinar->time }}</td>
                            <td>Rp {{ number_format($webinar->price, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('admin.webinar.detail', $webinar->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                <a href="{{ route('admin.webinar.edit', $webinar->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.webinar.delete', $webinar->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this webinar?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
