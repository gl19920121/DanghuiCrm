@extends('layouts.default')
@section('title', '职位管控')
@section('content')
<div class="management-job">
  <div class="banner">
    <div class="row">
      <div class="col col-3 mt-auto">
        <img src="{{ URL::asset('images/nav_left.png') }}">
      </div>
      <div class="col m-auto">
        <img class="mr-5" src="{{ URL::asset('images/nav_center.png') }}">
      </div>
      <div class="col m-auto text-right">
        <img class="mr-5" src="{{ URL::asset('images/nav_right.png') }}">
      </div>
    </div>
  </div>

  <div class="body bg-white">
    <div class="row tip mt-4 justify-content-start text-center">
      <div class="col col-auto">
        <h4>{{ $statistics['staff'] }}</h4>
        <b>下属员工</b>
      </div>
      <div class="col col-auto">
        <h4 class="color-red">{{ $statistics['job_doing'] }}</h4>
        <b>在招职位</b>
      </div>
      <div class="col col-auto">
        <h4 class="color-red">{{ $statistics['job_need_check'] }}</h4>
        <b>职位审核</b>
      </div>
      <div class="col col-auto">
        <h4>{{ $statistics['resume_need_check'] }}</h4>
        <b>简历审核</b>
      </div>
    </div>

    <div class="list">
      <div class="nav-tabs-border">
        <ul class="nav nav-tabs text-center" role="tablist">
          <li class="nav-item">
            <a class="nav-link @if($appends['tab'] === 'job_doing') active @endif" data-toggle="link" href="{{ route('management.job.list', ['tab' => 'job_doing']) }}" role="tab">
              在招职位
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link @if($appends['tab'] === 'job_end') active @endif" data-toggle="link" href="{{ route('management.job.list', ['tab' => 'job_end']) }}" role="tab">
              结束职位
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link @if($appends['tab'] === 'job_need_check') active @endif" data-toggle="link" href="{{ route('management.job.list', ['tab' => 'job_need_check']) }}" role="tab">
              职位审核
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link @if($appends['tab'] === 'resume_need_check') active @endif" data-toggle="link" href="{{ route('management.job.list', ['tab' => 'resume_need_check']) }}" role="tab">
              简历审核
            </a>
          </li>
        </ul>

        @if (in_array($appends['tab'], ['job_doing', 'job_end']))
          <div class="job-list">
            @include('management.shared._job_list', ['jobs' => $list, 'appends' => $appends])
          </div>
        @elseif ($appends['tab'] === 'job_need_check')
          <div class="job-list">
            @include('management.shared._job_list_need_check', ['jobs' => $list, 'appends' => $appends])
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@stop
