<!-- -------------- SECTION TOEFL ITF ------------ -->
<?php if ($grantee_grant->show_toefl_itp_section && ($show_itp || $is_admin)){ ?>
<div id="toefl_itp" class="tab-pane fade">
<div class="panel panel-default">
<?php if(has_permission('nominee', 'test_section_data') || $is_admin) { ?>
<div class="panel-body">
<div class="row form-group pull-right">
    <div class="col-lg-6">
        <button type="button" class="btn btn-primary btn-for-add" onclick="add_section('toeflitp')"><i class="fa fa-plus fa-fw"></i> Add New</button>
        <img src="<?php echo base_url() ?>/img/loading.gif" class="add-load-toeflitp" style="display:none;">
    </div>
</div>
</div>
<?php } ?>
<div id="wrap-toeflitp">
<?php if($data_toefl_itp_section) : ?>
    <?php foreach($data_toefl_itp_section as $ktfip => $toefl_itp_section) : ?>
    <?php
        $del_btn = ''; 
        if($ktfip > 0) : 
        $del_btn = '
        <img src="'.base_url('/img/loading.gif').'" class="delete-load-toefl" style="display:none;position:absolute; top:35px; right:75px;">
        <a href="javascript:;" onclick="del_item(this, \'toeflitp-item\','.$toefl_itp_section->id.', \'toeflitp\')" class="btn btn-danger btn-delete-nominee" style="position:absolute; top:-40px; right:15px;color: #fff;"><i class="fa fa-trash fa-fw"></i></a>';
    ?>
        <hr>
    <?php endif; ?>
    <input 
        type="hidden" 
        value="<?= $toefl_itp_section->id ?>" 
        name="toefl_itp_section[<?= $ktfip ?>][toefl_itp_selection_id]"
    >
    <div id="toeflitp-item-<?= $ktfip ?>" class="toeflitp-item" style="position:relative;<?= ($ktfip > 0) && $is_admin ? 'margin-top:50px;' : '' ?>">
        <?php if($ktfip == 0 && $grantee_grant->guideline_itp_test) { ?>
        <a href="<?= base_url($grantee_grant->guideline_itp_test) ?>" download title="Click to Download" class="btn btn-primary mb-5 <?= $grantee_grant->guideline_itp_test ? '' : 'hide' ?>" style="color:#fff">
            <i class="fa fa-download fa-fw text-white"></i> Download Guideline for Test
        </a>
        <?php } ?>
        <!-- <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> Toefl ITP <?= $toefl_itp_section->test_date ? 'test on ' . date('F j, Y', strtotime($toefl_itp_section->test_date)) : '' ?></p> -->
        <div class="panel-group" id="accordionItpParent<?= $ktfip ?>" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
            <?php echo $del_btn ?>
                <a role="button" data-toggle="collapse" data-parent="#accordionItpParent<?= $ktfip ?>" href="#collapseItpTestParent<?= $ktfip ?>" aria-expanded="true" aria-controls="collapseItpTestParent<?= $ktfip ?>">
                    <div class="panel-heading panel-heading-test-section text-left" role="tab" id="ItpTestParent">
                        <h4 class="panel-title panel-title-parent">
                            TOEFL ITP <?= $toefl_itp_section->test_date ? 'test on ' . date('F j, Y', strtotime($toefl_itp_section->test_date)) : '' ?>
                        </h4>
                    </div>
                </a>
                <div id="collapseItpTestParent<?= $ktfip ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="ItpTestParent">
                    <div class="panel-group p-4" id="accordionItp<?= $ktfip ?>" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <a role="button" data-toggle="collapse" data-parent="#accordionItp<?= $ktfip ?>" href="#collapseItpTest<?= $ktfip ?>" aria-expanded="true" aria-controls="collapseItpTest<?= $ktfip ?>">
                                <div class="panel-heading panel-heading-test-section text-left" role="tab" id="ItpTest">
                                    <h4 class="panel-title">
                                        Test Information
                                    </h4>
                                </div>
                            </a>
                            <div id="collapseItpTest<?= $ktfip ?>" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'before_visa' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="ItpTest">
                                <div class="panel-body">
                                    <?php if(has_permission('nominee', 'test_section_data') || $is_grantee) { ?>
                                        <div class="row form-group">
                                            <div class="col-lg-3">
                                                <label>Test Date</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input 
                                                    type="text" 
                                                    class="form-control datepicker" readonly style="background-color:#fff" 
                                                    name="toefl_itp_section[<?= $ktfip ?>][test_date]" 
                                                    value="<?= $toefl_itp_section->test_date ? date('d M Y', strtotime($toefl_itp_section->test_date)) : '' ?>"
                                                >
                                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary <?= $is_admin ? '' : 'hide' ?>" style="color:#000;position:absolute;top:0px;right:20px;">X</a>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-3">
                                                <label>Test Center</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input 
                                                    type="text" 
                                                    class="form-control" 
                                                    name="toefl_itp_section[<?= $ktfip ?>][test_center]" 
                                                    value="<?= $toefl_itp_section->test_center ?>"
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
                                                            <?= $toefl_itp_section->format == 'home_edition' ? 'checked' : ''?>
                                                            name="toefl_itp_section[<?= $ktfip ?>][format]" 
                                                            value="home_edition">
                                                            Home Edition
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" 
                                                            class="radio-nominee" 
                                                            <?= $toefl_itp_section->format == 'in-person' ? 'checked' : ''?>
                                                            name="toefl_itp_section[<?= $ktfip ?>][format]" 
                                                            value="in-person">
                                                            In-Person 
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-3">
                                                <label>Listening Comprehension</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input 
                                                    type="text" 
                                                    class="form-control" 
                                                    name="toefl_itp_section[<?= $ktfip ?>][listening_comprehension]" 
                                                    value="<?= format_decimal($toefl_itp_section->listening_comprehension) ?>"
                                                >
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-3">
                                                <label>Structure & Written Expression</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input 
                                                    type="text" 
                                                    class="form-control" 
                                                    name="toefl_itp_section[<?= $ktfip ?>][structure_written]" 
                                                    value="<?= format_decimal($toefl_itp_section->structure_written) ?>"
                                                >
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-3">
                                                <label>Reading Comprehension</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input 
                                                    type="text" 
                                                    class="form-control" 
                                                    name="toefl_itp_section[<?= $ktfip ?>][reading_comprehension]" 
                                                    value="<?= format_decimal($toefl_itp_section->reading_comprehension) ?>"
                                                >
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-3">
                                                <label>Total Score</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input 
                                                    type="text" 
                                                    class="form-control" 
                                                    name="toefl_itp_section[<?= $ktfip ?>][total_score]" 
                                                    value="<?= format_decimal($toefl_itp_section->total_score) ?>"
                                                >
                                            </div>
                                        </div>
                                        <div class="row form-group  <?= ($grantee_grant->is_final_placement || $submission_plan) ? '' : 'file-for-testing' ?>">
                                            <div class="col-lg-3">
                                                <label>Upload Score Report</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <?php if($toefl_itp_section->score_report) : ?>
                                                    <a 
                                                        href="<?= base_url($toefl_itp_section->score_report) ?>" 
                                                        class="btn btn-success lightbox"
                                                        style="color:#fff">
                                                        View
                                                    </a>
                                                    <?php if(!$is_grantee) { ?>
                                                    <a href=<?= $url_delete.'/toeflitp_section/'.$grantee_grant->id.'/'.$toefl_itp_section->id ?> onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger" style="margin-bottom:3px;color:#fff">Delete</a>
                                                    <?php } ?>
                                                <?php endif; ?>
                                                <input 
                                                    type="file" 
                                                    class="form-control file-for-testing" 
                                                    name="score_report_toefl_itp_section_<?= $ktfip ?>" 
                                                >
                                            </div>
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
    <?php endforeach; ?>
<?php else : ?>
    <div id="toeflitp-item-0" class="toeflitp-item" style="position:relative">
        <a href="<?= base_url($grantee_grant->guideline_itp_test) ?>" download title="Click to Download" class="btn btn-primary mb-5 <?= $grantee_grant->guideline_itp_test ? '' : 'hide' ?>" style="color:#fff">
            <i class="fa fa-download fa-fw text-white"></i> Download Guideline for Test
        </a>
        <!-- <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle" style="color:#4da6ff;margin-right:5px;"></i> Toefl ITP</p> -->
        <div class="panel-group" id="accordionItpParent" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <a role="button" data-toggle="collapse" data-parent="#accordionItpParent" href="#collapseItpTestParent" aria-expanded="true" aria-controls="collapseItpTestParent">
                    <div class="panel-heading panel-heading-test-section text-left" role="tab" id="ItpTestParent">
                        <h4 class="panel-title panel-title-parent">
                            TOEFL ITP <?= $toefl_itp_section->test_date ? 'test on ' . date('F j, Y', strtotime($toefl_itp_section->test_date)) : '' ?>
                        </h4>
                    </div>
                </a>
                <div id="collapseItpTestParent" class="panel-collapse collapse" role="tabpanel" aria-labelledby="ItpTestParent">
                    <div class="panel-group p-4" id="accordionItp" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <a role="button" data-toggle="collapse" data-parent="#accordionItp" href="#collapseItpTest" aria-expanded="true" aria-controls="collapseItpTest">
                                <div class="panel-heading panel-heading-test-section text-left" role="tab" id="ItpTest">
                                    <h4 class="panel-title">
                                        Test Information
                                    </h4>
                                </div>
                            </a>
                            <div id="collapseItpTest" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'before_visa' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="ItpTest">
                                <div class="panel-body">
                                    <?php if(has_permission('nominee', 'test_section_data') || $is_grantee) { ?>
                                    <div class="panel-body">
                                        <div class="row form-group">
                                            <div class="col-lg-3">
                                                <label>Test Date</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control datepicker" readonly style="background-color:#fff" name="toefl_itp_section[0][test_date]" value="">
                                                <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="color:#000;position:absolute;top:0px;right:20px;">X</a>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-3">
                                                <label>Test Center</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" name="toefl_itp_section[0][test_center]" value="">
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
                                                            name="toefl_itp_section[0][format]" 
                                                            value="home_edition">
                                                            Home Edition
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" 
                                                            class="radio-nominee" 
                                                            name="toefl_itp_section[0][format]" 
                                                            value="in-person">
                                                            In-Person 
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-3">
                                                <label>Listening Comprehension</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input 
                                                    type="text" 
                                                    class="form-control" 
                                                    name="toefl_itp_section[0][listening_comprehension]" 
                                                >
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-3">
                                                <label>Structure & Written Expression</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input 
                                                    type="text" 
                                                    class="form-control" 
                                                    name="toefl_itp_section[0][structure_written]" 
                                                >
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-3">
                                                <label>Reading Comprehension</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input 
                                                    type="text" 
                                                    class="form-control" 
                                                    name="toefl_itp_section[0][reading_comprehension]" 
                                                >
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-3">
                                                <label>Total Score</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input type="text" name="toefl_itp_section[0][total_score]" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-lg-3">
                                                <label>Upload Score Report</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input type="file" class="form-control file-for-testing" name="score_report_toefl_itp_section_0" value="">
                                                <small class="file-for-testing">File Size Max 5MB</small>
                                            </div>
                                        </div>
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
<?php if($is_admin) { ?>
<div class="panel-body pull-right">
<button type="submit" class="btn btn-success" name="btn" value="save-test-section-itp">Save</button>
</div>
<?php } ?>
</div>
</div>
<?php } ?>
<!-- ------------- END SECTION TOEFL ITF -------------- -->