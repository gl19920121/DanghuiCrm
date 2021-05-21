<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Resume;
use App\Models\Draft;
use App\Models\Company;
use Auth;

class JobsController extends Controller
{
    private $pageSize = 1;

    public function __construct()
    {
        $this->middleware('auth', [
            'except' => []
        ]);
    }

    public function create(Request $request)
    {
        $oldData = $request->job_data;
        if (is_array($oldData)) {
            if (isset($oldData['type']) && !empty($oldData['type'])) {
                $oldData['type'] = json_decode($oldData['type'], true);
            }
            if (isset($oldData['location']) && !empty($oldData['location'])) {
                $oldData['location'] = json_decode($oldData['location'], true);
            }
            if (isset($oldData['company_id']) && !empty($oldData['company_id'])) {
                $oldData['company'] = Company::find($oldData['company_id']);
            }
        }

        $companys = Company::where('status', '=', 1)->get();

        return view('jobs.create')
            ->with('draftId', $request->draft_id)
            ->with('oldData', $oldData)
            ->with('companys', $companys)
            ;
    }

    public function store(Request $request)
    {
        // $data = $request->toArray();
        // return $data['location'];
        $mssages = [
            'company_id.required' => '请填写 公司名称',
            'quota.numeric' => '请正确输入 招聘人数',
            'name.required' => '请填写 职位名称',
            'type.st.required' => '请选择 职位类别',
            'type.nd.required' => '请选择 职位类别',
            'type.rd.required' => '请选择 职位类别',
            'nature.required' => '请选择 工作性质',
            'location.province.required' => '请选择 工作城市',
            'location.city.required' => '请选择 工作城市',
            'location.district.required' => '请选择 工作城市',
            'salary_min.required' => '请填写 税前月薪',
            'salary_min.numeric' => '请正确填写 税前月薪',
            'salary_max.required' => '请填写 税前月薪',
            'salary_max.numeric' => '请正确填写 税前月薪',
            'welfare.required' => '请选择 福利待遇',
            'age_min.required' => '请选择 年龄范围',
            'age_min.numeric' => '请选择 年龄范围',
            'age_max.required' => '请选择 年龄范围',
            'age_max.numeric' => '请选择 年龄范围',
            'education.required' => '请填写 学历要求',
            'experience.required' => '请填写 经验要求',
            'duty.required' => '请填写 工作职责',
            'requirement.required' => '请填写 任职要求',
            'urgency_level.required' => '请选择 紧急程度',
            'channel.required' => '请选择 渠道',
            'deadline.required' => '请填写 截止日期',
        ];
        $this->validate($request, [
            'company_id' => 'required',
            'quota' => 'nullable|numeric',
            'name' => 'required|string',
            'type.st' => 'required',
            'type.nd' => 'required',
            'type.rd' => 'required',
            'nature' => 'bail|required|in:' . implode(",", array_keys(Job::natureArr)),
            'location.province' => 'required',
            'location.city' => 'required',
            'location.district' => 'required',
            'salary_min' => 'required|numeric',
            'salary_max' => 'required|numeric',
            'welfare' => 'required|in:' . implode(",", array_keys(Job::welfareArr)),
            'sparkle' => 'nullable|string',
            'age_min' => 'required|numeric',
            'age_max' => 'required|numeric',
            'education' => 'required|in:' . implode(",", array_keys(Job::educationArr)),
            'experience' => 'required|in:' . implode(",", array_keys(Job::experienceArr)),
            'duty' => 'required|string',
            'requirement' => 'required|string',
            'urgency_level' => 'required|in:' . implode(",", array_keys(Job::urgencyLevelArr)),
            'channel' => 'required',
            'channel_remark' => 'nullable|string',
            'deadline' => 'required|date'
        ], $mssages);

        $data = $request->toArray();
        unset($data['draft_id']);
        $data['release_uid'] = Auth::user()->id;
        if (isset($request->execute_uid)) {
            $data['execute_uid'] = $request->execute_uid;
        } else {
            $data['execute_uid'] = Auth::user()->id;
        }
        $data['type'] = json_encode($data['type']);
        $data['location'] = json_encode($data['location']);
        $data['channel'] = json_encode(array_keys($data['channel']));
        $job = Job::create($data);

        if (isset($request->draft_id)) {
            Draft::destroy($request->draft_id);
        }

        session()->flash('success', '发布成功');
        return redirect()->route('jobs.list');
    }

    public function list(Request $request)
    {
        // return $request->toArray();
        if ($request->has('tab')) {
            $tab = $request->tab;
        } else {
            $tab = 'ing';
        }
        $jobs = Job::
            where(function ($query) use($tab) {
                switch ($tab) {
                    case 'ing':
                        $query->where('status', '=', 1);
                        break;
                    case 'pause':
                        $query->where('status', '=', 2);
                        break;
                    case 'end':
                        $query->where('status', '=', 3);
                        break;

                    default:
                        $query->where('status', '=', 1);
                        break;
                }
            })
            ->where('execute_uid', '=', Auth::user()->id)
            ->withCount('resumes')
            ->where(function ($query) use($request) {
                if (!empty($request->name)) {
                    $query->where('name', 'like', '%'.$request->name.'%');
                }
                if (isset($request->urgency_level)) {
                    $query->where('urgency_level', '=', $request->urgency_level);
                }
                if (!empty($request->channel)) {
                    $query->whereJsonContains('channel', $request->channel);
                }
            });
        $jobs = $jobs->paginate($this->pageSize);

        $appends = [
            'tab' => $tab,
            'name' => $request->name,
            'urgencyLevel' => $request->urgency_level,
            'channel' => $request->channel
        ];

        return view('jobs.list')
            ->with('jobs', $jobs)
            ->with('appends', $appends);
    }

    public function show(Job $job, Request $request)
    {
        $tab = isset($request->tab) ? $request->tab : 'untreated';
        $resumes = $job->resumes()
            ->where(
            function ($query) use($tab) {
                switch ($tab) {
                    case 'untreated':
                        $query->whereIn('status', [1, -1]);
                        break;
                    case 'talking':
                        $query->where('status', '=', 2);
                        break;
                    case 'push_resume':
                        $query->where('status', '=', 3);
                        break;
                    case 'interview':
                        $query->where('status', '=', 4);
                        break;
                    case 'offer':
                        $query->where('status', '=', 5);
                        break;
                    case 'onboarding':
                        $query->where('status', '=', 6);
                        break;
                    case 'over_probation':
                        $query->where('status', '=', 7);
                        break;
                    case 'out':
                        $query->where('status', '=', 0);
                        break;

                    default:
                        $query->whereIn('status', [1, -1]);
                        break;
                }
            })
            ->paginate($this->pageSize);

        $count = [
            'untreated' => $job->resumes()->whereIn('status', [1, -1])->count(),
            'talking' => $job->resumes()->where('status', '=', 2)->count(),
            'push_resume' => $job->resumes()->where('status', '=', 3)->count(),
            'interview' => $job->resumes()->where('status', '=', 4)->count(),
            'offer' => $job->resumes()->where('status', '=', 5)->count(),
            'onboarding' => $job->resumes()->where('status', '=', 6)->count(),
            'over_probation' => $job->resumes()->where('status', '=', 7)->count(),
            'out' => $job->resumes()->where('status', '=', 0)->count()
        ];

        $job->increment('pv');

        return view('jobs.show')
            ->with('job', $job)
            ->with('resumes', $resumes)
            ->with('count', $count)
            ->with('tab', $tab);
    }

    public function edit(Job $job)
    {
        return view('jobs.edit', compact('job'));
    }

    public function update(Job $job, Request $request)
    {
        $mssages = [
            'company.required' => '请填写 公司名称',
            'quota.numeric' => '请正确输入 招聘人数',
            'name.required' => '请填写 职位名称',
            'type.st.required' => '请选择 职位类别',
            'type.nd.required' => '请选择 职位类别',
            'type.rd.required' => '请选择 职位类别',
            'nature.required' => '请选择 工作性质',
            'location.province.required' => '请选择 工作城市',
            'location.city.required' => '请选择 工作城市',
            'location.district.required' => '请选择 工作城市',
            'salary_min.required' => '请填写 税前月薪',
            'salary_min.numeric' => '请正确填写 税前月薪',
            'salary_max.required' => '请填写 税前月薪',
            'salary_max.numeric' => '请正确填写 税前月薪',
            'welfare.required' => '请选择 福利待遇',
            'age_min.required' => '请选择 年龄范围',
            'age_min.numeric' => '请选择 年龄范围',
            'age_max.required' => '请选择 年龄范围',
            'age_max.numeric' => '请选择 年龄范围',
            'education.required' => '请填写 学历要求',
            'experience.required' => '请填写 经验要求',
            'duty.required' => '请填写 工作职责',
            'requirement.required' => '请填写 任职要求',
            'urgency_level.required' => '请选择 紧急程度',
            'channel.required' => '请选择 渠道',
            'deadline.required' => '请填写 截止日期',
        ];

        $this->validate($request, [
            'company' => ['required', 'string'],
            'quota' => 'nullable|numeric',
            'name' => 'required|string',
            'type' => 'required',
            'nature' => 'required|in:' . implode(",", array_keys(Job::natureArr)),
            'location' => 'required',
            'salary_min' => 'required|numeric',
            'salary_max' => 'required|numeric',
            'welfare' => 'required|in:' . implode(",", array_keys(Job::welfareArr)),
            'sparkle' => 'nullable|string',
            'age_min' => 'required|numeric',
            'age_max' => 'required|numeric',
            'education' => 'required|in:' . implode(",", array_keys(Job::educationArr)),
            'experience' => 'required|in:' . implode(",", array_keys(Job::experienceArr)),
            'duty' => 'required|string',
            'requirement' => 'required|string',
            'urgency_level' => 'required|in:' . implode(",", array_keys(Job::urgencyLevelArr)),
            'channel' => 'required',
            'channel_remark' => 'nullable|string',
            'deadline' => 'required|date'
        ], $mssages);

        $data = $request->toArray();
        $data['type'] = json_encode($data['type']);
        $data['location'] = json_encode($data['location']);
        $data['channel'] = json_encode(array_keys($data['channel']));
        $job->update($data);

        return redirect()->route('jobs.list');
    }

    public function status(Job $job, Request $request)
    {
        if ($request->has('status')) {
            $job->status = $request->status;
            $job->save();
        }
        return redirect()->route('jobs.list');
    }

    public function exportedResume(Request $request)
    {
        $resumes = Resume::
            addSelect('name as 姓名')
            ->addSelect('status as 运作状态')
            ->addSelect('sex as 性别')
            ->addSelect('age as 年龄')
            ->addSelect('city as 工作年限')
            ->addSelect('education as 教育程度')
            ->addSelect('cur_company as 目前公司')
            ->addSelect('cur_position as 目前职位')
            ->addSelect('cur_salary as 目前月薪')
            ->addSelect('created_at as 投递时间')
            ->where('job_id', '=', $request->job_id)
            ->get();

        $header = [];
        $list = [];
        foreach ($resumes as $key => $value) {
            if ($key === 0) {
                $header = array_keys($value->toArray());
            }
            $list[] = array_values($value->toArray());
        }
        $name = $request->job_name . '-' .  $request->job_company . '-' . $request->created_at;

        $this->exported($name, $header, $list);
    }

    public function destroy(Job $job)
    {
        $job->delete();
        session()->flash('success', '删除成功');
        return redirect()->route('jobs.list');
    }

    private function exported(String $fileName, Array $header, Array $list)
    {
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=".$fileName.".csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        $output = fopen("php://output", "w");
        $converter = function($value) {
            return iconv('utf-8', 'gbk', $value);
        };
        $header = array_map($converter, $header);

        fputcsv($output, $header);
        $count = count($header);
        foreach($list as $k => $v) {
            $csvrow = array_map($converter, $v);
            fputcsv($output, $csvrow);
        }
        fclose($output);
    }
}
