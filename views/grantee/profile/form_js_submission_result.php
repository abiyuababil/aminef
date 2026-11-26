<script>
    $(".btn-choose").click(function(){
        var id = $(this).data('id');
        var uName = $(this).data('u-name');
        var directFlag = $(this).data('flag');
        var grantee_grant_id = $(this).data('grantee_grant_id');
        var sortfall = $(this).data('sortfall');
        $("#sortfall_radio").val(sortfall);
        $("#mdl_confirm").modal();
        $("#mdl_date").modal('hide');
        $("#u-name").html(uName);
        $('#btn-yes').attr("onclick","choose(" + id + ", \"" + directFlag + "\", \"" + uName + "\", "+ grantee_grant_id +")"); 
        $(".btn-disabled").prop("disabled", true);
        $("#radioShortfall_false, #radioShortfall_true").prop("checked", false);
        $("#radioShortfall_false, #radioShortfall_true").prop("disabled", true);
        setTimeout( function(){ 
            $("#radioShortfall_false, #radioShortfall_true").prop("disabled", false);
            if(sortfall != ''){
                $(".btn-disabled").prop("disabled", true);
                $("#btn-yes").prop("disabled", true);
            }else{
                $(".btn-disabled").prop("disabled", true);
                // $("#btn-yes").prop("disabled", false);
            }
        }  , 11000 );
        setTimeout(countdown, 1000);
        timeLeft = 11;
    });

    function setButtonConfirm(el)
    {
        sortFall = $('#sortfall_radio').val();
        value = $(el).val();

        if(sortFall !== ''){
            if(value == 1){
                $('.btn-disabled').prop('disabled', false)
            }else{
                $('.btn-disabled').prop('disabled', true)
            }
        }else{
            if(value == 1){
                $('.btn-disabled').prop('disabled', true)
            }else{
                $('.btn-disabled').prop('disabled', false)
            }

        }
    }

    function countdown() {
        timeLeft--;
        document.getElementById("seconds").innerHTML = '(' + String( timeLeft ) + ")";
        if (timeLeft > 0) {
        setTimeout(countdown, 1000);
        }else{
            document.getElementById("seconds").innerHTML = '';
            // $("#btn-yes").prop("disabled", false);
        }
    }

    function choose(id, directFlag, univName, grantee_grant_id) {
        var withSortfall = $('input[name="radioShortfall"]:checked').val();
        $(".btn-disabled").prop("disabled", true);
        $("#btn-yes").html('<img src="<?php echo base_url() ?>/img/loading.gif">');
        console.log(withSortfall)

        if(withSortfall == 1){
            location.href= '<?=base_url()?>grantee/profile/upload_bank_statement/'+ grantee_grant_id +'/' + id + '/'+ directFlag;
        }else{
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('grantee/profile/choose_university/') ?>',
                data: {
                    id : id,
                    flag: directFlag,
                    univName: univName
                },
                dataType: 'JSON',
                success: function(r) {
                    if(r.success){
                        location.href=r.redirect;
                    }
                }
            });
        }
    }

    $("#btn-allowance").click(function(){
        actual_settling = $("#actual-settling").val().replace(',', '');
        actual_technology = $("#actual-technology").val().replace(',', '');
        total_allowance = $("#total-allowance").val().replace(',', '');
        if(actual_settling == ''){
            actual_settling = 0
        }
        if(actual_technology == ''){
            actual_technology = 0
        }
        $("#load-allowance").css('display', 'inline-block');
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('grantee/profile/submit_allowance/') ?>',
            data: {
                actual_settling : actual_settling,
                actual_technology: actual_technology
            },
            dataType: 'JSON',
            success: function(r) {
                if(r.success){
                    total = parseInt(actual_settling) + parseInt(actual_technology);

                    if(total != 0){
                        $("#actual-total").val(
                            total
                            .toString()
                            .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                        );
                    }

                    overpaid = total - total_allowance;
                    $("#overpaid").val(
                        overpaid
                        .toString()
                        .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                        .replace('-', '')
                    );
                    $("#load-allowance").css('display', 'none');
                    $("#success-alert").fadeTo(5000, 500).slideUp(500, function() {
                    $("#success-alert").slideUp(500);
            });
                }
            }
        });
    });

    $('input.actual').keyup(function(event) {
        // skip for arrow keys
        if(event.which >= 37 && event.which <= 40) return;

        // format number
        $(this).val(function(index, value) {
        return value
        .replace(/\D/g, "")
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        ;
        });
    });

    
    $("#btn-invoice").click(function(){ 
        var icon = $("#load-upload"); 
        var input_file = document.getElementById('input-file'); 
        var base_url   = "<?= base_url()?>";
        var grantee_grant_id = <?= $this->session->userdata('grantee_grant_id') ?>;
        
        // define value form data
        var formData = new FormData();
        var totalfiles = input_file.files.length;
        console.log(totalfiles)
        if(totalfiles == 0){
            return false
        }
        icon.css('display', 'inline-block')
        $("#btn-invoice").prop('disabled', true)
        for (var i = 0; i < totalfiles; i++) {
            formData.append("file_"+i, input_file.files[i]);
        }
        formData.append("grantee_grant_id", grantee_grant_id)

        // autosave
        $.ajax({
            url: "<?= base_url(); ?>grantee/profile/add_invoice_allowance", 
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false
        }).done(function(r){
            var result = $.parseJSON(r);
            console.log(result.data)
            $("#btn-invoice").prop('disabled', false)
            for (var i = 0; i < result.data.length; i++) {
                var nameFile = result.data[i].file_name;
                var urlFile = result.data[i].file_url;
                var formatFile = result.data[i].file_format;
                var idInvoice = result.data[i].id;
                if(formatFile == 'pdf'){
                    urlFile = 'assets/images/icons/pdf.svg'
                }
                if(nameFile.length > 15){
                    nameFile = nameFile.substring(0, 15) + '...';
                }
                var html = '';
                    html += '<div class="col-lg-3 img-col" style="height: 150px;">';
                    html += '<img height="100" src="<?= base_url()?>'+urlFile+'">';
                    html += '<a href="javascript:;" class="btn btn-danger btn-xs" style="position:absolute; top:25px;" onclick="del_item(this, \'img-col\', '+idInvoice+')">';
                    html += '<i class="fa fa-trash fa-fw text-white"></i>';
                    html += '</a>';
                    html += '<a href="<?= base_url()?>'+urlFile+'" download title="Click to download" class="btn btn-primary btn-xs" style="position:absolute; top:0; ">';
                    html += '<i class="fa fa-download fa-fw text-white"></i>';
                    html += '</a>';
                    html += '<p class="filename" style="font-size:16px;cursor:pointer;" data-toggle="tooltip" data-placement="left" title="'+result.data[i].file_name+'">'+nameFile+'</p>';
                    html += '</div>';

                $(".wrap-invoice").append(html);
                $("#input-file").val('');
                icon.css('display', 'none')
            }
        });
    });
    

    function del_item(el, item_class, id) {
    if (confirm("Are you sure want to delete this ?"))
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('grantee/profile/delete_invoice_allowance') ?>/'+ id,
            dataType: 'JSON',
            success: function(r) {
                if(r.success){
                    $(el).closest('.' + item_class).remove();
                }
            }
        });
    }


    $('.btn-withdrawn').click(function(){
        var id = $(this).data('id');
        var directFlag = $(this).data('flag');
        var university = $(this).data('university');
        Swal.fire({
            title   : "Are you sure that you want to Reject from <br />" + university + "?",
            icon    : "warning",
            showCancelButton    : true,
            confirmButtonColor  : "#3085d6",
            cancelButtonColor   : "#d33",
            confirmButtonText   : "Yes, submit",
            customClass         : 'swal-interview'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'GET',
                    url: '<?php echo site_url('grantee/profile/withdrawn_result') ?>/'+ id + '/' + directFlag,
                    dataType: 'JSON',
                    success: function(r) {
                        if(r.success){
                            location.href=r.redirect;
                        }
                    }
                });
            }
        });
    });


    $("button[data-target='#upload_grantee_toa']").click(function() {
        var id = $(this).data('id');
        console.log(id)
        $('#toa_id').val(id)
    });
    
    $("#btn-upload_toa_grantee").click(function(){
        var fd = new FormData();
        var files = $('#upload_to_grantee_file')[0].files;
        var id = $('#toa_id').val();
        $('#btn-upload_toa_grantee').prop('disabled', true)
        let currentTd = $('.upload_grantee_toa_'+id).closest("td");


        // Check file selected or not
        if(files.length > 0 ){
            fd.append('upload_to_grantee_file',files[0]);
            fd.append('id',id);
            $.ajax({
                url: '<?php echo site_url('grantee/placement/upload_toa_grantee') ?>',
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    $('.upload_grantee_toa_'+id).remove();
                    $('.btn-reject-toa-preact-'+id).remove();
                    currentTd.prev("td").prev("td").text('');
                    currentTd.prev("td").text(response.created_date);
                    currentTd.prev("td").prev("td").append(response.filename);
                    currentTd.prev("td").prev("td").prev("td").text(response.status);
                    $('#btn-upload_toa_grantee').prop('disabled', false);
                    $('#upload_to_grantee_file').val('');
                    $("#upload_grantee_toa").modal('hide');   
                    $('#list_toa').append(response.html);
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
            $('#btn-upload_toa_grantee').prop('disabled', false);
        }
    })
    
    $("button[data-target='#upload_grantee_toa_placement']").click(function() {
        var id = $(this).data('id');
        console.log(id)
        $('#toa_placement_id').val(id)
    });
    
    $("#btn-upload_toa_grantee_placement").click(function(){
        var fd = new FormData();
        var files = $('#upload_to_grantee_file_placement')[0].files;
        var id = $('#toa_placement_id').val();
        $('#btn-upload_toa_grantee_placement').prop('disabled', true)
        let currentTd = $('.upload_grantee_toa_placement_'+id).closest("td");


        // Check file selected or not
        if(files.length > 0 ){
            fd.append('upload_to_grantee_file_placement',files[0]);
            fd.append('id',id);
            $.ajax({
                url: '<?php echo site_url('grantee/placement/upload_toa_grantee_placement') ?>',
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    currentTd.prev("td").prev("td").text('');
                    currentTd.prev("td").text(response.created_date);
                    currentTd.prev("td").prev("td").append(response.filename);
                    currentTd.prev("td").prev("td").prev("td").text(response.status);
                    $('#btn-upload_toa_grantee_placement').prop('disabled', false);
                    $('#upload_to_grantee_file_placement').val('');
                    $("#upload_grantee_toa_placement").modal('hide');   
                    $('#list_toa_placement').append(response.html);
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
            $('#btn-upload_toa_grantee_placement').prop('disabled', false);
        }
    })




    $('#btn-placement').click(function(){  
        event.preventDefault();// Validasi field required
        let isValid = true;
        let requiredFields = $('form#form_placement [required], [required][form="form_placement"]');
        requiredFields.each(function() {
            if (!$(this).val().trim()) {
                isValid = false;
                $(this).focus();; // Optional: Tambahkan class bootstrap
            }
        });

        if (!isValid) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please fill out all required fields!'
            });
            return;
        }

        Swal.fire({
            title   : "Are you sure that you want to save?",
            icon    : "warning",
            showCancelButton    : true,
            confirmButtonColor  : "#3085d6",
            cancelButtonColor   : "#d33",
            confirmButtonText   : "Yes, submit",
            customClass         : 'swal-interview'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form_placement').submit();
            }
        });
    });

    $('#btn-placement-preac').click(function(){  
        event.preventDefault();
        Swal.fire({
            title   : "Are you sure that you want to save?",
            icon    : "warning",
            showCancelButton    : true,
            confirmButtonColor  : "#3085d6",
            cancelButtonColor   : "#d33",
            confirmButtonText   : "Yes, submit",
            customClass         : 'swal-interview'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form_placement_preac').submit();
            }
        });
    });



    function grantee_update_status_toa_pre_file(el, id, status) {
        if (confirm("Are you sure want to "+status+" this ?"))
            if(status == 'reject'){
                $('#mdl_note_reject').modal()
                $('#btn-save-note-reject').attr("onclick","grantee_update_status_toa_pre_file_action("+ id +", '"+ status +"')"); 
            }else{
                grantee_update_status_toa_pre_file_action(id, status);
            }
    }

    function grantee_update_status_toa_pre_file_action(id, status) {
        var note = $('#note_reject_toa_pre').val()
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('grantee/placement/grantee_update_status_toa_pre_academic') ?>',
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

    $('.li-final a').click(function(){
        var href = $(this).attr('href');
        window.location.hash = href;
    });


    $(document).ready(function(){
            default_active_tab();
    });

    function default_active_tab() {
        let current_step = location.hash;
        
        if(current_step) {
            // let section = current_step.replace('#', '');
            // $(current_step).addClass('active in');
            // $('#li-'+section).addClass('active');
            // let first_tab = $('.first').attr('id');
            // if (first_tab != section) {
            //     $("#" + first_tab).removeClass('active in');
            //     $(".first_tab").removeClass('active');
            // }

            let section = current_step.replace('#', '');

            // Hapus 'active' dari semua elemen tab sebelumnya
        $('.tab-content .tab-pane').removeClass('active in');
        $('.nav-pills .li-final').removeClass('active');

            // Tambahkan 'active' ke tab dan li yang sesuai dengan hash
            $(current_step).addClass('active in');
            $('#li-' + section).addClass('active');

            // Jika hash bukan tab pertama, nonaktifkan tab pertama
            let first_tab = $('.first').attr('id');
            if (first_tab != section) {
                $("#" + first_tab).removeClass('active in');
                $(".first_tab").removeClass('active');
            }
        }
    }

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

    $(document).on('click', '.btn-univ-detail', function() {
        $('#m_degree').text($(this).data('degree'));
        $('#m_major').text($(this).data('major'));
        $('#m_credit').text($(this).data('credit'));
        $('#m_duration').text($(this).data('duration'));
        $('#m_specialization').text($(this).data('specialization'));

        $('#modalUniv').modal('show');
    });

    // Klik tombol Upload LOI
    $(document).on('click', '.btn-upload-loi', function () {
        let id = $(this).data('id');

        let $input = $('<input>', {
            type: 'file',
            accept: 'application/pdf',
            style: 'display:none'
        });

        $('body').append($input);

        $input.on('change', function () {
            let file = this.files[0];

            if (!file) {
                $input.remove();
                return;
            }

            let formData = new FormData();
            formData.append('loi_file', file);
            formData.append('id', id);

            let $button = $('.btn-upload-loi[data-id="' + id + '"]');

            $.ajax({
                url: '<?= base_url("grantee/placement/upload_loi") ?>',
                type: 'POST',
                data: formData,
                dataType: 'JSON',
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $button.prop('disabled', true).text('Uploading...');
                },
                success: function (response) {
                    if (response.status) {
                        Swal.fire({
                            icon: "success",
                            title: "Data has been update",
                            showConfirmButton: false,
                            timer: 1500
                        }).then((result) => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Failed', response.message, 'error');
                        $button.prop('disabled', false).text('Upload');
                    }
                },
                error: function (xhr) {
                    Swal.fire(
                        'Error',
                        'Something went wrong while uploading the file.',
                        'error'
                    );

                    $button.prop('disabled', false).text('Upload');
                },
                complete: function () {
                    $input.remove();
                }
            });
        });

        $input.trigger('click');
    });
</script>