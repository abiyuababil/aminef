<script src="<?php echo base_url() ?>js/wijmo.min.js"></script>

<script>
    const SITE_URL = '<?php echo site_url(); ?>';

    // validation shoe contact US
    $(document).ready(function () {
        let invalid_counted_pid = 0;
        $('.select2').select2({
            theme: 'bootstrap'
        });
    });

    function isMandatoryComplete() {
        let invalid_counted = 0;

        const fields = [
            'first_name',
            'last_name',
            'date_of_birth',
            'country_of_birth',
            'state_of_birth',
            'city_of_birth',
            'gender',
            'country_of_citizenship',
            'identity_card_number'
        ];

        fields.forEach(function (id) {
            const el = $('#' + id);
            if (el.length && el.val().trim() === '') {
                invalid_counted++;
            }
        });

        // Cek image preview
        const fallbackImages = {
            'preview_identity_card_file': '<?= base_url('assets/images/idcard.png') ?>'
        };

        const labelMap = {
            'preview_identity_card_file': 'identity_card_file'
        };

        Object.entries(fallbackImages).forEach(([id, fallback]) => {
            const src = $("#" + id).attr("src");
            const labelId = labelMap[id];
            if ((src === "" || src === fallback) && $("#" + labelId).val() === "") {
                invalid_counted++;
            }
        });
        
        return invalid_counted === 0;
    }

    function validateStyle(element, currentTag) {

        element.addClass('has-error');
        currentTag.find('label').addClass('text-danger')

        // Deteksi jika select2, tambahkan border error ke tampilannya
        if (element.hasClass('select2-hidden-accessible')) {
            element.next('.select2-container').find('.select2-selection').addClass('has-error');
        }

    }



    $("#btn-submit").click(function () {
        let invalid_counted = 0;
        let isAdmin = <?= isset($is_admin) ? 1 : 0 ?>;

        if(isAdmin) { return invalid_counted; }
        
        const fields = [
            { id: 'first_name', error: 'invalid_first_name' },
            { id: 'last_name', error: 'invalid_last_name' },
            { id: 'date_of_birth', error: 'invalid_date_of_birth' },
            { id: 'country_of_birth', error: 'invalid_country_of_birth' },
            { id: 'state_of_birth', error: 'invalid_state_of_birth' },
            { id: 'city_of_birth', error: 'invalid_city_of_birth' },
            { id: 'gender', error: 'invalid_gender' },
            { id: 'country_of_citizenship', error: 'invalid_country_of_citizenship' },
            { id: 'identity_card_number', error: 'invalid_identity_card_number' },
        ];

        fields.forEach(field => {
            const el = $('#' + field.id);
            let currentTag = el.closest(".form-group");

            if (el.length && el.val().trim() === '') {
                el.focus();
                $('#' + field.error).show();
                invalid_counted += 1;
                validateStyle(el, currentTag);
            }
        });

        const checkImageEmpty = (id, fallback, errorId, labelId) => {
            if (
                ($("#" + id).attr("src") == "" || $("#" + id).attr("src") == fallback) &&
                $("#" + labelId).val() == ""
            ) {
                let currentTag = $('#' + labelId).closest(".form-group");
                $('#label-' + labelId)[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                $("#" + errorId).show();
                invalid_counted += 1;

                $('#label-' + labelId).addClass('text-danger'); 
                currentTag.addClass('has-error');
                currentTag.find('label').addClass('text-danger')
            }
        };

        checkImageEmpty("preview_identity_card_file", "<?= base_url('assets/images/idcard.png') ?>", "invalid_passport_required", "identity_card_file");


        let country_of_citizenship = $("#country_of_citizenship").val();
        let identity_card_number = $("#identity_card_number");

        if (identity_card_number.val().length < 16) {
            identity_card_number.focus();
            $('#invalid_identity_card_number_length').show();
            $('#invalid_identity_card_number').hide();
            invalid_counted += 1;
        }
        return invalid_counted === 0;
    });

    // validation upload file 5mb
    $('#identity_card_file').change(function(e){
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
        var field_id = $(this).attr('id');
        
        if(size_file > 5000000){ //if > 5mb
            // Handle different fields based on their ID
            if(field_id === 'img_photo') {
                $('#invalid_photo').css('display', 'block');
                $('#invalid_photo_required').css('display', 'none');
                $('#img_photo').val('');
            } else if(field_id === 'identity_card_file') {
                $('#invalid_identity_card_file_size').css('display', 'block');
                $('#invalid_identity_card_file').css('display', 'none');
                $('#identity_card_file').val('');
            } else if(field_id === 'aspe_file') {
                $('#invalid_aspe').css('display', 'block');
                $('#invalid_aspe_required').css('display', 'none');
                $('#aspe_file').val('');
            } else if(field_id === 'bio_photo') {
                $('#invalid_photo_bio').css('display', 'block');
                $('#invalid_photo_bio').css('display', 'none');
                $('#bio_photo').val('');
            } else if(field_id === 'cv') {
                $('#invalid_cv').css('display', 'block');
                $('#invalid_cv').css('display', 'none');
                $('#cv').val('');
            }
            return false;
        }else{
            // Hide all error messages when file size is valid
            $('#invalid_photo_required').css('display', 'none');
            $('#invalid_identity_card_file').css('display', 'none');
            $('#invalid_aspe_required').css('display', 'none');
            $('#invalid_photo_bio').css('display', 'none');
            $('#invalid_cv').css('display', 'none');
        }
    });

    function del_file(el, name, label, value='') {
        let section = label.toLowerCase().replace(/ /g, '_');
        if (label == 'Photo') {
            section = 'profile';
        }
        
        $("input[name='" + name +"']").val("");

        let element = $("#preview_image_" + section);

        if (confirm("Are you sure want to delete " + label + " ?")) {
            
            let default_preview_image = SITE_URL + 'assets/images/profile.png';
            let active_country = '<?php echo $user_grantee->country_id; ?>';

            if (name == 'identity_card_file') {
                if (active_country == '<?php echo AMERICAN_DATABASE; ?>') {
                    default_preview_image = SITE_URL + 'assets/images/passport.png';
                } else {
                    default_preview_image = SITE_URL + 'assets/images/idcard.png';
                }
            }
            if (name == 'identity_card_file_id') {
                default_preview_image = SITE_URL + 'assets/images/passport.png';
            }
            
            if (name == 'account_book') {
                default_preview_image = SITE_URL + 'assets/images/accountbook.png';
            }
            
            if (name == 'aspe' || name == 'aspe_file') {
                default_preview_image = SITE_URL + 'assets/images/icons/add-file.png';
            }

            element.attr('src', default_preview_image);
            $("#button_preview_" + name).attr('href', default_preview_image);
            $("#button_download_" + name).attr('href', default_preview_image).addClass('hide');
            $("#button_delete_" + name).addClass('hide');

            return false;
        }
    }

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

    function reset_state(id) {
        var state_id = '#' + 'state_' + id.split('_')[1] + '_' + id.split('_')[2] ;
        $(state_id).html('');
        $(state_id).append('<option value="">-- Select Province --</option>');
        $(state_id).prop('disabled', false);
    }

    function reset_city(id) {
        var city_id = '#' + 'city_' + id.split('_')[1] + '_' + id.split('_')[2] ;
        $(city_id).html('');
        $(city_id).append('<option value="">-- Select City --</option>');
        $(city_id).prop('disabled', false);
    }
    
    // show hide password
    $(document).on('click', ".fa-eye", function() {
        $(this).removeClass('fa-eye');
        $(this).addClass('fa-eye-slash');
        $(this).siblings('input').attr('type', 'text');
    });

    $(document).on('click', ".fa-eye-slash", function() {
        $(this).removeClass('fa-eye-slash');
        $(this).addClass('fa-eye');
        $(this).siblings('input').attr('type', 'password');
    });

    $(document).ready(function() {

        // menghapus auto fill secara manaul, karena autocomplete sudah tidak disupport 
        $("input,select,textarea").on('change', function(){
            let is_required = $(this).attr('required');
            let value = $(this).val();

            if (typeof is_required !== undefined && (value && value.length > 0)) {
                $(this).closest('div').find('.invalid-tooltip').css('display', 'none');
                $(this).closest('div').find('label').removeClass('text-danger');
                $(this).removeClass('has-error');
                
                if ($(this).hasClass('select2-hidden-accessible')) {
                    $(this).next('.select2-container').find('.select2-selection').removeClass('has-error');
                }
            }
        })
    });

    function show_preview(element, type, upload_type) {
        if (!element || !element.files || element.files.length === 0) return;
        const file = element.files[0];
        const filetype = (file.name.split('.').pop() || '').toLowerCase();
        const allowed_extensions = ['jpg', 'jpeg', 'png', 'pdf'];

        const is_valid_extension = allowed_extensions.includes(filetype);

        if (!is_valid_extension) {
            alert('Unsupported file type. Supported: JPG, PNG, PDF');
            try { $(element).val(''); } catch (e) {}
            return false;
        }

        // ensure upload_type has a sensible value when caller only passed (element, type)
        if (typeof upload_type === 'undefined' || upload_type === null || upload_type === '') {
            upload_type = $(element).attr('name') || $(element).attr('id') || 'file';
        }

        let formData = new FormData();
        formData.append(upload_type, file);
        formData.append('type', upload_type);

        $.ajax({
            url: SITE_URL + 'det/profile/save_file', 
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
                    // only try to update buttons if they exist in DOM
                    if ($("#button_preview_" + upload_type).length) $("#button_preview_" + upload_type).attr('href', file_url).removeClass('hide');
                    if ($("#button_download_" + upload_type).length) $("#button_download_" + upload_type).attr('href', file_url).removeClass('hide');
                    if ($("#button_delete_" + upload_type).length) $("#button_delete_" + upload_type).removeClass('hide');
                    if ($("input[name='" + upload_type +"']").length) $("input[name='" + upload_type +"']").val(response.filepath);
                    if ($("." + type).length) $("." + type).val(response.filepath);
                }
            },
            error: function(xhr, status, error) {
                console.error(error); 
            }
        });

        const labelId = 'label-' + upload_type;
        const $label = $('#' + labelId);
        $label.removeClass('text-danger');    
        $(element).closest('.form-group').removeClass('has-error');
    }

    var showPicker = false;
    $( ".datepicker-birthdate" ).datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd M yy",
        maxDate:"<?php echo date('d M Y', strtotime('-16 year')) ?>" ,
        defaultDate:"<?php echo date('d M Y', strtotime('-16 year')) ?>" ,
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
    
    $('#identity_card_number').keypress(function(event) {
        if(event.which < 48 || event.which > 57) {
            event.preventDefault();
        }
    });


    $(".btn-deleted").click(function(e) {
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
                url: "<?= base_url('admin/users_det/delete_ajax/'); ?>" + id,
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
                                "<?= base_url('admin/users_det/manage'); ?>";
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
</script>