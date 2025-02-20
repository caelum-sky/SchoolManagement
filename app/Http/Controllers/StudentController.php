<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Subject;

class StudentController extends Controller
{
    public function index()
    {
       
        $subjects = Subject::all();
        $grades = Grade::all();
        $students = Student::with('subjects')->paginate(10);
 // Load students with their subjects
        return view('admin.index', compact('students', 'subjects', 'grades'));
    
        
    }
    
    

    public function create()
    {
        return view('admin.students.create'); // This view should not require $students
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:students',
            'phone' => 'required',
            'address' => 'required',
            'gender' => 'required'
        ]);

        Student::create($request->all());
        return redirect()->route('admin.index')->with('success', 'Student added successfully.');
    }

    public function edit($student_id)
    {
        $student = Student::with('subjects')->find($student_id);
    
        if (!$student) {
            return redirect()->back()->with('error', 'Student not found.');
        }
    
        return view('admin.index', compact('student'));
    }
    

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'gender' => 'required|string',
            'enrollment_status' => 'required|string|in:Enrolled,Pending,Dropped',
        ]);
    
        $student->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'enrollment_status' => $request->enrollment_status,
        ]);
    
        return redirect()->route('admin.index')->with('success', 'Student updated successfully');
    }
    public function enroll(Request $request)
    {
        // ✅ Step 1: Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'course_id' => 'required|exists:courses,id', // Ensure the course exists
        ]);

        // ✅ Step 2: Create a new student record
        $student = Student::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'course_id' => $validatedData['course_id'], // Linking student to a course
        ]);

        // ✅ Step 3: Return a success response
        return response()->json([
            'message' => 'Student enrolled successfully',
            'student' => $student
        ], 201);
    }
    public function enrollStudent(Request $request, $studentId, $subjectId)
{
    $student = Student::find($request->student_id);
    $student = Student::findOrFail($studentId);
    $student->subjects()->updateExistingPivot($subjectId, ['status' => $request->status]);
    

    if (!$student) {
        return redirect()->back()->with('error', 'Student not found.');
    }

    $student->subjects()->attach($request->subject_id, ['status' => 'Enrolled']);

    return redirect()->back()->with('success', 'Student enrolled successfully.');
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

