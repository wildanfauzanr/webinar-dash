@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-5">
        <div class="col-md-8 text-center">
            <h1 class="display-4 mb-3">Welcome to Dash Webinar</h1>
            <p class="lead">Start your learning journey! Dash Webinar makes it easy for you to find, attend, and host webinars that suit your interests.</p>
        </div>
    </div>

    <h2 class="text-center mb-4">Available Webinars</h2>

    <div class="row g-4 gy-5 mb-4">
        @foreach($webinars as $webinar)
        <div class="col-md-4 d-flex">
            <div class="card h-100 w-100" style="max-width: 450px; margin: 0 auto;">
                <div class="card-body p-3">
                    <h5 class="card-title" style="font-size: 1.1rem;">{{ $webinar->title }}</h5>
                    <p class="card-text small">{{ $webinar->description }}</p>
                    <p class="card-text">
                        <small class="text-muted">
                            <i class="fas fa-calendar"></i> {{ $webinar->date }}<br>
                            <i class="fas fa-clock"></i> {{ $webinar->time }}<br>
                            <i class="fas fa-money-bill-wave"></i> 
                            @if($webinar->price == 0 || $webinar->price == '0.00')
                                Free
                            @else
                                {{ 'Rp' . number_format($webinar->price, 0, ',', '.') }}
                            @endif
                        </small>
                    </p>
                </div>
                <div class="card-footer bg-transparent p-3">
                    <a href="{{ route('login') }}" class="btn btn-primary w-100 btn-sm">
                        Login to Join Webinar
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>    
</div>

<style>
.card {
    transition: transform 0.2s;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.display-4 {
    font-weight: 600;
}

.lead {
    font-size: 1.2rem;
}

.card-title {
    margin-bottom: 0.75rem;
    line-height: 1.3;
}

.card-text.small {
    font-size: 0.875rem;
    line-height: 1.4;
    color: #6c757d;
}

@media (max-width: 768px) {
    .card {
        max-width: 100% !important;
    }
}
</style>
@endsection
