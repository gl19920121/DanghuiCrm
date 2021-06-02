@extends('layouts.default')
@section('title', '人才管理')
@section('content')
<div class="resume-mine">
    <div class="row no-gutters">
        <div class="col col-auto">
            <div class="mine-nav bg-gray">
                <ul class="nav-sec-left">
                    <li>
                        <a href="#">我的人才库</a>
                        <ul class="sub">
                            <li @if($tab === 'all' || empty($tab)) class="active" @endif>
                                <a href="{{ route('resumes.mine', ['tab' => 'all']) }}">我的人才库（{{ $countInfo['all'] }}）</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">人才来源</a>
                        <ul class="sub">
                            <li @if($tab === 'seen') class="active" @endif>
                                <a href="{{ route('resumes.mine', ['tab' => 'seen']) }}">浏览的简历（{{ $countInfo['seen'] }}）</a>
                            </li>
                            <li @if($tab === 'apply') class="active" @endif>
                                <a href="{{ route('resumes.mine', ['tab' => 'apply']) }}">应聘的简历（{{ $countInfo['apply'] }}）</a>
                            </li>
                            <li @if($tab === 'commission') class="active" @endif>
                                <a href="{{ route('resumes.mine', ['tab' => 'commission']) }}">委托的简历（{{ $countInfo['commission'] }}）</a>
                            </li>
                            <li @if($tab === 'collect') class="active" @endif>
                                <a href="{{ route('resumes.mine', ['tab' => 'collect']) }}">收藏的简历（{{ $countInfo['collect'] }}）</a>
                            </li>
                            <li @if($tab === 'seenmy') class="active" @endif>
                                <a href="{{ route('resumes.mine', ['tab' => 'seenmy']) }}">看过我的人（{{ $countInfo['seenmy'] }}）</a>
                            </li>
                            <li @if($tab === 'relay') class="active" @endif>
                                <a href="{{ route('resumes.mine', ['tab' => 'relay']) }}">转发的简历（{{ $countInfo['relay'] }}）</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col">
            <div class="mine-body bg-white">
                <form id="searchForm"  method="GET" action="{{ route('resumes.mine') }}">
                    <div class="mine-form">
                        @if ($tab === 'all')
                            <div class="mt-2 mb-2">
                                @include('resumes.shared._search')
                            </div>
                            <div class="row justify-content-end mb-2">
                                <div class="col col-auto">
                                    <p>共<span class="color-red ml-1 mr-1">{{ $resumes->total() }}</span>份简历</p>
                                </div>
                            </div>
                        @else
                            <div class="row justify-content-between mt-2">
                                <div class="col">
                                    <p class="font-size-l">
                                        @switch ($tab)
                                            @case ('all')
                                                我的人才搜索
                                                @break
                                            @case ('seen')
                                                浏览的简历
                                                @break
                                            @case ('apply')
                                                应聘的简历
                                                @break
                                            @case ('commission')
                                                委托的简历
                                                @break
                                            @case ('collect')
                                                收藏的简历
                                                @break
                                            @case ('seenmy')
                                                看过我的人
                                                @break
                                            @case ('relay')
                                                转发的简历
                                                @break
                                        @endswitch
                                    </p>
                                </div>
                                @if ($tab === 'seen')
                                    <div class="col col-auto">
                                        <p class="font-size-s color-text-gray">仅保留近6个月的浏览记录</p>
                                    </div>
                                @endif
                            </div>
                            <div class="row justify-content-between mb-2">
                                <div class="col">
                                    <div class="form-group form-inline">
                                        <div class="input-group date datetimepicker normal">
                                          <input type="text" name="work_experience[0][start_at]" class="form-control append" placeholder="开始时间" autocomplete="off">
                                          <div class="input-group-append">
                                            <span class="input-group-text">
                                              <svg class="bi bi-calendar3-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2H0z"/>
                                                <path fill-rule="evenodd" d="M0 3h16v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3zm6.5 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-8 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-8 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                              </svg>
                                            </span>
                                          </div>
                                        </div>
                                        <label class="ml-2 mr-2">至</label>
                                        <div class="input-group date datetimepicker normal">
                                          <input type="text" name="work_experience[0][end_at]" class="form-control append" placeholder="结束时间" autocomplete="off">
                                          <div class="input-group-append">
                                            <span class="input-group-text">
                                              <svg class="bi bi-calendar3-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2H0z"/>
                                                <path fill-rule="evenodd" d="M0 3h16v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3zm6.5 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-8 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-8 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm2 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm4-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                              </svg>
                                            </span>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-auto">
                                    <p>共<span class="color-red ml-1 mr-1">{{ $resumes->total() }}</span>份简历</p>
                                </div>
                            </div>
                        @endif
                        <input type="hidden" name="show_detail" value="{{ $showDetail }}">
                    </div>
                </form>

                <div class="body-list">
                    @include('resumes.shared._list', ['tab' => $tab])
                </div>
            </div>
        </div>
    </div>

</div>
@stop
