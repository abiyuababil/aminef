<script>
	$("#btn-exe").click(function () {
		if($('.chk-row:checked').length == 0) {
			alert("You haven't select any item");
			return;
		}
		// var action = $(this).attr('data-action');
		if(!confirm('Are you sure want to change selected items?'))
			return;
		// $('input[name=action]').removeAttr('disabled').val(action);
		$(this).parents('form').submit();
	});
</script>