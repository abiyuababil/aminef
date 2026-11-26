<div class="modal fade" id="upload_ds2019" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleMedical">Add DS2019</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" id="form_memo" enctype="multipart/form-data">
            <div class="form-group">
                <label id="labelTitle">DS2019</label>
                <input type="file" id="upload_ds2019_file" name="file" multiple>
                <small class="file-for-testing">File Size Max 5MB</small>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-is_admin="<?= $is_admin ?>" id="btn-upload-ds2019">Save</button>
      </div>
    </div>
  </div>
</div>