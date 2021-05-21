@extends('layouts.default')
@section('title', '编辑'.$user->name)
@section('content')
<div class="user-edit bg-white">
  <div class="default-form">
    <div class="form-body">
      @if ($part === 'account')
        @include('users.shared._account_info')
      @else
        @include('users.shared._user_info')
      @endif
    </div>
  </div>
</div>
@stop
