@extends('layouts.default')
@section('title', '上传简历')
@section('content')
<div class="offset-md-2 col-md-8">
    <div class="card ">
    <div class="card-header">
    <h5>上传简历</h5>
</div>
<div class="card-body">
    @include('shared._errors')
    <form method="POST" action="{{ route('resumes.store') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">姓名：</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" />
        </div>
        <div class="form-group">
            <label for="sex">性别：</label>
            <select name="sex" class="form-control" value="{{ old('sex') }}">
                <option value="男">男</option>
                <option value="女">女</option>
            </select>
        </div>
        <div class="form-group">
            <label for="age">年龄：</label>
            <select name="age" class="form-control" value="{{ old('age') }}">
                @for($i = 18; $i <= 65; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>
        <div class="form-group">
            <label for="city">所在城市：</label>
            <input type="text" name="city" class="form-control" value="{{ old('city') }}" />
        </div>
        <div class="form-group">
            <label for="work_years">工作年限:</label>
            <select name="work_years" class="form-control" value="{{ old('work_years') }}">
                @foreach($workYears as $key => $workYear)
                <option value="{{ $key }}">{{ $workYear }}</option>
                @endforeach
                @for($i = 1; $i <= 30; $i++)
                    <option value="{{ $i }}">{{ $i }}年</option>
                @endfor
            </select>
        </div>
        <div class="form-group">
            <label for="education">教育程度:</label>
            <select name="education" class="form-control" value="{{ old('education') }}">
                @foreach($educations as $education)
                    <option value="{{ $education }}">{{ $education }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="phone_num">手机号:</label>
            <input type="text" name="phone_num" class="form-control" value="{{ old('phone_num') }}" />
        </div>
        <div class="form-group">
            <label for="email">邮件:</label>
            <input type="text" name="email" class="form-control" value="{{ old('email') }}" />
        </div>
        <div class="form-group">
            <label for="wechat_or_qq">微信/QQ:</label>
            <input type="text" name="wechat_or_qq" class="form-control" value="{{ old('wechat_or_qq') }}" />
        </div>
        <div class="form-group">
            <label for="cur_industry">所在行业:</label>
            <input type="text" name="cur_industry" class="form-control" value="{{ old('cur_industry') }}" />
        </div>
        <div class="form-group">
            <label for="cur_position">所在职位:</label>
            <input type="text" name="cur_position" class="form-control" value="{{ old('cur_position') }}" />
        </div>
        <div class="form-group">
            <label for="cur_company">所在公司:</label>
            <input type="text" name="cur_company" class="form-control" value="{{ old('cur_company') }}" />
        </div>
        <div class="form-group">
            <label for="cur_salary">目前月薪:</label>
            <select name="cur_salary" class="form-control" value="{{ old('cur_salary') }}">
                @for($i = 0; $i <= 250; $i++)
                <option value="{{ $i }}">{{ $i }}K</option>
                @endfor
            </select>
        </div>
        <div class="form-group">
            <label for="exp_industry">期望行业:</label>
            <input type="text" name="exp_industry" class="form-control" value="{{ old('exp_industry') }}" />
        </div>
        <div class="form-group">
            <label for="exp_position">期望职位:</label>
            <input type="text" name="exp_position" class="form-control" value="{{ old('exp_position') }}" />
        </div>
        <div class="form-group">
            <label for="exp_work_nature">工作性质:</label>
            <select name="exp_work_nature" class="form-control" value="{{ old('exp_work_nature') }}">
                @foreach($workNatures as $workNature)
                    <option value="{{ $workNature }}">{{ $workNature }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="exp_city">期望城市:</label>
            <input type="text" name="exp_city" class="form-control" value="{{ old('exp_city') }}" />
        </div>
        <div class="form-group">
            <label for="exp_salary">期望薪资:</label>
            <select name="exp_salary" class="form-control" value="{{ old('exp_salary') }}">
                <option value="-1">面议</option>
                @for($i = 1; $i <= 250; $i++)
                <option value="{{ $i }}">{{ $i }}K</option>
                @endfor
            </select>
        </div>
        <div class="form-group">
            <label for="jobhunter_status">求职者状态:</label>
            <select name="jobhunter_status" class="form-control" value="{{ old('jobhunter_status') }}">
                @foreach($jobhunterStatus as $index => $value)
                    <option value="{{ $index }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="source">来源渠道:</label>
            <select id="source" name="source" class="form-control" value="{{ old('source') }}">
                @foreach($sources as $index => $value)
                    <option value="{{ $index }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="source_remarks">备注:</label>
            <input type="text" name="source_remarks" class="form-control" value="{{ old('source_remarks') }}" />
        </div>
        <div class="form-group">
            <label for="file">简历附件:</label>
            <input type="file" name="file" class="form-control" />
        </div>

        <button type="submit" class="btn btn-primary">上传简历</button>
    </form>
</div>

<script type="text/javascript">
    // $("#source").select(function() {
    //     $("#source").after(" Text marked!");
    // });
</script>>
