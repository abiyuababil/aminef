<div class="panel panel-default">
    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionInterview" href="#collapseFourDP" aria-expanded="false" aria-controls="collapseFourDP" onclick="set_session('departure_package'); return get_visa(this);">
        <div class="panel-heading-visa text-left" role="tab" id="submission_result">
            <h4 class="panel-title">
                After Visa Interview
            </h4>
        </div>
    </a>
    <div id="collapseFourDP" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'departure_package' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="submission_result">
    <div class="panel-body">
        <div class="col-lg-12">
            <div class="form-group">
                <label>Status</label>
                <select class="form-control"  name="status_visa_interview" style="width:100%" <?= !$is_admin &&  $visa_interview->save_grantee && $visa_interview->status_visa_interview == 'Issued' ? 'disabled' : '' ?> id="status_visa_interview">
                    <option value="">-- Select --</option>
                    <option <?= $visa_interview->status_visa_interview == 'Refused' ? 'selected' : '' ?> value="Refused">Refused</option>
                    <option <?= $visa_interview->status_visa_interview == 'Approved' ? 'selected' : '' ?> value="Approved">Approved</option>
                    <option <?= $visa_interview->status_visa_interview == 'Issued' ? 'selected' : '' ?> value="Issued">Issued</option>
                </select>
            </div>
        </div>
        <div class="col-lg-12">
            <?php if(has_permission('nominee', 'departure') || !$is_admin) { ?>
            <div class="form-group">
                <label>Access the following documents for requesting your travel arrangement to the U.S.:</label>
                <ul>

                    <!-- ds2019 & visa page  -->
                    <table class="table table-striped table-bordered table-responsive table-sign my-3">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Surename/Last Name</th>
                                <th>Given Name/First Name</th>
                                <th>DS2019 (Signed)</th>
                                <th>Visa Page</th>
                                <?php if($is_admin) { ?>
                                <th>Enable Upload</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody id="list_ds2019sign_visapage">
                            <?php 
                                foreach($data_ds2019_sign as $key => $data_sign){ 
                                $data_sign->dont_have_first_name = $data_sign->first_name ? false : true;
                                $required_fields = ['ds2019_sign', 'visa_page'];
                                $complete = !array_filter($required_fields, fn($f) => empty($data_sign->$f));
                            ?>
                            <tr id="index-sign-<?= $key + 1 ?>">
                                <td><?= $key + 1 ?></td>
                                <td><?= $data_sign->last_name ?></td>
                                <td><?= $data_sign->first_name ?? 'FNU' ?></td>
                                <td>
                                    <?php if($data_sign->ds2019_sign) { ?>
                                        <a href="<?= base_url($data_sign->ds2019_sign) ?>" class="lightbox btn btn-warning btn-xs btn-xs btn-view-req-ds2019_sign" style="color:#fff">View</a>
                                        <a href="<?= base_url($data_sign->ds2019_sign) ?>" download="<?= get_full_name($data_sign) . '_Signed DS2019' ?>" class="btn btn-info btn-download-req-ds2019_sign btn-xs" style="color:#fff">Download</a>
                                    <?php } ?>
                                    <?php if(($data_sign->grantee_edit) || $is_admin) { ?>
                                    <a href="javascript:;" class="btn btn-primary <?= ($complete && !$is_admin && !$data_sign->grantee_edit) ? 'hide' : '' ?> hide-complete upload-button btn-xs btn-ds2019_sign-<?= $data_sign->id ?>" data-file-value="upload_require_doc_ds2019_sign_<?= $data_sign->id ?>" style="color:#fff;">Upload</a>
                                    <?php } ?>
                                    <input type="file" data-table_save="save_ds2019_sign" data-doc="ds2019_sign" data-is_admin="<?= $is_admin ? 1 : 0 ?>" data-id="<?= $data_sign->id ?>" class="upload_require_doc_ds2019_sign_<?= $data_sign->id ?> hide">
                                    <?php if($data_sign->ds2019_sign) { ?>
                                        <?php if(($data_sign->grantee_edit) || $is_admin) { ?>
                                        <a href="javascript:;" onclick="del_data_required(this, <?= $data_sign->id ?>, 'ds2019_sign', 'delete_save_ds2019_sign', <?= $is_admin ? 1 : 0 ?>)" class="btn btn-danger btn-xs <?= ($complete && !$is_admin && !$data_sign->grantee_edit) ? 'hide' : '' ?> hide-complete btn-del-req-ds2019_sign-<?= $data_sign->id ?>" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                        <?php } ?>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if($data_sign->visa_page) { ?>
                                        <a href="<?= base_url($data_sign->visa_page) ?>" class="lightbox btn btn-warning btn-xs btn-view-req-visa_page" style="color:#fff">View</a>
                                        <a href="<?= base_url($data_sign->visa_page) ?>" download="<?= get_full_name($data_sign) . '_Visa' ?>" class="btn btn-info btn-download-req-visa_page btn-xs" style="color:#fff">Download</a>
                                    <?php } ?>
                                    <?php if(($data_sign->grantee_edit) || $is_admin) { ?>
                                    <a href="javascript:;" class="btn btn-primary <?= ($complete && !$is_admin && !$data_sign->grantee_edit) ? 'hide' : '' ?> hide-complete upload-button btn-xs btn-visa_page-<?= $data_sign->id ?>" data-file-value="upload_require_doc_visa_page_<?= $data_sign->id ?>" style="color:#fff;">Upload</a>
                                    <?php } ?>
                                    <input type="file" data-table_save="save_ds2019_sign" data-doc="visa_page" data-is_admin="<?= $is_admin ? 1 : 0 ?>" data-id="<?= $data_sign->id ?>" class="upload_require_doc_visa_page_<?= $data_sign->id ?> hide">
                                    <?php if($data_sign->visa_page) { ?>
                                        <?php if(($data_sign->grantee_edit) || $is_admin) { ?>
                                        <a href="javascript:;" onclick="del_data_required(this, <?= $data_sign->id ?>, 'visa_page', 'delete_save_ds2019_sign', <?= $is_admin ? 1 : 0 ?>)" class="btn btn-danger btn-xs <?= ($complete && !$is_admin && !$data_sign->grantee_edit) ? 'hide' : '' ?> hide-complete btn-del-req-visa_page-<?= $data_sign->id ?>" style="color:#fff"><i class="fa fa-trash fa-fw text-white"></i></a>
                                        <?php } ?>
                                    <?php } ?>
                                </td>
                                <?php if($is_admin) { ?>
                                <td>
                                    <div class="TriSea-technologies-Switch" style="margin-left:15px;">
                                        <input onchange="grantee_edit_required(this, 'ds2019_sign')" data-id="<?= $data_sign->id ?>" name="grantee_edit" id="grantee_edit_ds2019_<?= $data_sign->id ?>" type="checkbox" <?= $data_sign->grantee_edit  ? 'checked' : '' ?>/>
                                        <label for="grantee_edit_ds2019_<?= $data_sign->id ?>" class="label-primary"></label>
                                    </div>
                                </td>
                                <?php } ?>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <!-- <li>DS2019 (Signed)</li>
                    <div class="panel-body">
                        <div class="col-lg-4">
                            <?php if($visa_interview->appointment_located == 'Surabaya' || $is_admin) { ?>
                            <input id="ds2019_signed" type="file" class="form-control" name="ds2019_signed">
                            <?php } ?>
                            <?php if ($visa_interview && $visa_interview->ds2019_signed != '') { ?>
                                <br>
                                <div style="margin-bottom:10px; position:relative; width:100px;" id="file_ds2019_signed">
                                    <a href="<?=base_url() ?><?=$visa_interview->ds2019_signed ?>" class="lightbox" aria-haspopup="dialog">
                                        <img id="preview_image_profile" data-old="<?php echo site_url($visa_interview->ds2019_signed); ?>" src="<?php echo get_preview($visa_interview->ds2019_signed); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                    </a>
                                    <a href="<?=base_url() ?><?=$visa_interview->ds2019_signed ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($visa_interview->ds2019_signed) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px; color:#fff;">
                                        <i class="fa fa-download fa-fw"></i>
                                    </a>
                                    <?php if($is_admin) { ?>
                                    <a href="javascript:;" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                                        <label class="btn btn-xs btn-danger" onclick="delete_file_visa(this, 'ds2019_signed', <?= $is_admin ?>)"><i class="fa fa-trash fa-fw"></i></label>
                                    </a>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <li>Visa Page</li>
                    <div class="panel-body">
                        <div class="col-lg-4">
                            <?php if($visa_interview->appointment_located == 'Surabaya' || $is_admin) { ?>
                            <input id="visa_page" type="file" class="form-control" name="visa_page">
                            <?php } ?>
                            <?php if ($visa_interview && $visa_interview->visa_page != '') { ?>
                                <br>
                                <div style="margin-bottom:10px; position:relative; width:100px;" id="file_visa_page">
                                    <a href="<?=base_url() ?><?=$visa_interview->visa_page ?>" class="lightbox" aria-haspopup="dialog">
                                        <img id="preview_image_profile" data-old="<?php echo site_url($visa_interview->visa_page); ?>" src="<?php echo get_preview($visa_interview->visa_page); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                    </a>
                                    <a href="<?=base_url() ?><?=$visa_interview->visa_page ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($visa_interview->visa_page) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px; color:#fff;">
                                        <i class="fa fa-download fa-fw"></i>
                                    </a>
                                    <?php if($is_admin) { ?>
                                    <a href="javascript:;" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                                        <label class="btn btn-xs btn-danger" onclick="delete_file_visa(this, 'visa_page', <?= $is_admin ?>)"><i class="fa fa-trash fa-fw"></i></label>
                                    </a>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div> -->
                </ul>
            </div>
            <hr />
            <?php } ?>
        </div>
        <div class="col-lg-12">
            <?php if(has_permission('nominee', 'departure') || !$is_admin) { ?>
            <div class="form-group section-obtaining">
                <label>Obtaining Departure Documents</label><br />
                <label class="mt-5 together_with_dependent hide">Would you go to the US together with your dependent?</label>
                <select id="together_with_dependent" class="form-control hide together_with_dependent" name="together_with_dependent" style="width:100%" <?= $visa_interview->together_with_dependent != '' ? ($is_admin ? '' : 'disabled') : '' ?>>
                    <option value="">-- Select --</option>
                    <option <?= $visa_interview->together_with_dependent == 'Yes' ? 'selected' : ''?> value="Yes">Yes</option>
                    <option <?= $visa_interview->together_with_dependent == 'No' ? 'selected' : ''?> value="No">No</option>
                </select>
                <?php if($visa_interview->obtaining_departur_document || $visa_interview->obtaining_departur_document_dependent || $is_admin) { ?>
                <p class="mt-3">Your departure documents consist of passport with J1 visa, and original DS2019 can be obtained at:</p>
                <?php } ?>
                <?php if($visa_interview->obtaining_departur_document || $is_admin) { ?>
                <div class="panel-body">
                    <div class="panel-body">
                        <?php if($is_admin) { ?>
                        <div class="col-lg-12 mb-5">
                            <div class="TriSea-technologies-Switch">
                                <span class="mr-2"> Enable Grantee Pickup</span>
                                <input onclick="toggle_enable_grantee_pickup(this)" data-id="<?= $grantee_grant->id ?>" id="enable_grantee_pickup" name="enable_grantee_pickup" type="checkbox" <?= $visa_interview->enable_grantee_pickup  ? 'checked' : '' ?>/>
                                <label for="enable_grantee_pickup" class="label-primary"></label>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="col-lg-8">
                            <label>Grantee Pickup Document</label>
                            <select id="obtaining_departur_document" class="form-control" name="obtaining_departur_document" style="width:100%" <?= !$is_admin ? 'disabled' : '' ?>>
                                <option value="">-- Select --</option>
                                <option <?= $visa_interview->obtaining_departur_document == 'AMINEF Office' ? 'selected' : ''?> value="AMINEF Office">AMINEF Office</option>
                                <option <?= $visa_interview->obtaining_departur_document == 'Hotel' ? 'selected' : ''?> value="Hotel">Hotel arranged by AMINEF</option>
                                <option <?= $visa_interview->obtaining_departur_document == 'Hotel Participant' ? 'selected' : ''?> value="Hotel Participant">Hotel arranged by Participant</option>
                            </select>
                        </div>
                    </div>
                    <?php
                        $enableHotel = (
                            $visa_interview->obtaining_departur_document == 'Hotel Participant' 
                            && $visa_interview->enable_grantee_pickup == 1
                        );
                    ?>
                    <div class="panel-body obtaining-section <?= $visa_interview->obtaining_departur_document == 'AMINEF Office' || $visa_interview->obtaining_departur_document == '' ? 'hide' : '' ?>">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Hotel Name</label>
                                <input class="form-control" type="input" name="hotel_name" <?= (!$is_admin && !$enableHotel) ? 'disabled' : '' ?> value="<?= $visa_interview->hotel_name ?>">
                            </div>
                        </div>
                        <div class="col-lg-4 obtaining-section <?= $visa_interview->obtaining_departur_document == '' || $visa_interview->obtaining_departur_document == 'AMINEF Office' ? 'hide' : '' ?>">
                            <div class="form-group">
                                <label>Address</label>
                                <textarea class="form-control" <?= (!$is_admin && !$enableHotel) ? 'disabled' : '' ?> name="address"><?= $visa_interview->address ?></textarea>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Appointment Date</label>
                                <input id="appointment_date" type="text" class="form-control datepicker " readonly style="background-color:#<?= (!$is_admin && $enableHotel) || $is_admin ? 'fff' : 'eee' ?>" placeholder="Appointment Date" name="appointment_date" <?= (!$is_admin && !$enableHotel) ? 'disabled' : '' ?> value="<?= $visa_interview  ? ($visa_interview->appointment_date != '' ? date('d M Y', strtotime($visa_interview->appointment_date)) : '') : '' ?>">
                                <?php if((!$is_admin && $enableHotel) || $is_admin) { ?>
                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Point of Contact</label>
                                <?php //if($is_admin) { ?>
                                <select class="form-control point_of_contact" name="point_of_contact" onchange="select_staff(this, false)" <?= !$is_admin ? 'disabled' : '' ?>>
                                    <option>-- Select --</option>
                                    <?php foreach($staffs as $staff) { ?>
                                        <option <?= $visa_interview->point_of_contact == $staff->id ? 'selected' : ''?> data-email="<?= $staff->email ?>" data-telephone="<?= $staff->telephone ?>" value="<?= $staff->id ?>"><?= $staff->full_name?></option>
                                    <?php } ?>
                                </select>
                                <?php //} else { ?>
                                    <!-- <input class="form-control" type="input" name="point_of_contact" <?= !$is_admin ? 'disabled' : '' ?> value="<?= $visa_interview->point_of_contact ?>"> -->
                                <?php //} ?>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" type="input" id="email" name="email" <?= !$is_admin ? 'disabled' : 'disabled' ?> value="<?= $visa_interview->email ?>">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Telephone</label>
                                <input class="form-control" type="input" name="telephone" id="telephone" <?= !$is_admin ? 'disabled' : 'disabled' ?> value="<?= $visa_interview->telephone ?>">
                            </div>
                        </div>
                        <?php if (($visa_interview && $visa_interview->receipt != '') || $is_admin) { ?>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Receipt</label>
                                <?php if($is_admin) { ?>
                                <input id="receipt" type="file" class="form-control" name="receipt">
                                <?php } ?>
                                <?php if ($visa_interview && $visa_interview->receipt != '') { ?>
                                    <br>
                                    <div style="margin-bottom:10px; position:relative; width:100px;" id="file_receipt">
                                        <a href="<?=base_url() ?><?=$visa_interview->receipt ?>" class="lightbox" aria-haspopup="dialog">
                                            <img id="preview_image_profile" data-old="<?php echo site_url($visa_interview->receipt); ?>" src="<?php echo get_preview($visa_interview->receipt); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                        </a>
                                        <a href="<?=base_url() ?><?=$visa_interview->receipt ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($visa_interview->receipt) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px; color:#fff;">
                                            <i class="fa fa-download fa-fw"></i>
                                        </a>
                                        <?php if($is_admin) { ?>
                                        <a href="javascript:;" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                                            <label class="btn btn-xs btn-danger" onclick="delete_file_visa(this, 'receipt', <?= $is_admin ?>)"><i class="fa fa-trash fa-fw"></i></label>
                                        </a>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>
                <?php if($visa_interview->obtaining_departur_document_dependent || $is_admin) {?>
                <div class="panel-body dependent-section <?= $visa_interview->have_dependent == 'Yes' || $visa_interview->have_dependent == '' ? 'hide' : ''?>">
                    <div class="panel-body">
                        <div class="col-lg-8">
                            <label>Dependent Pickup Document</label>
                            <select id="obtaining_departur_document_dependent" class="form-control" name="obtaining_departur_document_dependent" style="width:100%" <?= !$is_admin ? 'disabled' : '' ?>>
                                <option value="">-- Select --</option>
                                <option <?= $visa_interview->obtaining_departur_document_dependent == 'AMINEF Office' ? 'selected' : ''?> value="AMINEF Office">AMINEF Office</option>
                                <option <?= $visa_interview->obtaining_departur_document_dependent == 'Hotel' ? 'selected' : ''?> value="Hotel">Hotel arranged by AMINEF</option>
                            </select>
                        </div>
                    </div>
                    <div class="panel-body obtaining-dependent-section <?= $visa_interview->obtaining_departur_document_dependent == 'AMINEF Office' || $visa_interview->obtaining_departur_document_dependent == '' ? 'hide' : '' ?>">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Hotel Name</label>
                                <input class="form-control" type="input" name="hotel_name_dependent" <?= !$is_admin ? 'disabled' : '' ?> value="<?= $visa_interview->hotel_name_dependent ?>">
                            </div>
                        </div>
                        <div class="col-lg-4 obtaining-dependent-section <?= $visa_interview->obtaining_departur_document_dependent == '' || $visa_interview->obtaining_departur_document_dependent == 'AMINEF Office' ? 'hide' : '' ?>">
                            <div class="form-group">
                                <label>Address</label>
                                <textarea class="form-control" <?= !$is_admin ? 'disabled' : '' ?> name="address_dependent"><?= $visa_interview->address_dependent ?></textarea>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Appointment Date</label>
                                <input id="appointment_date_dependent" type="text" class="form-control datepicker" readonly style="background-color:#<?= $is_admin ? 'fff' : 'eee' ?>" placeholder="Appointment Date" name="appointment_date_dependent" <?= !$is_admin ? 'disabled' : '' ?> value="<?= $visa_interview  ? ($visa_interview->appointment_date_dependent != '' ? date('d M Y', strtotime($visa_interview->appointment_date_dependent)) : '') : '' ?>">
                                <?php if($is_admin) { ?>
                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Point of Contact</label>
                                <?php //if($is_admin) { ?>
                                    <select class="form-control point_of_contact" name="point_of_contact_dependent" onchange="select_staff(this, true)" <?= !$is_admin ? 'disabled' : '' ?>>
                                        <option>-- Select --</option>
                                        <?php foreach($staffs as $staff) { ?>
                                            <option <?= $visa_interview->point_of_contact_dependent == $staff->id ? 'selected' : ''?> data-email="<?= $staff->email ?>" data-telephone="<?= $staff->telephone ?>" value="<?= $staff->id ?>"><?= $staff->full_name?></option>
                                        <?php } ?>
                                    </select>
                                <?php //} else { ?>
                                    <!-- <input class="form-control" type="input" name="point_of_contact_dependent" <?= !$is_admin ? 'disabled' : '' ?> value="<?= $visa_interview->point_of_contact_dependent ?>"> -->
                                <?php //}?>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" type="input" name="email_dependent" id="email_dependent" <?= !$is_admin ? 'disabled' : 'disabled' ?> value="<?= $visa_interview->email_dependent ?>">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Telephone</label>
                                <input class="form-control" type="input" name="telephone_dependent" id="telephone_dependent" <?= !$is_admin ? 'disabled' : 'disabled' ?> value="<?= $visa_interview->telephone_dependent ?>">
                            </div>
                        </div>
                        <?php if (($visa_interview && $visa_interview->receipt_dependent != '') || $is_admin) { ?>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Receipt</label>
                                <?php if($is_admin) { ?>
                                <input id="receipt_dependent" type="file" class="form-control" name="receipt_dependent">
                                <?php } ?>
                                <?php if ($visa_interview && $visa_interview->receipt_dependent != '') { ?>
                                    <br>
                                    <div style="margin-bottom:10px; position:relative; width:100px;" id="file_receipt_dependent">
                                        <a href="<?=base_url() ?><?=$visa_interview->receipt_dependent ?>" class="lightbox" aria-haspopup="dialog">
                                            <img id="preview_image_profile" data-old="<?php echo site_url($visa_interview->receipt_dependent); ?>" src="<?php echo get_preview($visa_interview->receipt_dependent); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                        </a>
                                        <a href="<?=base_url() ?><?=$visa_interview->receipt_dependent ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty($visa_interview->receipt_dependent) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px; color:#fff;">
                                            <i class="fa fa-download fa-fw"></i>
                                        </a>
                                        <?php if($is_admin) { ?>
                                        <a href="javascript:;" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                                            <label class="btn btn-xs btn-danger" onclick="delete_file_visa(this, 'receipt_dependent', <?= $is_admin ?>)"><i class="fa fa-trash fa-fw"></i></label>
                                        </a>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>
            </div>
            <small class="section-obtaining"><i>No mailing service provided for this purpose to avoid any delivery risk which cause the lost document during shipment.</i></small>
            <hr class="section-obtaining" />

            <?php if(!$is_admin && $enableHotel) { ?>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="pull-right">
                        <button type="button" name="btn" value="save_after_visa_interview" onclick="return showSwal('confirm_submit', 'Are you sure you want to save?', false, false, false, '#form', 'save_after_visa_interview')" class="btn btn-success">Save</button>
                    </div>
                </div>

            </div>
            <?php } ?>
            <?php } ?>
        </div>
    </div>
    </div>
</div>