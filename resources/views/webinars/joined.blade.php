@extends('layouts.app')
@php
    use Illuminate\Support\Str;
@endphp

@section('content')
<div class="container">
    <h1 class="my-4">My Joined Webinars</h1>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('webinars.index') }}" class="btn btn-secondary">Back</a>
    </div>

    @if($webinars->isEmpty())
        <div class="alert alert-info">
            Anda belum terdaftar di webinar manapun.
        </div>
    @else
        <div class="row justify-content-start">
            @foreach($webinars as $webinar)
                <div class="col-md-4 mb-4 d-flex align-items-stretch">
                    <div class="card w-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $webinar->title }}</h5>
                            <p class="card-text">{{ Str::limit($webinar->description, 100) }}</p>
                            <p class="card-text">
                                <small class="text-muted">
                                    <i class="fas fa-calendar"></i> {{ $webinar->date }}<br>
                                    <i class="fas fa-clock"></i> {{ $webinar->time }}
                                </small>
                            </p>

                            <div class="mb-3">
                                <span class="badge bg-{{ $webinar->pivot->status == 'approved' ? 'success' : ($webinar->pivot->status == 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($webinar->pivot->status) }}
                                </span>
                            </div>

                            <div class="mt-auto">
                                @if($webinar->pivot->status == 'approved')
                                    @if($webinar->link_meet)
                                        <a href="{{ $webinar->link_meet }}" class="btn btn-primary mb-2 w-100" target="_blank">
                                            <i class="fas fa-video"></i> Join Meeting
                                        </a>
                                    @else
                                        <button class="btn btn-secondary mb-2 w-100" disabled>Link Meeting Belum Tersedia</button>
                                    @endif

                                    <a href="{{ route('webinar.download.proof', $webinar->id) }}" class="btn btn-info w-100">
                                        <i class="fas fa-download"></i> Download Bukti Pendaftaran
                                    </a>
                                @elseif($webinar->pivot->status == 'pending')
                                    <div class="alert alert-warning mt-2">
                                        <small>Menunggu verifikasi pembayaran dari penyelenggara.</small>
                                    </div>
                                @else
                                    <div class="alert alert-danger mt-2">
                                        <small>Pendaftaran Anda ditolak. Silakan hubungi penyelenggara <b>{{ $webinar->recruiter->email }}</b>.</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
