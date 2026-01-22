<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'invoice_id',
        'payment_number',
        'amount',
        'payment_method',
        'payment_date',
        'reference_number',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($payment) {
            if (empty($payment->payment_number)) {
                $payment->payment_number = 'PAY-' . date('Ymd') . '-' . str_pad(static::max('id') + 1, 4, '0', STR_PAD_LEFT);
            }
        });

        static::created(function ($payment) {
            $invoice = $payment->invoice;
            $invoice->paid_amount += $payment->amount;
            
            if ($invoice->paid_amount >= $invoice->total) {
                $invoice->status = 'paid';
                $invoice->paid_date = now();
            } elseif ($invoice->paid_amount > 0) {
                $invoice->status = 'partial';
            }
            
            $invoice->save();
        });
    }
}