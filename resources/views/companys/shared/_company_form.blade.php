<div class="default-form">
  <div class="form-body">
    @if ($act === 'store')
    <form class="text-center" method="POST" action="{{ route('companys.store') }}" enctype="multipart/form-data">
      {{ csrf_field() }}
    @else
    <form class="text-center" method="POST" action="{{ route('companys.update', Session::get('company_id','')) }}" enctype="multipart/form-data">
      {{ csrf_field() }}
      {{ method_field('PATCH') }}
    @endif
        <div class="form-group form-inline">
            <label for="name"><span>*</span>公司名称：</label>
            <input type="text" name="name" class="form-control middle" value="{{ isset($oldData['company']) ? $oldData['company']->name : '' }}" placeholder="请填写企业全称">
        </div>
        <div class="form-group form-inline">
            <label for="nickname"><span>*</span>对外显示名称：</label>
            <input type="text" name="nickname" class="form-control middle" value="" placeholder="展示给求职者" autocomplete="off">
        </div>
        <div class="form-group form-inline">
            <label for="industry"><span>*</span>所属行业：</label>
            <div class="input-group" data-toggle="industrypicker">

              <input type="hidden" name="industry[st]" value="">
              <input type="hidden" name="industry[nd]" value="">
              <input type="hidden" name="industry[rd]" value="">
              <input type="hidden" name="industry[th]" value="">

              <input id="industry" type="text" class="form-control middle-append append" value="" placeholder="请选择" autocomplete="off">
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
            <div data-toggle="distpicker" class="">
              <select class="form-control mini" name="location[province]" data-province="省"></select>
              <select class="form-control mini" name="location[city]" data-city="市"></select>
              <select class="form-control mini" name="location[district]"  data-district="区"></select>
            </div>
        </div>
        <div class="form-group form-inline">
            <label for="address"><span>*</span>公司详细地址：</label>
            <input type="text" name="address" class="form-control middle" value="" placeholder="请填写" autocomplete="off">
        </div>
        <div class="form-group form-inline">
            <label for="nature"><span>*</span>企业性质：</label>
            <select name="nature" class="form-control middle" value="{{  old('nature')}}">
                @foreach (App\Models\Company::natureArr as $key => $nature)
                    <option value="{{ $key }}" @if(isset($oldData['nature']) && $key === $oldData['nature']) selected="selected" @endif>{{ $nature['text'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group form-inline">
            <label for="scale"><span>*</span>企业规模：</label>
            <select name="scale" class="form-control middle" value="{{  old('scale')}}">
                @foreach (App\Models\Company::scaleArr as $key => $scale)
                    <option value="{{ $key }}" @if(isset($oldData['scale']) && $key === $oldData['scale']) selected="selected" @endif>{{ $scale['text'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group form-inline">
            <label for="investment"><span>*</span>融资阶段：</label>
            <select name="investment" class="form-control middle" value="{{  old('investment')}}">
                @foreach (App\Models\Company::investmentArr as $key => $investment)
                    <option value="{{ $key }}" @if(isset($oldData['investment']) && $key === $oldData['investment']) selected="selected" @endif>{{ $investment['text'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group form-inline">
          <label for="logo"><span>*</span>公司LOGO：</label>
          <input hidden type="file" multiple="true" accept="image/png, image/jpeg" name="logo" class="form-control middle">
          <input type="text" class="form-control middle" id="inputLogo" placeholder="请选择图片" onclick="setLogo()" readonly style="cursor: pointer;">
        </div>
        <div class="form-group form-inline">
            <label for="introduction">企业介绍：</label>
            <textarea name="introduction" class="form-control middle" placeholder="突出企业亮点" >{{ isset($oldData['introduction']) ? $oldData['introduction'] : '' }}</textarea>
        </div>
        <p class="color-silvery-gray">修改企业信息后，该企业下所有职位会统一更新</p>
        <button type="submit" class="btn btn-danger btn-form-submit">保存企业信息</button>
        <button type="button" class="btn btn-light btn-form-submit" data-dismiss="modal">取消</button>
    </form>
  </div>
</div>

<script type="text/javascript">
  $('#companyEditModal').on('show.bs.modal', function (e) {
    var btnThis = $(e.relatedTarget);
    var data = btnThis.attr('data-item');

    if (typeof(data) == 'undefined') {
      return;
    }
    var company = JSON.parse(data);
    $('input[name=name]').val(company.name);
    $('input[name=nickname]').val(company.nickname);

    var industry = JSON.parse(company.industry);
    var industryShow = industry.th;
    $('input[name="industry[st]"]').val(industry.st);
    $('input[name="industry[nd]"]').val(industry.nd);
    $('input[name="industry[rd]"]').val(industry.rd);
    $('input[name="industry[th]"]').val(industry.th);
    $('#industry').val(industryShow);

    var location = JSON.parse(company.location);
    $('select[name="location[province]"]').val(location.province);
    $('select[name="location[province]"]').trigger("change");
    $('select[name="location[city]"]').val(location.city);
    $('select[name="location[city]"]').trigger("change");
    $('select[name="location[district]"]').val(location.district);
    $('select[name="location[district]"]').trigger("change");

    $('input[name=address]').val(company.address);
    $('select[name=nature]').val(company.nature);
    $('select[name=scale]').val(company.scale);
    $('select[name=investment]').val(company.investment);
    // $('input[name=logo]').val(company.logo);
    $('textarea[name=introduction]').text(company.introduction);
  });

  function setLogo()
  {
    $('input[name="logo"]').click();
  }

  $('input[name="logo"]').change(function() {
    $('#inputLogo').val($(this).val());
  });
</script>
