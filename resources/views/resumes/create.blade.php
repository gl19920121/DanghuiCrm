@extends('layouts.default')
@section('title', '上传简历')
@section('content')
<div class="resume-create bg-white">
  <div class="default-form">
    <div class="form-header"></div>
    <hr class="divider">
    <div class="form-body">
      <div class="form-title ">
        <h5 class="font-size-l">上传简历</h5>
      </div>

      <div class="body">
        <p class="font-size-m">人才库管理，是当会直聘为广大招聘顾问提供的高效简历管理服务。当会直聘提供对简历的解析服务，但在未经允许的情况下不对解析结果进行任何修改或编辑。支持格式包括: DOC , DOCX ,WORD，文件大小不超过10MB</p>
        <div class="text-center mt-5">
          <form id="resumeUpload" method="POST" action="{{ route('resumes.create.auto') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input hidden type="file" multiple="true" name="resume">
          </form>
          <button class="btn btn-danger" onclick="setResume()">上传简历</button>
          <a href="{{ route('resumes.create.manual') }}" class="btn btn-light ml-2">手动添加</a>
        </div>
      </div>
    </div>
  </div>


</div>

<script type="text/javascript">

  function setResume()
  {
    $('input[name="resume"]').click();
  }

  $('input[name="resume"]').change(function() {
    $('#resumeUpload').submit();
  })

</script>
@stop
