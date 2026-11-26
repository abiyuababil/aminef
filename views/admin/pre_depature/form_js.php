<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<script>
    const SITE_URL = '<?php echo site_url(); ?>';
    var allEditors = document.querySelectorAll('.editor');
    for (var i = 0; i < allEditors.length; ++i) {
        ClassicEditor.create(allEditors[i]);
    }

    $(document).ready(function(){
        $(".select_show").trigger("change");
        
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

    function show_preview(element, type, upload_type) {
        const file = element.files[0];
        $('#btn-save-note-withdraw').html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop( 'disabled', true );
        let formData = new FormData();
        formData.append(upload_type, file);
        formData.append('type', upload_type);

        $.ajax({
            url: SITE_URL + 'admin/grantee/save_file', 
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType : 'JSON',
            success: function(response) {
                if (response.status) {
                    render_data_upload_attach(response, upload_type);
                    // let file_url = SITE_URL + response.filepath;
                    // $(".uploaded_attachment").attr('href', file_url).removeClass('hide').html('<b> <i class="fa fa-paperclip"></i> ' + response.filename) + '</b>';
                    // $("input[name='" + upload_type +"']").val(response.filepath);
                } else {
                    $(".uploaded_attachment").addClass('hide');
                    alert('Failed to upload your file, please try again');
                }

                $('#btn-save-note-withdraw').html('Save').prop( 'disabled', false );
            },
            error: function(xhr, status, error) {
                $('#btn-save-note-withdraw').html('Save').prop( 'disabled', false );
                console.error(error); 
            }
        });
    }

    function show_hide_transportation(obj, section, index){
        if($(obj).val() == 'No' || $(obj).val() == ''){
            $('.section-transportation-'+section+'-'+index).addClass('hide');
        }else{
            $('.section-transportation-'+section+'-'+index).removeClass('hide');
        }

        if($(obj).val() == 'Reimbursement'){
            $('#label_eticket_'+section+'_'+index).html('Receipt')
        }else{
            $('#label_eticket_'+section+'_'+index).html('E-Ticket')
        }

    }

    function show_hide_accomodation(obj, section, index){
        if($(obj).val() == 'No' || $(obj).val() == ''){
            $('.section-accomodation-'+section+'-'+index).addClass('hide');
        }else{
            $('.section-accomodation-'+section+'-'+index).removeClass('hide');
        }

        if($(obj).val() == 'Reimbursement'){
            $('#label_voucher_hotel_'+section+'_'+index).html('Receipt')
        }else{
            $('#label_voucher_hotel_'+section+'_'+index).html('Hotel Voucher')
        }

    }
    tinymce.init({
        selector: '.editor_grantee',
        plugins: 'link table',
        // toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | link | fontsizeselect',
        contenteditable: true,
        spellchecker: false,
        readonly: true
    });
</script>