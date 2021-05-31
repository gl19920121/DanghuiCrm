<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resume;
use App\Models\ResumeWork;
use App\Models\ResumePrj;
use App\Models\ResumeEdu;
use App\Models\Job;
use Auth;
use Illuminate\Support\Facades\Storage;

class ResumesController extends Controller
{
    private $pageSize;

    public function __construct()
    {
        $this->middleware('auth', [
            'except' => []
        ]);

        $this->pageSize = config('public.page_size');
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
        $jobs = Job::where('status', '=', 1)->where('execute_uid', '=', Auth::user()->id)->get();
        return view('resumes.edit', compact('resume', 'jobs'));
    }

    public function list(Request $request)
    {
        $jobs = Job::where('status', '=', 1)->where('execute_uid', '=', Auth::user()->id)->limit(6)->get();
        // if (empty($request->all())) {
        if (false) {
            $resumes = [];
        } else {
            // return dd($request->all());
            $resumes = Resume::
                where('status', '=', 1)
                ->where('upload_uid', '=', Auth::user()->id)
                ->where(function ($query) use($request) {
                    if (isset($request->job_name)) {
                        $arr = explode(' ', $request->job_name);
                        $query->whereJsonContains('cur_position', $arr);
                        $query->whereJsonContains('exp_position', $arr);
                    }
                    if (!empty($request->cur_company)) {
                        $likes = $this->formatLikeKey($request->cur_company);
                        foreach ($likes as $like) {
                            $query->where('cur_company', 'like', $like);
                        }
                    }
                    if (isset($request->location)) {
                        $query->whereJsonContains('location', $request->location);
                    }
                    if (isset($request->exp_location)) {
                        $query->whereJsonContains('exp_location', $request->exp_location);
                    }
                    if (isset($request->experience)) {
                        switch ($request->experience) {
                            case 'school':
                                $query->where('work_years_flag', '=', 1);
                                break;
                            case 'fresh_graduates':
                                $query->where('work_years_flag', '=', 2);
                                break;
                            case 'primary':
                                $query->where('work_years', '>=', 1)->where('work_years', '<=', 3);
                                break;
                            case 'middle':
                                $query->where('work_years', '>=', 3)->where('work_years', '<=', 5);
                                break;
                            case 'high':
                                $query->where('work_years', '>=', 5)->where('work_years', '<=', 10);
                                break;
                            case 'expert':
                                $query->where('work_years', '>', 10);
                                break;

                            default:
                                break;
                        }
                    }
                    if (isset($request->education)) {
                        $query->where('education', $request->education);
                    }
                    if (isset($request->cur_position)) {
                        $query->whereJsonContains('cur_position', $request->cur_position);
                    }
                    if (isset($request->exp_position)) {
                        $query->whereJsonContains('exp_position', $request->exp_position);
                    }
                })
                ->paginate($this->pageSize)
            ;
        }

        $parms = $request->all();

        return view('resumes.list', compact('resumes', 'jobs', 'parms'));
    }

    private function formatLikeKey(String $string)
    {
        $arr = explode(' ', $string);
        foreach ($arr as $index => $value) {
            $arr[$index] = '%' . implode('%', str_split($value)) . '%';
        }
        return $arr;
    }

    public function show(Resume $resume)
    {
        $jobs = Job::where('status', '=', 1)->where('execute_uid', '=', Auth::user()->id)->get();
        return view('resumes.show', compact('resume', 'jobs'));
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
            'jobhunter_status' => 'nullable|numeric',
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

        $work = $data['work_experience'];
        $project = $data['project_experience'];
        $education = $data['education_experience'];

        // $data['jobhunter_status'] = 0;
        // $data['attachment_path'] = '123';
        // array_walk($work, function(&$v, $k, $p) {
        //     $v = array_merge($v, $p);
        // }, ['salary' => 12]);
        // array_walk($work, function(&$v, $k, $p) {
        //     $v = array_merge($v, $p);
        // }, ['salary_count' => 12]);
        // return dd($data);

        unset($data['work_experience']);
        unset($data['project_experience']);
        unset($data['education_experience']);

        // db insert
        $resume = Resume::create($data);

        foreach ($work as $key => $value) {
            $work[$key]['resume_id'] = $resume->id;
            $work[$key]['company_industry'] = json_encode($value['company_industry']);
            $work[$key]['job_type'] = json_encode($value['job_type']);
        }
        array_walk($project, function(&$v, $k, $p) {
            $v = array_merge($v, $p);
        }, ['resume_id' => $resume->id]);
        array_walk($education, function(&$v, $k, $p) {
            $v = array_merge($v, $p);
        }, ['resume_id' => $resume->id]);

        $resumeWork = ResumeWork::insert($work);
        $resumePrj = ResumePrj::insert($project);
        $resumeEdu = ResumeEdu::insert($education);

        // 返回
        return redirect()->route('resumes.list');
    }

    public function update(Resume $resume, Request $request)
    {
        $data = $request->toArray();
        $resume->update($data);

        return back();
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
        return redirect()->route('resumes.list');
    }
}
