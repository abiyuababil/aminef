<div class="panel panel-default">
    <a role="button" data-toggle="collapse" data-parent="#accordionOne" href="#collapseLatestds2019" aria-expanded="true" aria-controls="collapseLatestds2019" onclick="return set_session('ds2019')">
        <div class="panel-heading panel-heading-returning text-left" role="tab" id="submission_result">
            <h4 class="panel-title">
                Latest DS-2019
            </h4>
        </div>
    </a>
    <div id="collapseLatestds2019" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'ds2019' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
        <div class="panel-body">
            <div class="form-group">
                <!-- <label>The latest DS2019</label> -->
                <table class="table table-striped table-bordered table-responsive mt-4">
                    <thead>
                        <tr>
                            <th width="30%">File Upload</th>
                            <th>Status</th>
                            <th>Upload Date</th>
                            <?php if(!$is_alumni_page) { ?>
                            <th>Action</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody id="latest_ds2019_list">
                        <?php // FOR MULTIPLE DATA
                        // foreach($file_latest_ds2019 as $ds2019) { 
                        //     $fileDs2019 = '';
                        //     if($ds2019->file_admin){
                        //         $ds2019_file = explode('/', $ds2019->file_admin);
                        //         $fileDs2019 = $ds2019_file ? end($ds2019_file) : '';
                        //         $detail_file = $ds2019_file ? explode('.', $fileDs2019) : '';
                        //     }
                        ?>
                        <tr>
                            <td><a href="<?= base_url($ds2019->file) ?>" class="lightbox" style="color:#337ab7"><?= $ds2019->filename ?></a></td>
                            <td>
                                <?= $ds2019->status ?>
                                <?php if($ds2019->status == 'Revise') { ?>
                                    <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" data-target="#modal_note" data-note="<?= $ds2019->note ?>" data-attach='<?= $ds2019->attachment_revise ?>'>i</span>
                                <?php } ?>
                                <?php if($ds2019->status == 'Rejected') { ?>
                                    <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" data-target="#modal_note" data-note="<?= $ds2019->note_reject ?>" data-attach='<?= $ds2019->attachment_revise ?>'>i</span>
                                <?php } ?>
                            </td>
                            <td><?= $ds2019->created_date ?></td>
                            <?php if(!$is_alumni_page) { ?>
                            <td>
                                <input type="hidden" name="latest_ds2019_id" id="latest_ds2019_id" value="<?= $grantee_grant->id ?>">
                                <input type="file" data-id="<?= $grantee_grant->id ?>" class="upload_latest_ds2019_<?= $grantee_grant->id ?> hide">
                                <a class="btn btn-primary btn-xs upload_departure_item <?= (!$is_admin && $ds2019->status == 'Revise') || $is_admin || $ds2019->file == '' ? '' : 'hide' ?>" data-id="<?= $grantee_grant->id ?>" style="color:#fff" data-document="latest_ds2019" data-file-value="upload_latest_ds2019_<?= $grantee_grant->id ?>">Upload</a>

                                <?php if($is_admin) { ?>
                                    <a href="javascript:;" onclick="update_status_file_returning(this, <?= $grantee_grant->id ?>, 'approve', 'latest_ds2019')" class="btn btn-success <?= $ds2019->file ? '' : 'hide' ?> show-button btn-xs" style="color:#fff">
                                        Approve
                                    </a>
                                    <a href="javascript:;" onclick="update_status_file_returning(this, <?= $grantee_grant->id ?>, 'revise', 'latest_ds2019')" class="btn btn-warning <?= $ds2019->file ? '' : 'hide' ?> show-button btn-xs" style="color:#fff">
                                        Revise
                                    </a>
                                    <input data-log="<?= $ds2019->id ?>" data-type="latest_ds2019" data-toggle="modal" data-target="#modal-payment-log" type="button" class="<?= $ds2019->file ? '' : 'hide' ?> show-button btn-xs btn btn-default modal-log" value="Open Log" style="font-size:12px;">
                                <?php } ?>
                                <a href="javascript:;" onclick="del_file_returning(this, <?= $grantee_grant->id ?>, 'latest_ds2019')" class="<?= (!$is_admin && $ds2019->status == 'Revise') || $is_admin ? '' : 'hide' ?> btn btn-danger show-button btn-xs btn-del-latest_ds2019 <?= $ds2019->file ? '' : 'hide' ?>" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php //} ?>
                    </tbody>
                </table>
                <em>Ensure your stay does not exceed the authorized period on your DS-2019. Departure must be on or before the DS-2019 expiration date.</em>
                <hr />
            </div>
        </div>
    </div>
</div>