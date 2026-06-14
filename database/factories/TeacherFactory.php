<?php

namespace Database\Factories;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherFactory extends Factory
{
    protected $model = Teacher::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),

            'specialization' => fake()->randomElement([
                'Mathematics',
                'Physics',
                'Chemistry',
                'Biology',
                'History',
                'Geography',
                'Portuguese',
                'English',
                'Physical Education',
                'Computer Science',
            ]),

            'phone' => fake()->phoneNumber(),

            'hire_date' => fake()->dateTimeBetween('-15 years', 'now'),

            'status' => fake()->randomElement([
                'active',
                'inactive',
                'on_leave',
            ]),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Teacher $teacher) {
            $teacher->user->assignRole('Professor');
        });
    }
}