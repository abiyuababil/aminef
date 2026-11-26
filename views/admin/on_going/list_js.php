<script>
    $(".succesfully").click(function(){
        var id = $(this).data('id');
        $("#mdl_info").modal();   
        $('#btn-successful').attr("onclick","succesfully("+ id +")"); 
        event.preventDefault();
    });

    function succesfully(grantee_grant_id)
    {
        $('#btn-successful').html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop( 'disabled', true );
        $.ajax({
            url: "<?= base_url(); ?>admin/on_going/successfully",
            method: "POST",
            dataType: 'JSON',
            data: {
                grantee_grant_id: grantee_grant_id,
            }
        })
        .success(function(data){
            window.location.href = data.redirect;
        })
    }
    
	function add_filter() {
		var html = $('#template-filter').html();
		$('#wrap-filter').append(html);
	}
	
	function remove_filter(el) {
		$(el).parent().remove();
	}
	
	function submitFilter(e) {
		if (e.keyCode == 13) {
			$('#frm_manage').submit();
			return false;
		}
	}
</script>