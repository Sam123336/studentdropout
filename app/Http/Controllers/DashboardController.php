<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Load student data
        $students = $this->loadStudentData();
        
        // Basic statistics
        $totalStudents = $students->count();
        $dropouts = $students->where('Dropped_Out', true)->count();
        $enrolled = $students->where('Dropped_Out', false)->count();
        $dropoutRate = $totalStudents > 0 ? round(($dropouts / $totalStudents) * 100, 2) : 0;
        $avgFinalGrade = $students->avg('Final_Grade');
        $avgAge = $students->avg('Age');

        // Chart using Larapex
        $chart = (new LarapexChart)->pieChart()
            ->setTitle('Dropout vs Enrolled Students')
            ->addData([$dropouts, $enrolled])
            ->setLabels(['Dropped Out', 'Enrolled']);

        // Gender distribution
        $genderStats = $students->groupBy('Gender')
            ->map(function ($group, $gender) {
                return [
                    'gender' => $gender,
                    'count' => $group->count()
                ];
            })->values();

        // Dropout rate by gender
        $dropoutsByGender = $students->groupBy('Gender')
            ->map(function ($group, $gender) {
                $total = $group->count();
                $dropouts = $group->where('Dropped_Out', true)->count();
                return [
                    'gender' => $gender,
                    'total' => $total,
                    'dropouts' => $dropouts,
                    'rate' => $total > 0 ? round(($dropouts / $total) * 100, 2) : 0
                ];
            })->values();

        // Prepare region-wise dropout data
        $dropoutData = $students->where('Dropped_Out', true)
            ->groupBy('Address')
            ->map(function ($group, $region) {
                return [
                    'region' => $region,
                    'dropout_count' => $group->count(),
                ];
            })->values();

        // Grade distribution
        $gradeDistribution = $students->groupBy(function ($student) {
                $grade = $student->Final_Grade ?? null;
                if ($grade === null) return 'N/A';
                if ($grade < 60) return 'Below 60';
                if ($grade < 70) return '60-69';
                if ($grade < 80) return '70-79';
                if ($grade < 90) return '80-89';
                return '90+';
            })
            ->map(function ($group, $range) {
                return [
                    'grade_range' => $range,
                    'count' => $group->count()
                ];
            })->values();

        // Prepare trends: Dropouts per month
        $dropoutTrends = collect([
            ['label' => 'Jan', 'value' => $students->where('Dropped_Out', true)->slice(0, 30)->count()],
            ['label' => 'Feb', 'value' => $students->where('Dropped_Out', true)->slice(30, 30)->count()],
            ['label' => 'Mar', 'value' => $students->where('Dropped_Out', true)->slice(60, 30)->count()],
            ['label' => 'Apr', 'value' => $students->where('Dropped_Out', true)->slice(90, 30)->count()],
            ['label' => 'May', 'value' => $students->where('Dropped_Out', true)->slice(120, 30)->count()],
            ['label' => 'Jun', 'value' => $students->where('Dropped_Out', true)->slice(150, 30)->count()],
        ]);

        // Risk Distribution for chart and stats
        $riskData = [0, 0, 0]; // [High, Medium, Low]
        foreach ($students as $student) {
            $grade = $student->Final_Grade ?? null;
            if ($grade === null) continue;
            if ($grade < 70) {
                $riskData[0]++;
            } elseif ($grade < 80) {
                $riskData[1]++;
            } else {
                $riskData[2]++;
            }
        }
        $high = $riskData[0];
        $medium = $riskData[1];
        $low = $riskData[2];

        // Study time vs dropout (if available in data)
        $studyTimeStats = [];
        if (isset($students->first()->Study_Time)) {
            $studyTimeStats = $students->groupBy('Study_Time')
                ->map(function ($group, $studyTime) {
                    $total = $group->count();
                    $dropouts = $group->where('Dropped_Out', true)->count();
                    return [
                        'study_time' => $studyTime,
                        'total' => $total,
                        'dropouts' => $dropouts,
                        'dropout_rate' => $total > 0 ? round(($dropouts / $total) * 100, 2) : 0,
                        'avg_grade' => $group->avg('Final_Grade')
                    ];
                })->values();
        }

        // Absences vs grades (if available)
        $absencesVsGrades = [];
        if (isset($students->first()->Absences)) {
            $absencesVsGrades = $students->groupBy(function ($student) {
                    $absences = (int)($student->Absences ?? 0);
                    if ($absences < 5) return '0-4';
                    if ($absences < 10) return '5-9';
                    if ($absences < 15) return '10-14';
                    return '15+';
                })
                ->map(function ($group, $range) {
                    return [
                        'absence_range' => $range,
                        'avg_grade' => $group->avg('Final_Grade'),
                        'count' => $group->count()
                    ];
                })->values();
        }

        // Dropout prediction based on region and grade
        $percentage = null;
        if ($request->has(['Address', 'Final_Grade'])) {
            $regionStudents = $students->where('Address', $request->input('Address'))
                                      ->where('Final_Grade', $request->input('Final_Grade'));
            $total = $regionStudents->count();
            $dropout = $regionStudents->where('Dropped_Out', true)->count();
            $percentage = $total > 0 ? round(($dropout / $total) * 100, 2) : 0;
        }

        // Get recent students for display in table
        $recentStudents = $students->sortByDesc('id')->take(10);

        return view('dashboard', [
            'totalStudents' => $totalStudents,
            'dropouts'      => $dropouts,
            'enrolled'      => $enrolled,
            'dropoutRate'   => $dropoutRate,
            'avgFinalGrade' => $avgFinalGrade,
            'avgAge'        => $avgAge,
            'genderStats'   => $genderStats,
            'dropoutsByGender' => $dropoutsByGender,
            'dropoutData'   => $dropoutData,
            'gradeDistribution' => $gradeDistribution,
            'chart'         => $chart,
            'students'      => $students,
            'recentStudents'=> $recentStudents,
            'percentage'    => $percentage,
            'dropoutTrends' => $dropoutTrends,
            'lowRiskCount'  => $low,
            'mediumRiskCount'=> $medium,
            'highRiskCount' => $high,
            'riskData'      => $riskData,
            'studyTimeStats'=> $studyTimeStats,
            'absencesVsGrades' => $absencesVsGrades,
        ]);
    }

    /**
     * Load and prepare student data from CSV
     * 
     * @return Collection
     */
    private function loadStudentData()
    {
        // Path to CSV
        $csvPath = storage_path('app/public/data/student_data.csv');
        $rows = [];
        $headers = [];

        // Open and parse the file
        if (($handle = fopen($csvPath, 'r')) !== false) {
            $headers = fgetcsv($handle);
            while (($data = fgetcsv($handle)) !== false) {
                $row = array_combine($headers, $data);
                $rows[] = (object) $row; // Convert each row to an object
            }
            fclose($handle);
        }

        // Convert 'Dropped_Out' to boolean for easier processing
        return collect($rows)->map(function ($s) {
            $s->Dropped_Out = filter_var($s->Dropped_Out, FILTER_VALIDATE_BOOLEAN);
            // Consistent types
            $s->Age = isset($s->Age) ? (int) $s->Age : null;
            $s->Final_Grade = isset($s->Final_Grade) ? (int) $s->Final_Grade : null;
            return $s;
        });
    }
}
