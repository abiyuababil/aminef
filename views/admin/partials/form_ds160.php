<div class="modal fade" id="form_add_ds160" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow-y: auto;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center" id="exampleModalLabel">Add Data DS160</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="form_ds160">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Surename/Last Name <span style='color:red'> *</span></label>
                                <input class="form-control auto-capitalize fields_ds160" name="last_name" required>
                            </div>
                            <div class="form-group">
                                <label>Given Name/First Name <span style='color:red'> *</span></label>
                                <input class="form-control auto-capitalize fields_ds160" name="first_name" required>
                                <input type="checkbox" value="1" autocomplete="off" name="dont_have_first_name" class="dont_have_first_name" id="dont_have_first_name5" <?= $grantee_grant->dont_have_first_name == 1 ? "checked" : "" ?>>
                                <label class="is_unlimited_label" for="dont_have_first_name5">I do not have a first/given name</label>
                            </div>
                            <div class="form-group">
                                <label>SEVIS ID <span style='color:red'> *</span></label>
                                <input class="form-control fields_ds160" name="sevis_id" required>
                            </div>
                            <div class="form-group">
                                <label>Program Number <span style='color:red'> *</span></label>
                                <input class="form-control fields_ds160" name="program_number" required id="program_number_add">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Program Starting Date <span style='color:red'> *</span></label>
                                <input class="form-control fields_ds160 datepicker" name="start_date" required id="start_date_add">
                            </div>
                            <div class="form-group">
                                <label>Program End Date <span style='color:red'> *</span></label>
                                <input class="form-control fields_ds160 datepicker" name="end_date" required id="end_date_add">
                            </div>
                            <div class="form-group">
                                <label>Interview Location <span style='color:red'> *</span></label>
                                <!-- <input class="form-control fields_ds160" name="interview_location"> -->
                                <select class="form-control" id="interview_location_add" name="interview_location" style="width:100%" required>
                                    <option value="">-- Select --</option>
                                    <option value="Jakarta">Jakarta</option>
                                    <option value="Surabaya">Surabaya</option>
                                </select>
                            </div>
                            <!-- <div class="form-group">
                                <label>Proposed Visa Interview Date <span style='color:red'> *</span></label>
                                <input class="form-control fields_ds160 datepicker" name="propose_date" id="propose_date_add" required>
                            </div> -->
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="submit" form="form_ds160" id="btn-save-ds160" name="btn-submit" class="btn btn-primary success">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="form_edit_ds160" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow-y: auto;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title text-center" id="exampleModalLabel">Edit Data DS160</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="edit_form_ds160">
                    <input type="hidden" name="ds160_id" id="ds160_id">
                    <input type="hidden" name="index" id="index">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Surename/Last Name <span style='color:red'> *</span></label>
                                <input class="form-control auto-capitalize fields_ds160" name="last_name" id="last_name" required>
                            </div>
                            <div class="form-group">
                                <label>Given Name/First Name <span style='color:red'> *</span></label>
                                <input class="form-control auto-capitalize fields_ds160" name="first_name" id="first_name" required>
                                <input type="checkbox" value="1" autocomplete="off" name="dont_have_first_name" class="dont_have_first_name" id="dont_have_first_nameds160" <?= $grantee_grant->dont_have_first_name == 1 ? "checked" : "" ?>>
                                <label class="is_unlimited_label" for="dont_have_first_nameds160">I do not have a first/given name</label>
                            </div>
                            <div class="form-group">
                                <label>SEVIS ID <span style='color:red'> *</span></label>
                                <input class="form-control fields_ds160" name="sevis_id" id="sevis_id" required>
                            </div>
                            <div class="form-group">
                                <label>Program Number <span style='color:red'> *</span></label>
                                <input class="form-control fields_ds160" name="program_number" id="program_number" required readonly>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Program Starting Date <span style='color:red'> *</span></label>
                                <input class="form-control fields_ds160 datepicker" name="start_date" id="start_date" required readonly>
                            </div>
                            <div class="form-group">
                                <label>Program End Date <span style='color:red'> *</span></label>
                                <input class="form-control fields_ds160 datepicker" name="end_date" id="end_date" required readonly>
                            </div>
                            <div class="form-group">
                                <label>Interview Location <span style='color:red'> *</span></label>
                                <!-- <input class="form-control fields_ds160" name="interview_location" id="interview_location" required> -->
                                <select class="form-control" id="interview_location" name="interview_location" style="width:100%" required>
                                    <option value="">-- Select --</option>
                                    <option value="Jakarta">Jakarta</option>
                                    <option value="Surabaya">Surabaya</option>
                                </select>
                            </div>
                            <!-- <div class="form-group">
                                <label>Proposed Visa Interview Date <span style='color:red'> *</span></label>
                                <input class="form-control fields_ds160 datepicker" name="propose_date" id="propose_date" required>
                            </div> -->
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button form="edit_form_ds160" type="submit" id="btn-edit-ds160" name="btn-submit" class="btn btn-primary success">Save</button>
            </div>
        </div>
    </div>
</div>