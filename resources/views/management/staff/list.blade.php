@extends('layouts.default')
@section('title', '职位管控')
@section('content')
<div class="management-staff">
  <div class="list bg-white">
    <div class="nav-tabs-border">
      <ul class="nav nav-tabs text-center" role="tablist">
        <li class="nav-item">
          <a class="nav-link @if($appends['tab'] === 'job') active @endif" data-toggle="link" href="{{ route('management.staff.list', ['tab' => 'job']) }}" role="tab">
            职位统计
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if($appends['tab'] === 'resume') active @endif" data-toggle="link" href="{{ route('management.staff.list', ['tab' => 'resume']) }}" role="tab">
            简历统计
          </a>
        </li>
      </ul>

      @if ($appends['tab'] === 'job')
        <div class="job-list">
          @include('management.shared._job_statistics_list', ['appends' => $appends, 'users' => $list])
        </div>
      @elseif ($appends['tab'] === 'resume')
        <div class="resume-list">
          @include('management.shared._resume_statistics_list', ['appends' => $appends])
        </div>
      @endif
    </div>
  </div>
</div>
@stop
