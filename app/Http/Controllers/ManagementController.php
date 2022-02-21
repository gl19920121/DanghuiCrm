<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use App\Models\User;
use App\Models\Role;
use App\Models\Job;
use App\Models\Department;
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

        $jobs = Job::status($appends['tab'])->children()->searchByName($appends['job_name'])->searchByChannel($appends['job_channel'])->paginate($this->pageSize);
        $statistics = $statistics = [
            'staff' => Auth::user()->children->count(),
            'job_doing' => Job::status(1)->children()->count(),
            'job_need_check' => Job::status(-1)->children()->count(),
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

        $items = collect();
        $self = null;
        $users = collect();
        $departments = Auth::user()->department;

        if (in_array(Auth::user()->id, [11, 12])) {
            $departments = Department::query()->whereIn('id', [5, 6, 7])->get();
        }

        foreach ($departments as $department) {
            if (Auth::user()->isDepartmentAdmin($department)) {

                $usersid = $department->users->where('status', 1)->pluck('id')->toArray();

                if ($tab === 'job') {
                    $statistics = User::whereIn('id', $usersid)->withCount([
                        'executeJobs as jobs_count' => function ($query) use ($request) {
                            $query->where('status', 1);
                            if ($request->filled('start_at')) {
                                $query->where('created_at', '>=', $request->start_at);
                            }
                            if ($request->filled('is_not_end') && $request->is_not_end) {
                                $query->where('created_at', '<=', new DateTime());
                            } elseif ($request->filled('end_at')) {
                                $query->where('created_at', '<=', $request->end_at);
                            }
                        },
                        'executeJobs as checkpending_jobs_count' => function ($query) use ($request) {
                            $query->where('status', -1);
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
                    ])->get();

                    foreach ($statistics as $statistic) {
                        if ($users->contains($statistic)) {
                            continue;
                        }

                        if ($statistic->id === Auth::user()->id) {
                            $self = $statistic;
                        } else {
                            $users->push($statistic);
                        }
                    }

                    $item = $department;
                    $item->jobs_count = $statistics->sum('jobs_count');
                    $item->checkpending_jobs_count = $statistics->sum('checkpending_jobs_count');
                    $item->resumes_count = $statistics->sum('resumes_count');
                    $item->talking_resumes_count = $statistics->sum('talking_resumes_count');
                    $item->push_resume_resumes_count = $statistics->sum('push_resume_resumes_count');
                    $item->interview_resumes_count = $statistics->sum('interview_resumes_count');
                    $item->offer_resumes_count = $statistics->sum('offer_resumes_count');
                    $item->onboarding_resumes_count = $statistics->sum('onboarding_resumes_count');
                    $item->over_probation_resumes_count = $statistics->sum('over_probation_resumes_count');
                    $item->out_resumes_count = $statistics->sum('out_resumes_count');

                    $items->push($item);
                } elseif ($tab === 'resume') {
                    $statistics = User::whereIn('id', $usersid)->withCount([
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
                    ])->get();

                    foreach ($statistics as $statistic) {
                        if ($users->contains($statistic)) {
                            continue;
                        }

                        if ($statistic->id === Auth::user()->id) {
                            $self = $statistic;
                        } else {
                            $users->push($statistic);
                        }
                    }

                    $item = $department;
                    $item->seen_resumes_count = $statistics->sum('seen_resumes');
                    $item->upload_resumes_count = $statistics->sum('upload_resumes');
                    $item->download_resumes_count = $statistics->sum('download_resumes');

                    $items->push($item);
                }
            }
        }

        if (!empty($self)) {
            $items->prepend($self);
        }
        if (!empty($users)) {
            $items = $items->merge($users);
        }

        $perPage = $this->pageSize;
        $curPage = $request->input('page', 1);
        $item = $items->slice(($curPage - 1) * $perPage, $perPage);
        $total = $items->count();
        $list = new LengthAwarePaginator($item, $total, $perPage, $curPage, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);

        return view('management.staff.list', compact('appends', 'list'));
    }
}
