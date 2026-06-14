<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\SchoolClass;
use App\Models\Enrollment;
use App\Models\Grade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

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

        foreach ($enrollments as $enrollment) {
            foreach ([
                'Exam 1',
                'Exam 2',
                'Assignment',
                'Final Exam'
            ] as $assessment) {

                Grade::create([
                    'student_id' => $enrollment->student_id,
                    'school_class_id' => $enrollment->school_class_id,
                    'teacher_id' => $enrollment->schoolClass->teacher_id,
                    'assessment_name' => $assessment,
                    'grade' => fake()->randomFloat(2, 4, 10),
                    'assessment_date' => fake()->dateTimeBetween('-6 months', 'now'),
                ]);
            }
        }
    }
}
