
    @extends('layouts.dash')

    @section('views')
    <div class="container">
        <h3 class="mb-4">Student Management</h3>

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
                <form action="{{ route('enrollments.store') }}" method="POST">
                    @csrf

                    <!-- Select Student -->
                    <div class="mb-3">
                        <label>Student:</label>
                        @if(isset($students) && count($students) > 0)
                            <select class="form-control" name="student_id" required>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->user->name }}</option>
                                @endforeach
                            </select>
                        @else
                            <p>No students available</p>
                        @endif

                    </div>

                    <!-- Select Subject -->
                    <div class="mb-3">
                        <label>Select Subject:</label>
                        <select class="form-control" name="subject_id" required>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Select Schedule (Day of the Week) -->
                    <div class="mb-3">
                        <label>Select Schedule Day:</label>
                        <select class="form-control" name="schedule_day" required>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                        </select>
                    </div>

                    <!-- Select Time Range -->
                    <div class="mb-3">
                        <label>Start Time:</label>
                        <input type="time" class="form-control" name="schedule_start_time" required>
                    </div>

                    <div class="mb-3">
                        <label>End Time:</label>
                        <input type="time" class="form-control" name="schedule_end_time" required>
                    </div>

                    <button type="submit" class="btn btn-success mt-2">Enroll</button>
                </form>
            </div>
        </div>
    </div>
    </div>

 
<!-- Add Grade Modal -->
<div class="modal fade" id="Grade" tabindex="-1" aria-labelledby="Grade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addGradeModalLabel">Add Grade</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('grades.store') }}" method="POST">
                    @csrf

                    <!-- Select Student -->
                    <div class="mb-3">
                        <label for="student_id">Select Student:</label>
                        <select id="student_id" name="student_id" class="form-control" required>
                            <option value="">Select Student</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}">{{ $student->user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Select Subject (Filtered Based on Student) -->
                    <div class="mb-3">
                        <label for="subject_id">Select Subject:</label>
                        <select id="subject_id" name="subject_id" class="form-control" required>
                            <option value="">Select Student First</option>
                        </select>
                    </div>

                    <!-- Enter Grade -->
                    <div class="mb-3">
                        <label for="grade">Enter Grade:</label>
                        <input type="number" name="grade" class="form-control" placeholder="Enter Grade" required min="0" max="5" step="0.25">
                    </div>

                    <button type="submit" class="btn btn-success">Add Grade</button>
                </form>
            </div>
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
                                <label>Year Level:</label>
                                <select name="year" class="form-control" required>
                                    <option value="">Year Level</option>
                                    <option value="1st year">1st year</option>
                                    <option value="2nd year">2nd year</option>
                                    <option value="3rd year">3rd year</option>
                                    <option value="4th year">4th year</option>
                                </select>
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
                            <div class="mb-3">
                                <label>Unit:</label>
                                <input type="number" name="unit" class="form-control" step="0.25" required>
                            </div>
                            <button type="submit" class="btn btn-success">Add Subject</button>
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
            <h3 class="mb-4">Students</h3>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Gender</th>
                    <th>Year Level</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                    @foreach ($students as $student)
                    <tr>
                    <td>{{ $student->user->name ?? 'No User Found' }}</td>
                    <td>{{ $student->user->email ?? 'No Email' }}</td>
                    <td>{{ $student->user->phone ?? 'Not Found' }}</td>
                    <td>{{ $student->user->address ?? 'Not Found'}}</td>
                    <td>{{ $student->user->gender ?? 'Not Found' }}</td>
                    <td>{{ $student->user->year ?? 'Not Found' }}</td>
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
                            <input type="text" name="name" class="form-control" value="{{ $student->user->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Email:</label>
                            <input type="email" name="email" class="form-control" value="{{ $student->user->email }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Phone:</label>
                            <input type="text" name="phone" class="form-control" value="{{ $student->user->phone }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Address:</label>
                            <input type="text" name="address" class="form-control" value="{{ $student->user->address }}" required>
                        </div>
                        <div class="mb-3">
                                <label>Year Level:</label>
                                <select name="year" class="form-control" required>
                                    <option value="">Year Level</option>
                                    <option value="1st year" {{ $student->user->year == '1st year'}}>1st year</option>
                                    <option value="2nd year" {{ $student->user->year == '2nd year'}}>2nd year</option>
                                    <option value="3rd year" {{ $student->user->year == '3rd year'}}>3rd year</option>
                                    <option value="4th year" {{ $student->user->year == '4th year'}}>4th year</option>
                                </select>
                            </div>
                        <div class="mb-3">
                            <label>Gender:</label>
                            <select name="gender" class="form-control" required>
                                <option value="Male" {{ $student->user->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ $student->user->gender == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
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
            <h3 class="mb-4">Subjects</h3>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Unit</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subjects as $subject)
                    <tr>
                        <td>{{ $subject->name }}</td>
                        <td>{{ $subject->code }}</td>
                        <td>{{ $subject->description }}</td>
                        <td>{{ $subject->unit }}</td>
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
                                    <div class="mb-3">
                                        <label>Unit:</label>
                                        <input type="number" name="unit" class="form-control" value="{{ $subject->unit }}" step="0.25" required >
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
        <table class="table table-bordered">
    <h3 class="mb-4">Enrolled Students</h3>
    <thead>
        <tr>
            <th>Students</th>
            <th>Enrolled Subjects</th>
            <th>Units</th>
            <th>Schedule</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $student)
            <tr>
                <td>{{ $student->user->name }}</td>

                <td>
                    @if($student->enrollments->isNotEmpty())
                        {{ $student->enrollments->pluck('subject.name')->join(', ') }}
                    @else
                        No subjects enrolled
                    @endif
                </td>

                <!-- Calculate total units dynamically -->
                <td>
                    {{ $student->enrollments->sum(fn($enrollment) => $enrollment->subject->unit) }}
                </td>

                <!-- Display schedule -->
                <td>
                    @if($student->enrollments->isNotEmpty())
                        <ul>
                            @foreach($student->enrollments as $enrollment)
                                <li>
                                    <strong>{{ $enrollment->subject->name }}:</strong>
                                    {{ $enrollment->schedule_day }} 
                                    ({{ \Carbon\Carbon::parse($enrollment->schedule_start_time)->format('g:i A') }} - 
                                    {{ \Carbon\Carbon::parse($enrollment->schedule_end_time)->format('g:i A') }})
                                </li>
                            @endforeach
                        </ul>
                    @else
                        No schedule available
                    @endif
                </td>

                <!-- Action buttons -->
                <td>
                    @foreach($student->enrollments as $enrollment)
                        <form action="{{ route('enrollments.destroy', ['student' => $student->id, 'subject' => $enrollment->subject->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button style="margin-top: 2px; margin-bottom: 2px;" type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">
                                Remove [{{ $enrollment->subject->name }}]
                            </button>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#EditEnrollment{{ $enrollment->subject->id }}">
                            Edit [{{ $enrollment->subject->name }}]
                        </button>
                        </form>
                    @endforeach
                </td>
            </tr>
        @endforeach
    </tbody>
        </table>
    @foreach($student->enrollments as $enrollment)
    <!-- Edit Enrollment Modal -->
    <div class="modal fade" id="EditEnrollment{{ $enrollment->subject->id }}" tabindex="-1" aria-labelledby="editEnrollmentLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Schedule for {{ $enrollment->subject->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('enrollments.update', ['student' => $student->id, 'subject' => $enrollment->subject->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Select Schedule Day -->
                        <div class="mb-3">
                            <label>Select Schedule Day:</label>
                            <select class="form-control" name="schedule_day" required>
                                <option value="Monday" {{ $enrollment->schedule_day == 'Monday' ? 'selected' : '' }}>Monday</option>
                                <option value="Tuesday" {{ $enrollment->schedule_day == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                                <option value="Wednesday" {{ $enrollment->schedule_day == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                                <option value="Thursday" {{ $enrollment->schedule_day == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                                <option value="Friday" {{ $enrollment->schedule_day == 'Friday' ? 'selected' : '' }}>Friday</option>
                                <option value="Saturday" {{ $enrollment->schedule_day == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                                <option value="Sunday" {{ $enrollment->schedule_day == 'Sunday' ? 'selected' : '' }}>Sunday</option>
                            </select>
                        </div>

                        <!-- Select Start Time -->
                        <div class="mb-3">
                            <label>Start Time:</label>
                            <input type="time" class="form-control" name="schedule_start_time" value="{{ $enrollment->schedule_start_time }}" required>
                        </div>

                        <!-- Select End Time -->
                        <div class="mb-3">
                            <label>End Time:</label>
                            <input type="time" class="form-control" name="schedule_end_time" value="{{ $enrollment->schedule_end_time }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Schedule</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach



    <!-- Student Grades Table -->
<table class="table mt-4">
    <h3 class="mb-4">Student Grades</h3>
    <thead>
        <tr>
            <th>Student</th>
            <th>Subject</th>
            <th>Grade</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($grades as $grade)
            <tr>
                <td>{{ $student->user->name }}</td>
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
                    <!-- Edit Grade Button -->
                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editGradeModal{{ $grade->id }}">
                        Edit
                    </button>

                    <!-- Delete Grade Form -->
                    <form action="{{ route('grades.destroy', $grade->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete grade?');">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>

            <!-- Edit Grade Modal -->
          <!-- Edit Grade Modal -->
        <div class="modal fade" id="editGradeModal{{ $grade->id }}" tabindex="-1" aria-labelledby="editGradeModalLabel{{ $grade->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editGradeModalLabel{{ $grade->id }}">Edit Grade</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('grades.update', $grade->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Display Student Name -->
                            <div class="mb-3">
                                <label>Student:</label>
                                <p class="form-control-plaintext">{{ $grade->student->user->name }}</p>
                            </div>

                            <!-- Display Subject Name -->
                            <div class="mb-3">
                                <label>Subject:</label>
                                <p class="form-control-plaintext">{{ $grade->subject->name }}</p>
                            </div>

                            <!-- Input for Editing Grade -->
                            <div class="mb-3">
                                <label for="grade">Grade:</label>
                                <input type="number" name="grade" class="form-control" value="{{ $grade->grade }}" min="0" max="5" step="0.25" required>
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
    <script>
document.getElementById('student_id').addEventListener('change', function() {
    let studentId = this.value;
    let subjectDropdown = document.getElementById('subject_id');

    // Clear existing options
    subjectDropdown.innerHTML = '<option value="">Select Subject</option>';

    if (studentId) {
        fetch(`/get-enrolled-subjects/${studentId}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(subject => {
                    let option = document.createElement('option');
                    option.value = subject.id;
                    option.textContent = subject.name;
                    subjectDropdown.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching subjects:', error));
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
