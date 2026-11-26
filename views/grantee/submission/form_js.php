<script>
    const active_country = <?= $this->session->userdata('grantee_country_id') ?>;

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
    $('.progressbar li').on('click', function() {
        // $(this).find('a').click();
    });

    function next_step(step) {
        $("#li_step_" + (step - 1)).removeClass("active");
        $("#li_step_" + (step - 1)).addClass("done");
        $("#li_step_" + step).addClass("active");
    }

    function back_step(step) {
        $("#li_step_" + (step + 1)).removeClass("active");
        $("#li_step_" + (step + 1)).removeClass("done");
        $("#li_step_" + step).addClass("active");
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

        $('.upload-button').each(function() {
            if ($(this).closest('.item-sub').find('.fileview').not('.hide').length) {
                $(this).text('Change File');
            }
        });

        $(document).on('change', '.select-education-group', function() {
            var selectedVal = $(this).val();
            var container = $(this).closest('.education-group-container');
            var visibleLevels = [];

            if (selectedVal === 'S3') {
                visibleLevels = ['S1/D4', 'S2', 'S3'];
            } else if (selectedVal === 'S2') {
                visibleLevels = ['S1/D4', 'S2'];
            } else if (selectedVal === 'S1/D4') {
                visibleLevels = ['S1/D4'];
            }

            container.find('.education-level-card').each(function() {
                var level = $(this).data('level');
                var disabled = $(this).data('disabled') ? true : false;
                var cdisabled = $(this).data('disabled') ? '#eee' : '#fff';
                var isVisible = visibleLevels.indexOf(level) !== -1;

                if (isVisible) {
                    $(this).slideDown(250);
                    $(this).find('.datepicker').css('background-color', cdisabled);
                    $(this).find('input, select, textarea').not('.choosefile[type=file]').prop('disabled', disabled);
                    $(this).find('input.choosefile[type=file]').prop('disabled', disabled).attr('required', 'required');
                } else {
                    $(this).slideUp(250);
                    $(this).find('input, select, textarea').prop('disabled', true);
                    $(this).find('input.choosefile[type=file]').prop('disabled', true).removeAttr('required');
                    $(this).find('.text-required').remove();
                }
            });
        });
        $('.select-education-group').trigger('change');

        // --- Add More Education Entry Handler ---
        $(document).on('click', '.btn-add-more-education', function() {
            var btn = $(this);
            var custom_field_id = btn.data('id');
            var level = btn.data('level');
            var slug = btn.data('slug');
            var step_id = btn.data('step');
            var category_id = btn.data('category-id');
            var category_type = btn.data('category-type');
            var grant_id = btn.data('grant-id');
            var period_id = btn.data('period-id');
            var wrapper = btn.closest('.panel-body').find('.education-entries-wrapper-' + slug);

            $('.add-education-spinner-' + custom_field_id + '-' + slug).show();
            btn.prop('disabled', true);

            var formData = new FormData();
            formData.append('custom_field_id', custom_field_id);
            formData.append('level', level);
            formData.append('user_grantee_step_id', step_id);
            formData.append('user_grantee_category_id', category_id);
            formData.append('user_grantee_category_type', category_type);
            formData.append('user_grantee_grant_id', grant_id);
            formData.append('user_grantee_period_id', period_id);
            formData.append('grantee_grant_id', <?= $grantee_grant->id ?>);

            $.ajax({
                url: '<?= base_url() ?>grantee/submission/multiple_file_education',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false
            }).done(function(r) {
                var html = r;
                wrapper.append(html);
                var $newItem = wrapper.children('.education-entry-item').last();

                $newItem.find('.select2-country').each(function() {
                    var $el = $(this);
                    $el.select2({
                        placeholder: "Select a country",
                    });
                    $el.on('select2:select', function() {
                        $(this).attr('data-value', $(this).val());
                        $(this).trigger('blur');
                        var key_of_unique = $(this).data('select_key_country');
                        $newItem.find(".select2-state[data-select_key_country='" + key_of_unique + "']").val(null).trigger('change').trigger('blur');
                        $newItem.find(".select2-city[data-select_key_country='" + key_of_unique + "']").val(null).trigger('change').trigger('blur');
                    });
                });

                $newItem.find('.select2-state').each(function() {
                    var $el = $(this);
                    $el.select2({
                        placeholder: "Select a state",
                        ajax: {
                            url: function() {
                                var key_of_unique = $el.data('select_key_country');
                                var country_id = $newItem.find(".select2-country[data-select_key_country='" + key_of_unique + "']").val();
                                return '<?php echo site_url('world/data_state') ?>' + (country_id ? '/' + country_id : '');
                            },
                            dataType: 'json'
                        }
                    });
                    $el.on('select2:select', function() {
                        $(this).attr('data-value', $(this).val());
                        $(this).trigger('blur');
                        var key_of_unique = $(this).data('select_key_country');
                        $newItem.find(".select2-city[data-select_key_country='" + key_of_unique + "']").val(null).trigger('change').trigger('blur');
                    });
                });

                $newItem.find('.select2-city').each(function() {
                    var $el = $(this);
                    $el.select2({
                        placeholder: "Select a city",
                        ajax: {
                            url: function() {
                                var key_of_unique = $el.data('select_key_country');
                                var state_id = $newItem.find(".select2-state[data-select_key_country='" + key_of_unique + "']").val();
                                return '<?php echo site_url('world/data_city') ?>' + (state_id ? '/' + state_id : '');
                            },
                            dataType: 'json'
                        }
                    });
                    $el.on('select2:select', function() {
                        $(this).trigger('blur');
                    });
                });

                $newItem.find('.select2-parent-field-of-study').each(function() {
                    var $el = $(this);
                    $el.select2({
                        placeholder: "Select Field of Study",
                    });
                    $el.on('select2:select', function() {
                        $(this).trigger('blur');
                        var key_of_unique = $(this).data('select_key_state_of_study');
                        $newItem.find(".select2-field-of-study[data-select_key_state_of_study='" + key_of_unique + "']").val(null).trigger('change').trigger('blur');
                    });
                });

                $newItem.find('.select2-field-of-study').each(function() {
                    var $el = $(this);
                    $el.select2({
                        placeholder: "Select Specialization",
                        ajax: {
                            url: function() {
                                var key_of_unique = $el.data('select_key_state_of_study');
                                var parent_id = $newItem.find(".select2-parent-field-of-study[data-select_key_state_of_study='" + key_of_unique + "']").val();
                                var grant_id = $el.data('grant-id') || '';
                                var period_id = $el.data('period-id') || '';
                                return '<?php echo site_url('world/field_of_study') ?>' + (parent_id ? '/' + parent_id : '') + '?grant_id=' + grant_id + '&period_id=' + period_id;
                            },
                            dataType: 'json'
                        }
                    });
                    $el.on('select2:select', function() {
                        $(this).trigger('blur');
                    });
                });
                $('.lightbox').topbox();
                $('.datepicker').datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'dd M yy',
                    yearRange: '<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>'
                });
                $('.datetime').datetimepicker({ format: 'yyyy-mm-dd hh:ii', autoclose: true });
                $('.add-education-spinner-' + custom_field_id + '-' + slug).hide();
                btn.prop('disabled', false);
            }).fail(function() {
                $('.add-education-spinner-' + custom_field_id + '-' + slug).hide();
                btn.prop('disabled', false);
            });
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
            applyConditionalVisibility();
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
            // var fileviewFull = $(this).closest('.is_row_class').find('.fileview');
            var fileviewFull = $(this).closest('.item-sub').find('.fileview');
            var base_url = "<?= base_url() ?>";
            // bind change first, then open picker only when empty
            var file_input = $('.' + data_value);
            file_input.off('change').on('change', function(e) {
                const elThis = $(this)
                // define variable name
                var custom_fields_id = $(this).data('id');
                var step_id = $(this).data('step');
                var category_id = $(this).data('category-id');
                var grant_id = $(this).data('grant-id');
                var period_id = $(this).data('period-id');
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
                const barLeft = $(this).closest('.item-sub').find('.bar-left');
                barLeft.html(`<svg class="icon-svg file-icon" viewBox="0 0 24 24"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg><div><span class="file-name-text">${fileName}</span></div>`)
                
                // icon.css('display', 'block')
                $("#progress-dialog-upload").modal('show');

                Swal.fire({
                    title: 'Uploading...',
                    text: 'Please wait, your file is being uploaded.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: function() {
                        Swal.showLoading();
                    }
                });

                // define value form data
                var formData = new FormData();
                formData.append("file", e.target.files[0]);
                formData.append("user_grantee_custom_fields_id", custom_fields_id),
                formData.append("user_grantee_step_id", step_id),
                formData.append("user_grantee_category_id", category_id),
                formData.append("user_grantee_grant_id", grant_id),
                formData.append("user_grantee_period_id", period_id),
                formData.append("multiple_file_id", multiple_id),
                formData.append("multiple_step_id", multiple_step_id),
                formData.append("group_element_id", group_element_id)

                // autosave
                $.ajax({
                    url: "<?= base_url(); ?>grantee/submission/save_fields",
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
                        // elThis.closest('.col-lg-4').find('.filename').html(substrFileName).attr('title', fileName)
                        // elThis.closest('.is_row_class').find('.filename').html(substrFileName).attr('title', fileName)
                        // fileview.css("display", "inline-block");
                        // fileview.attr("href", base_url + postsjson.filepath);

                        fileviewFull.removeClass("hide");
                        fileviewFull.attr("href", base_url + postsjson.filepath);
                        // icon.css("display", "none");
                        $(".btn-download" + upload_id).attr("href", base_url + postsjson.filepath);
                        $(".btn-delete" + upload_id).removeClass("hide");
                        $(".btn-download" + upload_id).removeClass("hide");
                        elThis.closest('.item-sub').find('.upload-button').text('Change File');
                        if (error == 0) {
                            $(".next, .submit-submission").removeClass("disabled");
                        } else {
                            // $(".next, .submit-submission").addClass("disabled");
                        }
    
                        // Dapatkan nilai onclick saat ini
                        var currentOnclick = $(".btn-delete" + upload_id).attr('onclick');
                        if (currentOnclick && postsjson?.submission_id) {
                            var newOnclick = currentOnclick.replace(/'subid'/g, postsjson.submission_id);
                            $(".btn-delete" + upload_id).attr('onclick', newOnclick);
                        }
                        setTimeout(function() {
                            Swal.fire({
                                icon: "success",
                                title: "Successfully upload the file",
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }, 600);
                    }else{
                        Swal.fire({
                            icon: "error",
                            title: postsjson.message || "Failed to upload the file",
                            showConfirmButton: false,
                            timer: 2000
                        });
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
            });

            if (file_input.length && file_input[0].files && file_input[0].files.length) {
                file_input.trigger('change');
            } else {
                file_input.click();
            }
        });

        var is_submit = false;
        $(".submit-submission").click(async function(e) {
            e.preventDefault();
            // if(active_country == 1){
            //     let isChanged = await checkActiveGrant();
            //     if (isChanged === false || isChanged === undefined) {
            //         return false;
            //     }
            // }
            is_submit = true;
            let first_invalid_tab = '';
            $(".tab-pane").each(function() {
                let valid = validate_all_input($(this).attr('id'));
                if (!valid && first_invalid_tab == '') {
                    first_invalid_tab = $(this).attr('id');
                }
            });

            if (first_invalid_tab != '') {
                console.log(first_invalid_tab)
                var tabLinkSelector = '[href="#' + first_invalid_tab + '"]';
                $(tabLinkSelector).trigger('click');
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
            // if(active_country == 1){
            //     let isChanged = await checkActiveGrant();
            //     if (isChanged === false || isChanged === undefined) {
            //         return false;
            //     }
            // }
            var element = $(this);
            var data_value = $(this).val();
            var custom_fields_id = $(this).data('id');
            var is_required = $(this).attr("required");
            var group_element_id = $(this).data("index");
            var is_advanced_checkbox = element.data('is_advanced_checkbox');

            // add logic for checkbox non advanced checkbox
            if (is_advanced_checkbox != 1) {
                if ($(this).is(':checkbox')) {
                    data_value = [];
                    $.each($(`input:checkbox.check-${custom_fields_id}:checked`), function() {
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

            var step_id = $(this).data('step');
            var category_id = $(this).data('category-id');
            var grant_id = $(this).data('grant-id');
            var period_id = $(this).data('period-id');

            // check if other value
            var data = {
                value: data_value,
                user_grantee_custom_fields_id: custom_fields_id,
                user_grantee_step_id: step_id,
                user_grantee_category_id: category_id,
                user_grantee_grant_id: grant_id,
                user_grantee_period_id: period_id,
                group_element_id: group_element_id,
                is_other: false
            };
            if ($(this).hasClass('text-have-other')) {
                data['is_other'] = true;
            }
            
            $.ajax({
                    url: "<?= base_url(); ?>grantee/submission/save_fields",
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
                        SaveToast.fire({icon: 'success', title: 'Saved'});
                        updateLastSaved(getFieldLabel(element));
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
            var custom_fields_id = $(this).data('id');
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
                value: data_value,
                user_grantee_custom_fields_id: custom_fields_id,
                user_grantee_step_id: step_id,
                user_grantee_category_id: category_id,
                user_grantee_grant_id: grant_id,
                user_grantee_period_id: period_id,
                group_element_id: group_element_id,
                grantee_grant_id: grantee_grant_id,
                user_grantee_id: user_grantee_id
            };

            $.ajax({
                url: "<?= base_url(); ?>grantee/submission/save_fields_checkbox",
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
                    SaveToast.fire({icon: 'success', title: 'Saved'});
                    updateLastSaved(getFieldLabel(element));
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
        
        applyConditionalVisibility();

    });

    /**
     * check whether a choosefile input already has an uploaded file (preview shown)
     * 
     * @param jQuery $input
     * @return bool
     */
    function has_uploaded_preview($input) {
        // find the download button (existing uploaded file) inside the same container as the file input
        // let $download = $input.closest('div').find('a[download]').first();
        let $download = $input.closest('.item-sub').find('.btn-download-sub').first();

        if (!$download.length) {
            return false;
        }

        let href = $download.attr('href');
        return !!href && href.indexOf('/uploads/') !== -1;
    }


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

            if (group != 'radio' && group != 'education') {
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
            if (group != 'radio' && group != 'education') {
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
        $("#" + tab).find("input.form-control,input.choosefile").each(function() {
            let group = $(this).data('type-group');

            if (group != 'radio' && group != 'education') {
                // bypass required for file input that already has uploaded preview
                if ($(this).is('input.choosefile') && has_uploaded_preview($(this))) {
                    return;
                }

                let invalid_values = [null, ''];
                let is_required = $(this).prop('required');
                if (invalid_values.includes($(this).val()) && is_required) {
                    const parent = $(this).closest('div');
                    const has_warning = parent.find('p.text-required');

                    if (has_warning.length == 0) {
                        validated = false;

                        const warning = '<p class="text-required text-danger">This field is required</p>';
                        const hr = parent.find('.doc-label').first();

                        if (hr.length) {
                            hr.append(warning);
                        } else {
                            parent.append(warning);
                        }

                        // $(this).focus();
                    }
                }
            }
        });

        // check input with type hidden
        $("#" + tab).find("input[type=hidden].autosave").each(function() {
            let group = $(this).data('type-group');
            let hidden_radio = $(this).is('[class*="radio"]');
            if (group != 'radio' && group != 'education' && !hidden_radio) {
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
            
            if (group != 'radio' && group != 'education') {
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
            radio_group_elements.each(function(){
                let current_element = $(this);
                if (current_element.data('element') == selected_radio_element.data('show')) {
                    let input_elements = current_element.find('input');
                    input_elements.each(function(){
                        // bypass required for file input that already has uploaded preview
                        if ($(this).is('input.choosefile') && has_uploaded_preview($(this))) {
                            return;
                        }

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

        // check for radio input type (plain radio, not radio group)
        $("#" + tab).find('input[type="radio"].autosave:not(.radio-group)').each(function() {
            // skip radios inside radio group sub elements (already handled by radio group validation)
            if ($(this).closest('.radio-group-element, .show-group, .education-group-container').length) {
                return;
            }

            let is_required = $(this).prop('required');
            if (!is_required) {
                return;
            }

            const $group = $('input[type="radio"][name="' + $(this).attr('name') + '"]');
            const hasChecked = $group.is(':checked');

            const $container = $(this).closest('div');
            const has_warning = $container.find('p.text-required');

            if (!hasChecked) {
                if (has_warning.length == 0) {
                    validated = false;
                    $container.append('<p class="text-required text-danger">This field is required</p>');
                    $(this).focus();
                }
            } else {
                $container.find('p.text-required').remove();
            }
        });

        // check for education group
        $("#" + tab).find('.education-group-container').each(function() {
            let selectEl = $(this).find('.select-education-group');
            let is_required = selectEl.prop('required');
            let selectedVal = selectEl.val();

            if ((!selectedVal || selectedVal === '') && is_required) {
                let hasWarning = $(this).find('.education-select-wrapper').find('p.text-required');
                if (hasWarning.length === 0) {
                    validated = false;
                    $(this).find('.education-select-wrapper').append('<p class="text-required text-danger">This field is required</p>');
                    selectEl.focus();
                }
            } else {
                $(this).find('.education-select-wrapper').find('p.text-required').remove();
            }

            if (selectedVal) {
                // Only validate visible education cards!
                let visibleCards = $(this).find('.education-level-card:visible');
                visibleCards.each(function() {
                    let card = $(this);
                    card.find('input:not([type=hidden]):not([type=file]), input.choosefile').each(function() {
                        if ($(this).prop('disabled')) return;
                        if ($(this).is('input.choosefile') && has_uploaded_preview($(this))) {
                            return;
                        }
                        let invalid_values = [null, ''];
                        let is_req = $(this).prop('required');
                        if (invalid_values.includes($(this).val()) && is_req) {
                            let parent = $(this).closest('div');
                            let has_warning = parent.find('p.text-required');
                            if (has_warning.length === 0) {
                                validated = false;
                                let warning = '<p class="text-required text-danger">This field is required</p>';
                                let hr = parent.find('hr').first();
                                if (hr.length) {
                                    hr.before(warning);
                                } else {
                                    parent.append(warning);
                                }
                                // $(this).focus();
                            }
                        } else {
                            $(this).closest('div').find('p.text-required').remove();
                        }
                    });

                    card.find('select').each(function() {
                        if ($(this).prop('disabled')) return;
                        let first_val = $(this).find("option:not(:selected):first").val();
                        let is_req = $(this).prop('required');
                        if (($(this).val() == null || $(this).val() == first_val || $(this).val() == '') && is_req) {
                            let has_warning = $(this).closest('div').find('p.text-required');
                            if (has_warning.length === 0) {
                                validated = false;
                                $(this).closest('div').append('<p class="text-required text-danger">This field is required</p>');
                                // $(this).focus();
                            }
                        } else {
                            $(this).closest('div').find('p.text-required').remove();
                        }
                    });

                    card.find('textarea').each(function() {
                        if ($(this).prop('disabled')) return;
                        let invalid_values = [null, ''];
                        let is_req = $(this).prop('required');
                        if (invalid_values.includes($(this).val()) && is_req) {
                            let has_warning = $(this).closest('div').find('p.text-required');
                            if (has_warning.length === 0) {
                                validated = false;
                                $(this).closest('div').append('<p class="text-required text-danger">This field is required</p>');
                                // $(this).focus();
                            }
                        } else {
                            $(this).closest('div').find('p.text-required').remove();
                        }
                    });
                });
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
            // bypass required for file input that already has uploaded preview
            if ($(this).is('input.choosefile') && has_uploaded_preview($(this))) {
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

            const allowed_extensions = ['gif', 'jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx', 'xsl', 'xlsx', 'heic', 'heif'];

            const is_valid_extension = allowed_extensions.some(function(extension) {
                return ext.toLowerCase().endsWith(extension);
            });


            let pdf_icon = '<?php echo base_url('assets/images/icons/pdf.svg'); ?>';
            let download_icon = '<?php echo base_url('assets/images/icons/download icon.png'); ?>';

            if((fileSize < maxSize) && is_valid_extension){
                $(element).closest('div').find('p.text-required').remove();

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

    var submission_file_picker = null;
    function pick_submission_file(callback) {
        if (!submission_file_picker) {
            submission_file_picker = $('<input type="file" style="display:none">').appendTo('body');
        }
        submission_file_picker.off('change').on('change', function() {
            var file = this.files[0];
            $(this).val('');
            if (file) callback(file);
        });
        submission_file_picker[0].click();
    }

    async function add_more_submission(element, is_multiple = false, file = null) {
        // if(active_country == 1){
        //     let isChanged = await checkActiveGrant();
        //     if (isChanged === false || isChanged === undefined) {
        //         return false;
        //     }
        // }
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
        var activeCountry = <?= $activeCountry ?>;
        const multiple_step = $('.multiple-cf-' + custom_field_id + multiple_step_id);
        
        if(max_multiple){
            if(multiple_step.length >=  max_multiple){
                showSwal('warning', 'You have reached the maximum number of allowed entries.', false, true, 2500);
                return false
            }
        }

        if (type === 'file' && !file) {
            pick_submission_file(function(chosen) {
                add_more_submission(element, is_multiple, chosen);
            });
            return;
        }

        // $(".add-multiple-file-spinner-" + custom_field_id).show();
        Swal.showLoading();

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
            formData.append("activeCountry", activeCountry),
            formData.append("grantee_grant_id", <?= $grantee_grant->id ?>)
            formData.append("multiple_step_id", multiple_step_id),
            formData.append("is_grantee", true),
            
            $.ajax({
                url: "<?= base_url(); ?>grantee/submission/multiple_file",
                type: 'POST',
                data: formData, // The form with the file inputs.
                processData: false,
                contentType: false // Using FormData, no need to process data.
            }).done(function(r) {
                Swal.close();
                var $new = $(r);
                if (is_multiple) {
                    $(".wrap-file-step-" + custom_field_id).append($new);
                    $(".add-multiple-file-spinner-" + custom_field_id).hide();
                } else {
                    if(type === 'file'){
                        $(".wrap-file-" + custom_field_id).find('.sub-item').append($new);
                    }else{
                        $(".wrap-file-" + custom_field_id).append($new);
                    }
                    $(".add-multiple-file-spinner-" + custom_field_id).hide();
                }

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
                                let grant_id = $(this).data('grant-id') || '';
                                let period_id = $(this).data('period-id') || '';
                                return '<?php echo site_url('world/field_of_study') ?>' + (parent_id ? '/' + parent_id : '') + '?grant_id=' + grant_id + '&period_id=' + period_id;
                            },
                            dataType: 'json'
                        }
                    });
                    $('.select2-field-of-study_' + study_id).on('select2:select', function() {
                        $(this).trigger('blur');
                    });
                }
                initSelect2(r);
                $('.lightbox').topbox();

                if (type === 'file' && file) {
                    var new_file_input = $new.find('input.choosefile').get(0);
                    if (new_file_input && window.DataTransfer) {
                        var data_transfer = new DataTransfer();
                        data_transfer.items.add(file);
                        new_file_input.files = data_transfer.files;
                        $new.find('.upload-button').trigger('click');
                    }
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
        var step_id = $(element).data('step');
        var category_id = $(element).data('category-id');
        var grant_id = $(element).data('grant-id');
        var period_id = $(element).data('period-id');
        var category_type = $(element).data('category-type');
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
                url: "<?= base_url(); ?>grantee/submission/multiple_file_radio",
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
                                let grant_id = $(this).data('grant-id') || '';
                                let period_id = $(this).data('period-id') || '';
                                return '<?php echo site_url('world/field_of_study') ?>' + (parent_id ? '/' + parent_id : '') + '?grant_id=' + grant_id + '&period_id=' + period_id;
                            },
                            dataType: 'json'
                        }
                    });
                    $('.select2-field-of-study_' + study_id).on('select2:select', function() {
                        $(this).trigger('blur');
                    });
                }
            });
            applyConditionalVisibility();

    }

    async function add_more_step_fields(element) {
        // if(active_country == 1){
        //     let isChanged = await checkActiveGrant();
        //     if (isChanged === false || isChanged === undefined) {
        //         return false;
        //     }
        // }
        var step_id = $(element).data("id");
        var user_grantee_category_id = $(element).data("user_grantee_category_id");
        var user_grantee_grant_id = $(element).data("user_grantee_grant_id");
        var period_id = $(element).data("period_id");
        var max_multiple = $(element).data("max_multiple") ? $(element).data("max_multiple") : 0;
        var activeCountry = <?= $activeCountry ?>;
        const multiple_step = $('.multiple-step-' + step_id);

        if(max_multiple){
            if(multiple_step.length >=  max_multiple){
                showSwal('warning', 'You have reached the maximum number of allowed entries.', false, true, 2500);
                return false
            }
        }
        $(".add-multiple-step-spinner-" + step_id).show();

        var formData = new FormData();
        formData.append("user_grantee_step_id", step_id),
        formData.append("user_grantee_category_id", user_grantee_category_id),
        formData.append("user_grantee_grant_id", user_grantee_grant_id),
        formData.append("period_id", period_id),
        formData.append("activeCountry", activeCountry),

        $.ajax({
            url: "<?= base_url(); ?>grantee/submission/multiple_field_step",
            type: 'POST',
            data: formData, // The form with the file inputs.
            processData: false,
            contentType: false // Using FormData, no need to process data.
        }).done(function(r) {
            $(".wrap-step-" + step_id).append(r);
            $(".add-multiple-step-spinner-" + step_id).hide();
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
                let elemet_id_country = country_tag.data('multiple-step-id');
                if (elemet_id_country) {
                    $('.select2-country_' + elemet_id_country).select2({
                        placeholder: "Select a country",
                    });
                    $('.select2-country_' + elemet_id_country).on('select2:select', function() {
                        $(this).attr('data-value', $(this).val());
                        $(this).trigger('blur');
                        $(this).trigger('change');
                        let key_of_unique = $(this).data('select_key_country');
                        $(".select2-state[data-select_key_country='" + key_of_unique + "']").val(null).trigger('change').trigger('blur');
                        $(".select2-city[data-select_key_country='" + key_of_unique + "']").val(null).trigger('change').trigger('blur');
                        applyConditionalVisibility();
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
                                let grant_id = $(this).data('grant-id') || '';
                                let period_id = $(this).data('period-id') || '';
                                return '<?php echo site_url('world/field_of_study') ?>' + (parent_id ? '/' + parent_id : '') + '?grant_id=' + grant_id + '&period_id=' + period_id;
                            },
                            dataType: 'json'
                        }
                    });
                    $('.select2-field-of-study_' + study_id).on('select2:select', function() {
                        $(this).trigger('blur');
                    });
                }
                applyConditionalVisibility();
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
                            let grant_id = $(this).data('grant-id') || '';
                            let period_id = $(this).data('period-id') || '';
                            return '<?php echo site_url('world/field_of_study') ?>' + (parent_id ? '/' + parent_id : '') + '?grant_id=' + grant_id + '&period_id=' + period_id;
                        },
                        dataType: 'json'
                    }
                });
                $('.select2-field-of-study_' + study_id).on('select2:select', function() {
                    $(this).trigger('blur');
                });
            }

    }

    function del_multiple(el, item_class) {
        if (confirm("Are you sure want to delete this ?")) {
            var multiple_id = $(el).data("multiple-id");
            $(".delete-multiple-spinner-" + multiple_id).show();
            Swal.showLoading();
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url('grantee/submission/delete_multiple') ?>/' + multiple_id,
                dataType: 'JSON',
                success: function(r) {
                    if (r.status) {
                        $(el).closest('.' + item_class).remove();
                        Swal.close();
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
            var custom_fields_id = $(this).data('id');
            var step_id = $(this).data('step');
            var category_id = $(this).data('category-id');
            var grant_id = $(this).data('grant-id');
            var period_id = $(this).data('period-id');
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
            formData.append("user_grantee_custom_fields_id", custom_fields_id),
            formData.append("user_grantee_step_id", step_id),
            formData.append("user_grantee_category_id", category_id),
            formData.append("user_grantee_grant_id", grant_id),
            formData.append("user_grantee_period_id", period_id),
            formData.append("multiple_file_id", multiple_id)
            formData.append("multiple_step_id", multiple_step_id)
            formData.append("group_element_id", group_element_id)

            // autosave
            $.ajax({
                url: "<?= base_url(); ?>grantee/submission/save_fields",
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
        var custom_fields_id = $(element).data('id');
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
                $.each($(`input:checkbox.check-${custom_fields_id}-${multiple_id}:checked`), function() {
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
            $.each($(`.table_${custom_fields_id}_${multiple_id} input:radio.multiple-choice-grid-multi:checked`), function() {
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
            value: data_value,
            user_grantee_custom_fields_id: custom_fields_id,
            user_grantee_step_id: step_id,
            user_grantee_category_id: category_id,
            user_grantee_grant_id: grant_id,
            user_grantee_period_id: period_id,
            group_element_id: group_element_id,
            multiple_file_id: multiple_id,
            multiple_step_id: multiple_step_id,
            is_other: false
        };
        if ($(element).hasClass('text-have-other')) {
            data['is_other'] = true;
        }

        $.ajax({
                url: "<?= base_url(); ?>grantee/submission/save_fields",
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
                    SaveToast.fire({icon: 'success', title: 'Saved'});
                    updateLastSaved(getFieldLabel($(element)));
                }
            })
    }

    function del_multiple_step(el, item_class) {
        if (confirm("Are you sure want to delete this ?")) {
            var multiple_id = $(el).data("id");
            $(".delete-multiple-step-spinner-" + multiple_id).show();
            Swal.showLoading();
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url('grantee/submission/delete_multiple_step') ?>/' + multiple_id,
                dataType: 'JSON',
                success: function(r) {
                    if (r.status) {
                        $(el).closest('.' + item_class).remove();
                        Swal.close();
                    }
                    $(".delete-multiple-step-spinner-" + multiple_id).hide();
                }
            });
        }
    }

    function del_file(el, name, label, subId = '', submissionId = '') {
        if (confirm("Are you sure want to delete " + label + " ?")) {
            const loadIcon = '<img src="<?php echo base_url() ?>/img/loading.gif">'
            // var fileview = $(el).closest('.col-lg-4').find('.fileview');
            // var fileviewFull = $(el).closest('.is_row_class').find('.fileview');
            // var btnDelete = $(el).closest('.col-lg-4').find('.btn-del-sub');
            // var filename = $(el).closest('.col-lg-4').find('.filename');
            // var filenameFull = $(el).closest('.is_row_class').find('.filename');
            // var html = '';
            // html += '<div id="preview_section_' + subId + '" style="position:relative; width:100px;">'
            // html += '<img onclick="add_file(\'my_file_\' + ' + subId + '\);" data-trigger="my_file_' + subId + '" height="100" style="margin-top: 16px; cursor: pointer;" id="preview_image_' + subId + '" class="preview_image_' + subId + '" src="<?php echo base_url('assets/images/icons/add-file.png'); ?>">'
            // html += '<a href="javascript:;" onclick="del_file(this, \'' + name + '\', \'' + label + '\', ' + subId + ', ' + submissionId + ')" class="hide btn btn-danger btn-xs btn-delete' + subId + '" style="position:absolute; top:25px;"><i class="fa fa-trash fa-fw text-white"></i></a>'
            // html += '<a download title="Click to download" class="hide btn btn-primary btn-xs btn-download' + subId + '" style="position:absolute; top:0;"><i class="fa fa-download fa-fw text-white"></i></a>'
            // html += '</div>'
            // html += '<p class="filename" style="font-size:16px;cursor:pointer;" data-toggle="tooltip" data-placement="left" title="No file chosen">No file chosen</p>'
            // $(el).html(loadIcon)
            const btnDownload = $('.btn-download' + subId + '');
            const btnDelete = $('.btn-delete' + subId + '');
            const btnPreview = $(el).closest('.item-sub').find('.fileview');
            const barLeft = $(el).closest('.item-sub').find('.bar-left');
            Swal.showLoading();

            $.ajax({
                type: 'GET',
                url: '<?php echo base_url('grantee/submission/delete_submission_value') ?>/' + submissionId,
                dataType: 'JSON',
                success: function(r) {
                    // $(el).parent().replaceWith(html);
                    // btnDelete.css("display", "block")
                    // fileview.css("display", "none");
                    // fileviewFull.css("display", "none");
                    // filename.remove();
                    // filenameFull.remove();
                    barLeft.html(`<svg class="icon-svg" viewBox="0 0 24 24" style="color: #94a3b8; stroke-width: 1.5;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg><div><span style="color: #64748b; font-size: 13px;">No file selected yet...</span></div>`);
                    btnDownload.addClass('hide');
                    btnDelete.addClass('hide');
                    btnPreview.addClass('hide');
                    $(el).closest('.item-sub').find('.upload-button').text('Upload');
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
        // var maxlen = $(element).data('maxlength');
        // var length = $(element).val().split(/\s+/).length;
        // var id = $(element).data('index');
        // var maxLength = $(element).val().split(/\s+/).slice(0, maxlen);
        // var maxWords = maxLength.join(' ');
        // var charCount = $(element).val().length;


        // if(isLimit){
        //     if(charCount > (maxlen)){
        //         var trimmedText = $(element).val().substring(0, maxlen);
        //         $(element).val(trimmedText);
        //         $('#textarea_message_'+id).text('max length '+maxlen+' characters only!').addClass('text-danger')
        //     }else
        //     {
        //         $('#textarea_message_'+id).text((maxlen-charCount) + ' characters remaining')
        //     }
        // }

        // if(length > (maxlen - 2) && isLimit){
        //     var length = $(element).val(maxWords);
        //     $('#textarea_message_'+id).text('max length '+maxlen+' words only!')
        // }else
        // {
        //     $('#textarea_message_'+id).text('');
        // }

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


    
    function loadRecommendationList(grantee_grant_id, section) {
        $('#email-recommendation-loading').show();
        $('#email-recommendation-error').hide().text('');
        $('#email-recommendation-content').hide();
        $('#add-recommender-card').hide();
        $('#btnAddRecommender').text('+ Add Recommender');

        $.ajax({
            url: "<?= base_url(); ?>grantee/submission/get_email_recommendation_list",
            method: "POST",
            dataType: "JSON",
            data: {
                grantee_grant_id: grantee_grant_id,
                section: section
            }
        })
        .done(function(data) {
            $('#email-recommendation-loading').hide();

            if (!data.status) {
                $('#email-recommendation-error')
                    .text(data.message || 'Failed to get recipient list.')
                    .show();
                return;
            }

            var recommenders = data.recommenders || data.data || [];
            var count = recommenders.length;
            var stepFields = data.step_fields || [];

            if (data.step_id) {
                $('#send-email-recommendation-modal').data('step_id', data.step_id);
            }
            // Store step_fields globally on modal for add form
            $('#send-email-recommendation-modal').data('step_fields', stepFields);

            // Check max multiple taken directly from am_user_grantee_step.max_multiple
            var max_multiple = parseInt(data.max_multiple, 10);
            if (isNaN(max_multiple)) {
                max_multiple = 0;
            }

            // Calculate active recommenders count (excluding 'excluded' and 'deleted')
            var activeCount = 0;
            $.each(recommenders, function(index, rec) {
                if (rec.status !== 'excluded' && rec.status !== 'deleted') {
                    activeCount++;
                }
            });

            $('#send-email-recommendation-modal').data('max_multiple', max_multiple);
            $('#send-email-recommendation-modal').data('active_count', activeCount);

            if (max_multiple > 0 && activeCount >= max_multiple) {
                $('#btnAddRecommender').prop('disabled', true).css('opacity', 0.6).attr('title', 'Maximum ' + max_multiple + ' active recommenders reached');
            } else {
                $('#btnAddRecommender').prop('disabled', false).css('opacity', 1).removeAttr('title');
            }

            var rows = '';
            if (count === 0) {
                rows = '<tr><td colspan="3" class="text-center" style="padding: 25px; color: #888;">No recommenders found. Click "+ Add Recommender" above to add one.</td></tr>';
            } else {
                $.each(recommenders, function(index, rec) {
                    var statusBadge = '';
                    var isExcluded = (rec.status === 'excluded');

                    if (rec.status === 'submitted') {
                        statusBadge = '<span class="label label-success" style="font-size:10px;padding:3px 7px;">Submitted</span>';
                    } else if (isExcluded) {
                        statusBadge = '<span class="label label-default" style="font-size:10px;padding:3px 7px;background-color:#94a3b8;">Excluded</span>';
                    } else if (rec.status === 'sent') {
                        statusBadge = '<span class="label label-info" style="font-size:10px;padding:3px 7px;">Email Sent</span>';
                    } else {
                        statusBadge = '<span class="label label-danger" style="font-size:10px;padding:3px 7px;">Pending</span>';
                    }

                    var rowClass = 'main-row' + (isExcluded ? ' row-excluded' : '');
                    var nameClass = 'rec-name' + (isExcluded ? ' excluded-text' : '');

                    var trAccordion = `
                        <tr id="accordion_${rec.id}" class="accordion-row">
                            <td colspan="3" class="accordion-td">
                                <div class="accordion-content">
                                <div class="accordion-header-title">
                                    <span>Edit Details: ${$('<div>').text(rec.full_name || '-').html()}</span>
                                </div>
                                <form onsubmit="handleEditSubmit(event, ${rec.id})">
                                    <input type="hidden" id="edit_step_id_${rec.id}" value="${rec.step_id || ''}">
                                    <input type="hidden" id="edit_multiple_step_id_${rec.id}" value="${rec.multiple_step_id !== undefined ? rec.multiple_step_id : ''}">
                                    <div class="form-grid">
                                    ${buildRecommenderFormFields(stepFields, rec, 'edit_' + rec.id)}
                                    </div>
                                    <div class="form-actions">
                                    <button type="button" class="btn btn-secondary" onclick="toggleEditAccordion(${rec.id})">Cancel</button>
                                    <button type="submit" class="btn btn-primary" id="btn_submit_edit_${rec.id}">Update Details</button>
                                    </div>
                                </form>
                                </div>
                            </td>
                        </tr>
                    `;

                    rows += `
                        <tr class="${rowClass}">
                            <td class="val">
                                <span class="${nameClass}">${$('<div>').text(rec.full_name || '-').html()}</span>
                                <div class="rec-sub">${$('<div>').text(rec.position || '-').html()} &bull; ${$('<div>').text(rec.institution || '-').html()}</div>
                            </td>
                            <td>${statusBadge}</td>
                            <td class="text-right">
                                <div class="actions-wrap">
                                <button class="action-btn btn-edit-rec" onclick="toggleEditAccordion(${rec.id})">
                                    Edit
                                </button>
                                ${
                                    isExcluded 
                                    ? `<button class="action-btn btn-reinstate" onclick="reinstateRecommender(${rec.id})">Reinstate</button>` 
                                    : `<button class="action-btn btn-exclude" onclick="excludeRecommender(${rec.id})">Exclude</button>`
                                }
                                <button class="action-btn btn-delete-rec" onclick="deleteRecommender(${rec.id})">Delete</button>
                                </div>
                            </td>
                        </tr>${trAccordion}
                    `;
                });
            }

            var cardsHtml = `
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 50%;">Recommender Name</th>
                            <th style="width: 20%;">Status</th>
                            <th style="width: 30%;" class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${rows}
                    </tbody>
                </table>`;

            $('#email-recommendation-cards').html(cardsHtml);
            if(data.is_expired){
                $('.action-btn').prop('disabled', true).css('opacity', 0.6);
            } else {
                $('.action-btn').prop('disabled', false).css('opacity', 1);
            }

            if (stepFields && stepFields.length > 0) {
                $('#add-recommender-grid').html(buildRecommenderFormFields(stepFields, null, 'add'));
            }
            $('#email-recommendation-content').show();
        })
        .fail(function() {
            $('#email-recommendation-loading').hide();
            $('#email-recommendation-error')
                .text('Failed to get recipient list.')
                .show();
        });
    }

    /**
     * Get current value from rec object for a given step field
     */
    function getRecValueForField(field, rec) {
        if (rec && rec.custom_field_values && rec.custom_field_values[field.id] !== undefined && rec.custom_field_values[field.id] !== null) {
            return rec.custom_field_values[field.id];
        }

        var label   = field.name.toLowerCase();
        var val_for = field.validation_for;

        if (val_for === 'prefix' || /\b(prefix|salutation)\b/i.test(label)) {
            return rec.prefix || '';
        } else if (/first.*name/i.test(label)) {
            return rec.firstName || rec.first_name || '';
        } else if (/last.*name|family.*name|surname/i.test(label)) {
            return rec.lastName || rec.last_name || '';
        } else if (['institution', 'institution_recommendation', 'recommendation_institution'].indexOf(val_for) !== -1 || /institution/i.test(label)) {
            return rec.institution || '';
        } else if (['position', 'position_title', 'recommendation_position'].indexOf(val_for) !== -1 || /position/i.test(label)) {
            return rec.position || '';
        } else if (['relationship', 'recommendation_relationship'].indexOf(val_for) !== -1 || /relationship/i.test(label)) {
            return rec.relationship || '';
        } else if (val_for === 'email_recommendation' || (/email/i.test(label) && val_for !== 'contact')) {
            return rec.email || '';
        } else if (['contact', 'recommendation_contact', 'phone'].indexOf(val_for) !== -1 || /(phone|tele)/i.test(label)) {
            // contact fields: distinguish email vs phone by label
            if (/email/i.test(label)) {
                return rec.email || '';
            } else {
                return rec.telephone || rec.phone || '';
            }
        }
        return '';
    }

    /**
     * Build dynamic form fields HTML from step_fields
     * @param {Array}  stepFields – from data.step_fields
     * @param {Object} rec        – recommender object (null for add form)
     * @param {String} prefix_id  – unique prefix for element IDs
     */
    function buildRecommenderFormFields(stepFields, rec, prefix_id) {
        if (!stepFields || stepFields.length === 0) {
            return buildFallbackFields(rec, prefix_id);
        }
        var html = '';
        stepFields.forEach(function(field) {
            var curVal    = rec ? getRecValueForField(field, rec) : '';
            var cfId      = field.id;
            var elemId    = prefix_id + '_cf_' + cfId;
            var reqMark   = field.is_required ? ' <span class="req">*</span>' : '';
            var reqAttr   = field.is_required ? ' required' : '';
            var safeLabel = $('<div>').text(field.name).html();
            var safeVal   = $('<div>').text(curVal).html();
            var label_lc  = field.name.toLowerCase();
            var val_for   = field.validation_for;

            html += '<div class="form-group-modal">';
            html += '<label>' + safeLabel + reqMark + '</label>';

            if (field.type === 'select' && field.options && field.options.length > 0) {
                html += '<select id="' + elemId + '" data-cf-id="' + cfId + '"' + reqAttr + '>';
                html += '<option value="">Select ' + safeLabel + '</option>';
                field.options.forEach(function(opt) {
                    var safeOpt  = $('<div>').text(opt).html();
                    var selected = (opt === curVal) ? ' selected' : '';
                    html += '<option value="' + safeOpt + '"' + selected + '>' + safeOpt + '</option>';
                });
                html += '</select>';
            } else {
                var inputType = 'text';
                if (val_for === 'email_recommendation' || (/email/i.test(label_lc) && val_for !== 'contact')) {
                    inputType = 'email';
                } else if (val_for === 'contact' && /email/i.test(label_lc)) {
                    inputType = 'email';
                } else if (/(phone|tele)/i.test(label_lc)) {
                    inputType = 'tel';
                }
                html += '<input type="' + inputType + '" id="' + elemId + '" data-cf-id="' + cfId + '" value="' + safeVal + '"' + reqAttr + '>';
            }

            html += '</div>';
        });
        return html;
    }

    /**
     * Fallback hardcoded fields (when step_fields not available)
     */
    function buildFallbackFields(rec, prefix_id) {
        var r = rec || {};
        return (
            '<div class="form-group-modal"><label>Prefix</label>' +
            '<select id="' + prefix_id + '_prefix">' +
            '<option value="" ' + (!r.prefix ? 'selected' : '') + '>Select Prefix</option>' +
            ['Dr.','Prof.','Mr.','Ms.','Mrs.'].map(function(p){
                return '<option value="' + p + '"' + (r.prefix === p ? ' selected' : '') + '>' + p + '</option>';
            }).join('') + '</select></div>' +
            '<div class="form-group-modal"><label>First Name <span class="req">*</span></label><input type="text" id="' + prefix_id + '_firstName" value="' + $('<div>').text(r.firstName || r.first_name || '').html() + '" required></div>' +
            '<div class="form-group-modal"><label>Last Name <span class="req">*</span></label><input type="text" id="' + prefix_id + '_lastName" value="' + $('<div>').text(r.lastName || r.last_name || '').html() + '" required></div>' +
            '<div class="form-group-modal"><label>Institution <span class="req">*</span></label><input type="text" id="' + prefix_id + '_institution" value="' + $('<div>').text(r.institution || '').html() + '" required></div>' +
            '<div class="form-group-modal"><label>Position / Title <span class="req">*</span></label><input type="text" id="' + prefix_id + '_position" value="' + $('<div>').text(r.position || '').html() + '" required></div>' +
            '<div class="form-group-modal"><label>Relationship <span class="req">*</span></label><input type="text" id="' + prefix_id + '_relationship" value="' + $('<div>').text(r.relationship || '').html() + '" required></div>' +
            '<div class="form-group-modal"><label>Telephone</label><input type="tel" id="' + prefix_id + '_telephone" value="' + $('<div>').text(r.telephone || r.phone || '').html() + '"></div>' +
            '<div class="form-group-modal"><label>Email <span class="req">*</span></label><input type="email" id="' + prefix_id + '_email" value="' + $('<div>').text(r.email || '').html() + '" required></div>'
        );
    }

    function toggleEditAccordion(id) {
        var row = $('#accordion_' + id);
        if (row.hasClass('open')) {
            row.removeClass('open');
            row.prev('.main-row').removeClass('active-editing');
            row.prev('.main-row').find('.btn-edit-rec').removeClass('active').text('Edit');
        } else {
            $('.accordion-row.open').each(function() {
                $(this).removeClass('open');
                $(this).prev('.main-row').removeClass('active-editing');
                $(this).prev('.main-row').find('.btn-edit-rec').removeClass('active').text('Edit');
            });
            $('#add-recommender-card').slideUp();
            $('#btnAddRecommender').text('+ Add Recommender');

            row.addClass('open');
            row.prev('.main-row').addClass('active-editing');
            row.prev('.main-row').find('.btn-edit-rec').addClass('active').text('Close');
        }
    }

    function toggleAddAccordion() {
        var card = $('#add-recommender-card');
        if (card.is(':visible')) {
            card.slideUp();
            $('#btnAddRecommender').text('+ Add Recommender');
        } else {
            var max_multiple = parseInt($('#send-email-recommendation-modal').data('max_multiple'), 10) || 0;
            var active_count = parseInt($('#send-email-recommendation-modal').data('active_count'), 10) || 0;
            if (max_multiple > 0 && active_count >= max_multiple) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Limit Reached',
                    text: 'You already have ' + max_multiple + ' active recommenders. Please exclude or delete another recommender first.'
                });
                return;
            }

            $('.accordion-row.open').each(function() {
                $(this).removeClass('open');
                $(this).prev('.main-row').removeClass('active-editing');
                $(this).prev('.main-row').find('.btn-edit-rec').removeClass('active').text('Edit');
            });
            card.slideDown();
            $('#btnAddRecommender').text('Close Add');
        }
    }

    function handleEditSubmit(e, id) {
        e.preventDefault();
        var grantee_grant_id = $('#send-email-recommendation-modal').data('id');
        var section = $('#send-email-recommendation-modal').data('section');

        var step_id = $('#edit_step_id_' + id).val();
        var multiple_step_id = $('#edit_multiple_step_id_' + id).val();

        // Collect all dynamic custom field values from this accordion's form
        var fields = {};
        var prefix_id = 'edit_' + id + '_cf_';
        $('[id^="' + prefix_id + '"][data-cf-id]').each(function() {
            var cfId = $(this).data('cf-id');
            fields[cfId] = $(this).val();
        });

        var prefix = $('#edit_prefix_' + id).val();
        var firstName = $('#edit_firstName_' + id).val();
        var lastName = $('#edit_lastName_' + id).val();
        var institution = $('#edit_institution_' + id).val();
        var position = $('#edit_position_' + id).val();
        var relationship = $('#edit_relationship_' + id).val();
        var telephone = $('#edit_telephone_' + id).val();
        var email = $('#edit_email_' + id).val();

        var btn = $('#btn_submit_edit_' + id);
        btn.prop('disabled', true).text('Updating...');

        $.ajax({
            url: "<?= base_url(); ?>grantee/submission/update_recommender",
            method: "POST",
            dataType: "JSON",
            data: {
                id: id,
                grantee_grant_id: grantee_grant_id,
                step_id: step_id,
                multiple_step_id: multiple_step_id,
                fields: fields,
                prefix: prefix,
                first_name: firstName,
                last_name: lastName,
                institution: institution,
                position: position,
                relationship: relationship,
                telephone: telephone,
                email: email
            }
        })
        .done(function(res) {
            btn.prop('disabled', false).text('Update Details');
            if (res.status) {
                Swal.fire({
                    icon: 'success',
                    title: 'Updated',
                    text: res.message,
                    timer: 3000,
                    showConfirmButton: false
                });
                loadRecommendationList(grantee_grant_id, section);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: res.message || 'Failed to update recommender.'
                });
            }
        })
        .fail(function() {
            btn.prop('disabled', false).text('Update Details');
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Server error while updating recommender.'
            });
        });
    }

    function handleAddSubmit(e) {
        e.preventDefault();
        var grantee_grant_id = $('#send-email-recommendation-modal').data('id');
        var section = $('#send-email-recommendation-modal').data('section');
        var step_id = $('#send-email-recommendation-modal').data('step_id') || 1958;
        var max_multiple = parseInt($('#send-email-recommendation-modal').data('max_multiple'), 10) || 0;
        var active_count = parseInt($('#send-email-recommendation-modal').data('active_count'), 10) || 0;

        if (max_multiple > 0 && active_count >= max_multiple) {
            Swal.fire({
                icon: 'warning',
                title: 'Limit Reached',
                text: 'You already have ' + max_multiple + ' active recommenders. Please exclude or delete another recommender first.'
            });
            return;
        }

        // Collect all dynamic custom field values from add form
        var fields = {};
        var prefix_id = 'add_cf_';
        $('[id^="' + prefix_id + '"][data-cf-id]').each(function() {
            var cfId = $(this).data('cf-id');
            fields[cfId] = $(this).val();
        });

        var prefix = $('#add_prefix').val();
        var firstName = $('#add_firstName').val();
        var lastName = $('#add_lastName').val();
        var institution = $('#add_institution').val();
        var position = $('#add_position').val();
        var relationship = $('#add_relationship').val();
        var telephone = $('#add_telephone').val();
        var email = $('#add_email').val();

        var btn = $('#btn-submit-add-rec');
        btn.prop('disabled', true).text('Saving & Sending...');

        $.ajax({
            url: "<?= base_url(); ?>grantee/submission/add_recommender",
            method: "POST",
            dataType: "JSON",
            data: {
                grantee_grant_id: grantee_grant_id,
                step_id: step_id,
                fields: fields,
                prefix: prefix,
                first_name: firstName,
                last_name: lastName,
                institution: institution,
                position: position,
                relationship: relationship,
                telephone: telephone,
                email: email
            }
        })
        .done(function(res) {
            btn.prop('disabled', false).text('Save & Send');
            if (res.status) {
                Swal.fire({
                    icon: 'success',
                    title: 'Added',
                    text: res.message,
                    timer: 2500,
                    showConfirmButton: false
                });
                $('[id^="add_cf_"]').val('');
                $('#add_prefix').val('');
                $('#add_firstName').val('');
                $('#add_lastName').val('');
                $('#add_institution').val('');
                $('#add_position').val('');
                $('#add_relationship').val('');
                $('#add_telephone').val('');
                $('#add_email').val('');

                $('#add-recommender-card').slideUp();
                $('#btnAddRecommender').text('+ Add Recommender');

                loadRecommendationList(grantee_grant_id, section);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: res.message || 'Failed to add recommender.'
                });
            }
        })
        .fail(function() {
            btn.prop('disabled', false).text('Save & Send');
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Server error while adding recommender.'
            });
        });
    }

    function excludeRecommender(id) {
        var grantee_grant_id = $('#send-email-recommendation-modal').data('id');
        var section = $('#send-email-recommendation-modal').data('section');

        Swal.fire({
            title: 'Exclude Recommender?',
            text: 'This will deactivate the recommender\'s link. They will not be able to submit their recommendation.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f59e0b',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, Exclude'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= base_url(); ?>grantee/submission/exclude_recommender",
                    method: "POST",
                    dataType: "JSON",
                    data: { id: id }
                })
                .done(function(res) {
                    if (res.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Excluded',
                            text: res.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                        loadRecommendationList(grantee_grant_id, section);
                    } else {
                        Swal.fire('Error', res.message || 'Failed to exclude.', 'error');
                    }
                })
                .fail(function() {
                    Swal.fire('Error', 'Server error while excluding recommender.', 'error');
                });
            }
        });
    }

    function reinstateRecommender(id) {
        var grantee_grant_id = $('#send-email-recommendation-modal').data('id');
        var section = $('#send-email-recommendation-modal').data('section');
        var max_multiple = parseInt($('#send-email-recommendation-modal').data('max_multiple'), 10) || 0;
        var active_count = parseInt($('#send-email-recommendation-modal').data('active_count'), 10) || 0;

        if (max_multiple > 0 && active_count >= max_multiple) {
            Swal.fire({
                icon: 'warning',
                title: 'Limit Reached',
                text: 'Cannot reinstate recommender. You already have ' + max_multiple + ' active recommenders. Please exclude or delete another recommender first.'
            });
            return;
        }

        Swal.fire({
            title: 'Reinstate Recommender?',
            text: 'A new recommendation invitation email with a fresh link will be sent to the recommender.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, Reinstate & Send Email'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Reinstating...',
                    text: 'Generating new link and dispatching email...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                $.ajax({
                    url: "<?= base_url(); ?>grantee/submission/reinstate_recommender",
                    method: "POST",
                    dataType: "JSON",
                    data: { id: id }
                })
                .done(function(res) {
                    if (res.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Reinstated',
                            text: res.message,
                            timer: 3000,
                            showConfirmButton: false
                        });
                        loadRecommendationList(grantee_grant_id, section);
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Cannot Reinstate',
                            text: res.message || 'Failed to reinstate.'
                        });
                    }
                })
                .fail(function() {
                    Swal.fire('Error', 'Server error while reinstating recommender.', 'error');
                });
            }
        });
    }

    function deleteRecommender(id) {
        var grantee_grant_id = $('#send-email-recommendation-modal').data('id');
        var section = $('#send-email-recommendation-modal').data('section');

        Swal.fire({
            title: 'Delete Recommender?',
            text: 'Are you sure you want to delete this recommender? Their recommendation request and submission data will be permanently removed.',
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, Delete'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= base_url(); ?>grantee/submission/delete_recommender",
                    method: "POST",
                    dataType: "JSON",
                    data: { id: id }
                })
                .done(function(res) {
                    if (res.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted',
                            text: res.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                        loadRecommendationList(grantee_grant_id, section);

                        if (res.multiple_step_id) {
                            $('.multiple-step-' + res.multiple_step_id).remove();
                        }
                    } else {
                        Swal.fire('Error', res.message || 'Failed to delete.', 'error');
                    }
                })
                .fail(function() {
                    Swal.fire('Error', 'Server error while deleting recommender.', 'error');
                });
            }
        });
    }

    $(document).on('click', '.btn-recommended', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var section = $(this).data('section');

        $('#send-email-recommendation-modal')
            .data('id', id)
            .data('section', section)
            .modal('show');

        loadRecommendationList(id, section);
    });
</script>