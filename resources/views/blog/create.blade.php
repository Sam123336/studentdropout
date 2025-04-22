@extends('layouts.app')

@section('content')
    <h2>Write Your Thoughts on Dropping Out</h2>
    <form action="{{ route('blogs.store') }}" method="POST">
        @csrf
        <label>Title: <input type="text" name="title" required></label><br>
        <label>Content:</label><br>
        <textarea name="content" rows="5" required></textarea><br>
        <button type="submit">Post Blog</button>
    </form>
@endsection
