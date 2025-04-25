@extends('layouts.app')

@section('title', 'Register New User')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Register New User</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.account.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                id="name" name="name" value="{{ old('name') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                id="email" name="email" value="{{ old('email') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                id="password" name="password" required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" 
                                id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select @error('role') is-invalid @enderror" 
                                id="role" name="role" required>
                                <option value="">Pilih Role</option>
                                <option value="applicant" {{ old('role') == 'applicant' ? 'selected' : '' }}>Applicant</option>
                                <option value="recruiter" {{ old('role') == 'recruiter' ? 'selected' : '' }}>Recruiter</option>
                            </select>
                        </div>

                        <div class="mb-3 organization-field" style="display: none;">
                            <label for="company_name" class="form-label">Nama Organisasi</label>
                            <input type="text" class="form-control @error('company_name') is-invalid @enderror" 
                                id="company_name" name="company_name" value="{{ old('company_name') }}">
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.accounts') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role');
    const organizationField = document.querySelector('.organization-field');

    function toggleOrganizationField() {
        if (roleSelect.value === 'recruiter') {
            organizationField.style.display = 'block';
        } else {
            organizationField.style.display = 'none';
        }
    }

    roleSelect.addEventListener('change', toggleOrganizationField);
    toggleOrganizationField(); // Run on page load
});
</script>
@endpush
@endsection 