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
    <?php if(isset($is_preview)) { ?>
    <div class="col-lg-12">
        <a href="<?= base_url('eta/application/pdf/'.$submission_id)?>" download class="btn btn-primary pull-right download-pdf">Download PDF</a>
    </div>
    <?php } ?>
    <div class="col-lg-12">
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
        <form action="" method="post" enctype="multipart/form-data">
            <?php //if(!isset($is_admin)) { ?>
            <div class="form-group">
                <h1><?= $data_form->title ?></h1>
                <div class="text-desc"><?= $data_form->description ?></div>
            </div>
            <hr />
            <?php //} ?>

            <!-- <div class="form-group">
                <label>Email <small class="text-danger">*</small></label>
                <input type="email" name="email" value="<?= $_POST['email'] ? $_POST['email'] : ($data_submission['email'] ? $data_submission['email'] : '') ?>" class="form-control" placeholder="" id="email" required <?= isset($is_preview) ? 'disabled' : '' ?>>
            </div> -->
            <input type="hidden" value="<?= $data_form->id ?>" name="eta_host_school_application_id">
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
        </form>
    </div>
</div>