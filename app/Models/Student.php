<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'address', 'gender'];

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'student_subject')
                    ->withPivot('status')
                    ->withTimestamps();
    }
    
    

}
