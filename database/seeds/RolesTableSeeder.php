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
        $admin = Role::firstOrCreate([
            'id' => 1,
            'name' => '管理员',
            'slug' => 'admin',
            'level' => 0,
            'is_root' => true
        ]);

        $ceo = Role::firstOrCreate([
            'id' => 2,
            'name' => '总裁',
            'slug' => 'ceo',
            'level' => 0,
            'is_root' => true
        ]);

        $rpo = Role::firstOrCreate([
            'id' => 3,
            'name' => 'RPO总监',
            'slug' => 'rpo',
            'level' => 1,
            'is_root' => true,
            'parent_id' => 2
        ]);
        $rpo2 = Role::firstOrCreate([
            'id' => 4,
            'name' => 'RPO总监',
            'slug' => 'rpo-2',
            'level' => 1,
            'is_root' => true,
            'parent_id' => 2
        ]);
        $rpo3 = Role::firstOrCreate([
            'id' => 6,
            'name' => 'RPO总监',
            'slug' => 'rpo-3',
            'level' => 1,
            'is_root' => true,
            'parent_id' => 2
        ]);

        $deliver = Role::firstOrCreate([
            'id' => 5,
            'name' => '交付专员',
            'slug' => 'deliver',
            'level' => 2,
            'parent_id' => 3
        ]);


    }
}
