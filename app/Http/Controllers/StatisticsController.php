<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Resume;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    private $pageSize;

    public function __construct()
    {
        $this->middleware('auth', [
            'except' => []
        ]);

        $this->pageSize = config('public.page_size');
    }

    public function list(Request $request)
    {
        $users = User::paginate($this->pageSize);
        $resumes = Resume::get();

        $statistics = [
            'all' => $resumes->count(),
            'new_week' => $resumes->where('created_at', '>=', Carbon::now()->startOfWeek())->count(),
            'new_month' => $resumes->where('created_at', '>=', Carbon::now()->startOfMonth())->count()
        ];

        return view('statistics.list', compact('statistics', 'users'));
    }
}
