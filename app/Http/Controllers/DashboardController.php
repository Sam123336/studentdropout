<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Dropout and enrolled counts
        $dropouts = Student::where('dropout_status', 1)->count();
        $enrolled = Student::where('dropout_status', 0)->count();

        // Chart using Larapex
        $chart = (new LarapexChart)->pieChart()
            ->setTitle('Dropout vs Enrolled Students')
            ->addData([$dropouts, $enrolled])
            ->setLabels(['Dropped Out', 'Enrolled']);

        // Region-wise dropout data
        $dropoutData = Student::select('region', DB::raw('count(*) as dropout_count'))
            ->where('dropout_status', 1)
            ->groupBy('region')
            ->get();

        // Line graph data for trends (dummy data for now)
        $dropoutTrends = collect([
            ['label' => 'Jan', 'value' => 5],
            ['label' => 'Feb', 'value' => 10],
            ['label' => 'Mar', 'value' => 8],
            ['label' => 'Apr', 'value' => 15],
            ['label' => 'May', 'value' => 12],
            ['label' => 'Jun', 'value' => 9],
        ]);

        // Dropout prediction based on region and grade
        $percentage = null;
        if ($request->has(['region', 'grade'])) {
            $total = Student::where('region', $request->region)
                            ->where('grade', $request->grade)
                            ->count();

            $dropout = Student::where('region', $request->region)
                              ->where('grade', $request->grade)
                              ->where('dropout_status', 1)
                              ->count();

            $percentage = $total > 0 ? round(($dropout / $total) * 100, 2) : 0;
        }

        $students = Student::all();

        return view('dashboard', compact(
            'dropouts',
            'enrolled',
            'dropoutData',
            'chart',
            'students',
            'percentage',
            'dropoutTrends'
        ));
    }
}