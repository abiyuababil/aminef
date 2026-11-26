<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<link href="<?php echo base_url() ?>css/jquery.dataTables.css" rel="stylesheet">
<script src="<?php echo base_url() ?>js/jquery.dataTables.js"></script>
<script src="<?php echo base_url() ?>js/sweet-alert.min.js?v=<?=VERSION?>"></script>
<script>
    // var allEditors = document.querySelectorAll('.editor');
    // for (var i = 0; i < allEditors.length; ++i) {
    //     ClassicEditor.create(allEditors[i]);
    // }
    tinymce.init({
        selector: 'textarea.editor',
        plugins: 'link table lists',
        toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | link | numlist bullist',
        extended_valid_elements: 'table[border|cellspacing|cellpadding|width|style]',
        contenteditable: true,
        spellchecker: false,
        table_default_attributes: {
            border: '0'  // Mengatur default border tabel menjadi 0
        },
        table_default_styles: {
            'border': '0'  // Mengatur default style border tabel menjadi 0
        }
    });

    $(document).ready(function() {
        $("#category_grant").trigger('change')
        $(".datepicker").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd M yy",
            yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
        });
        $(".datepickerCalendar").datepicker({
            changeMonth: true,
            changeYear: false,
            dateFormat: "dd MM",
            yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
        });
        $("#form-grand").submit(function(event) {
            const activeCountry = <?= $this->session->userdata('active_country') ?>;
            if(activeCountry === 1){
                if ($("input[type=checkbox]:checked").length === 0) {
                    alert("Please select at least one Nominee Menu.");
                    event.preventDefault(); // Prevent form submission
                }
            }
        });

        $(".select2").select2();
    });
    
    $("#form-add-memo").on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            enctype: 'multipart/form-data',
            processData: false,
            dataType: 'JSON',
            success: function(response) {
                $("#no-memo").addClass('hide');
                
                //add uploaded file into table memo budget
                var new_row = [
                    '<a href="<?php echo site_url(); ?>'+ response.data.memo_budget +'" class="lightbox">' + response.data.file_name + '</a>',
                    response.data.year,
                    response.data.is_active,
                    response.data.created_at,
                    '<a href="<?php echo site_url('admin/user_grantee_grant/delete_grant_memo/'); ?>' +  response.data.id + '" class="btn btn-danger btn-delete-memo pull-right">Delete</a>'
                ];

                $("#memo_revision").DataTable().row.add(new_row).draw();

                //close modal
                $("#mdl_memo_create").modal('hide');

                //clear all input of modal
                $('#memo_budget').val('').change();

                //set select is active = yes
                $('#is_active').val('Yes').change();

                //set select year = current year
                var current_year = new Date().getFullYear(); 
                $('#year').val(current_year).change();

                $('.lightbox').topbox();
            },
            error: function(response) {
                console.error(response);
            }
        });
    });
    
    
    $('#edit_mdl_memo').on('show.bs.modal', function(event) {
        $.fn.modal.Constructor.prototype.enforceFocus = function() {

            var button = $(event.relatedTarget);
            var memoID = button.data('memo_id');

            if (typeof currentMemoGrants !== 'undefined') {
                var data = currentMemoGrants[memoID];
                var baseUrl = window.location.origin;
                $('#memo_id').val(data.id);
                $('#edit_memo_year').val(data.year);
                $('#edit_memo_is_active').val(data.is_active);
            } else {
                $('#memo_id').val(button.data('id'));
                $('#edit_memo_year').val(button.data('year'));
                $('#edit_memo_is_active').val(button.data('is_active'));
            }
        };
    });

    $("#alumni_grant").change(function(){
        var category = $(this).find(':selected').data("category");
        if(category != ''){
            $("#category_grant").val(category)
        }else{
            $("#category_grant").val('')
        }
    });

    $("#category_grant").change(function(){
        var value = $(this).find(':selected').val();
        if(value == <?= ETA ?>){
            $("#sick_leave").removeClass('hide');
            $("#emergency_leave").removeClass('hide');
            $("#research_leave").addClass('hide');
        }else if(value == <?= RESEARCH ?>){
            $("#sick_leave").addClass('hide');
            $("#emergency_leave").removeClass('hide');
            $("#research_leave").removeClass('hide');
        }else if(value == <?= TEACHING ?>){
            $("#emergency_leave").removeClass('hide');
        }else{
            $("#sick_leave").addClass('hide');
            $("#emergency_leave").addClass('hide');
            $("#research_leave").addClass('hide');
        }
    });
    
    $("#is_letter_of_reference").change(function(){
        if ($(this).is(":checked")){
            $("#note_letter_of_reference").removeClass('hide');
        }else{
            $("#note_letter_of_reference").addClass('hide');
        }
    });

    $(document).ready(function() {
        $('#memo_revision').DataTable({
            info: false,
            paging: false,
            searching : false
        });

        // Mencegah form ter-submit saat mengklik header kolom untuk sorting
        $('#memo_revision thead th').on('click', function(event) {
            event.preventDefault();
        });
    });

    $(document).on('click', '.btn-delete-memo', function(e){
        e.preventDefault();
        let element = $(this);

        Swal.fire({
            title: "Do you want to delete?",
            showCancelButton: true,
            confirmButtonText: "Yes, delete",
            icon: "question",
            customClass: 'swal-custom'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url : element.attr('href'),
                    type : 'GET',
                    dataType : 'JSON',
                    success : function(response) {
                        Swal.fire({
                            title: response.success ? "Memo budget has been deleted" : "Failed to delete",
                            text: response.message,
                            icon: response.success ? "success" : "warning",
                            customClass: 'swal-custom'
                        });

                        if (response.success) {
                            let table = $('#memo_revision').DataTable(); 
                            table.row(element.closest('tr')).remove().draw();
                        }

                    }, error : function(response) {
                        Swal.fire({
                            title: "Failed to delete",
                            text: response.responseText,
                            icon: "warning",
                            customClass: 'swal-custom'
                        });
                    }
                });
            }
        });
    });

    function remove_file(event) {
		event.preventDefault();
        if (confirm("Are you sure you want to remove this file?")) {
            document.getElementById("example_cv_uploaded").value = "";
            const fileInfo = document.getElementById("file_info");
            if (fileInfo) {
                fileInfo.remove();
            }
        }
	}
</script>