<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;



use App\Models\Student;

class StudentSeeder extends Seeder
{
    public function run()
    {
        // Sample data
        $students = [
            [
                'gender' => 'Male',
                'age' => 20,
                'region' => 'North',
                'dropout_status' => 0, // Not Dropped Out
                'grade_avg' => 85.5,
            ],
            [
                'gender' => 'Female',
                'age' => 22,
                'region' => 'South',
                'dropout_status' => 1, // Dropped Out
                'grade_avg' => 70.0,
            ],
            [
                'gender' => 'Male',
                'age' => 21,
                'region' => 'East',
                'dropout_status' => 0, // Not Dropped Out
                'grade_avg' => 90.2,
            ],
            [
                'gender' => 'Female',
                'age' => 19,
                'region' => 'West',
                'dropout_status' => 1, // Dropped Out
                'grade_avg' => 60.5,
            ],
            // Add more sample students as needed
        ];

        // Insert data into the students table
        foreach ($students as $student) {
            Student::create($student);
        }
    }
}
