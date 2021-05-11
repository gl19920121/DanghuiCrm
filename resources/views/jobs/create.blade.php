@extends('layouts.default')
@section('title', '发布职位')
@section('content')
<div class="job-create bg-white">
    <div class="default-form">
        <div class="form-header"></div>
        <hr class="divider">
        <div class="form-body">
            <form class="text-center" method="POST">
                <!-- action="{{ route('jobs.store') }}" -->
                {{ csrf_field() }}
                @if(!empty($draftId))
                  <input type="hidden" name="draft_id" value="{{ $draftId }}">
                @endif
                <div class="form-title text-left">
                    <h5>企业基本信息</h5>
                </div>
                <div class="form-group form-inline">
                    <span>*</span><label for="company">公司名称：</label>
                    <input type="text" name="company" class="form-control normal" value="{{ isset($oldData['company']) ? $oldData['company'] : old('company') }}" placeholder="请填写"  />
                </div>
                <div class="form-group form-inline">
                    <span></span><label for="quota">招聘人数：</label>
                    <input type="text" name="quota" class="form-control normal" value="{{ isset($oldData['quota']) ? $oldData['quota'] : old('quota') }}" placeholder="请填写" />
                </div>
                <div class="form-title text-left">
                    <h5>职业基本信息</h5>
                </div>
                <div class="form-group form-inline">
                    <span>*</span><label for="name">职位名称：</label>
                    <input type="text" name="name" class="form-control normal" value="{{ isset($oldData['name']) ? $oldData['name'] : old('name') }}" placeholder="请输入职位名称"  />
                </div>
                <div class="form-group form-inline">
                    <span>*</span><label for="type">职位类别：</label>
                    <!-- <input type="text" name="type" class="form-control normal" value="{{ isset($oldData['type']) ? $oldData['type'] : old('type') }}" placeholder="请输入职位类别"  /> -->
                    <!-- <div>
                      <select class="form-control" name="type[1]">
                        <option>---- 选择类别 ----</option>
                        @foreach ($jobTypes as $jobType)
                          <option>{{ $jobType->name }}</option>
                        @endforeach
                      </select>
                    </div> -->
                    <div data-toggle="distpicker" data-source="jobTypes">
                      <select class="form-control" name="location[province]" data-province="---- 选择省 ----"></select>
                      <select class="form-control" name="location[city]"  data-city="---- 选择市 ----"></select>
                      <select class="form-control" name="location[district]"  data-district="---- 选择区 ----"></select>
                    </div>
                </div>
                <div class="form-group form-inline">
                    <span>*</span><label for="nature">工作性质：</label>
                    <select name="nature" class="form-control normal" value="{{ isset($oldData['nature']) ? $oldData['nature'] : old('nature') }}">
                        @foreach($natureArr as $key => $nature)
                            <option value="{{ $key }}" @if(isset($oldData['nature']) && $key === $oldData['nature']) selected="selected" @endif>{{ $nature }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group form-inline">
                    <span>*</span><label for="city">工作城市：</label>
                    <!-- <input type="text" name="city" class="form-control normal" value="{{ isset($oldData['city']) ? $oldData['city'] : old('city') }}" /> -->
                    <div data-toggle="distpicker">
                      <select class="form-control" name="location[province]" data-province="---- 选择省 ----"></select>
                      <select class="form-control" name="location[city]"  data-city="---- 选择市 ----"></select>
                      <select class="form-control" name="location[district]"  data-district="---- 选择区 ----"></select>
                    </div>
                </div>
                <div class="form-group form-inline">
                    <span>*</span><label for="salary">税前月薪：</label>
                    <div class="input-group">
                        <input type="text" name="salary_min" class="form-control small" value="{{ isset($oldData['salary_min']) ? $oldData['salary_min'] : old('salary_min') }}"  />
                        <div class="input-group-append">
                            <div class="input-group-text">K</div>
                        </div>
                    </div>
                    <label class="ml-1 mr-1">-</label>
                    <div class="input-group">
                        <input type="text" name="salary_max" class="form-control small" value="{{ isset($oldData['salary_max']) ? $oldData['salary_max'] : old('salary_max') }}"  />
                        <div class="input-group-append">
                            <div class="input-group-text">K</div>
                        </div>
                    </div>
                </div>
                <div class="form-group form-inline">
                    <span>*</span><label for="welfare">福利待遇：</label>
                    <select name="welfare" class="form-control normal" value="{{ old('welfare') }}">
                        @foreach($welfareArr as $key => $welfare)
                            <option value="{{ $key }}" @if(isset($oldData['welfare']) && $key === $oldData['welfare']) selected="selected" @endif>{{ $welfare }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group form-inline">
                    <span></span><label for="sparkle">职位亮点：</label>
                    <input type="text" name="sparkle" class="form-control normal" value="{{ isset($oldData['sparkle']) ? $oldData['sparkle'] : old('sparkle') }}" placeholder="请填写" />
                </div>
                <div class="form-title text-left">
                    <h5>职位要求</h5>
                </div>
                <div class="form-group form-inline">
                    <span>*</span><label for="age">年龄范围：</label>
                    <div class="input-group">
                        <input type="text" name="age_min" class="form-control small" value="{{ isset($oldData['age_min']) ? $oldData['age_min'] : old('age_min') }}"  />
                        <div class="input-group-append">
                            <div class="input-group-text">岁</div>
                        </div>
                    </div>
                    <label class="ml-1 mr-1">-</label>
                    <div class="input-group">
                        <input type="text" name="age_max" class="form-control small" value="{{ isset($oldData['age_max']) ? $oldData['age_max'] : old('age_max') }}"  />
                        <div class="input-group-append">
                            <div class="input-group-text">岁</div>
                        </div>
                    </div>
                </div>
                <div class="form-group form-inline">
                    <span>*</span><label for="education">学历要求：</label>
                    <select name="education" class="form-control normal" value="{{ old('education') }}">
                        @foreach($educationArr as $key => $education)
                            <option value="{{ $key }}" @if(isset($oldData['education']) && $key === $oldData['education']) selected="selected" @endif>{{ $education }}</option>
                        @endforeach
                    </select>
                    <label class="ml-2">及以上</label>
                </div>
                <div class="form-group form-inline">
                    <span>*</span><label for="experience">经验要求：</label>
                    <select name="experience" class="form-control normal" value="{{ old('experience') }}">
                        @foreach($experienceArr as $key => $experience)
                            <option value="{{ $key }}" @if(isset($oldData['experience']) && $key === $oldData['experience']) selected="selected" @endif>{{ $experience }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group form-inline">
                    <span>*</span><label for="duty">工作职责：</label>
                    <textarea name="duty" class="form-control normal">{{ isset($oldData['duty']) ? $oldData['duty'] : old('duty') }}</textarea>
                </div>
                <div class="form-group form-inline">
                    <span>*</span><label for="requirement">任职要求：</label>
                    <textarea name="requirement" class="form-control normal">{{ isset($oldData['requirement']) ? $oldData['requirement'] : old('requirement') }}</textarea>
                </div>
                <div class="form-title text-left">
                    <h5>发布设置</h5>
                </div>
                <div class="form-group form-inline">
                    <span>*</span><label for="urgency_level">紧急程度：</label>
                    @foreach ($urgencyLevelArr as $key => $urgencyLevel)
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="urgency_level_{{ $key }}" name="urgency_level" class="custom-control-input" value="{{ $key }}"
                              @if (isset($oldData['urgency_level']))
                                @if ($key == $oldData['urgency_level'])
                                  checked
                                @endif
                              @elseif ($urgencyLevel['selected'])
                                checked
                              @endif
                            >
                            <label class="custom-control-label" for="urgency_level_{{ $key }}">{{ $urgencyLevel['show'] }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="form-group form-inline">
                    <span>*</span><label for="channel">渠道选择：</label>
                    @foreach ($channelArr as $key => $channel)
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input" id="channel_{{ $key }}" name="channel[{{ $key }}]"
                              @if (isset($oldData['channel']))
                                @if (in_array($key, json_decode($oldData['channel'], true)))
                                  checked
                                @endif
                              @elseif ($channel['selected'])
                                checked
                              @endif
                            >
                            <label class="custom-control-label" for="channel_{{ $key }}">{{ $channel['show'] }}</label>
                        </div>
                    @endforeach
                </div>
                <!-- <div class="form-group form-inline">
                    <span>*</span><label for="deadline">截止日期：</label>
                    <input type="text" name="deadline" class="form-control normal" value="{{ isset($oldData['deadline']) ? $oldData['deadline'] : old('deadline') }}" placeholder="请填写" />
                </div> -->
                <div class="form-group form-inline">
                  <span>*</span><label for="deadline">截止日期：</label>
                  <div class="input-group date" id="datetimepicker1">
                    <input type="text" name="deadline" class="form-control normal" value="{{ isset($oldData['deadline']) ? $oldData['deadline'] : old('deadline') }}" placeholder="请选择" />
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
@include('shared._errors')
@stop
