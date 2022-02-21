@extends('layouts.default')
@section('title', '文章发布')
@section('content')

  <div class="articles-show">
    <div class="header-nav">
      <div>
        <p>
          @foreach ($article->articleType->relation as $articleType)
            <span class="item">{{ $articleType->name }}</span>
          @endforeach
          <span class="item">文章详情</span>
        </p>
      </div>
    </div>

    <div class="content">
      <div>
        <p class="title">{{ $article->title }}</p>
        <p class="sub">
          <span>{{ $article->created_at->toDateTimeString() }}</span>
          <span class="ms-3">作者{{ $article->publisher->nickname }}</span>
        </p>
        <hr class="divider">
        <div>{!! $article->content !!}</div>
      </div>
    </div>

    <div class="footer" style="padding-bottom: 50px;">
      <div class="row justify-content-center">
        <div class="col col-auto">
          <a href="{{ route('articles.edit', $article) }}" class="btn btn-light">修改</a>
        </div>
        <div class="col col-auto">
          <form method="POST" action="{{ route('articles.destroy', $article) }}">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#confirmModal" data-type="article">删除</button>
          </form>
        </div>
      </div>
    </div>
  </div>

@include('shared._confirm')

@stop
