<!-- ------------ SECTION DUOLINGO -------------- -->
<?php if ($grantee_grant->show_duolingo_section && ($show_duolingo || $is_admin)){ ?>
<div id="duolingo" class="tab-pane fade">
    <div class="panel panel-default">
        <?php if(has_permission('nominee', 'test_section_data') || $is_admin) { ?>
        <div class="panel-body">
            <div class="row form-group pull-right">
                <div class="col-lg-6">
                    <button type="button" class="btn btn-primary btn-for-add" onclick="add_section('duolingo')"><i class="fa fa-plus fa-fw"></i> Add New</button>
                    <img src="<?php echo base_url() ?>/img/loading.gif" class="add-load-duolingo" style="display:none;">
                </div>
            </div>
        </div>
        <?php } ?>
        <div id="wrap-duolingo">
            <?php if($data_duolingo) : ?>
                <?php foreach($data_duolingo as $kgduo => $duolingo) : ?>
                <?php
                    $del_btn = ''; 
                    if($kgduo > 0) : 
                    $del_btn = '
                    <img src="'.base_url('/img/loading.gif').'" class="delete-load-duolingo" style="display:none;position:absolute; top:35px; right:75px;">
                    <a href="javascript:;" onclick="del_item(this, \'duolingo-item\','.$duolingo->id.', \'duolingo\')" class="btn btn-danger btn-delete-nominee" style="position:absolute; top:-40px; right:15px;color: #fff;"><i class="fa fa-trash fa-fw"></i></a>';
                ?>
                    <hr>
                <?php endif; ?>
                <input type="hidden" name="duolingo[<?= $kgduo ?>][duolingo_id]" value="<?= $duolingo->id ?>">
                <div id="duolingo-item-<?= $kgduo ?>" class="duolingo-item" style="position:relative;<?= ($kgduo > 0) && $is_admin ? 'margin-top:50px;' : '' ?>">
                    <?php if($kgduo == 0 && $grantee_grant->guideline_duolingo_test) { ?>
                    <a href="<?= base_url($grantee_grant->guideline_duolingo_test) ?>" download title="Click to Download" class="btn btn-primary mb-5 <?= $grantee_grant->guideline_duolingo_test ? '' : 'hide' ?>" style="color:#fff">
                        <i class="fa fa-download fa-fw text-white"></i> Download Guideline for Test
                    </a>
                    <?php } ?>
                    <!-- <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> Duolingo <?= $duolingo->test_date ? 'test on ' . date('F j, Y', strtotime($duolingo->test_date)) : '' ?></p> -->
                    <div class="panel-group" id="accordionDuolingoParent<?= $kgduo ?>" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                        <?php echo $del_btn ?>
                            <a role="button" data-toggle="collapse" data-parent="#accordionDuolingoParent<?= $kgduo ?>" href="#collapseDuolingoTestParent<?= $kgduo ?>" aria-expanded="true" aria-controls="collapseDuolingoTestParent<?= $kgduo ?>">
                                <div class="panel-heading panel-heading-test-section text-left" role="tab" id="DuolingoTestParent">
                                    <h4 class="panel-title panel-title-parent">
                                        Duolingo <?= $duolingo->test_date ? 'test on ' . date('F j, Y', strtotime($duolingo->test_date)) : '' ?>
                                    </h4>
                                </div>
                            </a>
                            <div id="collapseDuolingoTestParent<?= $kgduo ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="DuolingoTestParent">
                                <div class="panel-group p-4" id="accordionDuolingo<?= $kgduo ?>" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-default">
                                        <a role="button" data-toggle="collapse" data-parent="#accordionDuolingo<?= $kgduo ?>" href="#collapseDuolingoTest<?= $kgduo ?>" aria-expanded="true" aria-controls="collapseDuolingoTest<?= $kgduo ?>">
                                            <div class="panel-heading panel-heading-test-section text-left" role="tab" id="DuolingoTest">
                                                <h4 class="panel-title">
                                                    Test Information
                                                </h4>
                                            </div>
                                        </a>
                                        <div id="collapseDuolingoTest<?= $kgduo ?>" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'before_visa' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="DuolingoTest">
                                            <div class="panel-body">
                                                <?php if(has_permission('nominee', 'test_section_data') || $is_grantee) { ?>
                                                <div class="panel-body">
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Username</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control form-control-grantee"
                                                                name="duolingo[<?= $kgduo ?>][username]" 
                                                                value="<?= $duolingo->username ?>"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Password</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control form-control-grantee"
                                                                name="duolingo[<?= $kgduo ?>][password]" 
                                                                value="<?= $duolingo->password ?>"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Test Date</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control datepicker" readonly style="background-color:#fff"
                                                                    name="duolingo[<?= $kgduo ?>][test_date]" 
                                                                    value="<?= $duolingo->test_date ? date('d M Y', strtotime($duolingo->test_date)) : '' ?>"
                                                                >
                                                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary <?= $is_admin ? '' : 'hide' ?>" style="color:#000;position:absolute;top:0px;right:20px;">X</a>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Test Time</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="time" 
                                                                class="form-control input_time" style="background-color:#fff" 
                                                                name="duolingo[<?= $kgduo ?>][time]" 
                                                                value="<?= $duolingo->test_date != '' ? (date('H:i:s', strtotime($duolingo->test_date)) != '00:00:00' ? date('H:i', strtotime($duolingo->test_date)) : '08:00') : '08:00' ?>"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Format</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label class="radio-inline">
                                                                <input type="radio" 
                                                                        class="radio-nominee" 
                                                                        <?= $duolingo->format == 'home_edition' ? 'checked' : '' ?>
                                                                        name="duolingo[<?= $kgduo ?>][format]" 
                                                                        value="home_edition">
                                                                        Home Edition
                                                            </label>
                                                            <!-- <label class="radio-inline">
                                                                <input type="radio" 
                                                                        class="radio-nominee" 
                                                                        <?= $duolingo->format == 'in-person' ? 'checked' : '' ?>
                                                                        name="duolingo[<?= $kgduo ?>][format]" 
                                                                        value="in-person">
                                                                        In-Person 
                                                            </label> -->
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Coupon Code</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                class="form-control"
                                                                name="duolingo[<?= $kgduo ?>][cupon_code]" 
                                                                value="<?= $duolingo->cupon_code ?>"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Confirmation Registration Form</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <?php if($duolingo->confirmation_registration) : ?>
                                                                <a 
                                                                    href="<?= base_url($duolingo->confirmation_registration) ?>" 
                                                                    class="btn btn-primary"
                                                                    download
                                                                    style="color:#fff">
                                                                    Download
                                                                </a>
                                                                <a 
                                                                    href="<?= base_url($duolingo->confirmation_registration) ?>" 
                                                                    class="btn btn-success lightbox"
                                                                    style="color:#fff">
                                                                    View
                                                                </a>
                                                                <?php if(!$is_grantee) { ?>
                                                                <a href=<?= $url_delete.'/test_section_confirmation/'.$grantee_grant->id.'/'.$duolingo->id ?> onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger" style="margin-bottom:3px;color:#fff">Delete</a>
                                                                <?php } ?>
                                                            <?php endif; ?>
                                                            <input 
                                                                type="file" 
                                                                class="form-control form-control-grantee" 
                                                                name="confirmation_registration_duolingo_<?= $kgduo ?>" 
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Overall Score</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control form-control-grantee" 
                                                                name="duolingo[<?= $kgduo ?>][total_score]" 
                                                                value="<?= format_decimal($duolingo->total_score) ?>"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-12 mt-5">
                                                            <label><u>Individual Subscores</u></label>
                                                            <hr style="margin-top:10px;" />
                                                        </div>
                                                        <div class="col-lg-6"></div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Speaking</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control form-control-grantee" 
                                                                name="duolingo[<?= $kgduo ?>][speaking]" 
                                                                value="<?= format_decimal($duolingo->speaking) ?>"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Writing</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control form-control-grantee" 
                                                                name="duolingo[<?= $kgduo ?>][writing]" 
                                                                value="<?= format_decimal($duolingo->writing) ?>"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Reading</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control form-control-grantee" 
                                                                name="duolingo[<?= $kgduo ?>][reading]" 
                                                                value="<?= format_decimal($duolingo->reading) ?>"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Listening</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control form-control-grantee" 
                                                                name="duolingo[<?= $kgduo ?>][listening]" 
                                                                value="<?= format_decimal($duolingo->listening) ?>"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-12 mt-5">
                                                            <label><u>Integrated Subscores</u></label>
                                                            <hr style="margin-top:10px;" />
                                                        </div>
                                                        <div class="col-lg-6"></div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Production</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control form-control-grantee" 
                                                                name="duolingo[<?= $kgduo ?>][production]" 
                                                                value="<?= format_decimal($duolingo->production) ?>"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Literacy</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control form-control-grantee" 
                                                                name="duolingo[<?= $kgduo ?>][literacy]" 
                                                                value="<?= format_decimal($duolingo->literacy) ?>"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Comprehension</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control form-control-grantee" 
                                                                name="duolingo[<?= $kgduo ?>][comprehension]" 
                                                                value="<?= format_decimal($duolingo->comprehension) ?>"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Conversation</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control form-control-grantee" 
                                                                name="duolingo[<?= $kgduo ?>][conversation]" 
                                                                value="<?= format_decimal($duolingo->conversation) ?>"
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Upload Score Report</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <?php if($duolingo->score_report) : ?>
                                                                <a 
                                                                    href="<?= base_url($duolingo->score_report) ?>" 
                                                                    class="btn btn-success lightbox"
                                                                    style="color:#fff">
                                                                    View
                                                                </a>
                                                                <?php if(!$is_grantee) { ?>
                                                                <a href=<?= $url_delete.'/duolingo/'.$grantee_grant->id.'/'.$duolingo->id ?> onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger" style="margin-bottom:3px;color:#fff">Delete</a>
                                                                <?php } ?>
                                                            <?php endif; ?>
                                                            <input 
                                                                type="file" 
                                                                class="form-control form-control-grantee" 
                                                                name="score_report_duolingo_<?= $kgduo ?>" 
                                                            >
                                                        </div>
                                                    </div>
                                                    <!-- <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Confirmation Registration Form</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <?php if($duolingo->confirmation_registration) : ?>
                                                                <a 
                                                                    href="<?= base_url($duolingo->confirmation_registration) ?>" 
                                                                    class="btn btn-success lightbox"
                                                                    style="color:#fff">
                                                                    View
                                                                </a>
                                                                <?php if(!$is_grantee) { ?>
                                                                <a href=<?= $url_delete.'/duolingo_confirmation/'.$grantee_grant->id.'/'.$duolingo->id ?> onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger" style="margin-bottom:3px;color:#fff">Delete</a>
                                                                <?php } ?>
                                                            <?php endif; ?>
                                                            <input 
                                                                type="file" 
                                                                class="form-control file-for-testing" 
                                                                name="confirmation_registration_duolingo_<?= $kgduo ?>" 
                                                            >
                                                        </div>
                                                    </div> -->
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php //if(has_permission('nominee', 'transportation_test_section') || $is_grantee) { ?>
                    <!-- <div class="panel-body">
                        <div class="col-lg-12">
                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> TRANSPORTATION</p>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Departure City</label>
                                <input type="text" class="form-control" placeholder="Departure City" name="duolingo[<?= $kgduo ?>][origin_city]" value="<?= $duolingo->origin_city ?>">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Destination City</label>
                                <input type="text" class="form-control" placeholder="Destination City" name="duolingo[<?= $kgduo ?>][destination_city]" value="<?= $duolingo->destination_city ?>">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Departure Date</label>
                                <input type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Departure Date" name="duolingo[<?= $kgduo ?>][departure_date]" value="<?= $duolingo->departure_date != '' ? date('d M Y', strtotime( $duolingo->departure_date)) : '' ?>">
                                <a href="javascript:;" onclick="emptyValue(this)" class="<?= $is_grantee ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Return Date</label>
                                <input type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Return Date" name="duolingo[<?= $kgduo ?>][returning_date]" value="<?= $duolingo->returning_date != '' ? date('d M Y', strtotime( $duolingo->returning_date)) : '' ?>">
                                <a href="javascript:;" onclick="emptyValue(this)" class="<?= $is_grantee ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>E-Ticket</label>
                                <input type="file" class="form-control" name="eticket_duolingo_<?= $kgduo ?>">
                                <?php if ($duolingo->eticket != '') { ?>
                                    <br>
                                    <div style="margin-bottom:10px; position:relative; width:100px;">
                                        <a href="<?=base_url() ?><?= $duolingo->eticket ?>" class="lightbox" aria-haspopup="dialog">
                                            <img id="preview_image_profile" data-old="<?php echo site_url( $duolingo->eticket); ?>" src="<?php echo get_preview( $duolingo->eticket); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                        </a>
                                        <a href="<?=base_url() ?><?= $duolingo->eticket ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty( $duolingo->eticket) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;color:#fff;">
                                            <i class="fa fa-download fa-fw"></i>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div> -->
                    <? //php} ?>

                    <?php //if(has_permission('nominee', 'accomodation_test_section') || $is_grantee) { ?>
                    <!-- <div class="panel-body" style="margin-top:-20px">
                        <div class="col-lg-12">
                            <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> ACCOMMODATION</p>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Check-In Date</label>
                                <input type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Check-In Date" name="duolingo[<?= $kgduo ?>][checkin_date]" value="<?= $duolingo->checkin_date != '' ? date('d M Y', strtotime( $duolingo->checkin_date)) : '' ?>">
                                <a href="javascript:;" onclick="emptyValue(this)" class="<?= $is_grantee ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Check-Out Date</label>
                                <input type="text" class="form-control datepicker" readonly style="background-color:#fff" placeholder="Check-Out Date" name="duolingo[<?= $kgduo ?>][checkout_date]" value="<?= $duolingo->checkout_date != '' ? date('d M Y', strtotime( $duolingo->checkout_date)) : '' ?>">
                                <a href="javascript:;" onclick="emptyValue(this)" class="<?= $is_grantee ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Hotel Voucher</label>
                                <input type="file" class="form-control" name="voucher_hotel_duolingo_<?= $kgduo ?>">
                                <?php if ( $duolingo &&  $duolingo->voucher_hotel != '') { ?>
                                    <br>
                                    <div style="margin-bottom:10px; position:relative; width:100px;">
                                        <a href="<?=base_url() ?><?= $duolingo->voucher_hotel ?>" class="lightbox" aria-haspopup="dialog">
                                            <img id="preview_image_profile" data-old="<?php echo site_url( $duolingo->voucher_hotel); ?>" src="<?php echo get_preview( $duolingo->voucher_hotel); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                        </a>
                                        <a href="<?=base_url() ?><?= $duolingo->voucher_hotel ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty( $duolingo->voucher_hotel) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;color:#fff;">
                                            <i class="fa fa-download fa-fw"></i>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div> -->
                    <?php //} ?>
                </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div id="duolingo-item-0" class="duolingo-item" style="position:relative">
                    <?php if($grantee_grant->guideline_duolingo_test) { ?>
                    <a href="<?= base_url($grantee_grant->guideline_duolingo_test) ?>" download title="Click to Download" class="btn btn-primary mb-5 <?= $grantee_grant->guideline_duolingo_test ? '' : 'hide' ?>" style="color:#fff">
                        <i class="fa fa-download fa-fw text-white"></i> Download Guideline for Test
                    </a>
                    <?php } ?>
                    <!-- <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> Duolingo</p> -->
                    <div class="panel-group" id="accordionDuolingoParent" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <a role="button" data-toggle="collapse" data-parent="#accordionDuolingoParent" href="#collapseDuolingoTestParent" aria-expanded="true" aria-controls="collapseDuolingoTestParent">
                                <div class="panel-heading panel-heading-test-section text-left" role="tab" id="DuolingoTestParent">
                                    <h4 class="panel-title panel-title-parent">
                                        Duolingo
                                    </h4>
                                </div>
                            </a>
                            <div id="collapseDuolingoTestParent" class="panel-collapse collapse" role="tabpanel" aria-labelledby="DuolingoTestParent">
                                <div class="panel-group p-4" id="accordionDuolingo" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-default">
                                        <a role="button" data-toggle="collapse" data-parent="#accordionDuolingo" href="#collapseDuolingoTest" aria-expanded="true" aria-controls="collapseDuolingoTest">
                                            <div class="panel-heading panel-heading-test-section text-left" role="tab" id="DuolingoTest">
                                                <h4 class="panel-title">
                                                    Test Information
                                                </h4>
                                            </div>
                                        </a>
                                        <div id="collapseDuolingoTest" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'before_visa' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="DuolingoTest">
                                            <div class="panel-body">
                                                <?php if(has_permission('nominee', 'test_section_data') || $is_grantee) { ?>
                                                <div class="panel-body">
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Username</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control form-control-grantee"
                                                                name="duolingo[0][username]" 
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Password</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control form-control-grantee"
                                                                name="duolingo[0][password]" 
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Test Date</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control datepicker" readonly style="background-color:#fff" name="duolingo[0][test_date]" value="">
                                                            <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute;top:0px;right:20px;">X</a>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Test Time</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="time" 
                                                                class="form-control input_time" style="background-color:#fff" 
                                                                name="duolingo[0][time]" 
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Format</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label class="radio-inline">
                                                                <input type="radio" 
                                                                        class="radio-nominee" 
                                                                        name="duolingo[0][format]" 
                                                                        value="home_edition">
                                                                        Home Edition
                                                            </label>
                                                            <!-- <label class="radio-inline">
                                                                <input type="radio" 
                                                                        class="radio-nominee" 
                                                                        name="duolingo[0][format]" 
                                                                        value="in-person">
                                                                        In-Person 
                                                            </label> -->
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Coupon Code</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                class="form-control"
                                                                name="duolingo[0][cupon_code]" 
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Confirmation Registration Form</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="file" 
                                                                class="form-control file-for-testing" 
                                                                name="confirmation_registration_duolingo_0" 
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Overall Score</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control form-control-grantee" name="duolingo[0][total_score]" value="">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-12 mt-5">
                                                            <label><u>Individual Subscores</u></label>
                                                            <hr style="margin-top:10px;" />
                                                        </div>
                                                        <div class="col-lg-6"></div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Speaking</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control form-control-grantee" 
                                                                name="duolingo[0][speaking]" 
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Writing</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control form-control-grantee" 
                                                                name="duolingo[0][writing]" 
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Reading</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control form-control-grantee" 
                                                                name="duolingo[0][reading]" 
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Listening</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control form-control-grantee" 
                                                                name="duolingo[0][listening]" 
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-12 mt-5">
                                                            <label><u>Integrated Subscores</u></label>
                                                            <hr style="margin-top:10px;" />
                                                        </div>
                                                        <div class="col-lg-6"></div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Production</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control form-control-grantee" 
                                                                name="duolingo[0][production]" 
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Literacy</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control form-control-grantee" 
                                                                name="duolingo[0][literacy]" 
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Comprehension</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control form-control-grantee" 
                                                                name="duolingo[0][comprehension]" 
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Conversation</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input 
                                                                type="text" 
                                                                class="form-control form-control-grantee" 
                                                                name="duolingo[0][conversation]" 
                                                            >
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Upload Score Report</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="file" class="form-control form-control-grantee" name="score_report_duolingo_0" value="">
                                                            <small class=form-control-grantee">File Size Max 5MB</small>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="row form-group">
                                                        <div class="col-lg-3">
                                                            <label>Confirmation Registration Form</label>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="file" class="form-control file-for-testing" name="confirmation_registration_duolingo_0" value="">
                                                            <small class="file-for-testing">File Size Max 5MB</small>
                                                        </div>
                                                    </div> -->
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php // if($is_grantee) { ?>
        <div class="panel-body pull-right">
            <button type="submit" class="btn btn-success" name="btn" value="save-test-section-duolingo">Save</button>
        </div>
        <?php // } ?>
    </div>
</div>
<?php } ?>
<!-- ------------- END SECTION DUOLINGO ------------- -->