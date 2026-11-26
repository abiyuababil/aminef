<script>
$(document).ready(function() {
    $('.password-show').click(function() {
        var input = $(this).siblings('input');
        if (input.attr('type') == 'password') {
            input.attr('type', 'text');
            $(this).removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            $(this).removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    $('#state').change(function() {
        var state = $(this).val();
        var citySelect = $('#city');
        
        citySelect.html('<option value="">Select City</option>');
        
        if (state) {
            $.ajax({
                url: '<?= base_url() ?>world/city/' + state,
                type: 'GET',
                data: { state: state },
                dataType: 'json',
                success: function(cities) {
                    for(i = 0; i < cities.length; i++) {
                        var city = cities[i];
                        citySelect.append('<option value="' + city.id + '">' + city.name + '</option>');
                    }
                }
            });
        }
    });

    function personal_active() {
        $('#li_personal').addClass('active');
        $('#personal').addClass('active in');
        $('#li_contact').removeClass('active');
        $('#contact').removeClass('active in');
    }

    function contact_active() {
        $('#li_contact').addClass('active');
        $('#contact').addClass('active in');
        $('#li_personal').removeClass('active');
        $('#personal').removeClass('active in');
    }
});
</script>