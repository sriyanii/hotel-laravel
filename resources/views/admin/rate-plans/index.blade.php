@extends('layouts.adminlte')
@section('title', 'Rate Plans')

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
    
    .rateplan-type.promotion {
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
    
    /* Quick Stats Cards */
    .stats-card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: all 0.3s;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .stats-card:nth-child(2) {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }
    
    .stats-card:nth-child(3) {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    
    .stats-card:nth-child(4) {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    }
    
    .stats-card .card-body {
        padding: 1.5rem;
    }
    
    .stats-card h3 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .stats-card p {
        margin-bottom: 0;
        opacity: 0.9;
        font-size: 0.9rem;
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
    .single-line {
    white-space: nowrap;
}
</style>

<!-- Header -->
<div class="header d-flex justify-content-between align-items-center">
    <h2><i class="fas fa-calendar-day me-2"></i> Rate Plans Management</h2>

    <div class="user-menu">
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ auth()->user()->photo ? asset('image/' . auth()->user()->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" alt="User" class="rounded-circle" width="32" height="32">
                <span class="ms-2 d-none d-sm-inline">{{ auth()->user()->name }}</span>
            </a>

            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownUser">
                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-2"></i> Sign out
                    </a>
                    <!-- Hidden Logout Form -->
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>



<!-- Quick Stats -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
        <div class="rateplan-card card">
            <div class="card-body text-center">
                <h3 class="mb-2">{{ $stats['active_plans'] }}</h3>
                <p class="text-muted mb-0">Active Rate Plans</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
        <div class="rateplan-card card">
            <div class="card-body text-center">
                <h3 class="mb-2">{{ $stats['upcoming_plans'] }}</h3>
                <p class="text-muted mb-0">Upcoming Plans</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
        <div class="rateplan-card card">
            <div class="card-body text-center">
                <h3 class="mb-2">{{ $stats['seasonal_plans'] }}</h3>
                <p class="text-muted mb-0">Seasonal Plans</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="rateplan-card card">
            <div class="card-body text-center">
                <h3 class="mb-2">{{ $stats['revenue_increase'] }}%</h3>
                <p class="text-muted mb-0" style="white-space: nowrap;">Avg. Revenue Increase</p>
            </div>
        </div>
    </div>
</div>

<!-- Rate Plans Table -->
<div class="row">
    <div class="col-12">
        <div class="rateplan-card card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">All Rate Plans</h5>
                <div>
                    <button type="button" class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#createRatePlanModal">
                        <i class="fas fa-plus me-1"></i> Add Rate Plan
                    </button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('admin.rate-plans.index') }}">All Rate Plans</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.rate-plans.index', ['status' => 'active']) }}">Active Only</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.rate-plans.index', ['status' => 'upcoming']) }}">Upcoming</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.rate-plans.index', ['status' => 'expired']) }}">Expired</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('admin.rate-plans.index', ['type' => 'seasonal']) }}">Seasonal</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.rate-plans.index', ['type' => 'event']) }}">Event</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                @if(session('success'))
                    <div class="alert alert-success shadow-sm mb-0">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    </div>
                @endif

                @if($ratePlans->isEmpty())
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-percentage fa-3x mb-3 text-primary"></i>
                        <h5 class="text-dark">No rate plans found</h5>
                        <p class="mb-0">Click "Add Rate Plan" to create a new pricing strategy</p>
                    </div>
                @else
                    <div class="rateplan-table table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Plan Name</th>
                                    <th>Type</th>
                                    <th>Room Types</th>
                                    <th>Date Range</th>
                                    <th>Rate Adjustment</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ratePlans as $plan)
                                    <tr>
                                        <td>{{ $plan->name }}</td>
                                        <td>
                                            <span class="rateplan-type {{ $plan->type }}">
                                                {{ ucfirst($plan->type) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if (is_array($plan->room_types))
                                                @if (in_array('all', $plan->room_types) || (count($plan->room_types) === 1 && $plan->room_types[0] === 'all'))
                                                    All Rooms
                                                @else
                                                    {{ implode(', ', $plan->room_types) }}
                                                @endif
                                            @else
                                                {{ $plan->room_types == 'all' ? 'All Rooms' : ($plan->room_types ?? 'N/A') }}
                                            @endif
                                        </td>
                                        <td>
                                            <small>
                                                {{ \Carbon\Carbon::parse($plan->start_date)->format('d M Y') }} - 
                                                {{ \Carbon\Carbon::parse($plan->end_date)->format('d M Y') }}
                                            </small><br>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($plan->start_date)->diffInDays(\Carbon\Carbon::parse($plan->end_date)) + 1 }} days
                                            </small>
                                        </td>
                                        <td>
                                            {{ $plan->rate_adjustment_sign }}{{ $plan->rate_adjustment_value }}
                                            {{ $plan->rate_adjustment_type === 'percentage' ? '%' : 'IDR' }}
                                        </td>
                                        <td>
                                            <span class="status-badge {{ $plan->status }}">
                                                {{ ucfirst($plan->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <!-- Tombol Edit: buka modal dengan data -->
                                            <button type="button" class="btn btn-sm btn-outline-primary me-1 edit-btn"
                                                data-id="{{ $plan->id }}"
                                                data-name="{{ $plan->name }}"
                                                data-type="{{ $plan->type }}"
                                                data-start_date="{{ $plan->start_date }}"
                                                data-end_date="{{ $plan->end_date }}"
                                                data-room_types="{{ json_encode($plan->room_types) }}"
                                                data-rate_adjustment_sign="{{ $plan->rate_adjustment_sign }}"
                                                data-rate_adjustment_value="{{ $plan->rate_adjustment_value }}"
                                                data-rate_adjustment_type="{{ $plan->rate_adjustment_type }}"
                                                data-min_stay="{{ $plan->min_stay }}"
                                                data-release_days="{{ $plan->release_days }}"
                                                data-description="{{ $plan->description }}"
                                                data-is_active="{{ $plan->is_active ? '1' : '0' }}">
                                                Edit
                                            </button>
                                            <form action="{{ route('admin.rate-plans.destroy', $plan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this rate plan?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($ratePlans->hasPages())
                        <div class="p-3 border-top d-flex justify-content-end">
                            {{ $ratePlans->appends(request()->query())->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal: Create Rate Plan -->
<div class="modal fade" id="createRatePlanModal" tabindex="-1" aria-labelledby="createRatePlanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createRatePlanModalLabel">
                    <i class="fas fa-percentage me-2"></i> Create New Rate Plan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.rate-plans.store') }}" method="POST" id="ratePlanForm">
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
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cancel
                </button>
                <button type="submit" form="ratePlanForm" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Save Rate Plan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Edit Rate Plan -->
<div class="modal fade" id="editRatePlanModal" tabindex="-1" aria-labelledby="editRatePlanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRatePlanModalLabel">
                    <i class="fas fa-edit me-2"></i> Edit Rate Plan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editRatePlanForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="edit_plan_id" name="id">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_name" class="form-label">Plan Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_type" class="form-label">Plan Type</label>
                            <select class="form-select" id="edit_type" name="type" required>
                                <option value="seasonal">Seasonal</option>
                                <option value="event">Event</option>
                                <option value="promotion">Promotion</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="edit_start_date" name="start_date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="edit_end_date" name="end_date" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_room_types" class="form-label">Apply To Room Types</label>
                            <select class="form-select" id="edit_room_types" name="room_types[]" multiple required>
                                <option value="all">All Rooms</option>
                                @foreach($tipeKamarList as $tipe)
                                    <option value="{{ $tipe }}">{{ $tipe }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Rate Adjustment</label>
                            <div class="input-group">
                                <select class="form-select" name="rate_adjustment_sign" style="max-width: 80px;" required>
                                    <option value="+">+</option>
                                    <option value="-">-</option>
                                </select>
                                <input type="number" step="0.01" class="form-control" name="rate_adjustment_value" min="0" placeholder="0" required>
                                <span class="input-group-text">
                                    <select class="form-select border-0 bg-transparent" name="rate_adjustment_type" style="width: auto; padding: 0; height: auto;" required>
                                        <option value="percentage">%</option>
                                        <option value="fixed">IDR</option>
                                    </select>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_min_stay" class="form-label">Minimum Stay (nights)</label>
                            <input type="number" class="form-control" id="edit_min_stay" name="min_stay" min="1">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_release_days" class="form-label">Release Days</label>
                            <input type="number" class="form-control" id="edit_release_days" name="release_days" min="0">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="edit_is_active" name="is_active" value="1">
                        <label class="form-check-label" for="edit_is_active">Activate this plan immediately</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Rate Plan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Performance Analysis -->
<div class="row mt-4">
    <div class="col-lg-6">
        <div class="rateplan-card card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Rate Plan Performance</h5>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="performanceDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Last 6 Months
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="performanceDropdown">
                        <li><a class="dropdown-item" href="#">Last Month</a></li>
                        <li><a class="dropdown-item" href="#">Last 3 Months</a></li>
                        <li><a class="dropdown-item" href="#">Last 6 Months</a></li>
                        <li><a class="dropdown-item" href="#">This Year</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <canvas id="rateplanPerformanceChart" height="250"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="rateplan-card card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Revenue Impact</h5>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="revenueDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        By Plan Type
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="revenueDropdown">
                        <li><a class="dropdown-item" href="#">By Plan Type</a></li>
                        <li><a class="dropdown-item" href="#">By Room Type</a></li>
                        <li><a class="dropdown-item" href="#">By Season</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <canvas id="revenueImpactChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
@parent
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Handle Edit button click
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function () {
            const modal = document.getElementById('editRatePlanModal');
            const form = document.getElementById('editRatePlanForm');
            const planId = this.dataset.id;

            // Set form action
            form.action = `/admin/rate-plans/${planId}`;

            // Fill form fields
            document.getElementById('edit_plan_id').value = planId;
            document.getElementById('edit_name').value = this.dataset.name;
            document.getElementById('edit_type').value = this.dataset.type;
            document.getElementById('edit_start_date').value = this.dataset.start_date;
            document.getElementById('edit_end_date').value = this.dataset.end_date;
            document.getElementById('edit_min_stay').value = this.dataset.min_stay || 1;
            document.getElementById('edit_release_days').value = this.dataset.release_days || 0;
            document.getElementById('edit_description').value = this.dataset.description || '';

            // Handle is_active checkbox
            document.getElementById('edit_is_active').checked = this.dataset.is_active === '1';

            // Handle room_types (multiple select)
            const roomTypesSelect = document.getElementById('edit_room_types');
            const roomTypes = JSON.parse(this.dataset.room_types || '[]');
            for (let option of roomTypesSelect.options) {
                option.selected = roomTypes.includes(option.value);
            }

            // Set rate adjustment fields
            document.querySelector('[name="rate_adjustment_sign"]').value = this.dataset.rate_adjustment_sign;
            document.querySelector('[name="rate_adjustment_value"]').value = this.dataset.rate_adjustment_value;
            document.querySelector('[name="rate_adjustment_type"]').value = this.dataset.rate_adjustment_type;

            // Show modal
            const bootstrapModal = new bootstrap.Modal(modal);
            bootstrapModal.show();
        });
    });
});
</script>
@endsection