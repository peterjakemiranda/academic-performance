<?php

namespace App\Http\Controllers;

use App\Charts\GPAChart;
use App\Charts\GPAStudentChart;
use Inertia\Inertia;
use App\Models\Grade;

class DashboardController extends Controller
{
    public function index(GPAChart $chart)
    {
        if (auth()->user()->role == 'registrar') {
            return redirect('/grades');
        }

        if (auth()->user()->role == 'student') {
            return redirect('/users/'.auth()->id().'/edit');
        }

        $schoolYears = Grade::schoolYears();
        $semesters = [1 => '1st Semester', 2 => '2nd Semester'];
        $charts = [];
        foreach( $schoolYears as $schoolYear) {
            foreach ([1,2] as $semester) {
                $gpaPerSem = Grade::where('school_year', $schoolYear)
                    ->where('semester', $semester)->get();
                if ($gpaPerSem->count()) {
                    $schoolYearSemester = $schoolYear.' - '.$semesters[$semester];
                    $gpas = $gpaPerSem->groupBy(function($data) {
                        $grouping = '';
                        switch ($data->gpa) {
                            case $data->gpa >= 1.00 && $data->gpa <= 1.24:
                                $grouping = '1.00 - 1.24 (Excellent)';
                                break;
                            case $data->gpa >= 1.25 && $data->gpa <= 1.49:
                                $grouping = '1.25 - 1.49 (Superior)';
                                break;
                            case $data->gpa >= 1.50 && $data->gpa <= 1.74:
                                $grouping = '1.50 - 1.74 (Very Good)';
                                break;
                            case $data->gpa >= 1.75 && $data->gpa <= 1.99:
                                $grouping = '1.75 - 1.99 (Good)';
                                break;
                            case $data->gpa >= 2.00 && $data->gpa <= 2.24:
                                $grouping = '2.00 - 2.24 (Very Satisfactory)';
                                break;
                            case $data->gpa >= 2.25 && $data->gpa <= 2.49:
                                $grouping = '2.25 - 2.49 (High Average)';
                                break;
                            case $data->gpa >= 2.50 && $data->gpa <= 2.74:
                                $grouping = '2.50 - 2.74 (Average)';
                                break;
                            case $data->gpa >= 2.75 && $data->gpa <= 2.99:
                                $grouping = '2.75 - 2.99 (Fair)';
                                break;
                            case $data->gpa >= 3.00 && $data->gpa <= 3.99:
                                $grouping = '3.00 - 3.99 (Pass)';
                                break;
                            case $data->gpa >= 4.00 && $data->gpa <= 4.99:
                                $grouping = '4.00 - 4.99 (Conditional)';
                                break;
                            case $data->gpa >= 5.00 && $data->gpa <= 5.00:
                                $grouping = '5.00 - 5.00 (Failing)';
                                break;
                        }
                        return $grouping;
                    })->sortKeys();

                    $gpaGrouping = [
                        '1.00 - 1.24 (Excellent)' => 0,
                        '1.25 - 1.49 (Superior)' => 0,
                        '1.50 - 1.74 (Very Good)' => 0,
                        '1.75 - 1.99 (Good)' => 0,
                        '2.00 - 2.24 (Very Satisfactory)' => 0,
                        '2.25 - 2.49 (High Average)' => 0,
                        '2.50 - 2.74 (Average)' => 0,
                        '2.75 - 2.99 (Fair)' => 0,
                        '3.00 - 3.99 (Pass)' => 0,
                        '4.00 - 4.99 (Conditional)' => 0,
                        '5.00 - 5.00 (Failing)' => 0,
                    ];

                    foreach( $gpas as $key => $gpa) {
                        $gpaGrouping[$key] = round(($gpa->count()/$gpaPerSem->count()) * 100, 2);
                    }
                    $charts[] = $chart->build($schoolYearSemester, array_keys($gpaGrouping), array_values($gpaGrouping));
                }
            }
        }
        return Inertia::render('Dashboard/Index', ['charts' => $charts]);
    }    
    
    public function student(GPAStudentChart $chart)
    {
        $schoolYears = Grade::schoolYears();
        $charts = [];
        foreach( $schoolYears as $schoolYear) {
                $gpaPerYear = Grade::where('student_id', auth()->user()->student->id)->where('school_year', $schoolYear)->get();
                if ($gpaPerYear->count()) {
                    $grades = $gpaPerYear->sortKeys();

                    $semesterGrouping = [
                        '1' => null,
                        '2' => null,
                    ];
                    foreach( $grades as $key => $grade) {
                        $semesterGrouping[$grade->semester] = $grade->gpa;
                    }
                    $charts[] = $chart->build($schoolYear, ['1st Semester', '2nd Semester'], array_values($semesterGrouping));
                }
        }
        return Inertia::render('Dashboard/Student', ['charts' => $charts]);
    }
}


