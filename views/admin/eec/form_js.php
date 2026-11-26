<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<script>
    const SITE_URL = '<?php echo site_url(); ?>';
    $(document).ready(function(){
        $("#fiscal_year").trigger('change');
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
            url: '<?php echo site_url('admin/eec/get_active_grant') ?>/' + this.value,
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
            url: '<?php echo site_url('admin/eec/get_list_participant') ?>',
            data: {
                grant_id : grant_id,
                fiscal_year : fiscal_year
            },
            dataType: 'JSON',
            success: function(r) {
                $(".wrap-table-list").append(r)
                $(load).hide();
                $('.chk-all').on('click', function(event){
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
        if(fiscal == ''){
            $(".validation-error-fiscal").css('display', 'block');
            $(".validation-error-fiscal").focus();
            return false;
        }
        $(".btn-s-pdo").html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop('disabled', true);
        var error = function() {
            var error = 1;
            $.ajax({
                async: false,
                type: 'GET',
                url: '<?php echo site_url('admin/eec/check/') ?>'+fiscal,
                dataType: 'JSON',
                success: function(r) {
                    console.log(r.error)
                    error = r.error;
                }
            });
            return error;
        }();
        if(error == 0){
            $("#form").submit();
            setTimeout(function(){ window.location = "<?= base_url('admin/eec/manage') ?>" }, 3000);
        }else{
            $("#label-alert").html('PDO with Fiscal year '+fiscal+' already exists!');
            $("#error-alert").removeClass('hide');
            $(".btn-s-pdo").html('Submit').prop('disabled', false);
        }
    })
    

    $(".btn-s-pdo-edit").click(function(){
        var fiscal = $("#fiscal_year").val();
        if(fiscal == ''){
            $(".validation-error-fiscal").css('display', 'block');
            $(".validation-error-fiscal").focus();
            return false;
        }
        $(".btn-s-pdo-edit").html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop('disabled', true);
        $("#form").submit();
        setTimeout(function(){ window.location = "<?= base_url('admin/eec/manage') ?>" }, 3000);
    })
    
    function view_tnc(element) {
        var $el = $(element);
        var base_url = '<?= base_url(); ?>';

        var fileDownload = $el.data('filedownload');

        function getStatus(status) {
            var statuses = {
                1: ['Accepted', 'success'],
                2: ['Revise', 'warning'],
                3: ['Reject', 'danger']
            };

            return statuses[status] || ['Submitted', 'primary'];
        }
        function updateDocument(type, data) {
            var uploaded = data.url !== '';
            var status = uploaded
                ? getStatus(data.status)
                : ['Not Uploaded', 'default'];

            $('#status_' + type)
                .html(status[0])
                .attr('class', 'badge badge-' + status[1]);

            // Preview image
            $('#image_preview' + (type === 'consent' ? '_consent' : ''))
                .attr('src', data.image);

            // Date & note
            $('#' + type + '_date').html(uploaded ? data.date : '');
            $('#note_' + type).val(uploaded ? data.note : '');

            // View button
            $('#view_' + type)
                .toggleClass('hide', !uploaded && !data.view);

            // Document link
            $('#url_' + type)
                .attr('href', uploaded ? base_url + data.url : 'javascript:;')
                .attr('title', uploaded ? data.title : '');

            // Download button
            $('#btn-download-' + type)
                .toggleClass('hide', !uploaded)
                .attr('href', uploaded ? base_url + data.url : '#')
                .attr('download', uploaded ? data.title : '')
                .html(
                    uploaded
                        ? data.title + ' <i class="fa fa-download fa-fw text-white"></i>'
                        : 'Not Uploaded'
                );
        }

        // General
        $('#info-grantee').html(
            $el.data('grantee') + ' (' + $el.data('grant') + ')'
        );

        $('#grantee_grant_id').val($el.data('granteegrantid'));

        // TNC
        updateDocument('tnc', {
            url: $el.data('tnc'),
            image: $el.data('imagepreview'),
            date: $el.data('tncdate') || '-',
            view: $el.data('viewtnc'),
            status: $el.data('tncstatus'),
            note: $el.data('tncnote'),
            title: fileDownload + ' Terms and Conditions'
        });

        // Consent
        updateDocument('consent', {
            url: $el.data('consentletter'),
            image: $el.data('imagepreviewconsent'),
            date: $el.data('consentdate') || '-',
            view: $el.data('viewconsent'),
            status: $el.data('consentstatus'),
            note: $el.data('consentnote'),
            title: fileDownload + ' Consent Letter'
        });
    }

    function show_preview(element, type, upload_type) {
        const file = element.files[0];
        // const filetype = file.name.split('.').pop();
        // const allowed_extensions = ['jpg', 'jpeg', 'png', 'pdf', 'docx', 'doc'];

        // const is_valid_extension = allowed_extensions.some(function(extension) {
        //     return filetype.toLowerCase().endsWith(extension);
        // });

        // if (is_valid_extension > 0) {
        
        // } else {
        //     let current_src = $('#preview_image_' + type).attr('src');
        //     $('#preview_image_' + type).attr('src', current_src);
        // }
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


    tinymce.init({
        selector: '.editor',
        height: 300,
        menubar: false,
        // plugins: 'link table lists',
        // toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | link | numlist bullist',
        plugins: false,
        toolbar: false,
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
</script>