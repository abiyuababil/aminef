<script>
	$('.btn-action').on('click', function(event){
		if($('.chk-row:checked').length == 0) {
			alert("You haven't select any item");
			return false;
		}
        if(!confirm('Are you sure ?'))
            return false;
	});

    $(document).ready(function(){
        if(notifapprove == 1){
            $("#success-alert").fadeTo(15000, 500).slideUp(500, function() {
            $("#success-alert").slideUp(500);
            });
        }
    })
</script>