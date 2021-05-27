<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resume;
use App\Models\ResumeEdu;
use App\Models\ResumeWork;
use App\Models\Job;
use Auth;
use Illuminate\Support\Facades\Storage;

class ResumesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => []
        ]);
    }

    /**
     * [create 创建简历 GET]
     * @author dante 2021-04-19
     * @return [type] [description]
     */
    public function create()
    {
        $jobs = Job::where('status', '=', 1)->where('execute_uid', '=', Auth::user()->id)->get();
        return view('resumes.create', compact('jobs'));
    }

    public function list(Request $request)
    {
        return view('resumes.list');
    }

    public function show(Resume $resume)
    {
        return view('resumes.show', compact('resume'));
    }

    /**
     * [store 创建简历 POST]
     * @author dante 2021-04-19
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        // 数据校验
        $this->validate($request, [
            'name' => 'required',
            'sex' => 'required',
            'age' => 'required|numeric',
            'location.province' => 'required',
            'location.city' => 'required',
            'location.district' => 'required',
            'work_years_flag' => 'required|numeric',
            'work_years' => 'nullable|numeric',
            'education' => 'required',
            'major' => 'required',
            'phone_num' => 'required|numeric',
            'email' => 'required|email|max:255',
            'wechat' => 'required|string|max:255',
            'qq' => 'required|string|max:255',
            'cur_industry.st' => 'required',
            'cur_industry.nd' => 'required',
            'cur_industry.rd' => 'required',
            'cur_industry.th' => 'required',
            'cur_position.st' => 'required',
            'cur_position.nd' => 'required',
            'cur_position.rd' => 'required',
            'cur_company' => 'required|string|max:255',
            'cur_salary' => 'required|numeric',
            'cur_salary_count' => 'required|numeric',
            'exp_industry.st' => 'required',
            'exp_industry.nd' => 'required',
            'exp_industry.rd' => 'required',
            'exp_industry.th' => 'required',
            'exp_position.province' => 'required',
            'exp_position.city' => 'required',
            'exp_position.district' => 'required',
            'exp_work_nature' => 'required',
            'exp_location.province' => 'required',
            'exp_location.city' => 'required',
            'exp_location.district' => 'required',
            'exp_salary_flag' => 'required|numeric',
            'exp_salary_min' => 'required|numeric',
            'exp_salary_max' => 'required|numeric',
            'exp_salary_count' => 'required|numeric',
            'jobhunter_status' => 'required|numeric',
            'social_home' => 'required',
            'personal_advantage' => 'required',
            'blacklist' => 'required',
            'remark' => 'required',
            'source' => 'required',
            'source_remarks' => 'nullable|string|max:255',
            'attachment' => 'required|file|mimes:doc,docx'
        ]);

        // 简历文件存储
        $file = $request->file('attachment');
        if($request->hasFile('attachment') && !$file->isValid()) {
            session()->flash('danger', '简历上传失败');
            return redirect()->back()->withInput();
        }
        $filePath = $file->store(date('Y-m-d').'/'.$request->user()->id, 'resume');
        unset($file);

        // 格式化db字段
        $data = $request->toArray();
        unset($data['attachment']);
        $data['upload_uid'] = Auth::user()->id;
        $data['attachment_path'] = $filePath;
        $data['location'] = json_encode($data['location']);
        $data['cur_industry'] = json_encode($data['cur_industry']);
        $data['cur_position'] = json_encode($data['cur_position']);
        $data['exp_industry'] = json_encode($data['exp_industry']);
        $data['exp_position'] = json_encode($data['exp_position']);
        $data['exp_location'] = json_encode($data['exp_location']);
        $data['source'] = json_encode($data['source']);

        $eduction = $data['eduction_experience'];
        $work = $data['work_experience'];

        unset($data['eduction_experience']);
        unset($data['work_experience']);

        // db insert
        $resume = Resume::create($data);

        array_walk($eduction, function(&$v, $k, $p) {
            $v = array_merge($v, $p);
        }, ['resume_id' => $resume->id]);
        foreach ($work as $key => $value) {
            $work[$key]['resume_id'] = $resume->id;
            $work[$key]['company_industry'] = json_encode($work[$key]['company_industry']);
            $work[$key]['job_type'] = json_encode($work[$key]['job_type']);
        }

        $resumeEdu = ResumeEdu::insert($eduction);
        $resumeWork = ResumeWork::insert($work);

        // 返回
        return redirect()->route('resumes.list');
    }

    public function status(Resume $resume, Request $request)
    {
        if ($request->has('status')) {
            $resume->status = $request->status;
            $resume->save();
        }

        return back();
    }

    /**
     * [destroy 删除简历 POST]
     * @author dante 2021-04-19
     * @param  Resume $resume [description]
     * @return [type]         [description]
     */
    public function destroy(Resume $resume)
    {
        if(Storage::disk('resume')->exists($resume->attachment_path)) {
            $delResult = Storage::disk('resume')->delete($resume->attachment_path);
            if($delResult === false) {
                session()->flash('danger', '删除失败');
                return;
            }
        }

        Resume::destroy($resume->id);
        session()->flash('success', '删除成功');
        return;
    }
}
