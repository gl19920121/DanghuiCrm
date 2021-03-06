<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Exports\JobsExport;
use App\Imports\ResumesImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Job;
use App\Models\User;
use App\Models\Resume;
use App\Models\ResumeEdu;
use Auth;
use Carbon\Carbon;

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

    public function exportJobStatistics(Request $request)
    {
        // dd($request->all());
        $ids = $request->id;
        $type = $request->type;
        $startAt = $request->filled('start_at') ? Carbon::parse($request->start_at) : null;
        $endAt = $request->filled('end_at') ? Carbon::parse($request->end_at) : Carbon::today();

        $jobsExport = new JobsExport($ids, $type, $startAt, $endAt);
        if ($request->filled('start_at')) {
            $fileName = sprintf('交付系统职位统计表 %s 至 %s.xlsx', $startAt->toDateString(), $endAt->toDateString());
        } else {
            $fileName = sprintf('交付系统职位统计表 至 %s.xlsx', $request->filled('end_at') ? $endAt->toDateString() : Carbon::today());
        }

        if (empty($startAt)) {
            $fileName = sprintf('交付系统职位统计表 截止至 %s.xlsx', $endAt->toDateString());
        } else if ($endAt->diffInDays($startAt) === 0) {
            $fileName = sprintf('交付系统职位统计表 %s.xlsx', $startAt->toDateString());
        } else {
            $fileName = sprintf('交付系统职位统计表 %s 至 %s.xlsx', $startAt->toDateString(), $endAt->toDateString());
        }

        return Excel::download($jobsExport, $fileName);
    }

    public function importResume(Request $request)
    {
        $filePath = NULL;
        $file = $request->file('attachment');
        if($request->hasFile('attachment')) {
            if (!$file->isValid()) {
                session()->flash('danger', '简历上传失败');
                return redirect()->back()->withInput();
            }
            $filePath = Storage::disk('resume_append')->putFile(date('Y-m-d').'/'.$request->user()->id, $file);
        }
        unset($file);

        // $resumesImport = Excel::import(new ResumesImport, $filePath, 'resume_append');
        $list = Excel::toArray(new ResumesImport, $filePath, 'resume_append');
        // dd($list);
        // for ($i=0; $i < count($list); $i++) {
        for ($i=0; $i < 1; $i++) {
            $startIndex = 3;
            for ($index=$startIndex; $index < count($list[$i]); $index++) {

                $row = empty($list[$i][$index]) ? NULL : $list[$i][$index];
                $requiredIndex = [0, 1, 2, 3, 4, 6, 7, 9, 10];
                $resume = new Resume();
                $resumeEdu = new ResumeEdu();

                foreach ($row as $rIndex => $item) {
                    $item = preg_replace('# #', '', $item);
                    if (empty($item)) {
                        if (in_array($rIndex, $requiredIndex)) {
                            continue 2;
                        }
                        $row[$rIndex] = NULL;
                    }
                }
                // dd($row);

                $oldCount = Resume::where('name', '=', $row[0])->where('phone_num', '=', $row[9])->count();
                if ($oldCount > 0) {
                    continue;
                }

                $resume->name = $row[0];
                $resume->sex = $row[1];
                $resume->age = $row[2];
                $resume->location = [
                    'province' => $row[3],
                    'city' => $row[4],
                    'district' => $row[5]
                ];
                $resume->work_years = $row[6];
                $resume->work_years_flag = 0;
                $resume->education = $row[7];
                $resume->major = $row[8];
                $resume->phone_num = $row[9];
                $resume->email = $row[10];
                $resume->wechat = $row[11];
                $resume->qq = $row[12];
                $resume->cur_industry = $row[13];
                $resume->cur_position = $row[14];
                $resume->cur_company = $row[15];
                $resume->cur_salary = $row[16];
                $resume->upload_uid = Auth::user()->id;
                $resume->source = ['batch'];
                $resume->save();

                if (!empty($row[17]) && !empty($row[18])) {
                    $resumeEdu->school_name = $row[17];
                    $resumeEdu->school_level = $row[18];
                    $resumeEdu->major = $row[19];
                    $resumeEdu->resume_id = $resume->id;
                    $resumeEdu->save();
                }

                $resume->save();
            }
        }

        session()->flash('result', '简历已上传');
        return redirect()->back()->withInput();
    }
}
