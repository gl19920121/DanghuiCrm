<!-- Modal -->
<div class="modal fade company-modal" id="companyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content m-auto">
      <div class="modal-header">
        <h5 class="modal-title mt-auto">企业信息</h5>
      </div>
      <div class="modal-body">
        @include('companys.shared._company_form_create', ['act' => 'store'])
      </div>
    </div>
  </div>
</div>
