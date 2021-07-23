<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Pagination Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used by the paginator library to build
    | the simple pagination links. You are free to change them to anything
    | you want to customize your views to better match your application.
    |
    */

    'job' => [
        'nature' => [
            'full' => '全职',
            'part' => '兼职',
            'all' => '全职/兼职',
        ],
        'urgency_level' => [
            '0' => '标准',
            '1' => '急聘',
        ],
        'channel_default' => [''],
    ],
    'resume' => [
        'work_years' => [
            '1' => '学生在读',
            '2' => '应届毕业生',
        ],
        'jobhunter_status' => [
            '0' => '在职-暂不考虑',
            '1' => '在职-考虑机会',
            '2' => '在职-月内到岗',
            '3' => '离职-随时到岗',
        ],
        'update_date' => [
            '1' => '最近三天',
            '2' => '最近一周',
            '3' => '最近两周',
            '4' => '最近一个月',
            '5' => '一个月以上',
        ],
        'channel_default' => [''],
    ],
    'company' => [
        'nature' => [
            'foreign' => '外商独资/外企办事处',
            'joint_venture' => '中外合营(合资/合作)',
            'private' => '私营/民营企业',
            'state' => '国有企业',
            'listed' => '国内上市公司',
            'government' => '政府机关／非盈利机构',
            'institution' => '事业单位',
            'other' => '其他',
        ],
        'scale' => [
            '1-49人',
            '50-99人',
            '100-499人',
            '500-999人',
            '1000-2000人',
            '2000-5000人',
            '5000-10000人',
            '10000人以上',
        ],
        'investment' => [
            'angel' => '天使轮',
            'round_a' => 'A轮',
            'round_b' => 'B轮',
            'round_c' => 'C轮',
            'round_d_and_above' => 'D轮及以上',
            'fuk' => '已上市',
            'strategic' => '战略融资',
            'undisclosed' => '融资未公开',
            'not_needed' => '不需要融资',
            'other' => '其他',
        ],
    ],
    'welfare' => [
        'social_insurance' => '社会保险',
        'five_social_insurance_and_one_housing_fund' => '五险一金',
        'four_social_insurance_and_one_housing_fund' => '四险一金',
    ],
    'education' => [
        'unlimited' => '不限',
        'high_schoo' => '高中',
        'junior' => '专科',
        'undergraduate' => '本科',
        'master' => '硕士',
        'doctor' => '博士',
    ],
    'experience' => [
        'unlimited' => '经验不限',
        'school' => '学生在读',
        'fresh_graduates' => '应届毕业生',
        'primary' => '1-3',
        'middle' => '3-5',
        'high' => '5-10',
        'expert' => '10年以上',
    ],
    'channel' => [
        'applets' => '小程序',
        'website' => '官网',
        'other_platform' => '其他',
    ],
    'channel_remark' => ['other_platform'],
    'source_remarks' => [
        'liepin' => '猎聘',
        '58zhaopin' => '58招聘',
        'qianchengwuyou' => '前程无忧',
        'zhilianzhaopin' => '智联招聘',
        'bosszhipin' => 'BOSS直聘',
        'maimai' => '脉脉',
        'offline_meeting' => '线下会议活动',
        'partner' => '合作方提供',
        'other' => '其他',
    ],

];
