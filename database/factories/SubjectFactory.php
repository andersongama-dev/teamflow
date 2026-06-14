<?php

namespace Database\Factories;

use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubjectFactory extends Factory
{
    protected $model = Subject::class;

    public function definition(): array
    {
        $subjects = [
            'Mathematics',
            'Physics',
            'Chemistry',
            'Biology',
            'History',
            'Geography',
            'Portuguese',
            'English',
            'Computer Science',
            'Physical Education',
        ];

        return [
            'teacher_id' => Teacher::inRandomOrder()->first()?->id,

            'name' => fake()->randomElement($subjects),

            'code' => strtoupper(fake()->bothify('???###')),

            'workload_hours' => fake()->randomElement([
                40,
                60,
                80,
                100,
                120,
            ]),

            'description' => fake()->paragraph(),
        ];
    }
}