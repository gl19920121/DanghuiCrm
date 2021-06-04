<div class="commission">
  <div class="row justify-content-between">
    <div class="col col-auto">
      <p class="color-light-gray font-size-s">ID:{{ $resume->no }}</p>
    </div>
    <div class="col col-auto">
      <p class="color-light-gray font-size-s">投递时间：{{ $resume->updated_at }}</p>
    </div>
  </div>
  <div class="row">
    <div class="col col-auto">
      <img src="{{ URL::asset('images/avatar_default.png') }}">
    </div>
    <div class="col">
      <p class="color-red">
        {{ $resume->name }}<span>|</span>{{ $resume->sex }}<span>|</span>{{ sprintf('%s岁', $resume->age) }}<span>|</span>{{ $resume->location->city }}<span>|</span>{{ $resume->education_show }}<span>|</span>{{ sprintf('工作%s年', $resume->work_years) }}
      </p>
      @foreach ($resume->resumeEdus as $index => $resumeEdu)
        @if ($index === 0)
            <p>
                最高学历：{{ $resumeEdu->duration }}
                <span>{{ $resumeEdu->school_name }}</span>
                <span>{{ $resumeEdu->school_level_show }}</span>
            </p>
        @endif
      @endforeach
      @foreach ($resume->resumeWorks as $index => $resumeWork)
        @if ($index === 0)
            <p>
                近期工作：{{ $resumeWork->duration }}
                <span>{{ $resumeWork->company_name }}</span>
                <span>{{ $resumeWork->job_type_show }}</span>
            </p>
        @endif
      @endforeach
      <p>
        <span>求职者状态：{{ $resume->jobhunter_status_show }}</span>
        <span class="ml-2">来源渠道：{{ $resume->source_show }}</span>
      </p>
      <p>委托职位：<span class="color-red">{{ $resume->job->name }}</span></p>
    </div>
    <div class="col col-auto align-self-end">
      <a href="{{ route('resumes.show', $resume) }}" class="btn btn-danger" target="_blank">查看简历</a>
    </div>
  </div>
</div>
