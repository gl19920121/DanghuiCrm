@extends('layouts.default')
@section('title', '发布职位')
@section('content')
<div class="job-list bg-white">
  <div class="my-nav-tabs-top">
    <ul class="nav nav-tabs text-center" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="ing-tab" data-toggle="tab" href="#ing" role="tab" aria-controls="ing"
              aria-selected="true">
          进行中职位
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="pause-tab" data-toggle="tab" href="#pause" role="tab" aria-controls="pause"
            aria-selected="false">
          已暂停职位
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="end-tab" data-toggle="tab" href="#end" role="tab" aria-controls="task"
            aria-selected="false">
          已结束职位
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="drafts-tab" data-toggle="tab" href="#drafts" role="tab" aria-controls="drafts"
            aria-selected="false">
          职位草稿箱
        </a>
      </li>
    </ul>
  </div>
  <div class="tab-content">
    <div class="tab-pane fade show active" id="ing" role="tabpanel" aria-labelledby="ing-tab">
      <ul class="list-group list-group-flush">
        <li class="list-group-item">
          <div class="job-list-body">
            <div class="default-list">
              @include('shared._list_job')
            </div>
          </div>
        </li>
      </ul>
    </div>
    <div class="tab-pane fade show" id="pause" role="tabpanel" aria-labelledby="pause-tab">
      <ul class="list-group list-group-flush">
        <li class="list-group-item">
          <div class="job-list-body">
            <div class="default-list">
              @include('shared._list_job')
            </div>
          </div>
        </li>
      </ul>
    </div>
    <div class="tab-pane fade show" id="end" role="tabpanel" aria-labelledby="end-tab">
      <ul class="list-group list-group-flush">
        <li class="list-group-item">
          <div class="job-list-body">
            <div class="default-list">
              @include('shared._list_job')
            </div>
          </div>
        </li>
      </ul>
    </div>
    <div class="tab-pane fade show" id="drafts" role="tabpanel" aria-labelledby="drafts-tab">
      <ul class="list-group list-group-flush">
        <li class="list-group-item">
          <div class="job-list-body">
            <div class="default-list">

            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</div>
@stop
