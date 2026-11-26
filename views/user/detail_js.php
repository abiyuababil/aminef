	<script>
	
	$(document).ready(function() {
		
		$('#yes-link').click(function() {
			$('#notifyModal').modal('hide');
		});
		
	});

	function notify_outlink(el) {
		$('#notifyModal').modal('show');
		var link = $(el).attr('data-target');
		$('#gotolink').html(link);
		$('#yes-link').attr('href', link);
	}
	
	</script>
