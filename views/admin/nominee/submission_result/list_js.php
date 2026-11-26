<script>
    const SITE_URL = '<?php echo site_url(); ?>';
    $(document).ready(function(){
        $(".view-data").click(function(){
            var id = $(this).data("id");
            var type = $(this).data("type");

            // hide and show view 
            if (type == 'submission_plan') {
                $(".detail-submission-plan").removeClass("hide");
                $(".detail-direct-application").addClass("hide");
            } else {
                $(".detail-submission-plan").addClass("hide");
                $(".detail-direct-application").removeClass("hide");
            }

            // get data ajax
            $.ajax({
                url: "<?php echo site_url('admin/nominee/submission_result/detail_data/') ?>" + id,
                method: "POST",
                dataType: "JSON",
                data: {
                    type: type
                }, 
                success: function(output){
                    console.log(output)
                    if (type == 'submission_plan') {
                        $(".detail-submission-plan .university").val(output.university_name);
                        // $(".detail-submission-plan .address").val(output.address);
                        $(".detail-submission-plan .major").val(output.major);
                        $(".detail-submission-plan .program_duration").val(output.program_duration);
                        $(".detail-submission-plan .specialization").val(output.specialization);
                        $(".detail-submission-plan .status").val(output.submission_result_status ?? 'Pending Decision');
                        if (output.submission_plan != "") {
                            var display = output.submission_plan;
                            var resultsubmission_plan = output.submission_plan.split('/');
                            var lastsubmission_plan = (resultsubmission_plan[resultsubmission_plan.length - 1]).split('.');
                            var extsubmission_plan = lastsubmission_plan[lastsubmission_plan.length - 1];
                            if(extsubmission_plan == 'pdf'){
                                var display = '<?= base_url('assets/images/icons/pdf.svg');?>';
                            } 
                            $(".detail-submission-plan .link-submission-plan").html("<a class='lightbox' href='"+output.submission_plan+"'><img height='100' src='"+display+"'></a>");
                        }else{
                            $(".detail-submission-plan .link-submission-plan").html("")
                        }
                    } else {
                        $(".detail-direct-application .university").val(output.university_name);
                        // $(".detail-direct-application .address").val(output.address);
                        $(".detail-direct-application .major").val(output.major);
                        $(".detail-direct-application .program_duration").val(output.program_duration);
                        $(".detail-direct-application .specialization").val(output.specialization);
                        $(".detail-direct-application .status").val(output.submission_result_status);
                        $(".detail-direct-application .note").val(output.note);
                        if (output.support_letter != ""){
                            var display = output.support_letter;
                            var resultsupport_letter = output.support_letter.split('/');
                            var lastsupport_letter = (resultsupport_letter[resultsupport_letter.length - 1]).split('.');
                            var extsupport_letter = lastsupport_letter[lastsupport_letter.length - 1];
                            if(extsupport_letter == 'pdf'){
                                var display = '<?= base_url('assets/images/icons/pdf.svg');?>';
                            } 
                            $(".detail-direct-application .link-support-letter").html("<a class='lightbox' href='"+output.support_letter+"'><img height='100' src='"+display+"' style='width:100%;object-fit:contain;'></a>");   
                        }else{
                            $(".detail-direct-application .link-support-letter").html("")
                        }
                        if (output.loa != ""){
                            var display = output.loa;
                            var resultLoa = output.loa.split('/');
                            var lastLoa = (resultLoa[resultLoa.length - 1]).split('.');
                            var extLoa = lastLoa[lastLoa.length - 1];
                            if(extLoa == 'pdf'){
                                var display = '<?= base_url('assets/images/icons/pdf.svg');?>';
                            } 
                            $(".detail-direct-application .link-loa").html("<a class='lightbox' href='"+output.loa+"'><img height='100' src='"+display+"'></a>");
                        }else{
                            $('.detail-direct-application .link-loa').html("");
                        }
                    }
                    $('.lightbox').topbox();
                }
            });
        });

        $(".view-log").click(function(e){
            var id_parent = $(this).data('id')
            var type = $(this).data('type')
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/nominee/submission_result/get_status_log') ?>',
                dataType: 'JSON',
                data:{id_parent: id_parent, type: type},
                success: function(r) {
                    $("#viewLog tbody").html("");
                    if (r.status){
                        for (let i = 0; i<r.data.length;i++){
                            var action = r.data[i].status_before != null || r.data[i].status_after != null 
                                            ? "<a data-old_data='"+ JSON.stringify(r.data[i].status_before).replace(/'/g, "&apos;").replace(/"/g, "&quot;") +"' data-new_data='"+ JSON.stringify(r.data[i].status_after).replace(/'/g, "&apos;").replace(/"/g, "&quot;") +"' class='btn btn-primary btn-xs view-detail-log'><i class='fa fa-eye'></i> View Detail</a>" 
                                            : '';
                                            
                                            
                            var created_at = "<td>" + r.data[i].created_at + "</td>"; 
                            var event = "<td>" + r.data[i].event + "</td>"; 
                            var created_by = "<td>" + r.data[i].created_by + "</td>";     
                            var pAction = "<td>" + action + "</td>"; 

                            $("#viewLog tbody").append(`<tr>${created_at}${event}${created_by}${pAction}</tr>`)
                        }
                    }
                }
            })
        })

        
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
                    if(key == 'loa' || key == 'bank_statement' || key == 'attachment_revise_bank_statement'){
                        if(value != '' && value != null){
                            value = '<a href="'+SITE_URL+value+'" class="lightbox btn btn-primary btn-xs">View</a>'
                        }
                    }

                    if(value == null){
                        value = ''
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
                    if(key == 'loa' || key == 'bank_statement' || key == 'attachment_revise_bank_statement'){
                        if(value != '' && value != null){
                            value = '<a href="'+SITE_URL+value+'" class="lightbox btn btn-primary btn-xs">View</a>'
                        }
                    }

                    if(value == null){
                        value = ''
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
            $("#viewLog").modal('hide');
            $("#mdl_detail_log").modal('show');
            $('.lightbox').topbox();
            
        });

        $('#mdl_detail_log').on('hidden.bs.modal', function () {
            $("#viewLog").modal('show');
        });

        function formatText(text) {
            return text.replace(/_/g, ' ') // Mengganti _ dengan spasi
            .replace(/\b\w/g, function(char) { // Membuat huruf pertama setiap kata kapital
                return char.toUpperCase();
            });
        }
    })

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

    $(".btn-choose-admin").click(function(){
        Swal.fire({
            title   : "Are you sure?",
            icon    : "warning",
            showCancelButton    : true,
            confirmButtonColor  : "#3085d6",
            cancelButtonColor   : "#d33",
            confirmButtonText   : "Yes",
        }).then((result) => {
            if (result.isConfirmed) {
                showSwal('loading', 'Please wait while we process your request.');
                var id = $(this).data('id');
                var universityName = $(this).data('university');
                var type = $(this).data('flag');
                var grantee_grant_id = $(this).data('grantee_grant_id');
                var action = $(this).data('action');
                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url('admin/nominee/submission_result/approve_choose_university') ?>',
                    dataType: 'JSON',
                    data:{
                        id: id,
                        type: type,
                        universityName: universityName,
                        grantee_grant_id: grantee_grant_id,
                        action: action
                    },
                    success: function(r) {
                        if (r.success){
                            location.reload();
                        }
                    }
                })
            }
        });
    });


    $(document).on('click', '.btn-univ-detail', function() {
        $('#m_degree').text($(this).data('degree'));
        $('#m_major').text($(this).data('major'));
        $('#m_credit').text($(this).data('credit'));
        $('#m_duration').text($(this).data('duration'));
        $('#m_specialization').text($(this).data('specialization'));

        $('#modalUniv').modal('show');
    });

    function showNote(el) {
        note = $(el).data('note')
        Swal.fire({
            html: `
                <div>
                    <label><b>Addmission Condition </b></label>
                    <br/>
                    <textarea rows="15" style="font-size:16px;resize: none;" class="form-control" readonly>`+note+`</textarea>    
                </div>
            `,
            showConfirmButton: false, 
            showCancelButton: true,
            cancelButtonText: 'Close',
        });
    }
</script>