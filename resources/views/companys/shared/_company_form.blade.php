<div class="default-form">
  <div class="form-body">
    <form class="text-center" method="POST" action="{{ route('companys.store') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group form-inline">
            <span>*</span><label for="name">公司名称：</label>
            <input type="text" name="name" class="form-control normal" value="{{ isset($oldData['company']) ? $oldData['company']->name : 'ddd' }}" placeholder="请填写企业全称">
        </div>
        <div class="form-group form-inline">
            <span>*</span><label for="nickname">对外显示名称：</label>
            <input type="text" name="nickname" class="form-control normal" value="ddd" placeholder="展示给求职者" autocomplete="off">
        </div>
        <div class="form-group form-inline">
            <span>*</span><label for="industry">所属行业：</label>
            <div class="input-group" data-toggle="industrypicker">

              <input type="hidden" name="industry[st]" value="ddd">
              <input type="hidden" name="industry[nd]" value="ddd">
              <input type="hidden" name="industry[rd]" value="ddd">
              <input type="hidden" name="industry[th]" value="ddd">

              <input type="text" class="form-control normal" id="industry" value="" placeholder="请选择" autocomplete="off">
              <div class="input-group-append">
                <span class="input-group-text" id="basic-addon2">
                  <svg class="bi bi-calendar" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1zm1-3a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2z"/>
                    <path fill-rule="evenodd" d="M3.5 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5zm9 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5z"/>
                  </svg>
                </span>
              </div>
            </div>
        </div>
        <div class="form-group form-inline">
            <span>*</span><label for="location">所在地：</label>
            <div data-toggle="distpicker">
              <select class="form-control" name="location[province]" data-province=""></select>
              <select class="form-control" name="location[city]"  data-city=""></select>
              <select class="form-control" name="location[district]"  data-district=""></select>
            </div>
        </div>
        <div class="form-group form-inline">
            <span>*</span><label for="address">公司详细地址：</label>
            <input type="text" name="address" class="form-control normal" value="ddd" placeholder="请填写" autocomplete="off">
        </div>
        <div class="form-group form-inline">
            <span>*</span><label for="nature">企业性质：</label>
            <select name="nature" class="form-control normal" value="{{  old('nature')}}">
                @foreach (App\Models\Company::natureArr as $key => $nature)
                    <option value="{{ $key }}" @if(isset($oldData['nature']) && $key === $oldData['nature']) selected="selected" @endif>{{ $nature['text'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group form-inline">
            <span>*</span><label for="scale">企业规模：</label>
            <select name="scale" class="form-control normal" value="{{  old('scale')}}">
                @foreach (App\Models\Company::scaleArr as $key => $scale)
                    <option value="{{ $key }}" @if(isset($oldData['scale']) && $key === $oldData['scale']) selected="selected" @endif>{{ $scale['text'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group form-inline">
            <span>*</span><label for="investment">融资阶段：</label>
            <select name="investment" class="form-control normal" value="{{  old('investment')}}">
                @foreach (App\Models\Company::investmentArr as $key => $investment)
                    <option value="{{ $key }}" @if(isset($oldData['investment']) && $key === $oldData['investment']) selected="selected" @endif>{{ $investment['text'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group form-inline">
          <span>*</span><label for="logo">公司LOGO：</label>
          <input type="file" multiple="true" accept="image/png, image/jpeg" name="logo" class="form-control normal">
        </div>
        <div class="form-group form-inline">
            <span></span><label for="introduction">企业介绍：</label>
            <input type="text" name="introduction" class="form-control normal" value="{{ isset($oldData['introduction']) ? $oldData['introduction'] : 'ddd' }}" placeholder="突出企业亮点" autocomplete="off">
        </div>
        <p class="color-silvery-gray">修改企业信息后，该企业下所有职位会统一更新</p>
        <button type="submit" class="btn btn-danger btn-form-submit">保存企业信息</button>
        <button type="button" class="btn btn-light btn-form-submit" data-dismiss="modal">取消</button>
    </form>
  </div>
</div>
