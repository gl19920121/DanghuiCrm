<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Job;
use Auth;

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
        $statistics = $this->getStatistics();
        $appends = [
            'tab' => $request->query('tab', 'job_doing'),
            'job_name' => $request->query('job_name', ''),
            'job_channel' => $request->query('job_channel', ''),
        ];

        $roles = Auth::user()->roles->pluck('id');
        $subRoles = Role::whereIn('parent_id', $roles)->get();
        $subUsers = [];
        foreach ($subRoles as $role) {
            $subUsers = array_merge($subUsers, $role->users->pluck('id')->toArray());
        }

        $jobs = Job::status($appends['tab'])->searchByName($appends['job_name'])->searchByChannel($appends['job_channel'])->whereIn('execute_uid', $subUsers)->paginate($this->pageSize);

        $list = $jobs;
        return view('management.job.list', compact('statistics', 'appends', 'list'));
    }

    public function staffList(Request $request)
    {
        return view('management.staff.list');
    }

    public function resumeList(Request $request)
    {
        $statistics = $this->getStatistics();
        $tab = $request->query('tab', 'job_doing');

        return view('management.job.list', compact('statistics', 'tab'));
    }

    private function getStatistics()
    {
        $statistics = [
            'staff' => 0,
            'job_doing' => 0,
            'job_need_check' => 0,
            'resume_need_check' => 0
        ];

        return $statistics;
    }
}
