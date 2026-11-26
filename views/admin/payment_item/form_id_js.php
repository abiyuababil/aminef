<script>
    $('#category_type').on('change',function(){
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/payment_item/get_sub_category') ?>',
            data:{
                'category_type' : this.value
            },
            dataType: 'JSON',
            success: function(r) {
                $('#sub_category_id').empty();
                $('#sub_category_id').append('<option value="">-- Select Sub Category --</option>');
                $.each(r, function(id, val) {
                    $('#sub_category_id').append('<option value="' + val.id + '">' + val.name + '</option>');
                });
            }
        });
    });
</script>