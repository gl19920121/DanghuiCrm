@extends('layouts.default')
@section('title', '登录')
@section('content')
    <div class="login-card">
        <div class="card">
            <div class="card-header text-center">
                <img src="{{ URL::asset('images/logo.png') }}" alt="" />
            </div>
            <div class="card-body">
                <form class="login-form" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <img src="{{ URL::asset('images/icon_user.png') }}" />
                            </span>
                            <input type="text" name="account" class="form-control" value="{{ old('account') }}" placeholder="用户名" autocomplete="off" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <img src="{{ URL::asset('images/icon_pwd.png') }}" />
                            </span>
                            <input type="password" name="password" class="form-control" value="{{ old('password') }}" placeholder="密码" />
                        </div>
                    </div>
                    <div class="text-right forget">
                        <a href="">忘记密码</a>
                    </div>
                    <button type="submit" class="btn btn-danger btn-login">登录</button>
                </form>
            </div>
            <div class="card-footer text-center">
                <p>当会官网：<a href="www.danghui.com">www.danghui.com</a></p>
            </div>
        </div>
    </div>

    @include('shared._errors')
@stop
