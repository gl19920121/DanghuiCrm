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
use Auth;
use DateTime;
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
        // return dd($request->job_id);
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
            ->has('user')
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

    public function show(Resume $resume)
    {
        $jobs = Job::where('status', '=', 1)->where('execute_uid', '=', Auth::user()->id)->get();
        $this->doOperation($resume->id, Auth::user()->id, 'seen');
        return view('resumes.show', compact('resume', 'jobs'));
    }

    public function operation(Resume $resume, Request $request)
    {
        $resumeId = $resume->id;
        $userId = $request->user_id;
        $type = $request->type;

        $this->doOperation($resumeId, $userId, $type);

        return back();
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
        // unset($file);

        // $api = new APIHelper(config('public.resumesdk'));
        // $file_cont = Storage::disk('resume')->get($filePath);
        // $file_cont = base64_encode($file_cont);
        // $body = [
        //     'file_name' => storage_path('resume/'.$filePath),
        //     'file_cont' => $file_cont,
        //     'need_avatar' => 0,
        //     'ocr_type' => 1
        // ];
        // $body = json_encode($body, JSON_UNESCAPED_UNICODE);
        // $res = $api->post($body, 'ResumeParser');
        // $data = json_decode($res);
        // return dd($data);

        // $api = new APIHelper();
        // $res = $api->resumesdk($filePath);
        // return dd($res);

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
        $data['source'] = json_encode(array_keys($data['source']));

        $work = $data['work_experience'];
        $project = $data['project_experience'];
        $education = $data['education_experience'];

        unset($data['work_experience']);
        unset($data['project_experience']);
        unset($data['education_experience']);

        // db insert
        $resume = Resume::create($data);

        foreach ($work as $key => $value) {
            $work[$key]['resume_id'] = $resume->id;
            $work[$key]['company_industry'] = json_encode($value['company_industry']);
            $work[$key]['job_type'] = json_encode($value['job_type']);
            $work[$key]['is_not_end'] = (isset($value['is_not_end']) && $value['is_not_end'] === 'on') ? 1 : 0;
            unset($work[$key]['is_end']);
        }
        foreach ($project as $key => $value) {
            $project[$key]['resume_id'] = $resume->id;
            $project[$key]['is_not_end'] = (isset($value['is_not_end']) && $value['is_not_end'] === 'on') ? 1 : 0;
            unset($project[$key]['is_end']);
        }
        foreach ($education as $key => $value) {
            $education[$key]['resume_id'] = $resume->id;
            $education[$key]['is_not_end'] = (isset($value['is_not_end']) && $value['is_not_end'] === 'on') ? 1 : 0;
            unset($education[$key]['is_end']);
        }
        // array_walk($project, function(&$v, $k, $p) {
        //     $v = array_merge($v, $p);
        // }, ['resume_id' => $resume->id]);
        // array_walk($education, function(&$v, $k, $p) {
        //     $v = array_merge($v, $p);
        // }, ['resume_id' => $resume->id]);

        $resumeWork = ResumeWork::insert($work);
        $resumePrj = ResumePrj::insert($project);
        $resumeEdu = ResumeEdu::insert($education);

        // 返回
        return redirect()->route('resumes.list');
    }

    public function update(Resume $resume, Request $request)
    {
        $data = $request->toArray();

        if (isset($request->attachment)) {
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
            unset($data['attachment']);
            $data['attachment_path'] = $filePath;
        }

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if ($key === 'source') {
                    $data[$key] = json_encode(array_keys($value));
                } else {
                    $data[$key] = json_encode($value);
                }
            }
        }

        // 格式化db字段
        // $data['location'] = json_encode($data['location']);
        // $data['cur_industry'] = json_encode($data['cur_industry']);
        // $data['cur_position'] = json_encode($data['cur_position']);
        // $data['exp_industry'] = json_encode($data['exp_industry']);
        // $data['exp_position'] = json_encode($data['exp_position']);
        // $data['exp_location'] = json_encode($data['exp_location']);
        // $data['source'] = json_encode($data['source']);

        // $work = $data['work_experience'];
        // $project = $data['project_experience'];
        // $education = $data['education_experience'];

        unset($data['work_experience']);
        unset($data['project_experience']);
        unset($data['education_experience']);

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

    private function doOperation($resumeId, $userId, $type)
    {
        $resumeUser = ResumeUser::where('resume_id', $resumeId)->where('user_id', $userId)->where('type', $type)->first();

        if (empty($resumeUser)) {
            $data = [
                'resume_id' => $resumeId,
                'user_id' => $userId,
                'type' => $type
            ];

            ResumeUser::create($data);
        } else {
            if ($type === 'seen') {
                $resumeUser->updated_at = new DateTime();
                $resumeUser->save();
            }
            if ($type === 'collect') {
                $resumeUser->delete();
            }
        }
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
