<!-- resources/views/blog/show.blade.php -->
@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-10">
    <!-- Main Blog Content Card -->
    <div class="bg-gray-800 rounded-xl border border-gray-700 shadow-xl overflow-hidden card-3d mb-8">
        <!-- Post Header -->
        <div class="bg-indigo-700 py-4 px-6 relative z-10 shadow-md">
            <h2 class="text-2xl md:text-3xl font-bold text-white text-shadow-md">{{ $blog->title }}</h2>
        </div>
        
        <!-- Post Content -->
        <div class="p-6 md:p-8 bg-gradient-to-b from-gray-800 to-gray-850">
            <p class="text-gray-200 mb-8 leading-relaxed text-shadow-sm whitespace-pre-line">{{ $blog->content }}</p>
            
            <!-- Like Section -->
            <div class="flex flex-wrap items-center mb-4 pb-4 border-b border-gray-700">
                @auth
                    @if (!$blog->likedBy(auth()->user()))
                        <form method="POST" action="{{ route('blogs.like', $blog->id) }}">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 mr-4 button-3d flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 icon-3d" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                </svg>
                                Like
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('blogs.unlike', $blog->id) }}">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-rose-600 text-white rounded-lg hover:bg-rose-700 mr-4 button-3d flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 icon-3d" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2" />
                                </svg>
                                Unlike
                            </button>
                        </form>
                    @endif
                @else
                    <span class="text-gray-400 mr-4 px-4 py-2 bg-gray-700 rounded-lg">Login to like</span>
                @endauth
                
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-400 icon-3d" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <span class="ml-2 text-gray-200 font-medium">
                        {{ $blog->likes->count() }} {{ Str::plural('Like', $blog->likes->count()) }}
                    </span>
                </div>
            </div>
            
            <!-- Liked By Section -->
            <div class="mb-6 text-sm text-gray-400">
                @if($blog->likes->count() > 0)
                    <p class="mb-2 text-gray-300">Liked by:</p>
                    <div class="flex flex-wrap">
                        @foreach ($blog->likes as $like)
                            <span class="mr-2 mb-2 px-3 py-1 bg-gray-700 rounded-full text-gray-200">
                                {{ $like->user ? $like->user->name : 'Unknown' }}
                            </span>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Comments Section -->
    <div class="mb-8">
        <h3 class="text-xl font-bold mb-4 text-white text-shadow-md flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-400 icon-3d" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
            </svg>
            Comments ({{ $comments->count() }})
        </h3>
        
        <div class="space-y-4">
            @forelse($comments as $comment)
                <div class="bg-gray-800 border-l-4 border-blue-500 rounded-r-lg p-4 card-3d transform hover:-translate-y-1 transition-all duration-200">
                    <div class="font-semibold text-blue-300 mb-1">
                        {{ $comment->user ? $comment->user->name : 'Unknown User' }}
                    </div>
                    <div class="text-gray-200 text-shadow-sm">{{ $comment->content }}</div>
                    <div class="text-xs text-gray-400 mt-2">{{ $comment->created_at->diffForHumans() }}</div>
                </div>
            @empty
                <div class="bg-gray-800 rounded-lg p-6 text-gray-400 text-center card-3d">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-3 text-gray-500 icon-3d" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <p>No comments yet. Be the first to share your thoughts!</p>
                </div>
            @endforelse
        </div>
    </div>
    
    <!-- Comment Form -->
    @auth
    <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 card-3d">
        <h4 class="text-lg font-medium mb-4 text-white text-shadow-sm">Add a Comment</h4>
        <form method="POST" action="{{ route('blogs.comment', $blog->id) }}">
            @csrf
            <div class="mb-4">
                <textarea name="content" placeholder="Share your thoughts..." 
                    class="w-full p-3 rounded-lg border border-gray-600 bg-gray-700 text-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" 
                    rows="3" required></textarea>
            </div>
            <button type="submit" class="bg-blue-600 text-white rounded-lg px-5 py-2.5 button-3d flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
                Post Comment
            </button>
        </form>
    </div>
    @else
        <div class="text-gray-300 bg-gray-800 p-6 rounded-xl border border-gray-700 card-3d text-center">
            Please <a href="{{ route('login') }}" class="text-blue-400 underline hover:text-blue-300">login</a> to join the conversation.
        </div>
    @endauth
    
    <!-- Back to Blog Link -->
    <div class="mt-8 text-center">
        <a href="{{ route('blogs.index') }}" class="inline-flex items-center text-blue-400 hover:text-blue-300 text-shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to All Posts
        </a>
    </div>
</div>
@endsection