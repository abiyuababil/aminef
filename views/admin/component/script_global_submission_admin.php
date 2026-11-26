<script>
    $(document).ready(function() {
        $('.upload-button').each(function() {
            if ($(this).closest('.item-sub').find('.fileview').not('.hide').length) {
                $(this).text('Change File');
            }
        });
    });

    $(document).on('click', '.upload-button', function() {

        var data_value      = $(this).data('file-value');
        var fileview        = $(this).closest('.col-lg-4').find('.fileview'); 
        var fileviewFull    = $(this).closest('.item-sub').find('.fileview'); 
        var icon            = $(this).closest('.col-lg-4').find('.submission-spinner'); 
        var base_url        = "<?= base_url()?>";

        // bind change first, then open picker only when empty
        var file_input = $(`.${data_value}`);
        file_input.off('change').on('change', function(e) {

            // define variable name
            const elThis = $(this);
            var custom_fields_id = $(this).data('id');
            var step_id = $(this).data('step');
            var category_id = $(this).data('category-id');
            var grant_id = $(this).data('grant-id');
            var user_id = $('#grantee_id').val() || <?= $grantee_grant->user_grantee_id ?? null ?>;
            var grantee_grant_id = $("#grantee_grant_id").val() || <?= $grantee_grant->id ?? null ?>;
            var period_id = $(this).data('period-id');
            var multiple_id = $(this).data('multiple-id');
            var multiple_step_id = $(this).data('multiple-step-id');
            var upload_id = $(this).data("upload-id");
            var group_element_id = $(this).data('index');
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
                    timer: 1500
                });
                return false
            }

            // set filename into label
            var substrFileName = fileName;
            if(substrFileName.length > 15){
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
            formData.append("user_grantee_id", user_id),
            formData.append("grantee_grant_id", grantee_grant_id),
            formData.append("user_grantee_period_id", period_id),
            formData.append("multiple_file_id", multiple_id),
            formData.append("multiple_step_id", multiple_step_id),
            formData.append("group_element_id", group_element_id)

            // autosave
            $.ajax({
                url: "<?= base_url(); ?>admin/grantee/save_fields", 
                type: 'POST',
                data: formData, // The form with the file inputs.
                processData: false,
                contentType: false                    // Using FormData, no need to process data.
            }).done(function(r){
                console.log("Success: Files sent!");
                var postsjson = $.parseJSON(r);
                if(postsjson.success){
                    if(postsjson.redirect){
                        window.location.href = postsjson.redirect;
                        return false
                    }
                    fileviewFull.removeClass("hide");
                    fileviewFull.attr("href", base_url + postsjson.filepath);
                    // icon.css("display", "none");
                    $(".btn-download" + upload_id).attr("href", base_url + postsjson.filepath);
                    $(".btn-delete" + upload_id).removeClass("hide");
                    $(".btn-download" + upload_id).removeClass("hide");
                    elThis.closest('.item-sub').find('.upload-button').text('Change File');
    
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
            }).fail(function() {
                Swal.fire({
                    icon: "error",
                    title: "Failed to upload the file. Please make sure the data is below 5Mb",
                    showConfirmButton: false,
                    timer: 2000
                });
            });

            $(this).val('');
        });

        if (file_input.length && file_input[0].files && file_input[0].files.length) {
            file_input.trigger('change');
        } else {
            file_input.click();
        }
    });
    
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
                url: '<?php echo base_url('admin/grantee/delete_submission_value') ?>/' + submissionId,
                dataType: 'JSON',
                success: function(r) {
                    barLeft.html(`<svg class="icon-svg" viewBox="0 0 24 24" style="color: #94a3b8; stroke-width: 1.5;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg><div><span style="color: #64748b; font-size: 13px;">No file selected yet...</span></div>`);
                    $(el).closest('.item-sub').find('.upload-button').text('Upload');
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

    function add_more_submission(element, is_multiple = false, file = null) {
        var custom_field_id = $(element).data("id");
        var label = $(element).data('label');
        var step_id = $(element).data('step');
        var category_id = $(element).data('category-id');
        var grant_id = $(element).data('grant-id');
        var period_id = $(element).data('period-id');
        var category_type = $(element).data('category-type');
        var multiple_step_id = $(element).data('multiple-step-id');
        var type = $(element).data('type');
        var multiple_step_id = $(element).data('multiple-step-id');
        var grantee_grant_id = $("#grantee_grant_id").val() || <?= $grantee_grant->id ?? null ?>;
        var user_grantee_id = $("#grantee_id").val() || <?= $grantee_grant->user_grantee_id ?? null ?>;

        if (type === 'file' && !file) {
            pick_submission_file(function(chosen) {
                add_more_submission(element, is_multiple, chosen);
            });
            return;
        }

        // $(".add-multiple-file-spinner-"+custom_field_id).show();
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
        formData.append("grantee_grant_id", grantee_grant_id),
        formData.append("user_grantee_id", user_grantee_id)

        $.ajax({
            url: "<?= base_url(); ?>admin/grantee/multiple_file", 
            type: 'POST',
            data: formData, // The form with the file inputs.
            processData: false,
            contentType: false                    // Using FormData, no need to process data.
        }).done(function(r){
            Swal.close();
            var $new = $(r);
            if(is_multiple){
                if(type === 'file'){
                    $(".wrap-file-step-" + custom_field_id).find('.sub-item').append($new);
                }else{
                    $(".wrap-file-step-" + custom_field_id).append($new);
                }
                $(".add-multiple-file-spinner-"+custom_field_id).hide();
            }else{
                if(type === 'file'){
                    $(".wrap-file-" + custom_field_id).find('.sub-item').append($new);
                }else{
                    $(".wrap-file-" + custom_field_id).append($new);
                }
                $(".add-multiple-file-spinner-" + custom_field_id).hide();
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
            initSelect2(r);

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
    
    function del_multiple(el, item_class) {
        if (confirm("Are you sure want to delete this ?")) {
            var multiple_id = $(el).data("multiple-id");
            $(".delete-multiple-spinner-"+multiple_id).show();
            Swal.showLoading();
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url('admin/grantee/delete_multiple') ?>/' + multiple_id,
                dataType: 'JSON',
                success: function(r) {
                    if(r.status){
                        $(el).closest('.' + item_class).remove();
                        Swal.close();
                    }
                    $(".delete-multiple-spinner-"+multiple_id).hide();
                }
            });
        }
    }

    function del_multiple_step(el, item_class) {
        if (confirm("Are you sure want to delete this ?")) {
            var multiple_id = $(el).data("id");
            $(".delete-multiple-step-spinner-" + multiple_id).show();
            Swal.showLoading();
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url('admin/grantee/delete_multiple_step') ?>/' + multiple_id,
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

</script>