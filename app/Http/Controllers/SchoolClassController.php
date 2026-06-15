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
        $user = auth()->user();

        abort_unless($user->hasAnyRole(['Administrador', 'Professor']), 403);

        $classes = SchoolClass::with([
                'subject',
                'teacher',
                'teacher.user',
            ])
            ->when($user->hasRole('Professor'), function ($query) use ($user) {
                $query->where('teacher_id', $user->teacher?->id);
            })
            ->latest()
            ->paginate(6);

        $subjects = Subject::when($user->hasRole('Professor'), function ($query) use ($user) {
                $query->where('teacher_id', $user->teacher?->id);
            })
            ->get();

        return view('App.SchoolClasses.index', compact('classes', 'subjects'));
    }

    public function create()
    {
        $user = auth()->user();

        abort_unless($user->hasRole('Professor'), 403);

        return view('App.SchoolClasses.create', [
            'subjects' => Subject::where('teacher_id', $user->teacher->id)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        abort_unless($user->hasRole('Professor'), 403);
        abort_if(!$user->teacher, 403);

        $validated = $request->validate([
            'subject_id' => ['required', 'exists:subjects,id'],
            'name' => ['required', 'string', 'max:255'],
            'academic_year' => ['required', 'string', 'max:10'],
            'semester' => ['required', 'string', 'max:10'],
            'room' => ['nullable', 'string', 'max:50'],
        ]);

        $validated['teacher_id'] = $user->teacher->id;

        SchoolClass::create($validated);

        return redirect()->route('classes.index');
    }

    public function update(Request $request, SchoolClass $class)
    {
        $user = auth()->user();

        abort_unless($user->hasAnyRole(['Administrador', 'Professor']), 403);

        if (
            $user->hasRole('Professor') &&
            $class->teacher_id !== $user->teacher?->id
        ) {
            abort(403);
        }

        $validated = $request->validate([
            'subject_id' => ['required', 'exists:subjects,id'],
            'name' => ['required', 'string', 'max:255'],
            'academic_year' => ['required', 'string', 'max:10'],
            'semester' => ['required', 'string', 'max:10'],
            'room' => ['nullable', 'string', 'max:50'],
        ]);

        $class->update($validated);

        return redirect()->route('classes.index');
    }

    public function destroy(SchoolClass $class)
    {
        $user = auth()->user();

        abort_unless($user->hasAnyRole(['Administrador', 'Professor']), 403);

        if (
            $user->hasRole('Professor') &&
            $class->teacher_id !== $user->teacher?->id
        ) {
            abort(403);
        }

        $class->delete();

        return redirect()->route('classes.index');
    }
}