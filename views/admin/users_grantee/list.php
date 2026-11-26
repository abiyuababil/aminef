<style>
    .select2-container .select2-selection {
        max-height: 60px;
        overflow: auto;
    }

    .data-header {
        padding-top: 10px !important;
    }

    .program-filter-section {
        display: flex;
    }

    .program-filter-section > .form-group {
        width: 350px;
        margin-left: 12px;
    }

    .select2-container--bootstrap .select2-selection {
        border-radius: 0px !important;
    }

    .select2-selection--single > .select2-selection__rendered {
        margin-top: 5px !important;
    }

    .select2-selection--single {
        overflow: hidden !important;
    }
    label {
        font-weight: normal !important;
    }


  /* Header Modal */
  .modal-header {
    background-color: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 16px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .modal-title { font-size: 16px; font-weight: 700; color: #0f172a; }
  .btn-close { background: none; border: none; font-size: 18px; color: #94a3b8; cursor: pointer; }

  /* Stepper Tab Bar */
  .step-bar {
    display: flex;
    border-bottom: 1px solid #e2e8f0;
    background-color: #fafbfc;
  }
  .step-tab {
    flex: 1;
    padding: 12px 16px;
    text-align: center;
    font-weight: 600;
    font-size: 12.5px;
    color: #64748b;
    border-bottom: 2px solid transparent;
  }
  .step-tab.active {
    color: #0284c7;
    border-bottom-color: #0284c7;
    background-color: #ffffff;
  }

  .modal-body {
    padding: 20px 24px;
    max-height: 480px;
    overflow-y: auto;
  }

  /* Filter Grid */
  .filters-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px 20px;
  }

  .field-box {
    display: flex;
    flex-direction: column;
    gap: 4px;
    position: relative;
  }
  .field-lbl {
    font-size: 11.5px;
    font-weight: 700;
    color: #475569;
  }

  /* Searchable Multi-Select Trigger */
  .search-select-trigger {
    border: 1px solid #cbd5e1;
    border-radius: 4px;
    padding: 6px 10px;
    font-size: 12.5px;
    background: #fff;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    user-select: none;
  }
  .search-select-trigger:focus, .search-select-trigger.active {
    border-color: #0284c7;
    box-shadow: 0 0 0 1px #0284c7;
  }
  .search-select-trigger::after {
    content: "▾";
    color: #94a3b8;
    font-size: 11px;
  }

  /* Searchable Multi-Select Dropdown Menu */
  .dropdown-menu-search {
    display: none;
    position: absolute;
    top: calc(100% + 4px);
    left: 0;
    width: 100%;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 4px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    z-index: 50;
    padding: 8px;
  }
  .dropdown-menu-search.show { display: block; }

  .dropdown-search-input {
    width: 100%;
    padding: 5px 8px;
    border: 1px solid #cbd5e1;
    border-radius: 3px;
    font-size: 12px;
    margin-bottom: 6px;
    outline: none;
  }
  .dropdown-search-input:focus { border-color: #0284c7; }

  .dropdown-options-list {
    max-height: 140px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 4px;
  }

  .dropdown-opt-label {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: #334155;
    padding: 3px 4px;
    border-radius: 3px;
    cursor: pointer;
  }
  .dropdown-opt-label:hover { background-color: #f1f5f9; }
  .dropdown-opt-label input { accent-color: #0284c7; }

  /* Step 2: Columns Selection */
  .preset-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 14px;
    padding: 8px 14px;
    background: #f0f9ff;
    border: 1px solid #e0f2fe;
    border-radius: 6px;
  }
  .preset-btn-group { display: flex; gap: 8px; }
  .btn-chip {
    border: 1px solid #cbd5e1;
    background: #ffffff;
    padding: 4px 10px;
    border-radius: 14px;
    font-size: 11.5px;
    font-weight: 600;
    color: #334155;
    cursor: pointer;
  }
  .btn-chip:hover { border-color: #0284c7; color: #0284c7; }

  .columns-ordered-list {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px 16px;
    background-color: #fafbfc;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    padding: 14px 16px;
  }
  .chk-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    color: #1e293b;
    cursor: pointer;
    user-select: none;
    padding: 3px 0;
  }
  .chk-item input { accent-color: #0284c7; width: 14px; height: 14px; cursor: pointer; }

  /* Footer Controls */
  .modal-footer {
    background-color: #f8fafc;
    border-top: 1px solid #e2e8f0;
    padding: 12px 24px;
    display: flex;
    justify-content: flex-end;
    gap: 5px;
    align-items: center;
  }
  .btn-act {
    padding: 7px 18px;
    border-radius: 4px;
    font-size: 12.5px;
    font-weight: 600;
    cursor: pointer;
    border: none;
  }
  .btn-ghost { background: #fff; border: 1px solid #cbd5e1; color: #475569; }
  .btn-primary { background: #0284c7; color: #fff; }
  .btn-success { background: #16a34a; color: #fff; }
</style>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Manage Users
            <?php if(has_permission('users', 'add')) { ?>
            <a href="<?php echo site_url('admin/users_grantee/add') ?>" class="btn btn-success btn-sm pull-right" title="Menambahkan data alumni baru">
                ADD NEW
            </a>
            <?php } ?>
            <!-- <a href="<?php //echo site_url('admin/users_grantee/download_excel?' . ($this->input->get() ? http_build_query($this->input->get()) : '')) ?>" class="btn btn-primary btn-sm pull-right mr-2" title="Menambahkan data alumni baru">
                DOWNLOAD EXCEL
            </a> -->
            <a href="javascript:;" onclick="show_download_modal('<?=http_build_query($_GET)?>')"
               class="btn btn-primary btn-sm pull-right mr-2" title="Export Data to excel">
                DOWNLOAD EXCEL
            </a>
        </h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <form id="frm-import-excel" method="POST" enctype="multipart/form-data" style="display:none">
            <input id="file-excel" type="file" name="file-excel">
        </form>
        <form id="frm_manage" method="GET">
            <div class="row mb-4 program-filter-section">
                <div class="form-group select-program">
                    <label>Program</label>
                    <select class="form-control select2" id="filter-program" name="program_ids[]" multiple>
                        <?php 
                            $program_ids = isset($_GET['program_ids']) ? (array) $_GET['program_ids'] : [];
                        ?>
                        <?php foreach($program_available as $program) { ?>
                            <option value="<?php echo $program->id; ?>" <?= (!empty($program_ids) && is_array($program_ids) && in_array($program->id, $program_ids)) ? 'selected' : '' ?>
><?php echo $program->name; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Period</label>
                    <select class="form-control select2" name="period[]" onchange="document.forms.frm_manage.submit()" multiple>
                        <option value="">&nbsp;</option>
                        <?php $_period = isset($_GET['period']) ? $_GET['period'] : ''; ?>
                        <?php foreach($available_period as $period) { ?>
                            <?php if (empty($period->fiscal_year) || $period->fiscal_year <= 0) continue; ?>
                            <option value="<?php echo $period->fiscal_year; ?>" <?php echo (!empty($_period) && is_array($_period) && in_array($period->fiscal_year, $_period)) ? 'selected' : ''; ?>><?php echo $period->fiscal_year; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div id="wrap-filter" class="data-header clearfix form-inline">
                <div class="pull-left">
                    Status : 
                    <select class="form-control input-sm selectpicker" name="status" onchange="document.forms.frm_manage.submit()" data-width="150px" data-live-search="true">
                        <option value="">All</option>
                        <?php
                        foreach ($status as $st) {
                            $selected = '';
                            if ($st->id == $paging['status']) {
                                $selected = 'selected';
                            }
                        ?>
                            <option value="<?= $st->id ?>" <?= $selected ?>><?= str_ireplace('On Going', 'Ongoing', $st->name) ?></option>
                        <?php } ?>
                    </select>

                    Academic Year :
                    <select class="form-control input-sm selectpicker" name="fiscal_year" onchange="document.forms.frm_manage.submit()" data-live-search="true">
                        <option value="">All</option>
                        <?php
                            foreach ($academic_year as $year) {
                            $selected = '';
                            if ($year->fiscal_year != null) {
                        ?>
                            <option value="<?= $year->fiscal_year ?>"  <?php echo $year->fiscal_year == $this->input->get('fiscal_year') ? 'selected' : ''; ?>><?= $year->fiscal_year ?></option>
                            <?php } ?>
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

                    <div class="form-group mr-2">
                        State 
                        <select class="form-control input-sm selectpicker" name="state" onchange="document.forms.frm_manage.submit()" data-live-search="true">
                            <option value="">-- Select --</option>
                            <?php
                            foreach ($states as $i => $val) {
                                $selected = '';
                                if ($val->id == $this->input->get('state')) {
                                    $selected = 'selected';
                                }
                            ?>
                                <option
                                    value="<?php echo $val->id ?>" <?php echo $selected; ?>><?php echo $val->name ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group mr-2">
                        City 
                        <select class="form-control input-sm selectpicker" name="city" onchange="document.forms.frm_manage.submit()" data-live-search="true">
                            <option value="">-- Select --</option>
                            <?php
                            foreach ($cities as $i => $val) {
                                $selected = '';
                                if ($val->id == $this->input->get('city')) {
                                    $selected = 'selected';
                                }
                            ?>
                                <option
                                    value="<?php echo $val->id ?>" <?php echo $selected; ?>><?php echo $val->name ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    Crate Date : 
                    <input type="text" class="form-control dateWithRange" name="filter_date" placeholder="Select Date" readonly style="background-color:#fff;" value="<?= $filter_date ?>">
                </div>
                <div class="pull-right">
                    Search : <input type="search" class="form-control input-sm" name="search" value="<?php echo $paging['search'] ?>" placeholder="" onkeypress="return submitFilter(event)">
                </div>
                <?php
                $total_filter = isset($_GET['search_by']) ? count($_GET['search_by']) : 0;
                if ($total_filter > 1) {
                    for ($i = 1; $i < $total_filter; $i++) {
                ?>
                        <div class="pull-right" style="margin-top:5px; clear:both;">
                            <div class="form-group">
                                <select class="form-control" name="cnj[]">
                                    <option value="AND" <?= $_GET['cnj'][$i - 1] == 'AND' ? 'selected' : null ?>>AND</option>
                                    <option value="OR" <?= $_GET['cnj'][$i - 1] == 'OR' ? 'selected' : null ?>>OR</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="search_by[]">
                                    <?php
                                    $search_by = $_GET['search_by'][$i];
                                    foreach ($filters as $field => $val) {
                                        $selected = '';
                                        if (isset($search_by) && $search_by == $field) {
                                            $selected = 'selected="selected"';
                                        }
                                    ?>
                                        <option value="<?= $field ?>" <?= $selected; ?>><?= $val ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            Keyword : <input type="search" class="form-control input-sm" name="q[]" value="<?= $q[$i] ?>" placeholder="" onkeypress="return submitFilter(event)">
                            <a href="javascript:;" onclick="remove_filter(this)" class="btn btn-danger btn-sm"><i class="fa fa-minus fa-fw"></i></a>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center">
                    <thead>
                        <tr>
                            <th width="30"><input type="checkbox" class="chk-all"></th>
                            <th width="35" class="text-center">#</th>
                            <th <?= sorting_attribute('first_name', $sort_by, $sort) ?>>Name</th>
                            <th>Grants</th>
                            <th>Grant State</th>
                            <th>Grant City</th>
                            <th <?= sorting_attribute('date_insert', $sort_by, $sort) ?>>Create Date</th>
                            <th>Academic Year</th>
                            <th>Status</th>
                            <th class="text-center" width="10px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data) {
                            // $no = 1;
                            $no = $paging['start_row'];
                            $grantee_ids = [];
                            foreach ($data as $row) {
                                if(!in_array($row->id,$grantee_ids)){
                                    $grantee_ids[] = $row->id;
                                    $format = 'ID';
                                    if ($country_id == '2') {
                                        $format = 'US';
                                    }
                                    $fullname = get_full_name($row, $format);
                            ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="chk-row" name="ids[]" value="<?= $row->user_id ?>">
                                        </td>
                                        <td><?= $no ?></td>
                                        <td class="text-left">
                                            <a href="<?= site_url('admin/users_grantee/edit/' . $row->id) ?>" target="_blank"><?= $fullname ?></a>
                                        </td>
                                        <td class="text-left"><?= $row->program_name ?></td>
                                        <td class="text-left"><?= $row->state_university ?></td>
                                        <td class="text-left"><?= $row->city_university ?></td>
                                        <td class="text-left"><?= $row->date_insert ? date('d M Y H:i:s', strtotime($row->date_insert)) : '-' ?></td>
                                        <td class="text-left"><?= $row->fiscal_year ?></td>
                                        <td class="text-left"><?= $row->status_name ? str_ireplace('On Going', 'Ongoing', $row->status_name) : '' ?></td>
                                        <td class="text-center">
                                            <?php if(has_permission('users', 'edit')) { ?>
                                            <a href="<?php echo site_url('admin/grantee/grants/' . $row->id) ?>" class="btn btn-primary btn-xs">
                                                <i class="fa fa-edit"></i> Edit Grants
                                            </a>
                                            <?php } ?>
                                            </ul>
                                        </td>
                                    </tr>
                            <?php
                                    $no++;
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
            <div class="pull-left">
                Showing <?= $paging['start_row'] ?> to <?= $paging['end_row'] ?>
                of <?= number_format($paging['total_rows']) ?> entries
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
        Keyword : <input type="search" class="form-control input-sm" name="q[]" value="" placeholder="" onkeypress="return submitFilter(event)">
        <a href="javascript:;" onclick="remove_filter(this)" class="btn btn-danger btn-sm"><i class="fa fa-minus fa-fw"></i></a>
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
                        <?php foreach (array_split($all_field, 4) as $key_a_f => $a_f) : ?>
                            <div class="col-md-3">
                                <ul class="list-style-none">
                                    <?php foreach ($a_f as $key => $value) : ?>
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

<div class="modal fade" id="modalDownloadV2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" id="form-download-excel-v2" action="<?php echo site_url('admin/users_grantee/download_excel_v2') ?>">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Export Users to Excel</h4>
                </div>

                <!-- Stepper Navigation -->
                <div class="step-bar">
                    <div class="step-tab active" id="tabStep1" onclick="goToStep(1)" style="cursor: pointer;">Filter Criteria</div>
                    <div class="step-tab" id="tabStep2" onclick="goToStep(2)" style="cursor: pointer;">Columns to Download</div>
                </div>

                <div class="modal-body" id="bodyStep1">
                    <div class="filters-grid">
                        <!-- Grant -->
                        <div class="field-box">
                            <span class="field-lbl">Grant</span>
                            <select class="form-control selectpicker" id="modal-filter-program" name="programs[]" multiple data-selected-text-format="count" data-live-search="true" title="Nothing Selected">
                                <?php foreach($program_available as $program) { ?>
                                    <option value="<?php echo $program->id; ?>"><?php echo html_escape($program->name); ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Fiscal year -->
                        <div class="field-box">
                            <span class="field-lbl">Fiscal year</span>
                            <select class="form-control selectpicker" name="periods[]" multiple data-selected-text-format="count" data-live-search="true" title="Nothing Selected">
                                <?php foreach($available_period as $period) { ?>
                                    <?php if (empty($period->fiscal_year) || $period->fiscal_year <= 0) continue; ?>
                                    <option value="<?php echo $period->fiscal_year; ?>"><?php echo $period->fiscal_year; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Country -->
                        <div class="field-box">
                            <span class="field-lbl">Country</span>
                            <select class="form-control selectpicker" id="modal_country" name="country" data-live-search="true" title="Nothing Selected">
                                <?php foreach($country_list as $country) { ?>
                                    <option value="<?php echo $country->id; ?>"><?php echo html_escape($country->name); ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- State/Province -->
                        <div class="field-box">
                            <span class="field-lbl">State/Province</span>
                            <select class="form-control selectpicker" id="modal_home_state" name="home_state" data-live-search="true" title="Nothing Selected">
                            </select>
                        </div>

                        <!-- City -->
                        <div class="field-box">
                            <span class="field-lbl">City</span>
                            <select class="form-control selectpicker" id="modal_home_city" name="home_city" data-live-search="true" title="Nothing Selected">
                            </select>
                        </div>

                        <!-- Year degree obtained -->
                        <div class="field-box">
                            <span class="field-lbl">Year degree obtained</span>
                            <select class="form-control selectpicker" name="year_do" data-live-search="true" title="Nothing Selected">
                                <?php for ($y = date('Y') + 2; $y >= 1950; $y--) { ?>
                                    <option value="<?php echo $y; ?>"><?php echo $y; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Field of Study -->
                        <div class="field-box">
                            <span class="field-lbl">Field of Study</span>
                            <select class="form-control selectpicker" name="field_of_study" data-live-search="true" title="Nothing Selected">
                                <?php if (!empty($study_fields)) { foreach($study_fields as $sf) { ?>
                                    <option value="<?php echo $sf->id; ?>"><?php echo html_escape($sf->name); ?></option>
                                <?php } } ?>
                            </select>
                        </div>

                        <!-- Gender -->
                        <div class="field-box">
                            <span class="field-lbl">Gender</span>
                            <select class="form-control selectpicker" name="gender" data-live-search="true" title="Nothing Selected">
                                <?php foreach($genders as $gender) { ?>
                                    <option value="<?php echo $gender; ?>"><?php echo $gender; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Status -->
                        <div class="field-box">
                            <span class="field-lbl">Status</span>
                            <select class="form-control selectpicker" name="status" data-live-search="true" title="Nothing Selected">
                                <?php
                                foreach ($status as $st) {
                                    $selected = '';
                                    if ($st->id == $paging['status']) {
                                        $selected = 'selected';
                                    }
                                ?>
                                    <option value="<?= $st->id ?>" <?= $selected ?>><?= str_ireplace('On Going', 'Ongoing', $st->name) ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Grant State/Province -->
                        <div class="field-box">
                            <span class="field-lbl">Grant State/Province</span>
                            <select class="form-control selectpicker" id="modal_grant_state" name="grant_state" data-live-search="true" title="Nothing Selected">
                                <?php
                                foreach ($states as $i => $val) {
                                ?>
                                    <option value="<?php echo $val->id ?>"><?php echo html_escape($val->name) ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Final Placement -->
                        <div class="field-box">
                            <span class="field-lbl">Final Placement</span>
                            <select class="form-control selectpicker" name="university" data-live-search="true" title="Nothing Selected">
                                <?php foreach($universities as $university) { ?>
                                    <option value="<?php echo $university->id; ?>"><?php echo html_escape($university->name); ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Grant City -->
                        <div class="field-box">
                            <span class="field-lbl">Grant City</span>
                            <select class="form-control selectpicker" id="modal_grant_city" name="grant_city" data-live-search="true" title="Nothing Selected">
                            </select>
                        </div>

                        <!-- Completion -->
                        <div class="field-box">
                            <span class="field-lbl">Completion</span>
                            <select class="form-control selectpicker" name="completion" data-live-search="true" title="Nothing Selected">
                                <option value="Successful">Successful</option>
                                <option value="Unsuccessful">Unsuccessful</option>
                            </select>
                        </div>

                    </div>
                </div>

                <div class="modal-body" id="bodyStep2" style="display: none;">
                
                <div class="preset-row">
                    <span style="font-size: 12px; font-weight: 700; color: #0284c7;">Quick Selection:</span>
                    <div class="preset-btn-group">
                    <button type="button" class="btn-chip" onclick="setAllCheckboxes(true)">Select All</button>
                    <button type="button" class="btn-chip" onclick="setAllCheckboxes(false)">Unselect All</button>
                    </div>
                </div>

                <div class="columns-ordered-list" id="orderedCheckboxList">
                    
                    <div>
                        <label class="chk-item"><input type="checkbox" name="fields[]" checked value="Gender"> Gender</label>
                        <label class="chk-item"><input type="checkbox" name="fields[]" checked value="Name"> Name</label>
                        <label class="chk-item"><input type="checkbox" name="fields[]" checked value="Email"> Email</label>
                        <label class="chk-item"><input type="checkbox" name="fields[]" checked value="Mobile Number"> Mobile Number</label>
                        <label class="chk-item"><input type="checkbox" name="fields[]" checked value="Period"> Period</label>
                        <label class="chk-item"><input type="checkbox" name="fields[]" checked value="Grants"> Grants</label>
                        <label class="chk-item"><input type="checkbox" name="fields[]" checked value="Status"> Status</label>
                        <label class="chk-item"><input type="checkbox" name="fields[]" checked value="Host Institution"> Host Institution</label>
                        <label class="chk-item"><input type="checkbox" name="fields[]" checked value="State/Province"> State/Province</label>
                    </div>

                    <div>
                        <label class="chk-item"><input type="checkbox" name="fields[]" checked value="City"> City</label>
                        <label class="chk-item"><input type="checkbox" name="fields[]" checked value="Field of Study"> Field of Study</label>
                        <label class="chk-item"><input type="checkbox" name="fields[]" checked value="Home Institution"> Home Institution</label>
                        <label class="chk-item"><input type="checkbox" name="fields[]" checked value="Office State/Province"> Office State/Province</label>
                        <label class="chk-item"><input type="checkbox" name="fields[]" checked value="Office City"> Office City</label>
                        <label class="chk-item"><input type="checkbox" name="fields[]" checked value="Final Placement"> Final Placement</label>
                        <label class="chk-item"><input type="checkbox" name="fields[]" checked value="Grant State/Province"> Grant State/Province</label>
                        <label class="chk-item"><input type="checkbox" name="fields[]" checked value="Grant City"> Grant City</label>
                        <label class="chk-item"><input type="checkbox" name="fields[]" checked value="Completion"> Completion</label>
                    </div>

                </div>

                </div>

                <div class="modal-footer">
                <button type="button" class="btn-act btn-ghost" id="btnBack" style="visibility: hidden;" onclick="goToStep(1)">
                    ← Back to Filters
                </button>

                <div>
                    <button type="button" class="btn-act btn-primary" id="btnNext" onclick="goToStep(2)">
                    Next: Choose Columns →
                    </button>
                    <button type="button" class="btn-act btn-success" id="btnDownload" style="display: none;" onclick="triggerDownload()">
                    Download Excel
                    </button>
                </div>
                </div>
            </form>
        </div>
    </div>
</div>