<script src="<?php echo base_url() ?>js/wijmo.min.js"></script>
<script src="<?php echo base_url() ?>js/undoredo.js"></script>

<script>

    function del_item(el, item_class) {
        if (confirm("Are you sure want to delete this ?"))
            $(el).closest('.' + item_class).remove();
    }
    
    $("#btn-upload1").click(function(){
        $("#my_file1").click();
    });
    
    $('input[type=file]').change(function (e) {
        if($(this).val() != ''){
            $('#file_name1').html($(this).val());
        }else{
            $('#file_name1').html('No file chosen');
        }
    });
    
    $("#btn-deleted").click(function(){
        $("#mdl_info").modal();    
        event.preventDefault();
    });

    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap'
});

        $('.tab-grants').each(function(i, obj) {
            var pid = $(this).data("pid");
            var upid = $(this).data("upid");
            var uid = $('#uid').val();
            var act_id = 0;
			if (pid == 10)
				act_id = $('#chg_activity_' + pid).val();
            var attr_content = $("#content_" + upid);

            $.ajax({
                url: '<?= site_url('admin/alumni/ajx_get_properties') ?>' + '/' + pid + '/' + uid + '/' + act_id + '/' + upid,
                success: function(data) {
                    attr_content.html(data);
                }
            });


            if (pid == 10) {
                if ($('#chg_activity_' + pid).length) {
                    $('#chg_activity_' + pid).on('change', function() {
                        var act_id = $(this).val();
                        var load_id = '#load-' + pid;
                        $(load_id).show();

                        if (act_id == undefined) {
                            act_id = 0;
                        }

                        $.ajax({
                            url: '<?= site_url('admin/alumni/ajx_get_properties') ?>' + '/' + pid + '/' + uid + '/' + act_id + '/' + upid,
                            success: function(data) {
                                attr_content.html(data);
                                $(load_id).hide();
                            }
                        });
                    })
                }
            }
        });
    });
</script>