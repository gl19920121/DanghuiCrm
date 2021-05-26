<!-- Modal -->
<div class="modal fade confirm-modal" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content m-auto">
      <div class="modal-header">
        <h5 class="modal-title font-size-s" id="confirmModalLabel">确认信息</h5>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row justify-content-md-center mt-1">
            <div class="col col-auto" style="padding-right: 0;">
              <img src="{{ URL::asset('images/question_mark.png')  }}">
            </div>
            <div class="col col-auto">
              <label class="font-size-l" id="confirmMessage"></label>
            </div>
          </div>
          <div class="row justify-content-md-center mt-4">
            <div class="col-auto">
              <button class="btn btn-danger" name="define" onclick="define()">确定</button>
              <button class="btn btn-light" name="cancel" data-dismiss="modal">关闭</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    var sourceBtn;

    $('#confirmModal').on('show.bs.modal', function (e) {
        let btnThis = $(e.relatedTarget);
        sourceBtn = btnThis;
        let type = btnThis.data('type');
        let typeShow = type;
        switch(type) {
            case 'job':
                typeShow = '职位';
        }
        let message = '您是否确认' + btnThis.text() + typeShow;

        $('#confirmMessage').text(message);
    });

    // $('#confirmModal').on('hide.bs.modal', function (e) {
    // });

    function define()
    {
        sourceBtn.closest('form').submit();
    }
</script>
