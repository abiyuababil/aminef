<script src="<?php echo base_url() ?>js/wijmo.min.js"></script>
<script src="<?php echo base_url() ?>js/undoredo.js"></script>

<script>

    function show_pcode(el_country, el_pcode) {
        var country_code = $('#' + el_country + ' option:selected').attr('data-pcode');
        if (country_code != undefined)
            $('#' + el_pcode).val('+' + country_code);
    }

    function del_item(el, item_class) {
        var deleted = $("#delete_desc").val();
        if (confirm("Are you sure want to delete this ?"))
            $(el).closest('.' + item_class).remove();
            var id = $(el).attr('id');
            if(deleted == ''){
                $("#delete_desc").val(id);
            }else{
                var join_id = deleted + ',' + id;
                $("#delete_desc").val(join_id);
            }
    }

    function del_item_sub(el, item_class) {
        var deleted = $("#delete_sub").val();
        if (confirm("Are you sure want to delete this ?"))
            $(el).closest('.' + item_class).remove();
            var id = $(el).attr('id');
            if(deleted == ''){
                $("#delete_sub").val(id);
            }else{
                var join_id = deleted + ',' + id;
                $("#delete_sub").val(join_id);
            }
    }

    

    function add_description() {
        var idx = $('.description-item').length;
        var html = '';
        html = '<div id="description-item-' + idx + '" class="description-item mt-3">';
        html += '<div class="col-lg-12">';
        html += '   <div class="form-group">';
        html += '       <label>Description '+(idx+1)+' <a href="javascript:;" onclick="del_item(this, \'description-item\')"><i class="fa fa-trash fa-fw fa-1x"></i></a> <a href="javascript:;" onclick="add_sub_description('+idx+')" class="btn btn-primary btn-xs"><i class="fa fa-plus fa-fw fa-1x"></i> Add Sub Descriptiom</a><img src="<?php echo base_url() ?>/img/loading.gif" class="request-load" style="display:none;"></label>';
        html += '       <textarea class="form-control" rows="4" name="description_mid['+idx+'][desc]"></textarea>';
        html += '       <input type="hidden" class="form-control" name="description_mid['+idx+'][desc_order]" value="'+(idx+1)+'">';
        html += '       <input type="hidden" class="form-control" name="description_mid['+idx+'][is_mid]" value="1">';
        html += '   </div>';
        html += '</div>';
        html += '<div id="wrap-sub-description'+idx+'">';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        $('#wrap-description').append(html);
    }

    function add_sub_description(i) {
        console.log(i)
        var wrap = '#wrap-sub-description'+i;
        var idx = $('.sub-description-item').length;
        var html = '';
        html = '<div id="sub-description-item-' + idx + '" class="sub-description-item mt-3">';
        html += '   <div class="col-lg-11 col-lg-offset-1">';
        html += '       <div class="form-group">';
        html += '           <label>Sub Description<a href="javascript:;" onclick="del_item(this, \'sub-description-item\')"><i class="fa fa-trash fa-fw fa-1x"></i></a> <img src="<?php echo base_url() ?>/img/loading.gif" class="request-load" style="display:none;"></label>';
        html += '           <textarea class="form-control" rows="4" name="description_mid['+i+'][sub]['+idx+'][sub_description]"></textarea>';
        html += '           <input type="hidden" class="form-control" name="description_mid['+idx+'][sub_order]" value="'+(idx+1)+'">';
        html += '       </div>';
        html += '   </div>';
        html += '</div>';
        $(wrap).append(html);
    }

    
    function add_description_final() {
        var idx = $('.description-final-item').length;
        var html = '';
        html = '<div id="description-final-item-' + idx + '" class="description-final-item mt-3">';
        html += '<div class="col-lg-12">';
        html += '   <div class="form-group">';
        html += '       <label>Description '+(idx+1)+' <a href="javascript:;" onclick="del_item(this, \'description-final-item\')"><i class="fa fa-trash fa-fw fa-1x"></i></a> <a href="javascript:;" onclick="add_sub_description_final('+idx+')" class="btn btn-primary btn-xs"><i class="fa fa-plus fa-fw fa-1x"></i> Add Sub Descriptiom</a><img src="<?php echo base_url() ?>/img/loading.gif" class="request-load" style="display:none;"></label>';
        html += '       <textarea class="form-control" rows="4" name="description_final['+idx+'][desc]"></textarea>';
        html += '       <input type="hidden" class="form-control" name="description_final['+idx+'][desc_order]" value="'+(idx+1)+'">';
        html += '       <input type="hidden" class="form-control" name="description_final['+idx+'][is_mid]" value="0">';
        html += '   </div>';
        html += '</div>';
        html += '<div id="wrap-sub-description-final'+idx+'">';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        $('#wrap-description-final').append(html);
    }

    function add_sub_description_final(i) {
        var wrap = '#wrap-sub-description-final'+i;
        var idx = $('.sub-description-final-item').length;
        var html = '';
        html = '<div id="sub-description-final-item-' + idx + '" class="sub-description-final-item mt-3">';
        html += '   <div class="col-lg-11 col-lg-offset-1">';
        html += '       <div class="form-group">';
        html += '           <label>Sub Description<a href="javascript:;" onclick="del_item(this, \'sub-description-final-item\')"><i class="fa fa-trash fa-fw fa-1x"></i></a> <img src="<?php echo base_url() ?>/img/loading.gif" class="request-load" style="display:none;"></label>';
        html += '           <textarea class="form-control" rows="4" name="description_final['+i+'][sub]['+idx+'][sub_description]"></textarea>';
        html += '           <input type="hidden" class="form-control" name="description_final['+idx+'][sub_order]" value="'+(idx+1)+'">';
        html += '       </div>';
        html += '   </div>';
        html += '</div>';
        $(wrap).append(html);
    }

    function del_file(el, name, label,value='') {
        if (confirm("Are you sure want to delete " + label + " ?")) {
            var html = '<input type="hidden" name="' + name + '" value="' + value + '">';
            $(el).parent().replaceWith(html);
        }
    }

    function submit_report() {
        var grant_id = $("#grants").val();

        $.ajax({
            url: '<?= site_url('admin/grantee_report/ajx_get_description') ?>' + '/' + grant_id,
            success: function(data) {
                if(data.redirect){
                    window.location.href = data.redirect;
                }else{
                    $("#content_").show();
                    $("#btn-action").show();
                    event.preventDefault();
                }
            }
        });
    }

    $("#btn-deleted").click(function(){
        $("#mdl_info").modal();    
        event.preventDefault();
    });

    $("#btn-submit").click(function(){
        var grant = $('#grants').val();
        if(grant == ''){
            alert('Please Choose Grants.');
            $('#grants').focus();
            return false;
        }
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