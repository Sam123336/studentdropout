<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    public function run()
    {
        $csvPath = storage_path('app/public/data/student_data.csv');

        if (!file_exists($csvPath) || !is_readable($csvPath)) {
            $this->command->error("CSV file not found or not readable at: $csvPath");
            return;
        }

        $header = null;
        $count = 0;
        if (($handle = fopen($csvPath, 'r')) !== false) {
            while (($row = fgetcsv($handle)) !== false) {
                // Parse header row
                if (!$header) {
                    $header = $row;
                } else {
                    $data = array_combine($header, $row);

                    // Map every field
                    $student = [
                        'school'                       => $data['School'] ?? null,
                        'gender'                       => $data['Gender'] ?? null,
                        'age'                          => isset($data['Age']) ? (int)$data['Age'] : null,
                        'address'                      => $data['Address'] ?? null,
                        'region'                       => $data['Region'] ?? null, 
                        'family_size'                  => $data['Family_Size'] ?? null,
                        'parental_status'              => $data['Parental_Status'] ?? null,
                        'mother_education'             => isset($data['Mother_Education']) ? (int)$data['Mother_Education'] : null,
                        'father_education'             => isset($data['Father_Education']) ? (int)$data['Father_Education'] : null,
                        'mother_job'                   => $data['Mother_Job'] ?? null,
                        'father_job'                   => $data['Father_Job'] ?? null,
                        'reason_for_choosing_school'   => $data['Reason_for_Choosing_School'] ?? null,
                        'guardian'                     => $data['Guardian'] ?? null,
                        'travel_time'                  => isset($data['Travel_Time']) ? (int)$data['Travel_Time'] : null,
                        'study_time'                   => isset($data['Study_Time']) ? (int)$data['Study_Time'] : null,
                        'number_of_failures'           => isset($data['Number_of_Failures']) ? (int)$data['Number_of_Failures'] : null,
                        'school_support'               => $data['School_Support'] ?? null,
                        'family_support'               => $data['Family_Support'] ?? null,
                        'extra_paid_class'             => $data['Extra_Paid_Class'] ?? null,
                        'extra_curricular_activities'  => $data['Extra_Curricular_Activities'] ?? null,
                        'attended_nursery'             => $data['Attended_Nursery'] ?? null,
                        'wants_higher_education'       => $data['Wants_Higher_Education'] ?? null,
                        'internet_access'              => $data['Internet_Access'] ?? null,
                        'in_relationship'              => $data['In_Relationship'] ?? null,
                        'family_relationship'          => isset($data['Family_Relationship']) ? (int)$data['Family_Relationship'] : null,
                        'free_time'                    => isset($data['Free_Time']) ? (int)$data['Free_Time'] : null,
                        'going_out'                    => isset($data['Going_Out']) ? (int)$data['Going_Out'] : null,
                        'weekend_alcohol_consumption'  => isset($data['Weekend_Alcohol_Consumption']) ? (int)$data['Weekend_Alcohol_Consumption'] : null,
                        'weekday_alcohol_consumption'  => isset($data['Weekday_Alcohol_Consumption']) ? (int)$data['Weekday_Alcohol_Consumption'] : null,
                        'health_status'                => isset($data['Health_Status']) ? (int)$data['Health_Status'] : null,
                        'number_of_absences'           => isset($data['Number_of_Absences']) ? (int)$data['Number_of_Absences'] : null,
                        'grade_1'                      => isset($data['Grade_1']) ? (int)$data['Grade_1'] : null,
                        'grade_2'                      => isset($data['Grade_2']) ? (int)$data['Grade_2'] : null,
                        'final_grade'                  => isset($data['Final_Grade']) ? (int)$data['Final_Grade'] : null,
                        'grade_avg'                    => null,
                        'dropout_status'               => (isset($data['Dropped_Out']) && $data['Dropped_Out'] === 'True') ? 1 : 0,
                    ];

                    // Calculate grade_avg as mean if possible
                    if (isset($student['grade_1'], $student['grade_2'], $student['final_grade'])) {
                        $student['grade_avg'] = round((
                            $student['grade_1'] + $student['grade_2'] + $student['final_grade']
                        ) / 3, 2);
                    }

                    Student::create($student);
                    $count++;
                }
            }
            fclose($handle);
            $this->command->info("Seeded $count students from CSV.");
        } else {
            $this->command->error("Could not open CSV at: $csvPath");
        }
    }
}
