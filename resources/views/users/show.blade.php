@extends('layouts.default')
@section('title', $user->name)
@section('content')
<div hidden class="row">
    <div class="offset-md-2 col-md-8">
        <div class="col-md-12">
            <div class="offset-md-2 col-md-8">
                <section class="user_info">
                    @include('shared._user_info', ['user' => $user])
                </section>

                <a href="{{ route('users.edit', $user) }}">修改</a>
                @can('destroy', $user)
                    <form action="{{ route('users.destroy', $user) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="nav-link" type="submit" name="button">删除</button>
                    </form>
                @endcan
            </div>
        </div>
    </div>
</div>
@stop
