<script>
    $(".payment-log").click(function(e){
        var data_id = $(this).data('log')
        var payment_type = $(this).data('type')
        $("#model-payment-log tbody").html("");
        $('#email-recommendation-loading').show();
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('grantee/placement/get_log') ?>',
            dataType: 'JSON',
            data:{id: data_id},
            success: function(r) {
                if (r.status){
                    for (let i = 0; i<r.data.length;i++){
                        var checkData = JSON.parse(r.data[i].old_values); 
                        if (checkData && checkData.hasOwnProperty('revise_from')) {
                            
                        } else {
                            // var action = r.data[i].old_values != null || r.data[i].new_values != null ? "<a data-old_data='"+ JSON.stringify(r.data[i].old_values) +"' data-new_data='"+ JSON.stringify(r.data[i].new_values) +"' class='btn btn-primary btn-xs view-detail-log'><i class='fa fa-eye'></i> View Detail</a>" : '';
                            var action = r.data[i].old_values != null || r.data[i].new_values != null 
                                            ? "<a data-old_data='"+ JSON.stringify(r.data[i].old_values).replace(/'/g, "&apos;").replace(/"/g, "&quot;") +"' data-new_data='"+ JSON.stringify(r.data[i].new_values).replace(/'/g, "&apos;").replace(/"/g, "&quot;") +"' class='btn btn-primary btn-xs view-detail-log'><i class='fa fa-eye'></i> View Detail</a>" 
                                            : '';

                            var created_at = "<td>" + r.data[i].created_at + "</td>"; 
                            var event = "<td>" + r.data[i].event + "</td>"; 
                            var created_by = "<td>" + r.data[i].created_name + "</td>"; 
                            var pAction = "<td>" + action + "</td>"; 
                            
                            $("#model-payment-log tbody").append(`<tr>${created_at}${event}${created_by}${pAction}</tr>`)
                            $('#email-recommendation-loading').hide();
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
                        value = 'Approved by IIE';    
                    }else if(value == 0){
                        value = 'Rejected by IIE';     
                    }else if(value == 2){
                        value = 'Pending Review';    
                    }else if(value == 3){
                        value = 'Pending Review by Nominee';    
                    }else if(value == 4){
                        value = 'Approved by Nominee';    
                    }else if(value == 5){
                        value = 'Rejected by Nominee';   
                    }else if(value == 6){
                        value = 'Reject';    
                    }else if(value == 7){
                        value = 'Cancelled by IIE';    
                    }
                }

                if(key == 'university_id'){
                    key = 'university_name'
                }
                if(key == 'link'){
                    key = 'University_Website'
                }
                if(key == 'reason_decline'){
                    key = 'Reason for proposing this university'
                }
                if(key == 'reason_rejection'){
                    key = 'Reason of Rejection'
                    value = new_data.reason_rejection
                }
                if(key == 'submission_plan'){
                    if(value != ''){
                        value = '<a href="'+SITE_URL+value+'" class="lightbox btn btn-primary btn-xs">View</a>'
                    }
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

            // payment items
            // if (old_data.payment_items.length > 0) {
            //     element_old_data += '<div class="accordion" id="old-data">';
            //     for(let i = 0; i < old_data.payment_items.length; i++) { 
            //             element_old_data += '<div class="card">';
            //                 element_old_data += '<div class="card-header" id="heading-'+ old_data.payment_items[i].id +'">';
            //                 element_old_data += '<h5 class="mb-0 text-left">';
            //                     element_old_data += '<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse-'+ old_data.payment_items[i].id +'" aria-expanded="true" aria-controls="collapse-'+ old_data.payment_items[i].id +'">';
            //                     element_old_data += old_data.payment_items[i].payment_sub_category;
            //                     element_old_data += '</button>';
            //                 element_old_data += '</h5>';
            //                 element_old_data += '</div>';
            //                 element_old_data += '<div id="collapse-'+ old_data.payment_items[i].id +'" class="collapse" aria-labelledby="heading-'+ old_data.payment_items[i].id +'" data-parent="#old-data">';
                            
            //                 element_old_data += '<div class="card-body text-left pl-4">';
            //                     element_old_data += '<div>';
            //                         element_old_data += '<label>Payment Item : </label> ';
            //                         element_old_data += old_data.payment_items[i].payment_name;
            //                     element_old_data += '</div>';
            //                     element_old_data += '<div>';
            //                         element_old_data += '<label>Nominal IDR : </label> ';
            //                         element_old_data += old_data.payment_items[i].nominal_idr;
            //                     element_old_data += '</div>';
            //                     element_old_data += '<div>';
            //                         element_old_data += '<label>Nominal USD : </label> ';
            //                         element_old_data += old_data.payment_items[i].nominal;
            //                     element_old_data += '</div>';
            //                 element_old_data += '</div>';
            //                 element_old_data += '</div>';
            //             element_old_data += '</div>';
            //     }
            //     element_old_data += '</div>';
            // }
        }

        // new data
        let element_new_data = '';
        if (new_data != null) {

            element_new_data += '<table class="table table-striped">';
            $.each(new_data, function(key, value) {
                if(key == 'status'){
                    if(value == 1){
                        value = 'Approved by IIE';    
                    }else if(value == 0){
                        value = 'Rejected by IIE';     
                    }else if(value == 2){
                        value = 'Pending Review';    
                    }else if(value == 3){
                        value = 'Pending Review by Nominee';    
                    }else if(value == 4){
                        value = 'Approved by Nominee';    
                    }else if(value == 5){
                        value = 'Rejected by Nominee';     
                    }else if(value == 6){
                        value = 'Reject';    
                    }else if(value == 7){
                        value = 'Cancelled by IIE';    
                    }
                }

                if(key == 'university_id'){
                    key = 'university_name'
                }
                if(key == 'link'){
                    key = 'University_Website'
                }
                if(key == 'reason_decline'){
                    key = 'Reason for proposing this university'
                }
                if(key == 'reason_rejection'){
                    key = 'Reason of Rejection'
                    value = ''
                }
                if(key == 'submission_plan'){
                    if(value != ''){
                        value = '<a href="'+SITE_URL+value+'" class="lightbox btn btn-primary btn-xs">View</a>'
                    }
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
        $('.lightbox').topbox();
        
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
</script>