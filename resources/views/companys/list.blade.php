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
                  <input type="text" name="name" class="form-control normal" value="{{ $appends['name'] }}" placeholder="请输入企业名称" />
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
                <td class="color-red">{{ $company->name }}</td>
                <td>{{ $company->location }}</td>
                <td>{{ $company->industry }}</td>
                <td>{{ $company->scale }}</td>
                <td>{{ $company->nature }}</td>
                <td class="color-red">{{ $company->jobs_count }}</td>
                <td>{{ $company->updated_at }}</td>
                <td>
                  <div class="btn-group" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn dropdown-toggle btn-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      操作
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                      <a class="dropdown-item" href="#">刷新</a>
                      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#companyEditModal" onclick="setCompany({{ json_encode($company) }})">修改</a>
                      <!-- route('companys.edit', $company) -->
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
<input type="hidden" id="companyInfo">
<script type="text/javascript">
  function setCompany(data)
  {
    //var company = JSON.parse(data);
    console.log(data);
    $('#companyInfo').val(data);
    var data = $('#companyInfo').val();
    console.log(data);
  }
</script>
@include('companys.shared._company_edit')
@stop
