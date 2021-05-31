@if (count($resumes) > 0)
  <div class="resume-list-general">
    <table class="table resume-table-general">
      <thead>
        <tr>
          <th scope="col"></th>
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
            <td>
              <div class="custom-control custom-checkbox custom-control-inline ml-3">
                <input type="checkbox" class="custom-control-input" onclick="chooseAll($(this))">
                <label class="custom-control-label"></label>
              </div>
            </td>
            <td>{{ $resume->name }}</td>
            <td>{{ sprintf('%s/%s岁', $resume->sex, $resume->age) }}</td>
            <td>{{ $resume->location->city }}</td>
            <td>{{ $resume->education_show }}</td>
            <td>{{ $resume->work_years_show }}</td>
            <td>{{ $resume->cur_company }}</td>
            <td>{{ $resume->cur_position_show }}</td>
            <td>{{ $resume->cur_salary_show_long }}</td>
            <td>{{ $resume->updated_at }}</td>
            <td>
              <div class="btn-group" role="group">
                <button id="btnGroupDrop1" type="button" class="btn dropdown-toggle btn-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  操作
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                  <a href="{{ route('resumes.edit', $resume) }}" class="dropdown-item">修改</a>
                  <a href="{{ route('resumes.show', $resume) }}" class="dropdown-item" target="_blank">预览</a>
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
