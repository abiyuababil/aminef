<script>
    var application_id = <?= $application_id ?>;
    var user_id = <?= $user_id ?>;
    var fiscal_year_id = <?= $fiscal_year_id ?>;
    
    $('<style>').text(`
        .swal2-toast {
            font-size: 11px !important;
            padding: 8px 14px !important;
            width: auto !important;
            min-width: 180px !important;
            max-width: 260px !important;
            font-weight: normal !important;
        }
        .swal2-toast .swal2-title {
            font-size: 12px !important;
            font-weight: normal !important;
        }
        .swal2-toast .swal2-icon {
            width: 18px !important;
            height: 18px !important;
            margin: 0 6px 0 0 !important;
        }
        .swal2-toast .swal2-timer-progress-bar {
            height: 4px !important;
        }
        #last-saved-indicator {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            background: rgba(0,0,0,0.8);
            color: #fff;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            display: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            max-width: 320px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        #last-saved-indicator .fa-check-circle {
            color: #5cb85c;
            margin-right: 5px;
        }
    `).appendTo('head');

    $('<div id="last-saved-indicator"><i class="fa fa-check-circle"></i> <span></span></div>').appendTo('body');

    var SaveToast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true
    });

    function updateLastSaved(label) {
        var now = new Date();
        var time = now.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit', second:'2-digit'});
        $('#last-saved-indicator span').text('Last saved: ' + label + ' at ' + time);
        $('#last-saved-indicator').stop(true, true).fadeIn(200).delay(3000).fadeOut(500);
    }

    function getFieldLabel(element) {
        var label = element.closest('.row.form-group, .multiple-item, .panel-body').find('b').first().text().trim();
        if (!label || label.length > 40) {
            label = element.attr('data-id') ? 'Field #' + element.attr('data-id') : 'Data';
        }
        return label;
    }

    function reset_done(step, args) {
        // remove all class done
        $(".stepper-list").removeClass("done");
        for (let i = step; i > 0; i--) {
            $(`#li_step_${i}`).addClass("done");
        }

        // trigger a clicked when li clicked
        var children = $(args).children('a');
        children[0].click()
    }

    var error = 0;

    var checking_active = function() {
        $('.active .autosave').each(function() {
            var is_required = $(this).attr('required');
            if (is_required) {
                if ($(this).val() == '' || $(this).val() == null) {
                    error++;
                }
            }
        });
    }

    var element_error = 0;
    var list_tab_element_error = [];
    var checking_all_tab = function() {
        $('.tab-pane .autosave').each(function() {
            var is_required = $(this).attr('required');
            if (is_required) {
                if ($(this).val() == '' || $(this).val() == null) {
                    element_error++;
                    let current_tab_id = $(this).closest('.tab-pane').attr('id');
                    var elemen = $('[aria-controls="' + current_tab_id + '"]').click();
                    var tab_title = elemen.text().trim();
                    list_tab_element_error.push(tab_title);
                }
            }
        });
    }

    function current_tab_url()
    {
        let current_url = window.location.href;
        
        if (!/#step_\d+$/.test(current_url)) {
            return undefined;
        }

        return current_url.substring(current_url.indexOf("#"));
    }


    $(document).ready(function() {
        setTimeout(function(){
            if (current_tab_url() == undefined) {
                $(".tabs").find('a:first').trigger('click');
            }
        });
        $(document).on('change', 'select.form-control, input.form-control, input.autosave, select.select2, select.autosave, textarea.autosave, textarea.form-control', function() {
            let currentElement = $(this);

            let is_required = false;
            if ($(this).prop('required')) {
                is_required = true;
            }

            if (currentElement.is('input') && is_required) {
                let not_allowed_input_value = [null, '', undefined];
                if (not_allowed_input_value.includes($(this).val())) {
                    const has_warning = $(this).closest('div').find('p.text-required');
                    if (has_warning.length == 0) {
                        $(this).closest('div').append('<p class="text-required text-danger">This field is required</p>');
                        $(this).focus();
                    }
                } else {
                    $(this).closest('div').find('.text-required').remove();
                }
            } else if (currentElement.is('select') && is_required) {
                
                let first_value = $(this).find("option:first").val();
                
                if ($(this).val() == '' || $(this).val() == null) {
                    const has_warning = $(this).closest('div').find('p.text-required');
                    if (has_warning.length == 0) {
                        $(this).closest('div').append('<p class="text-required text-danger">This field is required</p>');
                        $(this).focus();
                    }
                } else {
                    $(this).closest('div').find('.text-required').remove();
                }

            } else if (currentElement.is('textarea') && is_required) {
                let invalid_values = [null, ''];
                if (invalid_values.includes($(this).val())) {
                    const has_warning = $(this).closest('div').find('p.text-required');
                    if (has_warning.length == 0) {
                        $(this).closest('div').append('<p class="text-required text-danger">This field is required</p>');
                        $(this).focus();
                    }
                } else {
                    $(this).closest('div').find('.text-required').remove();
                }
            }
        });


        $(".select_multiselect").select2();
        $(".datetime").datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            autoclose: true,
        });
        $(".select2").on('select2:close', function() {
            $(this).trigger('blur');
        });
        $(".select2-country").on('select2:select', function() {
            $(this).attr('data-value', $(this).val());
            $(this).trigger('blur');
            let key_of_unique = $(this).data('select_key_country');
            $(".select2-state[data-select_key_country='" + key_of_unique + "']").val(null).trigger('change').trigger('blur');
            $(".select2-city[data-select_key_country='" + key_of_unique + "']").val(null).trigger('change').trigger('blur');
        });
        $(".select2-state").on('select2:select', function() {
            $(this).attr('data-value', $(this).val());
            $(this).trigger('blur');
            let key_of_unique = $(this).data('select_key_country');
            $(".select2-city[data-select_key_country='" + key_of_unique + "']").val(null).trigger('change').trigger('blur');
        });
        $(".select2-city").on('select2:select', function() {
            $(this).trigger('blur');
        });
        $(".select2-parent-field-of-study").on('select2:select', function() {
            let current_value = $(this).select2('data')[0].text;
            if (current_value == 'Other' || current_value == 'Lainnya') {
                let other_input_element = $(this).closest('div').find(".text-have-other");
                other_input_element.show();
            }
            
            $(this).trigger('blur');
            let key_of_unique = $(this).data('select_key_state_of_study');
            $(".select2-field-of-study[data-select_key_state_of_study='" + key_of_unique + "']").val(null).trigger('change').trigger('blur');
        });
        $(".select2-field-of-study").on('select2:select', function() {
            let current_value = $(this).select2('data')[0].text;
            if (current_value == 'Other' || current_value == 'Lainnya') {
                let other_input_element = $(this).closest('div').find(".text-have-other");
                other_input_element.show();
            }
            
            $(this).trigger('blur');
        });

        $(document).on('click', '.upload-button', async function() {
            
            var data_value = $(this).data('file-value');
            var fileview = $(this).closest('.col-lg-4').find('.fileview');
            var icon = $(this).closest('.col-lg-4').find('.submission-spinner');
            var fileviewFull = $(this).closest('.item-sub').find('.fileview');
            var base_url = "<?= base_url() ?>";

            // trigger click to closest type file
            $('.' + data_value).click();

            // add event when file has choosen
            $('.' + data_value).off('change').on('change', function(e) {
                const elThis = $(this)
                // define variable name
                var question_id = $(this).data('id');
                var multiple_id = $(this).data('multiple-id');
                var multiple_step_id = $(this).data('multiple-step-id');
                var fileName = '';
                var sizeFile = 0;
                if (e.target.files && e.target.files.length > 0) {
                    fileName = e.target.files[0].name;
                    sizeFile = e.target.files[0].size;
                }
                var maxSize = 5 * 1024 * 1024;
                if(sizeFile > maxSize){
                    Swal.fire({
                        icon: "error",
                        title: "Failed to upload the file. Please make sure the data is below 5Mb",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    return false
                }

                $(this).removeAttr('required');
                error = 0;
                checking_active();

                // set filename into label
                var substrFileName = fileName;
                if (substrFileName.length > 15) {
                    substrFileName = substrFileName.substring(0, 15) + '....';
                }
                const barLeft = $(this).closest('.item-sub').find('.bar-left');
                barLeft.html(`<svg class="icon-svg file-icon" viewBox="0 0 24 24"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg><div><span class="file-name-text">${fileName}</span></div>`);

                // icon.css('display', 'block')
                $("#progress-dialog-upload").modal('show');

                // define value form data
                var formData = new FormData();
                formData.append("file", e.target.files[0]);
                formData.append("question_id", question_id),
                formData.append("application_id", application_id),
                formData.append("fiscal_year_id", fiscal_year_id),
                formData.append("multiple_file_id", multiple_id),
                formData.append("multiple_step_id", multiple_step_id),
                formData.append("user_det_id", user_id),

                // autosave
                $.ajax({
                    url: "<?= base_url(); ?>det/application/save_fields",
                    type: 'POST',
                    data: formData, // The form with the file inputs.
                    // dataType: 'JSON',
                    processData: false,
                    contentType: false // Using FormData, no need to process data.
                }).done(function(r) {
                    var postsjson = $.parseJSON(r);
                    if(postsjson.success){

                        if(postsjson.redirect){
                            window.location.href = postsjson.redirect;
                            return false
                        }
                        
                        fileviewFull.removeClass("hide");
                        fileviewFull.attr("href", base_url + postsjson.filepath);
                        // icon.css("display", "none");
                        $(".btn-download" + question_id).attr("href", base_url + postsjson.filepath);
                        $(".btn-delete" + question_id).removeClass("hide");
                        $(".btn-download" + question_id).removeClass("hide");
                        if (error == 0) {
                            $(".next, .submit-submission").removeClass("disabled");
                        } else {
                            // $(".next, .submit-submission").addClass("disabled");
                        }
    
                        // Dapatkan nilai onclick saat ini
                        var currentOnclick = $(".btn-delete" + question_id).attr('onclick');
                        if (currentOnclick && postsjson?.submission_id) {
                            var newOnclick = currentOnclick.replace(/'subid'/g, postsjson.submission_id);
                            $(".btn-delete" + question_id).attr('onclick', newOnclick);
                        }
                        Swal.fire({
                            icon: "success",
                            title: "Successfully upload the file",
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }else{
                        console.log(postsjson.message)
                        // Swal.fire({
                        //     icon: "error",
                        //     title: postsjson.message,
                        //     showConfirmButton: false,
                        //     timer: 2000
                        // });
                    }
                })
                .fail(function() {
                    Swal.fire({
                        icon: "error",
                        title: "Failed to upload the file. Please make sure the data is below 5Mb",
                        showConfirmButton: false,
                        timer: 2000
                    });
                });

                $(this).val('');
                $("#progress-dialog-upload").modal('hide')
            })
        });

        var is_submit = false;
        $(".submit-submission").click(async function(e) {
            e.preventDefault();
            is_submit = true;
            let first_invalid_tab = '';
            $(".panel-question").each(function() {
                let valid = validate_all_input($(this).attr('id'));
                if (!valid && first_invalid_tab == '') {
                    first_invalid_tab = $(this).attr('id');
                }
            });

            if (first_invalid_tab != '') {
                validate_all_input(first_invalid_tab);
                Swal.fire({
                    title: "Incomplete Input",
                    text: "Kindly complete this section with the required details",
                    icon: "warning",
                    customClass: 'swal-custom'
                });
                return false;
            }
            
            Swal.fire({
                title: "Are you sure to submit?",
                text: "Your submission will be processed. Please ensure your data is correct.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, submit",
                customClass: 'swal-custom'
                }).then((result) => {
                if (result.isConfirmed) {
                    $("#" + $(this).data('submit')).submit();
                    Swal.fire({
                        title: "Success",
                        text: "Your Application hasbeen submited we'll be in touch shortly!",
                        icon: "success",
                        timer: 10000,
                        timerProgressBar: true,
                        customClass: 'swal-custom',
                        didOpen: () => {
                            Swal.showLoading();
                            const timer = Swal.getPopup().querySelector("b");
                            timerInterval = setInterval(() => {
                            timer.textContent = `${Swal.getTimerLeft()}`;
                            }, 100);
                        },
                        willClose: () => {
                            clearInterval(timerInterval);
                        }
                        }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                            // $("#" + $(this).data('submit')).submit();
                        }
                    });
                    
                } else {
                    default_active_tab();
                }
            });

        });

        $(".save-submission").click(function() {
            var $saveBtn = $(this);
            var $submitBtn = $(".submit-submission");

            $saveBtn.addClass('disabled').css('pointer-events', 'none');
            $submitBtn.addClass('disabled').css('pointer-events', 'none');

            var activeTab = $('.tab-pane.active');
            var autosaveFields = activeTab.find('.autosave');
            var count = autosaveFields.length;

            setTimeout(function() {
                SaveToast.fire({icon: 'success', title: 'All data has been saved'});
                $saveBtn.html('<i class="fa fa-check-circle"></i> Saved').removeClass('disabled').css('pointer-events', '');
                $submitBtn.removeClass('disabled').css('pointer-events', '');
                setTimeout(function() {
                    $saveBtn.text('Save');
                }, 3000);
            }, 500);
        });

        function readable_list(values) {
            if (!Array.isArray(values)) {
                console.error('Input harus berupa array.');
                return;
            }

            if (values.length === 0) {
                console.warn('Array kolom kosong.');
                return;
            }

            if (values.length === 1) {
                return values[0];
            }

            var result = values.slice(0, -1).join(', ') + ' & ' + values.slice(-1);
            return result;
        }

        $('.datepicker').change(function() {
            $(this).blur();
        });
        
        $('input[type="checkbox"]').on('change', function() {
            let is_parent = $(this).data('is_parent');
            let max_parent_can_checked = $(this).data('parent_checkbox_limit');
            let parent_group_id = $(this).data('parent_group_id');
            let field_id = $(this).data('id');
            let parent_id = $(this).data('parent');
            var parent = $('input[type="checkbox"][data-id="' + parent_id + '"]');
            var sub_checkbox_limit = 0;
            if (parent != undefined && parent.length == 1) {
                parent.each(function(){
                    sub_checkbox_limit = $(this).data('sub_checkbox_limit');
                });
            }
            
            let child_checkboxes = $('[data-parent="' + field_id + '"]');
            
            if ($(this).is(':checked')) {
                child_checkboxes.each(function() {
                    $(this).removeClass('hide');
                });
            } else {
                child_checkboxes.each(function() {
                    $(this).addClass('hide');
                });

                let sub_child_checkboxes = $('input[type="checkbox"][data-parent="' + field_id + '"]');
                sub_child_checkboxes.each(function(){
                    $(this).prop('checked', false);
                    $(this).trigger('blur');

                    let sub_field_id = $(this).data('id');
                    
                    let sub_parent_checkboxes = $('[data-parent="' + sub_field_id + '"]');
                    sub_parent_checkboxes.each(function() {
                        $(this).addClass('hide');
                    });

                    let sub_child_checkboxes_inner = $('input[type="checkbox"][data-parent="' + sub_field_id + '"]');
                    sub_child_checkboxes_inner.each(function(){
                        $(this).prop('checked', false);
                        $(this).trigger('blur');
                    });
                });
            }

            let current_checkboxes = $('input[type="checkbox"][data-parent="' + parent_id + '"]');
            let checked_count = 0;
            let unchecked_checkboxes = [];

            current_checkboxes.each(function(){
                let is_checked = $(this).is(':checked');
                if (is_checked) {
                    checked_count++;
                } else {
                    unchecked_checkboxes.push($(this));
                }
            });

            if (sub_checkbox_limit != 0 && checked_count >= sub_checkbox_limit) {
                unchecked_checkboxes.forEach(function(checkbox){
                    checkbox.prop('disabled', true);
                });
            } else {
                unchecked_checkboxes.forEach(function(checkbox){
                    checkbox.prop('disabled', false);
                });
            }

            if (is_parent == 1) {
                let parent_checkboxes = $('input[type="checkbox"][data-is_parent="1"]');
                var parent_checked_count = 0;
                var parent_unchecked_checkboxes = [];
                
                parent_checkboxes.each(function(){
                    if ($(this).data('parent_group_id') == parent_group_id) {
                        let is_checked = $(this).is(':checked');
                        if (is_checked) {
                            parent_checked_count++;
                        } else {
                            parent_unchecked_checkboxes.push($(this));
                        }
                    }
                });

                if (parent_checked_count >= max_parent_can_checked && max_parent_can_checked > 0) {
                    parent_unchecked_checkboxes.forEach(function(checkbox){
                        checkbox.prop('disabled', true);
                    });
                } else {
                    parent_unchecked_checkboxes.forEach(function(checkbox){
                        checkbox.prop('disabled', false);
                    });
                }
            }

            if ($(this).is(':checked')) {
                $('.checkbox-input-' + field_id).prop('disabled', false);
            } else {
                $('.checkbox-input-' + field_id).prop('disabled', true).val('');
            }
        });

        $('input[type="checkbox"]').each(function(){
            let is_parent = $(this).data('is_parent');
            let max_parent_can_checked = $(this).data('parent_checkbox_limit');
            let parent_group_id = $(this).data('parent_group_id');
            let field_id = $(this).data('id');
            let parent_id = $(this).data('parent');
            var parent = $('input[type="checkbox"][data-id="' + parent_id + '"]');
            var sub_checkbox_limit = 0;
            if (parent != undefined && parent.length == 1) {
                parent.each(function(){
                    sub_checkbox_limit = $(this).data('sub_checkbox_limit');
                });
            }
            
            let child_checkboxes = $('[data-parent="' + field_id + '"]');
            
            if ($(this).is(':checked')) {
                child_checkboxes.each(function() {
                    $(this).removeClass('hide');
                });
            } else {
                child_checkboxes.each(function() {
                    $(this).addClass('hide');
                });

                let sub_child_checkboxes = $('input[type="checkbox"][data-parent="' + field_id + '"]');
                sub_child_checkboxes.each(function(){
                    $(this).prop('checked', false);
                    $(this).trigger('blur');

                    let sub_field_id = $(this).data('id');
                    
                    let sub_parent_checkboxes = $('[data-parent="' + sub_field_id + '"]');
                    sub_parent_checkboxes.each(function() {
                        $(this).addClass('hide');
                    });

                    let sub_child_checkboxes_inner = $('input[type="checkbox"][data-parent="' + sub_field_id + '"]');
                    sub_child_checkboxes_inner.each(function(){
                        $(this).prop('checked', false);
                        $(this).trigger('blur');
                    });
                });
            }
        
            

            if (is_parent == 1) {
                let parent_checkboxes = $('input[type="checkbox"][data-is_parent="1"]');
                var parent_checked_count = 0;
                var parent_unchecked_checkboxes = [];
                
                parent_checkboxes.each(function(){
                    if ($(this).data('parent_group_id') == parent_group_id) {
                        let is_checked = $(this).is(':checked');
                        if (is_checked) {
                            parent_checked_count++;
                        } else {
                            parent_unchecked_checkboxes.push($(this));
                        }
                    }
                });
                
                if (parent_checked_count >= max_parent_can_checked && max_parent_can_checked > 0) {
                    parent_unchecked_checkboxes.forEach(function(checkbox){
                        checkbox.prop('disabled', true);
                    });
                } else {
                    parent_unchecked_checkboxes.forEach(function(checkbox){
                        <?php if (isset($show_note_period) && $show_note_period) { ?>
                            $(this).prop('disabled', true);
                            $('.autosave-other-checkbox-input').prop('disabled', true);
                        <?php } else { ?>
                            checkbox.prop('disabled', false);
                        <?php }?>
                    });
                }
            } else {
                let checked_count = 0;
                let unchecked_checkboxes = [];
                let current_checkboxes = $('input[type="checkbox"][data-parent="' + parent_id + '"]');
                if (current_checkboxes.length > 0) {
                    current_checkboxes.each(function(){
                        let is_checked = $(this).is(':checked');
                        if (is_checked) {
                            checked_count++;
                        } else {
                            unchecked_checkboxes.push($(this));
                        }
                    });

                    if (sub_checkbox_limit != 0 && checked_count >= sub_checkbox_limit) {
                        unchecked_checkboxes.forEach(function(checkbox){
                            checkbox.prop('disabled', true);
                        });
                    } else {
                        unchecked_checkboxes.forEach(function(checkbox){
                            <?php if (isset($show_note_period) && $show_note_period) { ?>
                                $(this).prop('disabled', true);
                                $('.autosave-other-checkbox-input').prop('disabled', true);
                            <?php } else { ?>
                                checkbox.prop('disabled', false);
                            <?php }?>
                        });
                    }
                }
            }

            if ($(this).is(':checked')) {
                $('.checkbox-input-' + field_id).prop('disabled', false);
            } else {
                $('.checkbox-input-' + field_id).prop('disabled', true).val('');
            }
        });

        $(document).on("blur", ".autosave", async function() {
            var element = $(this);
            var data_value = $(this).val();
            var question_id = $(this).data('id');
            var is_required = $(this).attr("required");
            var group_element_id = $(this).data("index");
            var is_advanced_checkbox = element.data('is_advanced_checkbox');

            // add logic for checkbox non advanced checkbox
            if (is_advanced_checkbox != 1) {
                if ($(this).is(':checkbox')) {
                    data_value = [];
                    $.each($(`input:checkbox.check-${question_id}:checked`), function() {
                        data_value.push($(this).val())
                    })
                }

                // add logic for multiple choice grid 
                if ($(this).hasClass('multiple-choice-grid')) {
                    data_value = [];
                    $.each($(`.table_${question_id} input:radio.multiple-choice-grid:checked`), function() {
                        data_value.push($(this).val())
                    })
                }
            } else {
                data_value = [];
                data_value.push($(this).val());
                if (!element.is(':checked')) {
                    data_value = null; 
                }
            }

            error = 0;
            checking_active();

            if (error == 0) {
                $(".next, .submit-submission").removeClass("disabled");
            } else {
                // $(".next, .submit-submission").addClass("disabled");
            }

            // check if other value
            var data = {
                user_det_id: user_id,
                value: data_value,
                question_id: question_id,
                application_id: application_id,
                fiscal_year_id: fiscal_year_id,
                group_element_id: group_element_id,
                is_other: false
            };
            if ($(this).hasClass('text-have-other')) {
                data['is_other'] = true;
            }
            
            $.ajax({
                    url: "<?= base_url(); ?>det/application/save_fields",
                    method: "POST",
                    dataType: "JSON",
                    data: data
                })
                .success(function(data) {
                    if (data.success == false) {
                        $(element).nextAll().remove();
                        var appendData = $("<p></p>").text(data.message).css("color", "red");
                        $(element).after(appendData);
                    } else {
                        // SaveToast.fire({icon: 'success', title: 'Saved'});
                        // updateLastSaved(getFieldLabel(element));
                    }
                })
        });

        $(".autosave-other-checkbox-input").blur(async function(){
            // if(active_country == 1){
            //     let isChanged = await checkActiveGrant();
            //     if (isChanged === false || isChanged === undefined) {
            //         return false;
            //     }
            // }
            var element = $(this);
            var data_value = $(this).val();
            var question_id = $(this).data('id');
            var is_required = $(this).attr("required");
            var group_element_id = $(this).data("index");
            var step_id = $(this).data('step');
            var category_id = $(this).data('category-id');
            var grant_id = $(this).data('grant-id');
            var period_id = $(this).data('period-id');
            var grantee_grant_id = $("#grantee_grant_id").val();
            var user_grantee_id = $("#grantee_id").val();

            // check if other value
            var data = {
                user_det_id: user_id,
                value: data_value,
                question_id: question_id,
                application_id: application_id,
                fiscal_year_id: fiscal_year_id,
                group_element_id: group_element_id,
                is_other: false
            };

            $.ajax({
                url: "<?= base_url(); ?>det/application/save_fields_checkbox",
                method: "POST",
                dataType: "JSON",
                data: data
            })
            .success(function(data){
                if (data.success == false){
                    $(element).nextAll().remove();
                    var appendData = $("<p></p>").text(data.message).css("color", "red");
                    $(element).after(appendData);
                } else {
                    // SaveToast.fire({icon: 'success', title: 'Saved'});
                    // updateLastSaved(getFieldLabel(element));
                }
            })
        });

        $('.checkbox-additional-input').each(function() {
            const $input = $(this);
            const $span = $('<span>').css({
                visibility: 'hidden',
                position: 'absolute', 
                whiteSpace: 'pre',
                font: $input.css('font'),
            }).appendTo('body');

            function resize() {
                const text = $input.val() || $input.attr('placeholder') || '';
                if (text) {
                    $span.text(text);
                    $input.width(Math.max($span.width() + 50, 150)); 
                } else {
                    $input.width(150);
                }
            }

            $input.on('input', resize);
            resize(); 
        });

        $(".next").click(function() {
            const current_tab = $(this).closest('.tab-pane');

            validate_all_input(current_tab.attr('id'));

            var selected = $(".tabs").tabs("option", "active");
            var data = $(this).data('index');
            $("#" + data).addClass("active in");
            $(".tabs").tabs("option", "active", selected + 1);
            location.hash = "#" + data;

            const last_element = $('.tab-content').children().last();
            const before_last_element = last_element.prev();
        });

        $(".previous").on("click",function() {
            if (is_submit) {
                is_submit = false;
                return false;
            }
            let selected = $(".tabs").tabs("option", "active");
            var data = $(this).data('index');
            $("#" + data).addClass("active in");
            $(".tabs").tabs("option", "active", selected - 1);
            location.hash = "#" + data;
        });

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
            var isLimit = $(this).data('limit');
            let limitType = $(this).data('limittype');
            let minlen = parseInt($(this).data('minlength')) || 0;
            let maxlen = parseInt($(this).data('maxlength')) || Infinity;
            let value = $(this).val().trim();

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

                if(isLimit){
                    $('.hint').text('')
                    if (limitType === 'Word') {
                        let words = value.split(/\s+/).filter(w => w !== '');
                        let wordCount = words.length;
    
                        if (wordCount < minlen) {
                            validated = false;
                            $(this).closest('div').append('<p class="text-required text-danger">Min ' + minlen + ' words required</p>');
                            $(this).focus();
                            return;
                        }
    
                        if (wordCount > maxlen) {
                            validated = false;
                            $(this).closest('div').append('<p class="text-required text-danger">Maximum ' + maxlen + ' words allowed</p>');
                            $(this).focus();
                            return;
                        }
                    } else if (limitType === 'Character') {
                        let charCount = value.length;
    
                        if (charCount < minlen) {
                            validated = false;
                            $(this).closest('div').append('<p class="text-required text-danger">Min ' + minlen + ' characters required</p>');
                            $(this).focus();
                            return;
                        }
    
                        if (charCount > maxlen) {
                            validated = false;
                            $(this).closest('div').append('<p class="text-required text-danger">Maximum ' + maxlen + ' characters allowed</p>');
                            $(this).focus();
                            return;
                        }
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
            let input = $(this).data('group');
            
            if (input == undefined) {
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
        
        // $("#" + tab).find("input[type=checkbox]").each(function() {
        //     let group = $(this).data('type-group');
            
        //     if (group != 'radio') {
        //         let invalid_values = [null, ''];
        //         let is_required = false;
        //         if ($(this).prop('required')) {
        //             is_required = true;
        //         }

        //         console.log(is_required);
        //         if ($(this).val() != '' && is_required) {
        //             const has_warning = $(this).closest('div').find('p');
        //             if (has_warning.length == 0) {
        //                 validated = false;
        //                 $(this).closest('div').append('<p class="text-required text-danger">This field is required</p>');
        //                 $(this).focus();
        //             }
        //         }
        //     }
        // });
        
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
            radio_group_elements.each(function(){
                let current_element = $(this);
                if (current_element.data('element') == selected_radio_element.data('show')) {
                    let input_elements = current_element.find('input');
                    input_elements.each(function(){
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
                    select_elements.each(function(){
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
                    textarea_elements.each(function(){
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

    function navigate_tab(step) {
        if (typeof step === 'number') {
            step = 'step_' + step;
        }
        $("#" + step).addClass("active in");
        
        location.hash = "#" + step;
        var selected = $(".tabs").tabs("option", "active");
        $(".tabs").tabs("option", "active", selected);
    }

    function show_preview(element, type) {
        const file = element.files[0];
        var fileSize = file.size;
        var maxSize = 5 * 1024 * 1024;
        if (file) {
            let filename = file.name;
            let ext = filename.split('.').pop();

            const allowed_extensions = ['gif', 'jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx', 'xsl', 'xlsx'];

            const is_valid_extension = allowed_extensions.some(function(extension) {
                return ext.toLowerCase().endsWith(extension);
            });


            let pdf_icon = '<?php echo base_url('assets/images/icons/pdf.svg'); ?>';
            let download_icon = '<?php echo base_url('assets/images/icons/download icon.png'); ?>';

            if((fileSize < maxSize) && is_valid_extension){
                if (ext == 'jpg' || ext == 'png' || ext == 'jpeg') {
                    let reader = new FileReader();
                    reader.onload = function(event) {
                        $('#preview_image_' + type).attr('src', event.target.result);
                        $('#preview_image_' + type).attr('height', 100);
                        $('#preview_image_' + type).css('margin-top', "-5px");
                    }

                    reader.readAsDataURL(file);
                } else if (ext == 'pdf' && active_country == 1) {
                    let readerText = new FileReader();
                    readerText.onload = function(event) {
                        var fileContent = event.target.result;
                        if (fileContent.includes('/Encrypt')) {
                            $(element).val('');
                        }else{
                            $('#preview_image_' + type).attr('src', pdf_icon);
                        }
                    }
                    readerText.readAsText(file.slice(0, 50000));
                } else {
                    $('#preview_image_' + type).attr('src', download_icon);
                }
            }else{
                $(element).val(''); // Hapus file yang dipilih
            }
        }
    }

    function add_file(button_id) {
        $("#" + button_id).trigger('click');
    }

    async function add_more_submission(element, is_multiple = false) {
        var custom_field_id = $(element).data("id");
        var label = $(element).data('label');
        var step_id = $(element).data('step');
        var category_id = $(element).data('category-id');
        var grant_id = $(element).data('grant-id');
        var period_id = $(element).data('period-id');
        var category_type = $(element).data('category-type');
        var multiple_step_id = $(element).data('multiple-step-id');
        var type = $(element).data('type');
        var max_multiple = $(element).data("max_multiple") ? $(element).data("max_multiple") : 0;
        const multiple_step = $('.multiple-cf-' + custom_field_id + multiple_step_id);
        
        if(max_multiple){
            if(multiple_step.length >=  max_multiple){
                showSwal('warning', 'You have reached the maximum number of allowed entries.', false, true, 2500);
                return false
            }
        }
        $(".add-multiple-file-spinner-" + custom_field_id).show();

        var formData = new FormData();
            formData.append("label", label),
            formData.append("question_id", question_id),
            formData.append("application_id", application_id),
            formData.append("fiscal_year_id", fiscal_year_id),
            formData.append("multiple_file_id", multiple_id),
            formData.append("multiple_step_id", multiple_step_id),
            formData.append("group_element_id", group_element_id),
            formData.append("user_det_id", user_id),
            
            $.ajax({
                url: "<?= base_url(); ?>det/application/multiple_file",
                type: 'POST',
                data: formData, // The form with the file inputs.
                processData: false,
                contentType: false // Using FormData, no need to process data.
            }).done(function(r) {
                if (is_multiple) {
                    $(".wrap-file-step-" + custom_field_id).append(r);
                    $(".add-multiple-file-spinner-" + custom_field_id).hide();
                } else {
                    $(".wrap-file-" + custom_field_id).append(r);
                    $(".add-multiple-file-spinner-" + custom_field_id).hide();
                }
                initSelect2(r);
                $('.lightbox').topbox();

                // for radio group purpose
                $(".radio-group").click(function() {
                    var get_parent_id = $(this).closest('div').attr('id');
                    var data_show = $(this).data('show');
                    // hide other than this class 
                    $("#" + get_parent_id + " .show-group[data-element!='" + data_show + "']").addClass('hide');
                    $("#" + get_parent_id + " .show-group[data-element='" + data_show + "']").removeClass('hide');
                });

                $("input:radio.radio-group:checked").trigger("click");
                $(".select_multiselect").select2();
                $(".have_other").change(function() {
                    if ($(this).is('input[type="checkbox"]')) {
                        if ($(this).is(':checked') && $(this).val() == 'Other') {
                            $(".text-other-" + $(this).data('show')).show();
                        } else if (!$(this).is(':checked') && $(this).val() == 'Other') {
                            $(".text-other-" + $(this).data('show')).hide();
                        }
                    } else {
                        if (Array.isArray($(this).val())) {
                            if ($(this).val().includes("Other")) {
                                $(".text-other-" + $(this).data('show')).show();
                            } else {
                                $(".text-other-" + $(this).data('show')).hide();
                            }
                        } else {
                            // show other
                            if ($(this).val() == 'Other') {
                                $(".text-other-" + $(this).data('show')).show();
                            } else {
                                $(".text-other-" + $(this).data('show')).hide();
                            }
                        }
                    }
                });
                $(".datetime").datetimepicker({
                    format: 'yyyy-mm-dd hh:ii',
                    autoclose: true,
                });
                $(".datepicker").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: "dd M yy",
                    yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
                });
                let country_tag = $(r).find(".select2-country");
                let elemet_id_country = country_tag.data('multiple-step-id');
                if (elemet_id_country) {
                    $('.select2-country_' + elemet_id_country).select2({
                        placeholder: "Select a country",
                    });
                    $('.select2-country_' + elemet_id_country).on('select2:select', function() {
                        $(this).attr('data-value', $(this).val());
                        $(this).trigger('blur');
                        let key_of_unique = $(this).data('select_key_country');
                        $(".select2-state[data-select_key_country='" + key_of_unique + "']").val(null).trigger('change').trigger('blur');
                        $(".select2-city[data-select_key_country='" + key_of_unique + "']").val(null).trigger('change').trigger('blur');
                    });
                }

                let state_tag = $(r).find(".select2-state");
                let elemet_id_state = state_tag.data('multiple-step-id');
                if (elemet_id_state) {
                    $('.select2-state_' + elemet_id_state).select2({
                        placeholder: "Select a state",
                        ajax: {
                            url: function(params) {
                                let key_of_unique = $(this).data('select_key_country');
                                let country_id = $(".select2-country[data-select_key_country='" + key_of_unique + "']").val();
                                return '<?php echo site_url('world/data_state') ?>' + (country_id ? '/' + country_id : '');
                            },
                            dataType: 'json'
                        }
                    });
                    $('.select2-state_' + elemet_id_state).on('select2:select', function() {
                        $(this).attr('data-value', $(this).val());
                        $(this).trigger('blur');
                        let key_of_unique = $(this).data('select_key_country');
                        $(".select2-city[data-select_key_country='" + key_of_unique + "']").val(null).trigger('change').trigger('blur');
                    });
                }

                let city_tag = $(r).find(".select2-city");
                let elemet_id_city = city_tag.data('multiple-step-id');
                if (elemet_id_city) {
                    $('.select2-city_' + elemet_id_city).select2({
                        placeholder: "Select a city",
                        ajax: {
                            url: function(params) {
                                let key_of_unique = $(this).data('select_key_country');
                                let state_id = $(".select2-state[data-select_key_country='" + key_of_unique + "']").val();
                                return '<?php echo site_url('world/data_city') ?>' + (state_id ? '/' + state_id : '');
                            },
                            dataType: 'json'
                        }
                    });
                    $('.select2-city_' + elemet_id_city).on('select2:select', function() {
                        $(this).trigger('blur');
                    });
                }

                let parent_study_tag = $(r).find(".select2-parent-field-of-study");
                let parent_study_id = parent_study_tag.data('multiple-step-id');
                if (parent_study_id) {
                    $('.select2-parent-field-of-study_' + parent_study_id).select2({
                        placeholder: "Select Field of Study",
                    });
                    $('.select2-parent-field-of-study_' + parent_study_id).on('select2:select', function() {
                        $(this).trigger('blur');
                        let key_of_unique = $(this).data('select_key_state_of_study');
                        $(".select2-field-of-study[data-select_key_state_of_study='" + key_of_unique + "']").val(null).trigger('change').trigger('blur');
                    });
                }

                let study_tag = $(r).find(".select2-field-of-study");
                let study_id = study_tag.data('multiple-step-id');
                if (study_id) {
                    $('.select2-field-of-study_' + study_id).select2({
                        placeholder: "Select Specialization",
                        ajax: {
                            url: function(params) {
                                let key_of_unique = $(this).data('select_key_state_of_study');
                                let parent_id = $(".select2-parent-field-of-study[data-select_key_state_of_study='" + key_of_unique + "']").val();
                                return '<?php echo site_url('world/field_of_study') ?>' + (parent_id ? '/' + parent_id : '');
                            },
                            dataType: 'json'
                        }
                    });
                    $('.select2-field-of-study_' + study_id).on('select2:select', function() {
                        $(this).trigger('blur');
                    });
                }
            });
    }

    async function add_more_submission_radio_group(element, is_multiple = false) {
        // if(active_country == 1){
        //     let isChanged = await checkActiveGrant();
        //     if (isChanged === false || isChanged === undefined) {
        //         return false;
        //     }
        // }
        var custom_field_id = $(element).data("id");
        var label = $(element).data('label');
        var multiple_step_id = $(element).data('multiple-step-id');
        var type = $(element).data('type');
        var data_element = $(element).data('element');
        var data_element_option = $(element).data('element-option');
        $(".add-multiple-file-spinner-" + custom_field_id).show();

        var formData = new FormData();
            formData.append("label", label),
            formData.append("user_grantee_step_id", step_id),
            formData.append("user_grantee_category_id", category_id),
            formData.append("user_grantee_grant_id", grant_id),
            formData.append("user_grantee_period_id", period_id),
            formData.append("custom_field_id", custom_field_id),
            formData.append("user_grantee_category_type", category_type),
            formData.append("is_multiple", is_multiple),
            formData.append("multiple_step_id", multiple_step_id),
            formData.append("type", type),
            formData.append("data_element_option", data_element_option),

            $.ajax({
                url: "<?= base_url(); ?>det/application/multiple_file_radio",
                type: 'POST',
                data: formData, // The form with the file inputs.
                processData: false,
                contentType: false // Using FormData, no need to process data.
            }).done(function(r) {
                if (is_multiple) {
                    $(".wrap-file-step-radio" + data_element).append(r);
                    $(".add-multiple-file-spinner-" + data_element).hide();
                } else {
                    $(".wrap-file-radio-" + data_element).append(r);
                    $(".add-multiple-file-spinner-" + data_element).hide();
                }
                $('.lightbox').topbox();

                // for radio group purpose
                $(".radio-group").click(function() {
                    var get_parent_id = $(this).closest('div').attr('id');
                    var data_show = $(this).data('show');
                    // hide other than this class 
                    $("#" + get_parent_id + " .show-group[data-element!='" + data_show + "']").addClass('hide');
                    $("#" + get_parent_id + " .show-group[data-element='" + data_show + "']").removeClass('hide');
                })

                $("input:radio.radio-group:checked").trigger("click");
                $(".select_multiselect").select2();
                $(".have_other").change(function() {
                    if ($(this).is('input[type="checkbox"]')) {
                        if ($(this).is(':checked') && $(this).val() == 'Other') {
                            $(".text-other-" + $(this).data('show')).show();
                        } else if (!$(this).is(':checked') && $(this).val() == 'Other') {
                            $(".text-other-" + $(this).data('show')).hide();
                        }
                    } else {
                        if (Array.isArray($(this).val())) {
                            if ($(this).val().includes("Other")) {
                                $(".text-other-" + $(this).data('show')).show();
                            } else {
                                $(".text-other-" + $(this).data('show')).hide();
                            }
                        } else {
                            // show other
                            if ($(this).val() == 'Other') {
                                $(".text-other-" + $(this).data('show')).show();
                            } else {
                                $(".text-other-" + $(this).data('show')).hide();
                            }
                        }
                    }
                });
                $(".datetime").datetimepicker({
                    format: 'yyyy-mm-dd hh:ii',
                    autoclose: true,
                });
                $(".datepicker").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: "dd M yy",
                    yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
                });
                let country_tag = $(r).find(".select2-country");
                let elemet_id_country = country_tag.data('multiple-id');
                if (elemet_id_country) {
                    $('.select2-country_' + elemet_id_country).select2({
                        placeholder: "Select a country",
                    });
                    $('.select2-country_' + elemet_id_country).on('select2:select', function() {
                        $(this).attr('data-value', $(this).val());
                        $(this).trigger('blur');
                        let key_of_unique = $(this).data('select_key_country');
                        $(".select2-state[data-select_key_country='" + key_of_unique + "']").val(null).trigger('change').trigger('blur');
                        $(".select2-city[data-select_key_country='" + key_of_unique + "']").val(null).trigger('change').trigger('blur');
                    });
                }

                let state_tag = $(r).find(".select2-state");
                let elemet_id_state = state_tag.data('multiple-id');
                if (elemet_id_state) {
                    $('.select2-state_' + elemet_id_state).select2({
                        placeholder: "Select a state",
                        ajax: {
                            url: function(params) {
                                let key_of_unique = $(this).data('select_key_country');
                                let country_id = $(".select2-country[data-select_key_country='" + key_of_unique + "']").val();
                                return '<?php echo site_url('world/data_state') ?>' + (country_id ? '/' + country_id : '');
                            },
                            dataType: 'json'
                        }
                    });
                    $('.select2-state_' + elemet_id_state).on('select2:select', function() {
                        $(this).attr('data-value', $(this).val());
                        $(this).trigger('blur');
                        let key_of_unique = $(this).data('select_key_country');
                        $(".select2-city[data-select_key_country='" + key_of_unique + "']").val(null).trigger('change').trigger('blur');
                    });
                }

                let city_tag = $(r).find(".select2-city");
                let elemet_id_city = city_tag.data('multiple-id');
                if (elemet_id_city) {
                    $('.select2-city_' + elemet_id_city).select2({
                        placeholder: "Select a city",
                        ajax: {
                            url: function(params) {
                                let key_of_unique = $(this).data('select_key_country');
                                let state_id = $(".select2-state[data-select_key_country='" + key_of_unique + "']").val();
                                return '<?php echo site_url('world/data_city') ?>' + (state_id ? '/' + state_id : '');
                            },
                            dataType: 'json'
                        }
                    });
                    $('.select2-city_' + elemet_id_city).on('select2:select', function() {
                        $(this).trigger('blur');
                    });
                }

                let parent_study_tag = $(r).find(".select2-parent-field-of-study");
                let parent_study_id = parent_study_tag.data('multiple-id');
                if (parent_study_id) {
                    $('.select2-parent-field-of-study_' + parent_study_id).select2({
                        placeholder: "Select Field of Study",
                    });
                    $('.select2-parent-field-of-study_' + parent_study_id).on('select2:select', function() {
                        $(this).trigger('blur');
                        let key_of_unique = $(this).data('select_key_state_of_study');
                        $(".select2-field-of-study[data-select_key_state_of_study='" + key_of_unique + "']").val(null).trigger('change').trigger('blur');
                    });
                }

                let study_tag = $(r).find(".select2-field-of-study");
                let study_id = study_tag.data('multiple-id');
                if (study_id) {
                    $('.select2-field-of-study_' + study_id).select2({
                        placeholder: "Select Specialization",
                        ajax: {
                            url: function(params) {
                                let key_of_unique = $(this).data('select_key_state_of_study');
                                let parent_id = $(".select2-parent-field-of-study[data-select_key_state_of_study='" + key_of_unique + "']").val();
                                return '<?php echo site_url('world/field_of_study') ?>' + (parent_id ? '/' + parent_id : '');
                            },
                            dataType: 'json'
                        }
                    });
                    $('.select2-field-of-study_' + study_id).on('select2:select', function() {
                        $(this).trigger('blur');
                    });
                }
            });
    }

    function del_multiple(el, item_class) {
        if (confirm("Are you sure want to delete this ?")) {
            var multiple_id = $(el).data("multiple-id");
            $(".delete-multiple-spinner-" + multiple_id).show();
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url('det/application/delete_multiple') ?>/' + multiple_id,
                dataType: 'JSON',
                success: function(r) {
                    if (r.status) {
                        $(el).closest('.' + item_class).remove();
                    }
                    $(".delete-multiple-spinner-" + multiple_id).hide();
                }
            });
        }
    }


    async function upload_button(element) {
        // if(active_country == 1){
        //     let isChanged = await checkActiveGrant();
        //     if (isChanged === false || isChanged === undefined) {
        //         return false;
        //     }
        // }
        var data_value = $(element).data('file-value');
        var fileview = $(element).closest('.col-lg-4').find('.fileview');
        var fileviewFull = $(element).closest('.is_row_class').find('.fileview');
        var icon = $(element).closest('.col-lg-4').find('.submission-spinner');
        var base_url = "<?= base_url() ?>";
        // trigger click to closest type file
        $(`.${data_value}`).click();

        // add event when file has choosen
        $(`.${data_value}`).off('change').on('change', function(e) {
            const elThis = $(this)
            // define variable name
            var question_id = $(this).data('id');
            var multiple_id = $(this).data('multiple-id');
            var multiple_step_id = $(this).data('multiple-step-id');
            var group_element_id = $(this).data("index");
            var upload_id = $(this).data("upload-id");
            var fileName = '';
            var sizeFile = 0;
            if (e.target.files && e.target.files.length > 0) {
                fileName = e.target.files[0].name;
                sizeFile = e.target.files[0].size;
            }
            var maxSize = 5 * 1024 * 1024;
            if(sizeFile > maxSize){
                Swal.fire({
                    icon: "error",
                    title: "Failed to upload the file. Please make sure the data is below 5Mb",
                    showConfirmButton: false,
                    timer: 2000
                });
                return false
            }

            $(this).removeAttr('required');
            error = 0;
            checking_active();

            // set filename into label
            var substrFileName = fileName;
            if (substrFileName.length > 15) {
                substrFileName = substrFileName.substring(0, 15) + '....';
            }
            // icon.css('display', 'block')
            $("#progress-dialog-upload").modal('show')

            // define value form data
            var formData = new FormData();
            formData.append("file", e.target.files[0]);
            formData.append("question_id", question_id),
            formData.append("application_id", application_id),
            formData.append("fiscal_year_id", fiscal_year_id),
            formData.append("multiple_file_id", multiple_id),
            formData.append("multiple_step_id", multiple_step_id),
            formData.append("group_element_id", group_element_id),
            formData.append("user_det_id", user_id),

            // autosave
            $.ajax({
                url: "<?= base_url(); ?>det/application/save_fields",
                type: 'POST',
                data: formData, // The form with the file inputs.
                // dataType: 'JSON',
                processData: false,
                contentType: false
            }).done(function(r) {
                var postsjson = $.parseJSON(r);
                if(postsjson.success){
                    if(postsjson.redirect){
                        window.location.href = postsjson.redirect;
                        return false
                    }
                    elThis.closest('.col-lg-4').find('.filename').html(substrFileName).attr('title', fileName)
                    elThis.closest('.is_row_class').find('.filename').html(substrFileName).attr('title', fileName)
                    fileview.css("display", "inline-block");
                    fileviewFull.css("display", "inline-block");
                    // icon.css("display", "none");
                    $(".btn-download" + upload_id).attr("href", base_url + postsjson.filepath);
                    fileview.attr("href", base_url + postsjson.filepath);
                    fileviewFull.attr("href", base_url + postsjson.filepath);
                    if (error == 0) {
                        $(".next, .submit-submission").removeClass("disabled");
                    } else {
                        // $(".next, .submit-submission").addClass("disabled");
                    }
    
                    // Dapatkan nilai onclick saat ini
                    var currentOnclick = $(".btn-delete" + upload_id).attr('onclick');
                    if (currentOnclick != undefined) {
                        var newOnclick = currentOnclick.replace(/'subid'/g, postsjson.submission_id);
                        $(".btn-delete" + upload_id).attr('onclick', newOnclick);
                    }
                    $(".btn-delete" + upload_id).removeClass("hide");
                    $(".btn-download" + upload_id).removeClass("hide");
                    Swal.fire({
                        icon: "success",
                        title: "Successfully upload the file",
                        showConfirmButton: false,
                        timer: 2000
                    });
                }else{
                    console.log(postsjson.message);
                    // Swal.fire({
                    //     icon: "error",
                    //     title: postsjson.message,
                    //     showConfirmButton: false,
                    //     timer: 2000
                    // });
                }
            })
            .fail(function() {
                Swal.fire({
                    icon: "error",
                    title: "Failed to upload the file. Please make sure the data is below 5Mb",
                    showConfirmButton: false,
                    timer: 2000
                });
            });

            $(this).val('');
            $("#progress-dialog-upload").modal('hide');
        })
    }
    
    async function submission_onblur(element) {
        // var element = $(this);
        // if(active_country == 1){
        //     let isChanged = await checkActiveGrant();
        //     if (isChanged === false || isChanged === undefined) {
        //         return false;
        //     }
        // }
        var data_value = element.value;
        var question_id = $(element).data('id');
        var is_required = $(element).attr("required");
        var group_element_id = $(element).data("index");

        var step_id = $(element).data('step');
        var category_id = $(element).data('category-id');
        var grant_id = $(element).data('grant-id');
        var period_id = $(element).data('period-id');
        var multiple_id = $(element).data('multiple-id');
        var multiple_step_id = $(element).data('multiple-step-id');
        var unique_id = $(element).data('unique_id');
        var is_advanced_checkbox = $(element).data('is_advanced_checkbox');

        // add logic for checkbox non advanced checkbox
        if (is_advanced_checkbox != 1) {
            if ($(element).is(':checkbox')) {
                data_value = [];
                $.each($(`input:checkbox.check-${question_id}-${multiple_id}:checked`), function() {
                    data_value.push($(this).val())
                })
            }
        } else {
            data_value = [];
            data_value.push($(this).val());
            if (!element.is(':checked')) {
                data_value = null; 
            }
        }

        $('.radio_' + unique_id).val(data_value);

        // add logic for multiple
        if ($(element).hasClass('multiple-select')) {
            data_value = $(element).val();
        }

        // add logic for multiple choice grid 
        if ($(element).hasClass('multiple-choice-grid-multi')) {
            data_value = [];
            $.each($(`.table_${question_id}_${multiple_id} input:radio.multiple-choice-grid-multi:checked`), function() {
                data_value.push($(this).val())
            })

        }

        error = 0;
        checking_active();

        if (error == 0) {
            $(".next, .submit-submission").removeClass("disabled");
        } else {
            // $(".next, .submit-submission").addClass("disabled");
        }

        // check if other value
        var data = {
            user_det_id: user_id,
            value: data_value,
            question_id: question_id,
            application_id: application_id,
            fiscal_year_id: fiscal_year_id,
            group_element_id: group_element_id,
            is_other: false
        };
        if ($(element).hasClass('text-have-other')) {
            data['is_other'] = true;
        }

        $.ajax({
                url: "<?= base_url(); ?>det/application/save_fields",
                method: "POST",
                dataType: "JSON",
                data: data
            })
            .success(function(data) {
                if (data.success == false) {
                    $(element).nextAll().remove();
                    var appendData = $("<p></p>").text(data.message).css("color", "red");
                    $(element).after(appendData);
                } else {
                    // SaveToast.fire({icon: 'success', title: 'Saved'});
                    // updateLastSaved(getFieldLabel($(element)));
                }
            })
    }

    function del_file(el, name, label, subId = '', submissionId = '') {
        if (confirm("Are you sure want to delete " + label + " ?")) {
            const loadIcon = '<img src="<?php echo base_url() ?>/img/loading.gif">';
            const btnDownload = $('.btn-download' + subId + '');
            const btnDelete = $('.btn-delete' + subId + '');
            const btnPreview = $(el).closest('.item-sub').find('.fileview');
            const barLeft = $(el).closest('.item-sub').find('.bar-left');
            Swal.showLoading();

            $.ajax({
                type: 'GET',
                url: '<?php echo base_url('det/application/delete_question_value') ?>/' + submissionId,
                dataType: 'JSON',
                success: function(r) {
                    barLeft.html(`<svg class="icon-svg" viewBox="0 0 24 24" style="color: #94a3b8; stroke-width: 1.5;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg><div><span style="color: #64748b; font-size: 13px;">No file selected yet...</span></div>`);
                    btnDownload.addClass('hide');
                    btnDelete.addClass('hide');
                    btnPreview.addClass('hide');
                    Swal.close(); 

                    if(r.is_required){
                        $(".my_file_" + subId).prop("required", true)
                    }
                    $(".my_file_" + subId).val('')
                    // $(".next, .submit-submission").addClass("disabled");
                }
            });
        }
    }
    
    function navigate_tab(id) {
        location.hash = "#step_" + id;
        
    }

    function validateTextArea(element) {
        var isLimit = $(element).data('limit');

        var limitType = $(element).data('limittype');
        var maxlen = $(element).data('maxlength');
        var minlen = $(element).data('minlength') || 0;
        var multipleId = $(element).data('multiple-id') != undefined ? String($(element).data('multiple-id')) : ''
        var multipleStepId = $(element).data('multiple-step-id') != undefined ? String($(element).data('multiple-step-id')) : ''
        var id = String($(element).data('id')) + String($(element).data('index')) + multipleId + multipleStepId;
        var text = $(element).val();
        
        if(isLimit){
            $(element).closest('div').find('p.text-required').remove()
            if (limitType === 'Character') {
                var charCount = text.length;

                if (charCount > maxlen) {
                    text = text.substring(0, maxlen);
                    $(element).val(text);
                    charCount = text.length;
                }

                if (charCount < minlen) {
                    $('#textarea_message_' + id).text('Min ' + minlen + ' characters required').addClass('text-hint');
                } else if (charCount >= minlen && charCount <= maxlen) {
                    $('#textarea_message_' + id).text((maxlen - charCount) + ' characters remaining').removeClass('text-hint');
                } else {
                    $('#textarea_message_' + id).text('Max ' + maxlen + ' characters only!').addClass('text-hint');
                }
            } else if (limitType === 'Word') {

                var words = text.split(/\s+/);
                var wordCount = words[0] === "" ? 0 : words.length;

                if (wordCount > maxlen) {
                    var trimmedWords = words.slice(0, maxlen);
                    text = trimmedWords.join(' ');
                    $(element).val(text);
                    wordCount = trimmedWords.length;
                }

                if (wordCount < minlen) {
                    $('#textarea_message_' + id).text('Min ' + minlen + ' words required').addClass('text-hint');
                } else if (wordCount >= minlen && wordCount <= maxlen) {
                    $('#textarea_message_' + id).text((maxlen - wordCount) + ' words remaining').removeClass('text-hint');
                } else {
                    $('#textarea_message_' + id).text('Max ' + maxlen + ' words only!').addClass('text-hint');
                }
            }
        }
    }

    function procced_application(user_id, application_id) {
        if (confirm("Are you sure want to Complete this ?")){
            var note = $('#note_document').val();
            $(this).html('<img src="<?php echo base_url() ?>/img/loading.gif">')
            $(".btn").attr('disabled', 'disabled');
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/submitted_det/procced_application') ?>',
                data: {
                    note    : note,
                    user_id : user_id,
                    application_id : application_id
                },
                success: function(r) {
                    if(r.err_message == false){
                        location.href=r.redirect;
                    }
                }
            });
        }

    }


    function reject_application(user_id, application_id) {
        if (confirm("Are you sure this grantee is Revise ?")){
            var note = $('#note_document').val();
            $("#btn-revise-submission").html('<img src="<?php echo base_url() ?>/img/loading.gif">')
            $(".btn").attr('disabled', 'disabled');
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/submitted_det/reject_application') ?>',
                data: {
                    note    : note,
                    user_id : user_id,
                    application_id : application_id
                },
                success: function(r) {
                    if(r.err_message == false){
                        location.href=r.redirect;
                    }
                }
            });
        }

    }
</script>