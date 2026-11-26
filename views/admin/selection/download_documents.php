<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default mt-4" style="background-color: white !important;">
            <div class="row">
                <div class="col-md-12">
                    <div class="accordion" id="accordionExample">
                        <div class="card">
                            <div class="card-header bg-primary text-white" id="headingOne" style="border-bottom: 2px solid #ddd;">
                                <button class="bg-primary btn-link text-white" style="color: white !important; text-decoration:none;" type="button" data-toggle="collapse" data-target="#collapse_programs" aria-expanded="true" aria-controls="collapse_programs">
                                    <h5>Select Program</h5>
                                </button>
                            </div>
                            <div id="collapse_programs" class="collapse in" aria-labelledby="headingOne" aria-expanded="true" data-parent="#accordionExample">
                                <div class="card-body p-4" style="background-color: white; position: relative; z-index: 1;">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Select Active Grant</label>
                                            <select class="form-control select2" id="program" name="program_id">
                                                <option value="">Select Program</option>
                                                <?php foreach ($programs as $program) { ?>
                                                    <option value="<?php echo $program->user_grantee_grant_id; ?>"><?php echo $program->program_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Select Period</label>
                                            <select class="form-control" id="period" name="period_id">
                                                <option value="">Select Period</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Download Option</label>
                                                <div>
                                                    <label for="checbox-hide-personal-info">
                                                        <input id="checbox-hide-personal-info" type="checkbox" value="1" checked> Hide Personal & Contact Informations
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-header bg-primary text-white" id="headingTwo" style="border-bottom: 2px solid #ddd;">
                                <button class="bg-primary btn-link text-white" style="color: white !important; text-decoration:none;" type="button" data-toggle="collapse" data-target="#collapse_user_grantee" aria-expanded="true" aria-controls="collapse_user_grantee">
                                    <h5>Select Applicant</h5>
                                </button>
                            </div>
                            <div id="collapse_user_grantee" class="collapse in" aria-labelledby="headingTwo" aria-expanded="true" data-parent="#accordionExample">
                                <div class="card-body p-4" style="background-color: white; position: relative; z-index: 1;">
                                    <div class="row search-filter-section hide" style="margin-bottom: 15px;">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-inline">
                                                <label style="font-weight: normal;">
                                                    Show 
                                                    <select id="entries-per-page" class="form-control input-sm" style="display: inline-block; width: auto; margin: 0 5px;">
                                                        <option value="10" selected>10</option>
                                                        <option value="25">25</option>
                                                        <option value="50">50</option>
                                                        <option value="100">100</option>
                                                        <option value="all">All</option>
                                                    </select>
                                                    entries
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 text-right">
                                            <div class="form-inline pull-right">
                                                <label style="font-weight: normal;">
                                                    Search: 
                                                    <input id="search-data" type="text" class="form-control input-sm" placeholder="Search..." style="display: inline-block; width: 220px; margin-left: 5px;">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <td width="2%">
                                                    <label for="select-all-applicant">
                                                        <input type="checkbox" id="select-all-applicant" disabled>
                                                    </label>
                                                </td>
                                                <td>Full Name</td>
                                                <td>Submission Date</td>
                                                <td>Period</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody class="applicant-list">
                                            <tr>
                                                <td width="100%" colspan="5" class="text-center">Please select program</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="row pagination-section hide" style="margin-top: 15px; margin-bottom: 15px;">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="pagination-info" style="padding-top: 8px;">
                                                Showing <span id="page-start">0</span> to <span id="page-end">0</span> of <span id="total-entries">0</span> entries
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 text-right">
                                            <div id="pagination-controls" class="pull-right"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 p-0 mb-2">
                                        <button class="btn btn-primary hide" id="download-documents">Download Selected</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>