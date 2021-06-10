<?php

use Illuminate\Database\Seeder;
use App\Models\User;

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
                'is_admin' => false
            ],
            [
                'account' => 'liruishan',
                'password' => bcrypt('liruishan123!@#'),
                'nickname' => '李瑞珊',
                'name' => '李瑞珊',
                'email' => '',
                'phone' => '',
                'is_admin' => false
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
            ]
        ];

        User::insert($users);
    }
}
