<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use App\Models\Student;

class GradesController extends Controller
{
    public function index()
    {
        return Inertia::render('Grades/Index', [
            'filters' => Request::all('search', 'school_year', 'semester', 'student'),
            'grades' => Grade::with('student')
                ->orderByYear()
                ->filter(Request::only('search', 'school_year', 'semester', 'student'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($grade) => [
                    'id' => $grade->id,
                    'student' => $grade->student ? $grade->student->only(['number','name']) : null,
                    'school_year' => $grade->school_year,
                    'semester' => $grade->semester,
                    'gpa' => $grade->gpa,
                ]),
            'school_years' => Grade::schoolYears(),
            'semesters' => Grade::semesters(),
            'semesters' => ['1','2','S'],
            'students' => Student::orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Grades/Create', [
            'school_years' => Grade::schoolYears(),
            'semesters' => Grade::semesters(),
            'students' => Student::orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
        ]);
    }

    public function store()
    {
        Grade::create(
            Request::validate([
                'student_id' => ['required', Rule::exists('students', 'id')],
                'school_year' => ['required'],
                'semester' => ['required'],
                'gpa' => ['required', 'numeric'],
            ])
        );

        return Redirect::route('grades')->with('success', 'Grade created.');
    }

    public function edit(Grade $grade)
    {
        return Inertia::render('Grades/Edit', [
            'grade' => [
                'id' => $grade->id,
                'student' => $grade->student ? $grade->student->only(['id','name', 'number']) : null,
                'school_year' => $grade->school_year,
                'semester' => $grade->semester,
                'gpa' => $grade->gpa,
            ],
            'school_years' => Grade::schoolYears(),
            'semesters' => Grade::semesters(),
            'students' => Student::orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
        ]);
    }

    public function update(Grade $grade)
    {
        $grade->update(
            Request::validate([
                'student_id' => ['required', Rule::exists('students', 'id')],
                'school_year' => ['required'],
                'semester' => ['required'],
                'gpa' => ['required', 'numeric'],
            ])
        );

        return Redirect::back()->with('success', 'Grade updated.');
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();

        return Redirect::back()->with('success', 'Grade deleted.');
    }

    public function restore(Grade $grade)
    {
        $grade->restore();

        return Redirect::back()->with('success', 'Grade restored.');
    }
}
