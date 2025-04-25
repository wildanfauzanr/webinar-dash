@extends('layouts.app')

@section('title', 'Detail Webinar')

@section('content')
<div class="container">
    <h1 class="my-4">Detail Webinar</h1>
    <div class="d-flex justify-content-between mb-4">
        <a href="{{ route('admin.webinars') }}" class="btn btn-secondary">Back to Webinars</a>
        <a href="{{ route('admin.webinar.download.pdf', $webinar->id) }}" class="btn btn-primary">
            <i class="fas fa-download"></i> Download Summary
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-8">
                    <h2>{{ $webinar->title }}</h2>
                    <p class="text-muted">
                        <i class="fas fa-calendar"></i> {{ $webinar->date }} 
                        <i class="fas fa-clock ms-3"></i> {{ $webinar->time }}
                    </p>
                </div>
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="card-title">Statistik</h5>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Peserta:</span>
                                <strong>{{ $totalParticipants }}</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Total Pendapatan:</span>
                                <strong>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <h4>Deskripsi</h4>
                    <p>{{ $webinar->description }}</p>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <h4>Informasi Webinar</h4>
                    <table class="table">
                        <tr>
                            <th>Harga</th>
                            <td>Rp {{ number_format($webinar->price, 0, ',', '.') }}</td>
                        </tr>
                        @if($webinar->link_meet)
                        <tr>
                            <th>Link Meeting</th>
                            <td><a href="{{ $webinar->link_meet }}" target="_blank">{{ $webinar->link_meet }}</a></td>
                        </tr>
                        @endif
                    </table>
                </div>
                <div class="col-md-6">
                    <h4>Daftar Peserta</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($webinar->applicants as $index => $participant)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $participant->name }}</td>
                                    <td>{{ $participant->email }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fungsi untuk menghitung ulang total pendapatan
    function calculateRevenue() {
        const totalParticipants = {{ $totalParticipants }};
        const price = {{ $webinar->price }};
        return totalParticipants * price;
    }
    
    // Tampilkan total pendapatan yang sudah diformat
    const formattedRevenue = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR'
    }).format(calculateRevenue());
});
</script>
@endsection 