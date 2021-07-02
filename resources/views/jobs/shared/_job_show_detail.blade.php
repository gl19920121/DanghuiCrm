<div class="job-detail">
    <div class="row row-cols-5">
        <div class="col-12">
            <h5>企业基本信息</h5>
        </div>
        <div class="col">
            <p class="font-size-m"><span class="color-gray">公司名称：</span>{{ $job->company->name }}</p>
        </div>
        <div class="col">
            <p class="font-size-m"><span class="color-gray">所在地：</span>{{ $job->company->locationShow }}</p>
        </div>
        <div class="col">
            <p class="font-size-m"><span class="color-gray">所属行业：</span>{{ $job->company->industryShow }}</p>
        </div>
        <div class="col">
            <p class="font-size-m"><span class="color-gray">企业性质：</span>{{ $job->company->natureShow }}</p>
        </div>
        <div class="col">
            <p class="font-size-m"><span class="color-gray">企业规模：</span>{{ $job->company->scaleShow }}</p>
        </div>
        <div class="col">
            <p class="font-size-m"><span class="color-gray">融资阶段：</span>{{ $job->company->investmentShow }}</p>
        </div>
        <div class="col">
            <p class="font-size-m"><span class="color-gray">招聘人数：</span>{{ $job->quota }}</p>
        </div>
    </div>
    <hr class="divider">
    <div class="row row-cols-4">
        <div class="col-12">
            <h5>职位基本信息</h5>
        </div>
        <div class="col">
            <p class="font-size-m"><span class="color-gray">职位名称：</span>{{ $job->name }}</p>
        </div>
        <div class="col">
            <p class="font-size-m"><span class="color-gray">职位类别：</span>{{ $job->type->rd }}</p>
        </div>
        <div class="col">
            <p class="font-size-m"><span class="color-gray">工作性质：</span>{{ $job->natureShow }}</p>
        </div>
        <div class="col">
            <p class="font-size-m"><span class="color-gray">工作城市：</span>{{ $job->location->city }}</p>
        </div>
        <div class="col">
            <p class="font-size-m"><span class="color-gray">税前月薪：</span>{{ sprintf('%dK-%dK', $job->salary_min, $job->salary_max) }}</p>
        </div>
        <div class="col col-9">
            <p class="font-size-m"><span class="color-gray">福利待遇：</span>{{ $job->welfareShow }}</p>
        </div>
        <div class="col">
            <p class="font-size-m"><span class="color-gray">职位亮点：</span>{{ $job->sparkle }}</p>
        </div>
    </div>
    <hr class="divider">
    <div class="row row-cols-3">
        <div class="col-12">
            <h5>职位要求</h5>
        </div>
        <div class="col">
            <p class="font-size-m"><span class="color-gray">年龄范围：</span>{{ sprintf('%d岁-%d岁', $job->age_min, $job->age_max) }}</p>
        </div>
        <div class="col">
            <p class="font-size-m"><span class="color-gray">学历要求：</span>{{ sprintf('%s以上', $job->educationShow) }}</p>
        </div>
        <div class="col">
            <p class="font-size-m">
              <span class="color-gray">经验要求：</span>
              @if (in_array($job->experience, ['primary', 'middle', 'high']))
                {{ sprintf('%s年工作经验', $job->experienceShow) }}
              @elseif ($job->experience === 'expert')
                {{ sprintf('%s工作经验', $job->experienceShow) }}
              @else
                {{ $job->experienceShow }}
              @endif
            </p>
        </div>
        <div class="col-12">
          <p class="font-size-m color-gray">工作职责</p>
          <p class="font-size-m">{{ $job->duty }}</p>
        </div>
        <div class="col-12">
          <p class="font-size-m color-gray">任职要求</p>
          <p class="font-size-m">{{ $job->requirement }}</p>
        </div>
    </div>
    <hr class="divider">
    <div class="row row-cols-2">
        <div class="col-12">
            <h5>职位备注</h5>
        </div>
        <div class="col">
            <p class="font-size-m"><span class="color-gray">紧急程度：</span>{{ $job->urgencyLevelShow }}</p>
        </div>
        <div class="col">
            <p class="font-size-m"><span class="color-gray">发布渠道：</span>{{ $job->channelShow }}</p>
        </div>
        <div class="col">
            <p class="font-size-m"><span class="color-gray">截止日期：</span>{{ $job->deadline }}</p>
        </div>
    </div>
</div>

<div class="row justify-content-center" data-html2canvas-ignore="true">
  <div class="col col-auto">
    <a href="{{ route('jobs.edit', $job) }}" class="btn btn-light">编辑本职位信息</a>
    <!-- <button class="btn btn-light">导出职位</button> -->
    <div class="btn-group" role="group">
      <button id="btnGroupDrop1" type="button" class="btn dropdown-toggle btn-dropdown btn-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        导出职位
      </button>
      <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
        <a href="{{ route('word.export.job', $job) }}" class="dropdown-item">Word</a>
        <a href="{{ route('pdf.export.job', $job) }}" class="dropdown-item">PDF</a>
        <a href="{{ route('excel.export.job', $job) }}" class="dropdown-item">Excel</a>
        <a href="javascript:void(0)" class="dropdown-item" onclick="jobScreenshot('edit', 'canvasContainer', 'jpg', '{{ $job->name }}')">JPG</a>
      </div>
    </div>
  </div>
</div>

<div hidden id="canvasContainer"></div>

<script type="text/javascript">
  function jobScreenshot (domId, canvasId, imgType, fileName)
  {
    window.pageYoffset = 0;
    document.documentElement.scrollTop = 0;
    document.body.scrollTop = 0;

    html2canvas(document.getElementById(domId), {
      // backgroundColor: "#fff",
      // dpi: window.devicePixelRatio * 2,
      // scale: 3,
      // allowTaint: true,
      // useCORS: true,
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
          ctx.save();

          let imgData = oCanvas.toDataURL(type);//canvas转换为图片
          // 加工image data，替换mime type，方便以后唤起浏览器下载
          imgData = imgData.replace(_fixType(type), 'image/octet-stream');
          fileDownload(imgData, type, fileName);
          $('body').remove('canvas');
        }
      }, 0);
    });
  }
</script>
