@extends('layouts.adminlte')
@section('title', 'Financial Dashboard')
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
        /* Finance Cards */
        .finance-card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 24px;
            transition: all 0.3s;
        }
        .finance-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .finance-card .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 15px 20px;
            border-radius: 12px 12px 0 0 !important;
        }
        .finance-card .card-title {
            font-weight: 600;
            margin-bottom: 0;
            color: var(--dark);
        }
        .finance-card .card-body {
            padding: 20px;
        }
        /* KPI Cards */
        .kpi-card {
            background-color: white;
            border-radius: 12px;
            padding: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 15px;
            text-align: center;
        }
        .kpi-card .kpi-value {
            font-size: 24px;
            font-weight: 600;
            margin: 10px 0;
        }
        .kpi-card .kpi-value.income {
            color: var(--success);
        }
        .kpi-card .kpi-value.expense {
            color: var(--danger);
        }
        .kpi-card .kpi-value.net {
            color: var(--primary);
        }
        .kpi-card .kpi-label {
            font-size: 14px;
            color: #6b7280;
        }
        .kpi-card .kpi-change {
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .kpi-card .kpi-change.positive {
            color: var(--success);
        }
        .kpi-card .kpi-change.negative {
            color: var(--danger);
        }
        /* Transaction Table */
        .transaction-table {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .transaction-table .table {
            margin-bottom: 0;
        }
        .transaction-table .table thead th {
            background-color: #f9fafb;
            color: #6b7280;
            font-weight: 600;
            padding: 15px 20px;
            border-bottom: none;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }
        .transaction-table .table tbody td {
            padding: 15px 20px;
            vertical-align: middle;
            border-top: 1px solid #f3f4f6;
        }
        .transaction-type {
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        .transaction-type.income {
            background-color: #ecfdf5;
            color: var(--success);
        }
        .transaction-type.expense {
            background-color: #fef2f2;
            color: var(--danger);
        }
        /* Invoice Status Badge */
        .invoice-status {
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        .invoice-status.paid {
            background-color: #ecfdf5;
            color: var(--success);
        }
        .invoice-status.pending {
            background-color: #fffbeb;
            color: var(--warning);
        }
        .invoice-status.overdue {
            background-color: #fef2f2;
            color: var(--danger);
        }
        /* Invoice Items Table */
        .invoice-items-table input {
            border: none;
            background: transparent;
            width: 100%;
        }
        .invoice-items-table input:focus {
            outline: none;
            background: #f8f9fa;
        }
    </style>

<!-- Header -->
<div class="header d-flex justify-content-between align-items-center">
    <h2><i class="fas fa-wallet me-2"></i> Financial Dashboard</h2>
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

<!-- Filter Controls -->
<div class="row mb-4">
    <div class="col-md-4 mb-3 mb-md-0">
        <label for="financePeriod" class="form-label">Time Period</label>
        <select class="form-select" id="financePeriod" name="period">
            <option value="this_month" {{ request('period') == 'this_month' ? 'selected' : '' }}>This Month</option>
            <option value="last_month" {{ request('period') == 'last_month' ? 'selected' : '' }}>Last Month</option>
            <option value="this_quarter" {{ request('period') == 'this_quarter' ? 'selected' : '' }}>This Quarter</option>
            <option value="this_year" {{ request('period') == 'this_year' ? 'selected' : '' }}>This Year</option>
        </select>
    </div>
    <div class="col-md-4 mb-3 mb-md-0">
        <label for="reportType" class="form-label">Report Type</label>
        <select class="form-select" id="reportType">
            <option selected>Summary</option>
            <option>Detailed Transactions</option>
        </select>
    </div>
    <div class="col-md-4">
        <button class="btn btn-primary w-100" style="margin-top: 28px;">
            <i class="fas fa-download me-1"></i> Export Report
        </button>
    </div>
</div>

<!-- Financial KPIs -->
<div class="row">
    <div class="col-xl-4 col-md-6">
        <div class="kpi-card">
            <i class="fas fa-money-bill-wave text-success"></i>
            <div class="kpi-value income">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
            <div class="kpi-label">Total Income</div>
            <div class="kpi-change positive">
                <i class="fas fa-arrow-up me-1"></i> 
                {{ isset($incomeChange) ? abs($incomeChange) : '12.5' }}% vs last month
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="kpi-card">
            <i class="fas fa-receipt text-danger"></i>
            <div class="kpi-value expense">Rp {{ number_format($totalExpenses, 0, ',', '.') }}</div>
            <div class="kpi-label">Total Expenses</div>
            <div class="kpi-change negative">
                <i class="fas fa-arrow-down me-1"></i> 
                {{ isset($expenseChange) ? abs($expenseChange) : '5.3' }}% vs last month
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-12">
        <div class="kpi-card">
            <i class="fas fa-calculator text-primary"></i>
            <div class="kpi-value net">Rp {{ number_format($netProfit, 0, ',', '.') }}</div>
            <div class="kpi-label">Net Profit</div>
            <div class="kpi-change positive">
                <i class="fas fa-arrow-up me-1"></i> 
                {{ isset($profitChange) ? abs($profitChange) : '18.7' }}% vs last month
            </div>
        </div>
    </div>
</div>

<!-- Financial Charts Row -->
<div class="row mt-4">
    <div class="col-lg-8">
        <div class="finance-card card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Income vs Expenses Trend</h5>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="trendDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Monthly
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="trendDropdown">
                        <li><a class="dropdown-item" href="#">Daily</a></li>
                        <li><a class="dropdown-item" href="#">Weekly</a></li>
                        <li><a class="dropdown-item" href="#">Monthly</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <canvas id="incomeExpenseChart" height="300"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="finance-card card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Expense Breakdown</h5>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="expenseDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        This Month
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="expenseDropdown">
                        <li><a class="dropdown-item" href="#">This Week</a></li>
                        <li><a class="dropdown-item" href="#">This Month</a></li>
                        <li><a class="dropdown-item" href="#">This Year</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <canvas id="expenseChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Transaction History -->
<div class="row mt-4">
    <div class="col-12">
        <div class="finance-card card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Recent Transactions</h5>
                <div>
                    <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#addTransactionModal">
                        <i class="fas fa-plus me-1"></i> Add Transaction
                    </button>
                    <a href="#" class="btn btn-sm btn-primary">View All</a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="transaction-table">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Transaction ID</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $txn)
                            <tr>
                                <td>{{ $txn->date->format('d M Y') }}</td>
                                <td>#{{ $txn->transaction_id }}</td>
                                <td>{{ $txn->description }}</td>
                                <td>{{ $txn->category }}</td>
                                <td>Rp {{ number_format($txn->amount, 0, ',', '.') }}</td>
                                <td>
                                    <span class="transaction-type {{ $txn->type == 'income' ? 'income' : 'expense' }}">
                                        {{ ucfirst($txn->type) }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">Details</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Invoices and Payments -->
<div class="row mt-4">
    <div class="col-12">
        <div class="finance-card card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Outstanding Invoices</h5>
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createInvoiceModal">
                    <i class="fas fa-plus me-1"></i> Create Invoice
                </button>
            </div>
            <div class="card-body p-0">
                <div class="transaction-table">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Client</th>
                                <th>Issue Date</th>
                                <th>Due Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                            <tr>
                                <td>#{{ $invoice->invoice_number }}</td>
                                <td>{{ $invoice->client }}</td>
                                <td>{{ $invoice->issue_date->format('d M Y') }}</td>
                                <td>{{ $invoice->due_date->format('d M Y') }}</td>
                                <td>Rp {{ number_format($invoice->amount, 0, ',', '.') }}</td>
                                <td>
                                    <span class="invoice-status {{ $invoice->status }}">
                                        {{ ucfirst($invoice->status) }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary me-1">View</button>
                                    @if($invoice->status !== 'paid')
                                        <form action="{{ route('admin.finance.invoices.mark-paid', $invoice) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success"
                                                    onclick="return confirm('Mark this invoice as paid?')">
                                                Mark Paid
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Invoice Modal -->
<div class="modal fade" id="createInvoiceModal" tabindex="-1" aria-labelledby="createInvoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createInvoiceModalLabel">Create New Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.finance.invoices.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="invoiceClient" class="form-label">Client</label>
                            <select class="form-select" id="invoiceClient" name="client" required>
                                <option value="">Select Client</option>
                                @foreach($unpaidBookings as $booking)
                                    @if($booking->guest)
                                        <option value="{{ $booking->guest->name }}">
                                            {{ $booking->guest->name }}
                                            @if($booking->booking_code)
                                                — Booking #{{ $booking->booking_code }}
                                            @endif
                                            (Check-in: {{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }})
                                        </option>
                                    @endif
                                @endforeach
                                <option value="other">+ Add New Client</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="invoiceDate" class="form-label">Invoice Date</label>
                            <input type="date" class="form-control" id="invoiceDate" name="issue_date" required value="{{ now()->format('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="dueDate" class="form-label">Due Date</label>
                            <input type="date" class="form-control" id="dueDate" name="due_date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="invoiceNumber" class="form-label">Invoice Number</label>
                            <input type="text" class="form-control" id="invoiceNumber" name="invoice_number" value="INV-{{ now()->format('Y-m') }}-{{ \Illuminate\Support\Str::random(6) }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Invoice Items</label>
                        <div class="table-responsive">
                            <table class="table table-bordered invoice-items-table">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th width="120">Quantity</th>
                                        <th width="150">Unit Price</th>
                                        <th width="150">Amount</th>
                                        <th width="50"></th>
                                    </tr>
                                </thead>
                                <tbody id="invoiceItems">
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" name="items[0][description]" placeholder="Item description" required>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control quantity" name="items[0][quantity]" value="1" min="1" required>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control unit-price" name="items[0][unit_price]" placeholder="0" required>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control amount" name="items[0][amount]" value="0" readonly>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-danger remove-item">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5">
                                            <button type="button" class="btn btn-sm btn-outline-primary" id="addInvoiceItem">
                                                <i class="fas fa-plus me-1"></i> Add Item
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end">Subtotal</td>
                                        <td colspan="2">
                                            <input type="text" class="form-control border-0 bg-transparent text-end fw-bold" id="subtotal" value="Rp 0" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end">Tax (10%)</td>
                                        <td colspan="2">
                                            <input type="text" class="form-control border-0 bg-transparent text-end fw-bold" id="tax" value="Rp 0" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Total</td>
                                        <td colspan="2">
                                            <input type="text" class="form-control border-0 bg-transparent text-end fw-bold" id="total" name="amount" value="Rp 0" readonly>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="invoiceNotes" class="form-label">Notes</label>
                        <textarea class="form-control" id="invoiceNotes" name="notes" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Invoice</button>
                    <button type="button" class="btn btn-success" id="saveAndSend">Save & Send</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Transaction Modal -->
<div class="modal fade" id="addTransactionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Add Transaction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Form will be implemented in the next feature.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Income vs Expense Chart
    const incomeExpenseCtx = document.getElementById('incomeExpenseChart').getContext('2d');
    new Chart(incomeExpenseCtx, {
        type: 'bar',
        data: {
            labels: @json($months),
            datasets: [
                {
                    label: 'Income',
                    data: @json($incomeData),
                    backgroundColor: 'rgba(16, 185, 129, 0.7)',
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Expenses',
                    data: @json($expenseData),
                    backgroundColor: 'rgba(239, 68, 68, 0.7)',
                    borderColor: 'rgba(239, 68, 68, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: ctx => ctx.dataset.label + ': Rp ' + ctx.raw.toLocaleString()
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: v => 'Rp ' + (v >= 1e6 ? (v/1e6)+'M' : v)
                    }
                }
            }
        }
    });

    // Expense Breakdown Chart
    const expenseCtx = document.getElementById('expenseChart').getContext('2d');
    const expenseLabels = @json(array_keys($expenseBreakdown));
    const expenseValues = @json(array_values($expenseBreakdown));
    new Chart(expenseCtx, {
        type: 'doughnut',
        data: {
            labels: expenseLabels,
            datasets: [{
                data: expenseValues,
                backgroundColor: [
                    'rgba(239, 68, 68, 0.7)',
                    'rgba(245, 158, 11, 0.7)',
                    'rgba(59, 130, 246, 0.7)',
                    'rgba(16, 185, 129, 0.7)',
                    'rgba(139, 92, 246, 0.7)',
                    'rgba(156, 163, 175, 0.7)'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { position: 'right' },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': Rp ' + context.raw.toLocaleString();
                        }
                    }
                }
            },
            cutout: '65%'
        }
    });

    // Invoice Management
    document.addEventListener('DOMContentLoaded', function() {
        let itemCount = 1;
        document.getElementById('addInvoiceItem').addEventListener('click', function() {
            const newRow = `
                <tr>
                    <td><input type="text" class="form-control" name="items[${itemCount}][description]" placeholder="Item description" required></td>
                    <td><input type="number" class="form-control quantity" name="items[${itemCount}][quantity]" value="1" min="1" required></td>
                    <td><input type="number" class="form-control unit-price" name="items[${itemCount}][unit_price]" placeholder="0" required></td>
                    <td><input type="text" class="form-control amount" name="items[${itemCount}][amount]" value="0" readonly></td>
                    <td><button type="button" class="btn btn-sm btn-danger remove-item"><i class="fas fa-times"></i></button></td>
                </tr>
            `;
            document.getElementById('invoiceItems').insertAdjacentHTML('beforeend', newRow);
            itemCount++;
            attachEventListeners();
        });

        function attachEventListeners() {
            document.querySelectorAll('.remove-item').forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('tr').remove();
                    calculateTotal();
                });
            });
            document.querySelectorAll('.quantity, .unit-price').forEach(input => {
                input.addEventListener('input', calculateItemAmount);
            });
        }

        function calculateItemAmount() {
            const row = this.closest('tr');
            const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
            const unitPrice = parseFloat(row.querySelector('.unit-price').value) || 0;
            const amount = quantity * unitPrice;
            row.querySelector('.amount').value = amount.toLocaleString();
            calculateTotal();
        }

        function calculateTotal() {
            let subtotal = 0;
            document.querySelectorAll('.amount').forEach(input => {
                const value = parseFloat(input.value.replace(/,/g, '')) || 0;
                subtotal += value;
            });
            const tax = subtotal * 0.1;
            const total = subtotal + tax;
            document.getElementById('subtotal').value = 'Rp ' + subtotal.toLocaleString();
            document.getElementById('tax').value = 'Rp ' + tax.toLocaleString();
            document.getElementById('total').value = 'Rp ' + total.toLocaleString();
            document.querySelector('input[name="amount"]').value = total;
        }

        document.getElementById('saveAndSend').addEventListener('click', function() {
            document.querySelector('form').action = "{{ route('admin.finance.invoices.store') }}?send=true";
            document.querySelector('form').submit();
        });

        attachEventListeners();
        const dueDate = new Date();
        dueDate.setDate(dueDate.getDate() + 15);
        document.getElementById('dueDate').value = dueDate.toISOString().split('T')[0];
    });
</script>
@endpush