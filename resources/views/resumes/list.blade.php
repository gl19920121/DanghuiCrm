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
                    <input style="border-top-left-radius: 0; border-bottom-left-radius: 0;" type="text" name="all" value="{{ isset($parms['all']) ? $parms['all'] : '' }}" class="form-control append" placeholder="请用空格隔开多个中文关键词，逗号隔开多个英文词组（如：design,tester）" autocomplete="off">
                    <div class="input-group-append" data-toggle="modal">
                      <button class="btn btn-danger">搜索</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="form-group form-inline">
                    <label for="job_name">职位名称：</label>
                    <div class="input-group">
                      <input type="text" name="job_name" value="{{ isset($parms['job_name'] ) ? $parms['job_name']  : ''}}" class="form-control" placeholder="空格隔开多个中文 逗号隔开英文" autocomplete="off">
                      <div class="input-group-append" data-toggle="modal">
                        <button class="btn btn-secondary">确定</button>
                      </div>
                    </div>
                </div>
              </div>
              <div class="col">
                <div class="form-group form-inline">
                    <label for="company_name">公司名称：</label>
                    <div class="input-group">
                      <input type="text" name="company_name" value="{{ isset($parms['company_name']) ? $parms['company_name'] : '' }}" class="form-control" placeholder="空格隔开多个中文 逗号隔开英文" autocomplete="off">
                      <div class="input-group-append" data-toggle="modal">
                        <button class="btn btn-secondary">确定</button>
                      </div>
                    </div>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group form-inline">
                  <label>发布中的职位：</label>
                  <form id="searchByCurJob" method="GET" action="{{ route('resumes.list') }}">
                    <input type="hidden" name="job_id">
                    @foreach ($jobs as $job)
                      <div class="cur-jobs font-size-m mr-4" onclick="searchByCurJob('{{ $job->id }}')">
                        <p class="text-truncate m-1" title="{{ sprintf('%s | %s | %s', $job->company->name, $job->location_show, $job->salary_show) }}">
                          <span>{{ $job->name }}</span>
                          <span class="color-silvery-gray text-truncate">（{{ $job->company->name }} | </span>
                          <span class="color-silvery-gray text-truncate">{{ $job->location_show }} | </span>
                          <span class="color-silvery-gray text-truncate">{{ $job->salary_show }}）</span>
                        </p>
                      </div>
                    @endforeach
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col col-12">
          <div class="resume-search-body">
            <div class="row row-cols-2">
              <div class="col-12">
                <div class="form-group form-inline">
                  <label for="location">目前城市：</label>
                  <div data-toggle="distpicker">
                    <select class="form-control normal" name="location[province]" data-province="{{ isset($parms['location']['province']) ? $parms['location']['province'] : '省' }}"></select>
                    <select class="form-control normal" name="location[city]"  data-city="{{ isset($parms['location']['city']) ? $parms['location']['city'] : '市' }}"></select>
                    <select class="form-control normal" name="location[district]"  data-district="{{ isset($parms['location']['district']) ? $parms['location']['district'] : '区' }}"></select>
                  </div>
                </div>
              </div>
              <div class="col-12">
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
                    <select name="experience" class="form-control">
                      <option>不限</option>
                      @foreach (App\Models\Job::experienceArr as $key => $experience)
                        <option value="{{ $key }}"
                        @if (isset($parms['experience']) && $key === $parms['experience'])
                          selected
                        @endif
                        >
                          {{ $experience['text'] }}
                        </option>
                      @endforeach
                    </select>
                </div>
              </div>
              <div class="col">
                <div class="form-group form-inline">
                    <label for="education">教育经历：</label>
                    <select name="education" class="form-control">
                      <option>不限</option>
                      @foreach (App\Models\Job::educationArr as $key => $education)
                        <option value="{{ $key }}"
                        @if (isset($parms['education']) && $key === $parms['education'])
                          selected
                        @endif
                        >
                          {{ $education['text'] }}
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
                      <input type="text" name="age_min" class="form-control small" value="{{ isset($parms['age_min']) ? $parms['age_min'] : '' }}" placeholder="岁" autocomplete="off" data-type="int">
                  </div>
                  <label class="ml-1 mr-1">-</label>
                  <div class="input-group">
                      <input type="text" name="age_max" class="form-control small" value="{{ isset($parms['age_max']) ? $parms['age_max'] : '' }}" placeholder="不限" autocomplete="off" data-type="int">
                  </div>
                  <label class="ml-4" for="sex">性别：</label>
                  <select name="sex" value="{{ isset($parms['sex']) ? $parms['sex'] : '' }}" class="form-control normal">
                    <option>不限</option>
                    <option @if(isset($parms['sex']) && $parms['sex'] === '男') selected @endif>男</option>
                    <option @if(isset($parms['sex']) && $parms['sex'] === '女') selected @endif>女</option>
                  </select>
                </div>
              </div>
              <div class="col">
                <div class="form-group form-inline">
                  <label for="jobhunter_statu">求职状态：</label>
                  <select name="jobhunter_statu" class="form-control normal">
                    <option>不限</option>
                    @foreach (App\Models\Resume::jobhunterStatusArr as $key => $jobhunterStatu)
                      <option value="{{ $key }}"
                      @if (isset($parms['jobhunter_statu']) && $key === $parms['jobhunter_statu'])
                        selected
                      @endif
                      >
                        {{ $jobhunterStatu['text'] }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col">
                <div class="form-group form-inline">
                  <label for="source">来源渠道：</label>
                  <select name="source" class="form-control normal">
                    <option>不限</option>
                    @foreach (App\Models\Resume::sourceArr as $key => $source)
                      <option value="{{ $key }}"
                      @if (isset($parms['source']) && $key === $parms['source'])
                        selected
                      @endif
                      >
                        {{ $source['text'] }}
                      </option>
                    @endforeach
                  </select>
                  <label class="ml-4" for="updated_at">更新时间：</label>
                  <select name="updated_at" class="form-control normal">
                    <option>不限</option>
                    @foreach (App\Models\Resume::updateDateArr as $key => $updateDate)
                      <option value="{{ $key }}"
                      @if (isset($parms['updated_at']) && $key === $parms['updated_at'])
                        selected
                      @endif
                      >
                        {{ $updateDate['text'] }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
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
                      <input type="text" name="exp_salary_min" class="form-control small" value="{{ isset($parms['cur_salary_min']) ? $parms['exp_salary_min'] : '' }}" placeholder="万" autocomplete="off" data-type="int">
                  </div>
                  <label class="ml-1 mr-1">-</label>
                  <div class="input-group">
                      <input type="text" name="exp_salary_max" class="form-control small" value="{{ isset($parms['cur_salary_min']) ? $parms['exp_salary_max'] : '' }}" placeholder="不限" autocomplete="off" data-type="int">
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="form-group form-inline">
                  <label for="cur_salary">目前年薪：</label>
                  <div class="input-group">
                      <input type="text" name="cur_salary_min" class="form-control small" value="{{ isset($parms['cur_salary_min']) ? $parms['cur_salary_min'] : '' }}" placeholder="万" autocomplete="off" data-type="int">
                  </div>
                  <label class="ml-1 mr-1">-</label>
                  <div class="input-group">
                      <input type="text" name="cur_salary_max" class="form-control small" value="{{ isset($parms['cur_salary_max']) ? $parms['cur_salary_max'] : '' }}" placeholder="不限" autocomplete="off" data-type="int">
                  </div>
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
                    <label for="major">毕业院校：</label>
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
  </form>
  @include('resumes.shared._list')
</div>

@include('shared._industry')
@include('shared._job_type')

<script type="text/javascript">

  function searchByCurJob(jobId)
  {
    $('input[name="job_id"]').val(jobId);
    $('#searchByCurJob').submit();
  }

  function submitResumeSearchForm()
  {
    $('#resumeSearchForm').submit();
  }

  $('button').click(function() {
    if ($(this).attr('id') != 'btnGroupDrop1') {
      submitResumeSearchForm();
    }
  })

  $('select').change(function() {
    submitResumeSearchForm();
  })

</script>
@stop
