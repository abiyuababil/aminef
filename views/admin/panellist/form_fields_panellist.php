<?php if(!isset($is_admin)) { ?>
    <style>
        #page-wrapper {
            padding: 50px !important;
        }
        body {
            font-size : 18px;
        }
        .btn {
            font-size : 18px;
        }
        .select2 {
            border-radius: 0px !important;
            width: 100% !important;
            height: 35px !important;
            padding-top: 2px !important;
            /* border: 1px solid #ccc; */
        }

        span.select2.select2-container{
            border-radius: 0px !important;
            width: 100% !important;
            height: 34px !important;
            padding-top: 2px !important;
            /* border: 1px solid #ccc; */
        }

        .select2-selection.select2-selection--single {
            border-radius: 0px !important;
            width: 100% !important;
            height: 34px !important;
            padding-top: 2px !important;
            border: 1px solid #ccc;
        }

        .select2-selection__arrow {
            margin-top: 5px !important;
        }
    </style>
<?php } ?>
<style>
    .text-desc {
        font-size : 18px;
    }
    .form-check .form-check-input {
        float: left;
        margin-left: -1.5em;
    }
</style>
<div class="row mt-5">
    <div class="col-lg-5 <?= !isset($is_admin) ? 'col-lg-offset-3' : '' ?> mt-5">
        <?php if($this->session->flashdata('error_submit_panel')) { ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?= $this->session->flashdata('error_submit_panel') ?>
            </div>
            <?php $this->session->unset_userdata('error_submit_panel');?>
        <?php } ?>
        <?php if($this->session->flashdata('success_submit_panel')) { ?>
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?= $this->session->flashdata('success_submit_panel') ?>
            </div>
            <?php $this->session->unset_userdata('success_submit_panel');?>
        <?php } ?>
        <form action="" method="post">
            <?php if(!isset($is_admin)) { ?>
            <div class="form-group">
                <h1><?= $data_form->title ?></h1>
                <div class="text-desc"><?= $data_form->description ?></div>
            </div>
            <hr />
            <?php } ?>

            <div class="form-group">
                <label>Email <small class="text-danger">*</small></label>
                <input type="email" name="email" value="<?= $_POST['email'] ? $_POST['email'] : ($data_submission['email'] ? $data_submission['email'] : '') ?>" class="form-control" placeholder="" id="email" required <?= isset($is_preview) ? 'disabled' : '' ?>>
                <input type="hidden" value="<?= $data_form->id ?>" name="form_panellist_id">
            </div>
            <?php 
                foreach($data as $key => $row) { 
                    $value_other = isset($data_submission['other_'.$row->id]) ? $data_submission['other_'.$row->id] : '';
            ?>
            <div class="form-group">
                <label><?= $row->name ?> <?= $row->is_required ? '<small class="text-danger">*</small>' : '' ?></label>
                <?= render_component_form_panellists(
                    $row, 
                    ($_POST[$row->id] ? $_POST[$row->id] : ($data_submission[$row->id] ? $data_submission[$row->id] : '')), 
                    isset($is_preview) ? 'disabled' : '', 
                    $value_other
                    ) ?>
            </div>
            <?php } ?>

            <?php if(!isset($is_preview)) { ?>
            <hr />
            <div class="form-group">
                <button id="btn-submit" class="btn btn-success">Submit</button>
            </div>
            <?php } ?>

            <?php if(isset($is_admin) && $data_panellist->is_active == 0) { ?>
            <hr />
            <div class="form-group">
                <label style="cursor:pointer;" class="form-check-label" for="chck"> Need to input Bank Information</label>
                <input type="checkbox" style="cursor:pointer;" class="form-check-input" id="chck" value="1" name="with_bank_info">
            </div>
            <div class="form-group">
                <button value="approve" name="btn-submit" id="btn-approve" onclick="return confirm('are you sure?')" class="btn btn-success">Approve</button>
                <button value="reject" name="btn-submit" id="btn-reject" class="btn btn-danger" onclick="return confirm('are you sure?')">Reject</button>
            </div>
            <?php } ?>
        </form>


        <!-- <div class="form-group">
            <label>Title <small class="text-danger">*</small></label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                <label class="form-check-label" for="exampleRadios1">
                    Default radio
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                <label class="form-check-label" for="exampleRadios2">
                    Second default radio
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="option3" disabled>
                <label class="form-check-label" for="exampleRadios3">
                    Disabled radio
                </label>
            </div>
        </div> -->
    </div>
</div>