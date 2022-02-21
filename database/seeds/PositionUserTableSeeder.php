<?php

use Illuminate\Database\Seeder;
use App\Models\PositionUser;

class PositionUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list = array();

        // LEVEL 10
        array_push($list, [
            'position_id' => 1,   // 总经理
            'user_id' => 11        // 李萍萍
        ], [
            'position_id' => 2,   // COO
            'user_id' => 12        // 严瑾婧
        ]);

        // LEVEL 20
        array_push($list, [
            'position_id' => 3,   // 项目总监
            'user_id' => 3         // 姜海洋
        ], [
            'position_id' => 3,   // 项目总监
            'user_id' => 19        // 蔡博
        ], [
            'position_id' => 4,   // 销售总监
            'user_id' => 19        // 蔡博
        ], [
            'position_id' => 5,   // 产品总监
            'user_id' => 2         // 田德雨
        ]);

        // LEVEL 30
        array_push($list, [
            'position_id' => 6,   // 商务拓展经理
            'user_id' => 6         // 支宪璐
        ], [
            'position_id' => 8,   // 新媒体运营
            'user_id' => 9         // 卢靓
        ]);

        // LEVEL 40
        array_push($list, [
            'position_id' => 9,   // 资深执行顾问
            'user_id' => 14        // 张傲
        ], [
            'position_id' => 9,   // 资深执行顾问
            'user_id' => 18        // 李新儒
        ], [
            'position_id' => 9,   // 资深执行顾问
            'user_id' => 21        // 姚康
        ], [
            'position_id' => 10,  // 实习顾问
            'user_id' => 16        // 陈春泽
        ], [
            'position_id' => 10,  // 实习顾问
            'user_id' => 17        // 张保存
        ]);

        foreach ($list as $item) {
            if (PositionUser::where('position_id', $item['position_id'])->where('user_id', $item['user_id'])->count() > 0) {
                continue;
            }
            PositionUser::firstOrCreate($item);
        }
    }
}
