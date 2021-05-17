@extends('jobs.layouts.list')
@section('list')

  <div class="job-list-body">

    @if (count($jobs) > 0)
      <div class="default-list">
        <form class="text-center" method="GET" action="{{ route('jobs.list') }}">
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
                  <select name="urgency_level" class="form-control normal" value="{{ old('nature') }}">
                      <option value="">紧急程度</option>
                      @foreach($appends['urgencyLevelArr'] as $key => $urgencyLevel)
                          <option value="{{ $key }}" @if($urgencyLevel['selected']) selected @endif>{{ $urgencyLevel['show'] }}</option>
                      @endforeach
                  </select>
              </div>
            </div>
            <div class="col-auto">
              <div class="form-inline">
                  <select name="channel" class="form-control normal" value="{{ old('nature') }}">
                      <option value="">发布渠道</option>
                      @foreach($appends['channelArr'] as $key => $channel)
                          <option value="{{ $key }}" @if($channel['selected']) selected @endif>{{ $channel['show'] }}</option>
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
              <th scope="col">职位</th>
              <th scope="col">招聘企业</th>
              <th scope="col">紧急程度</th>
              <th scope="col">发布渠道</th>
              <th scope="col">新增应聘</th>
              <th scope="col">更新时间</th>
              <th scope="col">操作</th>
            </tr>
          </thead>
          <tbody>
            @foreach($jobs as $job)
              <tr>
                <td>
                  <a class="color-red" href="{{ route('jobs.show', $job) }}">{{ $job->name }}</a>
                </td>
                <td>{{ $job->company }}</td>
                <td>{{ $appends['urgencyLevelArr'][$job->urgency_level]['show'] }}</td>
                <td>
                  @foreach (json_decode($job->channel) as $index => $item)
                    {{ $appends['channelArr'][$item]['show'] }}{{ $index === 0 ? '/' : '' }}
                  @endforeach
                </td>
                <td class="color-red">{{ $job->resumes_count }}</td>
                <td>{{ $job->updated_at }}</td>
                <td>
                  <div class="btn-group" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn dropdown-toggle btn-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      操作
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                      <a class="dropdown-item" href="#">刷新</a>
                      <a class="dropdown-item" href="{{ route('jobs.edit', $job) }}">修改</a>
                      <form method="POST" action="{{ route('jobs.status', [$job->id, 'status' => 'pause']) }}">
                        {{ csrf_field() }}
                        <button class="dropdown-item" type="submit">暂停</button>
                      </form>
                      <form method="POST" action="{{ route('jobs.status', [$job->id, 'status' => 'end']) }}">
                        {{ csrf_field() }}
                        <button class="dropdown-item" type="submit">结束</button>
                      </form>
                      <form method="POST" action="{{ route('jobs.destroy', $job) }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="dropdown-item" type="submit">删除</button>
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
@stop
