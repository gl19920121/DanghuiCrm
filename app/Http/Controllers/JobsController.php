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
        $jobs = Job::where('execute_uid', '=', Auth::user()->id)
            //->orWhere('release_uid', '=', Auth::user()->id)
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
        } else {

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
}
