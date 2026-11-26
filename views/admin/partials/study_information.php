
<div id="study_information" class="active in first_tab">
    <div class="panel-group" id="accordionToaRenewel" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionToaRenewel" href="#collapseToaRenewal" aria-expanded="false" aria-controls="collapseToaRenewal" onclick="return set_session('study_information_toa')">
                <div class="panel-heading-ongoing text-left" role="tab" id="submission_result">
                    <h4 class="panel-title">
                        TOA Renewal
                    </h4>
                </div>
            </a>
            <div id="collapseToaRenewal" class="panel-collapse collapse <?= $this->session->userdata('last_tab_visa') == 'study_information_toa' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                <div class="panel-body">
                    <p>After signing your TOA Renewal from IIE (available during the Spring semester), please upload the document in the space provided below between July 31 - August 31 each year. If your program is only one year in length, you do not need to upload this document.</p>
                    <?php //if($is_admin) { ?>
                    <br />
                    <button type="button" class="btn btn-primary upload_sign_toa" data-toggle="modal" data-target="#upload_sign_toa">Add New</button>
                    <?php //} ?>
                    <table class="table table-striped table-bordered table-responsive mt-4">
                        <thead>
                            <?php 
                                $showAction = array_reduce($doc_sign_toa, function($carry, $item) {
                                    return $carry || !empty($item->grantee_edit);
                                }, false);
                            ?>
                            <tr>
                                <th>No</th>
                                <th>Academic Year</th>
                                <th>Signed TOA Renewal</th>
                                <?php if($is_admin){ ?>
                                <th>Total Cost</th>
                                <th>Saving</th>
                                <th>Shortfall</th>
                                <th>Detail Cost</th>
                                <?php } ?>
                                <?php if($is_admin || (!$is_admin && $showAction)){ ?>
                                <th>Action</th>
                                <?php } ?>
                                <?php if($is_admin){ ?>
                                <th>Edit Grantee</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody id="sign_toa_list">
                            <?php foreach($doc_sign_toa as $row => $toa) { 

                                $calculate = $grantee_grant->grant_award - $toa->total_cost;
                                $sortfall = $calculate && ($grantee_grant->grant_award <= $toa->total_cost) ? number_format(abs($calculate)) : '';
                                $saving = $calculate && ($grantee_grant->grant_award >= $toa->total_cost) ? number_format($calculate) : '';
                                
                            ?>
                                <tr id="index-signToa-<?= $toa->id ?>">
                                    <td><?= $row + 1 ?></td>
                                    <td><?= $toa->year ?></td>
                                    <td>
                                        <?php if($toa->signed_toa) { ?>
                                        <!-- <a href="<?= base_url($toa->signed_toa) ?>" data-lightbox-type="iframe" class="lightbox" style="color:#337ab7"><?= file_name($toa->signed_toa) ?></a> -->
                                        <a href="<?= base_url($toa->signed_toa) ?>" data-lightbox-type="iframe" class="lightbox" style="color:#337ab7"><?= get_full_name($grantee_grant) ?>_TOA Renewal_<?= $toa->year ?></a>
                                        <?php } ?>
                                    </td>
                                    <?php if($is_admin){ ?>
                                    <td><span class="text-primary"><?= $toa->total_cost ? number_format($toa->total_cost) : '' ?></span></td>
                                    <td><span class="text-primary"><?= $saving ?></span></td>
                                    <td><span class="text-danger"><?= $sortfall ?></span></td>
                                    <td>
                                        <?php if($toa->detail_cost) { ?>
                                        <a href="<?= base_url($toa->detail_cost) ?>" class="lightbox" style="color:#337ab7"><?= file_name($toa->detail_cost) ?></a>
                                        <?php } ?>
                                    </td>
                                    <?php } ?>
                                    <?php if($is_admin || (!$is_admin && $toa->grantee_edit)) { ?>
                                    <td>
                                        <a onclick="edit_data_sign_toa(this, <?= $toa->id ?>, <?= $row + 1 ?>, <?= $is_admin ?>)" class="btn btn-primary btn-xs edit-sign_toa" style="color:#fff">
                                            Edit
                                        </a>
                                        <a href="javascript:;" onclick="del_data_ongoing(this, <?= $toa->id ?>, 'sign_toa_list', <?= $is_admin ?>)" class="btn btn-danger btn-xs" style="color:#fff">
                                            <i class="fa fa-trash fa-fw text-white"></i>
                                        </a>
                                        
                                        <?php if($is_admin){ ?>
                                        <input data-log="<?= $toa->id ?>" data-toggle="modal" data-target="#modal-payment-log" type="button" class="btn-xs btn btn-default modal-log-toa" value="Open Log" style="font-size:12px;">
                                        <?php } ?>
                                    </td>
                                    <?php } ?>
                                    <?php if($is_admin) { ?>
                                    <td>
                                        <div class="TriSea-technologies-Switch" style="margin-left:55px;">
                                            <input onchange="grantee_edit_toa(this, 'signed_toa_renewal')" data-id="<?= $toa->id ?>" name="grantee_edit" id="grantee_edit_<?= $toa->id ?>" type="checkbox" <?= $toa->grantee_edit  ? 'checked' : '' ?>/>
                                            <label for="grantee_edit_<?= $toa->id ?>" class="label-primary"></label>
                                        </div>
                                    </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <p><b>Note</b>: The document must be in pdf. format and should not exceed 1 MB in size.</p>
                </div>
            </div>
        </div>

        <?php $this->load->view('admin/partials/ds2019_ongoing') ?>

        <div class="panel panel-default">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionToaRenewel" href="#collapseTranskript" aria-expanded="false" aria-controls="collapseTranskript" onclick="return set_session('academic_transcript')">
                <div class="panel-heading-ongoing text-left" role="tab" id="submission_result">
                    <h4 class="panel-title">
                        Academic Transcript
                    </h4>
                </div>
            </a>
            <div id="collapseTranskript" class="panel-collapse collapse <?= $this->session->userdata('last_tab_visa') == 'academic_transcript' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
                <div class="panel-body">
                    <div class="form-group">
                        <p>When your academic transcript for the current academic year becomes available, please upload it in the box provided below between July 31 - August 31 each year.</p>

                        <button type="button" class="btn btn-primary my-2 upload_academic_transcript" data-toggle="modal" data-target="#upload_academic_transcript">Add New</button>
                        <table id="table-academic-transcript" class="table table-striped table-bordered table-responsive my-3">
                            <thead>
                                <?php 
                                    $showAction = false;
                                    foreach($data_academic_transcript as $index => $academic_transcript) { 
                                        $required_fields = ['enable_delete'];
                                        $showAction = !array_filter($required_fields, fn($f) => empty($academic_transcript->$f));

                                    }
                                ?>
                                <tr>
                                    <th>No</th>
                                    <th>Academic Year</th>
                                    <th>Academic Transcript</th>
                                    <?php if($is_admin || (!$is_admin && $showAction)){ ?>
                                    <th>Action</th>
                                    <?php } ?>
                                    <?php if($is_admin){ ?>
                                    <th>Enable Delete</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody id="academic_transcript_list">
                                <?php
                                    foreach($data_academic_transcript as $index => $academic_transcript) { 
                                    $detail_file = [];
                                    $file_ds2019 = '';
                                    if($academic_transcript->file){
                                        $data_ds = explode('/', $academic_transcript->file);
                                        // $file_ds2019 = $data_ds ? end($data_ds) : '';
                                        $detail_file = $data_ds ? explode('.', $file_ds2019) : '';
                                        $file_ds2019 = get_full_name($grantee_grant).'_Academic Transcript_'.$academic_transcript->year;
                                    }

                                ?>
                                <tr data-id="<?= $academic_transcript->id ?>">
                                    <td><?= $index + 1 ?></td>
                                    <td><?= $academic_transcript->year ?></td>
                                    <td><a href="<?= base_url($academic_transcript->file) ?>" class="lightbox" style="color:#337ab7"><?= $file_ds2019 ?></a></td>
                                    <?php if($academic_transcript->enable_delete || $is_admin) { ?>
                                    <td>
                                        <a href="javascript:;" onclick="del_data_academic_transcript(this, <?= $academic_transcript->id ?>, <?= $is_admin ?>)" class="btn btn-danger btn-xs" style="color:#fff">
                                            <i class="fa fa-trash fa-fw text-white"></i>
                                        </a>
                                    </td>
                                    <?php } ?>
                                    <?php if($is_admin) { ?>
                                    <td>
                                        <div class="TriSea-technologies-Switch" style="margin-left:55px;">
                                            <input onchange="enable_delete_file(this, 'academic_transcript')" data-id="<?= $academic_transcript->id ?>" name="enable_delete" id="grantee_edit_at<?= $academic_transcript->id ?>" type="checkbox" <?= $academic_transcript->enable_delete  ? 'checked' : '' ?>/>
                                            <label for="grantee_edit_at<?= $academic_transcript->id ?>" class="label-primary"></label>
                                        </div>
                                    </td>
                                    <?php } ?>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <p><b>Note</b>: The document must be in pdf. format and should not exceed 1 MB in size.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>