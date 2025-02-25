<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - SB Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="styalesheet" />
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
        <script src="{{ asset('js/scripts.js') }}"></script>
        <script src="{{ asset('assets/js/scripts.js') }}"></script>

        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">Start Bootstrap</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li>                        <form class="dropdown-item" method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>

                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Start Bootstrap
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>

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
        </tr>
    </thead>
    <tbody>
        @foreach ($grades as $grade)
            <tr>
                <td>{{ $grade->student->name }}</td>
                <td>{{ $grade->subject->name }}</td>
                <td>{{ $grade->grade }}</td>
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


                </main>

                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>


        <script>
    $(document).ready(function() {
        $('#addStudentForm').submit(function(event) {
            event.preventDefault(); 
            $.ajax({
                url: "{{ route('students.store') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    if(response.success) {
                        $('#createStudentModal').modal('hide');
                        let student = response.student;
                        $('#studentTable tbody').append(`
                            <tr>
                                <td>${student.name}</td>
                                <td>${student.email}</td>
                                <td>${student.phone}</td>
                                <td>${student.address}</td>
                                <td>${student.gender}</td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#EditStudentModal${student.id}">Edit</button>
                                    <form action="/students/${student.id}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        `);
                        $('#addStudentForm')[0].reset();
                    }
                }
            });
        });
    });
</script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
