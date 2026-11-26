<?php
$default_tab_active = 'class="active"';
$default_content_active = 'active in';

if ($pid != '') {
    $default_tab_active = '';
    $default_content_active = '';
}
?>

<style>
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
<?php if($grantee_grant->submission_result_id) { ?>
        <div class="col-lg-12" style="margin-bottom:10px">
            <ul class="nav nav-pills">
                <li id="li_university" <?php echo $default_tab_active ?>><a data-toggle="tab" href="#university" aria-expanded="true">University</a></li>
                <li id="li_allowance"><a data-toggle="tab" href="#allowance" aria-expanded="true">Allowance</a></li>
            </ul>
        </div>

        <div class="tab-content">
            <div id="university" class="tab-pane fade <?= $default_content_active ?>">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>University</label>
                                        <input type="text" class="form-control" value="<?= $submission_result->university_name ? $submission_result->university_name : '' ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea name="address" rows="4" class="form-control" readonly><?= $submission_result->address ? $submission_result->address : '' ?></textarea>
                                    </div>
                                    <div class="form-group"> 
                                        <label>Department</label>
                                        <input class="form-control" readonly name="department" value="<?= $submission_result->department ? $submission_result->department : '' ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Degree Level</label>
                                        <input class="form-control" readonly name="degree_level" value="<?= $submission_result->degree_level ? $submission_result->degree_level : '' ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Major</label>
                                        <input class="form-control" readonly name="major" value="<?= $submission_result->major ? $submission_result->major : '' ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Specialization</label>
                                        <input class="form-control" readonly name="specialization" value="<?= $submission_result->specialization ? $submission_result->specialization : '' ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Program Duration</label>
                                        <input class="form-control" readonly name="program_duration" value="<?= $submission_result->program_duration ? $submission_result->program_duration : '' ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>University Website</label>
                                        <input class="form-control" readonly name="link" value="<?= $submission_result->link ? $submission_result->link : '' ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Note</label>
                                        <textarea name="note" rows="4" class="form-control" readonly><?= $submission_result->note ? $submission_result->note : '' ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Support Letter</label>
                                        <?php if ($submission_result->support_letter != '') { ?>
                                            <div style="margin-bottom:10px; position:relative; width:100px;">
                                                <a href="<?php echo base_url() ?><?php echo $submission_result->support_letter ?>" class="lightbox"><img height="100" src="<?php echo get_preview($submission_result->support_letter); ?>"></a>
                                                <a href="<?= base_url($submission_result->support_letter) ?>" download title="Click to Download" class="btn btn-primary btn-xs" style="position:absolute; top:0; right:0;">
                                                    <i class="fa fa-download fa-fw text-white"></i>
                                                </a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <label>LoA</label>
                                        <?php if ($submission_result->loa != '') { ?>
                                            <div style="margin-bottom:10px; position:relative; width:100px;">
                                                <a href="<?php echo base_url() ?><?php echo $submission_result->loa ?>" class="lightbox"><img height="100" src="<?php echo get_preview($submission_result->loa); ?>"></a>
                                                <a href="<?= base_url($submission_result->loa) ?>" download title="Click to Download" class="btn btn-primary btn-xs" style="position:absolute; top:0; right:0;">
                                                    <i class="fa fa-download fa-fw text-white"></i>
                                                </a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="allowance" class="tab-pane fade">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <table width="100%">
                                        <tr>
                                            <td width="50%"></td>
                                            <td class="text-center"><label>Aminef Allowance</label></td>
                                            <!-- <td class="text-center"><label>Actual Spend</label></td> -->
                                        </tr>
                                        <tr>
                                            <td><label>Settling in Allowance</label></td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-addon">$</div>
                                                    <input style="z-index: 0" type="text" class="form-control" value="<?= number_format($data_period->settling_allowance) ?>" readonly>
                                                </div>
                                            </td>
                                            <!-- <td>
                                                <div class="input-group">
                                                    <div class="input-group-addon">$</div>
                                                    <input style="z-index: 0" class="form-control actual" id="actual-settling" value="<?= $grantee_grant->actual_settling != 0 ? number_format($grantee_grant->actual_settling) : '' ?>">
                                                </div>
                                            </td> -->
                                        </tr>
                                        <tr>
                                            <td><label>Computer/Technology Allowance</label></td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-addon">$</div>
                                                    <input style="z-index: 0" type="text" class="form-control" value="<?= number_format($data_period->technology_allowance) ?>" readonly>
                                                </div>
                                            </td>
                                            <!-- <td>
                                                <div class="input-group">
                                                    <div class="input-group-addon">$</div>
                                                    <input style="z-index: 0" class="form-control actual" id="actual-technology" value="<?= $grantee_grant->actual_technology != 0 ? number_format($grantee_grant->actual_technology) : '' ?>">
                                                </div>
                                            </td> -->
                                        </tr>
                                        <tr>
                                            <td><label>Travel Allowance</label></td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-addon">$</div>
                                                    <input style="z-index: 0" type="text" class="form-control" value="<?= number_format($data_period->travel_allowance) ?>" readonly>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="30%"><label>Total Allowance</label></td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-addon">$</div>
                                                    <input style="z-index: 0" type="text" class="form-control" id="total-allowance" value="<?= number_format($data_period->settling_allowance + $data_period->technology_allowance + $data_period->travel_allowance) ?>" readonly>
                                                </div>
                                            </td>
                                            <!-- <td>
                                                <div class="input-group">
                                                    <div class="input-group-addon">$</div>
                                                    <?php 
                                                        $total_actual = $grantee_grant->actual_settling + $grantee_grant->actual_technology; 
                                                    ?>
                                                    <input style="z-index: 0" type="text" class="form-control" id="actual-total" value="<?= $total_actual != 0 ? number_format($total_actual) : '' ?>" readonly>
                                                </div>
                                            </td> -->
                                        </tr>
                                        <!-- <tr>
                                            <td width="30%"><label>Overpaid</label></td>
                                            <td>
                                                <?php 
                                                    $overpaid = $total_actual - ($data_period->settling_allowance + $data_period->technology_allowance); 
                                                ?>
                                                <div class="input-group">
                                                    <div class="input-group-addon">$</div>
                                                    <input style="z-index: 0" type="text" class="form-control" id="overpaid" value="<?= $overpaid != 0 ? str_replace('-', '', number_format($overpaid)) : '' ?>" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-primary" id="btn-allowance">Submit Allowance</button>
                                                <img src="<?php echo base_url() ?>/img/loading.gif" id="load-allowance" style="display:none;">
                                            </td>
                                        </tr> -->
                                    </table>
                                </div>
                            </div>
                            <hr>
                            <!-- <div class="row">
                                <div class="col-lg-4">
                                    <input type="file" id="input-file" name="invoice_allowance[]" multiple class="form-control">
                                    <button class="btn btn-primary mt-2" type="button" id="btn-invoice">Upload Invoice</button>
                                    <img src="<?php echo base_url() ?>/img/loading.gif" id="load-upload" style="display:none;">
                                </div>
                            </div> -->
                            <div class="row mt-5">
                                <div class="col-lg-12">
                                    <div class="wrap-invoice">
                                        <?php foreach($data_invoice as $key => $d_i) { 
                                                $nameFile = end(explode('/', $d_i->file));
                                                $fileName = end(explode('/', $d_i->file));
                                                if(strlen($fileName) > 15){
                                                    $fileName = substr($fileName, 0, 15) . '....';
                                                }
                                        ?>
                                        <div class="col-lg-3 img-col" style="height: 150px;">
                                            <a href="<?= base_url($d_i->file) ?>" class="lightbox"><img height="100" src="<?php echo get_preview($d_i->file); ?>"></a>
                                            <!-- <a href="javascript:;" onclick="del_item(this, 'img-col', <?= $d_i->id ?>)" class="btn btn-danger btn-xs" style="position:absolute; top:25px;">
                                                <i class="fa fa-trash fa-fw text-white"></i>
                                            </a> -->
                                            <a href="<?= base_url($d_i->file) ?>" download title="Click to download" class="btn btn-primary btn-xs" style="position:absolute; top:0; ">
                                                <i class="fa fa-download fa-fw text-white"></i>
                                            </a>
                                            <p class="filename" style="font-size:16px;cursor:pointer;" data-toggle="tooltip" data-placement="left" title="<?= $nameFile ?>"><?= $fileName ?></p>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php }else {?>
    <!-- <div id="submission-result" class="tab-pane fade"> -->
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table table-striped table-responsive">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>University</th>
                                <th>Program Duration</th>
                                <th>Status</th>
                                <th>Total Cost $ (This Year)</th>
                                <th>Cost-sharing Status</th>
                                <th>Shortfall $ (Per Year)</th>
                                <th>Reply Deadline</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach ($submission_results as $submission_result) : ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= $submission_result->university_name; ?></td>
                                    <td><?= $submission_result->program_duration; ?></td>
                                    <td>
                                        <?php 
                                            if($submission_result->status_result == 'Rejected'){
                                                $span = 'text-danger';
                                            }else if($submission_result->status_result == 'Pending'){
                                                $span = '';
                                            }else{
                                                $span = 'text-primary';
                                            }
                                        ?>
                                        <span class="<?= $span ?>">
                                            <?= $submission_result->status_result; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-primary">
                                            <?= $submission_result->final_cost_university && $submission_result->show_detail ? 
                                            ($grantee_grant->grant_award > $submission_result->final_cost_university  ? 
                                                'Within the Grant' : number_format($submission_result->final_cost_university)) : '' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-primary">
                                            <?= $submission_result->show_detail ? $submission_result->cost_sharing : ''; ?>
                                        </span>
                                    </td>
                                    <td><?= ($grantee_grant->grant_award > $submission_result->final_cost_university) ? '' : ($submission_result->show_detail ? '<span class="text-danger">'.number_format($submission_result->final_cost_university - $grantee_grant->grant_award).'</span>' : '') ?></td>
                                    <td>
                                        <span class="text-danger">
                                            <?= $submission_result->replay_deadline && $submission_result->show_detail  ? date('d-M-Y', strtotime($submission_result->replay_deadline)) : ''; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if($submission_result->status_result == 'Admitted') { ?>
                                        <button 
                                            class="btn btn-xs btn-primary btn-choose" 
                                            data-id="<?= $submission_result->id ?>" 
                                            data-u-name = "<?= $submission_result->university_name; ?>"
                                            data-flag = "<?= $submission_result->flag ?>"
                                        >Choose
                                        </button>
                                        <?php } ?>
                                </td>
                                </tr>
                            <?php $no++; endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <!-- </div> -->
<?php }?>
</div>

<div class="modal fade bs-example-modal-sm" id="mdl_confirm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="text-center">Are you sure you want to choose <b id="u-name"></b> ?</h4>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-danger btn-disabled" data-dismiss="modal" disabled>No</button>
                <button type="button" class="btn btn-success btn-disabled" id="btn-yes" disabled>Yes <span id="seconds"></span></button>
            </div>
        </div>
    </div>
</div>