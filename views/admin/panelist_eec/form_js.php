
<script>
    $(document).ready(function(){
        $("#field_of_study_id").trigger('change')

    })

    // $(function () {
    //     $('#mobile').intlTelInput({
    //         autoHideDialCode: true,
    //         autoPlaceholder: "ON",
    //         dropdownContainer: document.body,
    //         formatOnDisplay: true,
    //         initialCountry: "<?= $country_code ?>",
    //         placeholderNumberType: "MOBILE",
    //         preferredCountries: ['id','gb','us'],
    //         separateDialCode: true
    //     });
    // });

    // $('#mobile').blur(function() {
    //     var code = $("#mobile").intlTelInput("getSelectedCountryData").dialCode;
    //     $('#mobile_code').val(code);
    // });
    
    $('.btn-success').click(function() {
        var password = $('#password').val().trim()
        var confirmPassword = $('#confirm_password').val().trim()

        if((password !== confirmPassword) ){
            Swal.fire({
                text: "Password and Confirm Password doesn't match!",
                icon: "error"
            });
            $('#confirm_password').focus();
            return false
        }
    });

    $('#mobile').keypress(function(event) {
        if(event.which < 48 || event.which > 57) {
            event.preventDefault();
        }
    });

    
    $('.select2').select2({
        theme: 'bootstrap'
    });

    $(".select-country-origin").change(function() {
        var state_el = 'select-state-origin';
        $('.load-city-origin').show();
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
                $('.load-city-origin').hide();
            }
        });
    });

    $(".select-state-origin").change(function() {
        var city_el = 'select-city-origin';
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

    function reset_state(id) {
        var state_id = '#' + id.split('_')[0] + '_state';
        $(state_id).html('');
        $(state_id).append('<option value="">-- Select State --</option>');
    }

    function reset_city(id) {
        var city_id = '#' + id.split('_')[0] + '_city';
        $(city_id).html('');
        $(city_id).append('<option value="">-- Select City --</option>');
    }

    $("#field_of_study_id").change(function() {
        var sof = $('#field_of_study_id').find(":selected").text().toLowerCase();
        
        if(sof == 'other'){
            $('.other-sof').removeClass('hide')
            $('#other_sof').prop('required', true)
        }else{
            $('.other-sof').addClass('hide')
            $('#other_sof').prop('required', false)
        }
    });
    </script>