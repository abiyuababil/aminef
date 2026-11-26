<?php
$default_tab_active = 'class="active"';
$default_content_active = 'active in';

if ($pid != '') {
    $default_tab_active = '';
    $default_content_active = '';
}
?>

<style>
    /* .swal2-show {
        width: 90% !important;
    } */
    /* .table-nowrap th,
    .table-nowrap td {
        white-space: nowrap;
    } */

    .note-row b {
        display: inline-block;
        min-width: 200px;
    }
    td {
        padding-top: 10px;
        padding-bottom: 20px;
        padding-left: 30px;
        padding-right: 40px;
    }
    
    #success-alert {
        position: fixed;
        top: 165px;
        right: 40px;
        z-index: 1001;
        font-weight: bold;
        border: none;
        outline: none;
        cursor: pointer;
        display: none;
    }

    th.sticky-no,
    td.sticky-no {
        position: sticky;
        left: 0;
        background: #f9f9f9;
        z-index: 5;
    }

    th.sticky-univ,
    td.sticky-univ {
        position: sticky;
        left: 35px;
        background: #f9f9f9;
        z-index: 5;
    }

    /* Action (kanan) */
    th.sticky-action,
    td.sticky-action {
        position: sticky;
        right: 0;
        background: #f9f9f9;
        z-index: 5;
    }
</style>
<div class="alert alert-success" id="success-alert" style="width:260px">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <span id="label-for-date">Success Submited</span>
</div>
<!-- <div class="row">
    <div class="col-lg-12 text-center">
        <h2 style="color:#0089d1">Submission Result</h2>
        <h1 class="page-header"><?php echo $grantee_grant->grant_name ?></h1>
    </div>
</div> -->
<div class="row">
    <!-- <div id="submission-result" class="tab-pane fade"> -->
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body table">
                    <p style="font-weight:bold;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> Submission Result</p>
                    <div class="table-responsive" >
                        <table class="table table-nowrap table-bordered">
                            <thead>
                                <tr>
                                    <th class="sticky-no">No</th>
                                    <th width="15%">University</th>
                                    <!-- <th>Degree</th>
                                    <th>Major</th>
                                    <th>Specialization</th>
                                    <th>Credits</th>
                                    <th>Program Duration</th> -->
                                    <th>Admission Status</th>
                                    <th>Total Cost $ (This Year)</th>
                                    <th>Cost-sharing Status</th>
                                    <th>Shortfall $ (Per Year)</th>
                                    <th>Reply Deadline</th>
                                    <th class="text-center sticky-action">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php //echo '<pre>';print_r($submission_results);die;?>
                                <?php $no=1; foreach ($submission_results['submission_plan'] as $submission_result) : ?>
                                    <tr style="background-color: #f9f9f9;">
                                        <td class="sticky-no"><?= $no ?></td>
                                        <td>
                                            <a href="javascript:void(0);" 
                                            class="btn-univ-detail"
                                            data-degree="<?= $submission_result->degree_level; ?>"
                                            data-major="<?= $submission_result->major; ?>"
                                            data-specialization="<?= $submission_result->specialization; ?>"
                                            data-credit="<?= $submission_result->credits; ?>"
                                            data-duration="<?= $submission_result->program_duration; ?>">
                                                <?= $submission_result->university_name; ?>
                                            </a>
                                            <?php if($submission_result->note) { ?>
                                            <!-- <br />
                                            <a data-note="<?= htmlspecialchars($submission_result->note, ENT_QUOTES, 'UTF-8') ?>" class="btn btn-xs btn-primary mt-3" onclick="showNote(this)">Admission Conditions</a> -->
                                            <?php } ?>
                                        </td>
                                        <!-- <td><?= $submission_result->degree_level; ?></td>
                                        <td><?= $submission_result->major; ?></td>
                                        <td><?= $submission_result->specialization; ?></td>
                                        <td><?= $submission_result->credits; ?></td>
                                        <td><?= $submission_result->program_duration; ?></td> -->
                                        <td>
                                            <?php 
                                                if($submission_result->status_result == 'Rejected' || $submission_result->status_result == 'Cancelled' || $submission_result->status_result == 'Withdrawn'){
                                                    $span = 'text-danger';
                                                }else if($submission_result->status_result == 'Pending Decision' || $submission_result->status_result == 'Waitlisted' || $submission_result->status_result == ''){
                                                    $span = '';
                                                }else{
                                                    $span = 'text-primary';
                                                }
    
                                                if($submission_result->status_result == 'Pending Decision'){
                                                    $submission_result->status_result = 'Pending';
                                                }
                                            ?>
                                            <span class="<?= $span ?>">
                                                <?= $submission_result->status_result ?? 'Pending'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-primary">
                                                <?= $submission_result->final_cost_university && $submission_result->show_detail ? 
                                                (($grantee_grant->grant_award > $submission_result->final_cost_university || $grantee_grant->grant_award == $submission_result->final_cost_university) || $submission_result->sortfall_covered ? 
                                                    'Within the Grant' : number_format($submission_result->final_cost_university)) : '' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-primary">
                                                <?= $submission_result->show_detail ? $submission_result->cost_sharing : ''; ?>
                                            </span>
                                        </td>
                                        <td><?= ($grantee_grant->grant_award > $submission_result->final_cost_university || $submission_result->sortfall_covered) ? '' : ($submission_result->show_detail ? ($submission_result->final_cost_university - $grantee_grant->grant_award ? '<span class="text-danger">'.number_format($submission_result->final_cost_university - $grantee_grant->grant_award).'</span>' : '') : '') ?></td>
                                        <td>
                                            <span class="text-danger">
                                                <?= $submission_result->replay_deadline && $submission_result->show_detail  ? date('d-M-Y', strtotime($submission_result->replay_deadline)) : ''; ?>
                                            </span>
                                        </td>
                                        <td class="text-center sticky-action">
                                            <?php if($submission_result->status_result == 'Rejected' && $submission_result->rejection_letter) {?>
                                                <a class="btn btn-default btn-xs lightbox" href="<?= base_url($submission_result->rejection_letter) ?>">Rejection Letter</a>
                                            <?php } ?>
                                            <?php if($submission_result->final_cost_university) { ?>
                                            <?php if(($submission_result->status_result == 'Admitted'|| $submission_result->status_result == 'Conditional') && !$selected_univ) { ?>
                                            <?php //if($grantee_grant->grant_award < $submission_result->final_cost_university) { ?>
                                                <!-- <a href="<?= base_url('grantee/submission_result/edit/'.$this->session->userdata('grantee_grant_id').'/'.$submission_result->id.'/'.$submission_result->flag) ?>" class="btn btn-default btn-xs">Support Leter</a> -->
                                            <?php //} ?>
                                            <button 
                                                class="btn btn-xs btn-primary btn-choose" 
                                                data-id="<?= $submission_result->id ?>" 
                                                data-u-name = "<?= $submission_result->university_name; ?>"
                                                data-flag = "<?= $submission_result->flag ?>"
                                                data-grantee_grant_id = "<?= $grantee_grant->id ?>"
                                                data-sortfall = "<?= ($grantee_grant->grant_award < $submission_result->final_cost_university) && !$submission_result->sortfall_covered ?>"
                                            >Approve
                                            </button>
                                            <button 
                                                class="btn btn-danger btn-xs btn-withdrawn"
                                                data-id="<?= $submission_result->id ?>" 
                                                data-flag = "<?= $submission_result->flag ?>"
                                                data-university = "<?= $submission_result->university_name ? true : false ?>" 
                                            >
                                                Reject
                                            </button>
                                            <?php } ?>
                                            <?php } ?>
                                            <?php //if($grantee_grant->submission_result_flag == 'submission_plan' && $submission_result->id == $grantee_grant->submission_result_id) { ?>
                                            <?php if($selected_univ && $submission_result->is_selected) { ?>
                                            <b class="text-success">Approve</b>
                                            <?php if($submission_result->status_bank_statement == 'Revise') { ?>
                                            <br />
                                            <a href="<?= base_url('grantee/profile/upload_bank_statement/'.$grantee_grant->id.'/'.$submission_result->id.'/submission_plan') ?>" class="btn btn-warning btn-xs">Revise Bank Statement</a>
                                            <?php } ?>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php if($submission_result->note) { ?>
                                    <tr>
                                        <td></td>
                                        <td colspan="1"><b>Admission Conditions : </b></td>
                                        <td colspan="6"><?= nl2br(htmlspecialchars($submission_result->note, ENT_QUOTES, 'UTF-8')) ?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if($submission_result->cost_sharing_detail) { ?>
                                    <tr>
                                        <td></td>
                                        <td colspan="1"><b>Cost Sharing Details : </b></td>
                                        <td colspan="6"><?= nl2br(htmlspecialchars($submission_result->cost_sharing_detail, ENT_QUOTES, 'UTF-8')) ?></td>
                                    </tr>
                                    <?php } ?>
                                <?php $no++; endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="alert alert-info" role="alert">
                        Note: Submit your final decision within 1 week (5 working days) prior to the actual deadline, otherwise it will be automatically withdrawn.
                    </div>

                    <?php if($submission_results['direct_application']) { ?>
                    <p style="font-weight:bold;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> Direct Application Result</p>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="sticky-no">No</th>
                                    <th width="15%">University</th>
                                    <!-- <th>Degree</th>
                                    <th>Major</th>
                                    <th>Specialization</th>
                                    <th>Credits</th>
                                    <th>Program Duration</th> -->
                                    <th>Admission Status</th>
                                    <th>Total Cost $ (This Year)</th>
                                    <th>Cost-sharing Status</th>
                                    <th>Shortfall $ (Per Year)</th>
                                    <th>Reply Deadline</th>
                                    <th class="text-center sticky-action">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach ($submission_results['direct_application'] as $submission_result) : ?>
                                    <tr style="background-color: #f9f9f9;">
                                        <td class="sticky-no"><?= $no ?></td>
                                        <td>
                                            <a href="javascript:void(0);" 
                                            class="btn-univ-detail"
                                            data-degree="<?= $submission_result->degree_level; ?>"
                                            data-major="<?= $submission_result->major; ?>"
                                            data-specialization="<?= $submission_result->specialization; ?>"
                                            data-credit="<?= $submission_result->credits; ?>"
                                            data-duration="<?= $submission_result->program_duration; ?>">
                                                <?= $submission_result->university_name; ?>
                                            </a>
                                            <?php if($submission_result->note) { ?>
                                            <!-- <br />
                                            <a data-note="<?= htmlspecialchars($submission_result->note, ENT_QUOTES, 'UTF-8') ?>" class="btn btn-xs btn-primary mt-3" onclick="showNote(this)">Note</a> -->
                                            <?php } ?>
                                        </td>
                                        <!-- <td><?= $submission_result->degree_level; ?></td>
                                        <td><?= $submission_result->major; ?></td>
                                        <td><?= $submission_result->specialization; ?></td>
                                        <td><?= $submission_result->credits; ?></td>
                                        <td><?= $submission_result->program_duration; ?></td> -->
                                        <td>
                                            <?php 
                                                if($submission_result->status_result == 'Rejected' || $submission_result->status_result == 'Cancelled' || $submission_result->status_result == 'Withdrawn'){
                                                    $span = 'text-danger';
                                                }else if($submission_result->status_result == 'Pending Decision' || $submission_result->status_result == 'Waitlisted' || $submission_result->status_result == ''){
                                                    $span = '';
                                                }else{
                                                    $span = 'text-primary';
                                                }
    
                                                if($submission_result->status_result == 'Pending Decision'){
                                                    $submission_result->status_result = 'Pending';
                                                }
                                            ?>
                                            <span class="<?= $span ?>">
                                                <?= $submission_result->status_result ?? 'Pending'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-primary">
                                                <?= $submission_result->final_cost_university && $submission_result->show_detail ? 
                                                (($grantee_grant->grant_award > $submission_result->final_cost_university || $grantee_grant->grant_award == $submission_result->final_cost_university) || $submission_result->sortfall_covered ? 
                                                    'Within the Grant' : number_format($submission_result->final_cost_university)) : '' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-primary">
                                                <?= $submission_result->show_detail ? $submission_result->cost_sharing : ''; ?>
                                            </span>
                                        </td>
                                        <td><?= ($grantee_grant->grant_award > $submission_result->final_cost_university || $submission_result->sortfall_covered) ? '' : ($submission_result->show_detail ? '<span class="text-danger">'.number_format($submission_result->final_cost_university - $grantee_grant->grant_award).'</span>' : '') ?></td>
                                        <td>
                                            <span class="text-danger">
                                                <?= $submission_result->replay_deadline && $submission_result->show_detail  ? date('d-M-Y', strtotime($submission_result->replay_deadline)) : ''; ?>
                                            </span>
                                        </td>
                                        <td class="text-center sticky-action">
                                            <?php if($submission_result->status_result == 'Rejected') {?>
                                                <a class="btn btn-default btn-xs lightbox" href="<?= base_url($submission_result->rejection_letter) ?>">Rejection Letter</a>
                                            <?php } ?>
                                            <?php if(!$selected_univ) { ?>
                                                <a href="<?= base_url('grantee/submission_result/edit/'.$this->session->userdata('grantee_grant_id').'/'.$submission_result->id.'/'.$submission_result->flag) ?>" class="btn btn-default btn-xs">Edit</a>
                                            <?php } ?>
                                            <?php if(($submission_result->status_result == 'Admitted' || $submission_result->status_result == 'Conditional') && $submission_result->is_authorize && !$selected_univ) { ?>
                                            <button 
                                                class="btn btn-xs btn-primary btn-choose" 
                                                data-id="<?= $submission_result->id ?>" 
                                                data-u-name = "<?= $submission_result->university_name; ?>"
                                                data-flag = "<?= $submission_result->flag ?>"
                                                data-grantee_grant_id = "<?= $grantee_grant->id ?>"
                                                data-sortfall = "<?= ($grantee_grant->grant_award < $submission_result->final_cost_university) && !$submission_result->sortfall_covered ?>"
                                            >Approve
                                            </button>
                                            <button 
                                                class="btn btn-danger btn-xs btn-withdrawn"
                                                data-id="<?= $submission_result->id ?>" 
                                                data-flag = "<?= $submission_result->flag ?>"
                                                data-university = "<?= $submission_result->university_name ?>"
                                            >
                                                Reject
                                            </button>
                                            <?php } ?>
                                            <?php if($selected_univ && $submission_result->is_selected) { ?>
                                            <b class="text-success">Approve</b>
                                            <?php if($submission_result->status_bank_statement == 'Revise') { ?>
                                            <br />
                                            <a href="<?= base_url('grantee/profile/upload_bank_statement/'.$grantee_grant->id.'/'.$submission_result->id.'/'.$submission_result->flag) ?>" class="btn btn-warning btn-xs">Revise Bank Statement</a>
                                            <?php } ?>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php if($submission_result->note) { ?>
                                    <tr>
                                        <td></td>
                                        <td colspan="1"><b>Admission Conditions : </b></td>
                                        <td colspan="6"><?= nl2br(htmlspecialchars($submission_result->note, ENT_QUOTES, 'UTF-8')) ?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if($submission_result->cost_sharing_detail) { ?>
                                    <tr>
                                        <td></td>
                                        <td colspan="1"><b>Cost Sharing Details : </b></td>
                                        <td colspan="6"><?= nl2br(htmlspecialchars($submission_result->cost_sharing_detail, ENT_QUOTES, 'UTF-8')) ?></td>
                                    </tr>
                                    <?php } ?>
                                <?php $no++; endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <!-- </div> -->
</div>

<div class="modal fade bs-example-modal-sm" id="mdl_confirm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="text-center">Are you sure that you want to approve <b id="u-name"></b> as your final placement?</h4>
            </div>
            <div class="modal-body">
                <div class="row" id="section_reason_rejection">
                    <div class="col-lg-12">
                        <div class="form-group">
				            <!-- <label>Reason of Rejection <span class="text-danger">*</span></label> -->
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="radioShortfall" id="radioShortfall_false" onclick="setButtonConfirm(this)" value="0">
                                <label class="form-check-label" for="radioShortfall_false">
                                    Admitted Without Shortfall
                                </label>
                                </div>
                                <div class="form-check">
                                <input class="form-check-input" type="radio" name="radioShortfall" id="radioShortfall_true" onclick="setButtonConfirm(this)" value="1">
                                <label class="form-check-label" for="radioShortfall_true">
                                    Admitted With Shortfall
                                </label>
                            </div>
                            <input type="hidden" id="sortfall_radio">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-success btn-disabled" id="btn-yes" disabled>Yes <span id="seconds"></span></button>
                <button type="button" class="btn btn-danger btn-disabled" data-dismiss="modal" disabled>No</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUniv" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">University Detail</h5>
      </div>
      <div class="modal-body">
        <div class="panel panel-body">
            <div class="row">
                <div class="col-lg-3">Degree</div>
                <div class="col-lg-9">: <span id="m_degree"></span></div>
                
                <div class="col-lg-3">Major</div>
                <div class="col-lg-9">: <span id="m_major"></span></div>
        
                <div class="col-lg-3">Specialization</div>
                <div class="col-lg-9">: <span id="m_specialization"></span></div>
        
                <div class="col-lg-3">Credits</div>
                <div class="col-lg-9">: <span id="m_credit"></span></div>
        
                <div class="col-lg-3">Program Duration</div>
                <div class="col-lg-9">: <span id="m_duration"></span></div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>