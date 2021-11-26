<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\JobsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Job;
use App\Models\User;

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
                'salary' => $job->salary_show,
                'welfare' => $job->welfareShow,
                'sparkle' => $job->sparkle
            ]
        ];
        return Excel::download(new JobsExport($row, $list), "$job->name.xlsx");
    }

    public function exportUserJob(User $user)
    {
        $row = []; $list = [];

        foreach ($user->executeJobs as $index => $job) {
            $rowItem = []; $listItem = [];

            $rowItem['job_name'] = '职位名称';
            $rowItem['resume_count'] = '应聘简历';
            $rowItem['resume_talking_count'] = '电话沟通';
            $rowItem['resume_push_resume_count'] = '推荐简历';
            $rowItem['resume_interview_count'] = '面试';
            $rowItem['resume_offer_count'] = 'OFFER';
            $rowItem['resume_onboarding_count'] = '入职';
            $rowItem['resume_over_probation_count'] = '过保';
            $rowItem['resume_out_count'] = '淘汰';

            $listItem['job_name'] = $job->name;
            $listItem['resume_count'] = (string)$job->resumes()->count();
            $listItem['resume_talking_count'] = (string)$job->resumes()->talking()->count();
            $listItem['resume_push_resume_count'] = (string)$job->resumes()->pushResume()->count();
            $listItem['resume_interview_count'] = (string)$job->resumes()->interview()->count();
            $listItem['resume_offer_count'] = (string)$job->resumes()->offer()->count();
            $listItem['resume_onboarding_count'] = (string)$job->resumes()->onboarding()->count();
            $listItem['resume_over_probation_count'] = (string)$job->resumes()->overProbation()->count();
            $listItem['resume_out_count'] = (string)$job->resumes()->out()->count();

            $row[] = $rowItem;
            $list[] = $listItem;
        }

        return Excel::download(new JobsExport($row, $list), "$user->name-职位统计.xlsx");
    }

    public function introductionResume()
    {

    }
}
