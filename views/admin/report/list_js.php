<script>
    $(document).ready(function () {
        $('#mdl_edit').on('show.bs.modal', function (event) {
            var grant_id = $(event.relatedTarget).attr('data-id');
            $("#user_grantee_grant_id").val(grant_id);
        });

        $('.select2').select2({
            theme: 'bootstrap'
        });
        
        $('#copy_grant_id').on('change', function(){
            const country_id = Number('<?= $this->session->userdata('active_country') ?>');
            let grant_id = $(this).val();
            
            $.ajax({
                url : '<?php echo site_url('world/all_period_for_copy/'); ?>' + grant_id,
                type : 'GET',
                dataType : 'JSON',
                success : function(response)
                {
                    console.log(response);
                    
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
    })
</script>