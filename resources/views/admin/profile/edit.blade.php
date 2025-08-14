@extends('layouts.adminlte')

@section('title', 'Edit Profil')

@section('content')
<div class="container-fluid px-0" style="background-color: #FAF6F0; min-height: 100vh;">
    <div class="row no-gutters">
        <div class="col-12">
            <div class="card border-0 shadow-none">
                <div class="card-header text-white py-3 px-4" style="background: linear-gradient(135deg, #C9A227, #FFD700);">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0"><i class="fas fa-user-edit mr-2"></i>Edit Profil</h3>
                        <a href="{{ route('admin.profile.show') }}" class="btn btn-outline-light btn-sm rounded-circle">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <form method="POST" action="{{ route('admin.profile.update') }}" class="needs-validation" novalidate>
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="name" class="form-label" style="color: #4E342E;">Nama Lengkap</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user" style="color: #C9A227;"></i></span>
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   name="name" value="{{ old('name', auth()->user()->name) }}" required autocomplete="name">
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label for="email" class="form-label" style="color: #4E342E;">Alamat Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope" style="color: #C9A227;"></i></span>
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                                   name="email" value="{{ old('email', auth()->user()->email) }}" required autocomplete="email">
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="phone" class="form-label" style="color: #4E342E;">Nomor Telepon</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-phone" style="color: #C9A227;"></i></span>
                                            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" 
                                                   name="phone" value="{{ old('phone', auth()->user()->phone) }}" autocomplete="phone">
                                            @error('phone')
                                                <div class="invalid-feedback">
                                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label for="address" class="form-label" style="color: #4E342E;">Alamat</label>
                                        <div class="input-group">
                                            <span class="input-group-text align-items-start pt-2"><i class="fas fa-map-marker-alt" style="color: #C9A227;"></i></span>
                                            <textarea id="address" class="form-control @error('address') is-invalid @enderror" 
                                                      name="address" rows="1" autocomplete="address">{{ old('address', auth()->user()->address) }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">
                                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-4">
                                    <button type="submit" class="btn rounded-pill py-2 px-4 shadow-sm" 
                                            style="background: linear-gradient(to right, #C9A227, #FFD700); color: #3E2723; font-weight: 500; border: none;">
                                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #FAF6F0;
    }

    .input-group-text {
        background-color: #FFF8E1;
        border-radius: 8px 0 0 8px;
        border: 1px solid #FFD700;
    }

    .form-control {
        border-radius: 8px;
        padding: 10px 15px;
        border: 1px solid #E0E0E0;
        transition: all 0.3s;
    }
    .form-control:focus {
        border-color: #C9A227;
        box-shadow: 0 0 0 0.2rem rgba(201, 162, 39, 0.25);
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(201, 162, 39, 0.4);
    }

    .invalid-feedback {
        display: block;
        margin-top: 5px;
    }
</style>

<script>
(function () {
  'use strict'
  var forms = document.querySelectorAll('.needs-validation')
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }
        form.classList.add('was-validated')
      }, false)
    })
})()
</script>
@endsection
