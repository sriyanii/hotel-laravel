<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'client_name',
        'issue_date',
        'due_date',
        'amount',
        'tax_rate',
        'notes',
        'status',
        'created_by',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
        'amount' => 'decimal:2',
        'tax_rate' => 'decimal:2',
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getSubtotalAttribute()
    {
        return $this->items->sum('amount');
    }

    public function getTaxAmountAttribute()
    {
        return $this->subtotal * ($this->tax_rate / 100);
    }

    public function getTotalAmountAttribute()
    {
        return $this->subtotal + $this->tax_amount;
    }

    public function getStatusBadgeAttribute()
    {
        $statuses = [
            'pending' => 'warning',
            'paid' => 'success',
            'overdue' => 'danger',
            'cancelled' => 'secondary',
        ];

        return $statuses[$this->status] ?? 'secondary';
    }
}

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'description',
        'quantity',
        'unit_price',
        'amount',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'amount' => 'decimal:2',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}