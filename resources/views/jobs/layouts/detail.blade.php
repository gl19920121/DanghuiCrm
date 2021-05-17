<table class="table table-striped default-table">
  <thead>
    <tr>
      <th scope="col">姓名</th>
      <th scope="col">运作状态</th>
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
        <td class="color-red">{{ $resume->name }}</td>
        <td>{{ $resume->status }}</td>
        <td>{{ $resume->sex }}</td>
        <td>{{ $resume->age }}</td>
        <td>{{ $resume->work_years }}</td>
        <td>{{ $resume->education }}</td>
        <td>{{ $resume->cur_company }}</td>
        <td>{{ $resume->cur_position }}</td>
        <td>{{ $resume->cur_salary }}</td>
        <td>{{ $resume->created_at }}</td>
        <td>
          <div class="btn-group" role="group">
            <button id="btnGroupDrop1" type="button" class="btn dropdown-toggle btn-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              操作
            </button>
            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
              <a class="dropdown-item" href="#">加入电话沟通</a>
              <a class="dropdown-item" href="#">待定</a>
              <a class="dropdown-item" href="#">淘汰</a>
            </div>
          </div>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
<div class="row justify-content-end">
  <div class="col-auto">
    {{ $resumes->links() }}
  </div>
</div>
