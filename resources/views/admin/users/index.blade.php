@extends('layouts.adminlte')
@section('title', 'Daftar Staff')

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
    
    .staff-card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        margin-bottom: 24px;
        transition: all 0.3s;
        overflow: hidden;
    }
    
    .staff-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .staff-card .card-body {
        padding: 20px;
        display: flex;
        align-items: center;
    }
    
    .staff-card .staff-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 20px;
        border: 3px solid #e5e7eb;
    }
    
    .staff-card .staff-info {
        flex: 1;
    }
    
    .staff-card .staff-name {
        font-weight: 600;
        margin-bottom: 5px;
        font-size: 18px;
    }
    
    .staff-card .staff-position {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 10px;
    }
    
    .staff-card .staff-contact {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 0;
    }
    
    .staff-card .staff-status {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .staff-card .staff-status.active {
        background-color: #ecfdf5;
        color: var(--success);
    }
    
    .staff-card .staff-status.inactive {
        background-color: #fef2f2;
        color: var(--danger);
    }
    
    .staff-card .staff-status.on-leave {
        background-color: #fffbeb;
        color: var(--warning);
    }
    
    .management-card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        margin-bottom: 24px;
    }
    
    .management-card .card-header {
        background-color: white;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        padding: 15px 20px;
        border-radius: 12px 12px 0 0 !important;
    }
    
    .management-card .card-title {
        font-weight: 600;
        margin-bottom: 0;
        color: var(--dark);
    }
    
    .staff-table {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    
    .staff-table .table {
        margin-bottom: 0;
    }
    
    .staff-table .table thead th {
        background-color: #f9fafb;
        color: #6b7280;
        font-weight: 600;
        padding: 15px 20px;
        border-bottom: none;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
    }
    
    .staff-table .table tbody td {
        padding: 15px 20px;
        vertical-align: middle;
        border-top: 1px solid #f3f4f6;
    }
    
    .staff-avatar-sm {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 10px;
    }
    
    .status-badge {
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .status-badge.active { background-color: #ecfdf5; color: var(--success); }
    .status-badge.inactive { background-color: #fef2f2; color: var(--danger); }
    .status-badge.on-leave { background-color: #fffbeb; color: var(--warning); }
    
    .department-badge {
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .department-badge.front-office { background-color: #eff6ff; color: var(--primary); }
    .department-badge.housekeeping { background-color: #ecfdf5; color: var(--success); }
    .department-badge.food-beverage { background-color: #fef2f2; color: var(--danger); }
    .department-badge.maintenance { background-color: #fffbeb; color: var(--warning); }
    .department-badge.management { background-color: #f3e8ff; color: #7e22ce; }
    
    @media (max-width: 992px) {
        .sidebar { margin-left: -280px; }
        .sidebar.active { margin-left: 0; }
        .main-content { margin-left: 0; }
    }
    
    @media (max-width: 768px) {
        .main-content { padding: 20px 15px; }
        .header h2 { font-size: 1.5rem; }
        .staff-card .card-body { flex-direction: column; text-align: center; }
        .staff-card .staff-avatar { margin-right: 0; margin-bottom: 15px; }
    }
</style>

<!-- Header -->
<div class="header d-flex justify-content-between align-items-center">
    <h2><i class="fas fa-users me-2"></i> Staff Management</h2>

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
        <div class="staff-card card">
            <div class="card-body text-center">
                <h3 class="mb-2">{{ $totalStaff }}</h3>
                <p class="text-muted mb-0">Total Staff</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
        <div class="staff-card card">
            <div class="card-body text-center">
                <h3 class="mb-2">{{ $activeStaff }}</h3>
                <p class="text-muted mb-0">Active Staff</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
        <div class="staff-card card">
            <div class="card-body text-center">
                <h3 class="mb-2">{{ $onLeaveStaff }}</h3>
                <p class="text-muted mb-0">On Leave</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="staff-card card">
            <div class="card-body text-center">
                <h3 class="mb-2">{{ $newHires }}</h3>
                <p class="text-muted mb-0">New Hires</p>
            </div>
        </div>
    </div>
</div>

<!-- Staff Tables -->
<div class="row">
    <div class="col-lg-12">
        <div class="management-card card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">All Staff Members</h5>
                <div>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary me-2">
                        <i class="fas fa-sync-alt me-1"></i> Refresh
                    </a>
                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addStaffModal">
                        <i class="fas fa-plus me-1"></i> Add Staff
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                @if(session('success'))
                    <div class="alert alert-success shadow-sm mb-0">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    </div>
                @endif

                @if($users->isEmpty())
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-user-friends fa-3x mb-3 text-primary"></i>
                        <h5 class="text-dark">Belum ada data staff</h5>
                        <p class="mb-0">Klik tombol "Add Staff" untuk menambahkan data baru</p>
                    </div>
                @else
                    <div class="staff-table table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Staff</th>
                                    <th>Position</th>
                                    <th>Department</th>
                                    <th>Join Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $user->photo ? asset('image/' . $user->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                                                     class="staff-avatar-sm"
                                                     alt="{{ $user->name }}">
                                                <div class="ms-3">
                                                    <div>{{ $user->name }}</div>
                                                    <small class="text-muted">ID: EMP-{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $user->position ?? ucfirst($user->role) }}</td>
                                        <td>
                                            <span class="department-badge {{ $user->department ?? 'management' }}">
                                                {{ ucfirst(str_replace('-', ' ', $user->department ?? 'management')) }}
                                            </span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($user->join_date ?? $user->created_at)->format('d M Y') }}</td>
                                        <td>
                                            <span class="status-badge {{ $user->status ?? 'active' }}">
                                                {{ ucfirst($user->status ?? 'Active') }}
                                            </span>
                                        </td>
                                        <td>
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-primary me-1" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editStaffModal"
                                                    data-id="{{ $user->id }}"
                                                    data-first-name="{{ $user->first_name }}"
                                                    data-last-name="{{ $user->last_name }}"
                                                    data-email="{{ $user->email }}"
                                                    data-phone="{{ $user->phone }}"
                                                    data-address="{{ $user->address }}"
                                                    data-position="{{ $user->position }}"
                                                    data-department="{{ $user->department }}"
                                                    data-join-date="{{ $user->join_date }}"
                                                    data-status="{{ $user->status }}"
                                                    data-salary="{{ $user->salary }}"
                                                    data-notes="{{ $user->notes }}"
                                                    data-photo-url="{{ $user->photo ? asset('image/' . $user->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}">
                                                Edit
                                            </button>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($users->hasPages())
                        <div class="p-3 border-top d-flex justify-content-end">
                            {{ $users->appends(request()->query())->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<!-- ✅ Add Staff Modal — HANYA SATU -->
<div class="modal fade" id="addStaffModal" tabindex="-1" aria-labelledby="addStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStaffModalLabel">Add New Staff Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addStaffForm" action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="staffFirstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="staffFirstName" name="first_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="staffLastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="staffLastName" name="last_name" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="staffEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="staffEmail" name="email" required>
                        </div>
                        <div class="col-md-6">
                            <label for="staffPhone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="staffPhone" name="phone" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="staffPosition" class="form-label">Position</label>
                            <input type="text" class="form-control" id="staffPosition" name="position" required>
                        </div>
                        <div class="col-md-6">
                            <label for="staffDepartment" class="form-label">Department</label>
                            <select class="form-select" id="staffDepartment" name="department" required>
                                <option value="">Select Department</option>
                                <option value="front-office">Front Office</option>
                                <option value="housekeeping">Housekeeping</option>
                                <option value="food-beverage">Food & Beverage</option>
                                <option value="maintenance">Maintenance</option>
                                <option value="management">Management</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="staffJoinDate" class="form-label">Join Date</label>
                            <input type="date" class="form-control" id="staffJoinDate" name="join_date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="staffStatus" class="form-label">Status</label>
                            <select class="form-select" id="staffStatus" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="on-leave">On Leave</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="staffSalary" class="form-label">Monthly Salary</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="staffSalary" name="salary" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="staffPhoto" class="form-label">Photo</label>
                            <input type="file" class="form-control" id="staffPhoto" name="photo" accept="image/*">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="staffAddress" class="form-label">Address</label>
                        <textarea class="form-control" id="staffAddress" name="address" rows="2" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="staffNotes" class="form-label">Notes</label>
                        <textarea class="form-control" id="staffNotes" name="notes" rows="2"></textarea>
                    </div>

                    <input type="hidden" name="role" value="resepsionis">

                    <div class="mb-3">
                        <label for="staffPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="staffPassword" name="password" required>
                        <small class="text-muted">Minimal 6 karakter</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="addStaffForm" class="btn btn-primary">Save Staff</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Staff Modal -->
<div class="modal fade" id="editStaffModal" tabindex="-1" aria-labelledby="editStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editStaffForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="editStaffId" name="id">

                <div class="modal-header">
                    <h5 class="modal-title" id="editStaffModalLabel">Edit Staff Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editFirstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="editFirstName" name="first_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editLastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="editLastName" name="last_name" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editEmail" name="email" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editPhone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="editPhone" name="phone" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editPosition" class="form-label">Position</label>
                            <input type="text" class="form-control" id="editPosition" name="position" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editDepartment" class="form-label">Department</label>
                            <select class="form-select" id="editDepartment" name="department" required>
                                <option value="front-office">Front Office</option>
                                <option value="housekeeping">Housekeeping</option>
                                <option value="food-beverage">Food & Beverage</option>
                                <option value="maintenance">Maintenance</option>
                                <option value="management">Management</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editJoinDate" class="form-label">Join Date</label>
                            <input type="date" class="form-control" id="editJoinDate" name="join_date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editStatus" class="form-label">Status</label>
                            <select class="form-select" id="editStatus" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="on-leave">On Leave</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editSalary" class="form-label">Monthly Salary</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="editSalary" name="salary" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="editPhoto" class="form-label">Photo</label>
                            <input type="file" class="form-control" id="editPhoto" name="photo" accept="image/*">
                            <div class="mt-2">
                                <img id="editPhotoPreview" src="" alt="Photo" style="width: 80px; height: 80px; object-fit: cover; display: none;">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="editAddress" class="form-label">Address</label>
                        <textarea class="form-control" id="editAddress" name="address" rows="2" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="editNotes" class="form-label">Notes</label>
                        <textarea class="form-control" id="editNotes" name="notes" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="editPassword" class="form-label">Password (Kosongkan jika tidak ingin mengganti)</label>
                        <input type="password" class="form-control" id="editPassword" name="password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Staff</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Edit Modal Handler
    const editModal = document.getElementById('editStaffModal');
    if (editModal) {
        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const firstName = button.getAttribute('data-first-name');
            const lastName = button.getAttribute('data-last-name');
            const email = button.getAttribute('data-email');
            const phone = button.getAttribute('data-phone');
            const address = button.getAttribute('data-address');
            const position = button.getAttribute('data-position');
            const department = button.getAttribute('data-department');
            const joinDate = button.getAttribute('data-join-date');
            const status = button.getAttribute('data-status');
            const salary = button.getAttribute('data-salary');
            const notes = button.getAttribute('data-notes');
            const photoUrl = button.getAttribute('data-photo-url');

            document.getElementById('editStaffId').value = id;
            document.getElementById('editStaffForm').action = `/admin/users/${id}`;
            document.getElementById('editFirstName').value = firstName;
            document.getElementById('editLastName').value = lastName;
            document.getElementById('editEmail').value = email;
            document.getElementById('editPhone').value = phone;
            document.getElementById('editAddress').value = address;
            document.getElementById('editPosition').value = position;
            document.getElementById('editDepartment').value = department;
            document.getElementById('editJoinDate').value = joinDate;
            document.getElementById('editStatus').value = status;
            document.getElementById('editSalary').value = salary || '';
            document.getElementById('editNotes').value = notes;

            const photoPreview = document.getElementById('editPhotoPreview');
            if (photoUrl) {
                photoPreview.src = photoUrl;
                photoPreview.style.display = 'block';
            } else {
                photoPreview.style.display = 'none';
            }
        });
    }
});
</script>

@endsection