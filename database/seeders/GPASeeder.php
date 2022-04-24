<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\Student;
use Illuminate\Database\Seeder;
use App\Models\Course;

class GPASeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Grade::truncate();
        $csvData = fopen(base_path('gpa.csv'), 'r');
        $gradeRow = true;
        $courseId = Course::whereName('BSInfoTech')->pluck('id')->first();
        while (($data = fgetcsv($csvData, 555, ',')) !== false) {
            if (!$gradeRow) {
                $studentNumber = $data['0'];
                $studentName = $data['1'];

                $student = Student::firstOrCreate(['number' => $studentNumber], ['name' => $studentName, 'course_id' => $courseId]);

                Grade::create([
                    'student_id' => $student->id,
                    'school_year' => $data['3'],
                    'semester' => $data['4'],
                    'gpa' => $data['5'],
                ]);
            }
            $gradeRow = false;
        }
        fclose($csvData);
    }
}
