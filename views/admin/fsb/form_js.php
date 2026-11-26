<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<script>
    const SITE_URL = '<?php echo site_url(); ?>';
    $(document).ready(function(){
        $("#fiscal_year").trigger('change');
    });

    $("#fiscal_year").change(function() {
        var grants = '#grants';
        var load = '#load-grants';
        var dataGrant = [<?= $data->user_grantee_grant_id ?>];
        console.log(dataGrant)
        if(this.value == ''){
            $(grants).html('');
            return false;
        }
        $(load).show();
        $(grants).html('');
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/fsb/get_active_grant') ?>/' + this.value,
            dataType: 'JSON',
            success: function(r) {
                $.each(r, function(id, val) {
                    var selected = '';
                    if(jQuery.inArray(parseInt(val.id), dataGrant) !== -1) {
                        selected = 'selected';
                    }
                    $(grants).append('<option '+selected+' value="' + val.id + '">' + val.name + '</option>');
                });
                $(load).hide();
                $(".validation-error-fiscal").css('display', 'none');
            }
        });
    });

    $("#grants").change(function(){
        var grant_id = $("#grants").val(); 
        var fiscal_year = $("#fiscal_year").val(); 
        var load = '#load-list';
        $(load).show();
        $(".wrap-table-list").html('');
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/fsb/get_list_participant') ?>',
            data: {
                grant_id : grant_id,
                fiscal_year : fiscal_year
            },
            dataType: 'JSON',
            success: function(r) {
                $(".wrap-table-list").append(r)
                $(load).hide();
                $('.chk-all').on('click', function(event){
                    $(this).parents('table').find('.chk-row').prop('checked', this.checked);
                });
            }
        });
    });

    $( ".datepicker" ).datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd M yy",
        yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
    });

    $(".btn-s-pdo").click(function(){
        var fiscal = $("#fiscal_year").val();
        if(fiscal == ''){
            $(".validation-error-fiscal").css('display', 'block');
            $(".validation-error-fiscal").focus();
            return false;
        }
        $(".btn-s-pdo").html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop('disabled', true);
        $("#form").submit();
        setTimeout(function(){ window.location = "<?= base_url('admin/fsb/manage') ?>" }, 3000);
    })
    

    $(".btn-s-pdo-edit").click(function(){
        var fiscal = $("#fiscal_year").val();
        if(fiscal == ''){
            $(".validation-error-fiscal").css('display', 'block');
            $(".validation-error-fiscal").focus();
            return false;
        }
        $(".btn-s-pdo-edit").html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop('disabled', true);
        $("#form").submit();
        setTimeout(function(){ window.location = "<?= base_url('admin/fsb/manage') ?>" }, 3000);
    })

    $(".succesfully").click(function(){
        let status = $(this).data('status') || 0;
        var id = $(this).data('id');

        if(!status){
            Swal.fire({
                title: "Unable to set as nominee.",
                text: "Please ensure the candidate has accepted the AMINEF Terms & Conditions.",
                icon: "warning",
                customClass: 'swal-custom'
            });
            return false;
        }

        $("#mdl_info").modal();   
        $('#btn-successful').attr("onclick","succesfully("+ id +")"); 
        event.preventDefault();
    });

    function succesfully(grantee_grant_id)
    {
        $('#btn-successful').html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop( 'disabled', true );
        $.ajax({
                url: "<?= base_url(); ?>admin/fsb/successfully",
                method: "POST",
                dataType: 'JSON',
                data: {
                    grantee_grant_id: grantee_grant_id
                }
            })
            .success(function(data){
                window.location.href = data.redirect;
            })
    }

function show_preview(element, type, upload_type) {
    const file = element.files[0];
    $('#btn-save-note-withdraw').html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop('disabled', true);
    let formData = new FormData();
    formData.append(upload_type, file);
    formData.append('type', upload_type);

    $.ajax({
        url: SITE_URL + 'admin/grantee/save_file',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'JSON',
        success: function(response) {
            if (response.status) {
                render_data_upload_attach(response, upload_type);
                // let file_url = SITE_URL + response.filepath;
                // $(".uploaded_attachment").attr('href', file_url).removeClass('hide').html('<b> <i class="fa fa-paperclip"></i> ' + response.filename) + '</b>';
                // $("input[name='" + upload_type + "']").val(response.filepath);
            } else {
                $(".uploaded_attachment").addClass('hide');
                alert('Failed to upload your file, please try again');
            }

            $('#btn-save-note-withdraw').html('Save').prop('disabled', false);
        },
        error: function(xhr, status, error) {
            $('#btn-save-note-withdraw').html('Save').prop('disabled', false);
            console.error(error);
        }
    });
}
</script>