<div class="job-list-body">

  <div class="default-list">
    <form name="search" class="text-center" method="GET" action="{{ route('management.staff.list') }}">
      {{ csrf_field() }}
      <input type="hidden" name="tab" value="{{ $appends['tab'] }}">
      <div class="row align-items-center mb-4">
        <div class="col-auto">
          <div class="form-inline">
              <label for="start_at">统计时间：</label>
              <div class="input-group date datetimepicker">
                <input type="text" name="start_at" class="form-control normal append" value="{{ $appends['start_at'] }}" placeholder="起始时间" autocomplete="off">
                <div class="input-group-append">
                  <span class="input-group-text">
                    <svg class="bi bi-calendar3-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                      <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2H0z"/>
                      <path fill-rule="evenodd" d="M0 3h16v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3zm6.5 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-8 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-8 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                    </svg>
                  </span>
                </div>
              </div>
              <span class="ml-2 mr-2">——</span>
              <div class="input-group date datetimepicker">
                <input type="text" name="end_at" class="form-control normal append" value="{{ $appends['end_at'] }}" placeholder="结束时间" autocomplete="off">
                <div class="input-group-append">
                  <span class="input-group-text">
                    <svg class="bi bi-calendar3-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                      <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2H0z"/>
                      <path fill-rule="evenodd" d="M0 3h16v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3zm6.5 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-8 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-8 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                    </svg>
                  </span>
                </div>
              </div>
              <div class="custom-control custom-checkbox custom-control-inline ml-3">
                <input type="checkbox" name="is_not_end" id="toNow" class="custom-control-input"
                @if ($appends['is_not_end'] === 'on')
                  checked
                @endif
                >
                <label class="custom-control-label" for="toNow">至今</label>
              </div>
          </div>
        </div>
        <button type="submit" class="btn btn-danger">查找</button>
      </div>
    </form>
    @if (count($users) > 0)
      <table class="table default-table">
        <thead>
          <tr>
            <th scope="col">发布顾问</th>
            <th scope="col">运作职位</th>
            <th scope="col">待审核职位</th>
            <th scope="col">操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $user)
            <tr>
              <td>
                @if ($user instanceof App\Models\Department)
                  <a href="{{ route('management.staff.department.list', ['department' => $user]) }}">{{ $user->name }}</a>
                @else
                  <a href="{{ route('management.staff.user.list', ['user' => $user]) }}">{{ $user->name }}</a>
                @endif
              </td>
              <td class="color-red">{{ $user->jobs_count }}</td>
              <td>{{ $user->checkpending_jobs_count }}</td>
              <td>
                <div class="btn-group" role="group">
                  <button id="btnGroupDrop1" type="button" class="btn dropdown-toggle btn-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    操作
                  </button>
                  <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <a class="dropdown-item" href="">刷新</a>
                    <a class="dropdown-item" href="{{ route('excel.export.user.job', ['id' => [$user->id], 'type' => 'user', 'start_at' => $appends['start_at'], 'end_at' => $appends['end_at']]) }}">导出</a>
                  </div>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

      <div class="row justify-content-end">
        <div class="col-auto">
          {{ $users->appends($appends)->links('vendor.pagination.bootstrap-4') }}
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
