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
                'id' => 1,
                'account' => 'admin',
                'password' => bcrypt('admin123!@#'),
                'nickname' => '管理员',
                'name' => '管理员',
                'email' => '694986534@qq.com',
                'phone' => '15001332305',
                'is_admin' => true
            ],
            [
                'id' => 2,
                'account' => 'tiandeyu',
                'password' => bcrypt('tiandeyu123!@#'),
                'nickname' => '田德雨',
                'name' => '田德雨'
            ],
            [
                'id' => 3,
                'account' => 'jianghaiyang',
                'password' => bcrypt('jianghaiyang123!@#'),
                'nickname' => '姜海洋',
                'name' => '姜海洋'
            ],
            [
                'id' => 4,
                'account' => 'liruishan',
                'password' => bcrypt('liruishan123!@#'),
                'nickname' => '李瑞珊',
                'name' => '李瑞珊'
            ],
            [
                'id' => 5,
                'account' => 'yucunxiang',
                'password' => bcrypt('yucunxiang123!@#'),
                'nickname' => '于存享',
                'name' => '于存享'
            ],
            [
                'id' => 6,
                'account' => 'zhixianlu',
                'password' => bcrypt('zhixianlu123!@#'),
                'nickname' => '支宪璐',
                'name' => '支宪璐'
            ],
            [
                'id' => 7,
                'account' => 'yeruizhao',
                'password' => bcrypt('yeruizhao123!@#'),
                'nickname' => '叶睿钊',
                'name' => '叶睿钊'
            ],
            [
                'id' => 8,
                'account' => 'zhangcong',
                'password' => bcrypt('zhangcong123!@#'),
                'nickname' => '张聪',
                'name' => '张聪'
            ],
            [
                'id' => 9,
                'account' => 'lujing',
                'password' => bcrypt('lujing123!@#'),
                'nickname' => '卢靓',
                'name' => '卢靓'
            ],
            [
                'id' => 10,
                'account' => 'zhangxinyi',
                'password' => bcrypt('zhangxinyi123!@#'),
                'nickname' => '张馨怡',
                'name' => '张馨怡'
            ],
            [
                'id' => 11,
                'account' => 'lipingping',
                'password' => bcrypt('lipingping123!@#'),
                'nickname' => '李萍萍',
                'name' => '李萍萍',
            ],
            [
                'id' => 12,
                'account' => 'yanjinjing',
                'password' => bcrypt('yanjinjing123!@#'),
                'nickname' => '严瑾婧',
                'name' => '严瑾婧',
            ],
            [
                'id' => 13,
                'account' => 'wangshuai',
                'password' => bcrypt('wangshuai123!@#'),
                'nickname' => '王帅',
                'name' => '王帅',
            ],
            [
                'id' => 14,
                'account' => 'zhangao',
                'password' => bcrypt('zhangao123!@#'),
                'nickname' => '张傲',
                'name' => '张傲',
            ],
            [
                'id' => 16,
                'account' => 'chenchunze',
                'password' => bcrypt('chenchunze123!@#'),
                'nickname' => '陈春泽',
                'name' => '陈春泽',
            ],
            [
                'id' => 17,
                'account' => 'zhangbaocun',
                'password' => bcrypt('zhangbaocun123!@#'),
                'nickname' => '张保存',
                'name' => '张保存',
            ],
            [
                'id' => 18,
                'account' => 'lixinru',
                'password' => bcrypt('lixinru123!@#'),
                'nickname' => '李新儒',
                'name' => '李新儒',
            ],
            [
                'id' => 19,
                'account' => 'caibo',
                'password' => bcrypt('caibo123!@#'),
                'nickname' => '蔡博',
                'name' => '蔡博',
            ],
            [
                'id' => 20,
                'account' => 'wuzhenfeng',
                'password' => bcrypt('wuzhenfeng123!@#'),
                'nickname' => '武振丰',
                'name' => '武振丰',
            ],
        ];

        foreach ($users as $user) {
            if (User::where('account', $user['account'])->count() > 0) {
                continue;
            }
            User::updateOrCreate($user);
        }

        // User::insert($users);
    }
}
