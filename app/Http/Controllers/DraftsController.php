<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Draft;
use App\Models\Job;
use App\Models\Company;
use Auth;

class DraftsController extends Controller
{
    private $pageSize;

    public function __construct()
    {
        $this->middleware('auth', [
            'except' => []
        ]);

        $this->pageSize = config('public.page_size');
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $data['release_uid'] = Auth::user()->id;
        if ($request->has('execute_uid')) {
            $data['execute_uid'] = $request->execute_uid;
        } else {
            $data['execute_uid'] = Auth::user()->id;
        }
        if ($request->has('company_id')) {
            $data['company'] = Company::find($request->company_id);
        }
        $data['channel'] = array_keys($request->input('channel', []));
        $value = [
            'data' => $data,
            'type' => 'job'
        ];

        $draft = Draft::create($value);

        session()->flash('result', '保存成功，可在“职位管理”-“职位草稿箱”');
        return back();
    }

    public function list(Request $request)
    {
        $tab = $request->input('tab', 'doing');
        $drafts = Draft::where('type', '=', 'job')
            ->where('status', '=', 1)
            ->where('data->execute_uid', Auth::user()->id)
            ->where(function ($query) use($request) {
                if (!empty($request->name)) {
                    $query->where('data->name', 'like', '%'.$request->name.'%');
                }
            });
            ;
        $drafts = $drafts->paginate($this->pageSize);

        $appends = [
            'tab' => $tab,
            'name' => $request->name,
        ];

        return view('drafts.list', compact('drafts', 'appends'));
    }

    public function show(Draft $draft)
    {
        return view('jobs.create', compact('draft'));
    }

    public function destroy(Draft $draft)
    {
        $draft->delete();
        return back();
    }
}
