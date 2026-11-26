<?php $require_bank_info = get_grantee_setting()->require_bank_info || is_admin(); ?>
<script src="<?php echo base_url() ?>js/wijmo.min.js"></script>

<script>
    const SITE_URL = '<?php echo site_url(); ?>';
    let country_active = <?= $this->session->userdata('grantee_active_country') ?>;
    let pidOngoing = '<?= $this->session->userdata('last_tab_visa') ?>';

    // validation shoe contact US
    $(document).ready(function () {
        // $(document).on('change', '#prefix_name', function () {
        //     if ($(this).val() === 'other') {
        //         $('#prefix_other').show().focus();
        //     } else {
        //         $('#prefix_other').hide().val('');
        //     }
        // });
        // $('#prefix_name').trigger('change');

        if(country_active == <?= AMERICAN_DATABASE ?>){
            if (isMandatoryComplete()) {
                $('#li_contact').removeClass('hide');
            } else {
                $('#li_contact').addClass('hide'); // jika perlu jaga tetap tersembunyi
            }
        }

        let invalid_counted_pid = 0;
        $('.select2').select2({
            theme: 'bootstrap'
        });
        if(pidOngoing != ''){

            const fields_pid = [
                { id: 'us_country', error: 'invalid_us_country' },
                { id: 'us_state', error: 'invalid_us_state' },
                { id: 'us_city', error: 'invalid_us_city' },
                { id: 'us_street', error: 'invalid_us_street' },
                { id: 'us_zipcode', error: 'invalid_us_zipcode' },
                { id: 'us_phone_number', error: 'invalid_us_phone_number' },
                { id: 'university_email', error: 'invalid_university_email' },
            ];

            fields_pid.forEach(field => {
                const el = $('#' + field.id);
                let currentTag = el.closest(".form-group");
                validateStyle(el, currentTag);
                if(field.id == 'us_country'){
                    el.focus()
                }
            });
            $('#us-address-section').addClass('has-error');
        }
    });

    function isMandatoryComplete() {
        let invalid_counted = 0;

        const fields = [
            'first_name',
            'last_name',
            'dietary_restrictions',
            'birth_date',
            'birth_country',
            'birth_state',
            'birth_city',
            'gender',
            'institute_name',
            'level_study',
            'institution_country',
            'institution_state',
            'institution_city',
            'degree_name',
            'degree_actual',
            'discipline',
            'endrolled_from',
            'citizen_country',
            <?php if ($require_bank_info) { ?>
            'bank_name',
            'bank_address',
            'beneficiary_name',
            'account_number',
            'routing_number',
            'swift_code',
            'currency'
            <?php } ?>
        ];

        fields.forEach(function (id) {
            const el = $('#' + id);
            if (el.length && el.val().trim() === '') {
                invalid_counted++;
            }
        });

        // Cek bio
        const bio = $('#bio');
        if (bio.length && bio.val().trim() === '') {
            invalid_counted++;
        }

        // Cek image preview
        const country_active = <?= $this->session->userdata('grantee_active_country') ?>;
        const fallbackImages = {
            'preview_image_bio_photo': '<?= base_url('assets/images/profile.png') ?>',
            'preview_image_cv': '<?= base_url('assets/images/icons/document-filetype.png') ?>',
            'preview_image_profile': '<?= base_url('assets/images/profile.png') ?>',
            'preview_image_passport': (country_active == <?= INDONESIAN_DATABASE ?>)
                ? '<?= base_url('assets/images/idcard.png') ?>'
                : '<?= base_url('assets/images/passport.png') ?>',
            'preview_image_aspe': '<?= base_url('assets/images/icons/document-filetype.png') ?>'
        };

        const labelMap = {
            'preview_image_bio_photo': 'bio_photo',
            'preview_image_cv': 'cv',
            'preview_image_profile': 'img_photo',
            'preview_image_passport': 'img_passport',
            'preview_image_aspe': 'aspe'
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

        let country_active = <?= $this->session->userdata('grantee_active_country') ?>;
        if(country_active == <?= AMERICAN_DATABASE ?> || pidOngoing != ''){
            element.addClass('has-error');
            currentTag.find('label').addClass('text-danger')

            // Deteksi jika select2, tambahkan border error ke tampilannya
            if (element.hasClass('select2-hidden-accessible')) {
                element.next('.select2-container').find('.select2-selection').addClass('has-error');
            }
        }

    }



    $("#btn-submit").click(function () {
        let country_active = <?= $this->session->userdata('grantee_active_country') ?>;
        let invalid_counted = 0;
        const fields = [
            { id: 'first_name', error: 'invalid_first_name' },
            { id: 'last_name', error: 'invalid_last_name' },
            { id: 'dietary_restrictions', error: 'invalid_dietary_restrictions' },
            { id: 'birth_date', error: 'invalid_birth_date' },
            { id: 'birth_country', error: 'invalid_birth_country' },
            { id: 'birth_state', error: 'invalid_birth_state' },
            { id: 'birth_city', error: 'invalid_birth_city' },
            { id: 'gender', error: 'invalid_gender' },
            { id: 'institute_name', error: 'invalid_institute_name' },
            { id: 'level_study', error: 'invalid_level_study' },
            { id: 'institution_country', error: 'invalid_institution_country' },
            { id: 'institution_state', error: 'invalid_institution_state' },
            { id: 'institution_city', error: 'invalid_institution_city' },
            { id: 'degree_name', error: 'invalid_degree_name' },
            { id: 'degree_actual', error: 'invalid_degree_actual' },
            { id: 'discipline', error: 'invalid_discipline' },
            { id: 'endrolled_from', error: 'invalid_endrolled_from' },
            { id: 'citizen_country', error: 'invalid_citizen_country' },
            <?php if ($require_bank_info) { ?>
            { id: 'bank_name', error: 'invalid_bank_name' },
            { id: 'bank_address', error: 'invalid_bank_address' },
            { id: 'beneficiary_name', error: 'invalid_beneficiary_name' },
            { id: 'account_number', error: 'invalid_account_number' },
            { id: 'routing_number', error: 'invalid_routing_number' },
            { id: 'swift_code', error: 'invalid_swift_code' },
            { id: 'currency', error: 'invalid_currency' }
            <?php } ?>
        ];

        fields.forEach(field => {
            const el = $('#' + field.id);
            let currentTag = el.closest(".form-group");

            if (el.length && el.val().trim() === '') {
                personal_active();
                el.focus();
                $('#' + field.error).show();
                invalid_counted += 1;
                validateStyle(el, currentTag);
            }
        });

        const hasDependents = $('input[name="has_dependents"]:checked').val();
        if (hasDependents === '1') {
            const dependentFields = [
                { id: 'number_of_dependents', error: 'invalid_number_of_dependents' },
                { id: 'number_of_school_age_dependents', error: 'invalid_number_of_school_age_dependents' }
            ];

            dependentFields.forEach(field => {
                const el = $('#' + field.id);
                let currentTag = el.closest(".form-group");

                if (el.length && (el.val().trim() === '' || el.val() === '0')) {
                    personal_active();
                    el.focus();
                    $('#' + field.error).show();
                    invalid_counted += 1;
                    validateStyle(el, currentTag);
                }
            });
        }

        const checkImageEmpty = (id, fallback, errorId, labelId) => {
            if (
                ($("#" + id).attr("src") == "" || $("#" + id).attr("src") == fallback) &&
                $("#" + labelId).val() == ""
            ) {
                let currentTag = $('#' + labelId).closest(".form-group");
                personal_active();
                $('#label-' + labelId)[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                $("#" + errorId).show();
                
                if (country_active == <?= AMERICAN_DATABASE ?>) {
                    $('#label-' + labelId).addClass('text-danger'); 
                    currentTag.addClass('has-error');
                    currentTag.find('label').addClass('text-danger')
                }
                invalid_counted += 1;
            }
        };

        checkImageEmpty("preview_image_bio_photo", "<?= base_url('assets/images/profile.png') ?>", "invalid_photo_bio", "bio_photo");
        checkImageEmpty("preview_image_cv", "<?= base_url('assets/images/icons/document-filetype.png') ?>", "invalid_cv", "cv");
        checkImageEmpty("preview_image_profile", "<?= base_url('assets/images/profile.png') ?>", "invalid_photo_required", "img_photo");
        checkImageEmpty("preview_image_aspe", "<?= base_url('assets/images/icons/document-filetype.png') ?>", "invalid_aspe_required", "aspe");
        if (country_active == <?= INDONESIAN_DATABASE ?>) {
            checkImageEmpty("preview_image_passport", "<?= base_url('assets/images/idcard.png') ?>", "invalid_passport_required", "img_passport");
        }else{
            checkImageEmpty("preview_image_passport", "<?= base_url('assets/images/passport.png') ?>", "invalid_passport_required", "img_passport");
        }

        // Cek bio jika ada
        let bio = $('#bio');
        let currentTag = bio.closest(".form-group");
        if (bio.length && bio.val().trim() === '') {
            $('#label-bio').focus();
            $('#invalid_bio_required').show();
            bio.addClass('has-error');
            currentTag.find('label').addClass('text-danger')
            invalid_counted += 1;
        }

        let citizen_country = $("#citizen_country").val();
        let number_identity = $("#number_identity");

        if (country_active == <?= INDONESIAN_DATABASE ?> && number_identity.val().length < 16) {
            personal_active();
            number_identity.focus();
            $('#invalid_number_identity_length').show();
            $('#invalid_number_identity').hide();
            invalid_counted += 1;
        }

        if (citizen_country == '101' || number_identity.length > 0) {
            if (number_identity.length && number_identity.val().trim() === '') {
                personal_active();
                number_identity.focus();
                $('#invalid_number_identity').show();
                $('#invalid_number_identity_length').hide();
                invalid_counted += 1;
            }
        } else {
            ['number_passport', 'passport_expiry_date', 'passport_date_issue'].forEach(id => {
                if ($('#' + id).val().trim() === '') {
                    let currentTag = $('#' + id).closest(".form-group");
                    personal_active();
                    $('#' + id).focus();
                    $('#invalid_' + id).show();
                    $('#' + id).addClass('has-error');
                    currentTag.find('label').addClass('text-danger')
                    invalid_counted += 1;
                }
            });
        }

        if (country_active == <?= AMERICAN_DATABASE ?>) {
            ['number_passport', 'passport_expiry_date', 'passport_date_issue'].forEach(id => {
                if ($('#' + id).val().trim() === '') {
                    let currentTag = $('#' + id).closest(".form-group");
                    personal_active();
                    $('#' + id).focus();
                    $('#invalid_' + id).show();
                    $('#' + id).addClass('has-error');
                    currentTag.find('label').addClass('text-danger')
                    invalid_counted += 1;
                }
            });
        }

        // Validasi akademik dinamis
        if (typeof academic_form !== "undefined" && academic_form.length > 0) {
            for (let i = 0; i < academic_form.length; i++) {
                const akademikFields = [
                    'institute_name', 'level_study', 'institution_country',
                    'institution_state', 'institution_city', 'degree_name',
                    'degree_actual', 'discipline', 'endrolled_from'
                ];
                for (const field of akademikFields) {
                    if ($('#' + field + i).length && $('#' + field + i).val().trim() === '') {
                        personal_active();
                        $('#' + field + i).focus();
                        $('#invalid_' + field + i).show();
                        return false;
                    }
                }
            }
        }

        if(invalid_counted === 0 ){
            $('#li_contact').show();
        }
        return invalid_counted === 0;
    });

    $("#btn-submit-contact").click(function (event) {
        let country_active = <?= $this->session->userdata('grantee_active_country') ?>;
        const password = $('#password').val();
        const confirm_password = $('#confirm_password').val();
        let invalid_counted_contact = 0;

        if (password !== confirm_password) {
            alert("Password and Confirm Password doesn't match");
            $('#password').focus();
            event.preventDefault();
            return false;
        }

        // Helper function to validate a field
        const validateField = (selector, invalidSelector, focus = true) => {
            if ($(selector).val() === '') {
                personal_active_contact();
                if (focus) $(selector).focus();
                $(invalidSelector).show();
                invalid_counted_contact++;
                let currentTag = $(selector).closest(".form-group");
                validateStyle($(selector), currentTag);
            }
        };

        // Validasi personal contact fields
        let personalFields = [
            ['#primary_email', '#invalid_primary_email'],
            ['#zipcode', '#invalid_zipcode'],
            ['#street', '#invalid_street'],
            ['#address_city', '#invalid_address_city'],
            ['#address_state', '#invalid_address_state'],
            ['#address_country', '#invalid_address_country']
        ];

        if (country_active == 2) {
            personalFields = [
                ['#phone_number_0', '#invalid_phone_number_0'],
                ['#home_phone_number', '#invalid_home_phone_number'],
                ['#nearest_international_airport', '#invalid_nearest_international_airport'],
                ...personalFields
            ];
        }


        personalFields.forEach(([selector, invalidSelector]) => {
            validateField(selector, invalidSelector);
        });

        // Validasi residence jika tidak tinggal di current address
        if (!$('#current-residence').is(':checked')) {
            const residenceFields = [
                ['#residence_country', '#invalid_residence_country'],
                ['#residence_street', '#invalid_residence_street'],
                ['#residence_state', '#invalid_residence_state'],
                ['#residence_zipcode', '#invalid_residence_zipcode'],
                ['#residence_city', '#invalid_residence_city']
            ];

            residenceFields.forEach(([selector, invalidSelector]) => {
                validateField(selector, invalidSelector);
            });
        }

        // Validasi emergency contact
        if(country_active == 2){
            const emergencyContactLength = <?= $emergency ? count($emergency) : 0 ?>;
            for (let i = 0; i < emergencyContactLength; i++) {
                const fields = [
                    [`#firs_name_temp${i}`, `#invalid_firs_name_temp${i}`],
                    [`#last_name_temp${i}`, `#invalid_last_name_temp${i}`],
                    [`#${i}temp_country`, `#invalid_temp_country${i}`],
                    [`#street_temp${i}`, `#invalid_street_temp${i}`],
                    [`#${i}temp_state`, `#invalid_temp_state${i}`],
                    [`#${i}temp_city`, `#invalid_temp_city${i}`],
                    [`#zipcode_tmep${i}`, `#invalid_zipcode_tmep${i}`],
                    [`#phone_temp${i}`, `#invalid_phone_temp${i}`],
                    [`#email_temp${i}`, `#invalid_email_temp${i}`],
                    [`#relation${i}`, `#invalid_relation${i}`]
                ];

                fields.forEach(([selector, invalidSelector]) => {
                    validateField(selector, invalidSelector);
                });
            }
        }

        if (invalid_counted_contact > 0) {
            event.preventDefault();
            return false;
        }
    });

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
    $('#img_photo,#img_passport,#aspe_file,#bio_photo,#cv').change(function(e){
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
            } else if(field_id === 'img_passport') {
                $('#invalid_img_passport_size').css('display', 'block');
                $('#invalid_img_passport').css('display', 'none');
                $('#img_passport').val('');
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
            $('#invalid_img_passport').css('display', 'none');
            $('#invalid_aspe_required').css('display', 'none');
            $('#invalid_photo_bio').css('display', 'none');
            $('#invalid_cv').css('display', 'none');
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
    })
    // $('#img_passport').change(function(e){
    //     var size_file = e.target.files[0].size;
    //     if(size_file > 5000000){ //if > 5mb
    //         $('#invalid_img_passport_size').css('display', 'block');
    //         $('#invalid_img_passport').css('display', 'none');
    //         $('#img_passport').val('');
    //         return false;
    //     }else{
    //         $('#invalid_img_passport').css('display', 'none');
    //     }
    // })
    $('#degree_name').change(function(e){
        if(this.value == 'Other'){
            $("#other_degree_col").css('display', 'block')
        }else{
            $("#other_degree_col").css('display', 'none')
        }
    })

    // function show_pcode(el_country, el_pcode) {
    //     var country_code = $('#' + el_country + ' option:selected').attr('data-pcode');
    //     if (country_code != undefined)
    //         $('#' + el_pcode).val('+' + country_code);
    // }

    // $(function() {
    //     show_pcode('of_country', 'of_phone_code');
    //     show_pcode('country', 'street');
    // });

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

    function add_mobile_number() {
        var idx = $('.opdt-item').length;
        var html = '';
        html = '<div id="opdt-item-' + idx + '" class="row opdt-item" style="position:relative">';
        html += '	<div class="col-lg-12">';
        html += '		<div class="form-group">';
        html += '			<label>Cell Phone Number</label>';
        html += '			<input type="number" class="form-control" name="phone_number[]" value="">';
        html += '		</div>';
        html += '	</div>';
        html += '	<a href="javascript:;" onclick="del_item(this, \'opdt-item\')" class="btn btn-danger" style="position:absolute; top:25px; right:15px;"><i class="fa fa-trash fa-fw"></i></a>';
        html += '</div>';
        $('#wrap-phone').append(html);
    }

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

            if (name == 'img_passport') {
                if (active_country == '<?php echo AMERICAN_DATABASE; ?>') {
                    default_preview_image = SITE_URL + 'assets/images/passport.png';
                } else {
                    default_preview_image = SITE_URL + 'assets/images/idcard.png';
                }
            }
            if (name == 'img_passport_id') {
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

    $(".select-country-emergency").change(function() {
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

    $(".select-state-emergency").change(function() {
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
        setTimeout(function(){
            var decoy = $("#swift_code_checking_filler").val();
            $("#password").val("")
            if ($("#swift_code").attr("autocomplete") != "" && decoy == ''){
                $("#swift_code").val("")
            }
        },500)
        // save();

    //     $('.tab-grants').each(function(i, obj) {
    //         var pid = $(this).data("pid");
    //         var upid = $(this).data("upid");
    //         var uid = $('#uid').val();
    //         var act_id = 0;
	// 		if (pid == 10)
	// 			act_id = $('#chg_activity_' + pid).val();
    //         var attr_content = $("#content_" + upid);

    //         $.ajax({
    //             url: '<?= site_url('admin/alumni/ajx_get_properties') ?>' + '/' + pid + '/' + uid + '/' + act_id + '/' + upid,
    //             success: function(data) {
    //                 attr_content.html(data);
    //             }
    //         });


    //         if (pid == 10) {
    //             if ($('#chg_activity_' + pid).length) {
    //                 $('#chg_activity_' + pid).on('change', function() {
    //                     var act_id = $(this).val();
    //                     var load_id = '#load-' + pid;
    //                     $(load_id).show();

    //                     if (act_id == undefined) {
    //                         act_id = 0;
    //                     }

    //                     $.ajax({
    //                         url: '<?= site_url('admin/alumni/ajx_get_properties') ?>' + '/' + pid + '/' + uid + '/' + act_id + '/' + upid,
    //                         success: function(data) {
    //                             attr_content.html(data);
    //                             $(load_id).hide();
    //                         }
    //                     });
    //                 })
    //             }
    //         }
    //     });
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
            url: SITE_URL + 'grantee/profile/save_file', 
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
        let params = address_state != '' && $(this).val() == '' ? address_state : $(this).val();
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
    
    $('#number_identity').keypress(function(event) {
        if(event.which < 48 || event.which > 57) {
            event.preventDefault();
        }
    });

    function add_other_bank()
    {
        let input_numbers = function() {
            let random_number = '';
            for (let i = 0; i < 4; i++) {
                random_number += Math.floor(Math.random() * 10); // Menghasilkan digit acak dari 0 hingga 9
            }
            return parseInt(random_number, 10);
        };
        let index = input_numbers();
        let html = `
        <div class="other-bank">
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Beneficiary Name (As listed on the bank account)</label>
                    <input type="text" class="form-control" name="other_bank_info[`+ index +`][beneficiary_name]" value="" placeholder="Full Name">
                    <div id="invalid_beneficiary_name" class="text-danger invalid-tooltip">
                        Full Name is not null.
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Bank Name</label>
                    <input type="text" class="form-control" name="other_bank_info[`+ index +`][bank_name]" value="" placeholder="Bank Name">
                    <div id="invalid_bank_name" class="text-danger invalid-tooltip">
                        Bank Name is not null.
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Beneficiary Address: [Building/Street, City, State/Province + Postal Code, Country]</label>
                    <input type="text" class="form-control" name="other_bank_info[`+ index +`][beneficiary_address]" value="" placeholder="Beneficiary Address">
                    <div id="invalid_bank_address" class="text-danger invalid-tooltip">
                        Beneficiary Address is not null.
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Bank Address: [Building/Street, City, State/Province + Postal Code, Country]</label>
                    <input type="text" class="form-control" name="other_bank_info[`+ index +`][bank_address]" value="" placeholder="Bank Address">
                    <div id="invalid_bank_address" class="text-danger invalid-tooltip">
                        Bank Address is not null.
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Account Number</label>
                    <input type="text" class="form-control" name="other_bank_info[`+ index +`][account_number]" value="" placeholder="Account Number">
                    <div id="invalid_account_number" class="text-danger invalid-tooltip">
                        Account Number is not null.
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Routing or ABA Number (for U.S. Banks)</label>
                    <input type="text" class="form-control" name="other_bank_info[`+ index +`][routing_number]" value="" placeholder="Routing or ABA Number (for U.S. Banks)">
                    <div id="invalid_routing_number" class="text-danger invalid-tooltip">
                        Routing or ABA Number (for U.S. Banks) is not null.
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>SWIFT Code</label>
                    <input type="text" class="form-control" name="other_bank_info[`+ index +`][swift_code]" value="" placeholder="SWIFT Code">
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
                    <label>Currency</label>
                    <select class="form-control" name="other_bank_info[`+ index +`][currency]" id="currency">
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
                    <label><?php echo $this->session->userdata('active_country') == AMERICAN_DATABASE ? 'Void Check' : 'First page of bank account information (buku tabungan halaman pertama)'; ?> <?php echo $active_country == AMERICAN_DATABASE ? '(optional)' : ''; ?></label>
                    <?php 
                        $account_book = user_grantee_file_url($user_grantee, 'account_book');
                    ?>
                    <div style="margin-bottom:10px; position:relative; width:100px;">
                        <a href="<?php echo site_url($account_book); ?>" class="lightbox" aria-haspopup="dialog">
                            <img id="preview_image_account_book-`+ index +`" data-old="<?php echo site_url($account_book); ?>" src="<?php echo get_preview($account_book); ?>" width="100" style="min-height:60px;object-fit:contain;">
                        </a>
                        <a href="javascript:;" onclick="del_other_bank_attachment(this, 'account_book-`+ index +`', 'Account Book')" id="button_delete_account_book-`+ index +`" class="btn btn-danger btn-xs hide" style="position:absolute; top:0; right:-28px;">
                            <i class="fa fa-trash fa-fw"></i>
                        </a>
                        <a href="<?php echo base_url($account_book) ?>" id="button_download_account_book-`+ index +`" download title="Click to download" class="btn btn-primary btn-xs mt-5 hide" style="position:absolute; top:0; right:-28px;">
                            <i class="fa fa-download fa-fw"></i>
                        </a>
                    </div>
                    <input type="file" class="custom-file-input hide" id="account_book-`+ index +`" onchange="show_preview(this, 'account_book-`+ index +`', 'account_book-`+ index +`');">
                    <input type="hidden" name="other_bank_info[`+ index +`][account_book]" class="account_book-`+ index +`" value="">
                    <label class="btn btn-primary upload-button" for="account_book-`+ index +`"> Choose file </label> 
                    <a href="<?php echo site_url($account_book) ?>" id="button_preview_account_book-`+ index +`" class="btn btn-warning fileview lightbox preview-profile" style="color:#fff;display:inline-block"><i class="fa fa-eye fa-fw"></i> Preview</a>
                    <div>
                        <small class="file-for-testing">
                            File Size Max 5MB 
                            <?php if (count(ALLOWED_PROFILE_FILETYPE) > 0) { ?>
                            | Supported File : <?php echo strtoupper(human_readable_list(ALLOWED_PROFILE_FILETYPE, ',')) ; ?> 
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

    function del_other_bank_attachment(el, name, label)
    {
        console.log(name, el);

        $("input[name='" + name +"']").val("");
        
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

    $(document).on('click', ".btn-remove-other-bank", function(){
        let el = $(this);
        let id = el.data('id');
        $('<input>').attr({
            type: 'hidden',
            name: 'deleted_other_bank[]',
            value: id
        }).appendTo('form');
        $(this).closest('.other-bank').remove();
    });


    $('input.check_default').on('change', function() {
        if ($("input.check_default:checked").length){
            $('input.check_default').not(this).prop('checked', false);  
        }else{
            alert ('Please select one Bank Info as default');
            $(this).prop('checked', true);
        }
    });

    $(".us-address-country").change(function() {
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

    $(".us-address-state").change(function() {
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
</script>

<script>
    $(document).ready(function() {
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

<?php $this->session->unset_userdata('last_tab_visa'); ?>