<script>
    $("#btn-history_file").click(function(){
        var fd = new FormData();
        var files = $('#history_file_input_file')[0].files;
        var grantee_grant_id = $('#grantee_grant_id').val();
        var description = $('#description').val();
        $('#btn-history_file').prop('disabled', true)


        // Check file selected or not
        if(files.length > 0 ){
            fd.append('history_file_input_file',files[0]);
            fd.append('grantee_grant_id',grantee_grant_id);
            fd.append('description',description);
            $.ajax({
                url: '<?php echo site_url('admin/grantee/save_history_file') ?>',
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                dataType: 'JSON',
                success: function(response){
                    $('#btn-history_file').prop('disabled', false);
                    $('#history_file_input_file').val('');
                    $('#description').val('');
                    $("#upload_history_file").modal('hide');
                    // $('#list_toa').append(response.html);
                    // $('.lightbox').topbox();
                    location.reload();
                },
            });
        }else{
            alert("Please select a file.");
            $('#btn-history_file').prop('disabled', false)
        }
    })
</script>