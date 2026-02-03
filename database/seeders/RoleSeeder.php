<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['role_name' => 'Admin', 'description' => 'Administrator with full access'],
            ['role_name' => 'cashier', 'description' => 'cashier with limited access'],
            ['role_name' => 'chef', 'description' => 'chef with elevated privileges'],
            ['role_name' => 'customer', 'description' => 'customer with limited access'],
        ];

        DB::table('roles')->insert($roles);
    }
}
