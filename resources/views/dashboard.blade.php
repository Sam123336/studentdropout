@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold mb-6">📊 Dashboard</h1>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 text-sm">
        <div class="bg-white shadow rounded-2xl p-4 flex items-center gap-4">
            <div class="text-3xl">👤</div>
            <div>
                <p class="text-gray-500 text-xs">TOTAL STUDENTS</p>
                <p class="font-semibold text-lg">
                    {{ isset($dropouts, $enrolled) ? $dropouts + $enrolled : 'N/A' }}
                </p>
            </div>
        </div>

        <div class="bg-white shadow rounded-2xl p-4 flex items-center gap-4">
            <div class="text-3xl">📉</div>
            <div>
                <p class="text-gray-500 text-xs">DROPOUT RATE</p>
                <p class="font-semibold text-lg">
                    {{ isset($dropouts, $enrolled) && ($dropouts + $enrolled) > 0 ? round(($dropouts / ($dropouts + $enrolled)) * 100, 2) . '%' : 'N/A' }}
                </p>
            </div>
        </div>

        <div class="bg-white shadow rounded-2xl p-4 flex items-center gap-4">
            <div class="text-3xl">📈</div>
            <div>
                <p class="text-gray-500 text-xs">PREDICTION RESULT</p>
                <p class="font-semibold text-lg">
                    {{ $percentage !== null ? $percentage . '%' : 'No prediction' }}
                </p>
            </div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 text-sm">
        <div class="bg-white p-4 rounded-2xl shadow">
            <h2 class="text-sm font-semibold mb-2">Dropout vs Enrolled</h2>
            {!! $chart->container() !!}
        </div>

        <div class="bg-white p-4 rounded-2xl shadow">
            <h2 class="text-sm font-semibold mb-2">Dropout Trends (Monthly)</h2>
            <div class="h-64 w-full">
                <canvas id="dropoutTrendsChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Region-Wise Dropout Table --}}
    <div class="bg-white mt-6 p-4 rounded-2xl shadow text-sm">
        <h2 class="text-sm font-semibold mb-4">Dropouts by Region</h2>
        <table class="table-auto w-full text-left">
            <thead>
                <tr class="text-gray-500 text-xs border-b">
                    <th class="pb-2">Region</th>
                    <th class="pb-2">Dropout Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dropoutData as $data)
                <tr class="border-b">
                    <td class="py-2">{{ $data->region }}</td>
                    <td class="py-2">{{ $data->dropout_count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
{{ $chart->script() }}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('dropoutTrendsChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($dropoutTrends->pluck('label')) !!},
            datasets: [{
                label: 'Dropouts',
                data: {!! json_encode($dropoutTrends->pluck('value')) !!},
                backgroundColor: 'rgba(255, 99, 132, 0.1)',
                borderColor: 'rgba(255, 99, 132, 1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection
