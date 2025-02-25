<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'phone', 'address', 'gender',  'year'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'student_subject')
                    ->withPivot('status', 'grade')
                    ->withTimestamps();
    }
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }
    public function getTotalUnitsAttribute()
    {
        return $this->enrollments->sum(fn($enrollment) => optional($enrollment->subject)->unit ?? 0);
    }
}
