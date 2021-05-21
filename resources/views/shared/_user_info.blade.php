<div class="user-show bg-white">
    <div class="default-form">
        <div class="form-header">
          <h5>基本信息</h5>
        </div>
        <hr class="divider">
        <div class="form-body">
            <form class="text-center" method="POST">
                {{ csrf_field() }}
                <div class="form-title text-left">
                    <h5>个人信息</h5>
                </div>
                <div class="row">
                  <div class="col col-11">
                    <div class="row">
                      <div class="col col-auto align-self-center">
                        <span class="color-gray">头像：</span>
                      </div>
                      <div class="col col-auto">
                        <img src="{{ URL::asset('images/avatar_default.png') }}">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col col-auto">
                        <span class="color-gray">名称：</span>
                      </div>
                      <div class="col col-auto">
                        {{ $user->nickname }}
                      </div>
                    </div>
                    <div class="row">
                      <div class="col col-auto">
                        <span class="color-gray">职位：</span>
                      </div>
                      <div class="col col-auto">
                        {{ $user->job }}
                      </div>
                    </div>
                    <div class="row">
                      <div class="col col-auto">
                        <span class="color-gray">微信号：</span>
                      </div>
                      <div class="col col-auto">
                        {{ $user->wechat }}
                      </div>
                    </div>
                    <div class="row">
                      <div class="col col-auto">
                        <span class="color-gray">优势介绍：</span>
                      </div>
                      <div class="col col-auto">
                        {{ $user->introduce }}
                      </div>
                    </div>
                  </div>
                  <div class="col align-self-center">
                    <img src="{{ URL::asset('images/edit.png') }}">
                    <a href="{{ route('users.edit', [$user, 'part' => 'account']) }}">编辑</a>
                  </div>
                </div>
                <hr class="divider">
                <div class="form-title text-left">
                    <h5>实名认证</h5>
                </div>
                <div class="row">
                  <div class="col col-11">
                    <div class="row">
                      <div class="col col-auto">
                        <span class="color-gray">真实姓名：</span>
                      </div>
                      <div class="col col-auto">
                        {{ $user->name }}
                      </div>
                    </div>
                    <div class="row">
                      <div class="col col-auto">
                        <span class="color-gray">性别：</span>
                      </div>
                      <div class="col col-auto">
                        {{ $user->sex }}
                      </div>
                    </div>
                    <div class="row">
                      <div class="col col-auto">
                        <span class="color-gray">所在城市：</span>
                      </div>
                      <div class="col col-auto">
                        {{ $user->city }}
                      </div>
                    </div>
                    <div class="row">
                      <div class="col col-auto">
                        <span class="color-gray">手机号码：</span>
                      </div>
                      <div class="col col-auto">
                        {{ $user->phone }}
                      </div>
                    </div>
                    <div class="row">
                      <div class="col col-auto">
                        <span class="color-gray">所在企业：</span>
                      </div>
                      <div class="col col-auto">
                        {{ $user->company }}
                      </div>
                    </div>
                  </div>
                  <div class="col align-self-center">
                    <img style="margin-bottom: 1px;" src="{{ URL::asset('images/edit.png') }}">
                    <a href="{{ route('users.edit', [$user, 'part' => 'user']) }}">编辑</a>
                  </div>
                </div>
            </form>
        </div>
    </div>
</div>
