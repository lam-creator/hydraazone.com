<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        // Create Permissions
        $permissions = [
            'menu.admin-management',
            'menu.admin',
            'menu.role',
            'menu.permission',
			'menu.city-management',
			'menu.website-settings-management',
			'menu.website-slider',
			'menu.basic-settings',
			'menu.Products',
			'menu.category',
			'menu.unit',
			'menu.all-product',
			'menu.order',
			'menu.order-processing',
			'menu.order-approved',
			'menu.order-delivered',
			'menu.order-cancelled',
			'menu.coupon-management',
			'menu.contact-messages',
            'permission.create',
            'permission.edit',
            'permission.list',
            'permission.delete',
            'role.create',
            'role.edit',
            'role.list',
            'role.delete',
            'admin.create',
            'admin.edit',
            'admin.list',
            'admin.delete',
            'coupon.create',
            'coupon.edit',
            'coupon.list',
            'coupon.delete'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'admin']);
        }

        // Create Role
        $role = Role::create(['name' => 'super', 'guard_name' => 'admin']);

        // Assign Permissions to Role
        $role->givePermissionTo(Permission::all());

        // Create Admin
        $admin = Admin::create([
            'name'     => 'hydraazone',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('admin@gmail.com'), // change to a secure password in production
        ]);

		// Update the user_id field with the new user's ID
        $admin->user_id = $admin->id;
        $admin->save();

        // Assign the 'super' role to the admin
        $admin->assignRole('super');
    }
}
