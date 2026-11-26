<?php
/**
 * @author Firman Sepdiansyah
 * @createddate May 09, 2019
 * mailto: sepdiansyah@yahoo.com; firman.sepdiansyah@gmail.com for more information
 */
?>

<script>
    $(document).ready(function () {
//        $('#mdl_edit').on('shown.bs.modal', function () {
//            $('#ex_program_id').val($('#btn_change').data('id'));
//        })
        $('.btn_change').on('click', function () {
            var p_id = $(this).data('id');
            var grantee_grant_id = $(this).data('granteegrantid');

            $('#mdl_edit').on('shown.bs.modal', function () {
                $('#grantee_grant_id').val(grantee_grant_id);
                $('#ex_program_id').val(p_id);
                $('#new_program_id').val(p_id).change();
            })
        });
        $('.btn_change_status').on('click', function () {
            var id = $(this).data('id');
            var status = $(this).data('status');
            console.log(id);
            $('#mdl_update_status').on('shown.bs.modal', function () {
                $('#id').val(id);
                $('#status').val(status).change();
            })
        });
        <?php if (get_active_country(true) == INDONESIAN_DATABASE) { ?>
            $("#program_id").change(function(){
                var grant_id = $(this).val();
                $.ajax({
                    type: 'GET',
                    url: "<?= base_url('admin/grantee/get_period_by_grant_id'); ?>",
                    data: {grant_id: grant_id},
                    dataType: 'JSON',
                    success: function(r) {
                        $("#period_id").find('option').remove().end().append('<option value="">--Chose one--</option>');
                        if (r.length > 0){
                            r.forEach(function(value){
                                $("#period_id").append($("<option></option>")
                                .attr("value", value.id)
                                .text(value.fiscal_year))
                            })
                        }
                    }
                });
            })
            <?php } else {?>
                $("#program_id").change(function(){
                    var year = $(this).find(':selected').attr('data-year');
                    if(year == ''){
                        Swal.fire({
                            icon: "error",
                            title: "Please set Year in Active grant!",
                            showConfirmButton: false,
                            timer: 2500
                        });
                        $(this).val('')
                        return false;
                    }
                    $('#year').val(year);
                    console.log(year)
                })
        <?php } ?>
    });

    // $("#form-submit").on('submit', function(e){
    //     var grantee_id = <?= $this->Grantee_ent_model->id ?>;
    //     var resultAjax = function() {
    //         var result = null;
    //         $.ajax({
    //             async: false,
    //             type: 'GET',
    //             url: "<?= base_url('admin/grantee/check_active_grantee'); ?>",
    //             data: {grantee_id: grantee_id},
    //             dataType: 'JSON',
    //             success: function(r) {
    //                 if(r.success == false){
    //                     $("#grant_name").html(r.data.grant_name);
    //                     $(".alert-danger").removeClass('hide');
    //                 }
    //                 result = r.success;
    //             }
    //         });
    //         return result;
    //     }();

    //     if(resultAjax == false){
    //         e.preventDefault();
    //     }
    // })
</script>