<script>
$(document).ready(function() {

    $('#state').change(function() {
        var state = $(this).val();
        var citySelect = $('#city');
        
        citySelect.html('<option value="">Select City</option>');
        
        if (state) {
            $.ajax({
                url: '<?= base_url() ?>host/register/get_cities',
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
        var hasUpper = /[A-Z]/.test(password);
        var hasNumber = /\d/.test(password);
        var hasLength = password.length >= 8;
        
        $('#d12 i').toggleClass('fa-times fa-check', hasUpper);
        $('#d15 i').toggleClass('fa-times fa-check', hasNumber);
        $('#d16 i').toggleClass('fa-times fa-check', hasLength);
        
        $('#d1').show();
        
        if (hasUpper && hasNumber && hasLength) {
            $('#d1').hide();
        }
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