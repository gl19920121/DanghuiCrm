<?php

use Illuminate\Database\Seeder;
use App\Models\Resume;
use App\Models\ResumeWork;
use App\Models\ResumePrj;
use App\Models\ResumeEdu;

class ResumesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resumes = [
            [
                'id' => 1,
                'name' => '高朗',
                'sex' => '男',
                'age' => '29',
                'location' => '{"city": "北京城区", "district": "海淀区", "province": "北京市"}',
                'work_years_flag' => 0,
                'work_years' => 6,
                'education' => 'undergraduate',
                'major' => '计算机科学与技术',
                'phone_num' => '15001332305',
                'email' => '694986534@qq.com',
                'wechat' => 'danteandlady',
                'qq' => '694986534',
                'cur_industry' => '{"nd": "互联网/移动互联网/电子商务", "rd": "互联网/移动互联网/电子商务", "st": "互联网.游戏.软件", "th": "互联网/移动互联网/电子商务"}',
                'cur_position' => '{"nd": "后端开发", "rd": "PHP", "st": "互联网+技术"}',
                'cur_company' => '清泰文化',
                'cur_salary' => '50',
                'cur_salary_count' => '14',
                'exp_industry' => '{"nd": "互联网/移动互联网/电子商务", "rd": "互联网/移动互联网/电子商务", "st": "互联网.游戏.软件", "th": "互联网/移动互联网/电子商务"}',
                'exp_position' => '{"nd": "后端开发", "rd": "PHP", "st": "互联网+技术"}',
                'exp_work_nature' => 'full',
                'exp_location' => '{"city": "北京城区", "district": "海淀区", "province": "北京市"}',
                'exp_salary_flag' => 1,
                'exp_salary_min' => NULL,
                'exp_salary_max' => NULL,
                'exp_salary_count' => NULL,
                'jobhunter_status' => 0,
                'social_home' => 'www.baidu.com',
                'personal_advantage' => '毫无优势',
                'blacklist' => '安普诺',
                'remark' => '无',
                'source' => '["other_platform"]',
                'source_remarks' => '猎聘',
                'upload_uid' => 1,
                'attachment_path' => '2021-05-19/1/jcMdxsv2QzSJGbWZvcJeT3tThbk8bSMlNCqnclqP.doc',
                'job_id' => 1,
                'created_at' => '2021-05-24 14:35:00',
                'updated_at' => '2021-05-24 14:35:00',
                'status' => 1
            ]
        ];

        $resume_works = [
            [
                'id' => 1,
                'company_name' => '百度',
                'company_nature' => 'private',
                'company_scale' => 7,
                'company_industry' => '{"nd": "互联网/移动互联网/电子商务", "rd": "互联网/移动互联网/电子商务", "st": "互联网.游戏.软件", "th": "互联网/移动互联网/电子商务"}',
                'job_type' => '{"nd": "后端开发", "rd": "PHP", "st": "互联网+技术"}',
                'start_at' => '2010-07-01',
                'end_at' => '2020-11-27',
                'is_not_end' => 0,
                'work_desc' => '百度智能汽车C端研发',
                'resume_id' => 1,
                'created_at' => '2021-05-24 14:35:00',
                'updated_at' => '2021-05-24 14:35:00'
            ]
        ];

        $resume_prjs = [
            [
                'id' => 1,
                'name' => '小天才智能手表',
                'role' => '研发总监',
                'start_at' => '2010-07-01',
                'end_at' => '2020-11-27',
                'is_not_end' => 1,
                'body' => '小天才',
                'resume_id' => 1,
                'created_at' => '2021-05-24 14:35:00',
                'updated_at' => '2021-05-24 14:35:00'
            ]
        ];

        $resume_edus = [
            [
                'id' => 1,
                'school_name' => '北京信息科技大学',
                'school_level' => 'undergraduate',
                'major' => '计算机科学与技术',
                'start_at' => '2010-09-01',
                'end_at' => '2014-07-01',
                'is_not_end' => 0,
                'resume_id' => 1,
                'created_at' => '2021-05-24 14:35:00',
                'updated_at' => '2021-05-24 14:35:00'
            ]
        ];
        Resume::insert($resumes);
        ResumeWork::insert($resume_works);
        ResumePrj::insert($resume_prjs);
        ResumeEdu::insert($resume_edus);
    }
}
