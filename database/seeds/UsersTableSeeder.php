<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'account' => 'admin',
                'password' => bcrypt('admin123!@#'),
                'nickname' => '管理员',
                'name' => '管理员',
                'email' => '694986534@qq.com',
                'phone' => '15001332305',
                'is_admin' => true
            ],
            [
                'account' => 'tiandeyu',
                'password' => bcrypt('tiandeyu123!@#'),
                'nickname' => '田德雨',
                'name' => '田德雨',
                'email' => '',
                'phone' => '',
                'is_admin' => false
            ],
            [
                'account' => 'jianghaiyang',
                'password' => bcrypt('jianghaiyang123!@#'),
                'nickname' => '姜海洋',
                'name' => '姜海洋',
                'email' => '',
                'phone' => '',
                'is_admin' => false,
                'created_at' => Carbon::parse('2 days ago')->toDateTimeString(),
                'updated_at' => Carbon::parse('2 days ago')->toDateTimeString(),
            ],
            [
                'account' => 'liruishan',
                'password' => bcrypt('liruishan123!@#'),
                'nickname' => '李瑞珊',
                'name' => '李瑞珊',
                'email' => '',
                'phone' => '',
                'is_admin' => false,
                'created_at' => Carbon::parse('-1 weeks')->toDateTimeString(),
                'updated_at' => Carbon::parse('-1 weeks')->toDateTimeString(),
            ],
            [
                'account' => 'yucunxiang',
                'password' => bcrypt('yucunxiang123!@#'),
                'nickname' => '于存享',
                'name' => '于存享',
                'email' => '',
                'phone' => '',
                'is_admin' => false
            ],
            [
                'account' => 'zhixianlu',
                'password' => bcrypt('zhixianlu123!@#'),
                'nickname' => '支宪璐',
                'name' => '支宪璐',
                'email' => '',
                'phone' => '',
                'is_admin' => false
            ],
            [
                'account' => 'yeruizhao',
                'password' => bcrypt('yeruizhao123!@#'),
                'nickname' => '叶睿钊',
                'name' => '叶睿钊',
                'email' => '',
                'phone' => '',
                'is_admin' => false
            ],
            [
                'account' => 'zhangcong',
                'password' => bcrypt('zhangcong123!@#'),
                'nickname' => '张聪',
                'name' => '张聪',
                'email' => '',
                'phone' => '',
                'is_admin' => false
            ]
        ];

        foreach ($users as $user) {
            if (User::where('name', $user['name'])->count() > 0) {
                continue;
            }
            User::create($user);
        }

        // User::insert($users);
    }
}
