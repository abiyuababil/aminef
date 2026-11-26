<script>
    const SITE_URL = '<?php echo site_url(); ?>';
    $('.select2').select2({
            theme: 'bootstrap'
});

    function reset_state(id) {
        var state_id = '#' + id.split('_')[0] + '_state';
        $(state_id).html('');
        $(state_id).append('<option value="">-- Select State/Province --</option>');
    }

    function reset_city(id) {
        var city_id = '#' + id.split('_')[0] + '_city';
        $(city_id).html('');
        $(city_id).append('<option value="">-- Select City --</option>');
    }


    function show_pcode(el_country, el_pcode) {
        var country_code = $('#' + el_country + ' option:selected').attr('data-pcode');
        if (country_code != undefined)
            $('#' + el_pcode).val('+' + country_code);
    }

    $(function() {
        show_pcode('of_country', 'of_phone_code');
        show_pcode('country', 'street');
    });

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

    $('select[name=grants]').on('change',function(){
        var period = $('select[name=period]');
        period.empty().append('<option value="">-- Choose Period --</option>');
        if(this.value != ''){
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url('world/period') ?>/' + this.value,
                dataType: 'JSON',
                success: function(r) {
                    $.each(r, function(id, val) {
                        period.append('<option value="' + val.id + '">' + val.fiscal_year + '</option>');
                    });
                }
            });
        }
    });

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
    
    function del_item(el, item_class) {
        if (confirm("Are you sure want to delete this ?"))
            $(el).closest('.' + item_class).remove();
    }

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
    $("#btn-deleted").click(function(e) {
        e.preventDefault();

        var id = $(this).data("id");

        Swal.fire({
            title: "Are you sure?",
            text: "This grantee data will be deleted.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
            reverseButtons: true
        }).then(function(result) {

            if (!result.isConfirmed) {
                return;
            }

            $.ajax({
                url: "<?= base_url('admin/users_grantee/delete_ajax/'); ?>" + id,
                type: "POST",
                dataType: "json",
                beforeSend: function() {
                    Swal.fire({
                        title: "Deleting...",
                        text: "Please wait.",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: function() {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(response) {

                    if (response.success) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Grantee data successfully deleted.",
                            icon: "success",
                            timer: 1500,
                            showConfirmButton: false
                        }).then(function() {
                            window.location.href =
                                "<?= base_url('admin/users_grantee/manage'); ?>";
                        });

                    } else {
                        Swal.fire({
                            title: "Failed",
                            text: response.message || "Failed delete data grantee.",
                            icon: "error"
                        });
                    }
                },
                error: function(xhr) {
                    var message = "Failed delete data grantee.";

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        title: "Error",
                        text: message,
                        icon: "error"
                    });
                }
            });
        });
    });

    // save();

    // AUTO SAVE FORM GRANTEE
    function save(){
            setTimeout( function(){ 
            var user_id = $('#grantee_id').val();
            var data_post = $("#form").serializeArray();
            data_post.push({
                name: 'user_id', value: user_id
            });
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/grantee/autosave_form') ?>',
                dataType: 'JSON',
                data: data_post,
                success: function(r) {
                if(r.success == false){
                    $("#mdl_validate").modal(); 
                    $("#validate_message").html(r.message); 
                    event.preventDefault();
                }else{
                    console.log('saved');
                    $("#success-alert").fadeTo(15000, 500).slideUp(500, function() {
                    $("#success-alert").slideUp(500);
                    });
                    for (var i = 0; i < r.index; i++) {
                        $('#delete_temp_'+i).val('');
                    }
                }
                }
            });
        }  , 60000 ); // in ms
        backsave();
    }

    function backsave(){
            setTimeout( function(){ 
                save();
        }  , 60000 ); // in ms

    }

    function show_preview(element, type) {
        const file = element.files[0];
        const filetype = file.name.split('.').pop();

        const allowed_extensions = ['jpg', 'jpeg', 'png'];

        const is_valid_extension = allowed_extensions.some(function(extension) {
            return filetype.toLowerCase().endsWith(extension);
        });

        if (is_valid_extension > 0){
            let reader = new FileReader();
            reader.onload = function(event){
                console.log(type)
                $("#preview_section_" + type).css('display', 'block');
                $('#preview_image_' + type).attr('src', event.target.result);
            }
            reader.readAsDataURL(file);
        } else {
            let currenct_src = $('#preview_image_' + type).attr('src');
            $('#preview_image_' + type).attr('src', currenct_src);
        }
    }

    function show_preview(element, type, upload_type) {
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
                url: SITE_URL + 'admin/users_grantee/save_file', 
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType : 'JSON',
                success: function(response) {
                    if (response.status) {
                        let file_url = SITE_URL + response.filepath;
                        $("#preview_section_" + type).css('display', 'block');
                        $('#preview_image_' + type).attr('src', response.preview);
                        $("#button_preview_" + upload_type).attr('href', file_url).removeClass('hide');
                        $("#button_download_" + upload_type).attr('href', file_url).removeClass('hide');
                        $("#button_delete_" + upload_type).removeClass('hide');
                        $("input[name='" + upload_type +"']").val(response.filepath);
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

        setTimeout( () => {
            $(".select-residence-state").change();
        }, 100);

        setTimeout( () => {
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
                    $('#' + state_el).append('<option value="' + val.id + '" ' + (address_state == val.id ? 'selected' : "") +'>' + val.name + '</option>');
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
        let params = $(this).val() == '' ? address_state : $(this).val();
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('world/city') ?>/' + params,
            dataType: 'JSON',
            success: function(r) {
            $.each(r, function(id, val) {
                    $('#' + city_el).append('<option value="' + val.id + '" ' + (address_city == val.id ? 'selected' : "") +'>' + val.name + '</option>');
                });
                $(load_id).hide();
            }
        });
    });

    
    $(document).ready(function() {
        // $(document).on('change', '#prefix_name', function () {
        //     if ($(this).val() === 'other') {
        //         $('#prefix_other').show().focus();
        //     } else {
        //         $('#prefix_other').hide().val('');
        //     }
        // });
        // $('#prefix_name').trigger('change');

        var access = '<?= has_permission('detail_grantee', 'edit') ?? 0 ?>';
        if(!access){
            $('.form-control').prop('disabled', true)
            $('.btn-d-none').css('display', 'none')
        }
        // $(".us-address-country").trigger('change');
    })


    $(".us-address-country").change(function() {
        var state_el = this.id.split('_')[0] + '_state';
        var load_id = '#load-' + state_el;
        $(load_id).show();
        reset_state(this.id);
        reset_city(this.id);
        if(this.value){
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
        }
    });
    
    $('input.check_default').on('change', function() {
        if ($("input.check_default:checked").length){
            $('input.check_default').not(this).prop('checked', false);  
        }else{
            alert ('Please select one Bank Info as default');
            $(this).prop('checked', true);
        }
    });

</script>