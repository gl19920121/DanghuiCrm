<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticlePost extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required'],
            'cover' => ['required', 'mimes:jpeg,jpg,png'],
            'brief' => ['nullable'],
            'type_no' => ['required'],
            'publisher_id' => ['required'],
            'content' => ['required'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => '请填写标题',
            'cover.required' => '请上传封面',
            'cover.mimes' => '请上传JPGE/PNG格式的图片',
            'type_no.required' => '请选择分类',
            'publisher_id.required' => '请选择发布人',
            'content.required' => '请填写正文',
        ];
    }
}
