<?php

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentTableSeeder extends Seeder
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
            'name' => '总裁办',
            'level' => 10
        ], [
            'no' => 'N0001',
            'name' => '业务事业部',
            'level' => 20,
            'pno' => 'N01'
        ], [
            'no' => 'N0002',
            'name' => '产品运营部',
            'level' => 20,
            'pno' => 'N01'
        ], [
            'no' => 'N0003',
            'name' => '综合管理部',
            'level' => 20,
            'pno' => 'N01'
        ], [
            'no' => 'N000001',
            'name' => '交付一部',
            'level' => 30,
            'pno' => 'N0001'
        ], [
            'no' => 'N000002',
            'name' => '交付二部',
            'level' => 30,
            'pno' => 'N0001'
        ], [
            'no' => 'N000003',
            'name' => '销售部',
            'level' => 30,
            'pno' => 'N0001'
        ], [
            'no' => 'N000004',
            'name' => '产品',
            'level' => 30,
            'pno' => 'N0002'
        ], [
            'no' => 'N000005',
            'name' => '技术',
            'level' => 30,
            'pno' => 'N0002'
        ], [
            'no' => 'N000006',
            'name' => '市场',
            'level' => 30,
            'pno' => 'N0002'
        ], [
            'no' => 'N000007',
            'name' => '行政',
            'level' => 30,
            'pno' => 'N0003'
        ], [
            'no' => 'N000008',
            'name' => '人力',
            'level' => 30,
            'pno' => 'N0003'
        ], [
            'no' => 'N000009',
            'name' => '财务',
            'level' => 30,
            'pno' => 'N0003'
        ]];

        foreach ($list as $item) {
            if (Department::where('no', $item['no'])->count() > 0) {
                continue;
            }
            $department = new Department;
            foreach ($item as $key => $value) {
                $department->$key = $value;
            }
            $department->save();
        }
    }
}
