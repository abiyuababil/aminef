<script>
    $(document).ready(function(){
        $('.select_multiselect').select2();
        $(".select_multiselect").on('select_multiselect:close', function () {
            $(this).trigger('blur');
        });
        
        $(".autosave").blur(function(){
            var element = $(this);
            var data_value = $(this).val();
            var custom_fields_id = $(this).data('id');
            var is_required = $(this).attr("required");
            var group_element_id = $(this).data("index");

            // add logic for checkbox
            if ($(this).is(':checkbox')){
                data_value = [];
                    $.each($(`input:checkbox.check-${custom_fields_id}:checked`), function(){
                        data_value.push($(this).val())
                    })
            }

            // add logic for multiple choice grid 
            if ($(this).hasClass('multiple-choice-grid')){
                data_value = [];
                $.each($(`.table_${custom_fields_id} input:radio.multiple-choice-grid:checked`), function(){
                    data_value.push($(this).val())
                })
                
            }

            var step_id = $(this).data('step');
            var category_id = $(this).data('category-id');
            var grant_id = $(this).data('grant-id');
            var period_id = $(this).data('period-id');
            var user_id = $('#grantee_id').val();

            // check if other value
            var data = {
                value: data_value,
                user_grantee_custom_fields_id: custom_fields_id,
                user_grantee_step_id: step_id,
                user_grantee_category_id: category_id,
                user_grantee_grant_id: grant_id,
                user_grantee_period_id: period_id,
                group_element_id: group_element_id,
                user_grantee_id: user_id,
                grantee_grant_id: '<?= $grantee_grant->id ?>',
                is_other: false
            };
            if ($(this).hasClass('text-have-other')){
                data['is_other'] = true; 
            }

            $.ajax({
                url: "<?= base_url(); ?>admin/grantee/save_fields",
                method: "POST",
                data: data
            })
            .success(function(data){
                
            })
        })

        $('.datepicker').change(function(){
            $(this).blur();
        });
    });

    function show_preview(element, type) {
        const file = element.files[0];
        
        if (file){
            let reader = new FileReader();
            let filename = file.name;
            let ext = filename.split('.').pop();

            const allowed_extensions = ['gif', 'jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx', 'xsl', 'xlsx', 'heic', 'heif'];

            const is_valid_extension = allowed_extensions.some(function(extension) {
                return ext.toLowerCase().endsWith(extension);
            });
            let pdf_icon = '<?php echo base_url('assets/images/icons/pdf.svg'); ?>';
            let download_icon = '<?php echo base_url('assets/images/icons/download icon.png'); ?>';
            reader.onload = function(event){
                if(ext == 'jpg' || ext == 'png' || ext == 'jpeg') {
                    $('#preview_image_' + type).attr('src', event.target.result);
                } else if(ext == 'pdf') {
                    $('#preview_image_' + type).attr('src', pdf_icon);
                } else {
                    $('#preview_image_' + type).attr('src', download_icon);
                }
                
            }

            reader.readAsDataURL(file);
        }
    }

    function add_file(button_id)
    {
        $("#" + button_id).trigger('click');
    }

    function add_more_step_fields(element)
    {
        var step_id = $(element).data("id");
        var user_grantee_category_id = $(element).data("user_grantee_category_id");
        var user_grantee_grant_id = $(element).data("user_grantee_grant_id");
        var period_id = $(element).data("period_id");
        $(".add-multiple-step-spinner-"+step_id).show();
        
        var formData = new FormData();
        formData.append("user_grantee_step_id", step_id),
        formData.append("user_grantee_category_id", user_grantee_category_id),
        formData.append("user_grantee_grant_id", user_grantee_grant_id),
        formData.append("period_id", period_id),
        formData.append("grantee_grant_id", <?= $grantee_grant->id ?>)

        $.ajax({
            url: "<?= base_url(); ?>admin/grantee/multiple_field_step", 
            type: 'POST',
            data: formData, // The form with the file inputs.
            processData: false,
            contentType: false                    // Using FormData, no need to process data.
        }).done(function(r){
            $(".wrap-step-" + step_id).append(r);
            $(".add-multiple-step-spinner-"+step_id).hide();
            $('.lightbox').topbox();
            
            // for radio group purpose
            $(".radio-group").click(function(){
                var get_parent_id = $(this).closest('div').attr('id');
                var data_show = $(this).data('show');
                // hide other than this class 
                $("#"+get_parent_id+" .show-group[data-element!='"+data_show+"']").addClass('hide');
                $("#"+get_parent_id+" .show-group[data-element='"+data_show+"']").removeClass('hide');
            })

            $("input:radio.radio-group:checked").trigger("click");
            $(".select_multiselect").select2();
            $(".have_other").change(function() {
                if ($(this).is('input[type="checkbox"]')){
                    if ($(this).is(':checked') && $(this).val() == 'Other'){
                        $(".text-other-" + $(this).data('show')).show();
                    }else if (!$(this).is(':checked') && $(this).val() == 'Other'){
                        $(".text-other-" + $(this).data('show')).hide();
                    }
                }else {
                    if (Array.isArray($(this).val())){
                        if ($(this).val().includes("Other")){
                            $(".text-other-" + $(this).data('show')).show();
                        }else{
                            $(".text-other-" + $(this).data('show')).hide();
                        }
                    } else{
                        // show other
                        if ($(this).val() == 'Other'){
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
            $( ".datepicker" ).datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "dd M yy",
                yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
            });
            // let country_tag = $(r).find(".select2-country");
            // let elemet_id_country = country_tag.data('multiple-step-id');
            // if(elemet_id_country) {
            //     $('.select2-country_' + elemet_id_country).select2({
            //         placeholder: "Select a country",
            //     });
            // }

            // let country_tag = $(r).find(".select2-country");
            // let elemet_id_country = country_tag.data('multiple-step-id');
            // if(elemet_id_country) {
            //     $('.select2-country_' + elemet_id_country).select2();
            //     $('.select2-country_' + elemet_id_country).on('select2:select', function () {
            //         $(this).attr('data-value', $(this).val());
            //         $(this).trigger('blur');
            //         let key_of_unique = $(this).data('select_key_country');
            //         $(".select2-state[data-select_key_country='"+key_of_unique+"']").val(null).trigger('change').trigger('blur');
            //         $(".select2-city[data-select_key_country='"+key_of_unique+"']").val(null).trigger('change').trigger('blur');
            //     });
            // }

            let state_tag = $(r).find(".select2-state");
            let elemet_id_state = state_tag.data('multiple-step-id');
            if(elemet_id_state) {
                $('.select2-state_' + elemet_id_state).select2({
                    placeholder: "Select a state",
                    ajax: {
                        url: function (params) {
                            let key_of_unique = $(this).data('select_key_country');
                            let country_id = $(".select2-country[data-select_key_country='"+key_of_unique+"']").val();
                            return '<?php echo site_url('world/data_state') ?>' + (country_id ? '/' + country_id : '');
                        },
                        dataType: 'json'
                    }
                });
                $('.select2-state_' + elemet_id_state).on('select2:select', function () {
                    $(this).attr('data-value', $(this).val());
                    $(this).trigger('blur');
                    let key_of_unique = $(this).data('select_key_country');
                    $(".select2-city[data-select_key_country='"+key_of_unique+"']").val(null).trigger('change').trigger('blur');
                });
            }

            let city_tag = $(r).find(".select2-city");
            let elemet_id_city = city_tag.data('multiple-step-id');
            if(elemet_id_city) {
                $('.select2-city_' + elemet_id_city).select2({
                    placeholder: "Select a city",
                    ajax: {
                        url: function (params) {
                            let key_of_unique = $(this).data('select_key_country');
                            let state_id = $(".select2-state[data-select_key_country='"+key_of_unique+"']").val();
                            return '<?php echo site_url('world/data_city') ?>' + (state_id ? '/' + state_id : '');
                        },
                        dataType: 'json'
                    }
                });
                $('.select2-city_' + elemet_id_city).on('select2:select', function () {
                    $(this).trigger('blur');
                });
            }

            let parent_study_tag = $(r).find(".select2-parent-field-of-study");
            let parent_study_id = parent_study_tag.data('multiple-step-id');
            if(parent_study_id) {
                $('.select2-parent-field-of-study_' + parent_study_id).select2({
                    placeholder: "Select Field of Study"
                });
                $('.select2-parent-field-of-study_' + parent_study_id).on('select2:select', function () {
                    $(this).trigger('blur');
                    let key_of_unique = $(this).data('select_key_state_of_study');
                    $(".select2-field-of-study[data-select_key_state_of_study='"+key_of_unique+"']").val(null).trigger('change').trigger('blur');
                });
            }

            let study_tag = $(r).find(".select2-field-of-study");
            let study_id = study_tag.data('multiple-step-id');
            if(study_id) {
                $('.select2-field-of-study_' + study_id).select2({
                    placeholder: "Select Specialization",
                    ajax: {
                        url: function (params) {
                            let key_of_unique = $(this).data('select_key_state_of_study');
                            let parent_id = $(".select2-parent-field-of-study[data-select_key_state_of_study='"+key_of_unique+"']").val();
                            return '<?php echo site_url('world/field_of_study') ?>' + (parent_id ? '/' + parent_id : '');
                        },
                        dataType: 'json'
                    }
                });
                $('.select2-field-of-study_' + study_id).on('select2:select', function () {
                    $(this).trigger('blur');
                });
            }
        });

    }
    
    function upload_button(element){

        var data_value = $(element).data('file-value');
        var fileview   = $(element).closest('.col-lg-4').find('.fileview'); 
        var fileviewFull   = $(element).closest('.is_row_class').find('.fileview'); 
        var icon       = $(element).closest('.col-lg-4').find('.submission-spinner'); 
        var base_url   = "<?= base_url()?>";
        // trigger click to closest type file
        $(`.${data_value}`).click();

        // add event when file has choosen
        $(`.${data_value}`).change(function(e){
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
            var fileName = e.target.files[0].name;
            $(this).removeAttr('required');

            // set filename into label
            $(this).closest('.col-lg-4').find('.filename').html(fileName)
            $(this).closest('.is_row_class').find('.filename').html(fileName).attr('title', fileName)
            icon.css('display', 'block')

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
            formData.append("grantee_grant_id", <?= $grantee_grant->id ?>),
            formData.append("user_grantee_id", <?= $grantee_grant->user_grantee_id ?>),
            formData.append("group_element_id", group_element_id)

            // autosave
            $.ajax({
                url: "<?= base_url(); ?>admin/grantee/save_fields", 
                type: 'POST',
                data: formData, // The form with the file inputs.
                processData: false,
                contentType: false
            }).done(function(r){

                var postsjson = $.parseJSON(r);

                if(postsjson.redirect){
                    window.location.href = postsjson.redirect;
                    return false
                }
                
                icon.css("display", "none");
                fileview.css("display", "inline-block");
                fileview.attr("href", base_url+postsjson.filepath );
                fileviewFull.css("display", "inline-block");
                fileviewFull.attr("href", base_url+postsjson.filepath );
                $(".btn-download"+upload_id).attr("href", base_url+postsjson.filepath );
                var currentOnclick = $(".btn-delete" + upload_id).attr('onclick');
                if (currentOnclick != undefined) {
                    var newOnclick = currentOnclick.replace(/'subid'/g, postsjson.submission_id);
                    $(".btn-delete" + upload_id).attr('onclick', newOnclick);
                }
                $(".btn-delete"+upload_id).removeClass("hide");
                $(".btn-download"+upload_id).removeClass("hide");
                // if (error == 0){
                //     $(".next, .submit-submission").removeClass("disabled");
                // }else{
                //     $(".next, .submit-submission").addClass("disabled");
                // }
            });
        })
    }

    function submission_onblur(element) {
        // var element = $(this);
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
        var user_id = $('#grantee_id').val();

        // add logic for checkbox
        if ($(element).is(':checkbox')){
            data_value = [];
                $.each($(`input:checkbox.check-${custom_fields_id}-${multiple_id}:checked`), function(){
                    data_value.push($(this).val())
                })
        }

        // add logic for multiple
        if ($(element).hasClass('multiple-select')){
            data_value = $(element).val();
        }

        // add logic for multiple choice grid 
        if ($(element).hasClass('multiple-choice-grid-multi')){
            data_value = [];
            $.each($(`.table_${custom_fields_id}_${multiple_id} input:radio.multiple-choice-grid-multi:checked`), function(){
                data_value.push($(this).val())
            })
            
        }
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
            user_grantee_id: user_id,
            grantee_grant_id: '<?= $grantee_grant->id ?>',
            is_other: false
        };
        if ($(element).hasClass('text-have-other')){
            data['is_other'] = true; 
        }

        $.ajax({
            url: "<?= base_url(); ?>admin/grantee/save_fields",
            method: "POST",
            dataType: "JSON",
            data: data
        })
        .success(function(data){
            if (data.success == false){
                $(element).nextAll().remove();
                var appendData = $("<p></p>").text(data.message).css("color", "red");
                $(element).after(appendData);
            }
        })
    }
    
    $(".next").click(function() {
        const current_tab = $(this).closest('.tab-pane');

        var selected = $(".tabs").tabs("option", "active");
        var data = $(this).data('index');
        $("#" + data).addClass("active in");
        $(".tabs").tabs("option", "active", selected + 1);
        location.hash = "#" + data;
    });
    
    $(".previous").click(function() {
        const current_tab = $(this).closest('.tab-pane');

        var selected = $(".tabs").tabs("option", "active");
        var data = $(this).data('index');
        $("#" + data).addClass("active in");
        $(".tabs").tabs("option", "active", selected - 1);
        location.hash = "#" + data;
    });

    $(document).on("change", ".upload-guide-file-applicant", function(e){
        e.preventDefault();
        let element = $(this);
        let file = e.target.files[0];
        
        let form_data = new FormData();
        form_data.append("file", file);
        let user_grantee_custom_field_id = $(this).data("user_grantee_custom_field_id");
        let user_grantee_id = $(this).data("user_grantee_id");
        let user_grantee_grant_id = $(this).data("user_grantee_grant_id");
        form_data.append("type", 'file');
        form_data.append("user_grantee_custom_field_id", user_grantee_custom_field_id);
        form_data.append("user_grantee_grant_id", user_grantee_grant_id);
        form_data.append("user_grantee_id", user_grantee_id);
        
        if (file !== undefined && file !== null) {
            $(".button-download-file-guide-" + user_grantee_custom_field_id).each(function() {
                let label = $(this).closest('div').find('label');
                label.html('<i class="fa fa-spinner fa-spin"></i>');
            });
        }

        $.ajax({
            url: "<?php echo site_url('admin/user_grantee_grant/save_file'); ?>",
            type: "POST",
            data: form_data,
            processData: false,
            contentType: false,
            dataType : 'JSON',
            success: function(response) {
                if (response.success) {

                    $(".button-download-file-guide-" + user_grantee_custom_field_id).each(function(){
                        $(this).attr('href', response.data.fileurl);
                    });

                    element.closest('div').find('label').html('<i class="fa fa-check"></i>');

                    setTimeout(function(){
                        $(".button-download-file-guide-" + user_grantee_custom_field_id).each(function() {
                            let label = $(this).closest('div').find('label');
                            label.html('<i class="fa fa-upload"></i>');
                        });
                    }, 1000);
                }
            },
            error: function(response) {
                console.error(error);
                alert(response.responseText);
                setTimeout(function(){
                    $(".button-download-file-guide-" + user_grantee_custom_field_id).each(function() {
                        let label = $(this).closest('div').find('label');
                        label.html('<i class="fa fa-upload"></i>');
                    });
                }, 1000);
            }
        });
    });


    

    function navigate_tab(id) {
        location.hash = "#step_" + id;
        
    }

    
    
    function accept_submission(user_id, grant_id) {
        if (confirm("Are you sure this grantee is Accept ?")){
            var note = $('#note_submission').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/grantee/accept_submission') ?>',
                data: {
                    note    : note,
                    user_id : user_id,
                    grant_id : grant_id,
                },
                success: function(r) {
                    if(r.err_message == false){
                        location.href=r.redirect;
                    }
                }
            });
        }

    }

    function revise_submission(user_id, grant_id) {
        if (confirm("Are you sure this grantee is Revise ?")){
            var note = $('#note_submission').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/grantee/revise_submission') ?>',
                data: {
                    note    : note,
                    user_id : user_id,
                    grant_id : grant_id,
                },
                success: function(r) {
                    if(r.err_message == false){
                        location.href=r.redirect;
                    }
                }
            });
        }

    }
    
    function accept_submission_us(user_id, grantee_grant_id, grant_id, category_id) {
        if (confirm("Are you sure this grantee is Accept ?")){
            var note = $('#note_submission'+grant_id).val();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/grantee/accept_submission') ?>',
                data: {
                    note    : note,
                    user_id : user_id,
                    grantee_grant_id : grantee_grant_id,
                    grant_id : grant_id,
                    category_id : category_id
                },
                success: function(r) {
                    if(r.err_message == false){
                        location.href=r.redirect;
                    }
                }
            });
        }

    }

    function revise_submission_us(user_id, grantee_grant_id, grant_id, category_id) {
        if (confirm("Are you sure this grantee is Revise ?")){
            var note = $('#note_submission'+grant_id).val();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/grantee/revise_submission') ?>',
                data: {
                    note    : note,
                    user_id : user_id,
                    grantee_grant_id : grantee_grant_id,
                    grant_id : grant_id,
                    category_id : category_id
                },
                success: function(r) {
                    if(r.err_message == false){
                        location.href=r.redirect;
                    }
                }
            });
        }

    }
    
    function accept_submission_document(user_id, grantee_grant_id, grant_id, category_id) {
        if (confirm("Are you sure this grantee is Complete ?")){
            var note = $('#note_document').val();
            var document = $('#document').val();
            $("#btn-accept-submission").html('<img src="<?php echo base_url() ?>/img/loading.gif">')
            $(".btn").attr('disabled', 'disabled');
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/new_grantee/accept_submission_document') ?>',
                data: {
                    note    : note,
                    user_id : user_id,
                    grantee_grant_id : grantee_grant_id,
                    grant_id : grant_id,
                    document : document,
                    category_id : category_id
                },
                success: function(r) {
                    if(r.err_message == false){
                        location.href=r.redirect;
                    }
                }
            });
        }

    }

    function revise_submission_document(user_id, grantee_grant_id, grant_id, category_id) {
        if (confirm("Are you sure this grantee is Revise ?")){
            var note = $('#note_document').val();
            var document = $('#document').val();
            $("#btn-revise-submission").html('<img src="<?php echo base_url() ?>/img/loading.gif">')
            $(".btn").attr('disabled', 'disabled');
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/new_grantee/revise_submission_document') ?>',
                data: {
                    note    : note,
                    user_id : user_id,
                    grantee_grant_id : grantee_grant_id,
                    grant_id : grant_id,
                    document : document,
                    category_id : category_id
                },
                success: function(r) {
                    if(r.err_message == false){
                        location.href=r.redirect;
                    }
                }
            });
        }

    }

    function arrived_submission_document(user_id, grantee_grant_id, grant_id, category_id) {
        if (confirm("Are you sure this grantee is Arrived ?")){
            var note = $('#note_document').val();
            var document = $('#document').val();
            $("#btn-arrived-submission").html('<img src="<?php echo base_url() ?>/img/loading.gif">')
            $(".btn").attr('disabled', 'disabled');
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/new_grantee/arrived_submission_document') ?>',
                data: {
                    note    : note,
                    user_id : user_id,
                    grantee_grant_id : grantee_grant_id,
                    grant_id : grant_id,
                    document : document,
                    category_id : category_id
                },
                success: function(r) {
                    if(r.err_message == false){
                        location.href=r.redirect;
                    }
                }
            });
        }

    }

    function withdraw_submission_document(user_id, grantee_grant_id, grant_id, category_id) {
        if (confirm("Are you sure this grantee is Withdraw ?")){
            var note = $('#note_document').val();
            var document = $('#document').val();
            $("#btn-withdraw-submission").html('<img src="<?php echo base_url() ?>/img/loading.gif">')
            $(".btn").attr('disabled', 'disabled');
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/new_grantee/withdraw_submission_document') ?>',
                data: {
                    note    : note,
                    user_id : user_id,
                    grantee_grant_id : grantee_grant_id,
                    grant_id : grant_id,
                    document : document,
                    category_id : category_id
                },
                success: function(r) {
                    if(r.err_message == false){
                        location.href=r.redirect;
                    }
                }
            });
        }

    }

    function permit_reject_submission_document(user_id, grantee_grant_id, grant_id, category_id) {
        if (confirm("Are you sure this grantee is Reject ?")){
            var note = $('#note_document').val();
            var document = $('#document').val();
            $("#btn-permit-reject-submission").html('<img src="<?php echo base_url() ?>/img/loading.gif">')
            $(".btn").attr('disabled', 'disabled');
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/new_grantee/permit_reject_submission_document') ?>',
                data: {
                    note    : note,
                    user_id : user_id,
                    grantee_grant_id : grantee_grant_id,
                    grant_id : grant_id,
                    document : document,
                    category_id : category_id
                },
                success: function(r) {
                    if(r.err_message == false){
                        location.href=r.redirect;
                    }
                }
            });
        }

    }

    function notify_grantee_submission(user_id, grantee_grant_id, grant_id, category_id) {
        var btnNotifyHtml = $("#btn-notify-grantee-submission").html();
        Swal.fire({
            title: 'Notify Grantee?',
            text: 'Are you sure you want to notify this grantee ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then(function(result) {
            if (!result.isConfirmed) {
                return;
            }
            var note = $('#note_document').val();
            var document = $('#document').val();
            $("#btn-notify-grantee-submission").html('<img src="<?php echo base_url() ?>/img/loading.gif">')
            $(".btn").attr('disabled', 'disabled');
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/new_grantee/notify_grantee_submission_document') ?>',
                data: {
                    note    : note,
                    user_id : user_id,
                    grantee_grant_id : grantee_grant_id,
                    grant_id : grant_id,
                    document : document,
                    category_id : category_id
                },
                success: function(r) {
                    if(r.err_message == false){
                        Swal.fire({
                            title: 'Success',
                            text: 'Grantee has been notified.',
                            icon: 'success'
                        }).then(function() {
                            location.href=r.redirect;
                        });
                    } else {
                        $("#btn-notify-grantee-submission").html(btnNotifyHtml);
                        $(".btn").removeAttr('disabled');
                        Swal.fire({
                            title: 'Failed',
                            text: r.err_message || 'Failed to notify grantee.',
                            icon: 'error'
                        });
                    }
                },
                error: function() {
                    $("#btn-notify-grantee-submission").html(btnNotifyHtml);
                    $(".btn").removeAttr('disabled');
                    Swal.fire({
                        title: 'Failed',
                        text: 'Failed to notify grantee. Please try again.',
                        icon: 'error'
                    });
                }
            });
        });

    }
    
    function add_more_submission_radio_group(element, is_multiple = false) {
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
        var grantee_grant_id = $("#grantee_grant_id").val();
        var user_grantee_id = $("#grantee_id").val();
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
            formData.append("grantee_grant_id", grantee_grant_id)
            formData.append("user_grantee_id", user_grantee_id)

            $.ajax({
                url: "<?= base_url(); ?>admin/grantee/multiple_file_radio",
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
                console.log("🚀 ~ file: form_js.php:442 ~ elemet_id_country:", elemet_id_country)
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
    }
</script>