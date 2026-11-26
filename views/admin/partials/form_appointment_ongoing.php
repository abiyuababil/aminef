<div class="modal fade" id="form_add_appointment_ongoing" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow-y: auto;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center" id="exampleModalLabel">Add Data Appointment</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" form="form_appointment_renewal" id="visa_id_renewal" name="visa_id"> 
                <input type="hidden" form="form_appointment_renewal" id="idx_renewal" name="idx"> 
                <input type="hidden" form="form_appointment_renewal" id="idxv_renewal" name="idxv"> 
                <form method="post" id="form_appointment_renewal">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="submit" form="form_appointment_renewal" data-is_admin="<?= $is_admin ?>" id="btn-save-appointment" name="btn-submit" class="btn btn-primary success">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="hide field-appointment-jakarta">
    <input type="hidden" class="fields_appointment appointment_id" name="appointment_id">
    <input type="hidden" class="fields_appointment index_appointment" name="index_appointment">
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label>Surename/Last Name <span style='color:red'> *</span></label>
                <input class="form-control auto-capitalize fields_appointment last_name" name="last_name" required>
            </div>
            <div class="form-group">
                <label>Given Name/First Name <span style='color:red'> *</span></label>
                <input class="form-control auto-capitalize fields_appointment first_name" name="first_name" required>
                <input type="checkbox" value="1" autocomplete="off" name="dont_have_first_name" id="dont_have_first_name_apa" class="dont_have_first_name" <?= $grantee_grant->dont_have_first_name == 1 ? "checked" : "" ?>>
                <label class="is_unlimited_label" for="dont_have_first_name_apa">I do not have a first/given name</label>
            </div>
            <div class="form-group">
                <label>Gender <span style='color:red'> *</span></label>
                <select class="form-control fields_appointment gender" id="gender" name="gender" style="width:100%" required>
                    <option value="">-- Select --</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="form-group">
                <label>Date of Birth <span style='color:red'> *</span></label>
                <input class="form-control fields_appointment needdatepicker date_of_birth" name="date_of_birth" required readonly>
            </div>
        </div>
    
        <div class="col-lg-6">
            <div class="form-group">
                <label>Place of Birth <span style='color:red'> *</span></label>
                <input class="form-control fields_appointment place_of_birth" name="place_of_birth" id="place_of_birth" required>
            </div>
            <div class="form-group">
                <label>Passport Number <span style='color:red'> *</span></label>
                <input class="form-control fields_appointment passport" name="passport" required>
            </div>
            <div class="form-group">
                <label>DS-160 Confirmation Number <span style='color:red'> *</span></label>
                <input class="form-control fields_appointment ds160" name="ds160" required>
            </div>
        </div>
    </div>
</div>

<div class="hide field-appointment-surabaya">
    <input type="hidden" class="fields_appointment appointment_id" name="appointment_id">
    <input type="hidden" class="fields_appointment index_appointment" name="index_appointment">
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label>Surename/Last Name <span style='color:red'> *</span></label>
                <input class="form-control auto-capitalize fields_appointment last_name" name="last_name" required>
            </div>
            <div class="form-group">
                <label>Given Name/First Name <span style='color:red'> *</span></label>
                <input class="form-control auto-capitalize fields_appointment first_name" name="first_name" required>
                <input type="checkbox" value="1" autocomplete="off" name="dont_have_first_name" id="dont_have_first_name2" class="dont_have_first_name" <?= $grantee_grant->dont_have_first_name == 1 ? "checked" : "" ?>>
                <label class="is_unlimited_label" for="dont_have_first_name2">I do not have a first/given name</label>
            </div>
            <div class="form-group">
                <label>Date of Birth <span style='color:red'> *</span></label>
                <input class="form-control fields_appointment needdatepicker date_of_birth" name="date_of_birth" required readonly>
                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:200px; right:15px;">X</a>
            </div>
            <div class="form-group">
                <label>Passport Number <span style='color:red'> *</span></label>
                <input class="form-control fields_appointment passport" name="passport" required>
            </div>
            <div class="form-group">
                <label>Passport Type <span style='color:red'> *</span></label>
                <select name="passport_type" class="form-control fields_appointment passport_type" required>
                    <option value="">-- Select --</option>
                    <option value="Regular">Regular</option>
                    <option value="Official">Official</option>
                    <option value="Diplomatic">Diplomatic</option>
                </select>
            </div>
            <div class="form-group">
                <label>Nationality <span style='color:red'> *</span></label>
                <input class="form-control fields_appointment nationality" name="nationality" required>
            </div>
            <div class="form-group">
                <label>Visa Type <span style='color:red'> *</span></label>
                <select name="visa_type_ongoing" class="form-control visa_type_ongoing" required>
                    <option value="">-- Select --</option>
                    <option value="J1">J1</option>
                    <option value="J2">J2</option>
                </select>
            </div>
            <div class="form-group">
                <label>DS-160 Confirmation Number <span style='color:red'> *</span></label>
                <input class="form-control fields_appointment ds160" name="ds160" required>
            </div>
        </div>
    
        <div class="col-lg-6">
            <div class="form-group">
                <label>Program Number <span style='color:red'> *</span></label>
                <input class="form-control fields_appointment program_number" name="program_number" required>
            </div>
            <div class="form-group">
                <label>Email Address <span style='color:red'> *</span></label>
                <input type="email" class="form-control fields_appointment email" name="email" required>
            </div>
            <div class="form-group">
                <label>SEVIS ID <span style='color:red'> *</span></label>
                <input class="form-control fields_appointment sevis_id" name="sevis_id" required>
            </div>
            <div class="form-group">
                <label>Interview Location <span style='color:red'> *</span></label>
                <!-- <input class="form-control fields_appointment" name="interview_location"> -->
                <select class="form-control fields_appointment interview_location" name="interview_location" id="interview_location_renewal" style="width:100%" required>
                    <option value="">-- Select --</option>
                    <option value="Jakarta">Jakarta</option>
                    <option value="Surabaya">Surabaya</option>
                </select>
            </div>
            <!-- <div class="form-group">
                <label>Visa Interview Date <span style='color:red'> *</span></label>
                <input class="form-control fields_appointment needdatepicker propose_date" name="propose_date" required readonly>
                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:320px; right:15px;">X</a>
            </div> -->
            <div class="form-group">
                <label>Travel Date <span style='color:red'> *</span></label>
                <input class="form-control fields_appointment needdatepicker travel_plan" name="travel_plan" required readonly>
                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute; top:395px; right:15px;">X</a>
            </div>
            <div class="form-group">
                <label>Telephone Number <span style='color:red'> *</span></label>
                <input class="form-control fields_appointment telephone" type="number" name="telephone" required>
            </div>
        </div>
    </div>
</div>