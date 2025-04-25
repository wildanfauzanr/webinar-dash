@extends('layouts.app')

@section('title', 'Webinar Applicants')

@section('content')
<div class="container">
    <h1 class="my-4">Webinar Applicants</h1>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('webinars.index') }}" class="btn btn-secondary">Back to Webinars</a>
        <a href="{{ route('webinars.applicants.download.pdf', $webinar->id) }}" class="btn btn-primary">
            <i class="fas fa-download"></i> Download Summary
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h2>{{ $webinar->title }}</h2>
            <p class="text-muted mb-1">
                <i class="fas fa-calendar"></i> {{ $webinar->date }}
                <i class="fas fa-clock ms-3"></i> {{ $webinar->time }}
            </p>
            <p class="fw-bold mb-0">
                Total Pendapatan:
                @php
                    $approvedCount = $webinar->applicants->filter(fn($a) => $a->pivot->status === 'approved')->count();
                @endphp
                @if($webinar->price == 0)
                    Free
                @else
                    Rp {{ number_format($webinar->price * $approvedCount, 0, ',', '.') }}
                @endif
            </p>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Bukti Bayar</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($webinar->applicants as $index => $applicant)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $applicant->name }}</td>
                            <td>{{ $applicant->email }}</td>
                            <td>
                                <span class="badge bg-{{ $applicant->pivot->status == 'approved' ? 'success' : ($applicant->pivot->status == 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($applicant->pivot->status) }}
                                </span>
                            </td>
                            <td>
                                @if($applicant->pivot->payment_proof)
                                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#proofModal{{ $applicant->id }}">
                                        <i class="fas fa-image"></i> Lihat Bukti
                                    </button>
                                @else
                                    <span class="text-muted">Tidak ada bukti</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown d-inline">
                                    @if($applicant->pivot->status == 'pending')
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-cog"></i> Status
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <form action="{{ route('webinars.applicants.status', ['webinarId' => $webinar->id, 'applicantId' => $applicant->id]) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="dropdown-item text-success">
                                                    <i class="fas fa-check"></i> Approve
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('webinars.applicants.status', ['webinarId' => $webinar->id, 'applicantId' => $applicant->id]) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fas fa-times"></i> Reject
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                    @endif
                                    
                                    <form action="{{ route('webinars.removeApplicant', ['webinarId' => $webinar->id, 'applicantId' => $applicant->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to remove this applicant?')">
                                            <i class="fas fa-trash"></i> Remove
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Proof Modal -->
                        @if($applicant->pivot->payment_proof)
                        <div class="modal fade" id="proofModal{{ $applicant->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Bukti Pembayaran - {{ $applicant->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        {{ $applicant->pivot->payment_proof }}
                                        <img src="{{ asset('storage/' . $applicant->pivot->payment_proof) }}" 
                                             alt="Bukti Pembayaran" 
                                             class="img-fluid">
                                    </div>
                                    <div class="modal-footer">
                                        @if($applicant->pivot->status == 'pending')
                                            <form action="{{ route('webinars.applicants.status', ['webinarId' => $webinar->id, 'applicantId' => $applicant->id]) }}" method="POST" class="me-2">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="btn btn-success">
                                                    <i class="fas fa-check"></i> Approve
                                                </button>
                                            </form>
                                            <form action="{{ route('webinars.applicants.status', ['webinarId' => $webinar->id, 'applicantId' => $applicant->id]) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-times"></i> Reject
                                                </button>
                                            </form>
                                        @endif
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.dropdown-item {
    cursor: pointer;
}
.dropdown-item:active {
    background-color: #e9ecef;
    color: inherit;
}
</style>
@endpush

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const price = {{ $webinar->price }};
        const totalApplicants = {{ $webinar->applicants->count() }};
        const totalIncome = price * totalApplicants;
        const incomeElement = document.getElementById('totalIncome');

        if (incomeElement) {
            if (price === 0) {
                incomeElement.textContent = 'Free';
            } else {
                incomeElement.textContent = 'Rp ' + totalIncome.toLocaleString('id-ID');
            }
        }
    });
</script>
@endpush
