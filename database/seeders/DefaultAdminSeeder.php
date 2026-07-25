<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultAdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'System Administrator',
            'email' => 'admin@bananachips.com',
            'password' => Hash::make('password'),
            'is_active' => true,
            'is_locked' => false,
            'branch_id' => 1,
            'department_id' => 1,
        ]);

        $admin->assignRole('Super Admin');
    }
}
