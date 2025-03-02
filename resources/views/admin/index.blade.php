
    @extends('layouts.dash')

    @section('views')
    <div class="container">
        <h3 class="mb-4">Student Management</h3>

        <!-- Add Student Modal Trigger -->
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createStudentModal">
            Add Student
        </button>


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
