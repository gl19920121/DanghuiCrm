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
use App\Models\Company;
use App\Tools\Statistic;
use Auth;
use DateTime;
use Carbon\Carbon;

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
        // dd($request->all());
        $tab = $request->query('tab', 'user');
        $appends = [
            'tab' => $tab,
            'start_at' => $request->query('start_at', ''),
            'end_at' => $request->query('end_at', ''),
            'is_not_end' => $request->query('is_not_end', '')
        ];
        if (!empty($appends['start_at'])) {
            $request->start_at = Carbon::parse($appends['start_at'])->toDateTimeString();
        }
        if (!empty($appends['end_at'])) {
            $request->end_at = Carbon::parse($appends['end_at'])->addHours(23)->addMinutes(59)->addSecond(59)->toDateTimeString();
        }

        $items = collect();
        $self = null;
        $users = collect();
        $departments = Auth::user()->department;

        if (in_array(Auth::user()->id, [11, 12])) {
            $departments = Department::query()->whereIn('id', [5, 6, 7])->get();
        }

        foreach ($departments as $department) {
            if (!Auth::user()->isDepartmentAdmin($department->no)) {
                continue;
            }

            $usersid = $department->users->pluck('id')->toArray();

            if ($tab === 'job') {
                $query = Job::whereIn('execute_uid', $usersid);
                $tool = new Statistic('job', $request->start_at, $request->end_at);
                $tool->queryJobStatistic($query);
                $statistics = $query->get();

                $items = $statistics;
            } else if ($tab === 'company') {
                $jobs = Job::whereIn('execute_uid', $usersid)->get();
                $companysid = $jobs->pluck('company_id')->toArray();
                $jobsid = $jobs->pluck('id')->toArray();
                $query = Company::whereIn('id', $companysid);
                $tool = new Statistic('company', $request->start_at, $request->end_at);
                $tool->queryJobStatistic($query, $jobsid);
                $statistics = $query->get();

                $items = $statistics;
            } else if ($tab === 'user') {
                $query = User::whereIn('id', $usersid);
                $tool = new Statistic('user', $request->start_at, $request->end_at);
                $tool->queryJobStatistic($query);
                $statistics = $query->get();

                foreach ($statistics as $statistic) {
                    if ($users->contains($statistic)) {
                        continue;
                    }

                    $statistic->type = 'user';
                    if ($statistic->id === Auth::user()->id) {
                        $self = $statistic;
                    } else {
                        $users->push($statistic);
                    }
                }

                $item = $department;
                $item->type = 'department';
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

    public function userStaffList(Request $request, User $user)
    {
        $item = $user;
        $tab = $request->query('tab', 'doing');
        $appends = [
            'tab' => $tab,
            'start_at' => $request->query('start_at', ''),
            'end_at' => $request->query('end_at', ''),
            'is_not_end' => $request->query('is_not_end', '')
        ];
        if (!empty($appends['start_at'])) {
            $request->start_at = Carbon::parse($appends['start_at'])->toDateTimeString();
        }
        if (!empty($appends['end_at'])) {
            $request->end_at = Carbon::parse($appends['end_at'])->addHours(23)->addMinutes(59)->addSecond(59)->toDateTimeString();
        }

        if ($tab === 'doing') {
            $list = Job::where('execute_uid', $user->id)->active()->withCount([
                'operation as resumes_count' => function ($query) use ($request) {
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
                'operation as talking_resumes_count' => function ($query) use ($request) {
                    $query->where('status', 2);
                    if ($request->filled('start_at')) {
                        $query->where('created_at', '>=', $request->start_at);
                    }
                    if ($request->filled('is_not_end') && $request->is_not_end) {
                        $query->where('created_at', '<=', new DateTime());
                    } elseif ($request->filled('end_at')) {
                        $query->where('created_at', '<=', $request->end_at);
                    }
                },
                'operation as push_resume_resumes_count' => function ($query) use ($request) {
                    $query->where('status', 3);
                    if ($request->filled('start_at')) {
                        $query->where('created_at', '>=', $request->start_at);
                    }
                    if ($request->filled('is_not_end') && $request->is_not_end) {
                        $query->where('created_at', '<=', new DateTime());
                    } elseif ($request->filled('end_at')) {
                        $query->where('created_at', '<=', $request->end_at);
                    }
                },
                'operation as interview_resumes_count' => function ($query) use ($request) {
                    $query->where('status', 4);
                    if ($request->filled('start_at')) {
                        $query->where('created_at', '>=', $request->start_at);
                    }
                    if ($request->filled('is_not_end') && $request->is_not_end) {
                        $query->where('created_at', '<=', new DateTime());
                    } elseif ($request->filled('end_at')) {
                        $query->where('created_at', '<=', $request->end_at);
                    }
                },
                'operation as offer_resumes_count' => function ($query) use ($request) {
                    $query->where('status', 5);
                    if ($request->filled('start_at')) {
                        $query->where('created_at', '>=', $request->start_at);
                    }
                    if ($request->filled('is_not_end') && $request->is_not_end) {
                        $query->where('created_at', '<=', new DateTime());
                    } elseif ($request->filled('end_at')) {
                        $query->where('created_at', '<=', $request->end_at);
                    }
                },
                'operation as onboarding_resumes_count' => function ($query) use ($request) {
                    $query->where('status', 6);
                    if ($request->filled('start_at')) {
                        $query->where('created_at', '>=', $request->start_at);
                    }
                    if ($request->filled('is_not_end') && $request->is_not_end) {
                        $query->where('created_at', '<=', new DateTime());
                    } elseif ($request->filled('end_at')) {
                        $query->where('created_at', '<=', $request->end_at);
                    }
                },
                'operation as over_probation_resumes_count' => function ($query) use ($request) {
                    $query->where('status', 7);
                    if ($request->filled('start_at')) {
                        $query->where('created_at', '>=', $request->start_at);
                    }
                    if ($request->filled('is_not_end') && $request->is_not_end) {
                        $query->where('created_at', '<=', new DateTime());
                    } elseif ($request->filled('end_at')) {
                        $query->where('created_at', '<=', $request->end_at);
                    }
                },
                'operation as out_resumes_count' => function ($query) use ($request) {
                    $query->where('status', 0);
                    if ($request->filled('start_at')) {
                        $query->where('created_at', '>=', $request->start_at);
                    }
                    if ($request->filled('is_not_end') && $request->is_not_end) {
                        $query->where('created_at', '<=', new DateTime());
                    } elseif ($request->filled('end_at')) {
                        $query->where('created_at', '<=', $request->end_at);
                    }
                }
            ])->paginate($this->pageSize);
        } else if ($tab === 'checkpending') {
            $list = Job::where('execute_uid', $user->id)->status('need_check')->paginate($this->pageSize);
        }

        return view('management.staff.user.list', compact('appends', 'list', 'item'));
    }

    public function departmentStaffList(Request $request, Department $department)
    {
        $item = $department;
        $tab = $request->query('tab', 'doing');
        $appends = [
            'tab' => $tab,
            'start_at' => $request->query('start_at', ''),
            'end_at' => $request->query('end_at', ''),
            'is_not_end' => $request->query('is_not_end', '')
        ];
        if (!empty($appends['start_at'])) {
            $request->start_at = Carbon::parse($appends['start_at'])->toDateTimeString();
        }
        if (!empty($appends['end_at'])) {
            $request->end_at = Carbon::parse($appends['end_at'])->addHours(23)->addMinutes(59)->addSecond(59)->toDateTimeString();
        }

        if ($tab === 'doing') {
            $list = Job::whereIn('execute_uid', $department->users->pluck('id'))->active()->withCount([
                'operation as resumes_count' => function ($query) use ($request) {
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
                'operation as talking_resumes_count' => function ($query) use ($request) {
                    $query->where('status', 2);
                    if ($request->filled('start_at')) {
                        $query->where('created_at', '>=', $request->start_at);
                    }
                    if ($request->filled('is_not_end') && $request->is_not_end) {
                        $query->where('created_at', '<=', new DateTime());
                    } elseif ($request->filled('end_at')) {
                        $query->where('created_at', '<=', $request->end_at);
                    }
                },
                'operation as push_resume_resumes_count' => function ($query) use ($request) {
                    $query->where('status', 3);
                    if ($request->filled('start_at')) {
                        $query->where('created_at', '>=', $request->start_at);
                    }
                    if ($request->filled('is_not_end') && $request->is_not_end) {
                        $query->where('created_at', '<=', new DateTime());
                    } elseif ($request->filled('end_at')) {
                        $query->where('created_at', '<=', $request->end_at);
                    }
                },
                'operation as interview_resumes_count' => function ($query) use ($request) {
                    $query->where('status', 4);
                    if ($request->filled('start_at')) {
                        $query->where('created_at', '>=', $request->start_at);
                    }
                    if ($request->filled('is_not_end') && $request->is_not_end) {
                        $query->where('created_at', '<=', new DateTime());
                    } elseif ($request->filled('end_at')) {
                        $query->where('created_at', '<=', $request->end_at);
                    }
                },
                'operation as offer_resumes_count' => function ($query) use ($request) {
                    $query->where('status', 5);
                    if ($request->filled('start_at')) {
                        $query->where('created_at', '>=', $request->start_at);
                    }
                    if ($request->filled('is_not_end') && $request->is_not_end) {
                        $query->where('created_at', '<=', new DateTime());
                    } elseif ($request->filled('end_at')) {
                        $query->where('created_at', '<=', $request->end_at);
                    }
                },
                'operation as onboarding_resumes_count' => function ($query) use ($request) {
                    $query->where('status', 6);
                    if ($request->filled('start_at')) {
                        $query->where('created_at', '>=', $request->start_at);
                    }
                    if ($request->filled('is_not_end') && $request->is_not_end) {
                        $query->where('created_at', '<=', new DateTime());
                    } elseif ($request->filled('end_at')) {
                        $query->where('created_at', '<=', $request->end_at);
                    }
                },
                'operation as over_probation_resumes_count' => function ($query) use ($request) {
                    $query->where('status', 7);
                    if ($request->filled('start_at')) {
                        $query->where('created_at', '>=', $request->start_at);
                    }
                    if ($request->filled('is_not_end') && $request->is_not_end) {
                        $query->where('created_at', '<=', new DateTime());
                    } elseif ($request->filled('end_at')) {
                        $query->where('created_at', '<=', $request->end_at);
                    }
                },
                'operation as out_resumes_count' => function ($query) use ($request) {
                    $query->where('status', 0);
                    if ($request->filled('start_at')) {
                        $query->where('created_at', '>=', $request->start_at);
                    }
                    if ($request->filled('is_not_end') && $request->is_not_end) {
                        $query->where('created_at', '<=', new DateTime());
                    } elseif ($request->filled('end_at')) {
                        $query->where('created_at', '<=', $request->end_at);
                    }
                }
            ])->paginate($this->pageSize);
        } else if ($tab === 'checkpending') {
            $list = Job::whereIn('execute_uid', $department->users->pluck('id'))->status('need_check')->paginate($this->pageSize);
        }

        return view('management.staff.user.list', compact('appends', 'list', 'item'));
    }
}
