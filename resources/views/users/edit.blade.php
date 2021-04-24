@extends('layouts.default')
@section('title', '修改账户')
@section('content')
<div class="offset-md-2 col-md-8">
    <div class="card ">
    <div class="card-header">
    <h5>修改账户</h5>
</div>
<div class="card-body">
    @include('shared._errors')
    <form method="POST" action="{{ route('users.update', $user->id) }}">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <div class="form-group">
            <label for="account">账户名称：</label>
            <input type="text" name="account" class="form-control" value="{{ $user->account }}" />
        </div>
        <div class="form-group">
            <label for="role_id">权限等级：</label>
            <input type="text" name="role_id" class="form-control" value="{{ $user->role_id }}" />
        </div>
        <div class="form-group">
            <label for="password">密码：</label>
            <input type="password" name="password" class="form-control" value="{{ $user->password }}" />
        </div>
        <div class="form-group">
            <label for="name">姓名:</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" />
        </div>
        <div class="form-group">
            <label for="sex">性别:</label>
            <input type="text" name="sex" class="form-control" value="{{ $user->sex }}" />
        </div>
        <div class="form-group">
            <label for="job">职位:</label>
            <input type="text" name="job" class="form-control" value="{{ $user->job }}" />
        </div>
        <div class="form-group">
            <label for="email">邮箱:</label>
            <input type="text" name="email" class="form-control" value="{{ $user->email }}" />
        </div>
        <div class="form-group">
            <label for="phone">手机号:</label>
            <input type="text" name="phone" class="form-control" value="{{ $user->phone }}" />
        </div>

        <button type="submit" class="btn btn-primary">修改账户</button>
    </form>
</div>
