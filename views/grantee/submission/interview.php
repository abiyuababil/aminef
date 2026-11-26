<style>
    h3{
        margin-top: 10px;
    }
    .action-button{
        float:right;
        margin-bottom:20px;
        width:100px;"
    }
</style>
<div class="row">
    <div class="col-lg-12 text-center">
        <h2 style="color:#0089d1">Interview</h2>
        <h1 class="page-header"><?php echo $title ?></h1>
    </div>
</div>
<div class="row">
    <div class="containt text-center">
        <ul class="progressbar">
            <?php foreach ($detail_data['step'] as $index => $step) : ?>
                <li id="li_step_<?=$step->sort; ?>" onclick="reset_done(<?=$step->sort; ?>, this)" data-id="step_<?= $step->sort; ?>" class="<?php if($index == 0) {echo 'active done';} ?> stepper-list"><a aria-expanded="true" data-toggle="tab" href="#step_<?= $step->sort?>" ><?= $step->sort; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<div class="row">
    <?php if ($grantee_detail->status != STATUS_WAITING_FOR_INTERVIEW && $grantee_detail->status != STATUS_INTERVIEW && $grantee_detail->status != STATUS_SELECTION_DECLINED) : ?>
        <div class="alert alert-danger">You're not ready for this stage yet!</div>
    <?php endif; ?>

    <?php if ($error = $this->session->flashdata('error')) : ?>
        <?= show_alert('danger', $error); ?>
    <?php endif; ?>

    <?php if ($success = $this->session->flashdata('success')) : ?>
        <?= show_alert('success', $success); ?>
    <?php endif; ?>

    <form action="" id="form-submission" method="POST">
    <div class="tab-content">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>Grantee Information</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label>Name</label>
                                <input type="text" name="" readonly value="<?= $grantee_detail->first_name . " " . $grantee_detail->middle_name . " " . $grantee_detail->last_name; ?>" id="" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Grant</label>
                                <input type="text" name="" readonly value="<?= $title; ?>" id="" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Period</label>
                                <input type="text" name="" readonly value="<?= $grantee_detail->first_name . " " . $grantee_detail->middle_name . " " . $grantee_detail->last_name; ?>" id="" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label>Email</label>
                                <input type="email" name="" readonly value="<?= $grantee_detail->primary_email; ?>" id="" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Phone Number</label>
                                <input type="text" name="" readonly value="<?= $grantee_detail->phone_number; ?>" id="" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>Interview Information</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label>Date & Time Schedule</label>
                                <input type="text" readonly name="" value="<?= $interview_detail->date ? format_date_time($interview_detail->date) : ''; ?>" id="" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Location</label>
                                <input type="text" readonly name="" value="<?= $interview_detail->location; ?>" id="" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label>Note</label>
                                <textarea name="" readonly id="" cols="30" rows="10" class="form-control"><?= $interview_detail->note?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if ($grantee_detail->status == STATUS_WAITING_FOR_INTERVIEW) : ?>
                <!-- <div class="progressbar">
                    <input type="submit" name="submit_action" value="Present" class="action-button btn btn-primary">
                    <input type="submit" name="submit_action" value="Declined" class="action-button btn btn-danger" style="margin-right: 5px;">
                </div> -->
                <?php endif; ?>
            </div>
    </div>
    </form>
</div>
<!-- /.row -->
