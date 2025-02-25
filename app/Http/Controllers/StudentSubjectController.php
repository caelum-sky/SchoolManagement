<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Grade;

class StudentSubjectController extends Controller
{
    public function updateEnrollmentStatus(Request $request, $studentId, $subjectId)
    {
        $request->validate([
            'status' => 'required|in:Enrolled,In Progress,Dropped',
        ]);
    
        $student = Student::findOrFail($studentId);
        $student->subjects()->updateExistingPivot($subjectId, ['status' => $request->status]);
    
        return redirect()->route('students.index')->with('success', 'Enrollment status updated successfully.');
    }
    
}
