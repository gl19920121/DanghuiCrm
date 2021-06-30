<div id="resumeList" class="resume-list bg-white">
  <div class="resume-list-header">
    <div class="row justify-content-between">
      <div class="col col-auto">
        <div hidden class="custom-control custom-checkbox custom-control-inline ml-3">
          <input type="checkbox" id="chooseAll" class="custom-control-input" onclick="chooseAll($(this))">
          <label class="custom-control-label" for="chooseAll">全选</label>
        </div>
        <button hidden class="btn btn-light">批量查看</button>
        <div class="custom-control custom-checkbox custom-control-inline ml-3">
          <input type="checkbox" id="hideSeen" name="hide_seen" @if($hideSeen) checked @endif class="custom-control-input">
          <label class="custom-control-label" for="hideSeen">隐藏已查看</label>
        </div>
        <div class="custom-control custom-checkbox custom-control-inline ml-3">
          <input type="checkbox" id="hideGet" name="hide_get" @if($hideGet) checked @endif class="custom-control-input">
          <label class="custom-control-label" for="hideGet">隐藏已获取</label>
        </div>
      </div>
      <div class="col col-auto">
        <span class="color-silvery-gray mr-3">共<span class="color-red ml-1 mr-1">{{ count($resumes) > 0 ? $resumes->total() : 0 }}</span>位人选</span>
        @if ($tab === 'detail')
          <a href="#resumeList" onclick="changeTab('general')"><img class="mr-3" src="{{ URL::asset('images/icon_general.png') }}"></a>
          <a href="#resumeList" onclick="changeTab('detail')"><img src="{{ URL::asset('images/icon_detail_checked.png') }}"></a>
        @elseif ($tab === 'general')
          <a href="#resumeList" onclick="changeTab('general')"><img class="mr-3" src="{{ URL::asset('images/icon_general_checked.png') }}"></a>
          <a href="#resumeList" onclick="changeTab('detail')"><img src="{{ URL::asset('images/icon_detail.png') }}"></a>
        @else
          <a href="#resumeList" onclick="changeTab('general')"><img class="mr-3" src="{{ URL::asset('images/icon_general.png') }}"></a>
          <a href="#resumeList" onclick="changeTab('detail')"><img src="{{ URL::asset('images/icon_detail.png') }}"></a>
        @endif
      </div>
    </div>
  </div>
  <div class="resume-list-body">
    @if ($tab === 'detail')
      @include('resumes.shared._list_detail')
    @else
      @include('resumes.shared._list_general')
    @endif
  </div>
</div>

<script type="text/javascript">

  function searchByCurJob(jobId)
  {
    $('input[name="job_id"]').val(jobId);
    $('#searchByCurJob').submit();
  }

  function changeTab(tab)
  {
    $('input[name="tab"]').val(tab);
    submitResumeSearchForm();
  }

  function hideGet(e)
  {
    if (e.is(':checked')) {
      $('input[name="hide_get"]').val(1);
    } else {
      $('input[name="hide_get"]').val(0);
    }
  }

  $('button').click(function() {
    if ($(this).attr('id') != 'btnGroupDrop1' && $(this).attr('id') != 'addToMyJob' && $(this).hasClass('dropdown-item') != true) {
      submitResumeSearchForm();
    }
  })

  $('select').change(function() {
    if (isSubmit) {
      submitResumeSearchForm();
    }
  })

  $('input[type="checkbox"]').change(function() {
    submitResumeSearchForm();
  })

  $('#jobtypeModal').on('hide.bs.modal', function (e) {
    submitResumeSearchForm();
  })

  $('#industryModal').on('hide.bs.modal', function (e) {
    submitResumeSearchForm();
  })

</script>
