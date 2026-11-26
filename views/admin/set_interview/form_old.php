<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<form method="POST">
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
        <div class="panel-body" style="margin-top:-30px">
            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> INTERVIEW INFORMATION</p>
            <div class="col-lg-4">
                <input type="hidden" name="interview_id" value="<?= $interview->id ?>">
                <div class="form-group">
                    <label>Date & Time Schedule</label>
                    <input type="text" readonly style="background-color:#fff" class="form-control datetime" name="date_time" placeholder="Date & Time Schedule" value="<?= $interview->date ? date('d M Y H:i', strtotime($interview->date)) : '' ?>">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Location</label>
                    <input type="text" class="form-control" placeholder="Location" name="location" value="<?= $interview->location ?>">
                </div>  
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label>Send Date</label>
                    <input type="text" readonly style="background-color:#fff" class="form-control datepicker" name="send_date" placeholder="Send Date" value="<?= $interview->send_date ? date('d M Y', strtotime($interview->send_date)) : '' ?>">
                </div>
            </div>
        </div>
        <div class="panel-body" style="margin-top:-30px">
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Note</label>
                    <textarea name="note" cols="10" rows="5" class="form-control" width="100%"><?= $interview->note ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="panel-body" >
            <?php if($interview != null){ ?>
                <button type="submit" name="btn" value="edit" class="btn btn-success">Submit</button>
            <?php } else { ?>
                <button type="submit" name="btn" value="submit" class="btn btn-success">Submit</button>
            <?php } ?>
            <a href="<?= site_url('admin/selection/manage')?>" type="button" class="btn btn-default">Back </a>
            <?php if($this->Grantee_ent_model->status != STATUS_INTERVIEW) { ?>
            <button type="button" id="btn-present" class="btn btn-primary" style="float:right;">Present </button>
            <button type="button" id="btn-decline" class="btn btn-danger" style="float:right;margin-right:5px;">Decline</button>
            <?php } ?>
        </div>
    </div>
</form>

            
<div class="modal fade text-center" id="mdl_info_decline" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p>Are you sure <br /> to Decline?</p>
                <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                <a href="<?= site_url('admin/set_interview/decline/' . $grantee_grant_id) ?>" id="submit" class="btn btn-success success">Yes</a>
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
                <a href="<?= site_url('admin/set_interview/present/' . $grantee_grant_id) ?>" id="submit" class="btn btn-success success">Yes</a>
            </div>
        </div>
    </div>
</div>
