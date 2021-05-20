@extends('layouts.default')
@section('title', '发布职位')
@section('content')
<div class="job-create bg-white">
    <div class="default-form">
        <div class="form-header"></div>
        <hr class="divider">
        <div class="form-body">
            <form class="text-center" method="POST">
                {{ csrf_field() }}
                @if(!empty($draftId))
                  <input type="hidden" name="draft_id" value="{{ $draftId }}">
                @endif
                <div class="form-title text-left">
                    <h5>企业基本信息</h5>
                </div>
                <div class="form-group form-inline">
                    <label for="company"><span class="color-red">*</span>公司名称：</label>
                    <select name="company_id" class="form-control normal" value="{{  old('company_id')}}" onchange="companySelect()">
                        <option value="">请填写</option>
                        @foreach ($companys as $index => $company)
                            <option value="{{ $company->id }}" @if(isset($oldData['company']->id) && $company->id === $oldData['company']->id) selected="selected" @endif data-item="{{ json_encode($company) }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                    <div>
                      <a href="#" class="color-red" data-toggle="modal" data-target="#companyModal">
                        <span>+</span>新增企业
                      </a>
                    </div>
                </div>
                <div style="display: none;" class="form-group form-inline text-left" id="companyPre">
                    <label class="align-self-start"><span class="color-red">*</span>企业信息预览：</label>
                    <div class="company-pre">
                      <div class="row row-cols-2">
                        <div class="col col-12" id="companyNickname">
                        </div>
                        <div class="col">
                          <div class="row align-items-center">
                            <div class="col col-auto align-self-center">
                              <div class="circle-red"></div>
                            </div>
                            <div class="col col-auto">
                              <div id="companyLocation"></div>
                            </div>
                          </div>
                        </div>
                        <div class="col">
                          <div class="row align-items-center">
                            <div class="col col-auto align-self-center">
                              <div class="circle-red"></div>
                            </div>
                            <div class="col col-auto">
                              <div id="companyNature"></div>
                            </div>
                          </div>
                        </div>
                        <div class="col">
                          <div class="row align-items-center">
                            <div class="col col-auto align-self-center">
                              <div class="circle-red"></div>
                            </div>
                            <div class="col col-auto">
                              <div id="companyScale"></div>
                            </div>
                          </div>
                        </div>
                        <div class="col">
                          <div class="row align-items-center">
                            <div class="col col-auto align-self-center">
                              <div class="circle-red"></div>
                            </div>
                            <div class="col col-auto">
                              <div id="companyIndustry"></div>
                            </div>
                          </div>
                        </div>
                        <div class="col col-12">
                          <hr class="divider"></div>
                          <div class="col col-12" id="companyIntroduction"></div>
                      </div>
                    </div>
                </div>
                <div class="form-group form-inline">
                    <label for="quota">招聘人数：</label>
                    <input type="text" name="quota" class="form-control normal" value="{{ isset($oldData['quota']) ? $oldData['quota'] : old('quota') }}" placeholder="请填写" autocomplete="off" data-type="int">
                </div>
                <div class="form-title text-left">
                    <h5>职业基本信息</h5>
                </div>
                <div class="form-group form-inline">
                    <label for="name"><span class="color-red">*</span>职位名称：</label>
                    <input type="text" name="name" class="form-control normal" value="{{ isset($oldData['name']) ? $oldData['name'] : old('name') }}" placeholder="请输入职位名称">
                </div>
                <div class="form-group form-inline">
                    <label for="type"><span class="color-red">*</span>职位类别：</label>
                    <div class="input-group" data-toggle="jobtypepicker">

                      <input type="hidden" name="type[st]" value="{{ isset($oldData['type']['st']) ? $oldData['type']['st'] : '' }}">
                      <input type="hidden" name="type[nd]" value="{{ isset($oldData['type']['nd']) ? $oldData['type']['nd'] : '' }}">
                      <input type="hidden" name="type[rd]" value="{{ isset($oldData['type']['rd']) ? $oldData['type']['rd'] : '' }}">

                      <input type="text" class="form-control normal" id="jobType" value="{{ isset($oldData['type']['rd']) ? $oldData['type']['rd'] : '' }}" placeholder="请选择" autocomplete="off">
                      <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2">
                          <svg class="bi bi-calendar" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1zm1-3a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2z"/>
                            <path fill-rule="evenodd" d="M3.5 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5zm9 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5z"/>
                          </svg>
                        </span>
                      </div>
                    </div>
                    <!-- <div hidden data-toggle="distpicker" data-source="jobTypes">
                      <select class="form-control" name="type[st]" data-province="{{ isset($oldData['type']['st']) ? $oldData['type']['st'] : '---- 请选择 ----'}}"></select>
                      <select class="form-control" name="type[nd]" data-city="{{ isset($oldData['type']['nd']) ? $oldData['type']['nd'] : '---- 请选择 ----'}}"></select>
                      <select class="form-control" name="type[rd]" data-district="{{ isset($oldData['type']['rd']) ? $oldData['type']['rd'] : '---- 请选择 ----'}}"></select>
                    </div> -->
                </div>
                <div class="form-group form-inline">
                    <label for="nature"><span class="color-red">*</span>工作性质：</label>
                    <select name="nature" class="form-control normal" value="{{  old('nature')}}">
                        @foreach (App\Models\Job::natureArr as $key => $nature)
                            <option value="{{ $key }}" @if(isset($oldData['nature']) && $key === $oldData['nature']) selected="selected" @endif>{{ $nature['text'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group form-inline">
                    <label for="location"><span class="color-red">*</span>工作城市：</label>
                    <div data-toggle="distpicker">
                      <select class="form-control" name="location[province]" data-province="{{ isset($oldData['location']['province']) ? $oldData['location']['province'] : '---- 选择省 ----' }}"></select>
                      <select class="form-control" name="location[city]"  data-city="{{ isset($oldData['location']['city']) ? $oldData['location']['city'] : '---- 选择市 ----' }}"></select>
                      <select class="form-control" name="location[district]"  data-district="{{ isset($oldData['location']['district']) ? $oldData['location']['district'] : '---- 选择区 ----' }}"></select>
                    </div>
                </div>
                <div class="form-group form-inline">
                    <label for="salary"><span class="color-red">*</span>税前月薪：</label>
                    <div class="input-group">
                        <input type="text" name="salary_min" class="form-control small" value="{{ isset($oldData['salary_min']) ? $oldData['salary_min'] : old('salary_min') }}" autocomplete="off" data-type="int">
                        <div class="input-group-append">
                            <div class="input-group-text">K</div>
                        </div>
                    </div>
                    <label class="ml-1 mr-1">-</label>
                    <div class="input-group">
                        <input type="text" name="salary_max" class="form-control small" value="{{ isset($oldData['salary_max']) ? $oldData['salary_max'] : old('salary_max') }}" autocomplete="off" data-type="int">
                        <div class="input-group-append">
                            <div class="input-group-text">K</div>
                        </div>
                    </div>
                </div>
                <div class="form-group form-inline">
                    <label for="welfare"><span class="color-red">*</span>福利待遇：</label>
                    <select name="welfare" class="form-control normal" value="{{ old('welfare') }}">
                        @foreach(App\Models\Job::welfareArr as $key => $welfare)
                            <option value="{{ $key }}" @if(isset($oldData['welfare']) && $key === $oldData['welfare']) selected="selected" @endif>{{ $welfare['text'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group form-inline">
                    <label for="sparkle">职位亮点：</label>
                    <input type="text" name="sparkle" class="form-control normal" value="{{ isset($oldData['sparkle']) ? $oldData['sparkle'] : old('sparkle') }}" placeholder="请填写" autocomplete="off">
                </div>
                <div class="form-title text-left">
                    <h5>职位要求</h5>
                </div>
                <div class="form-group form-inline">
                    <label for="age"><span class="color-red">*</span>年龄范围：</label>
                    <div class="input-group">
                        <input type="text" name="age_min" class="form-control small" value="{{ isset($oldData['age_min']) ? $oldData['age_min'] : old('age_min') }}" autocomplete="off" data-type="int">
                        <div class="input-group-append">
                            <div class="input-group-text">岁</div>
                        </div>
                    </div>
                    <label class="ml-1 mr-1">-</label>
                    <div class="input-group">
                        <input type="text" name="age_max" class="form-control small" value="{{ isset($oldData['age_max']) ? $oldData['age_max'] : old('age_max') }}" autocomplete="off" data-type="int">
                        <div class="input-group-append">
                            <div class="input-group-text">岁</div>
                        </div>
                    </div>
                </div>
                <div class="form-group form-inline">
                    <label for="education"><span class="color-red">*</span>学历要求：</label>
                    <select name="education" class="form-control normal" value="{{ old('education') }}">
                        @foreach(App\Models\Job::educationArr as $key => $education)
                            <option value="{{ $key }}" @if(isset($oldData['education']) && $key === $oldData['education']) selected="selected" @endif>{{ $education['text'] }}</option>
                        @endforeach
                    </select>
                    <label class="ml-2">及以上</label>
                </div>
                <div class="form-group form-inline">
                    <label for="experience"><span class="color-red">*</span>经验要求：</label>
                    <select name="experience" class="form-control normal" value="{{ old('experience') }}">
                        @foreach(App\Models\Job::experienceArr as $key => $experience)
                            <option value="{{ $key }}" @if(isset($oldData['experience']) && $key === $oldData['experience']) selected="selected" @endif>{{ $experience['text'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group form-inline">
                    <label for="duty"><span class="color-red">*</span>工作职责：</label>
                    <textarea name="duty" class="form-control normal">{{ isset($oldData['duty']) ? $oldData['duty'] : old('duty') }}</textarea>
                </div>
                <div class="form-group form-inline">
                    <label for="requirement"><span class="color-red">*</span>任职要求：</label>
                    <textarea name="requirement" class="form-control normal">{{ isset($oldData['requirement']) ? $oldData['requirement'] : old('requirement') }}</textarea>
                </div>
                <div class="form-title text-left">
                    <h5>发布设置</h5>
                </div>
                <div class="form-group form-inline">
                    <label for="urgency_level"><span class="color-red">*</span>紧急程度：</label>
                    @foreach (App\Models\Job::urgencyLevelArr as $key => $urgencyLevel)
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="urgency_level_{{ $key }}" name="urgency_level" class="custom-control-input" value="{{ $key }}"
                              @if (isset($oldData['urgency_level']))
                                @if ($key == $oldData['urgency_level'])
                                  checked
                                @endif
                              @elseif (!empty($urgencyLevel['checked']))
                                checked
                              @endif
                            >
                            <label class="custom-control-label" for="urgency_level_{{ $key }}">{{ $urgencyLevel['text'] }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="form-group form-inline">
                    <label for="channel"><span class="color-red">*</span>渠道选择：</label>
                    @foreach (App\Models\Job::channelArr as $key => $channel)
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input" id="channel_{{ $key }}" name="channel[{{ $key }}]"
                              @if (isset($oldData['channel']))
                                @if (in_array($key, json_decode($oldData['channel'], true)))
                                  checked
                                @endif
                              @elseif (!empty($channel['checked']))
                                checked
                              @endif
                            >
                            <label class="custom-control-label" for="channel_{{ $key }}">{{ $channel['text'] }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="form-group form-inline">
                  <label for="deadline"><span class="color-red">*</span>截止日期：</label>
                  <div class="input-group date" id="datetimepicker1">
                    <input type="text" name="deadline" class="form-control normal" value="{{ isset($oldData['deadline']) ? $oldData['deadline'] : old('deadline') }}" placeholder="请选择" autocomplete="off">
                    <span class="input-group-text">
                    <!-- <span class="glyphicon glyphicon-calendar"></span> -->
                      <svg class="bi bi-calendar3-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2H0z"/>
                        <path fill-rule="evenodd" d="M0 3h16v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3zm6.5 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-8 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-8 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                      </svg>
                    </span>
                  </div>
                </div>
                <button type="submit" class="btn btn-danger btn-form-submit" onclick="this.form.action='{{ route('jobs.store') }}'">发布职位</button>
                <button type="submit" class="btn btn-light btn-form-submit" onclick="this.form.action='{{ route('drafts.store') }}'">保存草稿</button>
            </form>
        </div>
    </div>
</div>
@include('companys.shared._company_create')
@include('shared._industry')
@include('shared._job_type')
@include('shared._errors')
<script type="text/javascript">
  function companySelect()
  {
    var data = $('select option:selected').attr('data-item');
    if (typeof(data) == 'undefined') {
      $('#companyPre').hide('fast');
      return;
    }
    var company = JSON.parse(data);
    $('#companyPre').show('fast');
    $('#companyNickname').addClass('text-truncate').attr('title', company.nickname).text(company.nickname);
    $('#companyLocation').addClass('text-truncate').attr('title', company.location).text(company.location);
    $('#companyNature').addClass('text-truncate').attr('title', company.nature).text(company.nature);
    $('#companyScale').addClass('text-truncate').attr('title', company.scale).text(company.scale);
    $('#companyIndustry').addClass('text-truncate').attr('title', company.industry).text(company.industry);
    $('#companyIntroduction').addClass('text-truncate').attr('title', company.introduction).text('介绍：'+company.introduction);
  }
</script>
@stop
