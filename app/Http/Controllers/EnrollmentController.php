<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'schedule_day' => 'required|string', // Added schedule validation
            'schedule_start_time' => 'required|date_format:H:i', // e.g., 13:00
            'schedule_end_time' => 'required|date_format:H:i|after:schedule_start_time', // End time must be after start time
        ]);

        // Check if the student is already enrolled in the same subject
        $existingEnrollment = Enrollment::where('student_id', $request->student_id)
                                        ->where('subject_id', $request->subject_id)
                                        ->first();

        if ($existingEnrollment) {
            return redirect()->back()->with('error', 'Student is already enrolled in this subject.');
        }

        // Create new enrollment with schedule
        Enrollment::create([
            'student_id' => $request->student_id,
            'subject_id' => $request->subject_id,
            'status' => 'Enrolled',
            'schedule_day' => $request->schedule_day,
            'schedule_start_time' => $request->schedule_start_time,
            'schedule_end_time' => $request->schedule_end_time,
        ]);

        return redirect()->back()->with('success', 'Student enrolled successfully with schedule!');
    }

    public function enroll(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'schedule_day' => 'required|string',
            'schedule_start_time' => 'required|date_format:H:i',
            'schedule_end_time' => 'required|date_format:H:i|after:schedule_start_time',
        ]);

        $student = Student::findOrFail($request->student_id);
        $subjectId = $request->subject_id;

        if ($student->subjects()->where('subject_id', $subjectId)->exists()) {
            return redirect()->back()->with('info', 'Student is already enrolled in this subject.');
        }

        // Attach with schedule details
        $student->subjects()->attach($subjectId, [
            'status' => 'Enrolled',
            'schedule_day' => $request->schedule_day,
            'schedule_start_time' => $request->schedule_start_time,
            'schedule_end_time' => $request->schedule_end_time,
        ]);

        return redirect()->route('admin.index')->with('success', 'Student enrolled successfully with schedule.');
    }
    public function update(Request $request, $studentId, $subjectId)
{
    // Validate input
    $request->validate([
        'schedule_day' => 'required|string',
        'schedule_start_time' => 'required|date_format:H:i',
        'schedule_end_time' => 'required|date_format:H:i|after:schedule_start_time',
    ]);

    // Find the enrollment
    $enrollment = Enrollment::where('student_id', $studentId)
                            ->where('subject_id', $subjectId)
                            ->firstOrFail();

    // Update schedule
    $enrollment->update([
        'schedule_day' => $request->schedule_day,
        'schedule_start_time' => $request->schedule_start_time,
        'schedule_end_time' => $request->schedule_end_time,
    ]);

    return redirect()->back()->with('success', 'Schedule updated successfully.');
}


    public function addGrade(Request $request, $studentId, $subjectId)
    {
        $request->validate([
            'grade' => 'required|numeric|min:0|max:100'
        ]);

        $student = Student::findOrFail($studentId);

        if (!$student->subjects()->where('subject_id', $subjectId)->exists()) {
            return redirect()->back()->with('error', 'Student is not enrolled in this subject.');
        }

        $student->subjects()->updateExistingPivot($subjectId, ['grade' => $request->grade]);

        return redirect()->back()->with('success', 'Grade added successfully.');
    }

    public function destroy($student, $subject)
    {
        // Find the enrollment and delete it
        Enrollment::where('student_id', $student)->where('subject_id', $subject)->delete();

        return redirect()->back()->with('success', 'Enrollment deleted successfully.');
    }
}
