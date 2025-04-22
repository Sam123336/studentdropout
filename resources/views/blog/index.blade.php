

@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white text-black py-10 px-4">
    <div class="max-w-3xl mx-auto">

        <h1 class="text-4xl font-bold mb-6 text-center text-black">🎓 Dropout Predictor & Public Blog</h1>

        {{-- Dropout Prediction Form --}}
        <form method="POST" action="{{ route('predict.run') }}" class="bg-gray-100 p-6 rounded-lg shadow mb-6 text-black">
            @csrf
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <input type="text" name="gender" placeholder="Gender (M/F)" required class="px-4 py-2 rounded bg-gray-200 text-black placeholder-black">
                <input type="number" name="age" placeholder="Age" required class="px-4 py-2 rounded bg-gray-200 text-black placeholder-black">
                <input type="text" name="region" placeholder="Region" required class="px-4 py-2 rounded bg-gray-200 text-black placeholder-black">
            </div>
            <button type="submit" class="mt-4 w-full bg-purple-600 hover:bg-purple-700 text-black font-semibold py-2 px-4 rounded transition">
                🔍 Predict Dropout Risk
            </button>
        </form>

        {{-- Dropout Chart --}}
        @if (isset($percentage))
        <div class="bg-gray-100 p-6 rounded-lg shadow-md mb-6 text-black">
            <h2 class="text-xl font-semibold mb-4 text-black">📊 Dropout Risk Chart</h2>

            @if(isset($chart))
                <div class="mb-4">{!! $chart->container() !!}</div>
            @else
                <canvas id="dropoutChart" height="100"></canvas>
            @endif

            <p class="mt-4 text-lg text-black">Estimated Dropout Chance: <strong class="text-black">{{ $percentage }}%</strong></p>
        </div>
        @endif

        {{-- Blog Submission Form --}}
        <div class="bg-gray-100 p-6 rounded-lg shadow-md mb-6 text-black">
            <h2 class="text-xl font-semibold mb-4 text-black">📝 Share a Thought</h2>
            <form method="POST" action="{{ route('blogs.store') }}">
                @csrf
                <input 
                    type="text"
                    name="title"
                    required
                    placeholder="Blog Title"
                    class="w-full p-4 rounded bg-gray-200 text-black mb-4 placeholder-black"
                />
                <textarea name="content" rows="4" required placeholder="Write your blog post..." class="w-full p-4 rounded bg-gray-200 text-black resize-none placeholder-black mb-4"></textarea>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded transition">
                    🚀 Post Blog
                </button>
            </form>
        </div>

        {{-- Blog Posts --}}
        <div class="bg-gray-100 p-6 rounded-lg shadow text-black">
            <h2 class="text-xl font-semibold mb-4 text-black">📰 Public Blog Feed</h2>
            @forelse ($blogs as $blog)
                <div class="border-b border-gray-400 pb-4 mb-4">
                    <h3 class="text-2xl font-bold text-black mb-2">{{ $blog->title }}</h3>
                    <p class="text-black">{{ $blog->content }}</p>
                    <p class="text-sm text-black mt-2">Posted on {{ $blog->created_at->format('F j, Y') }}</p>
                </div>
            @empty
                <p class="text-black">No blog posts yet. Be the first to share something!</p>
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
                    backgroundColor: ['rgba(255, 99, 132, 0.6)'],
                    borderColor: ['rgba(255, 99, 132, 1)'],
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
