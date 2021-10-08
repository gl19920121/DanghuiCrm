@extends('layouts.default')
@section('title', '企业管理')
@section('content')
<div class="company-detail bg-white">
  <div class="company-detail-body">
    <div class="row row-cols-4">
      <div class="col-12">
        <h5>企业基本信息</h5>
      </div>
      <div class="col">
        <p class="font-size-m"><span class="color-gray">公司名称：</span>{{ $company->name }}</p>
      </div>
      <div class="col">
        <p class="font-size-m"><span class="color-gray">所在地：</span>{{ $company->locationShow }}</p>
      </div>
      <div class="col">
        <p class="font-size-m"><span class="color-gray">详细地址：</span>{{ $company->address }}</p>
      </div>
      <div class="col">
        <p class="font-size-m"><span class="color-gray">所属行业：</span>{{ $company->industryShow }}</p>
      </div>
      <div class="col">
        <p class="font-size-m"><span class="color-gray">企业性质：</span>{{ $company->natureShow }}</p>
      </div>
      <div class="col">
        <p class="font-size-m"><span class="color-gray">企业规模：</span>{{ $company->scaleShow }}</p>
      </div>
      <div class="col">
        <p class="font-size-m"><span class="color-gray">融资阶段：</span>{{ $company->investmentShow }}</p>
      </div>
      <div class="col-12">
        <p class="font-size-m"><span class="color-gray">企业介绍：</span>{{ $company->introduction }}</p>
      </div>
    </div>
    <hr class="divider">
    <div class="row row-cols-5">
      <div class="col-12">
        <h5>相关职位列表</h5>
      </div>
      <div class="col-12">
        <div class="row align-items-center">
          <div class="col col-auto">
            <span class="font-size-m color-gray">职位名称：</span>
          </div>
          @foreach ($company->jobs as $job)
            <div class="col col-auto">
              <a class="btn btn-light" href="{{ route('jobs.show', $job) }}">{{ $job->name }}</a>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
@stop
