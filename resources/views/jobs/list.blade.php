@extends('jobs.layouts.list')
@section('list')

  <div class="job-list-body">

    @if (count($jobs) > 0)
      <div class="default-list">
        <form name="search" class="text-center" method="GET" action="{{ route('jobs.list') }}">
          {{ csrf_field() }}
          <input type="hidden" name="tab" value="{{ $appends['tab'] }}">
          <div class="row align-items-center mb-4">
            <div class="col-auto">
              <div class="form-inline">
                  <label for="name">职位名称：</label>
                  <input type="text" name="name" class="form-control normal" value="{{ $appends['name'] }}" placeholder="请填写职位名称" />
              </div>
            </div>
            <div class="col-auto">
              <div class="form-inline">
                  <select name="urgency_level" class="form-control normal" value="{{ old('urgency_level') }}">
                      <option value="">紧急程度</option>
                      @foreach(App\Models\Job::urgencyLevelArr as $key => $urgencyLevel)
                          <option value="{{ $key }}" @if($appends['urgencyLevel'] === (string)$key) selected @endif>{{ $urgencyLevel['text'] }}</option>
                      @endforeach
                  </select>
              </div>
            </div>
            <div class="col-auto">
              <div class="form-inline">
                  <select name="channel" class="form-control normal" value="{{ old('channel') }}">
                      <option value="">发布渠道</option>
                      @foreach(App\Models\Job::channelArr as $key => $channel)
                          <option value="{{ $key }}" @if($appends['channel'] === $key) selected @endif>{{ $channel['text'] }}</option>
                      @endforeach
                  </select>
              </div>
            </div>

            <button type="submit" class="btn btn-danger">搜索</button>
          </div>
        </form>

        <table class="table table-striped default-table">
          <thead>
            <tr>
              <th scope="col">进度</th>
              <th scope="col">职位</th>
              <th scope="col">公司名称</th>
              <th scope="col">紧急程度</th>
              <th scope="col">发布渠道</th>
              <th scope="col">发布状态</th>
              <th scope="col">待处理简历</th>
              <th scope="col">更新时间</th>
              <th scope="col">操作</th>
            </tr>
          </thead>
          <tbody>
            @foreach($jobs as $job)
              <tr>
                <td>
                  <a class="color-red" href="#">查看</a>
                </td>
                <td>
                  <a class="color-red" href="{{ route('jobs.show', $job) }}">{{ $job->name }}</a>
                </td>
                <td>{{ $job->company->name }}</td>
                <td>{{ $job->urgencyLevelShow }}</td>
                <td>{{ $job->channelShow }}</td>
                <td>{{ $job->statusShow }}</td>
                <td class="color-red">{{ $job->resumes->count() }}</td>
                <td>{{ $job->updated_at }}</td>
                <td>
                  <div class="btn-group" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn dropdown-toggle btn-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      操作
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                      <a class="dropdown-item" href="#" onclick="$('form[name=search1]').submit()">刷新</a>
                      <a class="dropdown-item" href="{{ route('jobs.edit', $job) }}">修改</a>
                      @if ($appends['tab'] === 'ing')
                        <form method="POST" action="{{ route('jobs.status', [$job->id, 'status' => 'pause']) }}">
                          {{ csrf_field() }}
                          <button class="dropdown-item" type="button" data-toggle="modal" data-target="#confirmModal" data-type="job">暂停</button>
                        </form>
                      @endif
                      @if ($appends['tab'] === 'pause' || $appends['tab'] === 'end')
                        <form method="POST" action="{{ route('jobs.status', [$job->id, 'status' => 'ing']) }}">
                          {{ csrf_field() }}
                          <button class="dropdown-item" type="button" data-toggle="modal" data-target="#confirmModal" data-type="job">恢复</button>
                        </form>
                      @endif
                      @if ($appends['tab'] !== 'end')
                        <form method="POST" action="{{ route('jobs.status', [$job->id, 'status' => 'end']) }}">
                          {{ csrf_field() }}
                          <button class="dropdown-item" type="button" data-toggle="modal" data-target="#confirmModal" data-type="job">结束</button>
                        </form>
                      @endif
                      <form method="POST" action="{{ route('jobs.destroy', $job) }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="dropdown-item" type="button" data-toggle="modal" data-target="#confirmModal" data-type="job">删除</button>
                      </form>
                    </div>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <div class="row justify-content-end">
          <div class="col-auto">
            {{ $jobs->appends($appends)->links('vendor.pagination.bootstrap-4') }}
          </div>
        </div>
      </div>

    @else
      <div class="empty row">
        <div class="col text-center m-auto">
          <img src="{{ URL::asset('images/empty.png') }}">
          <p>您还没有运作的职位</p>
        </div>
      </div>
    @endif

  </div>

  @include('shared._confirm')
@stop
