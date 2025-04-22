<!-- resources/views/blog/public.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6 text-center">📰 Public Blog Posts</h1>

    @foreach ($blogs as $blog)
        <div class="bg-white p-6 rounded-lg shadow-md mb-4">
            <h2 class="text-xl font-semibold mb-4">{{ $blog->title }}</h2>
            <p class="text-gray-800 mb-4">{{ Str::limit($blog->content, 150) }}</p>
            <a href="{{ route('blogs.show', $blog->id) }}" class="text-blue-500 hover:underline">Read More...</a>
        </div>
    @endforeach

    @if ($blogs->isEmpty())
        <p class="text-gray-500">No blog posts available. Be the first to write one!</p>
    @endif
</div>
@endsection
