@extends('layouts.default')
@section('title', '职位管理')
@section('content')
<div class="job-detail">
  <div class="job-detail-header bg-white">
    <div class="row justify-content-between">
      <div class="col-auto">
        <small>职位编号：{{ $job->no }}</small>
      </div>
      <div class="col-auto">
        <small>更新时间：{{ $job->created_at }}</small>
      </div>
    </div>
    <div class="row align-items-center">
      <div class="col-auto">
        <h1>{{ $job->name }}</h1>
      </div>
      @if ($job->urgency_level === 1)
        <div class="col-auto">
          <div class="tag-red text-center">紧急</div>
        </div>
      @endif
    </div>
    <div class="row justify-content-start">
      <div class="col-auto" style="width: 207px;">
        <p>企业：{{ $job->company->name }}</p>
      </div>
      <div class="col-auto">
        <p>|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;招聘人数：{{ empty($job->quota) ? '-' : $job->quota }}人</p>
      </div>
    </div>
    <div class="row align-items-center justify-content-between">
      <div class="col-auto">
        <div class="row">
          <div class="col-auto" style="width: 207px;">
            <h6><label>{{ $job->pv }}</label>浏览人数&nbsp;&nbsp;&nbsp;<label>{{ $job->resumes()->count() }}</label>次投递</h6>
          </div>
          <div hidden class="col-auto">
            <p>|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;分享</p>
          </div>
        </div>
      </div>
      <div class="col-auto">
        <div class="btn-group" role="group">
          <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle btn-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            简历导入
          </button>
          <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            @foreach ($availableResumes as $resume)
              <form method="POST" action="{{ route('resumes.update', [$resume, 'job_id' => $job->id]) }}">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <button class="dropdown-item" type="submit" data-toggle="modal" data-target="#confirmModal">{{ $resume->name }}</button>
              </form>
            @endforeach
          </div>
        </div>
        <div class="btn-group" role="group">
          <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle btn-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            更多操作
          </button>
          <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <a class="dropdown-item" href="{{ route('jobs.show', $job) }}">刷新</a>
            <a class="dropdown-item" href="{{ route('jobs.edit', $job) }}">修改</a>
            <form method="POST" action="{{ route('jobs.status', [$job->id, 'status' => 'pause']) }}">
              {{ csrf_field() }}
              <button type="submit" class="dropdown-item">暂停</button>
            </form>
            <form method="POST" action="{{ route('jobs.status', [$job->id, 'status' => 'end']) }}">
              {{ csrf_field() }}
              <button type="submit" class="dropdown-item">结束</button>
            </form>
            <form method="POST" action="{{ route('jobs.destroy', $job) }}">
              {{ csrf_field() }}
              {{ method_field('DELETE') }}
              <button class="dropdown-item" type="submit">删除</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="job-detail-list bg-white">
    <div class="my-nav-tabs">
      <ul class="nav nav-tabs mr-4" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="job-tab" data-toggle="tab" href="#admin" role="tab" aria-controls="job"
                aria-selected="true">
            <h6>相关简历</h6>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="accept-tab" data-toggle="tab" href="#edit" role="tab" aria-controls="accept"
              aria-selected="false">
            <h6>职位详情</h6>
          </a>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent" >
        <div class="tab-pane fade show active" id="admin" role="tabpanel" aria-labelledby="job-tab">
          <ul class="list-group list-group-flush">
            <li class="list-group-item">
              <div class="my-nav-tabs-top">
                <ul class="nav nav-tabs text-center" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link @if(empty($tab) || $tab === 'untreated') active @endif" id="all-tab" data-toggle="link" href="{{ route('jobs.show', ['id' => $job->id, 'tab' => 'untreated']) }}" role="tab" aria-controls="all"
                          aria-selected="true">
                      求职者应聘（{{ $count['untreated'] }}）
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link @if($tab === 'talking') active @endif" id="talking-tab" data-toggle="link" href="{{ route('jobs.show', ['id' => $job->id, 'tab' => 'talking']) }}" role="tab" aria-controls="talking"
                        aria-selected="false">
                      电话沟通（{{ $count['talking'] }}）
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link @if($tab === 'push_resume') active @endif" id="push_resume-tab" data-toggle="link" href="{{ route('jobs.show', ['id' => $job->id, 'tab' => 'push_resume']) }}" role="tab" aria-controls="push_resume"
                        aria-selected="false">
                      推荐简历（{{ $count['push_resume'] }}）
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link @if($tab === 'interview') active @endif" id="interview-tab" data-toggle="link" href="{{ route('jobs.show', ['id' => $job->id, 'tab' => 'interview']) }}" role="tab" aria-controls="interview"
                        aria-selected="false">
                      面试（{{ $count['interview'] }}）
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link @if($tab === 'offer') active @endif" id="offer-tab" data-toggle="link" href="{{ route('jobs.show', ['id' => $job->id, 'tab' => 'offer']) }}" role="tab" aria-controls="offer"
                        aria-selected="false">
                      offer（{{ $count['offer'] }}）
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link @if($tab === 'onboarding') active @endif" id="onboarding-tab" data-toggle="link" href="{{ route('jobs.show', ['id' => $job->id, 'tab' => 'onboarding']) }}" role="tab" aria-controls="onboarding"
                        aria-selected="false">
                      入职（{{ $count['onboarding'] }}）
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link @if($tab === 'over_probation') active @endif" id="over_probation-tab" data-toggle="link" href="{{ route('jobs.show', ['id' => $job->id, 'tab' => 'over_probation']) }}" role="tab" aria-controls="over_probation"
                        aria-selected="false">
                      过保（{{ $count['over_probation'] }}）
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link @if($tab === 'out') active @endif" id="out-tab" data-toggle="link" href="{{ route('jobs.show', ['id' => $job->id, 'tab' => 'out']) }}" role="tab" aria-controls="out"
                        aria-selected="false">
                      淘汰（{{ $count['out'] }}）
                    </a>
                  </li>
                </ul>
              </div>
              @include('jobs.shared._job_show_resumes')
            </li>
          </ul>
        </div>
        <div class="tab-pane fade" id="edit" role="tabpanel" aria-labelledby="accept-tab">
            <ul class="list-group list-group-flush">
              <li class="list-group-item">
                @include('jobs.shared._job_show_detail')
              </li>
            </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@stop
