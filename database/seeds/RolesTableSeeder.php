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
            'id' => 1,
            'name' => '管理员',
            'slug' => 'admin',
            'level' => 0,
            'is_root' => true,
            'permissions' => []
        ]);

        $rpo = Role::create([
            'id' => 2,
            'name' => 'RPO总监',
            'slug' => 'rpo',
            'level' => 1,
            'is_root' => true,
            'permissions' => []
        ]);

        $deliver = Role::create([
            'id' => 3,
            'name' => '交付专员',
            'slug' => 'deliver',
            'level' => 2,
            'parent_id' => 2,
            'permissions' => []
        ]);
    }
}
