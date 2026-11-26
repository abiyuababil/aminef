<script src="<?php echo base_url() ?>js/wijmo.min.js"></script>
<script src="<?php echo base_url() ?>js/undoredo.js"></script>

<script>
    $('#form').on('submit', function() {

        var valid_email = /^(([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)(\s*;\s*|\s*$))*$/;

    if ($('#primary_email').val() != '' && !valid_email.test($('#primary_email').val())) {
        alert('Email not valid.');
        $('#primary_email').focus();
        return false;
    }

        return true;
    });

    function show_pcode(el_country, el_pcode) {
        var country_code = $('#' + el_country + ' option:selected').attr('data-pcode');
        if (country_code != undefined)
            $('#' + el_pcode).val('+' + country_code);
    }

    $(function() {
        show_pcode('of_country', 'of_phone_code');
        show_pcode('country', 'street');
    });

    function del_item(el, item_class) {
        if (confirm("Are you sure want to delete this ?"))
            $(el).closest('.' + item_class).remove();
    }

    function add_label() {
        var idx = $('.label-item').length;
        $('.add-load-label').show();
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('world/getPartial') ?>/'+ idx,
            dataType: 'JSON',
            success: function(r) {
                var html = r;
                $('#wrap-label').append(html);
                $('.select2').select2({
            theme: 'bootstrap'
});
                $('.add-load-label').hide();
            }
        });
    }

    function add_institution() {
        var idx = $('.institution-item').length;
        $('.add-load').show();
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('world/getPartialInstitution') ?>/'+ idx,
            dataType: 'JSON',
            success: function(r) {
                var html = r;
                $('#wrap-institution').append(html);
                $('.select2').select2({
            theme: 'bootstrap'
});
                $('.add-load').hide();
            }
        });
    }

    function generate_pass() {
        $('.generate-load').show();
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('world/rand_string') ?>',
            dataType: 'JSON',
            success: function(r) {
                $("#password").val(r);
                $('.generate-load').hide();
            }
        });
    }

    function add_mobile_number() {
        var idx = $('.opdt-item').length;
        var html = '';
        html = '<div id="opdt-item-' + idx + '" class="row opdt-item" style="position:relative">';
        html += '	<div class="col-lg-12">';
        html += '		<div class="form-group">';
        html += '			<label>Cell Phone Number</label>';
        html += '			<input class="form-control" name="phone_number[]" value="">';
        html += '		</div>';
        html += '	</div>';
        html += '	<a href="javascript:;" onclick="del_item(this, \'opdt-item\')" class="btn btn-danger" style="position:absolute; top:25px; right:15px;"><i class="fa fa-trash fa-fw"></i></a>';
        html += '</div>';
        $('#wrap-phone').append(html);
    }

    function del_file(el, name, label,value='') {
        if (confirm("Are you sure want to delete " + label + " ?")) {
            var html = '<input type="hidden" name="' + name + '" value="' + value + '">';
            $(el).parent().replaceWith(html);
        }
    }

    $(".select-country").change(function() {
        var state_el = this.id.split('_')[0] + '_state';
        var load_id = '#load-' + state_el;
        $(load_id).show();
        reset_state(this.id);
        reset_city(this.id);
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('world/state') ?>/' + this.value,
            dataType: 'JSON',
            success: function(r) {
                $.each(r, function(id, val) {
                    $('#' + state_el).append('<option value="' + val.id + '">' + val.name + '</option>');
                });
                $(load_id).hide();
            }
        });
    });

    $(".select-country-birth").change(function() {
        var state_el = 'select-city-birth';
        $('.load-city-birth').show();
        reset_state(this.id);
        reset_city(this.id);
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('world/countrycity') ?>/' + this.value,
            dataType: 'JSON',
            success: function(r) {
                $.each(r, function(id, val) {
                    $('.' + state_el).append('<option value="' + val.id + '">' + val.name + '</option>');
                });
                $('.load-city-birth').hide();
            }
        });
    });

    $(".select-country-academic").change(function() {
        var state_el = 'select-city-academic';
        $('.load-city-academic').show();
        reset_state(this.id);
        reset_city(this.id);
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('world/countrycity') ?>/' + this.value,
            dataType: 'JSON',
            success: function(r) {
                $.each(r, function(id, val) {
                    $('.' + state_el).append('<option value="' + val.id + '">' + val.name + '</option>');
                });
                $('.load-city-academic').show();
            }
        });
    });

    $(".select-state").change(function() {
        var city_el = this.id.split('_')[0] + '_city';
        var load_id = '#load-' + city_el;
        $(load_id).show();
        reset_city(this.id);
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('world/city') ?>/' + this.value,
            dataType: 'JSON',
            success: function(r) {
                $.each(r, function(id, val) {
                    $('#' + city_el).append('<option value="' + val.id + '">' + val.name + '</option>');
                });
                $(load_id).hide();
            }
        });
    });

    function reset_state(id) {
        var state_id = '#' + id.split('_')[0] + '_state';
        $(state_id).html('');
        $(state_id).append('<option value="">-- Select Province --</option>');
    }

    function reset_city(id) {
        var city_id = '#' + id.split('_')[0] + '_city';
        $(city_id).html('');
        $(city_id).append('<option value="">-- Select City --</option>');
    }

    function select_province(el) {
        var selectValue = $(".select-country"+ el).val();
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('world/state') ?>/' + selectValue,
            dataType: 'JSON',
            success: function(r) {
                $.each(r, function(id, val) {
                    $('.select-state' + el).append('<option value="' + val.id + '">' + val.name + '</option>');
                });
            }
        });
    }

    function select_city(el) {
        var selectValue = $(".select-state"+ el).val();
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('world/city') ?>/' + selectValue,
            dataType: 'JSON',
            success: function(r) {
                $.each(r, function(id, val) {
                    $('.select-city' + el).append('<option value="' + val.id + '">' + val.name + '</option>');
                });
            }
        });
    }

    function select_country_city(el) {
        var selectValue = $(".select-country-academic"+ el).val();
        $('.load-city-academic'+el).show();
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('world/countrycity') ?>/' + selectValue,
            dataType: 'JSON',
            success: function(r) {
                $.each(r, function(id, val) {
                    $('.select-city-academic' + el).append('<option value="' + val.id + '">' + val.name + '</option>');
                });
                $('.load-city-academic'+el).hide();
            }
        });
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