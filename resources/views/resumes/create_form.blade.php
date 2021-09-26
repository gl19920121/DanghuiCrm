@extends('layouts.default')
@section('title', '上传简历')
@section('content')
<div class="resume-create-form bg-white">
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
          <label for="avatar">头像：</label>
          <div data-toggle="filechoose" data-type="avatar" data-size="normal">
            @if (!empty($resume['avatar']))
              <img src="{{ $resume['avatar'] }}" class="rounded-circle resume-avatar">
            @else
              @if ($resume['sex'] === '女')
                <img src="{{ URL::asset('images/resume_avatar_default_female.png') }}" class="rounded-circle resume-avatar">
              @else
                <img src="{{ URL::asset('images/resume_avatar_default_man.png') }}" class="rounded-circle resume-avatar">
              @endif
            @endif
            <input hidden type="file" multiple="true" accept="image/png, image/jpeg" name="avatar" class="form-control middle">
          </div>
        </div>
        <div class="form-group form-inline">
          <label for="name">
            <span class="color-red">*</span>
            姓名：
          </label>
          <input type="text" name="name" class="form-control must normal @if($errors->has('name')) border-danger @endif" value="{{ empty(old('name')) ? $resume['name'] : old('name') }}" placeholder="请填写" autocomplete="off">
        </div>
        <div class="form-group form-inline">
          <label for="sex">
            <span class="color-red">*</span>
            性别：
          </label>
          <select name="sex" class="form-control must normal @if($errors->has('sex')) border-danger @endif">
            <option hidden value="">请选择</option>
            <option
            @if (old('sex') === '男')
              selected
            @elseif ($resume['sex'] === '男')
              selected
            @endif
            >
              男
            </option>
            <option
            @if (old('sex') === '女')
              selected
            @elseif ($resume['sex'] === '女')
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
          <input type="text" name="age" class="form-control must normal @if($errors->has('age')) border-danger @endif" value="{{ empty(old('age')) ? $resume['age'] : old('age') }}" placeholder="请填写" autocomplete="off" data-type="int">
        </div>
        <div class="form-group form-inline">
          <label for="location">
            <span class="color-red">*</span>
            所在城市：
          </label>
          <div data-toggle="distpicker">
            @if (old('location'))
              <select class="form-control must @if($errors->has('location.province')) border-danger @endif" name="location[province]" data-province="{{ old('location')['province'] }}"></select>
              <select class="form-control must @if($errors->has('location.city')) border-danger @endif" name="location[city]" data-city="{{ old('location')['city'] }}"></select>
              <select class="form-control" name="location[district]" data-district="{{ old('location')['district'] }}"></select>
            @else
              <select class="form-control must @if($errors->has('location.province')) border-danger @endif" name="location[province]" data-province="{{ $resume['location']['province'] }}"></select>
              <select class="form-control must @if($errors->has('location.city')) border-danger @endif" name="location[city]"  data-city="{{ $resume['location']['city'] }}"></select>
              <select class="form-control" name="location[district]"  data-district="{{ $resume['location']['district'] }}"></select>
            @endif
          </div>
        </div>
        <div class="form-group form-inline">
          <label for="sex">
            <span class="color-red">*</span>
            工作年限：
          </label>
          <div class="input-group">
            <input type="hidden" name="work_years_flag" value="0">
            <input type="text" name="work_years" class="form-control must small append @if($errors->has('work_years')) border-danger @endif" value="{{ empty(old('work_years')) ? $resume['work_years'] : old('work_years') }}" autocomplete="off" data-type="int"
            @if (old('work_years_flag') != 0)
              disabled
            @endif
            >
            <div class="input-group-append">
              <div class="input-group-text">年</div>
            </div>
          </div>
          @foreach (trans('db.resume.work_years') as $key => $workYears)
            <div class="custom-control custom-checkbox custom-control-inline ml-3">
              <input type="checkbox" id="work_years_{{ $key }}" class="custom-control-input" onclick="setWorkYears($(this))"
              @if (old('work_years_flag') == $key)
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
          <select name="education" class="form-control must normal @if($errors->has('education')) border-danger @endif" value="{{ old('education') }}">
            <option hidden value="">请选择</option>
            @foreach (trans('db.education') as $key => $education)
              <option value="{{ $key }}"
              @if (old('education') === $key)
                selected
              @elseif ($resume['education'] === $key)
                selected
              @endif
              >
                {{ $education }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="form-group form-inline">
          <label for="major">所学专业：</label>
          <input type="text" name="major" class="form-control normal" value="{{ empty(old('major')) ? $resume['major'] : old('major') }}" placeholder="请填写" autocomplete="off">
        </div>

        <div class="form-title text-left">
          <h5>联系方式</h5>
        </div>
        <div class="form-group form-inline">
          <label for="phone_num">
            <span class="color-red">*</span>
            手机号码：
          </label>
          <input type="text" name="phone_num" class="form-control must normal @if($errors->has('phone_num')) border-danger @endif" value="{{ empty(old('phone_num')) ? $resume['phone_num'] : old('phone_num') }}" placeholder="请填写" autocomplete="off">
        </div>
        <div class="form-group form-inline">
          <label for="email">
            <span class="color-red">*</span>
            电子邮箱：
          </label>
          <input type="text" name="email" class="form-control must normal @if($errors->has('email')) border-danger @endif" value="{{ empty(old('email')) ? $resume['email'] : old('email') }}" placeholder="请填写" autocomplete="off">
        </div>
        <div class="form-group form-inline">
          <label for="wechat">
            微信：
          </label>
          <input type="text" name="wechat" class="form-control normal" value="{{ empty(old('wechat')) ? $resume['wechat'] : old('wechat') }}" placeholder="请填写" autocomplete="off">
        </div>
        <div class="form-group form-inline">
          <label for="qq">
            QQ：
          </label>
          <input type="text" name="qq" class="form-control normal" value="{{ empty(old('qq')) ? $resume['qq'] : old('qq') }}" placeholder="请填写" autocomplete="off" data-type="int">
        </div>

        <div class="form-title text-left">
          <h5>目前职业概况</h5>
        </div>
        <div class="form-group form-inline">
          <label for="cur_industry">所在行业：</label>
          <div class="input-group" data-toggle="industrypicker">
            @if (old('cur_industry'))
              <input type="hidden" name="cur_industry[st]" value="{{ old('cur_industry')['st'] }}">
              <input type="hidden" name="cur_industry[nd]" value="{{ old('cur_industry')['nd'] }}">
              <input type="hidden" name="cur_industry[rd]" value="{{ old('cur_industry')['rd'] }}">
              <input type="hidden" name="cur_industry[th]" value="{{ old('cur_industry')['th'] }}">
              <input type="text" class="form-control industryshow normal append" value="{{ old('cur_industry')['th'] }}" placeholder="请选择" autocomplete="off">
            @else
              <input type="hidden" name="cur_industry[st]" value="{{ $resume['cur_industry']['st'] }}">
              <input type="hidden" name="cur_industry[nd]" value="{{ $resume['cur_industry']['nd'] }}">
              <input type="hidden" name="cur_industry[rd]" value="{{ $resume['cur_industry']['rd'] }}">
              <input type="hidden" name="cur_industry[th]" value="{{ $resume['cur_industry']['th'] }}">
              <input type="text" class="form-control industryshow normal append" value="{{ $resume['cur_industry']['th'] }}" placeholder="请选择" autocomplete="off">
            @endif
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
            @if (old('cur_position'))
              <input type="hidden" name="cur_position[st]" value="{{ old('cur_position')['st'] }}">
              <input type="hidden" name="cur_position[nd]" value="{{ old('cur_position')['nd'] }}">
              <input type="hidden" name="cur_position[rd]" value="{{ old('cur_position')['rd'] }}">
              <input type="text" class="form-control jobshow normal append" value="{{ old('cur_position')['rd'] }}" placeholder="请选择" autocomplete="off">
            @else
              <input type="hidden" name="cur_position[st]" value="{{ $resume['cur_position']['st'] }}">
              <input type="hidden" name="cur_position[nd]" value="{{ $resume['cur_position']['nd'] }}">
              <input type="hidden" name="cur_position[rd]" value="{{ $resume['cur_position']['rd'] }}">
              <input type="text" class="form-control normal append" value="{{ $resume['cur_position']['rd'] }}" placeholder="请选择" autocomplete="off">
            @endif
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
          <input type="text" name="cur_company" class="form-control normal" value="{{ empty(old('cur_company')) ? $resume['cur_company'] : old('cur_company') }}" placeholder="请填写" autocomplete="off">
        </div>
        <div class="form-group form-inline">
          <label for="cur_salary">目前月薪：</label>
          <div class="input-group">
            <input type="text" name="cur_salary" class="form-control small append" value="{{ empty(old('cur_salary')) ? $resume['cur_salary'] : old('cur_salary') }}" autocomplete="off" data-type="int">
            <div class="input-group-append">
              <div class="input-group-text">K</div>
            </div>
          </div>
          <label class="ml-1 mr-1">*</label>
          <div class="input-group">
            <input type="text" name="cur_salary_count" class="form-control small append" value="{{ empty(old('cur_salary_count')) ? $resume['cur_salary_count'] : old('cur_salary_count') }}" autocomplete="off" data-type="int">
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
            @if (old('exp_industry'))
              <input type="hidden" name="exp_industry[st]" value="{{ old('exp_industry')['st'] }}">
              <input type="hidden" name="exp_industry[nd]" value="{{ old('exp_industry')['nd'] }}">
              <input type="hidden" name="exp_industry[rd]" value="{{ old('exp_industry')['rd'] }}">
              <input type="hidden" name="exp_industry[th]" value="{{ old('exp_industry')['th'] }}">
              <input type="text" class="form-control industryshow normal append" value="{{ old('exp_industry')['th'] }}" placeholder="请选择" autocomplete="off">
            @else
              <input type="hidden" name="exp_industry[st]" value="{{ $resume['exp_industry']['st'] }}">
              <input type="hidden" name="exp_industry[nd]" value="{{ $resume['exp_industry']['nd'] }}">
              <input type="hidden" name="exp_industry[rd]" value="{{ $resume['exp_industry']['rd'] }}">
              <input type="hidden" name="exp_industry[th]" value="{{ $resume['exp_industry']['th'] }}">
              <input type="text" class="form-control industryshow normal append" value="{{ $resume['exp_industry']['th'] }}" placeholder="请选择" autocomplete="off">
            @endif
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
            @if (old('exp_position'))
              <input type="hidden" name="exp_position[st]" value="{{ old('exp_position')['st'] }}">
              <input type="hidden" name="exp_position[nd]" value="{{ old('exp_position')['nd'] }}">
              <input type="hidden" name="exp_position[rd]" value="{{ old('exp_position')['rd'] }}">
              <input type="text" class="form-control must jobshow normal append
              @if ($errors->has('exp_position.st') || $errors->has('exp_position.nd') || $errors->has('exp_position.rd'))
                border-danger
              @endif
              " value="{{ old('exp_position')['rd'] }}" placeholder="请选择" autocomplete="off">
            @else
              <input type="hidden" name="exp_position[st]" value="{{ $resume['exp_position']['st'] }}">
              <input type="hidden" name="exp_position[nd]" value="{{ $resume['exp_position']['nd'] }}">
              <input type="hidden" name="exp_position[rd]" value="{{ $resume['exp_position']['rd'] }}">
              <input type="text" class="form-control must jobshow normal append
              @if ($errors->has('exp_position.st') || $errors->has('exp_position.nd') || $errors->has('exp_position.rd'))
                border-danger
              @endif
              " value="{{ $resume['exp_position']['rd'] }}" placeholder="请选择" autocomplete="off">
            @endif
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
              @if (old('exp_work_nature') === $key)
                selected
              @elseif ($resume['exp_work_nature'] === $key)
                selected
              @endif
              >
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
            @if (old('exp_location'))
              <select class="form-control must @if($errors->has('exp_location.province')) border-danger @endif" name="exp_location[province]" data-province="{{ old('exp_location')['province'] }}"></select>
              <select class="form-control must @if($errors->has('exp_location.city')) border-danger @endif" name="exp_location[city]"  data-city="{{ old('exp_location')['city'] }}"></select>
              <select class="form-control" name="exp_location[district]"  data-district="{{ old('exp_location')['district'] }}"></select>
            @else
              <select class="form-control must @if($errors->has('exp_location.province')) border-danger @endif" name="exp_location[province]" data-province="---- 选择省 ----"></select>
              <select class="form-control must @if($errors->has('exp_location.city')) border-danger @endif" name="exp_location[city]"  data-city="---- 选择市 ----"></select>
              <select class="form-control" name="exp_location[district]"  data-district="---- 选择区 ----"></select>
            @endif
          </div>
        </div>
        <div class="form-group form-inline">
          <label for="exp_salary"><span class="color-red">*</span>期望薪资：</label>
          <input type="hidden" name="exp_salary_flag" value="0">
          <div class="input-group">
            <input type="text" name="exp_salary_min" class="form-control must small append @if($errors->has('exp_salary_min')) border-danger @endif" value="{{ empty(old('exp_salary_min')) ? $resume['exp_salary_min'] : old('exp_salary_min') }}" autocomplete="off" data-type="int"
            @if (old('exp_salary_flag') != 0)
              disabled
            @endif
            >
            <div class="input-group-append">
              <div class="input-group-text">K</div>
            </div>
          </div>
          <label class="ml-1 mr-1">-</label>
          <div class="input-group">
            <input type="text" name="exp_salary_max" class="form-control must small append @if($errors->has('exp_salary_max')) border-danger @endif" value="{{ empty(old('exp_salary_max')) ? $resume['exp_salary_max'] : old('exp_salary_max') }}" autocomplete="off" data-type="int"
            @if (old('exp_salary_flag') != 0)
              disabled
            @endif
            >
            <div class="input-group-append">
              <div class="input-group-text">K</div>
            </div>
          </div>
          <label class="ml-1 mr-1">*</label>
          <div class="input-group">
            <input type="text" name="exp_salary_count" class="form-control must small append @if($errors->has('exp_salary_count')) border-danger @endif" value="{{ empty(old('exp_salary_count')) ? $resume['exp_salary_count'] : old('exp_salary_count') }}" autocomplete="off" data-type="int"
            @if (old('exp_salary_flag') != 0)
              disabled
            @endif
            >
            <div class="input-group-append">
              <div class="input-group-text">月</div>
            </div>
          </div>
          <div class="custom-control custom-checkbox custom-control-inline ml-3">
            <input type="checkbox" id="expSalaryDiscuss" class="custom-control-input" onclick="setExpSalary($(this))"
            @if (old('exp_salary_flag') == 1)
              checked
            @endif
            >
            <label class="custom-control-label" for="expSalaryDiscuss">面议</label>
          </div>
        </div>

        <div class="form-title text-left">
          <h5>工作经历</h5>
        </div>
        @php ($work_experience_default = [
          'company_name' => '',
          'company_nature' => '',
          'company_scale' => '',
          'company_investment' => '',
          'company_industry' => ['st' => '', 'nd' => '', 'rd' => '', 'th' => ''],
          'job_type' => ['st' => '', 'nd' => '', 'rd' => ''],
          'salary' => '',
          'salary_count' => '',
          'subordinates' => '',
          'start_at' => '',
          'end_at' => '',
          'is_not_end' => '',
          'work_desc' => ''
        ])
        @if (empty(old('work_experience')))
          @if (isset($resume['work_experience']) && count($resume['work_experience']) > 0)
            @php ($work_experiences = $resume['work_experience'])
          @else
            @php ($work_experiences = [$work_experience_default])
          @endif
        @else
          @php ($work_experiences = old('work_experience'))
        @endif
        <div id="work_experience">
          @foreach ($work_experiences as $index => $work_experience)
            @foreach ($work_experience_default as $key => $value)
              @if (!isset($work_experience[$key]))
                @php ($work_experience[$key] = $value)
              @endif
            @endforeach
            <div id="work-{{ $index }}" class="border border-gray rounded pt-4 pb-4 mb-4">
              <div class="color-red float-right cursor-pointer mr-4" onclick="dropWork({{ $index }})">X</div>
              <div class="form-group form-inline">
                <label for="work_experience[{{ $index }}][company_name]">
                  <span class="color-red">*</span>
                  公司名称：
                </label>
                <input type="text" name="work_experience[{{ $index }}][company_name]" value="{{ $work_experience['company_name'] }}" class="form-control must normal @if($errors->has("work_experience.$index.company_name")) border-danger @endif" placeholder="请填写" autocomplete="off">
              </div>
              <div class="form-group form-inline">
                <label for="work_experience[{{ $index }}][company_nature]">
                  公司性质：
                </label>
                <select name="work_experience[{{ $index }}][company_nature]" class="form-control normal">
                  <option hidden value="">请选择</option>
                  @foreach (trans('db.company.nature') as $key => $nature)
                    <option value="{{ $key }}"
                    @if ($work_experience['company_nature'] === $key)
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
                    @if ($work_experience['company_scale'] === $key)
                      selected
                    @endif>
                      {{ $scale }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="form-group form-inline">
                <label for="work_experience[{{ $index }}][company_investment]">
                  融资阶段：
                </label>
                <select name="work_experience[{{ $index }}][company_investment]" class="form-control normal">
                  <option hidden value="">请选择</option>
                  @foreach (trans('db.company.investment') as $key => $investment)
                    <option value="{{ $key }}"
                    @if ($work_experience['company_investment'] == $key)
                      selected
                    @endif>
                      {{ $investment }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="form-group form-inline">
                <label for="work_experience[{{ $index }}][company_industry]">所属行业：</label>
                <div class="input-group" data-toggle="industrypicker">
                  <input type="hidden" name="work_experience[{{ $index }}][company_industry][st]" value="{{ $work_experience['company_industry']['st'] }}">
                  <input type="hidden" name="work_experience[{{ $index }}][company_industry][nd]" value="{{ $work_experience['company_industry']['nd'] }}">
                  <input type="hidden" name="work_experience[{{ $index }}][company_industry][rd]" value="{{ $work_experience['company_industry']['rd'] }}">
                  <input type="hidden" name="work_experience[{{ $index }}][company_industry][th]" value="{{ $work_experience['company_industry']['th'] }}">
                  <input type="text" class="form-control industryshow normal append" value="{{ $work_experience['company_industry']['th'] }}" placeholder="请选择" autocomplete="off">
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
                  <input type="hidden" name="work_experience[{{ $index }}][job_type][st]" value="{{ $work_experience['job_type']['st'] }}">
                  <input type="hidden" name="work_experience[{{ $index }}][job_type][nd]" value="{{ $work_experience['job_type']['nd'] }}">
                  <input type="hidden" name="work_experience[{{ $index }}][job_type][rd]" value="{{ $work_experience['job_type']['rd'] }}">
                  <input type="text" class="form-control must jobshow normal append
                  @if ($errors->has("work_experience.$index.job_type.st") || $errors->has("work_experience.$index.job_type.nd") || $errors->has("work_experience.$index.job_type.rd"))
                    border-danger
                  @endif
                  " value="{{ $work_experience['job_type']['rd'] }}" placeholder="请选择" autocomplete="off">
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
                  <input type="text" name="work_experience[{{ $index }}][salary]" value="{{ $work_experience['salary'] }}" class="form-control must small append @if($errors->has("work_experience.$index.salary")) border-danger @endif" autocomplete="off" data-type="int">
                  <div class="input-group-append">
                    <div class="input-group-text">K</div>
                  </div>
                </div>
                <label class="ml-1 mr-1">*</label>
                <div class="input-group">
                  <input type="text" name="work_experience[{{ $index }}][salary_count]" value="{{ $work_experience['salary_count'] }}" class="form-control must small append @if($errors->has("work_experience.$index.salary_count")) border-danger @endif" autocomplete="off" data-type="int">
                  <div class="input-group-append">
                    <div class="input-group-text">月</div>
                  </div>
                  </div>
              </div>
              <div class="form-group form-inline">
                <label for="work_experience[{{ $index }}][subordinates]">下属人数：</label>
                <input type="text" name="work_experience[{{ $index }}][subordinates]" value="{{ $work_experience['subordinates'] }}" class="form-control normal" placeholder="请填写" autocomplete="off" data-type="int">
              </div>
              <div class="form-group form-inline">
                <label for="work_experience[{{ $index }}][start_at]"><span class="color-red">*</span>在职时间：</label>
                <div class="input-group date datemonthpicker">
                  <input type="text" name="work_experience[{{ $index }}][start_at]" value="{{ $work_experience['start_at'] }}" class="form-control must mini append @if($errors->has("work_experience.$index.start_at")) border-danger @endif" placeholder="入职时间" autocomplete="off">
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
                <div class="input-group date datemonthpicker">
                  <input type="text" name="work_experience[{{ $index }}][end_at]" value="{{ $work_experience['end_at'] }}" class="form-control must mini append @if($errors->has("work_experience.$index.end_at")) border-danger @endif" placeholder="离职时间" autocomplete="off"
                  @if ($work_experience['is_not_end'] === 'on')
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
                  <input type="checkbox" name="work_experience[{{ $index }}][is_not_end]" id="workAtNow-0" class="custom-control-input" onclick="setNotEnd($(this))"
                  @if ($work_experience['is_not_end'] === 'on')
                    checked
                  @endif
                  >
                  <label class="custom-control-label" for="workAtNow-0">至今</label>
                </div>
              </div>
              <div class="form-group form-inline">
                <label for="work_experience[{{ $index }}][work_desc]">
                  <span class="color-red">*</span>
                  工作描述：
                </label>
                <textarea name="work_experience[{{ $index }}][work_desc]" class="form-control must normal @if($errors->has("work_experience.$index.work_desc")) border-danger @endif" placeholder="请填写">{{ $work_experience['work_desc'] }}</textarea>
              </div>
            </div>
          @endforeach
        </div>
        <div class="form-group form-inline">
          <div class="addItem" onclick="addWork()">
            <p class="m-auto">添加工作经历</p>
          </div>
        </div>

        <div class="form-title text-left">
          <h5>项目经历</h5>
        </div>
        @php ($project_experience_default = [
          'name' => '',
          'role' => '',
          'start_at' => '',
          'end_at' => '',
          'is_not_end' => '',
          'body' => ''
        ])
        @if (empty(old('project_experience')))
          @if (isset($resume['project_experience']) && count($resume['project_experience']) > 0)
            @php ($project_experiences = $resume['project_experience'])
          @else
            @php ($project_experiences = [$project_experience_default])
          @endif
        @else
          @php ($project_experiences = old('project_experience'))
        @endif
        <div id="project_experience">
          @foreach ($project_experiences as $index => $project_experience)
            @foreach ($project_experience_default as $key => $value)
              @if (!isset($project_experience[$key]))
                @php ($project_experience[$key] = $value)
              @endif
            @endforeach
            <div id="project-{{ $index }}" class="border border-gray rounded pt-4 pb-4 mb-4">
              <div class="color-red float-right cursor-pointer mr-4" onclick="dropProject({{ $index }})">X</div>
              <div class="form-group form-inline">
                <label for="project_experience[{{ $index }}][name]">
                  项目名称：
                </label>
                <input type="text" name="project_experience[{{ $index }}][name]" value="{{ $project_experience['name'] }}" class="form-control normal" placeholder="请填写" autocomplete="off">
              </div>
              <div class="form-group form-inline">
                <label for="project_experience[{{ $index }}][role]">
                  担任角色：
                </label>
                <input type="text" name="project_experience[{{ $index }}][role]" value="{{ $project_experience['role'] }}" class="form-control normal" placeholder="请填写" autocomplete="off">
              </div>
              <div class="form-group form-inline">
                <label for="project_experience[{{ $index }}][start_at]">
                  项目时间：
                </label>
                <div class="input-group date datemonthpicker">
                  <input type="text" name="project_experience[{{ $index }}][start_at]" value="{{ $project_experience['start_at'] }}" class="form-control mini append" placeholder="开始时间" autocomplete="off">
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
                <div class="input-group date datemonthpicker">
                  <input type="text" name="project_experience[{{ $index }}][end_at]" value="{{ $project_experience['end_at'] }}" class="form-control mini append" placeholder="结束时间" autocomplete="off"
                  @if ($project_experience['is_not_end'] === 'on')
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
                  <input type="checkbox" name="project_experience[{{ $index }}][is_not_end]" id="projectAtNow-{{ $index }}" class="custom-control-input" onclick="setNotEnd($(this))"
                  @if ($project_experience['is_not_end'] === 'on')
                    checked
                  @endif
                  >
                  <label class="custom-control-label" for="projectAtNow-0">至今</label>
                </div>
              </div>
              <div class="form-group form-inline">
                <label for="project_experience[{{ $index }}][body]">
                  项目内容：
                </label>
                <textarea name="project_experience[{{ $index }}][body]" class="form-control normal" placeholder="请填写">{{ $project_experience['body'] }}</textarea>
              </div>
            </div>
          @endforeach
        </div>
        <div class="form-group form-inline">
          <div class="addItem" onclick="addProject()">
            <p class="m-auto">添加项目经历</p>
          </div>
        </div>

        <div class="form-title text-left">
          <h5>教育经历</h5>
        </div>
        @php ($education_experience_default = [
          'school_name' => '',
          'school_level' => '',
          'major' => '',
          'start_at' => '',
          'end_at' => '',
          'is_not_end' => ''
        ])
        @if (empty(old('education_experience')))
          @if (isset($resume['education_experience']) && count($resume['education_experience']) > 0)
            @php ($education_experiences = $resume['education_experience'])
          @else
            @php ($education_experiences = [$education_experience_default])
          @endif
        @else
          @php ($education_experiences = old('education_experience'))
        @endif
        <div id="education_experience">
          @foreach ($education_experiences as $index => $education_experience)
            @foreach ($education_experience_default as $key => $value)
              @if (!isset($education_experience[$key]))
                @php ($education_experience[$key] = $value)
              @endif
            @endforeach
            <div id="education-{{ $index }}" class="border border-gray rounded pt-4 pb-4 mb-4">
              <div class="color-red float-right cursor-pointer mr-4" onclick="dropEducation({{ $index }})">X</div>
              <div class="form-group form-inline">
                <label for="education_experience[{{ $index }}][school_name]">
                  <span class="color-red">*</span>
                  毕业院校：
                </label>
                <input type="text" name="education_experience[{{ $index }}][school_name]" value="{{ $education_experience['school_name'] }}" class="form-control must normal @if($errors->has("education_experience.$index.school_name")) border-danger @endif" placeholder="请填写" autocomplete="off">
              </div>
              <div class="form-group form-inline">
                <label for="education_experience[{{ $index }}][school_level]">
                  <span class="color-red">*</span>
                  最高学历：
                </label>
                <select name="education_experience[{{ $index }}][school_level]" class="form-control must normal @if($errors->has("education_experience.$index.school_level")) border-danger @endif">
                  <option hidden value="">请选择</option>
                  @foreach (trans('db.education') as $key => $education)
                    <option value="{{ $key }}"
                    @if ($education_experience['school_level'] == $key)
                      selected
                    @endif
                    >
                      {{ $education }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="form-group form-inline">
                <label for="education_experience[{{ $index }}][major]">
                  所学专业：
                </label>
                <input type="text" name="education_experience[{{ $index }}][major]" value="{{ $education_experience['major'] }}" class="form-control normal" placeholder="请填写" autocomplete="off">
              </div>
              <div class="form-group form-inline">
                <label for="education_experience[{{ $index }}][start_at]">
                  在校时间：
                </label>
                <div class="input-group date datemonthpicker">
                  <input type="text" name="education_experience[{{ $index }}][start_at]" value="{{ $education_experience['start_at'] }}" class="form-control mini append" placeholder="入学时间" autocomplete="off">
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
                <div class="input-group date datemonthpicker">
                  <input type="text" name="education_experience[{{ $index }}][end_at]" value="{{ $education_experience['end_at'] }}" class="form-control mini append" placeholder="毕业时间" autocomplete="off"
                  @if ($education_experience['is_not_end'] == 'on')
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
                  <input type="checkbox" name="education_experience[{{ $index }}][is_not_end]" id="educationAtNow-0" class="custom-control-input" onclick="setNotEnd($(this))"
                  @if ($education_experience['is_not_end'] == 'on')
                    checked
                  @endif
                  >
                  <label class="custom-control-label" for="educationAtNow-0">至今</label>
                </div>
              </div>
            </div>
          @endforeach
        </div>
        <div class="form-group form-inline">
          <div class="addItem" onclick="addEducation()">
            <p class="m-auto">添加教育经历</p>
          </div>
        </div>

        <div class="form-title text-left">
          <h5>附加信息</h5>
        </div>
        <div class="form-group form-inline">
          <label for="social_home">
            社交主页：
          </label>
          <input type="text" name="social_home" value="{{ old('social_home') }}" class="form-control normal" placeholder="请填写" autocomplete="off">
        </div>
        <div class="form-group form-inline">
          <label for="personal_advantage">
            个人优势：
          </label>
          <textarea name="personal_advantage" class="form-control normal" placeholder="请填写">{{ old('personal_advantage') }}</textarea>
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
          <select name="jobhunter_status" class="form-control normal">
            <option hidden value="">请选择</option>
            @foreach (trans('db.resume.jobhunter_status') as $key => $jobhunterStatus)
              <option value="{{ $key }}"
              @if (old('jobhunter_status') === $key)
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
          <input type="text" name="blacklist" value="{{ old('blacklist') }}" class="form-control normal" placeholder="请填写" autocomplete="off">
        </div>
        <div class="form-group form-inline">
          <label for="remark">
            其他备注：
          </label>
          <textarea name="remark" class="form-control normal" placeholder="请填写">{{ old('remark') }}</textarea>
        </div>

        <div class="form-title text-left">
          <h5>来源渠道</h5>
        </div>
        <div class="form-group form-inline">
          <label for="source">
            <span class="color-red">*</span>
            渠道选择：
          </label>
          @foreach (trans('db.channel') as $key => $channel)
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" class="custom-control-input" id="channel_{{ $key }}" name="source[{{ $key }}]"
                  @if (empty(old('source')))
                    @if (in_array($key, trans('db.resume.channel_default')))
                      checked
                    @endif
                  @else
                    @if (isset(old('source')[$key]))
                      checked
                    @endif
                  @endif
                  @if (in_array($key, trans('db.channel_remark')))
                    onclick='setRemark()'
                  @endif>
                <label class="custom-control-label" for="channel_{{ $key }}">{{ $channel }}</label>
            </div>
          @endforeach
          <select id="channelRemark" name="source_remarks" class="form-control must @if($errors->has('source_remarks')) border-danger @endif"
          @if (!isset(old('source')['other_platform']))
            style="visibility: hidden;"
          @endif>
            <option hidden value="">请选择</option>
            @foreach (trans('db.source_remarks') as $key => $sourceRemarks)
              <option value="{{ $key }}"
              @if (old('source_remarks') === $key)
                selected
              @elseif ($resume['source_remarks'] === $key)
                selected
              @endif>
                {{ $sourceRemarks }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="form-group form-inline">
          <label for="job_id">
            添加到"我的职位"：
          </label>
          <select name="job_id" class="form-control normal">
            <option hidden value="">请选择</option>
            @foreach($jobs as $job)
              <option value="{{ $job->id }}"
              @if (old('job_id') == $job->id)
                selected
              @endif>
                {{ $job->name }}
              </option>
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

  var worksCount = {{ count($work_experiences) }};
  var projectsCount = {{ count($project_experiences) }};
  var educationsCount = {{ count($education_experiences) }};

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

  function addWork()
  {z
    let work =
      '<div class="color-red float-right cursor-pointer mr-4" onclick="dropWork(' + worksCount + ')">X</div>' +
        '<div class="form-group form-inline">' +
          '<label for="work_experience[' + worksCount + '][company_name]">' +
            '<span class="color-red">*</span>' +
            '公司名称：' +
          '</label>' +
          '<input type="text" name="work_experience[' + worksCount + '][company_name]" class="form-control normal" placeholder="请填写" autocomplete="off">' +
        '</div>' +
        '<div class="form-group form-inline">' +
          '<label for="work_experience[' + worksCount + '][company_nature]">' +
            '公司性质：' +
          '</label>' +
          '<select name="work_experience[' + worksCount + '][company_nature]" class="form-control normal">' +
            '<option hidden value="">请选择</option>' +
            @foreach (trans('db.company.nature') as $key => $nature)
              '<option value="{{ $key }}">{{ $nature }}</option>' +
            @endforeach
          '</select>' +
        '</div>' +
        '<div class="form-group form-inline">' +
          '<label for="work_experience[' + worksCount + '][company_scale]">' +
            '公司规模：' +
          '</label>' +
          '<select name="work_experience[' + worksCount + '][company_scale]" class="form-control normal">' +
            '<option hidden value="">请选择</option>' +
            @foreach (trans('db.company.scale') as $key => $scale)
              '<option value="{{ $key }}">{{ $scale }}</option>' +
            @endforeach
          '</select>' +
        '</div>' +
        '<div class="form-group form-inline">' +
          '<label for="work_experience[' + worksCount + '][company_investment]">' +
            '融资阶段：' +
          '</label>' +
          '<select name="work_experience[' + worksCount + '][company_investment]" class="form-control normal">' +
            '<option hidden value="">请选择</option>' +
            @foreach (trans('db.company.investment') as $key => $investment)
              '<option value="{{ $key }}">{{ $investment }}</option>' +
            @endforeach
          '</select>' +
        '</div>' +
        '<div class="form-group form-inline">' +
          '<label for="work_experience[' + worksCount + '][company_industry]">所属行业：</label>' +
          '<div class="input-group" data-toggle="industrypicker">' +
            '<input type="hidden" name="work_experience[' + worksCount + '][company_industry][st]">' +
            '<input type="hidden" name="work_experience[' + worksCount + '][company_industry][nd]">' +
            '<input type="hidden" name="work_experience[' + worksCount + '][company_industry][rd]">' +
            '<input type="hidden" name="work_experience[' + worksCount + '][company_industry][th]">' +
            '<input type="text" class="form-control industryshow normal append" value="" placeholder="请选择" autocomplete="off">' +
            '<div class="input-group-append" data-toggle="modal" data-target="#industryModal">' +
              '<span class="input-group-text" id="basic-addon2">' +
                '<svg class="bi bi-calendar" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">' +
                  '<path fill-rule="evenodd" d="M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1zm1-3a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2z"/>' +
                  '<path fill-rule="evenodd" d="M3.5 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5zm9 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5z"/>' +
                '</svg>' +
              '</span>' +
            '</div>' +
          '</div>' +
        '</div>' +
        '<div class="form-group form-inline">' +
          '<label for="work_experience[' + worksCount + '][job_type]">' +
            '<span class="color-red">*</span>' +
            '职位名称：' +
          '</label>' +
          '<div class="input-group" data-toggle="jobtypepicker">' +
            '<input type="hidden" name="work_experience[' + worksCount + '][job_type][st]">' +
            '<input type="hidden" name="work_experience[' + worksCount + '][job_type][nd]">' +
            '<input type="hidden" name="work_experience[' + worksCount + '][job_type][rd]">' +
            '<input type="text" class="form-control jobshow normal append" placeholder="请选择" autocomplete="off">' +
            '<div class="input-group-append" data-toggle="modal" data-target="#jobtypeModal">' +
              '<span class="input-group-text" id="basic-addon2">' +
                '<svg class="bi bi-calendar" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">' +
                  '<path fill-rule="evenodd" d="M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1zm1-3a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2z"/>' +
                  '<path fill-rule="evenodd" d="M3.5 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5zm9 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5z"/>' +
                '</svg>' +
              '</span>' +
            '</div>' +
          '</div>' +
        '</div>' +
        '<div class="form-group form-inline">' +
          '<label for="work_experience[' + worksCount + '][salary]"><span class="color-red">*</span>月薪：</label>' +
          '<div class="input-group">' +
            '<input type="text" name="work_experience[' + worksCount + '][salary]" class="form-control small append" autocomplete="off" data-type="int">' +
            '<div class="input-group-append">' +
              '<div class="input-group-text">K</div>' +
            '</div>' +
          '</div>' +
          '<label class="ml-1 mr-1">*</label>' +
          '<div class="input-group">' +
            '<input type="text" name="work_experience[' + worksCount + '][salary_count]" class="form-control small append" autocomplete="off" data-type="int">' +
            '<div class="input-group-append">' +
              '<div class="input-group-text">月</div>' +
            '</div>' +
            '</div>' +
        '</div>' +
        '<div class="form-group form-inline">' +
          '<label for="work_experience[' + worksCount + '][subordinates]">下属人数：</label>' +
          '<input type="text" name="work_experience[' + worksCount + '][subordinates]" class="form-control normal" placeholder="请填写" autocomplete="off" data-type="int">' +
        '</div>' +
        '<div class="form-group form-inline">' +
          '<label for="work_experience[' + worksCount + '][start_at]"><span class="color-red">*</span>在职时间：</label>' +
          '<div class="input-group date datemonthpicker">' +
            '<input type="text" name="work_experience[' + worksCount + '][start_at]" class="form-control mini append" placeholder="入职时间" autocomplete="off">' +
            '<div class="input-group-append">' +
              '<span class="input-group-text">' +
                '<svg class="bi bi-calendar3-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">' +
                  '<path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2H0z"/>' +
                  '<path fill-rule="evenodd" d="M0 3h16v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3zm6.5 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-8 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-8 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>' +
                '</svg>' +
              '</span>' +
            '</div>' +
          '</div>' +
          '<label class="ml-1 mr-1">——</label>' +
          '<div class="input-group date datemonthpicker">' +
            '<input type="text" name="work_experience[' + worksCount + '][end_at]" class="form-control mini append" placeholder="离职时间" autocomplete="off">' +
            '<div class="input-group-append">' +
              '<span class="input-group-text">' +
                '<svg class="bi bi-calendar3-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">' +
                  '<path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2H0z"/>' +
                  '<path fill-rule="evenodd" d="M0 3h16v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3zm6.5 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-8 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-8 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>' +
                '</svg>' +
              '</span>' +
            '</div>' +
          '</div>' +
          '<div class="custom-control custom-checkbox custom-control-inline ml-3">' +
            '<input type="checkbox" name="work_experience[' + worksCount + '][is_not_end]" id="workAtNow-' + worksCount + '" class="custom-control-input" onclick="setNotEnd($(this))">' +
            '<label class="custom-control-label" for="workAtNow-' + worksCount + '">至今</label>' +
          '</div>' +
        '</div>' +
        '<div class="form-group form-inline">' +
          '<label for="work_experience[' + worksCount + '][work_desc]">' +
            '<span class="color-red">*</span>' +
            '工作描述：' +
          '</label>' +
          '<textarea name="work_experience[' + worksCount + '][work_desc]" class="form-control normal" placeholder="请填写"></textarea>' +
        '</div>' +
      '</div>'
    ;

    $('#work_experience').children("div:last-child").after($('<div>').attr('id', 'work-' + worksCount).addClass('border border-gray rounded pt-4 pb-4 mb-4').html(work));

    worksCount = worksCount + 1;
  }

  function dropWork(index)
  {
    if (index == 0) {
      return;
    }

    $('#work-' + index).remove();
  }

  function addProject()
  {
    let project =
      '<div class="color-red float-right cursor-pointer mr-4" onclick="dropProject(' + projectsCount + ')">X</div>' +
      '<div class="form-group form-inline">' +
        '<label for="project_experience[' + projectsCount + '][name]">' +
          '项目名称：' +
        '</label>' +
        '<input type="text" name="project_experience[' + projectsCount + '][name]" class="form-control normal" placeholder="请填写" autocomplete="off">' +
      '</div>' +
      '<div class="form-group form-inline">' +
        '<label for="project_experience[' + projectsCount + '][role]">' +
          '担任角色：' +
        '</label>' +
        '<input type="text" name="project_experience[' + projectsCount + '][role]" class="form-control normal" placeholder="请填写" autocomplete="off">' +
      '</div>' +
      '<div class="form-group form-inline">' +
        '<label for="project_experience[' + projectsCount + '][start_at]">' +
          '项目时间：' +
        '</label>' +
        '<div class="input-group date datemonthpicker">' +
          '<input type="text" name="project_experience[' + projectsCount + '][start_at]" class="form-control mini append" placeholder="开始时间" autocomplete="off">' +
          '<div class="input-group-append">' +
            '<span class="input-group-text">' +
              '<svg class="bi bi-calendar3-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">' +
                '<path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2H0z"/>' +
                '<path fill-rule="evenodd" d="M0 3h16v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3zm6.5 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-8 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-8 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>' +
              '</svg>' +
            '</span>' +
          '</div>' +
        '</div>' +
        '<label class="ml-1 mr-1">——</label>' +
        '<div class="input-group date datemonthpicker">' +
          '<input type="text" name="project_experience[' + projectsCount + '][end_at]" class="form-control mini append" placeholder="结束时间" autocomplete="off">' +
          '<div class="input-group-append">' +
            '<span class="input-group-text">' +
              '<svg class="bi bi-calendar3-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">' +
                '<path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2H0z"/>' +
                '<path fill-rule="evenodd" d="M0 3h16v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3zm6.5 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-8 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-8 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>' +
              '</svg>' +
            '</span>' +
          '</div>' +
        '</div>' +
        '<div class="custom-control custom-checkbox custom-control-inline ml-3">' +
          '<input type="checkbox" name="project_experience[' + projectsCount + '][is_not_end]" id="projectAtNow-' + projectsCount + '" class="custom-control-input" onclick="setNotEnd($(this))">' +
          '<label class="custom-control-label" for="projectAtNow-' + projectsCount + '">至今</label>' +
        '</div>' +
      '</div>' +
      '<div class="form-group form-inline">' +
        '<label for="project_experience[' + projectsCount + '][body]">' +
          '项目内容：' +
        '</label>' +
        '<textarea name="project_experience[' + projectsCount + '][body]" class="form-control normal" placeholder="请填写"></textarea>' +
      '</div>'
    ;

    $('#project_experience').children("div:last-child").after($('<div>').attr('id', 'project-' + projectsCount).addClass('border border-gray rounded pt-4 pb-4 mb-4').html(project));

    projectsCount = projectsCount + 1;
  }

  function dropProject(index)
  {
    if (index == 0) {
      return;
    }

    $('#project-' + index).remove();
  }

  function addEducation()
  {
    let education =
      '<div class="color-red float-right cursor-pointer mr-4" onclick="dropEducation(' + educationsCount + ')">X</div>' +
      '<div class="form-group form-inline">' +
        '<label for="education_experience[' + educationsCount + '][school_name]">' +
          '<span class="color-red">*</span>' +
          '毕业院校：' +
        '</label>' +
        '<input type="text" name="education_experience[' + educationsCount + '][school_name]" class="form-control normal" placeholder="请填写" autocomplete="off">' +
      '</div>' +
      '<div class="form-group form-inline">' +
        '<label for="education_experience[' + educationsCount + '][school_level]">' +
          '<span class="color-red">*</span>' +
          '最高学历：' +
        '</label>' +
        '<select name="education_experience[' + educationsCount + '][school_level]" class="form-control normal">' +
          '<option hidden value="">请选择</option>' +
          @foreach (trans('db.education') as $key => $education)
            '<option value="{{ $key }}">{{ $education }}</option>' +
          @endforeach
        '</select>' +
      '</div>' +
      '<div class="form-group form-inline">' +
        '<label for="education_experience[' + educationsCount + '][major]">' +
          '所学专业：' +
        '</label>' +
        '<input type="text" name="education_experience[' + educationsCount + '][major]" class="form-control normal" placeholder="请填写" autocomplete="off">' +
      '</div>' +
      '<div class="form-group form-inline">' +
        '<label for="education_experience[' + educationsCount + '][start_at]">' +
          '在校时间：' +
        '</label>' +
        '<div class="input-group date datemonthpicker">' +
          '<input type="text" name="education_experience[' + educationsCount + '][start_at]" class="form-control mini append" placeholder="入学时间" autocomplete="off">' +
          '<div class="input-group-append">' +
            '<span class="input-group-text">' +
              '<svg class="bi bi-calendar3-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">' +
                '<path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2H0z"/>' +
                '<path fill-rule="evenodd" d="M0 3h16v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3zm6.5 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-8 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-8 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>' +
              '</svg>' +
            '</span>' +
          '</div>' +
        '</div>' +
        '<label class="ml-1 mr-1">——</label>' +
        '<div class="input-group date datemonthpicker">' +
          '<input type="text" name="education_experience[' + educationsCount + '][end_at]" class="form-control mini append" placeholder="毕业时间" autocomplete="off">' +
          '<div class="input-group-append">' +
            '<span class="input-group-text">' +
              '<svg class="bi bi-calendar3-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">' +
                '<path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2H0z"/>' +
                '<path fill-rule="evenodd" d="M0 3h16v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3zm6.5 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-8 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-8 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>' +
              '</svg>' +
            '</span>' +
          '</div>' +
        '</div>' +
        '<div class="custom-control custom-checkbox custom-control-inline ml-3">' +
          '<input type="checkbox" name="education_experience[' + educationsCount + '][is_not_end]" id="educationAtNow-' + educationsCount + '" class="custom-control-input" onclick="setNotEnd($(this))">' +
          '<label class="custom-control-label" for="educationAtNow-' + educationsCount + '">至今</label>' +
        '</div>' +
      '</div>'
    ;

    $('#education_experience').children("div:last-child").after($('<div>').attr('id', 'education-' + educationsCount).addClass('border border-gray rounded pt-4 pb-4 mb-4').html(education));

    educationsCount = educationsCount + 1;
  }

  function dropEducation(index)
  {
    if (index == 0) {
      return;
    }

    $('#education-' + index).remove();
  }

  $('input[name="attachment"]').change(function() {
    $('#inputAppend').val($(this).val());
  });

  $('.form-control').change(function () {

    @if (count($errors) > 0)
      if ($(this).val() === '' && $(this).hasClass('must')) {
        $(this).addClass('border-danger');
      } else {
        $(this).removeClass('border-danger');
      }
    @endif

    if ($(this).hasClass('jobshow')) {
      let rd = $(this).prev('input[type="hidden"]');
      let nd = rd.prev('input[type="hidden"]');
      let st = nd.prev('input[type="hidden"]');
      rd.val($(this).val());
      nd.val($(this).val());
      st.val($(this).val());
    }

    if ($(this).hasClass('industryshow')) {
      let th = $(this).prev('input[type="hidden"]');
      let rd = th.prev('input[type="hidden"]');
      let nd = rd.prev('input[type="hidden"]');
      let st = nd.prev('input[type="hidden"]');
      th.val($(this).val());
      rd.val($(this).val());
      nd.val($(this).val());
      st.val($(this).val());
    }
  })

  // $('.form-control').bind('input propertychange', function() {
  //   if ($(this).val() === '' && $(this).hasClass('must')) {
  //     $(this).addClass('border-danger');
  //   } else {
  //     $(this).removeClass('border-danger');
  //   }
  // })

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
