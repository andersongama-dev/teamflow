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
        $teacher = auth()->user()->teacher;

        if (!$teacher) {
            return view('App.Subjects.index', [
                'subjects' => Subject::whereRaw('1 = 0')->paginate(),
            ]);
        }

        $subjects = Subject::with([
                'teacher',
                'teacher.user',
            ])
            ->where('teacher_id', $teacher->id)
            ->latest()
            ->paginate(10);

        return view('App.Subjects.index', compact('subjects'));
    }

    public function create()
    {
        $teachers = Teacher::orderBy('id')->get();

        return view('subjects.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher_id' => ['required', 'exists:teachers,id'],
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:subjects,code'],
            'workload_hours' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
        ]);

        Subject::create($validated);

        return redirect()
            ->route('subjects.index')
            ->with('success', 'Subject created successfully.');
    }

    public function show(Subject $subject)
    {
        $subject->load('teacher');

        return view('subjects.show', compact('subject'));
    }

    public function edit(Subject $subject)
    {
        $teachers = Teacher::orderBy('id')->get();

        return view('subjects.edit', compact('subject', 'teachers'));
    }

    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'teacher_id' => ['required', 'exists:teachers,id'],
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:subjects,code,' . $subject->id],
            'workload_hours' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
        ]);

        $subject->update($validated);

        return redirect()
            ->route('subjects.index')
            ->with('success', 'Subject updated successfully.');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()
            ->route('subjects.index')
            ->with('success', 'Subject deleted successfully.');
    }
}