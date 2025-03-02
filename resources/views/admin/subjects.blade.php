@extends('layouts.dash')
@section('title', 'Subjects')
@section('subject')
<div class="container">


    <button style="margin: 10px"  type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#Subject">
        Add Subject
    </button>

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

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

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
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#EditSubjectModal{{ $subject->id }}">
                            Edit
                        </button>

                        <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</button>
                        </form>
                    </td>
                </tr>

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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let students = @json($students);
            let subjects = @json($subjects);
            let enrolledStudents = students.filter(student => student.subjects.length > 0);
            
            let gradeButton = document.querySelector("[data-bs-target='#Grade']");
            if (gradeButton && enrolledStudents.length === 0) {
                gradeButton.disabled = true;
                gradeButton.title = "Students must be enrolled in a subject first.";
            }
        });
    </script>

    <script>
        document.getElementById('student_id')?.addEventListener('change', function() {
            let studentId = this.value;
            let subjectDropdown = document.getElementById('subject_id');
            
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

    @if (isset($grades) && $grades instanceof \Illuminate\Pagination\LengthAwarePaginator)
        {{ $grades->links() }}
    @endif
</div>
@endsection
