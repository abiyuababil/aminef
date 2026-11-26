<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<script>
    const SITE_URL = '<?php echo site_url(); ?>';
    $(document).ready(function(){
        $(".datetime").datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            autoclose: true,
        });
        
        $('.select2').select2({
            theme: 'bootstrap'
        });
        
		$( ".datepicker" ).datepicker({
		  changeMonth: true,
		  changeYear: true,
		  dateFormat: "dd M yy",
		  yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
		});

        $('#university_id_select').trigger('change');
        $('#is_final_placement').trigger('change', [true]);
    });
    
    $("#btn-decline").click(function(){
        $("#mdl_info_decline").modal();    
        event.preventDefault();
    });

    $("#btn-present").click(function(){
        $("#mdl_info_present").modal();    
        event.preventDefault();
    });

    function add_submission_plant() {
        var idx = $('.submission-plant-item').length;
        $('.add-load').show();
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/college_placement/getPartialSumbmissionPlant') ?>/'+ idx,
            dataType: 'JSON',
            success: function(r) {
                var html = r;
                $('#wrap-submission-plant').append(html);
                $('.select2').select2({
                    theme: 'bootstrap'
                });
                $('.add-load').hide();
                $( ".datepicker" ).datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "dd M yy",
                yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
                });
            }
        });
    }

    function del_item(el, item_class) {
        if (confirm("Are you sure want to delete this ?"))
            $(el).closest('.' + item_class).remove();
    }

    function get_university(select, index)
    {
        if(select.value == 'accept'){
            var status_arr = [];
            var field_status = $(".status_plan").length;
            for(let i = 0; i < field_status; i++) {
                status_arr.push($("#status_plant_"+i+"").val());
            }
            status_arr.splice(index,1);
            if(jQuery.inArray("accept", status_arr) !== -1) {
                alert('There is already an accepted status in other submissions')
                $("#status_plant_"+index+"").val('waiting')
            } 
        }
    }


    $("#btn-corespondence").click(function(){
        var fd = new FormData();
        var files = $('#corespondence_file_input_file')[0].files;
        var id = $('#collage_placement_id').val();
        var grantee_grant_id = $('#grantee_grant_id').val();
        $('#btn-corespondence').prop('disabled', true)
        var input_file = document.getElementById('corespondence_file_input_file'); 
        var totalfiles = input_file.files.length;


        // Check file selected or not
        if(totalfiles > 0 ){
            for (var i = 0; i < totalfiles; i++) {
                fd.append("corespondence_file_input_file_"+i, input_file.files[i]);
            }
            // fd.append('corespondence_file_input_file',files[0]);
            fd.append('id',id);
            fd.append('grantee_grant_id',grantee_grant_id);
            $.ajax({
                url: '<?php echo site_url('admin/college_placement/save_corespondence') ?>',
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    $('#btn-corespondence').prop('disabled', false);
                    $('#corespondence_file_input_file').val('');
                    $("#corespondence_file").modal('hide');   
                    // $('.wrap-corespondance').append(response.html);
                    $('#list_corespondance').append(response.html);
                    $('.lightbox').topbox();
                    // location.reload();
                    Swal.fire({
                        icon: "success",
                        title: "Successfully upload the file",
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
            });
        }else{
            alert("Please select a file.");
        }
    })

    function del_cores_file(el, item_class, id) {
        if (confirm("Are you sure want to delete this ?"))
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url('admin/college_placement/delete_corespondence') ?>/'+ id,
                dataType: 'JSON',
                success: function(r) {
                    if(r.success){
                        // $(el).closest('.' + item_class).remove();
                        $(el).closest('tr').remove();
                    }
                }
            });
    }

    function delete_file_placement(el, item_class, id, fields) {
        if (confirm("Are you sure want to delete this ?"))
            var currentTd = $('.final_placement_detail_'+id).closest("td");
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url('admin/college_placement/delete_file_placement') ?>/'+ id,
                dataType: 'JSON',
                success: function(r) {
                    if(r.success){
                        // currentTd.prev("td").text('');
                        // currentTd.prev("td").prev("td").text('');
                        // if(fields == 'final_placement_detail'){
                        //     currentTd.prev("td").prev("td").prev("td").text('');
                        // }
                        // $('.del-final-placement').remove();
                        // $('.download-final-placement').remove();
                        $(el).closest('tr').remove();
                    }
                }
            });
    }


    $('#is_final_placement').change(function(event, isTriggered) {
        var isChacked = 0;
        if($(this).is(':checked')) {
            isChacked = 1;
        } else {
            isChacked = 0;
        }
        if(!isTriggered){
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
        }
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/college_placement/set_final_placement') ?>',
            dataType: 'JSON',
            data:{
                is_final_placement: isChacked,
                grantee_grant_id: <?= $grantee_grant->id ?>
            },
            success: function(r) {
                if(!isTriggered){
                    location.reload();
                }
            }
        });
    });
    
    $('#university_id_select').change(function(){
        var id = $(this).val()
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/college_placement/get_detail_univ/') ?>' + id,
            dataType: 'JSON',
            success: function(r) {
                $('#country').val(r.country_name)
                $('#state').val(r.state_name)
                $('#city').val(r.city_name)
                // location.reload();
            }
        });
    })

    $('#btn-cancel').click(function(){
        Swal.fire({
            title   : "Are you sure you want to Cancel Final Placement?",
            icon    : "warning",
            showCancelButton    : true,
            confirmButtonColor  : "#3085d6",
            cancelButtonColor   : "#d33",
            confirmButtonText   : "Yes, submit",
            customClass         : 'swal-interview'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url('admin/college_placement/cancel_placement') ?>',
                    dataType: 'JSON',
                    data:{
                        grantee_grant_id: <?= $grantee_grant->id ?>
                    },
                    success: function(r) {
                        if(r.success){
                            location.href=r.redirect;
                        }
                    }
                });
            }
        });
    })

    $('#btn-departure').click(function(){
        Swal.fire({
            title   : "Are you sure you want to Set Departure?",
            icon    : "warning",
            showCancelButton    : true,
            confirmButtonColor  : "#3085d6",
            cancelButtonColor   : "#d33",
            confirmButtonText   : "Yes, submit",
            customClass         : 'swal-interview'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url('admin/college_placement/set_to_departure') ?>',
                    dataType: 'JSON',
                    data:{
                        grantee_grant_id: <?= $grantee_grant->id ?>
                    },
                    success: function(r) {
                        if(r.success){
                            Swal.fire({
                                icon: "success",
                                title: "Successfully Set to Departure",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    }
                });
            }
        });
    })

    $("#btn-toa_pre_academic").click(function(){
        var fd = new FormData();
        var files = $('#toa_pre_academic_file_input_file')[0].files;
        var id = $('#collage_placement_id').val();
        var grantee_grant_id = $('#grantee_grant_id').val();
        var deadline_date = $('#deadline_date_toa_pre_academic').val();
        $('#btn-toa_pre_academic').prop('disabled', true)


        // Check file selected or not
        if(files.length > 0 && deadline_date != ''){
            fd.append('toa_pre_academic_file_input_file',files[0]);
            fd.append('id',id);
            fd.append('grantee_grant_id',grantee_grant_id);
            fd.append('deadline_date',deadline_date);
            $.ajax({
                url: '<?php echo site_url('admin/college_placement/save_toa_pre_academic') ?>',
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    $('#btn-toa_pre_academic').prop('disabled', false);
                    $('#toa_pre_academic_file_input_file').val('');
                    $('#deadline_date_toa_pre_academic').val('');
                    $("#toa_pre_academic_file").modal('hide');   
                    // $('.wrap-toa_pre_academic').append(response.html);
                    $('#list_toa').append(response.html);
                    $('.lightbox').topbox();
                    // location.reload();
                },
            });
        }else{
            if(files.length == 0){
                alert("Please select a file.");
            } else if(deadline_date == '') {
                alert("Deadline is not null.");
            }
            $('#btn-toa_pre_academic').prop('disabled', false)
        }
    })

    function del_toa_pre_file(el, item_class, id) {
        if (confirm("Are you sure want to delete this ?"))
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url('admin/college_placement/delete_toa_pre_academic') ?>/'+ id,
                dataType: 'JSON',
                success: function(r) {
                    if(r.success){
                        $(el).closest('tr').remove();
                    }
                }
            });
    }

    function update_status_toa_pre_file(el, id, status) {
        if (confirm("Are you sure want to "+status+" this ?"))
            if(status == 'revise'){
                $('#mdl_note_revise').modal()
                $('#btn-save-note-pre').attr("onclick","update_status_toa_pre_file_action("+ id +", '"+ status +"')"); 
            }else{
                update_status_toa_pre_file_action(id, status);
            }
            // $.ajax({
            //     type: 'GET',
            //     url: '<?php echo site_url('admin/college_placement/update_status_toa_pre_academic') ?>/'+ id +'/' + status,
            //     dataType: 'JSON',
            //     success: function(r) {
            //         if(r.success){
            //             location.reload();
            //         }
            //     }
            // });
    }

    function update_status_toa_pre_file_action(id, status) {
        var note = $('#note_revise_toa_pre').val();
        var modal = $('#mdl_note_revise');
        var fileInput = modal.find('input[type="file"][name="temp_attachment_revise"]')[0] || modal.find('#temp_attachment_revise')[0];
        var btnSave = $('#btn-save-note-pre');

        var doSave = function(attachment_revise) {
            btnSave.html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/college_placement/update_status_toa_pre_academic') ?>',
                data: {
                    id: id,
                    status: status,
                    note: note,
                    attachment_revise: attachment_revise,
                    grantee_grant_id: <?= $grantee_grant->id ?>
                },
                dataType: 'JSON',
                success: function(r) {
                    if (r.success) {
                        location.reload();
                    } else {
                        btnSave.html('Save').prop('disabled', false);
                    }
                },
                error: function() {
                    btnSave.html('Save').prop('disabled', false);
                }
            });
        };

        if (status == 'revise' && fileInput && fileInput.files && fileInput.files.length > 0) {
            btnSave.html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop('disabled', true);
            let formData = new FormData();
            formData.append('attachment_revise', fileInput.files[0]);
            formData.append('type', 'attachment_revise');

            $.ajax({
                url: SITE_URL + 'admin/grantee/save_file',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'JSON',
                success: function(response) {
                    if (response.status) {
                        let paths = [];
                        if (response.files && response.files.length > 0) {
                            response.files.forEach(function(f) {
                                paths.push(f.filepath);
                            });
                        } else if (response.filepath) {
                            paths.push(response.filepath);
                        }
                        let paths_json = JSON.stringify(paths);
                        modal.find("input[name='attachment_revise']").val(paths_json);
                        doSave(paths_json);
                    } else {
                        btnSave.html('Save').prop('disabled', false);
                        alert(response.message || 'Failed to upload your file, please try again');
                    }
                },
                error: function(xhr, status, error) {
                    btnSave.html('Save').prop('disabled', false);
                    console.error(error);
                    alert('Failed to upload your file, please try again');
                }
            });
        } else {
            var attachment_revise = modal.find("input[name='attachment_revise']").val();
            doSave(attachment_revise);
        }
    }
    
    $("#btn-final_placement_detail").click(function(){
        var fd = new FormData();
        var files = $('#final_placement_detail_file')[0].files;
        var id = $('#collage_placement_id').val();
        $('#btn-final_placement_detail').prop('disabled', true)
        let currentTd = $('.final_placement_detail_'+id).closest("td");
        var input_file = document.getElementById('final_placement_detail_file'); 
        var totalfiles = input_file.files.length;
        var grantee_grant_id = $('#grantee_grant_id').val();


        // Check file selected or not
        if(totalfiles > 0 ){
            for (var i = 0; i < totalfiles; i++) {
                fd.append("final_placement_detail_file_"+i, input_file.files[i]);
            }
            // fd.append('final_placement_detail_file',files[0]);
            fd.append('grantee_grant_id',grantee_grant_id);
            fd.append('id',id);
            $.ajax({
                url: '<?php echo site_url('admin/college_placement/final_placement_detail') ?>',
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    // currentTd.append(response.html)
                    // currentTd.prev("td").text('');
                    // currentTd.prev("td").append(response.date);

                    // currentTd.prev("td").prev("td").text('');
                    // currentTd.prev("td").prev("td").append(response.ext);
                    
                    // currentTd.prev("td").prev("td").prev("td").text('');
                    // currentTd.prev("td").prev("td").prev("td").append(response.filename);
                    $('#btn-final_placement_detail').prop('disabled', false);
                    $('#final_placement_detail_file').val('');
                    $("#final_placement_detail").modal('hide');   
                    $("#list_final_placement_detail").append(response.html);   
                    $('.lightbox').topbox();
                    Swal.fire({
                        icon: "success",
                        title: "Successfully upload the file",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    // $('.wrap-toa_pre_academic').append(response.html);
                    // location.reload();
                },
            });
        }else{
            alert("Please select a file.");
            $('#btn-final_placement_detail').prop('disabled', false);
        }
    })

    $("#btn-toa_placement").click(function(){
        var fd = new FormData();
        var files = $('#toa_placement_input_file')[0].files;
        var id = $('#collage_placement_id').val();
        var grantee_grant_id = $('#grantee_grant_id').val();
        var deadline_date = $('#deadline_date_toa_placement').val();
        $('#btn-toa_placement').prop('disabled', true)


        // Check file selected or not
        if(files.length > 0 && deadline_date != ''){
            fd.append('toa_placement_input_file',files[0]);
            fd.append('id',id);
            fd.append('grantee_grant_id',grantee_grant_id);
            fd.append('deadline_date',deadline_date);
            $.ajax({
                url: '<?php echo site_url('admin/college_placement/save_toa_placement') ?>',
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    $('#btn-toa_placement').prop('disabled', false);
                    $('#toa_placement_input_file').val('');
                    $('#deadline_date_toa_placement').val('');
                    $("#toa_placement_file").modal('hide');   
                    $('#list_toa_placement').append(response.html);
                    $('.lightbox').topbox();
                },
            });
        }else{
            if(files.length == 0){
                alert("Please select a file.");
            } else if(deadline_date == '') {
                alert("Deadline is not null.");
            }
            $('#btn-toa_placement').prop('disabled', false)
        }
    })

    function del_toa_placement_file(el, item_class, id) {
        if (confirm("Are you sure want to delete this ?"))
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url('admin/college_placement/delete_toa_placement_academic') ?>/'+ id,
                dataType: 'JSON',
                success: function(r) {
                    if(r.success){
                        $(el).closest('tr').remove();
                    }
                }
            });
    }

    function update_status_toa_placement_file(el, id, status) {
        if (confirm("Are you sure want to "+ status+" this ?"))
            if(status == 'revise'){
                $('#mdl_note_revise_placement').modal()
                $('#btn-save-note-placement').attr("onclick","update_status_toa_placement_file_action("+ id +", '"+ status +"')"); 
            }else{
                update_status_toa_placement_file_action(id, status)
            }
    }

    function update_status_toa_placement_file_action(id, status) {
        var note = $('#note_revise_toa_placement').val();
        var modal = $('#mdl_note_revise_placement');
        var fileInput = modal.find('input[type="file"][name="temp_attachment_revise"]')[0] || modal.find('#temp_attachment_revise_placement')[0];
        var btnSave = $('#btn-save-note-placement');

        var doSave = function(attachment_revise) {
            btnSave.html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/college_placement/update_status_toa_placement_academic') ?>',
                data: {
                    id: id,
                    status: status,
                    note: note,
                    attachment_revise: attachment_revise,
                    grantee_grant_id: <?= $grantee_grant->id ?>
                },
                dataType: 'JSON',
                success: function(r) {
                    if (r.success) {
                        location.reload();
                    } else {
                        btnSave.html('Save').prop('disabled', false);
                    }
                },
                error: function() {
                    btnSave.html('Save').prop('disabled', false);
                }
            });
        };

        if (status == 'revise' && fileInput && fileInput.files && fileInput.files.length > 0) {
            btnSave.html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop('disabled', true);
            let formData = new FormData();
            formData.append('attachment_revise', fileInput.files[0]);
            formData.append('type', 'attachment_revise');

            $.ajax({
                url: SITE_URL + 'admin/grantee/save_file',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'JSON',
                success: function(response) {
                    if (response.status) {
                        let paths = [];
                        if (response.files && response.files.length > 0) {
                            response.files.forEach(function(f) {
                                paths.push(f.filepath);
                            });
                        } else if (response.filepath) {
                            paths.push(response.filepath);
                        }
                        let paths_json = JSON.stringify(paths);
                        modal.find("input[name='attachment_revise']").val(paths_json);
                        doSave(paths_json);
                    } else {
                        btnSave.html('Save').prop('disabled', false);
                        alert(response.message || 'Failed to upload your file, please try again');
                    }
                },
                error: function(xhr, status, error) {
                    btnSave.html('Save').prop('disabled', false);
                    console.error(error);
                    alert('Failed to upload your file, please try again');
                }
            });
        } else {
            var attachment_revise = modal.find("input[name='attachment_revise']").val();
            doSave(attachment_revise);
        }
    }


    $(".modal-log-toa-placement").click(function(e){
        var data_id = $(this).data('log')
        var type = $(this).data('type')
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/college_placement/get_log_toa_placement') ?>',
            dataType: 'JSON',
            data:{
                id: data_id,
                table: type == 'placement' ? 'am_toa_placement_file' : 'am_toa_pre_academic_file'
            },
            success: function(r) {
                $("#model-payment-log tbody").html("");
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
                if(key == 'file' || key == 'file_grantee'){
                    if(value != ''){
                        value = '<a href="'+SITE_URL+value+'" class="lightbox btn btn-primary btn-xs">View</a>'
                    }
                }
                if(key == 'grantee_grant_id' || key == 'collage_placement_id' || key == 'filename_grantee'){
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
                if(key == 'file' || key == 'file_grantee'){
                    if(value != ''){
                        value = '<a href="'+SITE_URL+value+'" class="lightbox btn btn-primary btn-xs">View</a>'
                    }
                }
                if(key == 'grantee_grant_id' || key == 'collage_placement_id' || key == 'filename_grantee'){
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

    
    function show_preview_attch(element, type, upload_type) {
        const file = element.files[0];
        let modal = $(element).closest('.modal');
        let previewEl = modal.find('.uploaded_attachment_admin, .uploaded_attachment');

        if (!file) {
            previewEl.addClass('hide').html('');
            modal.find("input[name='" + upload_type + "']").val('');
            return;
        }

        let file_url = URL.createObjectURL(file);
        if (previewEl.is('a')) {
            previewEl.attr('href', file_url)
                     .removeClass('hide')
                     .html('<b><i class="fa fa-paperclip"></i> ' + file.name + '</b>');
        } else {
            previewEl.removeClass('hide').html(`
                <div>
                    <a href="${file_url}" target="_blank">
                        <b><i class="fa fa-paperclip"></i> ${file.name}</b>
                    </a>
                </div>
            `);
        }
    }

    $('#mdl_note_revise').on('hidden.bs.modal', function () {
        $(this).find('input[type="file"]').val('');
        $(this).find('input[name="attachment_revise"]').val('');
        $(this).find('.uploaded_attachment_admin, .uploaded_attachment').addClass('hide').html('');
        $(this).find('#note_revise_toa_pre').val('');
        $('#btn-save-note-pre').html('Save').prop('disabled', false);
    });

    $('#mdl_note_revise_placement').on('hidden.bs.modal', function () {
        $(this).find('input[type="file"]').val('');
        $(this).find('input[name="attachment_revise"]').val('');
        $(this).find('.uploaded_attachment_admin, .uploaded_attachment').addClass('hide').html('');
        $(this).find('#note_revise_toa_placement').val('');
        $('#btn-save-note-placement').html('Save').prop('disabled', false);
    });


    // $('.span-note').click(function(){
    //     var note = $(this).data('note');
    //     var attach = $(this).data('attach');
    //     $('.note-note').val(note)
    //     if(attach){
    //         $('#attach_revise').attr('href', SITE_URL + attach)
    //         $('#attach_revise').removeClass('hide')
    //     }else{
    //         $('#attach_revise').addClass('hide')
    //     }
    // })

    function emptyValue(object) {
        $(object).closest('.form-group').find('.datepicker').val('');
    }

    function change_grantee_update(el, id) {
        var isChecked = $(el).is(':checked') ? 0 : 1;
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/college_placement/grantee_update') ?>',
            dataType: 'JSON',
            data:{
                grantee_update: isChecked,
                id: id
            },
            success: function(r) {
                showSwal('success', 'Successfully changed', false, true, 1500);
            }
        });
    }

    function change_update_preact(el, id) {
        var isChecked = $(el).is(':checked') ? 0 : 1;
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/college_placement/update_preact') ?>',
            dataType: 'JSON',
            data:{
                update_preact: isChecked,
                id: id
            },
            success: function(r) {
                showSwal('success', 'Successfully changed', false, true, 1500);
            }
        });
    }
    
    // function show_preview_attachment(element, type, upload_type) {
    //     const file = element.files[0];
    //     $('#btn-save-note-withdraw').html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop( 'disabled', true );
    //     let formData = new FormData();
    //     formData.append(upload_type, file);
    //     formData.append('type', upload_type);

    //     $.ajax({
    //         url: SITE_URL + 'admin/grantee/save_file', 
    //         type: 'POST',
    //         data: formData,
    //         processData: false,
    //         contentType: false,
    //         dataType : 'JSON',
    //         success: function(response) {
    //             if (response.status) {
    //                 render_data_upload_attach(response, upload_type);
    //             } else {
    //                 $(".uploaded_attachment").addClass('hide');
    //                 showSwal('error', response.message, false, true, 2000);
    //                 // alert('Failed to upload your file, please try again');
    //             }

    //             $('#btn-save-note-withdraw').html('Save').prop( 'disabled', false );
    //         },
    //         error: function(xhr, status, error) {
    //             $('#btn-save-note-withdraw').html('Save').prop( 'disabled', false );
    //             console.error(error); 
    //         }
    //     });
    // }
</script>