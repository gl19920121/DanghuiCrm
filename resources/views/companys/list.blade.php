@extends('layouts.default')
@section('title', '企业管理')
@section('content')
<div class="job-list bg-white">
  <div class="job-list-body">
    @if (count($companys) > 0)
      <div class="default-list">
        <form class="text-center" method="GET" action="{{ route('companys.list') }}">
          {{ csrf_field() }}
          <div class="row align-items-center mb-4">
            <div class="col-auto">
              <div class="form-inline">
                  <input type="text" name="company_name" class="form-control normal" value="{{ $appends['name'] }}" placeholder="请输入企业名称" />
              </div>
            </div>
            <button type="submit" class="btn btn-danger">搜索</button>
          </div>
        </form>

        <table class="table table-striped default-table">
          <thead>
            <tr>
              <th scope="col">企业名称</th>
              <th scope="col">所在地</th>
              <th scope="col">行业</th>
              <th scope="col">企业规模</th>
              <th scope="col">企业性质</th>
              <th scope="col">职位数量</th>
              <th scope="col">更新时间</th>
              <th scope="col">操作</th>
            </tr>
          </thead>
          <tbody>
            @foreach($companys as $company)
              <tr>
                <td>
                  <a class="color-red" href="{{ route('companys.show', $company) }}">{{ $company->name }}</a>
                </td>
                <td>{{ $company->location_show }}</td>
                <td>{{ $company->industry_show }}</td>
                <td>{{ $company->scale_show }}</td>
                <td>{{ $company->nature_show }}</td>
                <td class="color-red">{{ $company->jobs_count }}</td>
                <td>{{ $company->created_at }}</td>
                <td>
                  <div class="btn-group" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn dropdown-toggle btn-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      操作
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                      <a class="dropdown-item" href="{{ route('companys.list') }}">刷新</a>
                      <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#companyEditModal" data-item="{{ ($company) }}">修改</a>
                      <form method="POST" action="{{ route('companys.destroy', $company) }}">
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
            {{ $companys->appends($appends)->links('vendor.pagination.bootstrap-4') }}
          </div>
        </div>
      </div>
    @else
      <div class="empty row">
        <div class="col text-center m-auto">
          <img src="{{ URL::asset('images/empty.png') }}">
          <p>您还未添加企业</p>
        </div>
      </div>
    @endif
  </div>
</div>

@include('companys.shared._company_edit')
@include('shared._industry')

@stop
