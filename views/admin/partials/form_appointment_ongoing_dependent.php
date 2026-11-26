<div class="modal fade" id="form_add_appointment_dependent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow-y: auto;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center" id="exampleModalLabel">Add Data Appointment</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="form_appointment_dependent">
                <input type="hidden" id="visa_id_dependent" name="visa_id"> 
                <input type="hidden" id="idx_dependent" name="idx"> 
                <input type="hidden" id="idxv_dependent" name="idxv"> 
                <input type="hidden" class="fields_appointment appointment_id" name="appointment_id">
                <input type="hidden" class="fields_appointment index_appointment" name="index_appointment">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Surename/Last Name <span style='color:red'> *</span></label>
                                <input class="form-control auto-capitalize fields_appointment_dependent last_name" name="last_name" required>
                            </div>
                            <div class="form-group">
                                <label>Given Name/First Name <span style='color:red'> *</span></label>
                                <input class="form-control auto-capitalize fields_appointment_dependent first_name" name="first_name" required>
                                <input type="checkbox" value="1" autocomplete="off" name="dont_have_first_name" id="dont_have_first_name" class="dont_have_first_name" <?= $grantee_grant->dont_have_first_name == 1 ? "checked" : "" ?>>
                                <label class="is_unlimited_label" for="dont_have_first_name">I do not have a first/given name</label>
                            </div>
                            <div class="form-group">
                                <label>Date of Birth <span style='color:red'> *</span></label>
                                <input class="form-control fields_appointment_dependent needdatepicker date_of_birth" name="date_of_birth" required readonly>
                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:200px; right:15px;">X</a>
                            </div>
                            <div class="form-group">
                                <label>Passport Number <span style='color:red'> *</span></label>
                                <input class="form-control fields_appointment_dependent passport" name="passport" required>
                            </div>
                            <div class="form-group">
                                <label>Passport Type <span style='color:red'> *</span></label>
                                <select name="passport_type" class="form-control fields_appointment_dependent passport_type" required>
                                    <option value="">-- Select --</option>
                                    <option value="Regular">Regular</option>
                                    <option value="Official">Official</option>
                                    <option value="Diplomatic">Diplomatic</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nationality <span style='color:red'> *</span></label>
                                <input class="form-control fields_appointment_dependent nationality" name="nationality" required>
                            </div>
                            <div class="form-group">
                                <label>Visa Type <span style='color:red'> *</span></label>
                                <select name="visa_type_ongoing" class="form-control fields_appointment_dependent visa_type_ongoing no-click" required>
                                    <option value="">-- Select --</option>
                                    <option value="J1">J1</option>
                                    <option value="J2" selected>J2</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Email Address <span style='color:red'> *</span></label>
                                <input type="email" class="form-control fields_appointment_dependent email" name="email" required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>DS-160 Confirmation Number <span style='color:red'> *</span></label>
                                <input class="form-control fields_appointment_dependent ds160" name="ds160" required>
                            </div>
                            <div class="form-group">
                                <label>SEVIS ID <span style='color:red'> *</span></label>
                                <input class="form-control fields_appointment_dependent sevis_id" name="sevis_id" required>
                            </div>
                            <div class="form-group">
                                <label>Program Number <span style='color:red'> *</span></label>
                                <input class="form-control fields_appointment_dependent program_number" name="program_number" required>
                            </div>
                            <div class="form-group">
                                <label>Interview Location <span style='color:red'> *</span></label>
                                <select class="form-control fields_appointment_dependent interview_location" name="interview_location" id="interview_location_dependent" style="width:100%" required>
                                    <option value="">-- Select --</option>
                                    <option value="Jakarta">Jakarta</option>
                                    <option value="Surabaya">Surabaya</option>
                                </select>
                            </div>
                            <!-- <div class="form-group">
                                <label>Proposed Visa Interview Date <span style='color:red'> *</span></label>
                                <input class="form-control fields_appointment_dependent propose_date needdatepicker" name="propose_date" required readonly>
                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:320px; right:15px;">X</a>
                            </div> -->
                            <div class="form-group">
                                <label>Travel Plan <span style='color:red'> *</span></label>
                                <input class="form-control fields_appointment_dependent travel_plan needdatepicker" name="travel_plan" required readonly>
                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:322px; right:15px;">X</a>
                            </div>
                            <div class="form-group">
                                <label>Telephone Number <span style='color:red'> *</span></label>
                                <input class="form-control fields_appointment_dependent telephone" type="number" name="telephone" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="submit" form="form_appointment_dependent" data-is_admin="<?= $is_admin ?>" id="btn-save-appointment-dependent" name="btn-submit" class="btn btn-primary success">Save</button>
            </div>
        </div>
    </div>
</div>