<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'class',
        'student_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    public function teachingSchedules()
    {
        return $this->hasMany(Schedule::class, 'teacher_id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'student_id');
    }

    public function gradedStudents()
    {
        return $this->hasMany(Grade::class, 'teacher_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'student_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isTeacher()
    {
        return $this->role === 'teacher';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }
}
