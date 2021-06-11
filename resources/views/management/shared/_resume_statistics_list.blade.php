<div class="job-list-body">

  @if (count($list) > 0)
    <div class="default-list">
      <form name="search" class="text-center" method="GET" action="{{ route('management.job.list') }}">
        {{ csrf_field() }}
        <input type="hidden" name="tab" value="{{ $appends['tab'] }}">
        <div class="row align-items-center mb-4">
          <div class="col-auto">
            <div class="form-inline">
                <label for="job_name">职位名称：</label>
                <input type="text" name="job_name" class="form-control normal" value="{{ $appends['job_name'] }}" placeholder="请填写职位名称" />
            </div>
          </div>
          <div class="col-auto">
            <div class="form-inline">
                <select name="job_channel" class="form-control normal">
                    <option value="">发布渠道</option>
                    @foreach(App\Models\Job::channelArr as $key => $channel)
                        <option value="{{ $key }}" @if($appends['job_channel'] === $key) selected @endif>{{ $channel['text'] }}</option>
                    @endforeach
                </select>
            </div>
          </div>
          <button type="submit" class="btn btn-danger">搜索</button>
        </div>
      </form>

      <table class="table default-table">
        <thead>
          <tr>
            <th scope="col">发布顾问</th>
            <th scope="col">职位编号</th>
            <th scope="col">职位名称</th>
            <th scope="col">招聘企业</th>
            <th scope="col">发布渠道</th>
            <th scope="col">应聘简历</th>
            <th scope="col">发布日期</th>
            <th scope="col">操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach($jobs as $job)
            <tr>
              <td>{{ $job->executeUser->name }}</td>
              <td>{{ $job->no }}</td>
              <td class="color-red">{{ $job->name }}</td>
              <td>{{ $job->company->name }}</td>
              <td>{{ $job->channelShow }}</td>
              <td>{{ $job->resumes->count() }}</td>
              <td>{{ $job->created_at }}</td>
              <td>
                <div class="btn-group" role="group">
                  <button id="btnGroupDrop1" type="button" class="btn dropdown-toggle btn-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    操作
                  </button>
                  <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <a class="dropdown-item" href="#" onclick="$('form[name=search1]').submit()">刷新</a>
                    @if ($appends['tab'] === 'job_doing')
                      <form method="POST" action="{{ route('jobs.status', [$job->id, 'status' => 'end']) }}">
                        {{ csrf_field() }}
                        <button class="dropdown-item" type="button" data-toggle="modal" data-target="#confirmModal" data-type="job">结束</button>
                      </form>
                    @endif
                    @if ($appends['tab'] === 'job_end')
                      <form method="POST" action="{{ route('jobs.destroy', $job) }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="dropdown-item" type="button" data-toggle="modal" data-target="#confirmModal" data-type="job">删除</button>
                      </form>
                    @endif
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
