<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Resume;
use App\Models\Draft;
use App\Models\JobType;
use Auth;

class JobsController extends Controller
{
    private $natureArr = ['full' => '全职', 'part' => '兼职', 'all' => '全职/兼职'];
    private $welfareArr = ['social_insurance' => '社会保险', 'five_social_insurance_and_one_housing_fund' => '五险一金', 'four_social_insurance_and_one_housing_fund' => '四险一金'];
    private $educationArr = ['unlimited' => '不限', 'high_schoo' => '高中', 'junior' => '专科', 'undergraduate' => '本科', 'master' => '硕士', 'doctor' => '博士'];
    private $experienceArr = ['unlimited' => '经验不限', 'school' => '学生在读', 'fresh_graduates' => '应届毕业生', 'primary' => '1-3', 'middle' => '3-5', 'high' => '5-10', 'expert' => '10年以上'];
    private $urgencyLevelArr = [
        '0' => ['show' => '标准', 'selected' => true, 'default' => false],
        '1' => ['show' => '急聘', 'selected' => false, 'default' => false]
    ];
    private $channelArr = [
        'applets' => ['show' => '小程序', 'selected' => true, 'default' => false],
        'website' => ['show' => '官网', 'selected' => true, 'default' => false],
        'other_platform' => ['show' => '其他', 'selected' => false, 'default' => false]
    ];
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
        }

        return view('jobs.create')
            ->with('draftId', $request->draft_id)
            ->with('oldData', $oldData)
            ->with('natureArr', $this->natureArr)
            ->with('welfareArr', $this->welfareArr)
            ->with('educationArr', $this->educationArr)
            ->with('experienceArr', $this->experienceArr)
            ->with('urgencyLevelArr', $this->urgencyLevelArr)
            ->with('channelArr', $this->channelArr)
            ;
    }

    public function store(Request $request)
    {
        $data = $request->toArray();
        // return $data['location'];
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
            'company' => 'required',
            'quota' => 'nullable|numeric',
            'name' => 'required|string',
            'type.st' => 'required',
            'type.nd' => 'required',
            'type.rd' => 'required',
            'nature' => 'bail|required|in:' . implode(",", array_keys($this->natureArr)),
            'location.province' => 'required',
            'location.city' => 'required',
            'location.district' => 'required',
            'salary_min' => 'required|numeric',
            'salary_max' => 'required|numeric',
            'welfare' => 'required|in:' . implode(",", array_keys($this->welfareArr)),
            'sparkle' => 'nullable|string',
            'age_min' => 'required|numeric',
            'age_max' => 'required|numeric',
            'education' => 'required|in:' . implode(",", array_keys($this->educationArr)),
            'experience' => 'required|in:' . implode(",", array_keys($this->experienceArr)),
            'duty' => 'required|string',
            'requirement' => 'required|string',
            'urgency_level' => 'required|in:' . implode(",", array_keys($this->urgencyLevelArr)),
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
                if (!empty($request->urgency_level)) {
                    $query->where('urgency_level', '=', $request->urgency_level);
                }
                if (!empty($request->channel)) {
                    $query->whereJsonContains('channel', $request->channel);
                }
            });
        $jobs = $jobs->paginate($this->pageSize);

        $urgencyLevelArr = $this->urgencyLevelArr;
        if(isset($urgencyLevelArr[$request->urgency_level])) {
            $urgencyLevelArr[$request->urgency_level]['selected'] = true;
        } else {
            foreach($urgencyLevelArr as $key => $item) {
                $urgencyLevelArr[$key]['selected'] = false;
            }
        }
        $channelArr = $this->channelArr;
        foreach($channelArr as $key => $item) {
            $channelArr[$key]['selected'] = false;
        }
        if(isset($channelArr[$request->channel])) {
            $channelArr[$request->channel]['selected'] = true;
        }

        $appends = [
            'tab' => $tab,
            'name' => $request->name,
            'urgencyLevelArr' => $urgencyLevelArr,
            'channelArr' => $channelArr
        ];

        return view('jobs.list')
            ->with('jobs', $jobs)
            ->with('appends', $appends);
    }

    public function show(Job $job, Request $request)
    {
        $resumes = Resume::where('job_id', '=', $job->id)->paginate($this->pageSize);
        $job->increment('pv');
        $tab = isset($request->tab) ? $request->tab : '';
        return view('jobs.show', compact('job', 'resumes', 'tab'));
    }

    public function edit(Job $job)
    {
        // return var_dump($job->type);
        return view('jobs.edit', compact('job'))
            ->with('natureArr', $this->natureArr)
            ->with('welfareArr', $this->welfareArr)
            ->with('educationArr', $this->educationArr)
            ->with('experienceArr', $this->experienceArr)
            ->with('urgencyLevelArr', $this->urgencyLevelArr)
            ->with('channelArr', $this->channelArr);
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
            'nature' => 'required|in:' . implode(",", array_keys($this->natureArr)),
            'location' => 'required',
            'salary_min' => 'required|numeric',
            'salary_max' => 'required|numeric',
            'welfare' => 'required|in:' . implode(",", array_keys($this->welfareArr)),
            'sparkle' => 'nullable|string',
            'age_min' => 'required|numeric',
            'age_max' => 'required|numeric',
            'education' => 'required|in:' . implode(",", array_keys($this->educationArr)),
            'experience' => 'required|in:' . implode(",", array_keys($this->experienceArr)),
            'duty' => 'required|string',
            'requirement' => 'required|string',
            'urgency_level' => 'required|in:' . implode(",", array_keys($this->urgencyLevelArr)),
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
