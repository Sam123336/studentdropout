@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 p-4">
  <h1 class="text-2xl font-bold text-center mb-6 text-indigo-700">DROPOUT ANALYSER</h1>

  {{-- Summary Cards --}}
  <div class="grid grid-cols-1 sm:grid-cols-4 gap-3 mb-6">
    <div class="bg-white rounded-lg p-3 shadow-sm text-center">
      <div class="text-xs text-gray-500 mb-1">TOTAL STUDENTS</div>
      <div class="text-lg font-bold">{{ number_format($dropouts + $enrolled) }}</div>
    </div>
    <div class="bg-white rounded-lg p-3 shadow-sm text-center">
      <div class="text-xs text-gray-500 mb-1">DROPOUT RATE</div>
      <div class="text-lg font-bold">{{ $dropouts + $enrolled > 0 ? round(($dropouts / ($dropouts + $enrolled)) * 100, 2) : 0 }}%</div>
    </div>
    <div class="bg-white rounded-lg p-3 shadow-sm text-center">
      <div class="text-xs text-gray-500 mb-1">PREDICTED DROPOUTS</div>
      <div class="text-lg font-bold">{{ $percentage ?? 'N/A' }}</div>
    </div>
    <div class="bg-white rounded-lg p-3 shadow-sm text-center">
      <div class="text-xs text-gray-500 mb-1">DROPOUT RATE BY YEAR</div>
      <div class="text-xs text-blue-500">see chart →</div>
    </div>
  </div>

  {{-- Charts Row --}}
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    {{-- Dropouts by Department --}}
    <div class="bg-white p-3 rounded-lg shadow-sm">
      <h3 class="text-sm font-semibold mb-2 text-gray-700">Dropouts by Region</h3>
      <div class="h-40">
        <canvas id="regionChart"></canvas>
      </div>
    </div>
    
    {{-- Dropout Reasons --}}
    <div class="bg-white p-3 rounded-lg shadow-sm">
      <h3 class="text-sm font-semibold mb-2 text-gray-700">Dropout Trends</h3>
      <div class="h-40">
        <canvas id="trendChart"></canvas>
      </div>
    </div>
  </div>

  {{-- Student Table --}}
  <div class="bg-white p-3 rounded-lg shadow-sm">
    <h3 class="text-sm font-semibold mb-2 text-gray-700">STUDENT LIST</h3>
    <div class="overflow-x-auto">
      <table class="min-w-full text-xs">
        <thead>
          <tr class="border-b text-gray-600">
            <th class="py-1 px-2 text-left">Name</th>
            <th class="py-1 px-2 text-left">Region</th>
            <th class="py-1 px-2 text-left">Age</th>
            <th class="py-1 px-2 text-left">Grade</th>
            <th class="py-1 px-2 text-left">Status</th>
            <th class="py-1 px-2 text-left">Risk Level</th>
          </tr>
        </thead>
        <tbody>
          @foreach($students as $student)
          <tr class="border-b">
            <td class="py-1 px-2">{{ $student->name ?? 'N/A' }}</td>
            <td class="py-1 px-2">{{ $student->region }}</td>
            <td class="py-1 px-2">{{ $student->age }}</td>
            <td class="py-1 px-2">{{ $student->grade_avg }}</td>
            <td class="py-1 px-2">
              <span class="{{ $student->dropout_status ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }} px-1 rounded">
                {{ $student->dropout_status ? 'Dropped' : 'Enrolled' }}
              </span>
            </td>
            <td class="py-1 px-2">
              @php
                $risk = $student->grade_avg < 70 ? 'High' : 
                       ($student->grade_avg < 80 ? 'Medium' : 'Low');
              @endphp
              <span class="{{ 
                $risk === 'High' ? 'bg-red-100 text-red-800' : 
                ($risk === 'Medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') 
              }} px-1 rounded">
                {{ $risk }}
              </span>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    // Region Chart
    new Chart(document.getElementById('regionChart'), {
      type: 'bar',
      data: {
        labels: @json($dropoutData->pluck('region')),
        datasets: [{
          label: 'Dropouts',
          data: @json($dropoutData->pluck('dropout_count')),
          backgroundColor: '#3b82f6'
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: { beginAtZero: true }
        },
        plugins: {
          legend: { display: false }
        }
      }
    });

    // Trend Chart
    new Chart(document.getElementById('trendChart'), {
      type: 'line',
      data: {
        labels: @json($dropoutTrends->pluck('label')),
        datasets: [{
          label: 'Dropouts',
          data: @json($dropoutTrends->pluck('value')),
          borderColor: '#3b82f6',
          backgroundColor: 'rgba(59, 130, 246, 0.1)',
          fill: true,
          tension: 0.4
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false }
        }
      }
    });
  </script>
</div>
@endsection