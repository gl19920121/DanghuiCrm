@extends('layouts.default')
@section('title', '员工管控')
@section('content')
<div class="management-staff">
  <div class="list bg-white">
    <div class="nav-tabs-border">
      <ul class="nav nav-tabs text-center" role="tablist">
        <li style="width: auto;" class="nav-item">
          <a style="width: auto; padding: 0 20px;" class="nav-link @if($appends['tab'] === 'doing') active @endif" data-toggle="link" role="tab" href="
          @if ($item instanceof App\Models\Department)
            {{ route('management.staff.department.list', ['department' => $item, 'tab' => 'doing']) }}
          @else
            {{ route('management.staff.user.list', ['user' => $item, 'tab' => 'doing']) }}
          @endif
          ">
            {{ $item->name }}运作职位
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if($appends['tab'] === 'checkpending') active @endif" data-toggle="link" role="tab" href="
          @if ($item instanceof App\Models\Department)
            {{ route('management.staff.department.list', ['department' => $item, 'tab' => 'checkpending']) }}
          @else
            {{ route('management.staff.user.list', ['user' => $item, 'tab' => 'checkpending']) }}
          @endif
          ">
            待审核职位
          </a>
        </li>
      </ul>

      @switch ($appends['tab'])
        @case ('doing')
          <div class="job-list">
            @include('management.shared._user_statistics_doing_list', ['appends' => $appends, 'jobs' => $list])
          </div>
          @break
        @case ('checkpending')
          <div class="job-list">
            @include('management.shared._user_statistics_checkpending_list', ['appends' => $appends, 'jobs' => $list])
          </div>
          @break
      @endswitch
    </div>
  </div>
</div>
@stop
