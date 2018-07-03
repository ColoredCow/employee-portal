<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class VolunteersModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'volunteer-manager']);

        Permission::create(['name' => 'hr_volunteers_jobs.create']);
        Permission::create(['name' => 'hr_volunteers_jobs.view']);
        Permission::create(['name' => 'hr_volunteers_jobs.update']);
        Permission::create(['name' => 'hr_volunteers_jobs.delete']);

        $volunteerManager = Role::where(['name' => 'volunteer-manager'])->first();
        $volunteerManager->syncPermissions(Permission::where('name', 'LIKE', 'hr_volunteers%')->get());
    }
}
