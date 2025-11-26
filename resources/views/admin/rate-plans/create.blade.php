@extends('layouts.adminlte')
@section('title', 'Create Rate Plan')

@section('content')

<style>
    :root {
        --primary: #4361ee;
        --secondary: #3f37c9;
        --dark: #1f2937;
        --light: #f9fafb;
        --success: #10b981;
        --danger: #ef4444;
        --warning: #f59e0b;
        --info: #3b82f6;
    }
    
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f5f7fb;
        color: var(--dark);
    }
    
    /* Sidebar */
    .sidebar {
        width: 280px;
        min-height: 100vh;
        background: linear-gradient(180deg, var(--primary), var(--secondary));
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        position: fixed;
        z-index: 100;
        transition: all 0.3s;
    }
    
    .sidebar-brand {
        padding: 1.5rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    
    .sidebar-brand h3 {
        color: white;
        font-weight: 700;
        margin-bottom: 0;
    }
    
    .sidebar-brand .logo-icon {
        font-size: 2rem;
        margin-right: 10px;
        color: #fff;
    }
    
    .nav-item {
        position: relative;
        margin: 5px 15px;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .nav-link {
        color: rgba(255,255,255,0.8);
        padding: 12px 15px;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .nav-link:hover, .nav-link.active {
        color: white;
        background-color: rgba(255,255,255,0.1);
    }
    
    .nav-link i {
        width: 24px;
        text-align: center;
        margin-right: 10px;
    }
    
    .nav-link .badge {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
    }
    
    /* Main Content */
    .main-content {
        margin-left: 280px;
        padding: 30px;
        transition: all 0.3s;
    }
    
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    
    .header h2 {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0;
    }
    
    .user-menu {
        display: flex;
        align-items: center;
    }
    
    .user-menu img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
        object-fit: cover;
    }
    
    /* Form Card */
    .form-card {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        padding: 24px;
        background: white;
        margin-bottom: 24px;
    }

    /* Input Group Styling */
    .input-group {
        display: flex;
        align-items: stretch;
    }

    .input-group > .form-select,
    .input-group > .form-control,
    .input-group > .input-group-text {
        border-radius: 0;
    }

    .input-group > .form-select:first-child,
    .input-group > .form-control:first-child {
        border-top-left-radius: 0.375rem;
        border-bottom-left-radius: 0.375rem;
    }

    .input-group > .input-group-text:last-child {
        border-top-right-radius: 0.375rem;
        border-bottom-right-radius: 0.375rem;
    }

    @media (max-width: 992px) {
        .sidebar {
            margin-left: -280px;
        }
        .sidebar.active {
            margin-left: 0;
        }
        .main-content {
            margin-left: 0;
        }
    }
    
    @media (max-width: 768px) {
        .main-content {
            padding: 20px 15px;
        }
        .header h2 {
            font-size: 1.5rem;
        }
    }
</style>

<div class="header">
    <h2><i class="fas fa-percentage me-2"></i> Create New Rate Plan</h2>
    <div class="user-menu">
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ auth()->user()->photo ? asset('image/' . auth()->user()->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}">
                <span class="ms-2 d-none d-sm-inline">{{ auth()->user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownUser">
                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="fas fa-sign-out-alt me-2"></i> Sign out
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="form-card">
            <form action="{{ route('admin.rate-plans.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Plan Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="type" class="form-label">Plan Type</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="">Select Type</option>
                            <option value="seasonal" {{ old('type') == 'seasonal' ? 'selected' : '' }}>Seasonal</option>
                            <option value="event" {{ old('type') == 'event' ? 'selected' : '' }}>Event</option>
                            <option value="promotion" {{ old('type') == 'promotion' ? 'selected' : '' }}>Promotion</option>
                        </select>
                        @error('type')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                        @error('start_date')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                        @error('end_date')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="room_types" class="form-label">Apply To Room Types</label>
                        <select class="form-select" id="room_types" name="room_types[]" multiple required>
                            <option value="all" {{ in_array('all', old('room_types', [])) ? 'selected' : '' }}>All Rooms</option>
                            @foreach($tipeKamarList as $tipe)
                                <option value="{{ $tipe }}" {{ in_array($tipe, old('room_types', [])) ? 'selected' : '' }}>
                                    {{ $tipe }}
                                </option>
                            @endforeach
                        </select>
                        @error('room_types')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Rate Adjustment</label>
                        <div class="input-group">
                            <select class="form-select" name="rate_adjustment_sign" style="max-width: 80px;" required>
                                <option value="+" {{ old('rate_adjustment_sign', '+') == '+' ? 'selected' : '' }}>+</option>
                                <option value="-" {{ old('rate_adjustment_sign') == '-' ? 'selected' : '' }}>-</option>
                            </select>
                            <input type="number" step="0.01" class="form-control" name="rate_adjustment_value" 
                                   value="{{ old('rate_adjustment_value') }}" min="0" placeholder="0" required>
                            <span class="input-group-text">
                                <select class="form-select border-0 bg-transparent" name="rate_adjustment_type" style="width: auto; padding: 0; height: auto;" required>
                                    <option value="percentage" {{ old('rate_adjustment_type', 'percentage') == 'percentage' ? 'selected' : '' }}>%</option>
                                    <option value="fixed" {{ old('rate_adjustment_type') == 'fixed' ? 'selected' : '' }}>IDR</option>
                                </select>
                            </span>
                        </div>
                        @error('rate_adjustment_sign')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                        @error('rate_adjustment_value')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                        @error('rate_adjustment_type')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="min_stay" class="form-label">Minimum Stay (nights)</label>
                        <input type="number" class="form-control" id="min_stay" name="min_stay" min="1" value="{{ old('min_stay', 1) }}">
                        @error('min_stay')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="release_days" class="form-label">Release Days (prior to arrival)</label>
                        <input type="number" class="form-control" id="release_days" name="release_days" min="0" value="{{ old('release_days', 0) }}">
                        @error('release_days')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Activate this plan immediately</label>
                    @error('is_active')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.rate-plans.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Save Rate Plan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection