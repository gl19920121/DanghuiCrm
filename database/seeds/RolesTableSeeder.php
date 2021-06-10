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
        $admin = Role::create([
            'name' => '管理员',
            'slug' => 'admin',
            'level' => 0,
            'is_root' => true,
            'permissions' => []
        ]);

        $rpo = Role::create([
            'name' => 'RPO总监',
            'slug' => 'rpo',
            'level' => 1,
            'is_root' => true,
            'permissions' => []
        ]);

        $deliver = Role::create([
            'name' => '交付专员',
            'slug' => 'deliver',
            'level' => 2,
            'permissions' => []
        ]);
    }
}
