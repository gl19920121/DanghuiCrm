@if (session()->has('result') && session()->get('result') !== false)
  <!-- Modal -->
  <div class="modal fade msg-modal" id="msgModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content m-auto">
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
              <div class="col-auto m-auto">
                <img src="{{ URL::asset('images/success.png')  }}">
              </div>
            </div>
            <div class="row">
              <div class="col-auto m-auto">
                {{ session()->get('result') }}
              </div>
            </div>
            <div class="row">
              <div class="col-auto m-auto">
                <button type="button" class="btn btn-modal btn-success" data-dismiss="modal">辛苦啦</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endif
@if (session()->has('danger'))
  <!-- Modal -->
  <div class="modal fade msg-modal" id="msgModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content m-auto">
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
              <div class="col-auto m-auto">
                <img src="{{ URL::asset('images/fail.png')  }}">
              </div>
            </div>
            <div class="row">
              <div class="col-auto m-auto">
                {{ session()->get('danger') }}
              </div>
            </div>
            <div class="row">
              <div class="col-auto m-auto">
                <button type="button" class="btn btn-modal btn-fail" data-dismiss="modal">我再想想</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endif
