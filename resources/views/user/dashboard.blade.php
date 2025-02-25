@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Student Dashboard</h1>
        <h3>Your Enrolled Subjects</h3>

        @if(isset($subjects) && $subjects->isNotEmpty())
            <table class="table">
                <thead>
                    <tr>
                        <th>Subject Name</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subjects as $subject)
                        <tr>
                            <td>{{ $subject->name }}</td>
                            <td>{{ $subject->pivot->grade ?? 'Pending' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>You are not enrolled in any subjects.</p>
        @endif
    </div>
@endsection
