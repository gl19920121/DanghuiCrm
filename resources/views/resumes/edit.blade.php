@extends('layouts.default')
@section('title', '编辑简历')
@section('content')
<div class="resume-create-form bg-white">
  <div class="default-form">
    <div class="form-header"></div>
    <hr class="divider">
    <div class="form-body">
      <form class="text-center" method="POST" action="{{ route('resumes.update', $resume) }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <div class="form-title text-left">
          <h5>个人基本信息</h5>
        </div>
        <div class="form-group form-inline">
          <label for="avatar">头像：</label>
          <div data-toggle="filechoose" data-type="avatar" data-size="normal">
            <img src="{{ $resume->avatar_url }}" class="rounded-circle resume-avatar">
            <input hidden type="file" multiple="true" accept="image/png, image/jpeg" name="avatar" class="form-control middle">
          </div>
        </div>
        <div class="form-group form-inline">
          <label for="name">
            <span class="color-red">*</span>
            姓名：
          </label>
          <input type="text" name="name" class="form-control normal" value="{{ $resume->name }}" placeholder="请填写" autocomplete="off">
        </div>
        <div class="form-group form-inline">
          <label for="sex">
            <span class="color-red">*</span>
            性别：
          </label>
          <select name="sex" class="form-control normal">
            <option hidden value="">请选择</option>
            <option
            @if ($resume->sex === '男')
              selected
            @endif
            >
              男
            </option>
            <option
            @if ($resume->sex === '女')
              selected
            @endif
            >
              女
            </option>
          </select>
        </div>
        <div class="form-group form-inline">
          <label for="age">
            <span class="color-red">*</span>
            年龄：
          </label>
          <input type="text" name="age" class="form-control normal" value="{{ $resume->age }}" placeholder="请填写" autocomplete="off" data-type="int">
        </div>
        <div class="form-group form-inline">
          <label for="location">
            <span class="color-red">*</span>
            所在城市：
          </label>
          <div data-toggle="distpicker">
            <select class="form-control" name="location[province]" data-province="{{ $resume->location['province'] }}"></select>
            <select class="form-control" name="location[city]"  data-city="{{ $resume->location['city'] }}"></select>
            <select class="form-control" name="location[district]"  data-district="{{ $resume->location['district'] }}"></select>
          </div>
        </div>
        <div class="form-group form-inline">
          <label for="sex">
            <span class="color-red">*</span>
            工作年限：
          </label>
          <div class="input-group">
            <input type="hidden" name="work_years_flag" value="{{ $resume->work_years_flag }}">
            <input type="text" name="work_years" class="form-control small append" value="{{ $resume->work_years }}" autocomplete="off" data-type="int"
              @if ($resume->work_years_flag !== 0)
                disabled
              @endif
            >
            <div class="input-group-append">
              <div class="input-group-text">年</div>
            </div>
          </div>
          @foreach (trans('db.resume.work_years') as $key => $workYears)
            <div class="custom-control custom-checkbox custom-control-inline ml-3">
              <input type="checkbox" id="work_years_{{ $key }}" class="custom-control-input" onchange="setWorkYears($(this))"
              @if ($resume->work_years_flag === $key)
                checked
              @endif>
              <label class="custom-control-label" for="work_years_{{ $key }}">{{ $workYears }}</label>
            </div>
          @endforeach
        </div>
        <div class="form-group form-inline">
          <label for="sex">
            <span class="color-red">*</span>
            教育程度：
          </label>
          <select name="education" class="form-control normal">
            <option hidden value="">请选择</option>
            @foreach (trans('db.education') as $key => $education)
              <option value="{{ $key }}"
              @if ($resume->education === $key)
                selected
              @endif>
                {{ $education }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="form-group form-inline">
          <label for="major">所学专业：</label>
          <input type="text" name="major" class="form-control normal" value="{{ $resume->major }}" placeholder="请填写" autocomplete="off">
        </div>

        <div class="form-title text-left">
          <h5>联系方式</h5>
        </div>
        <div class="form-group form-inline">
          <label for="phone_num">
            <span class="color-red">*</span>
            手机号码：
          </label>
          <input type="text" name="phone_num" class="form-control normal" value="{{ $resume->phone_num }}" placeholder="请填写" autocomplete="off" data-type="int">
        </div>
        <div class="form-group form-inline">
          <label for="email">
            <span class="color-red">*</span>
            电子邮箱：
          </label>
          <input type="text" name="email" class="form-control normal" value="{{ $resume->email }}" placeholder="请填写" autocomplete="off">
        </div>
        <div class="form-group form-inline">
          <label for="wechat">
            微信：
          </label>
          <input type="text" name="wechat" class="form-control normal" value="{{ $resume->wechat }}" placeholder="请填写" autocomplete="off">
        </div>
        <div class="form-group form-inline">
          <label for="qq">
            QQ：
          </label>
          <input type="text" name="qq" class="form-control normal" value="{{ $resume->qq }}" placeholder="请填写" autocomplete="off" data-type="int">
        </div>

        <div class="form-title text-left">
          <h5>目前职业概况</h5>
        </div>
        <div class="form-group form-inline">
          <label for="cur_industry">所在行业：</label>
          <div class="input-group" data-toggle="industrypicker">
            <input type="hidden" name="cur_industry[st]" value="{{ $resume->cur_industry['st'] }}">
            <input type="hidden" name="cur_industry[nd]" value="{{ $resume->cur_industry['nd'] }}">
            <input type="hidden" name="cur_industry[rd]" value="{{ $resume->cur_industry['rd'] }}">
            <input type="hidden" name="cur_industry[th]" value="{{ $resume->cur_industry['th'] }}">
            <input type="text" class="form-control normal append" value="{{ $resume->cur_industry_show }}" placeholder="请选择" autocomplete="off">
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
          <label for="cur_position">所任职位：</label>
          <div class="input-group" data-toggle="jobtypepicker">
            <input type="hidden" name="cur_position[st]" value="{{ $resume->cur_position['st'] }}">
            <input type="hidden" name="cur_position[nd]" value="{{ $resume->cur_position['nd'] }}">
            <input type="hidden" name="cur_position[rd]" value="{{ $resume->cur_position['rd'] }}">
            <input type="text" class="form-control normal append" value="{{ $resume->cur_position_show }}" placeholder="请选择" autocomplete="off">
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
            所在公司：
          </label>
          <input type="text" name="cur_company" class="form-control normal" value="{{ $resume->cur_company }}" placeholder="请填写" autocomplete="off">
        </div>
        <div class="form-group form-inline">
          <label for="cur_salary">目前月薪：</label>
          <div class="input-group">
            <input type="text" name="cur_salary" class="form-control small append" value="{{ $resume->cur_salary }}" autocomplete="off" data-type="int">
            <div class="input-group-append">
              <div class="input-group-text">K</div>
            </div>
          </div>
          <label class="ml-1 mr-1">*</label>
          <div class="input-group">
            <input type="text" name="cur_salary_count" class="form-control small append" value="{{ $resume->cur_salary_count }}" autocomplete="off" data-type="int">
            <div class="input-group-append">
              <div class="input-group-text">月</div>
            </div>
            </div>
        </div>

        <div class="form-title text-left">
          <h5>职业发展意向</h5>
        </div>
        <div class="form-group form-inline">
          <label for="exp_industry">期望行业：</label>
          <div class="input-group" data-toggle="industrypicker">
            <input type="hidden" name="exp_industry[st]" value="{{ $resume->exp_industry['st'] }}">
            <input type="hidden" name="exp_industry[nd]" value="{{ $resume->exp_industry['nd'] }}">
            <input type="hidden" name="exp_industry[rd]" value="{{ $resume->exp_industry['rd'] }}">
            <input type="hidden" name="exp_industry[th]" value="{{ $resume->exp_industry['th'] }}">
            <input type="text" class="form-control normal append" value="{{ $resume->exp_industry_show }}" placeholder="请选择" autocomplete="off">
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
            <input type="hidden" name="exp_position[st]" value="{{ $resume->exp_position['st'] }}">
            <input type="hidden" name="exp_position[nd]" value="{{ $resume->exp_position['nd'] }}">
            <input type="hidden" name="exp_position[rd]" value="{{ $resume->exp_position['rd'] }}">
            <input type="text" class="form-control normal append" value="{{ $resume->exp_position_show }}" placeholder="请选择" autocomplete="off">
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
          <label for="exp_work_nature">工作性质：</label>
          <select name="exp_work_nature" class="form-control normal">
            <option value="" hidden>请选择</option>
            @foreach (trans('db.job.nature') as $key => $nature)
              <option value="{{ $key }}"
              @if ($resume->exp_work_nature === $key)
                selected
              @endif>
                {{ $nature }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="form-group form-inline">
          <label for="exp_location">
            <span class="color-red">*</span>
            期望城市：
          </label>
          <div data-toggle="distpicker">
            <select class="form-control" name="exp_location[province]" data-province="{{ $resume->exp_location['province'] }}"></select>
            <select class="form-control" name="exp_location[city]"  data-city="{{ $resume->exp_location['city'] }}"></select>
            <select class="form-control" name="exp_location[district]"  data-district="{{ $resume->exp_location['district'] }}"></select>
          </div>
        </div>
        <div class="form-group form-inline">
          <label for="exp_salary"><span class="color-red">*</span>期望薪资：</label>
          <input type="hidden" name="exp_salary_flag" value="{{ $resume->exp_salary_flag }}">
          <div class="input-group">
            <input type="text" name="exp_salary_min" class="form-control small append" value="{{ $resume->exp_salary_min }}" autocomplete="off" data-type="int"
              @if ($resume->exp_salary_flag === 1)
                disabled
              @endif
            >
            <div class="input-group-append">
              <div class="input-group-text">K</div>
            </div>
          </div>
          <label class="ml-1 mr-1">-</label>
          <div class="input-group">
            <input type="text" name="exp_salary_max" class="form-control small append" value="{{ $resume->exp_salary_max }}" autocomplete="off" data-type="int"
              @if ($resume->exp_salary_flag === 1)
                disabled
              @endif
            >
            <div class="input-group-append">
              <div class="input-group-text">K</div>
            </div>
          </div>
          <label class="ml-1 mr-1">*</label>
          <div class="input-group">
            <input type="text" name="exp_salary_count" class="form-control small append" value="{{ $resume->exp_salary_count }}" autocomplete="off" data-type="int"
              @if ($resume->exp_salary_flag === 1)
                disabled
              @endif
            >
            <div class="input-group-append">
              <div class="input-group-text">月</div>
            </div>
          </div>
          <div class="custom-control custom-checkbox custom-control-inline ml-3">
            <input type="checkbox" id="expSalaryDiscuss" class="custom-control-input" onclick="setExpSalary($(this))"
              @if ($resume->exp_salary_flag === 1)
                checked
              @endif
            >
            <label class="custom-control-label" for="expSalaryDiscuss">面议</label>
          </div>
        </div>

        <div class="form-title text-left">
          <h5>工作经历</h5>
        </div>
        @if (count($resume->resumeWorks) > 0)
          @php ($work_experiences = $resume->resumeWorks)
        @else
          @php ($work_experiences = [new App\Models\ResumeWork()])
        @endif
        @foreach ($work_experiences as $index => $work_experience)
          <input type="hidden" name="work_experience[{{ $index }}][id]" value="{{ $work_experience->id }}">
          <div class="form-group form-inline">
            <label for="work_experience[{{ $index }}][company_name]">
              <span class="color-red">*</span>
              公司名称：
            </label>
            <input type="text" name="work_experience[{{ $index }}][company_name]" class="form-control normal" value="{{ $work_experience->company_name }}" placeholder="请填写" autocomplete="off">
          </div>
          <div class="form-group form-inline">
            <label for="work_experience[{{ $index }}][company_nature]">
              公司性质：
            </label>
            <select name="work_experience[{{ $index }}][company_nature]" class="form-control normal">
              <option hidden value="">请选择</option>
              @foreach (trans('db.company.nature') as $key => $nature)
                <option value="{{ $key }}"
                @if ($work_experience->company_nature === $key)
                  selected
                @endif>
                  {{ $nature }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="form-group form-inline">
            <label for="work_experience[{{ $index }}][company_scale]">
              公司规模：
            </label>
            <select name="work_experience[{{ $index }}][company_scale]" class="form-control normal">
              <option hidden value="">请选择</option>
              @foreach (trans('db.company.scale') as $key => $scale)
                <option value="{{ $key }}"
                @if ($work_experience->company_scale === $key)
                  selected
                @endif>
                  {{ $scale }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="form-group form-inline">
            <label for="work_experience[{{ $index }}][company_industry]">所属行业：</label>
            <div class="input-group" data-toggle="industrypicker">
              <input type="hidden" name="work_experience[{{ $index }}][company_industry][st]" value="{{ $work_experience->company_industry['st'] }}">
              <input type="hidden" name="work_experience[{{ $index }}][company_industry][nd]" value="{{ $work_experience->company_industry['nd'] }}">
              <input type="hidden" name="work_experience[{{ $index }}][company_industry][rd]" value="{{ $work_experience->company_industry['rd'] }}">
              <input type="hidden" name="work_experience[{{ $index }}][company_industry][th]" value="{{ $work_experience->company_industry['th'] }}">
              <input type="text" class="form-control normal append" value="{{ $work_experience->company_industry['th'] }}" placeholder="请选择" autocomplete="off">
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
            <label for="work_experience[{{ $index }}][job_type]">
              <span class="color-red">*</span>
              职位名称：
            </label>
            <div class="input-group" data-toggle="jobtypepicker">
              <input type="hidden" name="work_experience[{{ $index }}][job_type][st]" value="{{ $work_experience->job_type['st'] }}">
              <input type="hidden" name="work_experience[{{ $index }}][job_type][nd]" value="{{ $work_experience->job_type['nd'] }}">
              <input type="hidden" name="work_experience[{{ $index }}][job_type][rd]" value="{{ $work_experience->job_type['rd'] }}">
              <input type="text" class="form-control normal append" value="{{ $work_experience->job_type['rd'] }}" placeholder="请选择" autocomplete="off">
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
                <label for="work_experience[{{ $index }}][salary]"><span class="color-red">*</span>月薪：</label>
                <div class="input-group">
                  <input type="text" name="work_experience[{{ $index }}][salary]" value="{{ $work_experience->salary }}" class="form-control must small append" autocomplete="off" data-type="int">
                  <div class="input-group-append">
                    <div class="input-group-text">K</div>
                  </div>
                </div>
                <label class="ml-1 mr-1">*</label>
                <div class="input-group">
                  <input type="text" name="work_experience[{{ $index }}][salary_count]" value="{{ $work_experience->salary_count }}" class="form-control must small append" autocomplete="off" data-type="int">
                  <div class="input-group-append">
                    <div class="input-group-text">月</div>
                  </div>
                  </div>
              </div>
          <div class="form-group form-inline">
            <label for="work_experience[{{ $index }}][subordinates]">下属人数：</label>
            <input type="text" name="work_experience[{{ $index }}][subordinates]" class="form-control normal" value="{{ $work_experience->subordinates }}" placeholder="请填写" autocomplete="off" data-type="int">
          </div>
          <div class="form-group form-inline">
            <label for="work_experience[{{ $index }}][start_at]"><span class="color-red">*</span>在职时间：</label>
            <div class="input-group date datetimepicker">
              <input type="text" name="work_experience[{{ $index }}][start_at]" class="form-control mini append" value="{{ $work_experience->start_at_month }}" placeholder="入职时间" autocomplete="off">
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
              <input type="text" name="work_experience[{{ $index }}][end_at]" class="form-control mini append" value="{{ $work_experience->end_at_month }}" placeholder="离职时间" autocomplete="off"
              @if ($work_experience->is_not_end)
                disabled
              @endif
              >
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
              <input type="checkbox" name="work_experience[{{ $index }}][is_not_end]" id="workAtNow" class="custom-control-input" onchange="setNotEnd($(this))"
              @if ($work_experience->is_not_end)
                checked
              @endif
              >
              <label class="custom-control-label" for="workAtNow">至今</label>
            </div>
          </div>
          <div class="form-group form-inline">
            <label for="work_experience[{{ $index }}][work_desc]">
              <span class="color-red">*</span>
              工作描述：
            </label>
            <textarea name="work_experience[{{ $index }}][work_desc]" class="form-control normal" placeholder="请填写">{{ $work_experience->work_desc }}</textarea>
          </div>
        @endforeach

        <div class="form-title text-left">
          <h5>项目经历</h5>
        </div>
        @if (count($resume->resumePrjs) > 0)
          @php ($project_experiences = $resume->resumePrjs)
        @else
          @php ($project_experiences = [new App\Models\ResumePrj()])
        @endif
        @foreach ($project_experiences as $index => $project_experience)
          <input type="hidden" name="project_experience[{{ $index }}][id]" value="{{ $project_experience->id }}">
          <div class="form-group form-inline">
            <label for="project_experience[{{ $index }}][name]">
              项目名称：
            </label>
            <input type="text" name="project_experience[{{ $index }}][name]" class="form-control normal" value="{{ $project_experience->name }}"  placeholder="请填写" autocomplete="off">
          </div>
          <div class="form-group form-inline">
            <label for="project_experience[{{ $index }}][role]">
              担任角色：
            </label>
            <input type="text" name="project_experience[{{ $index }}][role]" class="form-control normal" value="{{ $project_experience->role }}"  placeholder="请填写" autocomplete="off">
          </div>
          <div class="form-group form-inline">
            <label for="project_experience[{{ $index }}][start_at]">
              项目时间：
            </label>
            <div class="input-group date datetimepicker">
              <input type="text" name="project_experience[{{ $index }}][start_at]" class="form-control mini append" value="{{ $project_experience->start_at_month }}"  placeholder="开始时间" autocomplete="off">
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
              <input type="text" name="project_experience[{{ $index }}][end_at]" class="form-control mini append" value="{{ $project_experience->end_at_month }}" placeholder="结束时间" autocomplete="off"
              @if ($project_experience->is_not_end)
                disabled
              @endif
              >
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
              <input type="checkbox" name="project_experience[{{ $index }}][is_not_end]" id="projectAtNow" class="custom-control-input" onclick="setNotEnd($(this))"
              @if ($project_experience->is_not_end)
                checked
              @endif
              >
              <label class="custom-control-label" for="projectAtNow">至今</label>
            </div>
          </div>
          <div class="form-group form-inline">
            <label for="project_experience[{{ $index }}][body]">
              项目内容：
            </label>
            <textarea name="project_experience[{{ $index }}][body]" class="form-control normal" placeholder="请填写">{{ $project_experience->body }}</textarea>
          </div>
        @endforeach

        <div class="form-title text-left">
          <h5>教育经历</h5>
        </div>
        @if (count($resume->resumeEdus) > 0)
          @php ($education_experiences = $resume->resumeEdus)
        @else
          @php ($education_experiences = [new App\Models\ResumeEdu()])
        @endif
        @foreach ($education_experiences as $index => $education_experience)
          <input type="hidden" name="education_experience[{{ $index }}][id]" value="{{ $education_experience->id }}">
          <div class="form-group form-inline">
            <label for="education_experience[{{ $index }}][school_name]">
              <span class="color-red">*</span>
              毕业院校：
            </label>
            <input type="text" name="education_experience[{{ $index }}][school_name]" class="form-control normal" value="{{ $education_experience->school_name }}" placeholder="请填写" autocomplete="off">
          </div>
          <div class="form-group form-inline">
            <label for="education_experience[{{ $index }}][school_level]">
              <span class="color-red">*</span>
              最高学历：
            </label>
            <select name="education_experience[{{ $index }}][school_level]" class="form-control normal">
              <option hidden value="">请选择</option>
              @foreach (trans('db.education') as $key => $education)
                <option value="{{ $key }}"
                @if ($education_experience->school_level === $key)
                  selected
                @endif>
                  {{ $education }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="form-group form-inline">
            <label for="education_experience[{{ $index }}][major]">
              所学专业：
            </label>
            <input type="text" name="education_experience[{{ $index }}][major]" class="form-control normal" value="{{ $education_experience->major }}" placeholder="请填写" autocomplete="off">
          </div>
          <div class="form-group form-inline">
            <label for="education_experience[{{ $index }}][start_at]">
              在校时间：
            </label>
            <div class="input-group date datetimepicker">
              <input type="text" name="education_experience[{{ $index }}][start_at]" class="form-control mini append" value="{{ $education_experience->start_at_month }}" placeholder="入学时间" autocomplete="off">
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
              <input type="text" name="education_experience[{{ $index }}][end_at]" class="form-control mini append" value="{{ $education_experience->end_at_month }}" placeholder="毕业时间" autocomplete="off"
              @if ($education_experience->is_not_end)
                disabled
              @endif
              >
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
              <input type="checkbox" name="education_experience[{{ $index }}][is_not_end]" id="eductionAtNow" class="custom-control-input" onclick="setNotEnd($(this))"
              @if ($education_experience->is_not_end)
                checked
              @endif
              >
              <label class="custom-control-label" for="eductionAtNow">至今</label>
            </div>
          </div>
        @endforeach

        <div class="form-title text-left">
          <h5>附加信息</h5>
        </div>
        <div class="form-group form-inline">
          <label for="social_home">
            社交主页：
          </label>
          <input type="text" name="social_home" class="form-control normal" value="{{ $resume->social_home }}" placeholder="请填写" autocomplete="off">
        </div>
        <div class="form-group form-inline">
          <label for="personal_advantage">
            个人优势：
          </label>
          <textarea name="personal_advantage" class="form-control normal" placeholder="请填写">{{ $resume->personal_advantage }}</textarea>
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
            @foreach (trans('db.resume.jobhunter_status') as $key => $jobhunterStatus)
              <option value="{{ $key }}"
              @if ($resume->jobhunter_status === $key)
                selected
              @endif>
                {{ $jobhunterStatus }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="form-group form-inline">
          <label for="blacklist">
            屏蔽公司：
          </label>
          <input type="text" name="blacklist" class="form-control normal" value="{{ $resume->blacklist }}" placeholder="请填写" autocomplete="off">
        </div>
        <div class="form-group form-inline">
          <label for="remark">
            其他备注：
          </label>
          <textarea name="remark" class="form-control normal" placeholder="请填写">{{ $resume->remark }}</textarea>
        </div>

        <div class="form-title text-left">
          <h5>来源渠道</h5>
        </div>
        <div class="form-group form-inline">
          <label for="source">
            <span class="color-red">*</span>
            渠道选择：
          </label>
          @foreach (trans('db.channel') as $key => $source)
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" class="custom-control-input" id="source_{{ $key }}" name="source[{{ $key }}]"
                  @if (in_array($key, $resume->source))
                    checked
                  @endif
                  @if (in_array($key, trans('db.channel_remark')))
                    onclick='setRemark()'
                  @endif>
                <label class="custom-control-label" for="source_{{ $key }}">{{ $source }}</label>
            </div>
          @endforeach
          <input type="text" name="source_remarks" class="form-control" id="channelRemark" placeholder="请选择招聘平台" value="{{ $resume->source_remarks }}"
          @if (!in_array('other_platform', $resume->source))
            style="visibility: hidden;"
          @endif>
        </div>
        <div class="form-group form-inline">
          <label for="job_id">
            添加到"我的职位"：
          </label>
          <select name="job_id" class="form-control normal">
            <option hidden value="">请选择</option>
            @foreach($jobs as $job)
              <option value="{{ $job->id }}"
                @if ($resume->job_id === $job->id)
                  selected
                @endif
                >
                {{ $job->name }}
              </option>
            @endforeach
          </select>
        </div>

        <button type="submit" class="btn btn-danger btn-form-submit">保存修改并上传</button>
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
    @foreach (trans('db.resume.work_years') as $key => $workYears)
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
    let checked = $('#source_other_platform').is(':checked');
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

  $.fn.extend({
        txtaAutoHeight: function () {
            return this.each(function () {
                var $this = $(this);
                if (!$this.attr('initAttrH')) {
                    $this.attr('initAttrH', $this.outerHeight());
                }
                setAutoHeight(this).on('input', function () {
                    setAutoHeight(this);
                });
            });
            function setAutoHeight(elem) {
                var $obj = $(elem);
                var height = elem.scrollHeight;
                if (height > 300) {
                    height = 300;
                }
                return $obj.css({ height: $obj.attr('initAttrH'), 'overflow-y': 'auto' }).height(height);
            }
        }
    });

  $('textarea').txtaAutoHeight();
</script>
@stop
