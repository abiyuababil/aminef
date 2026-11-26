<style>
    .modal-content-eid {
        width: fit-content;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?= $page_title; ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>



<div class="modal fade bd-example-modal-lg" id="modal_view_eid" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View Detail Pending Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="">
                    <table class="table table-striped table-hover" id="table_view_eid" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th width="20%">Grants</th>
                                <th>Fiscal Year</th>
                                <th>Category</th>
                                <?php if ($this->active_cid == 1) { ?>
                                    <th>Sub Category</th>
                                <?php } ?>
                                <th>Total Payment</th>
                                <th>Payment Status</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<?php if($is_popup){ ?>
<div class="modal bd-example-modal-lg" id="modal_eid" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" width="100%">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pending Task <?= $data[0]->send_date ? format_date_time($data[0]->send_date) : '-' ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="">
                <table class="table table-striped table-hover text-center" id="table_eid" width="100%">
                    <thead>
                        <tr>
                            <th width="35" class="text-center">#</th>
                            <th <?= sorting_attribute('first_name', $sort_by, $sort) ?>>Name</th>
                            <th>Grants</th>
                            <th>Fiscal Year</th>
                            <th>Category</th>
                            <?php if($this->active_cid == 1) { ?>
                            <th>Sub Category</th>
                            <?php } ?>
                            <th>Total Payment</th>
                            <th <?= sorting_attribute('status_name', $sort_by, $sort) ?>>Payment Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data_all) {
                            $no = $paging['start_row'] ? $paging['start_row'] : 1;
                            foreach ($data_all as $row) {
                                $join_program = '';
                                $join_program .= '<ul>';

                                        $available_program = [];
                                        foreach ($row->programs as $key => $value) {
                                            $year_departure = '';
                                            if ($value['year_departure']) {
                                                $year_departure = " ({$value['year_departure']})";
                                            }

                                            if (!isset($available_program[$value['user_program_id']])) {
                                                $available_program[$value['user_program_id']] = 'Avail';
                                                $join_program .= '<li>' . $value['program_name'] . $year_departure . '</li>';
                                            }
                                        }
                                        $join_program .= '</ul>';

                                        $format = 'ID';
                                        if ($country_id == '2') {
                                            $format = 'US';
                                        }
                                        $fullname = $this->Grantee_ent_model->get_full_name($row, $format);

                                        $pid = '';
                                        if ($row->category == 'International Travel') {
                                            $pid = '?pid=travel';
                                        } elseif ($row->category == 'Grant Supporting') {
                                            $pid = '?pid=support';
                                        }
                                ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td class="text-left"><?= $fullname ?></td>
                                            <td class="text-left"><?= $row->program_name ?></td>
                                            <td class="text-left"><?= $row->fiscal_year ?></td>
                                            <td class="text-left"><?= $row->category ?></td>
                                            <?php if ($this->active_cid == 1) { ?>
                                                <td class="text-left"><?= $row->sub_category ?></td>
                                            <?php } ?>
                                            <td class="text-left"><?= $row->total_payment ? format_money($row->total_payment, 'USD') : 0 ?></td>
                                            <?php
                                            if ($row->status_name == 'Notify Finance') {
                                                $badge = 'warning';
                                            } elseif ($row->status_name == "Waiting for ED's Approval") {
                                                $badge = 'info';
                                            } elseif ($row->status_name == 'Released') {
                                                $badge = 'primary';
                                            } elseif ($row->status_name == 'On Hold') {
                                                $badge = 'danger';
                                            } else {
                                                $badge = 'success';
                                            }

                                            ?>
                                            <td class="text-left"><span class="badge badge-<?= $badge ?>"><?= $row->status_name ?></span></td>
                                        </tr>
                                <?php
                                        $no++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="close_modal_eid()" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <form id="frm-import-excel" method="POST" enctype="multipart/form-data" style="display:none">
            <input id="file-excel" type="file" name="file-excel">
        </form>

        <form id="form-exe" method="POST"></form>

        <form id="frm_manage" method="GET">
            <div id="wrap-filter" class="data-header clearfix form-inline">
                <div class="pull-left">
                    Search :
                    <input class="form-control input-sm" type="text" name="search" value="<?= $paging['search'] ?>" style="width:100px">
                    <?php $active_fiscal_year = $this->input->get('fiscal_year'); ?>
                    <?php if ($country_id == AMERICAN_DATABASE) { ?>
                        Fiscal Year :
                        <select class="form-control input-sm" name="fiscal_year" onchange="document.forms.frm_manage.program.value=''; document.forms.frm_manage.submit()">
                            <option value="" <?php echo $active_fiscal_year ? '' : 'selected'; ?>>All</option>
                            <?php
                            foreach ($fiscal_years as $fiscal_year) {
                                if (!is_numeric($fiscal_year->fiscal_year) || $fiscal_year->fiscal_year == 0) {
                                    continue;
                                }
                                $selected = '';
                                if ($active_fiscal_year == $fiscal_year->fiscal_year) {
                                    $selected = 'selected';
                                }
                            ?>
                                <option value="<?php echo $fiscal_year->fiscal_year ?>" <?php echo $selected; ?>><?php echo $fiscal_year->fiscal_year ?></option>
                            <?php } ?>
                        </select>
                    <?php } ?>
                    Grants :
                    <select class="form-control input-sm" name="program" onchange="document.forms.frm_manage.submit()" style="width:200px" <?php echo ($country_id == AMERICAN_DATABASE && !$active_fiscal_year) ? 'disabled' : ''; ?>>
                        <?php if ($country_id == AMERICAN_DATABASE && !$active_fiscal_year) { ?>
                            <option value="">Select fiscal year first</option>
                        <?php } else { ?>
                            <option value="">All</option>
                            <?php
                            foreach ($program_available as $pa) {
                                $selected = '';
                                if ($pa->id == $paging['program']) {
                                    $selected = 'selected';
                                }
                            ?>
                                <option value="<?= $pa->id ?>" <?= $selected ?>><?= $pa->name ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>


                    Status :
                    <select class="form-control input-sm" name="status" onchange="document.forms.frm_manage.submit()" style="width:100px">
                        <option value="">All</option>
                        <?php
                        foreach ($status as $st) {
                            $selected = '';
                            if ($st == $paging['status']) {
                                $selected = 'selected';
                            }
                        ?>
                            <option value="<?= $st ?>" <?= $selected ?>><?= $st ?></option>
                        <?php } ?>
                    </select>


                    Show :
                    <select class="form-control input-sm" name="limit" onchange="document.forms.frm_manage.submit()">
                        <?php
                        foreach ($limit_options as $lo) {
                            $selected = '';
                            if ($lo == $paging['limit']) {
                                $selected = 'selected';
                            }
                        ?>
                            <option value="<?= $lo ?>" <?= $selected ?>><?= $lo ?></option>
                        <?php } ?>
                    </select>
                </div>

                <!-- <div class="pull-right">
                    <?php if ($this->session->userdata('role') != 'executive') { ?>
                        <?php if (has_permission('pending_task', 'send_to_ed')) { ?>
                            <a href="javascript:;" id="btn-exe" class="btn btn-success" style="float:right;margin-left: 170px;">Send to Executive Director</a>
                        <?php } ?>
                    <?php } ?>
                </div> -->
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center">
                    <thead>
                        <tr>
                            <!-- <th width="30"><?php if ($this->session->userdata('role') != 'executive') { ?><input type="checkbox" class="chk-all"><?php } ?></th> -->
                            <th width="35" class="text-center">#</th>
                            <th <?= sorting_attribute('first_name', $sort_by, $sort) ?>>Name</th>
                            <th>Total Payment (USD)</th>
                            <th>Total Payment (IDR)</th>
                            <th>Grants</th>
                            <th>Fiscal Year</th>
                            <th>Category</th>
                            <?php if ($this->active_cid == 1) { ?>
                                <th>Sub Category</th>
                            <?php } ?>
                            <th <?= sorting_attribute('status_name', $sort_by, $sort) ?>>Payment Status</th>
                            <th <?= sorting_attribute('priority', $sort_by, $sort) ?>>Priority</th>
                            <th>Created Date</th>
                            <th <?= sorting_attribute('deadline_date', $sort_by, $sort) ?>>To be released on</th>
                            <th class="text-center" width="150px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data) {
                            $no = $paging['start_row'] ? $paging['start_row'] : 1;
                            foreach ($data as $row) {
                                $join_program = '';
                                $join_program .= '<ul>';

                                $available_program = [];
                                foreach ($row->programs as $key => $value) {
                                    $year_departure = '';
                                    if ($value['year_departure']) {
                                        $year_departure = " ({$value['year_departure']})";
                                    }

                                    if (!isset($available_program[$value['user_program_id']])) {
                                        $available_program[$value['user_program_id']] = 'Avail';
                                        $join_program .= '<li>' . $value['program_name'] . $year_departure . '</li>';
                                    }
                                }
                                $join_program .= '</ul>';

                                $format = 'ID';
                                if ($country_id == '2') {
                                    $format = 'US';
                                }

                                $bulkd_data_payment = get_bulk_data_payment($row->bulk_id, $row->is_payment_grant, $row->payment_for, $row->is_grant_cost);
                                $fullname = '';
                                if ((int) $row->bulk_id > 0 && count($bulkd_data_payment) > 1) {
                                    $fullname = '<ul style="margin:0px; padding:0px; list-style:none;">';
                                    foreach ($bulkd_data_payment as $payment) {
                                        $fullname .= '<li>' . $payment['full_name'] . '</li>';
                                    }
                                    $fullname .= '</ul>';
                                } else {
                                    $fullname = get_full_name($row, $format);
                                    if($row->is_payment_grant){
                                        $fullname = $row->first_name;
                                    }
                                }

                                $pid = '';
                                if ($row->category == 'International Travel') {
                                    $pid = '?pid=travel';
                                } elseif ($row->category == 'Grant Supporting') {
                                    $pid = '?pid=support';
                                }
                        ?>
                                <tr style="<?php echo $row->priority == 2 ? 'background-color:#dc35455e !important;' : ''; ?>">
                                    <td><?= $no ?></td>
                                    <td class="text-left" style="white-space:nowrap;">
                                        <?= $fullname != '' ? $fullname : 'Third Party' ?>
                                    </td>

                                    <td class="text-left" style="white-space:nowrap;">
                                        <?php if ($row->bulk_id > 0 && count($bulkd_data_payment) > 1) { ?>
                                            <ul style="margin:0; padding:0; list-style:none;">
                                                <?php $total_usd = 0; ?>
                                                <?php foreach ($bulkd_data_payment as $payment => $bulk_payment) { ?>
                                                    <?php $total_usd += $bulk_payment['total_usd']; ?>
                                                    <li><?= format_money($bulk_payment['total_usd'], 'USD'); ?></li>
                                                <?php } ?>
                                            </ul>
                                            <span style="border-bottom:1px solid black; font-weight:bold;">
                                                <?= format_money($total_usd, 'USD'); ?>
                                            </span>
                                        <?php } else { ?>
                                            <?= $row->total_payment ? format_money($row->total_payment, 'USD') : '' ?>
                                        <?php } ?>
                                    </td>

                                    <td class="text-left" style="white-space:nowrap;">
                                        <?php if ($row->bulk_id > 0 && count($bulkd_data_payment) > 1) { ?>
                                            <ul style="margin:0; padding:0; list-style:none;">
                                                <?php $total_idr = 0; ?>
                                                <?php foreach ($bulkd_data_payment as $payment => $bulk_payment) { ?>
                                                    <?php $total_idr += $bulk_payment['total_idr']; ?>
                                                    <li><?= format_money($bulk_payment['total_idr'], 'IDR'); ?></li>
                                                <?php } ?>
                                            </ul>
                                            <span style="border-bottom:1px solid black; font-weight:bold;">
                                                <?= format_money($total_idr, 'IDR'); ?>
                                            </span>
                                        <?php } else { ?>
                                            <?= $row->total_payment_idr ? format_money($row->total_payment_idr, 'IDR') : '' ?>
                                        <?php } ?>
                                    </td>

                                    <td class="text-left"><?= $row->program_name ?></td>
                                    <td class="text-left"><?= $row->fiscal_year ?></td>
                                    <td class="text-left"><?= $row->category ?></td>
                                    <?php if ($this->active_cid == 1) { ?>
                                        <td class="text-left"><?= $row->sub_category ?></td>
                                    <?php } ?>
                                    <?php
                                    if ($row->status_name == 'Notify Finance') {
                                        $badge = 'warning';
                                    } elseif ($row->status_name == "Waiting for ED's Approval") {
                                        $badge = 'info';
                                    } elseif ($row->status_name == 'On Hold') {
                                        $badge = 'danger';
                                    } else {
                                        $badge = 'success';
                                    }

                                    ?>
                                    <td class="text-left"><span class="badge badge-<?= $badge ?>"><?= $row->status_name ?></span></td>
                                    <td class="text-left">
                                        <span class="badge badge-<?php echo $row->priority == 2 ? 'danger' : 'default'; ?>">
                                            <?php echo $row->priority == 2 ? 'Urgent' : 'Normal'; ?>
                                        </span>
                                    </td>
                                    
                                    <?php if ($this->active_cid == 123) { ?>
                                        <td class="text-center"><?= $row->invoice != '' ? '<a href="' . site_url($row->invoice) . '" target="_blank"><span class="badge badge-primary">View Invoice</span></a>' : '-' ?></td>
                                    <?php } ?>
                                    <td class="text-left"><?= $row->entry_date ? date('F j, Y', strtotime($row->entry_date)) : '-' ?></td>
                                    <td class="text-left">
                                        <?php
                                            echo (isset($row->deadline_date) && $row->deadline_date != '') ? date('F j, Y', strtotime($row->deadline_date)) : '-';
                                        ?>
                                    </td>
                                    <td class="text-left">
                                        <?php
                                        $status_selection     = [STATUS_NEW_SELECTION, STATUS_SELECTION_REVISED, STATUS_SELECTION_DECLINED, STATUS_SELECTION_VERIFIED, STATUS_WAITING_FOR_INTERVIEW, STATUS_INTERVIEW];
                                        $status_candidate     = [STATUS_SELECTION_SUCCESSFUL, STATUS_NEW_CANDIDATE, STATUS_CANDIDATE_REVISED, STATUS_CANDIDATE_DECLINED, STATUS_CANDIDATE_VERIFIED];
                                        $status_on_going     = [STATUS_CANDIDATE_SUCCESSFUL, STATUS_ON_GOING_RESIGN, STATUS_ON_GOING_REVISED];
                                        $status_returning     = [STATUS_RETURNING_SUCCESSFUL, STATUS_NEW_RETURNING, STATUS_RETURNING_REVISED, STATUS_SET_TO_ALUMNI];
                                        $id_grantee = 'admin/request_payment/edit/' . $row->user_grantee_id . '/' . $row->grantee_grant_id . $pid;
                                        if ($this->active_cid == 1) {
                                            if (in_array($row->status, $status_selection)) {
                                                $section_name = 'selection';
                                            } else if (in_array($row->status, $status_candidate)) {
                                                $section_name = 'candidate';
                                            } else if (in_array($row->status, $status_on_going)) {
                                                $section_name = 'on_going';
                                            } else if (in_array($row->status, $status_returning)) {
                                                $section_name = 'returning';
                                            }
                                            $id_grantee = 'admin/payment_record/payment/' . $section_name . '/' . $row->grantee_grant_id;
                                        }
                                        ?>
                                        <?php if ($row->executive_id && $this->session->userdata('role') != 'finance') { ?>
                                            <?php if (has_permission('pending_task', 'ed_approval')) { ?>
                                                <a href="<?= base_url('admin/executive/get_data/' . $row->executive_id . '/' . $row->slug) ?>" target="_blank" class="btn btn-danger btn-xs mr-2 mb-2 "> ED Approval</a>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php if ($this->session->userdata('role') != 'executive') { ?>
                                            <?php if (has_permission('pending_task', 'edit')) { ?>
                                                <?php if ($row->is_payment_grant || $row->is_grantee_payment) { ?>
                                                    <?php
                                                    $url = '/admin/user_grantee_grant/payment_grant/' . $row->grantee_grant_id;

                                                    if ($country_id == INDONESIAN_DATABASE) {
                                                        $url = 'admin/user_grantee_grant/edit_period/' . $row->grantee_grant_id . '/' . $row->period_id . '?pid=payment';
                                                    }
                                                    
                                                    ?>
                                                    <?php if ((int) $row->bulk_id > 0) {
                                                        if($country_id == INDONESIAN_DATABASE){
                                                            if ($row->payment_for == 'grantee') {
                                                                $url = 'admin/user_grantee_grant/edit_period/' . $row->grant_id . '/' . $row->period_id . '?pid=payment_grantee';
                                                            } else {
                                                                $url = 'admin/user_grantee_grant/edit_period/' . $row->grant_id . '/' . $row->period_id . '?pid=payment_bulk';
                                                            }
                                                        }else{
                                                            $url = '/admin/user_grantee_grant/payment_grant/' . $row->grantee_grant_id . '?pid=bulk_non_grantee';
                                                        }
                                                        
                                                    } ?>
                                                    
                                                    <a href="<?= base_url($url) ?>" target="_blank" class="btn btn-primary btn-xs mr-2 mb-2 "><i class="fa fa-edit"></i> Edit</a>
                                                <?php } else { ?>
                                                    <?php if ((int) $row->bulk_id > 0) {
                                                        if($country_id == INDONESIAN_DATABASE){
                                                            if ($row->payment_for == 'grantee') {
                                                                $id_grantee = 'admin/user_grantee_grant/edit_period/' . $row->grant_id . '/' . $row->period_id . '?pid=payment_grantee';
                                                            } else {
                                                                $id_grantee = 'admin/user_grantee_grant/edit_period/' . $row->grant_id . '/' . $row->period_id . '?pid=payment_bulk';
                                                            }
                                                        }else{
                                                            $pid = $row->category == 'Grant Cost' ? 'payment_grantee' : 'payment_support';
                                                            $id_grantee = '/admin/user_grantee_grant/payment_grant/' . $row->grant_id . '?pid=' . $pid;
                                                        }
                                                        
                                                    } ?>
                                                    <a href="<?= base_url($id_grantee) ?>" target="_blank" class="btn btn-primary btn-xs mr-2 mb-2 "><i class="fa fa-edit"></i> Edit</a>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php if ($row->is_grantee_payment) { ?>
                                            <!-- download grant payment -->
                                            <a href=<?= site_url('admin/pending_task/download_payment_grant/' . $row->id) ?> target="_blank" class="btn btn-default btn-xs mr-2 mb-2 "><i class="fa fa-file-pdf-o"></i> Download</a>
                                        <?php } else { ?>
                                            <?php
                                            $category = $row->category == 'Grant Cost' ? 'cost' : 'record';
                                            ?>
                                            <?php if (count($bulkd_data_payment) > 1) { ?>
                                                <div class="dropdown" style="display: block;">
                                                    <button class="btn btn-default btn-xs dropdown-toggle mr-2 mb-2 " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa fa-download"></i> Download <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <?php foreach ($bulkd_data_payment as $bulk_payment) { ?>
                                                            <li>
                                                                <a href="<?= site_url('admin/pending_task/download/' . $bulk_payment['user_grantee_id'] . '?payment=' . $bulk_payment['payment_id'] . '&category=' . $category) ?>" target="_blank">
                                                                    <i class="fa fa-file-pdf-o"></i> <?= $bulk_payment['full_name']; ?>
                                                                </a>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>

                                            <?php } else { ?>
                                                <a href=<?= site_url('admin/pending_task/download/' . $row->user_grantee_id . '?payment=' . $row->id . '&category=' . $category) ?> target="_blank" class="btn btn-default btn-xs mr-2 mb-2 "><i class="fa fa-file-pdf-o"></i> Download</a>
                                            <?php } ?>
                                        <?php } ?>

                                        <?php
                                        $has_proof = array_filter($bulkd_data_payment, function ($item) {
                                            return !empty($item['proof']);
                                        });
                                        ?>

                                        <?php if (count($has_proof) > 1) { ?>
                                            <div class="dropdown" style="display: block;">
                                                <button class="btn btn-default btn-xs dropdown-toggle mr-2 mb-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-download"></i> Proof of Transfer <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <?php foreach ($has_proof as $bulk_payment) { ?>
                                                        <?php if (!empty($bulk_payment['proof'])) { ?>
                                                        <li>
                                                            <a href="<?= base_url($bulk_payment['proof']) ?>" download target="_blank">
                                                                <?= $bulk_payment['full_name']; ?>
                                                            </a>
                                                        </li>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        <?php } else { ?>
                                            <?php if (!empty($row->proof)) { ?>
                                                <a href="<?= base_url($row->proof) ?>" download class="btn btn-default btn-xs mr-2 mb-2">
                                                    <i class="fa fa-download"></i> Proof of Transfer
                                                </a>
                                            <?php } ?>
                                        <?php } ?>


                                        <?php
                                        $has_proof_expense = array_filter($bulkd_data_payment, function ($item) {
                                            return !empty($item['proof_of_expense']);
                                        });
                                        ?>

                                        <?php if (count($has_proof_expense) > 1) { ?>
                                            <div class="dropdown" style="display: block;">
                                                <button class="btn btn-default btn-xs dropdown-toggle mr-2 mb-2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-download"></i> Proof of Expense <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <?php foreach ($has_proof_expense as $bulk_payment) { ?>
                                                        <?php if (!empty($bulk_payment['proof_of_expense'])) { ?>
                                                        <li>
                                                            <a href="<?= base_url($bulk_payment['proof_of_expense']) ?>" download target="_blank">
                                                                <?= $bulk_payment['full_name']; ?>
                                                            </a>
                                                        </li>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        <?php } else { ?>
                                            <?php if (!empty($row->proof_of_expense)) { ?>
                                                <a href="<?= base_url($row->proof_of_expense) ?>" download class="btn btn-default btn-xs mr-2 mb-2">
                                                    <i class="fa fa-download"></i> Proof of Expense
                                                </a>
                                            <?php } ?>
                                        <?php } ?>



                                        <?php if ($this->active_cid == 1) { ?>
                                            <a href="<?= base_url($row->memo_budget) ?>" download class="btn btn-warning btn-xs mr-2 mb-2  <?= $row->memo_budget ? '' : 'hide' ?>"><i class="fa fa-download"></i> Memo Budget</a>
                                        <?php } ?>
                                        <?php if ($row->executive_id) { ?>
                                            <a ahref="#" class="btn btn-primary btn-xs mr-2 mb-2 " data-toggle="modal" data-target="#modal_view_eid" data-record_id="<?= $row->executive_id ?>">View Detail Approval Req</a>
                                        <?php } ?>
                                    </td>
                                </tr>
                        <?php
                                $no++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
            <div class="pull-left">
                Showing <?= $paging['start_row'] ?> to <?= $paging['end_row'] ?>
                of
                <?= number_format($paging['total_rows']) ?> entries
            </div>
            <!-- /.pagination info -->
            <?= $paging['html'] ?>
            <!-- /.pagination -->
            <input type="hidden" name="sort_by" value="<?= $sort_by ?>">
            <input type="hidden" name="sort" value="<?= $sort ?>">
        </form>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div id="template-filter" style="display:none">
    <div class="pull-right" style="margin-top:5px; clear:both;">
        <div class="form-group">
            <select class="form-control" name="cnj[]">
                <option value="AND">AND</option>
                <option value="OR">OR</option>
            </select>
        </div>
        <div class="form-group">
            <select class="form-control" name="search_by[]">
                <?php
                foreach ($filters as $field => $val) {
                ?>
                    <option value="<?= $field ?>"><?= $val ?></option>
                <?php } ?>
            </select>
        </div>
        &nbsp;&nbsp;&nbsp;&nbsp;
        Keyword : <input type="search" class="form-control input-sm" name="q[]" value="" placeholder=""
            onkeypress="return submitFilter(event)">
        <a href="javascript:;" onclick="remove_filter(this)" class="btn btn-danger btn-sm"><i
                class="fa fa-minus fa-fw"></i></a>
    </div>
</div>

<!-- Modal Download -->
<div class="modal fade" id="modalDownload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" id="form-download-excel">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Download Excel</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <center>
                                <b>List of Fields</b> ( <label>Select All <input id="sel-all" type="checkbox" checked></label> )<br><br>
                            </center>
                        </div>
                        <?php foreach (array_split($all_field, 4) as $key_a_f => $a_f): ?>
                            <div class="col-md-3">
                                <ul class="list-style-none">
                                    <?php foreach ($a_f as $key => $value): ?>
                                        <li>
                                            <div class="form-check">
                                                <input type="checkbox" name="field_alumni[]" class="form-check-input field-alumni" id="field_alumni_check<?= $key ?>" value="<?= "$key *-* $value" ?>" checked>
                                                <label class="form-check-label font-weight-normal d-inline" for="field_alumni_check<?= $key ?>"><?= $value ?></label>
                                            </div>
                                        </li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                        <?php endforeach ?>
                        <div class="col-md-12 d-none text-center text-validation mb-4" id="text-validation-field">
                            <small class="text-danger">Select at least one field</small>
                        </div>
                        <div class="col-md-12">
                            <hr>
                            <center>
                                <b>Show Grant</b><br><br>
                            </center>
                            <center>
                                <div class="radio d-inline mr-4">
                                    <label><input type="radio" class="grant-alumni" name="grant_option" style="margin-top:1px" value="single_grant" checked>Single Grant</label>
                                </div>
                                <div class="radio d-inline">
                                    <label><input type="radio" class="grant-alumni" name="grant_option" style="margin-top:1px" value="all_grant">All Grants</label>
                                </div>
                                <small class="text-danger d-none text-validation" id="text-validation-grant">Choose one between single grant or all grants</small>
                            </center>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <center>
                        <button type="submit" class="btn btn-success">Download</button>
                    </center>
                </div>
            </form>
        </div>
    </div>
</div>