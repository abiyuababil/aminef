<style>
    .panel-default .panel-heading{
        background-color: rgb(236 240 244);
        color: #000;
        /* border-radius: 8px;
        border-top-left-radius: 8px !important;
        border-top-right-radius: 8px !important; */
        padding: 20px;
    }

    .panel-collapse{
        border: 1px solid rgb(236 240 244);
    }

    #memo_revision th {
		padding-top: 10px;
		padding-bottom: 10px;
		text-align: left;
		background-color: #ebebeb;
		color: #7da2bd;
    }

	#memo_revision td {
		border: 0px !important;
	}
	.mytooltip {
		display: inline;
		position: relative;
		z-index: 999
	}
	.mytooltip .tooltip-item {
		background: #337ab7;
		cursor: pointer;
		display: inline-block;	
		padding: 0 10px;
		color: #fff;
		border-radius: 5px;
	}
	.mytooltip .tooltip-content {
		position: absolute;
		z-index: 9999;
		width: 360px;
		left: 70px;
		margin: 0 0 20px -180px;
		bottom: 100%;
		text-align: left;
		font-size: 14px;
		line-height: 30px;
		-webkit-box-shadow: -5px -5px 15px rgba(48, 54, 61, 0.2);
		box-shadow: -5px -5px 15px rgba(48, 54, 61, 0.2);
		background: #2b2b2b;
		opacity: 0;
		cursor: default;
		pointer-events: none
	}
	.mytooltip .tooltip-content::after {
		content: '';
		top: 100%;
		left: 34%;
		border: solid transparent;
		height: 0;
		width: 0;
		position: absolute;
		pointer-events: none;
		border-color: #2a3035 transparent transparent;
		border-width: 10px;
		margin-left: -10px
	}
	.mytooltip .tooltip-content img {
		position: relative;
		height: 170px;
		display: block;
		float: left;
		margin-right: 1em
	}
	.mytooltip .tooltip-item::after {
		content: '';
		position: absolute;
		width: 360px;
		height: 20px;
		bottom: 100%;
		left: 50%;
		pointer-events: none;
		-webkit-transform: translateX(-50%);
		transform: translateX(-50%)
	}
	.mytooltip:hover .tooltip-item::after {
		pointer-events: auto
	}
	.mytooltip:hover .tooltip-content {
		pointer-events: auto;
		opacity: 1;
		-webkit-transform: translate3d(0, 0, 0) rotate3d(0, 0, 0, 0deg);
		transform: translate3d(0, 0, 0) rotate3d(0, 0, 0, 0deg)
	}
	.mytooltip:hover .tooltip-content2 {
		opacity: 1;
		font-size: 18px
	}
	.mytooltip .tooltip-text {
		font-size: 14px;
		line-height: 24px;
		display: block;
		padding: 1.31em 1.21em 1.21em 0;
		color: #fff
	}
    .section_save {
        position: fixed;
        z-index: 26;
        background: #fff;
        bottom: 0;
        right: 0;
        width: 86%;
        padding: 10px 15px;
    }
</style>
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?= $title ?></h1>
	</div>
	<!-- /.col-lg-12 -->
</div>

<?php if($this->session->flashdata('success')) { ?>
	<div class="row">
		<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<?= $this->session->flashdata('success') ?>
            <?php $this->session->unset_userdata('success'); ?>
		</div>
	</div>

<?php } ?>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12" style="margin-bottom:65px;">
		<form role="form" method="POST" id="form-grand" enctype="multipart/form-data">
			<?php //if (is_admin_all()) : 
			?>
			<div class="form-group">
				<label>Alumni Grant</label>
				<select id="alumni_grant" class="form-control select2" name="alumni_grant" style="width:100%">
					<option value="">-- Select Grants --</option>
					<?php
					if ($alumni_grant) {
						foreach ($alumni_grant as $ag) {
							$selected = '';
							if ($this->User_grantee_grant_model->alumni_grant == $ag->id) {
								$selected = 'selected="selected"';
							}
					?>
							<option value="<?= $ag->id ?>" data-pcode="<?= $ag->phone_code ?>" data-category="<?= $ag->category_grant ?>" <?= $selected ?>><?= $ag->name ?></option>
					<?php
						}
					}
					?>
				</select>
			</div>
			<?php //endif; 
			?>
			<?php if (get_active_country(true) == AMERICAN_DATABASE) : ?>
			<div class="form-group">
				<label> Category Type</label>
				<select name="category_grant" id="category_grant" class="form-control">
					<option value="">-- Select Category Type --</option>
					<?php
					if ($category_grant) {
						foreach ($category_grant as $i => $cg) {
							$selected = '';
							if (isset($this->User_grantee_grant_model->category_grant) && $this->User_grantee_grant_model->category_grant == $i)
								$selected = 'selected="selected"';
					?>
							<option value="<?= $i ?>" <?= $selected ?>><?= $cg ?></option>
					<?php
						}
					}
					?>
				</select>
			</div>
			<?php endif; ?>
			<div class="form-group">
				<label> Grant Name</label>
				<input class="form-control" name="name" value="<?= (isset($this->User_grantee_grant_model->name)) ? $this->User_grantee_grant_model->name : '' ?>" placeholder="eg: Fullbright Master">
			</div>
			<div class="form-group">
				<label> Email</label>
				<input class="form-control" name="email" value="<?= (isset($this->User_grantee_grant_model->email)) ? $this->User_grantee_grant_model->email : '' ?>" placeholder="Email">
				<small class="text-danger">for multiple email, separate email by semi colon (;)</small>
			</div>

			<?php if (get_active_country(true) == INDONESIAN_DATABASE) : ?>
				<div class="row">
					<div class="col-lg-12">
						<div class="form-group">
							<div class="form-check required">
								<input type="checkbox" name="voucher_duolingo" class="form-check-input field-alumni" id="voucher_duolingo" value="1" style="cursor:pointer;" <?= $this->User_grantee_grant_model->voucher_duolingo ? 'checked' : '' ?>>
								<label class="form-check-label font-weight-normal d-inline" for="voucher_duolingo" style="cursor:pointer;">Voucher Duolingo</label>
							</div>
						</div>
					</div>
					
					<div class="form-group col-lg-4">
						<label> Image Logo </label>
						<input type="file" name="image">
						<small class="file-for-testing">File Size Max 5MB</small>
						<?php if($this->User_grantee_grant_model->image != '') : ?>
						<br />
						<a href="<?= base_url($this->User_grantee_grant_model->image) ?>" class="lightbox" aria-haspopup="dialog">
							<img src="<?= base_url($this->User_grantee_grant_model->image)?>" alt="<?php echo $this->User_grantee_grant_model->image; ?>" title="<?php echo $this->User_grantee_grant_model->image; ?>" width="100">
						</a>
						<a href="<?= base_url('admin/user_grantee_grant/delete_file/image/'.$this->User_grantee_grant_model->id) ?>" onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger btn-xs" style="position:absolute;">
							<i class="fa fa-trash fa-fw"></i>
						</a>
						<a href="<?= base_url() ?><?= $this->User_grantee_grant_model->image ?>" download title="Click to Download" class="btn btn-primary btn-xs mt-5" style="position:absolute;">
							<i class="fa fa-download fa-fw"></i>
						</a>
						<?php endif; ?>
					</div>
					<div class="form-group col-lg-4">
						<label>Guide </label>
						<input type="file" name="guide">
						<small class="file-for-testing">File Size Max 5MB</small>
						<?php if($this->User_grantee_grant_model->guide != '') : ?>
						<br />
						<a href="<?= base_url($this->User_grantee_grant_model->guide) ?>" class="lightbox" aria-haspopup="dialog">
							<img src="<?= get_preview($this->User_grantee_grant_model->guide)?>" width="100" alt="<?php echo $this->User_grantee_grant_model->guide; ?>" title="<?php echo $this->User_grantee_grant_model->guide; ?>">
						</a>
						<a href="<?= base_url('admin/user_grantee_grant/delete_file/guide/'.$this->User_grantee_grant_model->id) ?>" onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger btn-xs" style="position:absolute;">
							<i class="fa fa-trash fa-fw"></i>
						</a>
						<a href="<?= base_url() ?><?= $this->User_grantee_grant_model->guide ?>" download title="Click to Download" class="btn btn-primary btn-xs mt-5" style="position:absolute;">
							<i class="fa fa-download fa-fw"></i>
						</a>
						<?php endif; ?>
					</div>
					<div class="form-group col-lg-4">
						<label>Form </label>
						<input type="file" name="form_ofline">
						<small class="file-for-testing">File Size Max 5MB</small>
						<?php if($this->User_grantee_grant_model->form_ofline != '') : ?>
						<br />
						<a href="<?= base_url($this->User_grantee_grant_model->form_ofline) ?>" class="lightbox" aria-haspopup="dialog">
							<img src="<?= get_preview($this->User_grantee_grant_model->form_ofline)?>" alt="<?php echo $this->User_grantee_grant_model->form_ofline; ?>" title="<?php echo $this->User_grantee_grant_model->form_ofline; ?>" width="100">
						</a>
						<a href="<?= base_url('admin/user_grantee_grant/delete_file/form_ofline/'.$this->User_grantee_grant_model->id) ?>" onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-danger btn-xs" style="position:absolute;">
							<i class="fa fa-trash fa-fw"></i>
						</a>
						<a href="<?= base_url() ?><?= $this->User_grantee_grant_model->form_ofline ?>" download title="Click to Download" class="btn btn-primary btn-xs mt-5" style="position:absolute;">
							<i class="fa fa-download fa-fw"></i>
						</a>
						<?php endif; ?>
					</div>
				</div>

				<div class="panel-group" id="accordionOne" role="tablist" aria-multiselectable="true">
					<div class="panel panel-default">
						<a role="button" data-toggle="collapse" data-parent="#accordionOne" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
							<div class="panel-heading panel-heading-departure text-left" role="tab" id="submission_result">
								<h4 class="panel-title">
									Application
								</h4>
							</div>
						</a>
						<div id="collapseTwo" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'general' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">
								<div class="form-group ">
									<label> Activity </label>
									<textarea name="activity" cols="30" rows="10" class="form-control editor"><?= $this->User_grantee_grant_model->activity ?></textarea>
								</div>
								<div class="form-group">
									<label> Grant Length </label>
									<textarea name="grant_length" cols="30" rows="10" class="form-control editor"><?= $this->User_grantee_grant_model->grant_length ?></textarea>
								</div>
								<div class="form-group">
									<label> Specific Requirement </label>
									<textarea name="spesific_requirement" cols="30" rows="10" class="form-control editor"><?= $this->User_grantee_grant_model->spesific_requirement ?></textarea>
								</div>
								<div class="form-group">
									<label> General Requirement </label>
									<textarea name="general_requirement" cols="30" rows="10" class="form-control editor"><?= $this->User_grantee_grant_model->general_requirement ?></textarea>
								</div>
								<div class="form-group">
									<label> Submission Requirement </label>
									<textarea name="submission_requirement" cols="30" rows="10" class="form-control editor"><?= $this->User_grantee_grant_model->submission_requirement ?></textarea>
								</div>
								<div class="form-group">
									<label> Field of Study </label>
									<textarea name="field_of_study" cols="30" rows="10" class="form-control editor"><?= $this->User_grantee_grant_model->field_of_study ?></textarea>
								</div>
								<div class="form-group">
									<label> Deadline </label>
									<textarea name="deadline_note" cols="30" rows="10" class="form-control editor"><?= $this->User_grantee_grant_model->deadline_note ?></textarea>
								</div>
								<div class="form-group">
									<label> How to Apply </label>
									<textarea name="how_to_apply" cols="30" rows="10" class="form-control editor"><?= $this->User_grantee_grant_model->how_to_apply ?></textarea>
								</div>
								<div class="form-group">
									<label> AMINEF </label>
									<textarea name="aminef" cols="30" rows="10" class="form-control editor"><?= $this->User_grantee_grant_model->aminef ?></textarea>
								</div>
								<div class="form-group">
									<label> Support </label>
									<textarea name="contact_information" cols="30" rows="10" class="form-control editor"><?= $this->User_grantee_grant_model->contact_information ?></textarea>
								</div>
								<div class="form-group mb-4 mt-2">
									<label>Test Type</label>
									<div class="alert alert-info mb-1">The Test Type will only appear based on the selection; if you do not choose one from the list below, it will display all data from <a href="<?php echo site_url('admin/test_types/manage'); ?>" class="btn-link" style="text-decoration: underline;"> Master Test Type </a></div>
									<?php foreach($test_types as $test_type) { ?>
										<div>
											<label for="test-type-<?php echo $test_type['id']; ?>">
												<input id="test-type-<?php echo $test_type['id']; ?>" name="test_types[]" type="checkbox" value="<?php echo $test_type['id']; ?>" <?php echo $test_type['checked'] ? 'checked' : ''; ?> /> <?php echo $test_type['name']; ?>
											</label>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<a role="button" data-toggle="collapse" data-parent="#accordionOne" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
							<div class="panel-heading panel-heading-departure text-left" role="tab" id="submission_result">
								<h4 class="panel-title">
									Selection
								</h4>
							</div>
						</a>
						<div id="collapseThree" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'selection' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">
								<div class="form-group">
									<label> 
										Section Nominee Menu
									</label>
									<div class="col-lg-12" style="left:-65px;">
										<div class="col-md-4">
											<?php 
												$section_nominee_menu = $this->User_grantee_grant_model->section_nominee_menu ? explode(',', $this->User_grantee_grant_model->section_nominee_menu) : [];
											?>
											<ul class="list-style-none">
												<li>
													<div class="form-check required">
														<input type="checkbox" name="section_nominee_menu[]" class="form-check-input field-alumni" id="field_validation" value="validation" style="cursor:pointer;" <?= in_array('validation', $section_nominee_menu) ? 'checked' : '' ?>>
														<label class="form-check-label font-weight-normal d-inline" for="field_validation" style="cursor:pointer;">Validation</label>
													</div>
												</li>
												<li>
													<div class="form-check required">
														<input type="checkbox" name="section_nominee_menu[]" class="form-check-input field-alumni" id="field_review" value="review" style="cursor:pointer;" <?= in_array('review', $section_nominee_menu) ? 'checked' : '' ?>>
														<label class="form-check-label font-weight-normal d-inline" for="field_review" style="cursor:pointer;">Selection Review</label>
													</div>
												</li>
												<li>
													<div class="form-check required">
														<input type="checkbox" name="section_nominee_menu[]" class="form-check-input field-alumni" id="field_interview" value="interview" style="cursor:pointer;" <?= in_array('interview', $section_nominee_menu) ? 'checked' : '' ?>>
														<label class="form-check-label font-weight-normal d-inline" for="field_interview" style="cursor:pointer;">Interview Selection</label>
													</div>
												</li>
											</ul>
										</div>
									</div>
								</div>

								<?php 
									if(!empty($this->User_grantee_grant_model->nominee_menu) && is_string($this->User_grantee_grant_model->nominee_menu)){
										$check_data_menu = explode(",", $this->User_grantee_grant_model->nominee_menu);
									}
								?>
								<div class="form-group">
									<label> 
										Field AMINEF T&C
									</label>
									<div class="col-lg-12" style="left:-65px;">
										<div class="col-md-4">
											<?php 
												$field_tnc = $this->User_grantee_grant_model->field_tnc ? explode(',', $this->User_grantee_grant_model->field_tnc) : [];
											?>
											<ul class="list-style-none">
												<li>
													<div class="form-check required">
													<input type="checkbox" name="nominee_menu[]" class="form-check-input field-alumni" id="field_alumni_checktnc" value="tnc" <?= ($check_data_menu && in_array('tnc', $check_data_menu))  ? 'checked' : (is_array($this->User_grantee_grant_model->nominee_menu) ? 'checked' : '') ?> style="cursor:pointer;">
													<label class="form-check-label font-weight-normal d-inline" for="field_alumni_checktnc" style="cursor:pointer;">Menu Aminef T&C</label>
													</div>
												</li>
												<li>
													<div class="form-check required">
														<input type="checkbox" name="field_tnc[]" class="form-check-input field-alumni" id="field_upload_tnc" value="upload_tnc" style="cursor:pointer;" <?= in_array('upload_tnc', $field_tnc) ? 'checked' : '' ?>>
														<label class="form-check-label font-weight-normal d-inline" for="field_upload_tnc" style="cursor:pointer;">Upload AMINEF T&C</label>
													</div>
												</li>
												<li>
													<div class="form-check required">
														<input type="checkbox" name="field_tnc[]" class="form-check-input field-alumni" id="field_consent_letter" value="upload_consent_letter" style="cursor:pointer;" <?= in_array('upload_consent_letter', $field_tnc) ? 'checked' : '' ?>>
														<label class="form-check-label font-weight-normal d-inline" for="field_consent_letter" style="cursor:pointer;">Upload AMINEF Consent Letter</label>
													</div>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<a role="button" data-toggle="collapse" data-parent="#accordionOne" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
							<div class="panel-heading panel-heading-departure text-left" role="tab" id="submission_result">
								<h4 class="panel-title">
									Nominee
								</h4>
							</div>
						</a>
						<div id="collapseFour" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'nominee' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">
								<div class="form-group">
									<label> 
										Nominee Menu 
										<span class="mytooltip tooltip-effect-1">
											<span class="tooltip-item">i</span>
											<span class="tooltip-content clearfix">
												<img src="<?= base_url('assets/images/icons/nominee_menu.png') ?>">
												<span class="tooltip-text">This field is to customize the Nominee’s Section. Please choose any necessary section.</span>
											</span>	
										</span>
									</label>
									<div class="col-lg-12" style="left:-65px;">
										<?php
											if (is_array($this->User_grantee_grant_model->nominee_menu))
												$check_data_menu = $this->User_grantee_grant_model->nominee_menu;
											if (is_null($this->User_grantee_grant_model->nominee_menu))
												$check_data_menu = array();
											foreach (array_split($nominee_menu_master, 2) as $key_a_f => $a_f): 
										?>
										<div class="col-md-4">
											<ul class="list-style-none">
											<?php 
												foreach ($a_f as $key => $value): 
												if($value['label'] == 'EEC' || $value['label'] == 'FSB' || $value['label'] == 'AMINEF T&C') {
													continue;
												}
											?>
												<li>
													<div class="form-check required">
													<input type="checkbox" name="nominee_menu[]" class="form-check-input field-alumni" id="field_alumni_check<?=$key?>" value="<?= $key ?>" <?= ($check_data_menu && in_array($key, $check_data_menu))  ? 'checked' : (is_array($this->User_grantee_grant_model->nominee_menu) ? 'checked' : 'tt') ?> style="cursor:pointer;">
													<label class="form-check-label font-weight-normal d-inline" for="field_alumni_check<?=$key?>" style="cursor:pointer;"><?=$value['label']?></label>
													</div>
												</li>
											<?php endforeach ?>
											</ul>
										</div>
										<?php endforeach; ?>
									</div>
									<!-- <select name="nominee_menu[]" id="nominee_menu" class="form-control select2" multiple='multiple' style="width:100%">
										<?php foreach ($nominee_menu as $key => $value): ?>
											<?php $select = in_array($key, explode(",", $this->User_grantee_grant_model->nominee_menu))  ? 'selected' : ''; ?>
											<option value="<?= $key ?>" <?= $select ?>><?= $value['label'] ?></option>
										<?php endforeach; ?>
									</select> -->
								</div>
								<div class="form-group mb-4 mt-2">
									<label>Test Section</label>
									<div>
										<label for="test-type-toefl-show_toefl_section">
											<input id="test-section-show_toefl_section" name="show_toefl_section" value="1" type="checkbox" <?php echo $this->User_grantee_grant_model->show_toefl_section ? 'checked' : ''; ?>> TOEFL
										</label>
									</div>
									<div>
										<label for="test-type-toefl-show_gre_section">
											<input id="test-section-show_gre_section" name="show_gre_section" value="1" type="checkbox" <?php echo $this->User_grantee_grant_model->show_gre_section ? 'checked' : ''; ?>> GRE
										</label>
									</div>
									<div>
										<label for="test-type-toefl-show_gmat_section">
											<input id="test-section-show_gmat_section" name="show_gmat_section" value="1" type="checkbox" <?php echo $this->User_grantee_grant_model->show_gmat_section ? 'checked' : ''; ?>> GMAT
										</label>
									</div>
									<div>
										<label for="test-type-toefl-show_gre_subject_section">
											<input id="test-section-show_gre_subject_section" name="show_gre_subject_section" value="1" type="checkbox" <?php echo $this->User_grantee_grant_model->show_gre_subject_section ? 'checked' : ''; ?>> GRE Subject
										</label>
									</div>
									<div>
										<label for="test-type-toefl-show_duolingo_section">
											<input id="test-section-show_duolingo_section" name="show_duolingo_section" value="1" type="checkbox" <?php echo $this->User_grantee_grant_model->show_duolingo_section ? 'checked' : ''; ?>> DUOLINGO
										</label>
									</div>
									<div>
										<label for="test-type-toefl-show_toefl_itp_section">
											<input id="test-section-show_toefl_itp_section" name="show_toefl_itp_section" value="1" type="checkbox" <?php echo $this->User_grantee_grant_model->show_toefl_itp_section ? 'checked' : ''; ?>> TOEFL ITP
										</label>
									</div>
								</div>
								<div class="form-group mb-4 mt-2">
									<label>Mentoring Type</label>
									<?php foreach($mentoring_types as $mentoring_type) { ?>
										<div>
											<label for="mentoring-type-<?php echo $mentoring_type['id']; ?>">
												<input id="mentoring-type-<?php echo $mentoring_type['id']; ?>" name="mentoring_types[]" type="checkbox" value="<?php echo $mentoring_type['id']; ?>" <?php echo $mentoring_type['checked'] ? 'checked' : ''; ?> /> <?php echo $mentoring_type['name']; ?>
											</label>
										</div>
									<?php } ?>
									<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#mdl_add_mentoring"><i class="fa fa-plus fa-fw"></i> Add New Mentoring Type</button>
								</div>
								<div class="form-group">
									<label for="show_digital_grant_packet"> Show Digital Grant Package </label>
									<input type="checkbox" value="1" id="show_digital_grant_packet" name="show_digital_grant_packet" <?= $this->User_grantee_grant_model->show_digital_grant_packet == 1 ? "checked" : "" ?>>
								</div>
								<div class="form-group">
									<label for="show_study_information"> Show Study Information </label>
									<input type="checkbox" value="1" id="show_study_information" name="show_study_information" <?= $this->User_grantee_grant_model->show_study_information == 1 ? "checked" : "" ?>>
								</div>
								<div class="form-group">
									<label for="show_visa_renewal"> Show Visa Renewal </label>
									<input type="checkbox" value="1" id="show_visa_renewal" name="show_visa_renewal" <?= $this->User_grantee_grant_model->show_visa_renewal == 1 ? "checked" : "" ?>>
								</div>
								<div class="form-group">
									<label> Number of Grant</label>
									<input autocomplete="off" class="form-control" name="number_of_grant" id="number_of_grant" value="<?= $this->User_grantee_grant_model->number_of_grant ?>">
								</div>
								<div class="form-group">
									<label for="hide_fos_placement"> Hide Field of Study on Final Placement </label>
									<input type="checkbox" value="1" id="hide_fos_placement" name="hide_fos_placement" <?= $this->User_grantee_grant_model->hide_fos_placement == 1 ? "checked" : "" ?>>
								</div>
								<div class="form-group">
									<label for="field_of_study_input"> Field of Study Input </label>
									<input type="checkbox" value="1" id="field_of_study_input" name="field_of_study_input" <?= $this->User_grantee_grant_model->field_of_study_input == 1 ? "checked" : "" ?>>
								</div>
								<div class="form-group">
									<label for="required_date_grant_doc_placement"> Grant Document Final Placement: Start & end dates required</label>
									<input type="checkbox" value="1" id="required_date_grant_doc_placement" name="required_date_grant_doc_placement" <?= $this->User_grantee_grant_model->required_date_grant_doc_placement == 1 ? "checked" : "" ?>>
								</div>
								<div class="form-group">
									<label> Pre-Academic Program/Gateway Orientation</label>
									<input autocomplete="off" class="form-control" name="pre_academic" id="pre_academic" value="<?= $this->User_grantee_grant_model->pre_academic ?>">
									<input type="checkbox" value="1" autocomplete="off" name="pre_academic_visibility" id="pre_academic_visibility" <?= $this->User_grantee_grant_model->pre_academic_visibility == 1 ? "checked" : "" ?>>
									<label class="is_unlimited_label" for="pre_academic_visibility">Show</label>
								</div>
								<div class="form-group">
									<label> Final Placement Detail Label</label>
									<input autocomplete="off" class="form-control" name="final_placement_detail" id="final_placement_detail" value="<?= $this->User_grantee_grant_model->final_placement_detail ?>">
									<input type="checkbox" value="1" autocomplete="off" name="final_placement_detail_visibility" id="final_placement_detail_visibility" <?= $this->User_grantee_grant_model->final_placement_detail_visibility == 1 ? "checked" : "" ?>>
									<label class="is_unlimited_label" for="final_placement_detail_visibility">Show</label>
								</div>
								<div class="form-group">
									<label> University Corespondence Label</label>
									<input autocomplete="off" class="form-control" name="university_cores" id="university_cores" value="<?= $this->User_grantee_grant_model->university_cores ?>">
									<input type="checkbox" value="1" autocomplete="off" name="university_cores_visibility" id="university_cores_visibility" <?= $this->User_grantee_grant_model->university_cores_visibility == 1 ? "checked" : "" ?>>
									<label class="is_unlimited_label" for="university_cores_visibility">Show</label>
								</div>
								<div class="form-group">
									<label> ToA (Terms of Appoinment) Label</label>
									<input autocomplete="off" class="form-control" name="toa" id="toa" value="<?= $this->User_grantee_grant_model->toa ?>">
									<input type="checkbox" value="1" autocomplete="off" name="toa_visibility" id="toa_visibility" <?= $this->User_grantee_grant_model->toa_visibility == 1 ? "checked" : "" ?>>
									<label class="is_unlimited_label" for="toa_visibility">Show</label>
								</div>
								<div class="form-group">
									<label> Academic Program Label</label>
									<input autocomplete="off" class="form-control" name="academic_program" id="academic_program" value="<?= $this->User_grantee_grant_model->academic_program ?>">
									<input type="checkbox" value="1" autocomplete="off" name="academic_program_visibility" id="academic_program_visibility" <?= $this->User_grantee_grant_model->academic_program_visibility == 1 ? "checked" : "" ?>>
									<label class="is_unlimited_label" for="academic_program_visibility">Show</label>
								</div>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<a role="button" data-toggle="collapse" data-parent="#accordionOne" href="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
							<div class="panel-heading panel-heading-departure text-left" role="tab" id="submission_result">
								<h4 class="panel-title">
									Returning
								</h4>
							</div>
						</a>
						<div id="collapseFive" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'general' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">
								<div class="form-group">
									<label for="program_phd"> Show Participation Research Presentation (Returning) </label>
									<input type="checkbox" value="1" id="program_phd" name="program_phd" <?= $this->User_grantee_grant_model->program_phd == 1 ? "checked" : "" ?>>
								</div>
								<div class="form-group">
									<label> Label for "Have you completed you study?"</label>
									<input autocomplete="off" class="form-control" name="label_returning" id="label_returning" value="<?= $this->User_grantee_grant_model->label_returning ?>">
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<?php if($this->session->userdata('active_country') == AMERICAN_DATABASE) { ?>
				<div class="form-group">
					<label> Year</label>
					<select class="form-control" name="year">
					<?php for ($i = date('Y') + 5; $i > 1900; $i--) : ?>
						<?php
						$selected = '';
						$year = isset($this->User_grantee_grant_model->year) ? $this->User_grantee_grant_model->year : date('Y');
						if ($i == $year) {
							$selected = 'selected';
						}
						?>
						<option <?= $selected ?> value="<?= $i; ?>"><?= $i; ?></option>
					<?php endfor; ?>
					</select> 
				</div>
				<?php if (get_active_country(true) == AMERICAN_DATABASE && isset($this->User_grantee_grant_model->id)) { ?>
					<div class="form-group">
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mdl_memo">Add Memo Budget</button>
					</div>
					<table id="memo_revision" class="table table-striped" width="100%">
						<thead>
							<tr>
								<th>File name</th>
								<!-- <th>Year</th> -->
								<th>Active</th>
								<th>Uploaded Date</th>
								<th class="text-right">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($memo_grants as $key => $value) { ?>
								<tr>
									<td><a target="_blank" href="<?= site_url($value->memo_budget); ?>" class="lightbox"><?= $value->file_name;?></a></td>
									<!-- <td><?= $value->year;?></td> -->
									<td><?= $value->is_active;?></td>
									<td><?= date("d M y h:i", strtotime($value->created_at));?></td>
									<td class="text-right">
										<a class="btn btn-primary" data-toggle="modal" data-target="#edit_mdl_memo" data-memo_id="<?= $value->id ?>">Edit</a>
										<a href="<?php echo site_url('admin/user_grantee_grant/delete_grant_memo/') . $value->id; ?>" class="btn btn-danger btn-delete-memo">Delete</a>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				<?php } else { ?>
					<div class="form-group">
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mdl_memo_create">Add Memo Budget</button>
					</div>
					<table id="memo_revision" class="table table-bordered" width="100%">
						<thead>
							<tr>
								<th>File name</th>
								<!-- <th>Year</th> -->
								<th>Active</th>
								<th>Uploaded Date</th>
								<th class="text-right">Action</th>
							</tr>
						</thead>
						<tbody id="list_memo"> 
							
						</tbody>
					</table>
				<?php  } ?>
				<?php if ($this->session->userdata('active_country') == AMERICAN_DATABASE) { ?>
					<!-- <div class="form-group mt-4">
						<label for="require_personal_info_for_new_grantee"> Default Payment Record Status </label>
						<select class="select2 form-control" name="default_payment_record_status">
							<option>-- Select Payment Record Status --</option>
							<?php foreach($payment_record_statuses as $payment_record_status) { ?>
								<option value="<?php echo $payment_record_status->id; ?>" <?php echo $this->User_grantee_grant_model->default_payment_record_status == $payment_record_status->id ? 'selected' : ''; ?>><?php echo $payment_record_status->name; ?></option>
							<?php } ?>
						</select>
					</div> -->
				<?php } ?>
				<?php if (get_active_country(true) == AMERICAN_DATABASE) { ?>
					<div class="row mt-4">
						<div class="col-md-4">
							<div class="form-group">
								<label>Upload Example CV</label>
								<input type="file" name="example_cv" id="example_cv">
								<?php if (!empty($this->User_grantee_grant_model->example_cv)): ?>
									<input type="hidden" name="example_cv_uploaded" id="example_cv_uploaded" value="<?php echo $this->User_grantee_grant_model->example_cv; ?>">
									<p id="file_info">
										Current File: 
										<a href="<?php echo site_url($this->User_grantee_grant_model->example_cv) ?>" download>View</a> 
										<a class="text-danger" href="#" onclick="remove_file(event)"><i class="fa fa-times-circle" style="color: orangered;"></i></a>
									</p>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<div class="row mt-4">
						<div class="col-md-4">
							<div class="form-group">
								<label>Personal Travel Form</label>
								<input type="file" name="personal_travel_form" id="personal_travel_form">
								<?php if (!empty($this->User_grantee_grant_model->personal_travel_form)): ?>
									<input type="hidden" name="personal_travel_form_uploaded" id="personal_travel_form_uploaded" value="<?php echo $this->User_grantee_grant_model->personal_travel_form; ?>">
									<p id="file_info">
										Current File: 
										<a href="<?php echo site_url($this->User_grantee_grant_model->personal_travel_form) ?>" download>View</a> 
										<a class="text-danger" href="#" onclick="remove_file(event)"><i class="fa fa-times-circle" style="color: orangered;"></i></a>
									</p>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<div class="row mt-4">
						<div class="col-md-4">
							<div class="form-group">
								<label>International Travel Form</label>
								<input type="file" name="international_travel_form" id="international_travel_form">
								<?php if (!empty($this->User_grantee_grant_model->international_travel_form)): ?>
									<input type="hidden" name="international_travel_form_uploaded" id="international_travel_form_uploaded" value="<?php echo $this->User_grantee_grant_model->international_travel_form; ?>">
									<p id="file_info">
										Current File: 
										<a href="<?php echo site_url($this->User_grantee_grant_model->international_travel_form) ?>" download>View</a> 
										<a class="text-danger" href="#" onclick="remove_file(event)"><i class="fa fa-times-circle" style="color: orangered;"></i></a>
									</p>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php } ?>
				<div class="row mt-4">
					<div class="col-lg-3" id="personal_travel">
						<div class="form-group">
							<label>Personal Travel</label>
							<input type="number" class="form-control" name="personal_travel" value="<?= $this->User_grantee_grant_model->personal_travel ?>">
						</div>
					</div>
					<div class="col-lg-3 <?= $this->User_grantee_grant_model->category_grant != ETA ? 'hide' : '' ?>" id="sick_leave">
						<div class="form-group">
							<label>Sick Leave</label>
							<input type="number" class="form-control" name="sick_leave" value="<?= $this->User_grantee_grant_model->sick_leave ?>">
						</div>
					</div>
					<div class="col-lg-3 <?= !in_array($this->User_grantee_grant_model->category_grant, [ETA, RESEARCH]) ? 'hide' : '' ?>" id="emergency_leave">
						<div class="form-group">
							<label>Emergency Leave</label>
							<input type="number" class="form-control" name="emergency_leave" value="<?= $this->User_grantee_grant_model->emergency_leave ?>">
						</div>
					</div>
					<div class="col-lg-3 <?= $this->User_grantee_grant_model->category_grant != RESEARCH ? 'hide' : '' ?>" id="research_leave">
						<div class="form-group">
							<label>International Research Travel</label>
							<input type="number" class="form-control" name="research_leave" value="<?= $this->User_grantee_grant_model->research_leave ?>">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label>Show Upload Leave Form </label>
					<input type="checkbox" value="1" name="form_leave" <?= $this->User_grantee_grant_model->form_leave == 1 ? "checked" : "" ?>>
				</div>
				<div class="form-group">
					<label>Show Departure Time from Site</label>
					<input type="checkbox" value="1" name="show_departure_time" <?= $this->User_grantee_grant_model->show_departure_time == 1 ? "checked" : "" ?>>
				</div>
				<div class="form-group">
					<label> Default Dashboard Filter </label>
					<input type="checkbox" value="1" name="default_dashboard_filter" <?= isset($this->User_grantee_grant_model->default_dashboard_filter) && $this->User_grantee_grant_model->default_dashboard_filter == 1 ? "checked" : "" ?>>
					<small class="help-block">Check this to set this program as default filter for submitted documents widget on dashboard</small>
				</div>
				<div class="form-group">
					<label> Resources </label>
					<input type="checkbox" value="1" name="show_resources" <?= $this->User_grantee_grant_model->show_resources == 1 ? "checked" : "" ?>>
				</div>

				<div class="form-group">
					<label> ETA Resources </label>
					<input type="checkbox" value="1" name="show_eta_resources" <?= $this->User_grantee_grant_model->show_eta_resources == 1 ? "checked" : "" ?>>
				</div>
				<div class="form-group">
					<label for="allow_dependents"> Allow Dependents </label>
					<input type="checkbox" value="1" id="allow_dependents" name="allow_dependents" <?= $this->User_grantee_grant_model->allow_dependents == 1 ? "checked" : "" ?>>
				</div>
				<div class="form-group">
					<label for="require_personal_info_for_new_grantee"> Require complete personal info for new grantee submission form </label>
					<input type="checkbox" value="1" id="require_personal_info_for_new_grantee" name="require_personal_info_for_new_grantee" <?= $this->User_grantee_grant_model->require_personal_info_for_new_grantee == 1 || !isset($this->User_grantee_grant_model->require_personal_info_for_new_grantee) ? "checked" : "" ?>>
				</div>
				<div class="form-group">
					<label for="always_show_on_create_grantee"> Always show on create grantee dropdown </label>
					<input type="checkbox" value="1" id="always_show_on_create_grantee" name="always_show_on_create_grantee" <?= isset($this->User_grantee_grant_model->always_show_on_create_grantee) && $this->User_grantee_grant_model->always_show_on_create_grantee == 1 ? "checked" : "" ?>>
					<small class="help-block">Check this to always show this grant in the dropdown when creating a new grantee, regardless of the current year</small>
				</div>
				<div class="form-group">
					<label for="allow_retrospective_edits"> Allow Retrospective Edits </label>
					<input type="checkbox" value="1" id="allow_retrospective_edits" name="allow_retrospective_edits" <?= isset($this->User_grantee_grant_model->allow_retrospective_edits) && $this->User_grantee_grant_model->allow_retrospective_edits == 1 ? "checked" : "" ?>>
					<small class="help-block">Grantees can edit submissions from previous modules (Finalist, Incoming, Visa) until their status changes to "Current".</small>
				</div>
				<div class="form-group">
					<label> Show ASPE </label>
					<input type="checkbox" value="1" name="show_aspe" <?= isset($this->User_grantee_grant_model->show_aspe) && $this->User_grantee_grant_model->show_aspe == 1 ? "checked" : "" ?> >
				</div>
				<div class="form-group">
					<label> Show Nearest International Airport</label>
					<input type="checkbox" value="1" name="show_nearest_int_airport" <?= isset($this->User_grantee_grant_model->show_nearest_int_airport) && $this->User_grantee_grant_model->show_nearest_int_airport == 1 ? "checked" : "" ?> >
				</div>
			<?php } ?>


			<div class="form-group">
				<label for="show_pdf_logo"> Display Fulbright Logo on PDF Submission </label>
				<input type="checkbox" value="1" id="show_pdf_logo" name="show_pdf_logo" <?= $this->User_grantee_grant_model->show_pdf_logo == 1 ? "checked" : "" ?>>
			</div>

			<?php if (get_active_country(true) == INDONESIAN_DATABASE) { ?>
			<div class="form-group">
				<label for="show_attrition_detail"> Show Attrition Detail </label>
				<input type="checkbox" value="1" id="show_attrition_detail" name="show_attrition_detail" <?= $this->User_grantee_grant_model->show_attrition_detail == 1 ? "checked" : "" ?>>
			</div>
			<div class="form-group">
				<label for="is_degree"> Is Degree </label>
				<input type="checkbox" value="1" id="is_degree" name="is_degree" <?= $this->User_grantee_grant_model->is_degree == 1 ? "checked" : "" ?>>
			</div>
			<?php } ?>
			
			<div class="form-group">
				<label> Is Active </label>
				<input type="checkbox" value="1" name="is_active" <?= $this->User_grantee_grant_model->is_active == 1 ? "checked" : "" ?>>
			</div>
			

			<?php if (isset($this->User_grantee_grant_model->id)) { ?>
				<input type="hidden" name="id" value="<?= $this->User_grantee_grant_model->id ?>">
			<?php } ?>
		</form>
	</div>
	<!-- /.col-lg-12 -->
	<!-- <div class="row col-lg-12 section_save mb-3">
		<a href="<?= site_url('admin/user_grantee_grant/manage') ?>" class="btn btn-default">Back</a>
		<button type="submit" form="form-grand" class="btn btn-success">Save</button>
	</div> -->

	<div class="col-lg-12">
		<div class="section_save">
			<div class="pull-right">
				<a href="<?= site_url('admin/user_grantee_grant/manage') ?>" class="btn btn-default">Back</a>
				<button type="submit" form="form-grand" class="btn btn-success">Save</button>
			</div>
		</div>
	</div>
</div>
<!-- /.row -->

<!-- Modal For Edit -->
<div class="modal fade" id="mdl_memo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add Memo Budget</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form role="form" method="POST" id="form_memo" enctype="multipart/form-data">
					<input type="hidden" name="save_memo">
					<input type="hidden" name="user_grantee_grant_id" value="<?= $this->User_grantee_grant_model->id; ?>" >
					<input type="hidden" name="year" value="<?= $this->User_grantee_grant_model->year; ?>" >
					<div class="form-group">
						<label>Memo Budget</label>
						<input type="file" id="memo_budget" name="memo_budget">
						<small class="file-for-testing">File Size Max 5MB</small>
					</div>
					<!-- <div class="form-group">
						<label>Year</label>
						<select name="year" id="" name="year" class="form-control">
							<?php for ($i = date("Y", strtotime("-25 years")); $i < date("Y", strtotime("+10 years")); $i++) { ?>
								<?php $selected = date("Y") == $i ? ' selected="selected"' : '' ?>
								<option <?= $selected ?> value="<?= $i; ?>"><?= $i; ?></option>
							<?php } ?>
						</select>
					</div> -->
					<div class="form-group">
						<label for="">Active</label>
						<select name="is_active" id="" class="form-control">
							<option value="Yes">Yes</option>
							<option value="No">No</option>
						</select>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" form="form_memo" id="btn-memo">Save</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal For Create -->
<div class="modal fade" id="mdl_memo_create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add Memo Budget</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?= form_open(base_url('admin/user_grantee_grant/add_memo_budget'), ['id' => 'form-add-memo']); ?>
			<div class="modal-body">
					<input type="hidden" name="add_memo">
					<div class="form-group">
						<label>Memo Budget</label>
						<input type="file" id="memo_budget" name="memo_budget">
						<small class="file-for-testing">File Size Max 5MB</small>
					</div>
					<div class="form-group">
						<label>Year</label>
						<select name="year" id="year" name="year" class="form-control">
							<?php for ($i = date("Y", strtotime("-25 years")); $i < date("Y", strtotime("+10 years")); $i++) { ?>
								<?php $selected = date("Y") == $i ? ' selected="selected"' : '' ?>
								<option <?= $selected ?> value="<?= $i; ?>"><?= $i; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label for="">Active</label>
						<select name="is_active" id="is_active" class="form-control">
							<option value="Yes">Yes</option>
							<option value="No">No</option>
						</select>
					</div>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Save</button>
			</div>
			<?= form_close(); ?>
		</div>
	</div>
</div>

<!-- Modal For Edit -->
<div class="modal fade" id="edit_mdl_memo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Edit Memo Budget</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form role="form" method="POST" id="form_memo" enctype="multipart/form-data">
			<input type="hidden" name="save_memo">
			<div class="modal-body">
					<input type="hidden" id="memo_id" name="memo_id">
					<input type="hidden" id="edit_memo_year" name="year">
					<div class="form-group">
						<label>Memo Budget</label>
						<input type="file" id="memo_budget" name="memo_budget">
						<small class="file-for-testing">File Size Max 5MB</small>
					</div>
					<!-- <div class="form-group">
						<label>Year</label>
						<select name="year" id="edit_memo_year" name="year" class="form-control">
							<?php for ($i = date("Y", strtotime("-25 years")); $i < date("Y", strtotime("+10 years")); $i++) { ?>
								<option value="<?= $i; ?>"><?= $i; ?></option>
							<?php } ?>
						</select>
					</div> -->
					<div class="form-group">
						<label for="">Active</label>
						<select name="is_active" id="edit_memo_is_active" class="form-control">
							<option value="Yes">Yes</option>
							<option value="No">No</option>
						</select>
					</div>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Save</button>
			</div>
			</form>
		</div>
	</div>
</div>


<div class="modal fade" id="mdl_add_mentoring" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add Mentoring Type</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form role="form" method="POST" id="form_mentoring" action="<?= base_url('admin/user_grantee_grant/add_mentoring_type'); ?>" enctype="multipart/form-data">
			<input type="hidden" name="grant_id" value="<?= $this->User_grantee_grant_model->id; ?>" >
			<div class="modal-body">
				<div class="form-group">
					<label>Mentoring Type</label>
					<input type="text" id="mentoring_type" name="name" placeholder="eg: Objectives and Motivations" required class="form-control">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Save</button>
			</div>
			</form>
		</div>
	</div>
</div>


<?php
if (!empty($memo_grants)) :
    $final_record = [];
    foreach ($memo_grants as $memo) {
        $final_record[$memo->id] = $memo;
    }
?>
    <script>
        var currentMemoGrants = JSON.parse(`<?= safe_parse_json(json_encode($final_record)); ?>`);
    </script>
<?php endif; ?>