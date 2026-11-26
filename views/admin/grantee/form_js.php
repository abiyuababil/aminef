<script src="<?php echo base_url() ?>js/wijmo.min.js"></script>

<script>
    const SITE_URL = '<?php echo site_url(); ?>';
    // $('#form').on('submit', function() {

    //     var valid_email = /^(([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)(\s*;\s*|\s*$))*$/;

    //     if ($('#primary_email').val() != '' && !valid_email.test($('#primary_email').val())) {
    //         alert('Email not valid.');
    //         $('#primary_email').focus();
    //         return false;
    //     }

    //     return true;
    // });

    if (academic_form.length > 0) {
        for (let i = 0; i < academic_form.length; i++) {
            $('#degree_name' + i).change(function(e) {
                if (this.value == 'Other') {
                    $("#other_degree_col" + i).css('display', 'block')
                } else {
                    $("#other_degree_col" + i).css('display', 'none')
                }
            })
        }
    }

    $('#degree_name').change(function(e) {
        if (this.value == 'Other') {
            $("#other_degree_col").css('display', 'block')
        } else {
            $("#other_degree_col").css('display', 'none')
        }
    })

    function show_pcode(el_country, el_pcode) {
        var country_code = $('#' + el_country + ' option:selected').attr('data-pcode');
        if (country_code != undefined)
            $('#' + el_pcode).val('+' + country_code);
    }

    $(function() {
        show_pcode('of_country', 'of_phone_code');
        show_pcode('country', 'street');
    });

    function del_item(el, item_class) {
        if (confirm("Are you sure want to delete this ?"))
            $(el).closest('.' + item_class).remove();
    }

    function add_label() {
        var idx = $('.label-item').length;
        $('.add-load-label').show();
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('world/getPartial') ?>/' + idx,
            dataType: 'JSON',
            success: function(r) {
                var html = r;
                $('#wrap-label').append(html);
                $('.select2').select2({
                    theme: 'bootstrap'
                });
                $('.add-load-label').hide();
            }
        });
    }

    function add_institution() {
        var idx = $('.institution-item').length;
        $('.add-load').show();
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('world/getPartialInstitution') ?>/' + idx,
            dataType: 'JSON',
            success: function(r) {
                var html = r;
                $('#wrap-institution').append(html);
                $('.select2').select2({
                    theme: 'bootstrap'
                });
                $('.add-load').hide();
                $(".datepicker").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: "dd M yy",
                    yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
                });
            }
        });
    }

    function generate_pass() {
        $('.generate-load').show();
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('world/rand_string') ?>',
            dataType: 'JSON',
            success: function(r) {
                $("#password").val(r);
                $('.generate-load').hide();
            }
        });
    }

    function add_mobile_number() {
        var idx = $('.opdt-item').length;
        var html = '';
        html = '<div id="opdt-item-' + idx + '" class="row opdt-item" style="position:relative">';
        html += '	<div class="col-lg-12">';
        html += '		<div class="form-group">';
        html += '			<label>Cell Phone Number</label>';
        html += '			<input class="form-control" name="phone_number[]" value="">';
        html += '		</div>';
        html += '	</div>';
        html += '	<a href="javascript:;" onclick="del_item(this, \'opdt-item\')" class="btn btn-danger" style="position:absolute; top:25px; right:15px;"><i class="fa fa-trash fa-fw"></i></a>';
        html += '</div>';
        $('#wrap-phone').append(html);
    }

    function del_file(el, name, label, value = '') {
        let section = label.toLowerCase().replace(/ /g, '_');
        if (label == 'Photo') {
            section = 'profile';
        }

        $("input[name='" + name + "']").val("");

        let element = $("#preview_image_" + section);

        if (confirm("Are you sure want to delete " + label + " ?")) {

            let default_preview_image = SITE_URL + 'assets/images/profile.png';
            let active_country = '<?php echo $user_grantee->country_id; ?>';

            if (name == 'img_passport') {
                if (active_country == '<?php echo AMERICAN_DATABASE; ?>') {
                    default_preview_image = SITE_URL + 'assets/images/passport.png';
                } else {
                    default_preview_image = SITE_URL + 'assets/images/idcard.png';
                }
            }

            if (name == 'account_book') {
                default_preview_image = SITE_URL + 'assets/images/accountbook.png';
            }
            if (name == 'cv') {
                default_preview_image = SITE_URL + 'assets/images/icons/document-filetype.png';
            }

            element.attr('src', default_preview_image);
            $("#button_preview_" + name).attr('href', default_preview_image);
            $("#button_download_" + name).attr('href', default_preview_image).addClass('hide');
            $("#button_delete_" + name).addClass('hide');

            return false;
        }
    }

    $(".select-country").change(function() {
        var state_el = this.id.split('_')[0] + '_state';
        var load_id = '#load-' + state_el;
        $(load_id).show();
        reset_state(this.id);
        reset_city(this.id);
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('world/state') ?>/' + this.value,
            dataType: 'JSON',
            success: function(r) {
                $.each(r, function(id, val) {
                    $('#' + state_el).append('<option value="' + val.id + '">' + val.name + '</option>');
                });
                $(load_id).hide();
            }
        });
    });

    $(".select-state").change(function() {
        var city_el = this.id.split('_')[0] + '_city';
        var load_id = '#load-' + city_el;
        $(load_id).show();
        reset_city(this.id);
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('world/city') ?>/' + this.value,
            dataType: 'JSON',
            success: function(r) {
                $.each(r, function(id, val) {
                    $('#' + city_el).append('<option value="' + val.id + '">' + val.name + '</option>');
                });
                $(load_id).hide();
            }
        });
    });

    $(".select-country-birth").change(function() {
        var state_el = 'select-state-birth';
        $('.load-city-birth').show();
        reset_state(this.id);
        reset_city(this.id);
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('world/state') ?>/' + this.value,
            dataType: 'JSON',
            success: function(r) {
                $.each(r, function(id, val) {
                    $('.' + state_el).append('<option value="' + val.id + '">' + val.name + '</option>');
                });
                $('.load-city-birth').hide();
            }
        });
    });

    $(".select-state-birth").change(function() {
        var city_el = 'select-city-birth';
        // $(load_id).show();
        reset_city(this.id);
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('world/city') ?>/' + this.value,
            dataType: 'JSON',
            success: function(r) {
                $.each(r, function(id, val) {
                    $('.' + city_el).append('<option value="' + val.id + '">' + val.name + '</option>');
                });
                // $(load_id).hide();
            }
        });
    });

    function select_country(i) {
        var country_el = 'institution_country' + i;
        var state_el = 'institution_state' + i;
        var city_el = 'institution_city' + i;
        $('.load-province-academic' + i).show();
        $('#' + state_el).html('');
        $('#' + state_el).append('<option value="">-- Select Province --</option>');
        $('#' + city_el).html('');
        $('#' + city_el).append('<option value="">-- Select City --</option>');
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('world/state') ?>/' + $('#' + country_el).val(),
            dataType: 'JSON',
            success: function(r) {
                $.each(r, function(id, val) {
                    $('#' + state_el).append('<option value="' + val.id + '">' + val.name + '</option>');
                });
                $('.load-province-academic' + i).hide();
            }
        });
    }

    function select_state(i) {
        var state_el = 'institution_state' + i;
        var city_el = 'institution_city' + i;
        $('.load-city-academic' + i).show();
        $('#' + city_el).html('');
        $('#' + city_el).append('<option value="">-- Select City --</option>');
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('world/city') ?>/' + $('#' + state_el).val(),
            dataType: 'JSON',
            success: function(r) {
                $.each(r, function(id, val) {
                    $('#' + city_el).append('<option value="' + val.id + '">' + val.name + '</option>');
                });
                $('.load-city-academic' + i).hide();
            }
        });
    }

    function reset_state(id) {
        var state_id = '#' + id.split('_')[0] + '_state';
        $(state_id).html('');
        $(state_id).append('<option value="">-- Select Province --</option>');
        $(state_id).prop('disabled', false);
    }

    function reset_city(id) {
        var city_id = '#' + id.split('_')[0] + '_city';
        $(city_id).html('');
        $(city_id).append('<option value="">-- Select City --</option>');
        $(city_id).prop('disabled', false);
    }

    function select_province(el) {
        var selectValue = $(".select-country" + el).val();
        $('.load-province-academic' + el).show();
        $('.select-state' + el).html('');
        $('.select-state' + el).append('<option value="">-- Select Province --</option>');
        $('.select-city' + el).html('');
        $('.select-city' + el).append('<option value="">-- Select City --</option>');
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('world/state') ?>/' + selectValue,
            dataType: 'JSON',
            success: function(r) {
                $.each(r, function(id, val) {
                    $('.load-province-academic' + el).hide();
                    $('.select-state' + el).append('<option value="' + val.id + '">' + val.name + '</option>');
                });
            }
        });
    }

    function select_city(el) {
        var selectValue = $(".select-state" + el).val();
        $('.load-city-academic' + el).show();
        $('.select-city' + el).html('');
        $('.select-city' + el).append('<option value="">-- Select City --</option>');
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('world/city') ?>/' + selectValue,
            dataType: 'JSON',
            success: function(r) {
                $.each(r, function(id, val) {
                    $('.load-city-academic' + el).hide();
                    $('.select-city' + el).append('<option value="' + val.id + '">' + val.name + '</option>');
                });
            }
        });
    }

    function select_country_city(el) {
        var selectValue = $(".select-country-academic" + el).val();
        $('.load-city-academic' + el).show();
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('world/countrycity') ?>/' + selectValue,
            dataType: 'JSON',
            success: function(r) {
                $.each(r, function(id, val) {
                    $('.select-city-academic' + el).append('<option value="' + val.id + '">' + val.name + '</option>');
                });
                $('.load-city-academic' + el).hide();
            }
        });
    }

    function reset_password(id) {
        if (confirm("Are you sure want to send email for reset password ?")) {
            $('.reset-load').show();
            var email = $('#primary_email').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/grantee/reset_password') ?>',
                data: {
                    id: id,
                    email: email
                },
                success: function(r) {
                    if (r.err_message == false) {
                        alert(r.success_message);
                    }
                    $('.reset-load').hide();
                }
            });
        }
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

    $('input[type=file]').change(function(e) {
        if ($(this).val() != '') {
            $('#file_name1').html($(this).val());
        } else {
            $('#file_name1').html('No file chosen');
        }
    });



    $(".upload-button").click(function() {

        var data_value = $(this).data('file-value');
        var fileview = $(this).closest('.col-lg-4').find('.fileview');
        var icon = $(this).closest('.col-lg-4').find('.submission-spinner');
        var base_url = "<?= base_url() ?>";

        // trigger click to closest type file
        $(`.${data_value}`).click();

        // add event when file has choosen
        $(`.${data_value}`).change(function(e) {

            // define variable name
            var custom_fields_id = $(this).data('id');
            var step_id = $(this).data('step');
            var category_id = $(this).data('category-id');
            var grant_id = $(this).data('grant-id');
            var fileName = e.target.files[0].name;
            var user_id = $('#grantee_id').val();

            // set filename into label
            $(this).closest('.col-lg-4').find('.filename').html(fileName)
            icon.css('display', 'block')

            // define value form data
            var formData = new FormData();
            formData.append("file", e.target.files[0]);
            formData.append("user_grantee_custom_fields_id", custom_fields_id),
                formData.append("user_grantee_step_id", step_id),
                formData.append("user_grantee_category_id", category_id),
                formData.append("user_grantee_grant_id", grant_id)
            formData.append("user_grantee_id", user_id)
            formData.append("grantee_grant_id", '<?= $grantee_grant_id ?>')

            // autosave
            $.ajax({
                url: "<?= base_url(); ?>admin/grantee/save_fields",
                type: 'POST',
                data: formData, // The form with the file inputs.
                processData: false,
                contentType: false // Using FormData, no need to process data.
            }).done(function(r) {
                console.log("Success: Files sent!");
                var postsjson = $.parseJSON(r);

                if(postsjson.redirect){
                    window.location.href = postsjson.redirect;
                    return false
                }
                fileview.css("display", "block");
                icon.css("display", "none");
                fileview.attr("href", base_url + postsjson.filepath);
            });
        })
    });

    var error = 0;

    $(document).ready(function() {
        $('.choosefile').each(function(){
            if ($(this).is(':hidden')) {
                $(this).prop('required', false);
            }
        });
        
        $('.select2').select2({
            theme: 'bootstrap'
        });
        // $("#btn-deleted").click(function(){
        //     console.log("INI BERJALAN");
        //     $("#mdl_info").modal();
        //     e.preventDefault();
        // });



        // $(".autosave").blur(function(){
        //     var data_value = $(this).val();
        //     var custom_fields_id = $(this).data('id');
        //     var is_required = $(this).attr("required");
        //     var group_element_id = $(this).data("index");

        //     // add logic for checkbox
        //     if ($(this).is(':checkbox')){
        //         data_value = [];
        //             $.each($(`input[type='checkbox']:checked`), function(){
        //                 data_value.push($(this).val())
        //             })
        //     }

        //     // add logic for multiple choice grid 
        //     if ($(this).hasClass('multiple-choice-grid')){
        //         data_value = [];
        //         $.each($(`.table_${custom_fields_id} input:radio.multiple-choice-grid:checked`), function(){
        //             data_value.push($(this).val())
        //         })

        //     }

        //     // logic for required 
        //     if (is_required){
        //         // jika datanya tidak kosong
        //         if (data_value) {
        //             if (error > 0) error--;
        //         }else{
        //             error++;
        //         }

        //     }

        //     if (error == 0){
        //         $(".next, .submit-submission").removeClass("disabled");
        //     }else{
        //         $(".next, .submit-submission").addClass("disabled");
        //     }

        //     var step_id = $(this).data('step');
        //     var category_id = $(this).data('category-id');
        //     var grant_id = $(this).data('grant-id');
        //     var user_id = $('#grantee_id').val();
        //     $.ajax({
        //         url: "<?= base_url(); ?>admin/grantee/save_fields",
        //         method: "POST",
        //         data: {
        //             value: data_value,
        //             user_grantee_custom_fields_id: custom_fields_id,
        //             user_grantee_step_id: step_id,
        //             user_grantee_category_id: category_id,
        //             user_grantee_grant_id: grant_id,
        //             user_grantee_id: user_id,
        //             grantee_grant_id: '<?= $grantee_grant_id ?>',
        //             group_element_id: group_element_id
        //         }
        //     })
        //     .success(function(data){
        //         console.log(data);
        //     })
        // })

        $('.datepicker').change(function() {
            $(this).blur();
        });

        var notNullGrant = $("#select-grant").val();
        if (notNullGrant != "") {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/grantee/get_category_date') ?>',
                data: {
                    grant_id: notNullGrant
                },
                success: function(r) {
                    $('#wrap-category-report').html('');
                    $('#wrap-category-report').append(r);
                    $(".datepicker").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: "dd M yy",
                        yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
                    });
                    $("#report-spinner").hide();
                }
            });
        }
    });

    // function step_active(i){
    //     for (let index = 0; index < i; index++) {
    //         console.log(index)
    //         $("#li_step_"+(index)).addClass("done");

    //     }
    // }

    function accept_report(id, user_id) {
        if (confirm("Are you sure want to accept this ?")) {
            var note = $("#note" + id).val();
            var fiscal_year = $("#fiscal_year").val();
            var grant_id = $("#grant_id").val();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/grantee/action_report') ?>',
                data: {
                    id: id,
                    note: note,
                    user_id: user_id,
                    status: 'accept',
                    fiscal_year: fiscal_year,
                    grant_id: grant_id
                },
                success: function(r) {
                    if (r.err_message == false) {
                        location.href = r.redirect;
                    }
                }
            });
        }

    }

    function revisi_report(id, user_id) {
        if (confirm("Are you sure want to revisi this ?")) {
            var note = $("#note" + id).val();
            var fiscal_year = $("#fiscal_year").val();
            var grant_id = $("#grant_id").val();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/grantee/action_report') ?>',
                data: {
                    id: id,
                    note: note,
                    user_id: user_id,
                    status: 'revisi',
                    fiscal_year: fiscal_year,
                    grant_id: grant_id
                },
                success: function(r) {
                    if (r.err_message == false) {
                        location.href = r.redirect;
                    }
                }
            });
        }

    }

    function next_step(step) {
        $("#li_step_" + (step - 1)).removeClass("active");
        $("#li_step_" + (step - 1)).addClass("done");
        $("#li_step_" + step).addClass("active");
    }

    function back_step(step) {
        console.log(step)
        $("#li_step_" + (step + 1)).removeClass("active");
        $("#li_step_" + (step + 1)).removeClass("done");
        $("#li_step_" + step).addClass("active");
    }

    function accept_submission(user_id, grant_id) {
        if (confirm("Are you sure want to Accept this ?")) {
            var note = $('#note_submission').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/grantee/accept_submission') ?>',
                data: {
                    note: note,
                    user_id: user_id,
                    grant_id: grant_id,
                },
                success: function(r) {
                    if (r.err_message == false) {
                        location.href = r.redirect;
                    }
                }
            });
        }

    }

    function revise_submission(user_id, grant_id) {
        if (confirm("Are you sure want to Revise this ?")) {
            var note = $('#note_submission').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/grantee/revise_submission') ?>',
                data: {
                    note: note,
                    user_id: user_id,
                    grant_id: grant_id,
                },
                success: function(r) {
                    if (r.err_message == false) {
                        location.href = r.redirect;
                    }
                }
            });
        }

    }

    function accept_submission_us(user_id, grantee_grant_id, grant_id, category_id) {
        if (confirm("Are you sure want to Accept this ?")) {
            var note = $('#note_submission' + grant_id).val();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/grantee/accept_submission') ?>',
                data: {
                    note: note,
                    user_id: user_id,
                    grantee_grant_id: grantee_grant_id,
                    grant_id: grant_id,
                },
                success: function(r) {
                    if (r.err_message == false) {
                        location.href = r.redirect;
                    }
                }
            });
        }

    }

    function revise_submission_us(user_id, grantee_grant_id, grant_id, category_id) {
        if (confirm("Are you sure want to Revise this ?")) {
            var note = $('#note_submission' + grant_id).val();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/grantee/revise_submission') ?>',
                data: {
                    note: note,
                    user_id: user_id,
                    grantee_grant_id: grantee_grant_id,
                    grant_id: grant_id,
                },
                success: function(r) {
                    if (r.err_message == false) {
                        location.href = r.redirect;
                    }
                }
            });
        }

    }

    function accept_submission_document(user_id, grantee_grant_id, grant_id, category_id) {
        if (confirm("Are you sure want to Complete this ?")) {
            var note = $('#note_document').val();
            var document = $('#document').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/new_grantee/accept_submission_document') ?>',
                data: {
                    note: note,
                    user_id: user_id,
                    grantee_grant_id: grantee_grant_id,
                    grant_id: grant_id,
                    document: document,
                    category_id: category_id
                },
                success: function(r) {
                    if (r.err_message == false) {
                        location.href = r.redirect;
                    }
                }
            });
        }

    }

    function revise_submission_document(user_id, grantee_grant_id, grant_id, category_id) {
        if (confirm("Are you sure want to Revise this ?")) {
            var note = $('#note_document').val();
            var document = $('#document').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/new_grantee/revise_submission_document') ?>',
                data: {
                    note: note,
                    user_id: user_id,
                    grantee_grant_id: grantee_grant_id,
                    grant_id: grant_id,
                    document: document,
                    category_id: category_id
                },
                success: function(r) {
                    if (r.err_message == false) {
                        location.href = r.redirect;
                    }
                }
            });
        }

    }

    function arrived_submission_document(user_id, grantee_grant_id, grant_id, category_id) {
        if (confirm("Are you sure want to Arrived this ?")) {
            var note = $('#note_document').val();
            var document = $('#document').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/new_grantee/arrived_submission_document') ?>',
                data: {
                    note: note,
                    user_id: user_id,
                    grantee_grant_id: grantee_grant_id,
                    grant_id: grant_id,
                    document: document,
                    category_id: category_id
                },
                success: function(r) {
                    if (r.err_message == false) {
                        location.href = r.redirect;
                    }
                }
            });
        }

    }

    function withdraw_submission_document(user_id, grantee_grant_id, grant_id, category_id) {
        if (confirm("Are you sure want to Withdraw this ?")) {
            var note = $('#note_document').val();
            var document = $('#document').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/new_grantee/withdraw_submission_document') ?>',
                data: {
                    note: note,
                    user_id: user_id,
                    grantee_grant_id: grantee_grant_id,
                    grant_id: grant_id,
                    document: document,
                    category_id: category_id
                },
                success: function(r) {
                    if (r.err_message == false) {
                        location.href = r.redirect;
                    }
                }
            });
        }

    }

    function permit_reject_submission_document(user_id, grantee_grant_id, grant_id, category_id) {
        if (confirm("Are you sure want to Reject this ?")) {
            var note = $('#note_document').val();
            var document = $('#document').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/new_grantee/permit_reject_submission_document') ?>',
                data: {
                    note: note,
                    user_id: user_id,
                    grantee_grant_id: grantee_grant_id,
                    grant_id: grant_id,
                    document: document,
                    category_id: category_id
                },
                success: function(r) {
                    if (r.err_message == false) {
                        location.href = r.redirect;
                    }
                }
            });
        }

    }

    $("#select-grant").change(function() {
        // alert("babi");
        var grant_id = this.value;
        $("#report-spinner").show();
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/grantee/get_category_date') ?>',
            data: {
                grant_id: grant_id
            },
            success: function(r) {
                $('#wrap-category-report').html('');
                $('#wrap-category-report').append(r);
                $(".datepicker").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: "dd M yy",
                    yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
                });
                $("#report-spinner").hide();
                // if(r.err_message == false){
                //     alert(r.success_message);
                // }
                // $('.reset-load').hide();
            }
        });
    })

    $("#delete_grantee").click(function() {
        $("#mdl_info_grantee").modal();
        event.preventDefault();
    });

    // validation upload file 5mb
    $('#img_photo,#img_passport').change(function(e) {
        const file_input = $(this);
        const allowed_extensions = ['jpg', 'jpeg', 'png', 'pdf'];
        const file_name = file_input.val();

        const is_valid_extension = allowed_extensions.some(function(extension) {
            return file_name.toLowerCase().endsWith(extension);
        });

        if (!is_valid_extension) {
            alert('File type should be ' + '<?php echo human_readable_list(ALLOWED_PROFILE_FILETYPE, ','); ?>');
            $(this).val('');

            return false;
        }
        // after extension validated, do validate filesize
        var size_file = e.target.files[0].size;
        if (size_file > 5000000) { //if > 5mb
            $('#invalid_photo').css('display', 'block');
            $('#invalid_photo_required').css('display', 'none');
            $('#img_photo').val('');

            $('#invalid_img_passport_size').css('display', 'block');
            $('#invalid_img_passport').css('display', 'none');
            $('#img_passport').val('');
            return false;
        } else {
            $('#invalid_photo_required').css('display', 'none');
            $('#invalid_img_passport').css('display', 'none');
        }
    });

    function show_preview(element, type, upload_type) {
        console.log(upload_type);
        const file = element.files[0];
        const filetype = file.name.split('.').pop();
        const allowed_extensions = ['jpg', 'jpeg', 'png', ['pdf']];

        const is_valid_extension = allowed_extensions.some(function(extension) {
            return filetype.toLowerCase().endsWith(extension);
        });

        if (is_valid_extension > 0) {
            let formData = new FormData();
            formData.append(upload_type, file);
            formData.append('type', upload_type);

            $.ajax({
                url: SITE_URL + 'admin/grantee/save_file',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'JSON',
                success: function(response) {
                    if (response.status) {
                        let file_url = SITE_URL + response.filepath;
                        $("#preview_section_" + type).css('display', 'block');
                        $('#preview_image_' + type).attr('src', response.preview);
                        $("#button_preview_" + upload_type).attr('href', file_url).removeClass('hide');
                        $("#button_download_" + upload_type).attr('href', file_url).removeClass('hide');
                        $("#button_delete_" + upload_type).removeClass('hide');
                        $("input[name='" + upload_type + "']").val(response.filepath);
                        $("." + type).val(response.filepath);
                    } else {
                        alert('Failed to upload your file, please try again');
                    }

                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            let current_src = $('#preview_image_' + type).attr('src');
            $('#preview_image_' + type).attr('src', current_src);
        }
    }

    function appendDataToTable(data) {
        const tableBody = $('#data_table');

        // Clear the existing table data
        tableBody.empty();

        // Iterate through the data and append rows to the table
        var table = '';
        table += '<table id="data_table" class="table table-striped table-hover" width="100%">';
        table += '<thead>';
        table += '<tr>';
        table += '<th>File</th>';
        table += '<th>Upload Date</th>';
        table += '</tr>';
        table += '</thead>';
        data.forEach(function(item) {
            const nameFile = item.file.split('/');
            table += '<tr>'
            table += '<td><a class="lightbox" href="<?= base_url() ?>' + item.file + '">' + nameFile[nameFile.length - 1] + '</a></td>'
            table += '<td>' + item.insert_date + '</td>'
            table += '</tr>'
        });
        table += '</thead>';
        tableBody.append(table);
    }

    $('#mdl_detail_leave').on('show.bs.modal', function(event) {
        $.fn.modal.Constructor.prototype.enforceFocus = function() {

            var button = $(event.relatedTarget);
            var leaveId = button.data('leave-id');

            if (typeof currentLeaveApps !== 'undefined') {
                var data = currentLeaveApps[leaveId];
                var baseUrl = '<?= base_url() ?>';
                $("#leave_id").val(data.id);

                if (data.category_name != null) {
                    $("#leave_category").val(data.category_name).closest('div.form-group').removeClass('hide');
                } else {
                    $("#leave_category").val('').closest('div.form-group').addClass('hide');
                }

                if (data.total_request != null) {
                    $("#leave_day").val(data.total_request + ' Day').closest('div.form-group').removeClass('hide');
                } else {
                    $("#leave_day").val('').closest('div.form-group').addClass('hide');
                }

                if (data.start_date != null) {
                    $("#start_date").val($.datepicker.formatDate("d M yy", new Date(data.start_date))).closest('div.form-group').removeClass('hide');
                } else {
                    $("#start_date").val('').closest('div.form-group').addClass('hide');
                }

                if (data.end_date != null) {
                    $("#end_date").val($.datepicker.formatDate("d M yy", new Date(data.end_date))).closest('div.form-group').removeClass('hide');
                } else {
                    $("#end_date").val('').closest('div.form-group').addClass('hide');
                }

                if (data.status != null) {
                    $("#status").val(data.status).prop('disabled', true).closest('div.form-group').removeClass('hide');
                } else {
                    $("#status").val('').closest('div.form-group').addClass('hide');
                }

                if (data.telephone != null && data.telephone !== '') {
                    $("#telephone_val").val(data.telephone).closest('div.form-group').removeClass('hide');
                } else {
                    $("#telephone_val").val('').closest('div.form-group').addClass('hide');
                }

                if (data.email != null && data.email !== '') {
                    $("#email_val").val(data.email).closest('div.form-group').removeClass('hide');
                } else {
                    $("#email_val").val('').closest('div.form-group').addClass('hide');
                }

                if (data.address != null && data.address !== '') {
                    $("#address_val").val(data.address).closest('div.form-group').removeClass('hide');
                } else {
                    $("#address_val").val('').closest('div.form-group').addClass('hide');
                }

                if (data.destination_purpose != null && data.destination_purpose !== '') {
                    $("#destination_purpose").val(data.destination_purpose).closest('div.form-group').removeClass('hide');
                } else {
                    $("#destination_purpose").val('').closest('div.form-group').addClass('hide');
                }

                if (data.destination != null && data.destination !== '') {
                    $("#destination").val(data.destination?.toUpperCase()).closest('div.form-group').removeClass('hide');
                } else {
                    $("#destination").val('').closest('div.form-group').addClass('hide');
                }

                if (data.departure_site_date != null) {
                    $("#departure_site_date").val($.datepicker.formatDate("d M yy", new Date(data.departure_site_date))).closest('div.form-group').removeClass('hide');
                } else {
                    $("#departure_site_date").val('').closest('div.form-group').addClass('hide');
                }

                if (data.arrival_site_date != null) {
                    $("#arrival_site_date").val($.datepicker.formatDate("d M yy", new Date(data.arrival_site_date))).closest('div.form-group').removeClass('hide');
                } else {
                    $("#arrival_site_date").val('').closest('div.form-group').addClass('hide');
                }

                if (data.departure_indo_date != null) {
                    $("#departure_indo_date").val($.datepicker.formatDate("d M yy", new Date(data.departure_indo_date))).closest('div.form-group').removeClass('hide');
                } else {
                    $("#departure_indo_date").val('').closest('div.form-group').addClass('hide');
                }

                if (data.arrival_indo_date != null) {
                    $("#arrival_indo_date").val($.datepicker.formatDate("d M yy", new Date(data.arrival_indo_date))).closest('div.form-group').removeClass('hide');
                } else {
                    $("#arrival_indo_date").val('').closest('div.form-group').addClass('hide');
                }

                if (data.form_upload == null) {
                    $("#form_upload_file").addClass('hide')
                } else {
                    $("#form_upload_file").removeClass('hide').attr("href", baseUrl + data.form_upload)
                }

                if (data.boarding_pass == null) {
                    $("#borading_pass_file").addClass('hide')
                } else {
                    $("#borading_pass_file").removeClass('hide').attr("href", baseUrl + data.boarding_pass)
                }

                if (data.departure_time != null) {
                    $("#departure_time").val(data.departure_time).closest('div.form-group').removeClass('hide');
                } else {
                    $("#departure_time").val('').closest('div.form-group').addClass('hide');
                }

                if (data.note != null) {
                    $("#note").val(data.note).closest('div.form-group').removeClass('hide');
                } else {
                    $("#note").val('').closest('div.form-group').addClass('hide');
                }

                // if (data.category_name == 'Sick Leave') {
                //     $("#boarding_pass_form").addClass('hide');
                //     $("#destination_form").addClass('hide');
                //     $("#form_upload").removeClass('hide');
                //     $('#label_start').html('Start Date')
                //     $('#label_end').html('End Date')
                //     $("#telephone, #email, #address").addClass("hide");
                //     $("#section_departure_indo_date").addClass("hide");
                //     $("#section_arrival_indo_date").addClass("hide");
                //     $("#destination_purpose_form").addClass('hide');
                // } else if (data.category_name == 'Emergency Leave') {
                //     $("#boarding_pass_form").addClass('hide');
                //     $("#form_upload").removeClass('hide');
                //     $("#destination_form").removeClass('hide');
                //     $('#label_start').html('Start Date')
                //     $('#label_end').html('End Date')
                //     $("#telephone, #email, #address").addClass("hide");
                //     $("#section_departure_indo_date").addClass("hide");
                //     $("#section_arrival_indo_date").addClass("hide");
                //     $("#destination_purpose_form").removeClass('hide');
                // } else {
                //     $("#boarding_pass_form").removeClass('hide');
                //     $("#form_upload").removeClass('hide');
                //     $("#destination_form").removeClass('hide');
                //     $("#telephone, #email, #address").removeClass("hide");
                //     $('#label_start').html('Date of Departure from Site')
                //     $('#label_end').html('Date of Arrival at Your Site')
                //     $("#section_departure_indo_date").removeClass("hide");
                //     $("#section_arrival_indo_date").removeClass("hide");
                //     $("#destination_purpose_form").addClass('hide');
                // }

                if (data.boarding_pass != null && data.boarding_pass.length > 0) {
                    appendDataToTable(data.boarding_pass)
                }

                $('.lightbox').topbox();
            }
        };
    });

    var current_residence_section = $("#current-residence-section");
    var checkbox_current_residence = $("#current-residence");
    let is_current_resident_checked = checkbox_current_residence.prop('checked');
    if (is_current_resident_checked) {
        current_residence_section.addClass('hide');
    } else {
        current_residence_section.removeClass('hide');
    }

    var address_state = '';
    var address_city = '';
    checkbox_current_residence.on('click', function() {
        address_state = $("select[name='home_state']").val();
        address_city = $("select[name='city']").val();
        let address_country = $("select[name='country']").val();
        let address_street = $("input[name='street']").val();
        let address_zipcode = $("input[name='zipcode']").val();

        $("select[name='residence_country']").val(address_country).change();
        $("input[name='residence_street']").val(address_street).change();
        $("input[name='residence_zipcode']").val(address_zipcode).change();

        let is_checked = $(this).prop('checked');
        if (is_checked) {
            current_residence_section.addClass('hide');
        } else {
            let old_residence_country = $("select[name='residence_country']").data('old');
            let old_residence_state = $("select[name='residence_state']").data('old');
            let old_residence_city = $("select[name='residence_city']").data('old');
            let old_residence_street = $("input[name='residence_street']").data('old');
            let old_residence_zipcode = $("input[name='residence_zipcode']").data('old');

            address_state = old_residence_state;
            address_city = old_residence_city;
            $("select[name='residence_country']").val(old_residence_country).change();
            $("input[name='residence_street']").val(old_residence_street).change();
            $("input[name='residence_zipcode']").val(old_residence_zipcode).change();

            current_residence_section.removeClass('hide');
        }

        setTimeout(() => {
            $(".select-residence-state").change();
        }, 100);

        setTimeout(() => {
            $(".select-residence-city").change();
        }, 200);

    });

    $(".select-residence-country").change(function() {
        var state_el = this.id.split('_')[0] + '_state';
        var load_id = '#load-' + state_el;
        $(load_id).show();
        reset_state(this.id);
        reset_city(this.id);
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('world/state') ?>/' + this.value,
            dataType: 'JSON',
            success: function(r) {
                $.each(r, function(id, val) {
                    $('#' + state_el).append('<option value="' + val.id + '" ' + (address_state == val.id ? 'selected' : "") + '>' + val.name + '</option>');
                });
                $(load_id).hide();
            }
        });
    });

    $(".select-residence-state").change(function() {
        var city_el = this.id.split('_')[0] + '_city';
        var load_id = '#load-' + city_el;
        $(load_id).show();
        reset_city(this.id);
        let params = address_state == '' ? $(this).val() : address_state;
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('world/city') ?>/' + params,
            dataType: 'JSON',
            success: function(r) {
                $.each(r, function(id, val) {
                    $('#' + city_el).append('<option value="' + val.id + '" ' + (address_city == val.id ? 'selected' : "") + '>' + val.name + '</option>');
                });
                $(load_id).hide();
            }
        });
    });
    var showPicker = false;
    $(".datepicker-birthdate").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd M yy",
        maxDate: "<?php echo date('d M Y', strtotime('-16 year')) ?>",
        defaultDate: "<?php echo date('d M Y', strtotime('-16 year')) ?>",
        yearRange: "<?php echo date('Y') - 100 ?>:<?php echo date('Y') - 16 ?>",
        onClose: function(dateText, inst) {
            showPicker = false;
        }
    });
    $(".ui-datepicker").on("mouseenter", function() {
        if (!showPicker) {
            showPicker = true;
            //Reverse the years
            var dropYear = $("select.ui-datepicker-year");
            dropYear.find('option').each(function() {
                dropYear.prepend(this);
            });
        }

    });

    function add_other_bank() {
        let input_numbers = function() {
            let random_number = '';
            for (let i = 0; i < 4; i++) {
                random_number += Math.floor(Math.random() * 10); // Menghasilkan digit acak dari 0 hingga 9
            }
            return parseInt(random_number, 10);
        };
        let index = input_numbers();
        let html = `
        <div class="col-md-12">
            <hr>
        </div>
        <div class="other-bank">
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Beneficiary Name (As listed on the bank account)</label><?= $required_label ?>
                    <input type="text" class="form-control" name="other_bank_info[` + index + `][beneficiary_name]" value="" placeholder="Full Name">
                    <div id="invalid_beneficiary_name" class="text-danger invalid-tooltip">
                        Full Name is not null.
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Bank Name</label><?= $required_label ?>
                    <input type="text" class="form-control" name="other_bank_info[` + index + `][bank_name]" value="" placeholder="Bank Name">
                    <div id="invalid_bank_name" class="text-danger invalid-tooltip">
                        Bank Name is not null.
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Beneficiary Address: [Building/Street, City, State/Province + Postal Code, Country]</label><?= $required_label ?>
                    <input type="text" class="form-control" name="other_bank_info[` + index + `][beneficiary_address]" value="" placeholder="Beneficiary Address">
                    <div id="invalid_Beneficiary_address" class="text-danger invalid-tooltip">
                        Beneficiary Address is not null.
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Bank Address: [Building/Street, City, State/Province + Postal Code, Country]</label><?= $required_label ?>
                    <input type="text" class="form-control" name="other_bank_info[` + index + `][bank_address]" value="" placeholder="Bank Address">
                    <div id="invalid_bank_address" class="text-danger invalid-tooltip">
                        Bank Address is not null.
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Account Number</label><?= $required_label ?>
                    <input type="text" class="form-control" name="other_bank_info[` + index + `][account_number]" value="" placeholder="Account Number">
                    <div id="invalid_account_number" class="text-danger invalid-tooltip">
                        Account Number is not null.
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Routing or ABA Number (for U.S. Banks)</label><?= $required_label ?>
                    <input type="text" class="form-control" name="other_bank_info[` + index + `][routing_number]" value="" placeholder="Routing or ABA Number (for U.S. Banks)">
                    <div id="invalid_routing_number" class="text-danger invalid-tooltip">
                        Routing or ABA Number (for U.S. Banks) is not null.
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>SWIFT Code</label><?= $required_label ?>
                    <input type="text" class="form-control" name="other_bank_info[` + index + `][swift_code]" value="" placeholder="SWIFT Code">
                    <input type="hidden" id="swift_code_checking_filler" value="<?php echo $this->Grantee_ent_model->swift_code ?>">
                    <div id="invalid_swift_code" class="text-danger invalid-tooltip">
                        SWIFT Code is not null.
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Other Bank Details (Intermediary Bank, etc.)</label>
                    <textarea class="form-control" rows="2" name="other_bank_info[` + index + `][note_bank]"><?php echo $this->Grantee_ent_model->note_bank ?></textarea>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Currency</label><?= $required_label ?>
                    <select class="form-control" name="other_bank_info[` + index + `][currency]" id="currency">
                        <option value="">-- Select Currency --</option>
                        <?php
                        if ($currency) {
                            foreach ($currency as $cr) {
                                $selected = '';
                                if ($this->Grantee_ent_model->currency == $cr) {
                                    $selected = 'selected="selected"';
                                }
                        ?>
                                <option value="<?php echo $cr ?>" <?php echo $selected ?>><?php echo $cr ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                    <div id="invalid_currency" class="text-danger invalid-tooltip">
                        Currency is not null.
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label><?= $this->session->userdata('active_country') == AMERICAN_DATABASE ? 'Void Check' : 'First page of bank account information (buku tabungan halaman pertama)' ?> <?php echo $this->session->userdata('active_country') == AMERICAN_DATABASE ? '(optional)' : ''; ?></label>
                    <?php
                    $account_book = user_grantee_file_url($user_grantee, 'account_book');
                    ?>
                    <div style="margin-bottom:10px; position:relative; width:100px;">
                        <a href="<?php echo site_url($account_book); ?>" class="lightbox" aria-haspopup="dialog">
                            <img id="preview_image_account_book-` + index + `" data-old="<?php echo site_url($account_book); ?>" src="<?php echo get_preview($account_book); ?>" width="100" style="min-height:60px;object-fit:contain;">
                        </a>
                        <a href="javascript:;" onclick="del_other_bank_attachment(this, 'account_book-` + index + `', 'Account Book')" id="button_delete_account_book-` + index + `" class="btn btn-danger btn-xs hide" style="position:absolute; top:0; right:-28px;">
                            <i class="fa fa-trash fa-fw"></i>
                        </a>
                        <a href="<?php echo base_url($account_book) ?>" id="button_download_account_book-` + index + `" download title="Click to download" class="btn btn-primary btn-xs mt-5 hide" style="position:absolute; top:0; right:-28px;">
                            <i class="fa fa-download fa-fw"></i>
                        </a>
                    </div>
                    <input type="file" class="custom-file-input hide" id="account_book-` + index + `" onchange="show_preview(this, 'account_book-` + index + `', 'account_book-` + index + `');">
                    <input type="hidden" name="other_bank_info[` + index + `][account_book]" class="account_book-` + index + `" value="">
                    <label class="btn btn-primary upload-button" for="account_book-` + index + `"> Choose file </label> 
                    <a href="<?php echo site_url($account_book) ?>" id="button_preview_account_book-` + index + `" class="btn btn-warning fileview lightbox preview-profile" style="color:#fff;display:inline-block"><i class="fa fa-eye fa-fw"></i> Preview</a>
                    <div>
                        <small class="file-for-testing">
                            File Size Max 5MB 
                            <?php if (count(ALLOWED_PROFILE_FILETYPE) > 0) { ?>
                            | Supported File : <?php echo strtoupper(human_readable_list(ALLOWED_PROFILE_FILETYPE, ',')); ?> 
                            <?php } ?>
                        </small>
                        <div id="invalid_photo" class="text-danger invalid-tooltip">
                            Max File Size 5Mb.
                        </div>
                        <div id="invalid_photo_required" class="text-danger invalid-tooltip">
                            Please Choose File.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `;



        $("#list-other-bank").append(html);
        $('.lightbox').topbox();

        let other_bank = $(document).find('.other-bank');
        let other_bank_counted = other_bank.length;
        console.log(other_bank_counted);
        if (other_bank_counted > 0) {
            $('.setup-block-support').removeClass('hide');
        } else {
            $('.setup-block-support').addClass('hide');
        }
    }

    function del_other_bank_attachment(el, name, label) {
        console.log(name, el);

        $("input[name='" + name + "']").val("");

        let element = $("#preview_image_" + name);

        if (confirm("Are you sure want to delete " + label + " ?")) {

            let default_preview_image = SITE_URL + 'assets/images/accountbook.png';
            element.closest('a').attr('href', default_preview_image);
            element.attr('src', default_preview_image);
            $("#button_preview_" + name).attr('href', default_preview_image);
            $("#button_download_" + name).attr('href', default_preview_image).addClass('hide');
            $("#button_delete_" + name).addClass('hide');

            return false;
        }
    }

    $(document).on('click', ".btn-remove-other-bank", function() {
        let el = $(this);
        let id = el.data('id');
        $('<input>').attr({
            type: 'hidden',
            name: 'deleted_other_bank[]',
            value: id
        }).appendTo('form');
        $(this).closest('.other-bank').remove();
    });

    $(function(){
        $("input,select,textarea").on('change', function(){
            let is_required = $(this).attr('required');
            let value = $(this).val();

            if (typeof is_required !== undefined && (value && value.length > 0)) {
                $(this).closest('div').find('.invalid-tooltip').css('display', 'none');
            }
        })
        setTimeout(function(){
            var decoy = $("#swift_code_checking_filler").val();
            $("#password").val("")
            if ($("#swift_code").attr("autocomplete") != "" && decoy == ''){
                $("#swift_code").val("")
            }
        },500)
        function personal_active() {
            $('#li_personal').addClass('active');
            $('#personal').addClass('active in');
            $('#li_contact').removeClass('active');
            $('#contact').removeClass('active in');
        }
        // $("#btn-submit,#btn-submit-contact").click(function(){
        
        //     // var valid_email = /^(([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)(\s*;\s*|\s*$))*$/;

        //     // return true;
        //     let invalid_counted = 0;
        //     if($('#first_name').val() == ''){
        //         personal_active();
        //         $('#first_name').focus();
        //         $('#invalid_first_name').css('display', 'block');
        //         // return false;
        //         invalid_counted += 1;
        //     }
        //     if($('#last_name').val() == ''){
        //         personal_active();
        //         $('#last_name').focus();
        //         $('#invalid_last_name').css('display', 'block');
        //         // return false;
        //         invalid_counted += 1;
        //     }
        //     if($('#dietary_restrictions').val() == ''){
        //         personal_active();
        //         $('#dietary_restrictions').focus();
        //         $('#invalid_dietary_restrictions').css('display', 'block');
        //         // return false;
        //         invalid_counted += 1;
        //     }

        //     let bio = $('#bio');
        //     if (bio.length > 0 && bio.val() == '') {
        //         $('#label-bio').focus();
        //         $('#invalid_bio_required').css('display', 'block');
        //         // return false;
        //         invalid_counted += 1;
        //     }

        //     if(($("#preview_image_bio_photo").attr('src') == '' || $("#preview_image_bio_photo").attr('src') == '<?= base_url('assets/images/profile.png') ?>') && $('#bio_photo').val() == ''){
        //         personal_active();
        //         $('#label-bio-photo').focus();
        //         $('#invalid_photo_bio').css('display', 'block');
        //         // return false;
        //         invalid_counted += 1;
        //     }

        //     if(($("#preview_image_cv").attr('src') == '' || $("#preview_image_cv").attr('src') == '<?= base_url('assets/images/icons/document-filetype.png') ?>') && $('#cv').val() == ''){
        //         personal_active();
        //         $('#label-cv').focus();
        //         $('#invalid_cv').css('display', 'block');
        //         // return false;
        //         invalid_counted += 1;
        //     }

        //     if(($("#preview_image_profile").attr('src') == '' || $("#preview_image_profile").attr('src') == '<?= base_url('assets/images/profile.png') ?>') && $('#img_photo').val() == ''){
        //         personal_active();
        //         $('#label-photo').focus();
        //         $('#invalid_photo_required').css('display', 'block');
        //         // return false;
        //         invalid_counted += 1;
        //     }

        //     if(($("#preview_image_passport").attr('src') == '' || $("#preview_image_passport").attr('src') == '<?= base_url('assets/images/passport.png') ?>') && $('#img_passport').val() == ''){
        //         personal_active();
        //         $('#label-photo').focus();
        //         $('#invalid_passport_required').css('display', 'block');
        //         // return false;
        //         invalid_counted += 1;
        //     }

        //     if($('#birth_date').val() == ''){
        //         personal_active();
        //         $('#birth_date').focus();
        //         $('#invalid_birth_date').css('display', 'block');
        //         // return false;
        //         invalid_counted += 1;
        //     }
            
        //     if($('#birth_country').val() == ''){
        //         personal_active();
        //         $('#birth_country').focus();
        //         $('#invalid_birth_country').css('display', 'block');
        //         // return false;
        //         invalid_counted += 1;
        //     }
        //     if($('#birth_state').val() == ''){
        //         personal_active();
        //         $('#birth_state').focus();
        //         $('#invalid_birth_state').css('display', 'block');
        //         // return false;
        //         invalid_counted += 1;
        //     }
        //     if($('#birth_city').val() == ''){
        //         personal_active();
        //         $('#birth_city').focus();
        //         $('#invalid_birth_city').css('display', 'block');
        //         // return false;
        //         invalid_counted += 1;
        //     }
        //     if($('#gender').val() == ''){
        //         personal_active();
        //         $('#gender').focus();
        //         $('#invalid_gender').css('display', 'block');
        //         // return false;
        //         invalid_counted += 1;
        //     }
        //     if($('#institute_name').val() == ''){
        //         personal_active();
        //         $('#institute_name').focus();
        //         $('#invalid_institute_name').css('display', 'block');
        //         return false;
        //     }
        //     if($('#level_study').val() == ''){
        //         personal_active();
        //         $('#level_study').focus();
        //         $('#invalid_level_study').css('display', 'block');
        //         // return false;
        //         invalid_counted += 1;
        //     }
        //     if($('#institution_country').val() == ''){
        //         personal_active();
        //         $('#institution_country').focus();
        //         $('#invalid_institution_country').css('display', 'block');
        //         // return false;
        //         invalid_counted += 1;
        //     }
        //     if($('#institution_state').val() == ''){
        //         personal_active();
        //         $('#institution_state').focus();
        //         $('#invalid_institution_state').css('display', 'block');
        //         // return false;
        //         invalid_counted += 1;
        //     }
        //     if($('#institution_city').val() == ''){
        //         personal_active();
        //         $('#institution_city').focus();
        //         $('#invalid_institution_city').css('display', 'block');
        //         // return false;
        //         invalid_counted += 1;
        //     }
        //     if($('#degree_name').val() == ''){
        //         personal_active();
        //         $('#degree_name').focus();
        //         $('#invalid_degree_name').css('display', 'block');
        //         // return false;
        //         invalid_counted += 1;
        //     }
        //     if($('#degree_actual').val() == ''){
        //         personal_active();
        //         $('#degree_actual').focus();
        //         $('#invalid_degree_actual').css('display', 'block');
        //         // return false;
        //         invalid_counted += 1;
        //     }
        //     if($('#discipline').val() == ''){
        //         personal_active();
        //         $('#discipline').focus();
        //         $('#invalid_discipline').css('display', 'block');
        //         // return false;
        //         invalid_counted += 1;
        //     }
        //     if($('#endrolled_from').val() == ''){
        //         personal_active();
        //         $('#endrolled_from').focus();
        //         $('#invalid_endrolled_from').css('display', 'block');
        //         // return false;
        //         invalid_counted += 1;
        //     }
        //     // if($('#endrolled_to').val() == ''){
        //     //     personal_active();
        //     //     $('#endrolled_to').focus();
        //     //     $('#invalid_endrolled_to').css('display', 'block');
        //     //     return false;
        //     // }
        //     if($('#citizen_country').val() == ''){
        //         personal_active();
        //         $('#citizen_country').focus();
        //         $('#invalid_citizen_country').css('display', 'block');
        //         // return false;
        //         invalid_counted += 1;
        //     }

        //     let citizen_country = $("#citizen_country").val();
        //     let number_identity_element = $("#number_identity");
        //     let country_avtive = <?php echo isset($grantee_grant) ? $grantee_grant->country_id : $this->session->userdata('active_country') ?>;

        //     if(country_avtive == <?= INDONESIAN_DATABASE ?>){
        //         if(number_identity_element.val().length < 16){
        //             personal_active();
        //             $('#number_identity').focus();
        //             $('#invalid_number_identity_length').css('display', 'block');
        //             // return false;
        //             invalid_counted += 1;
        //         }
        //     }

        //     if (citizen_country == '101' || (typeof number_identity_element != undefined && number_identity_element.length > 0)) {
        //         if($('#number_identity').val() == ''){
        //             personal_active();
        //             $('#number_identity').focus();
        //             $('#invalid_number_identity').css('display', 'block');
        //             // return false;
        //             invalid_counted += 1;
        //         }
        //     } else {
        //         if($('#number_passport').val() == ''){
        //             personal_active();
        //             $('#number_passport').focus();
        //             $('#invalid_number_passport').css('display', 'block');
        //             // return false;
        //             invalid_counted += 1;
        //         }
        //         if($('#passport_expiry_date').val() == ''){
        //             personal_active();
        //             $('#passport_expiry_date').focus();
        //             $('#invalid_passport_expiry_date').css('display', 'block');
        //             // return false;
        //             invalid_counted += 1;
        //         }
        //         if($('#passport_date_issue').val() == ''){
        //             personal_active();
        //             $('#passport_date_issue').focus();
        //             $('#invalid_passport_date_issue').css('display', 'block');
        //             // return false;
        //             invalid_counted += 1;
        //         }
        //     }

        //     if(country_avtive == <?= AMERICAN_DATABASE ?>){
        //         if($('#number_passport').val() == ''){
        //             personal_active();
        //             $('#number_passport').focus();
        //             $('#invalid_number_passport').css('display', 'block');
        //             // return false;
        //             invalid_counted += 1;
        //         }
        //         if($('#passport_expiry_date').val() == ''){
        //             personal_active();
        //             $('#passport_expiry_date').focus();
        //             $('#invalid_passport_expiry_date').css('display', 'block');
        //             // return false;
        //             invalid_counted += 1;
        //         }
        //         if($('#passport_date_issue').val() == ''){
        //             personal_active();
        //             $('#passport_date_issue').focus();
        //             $('#invalid_passport_date_issue').css('display', 'block');
        //             // return false;
        //             invalid_counted += 1;
        //         }
        //     }

        //     if($('#bank_name').val() == ''){
        //         personal_active();
        //         $('#bank_name').focus();
        //         $('#invalid_bank_name').css('display', 'block');
        //         // return false;
        //         invalid_counted += 1;
        //     }
        //     if($('#bank_address').val() == ''){
        //         personal_active();
        //         $('#bank_address').focus();
        //         $('#invalid_bank_address').css('display', 'block');
        //         // return false;
        //         invalid_counted += 1;
        //     }
        //     if($('#beneficiary_name').val() == ''){
        //         personal_active();
        //         $('#beneficiary_name').focus();
        //         $('#invalid_beneficiary_name').css('display', 'block');
        //         // return false;
        //         invalid_counted += 1;
        //     }
        //     if($('#account_number').val() == ''){
        //         personal_active();
        //         $('#account_number').focus();
        //         $('#invalid_account_number').css('display', 'block');
        //         // return false;
        //         invalid_counted += 1;
        //     }
        //     if($('#routing_number').val() == ''){
        //         personal_active();
        //         $('#routing_number').focus();
        //         $('#invalid_routing_number').css('display', 'block');
        //         // return false;
        //         invalid_counted += 1;
        //     }
        //     if($('#swift_code').val() == ''){
        //         personal_active();
        //         $('#swift_code').focus();
        //         $('#invalid_swift_code').css('display', 'block');
        //         // return false;
        //         invalid_counted += 1;
        //     }
        //     if($('#currency').val() == ''){
        //         personal_active();
        //         $('#currency').focus();
        //         $('#invalid_currency').css('display', 'block');
        //         // return false;
        //         invalid_counted += 1;
        //     }
            
        //     // if(account_book == '' && $('#account_book').val() == ''){
        //     //     personal_active();
        //     //     $('#account_book').focus();
        //     //     $('#invalid_account_book').css('display', 'block');
        //     //     return false;
        //     // }
            
        //     if($("#preview_image_passport").attr('src') == '' && $('#img_passport').val() == ''){
        //         personal_active();
        //         $('#img_passport').focus();
        //         $('#invalid_img_passport').css('display', 'block');
        //         // return false;
        //         invalid_counted += 1;
        //     }
            
        //     if (invalid_counted > 0) {
        //         return false;
        //     }


        //     // validate academic
        //     if(academic_form.length > 0){
        //         for (let i = 0; i < academic_form.length; i++) {

        //             if($('#institute_name'+i).val() == ''){
        //                 personal_active();
        //                 $('#institute_name'+i).focus();
        //                 $('#invalid_institute_name'+i).css('display', 'block');
        //                 return false;
        //             }
        //             if($('#level_study'+i).val() == ''){
        //                 personal_active();
        //                 $('#level_study'+i).focus();
        //                 $('#invalid_level_study'+i).css('display', 'block');
        //                 return false;
        //             }
        //             if($('#institution_country'+i).val() == ''){
        //                 personal_active();
        //                 $('#institution_country'+i).focus();
        //                 $('#invalid_institution_country'+i).css('display', 'block');
        //                 return false;
        //             }
        //             if($('#institution_state'+i).val() == ''){
        //                 personal_active();
        //                 $('#institution_state'+i).focus();
        //                 $('#invalid_institution_state'+i).css('display', 'block');
        //                 return false;
        //             }
        //             if($('#institution_city'+i).val() == ''){
        //                 personal_active();
        //                 $('#institution_city'+i).focus();
        //                 $('#invalid_institution_city'+i).css('display', 'block');
        //                 return false;
        //             }
        //             if($('#degree_name'+i).val() == ''){
        //                 personal_active();
        //                 $('#degree_name'+i).focus();
        //                 $('#invalid_degree_name'+i).css('display', 'block');
        //                 return false;
        //             }
        //             if($('#degree_actual'+i).val() == ''){
        //                 personal_active();
        //                 $('#degree_actual'+i).focus();
        //                 $('#invalid_degree_actual'+i).css('display', 'block');
        //                 return false;
        //             }
        //             if($('#discipline'+i).val() == ''){
        //                 personal_active();
        //                 $('#discipline'+i).focus();
        //                 $('#invalid_discipline'+i).css('display', 'block');
        //                 return false;
        //             }
        //             if($('#endrolled_from'+i).val() == ''){
        //                 personal_active();
        //                 $('#endrolled_from'+i).focus();
        //                 $('#invalid_endrolled_from'+i).css('display', 'block');
        //                 return false;
        //             }
        //             // if($('#endrolled_to'+i).val() == ''){
        //             //     personal_active();
        //             //     $('#endrolled_to'+i).focus();
        //             //     $('#invalid_endrolled_to'+i).css('display', 'block');
        //             //     return false;
        //             // }
                
        //         }
        //     }
        //     return true;
        // });

        // $("#btn-submit-contact").click(function(){
        //     var password = $('#password').val();
        //     var confirm_password = $('#confirm_password').val();
        //     let invalid_counted = 0;
        //     if(password != confirm_password){
        //         alert("Password and Confirm Password doesn't match");
        //         $('#password').focus();
        //         event.preventDefault();
        //     }

        //     phoneNumber = $("input[name='phone_number[]']");
        //     emergencyContact = $(document).find('.label-item');
            
        
        //     if($('#primary_email').val() == ''){
        //         personal_active_contact();
        //         $('#primary_email').focus();
        //         $('#invalid_primary_email').css('display', 'block');
        //         invalid_counted += 1;
        //     }
        //     if($('#zipcode').val() == ''){
        //         personal_active_contact();
        //         $('#zipcode').focus();
        //         $('#invalid_zipcode').css('display', 'block');
        //         invalid_counted += 1;
        //     }
        //     if($('#street').val() == ''){
        //         personal_active_contact();
        //         $('#street').focus();
        //         $('#invalid_street').css('display', 'block');
        //         invalid_counted += 1;
        //     }
        //     if($('#address_city').val() == ''){
        //         personal_active_contact();
        //         $('#address_city').focus();
        //         $('#invalid_address_city').css('display', 'block');
        //         invalid_counted += 1;
        //     }
        //     if($('#phone_number_0').val() == ''){
        //         personal_active_contact();
        //         $('#phone_number_0').focus();
        //         $('#invalid_phone_number_0').css('display', 'block');
        //         // return false;
        //         invalid_counted += 1;
        //     }

        //     if($('#home_phone_number').val() == ''){
        //         personal_active_contact();
        //         $('#home_phone_number').focus();
        //         $('#invalid_home_phone_number').css('display', 'block');
        //             // return false;
        //         invalid_counted += 1;
        //     }
        //     if($('#address_state').val() == ''){
        //         personal_active_contact();
        //         $('#address_state').focus();
        //         $('#invalid_address_state').css('display', 'block');
        //         invalid_counted += 1;
        //     }
        //     if($('#address_country').val() == ''){
        //         personal_active_contact();
        //         $('#address_country').focus();
        //         $('#invalid_address_country').css('display', 'block');
        //         invalid_counted += 1;
        //     }

        //     if ($('#current-residence').is(':checked') != true) {
        //         if($('#residence_country').val() == ''){
        //             personal_active_contact();
        //             $('#residence_country').focus();
        //             $('#invalid_residence_country').css('display', 'block');
        //             invalid_counted += 1;
        //         }
        //         if($('#residence_street').val() == ''){
        //             personal_active_contact();
        //             $('#residence_street').focus();
        //             $('#invalid_residence_street').css('display', 'block');
        //             invalid_counted += 1;
        //         }
        //         if($('#residence_state').val() == ''){
        //             personal_active_contact();
        //             $('#residence_state').focus();
        //             $('#invalid_residence_state').css('display', 'block');
        //             invalid_counted += 1;
        //         }
        //         if($('#residence_zipcode').val() == ''){
        //             personal_active_contact();
        //             $('#residence_zipcode').focus();
        //             $('#invalid_residence_zipcode').css('display', 'block');
        //             invalid_counted += 1;
        //         }
        //         if($('#residence_city').val() == ''){
        //             personal_active_contact();
        //             $('#residence_city').focus();
        //             $('#invalid_residence_city').css('display', 'block');
        //             invalid_counted += 1;
        //         }
        //     }

        //     // Emergency Contact Validation
        //     for(let i = 0; i < emergencyContact.length; i++) {
        //         // First Name validation
        //         if($('#firs_name_temp'+i).val() == ''){
        //             $('#firs_name_temp'+i).focus();
        //             $('#invalid_firs_name_temp'+i).css('display', 'block');
        //             invalid_counted += 1;
        //         }
                
        //         // Last Name validation
        //         if($('#last_name_temp'+i).val() == ''){
        //             $('#last_name_temp'+i).focus();
        //             $('#invalid_last_name_temp'+i).css('display', 'block');
        //             invalid_counted += 1;
        //         }
                
        //         // Country validation
        //         if($('#'+i+'temp_country').val() == ''){
        //             $('#'+i+'temp_country').focus();
        //             $('#invalid_temp_country'+i).css('display', 'block');
        //             invalid_counted += 1;
        //         }
                
        //         // Street validation
        //         if($('#street_temp'+i).val() == ''){
        //             $('#street_temp'+i).focus();
        //             $('#invalid_street_temp'+i).css('display', 'block');
        //             invalid_counted += 1;
        //         }
                
        //         // State validation
        //         if($('#'+i+'temp_state').val() == ''){
        //             $('#'+i+'temp_state').focus();
        //             $('#invalid_temp_state'+i).css('display', 'block');
        //             invalid_counted += 1;
        //         }
                
        //         // City validation
        //         if($('#'+i+'temp_city').val() == ''){
        //             $('#'+i+'temp_city').focus();
        //             $('#invalid_temp_city'+i).css('display', 'block');
        //             invalid_counted += 1;
        //         }
                
        //         // Postal Code validation
        //         if($('#zipcode_tmep'+i).val() == ''){
        //             $('#zipcode_tmep'+i).focus();
        //             $('#invalid_zipcode_tmep'+i).css('display', 'block');
        //             invalid_counted += 1;
        //         }
                
        //         // Phone validation
        //         if($('#phone_temp'+i).val() == ''){
        //             $('#phone_temp'+i).focus();
        //             $('#invalid_phone_temp'+i).css('display', 'block');
        //             invalid_counted += 1;
        //         }
                
        //         // Email validation
        //         if($('#email_temp'+i).val() == ''){
        //             $('#email_temp'+i).focus();
        //             $('#invalid_email_temp'+i).css('display', 'block');
        //             invalid_counted += 1;
        //         }
                
        //         // Relationship validation
        //         if($('#relation'+i).val() == ''){
        //             $('#relation'+i).focus();
        //             $('#invalid_relation'+i).css('display', 'block');
        //             invalid_counted += 1;
        //         }
        //     }

        //     if (invalid_counted > 0) {
        //         return false;
        //     }
        // });

        if(academic_form.length > 0){
            for (let i = 0; i < academic_form.length; i++) {
                $('#degree_name'+i).change(function(e){
                    if(this.value == 'Other'){
                        $("#other_degree_col"+i).css('display', 'block')
                    }else{
                        $("#other_degree_col"+i).css('display', 'none')
                    }
                })
            }
        }

        function personal_active() {
            $('#li_personal').addClass('active');
            $('#personal').addClass('active in');
            $('#li_contact').removeClass('active');
            $('#contact').removeClass('active in');
        }

        function personal_active_contact() {
            $('#li_contact').addClass('active');
            $('#contact').addClass('active in');
            $('#li_personal').removeClass('active');
            $('#personal').removeClass('active in');
        }

        // validation upload file 5mb
        $('#img_photo,#img_passport').change(function(e){
            const file_input = $(this);
            const allowed_extensions = ['jpg', 'jpeg', 'png', 'pdf'];
            const file_name = file_input.val();

            const is_valid_extension = allowed_extensions.some(function(extension) {
                return file_name.toLowerCase().endsWith(extension);
            });

            if (!is_valid_extension) {
                alert('File type should be ' + '<?php echo human_readable_list(ALLOWED_PROFILE_FILETYPE, ','); ?>');
                $(this).val('');
                return false;
            }
            // after extension validated, do validate filesize
            var size_file = e.target.files[0].size;
            if(size_file > 5000000){ //if > 5mb
                $('#invalid_photo').css('display', 'block');
                $('#invalid_photo_required').css('display', 'none');
                $('#img_photo').val('');

                $('#invalid_img_passport_size').css('display', 'block');
                $('#invalid_img_passport').css('display', 'none');
                $('#img_passport').val('');
                return false;
            }else{
                $('#invalid_photo_required').css('display', 'none');
                $('#invalid_img_passport').css('display', 'none');
            }
        });

        $('#account_book').change(function(e){
            var size_file = e.target.files[0].size;
            if(size_file > 5000000){ //if > 5mb
                $('#invalid_account_book_size').css('display', 'block');
                $('#invalid_account_book').css('display', 'none');
                $('#account_book').val('');
                return false;
            }else{
                $('#invalid_account_book').css('display', 'none');
            }
        });

        $('input[name="has_dependents"]').on('change', function() {
        var hasDependents = $(this).val();
        
        if (hasDependents === '1') {
            $('#dependent_fields_section').show();
            $('#number_of_dependents').prop('required', true);
            $('#number_of_school_age_dependents').prop('required', true);
        } else {
            $('#dependent_fields_section').hide();
            $('#number_of_dependents').prop('required', false).val('');
            $('#number_of_school_age_dependents').prop('required', false).val('');
        }
    });
    
    var initialHasDependents = $('input[name="has_dependents"]:checked').val();
    if (initialHasDependents === '1') {
        $('#dependent_fields_section').show();
        $('#number_of_dependents').prop('required', true);
        $('#number_of_school_age_dependents').prop('required', true);
    } else {
        $('#dependent_fields_section').hide();
    }
    
    $('#number_of_dependents, #number_of_school_age_dependents').on('input', function() {
        var totalDependents = parseInt($('#number_of_dependents').val()) || 0;
        var schoolAgeDependents = parseInt($('#number_of_school_age_dependents').val()) || 0;
        
        if (schoolAgeDependents > totalDependents) {
            $('#number_of_school_age_dependents').val(totalDependents);
            showNotification('Number of school age dependents cannot exceed total number of dependents', 'warning');
        }
    });
        
    function showNotification(message, type) {
        if ($('#dependent-notification').length === 0) {
            $('body').append('<div id="dependent-notification" class="alert alert-' + type + '" style="position: fixed; top: 20px; right: 20px; z-index: 9999; display: none;"></div>');
        }
        
        var notification = $('#dependent-notification');
        notification.text(message).fadeIn();
        
        setTimeout(function() {
            notification.fadeOut();
        }, 3000);
    }
    });
</script>