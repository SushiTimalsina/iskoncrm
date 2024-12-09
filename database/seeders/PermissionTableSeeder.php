<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
           'role-list',
           'role-create',
           'role-edit',
           'role-delete',
           'user-list',
           'user-create',
           'user-edit',
           'user-delete',
           'sewa-list',
           'sewa-create',
           'sewa-edit',
           'sewa-delete',
           'department-list',
           'department-create',
           'department-edit',
           'department-delete',
           'branch-list',
           'branch-create',
           'branch-edit',
           'branch-delete',
           'devotee-list',
           'devotee-create',
           'devotee-edit',
           'devotee-delete',
           'course-list',
           'course-create',
           'course-edit',
           'course-delete',
           'yatra-list',
           'yatra-create',
           'yatra-edit',
           'yatra-delete',
           'donation-list',
           'donation-create',
           'donation-edit',
           'donation-delete',
           'initiative-list',
           'initiative-create',
           'initiative-edit',
           'initiative-delete',
           'skills-list',
           'skills-create',
           'skills-edit',
           'skills-delete',
           'occupations-list',
           'occupations-create',
           'occupations-edit',
           'occupations-delete',
           'mentor-list',
           'mentor-create',
           'mentor-edit',
           'mentor-delete',
           'changelog-list',
           'changelog-create',
           'changelog-edit',
           'changelog-delete',
           'admin-list',
           'admin-create',
           'admin-edit',
           'admin-delete',
           'guest-take-care-list',
           'guest-take-care-create',
           'guest-take-care-edit',
           'guest-take-care-delete',
           'sewa-sankalpa-list',
           'sewa-sankalpa-create',
           'sewa-sankalpa-edit',
           'sewa-sankalpa-delete'
        ];

        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission, 'guard_name' => 'admin']);
        }
    }
}
