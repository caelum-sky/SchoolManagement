<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Student;

class GradeController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'grade' => 'required|numeric|min:0|max:5',
        ]);

        $student = Student::find($validatedData['student_id']);

        // Check if student is enrolled in the subject
        if (!$student->subjects()->where('subject_id', $validatedData['subject_id'])->exists()) {
            return redirect()->back()->with('error', 'Student must be enrolled in the subject before assigning a grade.');
        }

        // Check if the grade already exists
        $existingGrade = Grade::where('student_id', $validatedData['student_id'])
                              ->where('subject_id', $validatedData['subject_id'])
                              ->first();

        if ($existingGrade) {
            return redirect()->back()->with('error', 'Grade already exists for this student and subject.');
        }

        // Create the grade
        Grade::create($validatedData);

        return redirect()->back()->with('success', 'Grade added successfully.');
    }

    public function update(Request $request, Grade $grade)
    {
        // Validate the grade input
        $request->validate([
            'grade' => 'required|numeric|min:0|max:5',
        ]);

        // Ensure the student is enrolled in the subject before updating the grade
        if (!$grade->student->subjects()->where('subject_id', $grade->subject_id)->exists()) {
            return redirect()->back()->with('error', 'Student must be enrolled in the subject to update the grade.');
        }

        // Update the grade
        $grade->update(['grade' => $request->grade]);

        return redirect()->back()->with('success', 'Grade updated successfully.');
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();

        return redirect()->back()->with('success', 'Grade deleted successfully!');
    }

    public function showStudentGrades(Student $student)
    {
        $grades = Grade::where('student_id', $student->id)->get();
        return view('grades.index', compact('grades', 'student'));
    }
}
