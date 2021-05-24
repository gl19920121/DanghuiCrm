<?php

use Illuminate\Database\Seeder;
use App\Models\Resume;

class ResumesTableSeeder extends Seeder
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
                'name' => '高朗',
                'sex' => '男',
                'age' => '29',
                'city' => '北京',
                'work_years_flag' => 6,
                'work_years' => 6,
                'education' => '本科',
                'phone_num' => '15001332305',
                'email' => '694986534@qq.com',
                'wechat_or_qq' => '694986534',
                'cur_industry' => '教育',
                'cur_position' => '中级PHP研发工程师',
                'cur_company' => '清泰文化',
                'cur_salary' => '50',
                'exp_industry' => '互联网',
                'exp_position' => 'PHP研发工程师',
                'exp_work_nature' => '全职',
                'exp_city' => '北京',
                'exp_salary_flag' => 0,
                'exp_salary' => NULL,
                'jobhunter_status' => 0,
                'source' => 1,
                'source_remarks' => NULL,
                'upload_uid' => 1,
                'attachment_path' => '2021-05-19/1/jcMdxsv2QzSJGbWZvcJeT3tThbk8bSMlNCqnclqP.doc',
                'job_id' => 1,
                'created_at' => '2021-05-24 14:35:00',
                'updated_at' => '2021-05-24 14:35:00',
                'status' => 1
            ]
        ];
        Resume::insert($data);
    }
}
