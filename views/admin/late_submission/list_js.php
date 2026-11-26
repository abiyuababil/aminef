<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<script>
    $(document).ready(function () {
        $( ".datepicker" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd M yy",
            yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
        });
        $(".datetime").datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            autoclose: true,
        });

        $('.select2').select2({
            theme: 'bootstrap'
        });

        $("#btn-submit").click(function (e) {
            e.preventDefault()
            if($('.chk-row:checked').length == 0) {
                alert("You haven't select Grantee");
                return;
            }else if($('#program_id').val() == '') {
                alert("Select Program");
                $('#program_id').focus()
                return;
            }else if($('#fiscal_year').val() == '') {
                alert("Input Fiscal Year");
                $('#fiscal_year').focus()
                return;
            }else if($('#end_offline_date').val() == '') {
                alert("Input Deadline Submit");
                $('#end_offline_date').focus()
                return;
            }else{
                $(this).parents('form').submit();
            }
        });
    });

    function handleKeyPress(event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Prevent form submission
            document.forms.frm_manage.submit()
        }
    }
</script>