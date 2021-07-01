@extends('layouts.default')
@section('title', '搜索简历')
@section('content')
<div class="resume-search">
  <form id="resumeSearchForm" method="GET" action="{{ route('resumes.list') }}">
    <div class="resume-search-form">
      <div class="row">
        <div class="col col-12">
          <div class="resume-search-header">
            <div class="row row-cols-2">
              <div class="col col-12">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">全部关键词</span>
                    </div>
                    <input style="border-top-left-radius: 0; border-bottom-left-radius: 0;" type="text" name="all" value="{{ isset($parms['all']) ? $parms['all'] : '' }}" class="form-control form-control-lg append" placeholder="请用空格隔开多个中文关键词，逗号隔开多个英文词组（如：design,tester）" autocomplete="off">
                    <div class="input-group-append" data-toggle="modal">
                      <button class="btn btn-search">搜索</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <div class="row no-gutters align-items-center">
                    <div class="col col-auto">
                      <label for="job_name">职位名称：</label>
                    </div>
                    <div class="col">
                      <div class="input-group">
                      <input type="text" name="job_name" value="{{ isset($parms['job_name'] ) ? $parms['job_name']  : ''}}" class="form-control" placeholder="空格隔开多个中文 逗号隔开英文" autocomplete="off">
                      <div class="input-group-append" data-toggle="modal">
                        <button class="btn btn-secondary">确定</button>
                      </div>
                    </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <div class="row no-gutters align-items-center">
                    <div class="col col-auto">
                      <label for="company_name">公司名称：</label>
                    </div>
                    <div class="col">
                      <div class="input-group">
                      <input type="text" name="company_name" value="{{ isset($parms['company_name']) ? $parms['company_name'] : '' }}" class="form-control" placeholder="空格隔开多个中文 逗号隔开英文" autocomplete="off">
                      <div class="input-group-append" data-toggle="modal">
                        <button class="btn btn-secondary">确定</button>
                      </div>
                    </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group form-inline">
                  <div class="row no-gutters">
                    <div class="col col-auto">
                      <label>发布中的职位：</label>
                    </div>
                    <div class="col">
                      @if (count($jobs) > 0)
                        <form id="curJobs" method="GET" action="{{ route('resumes.list') }}">
                          <input type="hidden" name="job_id">
                          <div class="row row-cols-2">
                            @foreach ($jobs as $job)
                              <div class="col col-auto mb-3">
                                <div class="cur-jobs font-size-m mr-4 p-1" onclick="searchByCurJob('{{ $job }}', '{{ $job->company->name }}')">
                                  <p class="text-truncate m-1" title="{{ sprintf('%s | %s | %s', $job->company->name, $job->location_show, $job->salary_show) }}">
                                    <span>{{ $job->name }}</span>
                                    <span class="color-silvery-gray text-truncate">（{{ $job->company->name }} | </span>
                                    <span class="color-silvery-gray text-truncate">{{ $job->location_show }} | </span>
                                    <span class="color-silvery-gray text-truncate">{{ $job->salary_show }}）</span>
                                  </p>
                                </div>
                                <input type="hidden" data-jobid="{{ $job }}">
                              </div>
                            @endforeach
                          </div>
                        </form>
                      @else
                        <label>暂无</label>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row text-center mt-3">
        <div class="col">
          <a id="btnToggleDetail" class="a-gray" href="javascript:void(0);" onclick="toggleDetail($(this))">+ 展开更多条件</a>
        </div>
      </div>

      <div id="resumeSearchDetail" class="mt-3">
        <div class="resume-search-body">
          <div class="row">
            <div class="col">
              <div class="row row-cols-2 justify-content-between">
                <div class="col">
                  <div class="form-group form-inline">
                    <label for="location">目前城市：</label>
                    <div data-toggle="distpicker">
                      <select class="form-control normal" name="location[province]" data-province="{{ isset($parms['location']['province']) ? $parms['location']['province'] : '省' }}"></select>
                      <select class="form-control normal" name="location[city]"  data-city="{{ isset($parms['location']['city']) ? $parms['location']['city'] : '市' }}"></select>
                      <select class="form-control normal" name="location[district]"  data-district="{{ isset($parms['location']['district']) ? $parms['location']['district'] : '区' }}"></select>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group form-inline">
                    <label for="exp_location">期望城市：</label>
                    <div data-toggle="distpicker">
                      <select class="form-control normal" name="exp_location[province]" data-province="{{ isset($parms['exp_location']['province']) ? $parms['exp_location']['province'] : '省' }}"></select>
                      <select class="form-control normal" name="exp_location[city]"  data-city="{{ isset($parms['exp_location']['city']) ? $parms['exp_location']['city'] : '市' }}"></select>
                      <select class="form-control normal" name="exp_location[district]"  data-district="{{ isset($parms['exp_location']['district']) ? $parms['exp_location']['district'] : '区' }}"></select>
                    </div>
                  </div>
                </div>

                <div class="col">
                  <div class="form-group form-inline">
                      <label for="experience">工作经验：</label>
                      <select name="experience" class="form-control large">
                        <option value="">不限</option>
                        @foreach (trans('db.experience') as $key => $experience)
                          <option value="{{ $key }}"
                          @if (isset($parms['experience']) && $key === $parms['experience'])
                            selected
                          @endif>
                            {{ $experience }}
                          </option>
                        @endforeach
                      </select>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group form-inline">
                      <label for="education">教育经历：</label>
                      <select name="education" class="form-control large">
                        <option value="">不限</option>
                        @foreach (trans('db.education') as $key => $education)
                          <option value="{{ $key }}"
                          @if (isset($parms['education']) && $key === $parms['education'])
                            selected
                          @endif>
                            {{ $education }}
                          </option>
                        @endforeach
                      </select>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group form-inline">
                    <label for="cur_industry">当前行业：</label>
                    <div class="input-group" data-toggle="industrypicker">
                      <input type="hidden" name="cur_industry[st]" value="{{ isset($parms['cur_industry']['st']) ? $parms['cur_industry']['st'] : '' }}">
                      <input type="hidden" name="cur_industry[nd]" value="{{ isset($parms['cur_industry']['nd']) ? $parms['cur_industry']['nd'] : '' }}">
                      <input type="hidden" name="cur_industry[rd]" value="{{ isset($parms['cur_industry']['rd']) ? $parms['cur_industry']['rd'] : '' }}">
                      <input type="hidden" name="cur_industry[th]" value="{{ isset($parms['cur_industry']['th']) ? $parms['cur_industry']['th'] : '' }}">
                      <input type="text" class="form-control middle-append append" value="{{ isset($parms['cur_industry']['th']) ? $parms['cur_industry']['th'] : '' }}" placeholder="不限" autocomplete="off">
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
                </div>
                <div class="col">
                  <div class="form-group form-inline">
                    <label for="cur_position">当前职位：</label>
                    <div class="input-group" data-toggle="jobtypepicker">
                      <input type="hidden" name="cur_position[st]" value="{{ isset($parms['cur_position']['st']) ? $parms['cur_position']['st'] : '' }}">
                      <input type="hidden" name="cur_position[nd]" value="{{ isset($parms['cur_position']['nd']) ? $parms['cur_position']['nd'] : '' }}">
                      <input type="hidden" name="cur_position[rd]" value="{{ isset($parms['cur_position']['rd']) ? $parms['cur_position']['rd'] : '' }}">
                      <input type="text" class="form-control append" value="{{ isset($parms['cur_position']['rd']) ? $parms['cur_position']['rd'] : '' }}" id="jobType" placeholder="不限" autocomplete="off">
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
                </div>
                <div class="col">
                  <div class="form-group form-inline">
                    <label for="age">年龄范围：</label>
                    <div class="input-group">
                        <input type="text" name="age_min" class="form-control normal" value="{{ isset($parms['age_min']) ? $parms['age_min'] : '' }}" placeholder="岁" autocomplete="off" data-type="int">
                    </div>
                    <label class="ml-1 mr-1">-</label>
                    <div class="input-group">
                        <input type="text" name="age_max" class="form-control normal" value="{{ isset($parms['age_max']) ? $parms['age_max'] : '' }}" placeholder="不限" autocomplete="off" data-type="int">
                    </div>
                    <button class="btn btn-secondary ml-3">确定</button>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group form-inline">
                    <label for="sex">性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;别：</label>
                    <select name="sex" value="{{ isset($parms['sex']) ? $parms['sex'] : '' }}" class="form-control normal">
                      <option value="">不限</option>
                      <option @if(isset($parms['sex']) && $parms['sex'] === '男') selected @endif>男</option>
                      <option @if(isset($parms['sex']) && $parms['sex'] === '女') selected @endif>女</option>
                    </select>
                    <label class="ml-3" for="jobhunter_status">求职状态：</label>
                    <select name="jobhunter_status" class="form-control normal">
                      <option value="">不限</option>
                      @foreach (trans('db.resume.jobhunter_status') as $key => $jobhunterStatus)
                        <option value="{{ $key }}"
                        @if (isset($parms['jobhunter_status']) && (int)$key === (int)$parms['jobhunter_status'])
                          selected
                        @endif>
                          {{ $jobhunterStatus }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group form-inline">
                    <label for="source">来源渠道：</label>
                    <select name="source" class="form-control large">
                      <option value="">不限</option>
                      @foreach (trans('db.channel') as $key => $source)
                        <option value="{{ $key }}"
                        @if (isset($parms['source']) && $key === $parms['source'])
                          selected
                        @endif>
                          {{ $source }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group form-inline">
                    <label for="updated_at">更新时间：</label>
                    <select name="updated_at" class="form-control large">
                      <option value="">不限</option>
                      @foreach (trans('db.resume.update_date') as $key => $updateDate)
                        <option value="{{ $key }}"
                        @if (isset($parms['updated_at']) && (int)$key === (int)$parms['updated_at'])
                          selected
                        @endif>
                          {{ $updateDate }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="col col-auto">
              <a class="a-gray" href="{{ route('resumes.list') }}">清空搜索条件</a>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col col-12">
            <div class="resume-search-footer">
              <div class="row row-cols-2">
                <div class="col col-12">
                  <hr class="divider">
                </div>
                <div class="col">
                  <div class="form-group form-inline">
                    <label for="exp_salary">期望年薪：</label>
                    <div class="input-group">
                        <input type="text" name="exp_year_salary_min" class="form-control normal" value="{{ isset($parms['exp_year_salary_min']) ? $parms['exp_year_salary_min'] : '' }}" placeholder="万" autocomplete="off" data-type="int">
                    </div>
                    <label class="ml-1 mr-1">-</label>
                    <div class="input-group">
                        <input type="text" name="exp_year_salary_max" class="form-control normal" value="{{ isset($parms['exp_year_salary_max']) ? $parms['exp_year_salary_max'] : '' }}" placeholder="不限" autocomplete="off" data-type="int">
                    </div>
                    <button class="btn btn-secondary ml-3">确定</button>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group form-inline">
                    <label for="cur_salary">目前年薪：</label>
                    <div class="input-group">
                        <input type="text" name="cur_year_salary_min" class="form-control normal" value="{{ isset($parms['cur_year_salary_min']) ? $parms['cur_year_salary_min'] : '' }}" placeholder="万" autocomplete="off" data-type="int">
                    </div>
                    <label class="ml-1 mr-1">-</label>
                    <div class="input-group">
                        <input type="text" name="cur_year_salary_max" class="form-control normal" value="{{ isset($parms['cur_year_salary_max']) ? $parms['cur_year_salary_max'] : '' }}" placeholder="不限" autocomplete="off" data-type="int">
                    </div>
                    <button class="btn btn-secondary ml-3">确定</button>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group form-inline">
                    <label for="exp_industry">期望行业：</label>
                    <div class="input-group" data-toggle="industrypicker">
                      <input type="hidden" name="exp_industry[st]" value="{{ isset($parms['exp_industry']['st']) ? $parms['exp_industry']['st'] : '' }}">
                      <input type="hidden" name="exp_industry[nd]" value="{{ isset($parms['exp_industry']['nd']) ? $parms['exp_industry']['nd'] : '' }}">
                      <input type="hidden" name="exp_industry[rd]" value="{{ isset($parms['exp_industry']['rd']) ? $parms['exp_industry']['rd'] : '' }}">
                      <input type="hidden" name="exp_industry[th]" value="{{ isset($parms['exp_industry']['th']) ? $parms['exp_industry']['th'] : '' }}">
                      <input type="text" class="form-control middle-append append" value="{{ isset($parms['exp_industry']['th']) ? $parms['exp_industry']['th'] : '' }}" placeholder="不限" autocomplete="off">
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
                </div>
                <div class="col">
                  <div class="form-group form-inline">
                    <label for="exp_position">期望职位：</label>
                    <div class="input-group" data-toggle="jobtypepicker">
                      <input type="hidden" name="exp_position[st]" value="{{ isset($parms['exp_position']['st']) ? $parms['exp_position']['st'] : '' }}">
                      <input type="hidden" name="exp_position[nd]" value="{{ isset($parms['exp_position']['nd']) ? $parms['exp_position']['nd'] : '' }}">
                      <input type="hidden" name="exp_position[rd]" value="{{ isset($parms['exp_position']['rd']) ? $parms['exp_position']['rd'] : '' }}">
                      <input type="text" class="form-control append" value="{{ isset($parms['exp_position']['rd']) ? $parms['exp_position']['rd'] : '' }}" id="jobType" placeholder="不限" autocomplete="off">
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
                </div>
                <div class="col">
                  <div class="form-group form-inline">
                      <label for="school">毕业院校：</label>
                      <div class="input-group">
                        <input type="text" name="school" class="form-control append" value="{{ isset($parms['school']) ? $parms['school'] : '' }}" placeholder="请输入学校名称" autocomplete="off">
                        <div class="input-group-append" data-toggle="modal">
                          <button class="btn btn-secondary">确定</button>
                        </div>
                      </div>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group form-inline">
                      <label for="major">专业名称：</label>
                      <div class="input-group">
                        <input type="text" name="major" class="form-control append" value="{{ isset($parms['major']) ? $parms['major'] : '' }}" placeholder="请输入专业名称" autocomplete="off">
                        <div class="input-group-append" data-toggle="modal">
                          <button class="btn btn-secondary">确定</button>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <input type="hidden" name="tab" value="{{ $tab }}">
      <input type="hidden" name="show_detail" value="{{ $showDetail }}">
      @include('resumes.shared._list_change')
    </div>
  </form>
</div>

@include('shared._industry')
@include('shared._job_type')

<script type="text/javascript">

  var isSubmit = true;

  function submitResumeSearchForm()
  {
    $('#resumeSearchForm').submit();
  }

  function searchByCurJob(jobInfo, companyName)
  {
    let job = JSON.parse(jobInfo);
    isSubmit = false;

    $('input[name="job_name"]').val(job.name);
    $('input[name="company_name"]').val(companyName);

    $('select[name="location[province]"]').val(job.location.province);
    $('select[name="location[province]"]').trigger("change");
    $('select[name="location[city]"]').val(job.location.city);
    $('select[name="location[city]"]').trigger("change");
    $('select[name="location[district]"]').val(job.location.district);
    $('select[name="location[district]"]').trigger("change");

    $('select[name="experience"]').val(job.experience);
    $('select[name="education"]').val(job.education);

    $('input[name="age_min"]').val(job.age_min);
    $('input[name="age_max"]').val(job.age_max);

    submitResumeSearchForm();
  }

  function toggleDetail(e)
  {
    if ($('#resumeSearchDetail').is(":hidden")) {
      $('input[name="show_detail"]').val('1');
      $('#resumeSearchDetail').show('fast');
      e.text('- 收起');
    } else {
      $('input[name="show_detail"]').val('0');
      $('#resumeSearchDetail').hide();
      e.text('+ 展开更多条件');
    }
    // $('#resumeSearchDetail').toggle();
  }

  function init()
  {
    @if ($showDetail === 0)
      $('#resumeSearchDetail').hide();
      $('#btnToggleDetail').text('+ 展开更多条件');
    @else
      $('#resumeSearchDetail').show();
      $('#btnToggleDetail').text('- 收起');
    @endif
  }

  init();

</script>
@stop
