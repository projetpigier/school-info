<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'teacher_id',
        'subject',
        'evaluation_type',
        'grade',
        'max_grade',
        'comment',
        'evaluation_date',
        'is_published',
    ];

    protected $casts = [
        'grade' => 'decimal:2',
        'max_grade' => 'decimal:2',
        'evaluation_date' => 'date',
        'is_published' => 'boolean',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // Helper method
    public function getPercentageAttribute()
    {
        return ($this->grade / $this->max_grade) * 100;
    }
}
