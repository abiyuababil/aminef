<?php
$default_tab_active = 'class="active"';
$default_content_active = 'active in';


$url_delete = base_url('admin/nominee/general_nominee/delete_file');
if($is_grantee){
    $url_delete = base_url('grantee/submission/delete_file_test');
}
?>

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
        padding: 10px;
        font-weight: bold;
    }

    #table-report tr {
        margin-top: 20px;
    }

    .invalid-tooltip {
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
        background-color: rgba(220, 53, 69, .8);
        border-radius: 0.2rem;
    }

    #delete-alert {
        position: fixed;
        top: 10px;
        right: 30px;
        z-index: 1001;
        font-weight: bold;
        border: none;
        outline: none;
        cursor: pointer;
        display: none;
    }

    #success-alert {
        position: fixed;
        top: 10px;
        right: 30px;
        z-index: 1001;
        font-weight: bold;
        border: none;
        outline: none;
        cursor: pointer;
        display: none;
    }
    
    .selected-preparation-n {
        display:none;
    }
    
    .selected-preparation-b {
        display:block;
    }

    .d-none-testing {
        display: none !important;
    }
    .panel-default .panel-heading-test-section{
        background-color: rgb(236 240 244);
        color: #000;
        /* border-radius: 8px;
        border-top-left-radius: 8px !important;
        border-top-right-radius: 8px !important; */
        padding: 20px;
    }

    .panel-collapse{
        border: 1px solid rgb(236 240 244);
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

    /* .panel-title-parent {
        font-weight: 700;
    } */
    .TriSea-technologies-Switch > input[type="checkbox"] {
        display: none;   
    }

    .TriSea-technologies-Switch > label {
        cursor: pointer;
        height: 0px;
        position: relative; 
        width: 40px;  
    }

    .TriSea-technologies-Switch > label::before {
        background: rgb(0, 0, 0);
        box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
        border-radius: 8px;
        content: '';
        height: 16px;
        margin-top: -8px;
        position:absolute;
        opacity: 0.3;
        transition: all 0.4s ease-in-out;
        width: 40px;
    }
    .TriSea-technologies-Switch > label::after {
        background: rgb(255, 255, 255);
        border-radius: 16px;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
        content: '';
        height: 24px;
        left: -4px;
        margin-top: -8px;
        position: absolute;
        top: -4px;
        transition: all 0.3s ease-in-out;
        width: 24px;
    }
    .TriSea-technologies-Switch > input[type="checkbox"]:checked + label::before {
        background: inherit;
        opacity: 0.5;
    }
    .TriSea-technologies-Switch > input[type="checkbox"]:checked + label::after {
        background: inherit;
        left: 20px;
    }

    .no-margin {
        margin: 8px;
    }
</style>


<div class="row <?= $is_grantee || $is_alumni_page ? 'd-none' : '' ?>">
    <div class="col-lg-12">
        <h1><?=$title ?></h1>
        <h3 class="page-header"><?=$grantee_grant->grant_name ?> (<?= $grantee_grant->fiscal_year_period ?>)</h3>
    </div>
</div>
<?php if (isset($notif_success) && $notif_success != '' && !$is_grantee) { ?>
    <div class="alert alert-success alert-dismissable mt-3">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $notif_success ?>
    </div>
<?php } ?>
<?php $this->session->unset_userdata('notif_success');?>
<?php if (isset($notif_error) && $notif_error != '') { ?>
    <div class="alert alert-danger alert-dismissable mt-3">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $notif_error ?>
    </div>
<?php } ?>
<div class="alert alert-success mt-3" id="success-alert" style="width:200px">
    <button type="button" class="close" data-dismiss="alert">x</button>
    Delete <strong>Success! </strong>
</div>
<div class="alert alert-danger mt-3" id="delete-alert" style="width:200px">
    <button type="button" class="close" data-dismiss="alert">x</button>
    Delete <strong>Failed! </strong>
</div>
<form id="frm_manage" name="frm_manage" method="GET"></form>
<form autocomplete="new-password" id="form" role="form" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="section" value="test_section">
    <div class="row warp-alumni-page">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="tabs">
                                <ul id="tab-test-section">
                                    <?php if ($grantee_grant->show_toefl_section && ($show_toefl || $is_admin)){ ?>
                                    <li>
                                        <a aria-expanded="true" data-toggle="tab" href="#toefls" aria-expanded="true">TOEFL</a>
                                    </li>
                                    <?php } ?>
                                    <?php if ($grantee_grant->show_gre_section && ($show_gre || $is_admin)){ ?>
                                    <li>
                                        <a aria-expanded="true" data-toggle="tab" href="#gres" aria-expanded="true">GRE</a>
                                    </li>
                                    <?php } ?>
                                    <?php if ($grantee_grant->show_gmat_section && ($show_gmat || $is_admin)) { ?>
                                    <li>
                                        <a aria-expanded="true" data-toggle="tab" href="#gmats" aria-expanded="true">GMAT</a>
                                    </li>
                                    <?php } ?>
                                    <?php if ($grantee_grant->show_gre_subject_section && ($show_gress || $is_admin)) { ?>
                                    <li>
                                        <a aria-expanded="true" data-toggle="tab" href="#gress" aria-expanded="true">GRE Subject</a>
                                    </li>
                                    <?php } ?>
                                    <?php if ($grantee_grant->show_duolingo_section && ($show_duolingo || $is_admin)) { ?>
                                    <li>
                                        <a aria-expanded="true" data-toggle="tab" href="#duolingo" aria-expanded="true">Duolingo</a>
                                    </li>
                                    <?php } ?>
                                    <?php if ($grantee_grant->show_toefl_itp_section && ($show_itp || $is_admin)) { ?>
                                    <li>
                                        <a aria-expanded="true" data-toggle="tab" href="#toefl_itp" aria-expanded="true">TOEFL ITP</a>
                                    </li>
                                    <?php } ?>
                                </ul>
                                <div class="row">
                                    <div class="col col-lg-12">
                                        <div class="tab-content">
                                            <?php $this->load->view('admin/nominee/partial/test_section_toefl') ?>
                                            <?php $this->load->view('admin/nominee/partial/test_section_gre') ?>
                                            <?php $this->load->view('admin/nominee/partial/test_section_gmat') ?>
                                            <?php $this->load->view('admin/nominee/partial/test_section_gre_subject') ?>
                                            <?php $this->load->view('admin/nominee/partial/test_section_duolingo') ?>
                                            <?php $this->load->view('admin/nominee/partial/test_section_toefl_itp') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if($is_grantee) { ?>
                <div class="panel-body hide">
                    <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> Payment</p>
                    <div class="col-lg-9">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Total Payment (IDR)</th>
                                    <th>Total Payment (USD)</th>
                                    <th>Proof of Transfer</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach($payment_items as $p_item) { ?>
                                    <?php if($p_item->proof) { ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= $p_item->nominal_idr ? format_money($p_item->nominal_idr, 'IDR') : '' ?></td>
                                        <td><?= $p_item->nominal ? format_money($p_item->nominal, 'USD') : '' ?></td>
                                        <td>
                                            <?php if($p_item->proof) { ?>
                                            <a href="<?php echo site_url($p_item->proof); ?>" class="lightbox btn btn-primary btn-xs" aria-haspopup="dialog">
                                                View
                                            </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php $no++; } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php // foreach($payment_items as $p_item) { ?>
                        <?php // if($p_item->proof_of_payment) { ?>
                        <!-- <div class="col-lg-4">
                            <div class="form-group">
                                <label><?= $p_item->payment_item_name ?></label>
                                <?php // if($p_item->proof_of_payment) { ?>
                                    <div style="margin-bottom:10px; position:relative; width:100px;">
                                        <a href="<?php // echo site_url($p_item->proof_of_payment); ?>" class="lightbox" aria-haspopup="dialog">
                                            <img id="preview_image_profile" data-old="<?php // echo site_url($p_item->proof_of_payment); ?>" src="<?php // echo get_preview($p_item->proof_of_payment); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                        </a>
                                        <a href="<?php // echo base_url($p_item->proof_of_payment) ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php // echo empty($p_item->proof_of_payment) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;">
                                            <i class="fa fa-download fa-fw"></i>
                                        </a>
                                    </div>
                                <?php // } ?>
                            </div>
                        </div> -->
                        <?php // } ?>
                    <?php // } ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="row">
        <?php if(!$is_alumni_page) { ?>
        <?php if(!$is_grantee) { ?>
        <!-- table payment -->
        <?php if(has_permission('nominee', 'test_section_payment') || $is_grantee) { ?>
        <div class="tab-content">
            <div id="record" class="tab-pane fade active in">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div id="content">
                            <div class="panel-body">
                                <div class="data-header clearfix form-inline">
                                    <div class="pull-left">
                                        Search : <input type="search" class="form-control input-sm" form="frm_manage" name="search" value="<?= $paging['search'] ?>" placeholder="Description">

                                        Status :
                                        <select class="form-control input-sm" name="status" form="frm_manage" onchange="document.forms.frm_manage.submit()">
                                            <option value="">-- Select Status --</option>
                                            <?php
                                            foreach ($record_status as $rs) {
                                                $selected = '';
                                                if ($rs->id == $paging['status']) $selected = 'selected';
                                            ?>
                                                <option value="<?=$rs->id ?>" <?=$selected ?>><?=$rs->name ?></option>
                                            <?php } ?>
                                        </select>

                                        Year :
                                        <select class="form-control input-sm" name="year" form="frm_manage" onchange="document.forms.frm_manage.submit()">
                                            <option value="">-- Select Year --</option>
                                            <?php for ($i=date('Y', strtotime('+5 years')); $i > 1900; $i--) : ?>
                                                <?php 
                                                    $selected = '';
                                                    if ($i == $paging['year']) {
                                                        $selected = 'selected';
                                                    }    
                                                ?>
                                                <option <?= $selected ?> value="<?= $i; ?>"><?= $i;?></option>
                                            <?php endfor; ?>
                                        </select>
                                        
                                        Show :
                                        <select class="form-control input-sm" name="limit" form="frm_manage" onchange="document.forms.frm_manage.submit()">
                                            <?php
                                            foreach ($limit['limit_options'] as $lo) {
                                                $selected = '';
                                                if ($lo == $paging['limit']) $selected = 'selected';
                                            ?>
                                                <option value="<?=$lo ?>" <?=$selected ?>><?=$lo ?></option>
                                            <?php } ?>
                                        </select>
                                        entries
                                    </div>
                                    <div class="pull-right">
                                        <a href="#" data-toggle="modal" data-target="#mdl_add_record" <?=$disabled; ?> class="<?=$disabled; ?> btn btn-success btn-sm "  id="btn-add">
                                            ADD NEW PAYMENT
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th width="35" class="text-center">#</th>
                                                <th>Payment Date</th>
                                                <th>Description</th>
                                                <th>Total Payment (IDR)</th>
                                                <th>Total Payment (USD)</th>
                                                <th>Proof</th>
                                                <th>Status</th>
                                                <th width="150" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($payment_record) {
                                                $no = $paging['start_row'];
                                                foreach ($payment_record as $row) {
                                            ?>
                                                    <tr>
                                                        <td><?= $no ?></td>
                                                        <td><?= $row->payment_date ? date('d M Y', strtotime($row->payment_date)) : '' ?></td>
                                                        <td><?=$row->description; ?></td>
                                                        <td>
                                                            <?php
                                                            $total_payment_idr = [];
                                                            foreach ($row->items as $key => $item) {
                                                                array_push($total_payment_idr, $item->nominal_idr);
                                                            }
                                                            ?>
                                                            <?= format_money(array_sum($total_payment_idr), 'IDR') ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $total_payment = [];
                                                            foreach ($row->items as $key => $item) {
                                                                array_push($total_payment, $item->nominal);
                                                            }
                                                            ?>
                                                            <?= format_money(array_sum($total_payment), 'USD') ?>
                                                        </td>
                                                        <td>
                                                            <?php if (!empty($row->proof)) { ?>
                                                                <a href="<?=base_url($row->proof) ?>" target="_blank"><label class="label label-primary" style="cursor:pointer">View Proof Of Transfer</label></a>
                                                            <?php } ?>
                                                        </td>
                                                        <td><?= $row->payment_status ?></td>
                                                        <td class="text-center">
                                                            <a href="#" data-toggle="modal" data-target="#mdl_edit_record" data-record_id="<?= $row->id ?>" class="btn btn-primary btn-xs <?=$disabled; ?>">
                                                                <i class="fa fa-edit"></i> Edit
                                                            </a>
                                                            <a href="<?= site_url('admin/request_payment/delete_record/' . $row->id) ?>" class="btn btn-danger btn-xs confirm-del <?=$disabled; ?>">
                                                                <i class="fa fa-times-circle"></i> Delete
                                                            </a>
                                                        </td>
                                                    </tr>
                                            <?php
                                                    $no++;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                                <div class="pull-left">
                                    Showing <?=$paging['start_row'] ?> to <?=$paging['end_row'] ?> of <?=$paging['total_rows'] ?> entries
                                </div>
                                <!-- /.pagination info -->
                                <?=$paging['html'] ?>
                                <!-- /.pagination -->
                                <input type="hidden" name="sort_by" value="<?=$sort_by ?>">
                                <input type="hidden" name="sort" value="<?=$sort ?>">
                                <input type="hidden" id="delete_detail_payment_record" name="edit_record[delete_detail_payment_record]">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php } ?>
        <?php } ?>

    </div>
    <?php if(!$is_alumni_page) { ?>
    <div class="row">
        <div class="col-lg-12" style="margin-bottom:10px;">
            <div style="margin-bottom:10px;" class="pull-right">
                <?php if (!isset($is_grantee)) { ?>
                    <a href="<?= $back_url ?>" class="btn btn-primary mr-2">Back</a>
                    <!-- <button type="submit" id="btn-submit" class="btn btn-success btn-submit" name="btn" value="save">Save</button> -->
                    <a href="#" data-id="<?= $grantee_grant_id ?>" data-section="candidate" class="btn btn-warning withdraw">Withdraw</a>
                    <a href="#" data-id="<?= $grantee_grant_id ?>" data-section="candidate" class="btn btn-danger drop">Drop</a>
                    <input type="hidden" id="data_section" value="test_section">
                <?php } ?>
            </div>
        </div>
    </div>
    <?php } ?>
</form>


<?php $this->load->view('admin/partials/modal_confirm') ?>
<?php $this->load->view('admin/partials/modal_add_payment_record') ?>
<?php $this->load->view('admin/partials/modal_edit_payment_record') ?>

<?php
if (!empty($payment_record)) :
    $final_record = [];
    foreach ($payment_record as $record) {
        $final_record[$record->id] = $record;
    }
?>
    <script>
        var currentUserReviews = JSON.parse(`<?=safe_parse_json(json_encode($final_record)); ?>`);
    </script>
<?php endif; ?>