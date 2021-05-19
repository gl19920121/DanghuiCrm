<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanysController extends Controller
{
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
            'logo.image' => '请上传 JPGE/PNG格式的图片且不超过300K',
            'introduction.required' => '请填写 企业介绍'
        ];

        $this->validate($request, [
            'name' => 'required',
            'nickname' => 'required',
            'industry' => 'required',
            'location' => 'required',
            'address' => 'required',
            'nature' => 'required',
            'scale' => 'required',
            'investment' => 'required',
            'logo' => 'required|mimes:jpeg,png|max:300',
            'introduction' => 'required'
        ], $mssages);

        $file = $request->file('logo');
        if(!$request->hasFile('logo') || !$file->isValid()) {
            session()->flash('danger', 'LOGO上传失败');
            return redirect()->back()->withInput();
        }
        $filePath = $file->store('logo/'.date('Y-m-d').'/'.$request->user()->id, 'company');
        unset($file);

        $data = $request->all();
        $data['logo'] = $filePath;
        $data['industry'] = json_encode($data['industry']);
        $data['location'] = json_encode($data['location']);
        $company = Company::create($data);

        return redirect()->back();
    }
}
