<script src="<?php echo base_url() ?>js/wijmo.min.js"></script>

<script>
    $('#form').on('submit', function() {

        var valid_email = /^(([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)(\s*;\s*|\s*$))*$/;

        if ($('#primary_email').val() != '' && !valid_email.test($('#primary_email').val())) {
            alert('Email not valid.');
            $('#primary_email').focus();
            return false;
        }

        return true;
    });

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
                $('.select_multiselect').select2();
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
                $('.select_multiselect').select2();
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

    function del_file(el, name, label, subId='', submissionId = '') {
        if (confirm("Are you sure want to delete " + label + " ?")) {
            const loadIcon   = '<img src="<?php echo base_url() ?>/img/loading.gif">'
            var fileview     = $(el).closest('.col-lg-4').find('.fileview'); 
            var fileviewFull = $(el).closest('.is_row_class').find('.fileview'); 
            var btnDelete    = $(el).closest('.col-lg-4').find('.btn-del-sub'); 
            var filename     = $(el).closest('.col-lg-4').find('.filename'); 
            var filenameFull = $(el).closest('.is_row_class').find('.filename'); 
            var html = '';
            html += '<div id="preview_section_' + subId + '" style="position:relative; width:100px;">'
            html += '<img onclick="add_file(\'my_file_\' + ' + subId + '\);" data-trigger="my_file_' + subId + '" height="100" style="margin-top: 16px; cursor: pointer;" id="preview_image_' + subId + '" class="preview_image_' + subId + '" src="<?php echo base_url('assets/images/icons/add-file.png'); ?>">'
            html += '<a href="javascript:;" onclick="del_file(this, \'' + name + '\', \'' + label + '\', ' + subId + ', ' + submissionId + ')" class="hide btn btn-danger btn-xs btn-delete' + subId + '" style="color:#fff;position:absolute; top:25px;"><i class="fa fa-trash fa-fw text-white"></i></a>'
            html += '<a download title="Click to download" class="hide btn btn-primary btn-xs btn-download' + subId + '" style="color:#fff;position:absolute; top:0;"><i class="fa fa-download fa-fw text-white"></i></a>'
            html += '</div>'
            html += '<p class="filename" style="font-size:16px;cursor:pointer;" data-toggle="tooltip" data-placement="left" title="No file chosen">No file chosen</p>'
            $(el).html(loadIcon)
            
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url('admin/grantee/delete_submission_value') ?>/' + submissionId,
                dataType: 'JSON',
                success: function(r) {
                    console.log("Success: Files deleted!");
                    $(el).parent().replaceWith(html);
                    btnDelete.css("display", "block")
                    fileview.css("display", "none");
                    fileviewFull.css("display", "none");
                    filename.remove();
                    filenameFull.remove();
                    $(".my_file_" + subId).prop("required", true)
                    $(".my_file_" + subId).val('')
                }
            });
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

    
        

    function reset_done(step, args,key){
        // remove all class done
        $("."+key+"_stepper-list").removeClass("done");
        for (let i = step; i > 0; i--) {
            $(`#${key}_li_step_${i}`).addClass("done");
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

    function show_preview(element, type) {
        const file = element.files[0];
        var fileSize = file.size;
        var maxSize = 5 * 1024 * 1024;
        if (file) {
            let reader = new FileReader();
            let filename = file.name;
            let ext = filename.split('.').pop();

            const allowed_extensions = ['gif', 'jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx', 'xsl', 'xlsx'];

            const is_valid_extension = allowed_extensions.some(function(extension) {
                return ext.toLowerCase().endsWith(extension);
            });
            
            reader.readAsText(file.slice(0, 50000));


            let pdf_icon = '<?php echo base_url('assets/images/icons/pdf.svg'); ?>';
            let download_icon = '<?php echo base_url('assets/images/icons/download icon.png'); ?>';
            reader.onload = function(event) {
                var fileContent = event.target.result;
                if((fileSize < maxSize) && is_valid_extension){
                    if (ext == 'jpg' || ext == 'png' || ext == 'jpeg') {
                        $('#preview_image_' + type).attr('src', event.target.result);
                        $('#preview_image_' + type).attr('height', 100);
                        $('#preview_image_' + type).css('margin-top', "-5px");
                    } else if (ext == 'pdf') {
                        if (fileContent.includes('/Encrypt')) {
                            $(element).val('');
                        }else{
                            $('#preview_image_' + type).attr('src', pdf_icon);
                        }
                    } else {
                        $('#preview_image_' + type).attr('src', download_icon);
                    }
                }else{
                    $(element).val(''); // Hapus file yang dipilih
                }

            }

            reader.readAsDataURL(file);
        }

        // const file = element.files[0];
        
        // if (file){
        //     let reader = new FileReader();
        //     let filename = file.name;
        //     let ext = filename.split('.').pop();
        //     let pdf_icon = '<?php echo base_url('assets/images/icons/pdf.svg'); ?>';
        //     reader.onload = function(event){
        //         if (ext == 'jpg' || ext == 'png' || ext == 'jpeg') {
        //             $('#preview_image_' + type).attr('src', event.target.result);
        //             $('#preview_image_' + type).attr('height', 100);
        //             $('#preview_image_' + type).css('margin-top', "-5px");
        //         } else if (ext == 'pdf') {
        //             $('#preview_image_' + type).attr('src', pdf_icon);
        //         } else {
        //             $('#preview_image_' + type).attr('src', download_icon);
        //         }
                
        //     }

        //     reader.readAsDataURL(file);
        // }
    }
    
    var error = 0;
    var show_required_active = function(){
        $('.text-required').remove();
        $( '.active .autosave').each( function () {
            var is_required = $(this).attr('required');
            if (is_required){
                if($(this).val() == '' || $(this).val() == null){
                    if ($(this).val() == null) {
                        $(this).parent('div:last').append('<p class="text-required text-danger">This field is required</p>');
                        $(this).focus();
                    } else {
                        $(this).after('<p class="text-required text-danger">This field is required</p>');
                        $(this).focus();
                    }
                }
            }
        });
    }
    $(document).ready(function() {
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
                        checkbox.prop('disabled', false);
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
                            checkbox.prop('disabled', false);
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
        
        $(".datetime").datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            autoclose: true,
        });
        $('.select_multiselect').select2();
        $(".select2-country").on('select2:select', function () {
            $(this).trigger('blur');
            $(this).attr('data-value', $(this).val());
            let key_of_unique = $(this).data('select_key_country');
            $(".select2-state[data-select_key_country='"+key_of_unique+"']").val(null).trigger('change').trigger('blur');
            $(".select2-city[data-select_key_country='"+key_of_unique+"']").val(null).trigger('change').trigger('blur');
        });
        $(".select2-state").on('select2:select', function () {
            $(this).trigger('blur');
            $(this).attr('data-value', $(this).val());
            let key_of_unique = $(this).data('select_key_country');
            $(".select2-city[data-select_key_country='"+key_of_unique+"']").val(null).trigger('change').trigger('blur');
        });
        $(".select2-city").on('select2:select', function () {
            $(this).trigger('blur');
        });
        $(".select2-parent-field-of-study").on('select2:select', function () {
            $(this).trigger('blur');
            let key_of_unique = $(this).data('select_key_state_of_study');
            $(".select2-field-of-study[data-select_key_state_of_study='"+key_of_unique+"']").val(null).trigger('change').trigger('blur');
        });
        $(".select2-field-of-study").on('select2:select', function () {
            $(this).trigger('blur');
        });
        
        $(".autosave").blur(function(){
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
            var is_advanced_checkbox = element.data('is_advanced_checkbox');

            // add logic for checkbox non advanced checkbox
            if (is_advanced_checkbox != 1) {
                if ($(this).is(':checkbox')){
                    data_value = [];
                        $.each($(`input[type='checkbox']:checked`), function(){
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

            // add logic for multiple choice grid 
            if ($(this).hasClass('multiple-choice-grid')){
                data_value = [];
                $.each($(`.table_${custom_fields_id} input:radio.multiple-choice-grid:checked`), function(){
                    data_value.push($(this).val())
                })
                    
            }
            

            // error = 0;
            // checking_active();

            // if (error == 0){
            //     $(".next, .submit-submission").removeClass("disabled");
            // }else{
            //     $(".next, .submit-submission").addClass("disabled");
            // }

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
                is_other: false,
                user_grantee_id: user_grantee_id
            };
            if ($(this).hasClass('text-have-other')){
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
        });

        $(".autosave-other-checkbox-input").blur(function(){
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
                is_other: false,
                user_grantee_id: user_grantee_id
            };
            
            console.log(data);

            $.ajax({
                url: "<?= base_url(); ?>admin/grantee/save_fields_checkbox",
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

        var is_submit = false;
        $(".submit-submission").click(function() {
            is_submit = true;
            var grantee_grant_id = $('#grantee_grant_id').val();
            let first_invalid_tab = '';
            $(".submission-pane").each(function() {
                console.log($(this).attr('id'))
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
                text: "Please check all data before you submit.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, submit",
                customClass: 'swal-custom'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'GET',
                        url: '<?php echo site_url('admin/in_progress/sumbit_submission') ?>/' + grantee_grant_id,
                        dataType: 'JSON',
                        success: function(r) {
                            Swal.fire({
                                title: "Success",
                                text: "Your Application hasbeen submited we'll be in touch shortly!",
                                icon: "success",
                                timer: 700,
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
                                    location.href='<?= site_url('admin/application/manage') ?>'
                                }
                            });
                        }
                    });
                    
                }
            });

            default_active_tab_admin();
        });
    });

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

    var checking_active = function(){
        $( '.active .autosave').each( function () {
            var is_required = $(this).attr('required');
            if (is_required){
                if($(this).val() == ''){
                    error++;
                }
            }
        });
    }

    function accept_report(id, user_id) {
        if (confirm("Are you sure want to accept this ?")){
            var note = $("#note"+id).val();
            var grantee_grant_id = $("#grantee_grant_id").val();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/grantee/action_report') ?>',
                data: {
                    id      : id,
                    note    : note,
                    user_id : user_id,
                    grantee_grant_id : grantee_grant_id,
                    status  : 'accept'
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
            var grantee_grant_id = $("#grantee_grant_id").val();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/grantee/action_report') ?>',
                data: {
                    id      : id,
                    note    : note,
                    user_id : user_id,
                    grantee_grant_id : grantee_grant_id,
                    status  : 'revisi'
                },
                success: function(r) {
                    if(r.err_message == false){
                        location.href=r.redirect;
                    }
                }
            });
        }
        
    }

    function next_step(step,key){
        $("#"+key+"_li_step_"+(step-1)).removeClass("active");
        $("#"+key+"_li_step_"+(step-1)).addClass("done");
        $("#"+key+"_li_step_"+step).addClass("active");
    }

    function back_step(step,key){
        console.log(step)
        $("#"+key+"_li_step_"+(step+1)).removeClass("active");
        $("#"+key+"_li_step_"+(step+1)).removeClass("done");
        $("#"+key+"_li_step_"+step).addClass("active");
    }
    
    function accept_submission(user_id, grant_id, key) {
        var label = 'Accept';
        if(key == 'selection'){ label = 'Selected'}
        console.log(label)
        // if (confirm("Are you sure want to "+ label +" this ?")){
            $(".btn").attr('disabled','disabled');
            $('#btn-successful').html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop('disabled', true);
            var note = $('#'+key+'_note_submission').val();
            var grantee_grant_id = $('#grantee_grant_id').val();
            if(key == 'selection'){
                url = '<?php echo site_url('admin/selection/accept_submission') ?>';
            }else if(key == 'candidate'){
                url = '<?php echo site_url('admin/candidate/accept_submission') ?>';
            }else if(key == 'on_going'){
                url = '<?php echo site_url('admin/on_going/accept_submission') ?>';
            }else if(key == 'returning'){
                url = '<?php echo site_url('admin/returning/accept_submission') ?>';
            }

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    note    : note,
                    user_id : user_id,
                    grant_id : grant_id,
                    grantee_grant_id : grantee_grant_id
                },
                success: function(r) {
                    if(r.err_message == false){
                        location.href=r.redirect;
                    }
                }
            });
        // }

    }

    function revise_submission(user_id, grant_id, key) {
        // if (confirm("Are you sure want to Revise this ?")){
            $(".btn").attr('disabled','disabled');
            $('#btn-successful').html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop('disabled', true);
            var note = $('#'+key+'_note_submission').val();
            var grantee_grant_id = $('#grantee_grant_id').val();
            if(key == 'selection'){
                url = '<?php echo site_url('admin/selection/revise_submission') ?>';
            }else if(key == 'candidate'){
                url = '<?php echo site_url('admin/candidate/revise_submission') ?>';
            }else if(key == 'on_going'){
                url = '<?php echo site_url('admin/on_going/revise_submission') ?>';
            }else if(key == 'returning'){
                url = '<?php echo site_url('admin/returning/revise_submission') ?>';
            }
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    note    : note,
                    user_id : user_id,
                    grant_id : grant_id,
                    grantee_grant_id : grantee_grant_id
                },
                success: function(r) {
                    if(r.err_message == false){
                        location.href=r.redirect;
                    }
                }
            });
        // }

    }

    $(".succesfully").click(function(){
        var id = $(this).data('id');
        $("#mdl_info").modal();   
        $('#btn-successful').attr("onclick","succesfully("+ id +")"); 
        event.preventDefault();
    });
    
    function succesfully(grantee_id)
    {
        $.ajax({
                url: "<?= base_url(); ?>admin/selection/successfully",
                method: "POST",
                data: {
                    grantee_id: grantee_id,
                }
            })
            .success(function(data){
                window.location.href = data.redirect;
            })
    }
    function upload_button(element) {

        var data_value = $(element).data('file-value');
        var fileview   = $(element).closest('.col-lg-4').find('.fileview'); 
        var fileviewFull   = $(element).closest('.is_row_class').find('.fileview'); 
        var icon       = $(element).closest('.col-lg-4').find('.submission-spinner'); 
        var base_url   = "<?= base_url()?>";
        // trigger click to closest type file
        $(`.${data_value}`).click();

        // add event when file has choosen
        $(`.${data_value}`).change(function(e) {
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
            var grantee_grant_id = $("#grantee_grant_id").val();
            var user_grantee_id = $("#grantee_id").val();
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
            $(this).removeAttr('required');
            // error = 0;
            // checking_active();

            // set filename into label
            var substrFileName = fileName;
            if (substrFileName.length > 15) {
                substrFileName = substrFileName.substring(0, 15) + '....';
            }
            $(this).closest('.col-lg-4').find('.filename').html(substrFileName).attr('title', fileName)
            $(this).closest('.is_row_class').find('.filename').html(substrFileName).attr('title', fileName)
            // icon.css('display', 'block')

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
            formData.append("grantee_grant_id", grantee_grant_id)
            formData.append("user_grantee_id", user_grantee_id)

            // autosave
            $.ajax({
                url: "<?= base_url(); ?>admin/grantee/save_fields",
                type: 'POST',
                data: formData, // The form with the file inputs.
                processData: false,
                contentType: false
            }).done(function(r) {
                var postsjson = $.parseJSON(r);

                if(postsjson.redirect){
                    window.location.href = postsjson.redirect;
                    return false
                }
                
                icon.css("display", "none");
                $(".btn-download"+upload_id).attr("href", base_url+postsjson.filepath );
                fileview.css("display", "inline-block");
                fileview.attr("href", base_url+postsjson.filepath );
                fileviewFull.css("display", "inline-block");
                fileviewFull.attr("href", base_url+postsjson.filepath );
                // if (error == 0){
                //     $(".next, .submit-submission").removeClass("disabled");
                // } else {
                //     // $(".next, .submit-submission").addClass("disabled");
                // }

                // Dapatkan nilai onclick saat ini
                var currentOnclick = $(".btn-delete" + upload_id).attr('onclick');
                if (currentOnclick != undefined) {
                    var newOnclick = currentOnclick.replace(/'subid'/g, postsjson.submission_id);
                    $(".btn-delete" + upload_id).attr('onclick', newOnclick);
                }
                $(".btn-delete" + upload_id).removeClass("hide");
                $(".btn-download" + upload_id).removeClass("hide");
            });
        })
    }

    function submission_onblur(element) {
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
        var grantee_grant_id = $("#grantee_grant_id").val();
        var user_grantee_id = $("#grantee_id").val();
        $('.radio_' + unique_id).val(data_value);

        // add logic for checkbox
        if ($(element).is(':checkbox')){
            data_value = [];
                $.each($(`input[type='checkbox']:checked`), function(){
                    data_value.push($(this).val())
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
                data_value.push($(this).val())
            })
            
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
            grantee_grant_id: grantee_grant_id,
            user_grantee_id: user_grantee_id,
            multiple_file_id: multiple_id,
            multiple_step_id: multiple_step_id,
            is_other: false,
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
            .success(function(data) {
                if (data.success == false) {
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

        const last_element = $('.tab-content').children().last();
        const before_last_element = last_element.prev();
    });


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
    

    function add_more_step_fields(element) {
        var step_id = $(element).data("id");
        var user_grantee_category_id = $(element).data("user_grantee_category_id");
        var user_grantee_grant_id = $(element).data("user_grantee_grant_id");
        var period_id = $(element).data("period_id");
        var grantee_grant_id = $("#grantee_grant_id").val();
        $(".add-multiple-step-spinner-" + step_id).show();

        var formData = new FormData();
        formData.append("user_grantee_step_id", step_id),
        formData.append("user_grantee_category_id", user_grantee_category_id),
        formData.append("user_grantee_grant_id", user_grantee_grant_id),
        formData.append("period_id", period_id),
        formData.append("grantee_grant_id", grantee_grant_id),
        formData.append("is_for_add_new", true),

        $.ajax({
            url: "<?= base_url(); ?>admin/grantee/multiple_field_step",
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

    function navigate_tab_admin(index, step) {
        console.log('index', index)
        if (typeof step === 'number') {
            step = index +'_step_' + step;
        }
        $("#" + step).addClass("active in");
        
        location.hash = "#" + step;
        var selected = $(".tabs").tabs("option", "active");
        $(".tabs").tabs("option", "active", selected);
    }


    function release_submission(user_id, grant_id, key) {
        // if (confirm("Are you sure want to release this ?")){
            $(".btn").attr('disabled','disabled');
            $('#btn-successful').html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop('disabled', true);
            var note = $('#'+key+'_note_submission').val();
            var grantee_grant_id = $('#grantee_grant_id').val();
            url = '<?php echo site_url('admin/in_progress/release_submission') ?>';
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    note    : note,
                    user_id : user_id,
                    grant_id : grant_id,
                    grantee_grant_id : grantee_grant_id
                },
                success: function(r) {
                    console.log(r);
                    if(r.err_message == false){
                        location.href=r.redirect;
                    }
                }
            });
        // }

    }
</script>