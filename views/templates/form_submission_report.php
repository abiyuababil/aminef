<style>
    .containt {
        margin: 0px auto 30px auto;
    }

    .progressbar {
        counter-reset: step;
        margin: 0px;
        padding: 0px;
    }

    .progressbar li {
        display: inline-block;
        list-style-type: none;
        width: 25%;
        /* float: left; */
        font-size: 12px;
        position: relative;
        text-align: center;
        text-transform: uppercase;
        color: #7d7d7d;
    }

    .progressbar li {
        width: 30px;
        height: 30px;
        line-height: 30px;
        background-color: #b5b5b5;
        /* display: block; */
        text-align: center;
        margin: auto 10px;
        border-radius: 50%;
        cursor: pointer;
    }

    .progressbar li a {
        color: white !important;
        text-decoration: none;
    }

    .progressbar li:after {
        width: 100%;
        height: 2px;
        content: '';
        position: absolute;
        background-color: #7d7d7d;
        top: 15px;
        left: -50%;
        z-index: -1;
    }

    .progressbar li:first-child:after {
        content: none;
    }

    .progressbar li.active {
        color: white;
        background-color: #0089d1;
    }

    .progressbar li.done {
        color: white;
        background-color: #0089d1;
    }

    .progressbar li.active+li:after {
        background-color: #55b776;
    }

    .btn_step {
        width: 150px;
    }

    .next {
        float: right;
    }

    #table-report td {
        height: 80px;
        vertical-align: top;
        padding:10px;
        font-weight:bold;
    }
    #table-report tr {
        margin-top:20px;
    }

    .invalid-tooltip{
        position: absolute;
        top: auto;
        z-index: 5;
        display: none;
        max-width: 100%;
        padding: 0.5rem;
        margin-top: 0.1rem;
        font-size: 12px;
        line-height: 1;
        color: #fff;
        background-color: rgba(220,53,69,.8);
        border-radius: 0.2rem;
    }
    
    #success-alert{
        position: fixed;
        top: 10px;
        right: 30px;
        z-index: 1001;
        font-weight: bold;
        border: none;
        outline: none;
        cursor: pointer;
        display:none;
    }
    input[type='radio'] {
        -webkit-appearance:none;
        width:15px;
        height:15px;
        border:1px solid #b455fb;
        border-radius:50%;
        outline:none;
    }
    input[type='radio']:hover {
        box-shadow:0 0 5px 0px orange inset;
    }
    input[type='radio']:before {
        content:'';
        display:block;
        width: 55%;
        height: 55%;
        margin: 25% auto;
        border-radius: 50%;    
    }
    input[type='radio']:checked:before {
        background:blue;
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><?php echo $title ?></h3>
    </div>
</div>
<?php if (isset($notif_success) && $notif_success != '') { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $notif_success ?>
    </div>
<?php } ?>
<?php if (isset($notif_error) && $notif_error != '') { ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $notif_error ?>
    </div>
<?php } ?>

<form autocomplete="new-password" id="form" role="form" method="POST" enctype="multipart/form-data">
    <input type="hidden" value="<?= $grantee_grant->grant_id ?>" id="grant_id">
    <input type="hidden" value="<?= $grantee_grant->fiscal_year ?>" id="fiscal_year">
    <div class="row">
        <div class="col-lg-12" style="margin-bottom:10px">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Upload Report</label>
                        <?php if($category_report->report_file != '') { ?>
                            <br>
                            <img 
                                height="100"
                                src="<?php echo get_preview($category_report->report_file); ?>"
                            >
                            <a href="<?= base_url($category_report->report_file) ?>" download title="Click to download" class="btn btn-primary btn-xs" style="position:absolute;">
                                <i class="fa fa-download fa-fw text-white"></i>
                            </a>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <a href="<?= base_url('admin/grantee/download_report/'.$grantee_grant->id.'/'.$category_report->id)?>" target="_blank" class="btn btn-info" style="float:right">Download PDF</a>
                </div>
            </div>
            <?php 
                if($category_report->status == 'submited'){
                    $status_name = "Document Submitted";
                }elseif($category_report->status == 'revisi'){
                    $status_name = "Not Completed";
                }elseif($category_report->status == 'accept'){
                    $status_name = "Completed";
                }else{
                    $status_name = "Not Submitted";
                }
            ?>
            <h2 class="text-center"><?= $category_report->name ?> - <?= $status_name ?></h2>
            <div style="font-weight:bold;"><?= $category_report->information ?></div>
        </div>
        
        <div class="mt-5">
            <?php 
                $no = 1;
                $file = 1;
                foreach($category_report->custom_field_report as $key => $cf) {    
                    $cf->period_id = $grantee_grant->fiscal_year;
            ?>
            <!-- template for others instead file template -->
            <?php if ($cf->type != 'file') : ?>
                <div class="row form-group">
                    <?php if ($cf->type == 'separator') : ?>
                        <div class="col-md-5 text-left"><b><?= preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a target="_blank" href="$1" style="color:blue !important;">$1</a>', $cf->name); ?></b></div>
                    <?php else: ?>
                        <!-- <div class="col-md-1 text-left" style="font-weight:bold"><?= $no ?>.</div> -->
                        <div class="col-md-4 text-left custom-field-section-<?php echo $cf->id; ?>"><?= preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a target="_blank" href="$1" style="color:blue !important;">$1</a>', $cf->name); ?><?= label_required($cf->is_required); ?></div>
                        <?php $no++; ?>
                    <?php endif; ?>
                    <div class="col-md-7">
                        <?= get_component($cf, '', $cf->value_custom_fields); ?>
                    </div>
                </div>
            <?php else : ?>
                <?php 
                    if ($file == 3 || $category_report->custom_field_report[$key+1]->type == 'file') { 
                        $file = 0; 
                        $row = ""; 
                        $exitrow = ""; 
                    }else{
                        $row="<div class='row form-group'>"; 
                        $exitrow="</div>";
                    }
                ?>
                
                <?= $row; ?>
                <div class="col-lg-4">
                    <label><?= preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a target="_blank" href="$1" style="color:blue !important;">$1</a>', $cf->name); ?></label>
                    <p id="file_name1" style="font-size:16px">No file chosen</p>
                    <a href="javascript:;" class="btn btn-danger" id="btn-upload1">Upload</a>
                    <input type="file" id="my_file1" style="display: none;">
                    <a class="btn btn-success">save</a>
                    <hr>
                </div>
                <?= $exitrow; ?>
            <?php $file++;endif; ?>

            <?php } ?>
        </div>

        
        <div class="col-lg-12 mb-3">
            <div class="form-group">
                <label>Note</label>
                <textarea class="form-control" rows="4" id="note<?= $category_report->report_id ?>"><?= $category_report->note ?></textarea>
            </div>
        </div>
        <?php if($category_report->status == 'submited' ||  $category_report->status == 'revisi') { ?>
        <div class="col-lg-12 mb-3">
            <button type="button" onclick="accept_report(<?= $category_report->report_id ?>, <?= $grantee_grant->user_grantee_id ?>)" class="btn btn-success" style="float:right;">Accept</button>
            <button type="button" onclick="revisi_report(<?= $category_report->report_id ?>, <?= $grantee_grant->user_grantee_id ?>)" class="btn btn-warning" style="float:right;margin-right: 10px;">Revised</button>
        </div>
        <?php } ?>
    </div>
</form>