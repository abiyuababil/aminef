<style>
    .load_section.selected {
        background: #337ab7 !important;
        color: #fff;
        border-color: #337ab7;
    }

    #monitoring-status-tabs {
        border-bottom: 2px solid #337ab7;
    }

    #monitoring-status-tabs > li.active > a,
    #monitoring-status-tabs > li.active > a:hover,
    #monitoring-status-tabs > li.active > a:focus {
        border-color: #337ab7;
        border-bottom-color: #fff;
    }

</style>
<!-- alert -->
<?php if (!is_null($this->session->flashdata('db_changed'))): ?>
    <div class="alert alert-success" id="alert-db-changed" style="width:300px">
        <button type="button" class="close" data-dismiss="alert">x</button>
        Database has changed to <strong> <?= get_active_country(); ?></strong>
    </div>
<?php endif; ?>
<!-- row -->
<?php if (is_admin()): ?>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Dashboard</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-users fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo number_format($total_users) ?></div>
                            <div>Total Alumni</div>
                        </div>
                    </div>
                </div>
                <a href="<?php echo site_url('admin/alumni/manage') ?>">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-book fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $total_programs ?></div>
                            <div><?= $this->session->userdata('active_country') == AMERICAN_DATABASE ? 'Total Grants' : 'Total Type of Grants' ?></div>
                        </div>
                    </div>
                </div>
                <a href="<?php echo site_url('admin/programs/manage') ?>">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-files-o fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo number_format($total_study_fields) ?></div>
                            <div>Total Study Fields</div>
                        </div>
                    </div>
                </div>
                <a href="<?php echo site_url('admin/study_fields/manage') ?>">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <?php if ($this->session->userdata('active_country') == INDONESIAN_DATABASE) { ?>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-graduation-cap fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo number_format($total_grantee) ?></div>
                            <div>Total Grantee</div>
                        </div>
                    </div>
                </div>
                <?php if ($this->session->userdata('active_country') == AMERICAN_DATABASE) {
                    $url = site_url('admin/search_grantee/manage');
                } else {
                    $url = site_url('admin/dashboard/data_grantee');
                } ?>
                <a href="<?php echo $url ?>">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <?php } ?>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-book fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $total_active_grant ?></div>
                            <div>Total Active Grants</div>
                        </div>
                    </div>
                </div>
                <a href="<?php echo site_url('admin/user_grantee_grant/manage') ?>">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <?php if ($this->session->userdata('active_country') == AMERICAN_DATABASE): ?>
        <div class="row my-5">
            <div class="col-lg-12">
                <h1 class="page-header">Select Monitoring Status</h1>
                <ul class="nav nav-tabs" id="monitoring-status-tabs">
                    <li><a href="#" class="load_section" data-section="submitted">Submitted Documents</a></li>
                    <li><a href="#" class="load_section" data-section="upcoming">Upcoming Grant Disbursements</a></li>
                    <li><a href="#" class="load_section" data-section="report">Upcoming AMINEF Reports</a></li>
                    <li><a href="#" class="load_section" data-section="travel_arrangement">Travel Arrangement</a></li>
                    <li><a href="#" class="load_section" data-section="leave">Grantee on Leave</a></li>
                </ul>
            </div>
        </div>


        <!-- SUBMITTED DOCUMENTS TABLE -->
        <div id="section-submitted" style="display: none;">
            <div class="row">
                <div class="col-lg-12">
                    <div class="documents-header">
                        <h2 class="documents-title">Submitted Documents</h2>
                        <div class="form-group mt-2">
                            <select class="form-control selectpicker" id="program-filter" name="program_filter"
                                data-live-search="true" data-width="300px" data-style="btn-default">
                                <option value="all" <?php echo (!isset($program_filter) || $program_filter == 'all') ? 'selected' : ''; ?>>All Programs</option>
                                <?php if (isset($programs) && !empty($programs)): ?>
                                    <?php foreach ($programs as $program): ?>
                                        <?php
                                        if ($this->session->userdata('active_country') == AMERICAN_DATABASE) {
                                            $program_value = isset($program->grant_id) ? $program->grant_id : (isset($program->grant_id) ? $program->grant_id : '');
                                            $program_name = isset($program->name) ? $program->name : '';
                                        } else {
                                            $program_value = isset($program->id) ? $program->id : '';
                                            $program_name = isset($program->name) ? $program->name : '';
                                        }
                                        $selected = (isset($program_filter) && $program_filter == $program_value) ? 'selected' : '';
                                        ?>
                                        <?php if (!empty($program_value)): ?>
                                            <option value="<?php echo htmlspecialchars($program_value); ?>" <?php echo $selected; ?>>
                                                <?php echo htmlspecialchars($program_name) . ' - ' . htmlspecialchars($program->year); ?>
                                            </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="loading-alert" style="display: none;">
                <div class="col-lg-12">
                    <div class="alert alert-info">
                        <i class="fa fa-spinner fa-spin"></i> Loading data...
                    </div>
                </div>
            </div>
            <div class="row" id="no-data-alert" style="display: none;">
                <div class="col-lg-12">
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> No data available for the selected filter.
                    </div>
                </div>
            </div>
            <div class="row" id="submitted-grantees-table">
                <div class="col-lg-12">
                    <div class="documents-container">
                        <div class="documents-content">
                            <table class="table table-striped table-hover" id="grantees-table">
                                <thead>
                                    <tr>
                                        <th style="width: 30%;">Name</th>
                                        <th style="width: 70%;" class="text-center">Sections</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SUBMITTED DOCUMENTS TABLE -->


        <!-- UPCOMING GRANT DISBURSEMENTS TABLE -->
         <div id="section-upcoming" style="display: none;">
            <div class="row" id="loading-alert-upcoming" style="display: none;">
                <div class="col-lg-12">
                    <div class="alert alert-info">
                        <i class="fa fa-spinner fa-spin"></i> Loading data...
                    </div>
                </div>
            </div>
            <div class="row" id="no-data-alert-upcoming" style="display: none;">
                <div class="col-lg-12">
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> No data available for the selected filter.
                    </div>
                </div>
            </div>
            <div class="row" id="upcoming-grantees-table">
                <div class="col-lg-12">
                    <div class="documents-container">
                        <div class="documents-content">
                            <table class="table table-striped table-hover" id="upcoming-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Program</th>
                                        <th>Disbursement Title</th>
                                        <th>Processing Date</th>
                                        <th>Total Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

         </div>
        <!-- END UPCOMING GRANT DISBURSEMENTS TABLE -->

        <!-- UPCOMING AMINEF REPORTS TABLE -->
         <div id="section-report" style="display: none;">
            <div class="row" id="loading-alert-report" style="display: none;">
                <div class="col-lg-12">
                    <div class="alert alert-info">
                        <i class="fa fa-spinner fa-spin"></i> Loading data...
                    </div>
                </div>
            </div>
            <div class="row" id="no-data-alert-report" style="display: none;">
                <div class="col-lg-12">
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> No data available for the selected filter.
                    </div>
                </div>
            </div>
            <div class="row" id="report-grantees-table">
                <div class="col-lg-12">
                    <div class="documents-container">
                        <div class="documents-content">
                            <table class="table table-striped table-hover" id="report-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Program</th>
                                        <th>Nama Report</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
         </div>
        <!-- END UPCOMING AMINEF REPORTS TABLE -->

        <!-- TRAVEL ARRANGEMENT TABLE -->
         <div id="section-travel_arrangement" style="display: none;">
            <ul class="nav nav-tabs" id="travel-arrangement-tabs">
                <li class="active"><a href="#" data-travel-tab="eta">ETA</a></li>
                <li><a href="#" data-travel-tab="non_eta">Non ETA</a></li>
            </ul>
            <div id="travel-tab-eta">
            <div class="row">
                <div class="col-lg-12">
                    <div class="documents-container">
                        <div class="clearfix" style="padding:10px 0;">
                            <div class="pull-left" style="line-height:34px;">
                                <label for="travel-filter-limit" style="margin-right:5px;">Show</label>
                                <select class="form-control input-sm" id="travel-filter-limit" style="display:inline-block; width:auto;">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                                <label style="margin:0 10px 0 5px;">entries</label>
                            </div>
                            <form class="form-inline pull-right">
                                <div class="form-group">
                                    <label for="travel-filter-period">Period</label>
                                    <select class="form-control" id="travel-filter-period">
                                        <option value="">All Periods</option>
                                        <?php if (isset($eta_travel_periods) && !empty($eta_travel_periods)): ?>
                                            <?php foreach ($eta_travel_periods as $eta_period): ?>
                                                <option value="<?php echo (int) $eta_period; ?>"><?php echo (int) $eta_period; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="travel-filter-status">Status</label>
                                    <select class="form-control" id="travel-filter-status">
                                        <option value="">All Status</option>
                                        <option value="<?php echo ETA_TRAVEL_STATUS_NEW_REQUEST; ?>">New Request</option>
                                        <option value="<?php echo ETA_TRAVEL_STATUS_PENDING_REVIEW; ?>">Pending Review</option>
                                        <option value="<?php echo ETA_TRAVEL_STATUS_REVISION; ?>">Revision</option>
                                        <option value="<?php echo ETA_TRAVEL_STATUS_BOOK_TICKET; ?>">Proceed To Book</option>
                                        <option value="<?php echo ETA_TRAVEL_STATUS_BOOKED; ?>">Booked</option>
                                        <option value="<?php echo ETA_TRAVEL_STATUS_PROCEED_TO_ISSUED; ?>">Proceed to Issue</option>
                                        <option value="<?php echo ETA_TRAVEL_STATUS_ISSUED; ?>">Ticket Sent</option>
                                        <option value="blank">Blank</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="travel-filter-category">Category</label>
                                    <select class="form-control" id="travel-filter-category">
                                        <option value="">All Categories</option>
                                        <?php if (isset($travel_categories) && !empty($travel_categories)): ?>
                                            <?php foreach ($travel_categories as $travel_category): ?>
                                                <option value="<?php echo (int) $travel_category->id; ?>"><?php echo htmlspecialchars($travel_category->name, ENT_QUOTES, 'UTF-8'); ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <button type="button" class="btn btn-primary" id="travel-filter-btn">Filter</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="loading-alert-travel" style="display: none;">
                <div class="col-lg-12">
                    <div class="alert alert-info">
                        <i class="fa fa-spinner fa-spin"></i> Loading data...
                    </div>
                </div>
            </div>
            <div class="row" id="no-data-alert-travel" style="display: none;">
                <div class="col-lg-12">
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> No data available.
                    </div>
                </div>
            </div>
            <div class="row" id="travel-arrangements-table">
                <div class="col-lg-12">
                    <div class="documents-container">
                        <div class="documents-content">
                            <table class="table table-striped table-hover" id="travel-table">
                                <thead>
                                    <tr>
                                        <th>Period</th>
                                        <th>Grantee Name</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Chat</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="travel-pagination-row">
                <div class="col-lg-12">
                    <div class="documents-container">
                        <div class="documents-content clearfix" style="padding:10px 0;">
                            <div class="pull-left">
                                <span id="travel-page-info"></span>
                            </div>
                            <div class="pull-right" id="travel-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div id="travel-tab-non_eta" style="display: none;">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="documents-container">
                            <div class="clearfix" style="padding:10px 0;">
                                <div class="pull-left" style="line-height:34px;">
                                    <label for="travel-non-eta-filter-limit" style="margin-right:5px;">Show</label>
                                    <select class="form-control input-sm" id="travel-non-eta-filter-limit" style="display:inline-block; width:auto;">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                    <label style="margin:0 10px 0 5px;">entries</label>
                                </div>
                                <form class="form-inline pull-right">
                                    <div class="form-group">
                                        <label for="travel-non-eta-filter-program">Program</label>
                                        <select class="form-control" id="travel-non-eta-filter-program">
                                            <option value="">All Programs</option>
                                            <?php if (isset($non_eta_programs) && !empty($non_eta_programs)): ?>
                                                <?php foreach ($non_eta_programs as $non_eta_program): ?>
                                                    <option value="<?php echo (int) $non_eta_program->id; ?>" data-period="<?php echo (int) $non_eta_program->fiscal_year; ?>"><?php echo htmlspecialchars($non_eta_program->name, ENT_QUOTES, 'UTF-8'); ?><?php echo !empty($non_eta_program->fiscal_year) ? ' - ' . (int) $non_eta_program->fiscal_year : ''; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="travel-non-eta-filter-status">Status</label>
                                        <select class="form-control" id="travel-non-eta-filter-status">
                                            <option value="">All Status</option>
                                            <option value="<?php echo TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_SUBMITTED; ?>">In Progress</option>
                                            <option value="<?php echo TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_APPROVED; ?>">Proceed to Issue</option>
                                            <option value="<?php echo TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_DECLINED; ?>">Revision</option>
                                            <option value="<?php echo TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_REIMBURSEMENT_SUBMITTED; ?>">Reimbursement Submitted</option>
                                            <option value="<?php echo TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_FLIGHT_APPROVAL; ?>">Travel Approval</option>
                                            <option value="<?php echo TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_PAYMENT_IN_PROGRESS; ?>">Payment in Progress</option>
                                            <option value="<?php echo TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_PAYMENT_RELEASE; ?>">Payment Released</option>
                                            <option value="<?php echo TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_TICKET_SENT; ?>">Ticket Sent</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="travel-non-eta-filter-category">Category</label>
                                        <select class="form-control" id="travel-non-eta-filter-category">
                                            <option value="">All Categories</option>
                                            <option value="self_arrangement">Self Arrangement</option>
                                            <option value="arranged_by_aminef">Arranged By Aminef</option>
                                        </select>
                                    </div>
                                    <button type="button" class="btn btn-primary" id="travel-non-eta-filter-btn">Filter</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="loading-alert-travel-non-eta" style="display: none;">
                    <div class="col-lg-12">
                        <div class="alert alert-info">
                            <i class="fa fa-spinner fa-spin"></i> Loading data...
                        </div>
                    </div>
                </div>
                <div class="row" id="no-data-alert-travel-non-eta" style="display: none;">
                    <div class="col-lg-12">
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> No data available.
                        </div>
                    </div>
                </div>
                <div class="row" id="travel-non-eta-table-row">
                    <div class="col-lg-12">
                        <div class="documents-container">
                            <div class="documents-content">
                                <table class="table table-striped table-hover" id="travel-non-eta-table">
                                    <thead>
                                        <tr>
                                            <th>Program</th>
                                            <th>Grantee Name</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            <th>Chat</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="travel-non-eta-pagination-row">
                    <div class="col-lg-12">
                        <div class="documents-container">
                            <div class="documents-content clearfix" style="padding:10px 0;">
                                <div class="pull-left">
                                    <span id="travel-non-eta-page-info"></span>
                                </div>
                                <div class="pull-right" id="travel-non-eta-pagination"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </div>
        <!-- END TRAVEL ARRANGEMENT TABLE -->
         
        <!-- LEAVE TABLE -->
        <div id="section-leave" style="display: none;">
            <div class="row">
                <div class="col-lg-12">
                    <div class="documents-container">
                        <div class="clearfix" style="padding:10px 0;">
                            <div class="pull-left" style="line-height:34px;">
                                <label for="leave-filter-limit" style="margin-right:5px;">Show</label>
                                <select class="form-control input-sm" id="leave-filter-limit" style="display:inline-block; width:auto;">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                                <label style="margin:0 10px 0 5px;">entries</label>
                            </div>
                            <form class="form-inline pull-right" id="leave-filter-form" onsubmit="return false;">
                                <div class="form-group" style="margin-right: 5px;">
                                    <label for="leave-filter-fiscal-year">Fiscal Year</label>
                                    <select class="form-control" id="leave-filter-fiscal-year">
                                        <option value="">All</option>
                                        <?php if (isset($leave_fiscal_years) && !empty($leave_fiscal_years)): ?>
                                            <?php foreach ($leave_fiscal_years as $fy): ?>
                                                <?php if (!is_numeric($fy->fiscal_year) || $fy->fiscal_year == 0) continue; ?>
                                                <option value="<?php echo htmlspecialchars($fy->fiscal_year, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($fy->fiscal_year, ENT_QUOTES, 'UTF-8'); ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group" style="margin-right: 5px;">
                                    <label for="leave-filter-program">Grant</label>
                                    <select class="form-control" id="leave-filter-program">
                                        <option value="">All Grants</option>
                                        <?php if (isset($leave_grants) && !empty($leave_grants)): ?>
                                            <?php foreach ($leave_grants as $grant): ?>
                                                <option value="<?php echo (int) $grant->id; ?>"><?php echo htmlspecialchars($grant->name, ENT_QUOTES, 'UTF-8'); ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group" style="margin-right: 5px;">
                                    <label for="leave-filter-category">Leave Category</label>
                                    <select class="form-control" id="leave-filter-category">
                                        <option value="">All Categories</option>
                                        <option value="<?php echo PERSONAL_TRAVEL; ?>">Personal Travel</option>
                                        <option value="<?php echo SICK_LEAVE; ?>">Sick Leave</option>
                                        <option value="<?php echo EMERGENCY_LEAVE; ?>">Emergency Leave</option>
                                        <option value="<?php echo RESEARCH_TRAVEL; ?>">International Research Travel</option>
                                    </select>
                                </div>
                                <div class="form-group" style="margin-right: 5px;">
                                    <label for="leave-filter-status">Status</label>
                                    <select class="form-control" id="leave-filter-status">
                                        <option value="">All Status</option>
                                        <option value="<?php echo LEAVE_PENDING; ?>">PENDING</option>
                                        <option value="<?php echo LEAVE_APPROVE; ?>">APPROVE</option>
                                        <option value="<?php echo LEAVE_REJECT; ?>">REJECT</option>
                                    </select>
                                </div>
                                <div class="form-group" style="margin-right: 5px;">
                                    <input type="text" class="form-control" id="leave-filter-keyword" placeholder="Search...">
                                </div>
                                <button type="button" class="btn btn-primary" id="leave-filter-btn">Filter</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="loading-alert-leave" style="display: none;">
                <div class="col-lg-12">
                    <div class="alert alert-info">
                        <i class="fa fa-spinner fa-spin"></i> Loading data...
                    </div>
                </div>
            </div>
            <div class="row" id="no-data-alert-leave" style="display: none;">
                <div class="col-lg-12">
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> No data available.
                    </div>
                </div>
            </div>
            <div class="row" id="leave-table-row">
                <div class="col-lg-12">
                    <div class="documents-container">
                        <div class="documents-content table-responsive">
                            <table class="table table-striped table-hover" id="leave-table">
                                <thead>
                                    <tr>
                                        <th width="10" class="text-center">#</th>
                                        <th>Name</th>
                                        <th>Grants</th>
                                        <th>Fiscal Year</th>
                                        <th>Leave Category</th>
                                        <th>Leave (day)</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Created Date</th>
                                        <th>Status</th>
                                        <th class="text-center" width="120">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="leave-pagination-row">
                <div class="col-lg-12">
                    <div class="documents-container">
                        <div class="documents-content clearfix" style="padding:10px 0;">
                            <div class="pull-left">
                                <span id="leave-page-info"></span>
                            </div>
                            <div class="pull-right" id="leave-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END LEAVE TABLE -->
        <?php $this->load->view('admin/partials/modal_log') ?>
    <?php endif; ?>
<?php endif; ?>
<!-- /.row -->

<style>
    .eta-status-label {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 3px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }
    .eta-status-label[data-status="1"] { background: #cce5ff; color: #004085; }
    .eta-status-label[data-status="2"] { background: #fff3cd; color: #856404; }
    .eta-status-label[data-status="3"] { background: #d4edda; color: #155724; }
    .eta-status-label[data-status="4"] { background: #d1ecf1; color: #0c5460; }
    .eta-status-label[data-status="5"] { background: #17a2b8; color: #fff; }
    .eta-status-label[data-status="6"] { background: #f8d7da; color: #721c24; }
    .eta-status-label[data-status="7"] { background: #0f6cbd; color: #fff; }
    .eta-status-label[data-status="8"] { background: #e67e22; color: #fff; }
    .eta-status-label[data-status="9"] { background: #578e9bff; color: #fff; }
    .eta-status-label[data-status="10"] { background: #cd4f46; color: #fff; }
</style>

<?php include 'select_db.php' ?>