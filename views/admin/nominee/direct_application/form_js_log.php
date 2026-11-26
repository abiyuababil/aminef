<script>
    const SITE_URL = '<?php echo site_url(); ?>';
    $(".payment-log").click(function(e){
        var data_id = $(this).data('log')
        var payment_type = $(this).data('type')
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/nominee/direct_application/get_log') ?>',
            dataType: 'JSON',
            data:{id: data_id},
            success: function(r) {
                $("#model-payment-log tbody").html("");
                if (r.status){
                    for (let i = 0; i<r.data.length;i++){
                        var checkData = JSON.parse(r.data[i].old_values); 
                        if (checkData && checkData.hasOwnProperty('revise_from')) {
                            
                        } else {

                            var oldData = r.data[i].old_values ? JSON.stringify(r.data[i].old_values).replace(/"/g, '&quot;').replace(/'/g, '&#39;') : null;
                            var newData = r.data[i].new_values ? JSON.stringify(r.data[i].new_values).replace(/"/g, '&quot;').replace(/'/g, '&#39;') : null;

                            var action = r.data[i].old_values != null || r.data[i].new_values != null 
                                ? "<a data-old_data='" + oldData + "' data-new_data='" + newData + "' class='btn btn-primary btn-xs view-detail-log'><i class='fa fa-eye'></i> View Detail</a>" 
                                : '';

                            

                            // var action = r.data[i].old_values != null || r.data[i].new_values != null ? "<a data-old_data='"+ JSON.stringify(r.data[i].old_values) +"' data-new_data='"+ JSON.stringify(r.data[i].new_values) +"' class='btn btn-primary btn-xs view-detail-log'><i class='fa fa-eye'></i> View Detail</a>" : '';
                            var created_at = "<td>" + r.data[i].created_at + "</td>"; 
                            var event = "<td>" + r.data[i].event + "</td>"; 
                            var created_by = "<td>" + r.data[i].created_name + "</td>"; 
                            var pAction = "<td>" + action + "</td>"; 
                            
                            $("#model-payment-log tbody").append(`<tr>${created_at}${event}${created_by}${pAction}</tr>`)
                        }
                    }
                }
            }
        })
    });

    $(document).on('click', '.view-detail-log', function(e){
        let element = $(this);
        let old_data = JSON.parse(element.data('old_data'));
        let new_data = JSON.parse(element.data('new_data'));
        old_data = JSON.parse(old_data);
        new_data = JSON.parse(new_data);
        // old data
        let element_old_data = '';
        if (old_data != null) {

            element_old_data += '<table class="table table-striped">';
            $.each(old_data, function(key, value) {
                if(key == 'status'){
                    if(value == 1){
                        value = 'Admitted';    
                    }else if(value == 0){
                        value = 'Rejected';     
                    }else{
                        value = 'Pending';    
                    }
                }

                if(key == 'university_id'){
                    key = 'university_name'
                }
                if(key == 'link'){
                    key = 'University_Website'
                }
                element_old_data += '<tr>';
                    element_old_data += '<td class="text-left" width="35%">';
                        element_old_data += formatText(key);
                    element_old_data += '</td>';
                    element_old_data += '<td class="text-left">';
                        element_old_data += ': ' + value;
                    element_old_data += '</td>';
                element_old_data += '</tr>';
            });
            element_old_data += '</table>';
        }

        // new data
        let element_new_data = '';
        if (new_data != null) {

            element_new_data += '<table class="table table-striped">';
            $.each(new_data, function(key, value) {
                if(key == 'status'){
                    if(value == 1){
                        value = 'Admitted';    
                    }else if(value == 0){
                        value = 'Rejected';     
                    }else{
                        value = 'Pending';    
                    }
                }

                if(key == 'university_id'){
                    key = 'university_name'
                }
                if(key == 'link'){
                    key = 'University_Website'
                }
                element_new_data += '<tr>';
                    element_new_data += '<td class="text-left" width="35%">';
                        element_new_data += formatText(key);
                    element_new_data += '</td>';
                    element_new_data += '<td class="text-left">';
                        element_new_data += ': ' + value;
                    element_new_data += '</td>';
                element_new_data += '</tr>';
            });
            element_new_data += '</table>';
        }

        $("#old-data").html(element_old_data);
        $("#new-data").html(element_new_data);
        $("#modal-payment-log").modal('hide');
        $("#mdl_detail_log").modal('show');
        
    });

    $('#mdl_detail_log').on('hidden.bs.modal', function () {
        $("#modal-payment-log").modal('show');
    });

    function formatText(text) {
        return text.replace(/_/g, ' ') // Mengganti _ dengan spasi
        .replace(/\b\w/g, function(char) { // Membuat huruf pertama setiap kata kapital
            return char.toUpperCase();
        });
    }

    function show_preview(element, type, upload_type) {
        const file = element.files[0];
        $('#btn-save-note-withdraw').html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop( 'disabled', true );
        let formData = new FormData();
        formData.append(upload_type, file);
        formData.append('type', upload_type);

        $.ajax({
            url: SITE_URL + 'admin/grantee/save_file', 
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType : 'JSON',
            success: function(response) {
                if (response.status) {
                    render_data_upload_attach(response, upload_type);
                    // let file_url = SITE_URL + response.filepath;
                    // $(".uploaded_attachment").attr('href', file_url).removeClass('hide').html('<b> <i class="fa fa-paperclip"></i> ' + response.filename) + '</b>';
                    // $("input[name='" + upload_type +"']").val(response.filepath);
                } else {
                    $(".uploaded_attachment").addClass('hide');
                    alert('Failed to upload your file, please try again');
                }

                $('#btn-save-note-withdraw').html('Save').prop( 'disabled', false );
            },
            error: function(xhr, status, error) {
                $('#btn-save-note-withdraw').html('Save').prop( 'disabled', false );
                console.error(error); 
            }
        });
    }

    function deleteable_grantee(el)
    {
        var grantee_grant_id = $(el).data('granteegrantid');
        var id = $(el).data('id');
        var deleteable = $(el).is(':checked') ? 1 : 0;
        $.ajax({
            url: SITE_URL + 'admin/nominee/direct_application/update_deleteable_grantee', 
            type: 'POST',
            data: {grantee_grant_id: grantee_grant_id, id: id, deleteable: deleteable},
            dataType : 'JSON',
            success: function(response) {
                if (response.status) {
                    showSwal('success', 'Successfully changed', false, true, 1500);
                } else {
                    showSwal('error', 'Failed to update Grantee Delete, please try again', false, true, 1500);
                }
            },
            error: function(xhr, status, error) {
                console.error(error); 
            }
        });
    }
</script>