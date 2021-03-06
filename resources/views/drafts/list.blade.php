@extends('jobs.layouts.list')
@section('list')

  <div class="job-list-body">

    @if (count($drafts) > 0)
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
            @foreach ($drafts as $draft)
              <tr onclick="window.location = '{{ route('jobs.create', ['draft_id' => $draft->id]) }}';">
                <td>
                  <span class="color-red">{{ $draft->name }}</span>
                </td>
                <td>{{ $draft->company_name }}</td>
                <td>{{ $draft->channel }}</td>
                <td>{{ $draft->updated_at }}</td>
                <td>
                  <form method="POST" action="{{ route('drafts.destroy', $draft) }}">
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
            {{ $drafts->appends($appends)->onEachSide(5)->links('vendor.pagination.bootstrap-4') }}
          </div>
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
@stop
