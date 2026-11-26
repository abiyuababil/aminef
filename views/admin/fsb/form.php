<?php
$default_tab_active = 'class="active"';
$default_content_active = 'active in';
$pid = $this->input->get('pid');
if ($pid != '') {
    $default_tab_active = '';
    $default_content_active = '';
}
?>
<style>
    .is_unlimited_label {
        font-size: 13px;
        font-weight: inherit;
        font-style: italic;
        cursor: pointer;
        user-select: none
    }

    .require{
        color: red;
    }

    #memo_revision th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #ebebeb;
    color: #7da2bd;
    }

    .select2-results__options[aria-multiselectable="true"] li {
        padding-left: 30px;
        position: relative
    }

    .select2-results__options[aria-multiselectable="true"] li:before {
        position: absolute;
        left: 8px;
        opacity: .6;
        top: 6px;
        font-family: "FontAwesome";
        content: "\f0c8";
    }

    .select2-results__options[aria-multiselectable="true"] li[aria-selected="true"]:before {
        content: "\f14a";
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<?php if($this->session->flashdata('success_period')) { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= $this->session->flashdata('success_period') ?>
    </div>
<?php } ?>
<form id="form" role="form" method="POST" enctype="multipart/form-data">
    <?php if($data){ ?>
            <input type="hidden" class="form-control" id="fsb_id" name="fsb_id" value="<?= $data->id ?>">
    <?php } ?>
    <div class="row">
        <div class="alert alert-danger hide" id="error-alert">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <span id="label-alert"></span>
        </div>
        <div class="tab-content">
            <div id="pdo" class="tab-pane fade <?= $default_content_active ?>">
                <div class="col-lg-12">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Period/Fiscal Year</label>   
                            <select class="form-control select_multiselect" name="fiscal_year" id="fiscal_year">
                                <option value="">-- Select Year --</option>
                                <?php
                                $current_year = date('Y', strtotime('+2 years'));
                                //$limit_year = $current_year - 20;
                                $limit_year = 1952;
                                for ($year = $current_year; $year >= $limit_year; $year--) {
                                    $selected = '';
                                    if ($data->fiscal_year == $year) {
                                        $selected = 'selected="selected"';
                                    }
                                ?>
                                    <option value="<?php echo $year ?>" <?php echo $selected ?>><?php echo $year ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <div class="text-danger invalid-tooltip validation-error-fiscal" style="display:none;">Period/Fiscal Year is Required</div> 
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Program</label>
                            <img src="<?php echo base_url() ?>/img/loading.gif" id="load-grants" style="display:none;">
                            <select class="form-control select_multiselect" name="grants[]" multiple='multiple' id="grants" data-live-search="true">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-5">
                    <p style="font-weight:bold;margin-bottom:25px;">
                        <i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> List Grantee 
                        <img src="<?php echo base_url() ?>/img/loading.gif" id="load-list" style="display:none;">
                    </p>
                    <div class="wrap-table-list">
                        <?php if($list_participant) { ?>

                            <?php foreach ($list_participant as $key => $list) { 
                                    $active_grant_id = end(explode('|', $key));
                                    $active_grant_name = explode('|', $key);
                            ?>
                                <div class="col-lg-12 pull-left mb-2">
                                    <h3><?= $active_grant_name[0] ?></h3>
                                    Total Grantee : <?= count($list) ?> 
                                </div>
                                
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>FSB Approval</label>
                                        <?php if($fsb_approval[$active_grant_id] != '') { ?>
                                        <div style="margin-bottom:25px; position:relative; width:100px; margin-top: 25px;">
                                            <a href="<?php echo base_url() ?><?php echo $fsb_approval[$active_grant_id] ?>" class="lightbox" aria-haspopup="dialog">
                                                <img height="100" src="<?php echo get_preview($fsb_approval[$active_grant_id]); ?>">
                                            </a>
                                            <a href="<?= base_url($fsb_approval[$active_grant_id]) ?>" download title="Click to Download" class="btn btn-primary btn-xs" style="position:absolute;top:0;">
                                                <i class="fa fa-download fa-fw text-white"></i>
                                            </a>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <table class="table table-striped table-hover mb-5">
                                    <thead>
                                        <tr>
                                            <th width="30"><input type="checkbox" class="chk-all"></th>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Interview Date</th>
                                            <th>Score Interview</th>
                                            <th>Rank</th>
                                            <th>Final Rank</th>
                                            <th>Status</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <?php 
                                        $is_check = unserialize($data->grantee_grant_id);$no=1; foreach ($list as $key => $row) { 
                                        if(!$row->final_rank_interview_update){ continue; } // skip if final rank is empty
                                    ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="chk-row" <?= (isset($is_check[$active_grant_id]) && is_array($is_check[$active_grant_id]) && in_array($row->id, $is_check[$active_grant_id])) ? 'checked' : '' ?> name="ids[<?= $active_grant_id ?>][]" value="<?= $row->id ?>">
                                            </td>
                                            <td><?= $no ?></td>
                                            <td><a href="<?= base_url('admin/users_grantee/edit/'.$row->user_grantee_id) ?>" target="_blank"><?= get_full_name($row,"ID") ?></a></td>
                                            <td><?= date('d F Y H:i', strtotime($row->date_interview)) ?></td>
                                            <td><?= $row->score_interview ?></td>
                                            <td><?= $row->rank_interview_date_update ?></td>
                                            <td><?= $row->final_rank_interview_update ?></td>
                                            <td><?= $row->status_name ?></td>
                                            <td class="text-right">
                                                <button class="btn btn-primary btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-gear fa-fw"></i> <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right" style="top:auto">
                                                    <li>
                                                        <a href="#" data-id="<?= $row->id ?>" data-section="fsb" class="reject">Reject</a>
                                                    </li>
                                                    <li>
                                                        <a href="#" data-id="<?= $row->id ?>" data-section="fsb" class="withdraw">Withdraw</a>
                                                    </li>
                                                    <?php 
                                                        $field_tnc = $row->field_tnc ? explode(',', $row->field_tnc) : [];
                                                        $view_tnc = in_array('upload_tnc', $field_tnc) ? 1 : 0;
                                                        $tnc_approver = $view_tnc ? $row->tnc_approver == 1 ? 1 : 0 : 1;
                                                    ?>
                                                    <li>
                                                        <a href="#" data-id="<?= $row->id ?>" data-status="<?= $tnc_approver ?>" data-section="fsb" class="succesfully">Set to Nominee</a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    <?php $no++; } ?>
                                </table>
                                <hr>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>

                <div class="col-lg-12 mt-3 mb-5">
                    <div class="pull-right">
                        <a href="<?= base_url('admin/fsb/manage') ?>" class="btn btn-default">Back</a>
                        <?php if($data) { ?>
                            <button type="submit" value="edit" name="btn" class="btn btn-success btn-s-pdo-edit">Save</button>
                            <!-- <button type="submit" value="send_email" name="btn" class="btn btn-warning btn-send-email" onclick="return confirm('Are you sure?')">Send Email FSB</button> -->
                        <?php }else{?>
                            <button type="button" class="btn btn-success btn-s-pdo">Save</button>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
</form>
<!-- /.row -->


<?php $this->load->view('admin/partials/modal_confirm') ?>