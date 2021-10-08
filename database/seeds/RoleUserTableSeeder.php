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
        $admin = RoleUser::firstOrCreate([
            'role_id' => 1,
            'user_id' => 1
        ]);

        $users = [
            [
                'role_id' => 2,
                'user_id' => 2
            ],
            [
                'role_id' => 2,
                'user_id' => 3
            ],
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
            ],
            [
                'role_id' => 4,
                'user_id' => 9
            ],
            [
                'role_id' => 4,
                'user_id' => 10
            ],
            [
                'role_id' => 5,
                'user_id' => 11
            ]
        ];

        foreach ($users as $user) {
            RoleUser::firstOrCreate($user);
        }
    }
}
