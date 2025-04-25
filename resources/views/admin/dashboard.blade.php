@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container">
    <h1 class="my-4">Admin Dashboard</h1>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Manage Accounts</h5>
                    <p class="card-text">View and manage user accounts</p>
                    <a href="{{ route('admin.accounts') }}" class="btn btn-primary">Go to Accounts</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Manage Webinars</h5>
                    <p class="card-text">View and manage webinars</p>
                    <a href="{{ route('admin.webinars') }}" class="btn btn-primary">Go to Webinars</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
