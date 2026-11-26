	<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
	<script>
	$(function() {
		$( ".sortable" ).sortable();
		$( ".datepicker" ).datepicker({
		  changeMonth: true,
		  changeYear: true,
		  dateFormat: "dd M yy",
		  yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
		});
        $(".datetime").datetimepicker({
            format: 'dd M yyyy hh:ii',
            autoclose: true,
        });
	});
	</script>
