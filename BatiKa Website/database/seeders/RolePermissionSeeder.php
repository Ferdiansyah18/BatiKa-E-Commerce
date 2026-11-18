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
            ['email' => env('SEED_OWNER_EMAIL', 'hafiz@dausinternasionalhospital.com')],
            [
                'name' => env('SEED_OWNER_NAME', 'Hafiz Firdaus S.Kom Pemilik'),
                'password' => bcrypt(env('SEED_OWNER_PASSWORD', 'daus123'))
            ]
        );
        $owner->assignRole($ownerRole);

        // Create Admin
        $admin = User::firstOrCreate(
            ['email' => env('SEED_ADMIN_EMAIL', 'admin@batika.com')],
            [
                'name' => env('SEED_ADMIN_NAME', 'Admin BatiKa'),
                'password' => bcrypt(env('SEED_ADMIN_PASSWORD', 'password'))
            ]
        );
        $admin->assignRole($adminRole);
    }
}
