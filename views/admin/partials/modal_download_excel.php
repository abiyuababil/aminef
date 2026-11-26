
<div class="modal fade" id="modalDownload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" id="form-download-excel">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Download Excel</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <center>
                                <b>Select Active Grant</b><br><br>
                            </center>
                            <center>
                                <div class="radio d-inline">
                                    <select name="active_grant_id" id="active_grant_id" class="form-control selectpicker" data-live-search="true">
                                        <option value="">-- Select Active Grant --</option>
                                        <?php foreach ($program_available as $key_p_a => $p_a) { ?>
                                            <option value="<?= $p_a->id ?>"><?= $p_a->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <small class="text-danger d-none text-validation-activegrant" id="text-validation-active-grant">Choose Active Grant</small>
                            </center>
                            <hr>
                        </div>
                        <div class="col-md-6">
                            <center>
                                <b>Select Period</b><br><br>
                            </center>
                            <center>
                                <div class="radio d-inline">
                                    <select name="period" id="select_period" class="form-control selectpicker">
                                        <option value="">-- Select Period --</option>
                                    </select>
                                </div>
                                <small class="text-danger d-none text-validation-activegrant" id="text-validation-period">Choose Period</small>
                            </center>
                            <hr>
                        </div>
                        <div class="field_row hide">
                            <div class="col-md-12">
                                <ul class="list-style-none p-0">
                                    <li>
                                        <div class="form-check">
                                            <label><input id="sel-all" type="checkbox" checked> Select All </label> 
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-12">
                                <div class="alert alert-info">
                                    <b>Personal Information</b>
                                </div>
                            </div>
                            <div class="row pr-4">
                            
                            <?php foreach (array_split($all_field, 4) as $key_a_f => $a_f) : ?>
                                <div class="col-md-3">
                                    <ul class="list-style-none pl-4">
                                        <?php foreach ($a_f as $key => $value) : ?>
                                            <?php
                                                $current_key = explode('_', $key);
                                                $field_property = '';
                                                if ($current_key[0] == 'emergency') {
                                                    $field_property = 'emergency_contact_field';
                                                }
                                            ?>
                                            <li>
                                                <div class="form-check">
                                                    <table>
                                                        <tr>
                                                            <td style="vertical-align: top !important;">
                                                                <input type="checkbox" name="field_alumni[]" class="form-check-input field-alumni mr-1" id="field_alumni_check<?= $key ?>" value="<?= "$key *-* $value" ?><?php echo !empty($field_property) ? " *-* " . $field_property : ""; ?>">
                                                            </td>
                                                            <td>
                                                                <label class="form-check-label font-weight-normal d-inline" for="field_alumni_check<?= $key ?>"><?= $value ?></label>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    
                                                    
                                                </div>
                                            </li>
                                        <?php endforeach ?>
                                    </ul>
                                </div>
                            <?php endforeach ?>
                            </div>
                            <div class="row add_fields pr-4"></div>
                            <div class="col-md-12 d-none text-center text-validation mb-4" id="text-validation-field">
                                <small class="text-danger">Select at least one field</small>
                            </div>
                        </div>
                        <div class="col-md-12 hide">
                            <div class="radio d-inline mr-4">
                                <label><input type="radio" class="grant-alumni" name="grant_option" style="margin-top:1px" value="single_grant" checked>Single Grant</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button type="submit" class="btn btn-success">Download</button>
                </div>
            </form>
        </div>
    </div>
</div>