<script>
$(document).ready(function() {

    $('#state').change(function() {
        var state = $(this).val();
        var citySelect = $('#city');
        
        citySelect.html('<option value="">Pilih Kota</option>');
        
        if (state) {
            $.ajax({
                url: '<?= base_url() ?>eta/register/get_cities',
                type: 'POST',
                data: { state: state },
                dataType: 'json',
                success: function(cities) {
                    $.each(cities, function(key, value) {
                        citySelect.append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        }
    });

    $('#password').on('input', function() {
        var password = $(this).val();

        var hasUpper  = /[A-Z]/.test(password);
        var hasNumber = /\d/.test(password);
        var hasLength = password.length >= 8;

        function updateValidation(selector, isValid) {
            $(selector)
                .toggleClass('text-green-500', isValid)
                .toggleClass('text-red-500', !isValid);

            $(selector + ' i')
                .toggleClass('fa-check', isValid)
                .toggleClass('fa-times', !isValid);
        }

        updateValidation('#d12', hasUpper);
        updateValidation('#d15', hasNumber);
        updateValidation('#d16', hasLength);

        $('#d1').toggle(!(hasUpper && hasNumber && hasLength));
    });

    $('#agree').change(function() {
        var password = $('#password').val();
        var hasUpper = /[A-Z]/.test(password);
        var hasNumber = /\d/.test(password);
        var hasLength = password.length >= 8;
        
        if ($(this).is(':checked') && hasUpper && hasNumber && hasLength) {
            $('.btn-subpas').prop('disabled', false);
        } else {
            $('.btn-subpas').prop('disabled', true);
        }
    });

    $('#password').on('input', function() {
        var password = $(this).val();
        var hasUpper = /[A-Z]/.test(password);
        var hasNumber = /\d/.test(password);
        var hasLength = password.length >= 8;
        
        if ($('#agree').is(':checked') && hasUpper && hasNumber && hasLength) {
            $('.btn-subpas').prop('disabled', false);
        } else {
            $('.btn-subpas').prop('disabled', true);
        }
    });
});
</script>