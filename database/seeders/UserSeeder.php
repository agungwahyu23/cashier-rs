<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample users with different statuses
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@demo.com',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
            ],
            [
                'name' => 'Kasir 1',
                'email' => 'kasir@mailinator.com',
                'password' => Hash::make('12345678'),
                'role' => 'kasir',
            ],
            [
                'name' => 'Marketing 1',
                'email' => 'marketing@mailinator.com',
                'password' => Hash::make('12345678'),
                'role' => 'marketing',
            ],
        ];

        foreach ($users as $u) 
        {
            $user = new User();
            $user->name = $u['name'];
            $user->email = $u['email'];
            $user->password = $u['password'];
            $user->save();

            $user->assignRole($u['role']);
            $user->syncRoles($u['role']);
        }
    }
}
