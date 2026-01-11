<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'amount',
        'amount_paid',
        'due_date',
        'paid_date',
        'status',
        'academic_year',
        'payment_type',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'due_date' => 'date',
        'paid_date' => 'date',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Helper methods
    public function getRemainingAmountAttribute()
    {
        return $this->amount - $this->amount_paid;
    }

    public function isOverdue()
    {
        return $this->status !== 'paid' && Carbon::now()->isAfter($this->due_date);
    }
}
