<form method="POST" class="text-center" action="{{ route('users.update', $user) }}">
  {{ csrf_field() }}
  {{ method_field('PATCH') }}
  <div class="form-title text-left">
      <h5>编辑个人信息</h5>
  </div>
  <div class="form-group form-inline">
      <label for="nickname"><span class="color-red">*</span>名称：</label>
      <input type="text" name="nickname" class="form-control normal" value="{{ $user->nickname }}" placeholder="请输入展示名称" autocomplete="off">
  </div>
  <div class="form-group form-inline">
      <label for="job"><span class="color-red">*</span>职位：</label>
      <input type="text" name="job" class="form-control normal" value="{{ $user->job }}" placeholder="请输入职位" autocomplete="off">
  </div>
  <div class="form-group form-inline">
      <label for="wechat"><span class="color-red">*</span>微信：</label>
      <input type="text" name="wechat" class="form-control normal" value="{{ $user->wechat }}" placeholder="请输入微信号" autocomplete="off">
  </div>
  <div class="form-group form-inline">
      <label for="introduce"><span class="color-red">*</span>介绍：</label>
      <textarea name="introduce" class="form-control normal" placeholder="请输入你的专业优势">{{ $user->introduce }}</textarea>
  </div>
  <button type="submit" class="btn btn-danger btn-form-submit">保存</button>
  <a href="{{ route('users.show', $user) }}" class="btn btn-light btn-form-submit">取消</a>
</form>