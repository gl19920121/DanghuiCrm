<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Resume;
use App\Models\Draft;
use App\Models\Company;
use App\Http\Requests\StoreJobPost;
use App\Http\Requests\UpdateJobPost;
use Auth;

class JobsController extends Controller
{
    private $pageSize;

    public function __construct()
    {
        $this->middleware('auth', [
            'except' => []
        ]);

        $this->pageSize = config('public.page_size');
    }

    public function create(Request $request)
    {
        $draftId = $request->input('draft_id', -1);
        $draft = Draft::find($draftId);
        $oldData = '';

        if (!empty($draft)) {
            $jobData = json_decode(json_encode($draft->data), true);
            // $job = new Job($jobData);
            // $oldData = $job->toArray();
            $oldData = $jobData;
        }

        $companys = Company::active()->get();

        return view('jobs.create', compact('draftId', 'oldData', 'companys'));
    }

    public function edit(Job $job)
    {
        $companys = Company::active()->get();
        return view('jobs.edit', compact('job', 'companys'));
    }

    public function list(Request $request)
    {
        $tab = $request->input('tab', 'doing');
        $jobs = Job::status($tab)
            ->executeUser(Auth::user()->id)
            ->withCount(['resumes' => function ($query) {
                $query->active();
            }])
            ->withCount([
                'resumes as resumes_talking_count' => function ($query) {
                    $query->status('talking');
                },
                'resumes as resumes_push_resume_count' => function ($query) {
                    $query->status('push_resume');
                },
                'resumes as resumes_interview_count' => function ($query) {
                    $query->status('interview');
                },
                'resumes as resumes_offer_count' => function ($query) {
                    $query->status('offer');
                },
                'resumes as resumes_onboarding_count' => function ($query) {
                    $query->status('onboarding');
                },
                'resumes as resumes_over_probation_count' => function ($query) {
                    $query->status('over_probation');
                },
                'resumes as resumes_out_count' => function ($query) {
                    $query->status('out');
                },
            ])
            ->searchByName($request->input('name', ''))
            ->searchByUrgencyLevel($request->input('urgency_level', ''))
            ->searchByChannel($request->input('channel', ''))
            ->orderBy('status', 'desc')
            ->orderBy('resumes_count', 'desc')
            ->orderBy('updated_at', 'desc')
            ->paginate($this->pageSize);

        $appends = [
            'tab' => $tab,
            'name' => $request->name,
            'urgencyLevel' => $request->urgency_level,
            'channel' => $request->channel
        ];

        return view('jobs.list', compact('jobs', 'appends'));
    }

    public function show(Job $job, Request $request)
    {
        $tab = $request->input('tab', 'untreated');
        $resumes = $job->resumes()->status($tab)->paginate($this->pageSize);
        $availableResumes = Resume::active()->where('job_id', null)->get();
        $count = [
            'untreated' => $job->resumes()->status('untreated')->count(),
            'talking' => $job->resumes()->status('talking')->count(),
            'push_resume' => $job->resumes()->status('push_resume')->count(),
            'interview' => $job->resumes()->status('interview')->count(),
            'offer' => $job->resumes()->status('offer')->count(),
            'onboarding' => $job->resumes()->status('onboarding')->count(),
            'over_probation' => $job->resumes()->status('over_probation')->count(),
            'out' => $job->resumes()->status('out')->count()
        ];

        $job->increment('pv');

        return view('jobs.show')
            ->with('job', $job)
            ->with('resumes', $resumes)
            ->with('count', $count)
            ->with('tab', $tab)
            ->with('availableResumes', $availableResumes);
    }

    public function store(StoreJobPost $request)
    {
        // $validated = $request->validated();
        $data = $request->except('draft_id');

        $data['release_uid'] = Auth::user()->id;
        if (isset($request->execute_uid)) {
            $data['execute_uid'] = $request->execute_uid;
        } else {
            $data['execute_uid'] = Auth::user()->id;
        }
        $data['channel'] = array_keys($data['channel']);
        $data['status'] = -1;
        $job = Job::create($data);

        if (isset($request->draft_id)) {
            Draft::destroy($request->draft_id);
        }

        session()->flash('success', '发布成功');
        return redirect()->route('jobs.list');
    }

    public function update(Job $job, UpdateJobPost $request)
    {
        $data = $request->except('_token', '_method');

        if ($request->has('channel')) {
            $data['channel'] = array_keys($data['channel']);
        }

        $job->update($data);

        return redirect()->route('jobs.show', $job);
    }

    public function destroy(Job $job)
    {
        $job->delete();
        session()->flash('success', '删除成功');
        return back();
    }

    public function status(Job $job, Request $request)
    {
        if ($request->has('status')) {
            $job->status = $request->status;
            $job->save();
        }

        return back();
    }
}
