<div id="us_address" class="tab-pane fade">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <h3 class="page-header">US ADDRESS</h3>
                <?php foreach ($history as $key => $value) { ?>
                    <div id="us-address-section" class="panel-body mt-3">
                        <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> <?= $value['grant_name'] ?> (<?= $value['fiscal_year'] ?>)<br />
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Country</label>
                                    <select id="<?= $key ?>us_country" class="form-control select2 us-address-country" name="us_country" style="width:100%">
                                        <option value="">-- Select Country --</option>
                                        <?php
                                        if ($country_list) {
                                            foreach ($country_list as $cl) {
                                                $selected = '';
                                                if ($value['us_country'] == $cl->id) {
                                                    $selected = 'selected="selected"';
                                                }
                                        ?>
                                                <option value="<?php echo $cl->id ?>" data-pcode="<?php echo $cl->phone_code ?>" <?php echo $selected ?>><?php echo $cl->name ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div id="invalid_us_country" class="text-danger invalid-tooltip">
                                        Country is not null.
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group pos-rel">
                                    <label>State/Province</label>
                                    <img src="<?php echo base_url() ?>/img/loading.gif" id="load-address_state" style="display:none;">
                                    <select id="<?= $key ?>us_state" class="form-control select2 us-address-state" name="us_state" style="width:100%" data-old="<?php echo $value['us_state']; ?>">
                                        <option value="">-- Select State/Province --</option>
                                        <?php
                                        $us_states = get_all_db('am_state', ['country_id' => $value['us_country']], [], '', '', [], ['field' => 'name', 'order' => 'ASC']);
                                        if ($us_states) {
                                            foreach ($us_states as $st) {
                                                $selected = '';
                                                if ($value['us_state'] == $st->id) {
                                                    $selected = 'selected="selected"';
                                                }
                                        ?>
                                                <option value="<?php echo $st->id ?>" <?php echo $selected ?>><?php echo $st->name ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <img id="load-us_state" src="<?php echo base_url() ?>/img/loading.gif" class="load-spinner">
                                    <div id="invalid_us_state" class="text-danger invalid-tooltip">
                                        State/Province is not null.
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group pos-rel">
                                    <label>City</label>
                                    <img src="<?php echo base_url() ?>/img/loading.gif" id="load-address_city" style="display:none;">
                                    <select id="us_city" class="form-control select2 us-address-city" name="us_city" style="width:100%" data-old="<?php echo $value['us_city']; ?>">
                                        <option value="">-- Select City --</option>
                                        <?php
                                        $us_cities = get_all_db('am_city', ['state_id' => $value['us_state']], [], '', '', [], ['field' => 'name', 'order' => 'ASC']);
                                        if ($us_cities) {
                                            foreach ($us_cities as $ct) {
                                                $selected = '';
                                                if ($value['us_city'] == $ct->id) {
                                                    $selected = 'selected="selected"';
                                                }
                                        ?>
                                                <option value="<?php echo $ct->id ?>" <?php echo $selected ?>><?php echo $ct->name ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <img id="load-us_city" src="<?php echo base_url() ?>/img/loading.gif" class="load-spinner">
                                    <div id="invalid_us_city" class="text-danger invalid-tooltip">
                                        City is not null.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Street</label>
                                    <input type="text" class="form-control" id="us_street" name="us_street" value="<?php echo $value['us_street'] ?>" placeholder="Street" data-old="<?php echo $value['us_street']; ?>">
                                    <div id="invalid_us_street" class="text-danger invalid-tooltip">
                                        Street is not null.
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Postal Code</label>
                                    <input type="text" class="form-control input_number" name="us_zipcode" id="us_zipcode" value="<?php echo $value['us_zipcode'] ?>" placeholder="Postal Code" data-old="<?php echo $value['us_zipcode']; ?>">
                                    <div id="invalid_us_zipcode" class="text-danger invalid-tooltip">
                                        Postal Code is not null.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>US Phone Number</label>
                                    <input type="text" class="form-control input_number" name="us_phone_number" id="us_phone_number" value="<?php echo $value['us_phone_number'] ?>" placeholder="US Phone Number" data-old="<?php echo $value['us_phone_number']; ?>">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>University Email</label>
                                    <input type="email" class="form-control" name="university_email" id="university_email" value="<?php echo $value['university_email'] ?>" placeholder="University Email" data-old="<?php echo $value['university_email']; ?>">
                                </div>
                            </div>
                        </div>

                    </div>
                    <hr />
                <?php } ?>
            </div>
        </div>
    </div>
</div>