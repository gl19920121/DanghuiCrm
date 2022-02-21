<?php

use Illuminate\Database\Seeder;
use App\Models\Position;

class PositionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list = [[
            'no' => 'N01',
            'name' => '总经理',
            'level' => 10
        ], [
            'no' => 'N02',
            'name' => 'COO',
            'level' => 10
        ], [
            'no' => 'N0001',
            'name' => '项目总监',
            'level' => 20
        ], [
            'no' => 'N0002',
            'name' => '销售总监',
            'level' => 20
        ], [
            'no' => 'N0003',
            'name' => '产品总监',
            'level' => 20
        ], [
            'no' => 'N000001',
            'name' => '商务拓展经理',
            'level' => 30
        ], [
            'no' => 'N000002',
            'name' => '工程师',
            'level' => 30
        ], [
            'no' => 'N000003',
            'name' => '新媒体运营',
            'level' => 30
        ], [
            'no' => 'N00000001',
            'name' => '资深执行顾问',
            'level' => 40
        ], [
            'no' => 'N00000002',
            'name' => '实习顾问',
            'level' => 40
        ]];

        foreach ($list as $item) {
            if (Position::where('no', $item['no'])->count() > 0) {
                continue;
            }
            $position = new Position;
            foreach ($item as $key => $value) {
                $position->$key = $value;
            }
            $position->save();
        }
    }
}
