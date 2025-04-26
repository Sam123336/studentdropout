@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-200 flex flex-col gap-6 p-4 md:p-6 lg:p-8">
    <header class="relative overflow-hidden bg-white rounded-xl shadow-lg p-5 mb-2 transform hover:scale-[1.01] transition-all duration-300">
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-500/10 to-purple-500/10"></div>
        <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800 flex items-center gap-3">
            <i class="fas fa-graduation-cap text-indigo-600 animate-pulse"></i>
            Student Dropout Dashboard
            <span class="ml-2 text-sm font-normal text-gray-500 hidden md:inline-block">Real-time analytics</span>
        </h1>
    </header>

    <!-- Key Stats -->
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4">
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 p-4 flex flex-col items-center relative overflow-hidden group">
            <div class="absolute inset-0 bg-indigo-500/5 transform scale-y-0 group-hover:scale-y-100 transition-transform duration-500 origin-bottom"></div>
            <div class="z-10 flex flex-col items-center">
                <i class="fas fa-users text-xl md:text-2xl text-indigo-600 mb-2 group-hover:scale-110 transition-transform"></i>
                <div class="text-xs text-gray-500 uppercase tracking-wider">Total Students</div>
                <div class="text-lg md:text-xl font-bold text-gray-800">{{ $totalStudents ?? 'N/A' }}</div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 p-4 flex flex-col items-center relative overflow-hidden group">
            <div class="absolute inset-0 bg-red-500/5 transform scale-y-0 group-hover:scale-y-100 transition-transform duration-500 origin-bottom"></div>
            <div class="z-10 flex flex-col items-center">
                <i class="fas fa-sign-out-alt text-xl md:text-2xl text-red-500 mb-2 group-hover:scale-110 transition-transform"></i>
                <div class="text-xs text-gray-500 uppercase tracking-wider">Dropout Rate</div>
                <div class="text-lg md:text-xl font-bold text-gray-800">{{ $dropoutRate ?? 'N/A' }}%</div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 p-4 flex flex-col items-center relative overflow-hidden group">
            <div class="absolute inset-0 bg-green-500/5 transform scale-y-0 group-hover:scale-y-100 transition-transform duration-500 origin-bottom"></div>
            <div class="z-10 flex flex-col items-center">
                <i class="fas fa-chart-line text-xl md:text-2xl text-green-500 mb-2 group-hover:scale-110 transition-transform"></i>
                <div class="text-xs text-gray-500 uppercase tracking-wider">Predicted Dropouts</div>
                <div class="text-lg md:text-xl font-bold text-gray-800">{{ $percentage ?? 'N/A' }}</div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 p-4 flex flex-col items-center relative overflow-hidden group">
            <div class="absolute inset-0 bg-blue-500/5 transform scale-y-0 group-hover:scale-y-100 transition-transform duration-500 origin-bottom"></div>
            <div class="z-10 flex flex-col items-center">
                <i class="fas fa-user-clock text-xl md:text-2xl text-blue-500 mb-2 group-hover:scale-110 transition-transform"></i>
                <div class="text-xs text-gray-500 uppercase tracking-wider">Avg Student Age</div>
                <div class="text-lg md:text-xl font-bold text-gray-800">{{ isset($avgAge) ? number_format($avgAge, 1) : 'N/A' }}</div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
        <!-- Pie Chart: Dropout vs Enrolled -->
        <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-indigo-500/5"></div>
            <h3 class="text-sm md:text-md font-semibold text-gray-700 mb-2 flex items-center gap-2">
                <i class="fas fa-chart-pie text-indigo-500"></i>
                Dropout vs Enrolled
            </h3>
            <div class="relative h-64">
                <canvas id="pieChart"></canvas>
            </div>
        </div>
        
        <!-- Doughnut Chart: Risk Level -->
        <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-green-500/5 to-yellow-500/5"></div>
            <h3 class="text-sm md:text-md font-semibold text-gray-700 mb-2 flex items-center gap-2">
                <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                Risk Level Distribution
            </h3>
            <div class="relative h-64">
                <canvas id="riskLevelChart"></canvas>
            </div>
        </div>
        
        <!-- Bar Chart: Dropouts by Region -->
        <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-pink-500/5"></div>
            <h3 class="text-sm md:text-md font-semibold text-gray-700 mb-2 flex items-center gap-2">
                <i class="fas fa-map-marker-alt text-purple-500"></i>
                Dropouts by Region
            </h3>
            <div class="relative h-64">
                <canvas id="regionBarChart"></canvas>
            </div>
        </div>
        
        <!-- Line Chart: Dropout Trends -->
        <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-teal-500/5 to-blue-500/5"></div>
            <h3 class="text-sm md:text-md font-semibold text-gray-700 mb-2 flex items-center gap-2">
                <i class="fas fa-chart-line text-teal-500"></i>
                Dropout Trends
            </h3>
            <div class="relative h-64">
                <canvas id="trendLineChart"></canvas>
            </div>
        </div>
        
        <!-- Area Chart: Grade Distribution -->
        <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 md:col-span-2 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-cyan-500/5"></div>
            <h3 class="text-sm md:text-md font-semibold text-gray-700 mb-2 flex items-center gap-2">
                <i class="fas fa-poll text-emerald-500"></i>
                Grade Distribution
            </h3>
            <div class="relative h-64">
                <canvas id="gradeAreaChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Student List Table -->
    <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-gray-500/5 to-slate-500/5"></div>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-3">
            <h3 class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                <i class="fas fa-list text-slate-500"></i>
                STUDENT LIST
            </h3>
            <div class="flex space-x-2">
                <div class="relative">
                    <input type="text" placeholder="Search students..." class="text-xs px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full sm:w-auto" />
                    <i class="fas fa-search absolute right-3 top-2 text-gray-400"></i>
                </div>
                <button class="px-3 py-2 bg-indigo-100 text-indigo-700 rounded-lg text-xs font-medium hover:bg-indigo-200 transition-colors flex items-center gap-1">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <button class="px-3 py-2 bg-green-100 text-green-700 rounded-lg text-xs font-medium hover:bg-green-200 transition-colors flex items-center gap-1">
                    <i class="fas fa-download"></i> Export
                </button>
            </div>
        </div>
        <div class="overflow-x-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100 rounded-lg">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-600">
                        <th class="py-3 px-3 text-left font-medium rounded-tl-lg">Name</th>
                        <th class="py-3 px-3 text-left font-medium">Region</th>
                        <th class="py-3 px-3 text-left font-medium">Age</th>
                        <th class="py-3 px-3 text-left font-medium">Grade</th>
                        <th class="py-3 px-3 text-left font-medium">Status</th>
                        <th class="py-3 px-3 text-left font-medium rounded-tr-lg">Risk Level</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr class="border-b hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-3 font-medium">{{ $student->name ?? 'N/A' }}</td>
                            <td class="py-3 px-3">{{ $student->Address ?? 'N/A' }}</td>
                            <td class="py-3 px-3">{{ $student->Age ?? 'N/A' }}</td>
                            <td class="py-3 px-3">{{ $student->Final_Grade ?? 'N/A' }}</td>
                            <td class="py-3 px-3">
                                <span class="{{ $student->Dropped_Out ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }} px-2 py-1 rounded-full text-xs font-medium">
                                    {{ $student->Dropped_Out ? 'Dropped' : 'Enrolled' }}
                                </span>
                            </td>
                            <td class="py-3 px-3">
                                @php
                                    $grade = $student->Final_Grade ?? null;
                                    if ($grade === null) {
                                        $risk = 'N/A';
                                        $riskColor = 'bg-gray-100 text-gray-800';
                                        $riskIcon = 'fa-question-circle';
                                    } else {
                                        if ($grade < 70) {
                                            $risk = 'High';
                                            $riskColor = 'bg-red-100 text-red-800';
                                            $riskIcon = 'fa-exclamation-circle';
                                        } elseif ($grade < 80) {
                                            $risk = 'Medium';
                                            $riskColor = 'bg-yellow-100 text-yellow-800';
                                            $riskIcon = 'fa-exclamation-triangle';
                                        } else {
                                            $risk = 'Low';
                                            $riskColor = 'bg-green-100 text-green-800';
                                            $riskIcon = 'fa-check-circle';
                                        }
                                    }
                                @endphp
                                <span class="{{ $riskColor }} px-2 py-1 rounded-full text-xs font-medium flex items-center gap-1 w-fit">
                                    <i class="fas {{ $riskIcon }}"></i> {{ $risk }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
            <div class="text-sm text-gray-500">
                Showing {{ $students->count() }} of {{ $totalStudents ?? $students->count() }} students
            </div>
            <div class="flex gap-1">
                <button class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 transition-colors">
                    <i class="fas fa-chevron-left text-gray-600"></i>
                </button>
                <button class="w-8 h-8 flex items-center justify-center rounded-full bg-indigo-500 text-white">1</button>
                <button class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 transition-colors">2</button>
                <button class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 transition-colors">3</button>
                <button class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 transition-colors">
                    <i class="fas fa-chevron-right text-gray-600"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Custom styles for better aesthetics */
    .scrollbar-thin::-webkit-scrollbar {
        height: 6px;
        width: 6px;
    }
    .scrollbar-thin::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .scrollbar-thin::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-5px); }
        100% { transform: translateY(0px); }
    }
    
    .icon-float {
        animation: float 3s ease-in-out infinite;
    }
    
    /* Add some depth effects */
    .text-3d {
        text-shadow: 1px 1px 1px rgba(0,0,0,0.1);
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Common chart options for consistency
    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        animation: {
            duration: 1000,
            easing: 'easeOutQuart'
        },
        plugins: {
            legend: {
                labels: {
                    font: {
                        family: "'Inter', 'Helvetica', 'Arial', sans-serif",
                        size: 12
                    },
                    boxWidth: 15,
                    padding: 15
                },
                position: 'bottom'
            },
            tooltip: {
                backgroundColor: 'rgba(17, 24, 39, 0.8)',
                titleFont: {
                    family: "'Inter', 'Helvetica', 'Arial', sans-serif",
                    size: 13
                },
                bodyFont: {
                    family: "'Inter', 'Helvetica', 'Arial', sans-serif",
                    size: 12
                },
                padding: 10,
                cornerRadius: 8,
                displayColors: true,
                usePointStyle: true
            }
        }
    };

    // Pie Chart: Dropout vs Enrolled with improved visuals
    new Chart(document.getElementById('pieChart'), {
        type: 'pie',
        data: {
            labels: ['Dropped Out', 'Enrolled'],
            datasets: [{
                data: [{{ $dropouts ?? 0 }}, {{ $enrolled ?? 0 }}],
                backgroundColor: ['rgba(239, 68, 68, 0.8)', 'rgba(16, 185, 129, 0.8)'],
                borderWidth: 2,
                borderColor: '#ffffff',
                hoverBorderWidth: 4,
                hoverBorderColor: '#ffffff'
            }]
        },
        options: {
            ...commonOptions,
            plugins: {
                ...commonOptions.plugins,
                legend: {
                    ...commonOptions.plugins.legend,
                    position: 'bottom'
                }
            }
        }
    });

    // Doughnut Chart: Risk Level with improved visuals
    new Chart(document.getElementById('riskLevelChart'), {
        type: 'doughnut',
        data: {
            labels: ['High Risk', 'Medium Risk', 'Low Risk'],
            datasets: [{
                data: @json($riskData ?? [0,0,0]),
                backgroundColor: [
                    'rgba(239, 68, 68, 0.8)', 
                    'rgba(245, 158, 11, 0.8)', 
                    'rgba(16, 185, 129, 0.8)'
                ],
                borderWidth: 2,
                borderColor: '#ffffff',
                hoverBorderWidth: 4,
                hoverBorderColor: '#ffffff'
            }]
        },
        options: {
            ...commonOptions,
            cutout: '65%',
            plugins: {
                ...commonOptions.plugins,
                legend: {
                    ...commonOptions.plugins.legend,
                    position: 'bottom'
                }
            }
        }
    });

    // Bar Chart: Dropouts by Region with improved visuals
    new Chart(document.getElementById('regionBarChart'), {
        type: 'bar',
        data: {
            labels: @json($dropoutData->pluck('region') ?? []),
            datasets: [{
                label: 'Dropouts',
                data: @json($dropoutData->pluck('dropout_count') ?? []),
                backgroundColor: 'rgba(99, 102, 241, 0.8)',
                borderColor: 'rgba(99, 102, 241, 1)',
                borderWidth: 1,
                borderRadius: 6,
                hoverBackgroundColor: 'rgba(79, 70, 229, 0.9)'
            }]
        },
        options: {
            ...commonOptions,
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(226, 232, 240, 0.6)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                ...commonOptions.plugins,
                legend: {
                    display: false
                }
            }
        }
    });

    // Line Chart: Dropout Trends with improved visuals
    new Chart(document.getElementById('trendLineChart'), {
        type: 'line',
        data: {
            labels: @json($dropoutTrends->pluck('label') ?? []),
            datasets: [{
                label: 'Dropouts',
                data: @json($dropoutTrends->pluck('value') ?? []),
                borderColor: 'rgba(79, 70, 229, 1)',
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#4f46e5',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: '#4f46e5',
                pointHoverBorderColor: '#ffffff',
                pointHoverBorderWidth: 3
            }]
        },
        options: {
            ...commonOptions,
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(226, 232, 240, 0.6)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Area Chart: Grade Distribution with improved visuals
    new Chart(document.getElementById('gradeAreaChart'), {
        type: 'line',
        data: {
            labels: @json($gradeDistribution->pluck('grade_range') ?? []),
            datasets: [{
                label: 'Students',
                data: @json($gradeDistribution->pluck('count') ?? []),
                borderColor: 'rgba(16, 185, 129, 1)',
                backgroundColor: 'rgba(16, 185, 129, 0.15)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#10b981',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: '#10b981',
                pointHoverBorderColor: '#ffffff',
                pointHoverBorderWidth: 3
            }]
        },
        options: {
            ...commonOptions,
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(226, 232, 240, 0.6)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                ...commonOptions.plugins,
                legend: {
                    display: false
                }
            }
        }
    });
    
    // Add hover effects to table rows
    const tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', () => {
            row.classList.add('bg-gray-50', 'shadow-sm');
        });
        row.addEventListener('mouseleave', () => {
            row.classList.remove('bg-gray-50', 'shadow-sm');
        });
    });
    
    // Add animation for the stats cards
    const statsCards = document.querySelectorAll('.stats-card i');
    statsCards.forEach(icon => {
        icon.classList.add('icon-float');
    });
});
</script>
@endsection