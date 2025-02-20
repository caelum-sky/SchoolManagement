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
        $student = Student::findOrFail($studentId);
     

        // Update enrollment status
        $student->subjects()->updateExistingPivot($subjectId, ['status' => $request->status]);

        // If status is "Dropped", set the grade to 5
        if ($request->status === 'Dropped') {
            Grade::updateOrCreate(
                ['student_id' => $studentId, 'subject_id' => $subjectId],
                ['grade' => 5]
            );
        }

        return redirect()->back()->with('success', 'Enrollment status updated successfully.');
    }
}
