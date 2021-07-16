<table class="table table-striped default-table">
  <thead>
    <tr>
      <th scope="col">姓名</th>
      @if ($tab === 'untreated')
        <th scope="col">运作状态</th>
      @endif
      <th scope="col">性别</th>
      <th scope="col">年龄</th>
      <th scope="col">工作年限</th>
      <th scope="col">教育程度</th>
      <th scope="col">目前公司</th>
      <th scope="col">目前职位</th>
      <th scope="col">目前月薪</th>
      <th scope="col">投递时间</th>
      <th scope="col">操作</th>
    </tr>
  </thead>
  <tbody>
    @foreach($resumes as $resume)
      <tr>
        <td>
          <a href="{{ route('resumes.show', $resume) }}" target="_blank" class="color-red">{{ $resume->name }}</a>
        </td>
        @if ($tab === 'untreated')
          <td>{{ $resume->status }}</td>
        @endif
        <td>{{ $resume->sex }}</td>
        <td>{{ $resume->age }}</td>
        <td>{{ $resume->work_years_show }}</td>
        <td>{{ $resume->education_show }}</td>
        <td>{{ $resume->cur_company }}</td>
        <td>{{ $resume->cur_position_show }}</td>
        <td>{{ $resume->cur_salary_show }}K</td>
        <td>{{ $resume->created_at }}</td>
        <td>
          <div class="btn-group" role="group">
            <button id="btnGroupDrop1" type="button" class="btn dropdown-toggle btn-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              操作
            </button>
            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
              @switch($tab)
                @case('untreated')
                  <form method="POST" action="{{ route('resumes.status', ['id' => $resume->id, 'status' => '2', 'tab' => $tab]) }}">
                    {{ csrf_field() }}
                    <button class="dropdown-item" type="submit">加入电话沟通</button>
                  </form>
                @break
                @case('talking')
                  <form method="POST" action="{{ route('resumes.status', ['id' => $resume->id, 'status' => '3', 'tab' => $tab]) }}">
                    {{ csrf_field() }}
                    <button class="dropdown-item" type="submit">加入推荐简历</button>
                  </form>
                @break
                @case('push_resume')
                  <form method="POST" action="{{ route('resumes.status', ['id' => $resume->id, 'status' => '4', 'tab' => $tab]) }}">
                    {{ csrf_field() }}
                    <button class="dropdown-item" type="submit">加入面试</button>
                  </form>
                @break
                @case('interview')
                  <form method="POST" action="{{ route('resumes.status', ['id' => $resume->id, 'status' => '5', 'tab' => $tab]) }}">
                    {{ csrf_field() }}
                    <button class="dropdown-item" type="submit">加入offer</button>
                  </form>
                @break
                @case('offer')
                  <form method="POST" action="{{ route('resumes.status', ['id' => $resume->id, 'status' => '6', 'tab' => $tab]) }}">
                    {{ csrf_field() }}
                    <button class="dropdown-item" type="submit">加入入职</button>
                  </form>
                @break
                @case('onboarding')
                  <form method="POST" action="{{ route('resumes.status', ['id' => $resume->id, 'status' => '7', 'tab' => $tab]) }}">
                    {{ csrf_field() }}
                    <button class="dropdown-item" type="submit">加入过保</button>
                  </form>
                @break
              @endswitch
              @if (in_array($tab, ['onboarding', 'over_probation']))
                <form method="POST" action="{{ route('resumes.status', ['id' => $resume->id, 'status' => '8', 'tab' => $tab]) }}">
                  {{ csrf_field() }}
                  <button class="dropdown-item" type="submit">结束</button>
                </form>
              @else
                <form method="POST" action="{{ route('resumes.status', ['id' => $resume->id, 'status' => '-1', 'tab' => $tab]) }}">
                  {{ csrf_field() }}
                  <button class="dropdown-item" type="submit">待定</button>
                </form>
              @endif
              @if ( ! in_array($tab, ['onboarding', 'over_probation', 'out']))
              <form method="POST" action="{{ route('resumes.status', ['id' => $resume->id, 'status' => '0', 'tab' => $tab]) }}">
                {{ csrf_field() }}
                <button class="dropdown-item" type="submit">淘汰</button>
              </form>
              @endif
            </div>
          </div>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
<div class="row justify-content-end">
  <div class="col-auto">
    {{ $resumes->appends(['tab' => $tab])->links('vendor.pagination.bootstrap-4') }}
  </div>
</div>
