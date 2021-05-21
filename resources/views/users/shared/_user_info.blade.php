<form method="POST" class="text-center" action="{{ route('users.update', $user) }}">
  {{ csrf_field() }}
  {{ method_field('PATCH') }}
  <div class="form-title text-left">
      <h5>实名认证信息</h5>
  </div>
  <div class="form-group form-inline">
      <label for="name"><span class="color-red">*</span>真实姓名：</label>
      <input type="text" name="name" class="form-control normal" value="{{ $user->name }}" placeholder="请输入真实名称" autocomplete="off">
  </div>
  <div class="form-group form-inline">
      <label for="sex"><span class="color-red">*</span>性别：</label>
      <input type="text" name="sex" class="form-control normal" value="{{ $user->sex }}" placeholder="请输入真实性别" autocomplete="off">
  </div>
  <div class="form-group form-inline">
      <label for="city"><span class="color-red">*</span>所在城市：</label>
      <input type="text" name="city" class="form-control normal" value="{{ $user->city }}" placeholder="请输入现居住城市" autocomplete="off">
  </div>
  <div class="form-group form-inline">
      <label for="phone"><span class="color-red">*</span>手机号码：</label>
      <input type="text" name="phone" class="form-control normal" value="{{ $user->phone }}" placeholder="请输入手机号码" autocomplete="off">
  </div>
  <div class="form-group form-inline">
      <label for="company"><span class="color-red">*</span>所在企业：</label>
      <input type="text" name="company" class="form-control normal" value="{{ $user->company }}" placeholder="请输入所在企业" autocomplete="off">
  </div>
  <button type="submit" class="btn btn-danger btn-form-submit">保存</button>
  <a href="{{ route('users.show', $user) }}" class="btn btn-light btn-form-submit">取消</a>
</form>
