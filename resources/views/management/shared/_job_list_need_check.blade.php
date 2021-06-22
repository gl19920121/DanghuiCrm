<div class="job-list-body">

  <div class="default-list">
    <label class="color-gray">共有<span class="color-red">{{ $jobs->total() }}</span>个待审核职位</label>
    @if (count($jobs) > 0)
      <table class="table default-table">
        <thead>
          <tr>
            <th scope="col">待审核职位</th>
            <th scope="col">发布顾问</th>
            <th scope="col">招聘企业</th>
            <th scope="col">发布渠道</th>
            <th scope="col">申请时间</th>
            <th scope="col">操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach($jobs as $job)
            <tr>
              <td class="color-red">{{ $job->name }}</td>
              <td>{{ $job->executeUser->name }}</td>
              <td>{{ $job->company->name }}</td>
              <td>{{ $job->channelShow }}</td>
              <td>{{ $job->created_at }}</td>
              <td>
                <div class="btn-group" role="group">
                  <button id="btnGroupDrop1" type="button" class="btn dropdown-toggle btn-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    操作
                  </button>
                  <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <form method="POST" action="{{ route('jobs.status', [$job, 'status' => 1]) }}">
                      {{ csrf_field() }}
                      <button class="dropdown-item" type="submit" data-toggle="modal" data-type="job">通过</button>
                    </form>
                    <form method="POST" action="{{ route('jobs.destroy', $job) }}">
                      {{ csrf_field() }}
                      {{ method_field('DELETE') }}
                      <button class="dropdown-item" type="submit" data-toggle="modal" data-type="job">驳回</button>
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

@include('shared._confirm')
