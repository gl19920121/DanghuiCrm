<?php

use Illuminate\Database\Seeder;
use App\Models\DepartmentPosition;

class DepartmentPositionTableSeeder extends Seeder
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
            'position_id' => 1         // 总经理
        ], [
            'department_id' => 1,
            'position_id' => 2         // COO
        ]);

        // 交付一部
        array_push($list, [
            'department_id' => 5,
            'position_id' => 3         // 项目总监
        ], [
            'department_id' => 5,
            'position_id' => 9         // 资深执行顾问
        ]);

        // 交付二部
        array_push($list, [
            'department_id' => 6,
            'position_id' => 3         // 项目总监
        ]);

        // 销售部
        array_push($list, [
            'department_id' => 7,
            'position_id' => 4         // 销售总监
        ], [
            'department_id' => 7,
            'position_id' => 6          // 商务拓展经理
        ]);

        // 产品
        array_push($list, [
            'department_id' => 8,
            'position_id' => 5          // 产品总监
        ]);

        // 市场
        array_push($list, [
            'department_id' => 10,
            'position_id' => 8          // 新媒体运营
        ]);

        foreach ($list as $item) {
            if (DepartmentPosition::where('department_id', $item['department_id'])->where('position_id', $item['position_id'])->count() > 0) {
                continue;
            }
            DepartmentPosition::firstOrCreate($item);
        }
    }
}
