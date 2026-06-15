<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    public function index()
    {
        $teacher = auth()->user()->teacher;

        if (!$teacher) {
            return view('App.SchoolClasses.index', [
                'classes' => SchoolClass::whereRaw('1 = 0')->paginate(),
                'subjects' => collect(),
            ]);
        }

        $classes = SchoolClass::with([
                'subject',
                'teacher',
                'teacher.user',
            ])
            ->where('teacher_id', $teacher->id)
            ->latest()
            ->paginate(10);

        $subjects = Subject::where('teacher_id', $teacher->id)->get();

        return view('App.SchoolClasses.index', compact('classes', 'subjects'));
    }

    public function create()
    {
        $teacher = auth()->user()->teacher;

        if (!$teacher) {
            abort(403);
        }

        return view('App.SchoolClasses.create', [
            'subjects' => Subject::where('teacher_id', $teacher->id)->get(),
        ]);
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->hasAnyRole(['Administrador', 'Professor']), 403);

        $teacher = auth()->user()->teacher;

        $validated = $request->validate([
            'subject_id' => ['required', 'exists:subjects,id'],
            'name' => ['required', 'string', 'max:255'],
            'academic_year' => ['required', 'string', 'max:10'],
            'semester' => ['required', 'string', 'max:10'],
            'room' => ['nullable', 'string', 'max:50'],
        ]);

        $validated['teacher_id'] = $teacher?->id;

        SchoolClass::create($validated);

        return redirect()->route('classes.index');
    }

    public function update(Request $request, SchoolClass $schoolClass)
    {
        $teacher = auth()->user()->teacher;

        if (!$teacher || $schoolClass->teacher_id !== $teacher->id) {
            abort(403);
        }

        $validated = $request->validate([
            'subject_id' => ['required', 'exists:subjects,id'],
            'name' => ['required', 'string', 'max:255'],
            'academic_year' => ['required', 'string', 'max:10'],
            'semester' => ['required', 'string', 'max:10'],
            'room' => ['nullable', 'string', 'max:50'],
        ]);

        $validated['teacher_id'] = $teacher->id;

        $schoolClass->update($validated);

        return redirect()
            ->route('classes.index')
            ->with('success', 'Class updated successfully.');
    }

    public function destroy(SchoolClass $class)
    {

        $user = auth()->user();

        abort_unless(
            $user->hasRole('Administrador') ||
            ($user->hasRole('Professor') && $class->teacher_id === $user->teacher?->id),
            403
        );

        $class->delete();

        return redirect()->route('classes.index');
    }
}