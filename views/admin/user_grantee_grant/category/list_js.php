<script>
    $(document).ready(function(){
        $('#copy_grant_id').on('change', function(){
            const country_id = Number('<?= $this->session->userdata('active_country') ?>');
            let grant_id = $(this).val();
            var urlAjax = '<?php echo site_url('world/all_period/'); ?>/' + grant_id;

            if (country_id == 2) {
                var urlAjax = '<?php echo site_url('world/all_period_for_copy/'); ?>/' + grant_id;
            }
            
            $.ajax({
                url : urlAjax,
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
            })
        });
    });
</script>