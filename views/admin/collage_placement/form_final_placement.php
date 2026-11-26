            <div class="row">
                <div class="col-lg-12">
					<h1 class="page-header"><?php echo $title ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="panel-body" style="margin-top:-30px">
                        <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> GRANTEE INFORMATION</p>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" disabled="disabled" class="form-control" name="bank_name" value="<?= get_full_name($this->Grantee_ent_model) ?>">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Grant</label>
                                <input type="text" disabled="disabled" class="form-control" name="bank_address" value="<?= $this->User_grantee_grant_model->name ?>">
                            </div>  
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Period</label>
                                <input type="text" disabled="disabled" class="form-control" name="beneficiary_name" value="<?= $this->User_grantee_grant_period_model->fiscal_year ?>">
                            </div>  
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" disabled="disabled" class="form-control" name="account_number" value="<?= $this->Grantee_ent_model->primary_email ?>">
                            </div>  
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="text" disabled="disabled" class="form-control" name="routing_number" value="<?= $this->Grantee_ent_model->phone_number ?>">
                            </div>  
                        </div>
                    </div>

                    <!-- FINAL PLACEMENT -->
                    <div class="panel-body" style="margin-top:-30px">
                        <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> FINAL PLACEMENT</p>
                        <div class="col-lg-4">
                            <?php if($collage_placement->id) { ?>
                            <input type="hidden" name="interview_id" value="<?= $collage_placement->id ?>">
                            <?php } ?>
                            <div class="form-group">
                                <label>University</label>
                                <input type="hidden" class="form-control" placeholder="University" id="university" name="university" value="<?= $submission_plans->university_id ?>">
                                <input type="text" class="form-control" placeholder="University" id="university_name" name="university_name" value="<?= $submission_plans->university_name ?>" disabled>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Department</label>
                                <input type="text" class="form-control" placeholder="Department" name="department" value="<?= $collage_placement->department ?>">
                            </div>  
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Estimated Cost</label>
                                <input type="text" class="form-control" name="estimate_cost" placeholder="Estimated Cost" value="<?= $collage_placement->estimate_cost ?>">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Time of Arrival (ToA)</label>
                                <input type="text" readonly style="background-color:#fff" class="form-control datepicker" placeholder="Time of Arrival (TOA)" name="toa" value="<?= $collage_placement->toa ? date('d M Y', strtotime($collage_placement->toa)) : '' ?>">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Bank Statement</label>
                                <input type="text" class="form-control" name="bank_statement" placeholder="Bank Statement" value="<?= $collage_placement->bank_statement ?>">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="text" readonly style="background-color:#fff" class="form-control datepicker" placeholder="Start Date" name="start_date" value="<?= $collage_placement->start_date ? date('d M Y', strtotime($collage_placement->start_date)) : '' ?>">
                            </div>  
                        </div>
                    </div>
                    <!-- FINAL PLACEMENT END -->

                    <div class="panel-body" style="margin-top:-30px">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Shortfails</label>
                                <textarea name="shortfails" cols="10" rows="3" class="form-control" width="100%"><?= $collage_placement->shortfails ?></textarea>
                            </div>  
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Note</label>
                                <textarea name="note" cols="10" rows="3" class="form-control" width="100%"><?= $collage_placement->note ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="panel-body" >
                        <?php if($collage_placement != null){ ?>
                            <button type="submit" name="btn" value="edit" class="btn btn-success">Submit</button>
                        <?php } else { ?>
                            <button type="submit" name="btn" value="submit" class="btn btn-success">Submit</button>
                        <?php } ?>
                        <a href="<?= site_url('admin/candidate/manage')?>" type="button" class="btn btn-default">Back </a>
                        <!-- <button type="button" id="btn-present" class="btn btn-primary" style="float:right;">Present </button>
                        <button type="button" id="btn-decline" class="btn btn-danger" style="float:right;margin-right:5px;">Decline</button> -->
                    </div>
                </div>
            </form>

            
<div class="modal fade text-center" id="mdl_info_decline" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p>Are you sure <br /> to Decline?</p>
                <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                <a href="<?= site_url('admin/set_interview/decline/' . $this->Grantee_ent_model->id) ?>" id="submit" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade text-center" id="mdl_info_present" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p>Are you sure <br /> to Present?</p>
                <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                <a href="<?= site_url('admin/set_interview/present/' . $this->Grantee_ent_model->id) ?>" id="submit" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>
