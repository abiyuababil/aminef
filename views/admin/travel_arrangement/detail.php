<style>
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

    th {
        /* text-align: center; */
        vertical-align: top !important;
    }
    .table-appointment th {
        /* text-align: center; */
        vertical-align: top !important;
    }
    .table-required th {
        /* text-align: center; */
        vertical-align: top !important;
    }

    .span-note:hover {
        background-color: #df7401;
        cursor: pointer;
    }
    .TriSea-technologies-Switch {
        margin-left: 15px;
    }
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

    .needdatepicker {
        background-color: #fff !important;
    }

    .no-margin {
        margin: 8px;
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
<?php 
$url_delete = base_url('admin/travel_arrangement/delete_file');
if($is_grantee){
    $url_delete = base_url('grantee/submission/delete_file_travel');
}
?>
<?php if($is_admin) { ?>
<div class="row warp-alumni-page">
    <div class="col-lg-12">
        <h1><?= get_full_name($grantee_grant) ?></h1>
        <h3 class="page-header">
            <?= $grantee_grant->grant_name ?> (<?= $grantee_grant->fiscal_year_period ?>)
            <div class="pull-right">
                <button id="btn-migrate-grantee" class="btn btn-warning mb-5" data-grantee-id="<?php echo $grantee_grant->id; ?>">
                    <i class="fa fa-replace"></i>Sync data Travel
                </button>
                <a href="<?= base_url('admin/travel_arrangement/sort/' . $grantee_grant->id) ?>" id="btn-sort" class="btn btn-info mb-5" target="_blank">
                    <i class="fa fa-arrows"></i> Sorting
                </a>
            </div>
        </h3>
    </div>
</div>
<?php } else { ?>
    <div class="row">
        <div class="col-lg-12 text-center">
            <h2 style="color:#0089d1">Travel Arrangement</h2>
            <h1 class="page-header"><?php echo $title ?></h1>
            <!-- <h2><?= $grantee_grant->status_name ?></h2> -->
        </div>
    </div>
<?php } ?>

<?php if($this->session->flashdata('success')) { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= $this->session->flashdata('success') ?>
    </div>
<?php } ?>
<?php $this->session->unset_userdata('success');?>
<form id="form" method="POST" enctype="multipart/form-data" class="warp-alumni-page">
    <input type="hidden" name="btn" id="btn_value">
    <input type="hidden" name="btn_save_and_send" id="btn_save_and_send">
    <div class="row">
        <div class="col-lg-12">
            <!-- <div class="panel"> -->
                <!-- <pre id="migrate-output" style="white-space:pre-wrap;margin-top:10px;"></pre>
                 <div id="migrate-output"></div> -->
            <!-- </div> -->
            <div class="panel panel-default">
                <?php if($is_admin) { ?>
                <div class="panel-body">
                    <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> GRANTEE INFORMATION</p>
                    <!-- <div class="col-lg-2">
                        <div class="form-group">
                            <label>KTP</label>
                            <div style="margin-bottom:10px; position:relative; width:100px;">
                                <a href="<?php echo site_url($grantee_grant->img_passport); ?>" class="lightbox" aria-haspopup="dialog">
                                    <img id="preview_image_passport_id" data-old="<?php echo site_url($grantee_grant->img_passport); ?>" src="<?php echo get_preview($grantee_grant->img_passport); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Visa</label>
                            <div style="margin-bottom:10px; position:relative; width:100px;">
                                <a href="<?php echo site_url($visa_grantee->visa_page); ?>" class="lightbox" aria-haspopup="dialog">
                                    <img id="preview_image_passport_id" data-old="<?php echo site_url($visa_grantee->visa_page); ?>" src="<?php echo get_preview($visa_grantee->visa_page); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Passport</label>
                            <div style="margin-bottom:10px; position:relative; width:100px;">
                                <a href="<?php echo site_url($grantee_grant->img_passport_id); ?>" class="lightbox" aria-haspopup="dialog">
                                    <img id="preview_image_passport_id" data-old="<?php echo site_url($grantee_grant->img_passport_id); ?>" src="<?php echo get_preview($grantee_grant->img_passport_id); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                </a>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-lg-6">
                        <table class="table table-striped table-bordered table-responsive">
                            <tr>
                                <td>KTP</td>
                                <td>
                                    <?php if($grantee_grant->img_passport == NULL || $grantee_grant->img_passport == '') { ?>
                                        No File Uploaded
                                    <?php } else { ?>
                                        <a href="<?php echo site_url($grantee_grant->img_passport); ?>" class="lightbox" aria-haspopup="dialog">
                                            <?php echo basename($grantee_grant->img_passport); ?>
                                        </a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Visa</td>
                                <td>
                                    <?php if($visa_grantee->visa_page == NULL || $visa_grantee->visa_page == '') { ?>
                                        No File Uploaded
                                    <?php } else { ?>
                                        <a href="<?php echo site_url($visa_grantee->visa_page); ?>" class="lightbox" aria-haspopup="dialog">
                                            <?php echo basename($visa_grantee->visa_page); ?>
                                        </a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Passport</td>
                                <td>
                                    <?php if($grantee_grant->img_passport_id == NULL || $grantee_grant->img_passport_id == '') { ?>
                                        No File Uploaded
                                    <?php } else { ?>
                                        <a href="<?php echo site_url($grantee_grant->img_passport_id); ?>" class="lightbox" aria-haspopup="dialog">
                                            <?php echo basename($grantee_grant->img_passport_id); ?>
                                        </a>
                                    <?php } ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <?php } ?>
                <?php if($is_admin) { ?>
                <div class="panel-body">
                    <div class="col-lg-12 mb-4">
                        <p style="font-weight:bold;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> Add Travel Arrangement</p>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name_travel" id="name_travel" placeholder="eg: Selection Interview Travel Arrangement">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Category</label>
                            <select class="form-control" name="category" id="category_travel">
                                <option value="">-- Chose Category --</option>
                                <option value="Domestic Ticket">Domestic Ticket</option>
                                <option value="International Ticket">International Ticket</option>
                                <option value="US Departure">US Departure</option>
                                <option value="Returning Travel Arrangement">Returning Travel Arrangement</option>
                                <option value="Parent Travel Arrangement">Parent Travel Arrangement</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <?php if($is_admin) { ?>
                                <button type="button" id="addTravelArrangement" class="btn btn-primary" style="margin-top:24px;">+ Add Travel Arrangement</button>
                            <?php } ?>
                            <img src="<?php echo base_url() ?>/img/loading.gif" class="add-load" style="display:none;">
                        </div>
                    </div>
                </div>
                <?php } ?>

                <div class="panel-body">
                    <div class="panel-group" id="accordionTravel0" role="tablist" aria-multiselectable="true">
                        <!-- <div id="travel-arrangement-wrapper"> -->
                            <?php //foreach($travel_arrangements as $key => $travel): ?>
                                <?php 
                                // Skip if not admin and both transportation and accommodation are hidden
                                // if($travel->category == 'Domestic Ticket' || $travel->category == 'Returning Travel Arrangement')
                                // {
                                //     if (!$is_admin && ($travel->show_transportation == 'No' || empty($travel->show_transportation)) && ($travel->show_accomodation == 'No' || empty($travel->show_accomodation))) {
                                //         continue;
                                //     }
                                // }else if($travel->category == 'International Ticket'){
                                //     if (!$is_admin && ($travel->show_international_ticket == 'No' || empty($travel->show_international_ticket))) {
                                //         continue;
                                //     }
                                // }
                                
                                // // Load appropriate template based on category
                                // $template_data = [
                                //     'travel' => $travel,
                                //     'key' => $key,
                                //     'is_admin' => $is_admin,
                                //     'url_delete' => $url_delete,
                                // ];
                                
                                // switch($travel->category) {
                                //     case 'Domestic Ticket':
                                //         $this->load->view('admin/partials/template_travel_arrangement_current_domestic', $template_data);
                                //         break;
                                //     case 'Returning Travel Arrangement':
                                //         $this->load->view('admin/partials/template_travel_arrangement_current_returning', $template_data);
                                //         break;
                                //     default:
                                //         $this->load->view('admin/partials/template_travel_arrangement_current_international', $template_data);
                                //         break;
                                // }
                                ?>
                            <?php //endforeach; ?>
                            <?php
                                $this->load->view('admin/partials/template_travel_recursive', [
                                    'tree' => $travelTree,
                                    'parent' => 0,
                                    'is_admin' => $is_admin,
                                    'url_delete' => $url_delete
                                ]);
                            ?>


                        <!-- </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


<?php //if($is_grantee) { ?>
<!-- <div class="panel-body">
    <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> Payment</p>
    <div class="col-lg-9">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="40">#</th>
                    <th>Description</th>
                    <th>Amount (IDR)</th>
                    <th>Amount (USD)</th>
                    <th>Proof of Transfer</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach($payment_items as $p_item) { ?>
                    <?php if($p_item->proof) { ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?= $p_item->description ?></td>
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
</div> -->
<?php //} ?>


<!-- TEMPLTE FORM -->
<?php $this->load->view('admin/partials/template_travel_arrangement_domestic') ?>
<?php $this->load->view('admin/partials/template_travel_arrangement_international') ?>
<?php $this->load->view('admin/partials/template_travel_arrangement_us_departure') ?>
<?php $this->load->view('admin/partials/template_travel_arrangement_returning') ?>
<?php $this->load->view('admin/partials/template_travel_arrangement_parent') ?>

<div class="modal fade" id="mdl_edit_name" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Name</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_edit_name" method="post" action="<?= base_url('admin/travel_arrangement/edit_name')?>">
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="hidden" name="id_for_edit_name" id="id_for_edit_name">
                            <label>Name</label>
                            <input type="text" name="name" id="edit_name" class="form-control">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-12 text-right">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary success">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="mdl_add_child" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal-title-child"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- <form id="form_add_child" method="post" action="<?= base_url('admin/travel_arrangement/add_child')?>"> -->
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="hidden" name="id_for_name_child" id="id_for_name_child">
                            <label>Name</label>
                            <input type="text" name="name_child" id="name_child" class="form-control">
                        </div>
                        <div class="col-lg-12">
                            <label>Category</label>
                            <select class="form-control" name="category_child" id="category_travel_child">
                                <option value="">-- Chose Category --</option>
                                <option value="Domestic Ticket">Domestic Ticket</option>
                                <option value="International Ticket">International Ticket</option>
                                <option value="US Departure">US Departure</option>
                                <option value="Returning Travel Arrangement">Returning Travel Arrangement</option>
                                <option value="Parent Travel Arrangement">Parent Travel Arrangement</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-12 text-right">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary success btnSaveChild">Save</button>
                        </div>
                    </div>
                <!-- </form> -->
            </div>
        </div>
    </div>
</div>


<?php $this->session->unset_userdata('last_tab_visa'); ?>
<?php $this->session->unset_userdata('last_list'); ?>
<?php $this->session->unset_userdata('active_list'); ?>
