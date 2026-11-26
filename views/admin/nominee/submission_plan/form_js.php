<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<script>

$(document).ready(function() {
    $('.select2, .select2univ').select2({
        theme: 'bootstrap'
    });
});
$( ".datepicker" ).datepicker({
    changeMonth: true,
    changeYear: true,
    dateFormat: "dd M yy",
    yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
});
</script>