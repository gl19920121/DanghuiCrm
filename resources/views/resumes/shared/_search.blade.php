<div class="search">
  <div class="row">
    <div class="col">
      <p class="font-size-l">我的人才搜索</p>
      <div class="form-group form-inline">
        <div class="form-group">
          <div class="input-group large">
            <input type="text" name="all" value="{{ isset($parms['all']) ? $parms['all'] : '' }}" class="form-control append" placeholder="简历全文搜索，请输入姓名，公司名，职位等关键词搜索，空格分开" autocomplete="off">
            <div class="input-group-append" data-toggle="modal">
              <button class="btn btn-danger">搜索</button>
            </div>
          </div>
        </div>
        <a id="btnDetail" class="a-gray ml-4" href="javascript:void(0);" onclick="detailToggle($(this))">展开高级搜索</a>
      </div>
    </div>
  </div>

  <div id="searchDetail" class="search-detail bg-gray">
    <div class="row row-cols-2 no-gutters bg-gray">
      <div class="col">
        <div class="form-group form-inline">
          <label for="location">目前城市：</label>
          <div data-toggle="distpicker">
            <select class="form-control small" name="location[province]" data-province="{{ isset($parms['location']['province']) ? $parms['location']['province'] : '省' }}"></select>
            <select class="form-control small" name="location[city]"  data-city="{{ isset($parms['location']['city']) ? $parms['location']['city'] : '市' }}"></select>
            <select class="form-control small" name="location[district]"  data-district="{{ isset($parms['location']['district']) ? $parms['location']['district'] : '区' }}"></select>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="form-group form-inline">
          <label for="exp_location">期望城市：</label>
          <div data-toggle="distpicker">
            <select class="form-control small" name="exp_location[province]" data-province="{{ isset($parms['exp_location']['province']) ? $parms['exp_location']['province'] : '省' }}"></select>
            <select class="form-control small" name="exp_location[city]"  data-city="{{ isset($parms['exp_location']['city']) ? $parms['exp_location']['city'] : '市' }}"></select>
            <select class="form-control small" name="exp_location[district]"  data-district="{{ isset($parms['exp_location']['district']) ? $parms['exp_location']['district'] : '区' }}"></select>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="form-group form-inline">
            <label for="experience">工作经验：</label>
            <select name="experience" class="form-control">
              <option value="">不限</option>
              @foreach (trans('db.experience') as $key => $experience)
                <option value="{{ $key }}"
                @if (isset($parms['experience']) && $key === $parms['experience'])
                  selected
                @endif>
                  {{ $experience }}
                </option>
              @endforeach
            </select>
        </div>
      </div>
      <div class="col">
        <div class="form-group form-inline">
            <label for="education">教育经历：</label>
            <select name="education" class="form-control">
              <option value="">不限</option>
              @foreach (trans('db.education') as $key => $education)
                <option value="{{ $key }}"
                @if (isset($parms['education']) && $key === $parms['education'])
                  selected
                @endif>
                  {{ $education }}
                </option>
              @endforeach
            </select>
        </div>
      </div>
      <div class="col">
        <div class="form-group form-inline">
          <label for="cur_industry">当前行业：</label>
          <div class="input-group" data-toggle="industrypicker">
            <input type="hidden" name="cur_industry[st]" value="{{ isset($parms['cur_industry']['st']) ? $parms['cur_industry']['st'] : '' }}">
            <input type="hidden" name="cur_industry[nd]" value="{{ isset($parms['cur_industry']['nd']) ? $parms['cur_industry']['nd'] : '' }}">
            <input type="hidden" name="cur_industry[rd]" value="{{ isset($parms['cur_industry']['rd']) ? $parms['cur_industry']['rd'] : '' }}">
            <input type="hidden" name="cur_industry[th]" value="{{ isset($parms['cur_industry']['th']) ? $parms['cur_industry']['th'] : '' }}">
            <input type="text" class="form-control middle-append append" value="{{ isset($parms['cur_industry']['th']) ? $parms['cur_industry']['th'] : '' }}" placeholder="不限" autocomplete="off">
            <div class="input-group-append" data-toggle="modal" data-target="#industryModal">
              <span class="input-group-text" id="basic-addon2">
                <svg class="bi bi-calendar" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1zm1-3a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2z"/>
                  <path fill-rule="evenodd" d="M3.5 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5zm9 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5z"/>
                </svg>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="form-group form-inline">
          <label for="cur_position">当前职位：</label>
          <div class="input-group" data-toggle="jobtypepicker">
            <input type="hidden" name="cur_position[st]" value="{{ isset($parms['cur_position']['st']) ? $parms['cur_position']['st'] : '' }}">
            <input type="hidden" name="cur_position[nd]" value="{{ isset($parms['cur_position']['nd']) ? $parms['cur_position']['nd'] : '' }}">
            <input type="hidden" name="cur_position[rd]" value="{{ isset($parms['cur_position']['rd']) ? $parms['cur_position']['rd'] : '' }}">
            <input type="text" class="form-control append" value="{{ isset($parms['cur_position']['rd']) ? $parms['cur_position']['rd'] : '' }}" id="jobType" placeholder="不限" autocomplete="off">
            <div class="input-group-append" data-toggle="modal" data-target="#jobtypeModal">
              <span class="input-group-text" id="basic-addon2">
                <svg class="bi bi-calendar" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1zm1-3a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2z"/>
                  <path fill-rule="evenodd" d="M3.5 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5zm9 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5z"/>
                </svg>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="form-group form-inline">
          <label for="age">年龄范围：</label>
          <div class="input-group">
              <input type="text" name="age_min" class="form-control small" value="{{ isset($parms['age_min']) ? $parms['age_min'] : '' }}" placeholder="岁" autocomplete="off" data-type="int">
          </div>
          <label class="ml-1 mr-1">-</label>
          <div class="input-group">
              <input type="text" name="age_max" class="form-control small" value="{{ isset($parms['age_max']) ? $parms['age_max'] : '' }}" placeholder="不限" autocomplete="off" data-type="int">
          </div>
          <button class="btn btn-secondary ml-3">确定</button>
        </div>
      </div>
      <div class="col">
        <div class="form-group form-inline">
          <label for="jobhunter_status">求职状态：</label>
          <select name="jobhunter_status" class="form-control normal">
            <option value="">不限</option>
            @foreach (trans('db.resume.jobhunter_status') as $key => $jobhunterStatus)
              <option value="{{ $key }}"
              @if (isset($parms['jobhunter_status']) && (int)$key === (int)$parms['jobhunter_status'])
                selected
              @endif>
                {{ $jobhunterStatus }}
              </option>
            @endforeach
          </select>
          <label class="ml-3" for="sex">性别：</label>
          <select name="sex" value="{{ isset($parms['sex']) ? $parms['sex'] : '' }}" class="form-control small">
            <option value="">不限</option>
            <option @if(isset($parms['sex']) && $parms['sex'] === '男') selected @endif>男</option>
            <option @if(isset($parms['sex']) && $parms['sex'] === '女') selected @endif>女</option>
          </select>
        </div>
      </div>
      <div class="col">
        <div class="form-group form-inline">
          <label for="cur_salary">目前年薪：</label>
          <div class="input-group">
              <input type="text" name="cur_year_salary_min" class="form-control small" value="{{ isset($parms['cur_year_salary_min']) ? $parms['cur_year_salary_min'] : '' }}" placeholder="万" autocomplete="off" data-type="int">
          </div>
          <label class="ml-1 mr-1">-</label>
          <div class="input-group">
              <input type="text" name="cur_year_salary_max" class="form-control small" value="{{ isset($parms['cur_year_salary_max']) ? $parms['cur_year_salary_max'] : '' }}" placeholder="不限" autocomplete="off" data-type="int">
          </div>
          <button class="btn btn-secondary ml-3">确定</button>
        </div>
      </div>
      <div class="col">
        <div class="form-group form-inline">
          <label for="exp_salary">期望年薪：</label>
          <div class="input-group">
              <input type="text" name="exp_year_salary_min" class="form-control small" value="{{ isset($parms['exp_year_salary_min']) ? $parms['exp_year_salary_min'] : '' }}" placeholder="万" autocomplete="off" data-type="int">
          </div>
          <label class="ml-1 mr-1">-</label>
          <div class="input-group">
              <input type="text" name="exp_year_salary_max" class="form-control small" value="{{ isset($parms['exp_year_salary_max']) ? $parms['exp_year_salary_max'] : '' }}" placeholder="不限" autocomplete="off" data-type="int">
          </div>
          <button class="btn btn-secondary ml-3">确定</button>
        </div>
      </div>
      <div class="col">
        <div class="form-group form-inline">
          <label for="exp_industry">期望行业：</label>
          <div class="input-group" data-toggle="industrypicker">
            <input type="hidden" name="exp_industry[st]" value="{{ isset($parms['exp_industry']['st']) ? $parms['exp_industry']['st'] : '' }}">
            <input type="hidden" name="exp_industry[nd]" value="{{ isset($parms['exp_industry']['nd']) ? $parms['exp_industry']['nd'] : '' }}">
            <input type="hidden" name="exp_industry[rd]" value="{{ isset($parms['exp_industry']['rd']) ? $parms['exp_industry']['rd'] : '' }}">
            <input type="hidden" name="exp_industry[th]" value="{{ isset($parms['exp_industry']['th']) ? $parms['exp_industry']['th'] : '' }}">
            <input type="text" class="form-control middle-append append" value="{{ isset($parms['exp_industry']['th']) ? $parms['exp_industry']['th'] : '' }}" placeholder="不限" autocomplete="off">
            <div class="input-group-append" data-toggle="modal" data-target="#industryModal">
              <span class="input-group-text" id="basic-addon2">
                <svg class="bi bi-calendar" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1zm1-3a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2z"/>
                  <path fill-rule="evenodd" d="M3.5 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5zm9 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5z"/>
                </svg>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="form-group form-inline">
          <label for="exp_position">期望职位：</label>
          <div class="input-group" data-toggle="jobtypepicker">
            <input type="hidden" name="exp_position[st]" value="{{ isset($parms['exp_position']['st']) ? $parms['exp_position']['st'] : '' }}">
            <input type="hidden" name="exp_position[nd]" value="{{ isset($parms['exp_position']['nd']) ? $parms['exp_position']['nd'] : '' }}">
            <input type="hidden" name="exp_position[rd]" value="{{ isset($parms['exp_position']['rd']) ? $parms['exp_position']['rd'] : '' }}">
            <input type="text" class="form-control append" value="{{ isset($parms['exp_position']['rd']) ? $parms['exp_position']['rd'] : '' }}" id="jobType" placeholder="不限" autocomplete="off">
            <div class="input-group-append" data-toggle="modal" data-target="#jobtypeModal">
              <span class="input-group-text" id="basic-addon2">
                <svg class="bi bi-calendar" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1zm1-3a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2z"/>
                  <path fill-rule="evenodd" d="M3.5 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5zm9 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5z"/>
                </svg>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

  function submitForm()
  {
    $('#searchForm').submit();
  }

  function detailToggle(e)
  {
    if ($('#searchDetail').is(":hidden")) {
      $('input[name="show_detail"]').val('1');
      $('#searchDetail').show('fast');
      e.text('收起');
    } else {
      $('input[name="show_detail"]').val('0');
      $('#searchDetail').hide();
      e.text('展开高级搜索');
    }
  }

  function init()
  {
    @if ($showDetail === 0)
      $('#searchDetail').hide();
      $('#btnDetail').text('展开高级搜索');
    @else
      $('#searchDetail').show();
      $('#btnDetail').text('收起');
    @endif
  }

  $('button').click(function() {
    //if ($(this).attr('id') != 'btnGroupDrop1' && $(this).attr('id') != 'addToMyJob') {
      submitForm();
    //}
  })

  $('select').change(function() {
    submitForm();
  })

  $('#jobtypeModal').on('hide.bs.modal', function (e) {
    submitForm();
  })

  $('#industryModal').on('hide.bs.modal', function (e) {
    submitForm();
  })

  init();

</script>
