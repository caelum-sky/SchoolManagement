@extends('layouts.dash')

@section('views')
<div class="container">
    <h2 class="mb-4">Student Management</h2>

    <!-- Add Student Modal Trigger -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createStudentModal">
        Add Student
    </button>
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#Subject">
        Add Subject
    </button>
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#Grade">
        Add Grade
    </button>
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#enrollStudentModal">
    Enroll Student in Subject
    </button>

    <div class="modal fade" id="enrollStudentModal" tabindex="-1" aria-labelledby="enrollStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="enrollStudentModalLabel">Enroll Student in Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.index') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Student:</label>
                        <select name="student_id" class="form-control" required>
                            <option value="">Select Student</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Subject:</label>
                        <select name="subject_id" class="form-control" required>
                            <option value="">Select Subject</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Enroll Student</button>
                </form>
            </div>
        </div>
    </div>
</div>


    <div class="modal fade" id="Grade" tabindex="-1" aria-labelledby="Grade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                    <h5 class="modal-title" id="createStudentModalLabel">Add Grade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            <form action="{{ route('grades.store') }}" method="POST">
    @csrf
    <select name="student_id" class="form-control" required>
        <option value="">Select Student</option>
        @foreach ($students as $student)
            <option value="{{ $student->id }}">{{ $student->name }}</option>
        @endforeach
    </select>

    <select name="subject_id" class="form-control mt-2" required>
        <option value="">Select Subject</option>
        @foreach ($subjects as $subject)
            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
        @endforeach
    </select>

    <input type="number" name="grade" class="form-control mt-2" placeholder="Enter Grade" required min="0" max="5" step="0.01">


    <button type="submit" class="btn btn-success mt-2">Add Grade</button>
</form>

            </div>
        </div>
    </div>


    <!-- Add Student Modal -->
    <div class="modal fade" id="createStudentModal" tabindex="-1" aria-labelledby="createStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createStudentModalLabel">Add New Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('students.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>Name:</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Email:</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Phone:</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Address:</label>
                            <input type="text" name="address" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Gender:</label>
                            <select name="gender" class="form-control" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Add Student</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="Subject" tabindex="-1" aria-labelledby="Subject" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createStudentModalLabel">Add New Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('subjects.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>Name:</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Code:</label>
                            <input type="text" name="code" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Description:</label>
                            <input type="text" name="description" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success">Add Student</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Form -->


    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Students Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Gender</th>
                <th>Subjects</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->phone }}</td>
                    <td>{{ $student->address }}</td>
                    <td>{{ $student->gender }}</td>
                    <td>
                            <strong>Enrolled:</strong>
                            @foreach ($student->subjects->where('pivot.status', 'Enrolled') as $subject)
                                <span class="badge bg-success">{{ $subject->name }}</span>
                            @endforeach
                            <br>


                    </td>


                    <td>
                        <!-- Edit Student Modal Trigger -->
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#EditStudentModal{{ $student->id }}">
                            Edit
                        </button>

                        <!-- Delete Form -->
                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</button>
                        </form>
                    </td>
                </tr>

                <!-- Edit Student Modal (Unique for each student) -->
                <div class="modal fade" id="EditStudentModal{{ $student->id }}" tabindex="-1" aria-labelledby="EditStudentModalLabel{{ $student->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="EditStudentModalLabel{{ $student->id }}">Edit Student</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('students.update', $student->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label>Name:</label>
                                        <input type="text" name="name" class="form-control" value="{{ $student->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Email:</label>
                                        <input type="email" name="email" class="form-control" value="{{ $student->email }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Phone:</label>
                                        <input type="text" name="phone" class="form-control" value="{{ $student->phone }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Address:</label>
                                        <input type="text" name="address" class="form-control" value="{{ $student->address }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Gender:</label>
                                        <select name="gender" class="form-control" required>
                                            <option value="Male" {{ $student->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female" {{ $student->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                    </div>
                                    @foreach ($student->subjects as $subject)
                                        <div class="mb-3">
                                            <label>Enrollment Status:</label>
                                            <form action="{{ route('updateEnrollmentStatus', [$student->id, $subject->id]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" class="form-control" onchange="this.form.submit()">
                                                    <option value="Enrolled" {{ $subject->pivot->status == 'Enrolled' ? 'selected' : '' }}>Enrolled</option>
                                                    <option value="In Progress" {{ $subject->pivot->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                                    <option value="Dropped" {{ $subject->pivot->status == 'Dropped' ? 'selected' : '' }}>Dropped</option>
                                                </select>
                                            </form>


                                        </div>
                                    @endforeach


                                    <button type="submit" class="btn btn-success">Update Student</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach
        </tbody>
    </table>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Code</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subjects as $subject)
                <tr>
                    <td>{{ $subject->name }}</td>
                    <td>{{ $subject->code }}</td>
                    <td>{{ $subject->description }}</td>
                    <td>
                        <!-- Edit Student Modal Trigger -->
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#EditSubjectModal{{ $subject->id }}">
                        Edit
                    </button>


                        <!-- Delete Form -->
                        <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</button>
                        </form>
                    </td>
                </tr>

                <!-- Edit Subject Modal (Unique for each subject) -->
<div class="modal fade" id="EditSubjectModal{{ $subject->id }}" tabindex="-1" aria-labelledby="EditSubjectModalLabel{{ $subject->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EditSubjectModalLabel{{ $subject->id }}">Edit Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                            <form action="{{ route('subjects.update', $subject->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label>Name:</label>
                                    <input type="text" name="name" class="form-control" value="{{ $subject->name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label>Description:</label>
                                    <input type="text" name="description" class="form-control" value="{{ $subject->description }}" required>
                                </div>
                                <div class="mb-3">
                                    <label>Code:</label>
                                    <input type="text" name="code" class="form-control" value="{{ $subject->code }}" required>
                                </div>
                                <button type="submit" class="btn btn-success">Update Subject</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            @endforeach
        </tbody>
    </table>


<table class="table mt-4">
    <thead>
        <tr>
            <th>Student</th>
            <th>Subject</th>
            <th>Grade</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($grades as $grade)
            <tr>
                <td>{{ $grade->student->name }}</td>
                <td>{{ $grade->subject->name }}</td>
                <td>{{ $grade->grade }}</td>
                <td>
                    @if ($grade->grade >= 1.0 && $grade->grade <= 3.0)
                        <span class="badge bg-success">Pass</span>
                    @elseif ($grade->grade > 3.0 && $grade->grade <= 5.0)
                        <span class="badge bg-danger">Fail</span>
                    @else
                        <span class="badge bg-secondary">Invalid</span>
                    @endif
                </td>
                <td>
                    <!-- Update Form -->

                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#Edit{{ $grade->id }}">
                        Edit
                    </button>

                    <!-- Delete Form -->
                    <form action="{{ route('grades.destroy', $grade->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete grade?');">Delete</button>
                    </form>
                </td>
            </tr>
            <div class="modal fade" id="Edit{{ $grade->id }}" tabindex="-1" aria-labelledby="Edit{{ $grade->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="Edit{{ $grade->id }}">Edit Grade</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                            <form action="{{ route('grades.update', $grade->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label>Student:</label>
                                    {{ $grade->student->name }}
                                </div>
                                <div class="mb-3">
                                    <label>Subject:</label>
                                    {{ $grade->subject->name }}
                                </div>
                                <div class="mb-3">
                                    <label>Grade:</label>
                                    <input type="number" name="grade" value="{{ $grade->grade }}" min="0" max="5" step="0.01" required>
                                </div>
                                <button type="submit" class="btn btn-success">Update Grade</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        @endforeach
    </tbody>
</table>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let students = @json($students);
        let subjects = @json($subjects);
        let enrolledStudents = students.filter(student => student.subjects.length > 0);
        
        let gradeButton = document.querySelector("[data-bs-target='#Grade']");
        if (enrolledStudents.length === 0) {
            gradeButton.disabled = true;
            gradeButton.title = "Students must be enrolled in a subject first.";
        }
    });
</script>


@if ($students instanceof \Illuminate\Pagination\LengthAwarePaginator)
    {{ $students->links() }}
@endif

@if ($subjects instanceof \Illuminate\Pagination\LengthAwarePaginator)
    {{ $subjects->links() }}
@endif

@if ($grades instanceof \Illuminate\Pagination\LengthAwarePaginator)
    {{ $grades->links() }}
@endif

   
</div>
@endsection
