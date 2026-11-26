<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<script>
    $(function(){
        $('#mdl_detail_leave').on('show.bs.modal', function(event) {
            $.fn.modal.Constructor.prototype.enforceFocus = function() {

                var button = $(event.relatedTarget);
                var leaveId = button.data('leave-id');

                if (typeof currentLeaveApps !== 'undefined') {
                    var data = currentLeaveApps[leaveId];
                    var baseUrl = '<?= base_url() ?>';
                    $("#leave_id").val(data.id);
                    
                    if(data.category_name != null) {
                        $("#leave_category").val(data.category_name).closest('div.form-group').removeClass('hide');
                    } else {
                        $("#leave_category").val('').closest('div.form-group').addClass('hide');
                    }

                    if(data.total_request != null) {
                        $("#leave_day").val(data.total_request + ' Day').closest('div.form-group').removeClass('hide');
                    } else {
                        $("#leave_day").val('').closest('div.form-group').addClass('hide');
                    }

                    if(data.start_date != null) {
                        $("#start_date").val($.datepicker.formatDate( "d M yy", new Date(data.start_date))).closest('div.form-group').removeClass('hide');
                    } else {
                        $("#start_date").val('').closest('div.form-group').addClass('hide');
                    }

                    if(data.end_date != null) {
                        $("#end_date").val($.datepicker.formatDate( "d M yy", new Date(data.end_date))).closest('div.form-group').removeClass('hide');
                    } else {
                        $("#end_date").val('').closest('div.form-group').addClass('hide');
                    }

                    if(data.status != null) {
                        $("#status").val(data.status).prop('disabled', true).closest('div.form-group').removeClass('hide');
                    } else {
                        $("#status").val('').closest('div.form-group').addClass('hide');
                    }

                    if(data.telephone != null && data.telephone !== '') {
                        $("#telephone_val").val(data.telephone).closest('div.form-group').removeClass('hide');
                    } else {
                        $("#telephone_val").val('').closest('div.form-group').addClass('hide');
                    }

                    if(data.email != null && data.email !== '') {
                        $("#email_val").val(data.email).closest('div.form-group').removeClass('hide');
                    } else {
                        $("#email_val").val('').closest('div.form-group').addClass('hide');
                    }

                    if(data.address != null && data.address !== '') {
                        $("#address_val").val(data.address).closest('div.form-group').removeClass('hide');
                    } else {
                        $("#address_val").val('').closest('div.form-group').addClass('hide');
                    }

                    if(data.destination_purpose != null && data.destination_purpose !== '') {
                        $("#destination_purpose").val(data.destination_purpose).closest('div.form-group').removeClass('hide');
                    } else {
                        $("#destination_purpose").val('').closest('div.form-group').addClass('hide');
                    }

                    if(data.destination != null && data.destination !== '') {
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
                    
                    if(data.form_upload == null){
                        $("#form_upload_file").addClass('hide')
                    }else{
                        $("#form_upload_file").removeClass('hide').attr("href", baseUrl+data.form_upload)
                    }

                    if(data.boarding_pass == null){
                        $("#borading_pass_file").addClass('hide')
                    }else{
                        $("#borading_pass_file").removeClass('hide').attr("href", baseUrl+data.boarding_pass)
                    }

                    if(data.departure_time != null){
                        $("#departure_time").val(data.departure_time).closest('div.form-group').removeClass('hide');
                    }else{
                        $("#departure_time").val('').closest('div.form-group').addClass('hide');
                    }

                    if(data.note != null){
                        $("#note").val(data.note).closest('div.form-group').removeClass('hide');
                    }else{
                        $("#note").val('').closest('div.form-group').addClass('hide');
                    }

                    $('.lightbox').topbox();
                }
            };
        });

    });
    function update_status_leave(leave_id)
    {

        if (confirm('Are you sure to cancel ?')) {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('grantee/leaves/edit_status_leave') ?>',
                data: {
                    id : leave_id,
                },
                success: function(r) {
                    window.location.href = r.redirect;
                }
            });
        }

    }

    function show_boarding(leave_id) {
        $.ajax({
            url: "<?= base_url('grantee/leaves/getBoardingPass/') ?>" + leave_id, // Ganti dengan URL yang sesuai
            method: "GET",
            success: function (data) {
                // Memuat data tabel ke dalam modal
                $("#leave_id_modal").val(leave_id);
                $("#mdl_boarding").modal("show");
                $("#tableContainer").html(data);
                $('.lightbox').topbox();
            },
            error: function () {
                alert("Gagal memuat data tabel.");
            },
        });
    }
    
    function appendDataToTable(data) {
        console.log(data)
        const tableBody = $('#data_table tbody');
        var table = '';
        table += '<tr>'
        table += '<td><a class="lightbox" href="<?= base_url() ?>'+ data.file +'">' + data.file_name + '</a></td>'
        table += '<td>' + data.date + '</td>'
        table += '</tr>'
        
        tableBody.append(table);
    }

    function show_boarding_preview(element) {
        if (!element || !element.files || element.files.length === 0) return;
        
        const file = element.files[0];
        const filetype = (file.name.split('.').pop() || '').toLowerCase();
        const allowed_extensions = ['jpg', 'jpeg', 'png', 'pdf', 'heic'];

        const is_valid_extension = allowed_extensions.includes(filetype);

        if (!is_valid_extension) {
            alert('Unsupported file type. Supported: JPG, JPEG, PNG, PDF, HEIC');
            try { $(element).val(''); } catch (e) {}
            return false;
        }

        document.getElementById('boarding_pass_filename').textContent = file.name;

        const reader = new FileReader();
        
        reader.onload = function(e) {
            const previewImg = document.getElementById('preview_image_boarding_pass');
            
            if (filetype === 'pdf' || filetype === 'heic') {
                previewImg.src = '<?= base_url('assets/images/icons/document-filetype.png') ?>';
            } else if (['jpg', 'jpeg', 'png'].includes(filetype)) {
                previewImg.src = e.target.result;
            }
        };
        
        reader.readAsDataURL(file);
        
        upload_boarding_pass();
    }

    function upload_boarding_pass() {
        const boarding_pass = document.getElementById('boarding_pass');
        const file = boarding_pass.files[0];
        
        if (!file) {
            alert('Boarding Pass is required!')
            return false;
        }

        $("#loading_borading").css("display", "inline-block");

        const formData = new FormData();
        formData.append('leave_id', $('#leave_id_modal').val());
        formData.append('file', file);

        $.ajax({
            url: '<?= base_url('grantee/leaves/uploadBoardingPass/') ?>',
            type: 'POST',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'JSON',
        })
        .done(function(res) {
            appendDataToTable(res);
            $("#loading_borading").css("display", "none");
            $('#boarding_pass').val('');
            document.getElementById('preview_image_boarding_pass').src = '<?= base_url('assets/images/icons/document-filetype.png') ?>';
            document.getElementById('boarding_pass_filename').textContent = '';
            $('.lightbox').topbox();
        })
        .fail(function() {
            $("#loading_borading").css("display", "none");
            alert('Failed to upload boarding pass. Please try again.');
        });
    }
</script>
