@extends('jobs.layouts.list')
@section('list')

  <div class="job-list-body">

    @if (count($jobs) > 0)
      <div class="default-list">
        <form class="text-center" method="GET" action="{{ route('drafts.list') }}">
          {{ csrf_field() }}
          <input type="hidden" name="tab" value="{{ $appends['tab'] }}">
          <div class="row align-items-center mb-4">
            <div class="col-auto">
              <div class="form-inline">
                  <label for="name">职位名称：</label>
                  <input type="text" name="name" class="form-control normal" value="{{ $appends['name'] }}" placeholder="请填写职位名称" />
              </div>
            </div>

            <button type="submit" class="btn btn-danger">搜索</button>
          </div>
        </form>

        <table class="table table-striped default-table draft-table">
          <thead>
            <tr>
              <th scope="col">职位</th>
              <th scope="col">招聘企业</th>
              <th scope="col">发布渠道</th>
              <th scope="col">更新时间</th>
              <th scope="col">操作</th>
            </tr>
          </thead>
          <tbody>
            @foreach($jobs as $job)
              <tr onclick="window.location = '{{ route('jobs.create', ['draft_id' => $job->id, 'job_data' => $job->data]) }}';">
                <td>
                  <span class="color-red">{{ $job->name }}</span>
                </td>
                <td>{{ $job->company }}</td>
                <td>
                  @foreach ($job->channel as $index => $item)
                    {{ $appends['channelArr'][$item]['show'] }}{{ $index === 0 ? '/' : '' }}
                  @endforeach
                </td>
                <td>{{ $job->updated_at }}</td>
                <td>
                  <form method="POST" action="{{ route('drafts.destroy', $job) }}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn btn-danger" type="submit">删除</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <div class="row justify-content-end">
          <div class="col-auto">
            {{ $jobs->appends($appends)->onEachSide(5)->links('vendor.pagination.bootstrap-4') }}
          </div>
        </div>
      </div>

    @else
      <div class="empty row">
        <div class="col text-center m-auto">
          <img src="{{ URL::asset('images/empty.png') }}">
          <p>您还没有草稿</p>
        </div>
      </div>
    @endif

  </div>
@stop
