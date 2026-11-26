<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<script>
    const SITE_URL = '<?php echo site_url(); ?>';
    $(".view-detail").click(function(e){
        var data_id = $(this).data('id')
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('grantee/profile/get_detail_submission_plan') ?>',
            dataType: 'JSON',
            data:{id: data_id},
            success: function(r) {
                $("#show_data").html("");
                if (r.status){
                    let element = '';
                    let element2 = '';
                    if (r.data != null) {
                        var statusName = '';
                        if(r.data.status == 1){
                            statusName = 'Approved by IIE';    
                        }else if(r.data.status == 0){
                            statusName = 'Rejected by IIE';     
                        }else if(r.data.status == 2){
                            statusName = 'Pending Review';    
                        }else if(r.data.status == 3){
                            statusName = 'Pending Review by Nominee';    
                        }else if(r.data.status == 4){
                            statusName = 'Approved by Nominee';    
                        }else if(r.data.status == 5){
                            statusName = 'Rejected by Nominee';    
                        }else if(r.data.status == 6){
                            statusName = 'Reject';    
                        }else if(r.data.status == 7){
                            statusName = 'Cancelled by IIE';    
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
                            element += '<tr>';
                                element += '<td class="text-left" width="35%">';
                                    element += 'University Website';
                                element += '</td>';
                                element += '<td class="text-left">';
                                    element += ': ' + r.data.link;
                                element += '</td>';
                            element += '</tr>';
                            element += '<tr>';
                                element += '<td class="text-left" width="35%">';
                                    element += 'Note';
                                element += '</td>';
                                element += '<td class="text-left">';
                                    element += ': ' + r.data.note;
                                element += '</td>';
                            element += '</tr>';
                        element += '</table>';

                        var date = new Date(r.data.reply_deadline);
                        var options = { day: '2-digit', month: 'long', year: 'numeric' };
                        var formattedDate = r.data.reply_deadline == '' || r.data.reply_deadline == null ? '' : date.toLocaleDateString('us-US', options);

                        element2 += '<table class="table table-striped">';
                            element2 += '<tr>';
                                element2 += '<td class="text-left" width="35%">';
                                    element2 += 'Status';
                                element2 += '</td>';
                                element2 += '<td class="text-left">';
                                    element2 += ': ' + statusName;
                                element2 += '</td>';
                            element2 += '</tr>';
                            element2 += '<tr>';
                                element2 += '<td class="text-left" width="35%">';
                                    element2 += 'Reply Deadline';
                                element2 += '</td>';
                                element2 += '<td class="text-left">';
                                    element2 += ': ' + formattedDate;
                                element2 += '</td>';
                            element2 += '</tr>';
                            element2 += '<tr>';
                                element2 += '<td class="text-left" width="35%">';
                                    element2 += 'Recommendation';
                                element2 += '</td>';
                                element2 += '<td class="text-left">';
                                    element2 += ': ' + r.data.recommendation;
                                element2 += '</td>';
                            element2 += '</tr>';
                            element2 += '<tr>';
                                element2 += '<td class="text-left" width="35%">';
                                    element2 += 'Submission Plan';
                                element2 += '</td>';
                                element2 += '<td class="text-left">';
                                    var displayButton = r.data.submission_plan == '' ? 'd-none' : '';
                                    element2 += ': <a href="'+ SITE_URL + r.data.submission_plan +'" class="'+ displayButton +' lightbox btn btn-primary btn-xs">View</a>';
                                element2 += '</td>';
                            element2 += '</tr>';
                        element2 += '</table>';
                        if(r.data.status == 0 || r.data.status == 6 ){
                            $('#button_approve, #button_decline').addClass('hide');
                            $('#button_revise').removeClass('hide');
                        }else if(r.data.status == 2){
                            $('#button_approve, #button_decline').addClass('hide');
                            $('#button_revise').removeClass('hide');
                            $('#button_revise').addClass('hide');
                        }else if(r.data.status == 1 || r.data.status == 4 || r.data.status == 5 || r.data.status == 7){
                            $('#button_approve, #button_decline, #button_revise').addClass('hide');
                        }else{
                            $('#button_revise').addClass('hide');
                            $('#button_approve, #button_decline').removeClass('hide');
                        }
                    }
                    $("#show_data").html(element)
                    $("#show_data2").html(element2)
                }

                $('.lightbox').topbox();
            }
        });
        $('#button_decline').attr('data-id', data_id);
        $('#submission_plan_id').val(data_id);
    });

    $('#button_revise').click(function(){
        $('#exampleModalLabel').html('Add New Data');
        // $('#section_reason').addClass('hide');
        // $('#note_decline').removeAttr('required');
        $('#university_id, #degree_level, #major, #specialization, #department, #link').prop('required', true); 
        $('#note_rejection').prop('required', false)
        $('#section_reason_rejection').css('display', 'none');
    });

    $('#button_decline').click(function(){
        $('#exampleModalLabel').html('Add Reason & Add New Data');
        $('#section_reason').removeClass('hide');
        $('#note_decline, #university_id, #note_rejection, #degree_level, #major, #specialization, #department, #link').prop('required', true);
    });

    $('#mdl_note_decline').on('hidden.bs.modal', function () {
        $("#modal-detail").modal('show');
    });
    $('.select2').select2({
        theme: 'bootstrap'
    });
    $('#university_id').select2({
        theme: 'bootstrap',
        dropdownParent: $('#mdl_note_decline'),
        tabindex: -1,
        dropdownAutoWidth: true,
    });

    $('#university_id').on('select2:select select2:opening select2:closing', function(e) {
        e.stopPropagation(); // Mencegah event merembes ke modal
    });

    $('#button_approve').click(function(){
        $('#hidden_submit').val('approve');
        Swal.fire({
                title   : "Are you sure you want to submit this assessment?",
                text    : "Once submitted, data cannot be changed.",
                icon    : "warning",
                showCancelButton    : true,
                confirmButtonColor  : "#3085d6",
                cancelButtonColor   : "#d33",
                confirmButtonText   : "Yes, submit",
                customClass         : 'swal-interview'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#form_sp").submit();
                }
            });
    });

    $('#btn-submit').click(function(){
        Swal.fire({
                title   : "Are you sure you want to submit?",
                icon    : "warning",
                showCancelButton    : true,
                confirmButtonColor  : "#3085d6",
                cancelButtonColor   : "#d33",
                confirmButtonText   : "Yes, submit",
                customClass         : 'swal-interview'
            }).then((result) => {
                if (result.isConfirmed) {
                $('input.rank').each(function() {
                    if ($(this).val() === null || $(this).val() === '') {
                        Swal.fire({
                        icon: "error",
                        text: "You have not yet arranged your ranked list of universities. To proceed with your application submission, please complete this step by dragging and dropping the university names into your desired order.",
                        });
                        return false; // Untuk menghentikan proses jika ada input yang kosong
                    }else{
                        $("form").submit();
                    }
                });
                }
            });
    });
    
    // var $select2 = $('#university_id');
    // $(window).on('scroll', function() {
    //     $select2.each(function() {
    //         var select2Instance = $(this).data('select2');
    //         if (select2Instance) {
    //             select2Instance.dropdown._positionDropdown();
    //         }
    //     });
    // });



    $(document).ready(function(){
        $("#submission_plan_table tbody").sortable({
            cursor: "move",
            placeholder: "sortable-placeholder",
            helper: function(e, tr) {
                let $originals = tr.children();
                let $helper = tr.clone();
                $helper.children().each(function(index) {
                    $(this).width($originals.eq(index).width());
                });
                return $helper;
            },
            update: function(event, ui) {
                let sorted_ids = [];
                $("#submission_plan_table tbody").find('tr').each(function(index) {
                    let row = $(this);
                    let row_number = index + 1;
                    // row.find('td:first').text(row_number); 

                    let field_score = row.find('td:eq(2) span');
                    field_score.text(row_number);

                    let input_score = row.find('td:eq(2) input.rank');
                    input_score.val(row_number);
                });
            }
        }).disableSelection();
    });

    $('#lock_submission_plan').change(function() {
        var isChacked = 0;
        if($(this).is(':checked')) {
            isChacked = 1;
        } else {
            isChacked = 0;
        }
        Swal.fire({
            title: 'Loading...',
            text: 'Please wait while we process your request.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,  // Menghilangkan tombol "OK"
            didOpen: () => {
                Swal.showLoading();  // Memunculkan loading spinner
        }
        });
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/nominee/submission_plan/changeLock') ?>',
            dataType: 'JSON',
            data:{
                lock_submission_plan: isChacked,
                grantee_grant_id: <?= $grantee_grant->id ?>
            },
            success: function(r) {
                location.reload();
            }
        });
    });

</script>