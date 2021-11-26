@extends('layouts.default')
@section('title', '数据统计')
@section('content')
<div class="management-job">
  <div class="body bg-white">
    <div class="row tip mt-4 justify-content-start text-center">
      <div class="col col-auto">
        <h4>{{ $statistics['all'] }}</h4>
        <b>当前总计</b>
      </div>
      <div class="col col-auto">
        <h4 class="color-red">{{ $statistics['new_month'] }}</h4>
        <b>本月新增</b>
      </div>
      <div class="col col-auto">
        <h4 class="color-red">{{ $statistics['new_week'] }}</h4>
        <b>本周新增</b>
      </div>
    </div>

    <div class="list">
      <div class="nav-tabs-border">
        <div class="job-list-body">
          <div class="default-list">
            @if (count($users) > 0)
              <table class="table default-table">
                <thead>
                  <tr>
                    <th scope="col">姓名</th>
                    <th scope="col">上传简历总数</th>
                    <th scope="col">最近一周上传简历</th>
                    <th scope="col">最近一月上传简历</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($users as $user)
                    <tr>
                      <td>{{ $user->name }}</td>
                      <td class="@if($user->uploadResumes->count() > 0) color-red bold @endif">{{ $user->uploadResumes->count() }}</td>
                      <td class="@if($user->uploadWeekResumes->count() > 0) color-red bold @endif">{{ $user->uploadWeekResumes->count() }}</td>
                      <td class="@if($user->uploadMonthResumes->count() > 0) color-red bold @endif">{{ $user->uploadMonthResumes->count() }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>

              <div class="row justify-content-end">
                <div class="col-auto">
                  {{ $users->links('vendor.pagination.bootstrap-4') }}
                </div>
              </div>

            @else
              <div class="empty row">
                <div class="col text-center m-auto">
                  <img src="{{ URL::asset('images/empty.png') }}">
                  <p>暂无</p>
                </div>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop
