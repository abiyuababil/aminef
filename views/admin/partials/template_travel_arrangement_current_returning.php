<div class="panel panel-default travelArrangement-item">
    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionTravel<?= $travel->parent_id ?>" href="#collapseToeflTransport<?= $key ?>" aria-expanded="false" aria-controls="collapseToeflTransport<?= $key ?>" onclick="return set_session('interview_apointment<?= $key ?>')">
        <div class="panel-heading panel-heading-test-section text-left" role="tab" id="ToeflTransport">
            <h4 class="panel-title">
                <span id="label_name_<?= $travel->id ?>"><?= $travel->name ?></span> 
                <?php if($is_admin) { ?>
                <span><i class="fa fa-pencil-square-o ml-3 btn-noaction edit_name" data-name="<?= $travel->name ?>" data-id ="<?= $travel->id ?>" title="Edit Name"></i></span>
                <?php } ?>
                <div class="btn-group pull-right">
                    <?php if($is_admin) { ?>
                    <button type="button" data-travel_id="<?= $travel->id ?>" class="btn btn-xs btn-danger btn-noaction pull-right removeApplicant"><i class="fa fa-trash fa-fw text-white"></i></button>
                    <?php } ?>
                    <input type="hidden" name="travel_arrangement[<?= $key ?>][name_travel]" value="<?= $travel->name ?>" id="name_travel_<?= $key ?>">
                    <input type="hidden" name="travel_arrangement[<?= $key ?>][category_travel]" value="<?= $travel->category ?>" id="category_travel_<?= $key ?>">
                    <input type="hidden" name="travel_arrangement[<?= $key ?>][travel_id]" value="<?= $travel->id ?>">
                </div>
            </h4>
        </div>
    </a>
    <div id="collapseToeflTransport<?= $key ?>" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'interview_apointment' . $key || $this->session->userdata('active_list') == 'tab_returning_travel' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="ToeflTransport">
        <div class="panel-body">
            <?php if($this->session->userdata('role') == 'travel-booking-assistant' || $is_grantee) { ?>
                <input id="show_transportation_<?= $key ?>" onchange="show_hide_transportation(this, 'international', '<?= $key ?>')" class="select_show hidden" value="<?= $travel->show_transportation ?>">
                <input id="show_transportation_domestic_<?= $key ?>" onchange="show_hide_transportation(this, 'domestic', '<?= $key ?>')" class="select_show hidden" value="<?= $travel->show_transportation_domestic ?>">
                <input id="show_accomodation_<?= $key ?>" onchange="show_hide_accomodation(this, 'domestic', '<?= $key ?>')" class="select_show hidden" value="<?= $travel->show_accomodation ?>">
            <?php } ?>
            <?php if(has_permission('travel_arrangement', 'add')) { ?>
            <div class="panel-body">
                <label>Show Transportation International</label>
                <select class="form-control select-transport-returning-<?= $key ?> select_show" name="travel_arrangement[<?= $key ?>][show_transportation]" id="show_transportation_<?= $key ?>" data-isreturning="1" onchange="show_hide_transportation(this, 'international', '<?= $key ?>')">
                    <option value="">- Select -</option>
                    <option <?= $travel->show_transportation == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
                    <option <?= $travel->show_transportation == 'No' ? 'selected' : '' ?> value="No">No</option>
                    <option <?= $travel->show_transportation == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>
                    <option <?= $travel->show_transportation == 'Third Party' ? 'selected' : '' ?> value="Third Party">Third Party</option>

                </select>
                <label class="mt-3">Show Transportation Domestic</label>
                <select class="form-control select-transport-returning-<?= $key ?> select_show" name="travel_arrangement[<?= $key ?>][show_transportation_domestic]" id="show_transportation_domestic_<?= $key ?>" data-isreturning="1" onchange="show_hide_transportation(this, 'domestic', '<?= $key ?>')">
                    <option value="">- Select -</option>
                    <option <?= $travel->show_transportation_domestic == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
                    <option <?= $travel->show_transportation_domestic == 'No' ? 'selected' : '' ?> value="No">No</option>
                    <option <?= $travel->show_transportation_domestic == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>

                </select>
                <label class="mt-3">Show Accommodation</label>
                <select class="form-control select_show" name="travel_arrangement[<?= $key ?>][show_accomodation]" id="show_accomodation_<?= $key ?>" onchange="show_hide_accomodation(this, 'domestic', '<?= $key ?>')">
                    <option value="">- Select -</option>
                    <option <?= $travel->show_accomodation == 'Yes' ? 'selected' : '' ?> value="Yes">Yes</option>
                    <option <?= $travel->show_accomodation == 'No' ? 'selected' : '' ?> value="No">No</option>
                    <option <?= $travel->show_accomodation == 'Reimbursement' ? 'selected' : '' ?> value="Reimbursement">Reimbursement</option>

                </select>
            </div>
            <?php } ?>
            <div class="header-transport-<?= $key ?>">
                <?php if($grantee_grant->is_degree) : ?>
                <div class="col-lg-12">
                    <div class="form-group">
                        <?php 
                            $grantee_grant_id = isset($grantee_grant_id) ? $grantee_grant_id : (isset($grantee_grant->id) ? $grantee_grant->id : null);
                            if (!isset($health_insurance) && $grantee_grant_id) {
                                $health_insurance = get_row_db('am_health_insurance', ['grantee_grant_id' => $grantee_grant_id]);
                            }
                        ?>
                        <p style="font-weight:bold;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> DOCUMENTS SUBMISSION</p>
                        <div class="panel-body">
                            <div class="col-lg-12"></div>
                                <table class="table table-striped table-bordered table-responsive mt-4">
                                    <thead>
                                        <tr>
                                            <th>Document Name</th>
                                            <th width="30%">File Upload</th>
                                            <th>Status</th>
                                            <th>Upload Date</th>
                                            <?php if(!$is_alumni_page) { ?>
                                            <th>Action</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody id="letter_from_graduate_school_list_<?= $grantee_grant->id ?>" data-is-admin="<?= $is_admin ? '1' : '0' ?>">
                                        <tr>
                                            <td>Letter from Graduate School</td>
                                            <td class="js-file-cell">
                                                <?php if($letter_from_graduate_school->file) : ?>
                                                    <a href="<?= base_url($letter_from_graduate_school->file) ?>" class="lightbox" style="color:#337ab7"><?= basename($letter_from_graduate_school->file) ?></a>
                                                <?php endif; ?>
                                            </td>
                                            <td class="js-status-cell">
                                                <?= $letter_from_graduate_school->status ?>
                                                <?php if($letter_from_graduate_school->status == 'Revise') { ?>
                                                    <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" data-target="#modal_note" data-note="<?= $letter_from_graduate_school->note ?>" data-attach='<?= $letter_from_graduate_school->attachment_revise ?>'>i</span>
                                                <?php } ?>
                                                <?php if($letter_from_graduate_school->status == 'Rejected') { ?>
                                                    <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" data-target="#modal_note" data-note="<?= $letter_from_graduate_school->note_reject ?>" data-attach='<?= $letter_from_graduate_school->attachment_revise ?>'>i</span>
                                                <?php } ?>
                                            </td>
                                            <td class="js-date-cell"><?= $letter_from_graduate_school->created_date ?></td>
                                            <?php if(!$is_alumni_page) { ?>
                                            <td>
                                                <input 
                                                    type="file" 
                                                    id="upload_graduate_school_<?= $grantee_grant->id ?>"
                                                    data-keysession="interview_apointment<?= $key ?>"
                                                    class="hide"
                                                    accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                                                >
                                                <?php 
                                                    $url_upload_graduate_school = $is_admin ? site_url('admin/travel_arrangement/upload_graduate_school') : site_url('grantee/submission/upload_graduate_school');
                                                    $url_delete_graduate_school = $is_admin
                                                        ? site_url('admin/travel_arrangement/delete_graduate_school')
                                                        : site_url('grantee/submission/delete_graduate_school');
                                                ?>
                                                <a
                                                    href="javascript:;"
                                                    class="btn btn-primary btn-xs js-upload-graduate-school <?= (!$is_admin && ($letter_from_graduate_school->status == 'Revise' || !isset($letter_from_graduate_school))) || $is_admin ? '' : 'hide' ?>"
                                                    data-id="<?= $grantee_grant->id ?>"
                                                    data-url="<?= $url_upload_graduate_school ?>"
                                                    style="color:#fff">
                                                    Upload
                                                </a>
            
                                                <?php if($is_admin) { ?>
                                                    <a 
                                                        href="javascript:;" 
                                                        onclick="update_status_graduate_school(this, <?= $letter_from_graduate_school->id ?>, 'approve')" 
                                                        class="btn btn-success <?= $letter_from_graduate_school->file ? '' : 'hide' ?> show-button btn-xs" 
                                                        style="color:#fff">
                                                        Approve
                                                    </a>
                                                    <a 
                                                        href="javascript:;" 
                                                        onclick="update_status_graduate_school(this, <?= $letter_from_graduate_school->id ?>, 'revise')" 
                                                        class="btn btn-warning <?= $letter_from_graduate_school->file ? '' : 'hide' ?> show-button btn-xs" 
                                                        style="color:#fff">
                                                        Revise
                                                    </a>
                                                    <input 
                                                        data-log="<?= $letter_from_graduate_school->id ?>" 
                                                        data-type="graduate_school" 
                                                        data-toggle="modal" 
                                                        data-target="#modal-payment-log" 
                                                        type="button" 
                                                        class="<?= $letter_from_graduate_school->file ? '' : 'hide' ?> show-button btn-xs btn btn-default modal-log" 
                                                        value="Open Log" 
                                                        style="font-size:12px;">
                                                <?php } ?>
                                                <a
                                                    href="javascript:;"
                                                    data-url="<?= $url_delete_graduate_school ?>"
                                                    onclick="del_file_graduate_school(this, <?= (int) $letter_from_graduate_school->id ?>); return false;"
                                                    class="btn btn-danger show-button btn-xs btn-del-letter_from_graduate_school <?= (!$is_admin && $letter_from_graduate_school->status == 'Revise') || $is_admin ? '' : 'hide' ?> <?= $letter_from_graduate_school->file ? '' : 'hide' ?>"
                                                    style="color:#fff">
                                                    <i class="fa fa-trash fa-fw text-white"></i>
                                                </a>
                                            </td>
                                            <?php } ?>
                                        </tr>
                                        <tr id="row_health_insurance_<?= $grantee_grant->id ?>">
                                            <td>Additional Health Insurance</td>
                                            <td class="js-file-cell-health-insurance">
                                                <?php if(!empty($health_insurance->file)) : ?>
                                                    <a href="<?= base_url($health_insurance->file) ?>" class="lightbox" style="color:#337ab7"><?= basename($health_insurance->file) ?></a>
                                                <?php endif; ?>
                                            </td>
                                            <td class="js-status-cell-health-insurance">
                                                <?= !empty($health_insurance->status) ? $health_insurance->status : '' ?>
                                                <?php if(!empty($health_insurance->status) && $health_insurance->status == 'Revise') { ?>
                                                    <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" data-target="#modal_note" data-note="<?= $health_insurance->note ?>" data-attach='<?= $health_insurance->attachment_revise ?>'>i</span>
                                                <?php } ?>
                                                <?php if(!empty($health_insurance->status) && $health_insurance->status == 'Rejected') { ?>
                                                    <span class="label label-primary span-note" style="width: 350px;" data-toggle="modal" data-target="#modal_note" data-note="<?= $health_insurance->note_reject ?>" data-attach='<?= $health_insurance->attachment_revise ?>'>i</span>
                                                <?php } ?>
                                            </td>
                                            <td class="js-date-cell-health-insurance"><?= !empty($health_insurance->created_date) ? $health_insurance->created_date : '' ?></td>
                                            <?php if(!$is_alumni_page) { ?>
                                            <td>
                                                <input 
                                                    type="file" 
                                                    id="upload_health_insurance_<?= $grantee_grant->id ?>"
                                                    data-keysession="interview_apointment<?= $key ?>"
                                                    class="hide"
                                                    accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                                                >
                                                <?php 
                                                    $url_upload_health_insurance = $is_admin ? site_url('admin/travel_arrangement/upload_health_insurance') : site_url('grantee/submission/upload_health_insurance');
                                                    $url_delete_health_insurance = $is_admin
                                                        ? site_url('admin/travel_arrangement/delete_health_insurance')
                                                        : site_url('grantee/submission/delete_health_insurance');
                                                ?>
                                                <a
                                                    href="javascript:;"
                                                    class="btn btn-primary btn-xs js-upload-health-insurance <?= (!$is_admin && (!empty($health_insurance->status) && $health_insurance->status == 'Revise' || !isset($health_insurance))) || $is_admin ? '' : 'hide' ?>"
                                                    data-id="<?= $grantee_grant->id ?>"
                                                    data-url="<?= $url_upload_health_insurance ?>"
                                                    style="color:#fff">
                                                    Upload
                                                </a>
             
                                                <?php if($is_admin) { ?>
                                                    <a 
                                                        href="javascript:;" 
                                                        onclick="update_status_health_insurance(this, <?= !empty($health_insurance->id) ? (int)$health_insurance->id : 0 ?>, 'approve')" 
                                                        class="btn btn-success js-approve-health-insurance <?= !empty($health_insurance->file) ? '' : 'hide' ?> show-button btn-xs" 
                                                        style="color:#fff">
                                                        Approve
                                                    </a>
                                                    <a 
                                                        href="javascript:;" 
                                                        onclick="update_status_health_insurance(this, <?= !empty($health_insurance->id) ? (int)$health_insurance->id : 0 ?>, 'revise')" 
                                                        class="btn btn-warning js-revise-health-insurance <?= !empty($health_insurance->file) ? '' : 'hide' ?> show-button btn-xs" 
                                                        style="color:#fff">
                                                        Revise
                                                    </a>
                                                    <input 
                                                        data-log="<?= !empty($health_insurance->id) ? (int)$health_insurance->id : '' ?>" 
                                                        data-type="health_insurance" 
                                                        data-toggle="modal" 
                                                        data-target="#modal-payment-log" 
                                                        type="button" 
                                                        class="<?= !empty($health_insurance->file) ? '' : 'hide' ?> show-button btn-xs btn btn-default modal-log js-log-health-insurance" 
                                                        value="Open Log" 
                                                        style="font-size:12px;">
                                                <?php } ?>
                                                <a
                                                    href="javascript:;"
                                                    data-url="<?= $url_delete_health_insurance ?>"
                                                    onclick="del_file_health_insurance(this, <?= !empty($health_insurance->id) ? (int)$health_insurance->id : 0 ?>); return false;"
                                                    class="btn btn-danger show-button btn-xs btn-del-health_insurance <?= (!$is_admin && !empty($health_insurance->status) && $health_insurance->status == 'Revise') || $is_admin ? '' : 'hide' ?> <?= !empty($health_insurance->file) ? '' : 'hide' ?>"
                                                    style="color:#fff">
                                                    <i class="fa fa-trash fa-fw text-white"></i>
                                                </a>
                                            </td>
                                            <?php } ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <div class="col-lg-12">
                    <p style="font-weight:bold;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> TRANSPORTATION</p>
                    <div class="panel-body">
                        <div class="col-lg-12">
                            <a href="<?= base_url($grantee_grant->procedure_domestic) ?>" download title="Click to Download" class="mb-5 btn btn-primary procedure_domestic <?= $grantee_grant->procedure_domestic ? '' : 'hide' ?>" style="color:#fff">
                                <i class="fa fa-download fa-fw text-white"></i> Procedure of Domestic Ticket Purchase
                            </a>
                            <p>You may request assistance for your return travel to Indonesia following the completion of your program.</p>
            
                            <ul>
                                <li>If you hold a round-trip international ticket, please contact your airline to confirm or update your return flight. You may request a domestic flight to your hometown (as stated in your initial application) and one night of transit accommodation in Jakarta, if needed.</li>
                                
                                <li>If you do not have a round-trip ticket, you may request a one-way international ticket from the U.S. to Indonesia. This request can include a domestic flight to your hometown (as stated in your initial application) and one night of transit accommodation in Jakarta, if needed.</li>
                            </ul>
            
                            <p>Please ensure all requests are submitted in a timely manner and contact your AMINEF PIC for further guidance and assistance.</p>
                        </div>
                    </div>
                </div>
                
            </div>
            <?php if(has_permission('travel_arrangement', 'add') || $is_grantee) { ?>
            <div class="panel-body section-transportation-international-<?= $key ?>">
                <?php if($is_admin) { ?>
                <div class="row mb-5 section-transportation-international-<?= $key ?>">
                    <div class="col-lg-12">
                        <div class="TriSea-technologies-Switch">
                            <span class="mr-2"> Enable Transportation Grantee</span>
                            <input data-id="<?= $travel->id ?>" onchange="enable_toogle(this, 'enable_transportation')" id="enable_transportation_<?= $key ?>" name="travel_arrangement[<?= $key ?>][enable_transportation]" type="checkbox" <?= $travel->enable_transportation ? 'checked' : '' ?>/>
                            <label for="enable_transportation_<?= $key ?>" class="label-primary"></label>
                        </div>
                    </div>
                </div>
                <?php } ?>

                <?php 
                    $transport_status = evaluate_transportation($travel, $is_admin, [], 'show_transportation', 'enable_transportation');
                ?>

                <?php //if($grantee_grant->is_degree) { ?>
                <div class="col-lg-12 label-international-<?= $key ?> hide">
                    <label>International</label>
                    <hr class="no-margin"/>
                </div>
                <div class="panel-body section-default label-international-<?= $key ?> hide">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>University</label>
                            <input type="text" class="form-control" value="<?= $collage_placement->university_id ? get_university_by_id($collage_placement->university_id)->name : '' ?>" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Arrival Date</label>
                            <input id="arrival_date" type="text" class="form-control datepicker <?= $transport_status['disable_transportation'] ? '' : 'form-control-grantee' ?>" readonly style="background-color:<?= (!$is_admin && $transport_status['disable_transportation']) || $this->session->userdata('role') == 'travel-booking-assistant' ? '#fff' : '#eee' ?>" placeholder="Arrival Date" name="travel_arrangement[<?= $key ?>][arrival_date]" value="<?= $travel->arrival_date ? date('d M Y', strtotime($travel->arrival_date)) : '' ?>">
                            <?php if(($is_admin && $this->session->userdata('role') != 'travel-booking-assistant') || (!$is_admin && $transport_status['disable_transportation'])) { ?>
                            <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Departure City</label>
                            <input id="departure_city" type="text" class="form-control <?= ($is_admin && $this->session->userdata('role') == 'travel-booking-assistant') || (!$is_admin && $transport_status['disable_transportation']) ? '' : 'form-control-grantee' ?>" placeholder="Departure City" name="travel_arrangement[<?= $key ?>][departure_city]" value="<?= $travel && $travel->departure_city != '' ? $travel->departure_city : '' ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Arrival City</label>
                            <input id="arrival_city" type="text" class="form-control <?= ($is_admin && $this->session->userdata('role') == 'travel-booking-assistant') || (!$is_admin) ? '' : 'form-control-grantee' ?>" placeholder="Arrival City" name="travel_arrangement[<?= $key ?>][arrival_city]" value="<?= $travel->arrival_city ?? 'Jakarta' ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Departure Airport</label>
                            <input id="arrival_airport" type="text" class="form-control <?= ($is_admin && $this->session->userdata('role') == 'travel-booking-assistant') || (!$is_admin && $transport_status['disable_transportation']) ? '' : 'form-control-grantee' ?>" placeholder="Departure Airport" name="travel_arrangement[<?= $key ?>][arrival_airport]" value="<?= $travel->arrival_airport ?>">
                        </div>
                    </div>
                    <?php if($transport_status['show_transportation'] || $is_admin || $travel->eticket != '') { ?>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label id="label_eticket_international_<?= $key ?>">E-Ticket</label>
                            <?php if($is_admin || $transport_status['show_upload']) { ?>
                            <input type="file" class="form-control <?= $transport_status['disable_transportation'] ? '' : 'form-control-grantee' ?>" name="eticket_<?= $key ?>">
                            <?php } ?>
                            <?php if ($travel->eticket != '') { ?>
                                <br>
                                <div style="margin-bottom:10px; position:relative; width:100px;">
                                    <a href="<?=base_url() ?><?= $travel->eticket ?>" class="lightbox" aria-haspopup="dialog">
                                        <img id="preview_image_profile" data-old="<?php echo site_url( $travel->eticket); ?>" src="<?php echo get_preview( $travel->eticket); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                    </a>
                                    <a href="<?=base_url() ?><?= $travel->eticket ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty( $travel->eticket) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;color:#fff;">
                                        <i class="fa fa-download fa-fw"></i>
                                    </a>
                                    <?php if($transport_status['show_upload'] || $is_admin) { ?>
                                    <a href="<?= $url_delete.'/eticket/'.$grantee_grant->id.'/'.$travel->id ?>" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                                        <label class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash fa-fw"></i></label>
                                    </a>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <?php //} ?>
            </div>
            <div class="panel-body section-transportation-domestic-<?= $key ?>">
                <!-- domestic section -->
                <?php 
                    $transport_status_domestic = evaluate_transportation($travel, $is_admin, [], 'show_transportation_domestic', 'enable_transportation_domestic');
                ?>
                <?php if($is_admin) { ?>
                <div class="row mb-5 section-transportation-domestic-<?= $key ?>">
                    <div class="col-lg-12">
                        <div class="TriSea-technologies-Switch">
                            <span class="mr-2"> Enable Transportation Domestic Grantee</span>
                            <input data-id="<?= $travel->id ?>" onchange="enable_toogle(this, 'enable_transportation_domestic')" id="enable_transportation_domestic_<?= $key ?>" name="travel_arrangement[<?= $key ?>][enable_transportation_domestic]" type="checkbox" <?= $travel->enable_transportation_domestic ? 'checked' : '' ?>/>
                            <label for="enable_transportation_domestic_<?= $key ?>" class="label-primary"></label>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <div class="col-lg-12">
                    <label>Domestic Ticket</label>
                    <hr class="no-margin"/>
                </div>
                <div class="panel-body">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Departure City</label>
                            <input type="text" class="form-control <?= !$is_admin ? '' : 'form-control-grantee' ?>" placeholder="Departure City" name="travel_arrangement[<?= $key ?>][returning_origin_city]" value="<?= $travel->returning_origin_city ?? 'Jakarta' ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Arrival City</label>
                            <input type="text" class="form-control <?= $transport_status_domestic['disable_transportation'] ? '' : 'form-control-grantee' ?>" placeholder="Arrival City" name="travel_arrangement[<?= $key ?>][returning_destination_city]" value="<?= $travel->returning_destination_city ?>">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Departure Date</label>
                            <input type="text" class="form-control <?= $transport_status_domestic['disable_transportation'] ? '' : 'form-control-grantee' ?> datepicker" readonly style="background-color:#fff" placeholder="Departure Date" name="travel_arrangement[<?= $key ?>][returning_date]" value="<?= $travel->returning_date != '' ? date('d M Y', strtotime($travel->returning_date)) : '' ?>">
                            <a href="javascript:;" onclick="emptyValue(this)" class="<?= !$transport_status_domestic['show_transportation'] ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                        </div>
                    </div>
                    <?php if($transport_status_domestic['show_transportation'] || $is_admin || $travel->eticket_returning != '') { ?>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label id="label_eticket_domestic_<?= $key ?>">E-Ticket</label>
                            <?php if($is_admin || $transport_status_domestic['show_transportation']) { ?>
                            <input type="file" class="form-control  <?= $transport_status_domestic['disable_transportation'] ? '' : 'form-control-grantee' ?>" name="eticket_returning_<?= $key ?>">
                            <?php } ?>
                            <?php if ($travel->eticket_returning != '') { ?>
                                <br>
                                <div style="margin-bottom:10px; position:relative; width:100px;">
                                    <a href="<?=base_url() ?><?= $travel->eticket_returning ?>" class="lightbox" aria-haspopup="dialog">
                                        <img id="preview_image_profile" data-old="<?php echo site_url( $travel->eticket_returning); ?>" src="<?php echo get_preview( $travel->eticket_returning); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                    </a>
                                    <a href="<?=base_url() ?><?= $travel->eticket_returning ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty( $travel->eticket_returning) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;color:#fff;">
                                        <i class="fa fa-download fa-fw"></i>
                                    </a>
                                    <?php if($transport_status_domestic['show_transportation'] || $is_admin) { ?>
                                    <a href="<?= $url_delete.'/eticket_returning/'.$grantee_grant->id.'/'.$travel->id ?>" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                                        <label class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash fa-fw"></i></label>
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
            <?php if(has_permission('travel_arrangement', 'add') || $is_grantee) { ?>
            <div class="panel-body section-accomodation-domestic-<?= $key ?>">
                <?php if($is_admin) { ?>
                <div class="row mt-5 section-accomodation-domestic-<?= $key ?>">
                    <div class="col-lg-12">
                        <div class="TriSea-technologies-Switch">
                            <span class="mr-2"> Enable Accommodation Grantee</span>
                            <input data-id="<?= $travel->id ?>" onchange="enable_toogle(this, 'enable_accommodation')" id="enable_accommodation_<?= $key ?>" name="travel_arrangement[<?= $key ?>][enable_accommodation]" type="checkbox" <?= $travel->enable_accommodation ? 'checked' : '' ?>/>
                            <label for="enable_accommodation_<?= $key ?>" class="label-primary"></label>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php 
                    $accommodation_status = evaluate_transportation($travel, $is_admin, [], 'show_accomodation', 'enable_accommodation');
                ?>
                <div class="col-lg-12">
                    <p style="font-weight:bold;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> ACCOMMODATION</p>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Check-In Date</label>
                        <input type="text" class="form-control <?= $accommodation_status['disable_transportation'] ? '' : 'form-control-grantee' ?> datepicker" readonly style="background-color:#fff" placeholder="Check-In Date" name="travel_arrangement[<?= $key ?>][checkin_date]" value="<?= $travel->checkin_date != '' ? date('d M Y', strtotime($travel->checkin_date)) : '' ?>">
                        <a href="javascript:;" onclick="emptyValue(this)" class="<?= !$accommodation_status['show_transportation'] ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Check-Out Date</label>
                        <input type="text" class="form-control <?= $accommodation_status['disable_transportation'] ? '' : 'form-control-grantee' ?> datepicker" readonly style="background-color:#fff" placeholder="Check-Out Date" name="travel_arrangement[<?= $key ?>][checkout_date]" value="<?= $travel->checkout_date != '' ? date('d M Y', strtotime($travel->checkout_date)) : '' ?>">
                        <a href="javascript:;" onclick="emptyValue(this)" class="<?= !$accommodation_status['show_transportation'] ? 'd-none' : '' ?> btn btn-secondary" style="color:#000;position:absolute; top:25px; right:15px;">X</a>
                    </div>
                </div>
                <?php if($accommodation_status['show_transportation'] || $is_admin || $travel->voucher_hotel != '') { ?>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label id="label_voucher_hotel_domestic_<?= $key ?>">Hotel Voucher</label>
                        <?php if($is_admin || $accommodation_status['show_upload']) { ?>
                        <input type="file" class="form-control <?= $accommodation_status['disable_transportation'] ? '' : 'form-control-grantee' ?>" name="voucher_hotel_<?= $key ?>">
                        <?php } ?>
                        <?php if ( $travel &&  $travel->voucher_hotel != '') { ?>
                            <br>
                            <div style="margin-bottom:10px; position:relative; width:100px;">
                                <a href="<?=base_url() ?><?= $travel->voucher_hotel ?>" class="lightbox" aria-haspopup="dialog">
                                    <img id="preview_image_profile" data-old="<?php echo site_url( $travel->voucher_hotel); ?>" src="<?php echo get_preview( $travel->voucher_hotel); ?>" width="100" style="min-height:60px;object-fit:contain;">
                                </a>
                                <a href="<?=base_url() ?><?= $travel->voucher_hotel ?>" id="button_download_img_photo" download title="Click to download" class="btn btn-primary btn-xs mt-5 <?php echo empty( $travel->voucher_hotel) ? 'hide' : ''; ?>" style="position:absolute; top:-28px; right:-28px;color:#fff;">
                                    <i class="fa fa-download fa-fw"></i>
                                </a>
                                <?php if($accommodation_status['show_transportation'] || $is_admin) { ?>
                                <a href="<?= $url_delete.'/voucher_hotel/'.$grantee_grant->id.'/'.$travel->id ?>" style="position:absolute; top:25px; right:-28px;cursor:pointer">
                                    <label class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash fa-fw"></i></label>
                                </a>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
        </div>

        <?php if($travel->enable_transportation || $travel->enable_transportation_domestic|| $travel->enable_accommodation || $is_admin) { ?>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="pull-right">
                    <?php if($this->session->userdata('role') == 'travel-booking-assistant') { ?>
                    <button type="button" name="btn_and_send" value="<?= $key ?>" onclick="return showSwal('confirm_submit', 'Are you sure you want to save and send?', false, false, false, '#form', '<?= $key ?>', 1)" class="btn btn-primary">Save and Send</button>
                    <?php } ?>
                    <button type="button" name="btn" value="<?= $key ?>" onclick="return showSwal('confirm_submit', 'Are you sure you want to save?', false, false, false, '#form', '<?= $key ?>')" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<div class="modal fade" id="mdl_note_revise" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow-y: auto;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center" id="exampleModalLabel">Add Note</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="submission_plan_id" id="submission_plan_id">
                <div class="row" id="section_reason_rejection">
                    <div class="col-md-12">
                        <label>Attachment</label>
                        <label for="temp_attachment_revise" class="withdraw-attachment-area">
                            <input type="file" id="temp_attachment_revise" name="temp_attachment_revise" class="hide" onchange="show_preview_attch(this, 'attachment_revise', 'attachment_revise');">
                            <input type="text" id="attachment_revise" name="attachment_revise" class="hide">
                            <i class="fa fa-cloud-upload"></i>
                        </label>
                        <div class="col-md-12 text-center">
                            <a class="uploaded_attachment_admin btn-link hide" style="cursor: pointer;" target="_blank"><b>View Uploaded Attachment</b></a>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
				            <label>Note</label>
                            <textarea class="form-control" name="note_revise" id="note_revise" rows="5"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="button" id="btn-save-note" name="btn-submit" value="decline" class="btn btn-primary success">Save</button>
                <input id="hide-btn" type="hidden" disabled="disabled" name="btn" value="save_rec">
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('admin/partials/modal_log') ?>
<?php $this->load->view('admin/partials/modal_note') ?>