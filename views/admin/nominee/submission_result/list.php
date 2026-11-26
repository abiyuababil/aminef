<style>
    /* .swal2-show {
        width: 90% !important;
    } */
    /* .table-nowrap th,
    .table-nowrap td {
        white-space: nowrap;
    } */
    .note-row td {
        background: #f9f9f9;
        padding: 10px 15px;
    }

    .note-row b {
        display: inline-block;
        min-width: 200px;
    }


    th.sticky-check,
    td.sticky-check {
        position: sticky;
        left: 0;
        background: #fff;
        z-index: 6;
    }

    th.sticky-no,
    td.sticky-no {
        position: sticky;
        left: 29px; /* lebar checkbox */
        background: #fff;
        z-index: 5;
    }

    th.sticky-univ,
    td.sticky-univ {
        position: sticky;
        left: 50px; /* 50 + lebar No */
        background: #fff;
        z-index: 5;
    }

    /* Action (kanan) */
    th.sticky-action,
    td.sticky-action {
        position: sticky;
        right: 0;
        background: #fff;
        z-index: 5;
    }
</style>
<?php if(!$is_alumni_page){ ?>
<div class="row">
    <div class="col-lg-12">
        <h1><?= get_full_name($grantee_grant) ?></h1>
        <h3 class="page-header">
            <?=$grantee_grant->grant_name ?> - <?= $grantee_grant->fiscal_year_period ?>
        </h3>
    </div>
</div>
<?php } ?>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <form id="frm_manage" method="GET">
            <?php if(!$is_alumni_page){ ?>
            <div class="data-header clearfix form-inline">
                <div class="pull-left">
                    <div id="frm-action" class="btn-group" role="group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:;" data-action="delete">Delete</a></li>
                        </ul>
                        <input type="hidden" name="action" value="" disabled="disabled">
                    </div>

                    Show :
                    <select class="form-control input-sm" name="limit" onchange="document.forms.frm_manage.submit()">
                        <?php
                        foreach ($limit_options as $lo) {
                            $selected = '';
                            if ($lo == $paging['limit']) $selected = 'selected';
                        ?>
                            <option value="<?php echo $lo ?>" <?php echo $selected ?>><?php echo $lo ?></option>
                        <?php } ?>
                    </select>
                    entries
                </div>
                <div class="pull-right">
                    Search : <input type="search" class="form-control input-sm" name="search" value="<?php echo $paging['search'] ?>" placeholder="">
                </div>
            </div>
            <?php } ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <?php if(!$is_alumni_page){ ?>
                            <th class="sticky-check"><input type="checkbox" class="chk-all"></th>
                            <?php } ?>
                            <th class="text-left sticky-no">#</th>
                            <th class="sticky-univ">University</th>
                            <th width="10%">Came From</th>
                            <!-- <th>Degree</th>
                            <th>Major</th>
                            <th>Specialization</th>
                            <th>Credits</th>
                            <th>Program Duration</th> -->
                            <th>Admission Status</th>
                            <th>Total Cost $ (This Year)</th>
                            <th>Cost-sharing Status</th>
                            <th>Saving $ (Per Year)</th>
                            <th>Shortfall $ (Per Year)</th>
                            <th>Reply Deadline</th>
                            <th>Selected Final Placement</th>
                            <?php if(!$is_alumni_page){ ?>
                            <th class="text-center sticky-action">Action</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data) {
                            $no = 1;
                            foreach ($data as $row) { 
                        ?>
                            <tr>
                                <?php if(!$is_alumni_page){ ?>
                                <td class="sticky-check"><input type="checkbox" class="chk-row" name="ids[]" value="<?php echo $row->id ?>"></td>
                                <?php } ?>
                                <td class="sticky-no"><?php  echo $no++ ?></td>
                                <td class="sticky-univ">
                                    <a href="javascript:void(0);" 
                                    class="btn-univ-detail"
                                    data-degree="<?= $row->degree_level; ?>"
                                    data-major="<?= $row->major; ?>"
                                    data-specialization="<?= $row->specialization; ?>"
                                    data-credit="<?= $row->credits; ?>"
                                    data-duration="<?= $row->program_duration; ?>">
                                        <?= $row->university_name; ?>
                                    </a>
                                    <?php if($row->note) { ?>
                                    <!-- <br />
                                    <a data-note="<?= htmlspecialchars($row->note, ENT_QUOTES, 'UTF-8') ?>" class="btn btn-xs btn-primary mt-3" onclick="showNote(this)">Admission Conditions</a> -->
                                    <?php } ?>
                                </td>
                                <td><?php echo $row->flag == 'submission_plan' ? 'Submission Plan' : '<span class="text-success">Direct Application</span>' ?></td>
                                <!-- <td><?php echo $row->degree_level ?></td>
                                <td><?php echo $row->major ?></td>
                                <td><?php echo $row->specialization ?></td>
                                <td><?php echo $row->credits ?></td>
                                <td><?php echo $row->program_duration ?></td> -->
                                <td>
                                    <?php 
                                        if($row->status_result == 'Rejected' || $row->status_result == 'Cancelled' || $row->status_result == 'Withdrawn'){
                                            $span = 'text-danger';
                                        }else if($row->status_result == 'Pending Decision' || $row->status_result == 'Waitlisted' || $row->status_result == ''){
                                            $span = '';
                                        }else{
                                            $span = 'text-primary';
                                        }

                                        if($row->status_result == 'Pending Decision'){
                                            $row->status_result = 'Pending';
                                        }
                                    ?>
                                    <span class="<?= $span ?>">
                                        <?= $row->status_result ?? 'Pending'; ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-primary">
                                        <?= $row->final_cost_university ? number_format($row->final_cost_university) : '' ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-primary">
                                        <?= $row->cost_sharing; ?>
                                    </span>
                                </td>
                                <?php //echo '<pre>';print_r($grantee_grant);die; ?>
                                <td>
                                    <?= $row->final_cost_university ? ($grantee_grant->grant_award > $row->final_cost_university  ? 
                                    '<span class="text-primary">'.number_format($grantee_grant->grant_award - $row->final_cost_university).'</span>' : '')
                                    : '' 
                                    ?>
                                </td>
                                <td>
                                    <?= $row->final_cost_university ? ($grantee_grant->grant_award < $row->final_cost_university  ? 
                                    '<span class="text-danger">'.number_format($row->final_cost_university - $grantee_grant->grant_award).'</span>' : '')
                                    : '' 
                                    ?>
                                </td>
                                <td>
                                    <span class="text-danger">
                                        <?= $row->replay_deadline ? date('d-M-Y', strtotime($row->replay_deadline)) : ''; ?>
                                    </span>
                                </td>
                                <td><?= $row->is_selected ? 'Yes' : '' ?></td>
                                <?php if(!$is_alumni_page){ ?>
                                <td class="sticky-action">
                                    <?php if($row->is_selected && !$status_approve) { ?>
                                    <button 
                                        type="button"
                                        class="btn btn-xs btn-success btn-choose-admin" 
                                        data-id="<?= $row->id ?>" 
                                        data-flag = "<?= $row->flag ?>"
                                        data-grantee_grant_id = "<?= $grantee_grant_id ?>"
                                        data-university = "<?= $row->university_name; ?>"
                                        data-action="approve"
                                    >Approve
                                    </button>
                                    <button 
                                        type="button"
                                        class="btn btn-danger btn-xs btn-choose-admin"
                                        data-id="<?= $row->id ?>" 
                                        data-flag = "<?= $row->flag ?>"
                                        data-grantee_grant_id = "<?= $grantee_grant_id ?>"
                                        data-university = "<?= $row->university_name ?>"
                                        data-action="reject"
                                    >
                                        Reject
                                    </button>
                                    <?php } ?>
                                    <a href="#" data-id="<?= $row->id ?>" data-type="<?= $row->flag; ?>" data-toggle="modal" data-target="#viewData" class="view-data btn btn-info btn-xs">
                                        <i class="fa fa-search"></i> View
                                    </a>
                                    <a href="<?= site_url('admin/nominee/submission_result/edit/' . $grantee_grant_id . '/' . $row->id . '/' . $row->flag); ?>" class="view-data btn btn-primary btn-xs">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a href="#" data-id="<?= $row->id ?>" data-type="<?= $row->flag; ?>" data-toggle="modal" data-target="#viewLog" class="view-log btn btn-default btn-xs">
                                        <i class="fa fa-file"></i> Log Status
                                    </a>
                                </td>
                                <?php } ?>
                            </tr>
                            <?php if($row->note) { ?>
                            <tr>
                                <td></td>
                                <td colspan="2"><b>Admission Conditions : </b></td>
                                <td colspan="9"><?= nl2br(htmlspecialchars($row->note, ENT_QUOTES, 'UTF-8')) ?></td>
                            </tr>
                            <?php } ?>
                            <?php if($row->cost_sharing_detail) { ?>
                            <tr>
                                <td></td>
                                <td colspan="2"><b>Cost Sharing Details : </b></td>
                                <td colspan="9"><?= nl2br(htmlspecialchars($row->cost_sharing_detail, ENT_QUOTES, 'UTF-8')) ?></td>
                            </tr>
                            <?php } ?>
                        <?php }
                        } ?>

                    </tbody>
                </table>
                
            </div>
            <!-- /.table-responsive -->
            <?php if(!$is_alumni_page){ ?>
            <div class="pull-left">
                Showing <?php echo $paging['start_row'] ?> to <?php echo $paging['end_row'] ?> of <?php echo $paging['total_rows'] ?> entries
            </div>
            <!-- /.pagination info -->
            <?php echo $paging['html'] ?>
            <!-- /.pagination -->
            <input type="hidden" name="sort_by" value="<?php echo $sort_by ?>">
            <input type="hidden" name="sort" value="<?php echo $sort ?>">
            <?php } ?>
        </form>

    </div>

    <div class="col-lg-12">
        <div class="pull-right">
            <a href="<?= $back_url ?>" class="btn btn-primary">Back</a>
            <a href="#" data-id="<?= $grantee_grant_id ?>" data-section="candidate" class="btn btn-warning withdraw">Withdraw</a>
            <a href="#" data-id="<?= $grantee_grant_id ?>" data-section="candidate" class="btn btn-danger drop">Drop</a>
            <input type="hidden" id="data_section" value="submission_result">
        </div>
    </div>
</div>

<?php $this->load->view('admin/nominee/submission_result/view_popup') ?>
<?php $this->load->view('admin/nominee/submission_result/view_log') ?>
<?php $this->load->view('admin/partials/modal_confirm') ?>
<div class="modal fade text-center" id="mdl_detail_log" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-lg-6" id="old_data_section">
                        <div class="alert alert-warning">Old Data</div>                    
                    </div>
                    <div class="col-lg-6" id="new_data_section">
                        <div class="alert alert-info">New Data</div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6" id="old_data_section">
                        <div id="old-data">

                        </div>                       
                    </div>
                    <div class="col-lg-6" id="new_data_section">
                        <div id="new-data">
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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