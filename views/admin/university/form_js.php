<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap'
});
    });
    

    $("#country").change(function() {
        var state_el = 'state';
        var load_id = '#load-' + state_el;
        $(load_id).show();
        reset_state();
        reset_city();
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

    $("#state").change(function() {
        var city_el = 'city';
        var load_id = '#load-' + city_el;
        $(load_id).show();
        reset_city();
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

    

    function reset_state() {
        var state_id = '#state';
        $(state_id).html('');
        $(state_id).append('<option value="">-- Select Province --</option>');
    }

    function reset_city() {
        var city_id = '#city';
        $(city_id).html('');
        $(city_id).append('<option value="">-- Select City --</option>');
    }
</script>