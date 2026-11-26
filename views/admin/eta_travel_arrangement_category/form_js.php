<script>
	const SITE_URL = '<?php echo site_url(); ?>';
	(function($){
		$(document).ready(function(){
			const selected_category = <?php echo json_encode(isset($this->Eta_travel_arrangement_category_model->user_grantee_category_id) ? $this->Eta_travel_arrangement_category_model->user_grantee_category_id : ''); ?>;
			const selected_step = <?php echo json_encode(isset($this->Eta_travel_arrangement_category_model->user_grantee_step_id) ? $this->Eta_travel_arrangement_category_model->user_grantee_step_id : ''); ?>;
			const selected_submission = <?php echo json_encode(isset($this->Eta_travel_arrangement_category_model->user_grantee_custom_fields_id) ? $this->Eta_travel_arrangement_category_model->user_grantee_custom_fields_id : ''); ?>;

			function load_categories(grant_id, selected) {
				if (!grant_id) return;
				$.getJSON(SITE_URL + 'admin/eta_travel_arrangement_category/ajax_get_user_grantee_categories/' + grant_id, function(data) {
					const $cat = $('#user_grantee_category_id');
					$cat.html('<option value="">-- Select Category --</option>');
					$.each(data, function(index, item) {
						const sel = (item.id == selected) ? 'selected' : '';
							$cat.append('<option value="' + item.id + '" ' + sel + '>' + item.name + '</option>');
						});
				});
			}

			function load_steps(grant_id, category_id, selected) {
				if (!grant_id || !category_id) return;
				$.getJSON(SITE_URL + 'admin/eta_travel_arrangement_category/ajax_get_user_grantee_steps/' + grant_id + '/' + category_id, function(data) {
					const $step = $('#user_grantee_step_id');
					$step.html('<option value="">-- Select Step --</option>');
					$.each(data, function(index, item) {
						const sel = (item.id == selected) ? 'selected' : '';
							$step.append('<option value="' + item.id + '" ' + sel + '>' + (item.label ? item.label : item.name) + '</option>');
						});
				});
			}

			function load_submissions(grant_id, step_id, selected) {
				if (!grant_id || !step_id) return;
				$.getJSON(SITE_URL + 'admin/eta_travel_arrangement_category/ajax_get_user_grantee_submissions/' + grant_id + '/' + step_id, function(data) {
					const $sub = $('#user_grantee_custom_fields_id');
					$sub.html('<option value="">-- Select Submission --</option>');
					$.each(data, function(index, item) {
						const sel = (item.id == selected) ? 'selected' : '';
						const dtype = item.type ? item.type : '';
						$sub.append('<option value="' + item.id + '" data-type="' + dtype + '" ' + sel + '>' + item.name + '</option>');
					});
				});
			}


			function load_submission_sub_elements(custom_field_id, selected_sub) {
				if (!custom_field_id) return;
				$.getJSON(SITE_URL + 'admin/eta_travel_arrangement_category/ajax_get_submission_sub_elements/' + custom_field_id, function(data) {
					const $wrap = $('#user_grantee_custom_sub_fields_wrap');
					const $sub = $('#user_grantee_custom_sub_fields_id');
					$sub.html('<option value="">-- Select Sub Field --</option>');
					if (data && data.length > 0) {
						$.each(data, function(index, item) {
							const sel = (item.id == selected_sub) ? 'selected' : '';
							$sub.append('<option value="' + item.id + '" data-property-type="' + (item.property_type ? item.property_type : '') + '" data-which-option="' + (item.which_option ? item.which_option : '') + '" ' + sel + '>' + (item.property_name ? item.property_name : item.property_name) + '</option>');
						});
						$wrap.removeClass('hide');
					} else {
						$wrap.addClass('hide');
					}
				});
			}

			const grant_id_from_option = <?php echo json_encode(get_option('eta_travel_arrangement_program') ?: ''); ?>;

			if (grant_id_from_option) {
				load_categories(grant_id_from_option, selected_category);
				if (selected_category) {
					load_steps(grant_id_from_option, selected_category, selected_step);
				}
				if (selected_step) {
					load_submissions(grant_id_from_option, selected_step, selected_submission);
				}
			}

			$('#user_grantee_category_id').on('change', function() {
				const cid = $(this).val();
				const grant_id = grant_id_from_option;
				$('#user_grantee_step_id').html('<option value="">-- Select Step --</option>');
				$('#user_grantee_custom_fields_id').html('<option value="">-- Select Submission --</option>');
				if (cid && grant_id) {
					load_steps(grant_id, cid, '');
				}
			});

			$('#user_grantee_step_id').on('change', function() {
				const sid = $(this).val();
				const grant_id = grant_id_from_option;
				$('#user_grantee_custom_fields_id').html('<option value="">-- Select Submission --</option>');
				if (sid && grant_id) {
					load_submissions(grant_id, sid, '');
				}
			});

			$('#user_grantee_custom_fields_id').on('change', function() {
				const selectedType = $(this).find('option:selected').data('type');
				const cfid = $(this).val();
				$('#user_grantee_custom_sub_fields_id').html('<option value="">-- Select Sub Field --</option>');
				if (selectedType && (selectedType === 'radio group' || selectedType === 'element group')) {
					load_submission_sub_elements(cfid, '');
				} else {
					$('#user_grantee_custom_sub_fields_wrap').addClass('hide');
				}
			});

			const selected_sub = <?php echo json_encode(isset($this->Eta_travel_arrangement_category_model->user_grantee_custom_sub_fields_id) ? $this->Eta_travel_arrangement_category_model->user_grantee_custom_sub_fields_id : ''); ?>;
			if (selected_submission) {
				setTimeout(function() {
					const $opt = $('#user_grantee_custom_fields_id').find('option:selected');
					const dtype = $opt.data('type');
					const cfid = $opt.val();
					if (dtype && (dtype === 'radio group' || dtype === 'element group')) {
						load_submission_sub_elements(cfid, selected_sub);
					}
				}, 250);
			}
		});
	})(jQuery);
</script>
