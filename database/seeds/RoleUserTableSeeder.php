<?php

use Illuminate\Database\Seeder;
use App\Models\RoleUser;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = RoleUser::create([
            'role_id' => 1,
            'user_id' => 1
        ]);

        $rpo = [
            [
                'role_id' => 2,
                'user_id' => 2
            ],
            [
                'role_id' => 2,
                'user_id' => 3
            ]
        ];
        RoleUser::insert($rpo);

        $deliver = [
            [
                'role_id' => 3,
                'user_id' => 4
            ],
            [
                'role_id' => 3,
                'user_id' => 5
            ],
            [
                'role_id' => 3,
                'user_id' => 6
            ]
        ];
        RoleUser::insert($deliver);
    }
}
