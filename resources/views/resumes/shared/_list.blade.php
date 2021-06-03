@if (count($resumes) > 0)
  <div class="resume-shared-list">
    @foreach($resumes as $resume)
      <div class="list-item mb-4">
        <div class="row justify-content-between">
          <div class="col col-auto">
            <p class="color-light-gray font-size-s">ID:{{ $resume->no }}</p>
          </div>
          <div class="col col-auto">
            <p class="color-light-gray font-size-s">
              @switch ($tab)
                @case ('all')
                  更新时间：{{ $resume->created_at }}
                  @break
                @case ('seen')
                  浏览时间：{{ $resume->created_at }}
                  @break
                @case ('apply')
                  应聘时间：{{ $resume->created_at }}
                  @break
                @case ('commission')
                  委托时间：{{ $resume->created_at }}
                  @break
                @case ('collect')
                  收藏时间：{{ $resume->created_at }}
                  @break
                @case ('seenmy')
                  查看时间：{{ $resume->created_at }}
                  @break
                @case ('relay')
                  转发时间：{{ $resume->created_at }}
                  @break

                @default
                  @break
              @endswitch
            </p>
          </div>
        </div>
        <div class="row">
          <div class="col col-auto">
            <img src="{{ URL::asset('images/avatar_default.png') }}">
          </div>
          <div class="col">
            <div class="row apart">
              <div class="col col-auto">
                {{ $resume->name }}
              </div>
              <div class="col col-auto">
                {{ $resume->sex }}
              </div>
              <div class="col col-auto">
                {{ sprintf('%s岁', $resume->age) }}
              </div>
              <div class="col col-auto">
                {{ $resume->location->city }}
              </div>
              <div class="col col-auto">
                {{ $resume->education_show }}
              </div>
              <div class="col col-auto">
                {{ $resume->work_years_show_list }}
              </div>
            </div>
            <div class="row apart mt-3">
              @foreach ($resume->resumeEdus as $index => $resumeEdu)
                @if ($index === 0)
                    <div class="col col-auto">
                      最高学历：{{ $resumeEdu->duration }}
                    </div>
                    <div class="col col-auto">{{ $resumeEdu->school_name }}</div>
                    <div class="col col-auto">{{ $resumeEdu->school_level_show }}</div>
                @endif
              @endforeach
            </div>
            <div class="row apart mt-1">
              @foreach ($resume->resumeWorks as $index => $resumeWork)
                @if ($index === 0)
                  <div class="col col-auto">
                    近期工作：{{ $resumeWork->duration }}
                  </div>
                  <div class="col col-auto">{{ $resumeWork->company_name }}</div>
                  <div class="col col-auto">{{ $resumeWork->job_type_show }}</div>
                @endif
              @endforeach
            </div>
            <div class="row no-gutters mt-1">
              <div class="col col-auto">求职者状态：</div>
              <div class="col col-auto">{{ $resume->jobhunter_status_show }}</div>
              <div class="col col-auto ml-5">来源渠道：</div>
              <div class="col col-auto">{{ $resume->source_show }}</div>
            </div>
            @switch ($tab)
              @case ('apply')
                <p class="mt-1">应聘职位：<span class="color-red">{{ $resume->job->name }}</span></p>
                @break
              @case ('commission')
                <p class="mt-1">委托职位：<span class="color-red">{{ $resume->job->name }}</span></p>
                @break

              @default
                @break
            @endswitch
          </div>
          <div class="col col-auto align-self-end">
            <a href="{{ route('resumes.show', $resume) }}" class="btn btn-danger">查看简历</a>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="row justify-content-end">
    <div class="col-auto">
      {{ $resumes->links('vendor.pagination.bootstrap-4') }}
    </div>
  </div>
@endif
