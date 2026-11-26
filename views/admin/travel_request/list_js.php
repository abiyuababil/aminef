<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<script>
    const SITE_URL = '<?php echo site_url(); ?>';
    function appendDataToTable(data) {
        const tableBody = $('#data_table');

        // Clear the existing table data
        tableBody.empty();

        // Iterate through the data and append rows to the table
        var table = '';
        table += '<table id="data_table" class="table table-striped table-hover" width="100%">';
        table += '<thead>';
        table += '<tr>';
        table += '<th>File</th>';
        table += '<th>Upload Date</th>';
        table += '</tr>';
        table += '</thead>';
        data.forEach(function(item) {
            const nameFile = item.file.split('/');
            table += '<tr>'
            table += '<td><a class="lightbox" href="<?= base_url() ?>' + item.file + '">' + nameFile[nameFile.length - 1] + '</a></td>'
            table += '<td>' + item.insert_date + '</td>'
            table += '</tr>'
        });
        table += '</thead>';
        tableBody.append(table);
    }

    $('#mdl_detail_leave').on('show.bs.modal', function(event) {
        $.fn.modal.Constructor.prototype.enforceFocus = function() {
            var button = $(event.relatedTarget);
            var leaveId = button.data('leave-id');
            var granteeGrantId = button.data('gratee-grant-id');

            if (typeof currentLeaveApps !== 'undefined') {
                $('#data_table').empty();
                var data = currentLeaveApps[leaveId];
                var baseUrl = '<?= base_url() ?>';
                var urlForm = '<?= base_url('admin/grantee/edit_status_leave/') ?>' + granteeGrantId + '/travelreq';
                if (data.status == <?= LEAVE_CANCEL ?>) {
                    $("#status-ddown").addClass("hide");
                    $("#status-cancel").removeClass("hide");
                    $("#v_status").val("CANCEL");
                    $(".btn-save").prop("disabled", true);
                } else {
                    $("#status-ddown").removeClass("hide");
                    $("#status-cancel").addClass("hide");
                    $(".btn-save").prop("disabled", false);
                }
                $("#form_status_leave").attr('action', urlForm);
                $("#leave_id").val(data.id);
                if (data.category_name != null) {
                    $("#leave_category").val(data.category_name).closest('div.form-group').removeClass('hide');
                } else {
                    $("#leave_category").val('').closest('div.form-group').addClass('hide');
                }

                if (data.total_request != null) {
                    $("#leave_day").val(data.total_request + ' Day').closest('div.form-group').removeClass('hide');
                } else {
                    $("#leave_day").val('').closest('div.form-group').addClass('hide');
                }

                if (data.start_date != null) {
                    $("#start_date").val($.datepicker.formatDate("d M yy", new Date(data.start_date))).closest('div.form-group').removeClass('hide');
                } else {
                    $("#start_date").val('').closest('div.form-group').addClass('hide');
                }

                if (data.end_date != null) {
                    $("#end_date").val($.datepicker.formatDate("d M yy", new Date(data.end_date))).closest('div.form-group').removeClass('hide');
                } else {
                    $("#end_date").val('').closest('div.form-group').addClass('hide');
                }

                if (data.status != null) {
                    $("#status").val(data.status);
                } else {
                    $("#status").val('');
                }

                if (data.telephone != null && data.telephone !== '') {
                    $("#telephone_val").val(data.telephone).closest('div.form-group').removeClass('hide');
                } else {
                    $("#telephone_val").val('').closest('div.form-group').addClass('hide');
                }

                if (data.email != null && data.email !== '') {
                    $("#email_val").val(data.email).closest('div.form-group').removeClass('hide');
                } else {
                    $("#email_val").val('').closest('div.form-group').addClass('hide');
                }

                if (data.address != null && data.address !== '') {
                    $("#address_val").val(data.address).closest('div.form-group').removeClass('hide');
                } else {
                    $("#address_val").val('').closest('div.form-group').addClass('hide');
                }

                if (data.destination_purpose != null && data.destination_purpose !== '') {
                    $("#destination_purpose").val(data.destination_purpose).closest('div.form-group').removeClass('hide');
                } else {
                    $("#destination_purpose").val('').closest('div.form-group').addClass('hide');
                }

                if (data.destination != null && data.destination !== '') {
                    $("#destination").val(data.destination?.toUpperCase()).closest('div.form-group').removeClass('hide');
                } else {
                    $("#destination").val('').closest('div.form-group').addClass('hide');
                }

                if (data.departure_site_date != null) {
                    $("#departure_site_date").val($.datepicker.formatDate("d M yy", new Date(data.departure_site_date))).closest('div.form-group').removeClass('hide');
                } else {
                    $("#departure_site_date").val('').closest('div.form-group').addClass('hide');
                }

                if (data.arrival_site_date != null) {
                    $("#arrival_site_date").val($.datepicker.formatDate("d M yy", new Date(data.arrival_site_date))).closest('div.form-group').removeClass('hide');
                } else {
                    $("#arrival_site_date").val('').closest('div.form-group').addClass('hide');
                }

                if (data.departure_indo_date != null) {
                    $("#departure_indo_date").val($.datepicker.formatDate("d M yy", new Date(data.departure_indo_date))).closest('div.form-group').removeClass('hide');
                } else {
                    $("#departure_indo_date").val('').closest('div.form-group').addClass('hide');
                }

                if (data.arrival_indo_date != null) {
                    $("#arrival_indo_date").val($.datepicker.formatDate("d M yy", new Date(data.arrival_indo_date))).closest('div.form-group').removeClass('hide');
                } else {
                    $("#arrival_indo_date").val('').closest('div.form-group').addClass('hide');
                }

                if (data.form_upload == null) {
                    $("#form_upload_file").addClass('hide').closest('div.form-group').addClass('hide');
                } else {
                    $("#form_upload_file").removeClass('hide').attr("href", baseUrl + data.form_upload).closest('div.form-group').removeClass('hide');
                }

                if (data.research_travel_activities == null) {
                    $("#research_travel").addClass('hide').closest('div.form-group').addClass('hide').val('');
                } else {
                    // var plainText = $('<div>').html(data.research_travel_activities).text();
                    $("#research_travel").removeClass('hide').html(data.research_travel_activities).text()
                    $("#research_travel").closest('div.form-group').removeClass('hide');
                }

                if (data.boarding_pass == null) {
                    $("#borading_pass_file").addClass('hide')
                } else {
                    $("#borading_pass_file").removeClass('hide').attr("href", baseUrl + data.boarding_pass)
                }
                console.log(data.departure_time);
                if (data.departure_time != null) {
                    $("#departure_time").val(data.departure_time).closest('div.form-group').removeClass('hide');
                } else {
                    $("#departure_time").val('').closest('div.form-group').addClass('hide');
                }

                if (data.note != null) {
                    $("#note").val(data.note);
                } else {
                    $("#note").val('');
                }

                // if (data.category_name == 'Personal Travel') {
                //     $("#section_departure_site_date").removeClass("hide");
                //     $("#section_arrival_site_date").removeClass("hide");
                //     $("#section_departure_indo_date").removeClass("hide");
                //     $("#section_arrival_indo_date").removeClass("hide");
                //     $('#label_start').html('Date of Departure from Site')
                //     $('#label_end').html('Date of Arrival at Your Site')
                //     $("#telephone, #email, #address").removeClass("hide");
                // } else {
                //     $("#section_departure_site_date").addClass("hide");
                //     $("#section_arrival_site_date").addClass("hide");
                //     $("#section_departure_indo_date").addClass("hide");
                //     $("#section_arrival_indo_date").addClass("hide");
                //     $('#label_start').html('Start Date')
                //     $('#label_end').html('End Date')
                //     $("#telephone, #email, #address").addClass("hide");
                // }

                // if (data.category_name == 'Sick Leave') {
                //     $("#boarding_pass_form").addClass('hide');
                //     $("#destination_form").addClass('hide');
                //     $("#form_upload").removeClass('hide');
                //     $("#destination_purpose_form").addClass('hide');
                // } else if (data.category_name == 'Emergency Leave') {
                //     $("#boarding_pass_form").addClass('hide');
                //     $("#form_upload").removeClass('hide');
                //     $("#destination_form").removeClass('hide');
                //     $("#destination_purpose_form").removeClass('hide');
                // } else {
                //     $("#boarding_pass_form").removeClass('hide');
                //     $("#form_upload").removeClass('hide');
                //     $("#destination_form").removeClass('hide');
                //     $("#destination_purpose_form").addClass('hide');
                // }

                if (data.boarding_pass != null && data.boarding_pass.length > 0) {
                    appendDataToTable(data.boarding_pass)
                }

                $('.lightbox').topbox();
            }
        };
    });

    $(".btn-save").click(function() {
        $(".btn-save").prop("disabled", true);
        $("#form_status_leave").submit();
    })



    $(".modal-log-leave").click(function(e){
        var data_id = $(this).data('log')
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/travel_request/get_log_leave') ?>',
            dataType: 'JSON',
            data:{
                id: data_id,
                table: 'am_grantee_leaves'
            },
            success: function(r) {
                $("#model-payment-log tbody").html("");
                if (r.status){
                    for (let i = 0; i<r.data.length;i++){
                        var checkData = JSON.parse(r.data[i].old_values); 
                        if (checkData && checkData.hasOwnProperty('revise_from')) {
                            
                        } else {
                            var action = r.data[i].old_values != null || r.data[i].new_values != null 
                                            ? "<a data-old_data='"+ JSON.stringify(r.data[i].old_values).replace(/'/g, "&apos;").replace(/"/g, "&quot;") +"' data-new_data='"+ JSON.stringify(r.data[i].new_values).replace(/'/g, "&apos;").replace(/"/g, "&quot;") +"' class='btn btn-primary btn-xs view-detail-log'><i class='fa fa-eye'></i> View Detail</a>" 
                                            : '';

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
                if(key == 'form_upload'){
                    if(value != ''){
                        value = '<a href="'+SITE_URL+value+'" class="lightbox btn btn-primary btn-xs">View</a>'
                    }
                }
                if(key == 'status'){
                    if(value == 0){
                        value = 'PENDING';    
                    }else if(value == 1){
                        value = 'APPROVE';     
                    }else if(value == 2){
                        value = 'REJECT';    
                    }else if(value == 3){
                        value = 'CANCEL';    
                    }

                }
                if(key == 'leave_category'){
                    if(value == 1){
                        value = 'Personal Travel';    
                    }else if(value == 2){
                        value = 'Sick Leave';     
                    }else if(value == 3){
                        value = 'Emergency Leave';    
                    }else if(value == 4){
                        value = 'International Research Travel';    
                    }
                }
                if( key == 'grantee_grant_id'){
                    return true;
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
                if(key == 'form_upload'){
                    if(value != ''){
                        value = '<a href="'+SITE_URL+value+'" class="lightbox btn btn-primary btn-xs">View</a>'
                    }
                }
                if(key == 'status'){
                    if(value == 0){
                        value = 'PENDING';    
                    }else if(value == 1){
                        value = 'APPROVE';     
                    }else if(value == 2){
                        value = 'REJECT';    
                    }else if(value == 3){
                        value = 'CANCEL';    
                    }

                }
                if(key == 'leave_category'){
                    if(value == 1){
                        value = 'Personal Travel';    
                    }else if(value == 2){
                        value = 'Sick Leave';     
                    }else if(value == 3){
                        value = 'Emergency Leave';    
                    }else if(value == 4){
                        value = 'International Research Travel';    
                    }
                }
                if( key == 'grantee_grant_id'){
                    return true;
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
</script>