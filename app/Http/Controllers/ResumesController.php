<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resume;
use App\Models\ResumeWork;
use App\Models\ResumePrj;
use App\Models\ResumeEdu;
use App\Models\Job;
use App\Models\ResumeUser;
use App\Http\Services\APIHelper;
use App\Http\Services\FormateHelper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Auth;
use DateTime;
use Carbon\Carbon;

class ResumesController extends Controller
{
    private $pageSize;
    private $resumeKeys = [
        'avatar_data' => '',
        'name' => '',
        'gender' => '',
        'age' => '',
        'living_address_norm' => '',
        'work_year' => '',
        'degree' => '',
        'major' => '',
        'phone' => '',
        'email' => '',
        'weixin' => '',
        'qq' => '',
        'work_industry' => '',
        'work_position' => '',
        'work_company' => '',
        'work_salary_min' => '',
        'work_salary' => '',
        'expect_industry' => '',
        'expect_job' => '',
        'work_job_nature' => '',
        'expect_salary' => '',
        'expect_salary_min' => '',
        'expect_salary_max' => '',
        'job_exp_objs' => [
            'job_cpy' => '',
            'job_cpy_size' => '',
            'job_industry' => '',
            'job_position' => '',
            'job_salary' => '',
            'start_date' => '',
            'end_date' => '',
            'job_content' => ''
        ],
        'proj_exp_objs' => [
            'proj_name' => '',
            'start_date' => '',
            'end_date' => '',
            'proj_resp' => ''
        ],
        'education_objs' => [
            'edu_college' => '',
            'edu_degree_norm' => '',
            'edu_major' => '',
            'start_date' => '',
            'end_date' => ''
        ]
    ];

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
        return view('resumes.create');
    }

    public function edit(Resume $resume)
    {
        $jobs = Job::active()->executeUser(Auth::user()->id)->get();
        return view('resumes.edit', compact('resume', 'jobs'));
    }

    public function list(Request $request)
    {
        $parms = $request->all();
        $showDetail = isset($request->show_detail) ? (int)$request->show_detail : 0;
        $hideGet = isset($request->hide_get) ? $request->hide_get : 0;
        $hideSeen = isset($request->hide_seen) ? $request->hide_seen : 0;
        $isShow = empty($request->all()) ? false : true;
        $jobId = $request->job_id;

        $jobs = Job::where('status', '=', 1)->where('execute_uid', '=', Auth::user()->id)->limit(6)->get();

        if (!$isShow) {
            $resumes = [];
            $tab = isset($request->tab) ? $request->tab : '';
        } else {
            $resumes = self::getBaseSearch($request, $jobId);
            if (!empty($request->school)) {
                $resumes = $resumes->whereHas('resumeEdus', function ($query) use($request) {
                    $query->where('school_name', 'like', '%'.$request->school.'%');
                });
            }
            if ($request->hide_get === 'on') {
                $resumes->whereDoesntHave('users', function ($query) {
                    $query->where('type', 'collect');
                });
            }
            if ($request->hide_seen === 'on') {
                $resumes->whereDoesntHave('users', function ($query) {
                    $query->where('type', 'seen');
                });
            }

            $resumes = $resumes->with(['resumeEdus' => function($query) {
                $query->where('is_not_end', 0)->orderBy('end_at', 'desc');
            }])->paginate($this->pageSize);

            $tab = isset($request->tab) ? $request->tab : 'detail';
        }

        return view('resumes.list', compact('resumes', 'jobs', 'parms', 'tab', 'showDetail', 'hideGet', 'hideSeen'));
    }

    public function show(Resume $resume)
    {
        $jobs = Job::where('status', '=', 1)->where('execute_uid', '=', Auth::user()->id)->get();
        ResumeUser::store($resume->id, Auth::user()->id, 'seen');
        return view('resumes.show', compact('resume', 'jobs'));
    }

    public function manual(Request $request)
    {
        $jobs = Job::where('status', '=', 1)->where('execute_uid', '=', Auth::user()->id)->get();

        if ($request->has('is_auto') && session()->has('resume')) {
            $resume = session()->get('resume');
            // return dd($resume);
            //'2019.09'
            // dd(Carbon::createFromFormat('Y-m-d', '2019-09')->toDateTimeString());
        } else {
            $result = [];
            $this->handleResData($result);
            $resume = $this->handleResumeData($result);
        }

        return view('resumes.create_form', compact('jobs', 'resume'));
    }

    public function auto(Request $request)
    {
        $jobs = Job::where('status', '=', 1)->where('execute_uid', '=', Auth::user()->id)->get();

        $filePath = NULL;
        $file = $request->file('resume');
        if($request->hasFile('resume')) {
            if (!$file->isValid()) {
                session()->flash('danger', '简历上传失败');
                return redirect()->back()->withInput();
            }
            $filePath = Storage::disk('resume_append')->putFile(date('Y-m-d').'/'.$request->user()->id, $file);
        }
        unset($file);

        $api = new APIHelper();
        // $res = $api->resumesdk($filePath);
        $res = $api->resumesdkTest($filePath);
        // return dd($res);

        if ($res['status']['code'] !== 200) {
            session()->flash('danger', '简历解析失败');
            return redirect()->back();
        }

        $result = $res['result'];
        $this->handleResData($result);
        $resume = $this->handleResumeData($result);

        session()->put('resume', $resume);
        return redirect()->route('resumes.create.manual', ['is_auto' => 1]);
    }

    public function mine(Request $request)
    {
        $tab = isset($request->tab) ? $request->tab : 'all';
        $showDetail = isset($request->show_detail) ? (int)$request->show_detail : 0;

        $resumes = self::getBaseSearch($request);
        //$resumes->where('status', '!=', 0)->where('upload_uid', Auth::user()->id);
        switch ($tab) {
            case 'all':
                $resumes->has('user');
                $resumes->where('status', '!=', 0);
                break;
            case 'seen':
                $resumes->whereHas('usersSeen', function ($query) use ($request) {
                    if (!empty($request->start_at)) {
                        $query->whereRaw('date(resume_user.updated_at) >= "' . $request->start_at . '"');
                    }
                    if (!empty($request->end_at)) {
                        $query->whereRaw('date(resume_user.updated_at) <= "' . $request->end_at . '"');
                    }
                });
                break;
            case 'collect':
                $resumes->whereHas('usersCollect', function ($query) use ($request) {
                    if (!empty($request->start_at)) {
                        $query->whereRaw('date(resume_user.updated_at) >= "' . $request->start_at . '"');
                    }
                    if (!empty($request->end_at)) {
                        $query->whereRaw('date(resume_user.updated_at) <= "' . $request->end_at . '"');
                    }
                });
                break;
            case 'apply':
            case 'commission':
                $resumes->where('status', '!=', 0);
                $resumes->whereHas('job', function ($query) use ($request) {
                    if (!empty($request->start_at)) {
                        $query->whereRaw('date(updated_at) >= "' . $request->start_at . '"');
                    }
                    if (!empty($request->end_at)) {
                        $query->whereRaw('date(updated_at) <= "' . $request->end_at . '"');
                    }
                });

            default:
                break;
        }
        $resumes = $resumes
            ->with(['resumeEdus' => function($query) {
                $query->orderBy('end_at', 'desc');
            }])
            ->with(['resumeWorks' => function($query) {
                $query->orderBy('end_at', 'desc');
            }])
        ;

        $resumes = $resumes->paginate($this->pageSize);

        $countInfo = [
            'all' => Resume::where('status', '!=', 0)->has('user')->count(),
            'seen' => Resume::has('usersSeen')->count(),
            'apply' => Resume::where('status', '!=', 0)->has('job')->count(),
            'commission' => Resume::where('status', '!=', 0)->has('job')->count(),
            'collect' => Resume::has('usersCollect')->count(),
            'seenmy' => Resume::has('user')->count(),
            'relay' => Resume::has('usersRelay')->count()
        ];
        $parms = $request->all();

        return view('resumes.mine', compact('resumes', 'parms', 'tab', 'showDetail', 'countInfo'));
    }

    public function current(Request $request)
    {
        $resumes = Resume::
            where('status', '!=', 0)
            // ->has('user')
            ->whereRaw('date(created_at) >= DATE_SUB(CURDATE(), INTERVAL 3 DAY)')
            ->with(['resumeEdus' => function($query) {
                $query->orderBy('end_at', 'desc');
            }])
            ->with(['resumeWorks' => function($query) {
                $query->orderBy('end_at', 'desc');
            }])
        ;

        if ($request->hide_get === 'on') {
            $resumes->whereDoesntHave('users', function ($query) {
                $query->where('type', 'collect');
            });
        }
        if ($request->hide_seen === 'on') {
            $resumes->whereDoesntHave('users', function ($query) {
                $query->where('type', 'seen');
            });
        }

        $resumes = $resumes->paginate($this->pageSize);
        $jobs = Job::where('status', '!=', 0)->where('execute_uid', '=', Auth::user()->id)->get();

        $tab = isset($request->tab) ? $request->tab : 'detail';
        $hideGet = isset($request->hide_get) ? $request->hide_get : 0;
        $hideSeen = isset($request->hide_seen) ? $request->hide_seen : 0;

        return view('resumes.current', compact('resumes', 'jobs', 'tab', 'hideGet', 'hideSeen'));
    }



    /**
     * [store 创建简历 POST]
     * @author dante 2021-04-19
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
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
            'source.required' => '请选择 来源渠道',
            'work_experience.*.company_name.required' => '请填写 公司名称',
            'work_experience.*.company_nature.required' => '请选择 公司性质',
            'work_experience.*.company_scale.required' => '请选择 公司规模',
            'work_experience.*.company_investment.required' => '请选择 融资阶段',
            'work_experience.*.company_industry.st.required' => '请选择 所属行业',
            'work_experience.*.company_industry.nd.required' => '请选择 所属行业',
            'work_experience.*.company_industry.rd.required' => '请选择 所属行业',
            'work_experience.*.company_industry.th.required' => '请选择 所属行业',
            'work_experience.*.job_type.st.required' => '请选择 职位名称',
            'work_experience.*.job_type.nd.required' => '请选择 职位名称',
            'work_experience.*.job_type.rd.required' => '请选择 职位名称',
            'work_experience.*.salary.required' => '请填写 月薪',
            'work_experience.*.salary_count.required' => '请填写 月薪',
            'work_experience.*.subordinates.numeric' => '请正确填写 下属人数',
            'work_experience.*.start_at.required' => '请填写 入职时间',
            'work_experience.*.end_at.required_without' => '请填写 离职时间',
            'work_experience.*.work_desc.required' => '请填写 工作描述',
            'project_experience.*.name.required' => '请填写 项目名称',
            'project_experience.*.role.required' => '请填写 担任角色',
            'project_experience.*.start_at.required' => '请填写 项目开始时间',
            'project_experience.*.end_at.required_without' => '请填写 项目结束时间',
            'education_experience.*.school_name.required' => '请填写 毕业院校',
            'education_experience.*.school_level.required' => '请选择 最高学历',
            'education_experience.*.start_at.required' => '请填写 入学时间',
            'education_experience.*.end_at.required_without' => '请填写 毕业时间',
        ];
        $this->validate($request, [
            'avatar' => 'nullable|mimes:jpeg,jpg,png',
            'name' => 'required',
            'sex' => 'required',
            'age' => 'required|numeric',
            'location.province' => 'required',
            'location.city' => 'required',
            'location.district' => 'nullable',
            'work_years_flag' => 'required|numeric',
            'work_years' => 'required_if:work_years_flag,0|numeric',
            'education' => 'required',
            'major' => 'nullable|string|max:255',
            'phone_num' => 'required|string|max:11',
            'email' => 'required|string|max:255',
            'wechat' => 'nullable|string|max:255',
            'qq' => 'nullable|string|max:255',
            'cur_industry.st' => 'nullable',
            'cur_industry.nd' => 'nullable',
            'cur_industry.rd' => 'nullable',
            'cur_industry.th' => 'nullable',
            'cur_position.st' => 'nullable',
            'cur_position.nd' => 'nullable',
            'cur_position.rd' => 'nullable',
            'cur_company' => 'nullable|string|max:255',
            'cur_salary' => 'nullable|numeric',
            'cur_salary_count' => 'nullable|numeric',
            'exp_industry.st' => 'nullable',
            'exp_industry.nd' => 'nullable',
            'exp_industry.rd' => 'nullable',
            'exp_industry.th' => 'nullable',
            'exp_position.st' => 'required',
            'exp_position.nd' => 'required',
            'exp_position.rd' => 'required',
            'exp_work_nature' => 'nullable',
            'exp_location.province' => 'required',
            'exp_location.city' => 'required',
            'exp_location.district' => 'nullable',
            'exp_salary_flag' => 'required|numeric',
            'exp_salary_min' => 'required_if:exp_salary_flag,0|numeric',
            'exp_salary_max' => 'required_if:exp_salary_flag,0|numeric',
            'exp_salary_count' => 'required_if:exp_salary_flag,0|numeric',
            'work_experience' => 'required|array',
            'work_experience.*.company_name' => 'required',
            'work_experience.*.company_nature' => 'nullable',
            'work_experience.*.company_scale' => 'nullable',
            'work_experience.*.company_investment' => 'nullable',
            'work_experience.*.company_industry.st' => 'nullable',
            'work_experience.*.company_industry.nd' => 'nullable',
            'work_experience.*.company_industry.rd' => 'nullable',
            'work_experience.*.company_industry.th' => 'nullable',
            'work_experience.*.job_type.st' => 'required',
            'work_experience.*.job_type.nd' => 'required',
            'work_experience.*.job_type.rd' => 'required',
            'work_experience.*.salary' => 'required',
            'work_experience.*.salary_count' => 'required',
            'work_experience.*.subordinates' => 'nullable|numeric',
            'work_experience.*.start_at' => 'required|date_format:Y/m',
            'work_experience.*.end_at' => 'required_without:work_experience.*.is_not_end|date_format:Y/m',
            'work_experience.*.is_not_end' => 'filled',
            'work_experience.*.work_desc' => 'required',
            'project_experience' => 'nullable|array',
            'project_experience.*.name' => 'nullable',
            'project_experience.*.role' => 'nullable',
            'project_experience.*.start_at' => 'nullable|date_format:Y/m',
            'project_experience.*.end_at' => 'nullable|date_format:Y/m',
            'project_experience.*.is_not_end' => 'filled',
            'project_experience.*.body' => 'nullable',
            'education_experience' => 'required|array',
            'education_experience.*.school_name' => 'required',
            'education_experience.*.school_level' => 'required',
            'education_experience.*.major' => 'nullable',
            'education_experience.*.start_at' => 'nullable|date_format:Y/m',
            'education_experience.*.end_at' => 'nullable|date_format:Y/m',
            'education_experience.*.is_not_end' => 'filled',
            'social_home' => 'nullable',
            'personal_advantage' => 'nullable',
            'attachment' => 'nullable|file|mimes:doc,docx',
            'jobhunter_status' => 'nullable|numeric',
            'blacklist' => 'nullable',
            'remark' => 'nullable',
            'source' => 'required',
            'source_remarks' => 'nullable|string|max:255'
        ], $mssages);

        $avatarPath = NULL;
        $avatar = $request->file('avatar');
        if($request->hasFile('avatar')) {
            if (!$avatar->isValid()) {
                session()->flash('danger', '头像上传失败');
                return redirect()->back()->withInput();
            }
            $avatarPath = Storage::disk('resume_avatar')->putFile(date('Y-m-d').'/'.$request->user()->id, $avatar);
        }
        unset($avatar);

        // 简历文件存储
        $filePath = NULL;
        $file = $request->file('attachment');
        if($request->hasFile('attachment')) {
            if (!$file->isValid()) {
                session()->flash('danger', '简历上传失败');
                return redirect()->back()->withInput();
            }
            $filePath = Storage::disk('resume_append')->putFile(date('Y-m-d').'/'.$request->user()->id, $file);
        }
        unset($file);

        // 格式化db字段
        $data = $request->except(['attachment', 'work_experience', 'project_experience', 'education_experience']);
        $data['upload_uid'] = Auth::user()->id;
        $data['attachment_path'] = $filePath;
        $data['avatar'] = $avatarPath;
        $data['source'] = array_keys($data['source']);
        if ((int)$data['exp_salary_flag'] === 1) {
            $data['exp_salary_min'] = NULL;
            $data['exp_salary_max'] = NULL;
            $data['exp_salary_count'] = NULL;
        }

        $work = $request->input('work_experience');
        $project = $request->input('project_experience');
        $education = $request->input('education_experience');

        DB::beginTransaction();
        try {
            // db insert
            $resume = Resume::create($data);

            foreach ($work as $key => $value) {
                $work[$key]['resume_id'] = $resume->id;
                $work[$key]['company_industry'] = json_encode($value['company_industry']);
                $work[$key]['job_type'] = json_encode($value['job_type']);
                $work[$key]['start_at'] = FormateHelper::date($value['start_at'], 'year');
                if (isset($value['is_not_end']) && $value['is_not_end'] === 'on') {
                    $work[$key]['is_not_end'] = true;
                    $work[$key]['end_at'] = FormateHelper::date(null, 'year');
                } else {
                    $work[$key]['is_not_end'] = false;
                    $work[$key]['end_at'] = FormateHelper::date($value['end_at'], 'year');
                }
            }
            foreach ($project as $key => $value) {
                $project[$key]['resume_id'] = $resume->id;
                $project[$key]['start_at'] = FormateHelper::date($value['start_at'], 'year');
                if (isset($value['is_not_end']) && $value['is_not_end'] === 'on') {
                    $project[$key]['is_not_end'] = true;
                    $project[$key]['end_at'] = FormateHelper::date(null, 'year');
                } else {
                    $project[$key]['is_not_end'] = false;
                    $project[$key]['end_at'] = FormateHelper::date($value['end_at'], 'year');
                }
            }
            foreach ($education as $key => $value) {
                $education[$key]['resume_id'] = $resume->id;
                $education[$key]['start_at'] = FormateHelper::date($value['start_at'], 'year');
                if (isset($value['is_not_end']) && $value['is_not_end'] === 'on') {
                    $education[$key]['is_not_end'] = true;
                    $education[$key]['end_at'] = FormateHelper::date(null, 'year');
                } else {
                    $education[$key]['is_not_end'] = false;
                    $education[$key]['end_at'] = FormateHelper::date($value['end_at'], 'year');
                }
            }

            $resumeWork = ResumeWork::insert($work);
            $resumePrj = ResumePrj::insert($project);
            $resumeEdu = ResumeEdu::insert($education);

            ResumeUser::store($resume->id, Auth::user()->id, 'upload');

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            // dd($exception);
        }

        // 返回
        return redirect()->route('resumes.list');
    }

    public function update(Resume $resume, Request $request)
    {
        $data = $request->except('_token', '_method', 'attachment', 'work_experience', 'project_experience', 'education_experience');

        if ($request->has('avatar')) {
            $avatarPath = NULL;
            $avatar = $request->file('avatar');
            if($request->hasFile('avatar')) {
                if (!$avatar->isValid()) {
                    session()->flash('danger', '头像上传失败');
                    return redirect()->back()->withInput();
                }
                $avatarPath = Storage::disk('resume_avatar')->putFile(date('Y-m-d').'/'.$request->user()->id, $avatar);
            }
            unset($avatar);
            $data['avatar'] = $avatarPath;
        }
        if ($request->has('attachment')) {
            // 简历文件存储
            $filePath = NULL;
            $file = $request->file('attachment');
            if($request->hasFile('attachment')) {
                if (!$file->isValid()) {
                    session()->flash('danger', '简历上传失败');
                    return redirect()->back()->withInput();
                }
                $filePath = Storage::disk('resume_append')->putFile(date('Y-m-d').'/'.$request->user()->id, $file);
            }
            unset($file);
            $data['attachment_path'] = $filePath;
        }
        if ($request->has('source')) {
            $data['source'] = array_keys($request->input('source'));
        }

        // $resume->update($data);
        $workUpdate = []; $workCreate = [];
        $projectUpdate = []; $projectCreate = [];
        $educationUpdate = []; $educationCreate = [];

        if ($request->has('work_experience')) {
            $workExperiences = $request->input('work_experience');
            foreach ($workExperiences as $index => $workExperience) {
                if (isset($workExperience['id'])) {
                    $resumeWork = ResumeWork::find($workExperience['id']);
                    if ($resumeWork) {
                        // $resumeWork->update($workExperience);
                        $workUpdate[] = ['model' => $resumeWork, 'value' => $workExperience];
                    }
                } else {
                    $message = [
                        'work_experience.*.company_name.required' => '请填写 公司名称',
                        'work_experience.*.company_nature.required' => '请选择 公司性质',
                        'work_experience.*.company_scale.required' => '请选择 公司规模',
                        'work_experience.*.company_investment.required' => '请选择 融资阶段',
                        'work_experience.*.company_industry.st.required' => '请选择 所属行业',
                        'work_experience.*.company_industry.nd.required' => '请选择 所属行业',
                        'work_experience.*.company_industry.rd.required' => '请选择 所属行业',
                        'work_experience.*.company_industry.th.required' => '请选择 所属行业',
                        'work_experience.*.job_type.st.required' => '请选择 职位名称',
                        'work_experience.*.job_type.nd.required' => '请选择 职位名称',
                        'work_experience.*.job_type.rd.required' => '请选择 职位名称',
                        'work_experience.*.salary.required' => '请填写 月薪',
                        'work_experience.*.salary_count.required' => '请填写 月薪',
                        'work_experience.*.subordinates.numeric' => '请正确填写 下属人数',
                        'work_experience.*.start_at.required' => '请填写 入职时间',
                        'work_experience.*.end_at.required_without' => '请填写 离职时间',
                        'work_experience.*.work_desc.required' => '请填写 工作描述',
                    ];
                    $this->validate($request, [
                        'work_experience' => 'required|array',
                        'work_experience.*.company_name' => 'required',
                        'work_experience.*.job_type.st' => 'required',
                        'work_experience.*.job_type.nd' => 'required',
                        'work_experience.*.job_type.rd' => 'required',
                        'work_experience.*.salary' => 'required',
                        'work_experience.*.salary_count' => 'required',
                        'work_experience.*.subordinates' => 'nullable|numeric',
                        'work_experience.*.start_at' => 'required|date_format:Y/m',
                        'work_experience.*.end_at' => 'required_without:work_experience.*.is_not_end|date_format:Y/m',
                        'work_experience.*.is_not_end' => 'filled',
                        'work_experience.*.work_desc' => 'required',
                    ], $message);

                    $workExperience['resume_id'] = $resume->id;
                    // ResumeWork::create($workExperience);
                    $workCreate[] = $workExperience;
                }
            }
        }
        if ($request->has('project_experience')) {
            $projectExperiences = $request->input('project_experience');
            foreach ($projectExperiences as $index => $projectExperience) {
                if (isset($projectExperience['id'])) {
                    $resumePrj = ResumePrj::find($projectExperience['id']);
                    if ($resumePrj) {
                        // $resumePrj->update($projectExperience);
                        $projectUpdate[] = ['model' => $resumePrj, 'value' => $projectExperience];
                    }
                } else {
                    $message = [
                        // 'project_experience.*.name.required' => '请填写 项目名称',
                        // 'project_experience.*.role.required' => '请填写 担任角色',
                        // 'project_experience.*.start_at.required' => '请填写 项目开始时间',
                        // 'project_experience.*.end_at.required_without' => '请填写 项目结束时间',
                    ];
                    $this->validate($request, [
                        'project_experience' => 'nullable|array',
                        'project_experience.*.start_at' => 'nullable|date_format:Y/m',
                        'project_experience.*.end_at' => 'nullable|date_format:Y/m',
                        'project_experience.*.is_not_end' => 'filled',
                    ], $message);

                    $projectExperience['resume_id'] = $resume->id;
                    // ResumePrj::create($projectExperience);
                    $projectCreate[] = $projectExperience;
                }
            }
        }
        if ($request->has('education_experience')) {
            $educationExperiences = $request->input('education_experience');
            foreach ($educationExperiences as $index => $educationExperience) {
                if (isset($educationExperience['id'])) {
                    $resumeEdu = ResumeEdu::find($educationExperience['id']);
                    if ($resumeEdu) {
                        // $resumeEdu->update($educationExperience);
                        $educationUpdate[] = ['model' => $resumeEdu, 'value' => $educationExperience];
                    }
                } else {
                    $message = [
                        'education_experience.*.school_name.required' => '请填写 毕业院校',
                        'education_experience.*.school_level.required' => '请选择 最高学历',
                        'education_experience.*.end_at.required_without' => '请填写 毕业时间',
                    ];
                    $this->validate($request, [
                        'education_experience' => 'required|array',
                        'education_experience.*.school_name' => 'required',
                        'education_experience.*.school_level' => 'required',
                        'education_experience.*.start_at' => 'nullable|date_format:Y/m',
                        'education_experience.*.end_at' => 'nullable|date_format:Y/m',
                        'education_experience.*.is_not_end' => 'filled',
                    ], $message);

                    $educationExperience['resume_id'] = $resume->id;
                    // ResumeEdu::create($educationExperience);
                    $educationCreate[] = $educationExperience;
                }
            }
        }

        $resume->update($data);
        foreach ($workUpdate as $item) {
            $item['model']->update($item['value']);
        }
        foreach ($projectUpdate as $item) {
            $item['model']->update($item['value']);
        }
        foreach ($educationUpdate as $item) {
            $item['model']->update($item['value']);
        }
        foreach ($workCreate as $value) {
            ResumeWork::create($value);
        }
        foreach ($projectCreate as $value) {
            ResumePrj::create($value);
        }
        foreach ($educationCreate as $value) {
            ResumeEdu::create($value);
        }

        return back();
    }

    public function operation(Resume $resume, Request $request)
    {
        $resumeId = $resume->id;
        $userId = Auth::user()->id;
        $type = $request->type;

        ResumeUser::store($resumeId, $userId, $type);

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
        if(Storage::disk('resume_append')->exists($resume->attachment_path)) {
            $delResult = Storage::disk('resume_append')->delete($resume->attachment_path);
            if($delResult === false) {
                session()->flash('danger', '删除失败');
                return back();
            }
        }

        Resume::destroy($resume->id);
        session()->flash('success', '删除成功');
        return back();
    }



    private function mb_str_split($str) {
        return preg_split('/(?<!^)(?!$)/u', $str );
    }

    private function formatLikeKey($string, $all = [])
    {
        if (empty($string)) {
            return $all;
        }

        $arr = explode(' ', $string);
        foreach ($arr as $index => $value) {
            // $arr[$index] = '%' . implode('%', $this->mb_str_split($value)) . '%';
            $arr[$index] = '%' . $value . '%';
        }

        return array_merge($arr, $all);
    }

    private function handleResData(&$result)
    {
        $default = $this->resumeKeys;

        foreach ($default as $key => $value) {
            if (is_array($value)) {
                $stKey = $key;
                if (!isset($result[$stKey])) {
                    $result[$stKey] = [];
                }
                foreach ($result[$stKey] as $index => $item) {
                    foreach ($value as $ndKey => $ndValue) {
                        if (!isset($item[$ndKey])) {
                            $result[$stKey][$index][$ndKey] = $ndValue;
                        }
                    }
                }

            } else {
                if (!isset($result[$key])) {
                    $result[$key] = $value;
                }
            }
        }
    }

    private function getNumber($data)
    {
        $num = $data;
        if (!empty($data) && preg_match('/\d+/', $data, $arr)) {
           $num = (int)$arr[0];
        }

        return (int)$num;
    }

    private function getDate($data = null)
    {
        if ($data === null) {
            return date('Y/m/d', time());
        }

        $data = str_replace('.', '/', $data);
        $data = str_replace('-', '/', $data);
        $dataArr = explode('/', $data);
        if (count($dataArr) < 3) {
            $data .= '/01';
        }

        $timestamp = strtotime($data);
        if ($timestamp === false) {
            return '';
        }
        return date('Y/m', $timestamp);

        // if(strtotime(date('m-d-Y H:i:s',$timestamp)) !== $timestamp) {
        //     return '';
        // }
        // $datetime = new DateTime($timestamp);

        // return $datetime->format('Y/m/d');
    }

    private function handleEducation($data)
    {
        if (strpos($data, '高') !== false) {
            $education = 'high_schoo';
        } elseif (strpos($data, '专') !== false) {
            $education = 'junior';
        } elseif (strpos($data, '本') !== false) {
            $education = 'undergraduate';
        } elseif (strpos($data, '硕') !== false) {
            $education = 'master';
        } elseif (strpos($data, '博') !== false) {
            $education = 'doctor';
        } else {
            $education = $data;
        }

        return $education;
    }

    private function handleSalary($data)
    {
        if (empty($data)) {
            return '';
        }
        $data = $this->getNumber($data);
        $salary = sprintf('%.1f', (int)$data / 1000);
        $salary = floatval($salary);
        return $salary;
    }

    private function handleResumeData($result)
    {
        $cur_salary_count = '';
        if (!empty($result['work_salary']) && preg_match('/\d+/', $result['work_salary'], $arr)) {
           $year_salary = (int)$arr[0];
           $salary = (int)$result['work_salary_min'];
           $cur_salary_count = floor($year_salary / $salary);
        } else {
            $cur_salary_count = !empty($result['name']) ? 12 : '';
        }

        $exp_salary_count = !empty($result['name']) ? 12 : '';

        $living_address_norm = explode('-', $result['living_address_norm']);
        if (count($living_address_norm) >= 3) {
            $location = [
                'province' => $living_address_norm[1],
                'city' => $living_address_norm[2],
                'district' => '',
            ];
        } else {
            $location = [
                'province' => '',
                'city' => '',
                'district' => ''
            ];
        }

        $education = $this->handleEducation($result['degree']);

        $exp_work_nature = $result['work_job_nature'];
        if (strpos($exp_work_nature, '全') !== false && strpos($exp_work_nature, '兼')) {
            $exp_work_nature = 'all';
        } elseif (strpos($exp_work_nature, '全') !== false) {
            $exp_work_nature = 'full';
        } elseif (strpos($exp_work_nature, '兼') !== false) {
            $exp_work_nature = 'part';
        }

        $resume = [
            'avatar' => $result['avatar_data'],
            'name' => $result['name'],
            'sex' => $result['gender'],
            'age' => $result['age'],
            'location' => $location,
            'work_years' => !empty($result['work_year']) ? intval($result['work_year']) : '',
            'work_years_flag' => 0,
            'education' => $education,
            'major' => $result['major'],
            'phone_num' => $result['phone'],
            'email' => $result['email'],
            'wechat' => $result['weixin'],
            'qq' => $result['qq'],
            'cur_industry' => [
                'st' => $result['work_industry'],
                'nd' => $result['work_industry'],
                'rd' => $result['work_industry'],
                'th' => $result['work_industry']
            ],
            'cur_position' => [
                'st' => $result['work_position'],
                'nd' => $result['work_position'],
                'rd' => $result['work_position']
            ],
            'cur_company' => $result['work_company'],
            'cur_salary' => $this->handleSalary($result['work_salary_min']),
            'cur_salary_count' => $cur_salary_count,
            'exp_industry' => [
                'st' => $result['expect_industry'],
                'nd' => $result['expect_industry'],
                'rd' => $result['expect_industry'],
                'th' => $result['expect_industry']
            ],
            'exp_position' => [
                'st' => $result['expect_job'],
                'nd' => $result['expect_job'],
                'rd' => $result['expect_job']
            ],
            'exp_work_nature' => $exp_work_nature,
            'exp_salary_min' => $this->handleSalary($result['expect_salary_min']),
            'exp_salary_max' => $this->handleSalary($result['expect_salary_max']),
            'exp_salary_count' => $exp_salary_count,
            'work_experience' => [],
            'project_experience' => [],
            'education_experience' => []
        ];

        foreach ($result['job_exp_objs'] as $index => $work_experience) {

            $resume['work_experience'][$index] = [
                'company_name' => $work_experience['job_cpy'],
                'company_scale' => $work_experience['job_cpy_size'],
                'company_industry' => [
                    'st' => $work_experience['job_industry'],
                    'nd' => $work_experience['job_industry'],
                    'rd' => $work_experience['job_industry'],
                    'th' => $work_experience['job_industry']
                ],
                'job_type' => [
                    'st' => $work_experience['job_position'],
                    'nd' => $work_experience['job_position'],
                    'rd' => $work_experience['job_position']
                ],
                'salary' => $this->handleSalary($work_experience['job_salary']),
                'salary_count' => 12,
                'start_at' => $this->getDate($work_experience['start_date']),
                'end_at' => $this->getDate($work_experience['end_date']),
                'is_not_end' => strstr($work_experience['end_date'], '至今') === false ? '' : 'on',
                'work_desc' => $work_experience['job_content']
            ];
        }

        foreach ($result['proj_exp_objs'] as $index => $project_experience) {

            $resume['project_experience'][$index] = [
                'name' => $project_experience['proj_name'],
                'start_at' => $this->getDate($project_experience['start_date']),
                'end_at' => $this->getDate($project_experience['end_date']),
                'is_not_end' => strstr($project_experience['end_date'], '至今') === false ? '' : 'on',
                'body' => $project_experience['proj_resp']
            ];
        }

        foreach ($result['education_objs'] as $index => $education_experience) {

            $resume['education_experience'][$index] = [
                'school_name' => $education_experience['edu_college'],
                'school_level' => $this->handleEducation($education_experience['edu_degree_norm']),
                'major' => $education_experience['edu_major'],
                'start_at' => $this->getDate($education_experience['start_date']),
                'end_at' => $this->getDate($education_experience['end_date']),
                'is_not_end' => strstr($education_experience['end_date'], '至今') === false ? '' : 'on'
            ];
        }

        return new Resume($resume);
    }

    private function getBaseSearch($request, $jobId = null)
    {
        if (empty($request->all)) {
            $hasAll = false;
            $allLikes = [];
        } else {
            $hasAll = true;
            $allLikes = $this->formatLikeKey($request->all);
        }
        // return dd($allLikes);

        return Resume::
            where(function ($query) use($request) {
                if (!empty($request->all)) {
                    $likes = $this->formatLikeKey($request->all);
                    foreach ($likes as $like) {
                        $query->orWhere('name', 'like', $like);

                        $query->orWhere('cur_company', 'like', $like);

                        $query->orWhere('location', 'like', $like);
                        $query->orWhere('exp_location', 'like', $like);

                        $query->orWhere('cur_industry', 'like', $like);
                        $query->orWhere('cur_position', 'like', $like);

                        $query->orWhere('exp_industry', 'like', $like);
                        $query->orWhere('exp_position', 'like', $like);

                        $query->orWhere('major', 'like', $like);
                    }
                }
            })
            ->where(function ($query) use($request) {
                if (!empty($request->job_name)) {
                    $likes = $this->formatLikeKey($request->job_name);
                    foreach ($likes as $index => $like) {
                        if ($index === 0) {
                            $query->where('cur_position->st', 'like', $like);
                        } else {
                            $query->orWhere('cur_position->st', 'like', $like);
                        }
                        $query->orWhere('cur_position->nd', 'like', $like);
                        $query->orWhere('cur_position->rd', 'like', $like);
                        $query->orWhere('exp_position->st', 'like', $like);
                        $query->orWhere('exp_position->nd', 'like', $like);
                        $query->orWhere('exp_position->rd', 'like', $like);
                    }
                }
            })
            ->where(function ($query) use($request) {
                if (!empty($request->company_name)) {
                    $likes = $this->formatLikeKey($request->company_name);
                    foreach ($likes as $index => $like) {
                        if ($index === 0) {
                            $query->where('cur_company', 'like', $like);
                        } else {
                            $query->orWhere('cur_company', 'like', $like);
                        }
                    }
                }
            })
            ->where(function ($query) use($request) {
                if (!empty($request->location)) {
                    foreach ($request->location as $key => $location) {
                        if (empty($location)) {
                            continue;
                        }
                        $query->where("location->$key", '=', $location);
                    }
                }
            })
            ->where(function ($query) use($request) {
                if (!empty($request->exp_location)) {
                    foreach ($request->exp_location as $key => $exp_location) {
                        if (empty($exp_location)) {
                            continue;
                        }
                        $query->where("exp_location->$key", '=', $exp_location);
                    }
                }
            })
            ->where(function ($query) use($request) {
                if (!empty($request->experience)) {
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
            })
            ->where(function ($query) use($request) {
                if (!empty($request->education)) {
                    $query->where('education', $request->education);
                }
            })
            ->where(function ($query) use($request) {
                if (!empty($request->cur_industry)) {
                    foreach ($request->cur_industry as $key => $cur_industry) {
                        if (empty($cur_industry)) {
                            continue;
                        }
                        $query->where("cur_industry->$key", '=', $cur_industry);
                    }
                }
            })
            ->where(function ($query) use($request) {
                if (!empty($request->cur_position)) {
                    foreach ($request->cur_position as $key => $cur_position) {
                        if (empty($cur_position)) {
                            continue;
                        }
                        $query->where("cur_position->$key", '=', $cur_position);
                    }
                }
            })
            ->where(function ($query) use($request) {
                if (!empty($request->age_min)) {
                    $query->where('age', '>=', $request->age_min);
                }
                if (!empty($request->age_max)) {
                    $query->where('age', '<=', $request->age_max);
                }
            })
            ->where(function ($query) use($request) {
                if (!empty($request->sex)) {
                    $query->where('sex', $request->sex);
                }
            })
            ->where(function ($query) use($request) {
                if (!empty($request->jobhunter_status)) {
                    $query->where('jobhunter_status', $request->jobhunter_status);
                }
            })
            ->where(function ($query) use($request) {
                if (!empty($request->source)) {
                    $query->where('source', $request->source);
                }
            })
            ->where(function ($query) use($request) {
                if (!empty($request->updated_at)) {
                    switch ($request->updated_at) {
                        case '1':
                            $query->whereRaw('date(updated_at) >= DATE_SUB(CURDATE(), INTERVAL 3 DAY)');
                            break;
                        case '2':
                            $query->whereRaw('date(updated_at) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)');
                            break;
                        case '3':
                            $query->whereRaw('date(updated_at) >= DATE_SUB(CURDATE(), INTERVAL 14 DAY)');
                            break;
                        case '4':
                            $query->whereRaw('date(updated_at) >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)');
                            break;
                        case '5':
                            $query->whereRaw('date(updated_at) < DATE_SUB(CURDATE(), INTERVAL 1 MONTH)');
                            break;

                        default:
                            break;
                    }
                }
            })
            ->where(function ($query) use($request) {
                if (!empty($request->exp_year_salary_min)) {
                    $query->whereRaw($request->exp_year_salary_min . ' <= (exp_salary_max * exp_salary_count / 10)');

                    if (!empty($request->exp_year_salary_max)) {
                        $query->whereRaw($request->exp_year_salary_max . ' >= (exp_salary_min * exp_salary_count / 10)');
                    } else {
                        $query->whereRaw('1');
                    }
                }
            })
            ->where(function ($query) use($request) {
                if (!empty($request->cur_year_salary_min)) {
                    $query->whereRaw($request->cur_year_salary_min . ' <= (cur_salary * cur_salary_count / 10)');

                    if (!empty($request->cur_year_salary_max)) {
                        $query->whereRaw($request->cur_year_salary_max . ' >= (cur_salary * cur_salary_count / 10)');
                    } else {
                        $query->whereRaw('1');
                    }
                }
            })
            ->where(function ($query) use($request) {
                if (!empty($request->exp_industry)) {
                    foreach ($request->exp_industry as $key => $exp_industry) {
                        if (empty($exp_industry)) {
                            continue;
                        }
                        $query->where("exp_industry->$key", '=', $exp_industry);
                    }
                }
            })
            ->where(function ($query) use($request) {
                if (!empty($request->exp_position)) {
                    foreach ($request->exp_position as $key => $exp_position) {
                        if (empty($exp_position)) {
                            continue;
                        }
                        $query->where("exp_position->$key", '=', $exp_position);
                    }
                }
            })
            ->where(function ($query) use($request) {
                if (!empty($request->major)) {
                    $query->where('major', 'like', '%'.$request->major.'%');
                }
            })
            ->where(function ($query) use($request) {
                if (!empty($request->hide_get) && $request->hide_get == 1) {
                    $query->where('is_collect', 0);
                }
            })
        ;
    }
}
