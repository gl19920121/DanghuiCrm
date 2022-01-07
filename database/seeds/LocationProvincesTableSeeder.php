<?php

use Illuminate\Database\Seeder;
use App\Models\LocationProvince;

class LocationProvincesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $provinces = [[
            'province_id' => 110000,
            'name' => '北京市',
            'level' => 'municipality'
        ], [
            'province_id' => 120000,
            'name' => '天津市',
            'level' => 'municipality'
        ], [
            'province_id' => 130000,
            'name' => '河北省',
            'level' => 'province'
        ], [
            'province_id' => 140000,
            'name' => '山西省',
            'level' => 'province'
        ], [
            'province_id' => 150000,
            'name' => '内蒙古自治区',
            'level' => 'autonomous_region'
        ], [
            'province_id' => 210000,
            'name' => '辽宁省',
            'level' => 'province'
        ], [
            'province_id' => 220000,
            'name' => '吉林省',
            'level' => 'province'
        ], [
            'province_id' => 230000,
            'name' => '黑龙江省',
            'level' => 'province'
        ], [
            'province_id' => 310000,
            'name' => '上海市',
            'level' => 'municipality'
        ], [
            'province_id' => 320000,
            'name' => '江苏省',
            'level' => 'province'
        ], [
            'province_id' => 330000,
            'name' => '浙江省',
            'level' => 'province'
        ], [
            'province_id' => 340000,
            'name' => '安徽省',
            'level' => 'province'
        ], [
            'province_id' => 350000,
            'name' => '福建省',
            'level' => 'province'
        ], [
            'province_id' => 360000,
            'name' => '江西省',
            'level' => 'province'
        ], [
            'province_id' => 370000,
            'name' => '山东省',
            'level' => 'province'
        ], [
            'province_id' => 410000,
            'name' => '河南省',
            'level' => 'province'
        ], [
            'province_id' => 420000,
            'name' => '湖北省',
            'level' => 'province'
        ], [
            'province_id' => 430000,
            'name' => '湖南省',
            'level' => 'province'
        ], [
            'province_id' => 440000,
            'name' => '广东省',
            'level' => 'province'
        ], [
            'province_id' => 450000,
            'name' => '广西壮族自治区',
            'level' => 'autonomous_region'
        ], [
            'province_id' => 460000,
            'name' => '海南省',
            'level' => 'province'
        ], [
            'province_id' => 500000,
            'name' => '重庆市',
            'level' => 'municipality'
        ], [
            'province_id' => 510000,
            'name' => '四川省',
            'level' => 'province'
        ], [
            'province_id' => 520000,
            'name' => '贵州省',
            'level' => 'province'
        ], [
            'province_id' => 530000,
            'name' => '云南省',
            'level' => 'province'
        ], [
            'province_id' => 540000,
            'name' => '西藏自治区',
            'level' => 'autonomous_region'
        ], [
            'province_id' => 610000,
            'name' => '陕西省',
            'level' => 'province'
        ], [
            'province_id' => 620000,
            'name' => '甘肃省',
            'level' => 'province'
        ], [
            'province_id' => 630000,
            'name' => '青海省',
            'level' => 'province'
        ], [
            'province_id' => 640000,
            'name' => '宁夏回族自治区',
            'level' => 'autonomous_region'
        ], [
            'province_id' => 650000,
            'name' => '新疆维吾尔自治区',
            'level' => 'autonomous_region'
        ], [
            'province_id' => 710000,
            'name' => '台湾省',
            'level' => 'province'
        ], [
            'province_id' => 810000,
            'name' => '香港特别行政区',
            'level' => 'special_administrative_region'
        ], [
            'province_id' => 820000,
            'name' => '澳门特别行政区',
            'level' => 'special_administrative_region'
        ]];

        LocationProvince::insert($provinces);
    }
}
