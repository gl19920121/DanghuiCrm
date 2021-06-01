@extends('layouts.default')
@section('title', '人才管理')
@section('content')
<div class="resume-mine">
    <div class="row">
        <div class="col col-auto bg-gray">
            <div class="mine-nav">
                <ul class="nav-sec-left">
                    <li>我的人才库</li>
                    <li>人才来源</li>
                </ul>
            </div>
        </div>

        <div class="col bg-white">
            <div class="mine-body"></div>
        </div>
    </div>
    <form method="GET" action="{{ route('resumes.mine') }}">
        <div class="mine-form">
        </div>
    </form>
</div>
@stop
