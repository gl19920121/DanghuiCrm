@extends('layouts.default')
@section('title', '文章发布')
@section('content')

@include('UEditor::head')
@include('shared._errors')

<div class="articles-create bg-white">
  <form class="text-center" method="POST" action="{{ route('articles.store') }}" enctype="multipart/form-data">
    {{ csrf_field() }}

    <div class="form-group form-inline">
      <span class="title must"><label for="title">标题</label></span>
      <input type="text" name="title" class="form-control must @if($errors->has('title')) border-danger @endif" value="{{ old('title') }}" placeholder="请填写标题" autocomplete="off">
    </div>

    <div class="form-group form-inline">
      <span class="title must"><label for="cover">封面</label></span>
      <div data-toggle="filechoose" data-type="cover" data-size="normal">
        <img hidden class="cover">
        <button type="button" class="btn btn-danger">选择封面</button>
        <input hidden type="file" multiple="true" accept="image/png, image/jpeg" name="cover" class="form-control">
      </div>
    </div>

    <div class="form-group form-inline">
      <span class="title"><label for="brief">简介</label></span>
      <input type="text" name="brief" class="form-control @if($errors->has('brief')) border-danger @endif" value="{{ old('brief') }}" placeholder="请填写简介，默认从正文开头截取" autocomplete="off">
    </div>

    <div class="form-group form-inline">
      <span class="title must"><label for="cover">分类</label></span>
      @foreach ($types as $level => $litem)
        @foreach ($litem as $pno => $pitem)
          <select @if($level !== 0) style="display: none;" @endif data-level="{{ $level }}" data-pno="{{ $pno }}" name="type_no[{{ $level }}]" class="form-control must normal @if($errors->has('type')) border-danger @endif">
            <option hidden value="">请选择</option>
            @foreach ($pitem as $type)
              <option value="{{ $type->no }}">{{ $type->name }}</option>
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
          <option @if(Auth::user()->id === $user->id) selected @endif value="{{ $user->id }}">{{ $user->name }}（{{ $user->nickname }}）</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <textarea id="ueditor" name="content" placeholder="编辑文章正文内容"></textarea>
    </div>

    <input class="btn btn-danger btn-submit" type="submit" value="提交">
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
    $("select[name^='type_no']:gt(" + index + ")").hide();
    $("select[data-pno='" + $(this).val() + "']").show();
  });
</script>

@stop
