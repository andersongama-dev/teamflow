<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );

        $this->call([
            RolesAndPermissionsSeeder::class,
        ]);

        Student::factory(50)->create();
        Teacher::factory(10)->create();
        Subject::factory(20)->create();
        SchoolClass::factory(20)->create();

        $students = Student::all();
        $classes = SchoolClass::all();

        foreach ($students as $student) {
            $selectedClasses = $classes->random(
                min(rand(3, 6), $classes->count())
            );

            foreach ($selectedClasses as $class) {
                Enrollment::create([
                    'student_id' => $student->id,
                    'school_class_id' => $class->id,
                    'enrollment_date' => now(),
                    'status' => 'active',
                ]);
            }
        }

        $enrollments = Enrollment::with('schoolClass')->get();

        $assessments = [
            'Exam 1',
            'Exam 2',
            'Assignment',
            'Final Exam',
        ];

        foreach ($enrollments as $enrollment) {

            foreach ($assessments as $assessment) {
                Grade::create([
                    'student_id' => $enrollment->student_id,
                    'school_class_id' => $enrollment->school_class_id,
                    'teacher_id' => $enrollment->schoolClass->teacher_id,
                    'assessment_name' => $assessment,
                    'grade' => fake()->randomFloat(2, 4, 10),
                    'assessment_date' => fake()->dateTimeBetween('-6 months', 'now'),
                ]);
            }

            for ($i = 0; $i < 20; $i++) {
                $present = fake()->boolean(85);

                Attendance::create([
                    'student_id' => $enrollment->student_id,
                    'school_class_id' => $enrollment->school_class_id,
                    'date' => fake()->dateTimeBetween('-4 months', 'now'),
                    'present' => $present,
                    'observation' => $present
                        ? null
                        : fake()->randomElement([
                            'Medical certificate',
                            'Unjustified absence',
                            'Family commitment',
                            'Late arrival',
                        ]),
                ]);
            }
        }
    }
}