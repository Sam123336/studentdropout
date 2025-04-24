<!-- resources/views/blog/public.blade.php -->
@extends('layouts.app')

@section('content')
<div class="py-10">
    <div class="container mx-auto px-4 max-w-5xl">
        <!-- 3D-style Header Section -->
        <div class="text-center mb-12">
            <h1 class="text-5xl md:text-6xl font-bold mb-4 text-white text-3d drop-shadow-[0_5px_5px_rgba(79,70,229,0.4)]">
                📰 Blog Sphere
            </h1>
            <p class="text-gray-300 text-lg max-w-2xl mx-auto text-shadow-sm">Discover thoughtful articles, stories, and insights from our community</p>
        </div>
        
        <!-- Blog Posts Container -->
        <div class="grid gap-8 md:grid-cols-2">
            @foreach ($blogs as $blog)
                <div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden card-3d">
                    <!-- Post Header -->
                    <div class="bg-indigo-700 py-4 px-6 relative z-10 shadow-md">
                        <h2 class="text-2xl font-bold text-white truncate text-shadow-md">{{ $blog->title }}</h2>
                    </div>
                    
                    <!-- Post Content -->
                    <div class="p-6 bg-gradient-to-b from-gray-800 to-gray-850">
                        <p class="text-gray-200 mb-6 leading-relaxed text-shadow-sm">{{ Str::limit($blog->content, 180) }}</p>
                        
                        <!-- Metadata Row -->
                        <div class="flex items-center justify-between border-t border-gray-700 pt-4">
                            <div class="flex items-center space-x-6">
                                <button 
                                    class="flex items-center focus:outline-none like-button transform transition-transform hover:scale-110" 
                                    data-blog-id="{{ $blog->id }}"
                                    data-liked="{{ auth()->check() && auth()->user() ? ($blog->likedBy(auth()->user()) ? 'true' : 'false') : 'false' }}"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                        class="h-5 w-5 icon-3d {{ auth()->check() && auth()->user() && $blog->likedBy(auth()->user()) ? 'text-red-500 fill-current' : 'text-red-400' }}" 
                                        viewBox="0 0 24 24" 
                                        stroke="currentColor"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    <span class="ml-1 text-gray-200 font-medium like-count">{{ $blog->likes()->count() }}</span>
                                </button>
                                
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400 icon-3d" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                    </svg>
                                    <span class="ml-1 text-gray-200 font-medium">{{ $blog->comments->count() ?? 0 }}</span>
                                </div>
                            </div>
                            
                            <a href="{{ route('blogs.show', $blog->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 rounded-lg text-white font-medium hover:bg-indigo-700 transition-colors duration-300 button-3d">
                                Read More
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Empty State -->
        @if ($blogs->isEmpty())
            <div class="bg-gray-800 rounded-xl border border-gray-700 p-12 text-center card-3d">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-indigo-400 mx-auto mb-4 icon-3d" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                <h3 class="text-2xl font-semibold text-white mb-2 text-shadow-md">No Blog Posts Yet</h3>
                <p class="text-gray-300 mb-6">Be the first to share your thoughts with our community!</p>
                <a href="{{ route('blogs.create') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 rounded-lg text-white font-medium hover:bg-indigo-700 transition-colors duration-300 button-3d">
                    Create New Post
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </a>
            </div>
        @endif
        
        <!-- Pagination with styled links -->
        @if(isset($blogs) && method_exists($blogs, 'links') && $blogs->hasPages())
            <div class="mt-10">
                <div class="pagination-dark">
                    {{ $blogs->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<style>
/* Custom styling for pagination in dark mode */
.pagination-dark nav {
    display: flex;
    justify-content: center;
}

.pagination-dark span, 
.pagination-dark a {
    margin: 0 0.25rem;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.pagination-dark span[aria-current="page"] span {
    background-color: #4f46e5;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0,0,0,0.4);
}

.pagination-dark a {
    background-color: #374151;
    color: #e5e7eb;
    transition: all 0.2s ease;
}

.pagination-dark a:hover {
    background-color: #4b5563;
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0,0,0,0.4);
}

.pagination-dark svg {
    height: 1rem;
    width: 1rem;
}

.like-button {
    cursor: pointer;
    position: relative;
}

.like-button:hover .icon-3d {
    filter: drop-shadow(0 0 4px rgba(248, 113, 113, 0.6));
}

.like-button.liked .icon-3d {
    fill: #ef4444;
    color: #ef4444;
    filter: drop-shadow(0 0 4px rgba(248, 113, 113, 0.6));
}

/* Animation for like button */
@keyframes likeAnimation {
    0% { transform: scale(1); }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); }
}

.like-button.animate .icon-3d {
    animation: likeAnimation 0.3s ease-in-out;
}

/* Add depth to the entire page */
body {
    background-color: #030712; /* Very dark background */
}
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const likeButtons = document.querySelectorAll('.like-button');
        
        likeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const blogId = this.getAttribute('data-blog-id');
                const isLiked = this.getAttribute('data-liked') === 'true';
                const likeCountElement = this.querySelector('.like-count');
                const likeIcon = this.querySelector('svg');
                
                // Add animation class
                this.classList.add('animate');
                
                // Make AJAX request to toggle like
                fetch(`/blogs/${blogId}/like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    if (!response.ok) {
                        if (response.status === 401) {
                            // User not authenticated, redirect to login
                            window.location.href = '{{ route("login") }}';
                            throw new Error('Please login to like posts');
                        }
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Update like count
                    likeCountElement.textContent = data.likesCount;
                    
                    // Toggle liked state
                    if (data.liked) {
                        this.setAttribute('data-liked', 'true');
                        this.classList.add('liked');
                        likeIcon.classList.add('text-red-500', 'fill-current');
                        likeIcon.classList.remove('text-red-400');
                    } else {
                        this.setAttribute('data-liked', 'false');
                        this.classList.remove('liked');
                        likeIcon.classList.remove('text-red-500', 'fill-current');
                        likeIcon.classList.add('text-red-400');
                    }
                    
                    // Remove animation class after animation completes
                    setTimeout(() => {
                        this.classList.remove('animate');
                    }, 300);
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Remove animation class if there's an error
                    setTimeout(() => {
                        this.classList.remove('animate');
                    }, 300);
                });
            });
        });
    });
</script>
@endpush
@endsection
