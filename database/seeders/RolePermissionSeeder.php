<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define permissions
        $permissions = [
            'manage hunian',
            'manage data booking',
            'manage riwayat booking',
            'manage user',
            'manage verifikasi data',
            'manage hunian lain',
            'manage data promosi',
            'manage fasilitas',
        ];

        // Create or find permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create or find roles and assign permissions
        $pemilikKostRole = Role::firstOrCreate(['name' => 'pemilik_kost']);
        $pemilikKostPermissions = ['manage hunian', 'manage data booking'];
        $pemilikKostRole->syncPermissions($pemilikKostPermissions);

        $pencariKostRole = Role::firstOrCreate(['name' => 'pencari_kost']);
        $pencariKostPermissions = ['manage riwayat booking', 'manage data booking'];
        $pencariKostRole->syncPermissions($pencariKostPermissions);

        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdminPermissions = ['manage user', 'manage verifikasi data', 'manage hunian lain', 'manage data promosi', 'manage fasilitas'];
        $superAdminRole->syncPermissions($superAdminPermissions);

        // Create a super admin user and assign the super admin role
        $user = User::firstOrCreate([
            'email' => 'admin@gmail.com',
        ], [
            'name' => 'Admin',
            'avatar' => 'avatars/profile.png',
            'password' => Hash::make('Admin123'),
            'phone' => '0895704307742',
            'email_verified_at' => now(),
        ]);

        $user->assignRole($superAdminRole);
    }
}
