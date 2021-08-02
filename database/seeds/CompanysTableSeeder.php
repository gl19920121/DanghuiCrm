<?php

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'name' => '百度',
                'nickname' => '百度',
                'industry' => '{"nd": "互联网/移动互联网/电子商务", "rd": "互联网/移动互联网/电子商务", "st": "互联网.游戏.软件", "th": "互联网/移动互联网/电子商务"}',
                'location' => '{"province": "北京市", "city": "北京城区", "district": "海淀区"}',
                'address' => '百度科技园',
                'nature' => 'private',
                'scale' => 7,
                'investment' => 'not_needed',
                'logo' => '2021-07-21/3/ItoGfmZpOdrjCqY9QF1O6pGtmdUO1DEJFRAJa66l.png',
                'introduction' => '百度',
                'created_at' => '2021-05-21 15:37:19',
                'updated_at' => '2021-05-21 15:37:19',
                'status' => 1
            ],
            [
                'id' => 2,
                'name' => '清泰文化',
                'nickname' => '清泰文化',
                'industry' => '{"nd": "互联网/移动互联网/电子商务", "rd": "互联网/移动互联网/电子商务", "st": "互联网.游戏.软件", "th": "互联网/移动互联网/电子商务"}',
                'location' => '{"province": "北京市", "city": "北京城区", "district": "海淀区"}',
                'address' => '清华园',
                'nature' => 'private',
                'scale' => 1,
                'investment' => 'not_needed',
                'logo' => '2021-07-21/3/N5ECSysASu8jDdaSvzadVbulHM87DLHPcWeRXvTW.png',
                'introduction' => '当会直聘',
                'created_at' => '2021-05-21 15:37:19',
                'updated_at' => '2021-05-21 15:37:19',
                'status' => 1
            ]
        ];
        Company::insert($data);
    }
}
