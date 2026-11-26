<script>
$('input[type=radio][name=is_new_grantee]').change(function() {
    var value = this.value;
    $.ajax({
        type: 'GET',
        url: '<?php echo site_url('admin/user_grantee_grant/get_grant_category') ?>/'+ value,
        dataType: 'JSON',
        success: function(r) {
            $('#name').html('');
            if(value != 2){
                $('#name').append('<option value="">-- Select Grant Page --</option>');
            }
            $.each(r, function(id, val) {
                $('#name').append('<option value="' + val + '">' + val + '</option>');
            });
        }
    });
});

function validate_form(e)
{
    var name = $("#name").val();
    if(name == ''){
        alert('Please select Grant Page!');
        event.preventDefault();
    }else{
        $('form').submit();
    }
}
</script>