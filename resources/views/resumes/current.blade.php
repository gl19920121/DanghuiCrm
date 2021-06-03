@extends('layouts.default')
@section('title', '新上传')
@section('content')
  <form id="resumeSearchForm" method="GET" action="{{ route('resumes.current') }}">
    <input type="hidden" name="tab" value="{{ $tab }}">
    @include('resumes.shared._list_change')
  </form>
@stop

<script type="text/javascript">

  function submitResumeSearchForm()
  {
    $('#resumeSearchForm').submit();
  }

</script>
