<?php

use Illuminate\Database\Seeder;
use App\Models\Job;

class JobsTableSeeder extends Seeder
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
                'quota' => 15,
                'name' => '高级PHP研发工程师',
                'type' => '{"nd": "后端开发", "rd": "PHP", "st": "互联网+技术"}',
                'nature' => 'full',
                'location' => '{"city": "北京城区", "district": "海淀区", "province": "北京市"}',
                'salary_min' => '15',
                'salary_max' => '30',
                'welfare' => 'five_social_insurance_and_one_housing_fund',
                'sparkle' => '工作时间自由，晋升空间大',
                'age_min' => '25',
                'age_max' => '30',
                'education' => 'undergraduate',
                'experience' => 'middle',
                'duty' => '百度搜索部门的后端研发',
                'requirement' => '逻辑缜密，责任心强',
                'urgency_level' => 0,
                'channel' => '["other_platform"]',
                'channel_remark' => '猎聘',
                'deadline' => '2021-07-15',
                'pv' => 0,
                'release_uid' => 1,
                'execute_uid' => 1,
                'company_id' => 1,
                'created_at' => '2021-05-24 14:35:00',
                'updated_at' => '2021-05-24 14:35:00',
                'status' => 1
            ],
            [
                'id' => 2,
                'quota' => 1,
                'name' => '中级JAVA研发工程师',
                'type' => '{"nd": "后端开发", "rd": "Java", "st": "互联网+技术"}',
                'nature' => 'full',
                'location' => '{"city": "北京城区", "district": "海淀区", "province": "北京市"}',
                'salary_min' => '10',
                'salary_max' => '15',
                'welfare' => 'five_social_insurance_and_one_housing_fund',
                'sparkle' => '公司氛围和谐',
                'age_min' => '20',
                'age_max' => '25',
                'education' => 'undergraduate',
                'experience' => 'middle',
                'duty' => '小程序后端研发',
                'requirement' => '逻辑缜密，责任心强',
                'urgency_level' => 1,
                'channel' => '["applets", "website"]',
                'channel_remark' => NULL,
                'deadline' => '2021-07-15',
                'pv' => 0,
                'release_uid' => 1,
                'execute_uid' => 1,
                'company_id' => 2,
                'created_at' => '2021-05-24 14:35:00',
                'updated_at' => '2021-05-24 14:35:00',
                'status' => 1
            ]
        ];
        Job::insert($data);
    }
}
