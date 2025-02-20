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
        $students = Student::paginate(10); // Use pagination
        $subjects = Subject::paginate(10);
        $grades = Grade::paginate(10);

        return view('admin.index', compact('students', 'subjects', 'grades'));
    }
}

