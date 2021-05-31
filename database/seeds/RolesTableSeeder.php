<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'role_name' => 'admin',
                'level' => 1,
                'permission' => json_encode([])
            ],
            [
                'role_name' => 'RPO总监',
                'level' => 2,
                'permission' => json_encode([])
            ],
            [
                'role_name' => '交付专员',
                'level' => 3,
                'permission' => json_encode([])
            ],
            [
                'role_name' => '创意总监',
                'level' => 3,
                'permission' => json_encode([])
            ]
        ];

        Role::insert($roles);
    }
}
