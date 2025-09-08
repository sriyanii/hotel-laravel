@extends('layouts.adminlte')

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Kembali Button -->
        <div class="col-12 mb-3">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>

        <!-- Profile Section -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <!-- Display Profile Picture or Initials -->
                        @if($user->photo)
                            <img class="profile-user-img img-fluid img-circle" src="{{ asset('imge/' . $user->photo) }}" alt="Foto profil" style="width: 120px; height: 120px;">
                        @else
                            <div class="profile-user-img img-fluid img-circle bg-primary d-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                                <span class="display-4 text-white">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            </div>
                        @endif
                    </div>
                    <h4 class="mb-2">{{ $user->name }}</h4>
                    <p class="text-muted">
                        @if($user->role == 'admin')
                            <span class="badge badge-danger">Administrator</span>
                        @else
                            <span class="badge badge-info">Resepsionis</span>
                        @endif
                    </p>
                    <ul class="list-unstyled mt-3">
                        <li><strong>Email:</strong> {{ $user->email }}</li>
                        <li><strong>Telepon:</strong> {{ $user->phone ?? '-' }}</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Password Section -->
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Password</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="inputPassword">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="inputPassword" value="********" readonly>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fa fa-eye"></i> Tampilkan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Info Section -->
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Informasi Pengguna</h5>
                    @if(auth()->user()->id == $user->id || auth()->user()->role == 'admin')
                        <a href="{{ url('/admin/users/' . $user->id . '/edit') }}" class="btn btn-sm btn-primary">Edit</a>
                    @endif
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="inputName">Nama Lengkap</label>
                        <input type="text" class="form-control" id="inputName" value="{{ $user->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail">Email</label>
                        <input type="email" class="form-control" id="inputEmail" value="{{ $user->email }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="inputPhone">Telepon</label>
                        <input type="text" class="form-control" id="inputPhone" value="{{ $user->phone ?? '-' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Alamat</label>
                        <textarea class="form-control" id="inputAddress" readonly rows="3">{{ $user->address ?? '-' }}</textarea>
                    </div>
                    <!-- <div class="form-group">
                        <label for="inputVerified">Email Terverifikasi</label>
                        <input type="text" class="form-control" id="inputVerified" value="{{ $user->email_verified_at ? $user->email_verified_at->format('d M Y H:i') : 'Belum diverifikasi' }}" readonly>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Toggle untuk melihat password
        $('#togglePassword').click(function() {
            const passwordField = $('#inputPassword');
            const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
            passwordField.attr('type', type);
            $(this).find('i').toggleClass('fa-eye fa-eye-slash');
            
            if (type === 'text') {
                passwordField.val('{{ $user->password_plain ?? "Tidak tersedia" }}');
            } else {
                passwordField.val('********');
            }
        });
    });
</script>
@endsection
