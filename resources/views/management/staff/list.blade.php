@extends('layouts.default')
@section('title', '员工管控')
@section('content')
<div class="management-staff">
  <div class="list bg-white">
    <div class="nav-tabs-border">
      <ul class="nav nav-tabs text-center" role="tablist">
        <li class="nav-item">
          <a class="nav-link @if($appends['tab'] === 'user') active @endif" data-toggle="link" href="{{ route('management.staff.list', ['tab' => 'user']) }}" role="tab">
            员工统计
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if($appends['tab'] === 'job') active @endif" data-toggle="link" href="{{ route('management.staff.list', ['tab' => 'job']) }}" role="tab">
            职位统计
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if($appends['tab'] === 'company') active @endif" data-toggle="link" href="{{ route('management.staff.list', ['tab' => 'company']) }}" role="tab">
            项目统计
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if($appends['tab'] === 'resume') active @endif" data-toggle="link" href="{{ route('management.staff.list', ['tab' => 'resume']) }}" role="tab">
            简历统计
          </a>
        </li>
      </ul>

      @switch ($appends['tab'])
      @case ('user')
          <div class="job-list">
            @include('management.shared._user_statistics_list', ['appends' => $appends, 'users' => $list])
          </div>
          @break
        @case ('job')
          <div class="job-list">
            @include('management.shared._job_statistics_list', ['appends' => $appends, 'jobs' => $list])
          </div>
          @break
        @case ('company')
          <div class="job-list">
            @include('management.shared._company_statistics_list', ['appends' => $appends, 'companys' => $list])
          </div>
          @break
        @case ('resume')
          <div class="job-list">
            @include('management.shared._resume_statistics_list', ['appends' => $appends, 'users' => $list])
          </div>
          @break
      @endswitch
    </div>
  </div>
</div>
@stop
