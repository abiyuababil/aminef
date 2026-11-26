<div class="modal fade" id="form_add_appointment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow-y: auto;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center" id="exampleModalLabel">Add Data Appointment</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="form_appointment">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Surename/Last Name <span style='color:red'> *</span></label>
                                <input class="form-control auto-capitalize fields_appointment" name="last_name" required>
                            </div>
                            <div class="form-group">
                                <label>Given Name/First Name <span style='color:red'> *</span></label>
                                <input class="form-control auto-capitalize fields_appointment" name="first_name" required>
                            </div>
                            <div class="form-group">
                                <label>Date of Birth <span style='color:red'> *</span></label>
                                <input class="form-control fields_appointment datepicker" name="date_of_birth" required>
                            </div>
                            <div class="form-group">
                                <label>Passport Number <span style='color:red'> *</span></label>
                                <input class="form-control fields_appointment" name="passport" required>
                            </div>
                            <div class="form-group">
                                <label>Passport Type <span style='color:red'> *</span></label>
                                <select name="passport_type" class="form-control" required>
                                    <option value="">-- Select --</option>
                                    <option value="Regular">Regular</option>
                                    <option value="Official">Official</option>
                                    <option value="Diplomatic">Diplomatic</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nationality <span style='color:red'> *</span></label>
                                <input class="form-control fields_appointment" name="nationality" required>
                            </div>
                            <div class="form-group">
                                <label>Visa Type <span style='color:red'> *</span></label>
                                <select name="visa_type" class="form-control" required>
                                    <option value="">-- Select --</option>
                                    <option value="J1">J1</option>
                                    <option value="J2">J2</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Email Address <span style='color:red'> *</span></label>
                                <input type="email" class="form-control fields_appointment" name="email" required>
                            </div>
                            <div class="form-group">
                                <label>DS-160 Confirmation Number <span style='color:red'> *</span></label>
                                <input class="form-control fields_appointment" name="ds160" required>
                            </div>
                            <div class="form-group">
                                <label>SEVIS ID <span style='color:red'> *</span></label>
                                <input class="form-control fields_ds160" name="sevis_id" required>
                            </div>
                            <div class="form-group">
                                <label>Interview Location <span style='color:red'> *</span></label>
                                <!-- <input class="form-control fields_ds160" name="interview_location"> -->
                                <select class="form-control" name="interview_location" style="width:100%" required>
                                    <option value="">-- Select --</option>
                                    <option value="Jakarta">Jakarta</option>
                                    <option value="Surabaya">Surabaya</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Proposed Visa Interview Date <span style='color:red'> *</span></label>
                                <input class="form-control fields_ds160 datepicker" name="propose_date" required>
                            </div>
                            <div class="form-group">
                                <label>Travel Plan <span style='color:red'> *</span></label>
                                <input class="form-control fields_ds160 datepicker" name="travel_plan" required>
                            </div>
                            <div class="form-group">
                                <label>Telephone Number <span style='color:red'> *</span></label>
                                <input class="form-control fields_appointment" type="number" name="telephone" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="submit" form="form_appointment" data-is_admin="<?= $is_admin ?>" id="btn-save-appointment" name="btn-submit" class="btn btn-primary success">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="form_edit_appointment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow-y: auto;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center" id="exampleModalLabel">Edit Data Appointment</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="edit_form_appointment">
                    <input type="hidden" name="appointment_id" id="appointment_id">
                    <input type="hidden" name="index" id="index_appointment">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Surename/Last Name <span style='color:red'> *</span></label>
                                <input readonly class="form-control auto-capitalize fields_appointment" name="last_name" id="last_name_appointment" required>
                            </div>
                            <div class="form-group">
                                <label>Given Name/First Name <span style='color:red'> *</span></label>
                                <input readonly class="form-control auto-capitalize fields_appointment" name="first_name" id="first_name_appointment" required>
                            </div>
                            <!-- <div class="form-group">
                                <label>Deadline <span style='color:red'> *</span></label>
                                <input class="form-control fields_appointment datepicker" name="deadline" id="deadline" required readonly style="background-color: #fff;">
                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:175px; right:15px;">X</a>
                            </div> -->
                            <div class="form-group">
                                <label>Date of Birth <span style='color:red'> *</span></label>
                                <input class="form-control fields_appointment datepicker" name="date_of_birth" id="date_of_birth" required readonly style="background-color: #fff;">
                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:248px; right:15px;">X</a>
                            </div>
                            <div class="form-group">
                                <label>Passport Number <span style='color:red'> *</span></label>
                                <input class="form-control fields_appointment" name="passport" id="passport" required>
                            </div>
                            <div class="form-group">
                                <label>Passport Type <span style='color:red'> *</span></label>
                                <select name="passport_type" class="form-control" id="passport_type" required>
                                    <option value="">-- Select --</option>
                                    <option value="Regular">Regular</option>
                                    <option value="Official">Official</option>
                                    <option value="Diplomatic">Diplomatic</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nationality <span style='color:red'> *</span></label>
                                <input class="form-control fields_appointment" name="nationality" id="nationality" required>
                            </div>
                            <div class="form-group">
                                <label>Visa Type <span style='color:red'> *</span></label>
                                <select name="visa_type" class="form-control" id="visa_type" required>
                                    <option value="">-- Select --</option>
                                    <option value="J1">J1</option>
                                    <option value="J2">J2</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Email Address <span style='color:red'> *</span></label>
                                <input type="email" class="form-control fields_appointment" name="email" id="email_app" required>
                            </div>
                            <div class="form-group">
                                <label>DS-160 Confirmation Number <span style='color:red'> *</span></label>
                                <input class="form-control fields_appointment" name="ds160" id="ds160" required>
                            </div>
                            <div class="form-group">
                                <label>SEVIS ID <span style='color:red'> *</span></label>
                                <input readonly class="form-control fields_ds160" name="sevis_id" id="sevis_id_app" required>
                            </div>
                            <div class="form-group">
                                <label>Interview Location <span style='color:red'> *</span></label>
                                <input type="hidden" class="form-control" id="interview_location_app_input" name="interview_location">
                                <select disabled class="form-control" id="interview_location_app_select" style="width:100%" required>
                                    <option value="">-- Select --</option>
                                    <option value="Jakarta">Jakarta</option>
                                    <option value="Surabaya">Surabaya</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Proposed Visa Interview Date <span style='color:red'> *</span></label>
                                <input class="form-control fields_ds160 datepicker" name="propose_date" id="propose_date_app" required readonly style="background-color: #fff;">
                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:322px; right:15px;">X</a>
                            </div>
                            <div class="form-group">
                                <label>Travel Plan <span style='color:red'> *</span></label>
                                <input class="form-control fields_ds160 datepicker" name="travel_plan" id="travel_plan_app" required readonly style="background-color: #fff;">
                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:395px; right:15px;">X</a>
                            </div>
                            <div class="form-group">
                                <label>Telephone Number <span style='color:red'> *</span></label>
                                <input class="form-control fields_appointment" type="number" name="telephone" id="telephone_app" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="submit" form="edit_form_appointment" data-is_admin="<?= $is_admin ?>" id="btn-edit-appointment" name="btn-submit" class="btn btn-primary success">Save</button>
            </div>
        </div>
    </div>
</div>