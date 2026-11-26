<link href="<?php echo base_url() ?>css/jquery.dataTables.css" rel="stylesheet">
<script src="<?php echo base_url() ?>js/jquery.dataTables.js"></script>

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
		// $(this).parents('form').submit();
		$('#form-exe').submit()
	});
	
	$(document).ready(function() {
		$('#modal_eid').modal('show');

		// data table
		$.fn.DataTable.ext.pager.numbers_length = 5;
		$('#table_eid').DataTable( {
		"pagingType":"full_numbers",
	
		} );  
		
	});

	function close_modal_eid(){
		$('#modal_eid').hide();
	}

    $('#modal_view_eid').on('show.bs.modal', function(event){
      $.fn.modal.Constructor.prototype.enforceFocus = function () { 
        var button = $(event.relatedTarget);
        var eId = button.data('record_id');
		var dti = $('#table_view_eid').DataTable( {"pagingType":"full_numbers"} );
		dti.destroy();
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/executive_payment_grants/detail_approval_req') ?>',
            dataType: 'JSON',
            data: {
                eid : eId
            },
            success: function(r) {
				dti.clear()
				$.each(r, function (i, item) {
					if(item.sub_category){
						dti.row.add([
							item.num,
							item.program_name,
							item.payment_date,
							item.total_payment,
							item.status_name
						]).draw(false);
					}else{
						dti.row.add([
							item.num,
							item.program_name,
							item.payment_date,
							item.total_payment,
							item.status_name
						]).draw(false);
					}
                });
            }
        });
      };
    });
</script>