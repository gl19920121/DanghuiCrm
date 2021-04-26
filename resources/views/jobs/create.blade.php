@extends('layouts.default')
@section('title', '发布职位')
@section('content')
<!-- offset-md-2 col-md-8 -->
<div class="job-create">
    <div class="default-form">
        <div class="form-header"></div>
        <hr class="divider">
        <div class="form-body">
            @include('shared._errors')
            <form class="text-center" method="POST" action="{{ route('users.store') }}">
                {{ csrf_field() }}
                <div class="form-title text-left">
                    <h5>企业基本信息</h5>
                </div>
                <div class="form-group form-inline">
                    <span>*</span><label for="account">公司名称：</label>
                    <input type="text" name="account" class="form-control" value="{{ old('account') }}" placeholder="请填写" />
                </div>
                <div class="form-group form-inline">
                    <span></span><label for="role_id">招聘人数：</label>
                    <input type="text" name="role_id" class="form-control" value="{{ old('role_id') }}" />
                </div>
                <div class="form-title text-left">
                    <h5>职业基本信息</h5>
                </div>
                <div class="form-group form-inline">
                    <span>*</span><label for="password">职位名称：</label>
                    <input type="password" name="password" class="form-control" value="{{ old('password') }}" />
                </div>
                <div class="form-group form-inline">
                    <span>*</span><label for="password_confirmation">职位类别：</label>
                    <input type="password" name="password_confirmation" class="form-control" />
                </div>
                <div class="form-group form-inline">
                    <span>*</span><label for="name">工作性质：</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" />
                </div>
                <div class="form-group form-inline">
                    <span>*</span><label for="sex">工作城市：</label>
                    <input type="text" name="sex" class="form-control" value="{{ old('sex') }}" />
                </div>
                <div class="form-group form-inline">
                    <span>*</span><label for="job">税前月薪：</label>
                    <input type="text" name="job" class="form-control" value="{{ old('job') }}" />
                </div>
                <div class="form-group form-inline">
                    <span>*</span><label for="email">福利待遇：</label>
                    <input type="text" name="email" class="form-control" value="{{ old('email') }}" />
                </div>

                <button style="margin-top: 100px;" type="submit" class="btn btn-danger">发布职位</button>
            </form>
        </div>
    </div>
</div>
@stop
