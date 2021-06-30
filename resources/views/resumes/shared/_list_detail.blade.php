@if (count($resumes) > 0)
  <div class="resume-list-detail">
    @foreach ($resumes as $resume)
      <div class="resume-list-detail-item">
        <div class="row">
          <div class="col col-2 text-center">
            <img class="resume-avatar rounded-circle" src="{{ $resume->avatar_url }}">
          </div>
          <div class="col">
            <div class="row color-dark apart">
              <div class="col col-auto">
                {{ $resume->name }}
              </div>
              <div class="col col-auto">
                {{ $resume->sex }}
              </div>
              <div class="col col-auto">
                {{ $resume->age }}
              </div>
              <div class="col col-auto">
                {{ $resume->location_show }}
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
            <div class="row mt-3">
              <div class="col">
                目前月薪：{{ $resume->cur_salary_show_long }}
              </div>
              <div class="col">
                来源渠道：{{ $resume->source_show }}
              </div>
            </div>
          </div>
          <div class="col text-truncate">
            @foreach ($resume->resumeWorks as $index => $work)
              <p class="text-truncate" title="{{ sprintf('%s %s %s（%s） 月薪：%s', $work->company_name, $work->job_type_show, $work->duration, $work->long, $work->salary_show) }}">
                <span>{{ $work->company_name }}</span>
                <span>{{ $work->job_type_show }}</span>
                <span>{{ $work->duration }}</span>
                <span class="color-silvery-gray">（{{ $work->long }}）</span>
                <span>月薪：{{ $work->salary_show }}</span>
              </p>
            @endforeach
          </div>
        </div>
        <div class="row">
          <div class="col col-2 text-center">
            <p class="color-light-gray">{{ $resume->updated_at }}</p>
          </div>
          <div class="col">
            <a href="javasrcipt:void(0)" class="btn btn-light">期望城市：{{ $resume->exp_location_show }}</a>
            <a href="javasrcipt:void(0)" class="btn btn-light">期望职位：{{ $resume->exp_position_show }}</a>
            <a href="javasrcipt:void(0)" class="btn btn-light">求职者状态：{{ $resume->jobhunter_status_show }}</a>
          </div>
          <div class="col col-auto">
            <a class="btn btn-danger mr-2" href="{{ route('resumes.show', $resume) }}">查看简历</a>
            <div class="btn-group" role="group">
              <button id="addToMyJob" type="button" class="btn dropdown-toggle btn-dropdown btn-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                加入我的职位
              </button>
              <div class="dropdown-menu" aria-labelledby="addToMyJob">
                <form id="formToJob" method="POST">
                  {{ csrf_field() }}
                  @foreach ($jobs as $job)
                    @if ($resume->job_id !== $job->id)
                      <button type="submit" form="formToJob" formaction="{{ route('resumes.add.job', [$resume, 'job_id' => $job->id, 'status' => 1]) }}" class="dropdown-item">{{ $job->name }}</button>
                    @endif
                  @endforeach
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endforeach
    <div class="row justify-content-end">
      <div class="col-auto">
        {{ $resumes->links('vendor.pagination.bootstrap-4') }}
      </div>
    </div>
    @include('shared._confirm')
  </div>
@endif
