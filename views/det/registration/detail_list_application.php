<style>
    .nav-pills>li+li {
        margin-left: 0px;
    }

    .nav-pills>li {
        background-color: #013473;
        border: 1px solid #ed3123;
    }

    .nav-pills>li>a {
        color: white;
    }

    .tab-pane {
        background-color: white;
    }

    .begin_button {
        float: right;
    }

    .nav-pills > li.active > a, .nav-pills > li.active > a:focus, .nav-pills > li.active > a:hover {
        background-color: #00b7f1 !important; 
    }
</style>

<form autocomplete="new-password" id="form" role="form" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-12" style="margin-bottom:10px; margin-top:30px;">
            <h2><b>Duolingo English Test - <?= $period->year ?></b></h2>

            <strong><?= $period->term_name ?></strong>
            <p>
                <strong>Period : </strong>
                <strong><?= date('d M Y', strtotime($period->start_date)) ?> (<?= date('H:i', strtotime($period->start_date)) ?> WIB) - <?= date('d M Y', strtotime($period->end_date)) ?> (<?= date('H:i', strtotime($period->end_date)) ?> WIB)</strong>
            </p>
            <?php 
                $notif = $this->session->userdata('error');
                if (isset($notif) && $notif != '') { ?>
                <div class="row">
                    <div class="col-lg-12" style="margin-top:30px;">
                        
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?= $this->session->flashdata('error') ?>
                        </div>
                    </div>
                </div>
            <?php }  $this->session->unset_userdata('error');?>
            <div class="tab-content" style="width: 100%;">
                <ul class="nav nav-pills nav-spec">
                    <li style="width: 11%;" class="active"><a data-toggle="tab" style="width:100%;" href="#activity" aria-expanded="true">Information</a></li>
                    <!-- <li style="width: 11%;"><a data-toggle="tab" style="width:100%;" href="#grant_length" aria-expanded="true">Grant Length</a></li>
                    <li style="width: 11%;"><a data-toggle="tab" style="width:100%;" href="#spesific_requirement" aria-expanded="true">Specific Requirements</a></li>
                    <li style="width: 11%;"><a data-toggle="tab" style="width:100%;" href="#general_requirement" aria-expanded="true">General Requirements</a></li>
                    <li style="width: 13%;"><a data-toggle="tab" style="width:100%;" href="#submission_requirement" aria-expanded="true">Submission Requirements</a></li> -->
                    <li style="width: 10%;"><a data-toggle="tab" style="width:100%;" href="#deadline_note" aria-expanded="true">Timeline</a></li>
                    <li style="width: 11%;"><a data-toggle="tab" style="width:100%;" href="#aminef" aria-expanded="true">AMINEF</a></li>
                    <li style="width: 11%;"><a data-toggle="tab" style="width:100%;" href="#contact_information" aria-expanded="true">Support</a></li>
                    <li style="width: 11%;"><a data-toggle="tab" style="width:100%;" href="#how_to_apply" aria-expanded="true">How to Apply</a></li>

                </ul>
            </div>
            <div class="tab-content" style="width: 100%;">
                <div id="activity" class="tab-pane fade active in">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?= $period->activity; ?>
                        </div>
                    </div>
                </div>
                <div id="grant_length" class="tab-pane fade">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?= $period->grant_length; ?>
                        </div>
                    </div>
                </div>
                <div id="spesific_requirement" class="tab-pane fade">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?= $period->spesific_requirement; ?>
                        </div>
                    </div>
                </div>
                <div id="general_requirement" class="tab-pane fade">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?= $period->general_requirement; ?>
                        </div>
                    </div>
                </div>
                <div id="submission_requirement" class="tab-pane fade">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?= $period->submission_requirement; ?>
                        </div>
                    </div>
                </div>
                <div id="deadline_note" class="tab-pane fade">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?= $period->deadline_note; ?>
                        </div>
                    </div>
                </div>
                <div id="how_to_apply" class="tab-pane fade">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?= $period->how_to_apply; ?>
                            <?php if($period->form_ofline != '') { ?>
                            <a href="<?= base_url($period->form_ofline) ?>" class="btn btn-info" download>Download Form</a>
                            <?php } ?>
                        </div>
                    </div>
                        
                    <div class="mt-5">
                        <a onclick="return confirm('Are you sure to choose this and already read thorough the details?');" href="<?php echo base_url('det/registration/apply/'. $period->id);?>" class="btn btn-success begin_button">BEGIN APPLICATION PROCESS</a>
                    </div>
                </div>
                <div id="aminef" class="tab-pane fade">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?= $period->aminef; ?>
                        </div>
                    </div>
                </div>
                <div id="contact_information" class="tab-pane fade">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?= $period->contact_information; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>