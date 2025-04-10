<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' => 'maximaa7@beget.tech',
                'email' => 'maximaa7@beget.tech',
                'password' => 'cECTy!fWb4mi'
            ]
        ];

        foreach($admins as $admin)
        {
            $adminUser = User::create([
                'name' => $admin['name'],
                'email' => $admin['email'],
                'password' => $admin['password'],
                'email_verified_at' => now(),
            ]);

            $adminUser->assignRole('Super Admin');
            $adminUser->assignRole('Admin');
        }
    }
}
