<div class="default-form">
  <div class="form-body">
    <form class="text-center" method="POST" action="{{ route('companys.store') }}" enctype="multipart/form-data">
      {{ csrf_field() }}
        <div class="form-group form-inline">
            <label for="name"><span>*</span>公司名称：</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control middle" placeholder="请填写企业全称">
        </div>
        <div class="form-group form-inline">
            <label for="nickname">对外显示名称：</label>
            <input type="text" name="nickname" value="{{ old('nickname') }}" class="form-control middle" placeholder="展示给求职者" autocomplete="off">
        </div>
        <div class="form-group form-inline">
            <label for="industry">所属行业：</label>
            <div class="input-group" data-toggle="industrypicker">
              @if (empty(old('industry')))
                <input type="hidden" name="industry[st]">
                <input type="hidden" name="industry[nd]">
                <input type="hidden" name="industry[rd]">
                <input type="hidden" name="industry[th]">
                <input id="industry" type="text" class="form-control middle-append append" placeholder="请选择" autocomplete="off">
              @else
                <input type="hidden" name="industry[st]" value="{{ old('industry')['st'] }}">
                <input type="hidden" name="industry[nd]" value="{{ old('industry')['nd'] }}">
                <input type="hidden" name="industry[rd]" value="{{ old('industry')['rd'] }}">
                <input type="hidden" name="industry[th]" value="{{ old('industry')['th'] }}">
                <input id="industry" type="text" value="{{ old('industry')['th'] }}" class="form-control middle-append append" placeholder="请选择" autocomplete="off">
              @endif
              <div class="input-group-append" data-toggle="modal" data-target="#industryModal">
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
            <label for="location"><span>*</span>所在地：</label>
            <div data-toggle="distpicker">
              <select class="form-control mini" name="location[province]" data-province="{{ isset(old('location')['province']) ? old('location')['province'] : '省' }}"></select>
              <select class="form-control mini" name="location[city]" data-city="{{ isset(old('location')['city']) ? old('location')['city'] : '市' }}"></select>
              <select class="form-control mini" name="location[district]"  data-district="{{ isset(old('location')['district']) ? old('location')['district'] : '区' }}"></select>
            </div>
        </div>
        <div class="form-group form-inline">
            <label for="address">公司详细地址：</label>
            <input type="text" name="address" class="form-control middle" value="{{ old('address') }}" placeholder="请填写" autocomplete="off">
        </div>
        <div class="form-group form-inline">
            <label for="nature">企业性质：</label>
            <select name="nature" class="form-control middle">
              <option hidden value="">请选择</option>
                @foreach (trans('db.company.nature') as $key => $nature)
                    <option value="{{ $key }}"
                    @if (old('nature') === $key)
                      selected
                    @endif>
                      {{ $nature }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group form-inline">
            <label for="scale">企业规模：</label>
            <select name="scale" class="form-control middle">
              <option hidden value="">请选择</option>
                @foreach (trans('db.company.scale') as $key => $scale)
                    <option value="{{ $key }}"
                    @if ((string)old('scale') === (string)$key)
                      selected
                    @endif>
                      {{ $scale }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group form-inline">
            <label for="investment">融资阶段：</label>
            <select name="investment" class="form-control middle">
              <option hidden value="">请选择</option>
                @foreach (trans('db.company.investment') as $key => $investment)
                    <option value="{{ $key }}"
                    @if (old('investment') === $key)
                      selected
                    @endif>
                      {{ $investment }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group form-inline">
          <label for="logo">公司LOGO：</label>
          <div data-toggle="filechoose" data-type="logo">
            <img hidden class="form-control">
            <input hidden type="file" multiple="true" accept="image/png, image/jpeg" name="logo" class="form-control middle">
            <input type="text" class="form-control" placeholder="请选择图片" readonly>
          </div>
        </div>
        <div class="form-group form-inline">
            <label for="introduction">企业介绍：</label>
            <textarea name="introduction" class="form-control middle" placeholder="突出企业亮点">{{ old('introduction') }}</textarea>
        </div>
        <p class="color-silvery-gray">修改企业信息后，该企业下所有职位会统一更新</p>
        <button type="submit" class="btn btn-danger btn-form-submit">保存企业信息</button>
        <button type="button" class="btn btn-light btn-form-submit" data-dismiss="modal">取消</button>
    </form>
  </div>
</div>
