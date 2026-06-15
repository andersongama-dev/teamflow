<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            "users.*",
            "roles.*",

            "students.*",
            "teachers.*",

            "subjects.*",
            "classes.*",
            "enrollments.*",

            "grades.view",
            "grades.create",
            "grades.edit",
            "grades.delete",
            "grades.view.own",

            "attendances.view",
            "attendances.create",
            "attendances.edit",
            "attendances.delete",
            "attendances.view.own",

            "history.view",
            "history.view.own",

            "profile.view",
            "profile.edit",

            "reports.view",
            "reports.view.own",
            "reports.export",

            "dashboard.admin",
            "dashboard.teacher",
            "dashboard.student",

            "dashboard.student",

            'enrollments.view',
            'enrollments.create',
            'enrollments.delete',
            'enrollments.manage'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
            ]);
        }

        $admin = Role::firstOrCreate([
            'name' => 'Administrador'
        ]);

        $teacher = Role::firstOrCreate([
            'name' => 'Professor'
        ]);

        $student = Role::firstOrCreate([
            'name' => 'Aluno'
        ]);

        $admin->syncPermissions(Permission::all());

        $teacher->syncPermissions([
            'dashboard.teacher',

            'students.*',

            'subjects.*',

            'classes.*',

            'grades.view',
            'grades.create',
            'grades.edit',

            'attendances.view',
            'attendances.create',
            'attendances.edit',

            'reports.view',

            'enrollments.view',
            'enrollments.create',
            'enrollments.delete',
        ]);

        $student->syncPermissions([
            'dashboard.student',

            'subjects.*',

            'grades.view',

            'attendances.view',

            'enrollments.view',
            'enrollments.create',
            'enrollments.delete',
        ]);
    }
}