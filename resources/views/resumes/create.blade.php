@extends('layouts.default')
@section('title', '上传简历')
@section('content')
<div class="resume-create bg-white">
  <div class="default-form">
    <div class="form-header"></div>
    <hr class="divider">
    <div class="form-body">
      <form class="text-center" method="POST" action="{{ route('resumes.store') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-title text-left">
          <h5>个人基本信息</h5>
        </div>
        <div class="form-group form-inline">
          <label for="name">
            <span class="color-red">*</span>
            姓名：
          </label>
          <input type="text" name="name" class="form-control normal" value="{{ old('name') }}" placeholder="请填写" autocomplete="off">
        </div>
        <div class="form-group form-inline">
          <label for="sex">
            <span class="color-red">*</span>
            性别：
          </label>
          <select name="sex" class="form-control normal" value="{{ old('sex') }}">
            <option hidden value="">请选择</option>
            <option>男</option>
            <option>女</option>
          </select>
        </div>
        <div class="form-group form-inline">
          <label for="age">
            <span class="color-red">*</span>
            年龄：
          </label>
          <input type="text" name="age" class="form-control normal" value="{{ old('age') }}" placeholder="请填写" autocomplete="off" data-type="int">
        </div>
        <div class="form-group form-inline">
          <label for="location">
            <span class="color-red">*</span>
            所在城市：
          </label>
          <div data-toggle="distpicker">
            <select class="form-control" name="location[province]" data-province="---- 选择省 ----"></select>
            <select class="form-control" name="location[city]"  data-city="---- 选择市 ----"></select>
            <select class="form-control" name="location[district]"  data-district="---- 选择区 ----"></select>
          </div>
        </div>
        <div class="form-group form-inline">
          <label for="sex">
            <span class="color-red">*</span>
            工作年限：
          </label>
          <div class="input-group">
            <input type="hidden" name="work_years_flag" value="0">
            <input type="text" name="work_years" class="form-control small append" value="{{ old('work_years') }}" autocomplete="off" data-type="int">
            <div class="input-group-append">
              <div class="input-group-text">年</div>
            </div>
          </div>
          @foreach (App\Models\Resume::workYearsArr as $key => $workYears)
            <div class="custom-control custom-checkbox custom-control-inline ml-3">
              <input type="checkbox" id="work_years_{{ $key }}" class="custom-control-input" onclick="setWorkYears($(this))">
              <label class="custom-control-label" for="work_years_{{ $key }}">{{ $workYears['text'] }}</label>
            </div>
          @endforeach
        </div>
        <div class="form-group form-inline">
          <label for="sex">
            <span class="color-red">*</span>
            教育程度：
          </label>
          <select name="education" class="form-control normal" value="{{ old('education') }}">
            <option hidden value="">请选择</option>
            @foreach (App\Models\Resume::educationArr as $key => $education)
              <option value="{{ $key }}">{{ $education['text'] }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group form-inline">
          <label for="major">所学专业：</label>
          <input type="text" name="major" class="form-control normal" value="{{ old('major') }}" placeholder="请填写" autocomplete="off">
        </div>

        <div class="form-title text-left">
          <h5>联系方式</h5>
        </div>
        <div class="form-group form-inline">
          <label for="phone_num">
            <span class="color-red">*</span>
            手机号码：
          </label>
          <input type="text" name="phone_num" class="form-control normal" value="{{ old('phone_num') }}" placeholder="请填写" autocomplete="off" data-type="int">
        </div>
        <div class="form-group form-inline">
          <label for="email">
            <span class="color-red">*</span>
            电子邮箱：
          </label>
          <input type="text" name="email" class="form-control normal" value="{{ old('email') }}" placeholder="请填写" autocomplete="off">
        </div>
        <div class="form-group form-inline">
          <label for="wechat">
            <span class="color-red">*</span>
            微信：
          </label>
          <input type="text" name="wechat" class="form-control normal" value="{{ old('wechat') }}" placeholder="请填写" autocomplete="off">
        </div>
        <div class="form-group form-inline">
          <label for="qq">
            <span class="color-red">*</span>
            QQ：
          </label>
          <input type="text" name="qq" class="form-control normal" value="{{ old('qq') }}" placeholder="请填写" autocomplete="off" data-type="int">
        </div>

        <div class="form-title text-left">
          <h5>目前职业概况</h5>
        </div>
        <div class="form-group form-inline">
          <label for="cur_industry"><span>*</span>所在行业：</label>
          <div class="input-group" data-toggle="industrypicker">
            <input type="hidden" name="cur_industry[st]">
            <input type="hidden" name="cur_industry[nd]">
            <input type="hidden" name="cur_industry[rd]">
            <input type="hidden" name="cur_industry[th]">
            <input type="text" class="form-control normal append" value="" placeholder="请选择" autocomplete="off">
            <div class="input-group-append" data-toggle="modal" data-target="#industryModal">
              <span class="input-group-text" id="basic-addon2">
                <svg class="bi bi-calendar" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1zm1-3a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2z"/>
                  <path fill-rule="evenodd" d="M3.5 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5zm9 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5z"/>
                </svg>
              </span>
            </div>
          </div>
        </div>
        <div class="form-group form-inline">
          <label for="cur_position"><span>*</span>所任职位：</label>
          <div class="input-group" data-toggle="jobtypepicker">
            <input type="hidden" name="cur_position[st]">
            <input type="hidden" name="cur_position[nd]">
            <input type="hidden" name="cur_position[rd]">
            <input type="text" class="form-control normal append" placeholder="请选择" autocomplete="off">
            <div class="input-group-append" data-toggle="modal" data-target="#jobtypeModal">
              <span class="input-group-text" id="basic-addon2">
                <svg class="bi bi-calendar" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1zm1-3a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2z"/>
                  <path fill-rule="evenodd" d="M3.5 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5zm9 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5z"/>
                </svg>
              </span>
            </div>
          </div>
        </div>
        <div class="form-group form-inline">
          <label for="cur_company">
            <span class="color-red">*</span>
            所在公司：
          </label>
          <input type="text" name="cur_company" class="form-control normal" value="{{ old('cur_company') }}" placeholder="请填写" autocomplete="off">
        </div>
        <div class="form-group form-inline">
          <label for="cur_salary"><span class="color-red">*</span>目前月薪：</label>
          <div class="input-group">
            <input type="text" name="cur_salary" class="form-control small append" value="{{ old('cur_salary') }}" autocomplete="off" data-type="int">
            <div class="input-group-append">
              <div class="input-group-text">K</div>
            </div>
          </div>
          <label class="ml-1 mr-1">*</label>
          <div class="input-group">
            <input type="text" name="cur_salary_count" class="form-control small append" value="{{ old('cur_salary_count') }}" autocomplete="off" data-type="int">
            <div class="input-group-append">
              <div class="input-group-text">月</div>
            </div>
            </div>
        </div>

        <div class="form-title text-left">
          <h5>职业发展意向</h5>
        </div>
        <div class="form-group form-inline">
          <label for="exp_industry"><span>*</span>期望行业：</label>
          <div class="input-group" data-toggle="industrypicker">
            <input type="hidden" name="exp_industry[st]">
            <input type="hidden" name="exp_industry[nd]">
            <input type="hidden" name="exp_industry[rd]">
            <input type="hidden" name="exp_industry[th]">
            <input type="text" class="form-control normal append" placeholder="请选择" autocomplete="off">
            <div class="input-group-append" data-toggle="modal" data-target="#industryModal">
              <span class="input-group-text" id="basic-addon2">
                <svg class="bi bi-calendar" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1zm1-3a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2z"/>
                  <path fill-rule="evenodd" d="M3.5 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5zm9 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5z"/>
                </svg>
              </span>
            </div>
          </div>
        </div>
        <div class="form-group form-inline">
          <label for="exp_position"><span>*</span>期望职位：</label>
          <div class="input-group" data-toggle="jobtypepicker">
            <input type="hidden" name="exp_position[st]">
            <input type="hidden" name="exp_position[nd]">
            <input type="hidden" name="exp_position[rd]">
            <input type="text" class="form-control normal append" placeholder="请选择" autocomplete="off">
            <div class="input-group-append" data-toggle="modal" data-target="#jobtypeModal">
              <span class="input-group-text" id="basic-addon2">
                <svg class="bi bi-calendar" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1zm1-3a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2z"/>
                  <path fill-rule="evenodd" d="M3.5 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5zm9 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5z"/>
                </svg>
              </span>
            </div>
          </div>
        </div>
        <div class="form-group form-inline">
          <label for="exp_work_nature"><span class="color-red">*</span>工作性质：</label>
          <select name="exp_work_nature" class="form-control normal" value="{{ old('exp_work_nature') }}">
            <option value="" hidden>请选择</option>
            @foreach (App\Models\Job::natureArr as $key => $nature)
              <option value="{{ $key }}">{{ $nature['text'] }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group form-inline">
          <label for="exp_location">
            <span class="color-red">*</span>
            期望城市：
          </label>
          <div data-toggle="distpicker">
            <select class="form-control" name="exp_location[province]" data-province="---- 选择省 ----"></select>
            <select class="form-control" name="exp_location[city]"  data-city="---- 选择市 ----"></select>
            <select class="form-control" name="exp_location[district]"  data-district="---- 选择区 ----"></select>
          </div>
        </div>
        <div class="form-group form-inline">
          <label for="exp_salary"><span class="color-red">*</span>期望薪资：</label>
          <input type="hidden" name="exp_salary_flag" value="0">
          <div class="input-group">
            <input type="text" name="exp_salary_min" class="form-control small append" value="{{ old('exp_salary_min') }}" autocomplete="off" data-type="int">
            <div class="input-group-append">
              <div class="input-group-text">K</div>
            </div>
          </div>
          <label class="ml-1 mr-1">-</label>
          <div class="input-group">
            <input type="text" name="exp_salary_max" class="form-control small append" value="{{ old('exp_salary_max') }}" autocomplete="off" data-type="int">
            <div class="input-group-append">
              <div class="input-group-text">K</div>
            </div>
          </div>
          <label class="ml-1 mr-1">*</label>
          <div class="input-group">
            <input type="text" name="exp_salary_count" class="form-control small append" value="{{ old('exp_salary_count') }}" autocomplete="off" data-type="int">
            <div class="input-group-append">
              <div class="input-group-text">月</div>
            </div>
          </div>
          <div class="custom-control custom-checkbox custom-control-inline ml-3">
            <input type="checkbox" id="expSalaryDiscuss" class="custom-control-input" onclick="setExpSalary($(this))">
            <label class="custom-control-label" for="expSalaryDiscuss">面议</label>
          </div>
        </div>

        <div class="form-title text-left">
          <h5>工作经历</h5>
        </div>
        <div class="form-group form-inline">
          <label for="work_experience[0][company_name]">
            <span class="color-red">*</span>
            公司名称：
          </label>
          <input type="text" name="work_experience[0][company_name]" class="form-control normal" placeholder="请填写" autocomplete="off">
        </div>
        <div class="form-group form-inline">
          <label for="work_experience[0][company_nature]">
            <span class="color-red">*</span>
            公司性质：
          </label>
          <select name="work_experience[0][company_nature]" class="form-control normal">
            <option hidden value="">请选择</option>
            @foreach (App\Models\Company::natureArr as $key => $nature)
              <option value="{{ $key }}">{{ $nature['text'] }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group form-inline">
          <label for="work_experience[0][company_scale]">
            <span class="color-red">*</span>
            公司规模：
          </label>
          <select name="work_experience[0][company_scale]" class="form-control normal">
            <option hidden value="">请选择</option>
            @foreach (App\Models\Company::scaleArr as $key => $scale)
              <option value="{{ $key }}">{{ $scale['text'] }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group form-inline">
          <label for="work_experience[0][company_industry]"><span>*</span>所属行业：</label>
          <div class="input-group" data-toggle="industrypicker">
            <input type="hidden" name="work_experience[0][company_industry][st]">
            <input type="hidden" name="work_experience[0][company_industry][nd]">
            <input type="hidden" name="work_experience[0][company_industry][rd]">
            <input type="hidden" name="work_experience[0][company_industry][th]">
            <input type="text" class="form-control normal append" value="" placeholder="请选择" autocomplete="off">
            <div class="input-group-append" data-toggle="modal" data-target="#industryModal">
              <span class="input-group-text" id="basic-addon2">
                <svg class="bi bi-calendar" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1zm1-3a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2z"/>
                  <path fill-rule="evenodd" d="M3.5 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5zm9 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5z"/>
                </svg>
              </span>
            </div>
          </div>
        </div>
        <div class="form-group form-inline">
          <label for="work_experience[0][job_type]">职位名称：</label>
          <div class="input-group" data-toggle="jobtypepicker">
            <input type="hidden" name="work_experience[0][job_type][st]">
            <input type="hidden" name="work_experience[0][job_type][nd]">
            <input type="hidden" name="work_experience[0][job_type][rd]">
            <input type="text" class="form-control normal append" placeholder="请选择" autocomplete="off">
            <div class="input-group-append" data-toggle="modal" data-target="#jobtypeModal">
              <span class="input-group-text" id="basic-addon2">
                <svg class="bi bi-calendar" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1zm1-3a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2z"/>
                  <path fill-rule="evenodd" d="M3.5 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5zm9 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5z"/>
                </svg>
              </span>
            </div>
          </div>
        </div>
        <div class="form-group form-inline">
          <label for="work_experience[0][start_at]"><span class="color-red">*</span>在职时间：</label>
          <div class="input-group date datetimepicker">
            <input type="text" name="work_experience[0][start_at]" class="form-control mini append" placeholder="入职时间" autocomplete="off">
            <div class="input-group-append">
              <span class="input-group-text">
                <svg class="bi bi-calendar3-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2H0z"/>
                  <path fill-rule="evenodd" d="M0 3h16v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3zm6.5 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-8 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-8 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                </svg>
              </span>
            </div>
          </div>
          <label class="ml-1 mr-1">——</label>
          <div class="input-group date datetimepicker">
            <input type="text" name="work_experience[0][end_at]" class="form-control mini append" placeholder="离职时间" autocomplete="off">
            <div class="input-group-append">
              <span class="input-group-text">
                <svg class="bi bi-calendar3-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2H0z"/>
                  <path fill-rule="evenodd" d="M0 3h16v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3zm6.5 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-8 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-8 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                </svg>
              </span>
            </div>
          </div>
          <div class="custom-control custom-checkbox custom-control-inline ml-3">
            <input type="checkbox" name="work_experience[0][is_end]" id="workAtNow" class="custom-control-input" onclick="setNotEnd($(this))">
            <label class="custom-control-label" for="workAtNow">至今</label>
          </div>
        </div>
        <div class="form-group form-inline">
          <label for="work_experience[0][work_desc]">
            <span class="color-red">*</span>
            工作描述：
          </label>
          <textarea name="work_experience[0][work_desc]" class="form-control normal"></textarea>
        </div>

        <div class="form-title text-left">
          <h5>教育经历</h5>
        </div>
        <div class="form-group form-inline">
          <label for="eduction_experience[0][school_name]">
            <span class="color-red">*</span>
            毕业院校：
          </label>
          <input type="text" name="eduction_experience[0][school_name]" class="form-control normal" placeholder="请填写" autocomplete="off">
        </div>
        <div class="form-group form-inline">
          <label for="eduction_experience[0][school_level]">
            <span class="color-red">*</span>
            最高学历：
          </label>
          <select name="eduction_experience[0][school_level]" class="form-control normal">
            <option hidden value="">请选择</option>
            @foreach (App\Models\Resume::educationArr as $key => $education)
              <option value="{{ $key }}">{{ $education['text'] }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group form-inline">
          <label for="eduction_experience[0][major]">
            所学专业：
          </label>
          <input type="text" name="eduction_experience[0][major]" class="form-control normal" placeholder="请填写" autocomplete="off">
        </div>
        <div class="form-group form-inline">
          <label for="eduction_experience[0][start_at]">
            <span class="color-red">*</span>
            在校时间：
          </label>
          <div class="input-group date datetimepicker">
            <input type="text" name="eduction_experience[0][start_at]" class="form-control mini append" placeholder="入职时间" autocomplete="off">
            <div class="input-group-append">
              <span class="input-group-text">
                <svg class="bi bi-calendar3-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2H0z"/>
                  <path fill-rule="evenodd" d="M0 3h16v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3zm6.5 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-8 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-8 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                </svg>
              </span>
            </div>
          </div>
          <label class="ml-1 mr-1">——</label>
          <div class="input-group date datetimepicker">
            <input type="text" name="eduction_experience[0][end_at]" class="form-control mini append" placeholder="离职时间" autocomplete="off">
            <div class="input-group-append">
              <span class="input-group-text">
                <svg class="bi bi-calendar3-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2H0z"/>
                  <path fill-rule="evenodd" d="M0 3h16v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3zm6.5 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-8 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-8 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                </svg>
              </span>
            </div>
          </div>
          <div class="custom-control custom-checkbox custom-control-inline ml-3">
            <input type="checkbox" name="eduction_experience[0][is_end]" id="eductionAtNow" class="custom-control-input" onclick="setNotEnd($(this))">
            <label class="custom-control-label" for="eductionAtNow">至今</label>
          </div>
        </div>

        <div class="form-title text-left">
          <h5>附加信息</h5>
        </div>
        <div class="form-group form-inline">
          <label for="social_home">
            社交主页：
          </label>
          <input type="text" name="social_home" class="form-control normal" placeholder="请填写" autocomplete="off">
        </div>
        <div class="form-group form-inline">
          <label for="personal_advantage">
            个人优势：
          </label>
          <textarea name="personal_advantage" class="form-control normal" placeholder="请填写"></textarea>
        </div>
        <div class="form-group form-inline">
          <label for="attachment">
            简历附件：
          </label>
          <input hidden type="file" multiple="true" name="attachment">
          <input type="text" class="form-control normal" id="inputAppend" placeholder="请添加" onclick="setAppend()" readonly style="cursor: pointer;">
        </div>
        <div class="form-group form-inline">
          <label for="jobhunter_status">
            求职状态：
          </label>
          <select name="jobhunter_status" class="form-control normal" value="{{ old('jobhunter_status') }}">
            <option hidden value="">请选择</option>
            @foreach (App\Models\Resume::jobhunterStatusArr as $key => $jobhunterStatus)
              <option value="{{ $key }}">{{ $jobhunterStatus['text'] }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group form-inline">
          <label for="blacklist">
            屏蔽公司：
          </label>
          <input type="text" name="blacklist" class="form-control normal" placeholder="请填写" autocomplete="off">
        </div>
        <div class="form-group form-inline">
          <label for="remark">
            其他备注：
          </label>
          <textarea name="remark" class="form-control normal" placeholder="请填写"></textarea>
        </div>

        <div class="form-title text-left">
          <h5>来源渠道</h5>
        </div>
        <div class="form-group form-inline">
          <label for="source">
            <span class="color-red">*</span>
            渠道选择：
          </label>
          @foreach (App\Models\Job::channelArr as $key => $channel)
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" class="custom-control-input" id="channel_{{ $key }}" name="source[{{ $key }}]"
                  @if (!empty($channel['checked']))
                    checked
                  @endif
                  @if (isset($channel['has_remark']) && $channel['has_remark'])
                    onclick='setRemark()'
                  @endif
                >
                <label class="custom-control-label" for="channel_{{ $key }}">{{ $channel['text'] }}</label>
            </div>
          @endforeach
          <input style="visibility: hidden;" type="text" name="source_remarks" class="form-control" id="channelRemark" placeholder="请选择招聘平台">
        </div>
        <div class="form-group form-inline">
          <label for="job_id">
            添加到"我的职位"：
          </label>
          <select name="job_id" class="form-control normal">
            <option hidden value="">请选择</option>
            @foreach($jobs as $job)
              <option value="{{ $job->id }}">{{ $job->name }}</option>
            @endforeach
          </select>
        </div>

        <button type="submit" class="btn btn-danger btn-form-submit">保存简历并上传</button>
      </form>
    </div>
  </div>
</div>

@include('shared._industry')
@include('shared._job_type')
@include('shared._errors')

<script type="text/javascript">
  function setExpSalary(e)
  {
    let flag = 0;
    if (e.is(':checked')) {
      flag = 1;
      $('input[name="exp_salary_min"]').attr("disabled", true);
      $('input[name="exp_salary_max"]').attr("disabled", true);
      $('input[name="exp_salary_count"]').attr("disabled", true);
    } else {
      flag = 0;
      $('input[name="exp_salary_min"]').attr("disabled", false);
      $('input[name="exp_salary_max"]').attr("disabled", false);
      $('input[name="exp_salary_count"]').attr("disabled", false);
    }
    $('input[name="exp_salary_flag"]').val(flag);
  }

  function setWorkYears(e)
  {
    let flag = 0;
    @foreach (App\Models\Resume::workYearsArr as $key => $workYears)
      if (e.attr('id') == 'work_years_{{ $key }}') {
        flag = {{ $key }};
      } else {
        $('#work_years_{{ $key }}').prop('checked', false);
      }
    @endforeach
    if (e.is(':checked')) {
      flag = 1;
      $('input[name="work_years"]').attr("disabled", true);
    } else {
      flag = 0;
      $('input[name="work_years"]').attr("disabled", false);
    }
    $('input[name="work_years_flag"]').val(flag);
  }

  function setAppend()
  {
    $('input[name="attachment"]').click();
  }

  function setRemark()
  {
    let checked = $('#channel_other_platform').is(':checked');
    if (checked == true) {
      $('#channelRemark').css('visibility', 'visible');
    } else {
      $('#channelRemark').css('visibility', 'hidden');
    }
  }

  function setNotEnd(e)
  {
    if (e.is(':checked')) {
      e.closest('.form-group').find('input[type="text"]').last().attr('disabled', true);
      // e.closest('.form-group').find('input[type="text"]').last().val('');
    } else {
      e.closest('.form-group').find('input[type="text"]').attr('disabled', false);
    }
  }

  $('input[name="attachment"]').change(function() {
    $('#inputAppend').val($(this).val());
  });
</script>
@stop
