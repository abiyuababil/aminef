<script>
    var active_country = <?= $this->session->userdata('active_country') ?>;
    $('#copy_grant_id').change(function(){
        var el_category = $('#copy_category_id');
        reset_state(this.id);
        // reset_city(this.id);
        
        var urlAjax = '<?php echo site_url('world/category') ?>/' + this.value;
        if(active_country == 2){
            urlAjax = '<?php echo site_url('world/all_period_for_copy') ?>/' + this.value;
        }
        $.ajax({
            type: 'GET',
            url: urlAjax,
            dataType: 'JSON',
            success: function(r) {
                $.each(r, function(id, val) {
                    el_category.append('<option value="' + val.id + '">' + val.name + '</option>');
                });
            }
        });

        let grant_id = $('#copy_grant_id').val();
        var urlAjaxOpt = '<?php echo site_url('world/all_period/'); ?>/' + grant_id;
        if(active_country == 2){
            urlAjaxOpt = '<?php echo site_url('world/all_period_for_copy/'); ?>/' + grant_id
        }
        $.ajax({
            url : urlAjaxOpt,
            type : 'GET',
            dataType : 'JSON',
            success : function(response)
            {
                if (response.length > 0) {
                    $('.select-period-section').removeClass('hide');
                } else {
                    $('.select-period-section').addClass('hide');
                }

                $('#period_id').empty();
                    $('#period_id').append(
                        $('<option>', {
                            value: '',
                            text: '-- Select Period --'
                        })
                    );
                    
                    $.each(response, function(index, item){
                        $('#period_id').append(
                            $('<option>', {
                                value: item.id,
                                text: item.fiscal_year
                            })
                        );
                    });
                },
            error : function (response)
            {

            }
        });
    });

    $('#period_id').on('change', function(){
        var el_category = $('#copy_category_id');
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('world/category') ?>/' + $('#copy_grant_id').val() + '/1/' + $(this).val(),
            dataType: 'JSON',
            success: function(r) {
                el_category.empty();
                el_category.append('<option value="">-- Select Category --</option>');
                $.each(r, function(id, val) {
                    el_category.append('<option value="' + val.id + '">' + val.name + '</option>');
                });
            }
        });
    });
    
    function reset_state(id) {
        var state_id = '#copy_category_id';
        $(state_id).html('');
        $(state_id).append('<option value="">-- Select Category --</option>');
    }

    function reset_city(id) {
        var city_id = '#' + id.split('_')[0] + '_city';
        $(city_id).html('');
        $(city_id).append('<option value="">-- Select City --</option>');
    }
</script>