<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AddStudentController extends Controller implements HasMiddleware
{
    /**
     * Define the middleware for the controller.
     */
    public static function middleware(): array
    {
        return [
            'auth',
            // new Middleware('admin', only: ['create', 'store']),
        ];
    }

    /**
     * Show the form to create a new student.
     */
    public function create()
    {
        return view('add-student');
    }

    /**
     * Store a newly created student and calculate dropout percentage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'gender' => 'required|string',
            'age' => 'required|integer',
            'region' => 'required|string',
            'dropout_status' => 'required|boolean',
            'grade_avg' => 'required|numeric',
        ]);

        // Save the new student
        Student::create($validatedData);

        // Define grade range for similarity (±5 range)
        $gradeMin = $validatedData['grade_avg'] - 5;
        $gradeMax = $validatedData['grade_avg'] + 5;

        // Calculate total similar students
        $total = Student::where('gender', $validatedData['gender'])
            ->where('region', $validatedData['region'])
            ->whereBetween('grade_avg', [$gradeMin, $gradeMax])
            ->count();

        // Calculate total dropouts among similar students
        $dropouts = Student::where('gender', $validatedData['gender'])
            ->where('region', $validatedData['region'])
            ->whereBetween('grade_avg', [$gradeMin, $gradeMax])
            ->where('dropout_status', true)
            ->count();

        // Calculate dropout percentage
        $percentage = $total > 0 ? round(($dropouts / 30) * 100, 2) : 0;

        return redirect()->route('add-student')->with([
            'success' => 'Student added successfully!',
            'dropout_percentage' => $percentage
        ]);
    }
}
