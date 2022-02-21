@extends('layouts.default')
@section('title', '文章发布')
@section('content')

@include('UEditor::head')
@include('shared._errors')

<div class="articles-create articles-edit bg-white">
  <form class="text-center" method="POST" action="{{ route('articles.update', $article) }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}
    <div class="form-group form-inline">
      <span class="title must"><label for="title">标题</label></span>
      <input type="text" name="title" value="{{ $article->title }}" class="form-control must @if($errors->has('title')) border-danger @endif" value="{{ old('title') }}" placeholder="请填写标题" autocomplete="off">
    </div>

    <div class="form-group form-inline">
      <span class="title must"><label for="cover">封面</label></span>
      <div data-toggle="filechoose" data-type="cover" data-size="normal">
        <img src="{{ $article->cover_url }}" class="cover">
        <input hidden type="file" multiple="true" accept="image/png, image/jpeg" name="cover" class="form-control">
      </div>
    </div>

    <div class="form-group form-inline">
      <span class="title"><label for="brief">简介</label></span>
      <input type="text" name="brief" value="{{ $article->brief }}" class="form-control @if($errors->has('brief')) border-danger @endif" value="{{ old('brief') }}" placeholder="请填写简介，默认从正文开头截取" autocomplete="off">
    </div>

    <div class="form-group form-inline">
      <span class="title must"><label for="cover">分类</label></span>
      @foreach ($types as $level => $litem)
        @foreach ($litem as $pno => $pitem)
          <select data-level="{{ $level }}" data-pno="{{ $pno }}" name="type_no[{{ $level }}]" class="form-control must normal @if($errors->has('type')) border-danger @endif"
          @if($level !== 0 && !in_array($pno, $article->articleType->relation->pluck('no')->toArray()))
            style="display: none;"
          @endif
          >
            <option hidden value="">请选择</option>
            @foreach ($pitem as $type)
              <option value="{{ $type->no }}" @if($article->article_types_id === $type->id || in_array($type->no, $article->articleType->relation->pluck('no')->toArray())) selected @endif>{{ $type->name }}</option>
            @endforeach
          </select>
        @endforeach
      @endforeach
    </div>

    <div class="form-group form-inline">
      <span class="title must"><label for="cover">发布人</label></span>
      <select name="publisher_id" class="form-control must normal @if($errors->has('user')) border-danger @endif">
        <option hidden value="">请选择</option>
        @foreach ($users as $user)
          <option @if($article->publisher_id === $user->id) selected @endif value="{{ $user->id }}">{{ $user->name }}（{{ $user->nickname }}）</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <textarea id="ueditor" name="content" placeholder="编辑文章正文内容">{{ $article->content }}</textarea>
    </div>

    <input class="btn btn-danger btn-submit" type="submit" value="提交">
    <a href="{{ route('articles.index') }}" class="btn btn-light btn-cancel">取消</a>
  </form>
</div>

<script type="text/javascript">
  var ue = UE.getEditor('ueditor', {
    initialFrameWidth : 1200,
    initialFrameHeight : 350,
  });
  ue.ready(function() {
    //此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
    ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
  });

  $("select[name^='type_no']").change(function() {
    let index = $(this).index() - 1;
    $("select[name^='type_no']:gt(" + index + ")").val("");
    $("select[name^='type_no']:gt(" + index + ")").hide();
    $("select[data-pno='" + $(this).val() + "']").show();
  });
</script>

@stop
