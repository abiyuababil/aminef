<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap'
        });
		$( ".datepicker" ).datepicker({
		  changeMonth: true,
		  changeYear: true,
		  dateFormat: "dd M yy",
		  yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>",
		});

        if($('.datepicker').val() == ''){
            $('.datepicker').datepicker('setDate', new Date());
        }

        // $('#table_list_score tbody').sortable({
        //     containment: "parent",
        //     tolerance: "pointer",
        //     update: function(event, ui) {
        //     // Handle update event
        //     }
        // }).disableSelection();

        $('#program').trigger('change');
    });

    $('#program').change(function(){
        $('#grantee').html('')
        $('#grantee').append('<option value="">-- Select Grantee --</option>');
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/new_selection/get_grantee') ?>/' + this.value + '/' + '<?= $section ?>',
            dataType: 'JSON',
            success: function(r) {
                $.each(r, function(id, val) {
                    var selected = '';
                    // if(jQuery.inArray(parseInt(val.id), dataGrant) !== -1) {
                    //     selected = 'selected';
                    // }
                    $('#grantee').append('<option '+selected+' data-grantee="'+ val.user_grantee_id +'" value="' + val.id + '">' + val.first_name + ' ' + (val.middle_name ?? '') + ' ' + (val.last_name ?? '') + '</option>');
                });
                // $(load).hide();
                // $(".validation-error-fiscal").css('display', 'none');
            }
        });
    });
    $('#grantee').on('change', function() {
        var selectedOptions = $(this).val();
        var tableBody = $('#table_list_score tbody');
        var countTr = $('#table_list_score tbody tr').length;
        var section = '<?= $section ?>';
        
        if (selectedOptions) {
            var userGranteeId = $('#grantee option[value="' + selectedOptions + '"]').data('grantee');
            var inputTime = $('#time').val();
            var timeObj = new Date('1970-01-01T' + inputTime);
            timeObj.setMinutes(timeObj.getMinutes() + ((countTr + 1) * 30));
            var newTime = ('0' + timeObj.getHours()).slice(-2) + ':' + ('0' + timeObj.getMinutes()).slice(-2);
            var row = '\
                        <tr>\
                            <td>\
                                ' + $('#grantee option[value="' + selectedOptions + '"]').text() + '\
                                <input type="hidden" value="'+selectedOptions+'" name="grantee[]">\
                                <input type="hidden" value="'+userGranteeId+'" name="grantee_id[]">\
                            </td>\
                            <td><input type="time" class="form-control" value="'+ newTime +'" name="gratee_time[]"></td>\
                            <td><button class="btn btn-danger btn-xs removeRow" data-value="'+ selectedOptions +'" onclick="deleteRow(this)"><i class="fa fa-trash fa-fw"></i></button></td>\
                        </tr>';
            if(section == 'Review'){
                row = '\
                        <tr>\
                            <td>\
                                ' + $('#grantee option[value="' + selectedOptions + '"]').text() + '\
                                <input type="hidden" value="'+selectedOptions+'" name="grantee[]">\
                                <input type="hidden" value="'+userGranteeId+'" name="grantee_id[]">\
                            </td>\
                            <td><button class="btn btn-danger btn-xs removeRow" data-value="'+ selectedOptions +'" onclick="deleteRow(this)"><i class="fa fa-trash fa-fw"></i></button></td>\
                        </tr>';
            }
            tableBody.append(row);
            $('#grantee option[value="' + selectedOptions + '"]').prop('disabled', true);
            $(this).val('');
        }
    });

    function deleteRow(el)
    {
        var row = $(el).closest('tr');
        var value = $(el).data('value');
        row.remove();
        $('#grantee option[value="' + value + '"]').prop('disabled', false);
    }

    function deleteRowEdit(el)
    {
        var countRow = $(el).data('count');
        var row = $(el).closest('tr');
        var value = $(el).data('value');
        for($i = 1; $i < countRow; $i++) {
            row.next('tr').remove();
        }
        row.remove();
        $('#grantee option[value="' + value + '"]').prop('disabled', false);
    }

    function checkDuplicates() {
        // Create an array to store the values
        var values = [];
        var hasDuplicate = false;

        // Iterate over each input with class 'daily_rank'
        $('.daily_rank').each(function() {
            var value = $(this).val();
            if (values.includes(value)) {
                hasDuplicate = true;
                return false; // Exit the loop early
            }
            values.push(value);
        });

        return hasDuplicate;
    }

    $("#submit-score").on('click', function(e){
        e.preventDefault();
        if (checkDuplicates()) {
            Swal.fire({
                title: "Rank cannot be the same!",
                icon: "error",
                customClass: 'swal-custom'
            });
        } else {
            Swal.fire({
                title   : "Are you sure you want to submit?",
                // text    : "Once submitted, data cannot be changed.",
                icon    : "warning",
                showCancelButton    : true,
                confirmButtonColor  : "#3085d6",
                cancelButtonColor   : "#d33",
                confirmButtonText   : "Yes, submit",
                customClass         : 'swal-interview'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("form").submit();
                }
            });
        }
    });

    // $('#grantee').on('change', function() {
    //     $('#table_list_score tbody').empty(); // Empty the table body
    //     var selectedOptions = $(this).val(); // Get selected values
    //     if(selectedOptions){
    //         $.each(selectedOptions, function(index, value){
    //             var text = $('#grantee option[value="' + value + '"]').text();
    //             console.log(text)
    //             $('#grantee option[value="' + value + '"]').prop('disabled', true);
    //             $('#table_list_score tbody').append('\
    //                     <tr> \
    //                         <td rowspan="4">'+ text +'</td>\
    //                         <td>Rianti</td>\
    //                         <td><input class="form-control"></td>\
    //                         <td>\
    //                         <select class="form-control">\
    //                             <option>HR</option>\
    //                             <option>R</option>\
    //                             <option>NR</option>\
    //                         </select>\
    //                         </td>\
    //                     </tr>\
    //                     <tr>\
    //                         <td>Alan</td>\
    //                         <td><input class="form-control"></td>\
    //                         <td>\
    //                         <select class="form-control">\
    //                             <option>HR</option>\
    //                             <option>R</option>\
    //                             <option>NR</option>\
    //                         </select>\
    //                         </td>\
    //                     </tr>\
    //                     <tr>\
    //                         <td>Robby</td>\
    //                         <td><input class="form-control"></td>\
    //                         <td>\
    //                         <select class="form-control">\
    //                             <option>HR</option>\
    //                             <option>R</option>\
    //                             <option>NR</option>\
    //                         </select>\
    //                         </td>\
    //                     </tr>\
    //                     <tr>\
    //                         <td>Dani</td>\
    //                         <td><input class="form-control"></td>\
    //                         <td>\
    //                         <select class="form-control">\
    //                             <option>HR</option>\
    //                             <option>R</option>\
    //                             <option>NR</option>\
    //                         </select>\
    //                         </td>\
    //                     </tr>'); // Append selected options to table
    //         });
    //     }
    // });
    
    

    function emptyValue(object){
        $(object).closest('.form-group').find('.datepicker').val('');
    }
</script>
