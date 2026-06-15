<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'specialization' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'hire_date' => 'nullable|date',
            'status' => 'required|in:active,inactive,on_leave',
        ]);

        $user = auth()->user();

        $teacher = $user->teacher;

        if ($teacher) {
            $teacher->update([
                'specialization' => $request->specialization,
                'phone' => $request->phone,
                'hire_date' => $request->hire_date,
                'status' => $request->status,
            ]);
        } else {
            $user->teacher()->create([
                'specialization' => $request->specialization,
                'phone' => $request->phone,
                'hire_date' => $request->hire_date,
                'status' => $request->status,
            ]);
        }

        return redirect('/classes')
            ->with('success', 'Perfil do professor salvo com sucesso');
    }
}
