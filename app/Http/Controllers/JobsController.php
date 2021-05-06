<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Resume;
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
        'applets' => ['name' => 'channel1', 'show' => '小程序', 'selected' => true, 'default' => false],
        'website' => ['name' => 'channel2', 'show' => '官网', 'selected' => true, 'default' => false],
        'other_platform' => ['name' => 'channel3', 'show' => '其他', 'selected' => false, 'default' => false]
    ];
    private $pageSize = 10;

    public function __construct()
    {
        $this->middleware('auth', [
            'except' => []
        ]);
    }

    public function create()
    {
        return view('jobs.create')
            ->with('natureArr', $this->natureArr)
            ->with('welfareArr', $this->welfareArr)
            ->with('educationArr', $this->educationArr)
            ->with('experienceArr', $this->experienceArr)
            ->with('urgencyLevelArr', $this->urgencyLevelArr)
            ->with('channelArr', $this->channelArr);
    }

    public function store(Request $request)
    {
        // return $request->toArray();
        $this->validate($request, [
            'company' => ['required', 'string'],
            'quota' => 'nullable|numeric',
            'name' => 'required|string',
            'type' => 'required|string',
            'nature' => 'required|in:' . implode(",", array_keys($this->natureArr)),
            'city' => 'required|string',
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
        ]);

        $data = $request->toArray();
        $data['release_uid'] = Auth::user()->id;
        if (isset($request->execute_uid)) {
            $data['execute_uid'] = $request->execute_uid;
        } else {
            $data['execute_uid'] = Auth::user()->id;
        }
        $data['channel'] = json_encode(array_keys($data['channel']));
        $job = Job::create($data);

        session()->flash('success', '发布成功');
        return redirect()->route('jobs.list');
    }

    public function list(Request $request)
    {
        // return $request->toArray();
        $jobs = Job::
            where(function ($query) use($request) {
                if ($request->has('tab')) {
                    $tab = $request->tab;
                } else {
                    $tab = 'ing';
                }
                switch ($request->tab) {
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
                    $query->where('name', 'like', $request->name);
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

        return view('jobs.list')
            ->with('jobs', $jobs)
            ->with('tab', $request->tab)
            ->with('name', $request->name)
            ->with('urgencyLevelArr', $urgencyLevelArr)
            ->with('channelArr', $channelArr);
    }

    public function show(Job $job, Request $request)
    {
        $resumes = Resume::where('job_id', '=', $job->id)->paginate($this->pageSize);
        $tab = isset($request->tab) ? $request->tab : '';
        return view('jobs.show', compact('job', 'resumes', 'tab'));
    }

    public function update(Job $job, Request $request)
    {
        // $job->save();
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
