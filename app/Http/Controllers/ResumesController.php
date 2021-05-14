<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resume;
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
        $educations = ['高中', '专科', '本科', '硕士', '博士'];
        $workYears = [
            '-1' => '学生在读',
            '-2' => '应届毕业生'
        ];
        $workNatures = ['全职', '兼职', '全职兼职'];
        $jobhunterStatus = ['在职-暂不考虑', '在职-考虑机会', '在职-月内到岗', '离职-随时到岗'];
        $sources = ['招聘平台', '小程序', '当会官网', '其他'];

        $jobs = Job::where('execute_uid', '=', Auth::user()->id)->get();

        return view('resumes.create', compact('educations', 'workYears', 'workNatures', 'jobhunterStatus', 'sources', 'jobs'));
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
            'name' => 'required|string|max:255',
            'sex' => 'required|string|max:2',
            'age' => 'required|numeric',
            'city' => 'required|string|max:255',
            // 'work_years_flag' => 'required|numeric',
            'work_years' => 'nullable|numeric',
            'education' => 'required|string|max:255',
            'phone_num' => 'required|numeric',
            'email' => 'required|email|max:255',
            'wechat_or_qq' => 'required|string|max:255',
            'cur_industry' => 'required|string|max:255',
            'cur_position' => 'required|string|max:255',
            'cur_company' => 'required|string|max:255',
            'cur_salary' => 'required|numeric',
            'exp_industry' => 'required|string|max:255',
            'exp_position' => 'required|string|max:255',
            'exp_work_nature' => 'required|string|max:255',
            'exp_city' => 'required|string|max:255',
            // 'exp_salary_flag' => 'required|numeric',
            'exp_salary' => 'required|numeric',
            'jobhunter_status' => 'required|numeric',
            'source' => 'required|numeric',
            'source_remarks' => 'nullable|string|max:255',
            'file' => 'required|file|mimes:doc,docx'
        ]);

        // 简历文件存储
        $file = $request->file('file');
        if(!$request->hasFile('file') || !$file->isValid()) {
            session()->flash('danger', '简历上传失败');
            return redirect()->back()->withInput();
        }
        $filePath = $file->store(date('Y-m-d').'/'.$request->user()->id, 'resume');
        unset($file);

        // 格式化db字段
        $data = $request->toArray();
        if($data['work_years'] < 0) {
            $data['work_years_flag'] = abs($data['work_years']);
            unset($data['work_years']);
        } else {
            $data['work_years_flag'] = 0;
        }
        if($data['exp_salary'] < 0) {
            $data['exp_salary_flag'] = abs($data['exp_salary']);
            unset($data['exp_salary']);
        } else {
            $data['exp_salary_flag'] = 0;
        }
        unset($data['file']);
        unset($data['edu']);
        unset($data['work']);
        unset($data['prj']);
        $data['upload_uid'] = Auth::user()->id;
        $data['attachment_path'] = $filePath;

        // db insert
        $resume = Resume::create($data);

        // 返回
        session()->flash('success', '简历上传成功');
        return redirect()->route('home');
        //return redirect()->route('resumes.show', [$resume]);
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
