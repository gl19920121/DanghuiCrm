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
    private $pageSize = 1;

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

    public function edit(Resume $resume)
    {
        // return dd($resume->resumeWorks[0]);
        $jobs = Job::where('status', '=', 1)->where('execute_uid', '=', Auth::user()->id)->get();
        return view('resumes.edit', compact('resume', 'jobs'));
    }

    public function list(Request $request)
    {
        $resumes = Resume::
            where('status', '=', 1)
            ->where('upload_uid', '=', Auth::user()->id)
            ->paginate($this->pageSize)
        ;
        return view('resumes.list', compact('resumes'));
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
        // $data = $request->toArray();
        // return dd($data);
        // 数据校验 请正确输入
        $mssages = [
            'name.required' => '请填写 姓名',
            'sex.required' => '请选择 性别',
            'age.required' => '请填写 年龄',
            'location.province.required' => '请选择 所在城市',
            'location.city.required' => '请选择 所在城市',
            'location.district.required' => '请选择 所在城市',
            'work_years.required_if' => '请填写 工作年限',
            'education.required' => '请填写 教育程度',
            'phone_num.required' => '请填写 手机号码',
            'email.required' => '请填写 电子邮箱地址',
            'email.email' => '请填写 正确的邮箱地址',
            'wechat.required' => '请填写 微信号',
            'qq.required' => '请填写 QQ号',
            'cur_industry.st.required' => '请填写 所在行业',
            'cur_industry.nd.required' => '请填写 所在行业',
            'cur_industry.rd.required' => '请填写 所在行业',
            'cur_industry.th.required' => '请填写 所在行业',
            'cur_position.st.required' => '请填写 所任职位',
            'cur_position.nd.required' => '请填写 所任职位',
            'cur_position.rd.required' => '请填写 所任职位',
            'cur_company.required' => '请填写 所在公司',
            'cur_salary.required' => '请填写 目前月薪',
            'cur_salary_count.required' => '请填写 目前月薪',
            'exp_industry.st.required' => '请填写 期望行业',
            'exp_industry.nd.required' => '请填写 期望行业',
            'exp_industry.rd.required' => '请填写 期望行业',
            'exp_industry.th.required' => '请填写 期望行业',
            'exp_position.st.required' => '请填写 期望职位',
            'exp_position.nd.required' => '请填写 期望职位',
            'exp_position.rd.required' => '请填写 期望职位',
            'exp_work_nature.required' => '请选择 工作性质',
            'exp_location.province.required' => '请选择 期望城市',
            'exp_location.city.required' => '请选择 期望城市',
            'exp_location.district.required' => '请选择 期望城市',
            'exp_salary_min.required_if' => '请填写 期望薪资',
            'exp_salary_max.required_if' => '请填写 期望薪资',
            'exp_salary_count.required_if' => '请填写 期望薪资',
            'source.required' => '请选择 来源渠道'
        ];
        $this->validate($request, [
            'name' => 'required',
            'sex' => 'required',
            'age' => 'required|numeric',
            'location.province' => 'required',
            'location.city' => 'required',
            'location.district' => 'required',
            'work_years_flag' => 'required|numeric',
            'work_years' => 'required_if:work_years_flag,0|numeric',
            'education' => 'required',
            'major' => 'nullable|string|max:255',
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
            'exp_position.st' => 'required',
            'exp_position.nd' => 'required',
            'exp_position.rd' => 'required',
            'exp_work_nature' => 'required',
            'exp_location.province' => 'required',
            'exp_location.city' => 'required',
            'exp_location.district' => 'required',
            'exp_salary_flag' => 'required|numeric',
            'exp_salary_min' => 'required_if:exp_salary_flag,0|numeric',
            'exp_salary_max' => 'required_if:exp_salary_flag,0|numeric',
            'exp_salary_count' => 'required_if:exp_salary_flag,0|numeric',
            'jobhunter_status' => 'required|numeric',
            'social_home' => 'nullable',
            'personal_advantage' => 'nullable',
            'blacklist' => 'nullable',
            'remark' => 'nullable',
            'source' => 'required',
            'source_remarks' => 'nullable|string|max:255',
            'attachment' => 'nullable|file|mimes:doc,docx'
        ], $mssages);

        // 简历文件存储
        $filePath = NULL;
        $file = $request->file('attachment');
        if($request->hasFile('attachment')) {
            if (!$file->isValid()) {
                session()->flash('danger', '简历上传失败');
                return redirect()->back()->withInput();
            }
            $filePath = $file->store(date('Y-m-d').'/'.$request->user()->id, 'resume');
        }
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
            $work[$key]['company_industry'] = json_encode($value['company_industry']);
            $work[$key]['job_type'] = json_encode($value['job_type']);
            // if (isset($value['end_at_now']) && $value['end_at_now'] === 'on') {
            //     $work[$key]['end_at_now'] =
            // }
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
