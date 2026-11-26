<script>
	$('.chk-all-role').on('click', function(event){
        var feature = $(this).data('feature');
		$(this).parents('table').find('.chk-row-'+feature).prop('checked', this.checked);
	});
</script>