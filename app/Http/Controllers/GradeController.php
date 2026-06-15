<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        abort_unless($user->hasAnyRole(['Administrador', 'Professor', 'Aluno']), 403);

        $grades = Grade::with([
            'student.user',
            'schoolClass.subject',
            'schoolClass.teacher.user',
            'teacher.user',
        ])
        ->when($user->hasRole('Aluno'), function ($query) use ($user) {
            $query->where('student_id', $user->student->id);
        })
        ->when($user->hasRole('Professor'), function ($query) use ($user) {
            $query->where('teacher_id', $user->teacher?->id);
        })
        ->latest()
        ->paginate(10);

        $classes = SchoolClass::when($user->hasRole('Professor'), function ($query) use ($user) {
            $query->where('teacher_id', $user->teacher?->id);
        })->get();

        $students = Student::with('user')->get();

        return view('App.Grades.index', compact('grades', 'classes', 'students'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        abort_unless(
            $user->hasAnyRole(['Professor']),
            403
        );

        abort_if(!$user->teacher, 403);

        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'school_class_id' => ['required', 'exists:school_classes,id'],
            'assessment_name' => ['required', 'string', 'max:255'],
            'grade' => ['required', 'numeric', 'min:0', 'max:10'],
            'assessment_date' => ['required', 'date'],
        ]);

        $class = SchoolClass::findOrFail($validated['school_class_id']);

        $validated['teacher_id'] = $user->teacher->id;

        Grade::create($validated);

        return redirect()->route('grades.index');
    }

    public function update(Request $request, Grade $grade)
    {
        $user = auth()->user();

        abort_unless(
            $user->hasAnyRole(['Administrador', 'Professor']),
            403
        );

        if (
            $user->hasRole('Professor') &&
            $grade->teacher_id !== $user->teacher?->id
        ) {
            abort(403);
        }

        $validated = $request->validate([
            'assessment_name' => ['required', 'string', 'max:255'],
            'grade' => ['required', 'numeric', 'min:0', 'max:10'],
            'assessment_date' => ['required', 'date'],
        ]);

        $grade->update($validated);

        return redirect()->route('grades.index');
    }

    public function destroy(Grade $grade)
    {
        $user = auth()->user();

        abort_unless(
            $user->hasAnyRole(['Administrador', 'Professor']),
            403
        );

        if (
            $user->hasRole('Professor') &&
            $grade->teacher_id !== $user->teacher?->id
        ) {
            abort(403);
        }

        $grade->delete();

        return redirect()->route('grades.index');
    }
}