<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<script>
    var allEditors = document.querySelectorAll('.editor');
    for (var i = 0; i < allEditors.length; ++i) {
        ClassicEditor.create(allEditors[i]).then(editor => {
          editor.isReadOnly = true;
        });
    }

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
    
    $("#btn-decline").click(function(){
        $("#mdl_info_decline").modal();    
        event.preventDefault();
    });

    $("#btn-present").click(function(){
        $("#mdl_info_present").modal();    
        event.preventDefault();
    });
</script>