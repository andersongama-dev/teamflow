<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        abort_unless($user->hasAnyRole(['Administrador', 'Professor', 'Aluno']), 403);

        $attendances = Attendance::with([
                'student.user',
                'schoolClass.subject',
                'schoolClass.teacher.user',
            ])
            ->when($user->hasRole('Aluno'), function ($query) use ($user) {
                $query->where('student_id', $user->student->id);
            })
            ->when($user->hasRole('Professor'), function ($query) use ($user) {
                $query->whereHas('schoolClass', function ($q) use ($user) {
                    $q->where('teacher_id', $user->teacher?->id);
                });
            })
            ->latest()
            ->paginate(10);

        return view('App.Attendances.index', [
            'attendances' => $attendances,
            'classes' => SchoolClass::when($user->hasRole('Professor'), function ($q) use ($user) {
                $q->where('teacher_id', $user->teacher?->id);
            })->get(),
            'students' => Student::with('user')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        abort_unless($user->hasAnyRole(['Administrador', 'Professor']), 403);

        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'school_class_id' => ['required', 'exists:school_classes,id'],
            'date' => ['required', 'date'],
            'present' => ['required', 'boolean'],
            'observation' => ['nullable', 'string'],
        ]);

        if ($user->hasRole('Professor')) {
            $class = SchoolClass::findOrFail($validated['school_class_id']);

            abort_if($class->teacher_id !== $user->teacher?->id, 403);
        }

        Attendance::updateOrCreate(
            [
                'student_id' => $validated['student_id'],
                'school_class_id' => $validated['school_class_id'],
                'date' => $validated['date'],
            ],
            [
                'present' => $validated['present'],
                'observation' => $validated['observation'] ?? null,
            ]
        );

        return redirect()->route('attendances.index');
    }

    public function update(Request $request, Attendance $attendance)
    {
        $user = auth()->user();

        abort_unless($user->hasAnyRole(['Administrador', 'Professor']), 403);

        if ($user->hasRole('Professor')) {
            abort_if(
                $attendance->schoolClass->teacher_id !== $user->teacher?->id,
                403
            );
        }

        $validated = $request->validate([
            'present' => ['required', 'boolean'],
            'observation' => ['nullable', 'string'],
        ]);

        $attendance->update($validated);

        return redirect()->route('attendances.index');
    }

    public function destroy(Attendance $attendance)
    {
        $user = auth()->user();

        abort_unless($user->hasAnyRole(['Administrador', 'Professor']), 403);

        if ($user->hasRole('Professor')) {
            abort_if(
                $attendance->schoolClass->teacher_id !== $user->teacher?->id,
                403
            );
        }

        $attendance->delete();

        return redirect()->route('attendances.index');
    }
}