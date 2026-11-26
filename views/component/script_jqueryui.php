	<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
	<script>
	$(function() {
		$( ".sortable" ).sortable();
		$( ".datepicker" ).datepicker({
		  changeMonth: true,
		  changeYear: true,
		  dateFormat: "dd M yy",
		  yearRange: "<?php echo date('Y') - 100 ?>:<?php echo date('Y') + 20 ?>",
		  onClose: function() {
				$(this).trigger('blur');
		  }
		});
	});
	</script>
