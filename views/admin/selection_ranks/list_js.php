<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<script>
    const SITE_URL = '<?php echo site_url(); ?>';
    $(document).ready(function(){
        $("#grant_id").on('change', function() {
            let el = $(this);
            if (el.val() =='') {
                return false;
            }

            $.ajax({
                url : SITE_URL + 'admin/user_grantee_grant/ajax_get_period_by_grant_id/' + el.val(),
                type : 'GET',
                dataType : 'JSON',
                success : function(response) {
                    let options = '<option value="">Select Period</option>';
                    for (let i =0; i < response.length; i++) {  
                        options += '<option value="' + response[i].id + '">' + response[i].fiscal_year + ' </options>';
                    }

                    $("#fiscal_year").html(options);
                }, error : function(response) {
                    console.error(response.responseText);
                }
            });
        });

        $("#principal_table tbody").sortable({
            cursor: "move",
            placeholder: "sortable-placeholder",
            helper: function(e, tr) {
                let $originals = tr.children();
                let $helper = tr.clone();
                $helper.children().each(function(index) {
                    $(this).width($originals.eq(index).width());
                });
                return $helper;
            },
            update: function(event, ui) {
                let sorted_ids = [];
                $("#principal_table tbody").find('tr').each(function(index) {
                    let row = $(this);
                    let row_number = index + 1;
                    row.find('td:first').text(row_number); 

                    let field_score = row.find('td:eq(7) span');
                    field_score.text(row_number);

                    let input_score = row.find('td:eq(7) input.final_rank');
                    input_score.val(row_number);
                });
            }
        }).disableSelection();

        $("#alternate_table tbody").sortable({
            cursor: "move",
            placeholder: "sortable-placeholder",
            helper: function(e, tr) {
                let $originals = tr.children();
                let $helper = tr.clone();
                $helper.children().each(function(index) {
                    $(this).width($originals.eq(index).width());
                });
                return $helper;
            },
            update: function(event, ui) {
                let sorted_ids = [];
                $("#alternate_table tbody").find('tr').each(function(index) {
                    let row = $(this);
                    let row_number = index + 1;
                    row.find('td:first').text(row_number); 

                    let field_score = row.find('td:eq(7) span');
                    field_score.text('ALT ' + row_number);

                    let input_score = row.find('td:eq(7) input.final_rank');
                    input_score.val(row_number);
                });
            }
        }).disableSelection();

        $('#form-update-rank').on('submit', function(event) {
            event.preventDefault(); 

            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this action",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, save',
            customClass: 'swal-custom'
            }).then((result) => {
            if (result.isConfirmed) {
                $(this).off('submit').submit();
            }
            });
        });

        $('#button-reset-rank').on('click', function(event) {
            event.preventDefault(); 

            Swal.fire({
                title: 'Are you sure you want to reset the current rank?',
                text: "This action will re-order the rank based on the score, and any changes will be lost.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, reset it!',
                customClass: 'swal-reset-rank'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'action',
                        value: 'reset_rank'
                    }).appendTo('#form-filter-grant');
                    $("#form-filter-grant").submit();
                }
            });
        });

        $("#check-all-daily-rank-principle").on('click', function(){
            if ($(this).is(':checked')) {
                $(".daily-rank-lock-principle").each(function(){
                    $(this).prop('checked', true);
                });
            } else {
                $(".daily-rank-lock-principle").each(function(){
                    $(this).prop('checked', false);
                });
            }
            
        });

        $("#check-all-daily-rank-alternate").on('click', function(){
            if ($(this).is(':checked')) {
                $(".daily-rank-lock-alternate").each(function(){
                    $(this).prop('checked', true);
                });
            } else {
                $(".daily-rank-lock-alternate").each(function(){
                    $(this).prop('checked', false);
                });
            }
            
        });

        $("#check-all-daily-rank-unchoses_status").on('click', function(){
            if ($(this).is(':checked')) {
                $(".daily-rank-lock-unchoses_status").each(function(){
                    $(this).prop('checked', true);
                });
            } else {
                $(".daily-rank-lock-unchoses_status").each(function(){
                    $(this).prop('checked', false);
                });
            }
            
        });

    });
</script>