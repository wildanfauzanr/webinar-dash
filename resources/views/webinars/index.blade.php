@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Webinars</h1>
    @if(auth()->user()->role == 'recruiter')
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createWebinarModal">
        Create Webinar
    </button>
    @endif
    @if(auth()->user()->role == 'applicant')
    <a href="{{ route('webinars.joined') }}" class="btn btn-primary mb-3">Joined Webinars</a>
    @endif
    @foreach($webinars as $webinar)
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h5 class="card-title">{{ $webinar->title }}</h5>
                    <p class="card-text">{{ $webinar->description }}</p>
                    <p class="card-text">
                        <?php $user = $webinar->applicants->firstWhere('id', auth()->id()) ?? 0; ?>
                        <small class="text-muted">
                            <i class="fas fa-calendar"></i> {{ $webinar->date }}<br>
                            <i class="fas fa-clock"></i> {{ $webinar->time }}<br>
                            <i class="fas fa-tag"></i> {{ $webinar->price > 0 ? 'IDR ' . number_format($webinar->price, 0, ',', '.') : 'Free' }} <br>
                        </small>
                    </p>
                    {{-- <p>Registration Status: <b>{{ $user->pivot->status ?? 'Not Join' }}</b></p> --}}
                    @if($webinar->link_meet)
                    @if(auth()->user()->role == 'recruiter' || (auth()->user()->role == 'applicant' && $webinar->applicants->contains(auth()->user()) && $user->pivot->status == 'approved' ))
                    <p class="card-text">
                        <strong>Meeting Link:</strong>
                        <a href="{{ $webinar->link_meet }}" target="_blank">{{ $webinar->link_meet }}</a>
                    </p>
                    @endif
                    @endif
                    <div class="mt-3">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#webinarDetailsModal"
                            data-title="{{ $webinar->title }}"
                            data-description="{{ $webinar->description }}"
                            data-date="{{ $webinar->date }}"
                            data-time="{{ $webinar->time }}"
                            data-link="{{ $webinar->link_meet }}"
                            data-price="{{ $webinar->price }}">
                            View Details
                        </button>
                        @if(auth()->user()->role == 'applicant')
                        @if(!$webinar->applicants->contains(auth()->user()))
                        <button class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#joinModal"
                            data-id="{{ $webinar->id }}"
                            data-title="{{ $webinar->title }}"
                            data-date="{{ $webinar->date }}"
                            data-time="{{ $webinar->time }}"
                            data-price="{{ $webinar->price }}">
                            Join Webinar
                        </button>
                        @else
                        <button type="button" class="btn btn-secondary" disabled>Already Joined</button>
                        @endif
                        @endif
                        @if(auth()->user()->role == 'recruiter' && auth()->user()->id == $webinar->recruiter_id)
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editWebinarModal"
                            data-id="{{ $webinar->id }}"
                            data-title="{{ $webinar->title }}"
                            data-description="{{ $webinar->description }}"
                            data-date="{{ $webinar->date }}"
                            data-time="{{ $webinar->time }}"
                            data-link="{{ $webinar->link_meet }}"
                            data-price="{{ $webinar->price }}">
                            Edit Webinar
                        </button>
                        <a href="{{ route('webinars.applicants', $webinar->id) }}" class="btn btn-info">View Applicants</a>
                        <form action="{{ route('webinars.destroy', $webinar->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Close Webinar</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Create Webinar Modal -->
<div class="modal fade" id="createWebinarModal" tabindex="-1" aria-labelledby="createWebinarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createWebinarModalLabel">Create Webinar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form action="{{ route('webinars.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="title">Webinar Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="description">Webinar Description</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="date">Webinar Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="time">Webinar Time</label>
                        <input type="time" class="form-control" id="time" name="time" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="link_meet">Meeting Link</label>
                        <input type="url" class="form-control" id="link_meet" name="link_meet" placeholder="https://meet.google.com/xxx-xxxx-xxx">
                        <small class="text-muted">Enter the meeting link (Google Meet, Zoom, etc.)</small>
                    </div>

                    <div class="form-group mb-3">
                        <label for="price">Price (IDR)</label>
                        <input type="number" class="form-control" id="price" name="price" min="0" step="1000" value="0">
                        <small class="text-muted">Enter the webinar price (0 for free webinar)</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Webinar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- View Webinar Details Modal -->
<div class="modal fade" id="webinarDetailsModal" tabindex="-1" aria-labelledby="webinarDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="webinarDetailsModalLabel">Webinar Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 id="webinarTitle"></h5>
                <p id="webinarDescription"></p>
                <p><strong>Date:</strong> <span id="webinarDate"></span></p>
                <p><strong>Time:</strong> <span id="webinarTime"></span></p>
                @if(auth()->user()->role == 'recruiter' || (auth()->user()->role == 'applicant' && isset($webinar) && $webinar->applicants->contains(auth()->user())))
                <p id="webinarLinkContainer" style="display: none;">
                    <strong>Meeting Link:</strong>
                    <a id="webinarLink" href="#" target="_blank"></a>
                </p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Edit Webinar Modal -->
<div class="modal fade" id="editWebinarModal" tabindex="-1" aria-labelledby="editWebinarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editWebinarModalLabel">Edit Webinar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form id="editWebinarForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label for="editTitle">Webinar Title</label>
                        <input type="text" class="form-control" id="editTitle" name="title" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="editDescription">Webinar Description</label>
                        <textarea class="form-control" id="editDescription" name="description" required></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="editDate">Webinar Date</label>
                        <input type="date" class="form-control" id="editDate" name="date" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="editTime">Webinar Time</label>
                        <input type="time" class="form-control" id="editTime" name="time" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="editLinkMeet">Meeting Link</label>
                        <input type="url" class="form-control" id="editLinkMeet" name="link_meet" placeholder="https://meet.google.com/xxx-xxxx-xxx">
                        <small class="text-muted">Enter the meeting link (Google Meet, Zoom, etc.)</small>
                    </div>

                    <div class="form-group mb-3">
                        <label for="editPrice">Price (IDR)</label>
                        <input type="number" class="form-control" id="editPrice" name="price" min="0" step="1000" value="0">
                        <small class="text-muted">Enter the webinar price (0 for free webinar)</small>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Webinar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Join Modal -->
<div class="modal fade" id="joinModal" tabindex="-1" aria-labelledby="joinModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="POST" enctype="multipart/form-data" id="joinForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="joinModalLabel">Konfirmasi Pendaftaran Webinar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <h6>Detail Webinar:</h6>
                        <p><strong id="joinWebinarTitle"></strong></p>
                        <p>Tanggal: <span id="joinWebinarDate"></span></p>
                        <p>Waktu: <span id="joinWebinarTime"></span></p>
                        <p>Harga: <span id="joinWebinarPrice"></span></p>
                    </div>

                    <div class="mb-3">
                        <label for="payment_proof" class="form-label required">Upload Bukti Pembayaran</label>
                        <input type="text" class="form-control" id="webinars" name="webinars" hidden>
                        <input type="file" class="form-control" id="payment_proof" name="payment_proof" required accept="image/*">
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
                    <button type="submit" class="btn btn-primary" id="submitBtn">Daftar Webinar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const webinarDetailsModal = document.getElementById('webinarDetailsModal');
        webinarDetailsModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const title = button.getAttribute('data-title');
            const description = button.getAttribute('data-description');
            const date = button.getAttribute('data-date');
            const time = button.getAttribute('data-time');
            const link = button.getAttribute('data-link');
            const price = button.getAttribute('data-price');

            const modalTitle = webinarDetailsModal.querySelector('#webinarTitle');
            const modalDescription = webinarDetailsModal.querySelector('#webinarDescription');
            const modalDate = webinarDetailsModal.querySelector('#webinarDate');
            const modalTime = webinarDetailsModal.querySelector('#webinarTime');
            const modalLink = webinarDetailsModal.querySelector('#webinarLink');
            const modalLinkContainer = webinarDetailsModal.querySelector('#webinarLinkContainer');
            const modalPrice = webinarDetailsModal.querySelector('#webinarPrice');

            modalTitle.textContent = title;
            modalDescription.textContent = description;
            modalDate.textContent = date;
            modalTime.textContent = time;

            if (link) {
                modalLink.href = link;
                modalLink.textContent = link;
                modalLinkContainer.style.display = 'block';
            } else {
                modalLinkContainer.style.display = 'none';
            }

            if (price) {
                modalPrice.textContent = price;
            } else {
                modalPrice.textContent = 'Free';
            }
        });

        const editWebinarModal = document.getElementById('editWebinarModal');
        editWebinarModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const title = button.getAttribute('data-title');
            const description = button.getAttribute('data-description');
            const date = button.getAttribute('data-date');
            const time = button.getAttribute('data-time');
            const link = button.getAttribute('data-link');
            const price = button.getAttribute('data-price');

            const modalTitle = editWebinarModal.querySelector('#editTitle');
            const modalDescription = editWebinarModal.querySelector('#editDescription');
            const modalDate = editWebinarModal.querySelector('#editDate');
            const modalTime = editWebinarModal.querySelector('#editTime');
            const modalLink = editWebinarModal.querySelector('#editLinkMeet');
            const form = editWebinarModal.querySelector('#editWebinarForm');
            const modalPrice = editWebinarModal.querySelector('#editPrice');

            modalTitle.value = title;
            modalDescription.value = description;
            modalDate.value = date;
            modalTime.value = time;
            modalLink.value = link || '';
            modalPrice.value = price || '0';

            form.action = `/webinars/${id}`;
        });

        // Join Webinar Modal
        const joinWebinarModal = document.getElementById('joinModal');
        joinWebinarModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const webinarId = button.getAttribute('data-id');
            const title = button.getAttribute('data-title');
            const date = button.getAttribute('data-date');
            const time = button.getAttribute('data-time');
            const price = button.getAttribute('data-price');

            const modalTitle = joinWebinarModal.querySelector('#joinWebinarTitle');
            const modalDate = joinWebinarModal.querySelector('#joinWebinarDate');
            const modalTime = joinWebinarModal.querySelector('#joinWebinarTime');
            const form = joinWebinarModal.querySelector('#joinForm');
            const modalPrice = joinWebinarModal.querySelector('#joinWebinarPrice');

            modalTitle.textContent = title;
            modalDate.textContent = date;
            modalTime.textContent = time;
            modalPrice.textContent = price;
            form.action = `/webinars/${webinarId}/join`;

            if (price) {
                modalPrice.textContent = price;
            } else {
                modalPrice.textContent = 'Free';
            }

            // Reset checkbox and button state
            const checkbox = document.getElementById('confirmAvailability');
            const submitBtn = document.getElementById('submitJoinBtn');
            checkbox.checked = false;
            submitBtn.disabled = true;
        });

        // Handle checkbox change
        document.getElementById('confirmAvailability').addEventListener('change', function(e) {
            document.getElementById('submitJoinBtn').disabled = !e.target.checked;
        });
    });
</script>
@endsection