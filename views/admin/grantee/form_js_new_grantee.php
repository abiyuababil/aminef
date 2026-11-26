<script src="<?php echo base_url() ?>js/wijmo.min.js"></script>

<script>
    // $('#form').on('submit', function() {

    //     var valid_email = /^(([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)(\s*;\s*|\s*$))*$/;

    //     if ($('#primary_email').val() != '' && !valid_email.test($('#primary_email').val())) {
    //         alert('Email not valid.');
    //         $('#primary_email').focus();
    //         return false;
    //     }

    //     return true;
    // });
    
    $('#degree_name').change(function(e){
        if(this.value == 'Other'){
            $("#other_degree_col").css('display', 'block')
        }else{
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
            url: '<?php echo site_url('world/getPartial') ?>/'+ idx,
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
            url: '<?php echo site_url('world/getPartialInstitution') ?>/'+ idx,
            dataType: 'JSON',
            success: function(r) {
                var html = r;
                $('#wrap-institution').append(html);
                $('.select2').select2({
                    theme: 'bootstrap'
                });
                $('.add-load').hide();
                $( ".datepicker" ).datepicker({
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

    function del_file(el, name, label,value='') {
        if (confirm("Are you sure want to delete " + label + " ?")) {
            var html = '<input type="hidden" name="' + name + '" value="' + value + '">';
            $(el).parent().replaceWith(html);
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
        var state_el = 'select-city-birth';
        $('.load-city-birth').show();
        reset_state(this.id);
        reset_city(this.id);
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('world/countrycity') ?>/' + this.value,
            dataType: 'JSON',
            success: function(r) {
                $.each(r, function(id, val) {
                    $('.' + state_el).append('<option value="' + val.id + '">' + val.name + '</option>');
                });
                $('.load-city-birth').hide();
            }
        });
    });

    function select_country(i) {
        var country_el = 'institution_country'+i;
        var state_el = 'institution_state'+i;
        var city_el = 'institution_city'+i;
        $('.load-province-academic'+i).show();
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
                $('.load-province-academic'+i).hide();
            }
        });
    }

    function select_state(i) {
        var state_el = 'institution_state'+i;
        var city_el = 'institution_city'+i;
        $('.load-city-academic'+i).show();
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
                $('.load-city-academic'+i).hide();
            }
        });
    }

    function reset_state(id) {
        var state_id = '#' + id.split('_')[0] + '_state';
        $(state_id).html('');
        $(state_id).append('<option value="">-- Select Province --</option>');
    }

    function reset_city(id) {
        var city_id = '#' + id.split('_')[0] + '_city';
        $(city_id).html('');
        $(city_id).append('<option value="">-- Select City --</option>');
    }

    function select_province(el) {
        var selectValue = $(".select-country"+ el).val();
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
        var selectValue = $(".select-state"+ el).val();
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
        var selectValue = $(".select-country-academic"+ el).val();
        $('.load-city-academic'+el).show();
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('world/countrycity') ?>/' + selectValue,
            dataType: 'JSON',
            success: function(r) {
                $.each(r, function(id, val) {
                    $('.select-city-academic' + el).append('<option value="' + val.id + '">' + val.name + '</option>');
                });
                $('.load-city-academic'+el).hide();
            }
        });
    }

    function reset_password(id) {
        if (confirm("Are you sure want to send email for reset password ?")){
            $('.reset-load').show();
            var email = $('#primary_email').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/grantee/reset_password') ?>',
                data: {
                    id : id,
                    email : email
                },
                success: function(r) {
                    if(r.err_message == false){
                        alert(r.success_message);
                    }
                    $('.reset-load').hide();
                }
            });
        }
    }

    
        

    function reset_done(step, args){
        // remove all class done
        $(".stepper-list").removeClass("done");
        for (let i = step; i > 0; i--) {
            $(`#li_step_${i}`).addClass("done");
        }

        // trigger a clicked when li clicked
        var children = $(args).children('a');
        children[0].click()
    }
    
    $('input[type=file]').change(function (e) {
        if($(this).val() != ''){
            $('#file_name1').html($(this).val());
        }else{
            $('#file_name1').html('No file chosen');
        }
    });
    
    $("#btn-deleted").click(function(){
        $("#mdl_info").modal();    
        event.preventDefault();
    });
    
    var error = 0;

    $(document).ready(function() {
        var notNullGrant = $("#select-grant").val();
        if(notNullGrant != ""){
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/grantee/get_category_date') ?>',
            data: {
                grant_id : notNullGrant
            },
            success: function(r) {
                $('#wrap-category-report').html('');
                $('#wrap-category-report').append(r);
                $( ".datepicker" ).datepicker({
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
        if (confirm("Are you sure want to accept this ?")){
            var note = $("#note"+id).val();
            var fiscal_year = $("#fiscal_year").val();
            var grant_id = $("#grant_id").val();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/grantee/action_report') ?>',
                data: {
                    id      : id,
                    note    : note,
                    user_id : user_id,
                    status  : 'accept',
                    fiscal_year : fiscal_year,
                    grant_id : grant_id
                },
                success: function(r) {
                    if(r.err_message == false){
                        location.href=r.redirect;
                    }
                }
            });
        }
        
    }

    function revisi_report(id, user_id) {
        if (confirm("Are you sure want to revisi this ?")){
            var note = $("#note"+id).val();
            var fiscal_year = $("#fiscal_year").val();
            var grant_id = $("#grant_id").val();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/grantee/action_report') ?>',
                data: {
                    id      : id,
                    note    : note,
                    user_id : user_id,
                    status  : 'revisi',
                    fiscal_year : fiscal_year,
                    grant_id : grant_id
                },
                success: function(r) {
                    if(r.err_message == false){
                        location.href=r.redirect;
                    }
                }
            });
        }
        
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

    $("#select-grant").change(function(){
        // alert("babi");
        var grant_id = this.value;
        $("#report-spinner").show();
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/grantee/get_category_date') ?>',
            data: {
                grant_id : grant_id
            },
            success: function(r) {
                $('#wrap-category-report').html('');
                $('#wrap-category-report').append(r);
                $( ".datepicker" ).datepicker({
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
    });


    // ===================================================================
    // - paymnt item sort berdasarkan name 
    // ===================================================================
</script>