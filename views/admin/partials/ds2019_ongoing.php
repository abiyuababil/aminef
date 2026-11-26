<div class="panel panel-default">
    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionToaRenewel" href="#collapseDs2019" aria-expanded="false" aria-controls="collapseDs2019" onclick="return set_session('ds2019')">
        <div class="panel-heading panel-heading-returning panel-heading-ongoing text-left" role="tab" id="submission_result">
            <h4 class="panel-title">
                <?= isset($is_returning) ? 'Latest DS-2019' : 'DS2019' ?>
            </h4>
        </div>
    </a>
    <div id="collapseDs2019" class="panel-collapse collapse <?= $this->session->userdata('last_tab_visa') == 'ds2019' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
        <div class="panel-body">
            <div class="form-group">
                <?php if(!isset($is_returning)) { ?>
                <!-- <p>When you receive a new DS2019 from IIE with a different program end date, please upload it in the box below by August 15 each year. If your current DS2019 is valid through the program end date, you do not need to upload the document.</p> -->

                <p>When you receive a new DS-2019 from IIE with an updated program end date, please upload it to the box provided below. If your current DS-2019 remains valid through your program end date, you do not need to upload a new document.</p>
                <?php } ?>

                <?php if($is_admin) { ?>
                <!-- <div class="row my-5">
                    <div class="col-lg-12">
                        <div class="TriSea-technologies-Switch">
                            <span class="mr-2"> Enable Delete File</span>
                            <input id="enable_delete_ds2019" name="enable_delete_ds2019" type="checkbox" <?= $visa_interview->enable_delete_ds2019  ? 'checked' : '' ?>/>
                            <label for="enable_delete_ds2019" class="label-primary"></label>
                        </div>
                    </div>
                </div> -->
                <?php } ?>
                <?php //if($grantee_grant->status != STATUS_SET_TO_ALUMNI) { ?>
                <button type="button" class="btn btn-primary my-2 upload_ds2019_ongoing" data-toggle="modal" data-target="#upload_ds2019_ongoing">Add New</button>
                <?php //} ?>
                <table id="table-ds2019-ongoing" class="table table-striped table-bordered table-responsive my-3">
                    <thead>
                        <?php 
                            $showAction = false;
                            foreach($data_ds2019 as $index => $ds2019) { 
                                $required_fields = ['enable_delete'];
                                $showAction = !array_filter($required_fields, fn($f) => empty($ds2019->$f));

                            }
                        ?>
                        <tr>
                            <th>No</th>
                            <!-- <th>Year</th> -->
                            <th>File Name</th>
                            <th>Extension</th>
                            <th>Upload Date</th>
                            <?php if($is_admin || (!$is_admin && $showAction)){ ?>
                            <th>Action</th>
                            <?php } ?>
                            <?php if($is_admin){ ?>
                            <th>Enable Delete</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody id="ds2019_list_ongoing">
                        <?php
                            foreach($data_ds2019 as $index => $ds2019) { 
                            $detail_file = [];
                            $file_ds2019 = '';
                            if($ds2019->file){
                                $data_ds = explode('/', $ds2019->file);
                                $file_ds2019 = $data_ds ? end($data_ds) : '';
                                $detail_file = $data_ds ? explode('.', $file_ds2019) : '';
                                $file_ds2019 = get_full_name($grantee_grant).'_DS2019';
                            }

                        ?>
                        <tr data-id="<?= $ds2019->id ?>">
                            <td><?= $index + 1 ?></td>
                            <!-- <td><?= $ds2019->year ?></td> -->
                            <td><a href="<?= base_url($ds2019->file) ?>" class="lightbox" style="color:#337ab7"><?= $file_ds2019 ?></a></td>
                            <td><?= end($detail_file) ?></td>
                            <td><?= $ds2019->created_date ?></td>
                            <?php if($ds2019->enable_delete || $is_admin) { ?>
                            <td>
                                <a href="javascript:;" onclick="del_data_ds2019(this, <?= $ds2019->id ?>, <?= $is_admin ?>)" class="btn btn-danger btn-xs" style="color:#fff">
                                    <i class="fa fa-trash fa-fw text-white"></i>
                                </a>
                            </td>
                            <?php } ?>
                            <?php if($is_admin) { ?>
                            <td>
                                <div class="TriSea-technologies-Switch" style="margin-left:55px;">
                                    <input onchange="enable_delete_file(this, 'ds2019')" data-id="<?= $ds2019->id ?>" name="enable_delete" id="grantee_edit_ds2019<?= $ds2019->id ?>" type="checkbox" <?= $ds2019->enable_delete  ? 'checked' : '' ?>/>
                                    <label for="grantee_edit_ds2019<?= $ds2019->id ?>" class="label-primary"></label>
                                </div>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php if(isset($is_returning)) { ?>
                    <em>Ensure your stay does not exceed the authorized period on your DS-2019. Departure must be on or before the DS-2019 expiration date.</em>
                <?php } ?>
                <?php if(!isset($is_returning)) { ?>
                <p><b>Note</b>: The document must be in pdf. format and should not exceed 1 MB in size.</p>
                <?php } ?>
            </div>
        </div>
    </div>
</div>