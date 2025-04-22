
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Predict Dropout Rate</h2>

    <form method="POST" action="{{ route('predict.run') }}">
        @csrf
        <div>
            <label>Gender</label>
            <input type="text" name="gender" required>
        </div>
        <div>
            <label>Age</label>
            <input type="number" name="age" required>
        </div>
        <div>
            <label>Region</label>
            <input type="text" name="region" required>
        </div>
        <div>
            <label>Grade</label>
            <input type="text" name="grade" required>
        </div>
        <button type="submit">Predict</button>
    </form>

    @if (isset($percentage))
        <div style="margin-top: 20px;">
            <strong>Estimated Dropout Rate:</strong> {{ $percentage }}%
        </div>
    @endif
</div>
@endsection
