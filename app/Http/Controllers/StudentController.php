<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
// StudentController.php - index method
public function index()
{

    $students = Student::with('enrollments.subject')->get();
    $subjects = Subject::all();
    $grades = Grade::all();
    $students = Student::with(['user', 'subjects'])->paginate(10); // Ensure 'user' relation is loaded

    return view('admin.index', compact('students', 'subjects', 'grades'));
}


    public function create()
    {
        return view('admin.students.create');
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'year' => 'nullable|string',
            'gender' => 'nullable|string|in:Male,Female,Other',
        ]);
    
        // ✅ Step 1: Create the User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'year' => $request->year,
            'password' => Hash::make('defaultpassword123'), // Default password
            'role' => 'student', // Assign role as student
        ]);
    
        // ✅ Step 2: Create Student Linked to User
        $student = Student::create([
            'user_id' => $user->id, // Link student to user
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'year' => $request->year,
        ]);
    
        return redirect()->route('students.index')->with('success', 'Student added successfully.');
    }
    

    
    
    
    
    
    
    

    
    public function enrollStudent(Request $request, $studentId, $subjectId)
    {
        $student = Student::findOrFail($studentId);
    
        if (!$student->subjects()->where('subject_id', $subjectId)->exists()) {
            $student->subjects()->attach($subjectId, ['status' => 'Enrolled']);
        } else {
            return redirect()->back()->with('info', 'Student is already enrolled in this subject.');
        }
    
        return redirect()->back()->with('success', 'Student enrolled successfully.');
    }
    
public function addGrade(Request $request, $studentId, $subjectId)
{
    $request->validate([
        'grade' => 'required|numeric|min:0|max:100',
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

        public function edit($student_id)
    {
        $student = Student::with('subjects')->find($student_id);

        if (!$student) {
            return redirect()->back()->with('error', 'Student not found.');
        }

        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id, // Ensure email is unique except for the current user
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'year' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female'
        ]);
    
        $student = Student::findOrFail($id);
        $user = $student->user; // Assuming Student belongsTo User
    
        // Update user details
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'year' => $request->year,
            'gender' => $request->gender,
        ]);
    
        // Update student details (if necessary)
        $student->update([
            'user_id' => $user->id,
        ]);
    
        return redirect()->route('admin.index')->with('success', 'Student updated successfully');
    }
    
    
    public function updateEnrollmentStatus(Request $request, $studentId, $subjectId)
    {
        // Validate input
        $request->validate([
            'status' => 'required|in:Enrolled,In Progress,Dropped',
        ]);
    
        // Find the student and subject relationship
        $student = Student::findOrFail($studentId);
        $student->subjects()->updateExistingPivot($subjectId, ['status' => $request->status]);
    
        // Redirect with success message
        return redirect()->back()->with('success', 'Enrollment status updated successfully.');
    }
    
    

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('admin.index')->with('success', 'Student deleted successfully.');
    }
}
