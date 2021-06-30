<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;

class CompanysController extends Controller
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
        $companys = Company::where('status', '=', 1)
            // ->where('execute_uid', '=', Auth::user()->id)
            ->withCount('jobs')
            ->where(function ($query) use($request) {
                if (!empty($request->company_name)) {
                    $query->where('name', 'like', '%'.$request->company_name.'%');
                }
            });
        $companys = $companys->paginate($this->pageSize);

        $appends = [
            'name' => $request->company_name
        ];

        return view('companys.list', compact('companys', 'appends'));
    }

    public function store(Request $request)
    {
        $mssages = [
            'name.required' => '请填写 公司名称',
            'nickname.required' => '请填写 对外显示名称',
            'industry.required' => '请选择 所属行业',
            'location.required' => '请选择 所在地',
            'address.required' => '请填写 公司详细地址',
            'nature.required' => '请选择 企业性质',
            'scale.required' => '请选择 企业规模',
            'investment.required' => '请选择 融资阶段',
            'logo.required' => '请上传 公司LOGO',
            'logo.mimes' => '请上传 JPGE/PNG格式的图片且不超过300K',
            'logo.max' => '请上传 JPGE/PNG格式的图片且不超过300K'
        ];

        $this->validate($request, [
            'name' => 'required',
            'nickname' => 'nullable',
            'industry.st' => 'nullable',
            'industry.nd' => 'nullable',
            'industry.rd' => 'nullable',
            'industry.th' => 'nullable',
            'location.province' => 'required',
            'location.city' => 'nullable',
            'location.district' => 'nullable',
            'address' => 'nullable',
            'nature' => 'nullable',
            'scale' => 'nullable',
            'investment' => 'nullable',
            'logo' => 'nullable|mimes:jpeg,jpg,png|max:300',
            'introduction' => 'nullable'
        ], $mssages);

        $filePath = null;
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            if (!$file->isValid()) {
                session()->flash('danger', 'LOGO上传失败');
                return redirect()->back()->withInput();
            }
            $filePath = Storage::disk('company_logo')->putFile(date('Y-m-d').'/'.$request->user()->id, $file);
            unset($file);
        }

        $data = $request->all();
        $data['logo'] = $filePath;
        $company = Company::create($data);

        return redirect()->back();
    }

    public function update(Company $company, Request $request)
    {
        $mssages = [
            'logo.image' => '请上传 JPGE/PNG格式的图片且不超过300K'
        ];

        $this->validate($request, [
            'name' => 'nullable',
            'nickname' => 'nullable',
            'industry' => 'nullable',
            'location' => 'nullable',
            'address' => 'nullable',
            'nature' => 'nullable',
            'scale' => 'nullable',
            'investment' => 'nullable',
            'logo' => 'nullable|mimes:jpeg,png|max:300',
            'introduction' => 'nullable'
        ], $mssages);

        $data = $request->all();
        foreach ($data as $key => $value) {
            if (empty($value)) {
                unset($data[$key]);
            }
        }

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            if (!$file->isValid()) {
                session()->flash('danger', 'LOGO上传失败');
                return redirect()->back()->withInput();
            }
            Storage::disk('company_logo')->delete($company->logo);
            $filePath = Storage::disk('company_logo')->putFile(date('Y-m-d').'/'.$request->user()->id, $file);
            unset($file);
            $data['logo'] = $filePath;
        }

        $company->update($data);

        return redirect()->back();
    }

    public function destroy(Company $company)
    {
        Storage::disk('company_logo')->delete($company->logo);
        $company->delete();
        session()->flash('success', '删除成功');
        return redirect()->back();
    }
}
