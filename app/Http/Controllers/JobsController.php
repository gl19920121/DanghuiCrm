<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\Support\Facades\DB;

class JobsController extends Controller
{
    private $natureArr = ['full' => '全职', 'part' => '兼职', 'all' => '全职/兼职'];
    private $welfareArr = ['social_insurance' => '社会保险', 'five_social_insurance_and_one_housing_fund' => '五险一金', 'four_social_insurance_and_one_housing_fund' => '四险一金'];
    private $educationArr = ['unlimited' => '不限', 'high_schoo' => '高中', 'junior' => '专科', 'undergraduate' => '本科', 'master' => '硕士', 'doctor' => '博士'];
    private $experienceArr = ['unlimited' => '经验不限', 'school' => '学生在读', 'fresh_graduates' => '应届毕业生', 'primary' => '1-3', 'middle' => '3-5', 'high' => '5-10', 'expert' => '10年以上'];
    private $urgencyLevelArr = [
        '0' => ['show' => '标准', 'selected' => false],
        '1' => ['show' => '急聘', 'selected' => false]
    ];
    private $channelArr = [
        'applets' => ['show' => '小程序', 'selected' => false],
        'website' => [ 'show' => '官网', 'selected' => false],
        'other_platform' => ['show' => '其他', 'selected' => false]
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
        //return $request->toArray();
        // $this->validate($request, [
        //     'company' => ['required', 'string'],
        //     'quota' => 'nullable|numeric',
        //     'name' => 'required|string',
        //     'type' => 'required|string',
        //     'nature' => 'required|string|in:' . implode(",", array_keys($this->natureArr)),
        //     'city' => 'required|string',
        //     'salary_min' => 'required|numeric',
        //     'salary_max' => 'required|numeric',
        //     'welfare' => 'required|string|in_array:' . implode(",", array_keys($this->welfareArr)),
        //     'sparkle' => 'nullable|string',
        //     'age_min' => 'required|numeric',
        //     'age_max' => 'required|numeric',
        //     'education' => 'required|string|in_array:' . implode(",", array_keys($this->educationArr)),
        //     'experience' => 'required|string|in_array:' . implode(",", array_keys($this->experienceArr)),
        //     'duty' => 'required|string',
        //     'requirement' => 'required|string',
        //     'urgency_level' => 'required|numeric',
        //     'channel' => 'required|string|in_array:' . implode(",", $this->channelArr),
        //     'channel_remark' => 'nullable|string',
        //     'deadline' => 'required|date'
        // ]);

        $data = $request->toArray();
        $job = Job::create($data);

        session()->flash('success', '发布成功');
        return redirect()->route('jobs.list');
    }

    public function show(Job $job)
    {

    }

    public function list(Request $request)
    {
        $jobs = Job::where(function ($query) {
            // if (!empty($request->name)) {
            //     $query->where('name', 'like', $request->name);
            // }
        });
        $jobs = $jobs->paginate($this->pageSize);

        return view('jobs.list')
            ->with('jobs', $jobs)
            ->with('name', '')
            ->with('urgencyLevelArr', $this->urgencyLevelArr)
            ->with('channelArr', $this->channelArr);
    }

    public function search(Request $request)
    {
        $jobs = Job::where(function ($query) use($request) {
            if (!empty($request->name)) {
                $query->where('name', 'like', $request->name);
            }
            if (!empty($request->urgency_level)) {
                $query->where('urgency_level', '=', $request->urgency_level);
            }
            if (!empty($request->channel)) {
                $query->where('channel', '=', $request->channel);
            }
        });
        $jobs = $jobs->paginate($this->pageSize);

        $urgencyLevelArr = $this->urgencyLevelArr;
        if(isset($urgencyLevelArr[$request->urgency_level])) {
            $urgencyLevelArr[$request->urgency_level]['selected'] = true;
        }
        $channelArr = $this->channelArr;
        if(isset($channelArr[$request->channel])) {
            $channelArr[$request->channel]['selected'] = true;
        }

        return view('jobs.list')
            ->with('jobs', $jobs)
            ->with('name', $request->name)
            ->with('urgencyLevelArr', $urgencyLevelArr)
            ->with('channelArr', $channelArr);
    }
}
