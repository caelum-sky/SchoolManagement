
@extends('layouts.dash')

@section('enroll')
<div class="container">
    <h3 class="mb-4">Student Management</h3>

    <!-- Add Student Modal Trigger -->
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


    <!-- Add Student Modal -->


    <!-- Search Form -->


    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Students Table -->

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
                @endforeach
            </td>
        </tr>
    @endforeach
</tbody>
    </table>




<!-- Student Grades Table -->

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
