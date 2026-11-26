<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<script>
    $(document).ready(function(){
        $("#fiscal_year, #pdo_format").trigger('change');
        $(".datetime").datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            autoclose: true,
        });
    });

    $("#fiscal_year").change(function() {
        var grants = '#grants';
        var load = '#load-grants';
        var dataGrant = [<?= $data->user_grantee_grant_id ?>];
        console.log(dataGrant)
        if(this.value == ''){
            $(grants).html('');
            return false;
        }
        $(load).show();
        $(grants).html('');
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/pre_departure_orientation/get_active_grant') ?>/' + this.value,
            dataType: 'JSON',
            success: function(r) {
                $.each(r, function(id, val) {
                    var selected = '';
                    if(jQuery.inArray(parseInt(val.id), dataGrant) !== -1) {
                        selected = 'selected';
                    }
                    $(grants).append('<option '+selected+' value="' + val.id + '">' + val.name + '</option>');
                });
                $(load).hide();
                $(".validation-error-fiscal").css('display', 'none');
            }
        });
    });

    $("#grants").change(function(){
        var grant_id = $("#grants").val(); 
        var fiscal_year = $("#fiscal_year").val(); 
        var load = '#load-list';
        $(load).show();
        $(".wrap-table-list").html('');
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/pre_departure_orientation/get_list_participant') ?>',
            data: {
                grant_id : grant_id,
                fiscal_year : fiscal_year
            },
            dataType: 'JSON',
            success: function(r) {
                $(".wrap-table-list").append(r)
                $(load).hide();

                $('.chk-all').on('click', function (event) {
                    $(this).parents('table').find('.chk-row').prop('checked', this.checked);
                });
            }
        });
    });

    $( ".datepicker" ).datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd M yy",
        yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
    });

    $(".btn-s-pdo").click(function(){
        var fiscal = $("#fiscal_year").val();
        var value = $(this).data('value')

        $('#btn').val(value)
        if(fiscal == ''){
            $(".validation-error-fiscal").css('display', 'block');
            $(".validation-error-fiscal").focus();
            return false;
        }
        $(this).html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop('disabled', true);
        var error = 0;
        // var error = function() {
        //     var error = 1;
        //     $.ajax({
        //         async: false,
        //         type: 'GET',
        //         url: '<?php echo site_url('admin/pre_departure_orientation/check/') ?>'+fiscal,
        //         dataType: 'JSON',
        //         success: function(r) {
        //             console.log(r.error)
        //             error = r.error;
        //         }
        //     });
        //     return error;
        // }();
        if(error == 0){
            $("#form").submit();
            setTimeout(function(){ window.location = "<?= base_url('admin/pre_departure_orientation/manage') ?>" }, 5000);
        }else{
            $("#label-alert").html('PDO with Fiscal year '+fiscal+' already exists!');
            $("#error-alert").removeClass('hide');
            $(this).html('Submit').prop('disabled', false);
        }
    })
    

    $(".btn-s-pdo-edit").click(function(){
        var fiscal = $("#fiscal_year").val();
        var value = $(this).data('value')

        $('#btn').val(value)
        if(fiscal == ''){
            $(".validation-error-fiscal").css('display', 'block');
            $(".validation-error-fiscal").focus();
            return false;
        }
        $(this).html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop('disabled', true);
        $("#form").submit();
        setTimeout(function(){ window.location = "<?= base_url('admin/pre_departure_orientation/manage') ?>" }, 5000);
    })

    $('#pdo_format').change(function(){
        var value = $(this).val()
        if(value == 'hybrid'){
            $('#section_offline, #section_online').removeClass('hide')
        }

        if(value == 'offline'){
            $('#section_offline').removeClass('hide')
            $('#section_online').addClass('hide')
        }

        if(value == 'online'){
            $('#section_offline').addClass('hide')
            $('#section_online').removeClass('hide')
        }
    })
    
    function delete_file_materials(el, id)
    {
        if (confirm("Are you sure want to delete this ?")) {
            $.ajax({
                url: '<?= base_url()?>/admin/pre_departure_orientation/delete_file_materials', // endpoint backend
                type: 'GET',
                data: { 
                    id: id
                },
                dataType: 'json',
                success: function (res) {
                    $(el).closest('li').remove();
                    showSwal('success', 'Successfully changed', false, true, 1500);
                }
            });
        }

    }
</script>