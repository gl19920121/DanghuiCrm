<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Job;
use Auth;
use DateTime;

class ManagementController extends Controller
{
    private $pageSize;

    public function __construct()
    {
        $this->middleware('auth', [
            'except' => []
        ]);

        $this->pageSize = config('public.page_size');
    }

    public function jobList(Request $request)
    {
        $appends = [
            'tab' => $request->query('tab', 'job_doing'),
            'job_name' => $request->query('job_name', ''),
            'job_channel' => $request->query('job_channel', ''),
        ];

        $udis = Auth::user()->branch;
        $jobs = Job::status($appends['tab'])->branch($udis)->searchByName($appends['job_name'])->searchByChannel($appends['job_channel'])->paginate($this->pageSize);
        $statistics = $statistics = [
            'staff' => count($udis),
            'job_doing' => Job::status(1)->branch($udis)->count(),
            'job_need_check' => Job::status(-1)->branch($udis)->count(),
            'resume_need_check' => 0
        ];

        $list = $jobs;
        return view('management.job.list', compact('statistics', 'appends', 'list'));
    }

    public function staffList(Request $request)
    {
        $tab = $request->query('tab', 'job');
        $appends = [
            'tab' => $tab,
            'start_at' => $request->query('start_at', ''),
            'end_at' => $request->query('end_at', ''),
            'is_not_end' => $request->query('is_not_end', '')
        ];

        $udis = Auth::user()->branch;
        if ($tab === 'job') {
            $list = User::branch($udis)->withCount([
                'executeJobs as jobs_count' => function ($query) use ($request) {
                    if ($request->filled('start_at')) {
                        $query->where('created_at', '>=', $request->start_at);
                    }
                    if ($request->filled('is_not_end') && $request->is_not_end) {
                        $query->where('created_at', '<=', new DateTime());
                    } elseif ($request->filled('end_at')) {
                        $query->where('created_at', '<=', $request->end_at);
                    }
                },
                'executeJobResumes as resumes_count' => function ($query) use ($request) {
                    if ($request->filled('start_at')) {
                        $query->where('jobs.created_at', '>=', $request->start_at);
                    }
                    if ($request->filled('is_not_end') && $request->is_not_end) {
                        $query->where('jobs.created_at', '<=', new DateTime());
                    } elseif ($request->filled('end_at')) {
                        $query->where('jobs.created_at', '<=', $request->end_at);
                    }
                },
                'executeJobResumes as talking_resumes_count' => function ($query) use ($request) {
                    $query->where('resumes.status', 2);
                    if ($request->filled('start_at')) {
                        $query->where('jobs.created_at', '>=', $request->start_at);
                    }
                    if ($request->filled('is_not_end') && $request->is_not_end) {
                        $query->where('jobs.created_at', '<=', new DateTime());
                    } elseif ($request->filled('end_at')) {
                        $query->where('jobs.created_at', '<=', $request->end_at);
                    }
                },
                'executeJobResumes as push_resume_resumes_count' => function ($query) use ($request) {
                    $query->where('resumes.status', 3);
                    if ($request->filled('start_at')) {
                        $query->where('jobs.created_at', '>=', $request->start_at);
                    }
                    if ($request->filled('is_not_end') && $request->is_not_end) {
                        $query->where('jobs.created_at', '<=', new DateTime());
                    } elseif ($request->filled('end_at')) {
                        $query->where('jobs.created_at', '<=', $request->end_at);
                    }
                },
                'executeJobResumes as interview_resumes_count' => function ($query) use ($request) {
                    $query->where('resumes.status', 4);
                    if ($request->filled('start_at')) {
                        $query->where('jobs.created_at', '>=', $request->start_at);
                    }
                    if ($request->filled('is_not_end') && $request->is_not_end) {
                        $query->where('jobs.created_at', '<=', new DateTime());
                    } elseif ($request->filled('end_at')) {
                        $query->where('jobs.created_at', '<=', $request->end_at);
                    }
                },
                'executeJobResumes as offer_resumes_count' => function ($query) use ($request) {
                    $query->where('resumes.status', 5);
                    if ($request->filled('start_at')) {
                        $query->where('jobs.created_at', '>=', $request->start_at);
                    }
                    if ($request->filled('is_not_end') && $request->is_not_end) {
                        $query->where('jobs.created_at', '<=', new DateTime());
                    } elseif ($request->filled('end_at')) {
                        $query->where('jobs.created_at', '<=', $request->end_at);
                    }
                },
                'executeJobResumes as onboarding_resumes_count' => function ($query) use ($request) {
                    $query->where('resumes.status', 6);
                    if ($request->filled('start_at')) {
                        $query->where('jobs.created_at', '>=', $request->start_at);
                    }
                    if ($request->filled('is_not_end') && $request->is_not_end) {
                        $query->where('jobs.created_at', '<=', new DateTime());
                    } elseif ($request->filled('end_at')) {
                        $query->where('jobs.created_at', '<=', $request->end_at);
                    }
                },
                'executeJobResumes as over_probation_resumes_count' => function ($query) use ($request) {
                    $query->where('resumes.status', 7);
                    if ($request->filled('start_at')) {
                        $query->where('jobs.created_at', '>=', $request->start_at);
                    }
                    if ($request->filled('is_not_end') && $request->is_not_end) {
                        $query->where('jobs.created_at', '<=', new DateTime());
                    } elseif ($request->filled('end_at')) {
                        $query->where('jobs.created_at', '<=', $request->end_at);
                    }
                },
                'executeJobResumes as out_resumes_count' => function ($query) use ($request) {
                    $query->where('resumes.status', 0);
                    if ($request->filled('start_at')) {
                        $query->where('jobs.created_at', '>=', $request->start_at);
                    }
                    if ($request->filled('is_not_end') && $request->is_not_end) {
                        $query->where('jobs.created_at', '<=', new DateTime());
                    } elseif ($request->filled('end_at')) {
                        $query->where('jobs.created_at', '<=', $request->end_at);
                    }
                }
            ])->paginate($this->pageSize);

        } elseif ($tab === 'resume') {
            $list = User::branch($udis)->withCount([
                'seenResumes'  => function ($query) use ($request) {
                    if ($request->filled('start_at')) {
                        $query->where('resume_user.created_at', '>=', $request->start_at);
                    }
                    if ($request->filled('is_not_end') && $request->is_not_end) {
                        $query->where('resume_user.created_at', '<=', new DateTime());
                    } elseif ($request->filled('end_at')) {
                        $query->where('resume_user.created_at', '<=', $request->end_at);
                    }
                },
                'uploadResumes'  => function ($query) use ($request) {
                    if ($request->filled('start_at')) {
                        $query->where('created_at', '>=', $request->start_at);
                    }
                    if ($request->filled('is_not_end') && $request->is_not_end) {
                        $query->where('created_at', '<=', new DateTime());
                    } elseif ($request->filled('end_at')) {
                        $query->where('created_at', '<=', $request->end_at);
                    }
                },
                'downloadResumes'  => function ($query) use ($request) {
                    if ($request->filled('start_at')) {
                        $query->where('resume_user.created_at', '>=', $request->start_at);
                    }
                    if ($request->filled('is_not_end') && $request->is_not_end) {
                        $query->where('resume_user.created_at', '<=', new DateTime());
                    } elseif ($request->filled('end_at')) {
                        $query->where('resume_user.created_at', '<=', $request->end_at);
                    }
                }
            ])
            ->paginate($this->pageSize);
        }

        return view('management.staff.list', compact('appends', 'list'));
    }
}
