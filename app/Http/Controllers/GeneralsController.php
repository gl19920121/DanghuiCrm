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
    private $pageSize;

    public function __construct()
    {
        $this->middleware('auth', [
            'except' => []
        ]);

        $this->pageSize = config('public.page_size');
    }

    public function show(Request $request)
    {
        $udis = array_merge(Auth::user()->branch, [Auth::user()->id]);
        $jobs = Job::doing()->branch($udis)
            ->withCount(['resumes' => function ($query) {
                $query->active();
            }])
            ->orderBy('resumes_count', 'desc')
            ->orderBy('updated_at', 'desc')
            ->paginate($this->pageSize, ['*'], 'jpage');
        $newJobs = Job::doing()->branch($udis)
            ->whereHas('resumes', function ($query) {
                $query->new();
            })
            ->withCount(['resumes' => function ($query) {
                $query->new();
            }])
            ->orderBy('resumes_count', 'desc')
            ->orderBy('updated_at', 'desc')
            ->paginate($this->pageSize, ['*'], 'njpage');
        $newResumes = Resume::new()
            ->whereHas('job', function ($query) {
                $query->doing();
                $query->executeUser(Auth::user()->id);
            })
            ->with([
                'job' => function($query) {
                    $query->select('id', 'name');
                },
                'resumeEdus' => function($query) {
                    $query->orderBy('end_at', 'desc');
                },
                'resumeWorks' => function($query) {
                    $query->orderBy('end_at', 'desc');
                }
            ])
            ->orderBy('deliver_at', 'desc')
            ->paginate($this->pageSize, ['*'], 'nrpage');

        $list = [
            'jobs' => $jobs,
            'newJobs' => $newJobs,
            'newResumes' => $newResumes
        ];

        $statistics = [
            'message' => 0,
            'mine' => Resume::active()->has('user')->count(),
            'resume_check' => Auth::user()->seenResumes()->sum('times'),
            'resume_download' => Auth::user()->downloadResumes()->sum('times'),
            'resume_upload' => Auth::user()->uploadResumes()->count(),
            'job_doing' => $jobs->total(),
            'job_apply' => $newJobs->total(),
            'job_commission' => $newResumes->total(),
            'resume' => Auth::user()->executeJobResumes()->count(),
            'schedule_talking' => Resume::Talking()->count(),
            'schedule_push_resume' => Resume::PushResume()->count(),
            'schedule_interview' => Resume::Interview()->count(),
            'schedule_offer' => Resume::Offer()->count(),
            'schedule_onboarding' => Resume::Onboarding()->count(),
            'schedule_over_probation' => Resume::OverProbation()->count(),
            'schedule_out' => Resume::Out()->count()
        ];

        return view('home')->with('statistics', $statistics)
            ->with('tab', empty($request->tab) ? 'jobs' : $request->tab)
            ->with('list', $list);
    }
}
