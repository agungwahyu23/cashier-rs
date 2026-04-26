<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $actions = ['list', 'create', 'view', 'edit', 'delete'];

        $modules = [
            'role',
            'user',
            'voucher',
            'insurances',
            'procedures',
            'procedures-price',
            'transaction',
            'transaction-detail',
        ];

        foreach ($modules as $key => $module)
        {
            foreach ($actions as $action) 
            {
                Permission::firstOrCreate([
                    'name' => "{$module}-{$action}",
                    'guard_name' => 'web',
                    'group' => $key+1,
                    'display' => ucwords("{$module} {$action}"),
                ]);
            }
        }
    }
}
