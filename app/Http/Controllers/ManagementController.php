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
        $appends = [
            'tab' => $request->query('tab', 'job_doing'),
            'job_name' => $request->query('job_name', ''),
            'job_channel' => $request->query('job_channel', ''),
        ];

        $roles = Auth::user()->roles->pluck('id');
        $subRoles = Role::whereIn('parent_id', $roles)->get();
        $udis = [];
        foreach ($subRoles as $role) {
            $udis = array_merge($udis, $role->users->pluck('id')->toArray());
        }

        $jobs = Job::status($appends['tab'])->searchByName($appends['job_name'])->searchByChannel($appends['job_channel'])->branch($udis)->paginate($this->pageSize);
        $statistics = $this->getStatistics($udis);

        $list = $jobs;
        return view('management.job.list', compact('statistics', 'appends', 'list'));
    }

    public function staffList(Request $request)
    {
        return view('management.staff.list');
    }

    public function resumeList(Request $request)
    {
        $appends = [
            'tab' => $request->query('tab', 'job_doing'),
            'job_name' => $request->query('job_name', ''),
            'job_channel' => $request->query('job_channel', ''),
        ];

        $roles = Auth::user()->roles->pluck('id');
        $subRoles = Role::whereIn('parent_id', $roles)->get();
        $udis = [];
        foreach ($subRoles as $role) {
            $udis = array_merge($udis, $role->users->pluck('id')->toArray());
        }

        $statistics = $this->getStatistics($udis);

        return view('management.job.list', compact('statistics', 'appends'));
    }

    private function getStatistics($udis)
    {
        $statistics = [
            'staff' => count($udis),
            'job_doing' => Job::status(1)->branch($udis)->count(),
            'job_need_check' => Job::status(-1)->branch($udis)->count(),
            'resume_need_check' => 0
        ];

        return $statistics;
    }
}
