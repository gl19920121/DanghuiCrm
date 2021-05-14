<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Job;
use App\Models\Resume;
use Auth;

class GeneralsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => []
        ]);
    }

    public function show()
    {
        // $this->authorize('view', [User::Class, Route::current()]);
        $jobDoing = Job::where('execute_uid', '=', Auth::user()->id)->count();
        $jobApply = Resume::count();
        $statistics = [
            'message' => 0,
            'resume_check' => 0,
            'resume_download' => 0,
            'resume_upload' => 0,
            'job_doing' => $jobDoing,
            'job_apply' => $jobApply,
            'job_commission' => 0,
            'schedule_talking' => 0,
            'schedule_push_resume' => 0,
            'schedule_interview' => 0,
            'schedule_offer' => 0,
            'schedule_onboarding' => 0,
            'schedule_over_probation' => 0
        ];
        return view('home')->with('statistics', json_decode(json_encode($statistics)));
    }
}
