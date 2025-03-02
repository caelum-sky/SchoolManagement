
@extends('layouts.dash')
@section('title', 'Grades')
@section('grade')
<div class="container">


    <!-- Add Student Modal Trigger -->

    <button style="margin: 10px"  type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGradeModal">
    Add Grade
    </button>





<!-- Add Grade Modal -->
<div class="modal fade" id="addGradeModal" tabindex="-1" aria-labelledby="addGradeModalLabel" aria-hidden="true">
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



    <!-- Search Form -->


    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif


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
        <td>{{ $grade->student->user->name }}</td>
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
    let enrolledStudents = students.filter(student => student.subjects && student.subjects.length > 0);
    
    let gradeButton = document.querySelector("[data-bs-target='#Grade']");
    if (!enrolledStudents || enrolledStudents.length === 0) {
        gradeButton.disabled = true;
        gradeButton.title = "Students must be enrolled in a subject first.";
    } else {
        gradeButton.disabled = false; // Ensure button is enabled if students exist
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
