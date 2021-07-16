@if (count($resumes) > 0)
  <div class="resume-list-general">
    <table class="table resume-table-general">
      <thead>
        <tr>
          <th hidden scope="col"></th>
          <th scope="col">姓名</th>
          <th scope="col">性别/年龄</th>
          <th scope="col">所在地</th>
          <th scope="col">学历</th>
          <th scope="col">工作年限</th>
          <th scope="col">目前公司</th>
          <th scope="col">目前职位</th>
          <th scope="col">目前月薪</th>
          <th scope="col">更新时间</th>
          <th scope="col">操作</th>
        </tr>
      </thead>
      <tbody>
        @foreach($resumes as $resume)
          <tr>
            <td hidden>
              <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" class="custom-control-input">
                <label class="custom-control-label"></label>
              </div>
            </td>
            <td>
              <a href="{{ route('resumes.show', $resume) }}" target="_blank">
                {{ $resume->name }}
              </a>
            </td>
            <td>{{ sprintf('%s/%s岁', $resume->sex, $resume->age) }}</td>
            <td>{{ $resume->location_show }}</td>
            <td>{{ $resume->education_show }}</td>
            <td>{{ $resume->work_years_show }}</td>
            <td>{{ $resume->cur_company_show }}</td>
            <td>{{ $resume->cur_position_show }}</td>
            <td>{{ $resume->cur_salary_show_long }}</td>
            <td>{{ $resume->updated_at }}</td>
            <td>
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
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div class="row justify-content-end">
      <div class="col-auto">
        {{ $resumes->links('vendor.pagination.bootstrap-4') }}
      </div>
    </div>
    @include('shared._confirm')
  </div>
@endif
