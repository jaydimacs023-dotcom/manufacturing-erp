<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    /**
     * Seed default users for each role.
     *
     * Run after RoleAndPermissionSeeder so roles exist.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'System Administrator',
                'email' => 'admin@bananachips.com',
                'role' => 'Super Admin',
                'branch_id' => 1,
                'department_id' => 1,
            ],
            [
                'name' => 'Administrator',
                'email' => 'administrator@bananachips.com',
                'role' => 'Administrator',
                'branch_id' => 1,
                'department_id' => 1,
            ],
            [
                'name' => 'Purchasing Officer',
                'email' => 'purchasing@bananachips.com',
                'role' => 'Purchasing Officer',
                'branch_id' => 1,
                'department_id' => 2,
            ],
            [
                'name' => 'Warehouse Staff',
                'email' => 'warehouse@bananachips.com',
                'role' => 'Warehouse Staff',
                'branch_id' => 1,
                'department_id' => 3,
            ],
            [
                'name' => 'Production Supervisor',
                'email' => 'production@bananachips.com',
                'role' => 'Production Supervisor',
                'branch_id' => 1,
                'department_id' => 4,
            ],
            [
                'name' => 'Quality Inspector',
                'email' => 'quality@bananachips.com',
                'role' => 'Quality Inspector',
                'branch_id' => 1,
                'department_id' => 5,
            ],
            [
                'name' => 'Sales Officer',
                'email' => 'sales@bananachips.com',
                'role' => 'Sales Officer',
                'branch_id' => 1,
                'department_id' => 6,
            ],
            [
                'name' => 'Export Officer',
                'email' => 'export@bananachips.com',
                'role' => 'Export Officer',
                'branch_id' => 1,
                'department_id' => 1,
            ],
            [
                'name' => 'Accounting Officer',
                'email' => 'accounting@bananachips.com',
                'role' => 'Accounting Officer',
                'branch_id' => 1,
                'department_id' => 7,
            ],
        ];

        foreach ($users as $userData) {
            $role = $userData['role'];
            unset($userData['role']);

            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                array_merge($userData, [
                    'password' => Hash::make('password'),
                    'is_active' => true,
                    'is_locked' => false,
                ])
            );

            // Assign role (firstOrCreate may have fetched existing user without assigning role)
            if (!$user->hasRole($role)) {
                $user->assignRole($role);
            }
        }
    }
}

