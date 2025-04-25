@extends('layouts.app')

@section('title', 'Manage Accounts')

@section('content')
<div class="container">
    <h1>Manage Accounts</h1>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
        <a href="{{ route('admin.account.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Register New User
        </a>
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Organization</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($user->role) }}</td> <!-- No badge -->
                            <td>{{ $user->company_name ?? '-' }}</td>
                            <td>
                                <div class="d-flex gap-4"> <!-- Added spacing using Bootstrap 5 utility class -->
                                    <a href="{{ route('admin.account.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.account.delete', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
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
