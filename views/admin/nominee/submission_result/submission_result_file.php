<div class="modal fade" id="submission_result_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Upload Submission Result</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method="POST" id="form_memo" enctype="multipart/form-data">
            <div class="form-group">
                <label>Submission Result</label>
                <input type="file" id="submission_result_input_file" name="submission_result_file">
                <small class="file-for-testing">File Size Max 5MB</small>
                <input type="hidden" name="submission_result_id" id="submission_result_id" value="<?= $id ?>">
                <input type="hidden" name="type" id="type" value="<?= $type ?>">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-submission-result">Save</button>
      </div>
    </div>
  </div>
</div>