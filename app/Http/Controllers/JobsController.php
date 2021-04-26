<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Models\Job;

class JobsController extends Controller
{
    private $natureArr = ['full', 'part', 'all'];
    private $welfareArr = ['social_insurance', 'five_social_insurance_and_one_housing_fund', 'four_social_insurance_and_one_housing_fund'];
    private $educationArr = ['unlimited', 'high_schoo', 'junior', 'undergraduate', 'master', 'doctor'];
    private $experienceArr = ['unlimited', 'school', 'fresh_graduates', 'primary', 'middle', 'high', 'expert'];
    private $channelArr = ['applets', 'website', 'other_platform'];

    public function create()
    {
        return view('jobs.create');
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
