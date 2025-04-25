@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>{{ $webinar->title }}</h2>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        <i class="fas fa-calendar"></i> {{ $webinar->date }}
                        <i class="fas fa-clock ms-3"></i> {{ $webinar->time }}
                    </p>
                    <p>{{ $webinar->description }}</p>
                    <p><strong>Harga:</strong> Rp {{ number_format($webinar->price, 0, ',', '.') }}</p>
                    
                    @if(auth()->check())
                        @if(!$webinar->applicants->contains(auth()->id()))
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#joinModal">
                                Join Webinar
                            </button>
                        @else
                            <button class="btn btn-secondary" disabled>Sudah Terdaftar</button>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">Login untuk Join</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Join Modal -->
<div class="modal fade" id="joinModal" tabindex="-1" aria-labelledby="joinModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('webinars.join', $webinar->id) }}" method="POST" enctype="multipart/form-data" id="joinForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="joinModalLabel">Konfirmasi Pendaftaran Webinar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <h6>Detail Webinar:</h6>
                        <p><strong>{{ $webinar->title }}</strong></p>
                        <p>Tanggal: {{ $webinar->date }}</p>
                        <p>Waktu: {{ $webinar->time }}</p>
                        <p>Harga: Rp {{ number_format($webinar->price, 0, ',', '.') }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label for="payment_proof" class="form-label required">Upload Bukti Pembayaran</label>
                        <input type="file" class="form-control" id="payment_proof" name="payment_proof" required accept="image/*" onchange="previewImage(this)">
                        <div class="form-text">Format yang diterima: JPG, JPEG, PNG (max. 2MB)</div>
                        
                        <div id="imagePreview" class="mt-3 text-center d-none">
                            <img src="" alt="Preview" class="img-fluid" style="max-height: 200px;">
                            <button type="button" class="btn btn-sm btn-danger mt-2" onclick="removeImage()">
                                <i class="fas fa-times"></i> Hapus Gambar
                            </button>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <small>
                            <i class="fas fa-info-circle"></i> 
                            Setelah mendaftar, status Anda akan "pending" sampai penyelenggara memverifikasi pembayaran Anda.
                            Link meeting akan tersedia setelah pembayaran diverifikasi.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn" disabled>Daftar Webinar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .required:after {
        content: " *";
        color: red;
    }
</style>
@endpush

@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const submitBtn = document.getElementById('submitBtn');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.querySelector('img').src = e.target.result;
            preview.classList.remove('d-none');
            submitBtn.disabled = false;
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.classList.add('d-none');
        submitBtn.disabled = true;
    }
}

function removeImage() {
    const input = document.getElementById('payment_proof');
    const preview = document.getElementById('imagePreview');
    const submitBtn = document.getElementById('submitBtn');
    
    input.value = '';
    preview.classList.add('d-none');
    submitBtn.disabled = true;
}

document.getElementById('joinForm').addEventListener('submit', function(e) {
    const input = document.getElementById('payment_proof');
    if (!input.files || !input.files[0]) {
        e.preventDefault();
        alert('Silakan upload bukti pembayaran terlebih dahulu!');
    }
});
</script>
@endpush
@endsection
