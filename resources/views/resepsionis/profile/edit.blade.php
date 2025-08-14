@extends('layouts.adminlte')

@section('title', 'Edit Profil')

@section('content')
<div class="container-fluid px-4 py-3">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0 text-dark">
                    <i class="fas fa-user-edit me-2 text-primary"></i>Edit Profil
                </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('resepsionis.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('resepsionis.profile.show') }}">Profil</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row justify-content-start">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-dark">
                            <i class="fas fa-user-cog me-2 text-primary"></i>Form Edit Profil
                        </h4>
                        <a href="{{ route('resepsionis.profile.show') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('resepsionis.profile.update') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-user text-primary"></i>
                                    </span>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-envelope text-primary"></i>
                                    </span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4 gap-3">
                            <button type="reset" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-undo me-2"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-2"></i> Perbarui Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #FAF6F0; /* Cream hangat */
        color: #4E342E; /* Cokelat tua untuk teks utama */
    }

    .card {
        border-radius: 0.5rem;
        overflow: hidden;
        border: none;
        background-color: white;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    
    .card-header {
        background-color: #FAF6F0; /* Cream hangat */
        border-bottom: 1px solid #FFD700; /* Gold terang untuk aksen */
    }
    
    .form-control {
        border-radius: 0.375rem;
        padding: 0.375rem 0.75rem;
        border: 1px solid #C9A227; /* Gold modern */
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    
    .form-control:focus {
        border-color: #FFD700; /* Gold terang saat fokus */
        box-shadow: 0 0 0 0.25rem rgba(201, 162, 39, 0.25);
    }
    
    .input-group-text {
        background-color: #FAF6F0; /* Cream hangat */
        border-right: none;
        color: #C9A227; /* Gold modern */
    }
    
    .invalid-feedback {
        display: block;
        margin-top: 0.25rem;
        color: #B71C1C; /* merah elegan untuk error */
    }
    
    .text-primary {
        color: #C9A227 !important; /* Gold modern */
    }
    
    .btn-primary {
        background-color: #C9A227; /* Gold modern */
        border-color: #C9A227;
        color: white;
        font-weight: 600;
    }
    
    .btn-primary:hover {
        background-color: #FFD700; /* Gold terang */
        border-color: #FFD700;
        color: #3E2723; /* Dark brown */
    }
    
    .btn-outline-secondary {
        color: #4E342E; /* Cokelat tua */
        border-color: #4E342E;
    }
    
    .btn-outline-secondary:hover {
        background-color: #4E342E;
        color: white;
    }
</style>


<script>
// Form validation
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