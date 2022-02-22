@extends('layouts.default')
@section('title', '文章发布')
@section('content')

<div class="articles-index bg-white">
  @if ($articles->count() > 0)
    <table class="table table-striped default-table">
      <thead>
        <tr>
          <th scope="col">标题</th>
          <th scope="col">封面</th>
          <th scope="col">简介</th>
          <th scope="col">分类</th>
          <th scope="col">发布人</th>
          <th scope="col">发布时间</th>
          <th scope="col">最后更新时间</th>
          <th scope="col">操作</th>
        </tr>
      </thead>
      <tbody>
        @foreach($articles as $article)
          <tr>
            <td>{{ $article->title }}</td>
            <td><img class="cover" src="{{ $article->cover_url }}"></td>
            <td>{{ $article->brief }}</td>
            <td>{{ $article->articleType->name }}</td>
            <td>{{ $article->publisher->name }}（{{ $article->publisher->nickname }}）</td>
            <td>{{ $article->created_at }}</td>
            <td>{{ $article->updated_at }}</td>
            <td>
              <div class="btn-group" role="group">
                <button id="btnGroupDrop1" type="button" class="btn dropdown-toggle btn-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  操作
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                  <a target="_blank" class="dropdown-item" href="{{ route('articles.show', $article) }}">查看</a>
                  @can('update', $article)
                    <a class="dropdown-item" href="{{ route('articles.edit', $article) }}">修改</a>
                  @endcan
                  @can('delete', $article)
                    <form method="POST" action="{{ route('articles.destroy', $article) }}">
                      {{ csrf_field() }}
                      {{ method_field('DELETE') }}
                      <button class="dropdown-item" type="button" data-toggle="modal" data-target="#confirmModal" data-type="article">删除</button>
                    </form>
                  @endcan
                </div>
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="row justify-content-end">
      <div class="col-auto">
        {{ $articles->links('vendor.pagination.bootstrap-4') }}
      </div>
    </div>
  @else
    <div class="empty row">
      <div class="col text-center m-auto">
        <img src="{{ URL::asset('images/empty.png') }}">
        <p>暂无</p>
      </div>
    </div>
  @endif
</div>

@include('shared._confirm')

@stop
