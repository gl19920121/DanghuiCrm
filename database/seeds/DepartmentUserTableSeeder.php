<?php

use Illuminate\Database\Seeder;
use App\Models\DepartmentUser;

class DepartmentUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list = array();

        // 总裁办
        array_push($list, [
            'department_id' => 1,
            'user_id' => 11         // 李萍萍
        ], [
            'department_id' => 1,
            'user_id' => 12         // 严瑾婧
        ]);

        // 业务事业部
        array_push($list, [
            'department_id' => 2,
            'user_id' => 11         // 李萍萍
        ], [
            'department_id' => 2,
            'user_id' => 12         // 严瑾婧
        ]);

        // 交付一部
        array_push($list, [
            'department_id' => 5,
            'user_id' => 3          // 姜海洋
        ], [
            'department_id' => 5,
            'user_id' => 14         // 张傲
        ], [
            'department_id' => 5,
            'user_id' => 18         // 李新儒
        ], [
            'department_id' => 5,
            'user_id' => 21         // 姚康
        ]);

        // 交付二部
        array_push($list, [
            'department_id' => 6,
            'user_id' => 19         // 蔡博
        ]);

        // 销售部
        array_push($list, [
            'department_id' => 7,
            'user_id' => 19         // 蔡博
        ], [
            'department_id' => 7,
            'user_id' => 6          // 支宪璐
        ], [
            'department_id' => 7,
            'user_id' => 16         // 陈春泽
        ], [
            'department_id' => 7,
            'user_id' => 17         // 张保存
        ]);

        // 产品
        array_push($list, [
            'department_id' => 8,
            'user_id' => 2          // 田德雨
        ]);

        // 市场
        array_push($list, [
            'department_id' => 10,
            'user_id' => 9          // 卢靓
        ], [
            'department_id' => 10,
            'user_id' => 16         // 陈春泽
        ], [
            'department_id' => 10,
            'user_id' => 17         // 张保存
        ]);

        foreach ($list as $item) {
            if (DepartmentUser::where('department_id', $item['department_id'])->where('user_id', $item['user_id'])->count() > 0) {
                continue;
            }
            DepartmentUser::firstOrCreate($item);
        }
    }
}
