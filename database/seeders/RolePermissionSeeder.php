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
        $superAdminPermissions = ['manage user', 'manage verifikasi data', 'manage hunian lain', 'manage data promosi'];
        $superAdminRole->syncPermissions($superAdminPermissions);

        // Create a super admin user and assign the super admin role
        $user = User::firstOrCreate([
            'email' => 'super@admin.com',
        ], [
            'name' => 'Super Admin',
            'password' => Hash::make('1234567890'),
            'phone' => '0895704307742',
        ]);

        $user->assignRole($superAdminRole);
    }
}
