

@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-tr from-purple-100 via-pink-100 to-blue-100 text-black py-10 px-4">
    <div class="max-w-4xl mx-auto">

        {{-- HEADER --}}
        <div class="mb-10 flex flex-col gap-2 items-center">
            <h1 class="text-4xl md:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-tr from-indigo-700 via-pink-600 to-green-600 mb-2 text-center drop-shadow">
                🎓 Dropout Predictor <span class="hidden sm:inline">&</span> <span class="block sm:inline">Public Blog</span>
            </h1>
            <p class="text-md text-gray-700 max-w-2xl text-center mb-1">Predict dropout chance and join the conversation with students around you. Share your thoughts and experiences, or read what others are saying!</p>
        </div>

        {{-- Dropout Prediction --}}
        <div class="bg-white/80 border border-blue-200 p-6 md:p-8 rounded-xl shadow-xl mb-10 backdrop-blur-md transition hover:shadow-2xl">
            <form method="POST" action="{{ route('predict.run') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <input type="text" name="gender" placeholder="Gender (M/F)" required class="px-4 py-3 rounded-lg border bg-gray-100 text-black placeholder-gray-500 focus:ring-purple-400 focus:outline-none transition">
                    <input type="number" name="age" placeholder="Age" required class="px-4 py-3 rounded-lg border bg-gray-100 text-black placeholder-gray-500 focus:ring-purple-400 focus:outline-none transition">
                    <input type="text" name="region" placeholder="Region" required class="px-4 py-3 rounded-lg border bg-gray-100 text-black placeholder-gray-500 focus:ring-purple-400 focus:outline-none transition">
                </div>
                <button type="submit" class="mt-6 w-full py-3 bg-gradient-to-tr from-purple-600 to-pink-500 hover:from-purple-800 hover:to-pink-700 text-white font-bold text-lg rounded-lg shadow hover:shadow-lg transition-all duration-200">
                    🔍 Predict Dropout Risk
                </button>
            </form>
            @if (isset($percentage))
                <div class="mt-8 bg-purple-50/60 p-6 rounded-lg border-t-4 border-pink-400">
                    <h2 class="text-xl font-bold text-purple-800 mb-4 flex items-center"><span class="mr-2">📊</span> Dropout Risk Chart</h2>
                    @if(isset($chart))
                        <div class="mb-4 mx-auto max-w-xs">{!! $chart->container() !!}</div>
                    @else
                        <div class="mb-4 mx-auto max-w-xs"><canvas id="dropoutChart" height="120"></canvas></div>
                    @endif
                    <p class="mt-2 text-lg text-purple-700">Estimated Dropout Chance: <strong class="font-bold text-pink-700">{{ $percentage }}%</strong></p>
                </div>
            @endif
        </div>

        {{-- Blog Submission Form --}}
        <div class="bg-gradient-to-tr from-green-100 via-blue-100 to-pink-100 border border-gray-200 p-6 md:p-8 rounded-xl shadow-lg mb-10 transition hover:shadow-2xl">
            <h2 class="text-2xl font-bold mb-4 text-blue-700 flex items-center"><span class="mr-2">📝</span> Share a Thought</h2>
            <form method="POST" action="{{ route('blogs.store') }}" class="space-y-4">
                @csrf
                <input 
                    type="text"
                    name="title"
                    required
                    placeholder="Blog Title"
                    class="w-full p-4 rounded-md border bg-gray-100 text-black placeholder-gray-500 focus:ring-pink-300 focus:outline-none transition"
                />
                <textarea name="content" rows="4" required placeholder="Write your blog post..." class="w-full p-4 rounded-md border bg-gray-100 text-black resize-none placeholder-gray-500 focus:ring-blue-300 focus:outline-none transition"></textarea>
                <button type="submit" class="bg-gradient-to-r from-green-500 to-pink-500 hover:from-green-600 hover:to-pink-600 text-white font-bold py-3 px-8 rounded-full transition-all duration-200 shadow-lg hover:shadow-none">
                    🚀 Post Blog
                </button>
            </form>
        </div>

        {{-- Blog Feed --}}
        <div class="bg-white/90 border border-indigo-200 p-6 md:p-8 rounded-xl shadow-xl">
            <h2 class="text-2xl font-bold mb-6 text-indigo-800 flex items-center"><span class="mr-2">📰</span> Public Blog Feed</h2>
            @forelse ($blogs as $blog)
                <div class="flex gap-4 items-start border-b border-gray-300 pb-6 mb-6 animate__animated animate__fadeIn">
                    {{-- Avatar/Initials - could add author avatar logic --}}
                    <div class="flex-shrink-0 w-14 h-14 rounded-full bg-gradient-to-tr from-purple-300 to-pink-300 flex items-center justify-center text-2xl font-bold text-white shadow">
                        {{ strtoupper(mb_substr($blog->title, 0, 1)) }}
                    </div>
                    <div class="flex-grow">
                        <h3 class="text-xl font-extrabold text-gray-900 mb-1 hover:underline">{{ $blog->title }}</h3>
                        <p class="text-gray-800 leading-relaxed mb-2">{{ $blog->content }}</p>
                        <div class="flex justify-between items-center text-xs text-gray-600 mt-2">
                            <span>📅 {{ $blog->created_at->format('F j, Y, g:i a') }}</span>
                            {{-- could add future actions like like or comment count --}}
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-600 text-center">No blog posts yet. Be the first to share something inspirational!</p>
            @endforelse
        </div>

    </div>
</div>
@endsection

@section('scripts')
    @if(isset($chart))
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        {{ $chart->script() }}
    @elseif(isset($percentage))
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
        const ctx = document.getElementById('dropoutChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Dropout Risk'],
                datasets: [{
                    label: 'Dropout Probability (%)',
                    data: [{{ $percentage }}],
                    backgroundColor: ['rgba(236, 72, 153, 0.7)'],
                    borderColor: ['rgba(139, 92, 246, 0.9)'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });
        </script>
    @endif
@endsection
