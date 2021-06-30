@extends('layouts.default')
@section('title', '简历预览')
@section('content')
<div class="resume-show">
  <div class="row">
    <div class="col col-10">
      <div id="capture" class="resume-show-body">

        <div class="body-title" data-html2canvas-ignore="true">
          <div class="row justify-content-between">
            <div class="col col-auto align-self-end ml-4">
              <div class="trapezoid text-center">
                <b class="font-size-m">中文简历</b>
              </div>
            </div>
            <div class="col col-auto mt-2 mr-4">
              <span class="color-light-gray font-size-s mr-3">简历编号：{{ $resume->no }}</span>
              <span class="color-light-gray font-size-s">更新时间：{{ $resume->updated_at }}</span>
            </div>
          </div>
        </div>

        <div class="body-contant bg-white">
          <div class="row">
            <div class="col col-2">
              <div class="row row-cols-1 text-center">
                <div class="col align-self-start">
                  <img class="resume-avatar rounded-circle" src="{{ $resume->avatar_url }}">
                </div>
                <div class="col align-self-end" data-html2canvas-ignore="true">
                  <button class="btn btn-danger">推荐职位</button>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="row align-items-center">
                <div class="col col-auto">
                  <span class="font-size-xl">{{ $resume->name }}</span>
                </div>
                <div class="col col-auto">
                  <span class="tag tag-light p-2">{{ $resume->jobhunter_status_show }}</span>
                </div>
              </div>
              <div class="row">
                <div class="col col-auto">
                  <span>{{ $resume->sex }}</span>
                </div>
                <div class="col col-auto">
                  <p>{{ $resume->location_show }}</p>
                </div>
                <div class="col col-auto">
                  {{ $resume->education_show }}
                </div>
                <div class="col col-auto">
                  {{ $resume->work_years_show_long }}
                </div>
              </div>
              <div class="row">
                <div class="col col-auto">
                  {{ $resume->cur_position_show }}
                </div>
                <div class="col col-auto">
                  {{ $resume->cur_company_show }}
                </div>
              </div>
              <div class="row">
                <div class="col col-auto align-self-center">
                  <img style="margin-bottom: 3px;" class="img-responsive center-block" src="{{ URL::asset('images/icon_phone.png') }}">
                  {{ $resume->phone_num }}
                </div>
                <div class="col col-auto">
                  <img style="margin-bottom: 3px;"  class="img-responsive center-block" src="{{ URL::asset('images/icon_email.png') }}">
                  {{ $resume->email }}
                </div>
                <div class="col col-auto">
                  <img style="margin-bottom: 3px;"  class="img-responsive center-block" src="{{ URL::asset('images/icon_wechat.png') }}">
                  {{ $resume->wechat_show }}
                </div>
                <div class="col col-auto">
                  <img style="margin-bottom: 5px;"  class="img-responsive center-block" src="{{ URL::asset('images/icon_qq.png') }}">
                  {{ $resume->qq_show }}
                </div>
              </div>

              <div class="row" data-html2canvas-ignore="true">
                <div class="col col-12 align-self-end">
                  <div class="row">
                    <div class="col col-auto">
                      <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle btn-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          加入我的职位
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                          @foreach ($jobs as $job)
                            @if ($resume->job_id !== $job->id)
                              <form method="POST" action="{{ route('resumes.update', [$resume, 'job_id' => $job->id, 'status' => 1]) }}">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                                <button class="dropdown-item" type="submit" data-toggle="modal" data-target="#confirmModal">{{ $job->name }}</button>
                              </form>
                            @endif
                          @endforeach
                        </div>
                      </div>
                    </div>
                    <div class="col col-auto">
                      <div class="btn-group" role="group">
                        <button style="border-radius: 5px;" id="btnGroupDrop1" type="button" class="btn btn-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          ...
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                          <a href="{{ route('resumes.show', $resume) }}" class="dropdown-item">刷新</a>
                          <a href="{{ route('resumes.edit', $resume) }}" class="dropdown-item">编辑</a>
                          <a href="{{ route('resumes.destroy', $resume) }}" class="dropdown-item">删除</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col col-auto align-self-end" data-html2canvas-ignore="true">
              <div class="row">
                <div class="col col-auto">
                  <form id="collect_form" method="POST" action="{{ route('resumes.operation', [$resume, 'type' => 'collect']) }}">
                    {{ csrf_field() }}
                    <a href="javascript:document:collect_form.submit();" class="color-n mr-3">
                      @if ($resume->usersCollect()->count() > 0)
                        <img style="margin-bottom: 4px;" src="{{ URL::asset('images/icon_collected.png') }}">
                        <span>取消收藏</span>
                      @else
                        <img style="margin-bottom: 4px;" src="{{ URL::asset('images/icon_collect.png') }}">
                        <span>收藏</span>
                      @endif
                    </a>
                  </form>
                </div>
                <div class="col col-auto">
                  <form id="relayForm" method="POST" action="{{ route('resumes.operation', [$resume, 'type' => 'relay']) }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="uid">
                    <div class="btn-group" role="group">
                      <a id="btnGroupForward" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img style="margin-bottom: 4px;" src="{{ URL::asset('images/icon_forward.png') }}">
                        转发
                      </a>
                      <div class="dropdown-menu" aria-labelledby="btnGroupForward">
                        @foreach ($users as $user)
                          <a href="javascript:void(0)" onclick="relay('{{ $user->id }}')" class="dropdown-item">{{ $user->name }}</a>
                        @endforeach
                      </div>
                    </div>
                  </form>
                  <form hidden method="POST" action="{{ route('resumes.update', [$resume, 'status' => 2]) }}">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
                    <a href="#" class="color-n mr-3">
                      <img style="margin-bottom: 4px;" src="{{ URL::asset('images/icon_forward.png') }}">
                      <span>转发</span>
                    </a>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <hr class="divider">

          <div class="row row-cols-4">
            <div class="col-12">
              <h5 id="jobExp">职业期望</h5>
            </div>
            <div class="col">
              <p class="font-size-m">
                <span class="color-gray">所在行业：</span>
                {{ $resume->cur_industry_show }}
              </p>
            </div>
            <div class="col">
              <p class="font-size-m">
                <span class="color-gray">所任职位：</span>
                {{ $resume->cur_position_show }}
              </p>
            </div>
            <div class="col">
              <p class="font-size-m">
                <span class="color-gray">所在公司：</span>
                {{ $resume->cur_company_show }}
              </p>
            </div>
            <div class="col">
              <p class="font-size-m">
                <span class="color-gray">目前薪资：</span>
                {{ $resume->cur_salary_show_short }}
              </p>
            </div>
            <div class="col">
              <p class="font-size-m">
                <span class="color-gray">期望行业：</span>
                {{ $resume->exp_industry_show }}
              </p>
            </div>
            <div class="col">
              <p class="font-size-m">
                <span class="color-gray">期望职位：</span>
                {{ $resume->exp_position_show }}
              </p>
            </div>
            <div class="col">
              <p class="font-size-m">
                <span class="color-gray">期望城市：</span>
                {{ $resume->exp_location_show }}
              </p>
            </div>
            <div class="col">
              <p class="font-size-m">
                <span class="color-gray">期望薪资：</span>
                {{ $resume->exp_salary_show }}
              </p>
            </div>
            <div class="col">
              <p class="font-size-m">
                <span class="color-gray">工作性质：</span>
                {{ $resume->exp_work_nature_show }}
              </p>
            </div>
            <div class="col">
              <p class="font-size-m">
                <span class="color-gray">勿推企业：</span>
                {{ $resume->blacklist_show }}
              </p>
            </div>
          </div>

          <hr class="divider">

          @if ($resume->resumeWorks->count() > 0)
            <div class="row row-cols-2">
              <div class="col-12">
                <h5 id="resumeWork">工作经历</h5>
              </div>
              @foreach ($resume->resumeWorks as $index => $work)
                <div class="col-12">
                  <p class="bg-gray p-2">
                    <span>{{ $work->company_name }}</span>
                    <span class="color-gray font-size-s">（工作时间：{{ $work->duration }}，{{ $work->long }}）</span>
                  </p>
                </div>
                <div class="col col-auto">
                  <button class="btn btn-light">{{ $work->company_industry_show }}</button>
                </div>
                <div class="col col-auto">
                  <button class="btn btn-light">{{ $work->company_scale_show }}</button>
                </div>
                <div class="col col-auto">
                  <button class="btn btn-light">{{ $work->company_investment_show }}</button>
                </div>
                <div class="col col-12 mt-3 mb-3">
                  {{ $work->job_type_show }}
                </div>
                <div class="col">
                  <p class="font-size-m">
                    <span class="color-gray">下属人数：</span>
                    {{ $work->subordinates }}
                  </p>
                </div>
                <div class="col">
                  <p class="font-size-m">
                    <span class="color-gray">职位类别：</span>
                    {{ $work->job_type_show }}
                  </p>
                </div>
                <div class="col-12">
                  <p class="font-size-m">
                    <span class="color-gray">薪资：</span>
                    {{ $work->salary_show }}
                  </p>
                </div>
                <div class="col">
                  <p class="font-size-m">
                    <span class="color-gray">工作描述：</span>
                    {{ $work->work_desc }}
                  </p>
                </div>
              @endforeach
            </div>
          @endif

          @if ($resume->resumePrjs->count() > 0)
            <hr class="divider">
            <div class="row row-cols-1">
              <div class="col-12">
                <h5 id="resumeProject">项目经历</h5>
              </div>
              @foreach ($resume->resumePrjs as $index => $project)
                <div class="col-12">
                  <p class="bg-gray p-2">
                    <span>{{ $project->name_show }}</span>
                    <span class="color-gray font-size-s">（项目时间：{{ $project->duration }}，{{ $project->long }}）</span>
                  </p>
                </div>
                <div class="col-12">
                  <p class="font-size-m">
                    <span class="color-gray">担任角色：</span>
                    {{ $project->role_show }}
                  </p>
                </div>
                <div class="col-12">
                  <p class="font-size-m">
                    <span class="color-gray">项目内容：</span>
                    {{ $project->body_show }}
                  </p>
                </div>
              @endforeach
            </div>
          @endif

          @if ($resume->resumeEdus->count() > 0)
            <hr class="divider">
            <div class="row row-cols-1">
              <div class="col-12">
                <h5 id="resumeEduction">教育经历</h5>
              </div>
              @foreach ($resume->resumeEdus as $index => $eduction)
                <div class="col">
                  <p class="font-size-m">
                    <span class="color-gray">毕业院校：</span>
                    {{ $eduction->school_name }}（{{ $eduction->duration }}）
                  </p>
                </div>
                <div class="col-12">
                  <p class="font-size-m">
                    <span class="color-gray">学历：</span>
                    {{ $eduction->school_level_show }}
                  </p>
                </div>
                <div class="col-12">
                  <p class="font-size-m">
                    <span class="color-gray">所学专业：</span>
                    {{ $eduction->major_show }}
                  </p>
                </div>
              @endforeach
            </div>
          @endif

          <hr class="divider">

          <div class="row row-cols-1">
            <div class="col-12">
              <h5 id="appendInfo">附加信息</h5>
            </div>
            <div class="col">
              <p class="font-size-m">
                <span class="color-gray">社交主页：</span>
                {{ $resume->social_home_show }}
              </p>
            </div>
            <div class="col-12">
              <p class="font-size-m">
                <span class="color-gray">个人优势：</span>
                {{ $resume->personal_advantage_show }}
              </p>
            </div>
          </div>

          <div class="row" data-html2canvas-ignore="true">
            <div class="col text-center">
              <div id="resumeExport" class="btn-group" role="group">
                <button id="btnGroupDrop1" type="button" class="btn dropdown-toggle btn-dropdown btn-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  导出简历
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                  <a href="{{ route('word.export.resume', $resume) }}" class="dropdown-item">Word</a>
                  <!-- <a href="{{ route('pdf.export.resume', $resume) }}" class="dropdown-item">PDF</a> -->
                  <a href="javascript:void(0)" class="dropdown-item" onclick="resumeScreenshot('capture', 'canvasContainer', 'jpg', '{{ $resume->name }}')">JPG</a>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col text-center">
              <p class="font-size-s">声明：该人选信息仅供公司内部使用，严禁以招聘以外的任何目的使用人选信息或利用猎聘平台及人选信息从事任何违法违规活动</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col" data-html2canvas-ignore="true">
      <div class="nav-remarks">
        <div class="nav-remarks-title">
          <div class="row align-items-center">
            <div class="col col-auto">
              <span>简历备注</span>
            </div>
          </div>
        </div>

        <div class="nav-remarks-contant bg-white">
          <p>{{ $resume->remark_show }}</p>
        </div>
      </div>

      <nav id="resumeShowNavRight" class="nav-ap bg-white">
        <ul>
          <li>简历信息</a></li>
          <li>
            <a href="#jobExp">职业期望</a>
          </li>
          <li>
            <a href="#resumeWork">工作经历</a>
          </li>
          <li>
            <a href="#resumeProject">项目经历</a>
          </li>
          <li>
            <a href="#resumeEduction">教育经历</a>
          </li>
          <li>
            <a href="#appendInfo">附加信息</a>
          </li>
          <li>
            <a href="#resumeExport">导出简历</a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</div>

<div hidden id="canvasContainer"></div>

<script type="text/javascript">

  function resumeScreenshot (domId, canvasId, imgType, fileName)
  {
    window.pageYoffset = 0;
    document.documentElement.scrollTop = 0;
    document.body.scrollTop = 0;

    html2canvas(document.getElementById(domId), {
      // scale: 2,
    }).then(canvas => {
      document.querySelector("#" + canvasId).appendChild(canvas);

      setTimeout(() => {
        var type = imgType;
        var oCanvas = document.querySelector("#" + canvasId).getElementsByTagName("canvas")[0];

        var imgWatermark = new Image();
        imgWatermark.src = "{{ URL::asset('images/watermark.png') }}";
        imgWatermark.onload = function () {
          var ctx = oCanvas.getContext('2d');
          ctx.drawImage(imgWatermark, 0, 0, 1067, 2011);
          // ctx.save();

          var imgLogo = new Image();
          imgLogo.src = "{{ URL::asset('images/logo-red.png') }}";
          imgLogo.onload = function () {
            // var ctx = oCanvas.getContext('2d');
            ctx.drawImage(imgLogo, 886, 200, 56, 19);
            ctx.save();

            let imgData = oCanvas.toDataURL(type);//canvas转换为图片
            // 加工image data，替换mime type，方便以后唤起浏览器下载
            imgData = imgData.replace(_fixType(type), 'image/octet-stream');
            fileDownload(imgData, type, fileName);
            $('body').remove('canvas');
          }
        }
      }, 0);
    });
  }

  function relay(uid)
  {
    $('input[name="uid"][type="hidden"]').val(uid);
    $('form#relayForm').submit();
  }

  $(window).scroll(function (event) {
    let winPos = $(window).scrollTop();
    let jobExpPos = $('#jobExp').offset().top;
    let resumeWorkPos = $('#resumeWork').offset().top;
    let resumeProjectPos = $('#resumeProject').offset().top;
    let resumeEductionPos = $('#resumeEduction').offset().top;
    let appendInfoPos = $('#appendInfo').offset().top;
    let resumeExportPos = $('#resumeExport').offset().top;
    let navRight = $('#resumeShowNavRight').find('ul');
    let offset = -100;

    if ((winPos - jobExpPos) >= offset && (winPos - resumeWorkPos) < offset) {
      navRight.find('li').removeClass('active');
      navRight.find('li').eq(1).addClass('active');
    } else if ((winPos - resumeWorkPos) >= offset && (winPos - resumeProjectPos) < offset) {
      navRight.find('li').removeClass('active');
      navRight.find('li').eq(2).addClass('active');
    } else if ((winPos - resumeProjectPos) >= offset && (winPos - resumeEductionPos) < offset) {
      navRight.find('li').removeClass('active');
      navRight.find('li').eq(3).addClass('active');
    } else if ((winPos - resumeEductionPos) >= offset && (winPos - appendInfoPos) < offset) {
      navRight.find('li').removeClass('active');
      navRight.find('li').eq(4).addClass('active');
    } else if ((winPos - appendInfoPos) >= offset && (winPos - resumeExportPos) < offset) {
      navRight.find('li').removeClass('active');
      navRight.find('li').eq(5).addClass('active');
    } else if ((winPos - resumeExportPos) >= offset) {
      navRight.find('li').removeClass('active');
      navRight.find('li').eq(6).addClass('active');
    } else {
      navRight.find('li').removeClass('active');
    }
  });

</script>
@stop
