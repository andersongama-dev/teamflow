<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'registration_number' => 'RA' . fake()->unique()->numerify('######'),
            'birth_date' => fake()->dateTimeBetween('-25 years', '-10 years'),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'enrollment_date' => fake()->dateTimeBetween('-5 years', 'now'),
            'status' => 'active',
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Student $student) {
            $student->user->assignRole('Aluno');
        });
    }
}