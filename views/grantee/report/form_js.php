<script>
    $(document).ready(function() {

        $(".select2").select2();
        $(".datetime").datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            autoclose: true,
        })

        $(".datetime").change(function() {
            $(this).trigger('blur');
        })

        $('.datepicker').change(function() {
            $(this).blur();
        });

        $(".select2").on('select2:close', function() {
            $(this).trigger('blur');
        });

        $(document).on("blur", ".autosave", function() {
            var data_value = $(this).val();
            var custom_fields_id = $(this).data('id');
            var step_id = $(this).data('step');
            var category_type = $(this).data('category-type');
            var category_id = $(this).data('category-id');
            var grant_id = $(this).data('grant-id');
            var period_id = $(this).data('period-id');

            // add logic for checkbox
            if ($(this).is(':checkbox')) {
                data_value = [];
                $.each($(`input[type='checkbox']:checked`), function() {
                    data_value.push($(this).val())
                })
            }

            // add logic for multiple choice grid 
            if ($(this).hasClass('multiple-choice-grid')) {
                data_value = [];
                $.each($(`.table_${custom_fields_id} input:radio.multiple-choice-grid:checked`), function() {
                    data_value.push($(this).val())
                })

            }

            // check if other value
            var data = {
                value: data_value,
                user_grantee_custom_fields_id: custom_fields_id,
                user_grantee_step_id: step_id,
                user_grantee_category_type: category_type,
                user_grantee_category_report_id: category_id,
                user_grantee_grant_id: grant_id,
                user_grantee_period_id: period_id,
                is_other: false
            };
            if ($(this).hasClass('text-have-other')) {
                data['is_other'] = true;
            }

            $(document).find('.btn-submit').prop('disabled', true);
            $.ajax({
                    url: "<?= base_url(); ?>grantee/submission/save_fields",
                    method: "POST",
                    data: data
                })
                .success(function(data) {
                    console.log(data);
                    $(document).find('.btn-submit').prop('disabled', false);
                }).fail(function(xhr, status, error) {
                    alert('Failed to save data. Please try again.');
                    $(document).find('.btn-submit').prop('disabled', false);
                });
        });
    });
    
    function submission_onblur(element) {
        // var element = $(this);
        var data_value = element.value;
        var custom_fields_id = $(element).data('id');
        var is_required = $(element).attr("required");

        // add logic for checkbox
        if ($(element).is(':checkbox')) {
            data_value = [];
            $.each($(`input[type='checkbox']:checked`), function(){
                data_value.push($(element).val())
            })
        }

        // add logic for multiple
        if ($(element).hasClass('multiple-select')) {
            data_value = $(element).val();
        }

        // add logic for multiple choice grid 
        if ($(element).hasClass('multiple-choice-grid')){
            data_value = [];
            $.each($(`.table_${custom_fields_id} input:radio.multiple-choice-grid:checked`), function(){
                data_value.push($(element).val())
            })
            
        }

        var step_id = $(element).data('step');
        var category_type = $(element).data('category-type');
        var grant_id = $(element).data('grant-id');
        var user_id = $('#grantee_id').val();
        var period_id = $(element).data('period-id');
        var category_id = $(element).data('category-id');
        $.ajax({
            url: "<?= base_url(); ?>grantee/submission/save_fields",
            method: "POST",
            data: {
                value: data_value,
                user_grantee_custom_fields_id: custom_fields_id,
                user_grantee_step_id: step_id,
                user_grantee_category_type: category_type,
                user_grantee_category_report_id: category_id,
                user_grantee_grant_id: grant_id,
                user_grantee_period_id: period_id,
                is_other: false
            }
        })
        .success(function(data){
            console.log(data);
        })
    }

    $(".btn-submit").click(function() { 
        event.preventDefault();
        let form_id = $(this).data('form_id');
        let category_id = $(this).data('category_id');
        let validated = validate_all_input(form_id);

        $('#user_grantee_category_report_id').val(category_id)

        if (validated) {
            $("#mdl_info").modal();
        }
    });

    $("#btn-yes").click(function() {
        $("#form").submit();
    });

    /**
     * @param mixed tab
     * 
     * validate tab fields
     * 
     * @return bool
     */
    function validate_all_input(tab) {

        $(".text-required").remove();

        var validated = true;



        // check for element textarea
        $("#" + tab).find("textarea.form-control").each(function() {
            let group = $(this).data('type-group');
            if (group != 'radio') {
                let invalid_values = [null, ''];

                let is_required = false;
                if ($(this).prop('required')) {
                    is_required = true;
                }

                if (invalid_values.includes($(this).val()) && is_required) {
                    const has_warning = $(this).closest('div').find('p');
                    if (has_warning.length == 0) {
                        validated = false;
                        $(this).closest('div').append('<p class="text-required text-danger">This field is required</p>');
                        $(this).focus();
                    }
                }
            }

        });

        // check for element select
        $("#" + tab).find("select.form-control").each(function() {
            let group = $(this).data('type-group');
            if (group != 'radio') {
                let first_value = $(this).find("option:not(:selected):first").val();

                let is_required = false;
                if ($(this).prop('required')) {
                    is_required = true;
                }

                if (($(this).val() == null || $(this).val() == first_value || $(this).val() == '') && is_required) {
                    const has_warning = $(this).closest('div').find('p.text-required');
                    if (has_warning.length == 0) {
                        validated = false;
                        $(this).closest('div').append('<p class="text-required text-danger">This field is required</p>');
                        $(this).focus();
                    }
                }
            }
        });

        // check for element input
        $("#" + tab).find("input.form-control").filter(function() {
            // exclude input elements inside the element group, radio group or not displayed input
            let display_property = $(this).css("display");
            let input_group = $(this).data('group');
            
            if (input_group == undefined) {
                return false;
            }

            if ($(this).data('group').length > 0) {
                return false;
            }

            return display_property !== "none" && typeof display_property !== "undefined";
        }).each(function() {
            let group = $(this).data('type-group');
            if (group != 'radio') {
                let invalid_values = [null, ''];
                let is_required = false;
                if ($(this).prop('required')) {
                    is_required = true;
                }
                if (invalid_values.includes($(this).val()) && is_required) {
                    const has_warning = $(this).closest('div').find('p');
                    if (has_warning.length == 0) {
                        validated = false;
                        $(this).closest('div').append('<p class="text-required text-danger">This field is required</p>');
                        $(this).focus();
                    }
                }
            }
        });

        // check input with type hidden
        $("#" + tab).find("input[type=hidden].autosave").each(function() {
            let group = $(this).data('type-group');
            let hidden_radio = $(this).is('[class*="radio"]');
            if (group != 'radio' && !hidden_radio) {
                let invalid_values = [null, ''];
                let is_required = false;
                if ($(this).prop('required')) {
                    is_required = true;
                }

                if (invalid_values.includes($(this).val()) && is_required) {
                    const has_warning = $(this).closest('div').find('p');
                    if (has_warning.length == 0) {
                        validated = false;
                        $(this).closest('div').append('<p class="text-required text-danger">This field is required</p>');
                        $(this).focus();
                    }
                }
            }
        });

        $("#" + tab).find("input[type=checkbox]").each(function() {
            let group = $(this).data('type-group');

            if (group != 'radio') {
                let invalid_values = [null, ''];
                let is_required = false;
                if ($(this).prop('required')) {
                    is_required = true;
                }

                if ($(this).val() != '' && is_required) {
                    const has_warning = $(this).closest('div').find('p');
                    if (has_warning.length == 0) {
                        validated = false;
                        $(this).closest('div').append('<p class="text-required text-danger">This field is required</p>');
                        $(this).focus();
                    }
                }
            }
        });

        // check for element checkbox
        $("#" + tab).find(".checkbox-inline").find('input[type="checkbox"]').each(function() {
            let group = $(this).data('type-group');
            if (group != 'radio') {
                let invalid_values = [null, ''];
                let is_required = false;
                let parentDiv = $(this).closest('div');

                if ($(this).find('input').prop('required')) {
                    is_required = true;
                }

                // Check if there's any checked checkbox within the parent div
                const any_checkbox_checked = parentDiv.find(':checkbox:checked').length > 0;

                if (!any_checkbox_checked && is_required) {
                    const has_warning = parentDiv.find('p');
                    if (has_warning.length == 0) {
                        validated = false;
                        parentDiv.append('<p class="text-required text-danger">This field is required</p>');
                        $(this).focus();
                    } else {
                        // Remove the warning message if a valid option is selected
                        $(this).find('p.text-required').remove();
                    }
                }
            }
        });

        // check for radio
        $("#" + tab).find('.radio-group-element').each(function() {
            let is_required = $(this).find('input[type="radio"]').prop('required');
            const hasChecked = $(this).find('input[type="radio"]:checked').length > 0;
            if (!hasChecked && is_required) {
                const hasWarning = $(this).find('p.text-required');
                if (hasWarning.length === 0) {
                    validated = false;
                    $(this).find('label.radio-inline:last').after('<p class="text-required text-danger">This field is required</p>');
                    $(this).find('input[type="radio"]').focus();
                }
            } else {
                // Remove the warning message if a valid option is selected
                $(this).find('p.text-required').remove();
            }

            var selected_radio_element = $(this).find('input:checked');
            let radio_group_elements = $(this).closest('div').find('.show-group');
            radio_group_elements.each(function() {
                let current_element = $(this);
                if (current_element.data('element') == selected_radio_element.data('show')) {
                    let input_elements = current_element.find('input');
                    input_elements.each(function() {
                        let invalid_input_values = [null, ''];
                        let is_required = false;

                        if ($(this).prop('required')) {
                            is_required = true;
                        }

                        if (invalid_input_values.includes($(this).val()) && is_required) {
                            let has_warning = $(this).closest('div').find('p');
                            if (has_warning.length == 0) {
                                validated = false;
                                $(this).closest('div').append('<p class="text-required text-danger">This field is required</p>');
                                $(this).focus();
                            }
                        } else {
                            $(this).closest('div').find('p.text-required').remove();
                        }
                    });

                    let select_elements = current_element.find('select');
                    select_elements.each(function() {
                        let first_value = $(this).find("option:not(:selected):first").val();

                        let is_required = false;
                        if ($(this).prop('required')) {
                            is_required = true;
                        }

                        if (($(this).val() == null || $(this).val() == first_value || $(this).val() == '') && is_required) {
                            let has_warning = $(this).closest('div').find('p.text-required');
                            if (has_warning.length == 0) {
                                validated = false;
                                $(this).closest('div').append('<p class="text-required text-danger">This field is required</p>');
                                $(this).focus();
                            }
                        } else {
                            $(this).closest('div').find('p.text-required').remove();
                        }
                    });

                    let textarea_elements = current_element.find('textarea');
                    textarea_elements.each(function() {
                        let invalid_input_values = [null, ''];
                        let is_required = false;

                        if ($(this).prop('required')) {
                            is_required = true;
                        }

                        if (invalid_input_values.includes($(this).val()) && is_required) {
                            let has_warning = $(this).closest('div').find('p');
                            if (has_warning.length == 0) {
                                validated = false;
                                $(this).closest('div').append('<p class="text-required text-danger">This field is required</p>');
                                $(this).focus();
                            }
                        } else {
                            $(this).closest('div').find('p.text-required').remove();
                        }
                    });

                    let checkbox_elements = current_element.find('.checkbox-inline');
                    checkbox_elements.each(function() {
                        let invalid_values = [null, ''];
                        let is_required = false;
                        let parentDiv = $(this).closest('div');

                        if ($(this).find('input').prop('required')) {
                            is_required = true;
                        }

                        // Check if there's any checked checkbox within the parent div
                        const any_checkbox_checked = parentDiv.find(':checkbox:checked').length > 0;

                        if (!any_checkbox_checked && is_required) {
                            const has_warning = parentDiv.find('p');
                            if (has_warning.length == 0) {
                                validated = false;
                                parentDiv.append('<p class="text-required text-danger">This field is required</p>');
                                $(this).focus();
                            } else {
                                // Remove the warning message if a valid option is selected
                                $(this).find('p.text-required').remove();
                            }
                        }
                    });

                    // hidden for radio value
                    let hidden_elements = current_element.find("input[type=hidden].autosave");
                    hidden_elements.each(function() {
                        let invalid_values = [null, ''];
                        let is_required = false;
                        if ($(this).prop('required')) {
                            is_required = true;
                        }

                        if (invalid_values.includes($(this).val()) && is_required) {
                            const has_warning = $(this).closest('div').find('p');
                            if (has_warning.length == 0) {
                                validated = false;
                                $(this).closest('div').append('<p class="text-required text-danger">This field is required</p>');
                                $(this).focus();
                            }
                        }
                    });
                }
            });
        });
        
        
        $('#' + tab).find('.multiple-choice-grid').each(function () {
            let cf_id = $(this).data('id');
            let opt_name = $(this).prop('name');
            let options = $('input[name="' + opt_name + '"]');
            let is_required = options.prop('required');
            let has_checked = false;
            options.each(function () {
                if ($(this).is(':checked')) {
                    has_checked = true;
                }
            });
            
            if (!has_checked) {
                validated = false;
                let has_text_required = $('.custom-field-section-' + cf_id).find('.text-required');
                if (has_text_required.length === 0) {
                    $('.custom-field-section-' + cf_id).append('<p class="text-required text-danger">Option on this sections should be completed</p>');
                }

            } else {
                $(this).find('p.text-required').remove();
            }
        });

        $('#' + tab).find('.radio-inline').find('input').each(function () {
            let cf_id = $(this).data('id');
            let opt_name = $(this).prop('name');
            let options = $('input[name="' + opt_name + '"]');
            let is_required = options.prop('required');
            let has_checked = false;
            options.each(function () {
                if ($(this).is(':checked')) {
                    has_checked = true;
                }
            });
            
            if (!has_checked) {
                validated = false;
                let has_text_required = $('.custom-field-section-' + cf_id).find('.text-required');
                if (has_text_required.length === 0) {
                    $('.custom-field-section-' + cf_id).append('<p class="text-required text-danger">Option on this sections should be completed</p>');
                }

            } else {
                $(this).find('p.text-required').remove();
            }
        });


        // check for file
        $("#" + tab).find("input[type=file]").each(function() {
            if ($(this).prop('disabled')) {
                return;
            }
            // skip file inputs that belong to radio-group or education-group sub-elements
            // those are validated separately within their own group validator block
            let fileGroup = $(this).data('type-group');
            if (fileGroup == 'radio' || fileGroup == 'education') {
                return;
            }
            let is_required = false;
            if ($(this).prop('required')) {
                is_required = true;
            }

            if ($(this).val().length === 0 && is_required) {
                const has_warning = $(this).closest('div').find('p.text-required');
                if (has_warning.length == 0) {
                    validated = false;
                    $(this).after('<p class="text-required text-danger">This field is required</p>');
                    $(this).focus();
                }
            }
        });

        return validated;
    }

    function validateTextArea(element) {
        var isLimit = $(element).data('limit');
        var maxlen = $(element).data('maxlength');
        var length = $(element).val().split(/\s+/).length;
        var id = $(element).data('index');
        var maxLength = $(element).val().split(/\s+/).slice(0, maxlen);
        var maxWords = maxLength.join(' ');
        var charCount = $(element).val().length;


        if(isLimit){
            if(charCount > (maxlen)){
                var trimmedText = $(element).val().substring(0, maxlen);
                $(element).val(trimmedText);
                $('#textarea_message_'+id).text('max length '+maxlen+' characters only!').addClass('text-danger')
            }else
            {
                $('#textarea_message_'+id).text((maxlen-charCount) + ' characters remaining')
            }
        }
    }
</script>