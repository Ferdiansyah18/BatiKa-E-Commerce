<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ownerRole = Role::firstOrCreate(['name' => 'owner']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $buyerRole = Role::firstOrCreate(['name' => 'buyer']);

        // Create Owner
        $owner = User::firstOrCreate(
            ['email' => 'hafiz@dausinternasionalhospital.com'],
            [
                'name' => 'Hafiz Firdaus S.Kom Pemilik',
                'password' => bcrypt('daus123')
            ]
        );
        $owner->assignRole($ownerRole);

        // Create Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@batika.com'],
            [
                'name' => 'Admin BatiKa',
                'password' => bcrypt('password')
            ]
        );
        $admin->assignRole($adminRole);
    }
}
