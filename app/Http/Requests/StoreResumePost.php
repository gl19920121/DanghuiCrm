<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResumePost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'avatar.mimes' => '请上传 JPGE/PNG格式的图片且不超过2M',
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
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
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
            'work_experience.*.start_at' => 'required|date_format:Y-m',
            'work_experience.*.end_at' => 'required_without:work_experience.*.is_not_end|date_format:Y-m',
            'work_experience.*.is_not_end' => 'filled',
            'work_experience.*.work_desc' => 'required',
            'project_experience' => 'nullable|array',
            'project_experience.*.name' => 'nullable',
            'project_experience.*.role' => 'nullable',
            'project_experience.*.start_at' => 'nullable|date_format:Y-m',
            'project_experience.*.end_at' => 'nullable|date_format:Y-m',
            'project_experience.*.is_not_end' => 'filled',
            'project_experience.*.body' => 'nullable',
            'education_experience' => 'required|array',
            'education_experience.*.school_name' => 'required',
            'education_experience.*.school_level' => 'required',
            'education_experience.*.major' => 'nullable',
            'education_experience.*.start_at' => 'nullable|date_format:Y-m',
            'education_experience.*.end_at' => 'nullable|date_format:Y-m',
            'education_experience.*.is_not_end' => 'filled',
            'social_home' => 'nullable',
            'personal_advantage' => 'nullable',
            'attachment' => 'nullable|file|mimes:doc,docx',
            'jobhunter_status' => 'nullable|numeric',
            'blacklist' => 'nullable',
            'remark' => 'nullable',
            'source' => 'required',
            'source_remarks' => 'nullable|string|max:255',
        ];
    }
}
