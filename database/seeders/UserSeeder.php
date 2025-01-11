<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Pastikan role ada atau buat baru
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $ownerRole = Role::firstOrCreate(['name' => 'owner']);
        $tenantRole = Role::firstOrCreate(['name' => 'tenant']);

        // Membuat user jika tidak ada
        $this->createUser('Admin User', 'admin@example.com', 'password123', $adminRole);
        $this->createUser('Owner User', 'owner@example.com', 'password123', $ownerRole);
        $this->createUser('Tenant User', 'tenant@example.com', 'password123', $tenantRole);
    }

    private function createUser($name, $email, $password, $role)
    {
        $user = User::firstOrNew(['email' => $email]);
        if (!$user->exists) {
            $user->name = $name;
            $user->password = Hash::make($password);
            $user->save();
            $user->assignRole($role);
        }
    }
}
