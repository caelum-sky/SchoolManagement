<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student; // Make sure you import the Student model
use App\Models\Subject; // Import the Subject model
use App\Models\Grade;   // Import the Grade model

class AdminController extends Controller
{
    public function index()
    {
        $students = Student::with('user')->get(); // Fetch students with related user data
        $subjects = Subject::all();
        $grades = Grade::paginate(10);
        $students = Student::with('user', 'enrollments.subject')->get();

        // Calculate total units per student
        $students = Student::with('user', 'enrollments.subject')->get();

        foreach ($students as $student) {
            $student->totalUnits = $student->enrollments->sum(fn($enrollment) => $enrollment->subject->units ?? 0);
        }
        return view('admin.index', compact('students', 'subjects', 'grades'));
    }
    public function showSubjects()
    {
        $subjects = Subject::all();  // Paginate to avoid large data loads
        $students = Student::with('user');
        $grades = Grade::all(); // Ensure $grades is available

        return view('admin.subjects', compact('subjects', 'students', 'grades'));
    }

}

