
        <div class="panel panel-default">
            <div class="panel-body">
                <?php echo form_open('', array('id' => 'form', 'method' => 'POST', 'enctype' => 'multipart/form-data')); ?>
                    <?php if(isset($is_admin)) : ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Reviewer</label>
                                <select name="panelis_id" id="panelis_id" class="form-control selectpicker" data-live-search="true">
                                    <option value="">Select Reviewer</option>
                                    <?php foreach($panelists as $panelist) : ?>
                                        <option value="<?= $panelist->id ?>" <?= (isset($panelis_id) && $panelis_id == $panelist->id) ? 'selected' : '' ?>>
                                            <?= $panelist->name ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="hidden" class="form-control" name="id" value="<?php echo (isset($id) ? $id : '') ?>">
                                <input required class="form-control" placeholder="Email" name="email" type="email" value="<?php echo (isset($email) ? $email : '') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Institution Name</label>
                                <input required class="form-control" placeholder="Institution Name" name="institution_name" type="text" value="<?php echo (isset($institution_name) ? $institution_name : '') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input required class="form-control" placeholder="Phone Number" name="phone_number" type="text" value="<?php echo (isset($phone_number) ? $phone_number : '') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Faculty/Department</label>
                                <input class="form-control" placeholder="Faculty/Department" name="department" type="text" value="<?php echo (isset($department) ? $department : '') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Address</label>
                                <textarea required class="form-control" placeholder="Address" name="address" rows="3"><?php echo (isset($address) ? $address : '') ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Proposal</label>
                                <input type="file" class="form-control" name="proposal">
                                <?php if (isset($proposal) && $proposal): ?>
                                    <a href="<?= base_url($proposal) ?>" class="btn btn-info mt-2 btn-sm lightbox">
                                        <i class="fa fa-file fa-fw"></i> View
                                    </a>
                                    <a href="javascript:;" onclick="delete_proposal(this)" data-id="<?= $id ?>" class="btn btn-danger mt-2 btn-sm" style="color:#fff">
                                        <i class="fa fa-trash fa-fw text-white"></i>
                                    </a>
                                <?php endif; ?>
                                <a href="<?= base_url('uploads/Host-Institution-Project-Proposal-Form_2026.docx') ?>" download title="Click to Download" class="btn btn-primary mt-2 btn-sm" style="color:#fff">
                                    <i class="fa fa-download fa-fw text-white"></i> Downloads Template Proposal
                                </a>
                            </div>
                        </div>
                    </div>

                    <?php if(isset($is_admin)) : ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="reviewred" <?php echo (isset($status) && $status == 'reviewred') ? 'selected' : '' ?>>Reviewred</option>
                                    <option value="revise" <?php echo (isset($status) && $status == 'revise') ? 'selected' : '' ?>>Revise</option>
                                    <option value="selected" <?php echo (isset($status) && $status == 'selected') ? 'selected' : '' ?>>Selected</option>
                                    <option value="not_selected" <?php echo (isset($status) && $status == 'not_selected') ? 'selected' : '' ?>>Not Selected</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="contact_person_section">
                        <?php
                        $contact_person = isset($contact_person) && is_array($contact_person) ? $contact_person : (object)[
                            [
                                'id' => '',
                                'name' => '',
                                'email' => '',
                                'phone_number' => ''
                            ]
                        ];
                        ?>

                        <div class="row">
                            <div class="col-md-12 my-3">
                                <p style="font-weight:bold;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> Contact Person</p>
                            </div>
                        </div>
                        <?php foreach ($contact_person as $i => $cp): ?>
                        <div class="contact-person">
                            <div class="row">
                                <?php if($cp->id != '') { ?>
                                <div class="col-md-12">
                                    <input type="text" name="contact_person[<?= $i ?>][id]" value="<?= $cp->id ?>" hidden>
                                    <a href="javascript:;" onclick="delete_contact_person(this)" data-id="<?= $cp->id ?>" class="btn btn-danger  pull-right" style="margin-bottom:10px;">
                                        <i class="fa fa-trash fa-fw"></i>
                                    </a>
                                </div>
                                <?php } ?>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input required class="form-control"
                                            placeholder="Name"
                                            name="contact_person[<?= $i ?>][name]"
                                            type="text"
                                            value="<?= $cp->name ?>">
                                    </div>
                                </div>
    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input required class="form-control"
                                            placeholder="Email"
                                            name="contact_person[<?= $i ?>][email]"
                                            type="email"
                                            value="<?= $cp->email ?>">
                                    </div>
                                </div>
    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <input required class="form-control"
                                            placeholder="Phone Number"
                                            name="contact_person[<?= $i ?>][phone_number]"
                                            type="text"
                                            value="<?= $cp->phone_number ?>">
                                    </div>
                                </div>
                            </div>
                            <hr />
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <a href="javascript:;" onclick="add_contact_person(this)" class="btn btn-primary">
                                <i class="fa fa-plus fa-fw"></i> Add Contact Person
                            </a>
                            <img src="<?php echo base_url() ?>/img/loading.gif" class="add-load-label" style="display:none;">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button type="submit" id="btn-submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>