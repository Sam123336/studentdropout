<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;

class ImportStudentData extends Command
{
    protected $signature = 'import:students';
    protected $description = 'Import student data from CSV file';

    public function handle()
    {
        $path = storage_path('app/public/data/student_data.csv');

        if (!file_exists($path)) {
            $this->error("CSV file not found at: $path");
            return;
        }

        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);

        foreach ($csv as $record) {
            Student::create([
                'gender' => $record['Gender'],  // Corrected column name
                'age' => (int)$record['Age'],  // Corrected column name
                'region' => $record['Address'],  // Assuming 'region' should be 'Address'
                'dropout_status' => (bool)($record['Dropped_Out'] === 'True'),  // Corrected column name and boolean conversion
                'grade_avg' => ((float)((float)$record['Grade_1'] + (float)$record['Grade_2']) / 2),  // Corrected parentheses
            ]);
        }

        $this->info('Student data imported successfully.');
    }
}
