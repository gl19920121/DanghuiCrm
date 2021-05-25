<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\JobsExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Job;

class ExcelController extends Controller
{
    public function exportJob(Job $job)
    {
        $row = [
            [
                'name' => '公司名称',
                'location' => '所在地',
                'industry' => '所属行业',
                'nature' => '企业性质',
                'scale' => '企业规模',
                'investment' => '公司名称',
                'quota' => '招聘人数'
            ],
            [
                'name' => '职位名称',
                'type' => '职位类别',
                'nature' => '工作性质',
                'location' => '工作城市',
                'salary' => '税前月薪',
                'welfare' => '福利待遇',
                'sparkle' => '职位亮点'
            ]
        ];
        $list = [
            [
                'name' => $job->company->name,
                'location' => $job->company->locationShow,
                'industry' => $job->company->industryShow,
                'nature' => $job->company->natureShow,
                'scale' => $job->company->scaleShow,
                'investment' => $job->company->investmentShow,
                'quota' => $job->quota
            ],
            [
                'name' => $job->name,
                'type' => $job->typeShow,
                'nature' => $job->natureShow,
                'location' => $job->locationShow,
                'salary' => sprintf('%sK-%sK', $job->salary_min, $job->salary_max),
                'welfare' => $job->welfareShow,
                'sparkle' => $job->sparkle
            ]
        ];
        return Excel::download(new JobsExport($row, $list), 'jobs.xlsx');
    }
}
