@extends('layouts.adminlte')

@section('title', 'Guest Management')

@section('content')
@php
    $prefix = 'resepsionis';
@endphp

<!-- Header -->
<div class="header">
    <h2><i class="fas fa-users me-2"></i> Guest Management</h2>
    <div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newGuestModal">
            <i class="fas fa-plus-circle me-2"></i> New Guest
        </button>
    </div>
</div>

<!-- Guest Stats -->
<div class="row">
    <div class="col-md-3">
        <div class="stats-card">
            <div class="count">{{ $totalGuests ?? 0 }}</div>
            <div class="label">Total Guests</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="count" style="color: var(--success);">{{ $currentGuests ?? 0 }}</div>
            <div class="label">Currently Checked In</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="count" style="color: var(--danger);">{{ $checkedOutToday ?? 0 }}</div>
            <div class="label">Checked Out Today</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="count" style="color: var(--warning);">{{ $vipGuests ?? 0 }}</div>
            <div class="label">VIP Guests</div>
        </div>
    </div>
</div>

<!-- Guest List -->
<div class="guest-card">
    <ul class="nav nav-tabs guest-tabs" id="guestTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="current-tab" data-bs-toggle="tab" data-bs-target="#current" type="button" role="tab">Current Guests <span class="badge bg-success ms-2">{{ $currentGuests ?? 0 }}</span></button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="today-tab" data-bs-toggle="tab" data-bs-target="#today" type="button" role="tab">Today's Check Outs <span class="badge bg-danger ms-2">{{ $checkedOutToday ?? 0 }}</span></button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="vip-tab" data-bs-toggle="tab" data-bs-target="#vip" type="button" role="tab">VIP Guests <span class="badge bg-warning ms-2">{{ $vipGuests ?? 0 }}</span></button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">All Guests</button>
        </li>
    </ul>
    
    <div class="tab-content mt-4">
        <!-- Current Guests Tab -->
        <div class="tab-pane fade show active" id="current" role="tabpanel">
            <div class="guest-search">
                <i class="fas fa-search"></i>
                <input type="text" class="form-control search-current" placeholder="Search current guests by name or phone...">
            </div>
            
            @if ($currentGuestsList->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="fas fa-user-clock fa-3x mb-3 opacity-50"></i>
                    <h5>No Current Guests</h5>
                    <p>There are no guests currently checked in.</p>
                </div>
            @else
                <div class="guest-list">
                    @foreach ($currentGuestsList as $guest)
                    <div class="guest-item">
                        @if($guest->photo)
                            <img src="{{ asset('storage/guests/' . $guest->photo) }}" alt="Guest" class="guest-avatar">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($guest->name) }}&background=3a86ff&color=fff" alt="Guest" class="guest-avatar">
                        @endif
                        <div class="guest-info">
                            <h6 class="mb-1 guest-name">{{ $guest->name }}</h6>
                            <p class="text-muted mb-1">{{ $guest->phone }}</p>
                            <p class="mb-0"><small>ID: {{ $guest->identity_number }}</small></p>
                        </div>
                        <span class="guest-status status-current {{ in_array($guest->guest_type, ['vip', 'vvip']) ? 'status-vip' : '' }}">
                            {{ in_array($guest->guest_type, ['vip', 'vvip']) ? strtoupper($guest->guest_type) : 'Current' }}
                        </span>
                        <button class="btn btn-sm btn-outline-primary ms-3 view-guest"
                                data-guest-id="{{ $guest->id }}"
                                data-bs-toggle="modal"
                                data-bs-target="#guestModal">
                            View
                        </button>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
        
        <!-- Today's Check Outs Tab -->
        <div class="tab-pane fade" id="today" role="tabpanel">
            <div class="guest-search">
                <i class="fas fa-search"></i>
                <input type="text" class="form-control search-today" placeholder="Search check-outs by name or phone...">
            </div>
            
            @if ($checkOutTodayList->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="fas fa-sign-out-alt fa-3x mb-3 opacity-50"></i>
                    <h5>No Check Outs Today</h5>
                    <p>There are no guests checking out today.</p>
                </div>
            @else
                <div class="guest-list">
                    @foreach ($checkOutTodayList as $guest)
                    <div class="guest-item">
                        @if($guest->photo)
                            <img src="{{ asset('storage/guests/' . $guest->photo) }}" alt="Guest" class="guest-avatar">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($guest->name) }}&background=ef4444&color=fff" alt="Guest" class="guest-avatar">
                        @endif
                        <div class="guest-info">
                            <h6 class="mb-1 guest-name">{{ $guest->name }}</h6>
                            <p class="text-muted mb-1">{{ $guest->phone }}</p>
                            <p class="mb-0"><small>ID: {{ $guest->identity_number }}</small></p>
                        </div>
                        <span class="guest-status status-checkedout">Checking Out</span>
                        <button class="btn btn-sm btn-outline-primary ms-3 view-guest"
                                data-guest-id="{{ $guest->id }}"
                                data-bs-toggle="modal"
                                data-bs-target="#guestModal">
                            View
                        </button>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
        
        <!-- VIP Guests Tab -->
        <div class="tab-pane fade" id="vip" role="tabpanel">
            <div class="guest-search">
                <i class="fas fa-search"></i>
                <input type="text" class="form-control search-vip" placeholder="Search VIP guests...">
            </div>
            
            @if ($vipGuestsList->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="fas fa-crown fa-3x mb-3 opacity-50"></i>
                    <h5>No VIP Guests</h5>
                    <p>There are no VIP guests in the system.</p>
                </div>
            @else
                <div class="guest-list">
                    @foreach ($vipGuestsList as $guest)
                    <div class="guest-item">
                        @if($guest->photo)
                            <img src="{{ asset('storage/guests/' . $guest->photo) }}" alt="Guest" class="guest-avatar">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($guest->name) }}&background=f59e0b&color=fff" alt="Guest" class="guest-avatar">
                        @endif
                        <div class="guest-info">
                            <h6 class="mb-1 guest-name">{{ $guest->name }}</h6>
                            <p class="text-muted mb-1">{{ $guest->phone }}</p>
                            <p class="mb-0"><small>ID: {{ $guest->identity_number }}</small></p>
                        </div>
                        <span class="guest-status status-vip">{{ strtoupper($guest->guest_type) }}</span>
                        <button class="btn btn-sm btn-outline-primary ms-3 view-guest"
                                data-guest-id="{{ $guest->id }}"
                                data-bs-toggle="modal"
                                data-bs-target="#guestModal">
                            View
                        </button>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
        
        <!-- All Guests Tab -->
        <div class="tab-pane fade" id="all" role="tabpanel">
            <div class="guest-search">
                <i class="fas fa-search"></i>
                <input type="text" class="form-control search-all" placeholder="Search all guests...">
            </div>
            
            @if ($guests->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="fas fa-users fa-3x mb-3 opacity-50"></i>
                    <h5>No Guests Found</h5>
                    <p>There are no guests in the system yet.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover guest-table">
                        <thead>
                            <tr>
                                <th>Guest</th>
                                <th>Contact</th>
                                <th>ID Number</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($guests as $guest)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($guest->photo)
                                            <img src="{{ asset('storage/guests/' . $guest->photo) }}" alt="Guest" class="guest-avatar me-3">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($guest->name) }}&background=6b7280&color=fff" alt="Guest" class="guest-avatar me-3">
                                        @endif
                                        <div>
                                            <div class="guest-name">{{ $guest->name }}</div>
                                            <small class="text-muted">{{ $guest->guest_code }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>{{ $guest->phone }}</div>
                                    @if($guest->email)
                                        <small class="text-muted">{{ $guest->email }}</small>
                                    @endif
                                </td>
                                <td>{{ $guest->identity_number }}</td>
                                <td>
                                    @if(in_array($guest->guest_type, ['vip', 'vvip']))
                                        <span class="guest-status status-vip">{{ strtoupper($guest->guest_type) }}</span>
                                    @else
                                        <span class="guest-status status-current">{{ ucfirst($guest->guest_type) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary view-guest"
                                            data-guest-id="{{ $guest->id }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#guestModal">
                                        View
                                    </button>
                                    <a href="{{ route($prefix . '.guests.edit', $guest->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($guests->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Showing {{ $guests->firstItem() }} to {{ $guests->lastItem() }} of {{ $guests->total() }} results
                        </div>
                        <div>
                            {{ $guests->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>

<!-- Guest Details Modal -->
<div class="modal fade guest-modal" id="guestModal" tabindex="-1" aria-labelledby="guestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="guestModalLabel">Guest Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img id="modal-guest-photo" src="" alt="Guest" class="img-fluid rounded mb-3" style="max-height: 200px;">
                        
                        <div class="d-flex justify-content-center mb-3" id="modal-guest-badges">
                            <!-- Badges will be loaded here -->
                        </div>
                        
                        <h4 id="modal-guest-name">Loading...</h4>
                        <p class="text-muted" id="modal-guest-membership">Loading...</p>
                        
                        <ul class="guest-details">
                            <li>
                                <span class="label">Guest Code:</span>
                                <span class="value" id="modal-guest-code">-</span>
                            </li>
                            <li>
                                <span class="label">Phone:</span>
                                <span class="value" id="modal-phone">-</span>
                            </li>
                            <li>
                                <span class="label">Email:</span>
                                <span class="value" id="modal-email">-</span>
                            </li>
                            <li>
                                <span class="label">ID Number:</span>
                                <span class="value" id="modal-identity">-</span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-8">
                        <ul class="nav nav-tabs" id="guestDetailTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">Profile</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab">Stay History</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="preferences-tab" data-bs-toggle="tab" data-bs-target="#preferences" type="button" role="tab">Preferences</button>
                            </li>
                        </ul>
                        
                        <div class="tab-content mt-4">
                            <!-- Profile Tab -->
                            <div class="tab-pane fade show active" id="profile" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Personal Information</h6>
                                        <ul class="guest-details">
                                            <li>
                                                <span class="label">Full Name:</span>
                                                <span class="value" id="modal-full-name">-</span>
                                            </li>
                                            <li>
                                                <span class="label">Date of Birth:</span>
                                                <span class="value" id="modal-dob">-</span>
                                            </li>
                                            <li>
                                                <span class="label">Gender:</span>
                                                <span class="value" id="modal-gender">-</span>
                                            </li>
                                            <li>
                                                <span class="label">Nationality:</span>
                                                <span class="value" id="modal-nationality">-</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Additional Information</h6>
                                        <ul class="guest-details">
                                            <li>
                                                <span class="label">Profession:</span>
                                                <span class="value" id="modal-profession">-</span>
                                            </li>
                                            <li>
                                                <span class="label">Company:</span>
                                                <span class="value" id="modal-company">-</span>
                                            </li>
                                            <li>
                                                <span class="label">Marital Status:</span>
                                                <span class="value" id="modal-marital-status">-</span>
                                            </li>
                                            <li>
                                                <span class="label">Guest Type:</span>
                                                <span class="value" id="modal-guest-type">-</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <h6>Address</h6>
                                        <p id="modal-address">-</p>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <h6>Notes</h6>
                                        <p id="modal-notes">No notes available</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- History Tab -->
                            <div class="tab-pane fade" id="history" role="tabpanel">
                                <h5>Stay History</h5>
                                <div id="modal-history">
                                    <div class="text-center text-muted py-4">
                                        <i class="fas fa-history fa-2x mb-2 opacity-50"></i>
                                        <p>No stay history available</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Preferences Tab -->
                            <div class="tab-pane fade" id="preferences" role="tabpanel">
                                <h5>Guest Preferences</h5>
                                <div id="modal-preferences">
                                    <div class="text-center text-muted py-4">
                                        <i class="fas fa-star fa-2x mb-2 opacity-50"></i>
                                        <p>No preferences set</p>
                                    </div>
                                </div>
                                
                                <h5 class="mt-4">Health Notes</h5>
                                <p id="modal-health-notes">No health notes</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="#" id="modal-edit-btn" class="btn btn-primary">Edit Profile</a>
            </div>
        </div>
    </div>
</div>

<!-- New Guest Modal -->
<div class="modal fade guest-modal" id="newGuestModal" tabindex="-1" aria-labelledby="newGuestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newGuestModalLabel"><i class="fas fa-user-plus me-2"></i> New Guest Registration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('resepsionis.guests.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <div class="form-section">
                        <h5><i class="fas fa-user-circle me-2"></i> Personal Information</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">First Name *</label>
                                <input type="text" name="first_name" class="form-control" placeholder="Enter first name" required value="{{ old('first_name') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control" placeholder="Enter last name" value="{{ old('last_name') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">ID/Passport Number *</label>
                                <input type="text" name="identity_number" class="form-control" placeholder="Enter ID/Passport number" required value="{{ old('identity_number') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nationality</label>
                                <input type="text" name="nationality" class="form-control" placeholder="Enter nationality" value="{{ old('nationality') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-select">
                                    <option value="">Select gender</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h5><i class="fas fa-address-card me-2"></i> Contact Information</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone Number *</label>
                                <input type="tel" name="phone" class="form-control" placeholder="Enter phone number" required value="{{ old('phone') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter email" value="{{ old('email') }}">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control" rows="2" placeholder="Enter full address">{{ old('address') }}</textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" name="city" class="form-control" placeholder="Enter city" value="{{ old('city') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Country</label>
                                <input type="text" name="country" class="form-control" placeholder="Enter country" value="{{ old('country') }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h5><i class="fas fa-suitcase me-2"></i> Additional Information</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Profession</label>
                                <input type="text" name="profession" class="form-control" placeholder="Enter profession" value="{{ old('profession') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Company</label>
                                <input type="text" name="company" class="form-control" placeholder="Enter company name" value="{{ old('company') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Guest Type *</label>
                                <select name="guest_type" class="form-select" required>
                                    <option value="">Select guest type</option>
                                    <option value="reguler" {{ old('guest_type') == 'reguler' ? 'selected' : '' }}>Regular</option>
                                    <option value="vip" {{ old('guest_type') == 'vip' ? 'selected' : '' }}>VIP</option>
                                    <option value="vvip" {{ old('guest_type') == 'vvip' ? 'selected' : '' }}>VVIP</option>
                                    <option value="corporate" {{ old('guest_type') == 'corporate' ? 'selected' : '' }}>Corporate</option>
                                    <option value="staff" {{ old('guest_type') == 'staff' ? 'selected' : '' }}>Staff</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Marital Status</label>
                                <select name="marital_status" class="form-select">
                                    <option value="">Select marital status</option>
                                    <option value="single" {{ old('marital_status') == 'single' ? 'selected' : '' }}>Single</option>
                                    <option value="married" {{ old('marital_status') == 'married' ? 'selected' : '' }}>Married</option>
                                    <option value="divorced" {{ old('marital_status') == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                    <option value="widowed" {{ old('marital_status') == 'widowed' ? 'selected' : '' }}>Widowed</option>
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Social Account</label>
                                <input type="text" name="social_account" class="form-control" placeholder="Enter social media account" value="{{ old('social_account') }}">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Special Requests & Notes</label>
                                <textarea name="notes" class="form-control" rows="2" placeholder="Any special requests?">{{ old('notes') }}</textarea>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Health Notes</label>
                                <textarea name="health_notes" class="form-control" rows="2" placeholder="Any health concerns?">{{ old('health_notes') }}</textarea>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Profile Photo</label>
                                <input type="file" name="photo" class="form-control" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Guest</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
:root {
    --primary: #3a86ff;
    --secondary: #2667cc;
    --dark: #1f2937;
    --light: #f9fafb;
    --success: #10b981;
    --danger: #ef4444;
    --warning: #f59e0b;
    --info: #3b82f6;
}

/* Font Family */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Guest Cards */
.guest-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    padding: 20px;
    margin-bottom: 30px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Guest Tabs */
.guest-tabs .nav-link {
    color: var(--dark);
    border: none;
    padding: 10px 20px;
    font-weight: 500;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.guest-tabs .nav-link.active {
    color: var(--primary);
    border-bottom: 3px solid var(--primary);
    background: transparent;
}

/* Guest Search */
.guest-search {
    position: relative;
    margin-bottom: 20px;
}

.guest-search input {
    padding-left: 40px;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.guest-search i {
    position: absolute;
    left: 15px;
    top: 12px;
    color: #9ca3af;
}

/* Guest List */
.guest-list {
    max-height: 600px;
    overflow-y: auto;
}

.guest-item {
    display: flex;
    align-items: center;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 10px;
    background-color: #f9fafb;
    transition: all 0.3s;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.guest-item:hover {
    background-color: #f3f4f6;
    transform: translateX(5px);
}

.guest-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 15px;
}

.guest-info {
    flex: 1;
}

/* Remove bold from guest names */
.guest-name {
    font-weight: normal !important;
    font-size: 16px;
    color: #1f2937;
    margin-bottom: 4px;
}

.guest-status {
    font-size: 12px;
    padding: 4px 10px;
    border-radius: 20px;
    font-weight: 500;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.status-current {
    background-color: #d1fae5;
    color: #065f46;
}

.status-checkedout {
    background-color: #fee2e2;
    color: #991b1b;
}

.status-vip {
    background-color: #fef3c7;
    color: #92400e;
}

/* Guest Details Modal */
.guest-modal .modal-header {
    border-bottom: none;
    padding-bottom: 0;
}

.guest-modal .modal-footer {
    border-top: none;
    padding-top: 0;
}

.guest-details {
    list-style: none;
    padding: 0;
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.guest-details li {
    padding: 10px 0;
    border-bottom: 1px solid #f3f4f6;
    display: flex;
}

.guest-details li:last-child {
    border-bottom: none;
}

.guest-details .label {
    width: 120px;
    color: #6b7280;
    font-weight: 500;
}

.guest-details .value {
    flex: 1;
    font-weight: normal;
}

/* Stats Cards */
.stats-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    margin-bottom: 20px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.stats-card .count {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 5px;
}

.stats-card .label {
    color: #6b7280;
    font-size: 14px;
}

/* New Guest Form */
.form-section {
    background: white;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.form-section h5 {
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid #f3f4f6;
    color: var(--primary);
}

/* Table Styles */
.guest-table {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.guest-table th {
    font-weight: 600;
    color: #374151;
    border-bottom: 2px solid #e5e7eb;
    padding: 12px 8px;
    font-size: 14px;
}

.guest-table td {
    padding: 12px 8px;
    vertical-align: middle;
    border-bottom: 1px solid #f3f4f6;
}

.guest-table .guest-name {
    font-weight: normal;
    color: #1f2937;
    font-size: 15px;
}

/* Modal Styles */
.modal-title {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    font-weight: 600;
}

.modal-body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Button Styles */
.btn {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    font-weight: 500;
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Guest management script loaded');

    // Search functionality
    const initSearch = (inputClass, tabId) => {
        const input = document.querySelector(`.${inputClass}`);
        if (!input) return;
        
        input.addEventListener('input', function() {
            const term = this.value.toLowerCase();
            const items = document.querySelectorAll(`${tabId} .guest-item, ${tabId} tbody tr`);
            
            items.forEach(item => {
                const name = item.querySelector('.guest-name')?.textContent.toLowerCase() || '';
                const phone = item.querySelector('.text-muted')?.textContent.toLowerCase() || '';
                const identity = item.querySelector('small')?.textContent.toLowerCase() || '';
                
                const shouldShow = name.includes(term) || phone.includes(term) || identity.includes(term);
                item.style.display = shouldShow ? '' : 'none';
            });
        });
    };

    initSearch('search-current', '#current');
    initSearch('search-today', '#today');
    initSearch('search-vip', '#vip');
    initSearch('search-all', '#all');

    // Guest detail modal functionality - FIXED VERSION
    document.querySelectorAll('.view-guest').forEach(btn => {
        btn.addEventListener('click', async function() {
            const guestId = this.dataset.guestId;
            console.log('Loading guest ID:', guestId);
            
            // Show loading state
            showLoadingState();
            
            try {
                // Determine current user role and build correct URL
                const currentPath = window.location.pathname;
                let baseUrl = '/resepsionis'; // default
                
                if (currentPath.includes('/admin/')) {
                    baseUrl = '/admin';
                }
                
                // Try the details endpoint first
                const response = await fetch(`${baseUrl}/guests/${guestId}/details`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const guest = await response.json();
                console.log('Guest data loaded:', guest);
                
                // Update modal with actual data
                updateModalWithGuestData(guest, guestId, baseUrl);
                
            } catch (error) {
                console.error('Error loading guest details:', error);
                // Try fallback method
                tryFallbackData(guestId);
            }
        });
    });

    // Function to show loading state
    function showLoadingState() {
        document.getElementById('modal-guest-name').textContent = 'Loading...';
        document.getElementById('modal-guest-membership').textContent = 'Please wait...';
        document.getElementById('modal-guest-code').textContent = '-';
        document.getElementById('modal-phone').textContent = '-';
        document.getElementById('modal-email').textContent = '-';
        document.getElementById('modal-identity').textContent = '-';
        
        // Clear profile data
        document.getElementById('modal-full-name').textContent = '-';
        document.getElementById('modal-dob').textContent = '-';
        document.getElementById('modal-gender').textContent = '-';
        document.getElementById('modal-nationality').textContent = '-';
        document.getElementById('modal-profession').textContent = '-';
        document.getElementById('modal-company').textContent = '-';
        document.getElementById('modal-marital-status').textContent = '-';
        document.getElementById('modal-guest-type').textContent = '-';
        document.getElementById('modal-address').textContent = '-';
        document.getElementById('modal-notes').textContent = 'Loading...';
        document.getElementById('modal-health-notes').textContent = 'Loading...';
        
        // Set default avatar
        document.getElementById('modal-guest-photo').src = 'https://ui-avatars.com/api/?name=Loading&background=6b7280&color=fff';
    }

    // Function to update modal with guest data
    function updateModalWithGuestData(guest, guestId, baseUrl = '/resepsionis') {
        console.log('Updating modal with guest data:', guest);
        
        // Update modal photo
        const photo = document.getElementById('modal-guest-photo');
        if (guest.photo && guest.photo !== 'null') {
            photo.src = `/storage/guests/${guest.photo}`;
            photo.alt = guest.name || 'Guest';
        } else {
            photo.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(guest.name || 'Guest')}&background=3a86ff&color=fff&size=200`;
            photo.alt = guest.name || 'Guest';
        }

        // Update badges
        const badgesContainer = document.getElementById('modal-guest-badges');
        let badges = '';
        if (guest.guest_type && ['vip','vvip'].includes(guest.guest_type.toLowerCase())) {
            badges += `<span class="badge bg-warning text-dark me-1">${guest.guest_type.toUpperCase()}</span>`;
        }
        if (guest.loyalty_points > 100) {
            badges += `<span class="badge bg-info me-1">Loyalty Member</span>`;
        }
        badgesContainer.innerHTML = badges || '<span class="badge bg-secondary">Regular Guest</span>';

        // Update basic info
        document.getElementById('modal-guest-name').textContent = guest.name || 'No Name';
        document.getElementById('modal-guest-membership').textContent = `Member since ${guest.created_at || 'Unknown'}`;
        document.getElementById('modal-guest-code').textContent = guest.guest_code || 'Not set';
        document.getElementById('modal-phone').textContent = guest.phone || 'Not provided';
        document.getElementById('modal-email').textContent = guest.email || 'Not provided';
        document.getElementById('modal-identity').textContent = guest.identity_number || 'Not set';

        // Update profile details
        document.getElementById('modal-full-name').textContent = guest.name || 'No Name';
        document.getElementById('modal-dob').textContent = guest.date_of_birth || 'Not set';
        document.getElementById('modal-gender').textContent = guest.gender ? 
            guest.gender.charAt(0).toUpperCase() + guest.gender.slice(1) : 'Not set';
        document.getElementById('modal-nationality').textContent = guest.nationality || 'Not set';
        document.getElementById('modal-profession').textContent = guest.profession || 'Not set';
        document.getElementById('modal-company').textContent = guest.company || 'Not set';
        document.getElementById('modal-marital-status').textContent = guest.marital_status ? 
            guest.marital_status.charAt(0).toUpperCase() + guest.marital_status.slice(1) : 'Not set';
        document.getElementById('modal-guest-type').textContent = guest.guest_type ? 
            guest.guest_type.toUpperCase() : 'REGULAR';
        
        // Update address
        let address = guest.address || '';
        if (guest.city) address += (address ? ', ' : '') + guest.city;
        if (guest.country) address += (address ? ', ' : '') + guest.country;
        document.getElementById('modal-address').textContent = address || 'Not provided';
        
        document.getElementById('modal-notes').textContent = guest.notes || 'No notes available';
        document.getElementById('modal-health-notes').textContent = guest.health_notes || 'No health notes';

        // Update edit button with correct base URL
        document.getElementById('modal-edit-btn').href = `${baseUrl}/guests/${guestId}/edit`;
    }

    // Function to show error state
    function showErrorState(guestId) {
        const currentPath = window.location.pathname;
        let baseUrl = '/resepsionis';
        
        if (currentPath.includes('/admin/')) {
            baseUrl = '/admin';
        }
        
        document.getElementById('modal-guest-name').textContent = 'Error Loading Data';
        document.getElementById('modal-guest-membership').textContent = 'Please try again or contact support';
        document.getElementById('modal-edit-btn').href = `${baseUrl}/guests/${guestId}/edit`;
    }

    // Fallback method if API fails
    function tryFallbackData(guestId) {
        console.log('Trying fallback data for guest:', guestId);
        
        // Try to get data from visible list items
        const guestItem = document.querySelector(`[data-guest-id="${guestId}"]`);
        if (guestItem) {
            const guestName = guestItem.querySelector('.guest-name')?.textContent || 'Guest';
            const guestPhone = guestItem.querySelector('.text-muted')?.textContent || 'Not provided';
            const guestIdentity = guestItem.querySelector('small')?.textContent || 'Not set';
            
            // Get guest type from status badge
            const statusBadge = guestItem.querySelector('.guest-status');
            let guestType = 'regular';
            if (statusBadge && statusBadge.classList.contains('status-vip')) {
                guestType = statusBadge.textContent.toLowerCase();
            }
            
            // Update modal with minimal data
            document.getElementById('modal-guest-name').textContent = guestName;
            document.getElementById('modal-guest-membership').textContent = 'Basic information only';
            document.getElementById('modal-phone').textContent = guestPhone;
            document.getElementById('modal-identity').textContent = guestIdentity;
            document.getElementById('modal-full-name').textContent = guestName;
            document.getElementById('modal-guest-type').textContent = guestType.toUpperCase();
            
            // Set default avatar
            document.getElementById('modal-guest-photo').src = `https://ui-avatars.com/api/?name=${encodeURIComponent(guestName)}&background=3a86ff&color=fff&size=200`;
            
        } else {
            showErrorState(guestId);
        }
    }

    // Initialize Bootstrap tabs
    const triggerTabList = document.querySelectorAll('#guestTabs button');
    triggerTabList.forEach(triggerEl => {
        triggerEl.addEventListener('click', function (event) {
            event.preventDefault();
            const tabTrigger = new bootstrap.Tab(this);
            tabTrigger.show();
        });
    });

    // Initialize guest detail tabs
    const guestDetailTabs = document.querySelectorAll('#guestDetailTabs button');
    guestDetailTabs.forEach(tab => {
        tab.addEventListener('click', function (event) {
            event.preventDefault();
            const tabTrigger = new bootstrap.Tab(this);
            tabTrigger.show();
        });
    });

    // Show success/error messages
    @if(session('success'))
        setTimeout(() => {
            alert('{{ session('success') }}');
        }, 500);
    @endif

    @if(session('error'))
        setTimeout(() => {
            alert('{{ session('error') }}');
        }, 500);
    @endif
});
</script>
@endsection