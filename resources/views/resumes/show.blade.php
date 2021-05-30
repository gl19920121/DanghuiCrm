@extends('layouts.default')
@section('title', '简历预览')
@section('content')
<div id="capture" class="resume-show">
  <div class="row">
    <div class="col col-10">
      <div class="resume-show-body">

        <div class="body-title">
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
                  <img src="{{ URL::asset('images/resume_default_avatar.png') }}">
                </div>
                <div class="col align-self-end">
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
                  <span class="tag tag-light">{{ $resume->jobhunter_status_show }}</span>
                </div>
              </div>
              <div class="row">
                <div class="col col-auto">
                  <span>{{ $resume->sex }}</span>
                </div>
                <div class="col col-auto">
                  <p>{{ $resume->location->city }}</p>
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
                  {{ $resume->cur_company }}
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
                  {{ $resume->wechat }}
                </div>
                <div class="col col-auto">
                  <img style="margin-bottom: 5px;"  class="img-responsive center-block" src="{{ URL::asset('images/icon_qq.png') }}">
                  {{ $resume->qq }}
                </div>
              </div>

              <div class="row">
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
                              <form method="POST" action="{{ route('resumes.update', [$resume, 'job_id' => $job->id]) }}">
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
            <div class="col col-auto align-self-end">
              <div class="row">
                <div class="col col-auto">
                  <form id="collect_form" method="POST" action="{{ route('resumes.update', [$resume, 'is_collect' => $resume->is_collect === 0 ? 1 : 0]) }}">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
                    <a href="javascript:document:collect_form.submit();" class="color-n mr-3">
                      @if ($resume->is_collect === 1)
                        <img style="margin-bottom: 4px;" src="{{ URL::asset('images/icon_collected.png') }}">
                        <span>取消收藏</span>
                      @else
                        <img style="margin-bottom: 4px;" src="{{ URL::asset('images/icon_collect.png') }}">
                        <span>收藏</span>
                      @endif
                    </a>
                  </form>
                </div>
                <div hidden class="col col-auto">
                  <form method="POST" action="{{ route('resumes.update', [$resume, 'status' => 2]) }}">
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

          <div class="row row-cols-2">
            <div class="col-12">
              <h5 id="jobExp">职业期望</h5>
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
                {{ $resume->exp_location->city }}
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
                <span class="color-gray">目前薪资：</span>
                {{ $resume->cur_salary_show }}
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
                <span class="color-gray">所在行业：</span>
                {{ $resume->cur_industry_show }}
              </p>
            </div>
            <div class="col-12">
              <p class="font-size-m">
                <span class="color-gray">工作性质：</span>
                {{ $resume->exp_work_nature_show }}
              </p>
            </div>
            <div class="col">
              <p class="font-size-m">
                <span class="color-gray">勿推企业：</span>
                {{ $resume->blacklist }}
              </p>
            </div>
          </div>

          <hr class="divider">

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
              {{ $work->job_type->nd }}
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
                {{ $work->job_type->rd }}
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

          <hr class="divider">

          <div class="row row-cols-1">
            <div class="col-12">
              <h5 id="resumeProject">项目经历</h5>
            </div>
            @foreach ($resume->resumePrjs as $index => $project)
            <div class="col-12">
              <p class="bg-gray p-2">
                <span>{{ $project->name }}</span>
                <span class="color-gray font-size-s">（项目时间：{{ $project->duration }}，{{ $project->long }}）</span>
              </p>
            </div>
            <div class="col-12">
              <p class="font-size-m">
                <span class="color-gray">担任角色：</span>
                {{ $project->role }}
              </p>
            </div>
            <div class="col-12">
              <p class="font-size-m">
                <span class="color-gray">项目内容：</span>
                {{ $project->body }}
              </p>
            </div>
            @endforeach
          </div>

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
                {{ $eduction->major }}
              </p>
            </div>
            @endforeach
          </div>

          <hr class="divider">

          <div class="row row-cols-1">
            <div class="col-12">
              <h5 id="appendInfo">附加信息</h5>
            </div>
            <div class="col">
              <p class="font-size-m">
                <span class="color-gray">社交主页：</span>
                {{ $resume->social_home }}
              </p>
            </div>
            <div class="col-12">
              <p class="font-size-m">
                <span class="color-gray">个人优势：</span>
                {{ $resume->personal_advantage }}
              </p>
            </div>
          </div>

          <div class="row">
            <div class="col text-center">
              <div id="resumeExport" class="btn-group" role="group">
                <button id="btnGroupDrop1" type="button" class="btn dropdown-toggle btn-dropdown btn-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  导出简历
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                  <a href="{{ route('word.export.resume', $resume) }}" class="dropdown-item">Word</a>
                  <!-- <a href="{{ route('pdf.export.resume', $resume) }}" class="dropdown-item">PDF</a> -->
                  <a href="#" class="dropdown-item" onclick="takeScreenshot()">JPG</a>
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

    <div class="col">
      <div class="nav-remarks">
        <div class="nav-remarks-title">
          <div class="row align-items-center">
            <div class="col col-auto">
              <span>简历备注</span>
            </div>
          </div>
        </div>

        <div class="nav-remarks-contant bg-white">
          <p>{{ $resume->remark }}</p>
        </div>
      </div>

      <div class="nav-ap bg-white">
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
      </div>
    </div>
  </div>
</div>

<div hidden id="canvasContainer"></div>

<script type="text/javascript">
  function _fixType(type)
  {
    type = type.toLowerCase().replace(/jpg/i, 'jpeg');
    let r = type.match(/png|jpeg|bmp|gif/)[0];
    return 'image/' + r;
  }

  function fileDownload(downloadUrl){
    let aLink = document.createElement('a');
    aLink.style.display = 'none';
    aLink.href = downloadUrl;
    aLink.download = "{{ $job->name }}.png";
    // 触发点击-然后移除
    document.body.appendChild(aLink);
    aLink.click();
    document.body.removeChild(aLink);
  }

  function takeScreenshot()
  {
    window.pageYoffset = 0;
    document.documentElement.scrollTop = 0;
    document.body.scrollTop = 0;

    html2canvas(document.querySelector("#capture")).then(canvas => {
      document.querySelector("#canvasContainer").appendChild(canvas);
      //延迟执行确保万无一失，玄学
      setTimeout(() => {
        var type = 'png';
        var oCanvas = document.querySelector("#canvasContainer").getElementsByTagName("canvas")[0];
        var imgData = oCanvas.toDataURL(type);//canvas转换为图片
        // 加工image data，替换mime type，方便以后唤起浏览器下载
        imgData = imgData.replace(_fixType(type), 'image/octet-stream');
        fileDownload(imgData);
        $('body').remove('canvas');
      }, 0);
    });
  }
</script>
@stop
