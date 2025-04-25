@extends('layouts.app')

@section('title', 'Pengaturan Akun - Dash')

@section('content')
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f8f9fa;
    }

    .card {
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        border: 2px solid #ced4da;
    }

    .section-title {
        color: #007bff;
        font-weight: bold;
    }

    .btn-danger,
    .btn-success {
        border-radius: 20px;
        font-weight: bold;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }
</style>

<div class="container mt-5">
    <div class="d-flex justify-content-center">
        <form action="{{ route('applicant.updateProfile') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card p-4" style="width: 600px;">
                <h3 class="section-title mb-4 text-center">Edit Profile Applicant</h3>
                {{-- <div class="text-center mb-4">
                    @if($user->profile_photo)
                        <img src="{{ asset('images/profile/' . $user->profile_photo) }}"
                            class="img-fluid mb-3 rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    @endif
                    <input type="file" name="profile_photo" class="form-control mt-3">
                </div> --}}
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control mb-3" id="name" value="{{ $user->name }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control mb-3" id="email" value="{{ $user->email }}" required>
                </div>
                <div class="form-group">
                    <label for="password">Password Baru</label>
                    <input type="password" name="password" class="form-control mb-3" id="password">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah password</small>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-control mb-3" id="password_confirmation">
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" onclick="window.location='{{ route('applicant.profile') }}'"
                        class="btn btn-danger" style="margin-top: 10px;">Batal</button>
                    <button type="submit" class="btn btn-success" style="margin-top: 10px;">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
