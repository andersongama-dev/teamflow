<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        abort_unless(
            $user->hasAnyRole(['Administrador', 'Professor', 'Aluno']),
            403
        );

        $enrollments = Enrollment::with([
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

        return view('App.Enrollments.index', compact('enrollments'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        abort_unless(
            $user->hasAnyRole(['Administrador', 'Professor', 'Aluno']),
            403
        );

        $validated = $request->validate([
            'school_class_id' => ['required', 'exists:school_classes,id'],
            'student_id' => ['nullable', 'exists:students,id'],
        ]);

        if ($user->hasRole('Aluno')) {
            $validated['student_id'] = $user->student->id;
        }

        if ($user->hasRole('Professor')) {
            $class = SchoolClass::findOrFail($validated['school_class_id']);

            if ($class->teacher_id !== $user->teacher?->id) {
                abort(403);
            }
        }

        Enrollment::firstOrCreate(
            [
                'student_id' => $validated['student_id'],
                'school_class_id' => $validated['school_class_id'],
            ],
            [
                'enrollment_date' => now(),
                'status' => 'active',
            ]
        );

        return redirect()->route('enrollments.index');
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        $user = auth()->user();

        abort_unless(
            $user->hasAnyRole(['Administrador', 'Professor']),
            403
        );

        if (
            $user->hasRole('Professor') &&
            $enrollment->schoolClass->teacher_id !== $user->teacher?->id
        ) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => ['required', 'in:active,cancelled,completed'],
        ]);

        $enrollment->update($validated);

        return redirect()->route('enrollments.index');
    }

    public function destroy(Enrollment $enrollment)
    {
        $user = auth()->user();

        abort_unless(
            $user->hasAnyRole(['Administrador', 'Professor', 'Aluno']),
            403
        );

        if ($user->hasRole('Aluno')) {
            if ($enrollment->student_id !== $user->student->id) {
                abort(403);
            }
        }

        if ($user->hasRole('Professor')) {
            if ($enrollment->schoolClass->teacher_id !== $user->teacher?->id) {
                abort(403);
            }
        }

        $enrollment->delete();

        return redirect()->route('enrollments.index');
    }
}