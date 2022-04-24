<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use App\Models\Course;

class StudentsController extends Controller
{
    public function index()
    {
        return Inertia::render('Students/Index', [
            'filters' => Request::all('search', 'trashed'),
            'students' => Student::with('course')
                ->orderByName()
                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($student) => [
                    'id' => $student->id,
                    'number' => $student->number,
                    'name' => $student->name,
                    'course' => $student->course ? $student->course->only('name') : null,
                ]),
        ]);
    }

    public function create()
    {
        return Inertia::render('Students/Create', [
            'courses' => Course::orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
        ]);
    }

    public function store()
    {
        Auth::user()->account->students()->create(
            Request::validate([
                'number' => ['required', 'max:20'],
                'name' => ['required', 'max:100'],
                'course_id' => ['nullable', Rule::exists('courses', 'id')],
            ])
        );

        return Redirect::route('students')->with('success', 'Student created.');
    }

    public function edit(Student $student)
    {
        return Inertia::render('Students/Edit', [
            'student' => [
                'id' => $student->id,
                'number' => $student->number,
                'name' => $student->name,
                'course_id' => $student->course_id,
                'deleted_at' => $student->deleted_at,
            ],
            'courses' => Course::orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
        ]);
    }

    public function update(Student $student)
    {
        $student->update(
            Request::validate([
                'number' => ['required', 'max:20'],
                'name' => ['required', 'max:100'],
                'course_id' => [
                    'nullable',
                    Rule::exists('courses', 'id'),
                ],
            ])
        );

        return Redirect::back()->with('success', 'Student updated.');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return Redirect::back()->with('success', 'Student deleted.');
    }

    public function restore(Student $student)
    {
        $student->restore();

        return Redirect::back()->with('success', 'Student restored.');
    }
}
