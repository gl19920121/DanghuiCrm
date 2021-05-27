@if (count($errors) > 0)
  <!-- Modal -->
  <div class="modal fade msg-modal" id="errModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                <ul>
                  <li>{{ $errors->all()[0] }}</li>
                </ul>
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
