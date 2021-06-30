@extends('layouts.default')
@section('title', '编辑职位')
@section('content')
<div class="job-create bg-white">
    <div class="default-form">
        <div class="form-header"></div>
        <hr class="divider">
        <div class="form-body">
            @include('shared._errors')
            <form class="text-center" method="POST" action="{{ route('jobs.update', $job->id) }}">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="form-title text-left">
                    <h5>企业基本信息</h5>
                </div>
                <div class="form-group form-inline">
                    <label for="company"><span class="color-red">*</span>公司名称：</label>
                    <select name="company_id" class="form-control normal" value="{{  old('company_id')}}" onchange="companySelect()">
                        <option value="">请填写</option>
                        @foreach ($companys as $index => $company)
                            <option value="{{ $company->id }}" @if($company->id === $job->company->id) selected="selected" @endif data-item="{{ json_encode($company) }}">{{ $company->name }}</option>
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
                    <div class="row">
                      <div class="col" id="companyNickname">
                      </div>
                    </div>
                    <div class="row row-cols-2">
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
                    </div>
                    <hr class="divider">
                    <div class="row">
                      <div class="col col-auto">
                        <div id="companyIntroduction"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group form-inline">
                    <label for="quota">招聘人数：</label>
                    <input type="text" name="quota" class="form-control normal" value="{{  $job->quota }}" placeholder="请填写" autocomplete="off" data-type="int">
                </div>
                <div class="form-title text-left">
                    <h5>职业基本信息</h5>
                </div>
                <div class="form-group form-inline">
                    <label for="name"><span>*</span>职位名称：</label>
                    <input type="text" name="name" class="form-control normal" value="{{  $job->name }}" placeholder="请输入职位名称"  />
                </div>
                <div class="form-group form-inline">
                    <label for="type"><span>*</span>职位类别：</label>
                    <div class="input-group" data-toggle="jobtypepicker">

                      <input type="hidden" name="type[st]" value="{{ $job->type->st }}">
                      <input type="hidden" name="type[nd]" value="{{ $job->type->nd }}">
                      <input type="hidden" name="type[rd]" value="{{ $job->type->rd }}">

                      <input type="text" class="form-control normal" id="jobType" value="{{ $job->type->rd }}" placeholder="请选择" autocomplete="off">
                      <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2">
                          <svg class="bi bi-calendar" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1zm1-3a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2z"/>
                            <path fill-rule="evenodd" d="M3.5 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5zm9 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5z"/>
                          </svg>
                        </span>
                      </div>
                    </div>
                    <div hidden data-toggle="distpicker" data-source="jobTypes">
                      <select class="form-control" name="type[st]" data-province="{{ $job->type->st }}"></select>
                      <select class="form-control" name="type[nd]"  data-city="{{ $job->type->nd }}"></select>
                      <select class="form-control" name="type[rd]"  data-district="{{ $job->type->rd }}"></select>
                    </div>
                </div>
                <div class="form-group form-inline">
                    <label for="nature"><span>*</span>工作性质：</label>
                    <select name="nature" class="form-control normal">
                        @foreach($job->natureArr as $key => $nature)
                            <option value="{{ $key }}" {{ $nature['selected'] }}>{{ $nature['text'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group form-inline">
                    <label for="city"><span>*</span>工作城市：</label>
                    <div data-toggle="distpicker">
                      <select class="form-control" name="location[province]" data-province="{{ $job->location->province }}"></select>
                      <select class="form-control" name="location[city]"  data-city="{{ $job->location->city }}"></select>
                      <select class="form-control" name="location[district]"  data-district="{{ $job->location->district }}"></select>
                    </div>
                </div>
                <div class="form-group form-inline">
                    <label for="salary"><span>*</span>税前月薪：</label>
                    <div class="input-group">
                        <input type="text" name="salary_min" class="form-control small" value="{{  $job->salary_min }}"  />
                        <div class="input-group-append">
                            <div class="input-group-text">K</div>
                        </div>
                    </div>
                    <label class="ml-1 mr-1">-</label>
                    <div class="input-group">
                        <input type="text" name="salary_max" class="form-control small" value="{{  $job->salary_max }}"  />
                        <div class="input-group-append">
                            <div class="input-group-text">K</div>
                        </div>
                    </div>
                </div>
                <div class="form-group form-inline">
                    <label for="welfare"><span>*</span>福利待遇：</label>
                    <select name="welfare" class="form-control normal">
                        @foreach($job->welfareArr as $key => $welfare)
                            <option value="{{ $key }}" {{ $welfare['selected'] }}>{{ $welfare['text'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group form-inline">
                    <label for="sparkle">职位亮点：</label>
                    <input type="text" name="sparkle" class="form-control normal" value="{{  $job->sparkle }}" placeholder="请填写" />
                </div>
                <div class="form-title text-left">
                    <h5>职位要求</h5>
                </div>
                <div class="form-group form-inline">
                    <label for="age"><span>*</span>年龄范围：</label>
                    <div class="input-group">
                        <input type="text" name="age_min" class="form-control small" value="{{  $job->age_min }}"  />
                        <div class="input-group-append">
                            <div class="input-group-text">岁</div>
                        </div>
                    </div>
                    <label class="ml-1 mr-1">-</label>
                    <div class="input-group">
                        <input type="text" name="age_max" class="form-control small" value="{{  $job->age_max }}"  />
                        <div class="input-group-append">
                            <div class="input-group-text">岁</div>
                        </div>
                    </div>
                </div>
                <div class="form-group form-inline">
                    <label for="education"><span>*</span>学历要求：</label>
                    <select name="education" class="form-control normal">
                        @foreach($job->educationArr as $key => $education)
                            <option value="{{ $key }}" {{ $education['selected'] }}>{{ $education['text'] }}</option>
                        @endforeach
                    </select>
                    <label class="ml-2">及以上</label>
                </div>
                <div class="form-group form-inline">
                    <label for="experience"><span>*</span>经验要求：</label>
                    <select name="experience" class="form-control normal">
                        @foreach($job->experienceArr as $key => $experience)
                            <option value="{{ $key }}" {{ $experience['selected'] }}>{{ $experience['text'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group form-inline">
                    <label for="duty"><span>*</span>工作职责：</label>
                    <textarea name="duty" class="form-control normal">{{  $job->duty }}</textarea>
                </div>
                <div class="form-group form-inline">
                    <label for="requirement"><span>*</span>任职要求：</label>
                    <textarea name="requirement" class="form-control normal">{{  $job->requirement }}</textarea>
                </div>
                <div class="form-title text-left">
                    <h5>发布设置</h5>
                </div>
                <div class="form-group form-inline">
                    <label for="urgency_level"><span>*</span>紧急程度：</label>
                    @foreach ($job->urgencyLevelArr as $key => $urgencyLevel)
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="urgency_level_{{ $key }}" name="urgency_level" class="custom-control-input" value="{{ $key }}" {{ $urgencyLevel['checked'] }}>
                            <label class="custom-control-label" for="urgency_level_{{ $key }}">{{ $urgencyLevel['text'] }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="form-group form-inline">
                    <label for="channel"><span>*</span>渠道选择：</label>
                    @foreach ($job->channelArr as $key => $channel)
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input" id="channel_{{ $key }}" name="channel[{{ $key }}]" {{ $channel['checked'] }}
                            @if (isset($channel['has_remark']) && $channel['has_remark'])
                              onclick='setRemark()'
                            @endif
                            >
                            <label class="custom-control-label" for="channel_{{ $key }}">{{ $channel['text'] }}</label>
                        </div>
                    @endforeach
                    <input style="visibility: hidden;" type="text" name="channel_remark" class="form-control" id="channelRemark" value="{{  $job->channel_remark }}" placeholder="请选择招聘平台">
                </div>
                <div class="form-group form-inline">
                    <label for="deadline"><span>*</span>截止日期：</label>
                    <div class="input-group date datetimepicker">
                      <input type="text" name="deadline" class="form-control normal append" value="{{  $job->deadline }}" placeholder="请选择" autocomplete="off">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <svg class="bi bi-calendar3-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2H0z"/>
                            <path fill-rule="evenodd" d="M0 3h16v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3zm6.5 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-8 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-8 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                          </svg>
                        </span>
                      </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-danger btn-form-submit">确认修改</button>
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

    var nickname = company.nickname == null ? company.name : company.nickname;
    $('#companyNickname').addClass('text-truncate').attr('title', nickname).text(nickname);

    var location = company.location;
    var locationShow = location.province;
    if (location.city !== null) {
      locationShow = locationShow + '-' + location.city;
    }
    if (location.district !== null) {
      locationShow = locationShow + '-' + location.district;
    }
    $('#companyLocation').addClass('text-truncate').attr('title', locationShow).text(locationShow);

    var natureArr = JSON.parse('{!! json_encode(App\Models\Company::natureArr) !!}');
    console.log(natureArr.length);
    if (natureArr.hasOwnProperty(company.nature)) {
      var natureShow = natureArr[company.nature].text;
    } else {
      var natureShow = '无';
    }
    $('#companyNature').addClass('text-truncate').attr('title', natureShow).text(natureShow);

    var scaleArr = JSON.parse('{!! json_encode(App\Models\Company::scaleArr) !!}');
    if (scaleArr.hasOwnProperty(company.scale)) {
      var scaleShow = scaleArr[company.scale].text;
    } else {
      var scaleShow = '无';
    }
    $('#companyScale').addClass('text-truncate').attr('title', scaleShow).text(scaleShow);

    var industry = company.industry;
    if (industry.th == null) {
      var industryShow = '无';
    } else {
      var industryShow = industry.th;
    }
    $('#companyIndustry').addClass('text-truncate').attr('title', industryShow).text(industryShow);

    var introduction = company.introduction == null ? '无' : company.introduction;
    $('#companyIntroduction').attr('title', introduction).text('介绍：'+introduction);
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

  companySelect();
  setRemark();

</script>

@stop
