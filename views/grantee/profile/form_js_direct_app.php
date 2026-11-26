<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<script>
    // const SITE_URL = '<?php echo site_url(); ?>';
    $(".view-detail-direct").click(function(e){
        var data_id = $(this).data('id')
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('grantee/profile/get_detail_direct_application') ?>',
            dataType: 'JSON',
            data:{id: data_id},
            success: function(r) {
                $("#show_data_direct").html("");
                if (r.status){
                    let element = '';
                    let element2 = '';
                    if (r.data != null) {
                        var statusName = '';
                        if(r.data.status == 1){
                            statusName = 'Addmitted';    
                        }else if(r.data.status == 0){
                            statusName = 'Rejected';    
                        }else{
                            statusName = 'Pending';    
                        }

                        element += '<table class="table table-striped">';
                            element += '<tr>';
                                element += '<td class="text-left" width="35%">';
                                    element += 'University';
                                element += '</td>';
                                element += '<td class="text-left">';
                                    element += ': ' + r.data.name;
                                element += '</td>';
                            element += '</tr>';
                            element += '<tr>';
                                element += '<td class="text-left" width="35%">';
                                    element += 'Degree Level';
                                element += '</td>';
                                element += '<td class="text-left">';
                                    element += ': ' + r.data.degree_level;
                                element += '</td>';
                            element += '</tr>';
                            element += '<tr>';
                                element += '<td class="text-left" width="35%">';
                                    element += 'Major';
                                element += '</td>';
                                element += '<td class="text-left">';
                                    element += ': ' + r.data.major;
                                element += '</td>';
                            element += '</tr>';
                            element += '<tr>';
                                element += '<td class="text-left" width="35%">';
                                    element += 'Specialization';
                                element += '</td>';
                                element += '<td class="text-left">';
                                    element += ': ' + r.data.specialization;
                                element += '</td>';
                            element += '</tr>';
                            element += '<tr>';
                                element += '<td class="text-left" width="35%">';
                                    element += 'Department';
                                element += '</td>';
                                element += '<td class="text-left">';
                                    element += ': ' + r.data.department;
                                element += '</td>';
                            element += '</tr>';
                            element += '<tr>';
                                element += '<td class="text-left" width="35%">';
                                    element += 'Credits';
                                element += '</td>';
                                element += '<td class="text-left">';
                                    element += ': ' + r.data.credits;
                                element += '</td>';
                            element += '</tr>';
                            element += '<tr>';
                                element += '<td class="text-left" width="35%">';
                                    element += 'Program Duration';
                                element += '</td>';
                                element += '<td class="text-left">';
                                    element += ': ' + r.data.program_duration;
                                element += '</td>';
                            element += '</tr>';
                        element += '</table>';

                        var date = new Date(r.data.reply_deadline);
                        var options = { day: '2-digit', month: 'long', year: 'numeric' };
                        var formattedDate = r.data.reply_deadline == '' || r.data.reply_deadline == null ? '' : date.toLocaleDateString('us-US', options);

                        element2 += '<table class="table table-striped">';
                            element2 += '<tr>';
                                element2 += '<td class="text-left" width="35%">';
                                    element2 += 'Satus';
                                element2 += '</td>';
                                element2 += '<td class="text-left">';
                                    element2 += ': ' + statusName;
                                element2 += '</td>';
                            element2 += '</tr>';
                            element2 += '<tr>';
                                element2 += '<td class="text-left" width="35%">';
                                    element2 += 'Link';
                                element2 += '</td>';
                                element2 += '<td class="text-left">';
                                    element2 += ': ' + r.data.link;
                                element2 += '</td>';
                            element2 += '</tr>';
                            element2 += '<tr>';
                                element2 += '<td class="text-left" width="35%">';
                                    element2 += 'Reason';
                                element2 += '</td>';
                                element2 += '<td class="text-left">';
                                    element2 += ': ' + r.data.note;
                                element2 += '</td>';
                            element2 += '</tr>';
                            // element2 += '<tr>';
                            //     element2 += '<td class="text-left" width="35%">';
                            //         element2 += 'Reply Deadline';
                            //     element2 += '</td>';
                            //     element2 += '<td class="text-left">';
                            //         element2 += ': ' + formattedDate;
                            //     element2 += '</td>';
                            // element2 += '</tr>';
                            // element2 += '<tr>';
                            //     element2 += '<td class="text-left" width="35%">';
                            //         element2 += 'Recommendation';
                            //     element2 += '</td>';
                            //     element2 += '<td class="text-left">';
                            //         element2 += ': ' + r.data.recommendation;
                            //     element2 += '</td>';
                            // element2 += '</tr>';
                            // element2 += '<tr>';
                            //     element2 += '<td class="text-left" width="35%">';
                            //         element2 += 'Submission Plan';
                            //     element2 += '</td>';
                            //     element2 += '<td class="text-left">';
                            //         var displayButton = r.data.submission_plan == '' ? 'd-none' : '';
                            //         element2 += ': <a href="'+ SITE_URL + r.data.submission_plan +'" class="'+ displayButton +' lightbox btn btn-primary btn-xs">View</a>';
                            //     element2 += '</td>';
                            // element2 += '</tr>';
                        element2 += '</table>';
                        if(r.data.status == 0){
                            $('#button_approve, #button_decline').addClass('hide');
                            $('#button_revise').removeClass('hide');
                        }else if(r.data.status == 1 || r.data.status == 4){
                            $('#button_approve, #button_decline, #button_revise').addClass('hide');
                        }else{
                            $('#button_revise').addClass('hide');
                            $('#button_approve, #button_decline').removeClass('hide');
                        }
                    }
                    $("#show_data_direct").html(element)
                    $("#show_data_direct2").html(element2)
                }

                $('.lightbox').topbox();
            }
        });
    });


    $(document).on('click', '.btn-noaction', function(e) {
        e.stopPropagation();
        e.preventDefault();

    });

    function grantee_update_status_pre_academic(el, id, status) {
        if (confirm("Are you sure want to "+status+" this ?"))
            if(status == 'Reject'){
                $('#mdl_note_reject').modal()
                $('#btn-save-note-reject').attr("onclick","grantee_update_status_pre_academic_action("+ id +", '"+ status +"')"); 
            }else{
                grantee_update_status_pre_academic_action(id, status);
            }
    }

    function grantee_update_status_pre_academic_action(id, status) {
        var note = $('#note_reject_toa_pre').val()
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('grantee/placement/grantee_update_status_pre_academic') ?>',
            data: {
                id:id,
                status:status,
                note:note
            },
            dataType: 'JSON',
            success: function(r) {
                if(r.success){
                    location.reload();
                }
            }
        });
    }
</script>