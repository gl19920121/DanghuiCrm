<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Job;

class UpdateJobPost extends FormRequest
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
            'company_id.required' => '请填写 公司名称',
            'quota.numeric' => '请正确输入 招聘人数',
            'name.required' => '请填写 职位名称',
            'type.st.required' => '请选择 职位类别',
            'type.nd.required' => '请选择 职位类别',
            'type.rd.required' => '请选择 职位类别',
            'nature.required' => '请选择 工作性质',
            'location.*.province.required' => '请选择 工作城市',
            'location.*.city.required' => '请选择 工作城市',
            'location.*.district.required' => '请选择 工作城市',
            'salary_min.required' => '请填写 税前月薪',
            'salary_min.numeric' => '请正确填写 税前月薪',
            'salary_max.required' => '请填写 税前月薪',
            'salary_max.numeric' => '请正确填写 税前月薪',
            'welfare.required' => '请选择 福利待遇',
            'age_min.required' => '请选择 年龄范围',
            'age_min.numeric' => '请选择 年龄范围',
            'age_max.required' => '请选择 年龄范围',
            'age_max.numeric' => '请选择 年龄范围',
            'education.required' => '请填写 学历要求',
            'experience.required' => '请填写 经验要求',
            'duty.required' => '请填写 工作职责',
            'requirement.required' => '请填写 任职要求',
            'urgency_level.required' => '请选择 紧急程度',
            'channel.required' => '请选择 渠道',
            'deadline.required' => '请填写 截止日期',
            'heat.required' => '请选择 热度',
            'tag.required' => '请选择 职位类型',
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
            'company_id' => 'required',
            'quota' => [
                'nullable',
                function($attribute, $value, $fail) {
                    if (!is_numeric($value) && $value !== '若干') {
                        return $fail('请正确输入 招聘人数');
                    }
                },
            ],
            'name' => 'required|string',
            'type.st' => 'required',
            'type.nd' => 'required',
            'type.rd' => 'required',
            'nature' => [
                'required', Rule::in(array_keys(trans('db.job.nature')))
            ],
            'location.*.province' => ['required'],
            'location.*.city' => ['required'],
            'location.*.district' => ['nullable'],
            'location.*.address' => ['nullable'],
            'salary_min' => 'required|numeric',
            'salary_max' => 'required|numeric',
            'welfare' => [
                'required', Rule::in(array_keys(trans('db.welfare')))
            ],
            'sparkle' => 'nullable|string',
            'age_min' => 'required|numeric',
            'age_max' => 'required|numeric',
            'education' => [
                'required', Rule::in(array_keys(trans('db.education')))
            ],
            'experience' => [
                'required', Rule::in(array_keys(trans('db.experience')))
            ],
            'duty' => 'required',
            'requirement' => 'required|string',
            'urgency_level' => [
                'required', Rule::in(array_keys(trans('db.job.urgency_level')))
            ],
            'channel' => 'required',
            'channel_remark' => 'nullable|string',
            'deadline' => 'required|date',
            'tag' => ['required', 'array'],
            'heat' => ['required', 'boolean'],
        ];
    }
}
