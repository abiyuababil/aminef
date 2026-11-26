<div class="modal fade" id="upload_ds2019_ongoing" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
            <div class="row">
                <!-- <div class="col-md-6">
                    <div class="form-group">
                        <label id="labelTitle">Year</label>
                        <select class="form-control" name="year" id="year_ds2019_ongoing">
                            <option value="">-- Select Year --</option>
                        <?php
                        $current_year = date('Y', strtotime('+5 years'));
                        $limit_year = $current_year - 6;
                        for ($year=$current_year; $year>$limit_year; $year--) { ?>
                            <option value="<?php echo $year ?>"><?php echo $year ?></option>
                        <?php
                        }
                        ?>
                        </select>
                    </div>
                </div> -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label id="labelTitle">DS2019</label>
                        <input type="file" id="upload_ds2019_file_ongoing" name="file">
                        <small class="file-for-testing">File Size Max 1MB</small>
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-is_admin="<?= $is_admin ?>" id="btn-upload-ds2019-ongoing">Save</button>
      </div>
    </div>
  </div>
</div>