@extends('layouts.app')

@section('content')
    <h1>Add Student</h1>

    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    @if(session('dropout_percentage') !== null)
        <p>Dropout rate for similar students: <strong>{{ session('dropout_percentage') }}%</strong></p>
    @endif

    @if($errors->any())
        <div style="color: red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('student.store') }}" method="POST">
        @csrf

        <label>Gender:
            <input type="text" name="gender" value="{{ old('gender') }}" required>
        </label><br>

        <label>Age:
            <input type="number" name="age" value="{{ old('age') }}" required>
        </label><br>

        <label>Region:
            <input type="text" name="region" value="{{ old('region') }}" required>
        </label><br>

        <label>Dropout Status (1 = Yes, 0 = No):
            <input type="number" name="dropout_status" min="0" max="1" value="{{ old('dropout_status') }}" required>
        </label><br>

        <label>Grade Average:
            <input type="number" step="0.01" name="grade_avg" value="{{ old('grade_avg') }}" required>
        </label><br>

        <button type="submit">Add</button>
    </form>
@endsection
