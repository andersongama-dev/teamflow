<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'registration_number' => 'required|string|max:50|unique:students',
            'birth_date' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'enrollment_date' => 'required|date',
            'status' => 'required|in:active,inactive,transferred,graduated',
        ]);

        Student::create([
            'user_id' => auth()->id(),
            'registration_number' => $request->registration_number,
            'birth_date' => $request->birth_date,
            'phone' => $request->phone,
            'address' => $request->address,
            'enrollment_date' => $request->enrollment_date,
            'status' => $request->status,
        ]);

        return redirect('/enrollments');
    }
}