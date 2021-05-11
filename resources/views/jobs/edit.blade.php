@extends('layouts.default')
@section('title', '修改职位')
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
                    <span>*</span><label for="company">公司名称：</label>
                    <input type="text" name="company" class="form-control normal" value="{{ $job->company }}" placeholder="请填写" autocomplete="off">
                </div>
                <div class="form-group form-inline">
                    <span></span><label for="quota">招聘人数：</label>
                    <input type="text" name="quota" class="form-control normal" value="{{  $job->quota }}" placeholder="请填写" autocomplete="off" data-type="int">
                </div>
                <div class="form-title text-left">
                    <h5>职业基本信息</h5>
                </div>
                <div class="form-group form-inline">
                    <span>*</span><label for="name">职位名称：</label>
                    <input type="text" name="name" class="form-control normal" value="{{  $job->name }}" placeholder="请输入职位名称"  />
                </div>
                <div class="form-group form-inline">
                    <span>*</span><label for="type">职位类别：</label>
                    <div data-toggle="distpicker" data-source="jobTypes">
                      <select class="form-control" name="type[st]" data-province="{{ $job->type->st }}"></select>
                      <select class="form-control" name="type[nd]"  data-city="{{ $job->type->nd }}"></select>
                      <select class="form-control" name="type[rd]"  data-district="{{ $job->type->rd }}"></select>
                    </div>
                </div>
                <div class="form-group form-inline">
                    <span>*</span><label for="nature">工作性质：</label>
                    <select name="nature" class="form-control normal">
                        @foreach($natureArr as $key => $nature)
                            <option value="{{ $key }}" @if($key === $job->nature) selected="selected" @endif>{{ $nature }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group form-inline">
                    <span>*</span><label for="city">工作城市：</label>
                    <div data-toggle="distpicker">
                      <select class="form-control" name="location[province]" data-province="{{ $job->location->province }}"></select>
                      <select class="form-control" name="location[city]"  data-city="{{ $job->location->city }}"></select>
                      <select class="form-control" name="location[district]"  data-district="{{ $job->location->district }}"></select>
                    </div>
                </div>
                <div class="form-group form-inline">
                    <span>*</span><label for="salary">税前月薪：</label>
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
                    <span>*</span><label for="welfare">福利待遇：</label>
                    <select name="welfare" class="form-control normal">
                        @foreach($welfareArr as $key => $welfare)
                            <option value="{{ $key }}" @if($key === $job->welfare) selected="selected" @endif>{{ $welfare }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group form-inline">
                    <span></span><label for="sparkle">职位亮点：</label>
                    <input type="text" name="sparkle" class="form-control normal" value="{{  $job->sparkle }}" placeholder="请填写" />
                </div>
                <div class="form-title text-left">
                    <h5>职位要求</h5>
                </div>
                <div class="form-group form-inline">
                    <span>*</span><label for="age">年龄范围：</label>
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
                    <span>*</span><label for="education">学历要求：</label>
                    <select name="education" class="form-control normal">
                        @foreach($educationArr as $key => $education)
                            <option value="{{ $key }}" @if($key === $job->education) selected="selected" @endif>{{ $education }}</option>
                        @endforeach
                    </select>
                    <label class="ml-2">及以上</label>
                </div>
                <div class="form-group form-inline">
                    <span>*</span><label for="experience">经验要求：</label>
                    <select name="experience" class="form-control normal">
                        @foreach($experienceArr as $key => $experience)
                            <option value="{{ $key }}" @if($key === $job->experience) selected="selected" @endif>{{ $experience }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group form-inline">
                    <span>*</span><label for="duty">工作职责：</label>
                    <textarea name="duty" class="form-control normal">{{  $job->duty }}</textarea>
                </div>
                <div class="form-group form-inline">
                    <span>*</span><label for="requirement">任职要求：</label>
                    <textarea name="requirement" class="form-control normal">{{  $job->requirement }}</textarea>
                </div>
                <div class="form-title text-left">
                    <h5>发布设置</h5>
                </div>
                <div class="form-group form-inline">
                    <span>*</span><label for="urgency_level">紧急程度：</label>
                    @foreach ($urgencyLevelArr as $key => $urgencyLevel)
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="urgency_level_{{ $key }}" name="urgency_level" class="custom-control-input" value="{{ $key }}" @if($key === $job->urgency_level) checked @endif>
                            <label class="custom-control-label" for="urgency_level_{{ $key }}">{{ $urgencyLevel['show'] }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="form-group form-inline">
                    <span>*</span><label for="channel">渠道选择：</label>
                    @foreach ($channelArr as $key => $channel)
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input" id="channel_{{ $key }}" name="channel[{{ $key }}]" @if(in_array($key, json_decode($job->channel, true))) checked @endif>
                            <label class="custom-control-label" for="channel_{{ $key }}">{{ $channel['show'] }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="form-group form-inline">
                    <span>*</span><label for="deadline">截止日期：</label>
                    <input type="text" name="deadline" class="form-control normal" value="{{  $job->deadline }}" placeholder="请填写" />
                </div>

                <button type="submit" class="btn btn-danger btn-form-submit">确认修改</button>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
  $("[data-type='int']").on('input', function() {
    this.value=this.value.replace(/\D/g,'');
  })
  $.fn.distpicker.setDefaults({
    province: '---- 请选择 ----',
    city: '---- 请选择 ----',
    district: '---- 请选择 ----'
  });
</script>
@stop
