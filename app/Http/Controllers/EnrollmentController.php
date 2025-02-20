<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Subject;

class EnrollmentController extends Controller
{
    public function enroll(Request $request)
    {
        $student = Student::find($request->student_id);

        if (!$student) {
            return redirect()->back()->with('error', 'Student not found.');
        }

        $student->subjects()->attach($request->subject_id, ['status' => 'Enrolled']);

        return redirect()->back()->with('success', 'Student enrolled successfully.');
    }
}

