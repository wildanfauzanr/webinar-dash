@extends('layouts.app')

@section('title', 'Pengaturan Akun - Dash')

@section('content')
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

    .btn-warning {
        border-radius: 20px;
        font-weight: bold;
        background-color: #ffc107;
        border-color: #ffc107;
    }

    .profile-photo {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .photo-placeholder {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background-color: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        color: #6c757d;
    }
</style>

<div class="container mt-5">
    <div class="d-flex justify-content-center">
        <div class="card p-4" style="width: 600px;">
            <h3 class="section-title mb-4 text-center">Profile Akun Applicant</h3>
            {{-- <div class="text-center">
                @if($user->profile_photo)
                    <img src="{{ asset('images/profile/' . $user->profile_photo) }}" class="profile-photo" alt="Profile Photo">
                @else
                    <div class="photo-placeholder">
                        <i class="fas fa-user fa-4x"></i>
                    </div>
                @endif
            </div> --}}
            <form>
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" class="form-control mb-3" id="name" value="{{ $user->name }}" readonly>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control mb-3" id="email" value="{{ $user->email }}" readonly>
                </div>
                <div class="text-center">
                    <button type="button" onclick="window.location='{{ route('applicant.detailProfile') }}'" class="btn btn-warning mt-3">Edit Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
