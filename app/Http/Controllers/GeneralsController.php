<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Job;
use App\Models\Resume;
use Auth;
use Illuminate\Support\Facades\DB;

class GeneralsController extends Controller
{
    private $pageSize = 1;

    public function __construct()
    {
        $this->middleware('auth', [
            'except' => []
        ]);
    }

    public function show(Request $request)
    {
        // $this->authorize('view', [User::Class, Route::current()]);
        $jobs = Job::where('status', '=', 1)
            ->where('execute_uid', '=', Auth::user()->id)
            ->withCount('resumes')
            ->paginate($this->pageSize, ['*'], 'jpage');
        $newJobs = Job::where('status', '=', 1)
            ->where('execute_uid', '=', Auth::user()->id)
            ->whereHas('resumes', function ($query) {
                $query->where('status', '=', 1);
            })
            ->withCount('resumes')
            ->paginate($this->pageSize, ['*'], 'njpage');
        $newResumes = Resume::where('status', '=', 1)
            ->whereHas('job', function ($query) {
                $query->where('status', '=', 1);
                $query->where('execute_uid', '=', Auth::user()->id);
            })
            ->with(['job' => function($query) {
                $query->select('id', 'name');
            }])
            ->paginate($this->pageSize, ['*'], 'nrpage');

        // return dd($newResumes->toArray()['data']);

        $list = [
            'jobs' => $jobs,
            'newJobs' => $newJobs,
            'newResumes' => $newResumes
        ];

        $statistics = [
            'message' => 0,
            'resume_check' => 0,
            'resume_download' => 0,
            'resume_upload' => 0,
            'job_doing' => $jobs->total(),
            'job_apply' => $newJobs->total(),
            'job_commission' => $newResumes->total(),
            'schedule_talking' => Resume::where('status', '=', 2)->count(),
            'schedule_push_resume' => Resume::where('status', '=', 3)->count(),
            'schedule_interview' => Resume::where('status', '=', 4)->count(),
            'schedule_offer' => Resume::where('status', '=', 5)->count(),
            'schedule_onboarding' => Resume::where('status', '=', 6)->count(),
            'schedule_over_probation' => Resume::where('status', '=', 7)->count()
        ];

        return view('home')->with('statistics', $statistics)
            ->with('tab', empty($request->tab) ? 'jobs' : $request->tab)
            ->with('list', $list);
    }
}
