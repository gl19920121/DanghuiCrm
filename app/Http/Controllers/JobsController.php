<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Models\Job;

class JobsController extends Controller
{
    private $natureArr = ['full' => '全职', 'part' => '兼职', 'all' => '全职/兼职'];
    private $welfareArr = ['social_insurance' => '社会保险', 'five_social_insurance_and_one_housing_fund' => '五险一金', 'four_social_insurance_and_one_housing_fund' => '四险一金'];
    private $educationArr = ['unlimited' => '不限', 'high_schoo' => '高中', 'junior' => '专科', 'undergraduate' => '本科', 'master' => '硕士', 'doctor' => '博士'];
    private $experienceArr = ['unlimited' => '经验不限', 'school' => '学生在读', 'fresh_graduates' => '应届毕业生', 'primary' => '1-3', 'middle' => '3-5', 'high' => '5-10', 'expert' => '10年以上'];
    private $channelArr = ['applets', 'website', 'other_platform'];

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
            ->with('experienceArr', $this->experienceArr);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'company' => 'required|string',
            'quota' => 'nullable|numeric',
            'name' => 'required|string',
            'type' => 'required|string',
            'nature' => 'required|string|in_array:' . self::natureArr,
            'city' => 'required|string',
            'salary_min' => 'required|numeric',
            'salary_max' => 'required|numeric',
            'welfare' => 'required|string|in_array:' . self::welfareArr,
            'sparkle' => 'nullable|string',
            'age_min' => 'required|numeric',
            'age_max' => 'required|numeric',
            'education' => 'required|string|in_array:' . self::educationArr,
            'experience' => 'required|string|in_array:' . self::experienceArr,
            'duty' => 'required|string',
            'requirement' => 'required|string',
            'urgency_level' => 'required|numeric',
            'channel' => 'required|string|in_array:' . self::channelArr,
            'channel_remark' => 'nullable|string',
            'deadline' => 'required|date'
        ]);

        $job = Job::create($request->toArray());

        session()->flash('success', '发布成功');
        return redirect()->route('jobs.show', [$job]);
    }

    public function list()
    {
        return view('jobs.list');
    }
}
