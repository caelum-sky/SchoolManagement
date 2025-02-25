<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'subject_id',
        'status',
        'schedule_day',
        'schedule_start_time',
        'schedule_end_time',
    ];
    

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Scope to check if a student is already enrolled in a specific subject.
     */
    public static function alreadyEnrolled($studentId, $subjectId)
    {
        return self::where('student_id', $studentId)
                   ->where('subject_id', $subjectId)
                   ->exists();
    }
}
