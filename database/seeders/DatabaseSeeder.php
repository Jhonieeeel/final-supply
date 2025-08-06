<?php

namespace Database\Seeders;

use App\Models\Supply;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // User::factory(10)->create();

        $super = Role::create(['name' => 'super-admin']);
        $admin = Role::create(['name' => 'admin']);
        $employee = Role::create(['name' => 'employee']);

        $approver = Permission::create(['name' => 'can approve']);
        $issueance = Permission::create(['name' => 'can issue']);

        $user = User::factory()->create([
            'name' => 'Jhoniel Villacura',
            'email' => 'test@example.com',
        ]);
        $user->assignRole($super);
        $user->givePermissionTo($approver);
        $user->givePermissionTo($issueance);

        $user_issueance = User::create([
            'name' => 'issue',
            'email' => 'issue@example.com',
            'password' => 'password'
        ]);
        $user_issueance->assignRole($admin);
        $user_issueance->givePermissionTo($issueance);
        $user_issueance->givePermissionTo($approver);

        Supply::create([
            'name' => 'Alcohol 500ml',
            'category' => 'Supplies',
            'unit' => 'pc'
        ]);

        Supply::create([
            'name' => 'Ballpen',
            'category' => 'Supplies',
            'unit' => 'pc'
        ]);

        Supply::create([
            'name' => 'Silhig',
            'category' => 'Supplies',
            'unit' => 'pc'
        ]);

        Supply::create([
            'name' => 'Dishwashing Liquid',
            'category' => 'Supplies',
            'unit' => 'bottle'
        ]);
    }
}
