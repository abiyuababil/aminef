<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<script>
    $(document).ready(function(){
        $('.select2').select2({
            theme: 'bootstrap'
});
		$( ".datepicker" ).datepicker({
		  changeMonth: true,
		  changeYear: true,
		  dateFormat: "dd M yy",
		  yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
		});
    });

    function saveButton() {
        event.preventDefault();
        const status = $("#status").val();
        if(status == <?= INVALID ?>){
            $("#mdl_note_reject_selection").modal();   
        }else{
            if (confirm("Are you sure want to Save this ?")){
                var btn = $("<input>").attr("type", "hidden").attr("name", "btn").val("save");
                $( "#form" ).append(btn);
                $( "#form" ).submit();
            }
        }

    }
    
    // $('input[type=radio][name=academic_status]').change(function() {
    //     console.log(this.value)   
    //     if (this.value == 's1_completed') {
    //         $("#status").val('1');
    //         $("#status_validation").val('1');
    //     }
    //     else {
    //         $("#status").val('2');
    //         $("#status_validation").val('2');
    //     }
    // });
</script>