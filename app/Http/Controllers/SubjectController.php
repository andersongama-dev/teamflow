<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        abort_unless($user->hasAnyRole(['Administrador', 'Professor']), 403);

        $subjects = Subject::with(['teacher', 'teacher.user'])
            ->when($user->hasRole('Professor'), function ($query) use ($user) {
                $query->where('teacher_id', $user->teacher->id);
            })
            ->latest()
            ->paginate(6);

        return view('App.Subjects.index', compact('subjects'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        abort_unless($user->hasRole('Professor'), 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:subjects,code'],
            'workload_hours' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
        ]);

        $validated['teacher_id'] = $user->teacher->id;

        Subject::create($validated);

        return redirect()->route('subjects.index');
    }

    public function update(Request $request, Subject $subject)
    {
        $user = auth()->user();

        abort_unless($user->hasAnyRole(['Administrador', 'Professor']), 403);

        if (
            $user->hasRole('Professor') &&
            $subject->teacher_id !== $user->teacher->id
        ) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:subjects,code,' . $subject->id],
            'workload_hours' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
        ]);

        $subject->update($validated);

        return redirect()->route('subjects.index');
    }

    public function destroy(Subject $subject)
    {
        $user = auth()->user();

        abort_unless($user->hasAnyRole(['Administrador', 'Professor']), 403);

        if (
            $user->hasRole('Professor') &&
            $subject->teacher_id !== $user->teacher->id
        ) {
            abort(403);
        }

        $subject->delete();

        return redirect()->route('subjects.index');
    }
}