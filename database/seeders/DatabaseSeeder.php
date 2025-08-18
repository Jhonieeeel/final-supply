<?php

namespace Database\Seeders;

use App\Models\ReportSupply;
use App\Models\Requisition;
use App\Models\Stock;
use App\Models\Supply;
use App\Models\User;
use Carbon\Carbon;
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

        $stocks = [
            [
                'barcode' => 'barcode-1',
                'stock_number' => 'stock_number-1',
                'quantity' => 50,
                'initial_quantity' => 50,
                'price' => 200,
                'supply_id' => 1,

            ],
            [
                'barcode' => 'barcode-2',
                'stock_number' => 'stock_number-2',
                'quantity' => 25,
                'initial_quantity' => 25,
                'price' => 500,
                'supply_id' => 2,
            ],
            [
                'barcode' => 'barcode-3',
                'stock_number' => 'stock_number-3',
                'quantity' => 100,
                'initial_quantity' => 100,
                'price' => 250,
                'supply_id' => 3,

            ],
            [
                'barcode' => 'barcode-4',
                'stock_number' => 'stock_number-4',
                'quantity' => 50,
                'initial_quantity' => 50,
                'price' => 20,
                'supply_id' => 4,
            ],
        ];

        foreach ($supplies as $supply) {
            Supply::create($supply);
        }

        foreach ($stocks as $stock) {
            Stock::create($stock);
        }
        $monthlyReport = ReportSupply::create([
            'serial_number' => Carbon::now()->format('Y-m-d') . '-' . 1
        ]);

        $requisition = Requisition::create([
            'ris' => null,
            'owner_id' => 1,
            'requested_by' => $superAdminUser->id,
            'approved_by' => 1,
            'issued_by' => 2,
            'received_by' => null,
            'report_supply_id' => $monthlyReport->id
        ]);

        $requisition->items()->create([
            'stock_id' => 1,
            'quantity' => 2
        ]);
    }
}
