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
            // CEO
            [
                'role_id' => 2,
                'user_id' => 11
            ],
            [
                'role_id' => 2,
                'user_id' => 12
            ],
            // RPO
            [
                'role_id' => 3,
                'user_id' => 2
            ],
            [
                'role_id' => 3,
                'user_id' => 3
            ],
            // RPO-2
            [
                'role_id' => 4,
                'user_id' => 13
            ],
            // 招聘专员
            [
                'role_id' => 5,
                'user_id' => 4
            ],
            [
                'role_id' => 5,
                'user_id' => 5
            ],
            [
                'role_id' => 5,
                'user_id' => 6
            ],
            [
                'role_id' => 5,
                'user_id' => 7
            ],
            [
                'role_id' => 5,
                'user_id' => 8
            ],
            [
                'role_id' => 5,
                'user_id' => 10
            ],
            [
                'role_id' => 5,
                'user_id' => 10
            ],
            [
                'role_id' => 5,
                'user_id' => 14
            ]
        ];

        foreach ($users as $user) {
            if (RoleUser::where('role_id', $user['role_id'])->where('user_id', $user['user_id'])->count() > 0) {
                continue;
            }
            RoleUser::firstOrCreate($user);
        }
    }
}
