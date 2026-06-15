<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;

class DashboardController extends Controller
{
    public function admin()
    {
        $user = auth()->user();

        abort_unless($user->hasRole('Administrador'), 403);

        return view('App.Dashboard.admin', [
            'students' => Student::count(),
            'teachers' => Teacher::count(),
            'subjects' => Subject::count(),
            'classes' => SchoolClass::count(),
            'enrollments' => Enrollment::count(),
            'grades' => Grade::count(),
            'attendances' => Attendance::count(),
        ]);
    }

    public function teacher()
    {
        $user = auth()->user();

        abort_unless($user->hasRole('Professor'), 403);

        $teacherId = $user->teacher?->id;

        return view('App.Dashboard.teacher', [
            'subjects' => Subject::where('teacher_id', $teacherId)->count(),

            'classes' => SchoolClass::where('teacher_id', $teacherId)->count(),

            'enrollments' => Enrollment::whereHas('schoolClass', function ($query) use ($teacherId) {
                $query->where('teacher_id', $teacherId);
            })->count(),

            'grades' => Grade::where('teacher_id', $teacherId)->count(),

            'attendances' => Attendance::whereHas('schoolClass', function ($query) use ($teacherId) {
                $query->where('teacher_id', $teacherId);
            })->count(),
        ]);
    }

    public function student()
    {
        $user = auth()->user();

        abort_unless($user->hasRole('Aluno'), 403);

        $studentId = $user->student?->id;

        return view('App.Dashboard.student', [
            'enrollments' => Enrollment::where('student_id', $studentId)->count(),

            'grades' => Grade::where('student_id', $studentId)->count(),

            'attendances' => Attendance::where('student_id', $studentId)->count(),

            'averageGrade' => Grade::where('student_id', $studentId)
                ->avg('grade'),
        ]);
    }
}