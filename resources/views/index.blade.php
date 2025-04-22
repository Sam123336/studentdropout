
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6 text-center">🎓 Dropout Predictor & Blog</h1>

    {{-- Dropout Prediction Form --}}
    {{-- Predictor Form --}}
    <form method="POST" action="{{ route('dashboard') }}" class="bg-white p-4 rounded shadow-md mb-6">
        @csrf
        <div class="flex flex-wrap gap-4">
            <input type="text" name="region" placeholder="Region" required class="border px-4 py-2 rounded" />
            <input type="text" name="grade" placeholder="Grade" required class="border px-4 py-2 rounded" />
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Predict</button>
        </div>
    </form>

    @if ($percentage !== null)
        <div class="bg-gray-100 p-4 rounded mt-4">
            💡 Estimated Dropout Rate: <strong>{{ $percentage }}%</strong>
        </div>
    @endif

    {{-- Dropout Result and Blog Form --}}
    @if (isset($percentage) && $percentage !== null)
    <div class="bg-gray-100 p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-xl font-semibold mb-4">📊 Dropout Risk Chart</h2>
        <canvas id="dropoutChart" height="100"></canvas>
        <p class="mt-4 text-lg">🔍 Dropout chance for students like you: <strong>{{ $percentage }}%</strong></p>
    </div>

    {{-- Blog Submission Form --}}
    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-xl font-semibold mb-2">📝 Share Your Thoughts</h2>
        <form method="POST" action="{{ route('blogs.store') }}">
            @csrf
            <textarea name="content" placeholder="Write your thoughts..." required
                class="w-full border border-gray-300 rounded px-4 py-2 mb-4 resize-none" rows="4"></textarea>
            <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded hover:bg-purple-700 transition">
                Post Blog
            </button>
        </form>
    </div>
    @endif

    {{-- Blog Posts --}}
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">📰 Recent Blog Posts</h2>
        @forelse ($blogs as $blog)
        <div class="border-b border-gray-200 pb-4 mb-4">
            <p class="text-gray-800">{{ $blog->content }}</p>
            <p class="text-sm text-gray-500 mt-2">Posted on {{ $blog->created_at->format('F j, Y') }}</p>
        </div>
        @empty
        <p class="text-gray-500">No blog posts yet. Be the first to write one!</p>
        @endforelse
    </div>

</div>
@endsection

@section('scripts')
@if (isset($percentage))
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
