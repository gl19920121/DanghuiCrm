@extends('layouts.default')
@section('title', '发布职位')
@section('content')
<div class="job-detail">
  <div class="job-detail-header bg-white">
    <div class="row justify-content-between">
      <div class="col-auto">
        <small>职位编号：{{ $job->id }}</small>
      </div>
      <div class="col-auto">
        <small>更新时间：{{ $job->created_at }}</small>
      </div>
    </div>
    <div class="row align-items-center">
      <div class="col-auto">
        <h1>{{ $job->name }}</h1>
      </div>
      @if ($job->urgency_level === 1)
        <div class="col-auto">
          <div class="tag-red text-center">紧急</div>
        </div>
      @endif
    </div>
    <div class="row justify-content-start">
      <div class="col-auto" style="width: 207px;">
        <p>企业：{{ $job->company }}</p>
      </div>
      <div class="col-auto">
        <p>|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;招聘人数：{{ empty($job->quota) ? '-' : $job->quota }}人</p>
      </div>
    </div>
    <div class="row align-items-center justify-content-between">
      <div class="col-auto">
        <div class="row">
          <div class="col-auto" style="width: 207px;">
            <h6><label>9</label>浏览人数&nbsp;&nbsp;&nbsp;<label>9</label>次投递</h6>
          </div>
          <div class="col-auto">
            <p>|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;分享</p>
          </div>
        </div>
      </div>
      <div class="col-auto">
        <button class="btn btn-danger">导出</button>
        <div class="btn-group" role="group">
          <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle btn-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            更多操作
          </button>
          <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <a class="dropdown-item" href="#">刷新</a>
            <a class="dropdown-item" href="#">修改</a>
            <a class="dropdown-item" href="#">暂停</a>
            <a class="dropdown-item" href="#">结束</a>
            <a class="dropdown-item" href="#">删除</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="job-detail-list bg-white">
    <div class="my-nav-tabs">
      <ul class="nav nav-tabs mr-4" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="job-tab" data-toggle="tab" href="#admin" role="tab" aria-controls="job"
                aria-selected="true">
            <h6>相关简历</h6>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="accept-tab" data-toggle="tab" href="#edit" role="tab" aria-controls="accept"
              aria-selected="false">
            <h6>职位详情</h6>
          </a>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent" >
        <div class="tab-pane fade show active" id="admin" role="tabpanel" aria-labelledby="job-tab">
          <ul class="list-group list-group-flush">
            <li class="list-group-item">
              <table class="table table-striped default-table">
                <thead>
                  <tr>
                    <th scope="col">姓名</th>
                    <th scope="col">运作状态</th>
                    <th scope="col">性别</th>
                    <th scope="col">年龄</th>
                    <th scope="col">工作年限</th>
                    <th scope="col">教育程度</th>
                    <th scope="col">目前公司</th>
                    <th scope="col">目前职位</th>
                    <th scope="col">目前月薪</th>
                    <th scope="col">投递时间</th>
                    <th scope="col">操作</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($resumes as $resume)
                    <tr>
                      <td class="color-red">{{ $resume->name }}</td>
                      <td>{{ $resume->status }}</td>
                      <td>{{ $resume->sex }}</td>
                      <td>{{ $resume->age }}</td>
                      <td>{{ $resume->education }}</td>
                      <td>{{ $resume->cur_company }}</td>
                      <td>{{ $resume->cur_position }}</td>
                      <td>{{ $resume->cur_salary }}</td>
                      <td>{{ $resume->created_at }}</td>
                      <td>
                        <div class="btn-group" role="group">
                          <button id="btnGroupDrop1" type="button" class="btn dropdown-toggle btn-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            操作
                          </button>
                          <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <a class="dropdown-item" href="#">加入电话沟通</a>
                            <a class="dropdown-item" href="#">待定</a>
                            <a class="dropdown-item" href="#">淘汰</a>
                          </div>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </li>
          </ul>
        </div>
        <div class="tab-pane fade" id="edit" role="tabpanel" aria-labelledby="accept-tab">
            <ul class="list-group list-group-flush">
              <li class="list-group-item"></li>
            </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@stop
