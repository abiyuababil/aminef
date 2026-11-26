<script src="<?php echo base_url() ?>js/wijmo.min.js"></script>
<script src="<?php echo base_url() ?>js/undoredo.js"></script>

<script>

    const showKeywords = [
    'preview',
    'view',
    'go'
    ];
    $(document).on('click', '.btn-section', function(e){
        e.preventDefault();

        const section = $(this).data('section');
        const grantee_grant_id = $(this).data('grantee_grant_id');
        const sub_section = $(this).data('sub_section') ?? 0;
        const up = $(this).data('up') ?? 0;
        const sub = $(this).data('sub_section') ?? 0;
        $('.html-section' + up).html('<div class="alert alert-info text-center" id="loading-spinner'+ up +'"><i class="fa fa-spinner fa-spin"></i> Loading, please wait.</div>')
        // $('#loading-spinner').removeClass('hide');
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('world/get_section_alumni') ?>/' + section + '/' + grantee_grant_id + '/' + sub_section,
            dataType: "json",
            success: function (res) {
                if (!res.url) {
                    $('.html-section' + up).html('<div class="alert alert-danger">Invalid response.</div>');
                    return;
                }

                // Ambil URL yang nanti akan dipakai untuk button
                let fullPageUrl = res.url;
                let fullPageUrl_Btn = fullPageUrl.split('?')[0];

                // Load view ke dalam container
                $('.html-section' + up).load(fullPageUrl, function(response, status) {

                    if (status === "error") {
                        $('.html-section' + up).html(
                            `<div class="alert alert-danger">
                                Error loading content.<br>
                                URL: ${fullPageUrl}
                            </div>`
                        );
                        return;
                    }

                    // Sisipkan tombol "Open Full Page"
                    let buttonHtml = `
                        <div class="p-2 mb-2">
                            <a href="${fullPageUrl_Btn}" target="_blank" class="btn btn-primary btn-sm">
                                Go to Page
                            </a>
                        </div>
                        <hr />
                    `;

                    // Sisipkan tombol di atas view
                    $('.html-section' + up).prepend(buttonHtml);
                    $('.html-section' + up).find('.warp-alumni-page').find('.form-control').prop('disabled', true).css('background-color', '#eee');
                    $('.html-section' + up).find('.warp-alumni-page').find('.grant-alumni').prop('disabled', true);
                    $('.html-section' + up).find('.warp-alumni-page').find('.radio-nominee').prop('disabled', true);
                    $('.html-section' + up).find('.warp-alumni-page').find('input[type="file"]').prop('disabled', true);
                    $('.html-section' + up).find('.warp-alumni-page').find('.btn').addClass('hide');
                    $('.html-section' + up).find('.warp-alumni-page').find('.fileview').removeClass('hide');
                    $('.html-section' + up).find('.warp-alumni-page').find('.TriSea-technologies-Switch').addClass('hide');
                    $('.html-section' + up).find('.warp-alumni-page').find('.btn').each(function () {
                        const text = $(this).text().trim().toLowerCase();

                        const isShow = showKeywords.some(k => text.includes(k));

                        if (isShow) {
                            $(this).removeClass('hide');
                        }
                    });

                });

                window.history.replaceState({}, "", "?section=" + section + "&sub=" + sub);
            },
            error: function (xhr) {
                $('.html-section').html('<div class="alert alert-danger">Request failed.</div>');
                console.error(xhr.responseText);
            }

        });
    });

    $('#form').on('submit', function() {

        var valid_email = /^(([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)(\s*;\s*|\s*$))*$/;

        if ($('#of_email').val() != '' && !valid_email.test($('#of_email').val())) {
            alert('Format pengisian Email di tab Current Institution tidak valid.');
            return false;
        }

        if ($('#email').val() != '' && !valid_email.test($('#email').val())) {
            alert('Format pengisian Email di tab Home Address tidak valid.');
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
        show_pcode('home_country', 'home_phone_code');
    });

    function del_item(el, item_class) {
        if (confirm("Are you sure want to delete this ?"))
            $(el).closest('.' + item_class).remove();
    }

    function add_publication() {
        var idx = $('.pubs-item').length;
        var html = '';
        html = '<div id="pubs-item-' + idx + '" class="row pubs-item" style="position:relative">';
        html += '	<div class="col-md-4" style="padding-right:0">';
        html += '		<div class="form-group">';
        html += '			<label>Title</label>';
        html += '			<input class="form-control" name="info[publications][' + idx + '][title]" value="">';
        html += '		</div>';
        html += '	</div>';
        html += '	<div class="col-md-8">';
        html += '		<div class="form-group">';
        html += '			<label>Hyperlink</label>';
        html += '			<input class="form-control" name="info[publications][' + idx + '][link]" value="">';
        html += '		</div>';
        html += '	</div>';
        html += '	<a href="javascript:;" onclick="del_item(this, \'pubs-item\')" class="btn btn-danger" style="position:absolute; top:25px; right:15px;"><i class="fa fa-trash fa-fw"></i></a>';
        html += '</div>';
        $('#wrap-publications').append(html);
    }

    function add_other_updates() {
        var idx = $('.opdt-item').length;
        var html = '';
        html = '<div id="opdt-item-' + idx + '" class="row opdt-item" style="position:relative">';
        html += '	<div class="col-md-4" style="padding-right:0">';
        html += '		<div class="form-group">';
        html += '			<label>Title</label>';
        html += '			<input class="form-control" name="info[other_updates][' + idx + '][title]" value="">';
        html += '		</div>';
        html += '	</div>';
        html += '	<div class="col-md-8">';
        html += '		<div class="form-group">';
        html += '			<label>Hyperlink</label>';
        html += '			<input class="form-control" name="info[other_updates][' + idx + '][link]" value="">';
        html += '		</div>';
        html += '	</div>';
        html += '	<a href="javascript:;" onclick="del_item(this, \'opdt-item\')" class="btn btn-danger" style="position:absolute; top:25px; right:15px;"><i class="fa fa-trash fa-fw"></i></a>';
        html += '</div>';
        $('#wrap-other-updates').append(html);
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
                $('.selectpicker').selectpicker('refresh');
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
                $('.selectpicker').selectpicker('refresh');
            }
        });
    });

    function reset_state(id) {
        var state_id = '#' + id.split('_')[0] + '_state';
        $(state_id).html('');
        $(state_id).append('<option value="">-- Select State/Province --</option>');
    }

    function reset_city(id) {
        var city_id = '#' + id.split('_')[0] + '_city';
        $(city_id).html('');
        $(city_id).append('<option value="">-- Select City --</option>');
    }

    $(document).ready(function() {
        $('.select2Alumni').select2({
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
            var is_readonly = <?php echo $readonly ? "'?readonly=1'" : "'?readonly=0'"; ?>;
            $.ajax({
                url: '<?= site_url('admin/alumni/ajx_get_properties') ?>' + '/' + pid + '/' + uid + '/' + act_id + '/' + upid + is_readonly,
                success: function(data) {
                    attr_content.html(data);
                    $('.lightbox').topbox();
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
                            url: '<?= site_url('admin/alumni/ajx_get_properties') ?>' + '/' + pid + '/' + uid + '/' + act_id + '/' + upid + is_readonly,
                            success: function(data) {
                                attr_content.html(data);
                                $(load_id).hide();
                                $('.lightbox').topbox();
                            }
                        });
                    })
                }
            }
        });

        <?php if ($readonly) { ?>
            $('input,textarea,select').prop('disabled', true);
        <?php } ?>
    });

    function show_preview(element, type) {
        const file = element.files[0];
        const filetype = file.name.split('.').pop();

        const allowed_extensions = ['jpg', 'jpeg', 'png'];

        const is_valid_extension = allowed_extensions.some(function(extension) {
            return filetype.toLowerCase().endsWith(extension);
        });

        if (is_valid_extension > 0){
            let reader = new FileReader();
            reader.onload = function(event){
                $("#preview_section_" + type).css('display', 'block');
                $('#preview_image_' + type).attr('src', event.target.result);
            }
            reader.readAsDataURL(file);
        } else {
            let currenct_src = $('#preview_image_' + type).attr('src');
            $('#preview_image_' + type).attr('src', currenct_src);
        }
    }



    $('#btn-migrate-grantee').on('click', function(e){
        e.preventDefault();
        var id = $(this).data('user-id');
        // if (!confirm('Migrate travel arrangement for grantee '+id+'?')) return;

        var $btn = $(this);
        $btn.prop('disabled', true).text('Starting...');


        // actual migration
        Swal.fire({
            title: "Syncing Please Wait...",
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: '<?php echo site_url("admin/alumni/sync_data_grantee/"); ?>' + id,
            method: 'POST',
            dataType: 'json',
            success: function(res) {

                const report = res.report;
                Swal.fire({
                    icon: "success",
                    title: "Sync Complete!",
                    confirmButtonText: "OK"
                }).then(() => {
                    location.reload();
                });
            },
            error: function() {
                $btn.prop('disabled', false).text('Sync Data');
                Swal.fire("Error", "Failed to sync data", "error");
            }
        });
    });
</script>