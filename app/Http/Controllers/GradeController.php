<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Enrollment;

class GradeController extends Controller
{
    public function getEnrolledSubjects($studentId)
{
    $student = Student::with('enrollments.subject')->find($studentId);
    if (!$student) {
        return response()->json([]);
    }

    return response()->json($student->enrollments->pluck('subject'));
}
public function index() {
    $students = Student::with('user', 'subjects')->get();
    $subjects = Subject::all();
    $grades = Grade::with('student.user', 'subject')->get();
    return view('admin.grades', compact('students', 'subjects', 'grades'));
}

    
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'grade' => 'required|numeric|min:0|max:5'
        ]);
    
        // Check if the student is actually enrolled in the selected subject
        $enrollment = Enrollment::where('student_id', $request->student_id)
                                ->where('subject_id', $request->subject_id)
                                ->first();
    
        if (!$enrollment) {
            return redirect()->back()->with('error', 'Student is not enrolled in this subject.');
        }
    
        // Check if a grade already exists for this student & subject
        $existingGrade = Grade::where('student_id', $request->student_id)
                              ->where('subject_id', $request->subject_id)
                              ->first();
    
        if ($existingGrade) {
            return redirect()->back()->with('error', 'Grade already exists for this subject.');
        }
    
        // Store the grade
        Grade::create([
            'student_id' => $request->student_id,
            'subject_id' => $request->subject_id,
            'grade' => $request->grade
        ]);
    
        return redirect()->back()->with('success', 'Grade added successfully.');
    }
    

    public function update(Request $request, Grade $grade)
    {
        $request->validate([
            'grade' => 'required|numeric|min:0|max:5',
        ]);
    
        $grade->update([
            'grade' => $request->grade,
        ]);
    
        return redirect()->back()->with('success', 'Grade updated successfully.');
    }
    

    public function destroy(Grade $grade)
    {
        $grade->delete();

        return redirect()->back()->with('success', 'Grade deleted successfully!');
    }
    public function addGrade(Request $request, $studentId, $subjectId)
{
    $request->validate([
        'grade' => 'required|decimal|min:0|max:5',
    ]);

    $student = Student::findOrFail($studentId);

    // Ensure student is enrolled in subject
    if (!$student->subjects()->where('subject_id', $subjectId)->exists()) {
        return redirect()->back()->with('error', 'Student is not enrolled in this subject.');
    }

    // Update grade
    $student->subjects()->updateExistingPivot($subjectId, ['grade' => $request->grade]);

    return redirect()->back()->with('success', 'Grade added successfully.');
}


    public function showStudentGrades(Student $student)
    {
        $grades = Grade::where('student_id', $student->id)->get();
        return view('admin.grades', compact('grades', 'student'));
    }
    
}
