@extends('layouts.adminlte')
@section('title', 'Edit Rate Plan')

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
        
        /* Rate Plan Cards */
        .rateplan-card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 24px;
            transition: all 0.3s;
        }
        
        .rateplan-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .rateplan-card .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 15px 20px;
            border-radius: 12px 12px 0 0 !important;
        }
        
        .rateplan-card .card-title {
            font-weight: 600;
            margin-bottom: 0;
            color: var(--dark);
        }
        
        /* Rate Plan Type Badge */
        .rateplan-type {
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .rateplan-type.seasonal {
            background-color: #eff6ff;
            color: var(--primary);
        }
        
        .rateplan-type.event {
            background-color: #ecfdf5;
            color: var(--success);
        }
        
        .rateplan-type.promo {
            background-color: #fef2f2;
            color: var(--danger);
        }
        
        /* Status Badge */
        .status-badge {
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .status-badge.active {
            background-color: #ecfdf5;
            color: var(--success);
        }
        
        .status-badge.upcoming {
            background-color: #fffbeb;
            color: var(--warning);
        }
        
        .status-badge.expired {
            background-color: #f3f4f6;
            color: #6b7280;
        }
        
        /* Rate Plan Table */
        .rateplan-table {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        
        .rateplan-table .table {
            margin-bottom: 0;
        }
        
        .rateplan-table .table thead th {
            background-color: #f9fafb;
            color: #6b7280;
            font-weight: 600;
            padding: 15px 20px;
            border-bottom: none;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }
        
        .rateplan-table .table tbody td {
            padding: 15px 20px;
            vertical-align: middle;
            border-top: 1px solid #f3f4f6;
        }
        
        /* Responsive */
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
    <h2><i class="fas fa-percentage me-2"></i> Edit Rate Plan</h2>
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
            <form action="{{ route('admin.rate-plans.update', $ratePlan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Plan Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $ratePlan->name) }}" required>
                        @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="type" class="form-label">Plan Type</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="">Select Type</option>
                            <option value="seasonal" {{ (old('type') ?? $ratePlan->type) == 'seasonal' ? 'selected' : '' }}>Seasonal</option>
                            <option value="event" {{ (old('type') ?? $ratePlan->type) == 'event' ? 'selected' : '' }}>Event</option>
                        </select>
                        @error('type')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', \Carbon\Carbon::parse($ratePlan->start_date)->format('Y-m-d')) }}" required>
                        @error('start_date')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date', \Carbon\Carbon::parse($ratePlan->end_date)->format('Y-m-d')) }}" required>
                        @error('end_date')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="room_types" class="form-label">Room Types</label>
                        <select class="form-select" id="room_types" name="room_types[]" multiple required>
                            <option value="all" {{ in_array('all', old('room_types', is_array($ratePlan->room_types) ? $ratePlan->room_types : explode(',', $ratePlan->room_types))) ? 'selected' : '' }}>
                                All Rooms
                            </option>
                            @foreach($tipeKamarList as $tipe)
                                <option value="{{ $tipe }}" 
                                    {{ in_array($tipe, old('room_types', is_array($ratePlan->room_types) ? $ratePlan->room_types : explode(',', $ratePlan->room_types))) ? 'selected' : '' }}>
                                    {{ $tipe }}
                                </option>
                            @endforeach
                        </select>
                        @error('room_types')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="rate_adjustment" class="form-label">Rate Adjustment</label>
                        <input type="text" class="form-control" id="rate_adjustment" name="rate_adjustment" 
                               value="{{ old('rate_adjustment', $ratePlan->rate_adjustment) }}" 
                               placeholder="+15% or -50000" 
                               required>
                        <div class="form-text">Format: <code>+15%</code>, <code>-10%</code>, atau nilai tetap seperti <code>500000</code></div>
                        @error('rate_adjustment')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.rate-plans.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Update Rate Plan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection