<?php

namespace Database\Seeders;

use App\Models\Supply;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $adminRole = Role::create(['name' => 'admin']);
        $employeeRole = Role::create(['name' => 'employee']);

        $canApprove = Permission::create(['name' => 'can approve']);
        $canIssue = Permission::create(['name' => 'can issue']);

        $superAdminRole->syncPermissions([$canApprove, $canIssue]);
        $adminRole->syncPermissions([$canApprove, $canIssue]);

        $superAdminUser = User::factory()->create([
            'name' => 'Dave Madayag',
            'email' => 'test@example.com',
        ]);
        $superAdminUser->assignRole($superAdminRole);

        $issuanceUser = User::create([
            'name' => 'Ray Alingasa',
            'email' => 'issue@example.com',
            'password' => bcrypt('password'), // default na pass is = password
        ]);
        $issuanceUser->assignRole($adminRole);

        $employeeUser = User::create([
            'name' => 'Jhoniel Villacura',
            'email' => 'employee@example.com',
            'password' => bcrypt('password'),
        ]);
        $employeeUser->assignRole($employeeRole);

        $supplies = [
            ['name' => 'Alcohol 500ml', 'category' => 'Supplies', 'unit' => 'pc'],
            ['name' => 'Ballpen', 'category' => 'Supplies', 'unit' => 'pc'],
            ['name' => 'Silhig', 'category' => 'Supplies', 'unit' => 'pc'],
            ['name' => 'Dishwashing Liquid', 'category' => 'Supplies', 'unit' => 'bottle'],
        ];

        foreach ($supplies as $supply) {
            Supply::create($supply);
        }
    }
}
