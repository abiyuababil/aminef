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

            $('#mdl_edit').on('shown.bs.modal', function () {
                $('#ex_program_id').val(p_id);
                $('#new_program_id').val(p_id).change();
            })
        });
    })
</script>