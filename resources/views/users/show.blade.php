@extends('layouts.default')
@section('title', $user->name)
@section('content')

@include('shared._user_info', ['user' => $user])
<a href="{{ route('users.edit', $user) }}">修改</a>
@can('destroy', $user)
    <form action="{{ route('users.destroy', $user) }}" method="POST">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <button class="nav-link" type="submit" name="button">删除</button>
    </form>
@endcan
@stop
