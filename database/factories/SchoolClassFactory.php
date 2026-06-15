<?php

namespace Database\Factories;

use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

class SchoolClassFactory extends Factory
{
    protected $model = SchoolClass::class;

    public function definition(): array
    {
        $subject = Subject::query()->inRandomOrder()->first();

        return [
            'subject_id' => $subject->id,
            'teacher_id' => $subject->teacher_id,

            'name' => $subject->name . ' - ' . fake()->randomElement(['A', 'B', 'C']),

            'academic_year' => now()->year,

            'semester' => fake()->randomElement([1, 2]),

            'room' => 'Room ' . fake()->numberBetween(1, 30),
        ];
    }
}