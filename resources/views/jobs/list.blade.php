@extends('layouts.default')
@section('title', '发布职位')
@section('content')
<div class="job-list bg-white">
  <div class="default-list">
    <div class="my-nav-tabs">
      <ul class="nav nav-tabs mr-4" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="job-tab" data-toggle="tab" href="#admin" role="tab" aria-controls="job"
                aria-selected="true">
            <h6>进行中职位</h6>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="accept-tab" data-toggle="tab" href="#edit" role="tab" aria-controls="accept"
              aria-selected="false">
            <h6>已暂停职位</h6>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="task-tab" data-toggle="tab" href="#audit" role="tab" aria-controls="task"
              aria-selected="false">
            <h6>已结束职位</h6>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="message-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="message"
              aria-selected="false">
            <h6>职位草稿箱</h6>
          </a>
        </li>
      </ul>
    </div>
    <form class="text-center" method="GET" action="{{ route('jobs.list') }}">
      {{ csrf_field() }}
      <div class="row align-items-center mb-4">
        <div class="col-auto">
          <div class="form-inline">
              <label for="name">职位名称：</label>
              <input type="text" name="name" class="form-control normal" value="{{ $name }}" placeholder="请填写职位名称" />
          </div>
        </div>
        <div class="col-auto">
          <div class="form-inline">
              <select name="urgency_level" class="form-control normal" value="{{ old('nature') }}">
                  <option value="">紧急程度</option>
                  @foreach($urgencyLevelArr as $key => $urgencyLevel)
                      <option value="{{ $key }}" @if($urgencyLevel['selected']) selected @endif>{{ $urgencyLevel['show'] }}</option>
                  @endforeach
              </select>
          </div>
        </div>
        <div class="col-auto">
          <div class="form-inline">
              <select name="channel" class="form-control normal" value="{{ old('nature') }}">
                  <option value="">发布渠道</option>
                  @foreach($channelArr as $key => $channel)
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
            <td>{{ $job->name }}</td>
            <td>{{ $job->company }}</td>
            <td>{{ $urgencyLevelArr[$job->urgency_level]['show'] }}</td>
            <td>
              @foreach (json_decode($job->channel) as $index => $item)
                {{ $channelArr[$item]['show'] }}{{ $index === 0 ? '/' : '' }}
              @endforeach
            </td>
            <td>{{ $job->company }}</td>
            <td>{{ $job->updated_at }}</td>
            <td>
              <div class="btn-group" role="group">
                <button id="btnGroupDrop1" type="button" class="btn dropdown-toggle btn-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  操作
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                  <a class="dropdown-item" href="#">刷新</a>
                  <a class="dropdown-item" href="#">修改</a>
                  <a class="dropdown-item" href="#">暂停</a>
                  <a class="dropdown-item" href="#">结束</a>
                  <a class="dropdown-item" href="#">删除</a>
                </div>
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="row justify-content-end">
      <div class="col-auto">
        {{ $jobs->links() }}
      </div>
    </div>
  </div>
</div>
@stop
