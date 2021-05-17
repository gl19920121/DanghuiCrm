@extends('layouts.default')
@section('title', '职位管理')
@section('content')
<div class="job-list bg-white">
  <div class="my-nav-tabs-top">
    <ul class="nav nav-tabs text-center" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link @if($appends['tab'] === 'ing') active @endif" id="ing-tab" data-toggle="link" href="{{ route('jobs.list', ['tab' => 'ing']) }}" role="tab" aria-controls="ing" aria-selected="true">
          进行中职位
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link @if($appends['tab'] === 'pause') active @endif" id="pause-tab" data-toggle="link" href="{{ route('jobs.list', ['tab' => 'pause']) }}" role="tab" aria-controls="pause" aria-selected="false">
          已暂停职位
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link @if($appends['tab'] === 'end') active @endif" id="end-tab" data-toggle="link" href="{{ route('jobs.list', ['tab' => 'end']) }}" role="tab" aria-controls="task" aria-selected="false">
          已结束职位
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link @if($appends['tab'] === 'drafts') active @endif" id="drafts-tab" data-toggle="link" href="{{ route('drafts.list', ['tab' => 'drafts', 'type' => 'drafts']) }}" role="tab" aria-controls="drafts" aria-selected="false">
          职位草稿箱
        </a>
      </li>
    </ul>
  </div>

  <div>
    @yield('list')
  </div>
</div>
@stop
