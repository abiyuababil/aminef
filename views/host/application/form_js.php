<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<script>

    function copyURL(element) {
        let url = $(element).data('url');
    
        navigator.clipboard.writeText(url)
        .then(function() {
            Swal.fire({
                icon: "success",
                title: "Successfully copied",
                showConfirmButton: false,
                timer: 1500
            });
        })
    }

    function set_validation_messages() {
        $('input[required], textarea[required], select[required]').each(function() {
            
            let $input = $(this);
            let type = $input.attr('type') || 'text';
            let label = $input.closest('.form-group').find('label').first().text().replace('*', '').trim();
            
            if(!label) {
                label = $input.attr('placeholder') || 'Field ini';
            }
            
            if(type === 'file') {
                
                $input.attr('data-file-required', 'true');
                $input.attr('data-file-label', label);
            }
            
            this.addEventListener('invalid', function(e) {
                var message = '';
                if(this.validity.valueMissing) {
                    if(type === 'file') {
                        console.log('label', label);
                        message = 'Mohon pilih file untuk ' + label;
                    } else if(type === 'email') {
                        message = 'Mohon isi ' + label;
                    } else if(type === 'checkbox' || type === 'radio') {
                        message = 'Mohon centang ' + label;
                    } else if(this.tagName === 'SELECT') {
                        message = 'Mohon pilih ' + label;
                    } else {
                        message = 'Mohon isi ' + label;
                    }
                } else if(this.validity.typeMismatch && type === 'email') {
                    message = 'Format email tidak valid';
                }

                e.preventDefault();
                this.setCustomValidity(message);

                try {
                    var $parent = $(this).closest('.form-group');
                    var $fileContainer = $parent.find('.file-input-container');
                    if($fileContainer.length) {
                        $fileContainer.find('p.text-required').remove();
                        if(message) {
                            $fileContainer.append('<p class="text-required text-danger">' + message + '</p>');
                        }
                    } else {
                        $parent.find('p.text-required').remove();
                        if(message) {
                            $parent.append('<p class="text-required text-danger">' + message + '</p>');
                        }
                    }
                } catch (err) {
                    console.error(err);
                }
            });

            this.addEventListener('input', function() {
                this.setCustomValidity('');
                try { $(this).closest('.form-group').find('p.text-required').remove(); } catch (err) {}
            });

            this.addEventListener('change', function() {
                this.setCustomValidity('');
                try {
                    var $parent = $(this).closest('.form-group');
                    $parent.find('p.text-required').remove();
                    var $fileContainer = $parent.find('.file-input-container');
                    if($fileContainer.length) $fileContainer.find('p.text-required').remove();
                } catch (err) {}
            });
        });
    }
    
    $(document).ready(function() {
        set_validation_messages();
    });

    $('.have_other').change(function() {
        let id = $(this).data('id');
        if ($(this).is(':checked') && ($(this).val() == 'Other' || $(this).val() == 'Lainnya')) {
            $('.text-other-'+id).show();
            if($(this).hasClass('is_required')){
                $('.text-other-'+id).prop('required', true);
            }
        }else{
            $('.text-other-'+id).hide();
            if($(this).hasClass('is_required')){
                $('.text-other-'+id).prop('required', false);
            }
        }
    })

    $(document).on('change', 'input[data-show]', function() {
        let $el = $(this);
        let show_element = $el.data('show');
        let parent_id = $el.closest('div').attr('id');

        if ($el.is(':checkbox')) {
            let $target = parent_id ? $('#' + parent_id + ' .show-group[data-element="' + show_element + '"]') : $('[data-element="' + show_element + '"]');
            if ($el.is(':checked')) {
                $target.removeClass('hide');
                $target.find(':input').prop('disabled', false);
            } else {
                $target.addClass('hide');
                $target.find(':input').prop('disabled', true);
            }
        } else if ($el.is(':radio')) {
            let name = $el.attr('name');
            $('input[name="' + name + '"]').each(function() {
                let element_to_hide = $(this).data('show');
                let $t = parent_id ? $('#' + parent_id + ' [data-element="' + element_to_hide + '"]') : $('[data-element="' + element_to_hide + '"]');
                $t.addClass('hide');
                $t.find(':input').prop('disabled', true);
            });
            let $showTarget = parent_id ? $('#' + parent_id + ' [data-element="' + show_element + '"]') : $('[data-element="' + show_element + '"]');
            $showTarget.removeClass('hide');
            $showTarget.find(':input').prop('disabled', false);
        }
    });

    $('.show-group.hide').find(':input').prop('disabled', true);


    $("form").submit(function(e){
        e.preventDefault();
        
        let form = this;
        
        let missing_files = [];
        let first_error_element = null;
        
        $('input[type="file"][data-file-required="true"]').each(function() {
            let $input = $(this);
            let field_id = $input.attr('data-id');
            let $wrapper = $input.closest('.file-upload-wrapper');
            let has_existing_file = $wrapper.find('input[name="existing_file_' + field_id + '"]').val();
            let has_new_file = this.files && this.files.length > 0;
            
            if(!has_existing_file && !has_new_file) {
                let label = $input.closest('.form-group').find('label').first().text().replace('*', '').trim() || 'Field';
                missing_files.push(label);

                if(!first_error_element) {
                    first_error_element = $input.closest('.form-group');
                }

                $input.closest('.form-group').addClass('has-error');
                try {
                    let $fileContainer = $input.closest('.form-group').find('.file-input-container');
                    if($fileContainer.length){
                        $fileContainer.find('p.text-required').remove();
                        $fileContainer.append('<p class="text-required text-danger">Mohon pilih file untuk ' + label + '</p>');
                    } else {
                        $input.closest('.form-group').find('p.text-required').remove();
                        $input.closest('.form-group').append('<p class="text-required text-danger">Mohon pilih file untuk ' + label + '</p>');
                    }
                } catch (err) {}
            }
        });
        
        if(missing_files.length > 0) {
            let message = 'Mohon lengkapi file berikut:\n\n';
            missing_files.forEach(function(label, index) {
                message += (index + 1) + '. ' + label + '\n';
            });
            
            Swal.fire({
                icon: 'warning',
                title: 'File Belum Lengkap',
                text: message,
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'swal-wide'
                }
            });
            
            if(first_error_element) {
                $('html, body').animate({
                    scrollTop: first_error_element.offset().top - 100
                }, 500);
            }
            
            return false;
        }
        
        if(!form.checkValidity()) {
            var invalids = $(form).find(':input:invalid');
            if(invalids.length){
                var first = invalids.first();
                invalids.each(function(){
                    var $el = $(this);
                    var type = $el.attr('type') || 'text';
                    var label = $el.closest('.form-group').find('label').first().text().replace('*','').trim() || $el.attr('placeholder') || 'Field';
                    var message = '';
                    if(this.validity.valueMissing){
                        if(type === 'file') message = 'Mohon pilih file untuk ' + label;
                        else if(type === 'email') message = 'Mohon isi ' + label;
                        else if($el.is(':checkbox') || $el.is(':radio')) message = 'Mohon pilih ' + label;
                        else if(this.tagName === 'SELECT') message = 'Mohon pilih ' + label;
                        else message = 'Mohon isi ' + label;
                    } else if(this.validity.typeMismatch && type === 'email'){
                        message = 'Format email tidak valid';
                    }
                    $el.closest('.form-group').find('p.text-required').remove();
                    if(message){
                        $el.closest('.form-group').append('<p class="text-required text-danger">' + message + '</p>');
                    }
                });

                // scroll to first error
                $('html, body').animate({ scrollTop: first.closest('.form-group').offset().top - 100 }, 500);
            }
            return false;
        }
        
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin data yang Anda isi sudah sesuai?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Kirim Pengajuan',
            cancelButtonText: 'Periksa Kembali',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            reverseButtons: true
        }).then((result) => {
            if(!result.isConfirmed) {
                return;
            }
            
            let formData = new FormData(form);
            formData.append('final', '1');
            $.ajax({
                url: "<?= base_url('eta/application/autosave'); ?>",
                method: "POST",
                dataType: "JSON",
                data: formData,
                processData: false,
                contentType: false
            })
            .done(function(res){
                if(res && res.success){
                    let id = res.id;
                    if(id){
                        if($(form).find('input[name="submission_id"]').length === 0){
                            $('<input/>', {type:'hidden', name:'submission_id', value:id}).appendTo(form);
                        } else {
                            $(form).find('input[name="submission_id"]').val(id);
                        }
                        Swal.fire({
                            icon: "success",
                            title: "Pengajuan berhasil dikirim.",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            window.location.reload();
                        });
                    }
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Gagal mengirim pengajuan",
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            });
        });
    });

    function validationCheckbox(element)
    {
        if($(element).hasClass('is_required')){
            if($(element).is(':checked')){
                $(element).closest('.form-group').find('input[type="checkbox"]').prop('required', false);
            }else{
                $(element).closest('.form-group').find('input[type="checkbox"]').prop('required', true);
            }
        }
    }

    $('.select2-country').select2({
        placeholder: "Select a country",
    });

    $('.select2-level-of-study').select2({
        placeholder: "Select a level of study",
    });

    $('.select2-state').select2({
        placeholder: "Select a state",
        ajax: {
            url: function (params) {
                let key_of_unique = $(this).data('select_key_country');
                let country_id = $(".select2-country[data-select_key_country='"+key_of_unique+"']").val();
                return '<?php echo site_url('world/data_state_panellist') ?>' + (country_id ? '/' + country_id : '');
            },
            dataType: 'json'
        }
    });

    $('.select2-city').select2({
        placeholder: "Select a city",
        ajax: {
            url: function (params) {
                let key_of_unique = $(this).data('select_key_country');
                console.log("unique", key_of_unique);
                let state_id = $(".select2-state[data-select_key_country='"+key_of_unique+"']").val();
                return '<?php echo site_url('world/data_city_panellist') ?>' + (state_id ? '/' + state_id : '');
            },
            dataType: 'json'
        }
    });
    
    $('.select2-parent-field-of-study').select2({
        placeholder: "Select Field of Study",
    });
    
    $('.select2-field-of-study').select2({
        placeholder: "Select Specialization",
        ajax: {
            url: function (params) {
                let key_of_unique = $(this).data('select_key_state_of_study');
                let parent_id = $(".select2-parent-field-of-study[data-select_key_state_of_study='"+key_of_unique+"']").val();
                return '<?php echo site_url('world/field_of_study') ?>' + (parent_id ? '/' + parent_id : '');
            },
            dataType: 'json'
        }
    });
    
    $(".select2-parent-field-of-study").on('select2:select', function() {
        let current_value = $(this).select2('data')[0].text;
        if (current_value == 'Other' || current_value == 'Lainnya') {
            let other_input_element = $(this).closest('div').find(".text-have-other");
            other_input_element.show();
        }
        
        $(this).trigger('blur');
        let key_of_unique = $(this).data('select_key_state_of_study');
        $(".select2-field-of-study[data-select_key_state_of_study='" + key_of_unique + "']").val(null).trigger('change').trigger('blur');
    });
    $(".select2-field-of-study").on('select2:select', function() {
        let current_value = $(this).select2('data')[0].text;
        if (current_value == 'Other' || current_value == 'Lainnya') {
            let other_input_element = $(this).closest('div').find(".text-have-other");
            other_input_element.show();
        }
        
        $(this).trigger('blur');
    });

    function copyForm(id) {
        Swal.fire({
            title: "Input Title",
            input: "text",
            inputAttributes: {
                autocapitalize: "off"
            },
            showCancelButton: true,
            confirmButtonText: "Copy",
            showLoaderOnConfirm: true,
            preConfirm: async (inputValue) => {
                if (!inputValue) {
                    Swal.showValidationMessage('Title is required');
                    return false;
                }

                try {
                    const url = `<?= base_url('admin/eta_host_school_application/copy_form/')?>` + id;
                    const response = await fetch(url, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ title: inputValue })
                    });

                    console.log(response)
                    if (!response.ok) {
                        const errorData = await response.json();
                        return Swal.showValidationMessage(errorData.message);
                    }

                    const result = await response.json();
                    return result;

                } catch (error) {
                    Swal.showValidationMessage(`Something went wrong`);
                }
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: 'Form copied successfully!',
                    text: result.value.message || 'Copy successful.'
                }).then(() => {
                    window.location.href = '<?= base_url('admin/eta_host_school_application/manage')?>';
                });
            }
        });
    }

    $(document).on('click', '.confirm-del-form', function (e) {
        e.preventDefault();

        let id = $(this).data('id');
        let url = $(this).data('url');

        $.ajax({
            url: '<?= site_url("admin/eta_host_school_application/check_relation") ?>',
            type: 'POST',
            data: {id: id},
            dataType: 'json',
            success: function (response) {
                let msg = response.has_relation
                            ? "This data is related to other records. Are you sure you want to delete it?"
                            : "Are you sure you want to delete this data?";

                Swal.fire({
                    title: 'Delete Confirmation',
                    text: msg,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            }
        });
    });

    $('.datepicker').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd M yy"
    });

    $(".datetime").datetimepicker({
        format: 'dd M yy hh:ii',
        autoclose: true,
    });

    (function(){
        let application_status = '<?php echo isset($status) ? $status : 0 ?>';
        
        if(application_status == 1){
            return; 
        }

        let form = document.querySelector('form');
        if(!form) return;
        let saving = false;
        let timer = null;
        let has_submission_id = false;
        let $form = $(form);
        let $status = $('<div/>').css({position:'fixed',bottom:'15px',right:'15px',background:'#f5f5f5',border:'1px solid #ddd',padding:'6px 10px',borderRadius:'4px',boxShadow:'0 1px 3px rgba(0,0,0,0.08)',zIndex:1000,fontSize:'12px',color:'#333'}).appendTo('body');
        
        if($form.find('input[name="submission_id"]').length > 0){
            has_submission_id = true;
        }
        
        function set_status(text, color){
            $status.text(text || '');
            if(color) $status.css('color', color);
        }

        function do_save(){
            if(saving) return;
            saving = true;
            set_status('Menyimpan…', '#666');
            let form_data = new FormData(form);
            
            let file_inputs = form.querySelectorAll('input[type="file"]');
            file_inputs.forEach(function(input){
                if(!input.files || input.files.length === 0){
                    form_data.delete(input.name);
                }
            });
            
            $.ajax({
                url: "<?= base_url('eta/application/autosave'); ?>",
                method: 'POST',
                data: form_data,
                dataType: 'json',
                processData: false,
                contentType: false
            }).done(function(res){
                if(res && res.success){
                    if(res.id){
                        let $hidden_id = $form.find('input[name="submission_id"]');
                        if($hidden_id.length === 0){
                            $('<input/>', {type:'hidden', name:'submission_id', value:res.id}).appendTo($form);
                        } else {
                            $hidden_id.val(res.id);
                        }
                        
                        let $header_row = $('#pdf-status-container');
                        
                        if($header_row.find('.status-badge').length === 0){
                            let download_url = '<?= base_url("eta/application/pdf/") ?>' + res.id;
                            let $status_badge = $('<a href="javascript:void(0)" onclick="showPdfPopup(\'' + download_url + '\')" class="btn btn-outline btn-default pull-right mr-2 status-badge" data-toggle="tooltip" title="Klik untuk lihat PDF"><i class="fa fa-pencil-o"></i> Pratinjau</a>');
                            
                            $header_row.prepend($status_badge);
                        }
                    }
                    
                    if(res.files && typeof res.files === 'object'){
                        for(let field_id in res.files){
                            let file_path = res.files[field_id];
                            if(file_path){
                                update_file_preview(field_id, '<?= base_url() ?>' + file_path);
                                
                                let $input = $form.find('input[name="' + field_id + '"]');
                                if($input.length && $input.attr('type') === 'file'){
                                    $input.val('');
                                }
                                
                                $('#file-name-' + field_id).text('');
                            }
                        }
                        
                        setTimeout(function(){
                            $('.file-preview-link').each(function(){
                                if(typeof lightbox !== 'undefined' && lightbox.init){
                                    lightbox.init();
                                }
                            });
                        }, 200);
                    }
                    
                    set_status('Tersimpan otomatis ' + (new Date()).toLocaleTimeString(), '#2c7a7b');
                } else {
                    set_status('Gagal menyimpan otomatis', '#c53030');
                }
            }).fail(function(){
                set_status('Gagal menyimpan otomatis', '#c53030');
            }).always(function(){
                saving = false;
            });
        }
        
        function debounce(){
            if(timer) clearTimeout(timer);
            timer = setTimeout(do_save, 800);
        }
        
        $form.on('input change', ':input:not([type="file"]):not([type="radio"])', debounce);
        
        $form.on('change', 'input[type="radio"]', function(){
            if(timer) clearTimeout(timer);
            timer = setTimeout(do_save, 300);
        });
        
        $form.on('change', 'input[type="file"]', function(){
            let $input = $(this);
            let field_id = $input.data('id');
            
            if(this.files && this.files.length > 0){
                let file = this.files[0];
                let file_name = file.name;
                let file_size = file.size;
                let max_size = 5 * 1024 * 1024;
                
                if(file_size > max_size){
                    Swal.fire({
                        icon: 'error',
                        title: 'File terlalu besar',
                        text: 'Maksimal ukuran file adalah 5MB. File Anda: ' + (file_size / 1024 / 1024).toFixed(2) + 'MB'
                    });
                    $input.val('');
                    return;
                }
                
                $input.closest('.form-group').removeClass('has-error');
                
                // remove inline validation message if present (file-input-container or form-group)
                try {
                    let $fileContainer = $input.closest('.form-group').find('.file-input-container');
                    if($fileContainer.length){
                        $fileContainer.find('p.text-required').remove();
                    }
                    $input.closest('.form-group').find('p.text-required').remove();
                } catch (err) {}

                let $name_display = $('#file-name-' + field_id);
                if($name_display.length){
                    $name_display.text(file_name).css('color', '#2c7a7b');
                }
                
                set_status('Mengupload file...', '#666');
                
                if(timer) clearTimeout(timer);
                timer = setTimeout(do_save, 300);
            }
        });
    })();

    $(document).on('click', '.btn-remove-file', function(e){
        e.preventDefault();
        e.stopPropagation();
        
        let field_id = $(this).data('field-id');
        let $wrapper = $(this).closest('.file-upload-wrapper');
        
        Swal.fire({
            title: 'Hapus File?',
            text: 'File akan dihapus saat autosave berikutnya',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $wrapper.find('.file-preview-container').remove();
                $wrapper.find('input[name="existing_file_' + field_id + '"]').remove();
                
                if($wrapper.find('.file-input-container').length === 0) {
                    let $new_container = $('<div class="file-input-container"></div>');
                    $new_container.html(`
                        <input type="file" data-id="${field_id}" name="${field_id}" id="file-input-${field_id}" class="file-input-field" style="display:none;" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx">
                        <label for="file-input-${field_id}" class="btn btn-sm btn-primary" style="cursor:pointer; margin:0;"><i class="fa fa-folder-open"></i> Pilih File</label>
                        <span class="file-name-display" id="file-name-${field_id}" style="margin-left:10px; color:#666; font-size:13px;"></span>
                        <div style="margin-top:5px; font-size:11px; color:#999;">File PDF Maksimum 5MB</div>
                    `);
                    $wrapper.append($new_container);
                } else {
                    let $container = $wrapper.find('.file-input-container');
                    $container.empty();
                    $container.html(`
                        <input type="file" data-id="${field_id}" name="${field_id}" id="file-input-${field_id}" class="file-input-field" style="display:none;" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx">
                        <label for="file-input-${field_id}" class="btn btn-sm btn-primary" style="cursor:pointer; margin:0;"><i class="fa fa-folder-open"></i> Pilih File</label>
                        <span class="file-name-display" id="file-name-${field_id}" style="margin-left:10px; color:#666; font-size:13px;"></span>
                        <div style="margin-top:5px; font-size:11px; color:#999;">File PDF Maksimum 5MB</div>
                    `);
                }
                
                let is_required = $wrapper.data('originally-required');
                if(is_required){
                    $wrapper.find('input[type="file"]').prop('required', true);
                }
                
                set_validation_messages();
                
                let form = document.querySelector('form');
                if(form) {
                    setTimeout(function() {
                        $(form).find('input:not([type="file"]):first').trigger('change');
                    }, 100);
                }
                
                Swal.fire('Terhapus!', 'File berhasil dihapus.', 'success');
            }
        });
    });

    function update_file_preview(field_id, file_url) {
        let $wrapper = $('div[data-field-id="' + field_id + '"]');
        
        if(!$wrapper.length) {
            console.error('No wrapper found for field:', field_id);
            return;
        }
        
        let $preview = $wrapper.find('#preview-' + field_id);
        
        if($preview.length === 0) {
            $preview = $('<div class="file-preview-container" id="preview-' + field_id + '" style="margin-bottom:15px;"></div>');
            $wrapper.prepend($preview);
        }
        
        let file_ext = file_url.split('.').pop().toLowerCase();
        let preview_url = file_url;
        
        if(['jpg', 'jpeg', 'png'].indexOf(file_ext) > -1) {
            preview_url = file_url;
        } else if(file_ext === 'pdf') {
            preview_url = '<?= base_url("assets/images/icons/pdf.svg") ?>';
        } else if(['doc', 'docx', 'xls', 'xlsx'].indexOf(file_ext) > -1) {
            preview_url = '<?= base_url("assets/images/icons/document-filetype.png") ?>';
        } else if(['zip', 'gzip', 'rar'].indexOf(file_ext) > -1) {
            preview_url = '<?= base_url("assets/images/icons/compressed-filetype.png") ?>';
        } else {
            preview_url = '<?= base_url("assets/images/icons/download icon.png") ?>';
        }
        
        let preview_html = `
            <div style="margin-bottom:10px;">
                <a href="${file_url}" class="lightbox file-preview-link" data-lightbox="file-${field_id}" aria-haspopup="dialog">
                    <img src="${preview_url}" style="max-width:150px; max-height:150px; object-fit:contain; border:1px solid #ddd; border-radius:4px; padding:5px; background:#f9f9f9;">
                </a>
            </div>
            <div style="margin-top:10px;">
                <a href="${file_url}" download class="btn btn-sm btn-primary" style="margin-right:5px;" title="Download">
                    <i class="fa fa-download"></i>
                </a>
                <button type="button" class="btn btn-sm btn-danger btn-remove-file" data-field-id="${field_id}" style="margin-right:5px;" title="Hapus">
                    <i class="fa fa-trash"></i>
                </button>
                <label for="file-input-${field_id}" class="btn btn-sm btn-default" style="cursor:pointer; margin:0;">
                    <i class="fa fa-folder-open"></i> Pilih File
                </label>
                <input type="file" data-id="${field_id}" name="${field_id}" id="file-input-${field_id}" class="file-input-field" style="display:none;" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx">
            </div>
            <div style="margin-top:5px; font-size:11px; color:#999;">File PDF Maksimum 5MB</div>
        `;
        
        $preview.html(preview_html).show();
        
        setTimeout(function() {
            $('.lightbox').topbox();
        }, 100);
        
        $wrapper.find('.file-input-container').remove();
        
        let $existing_input = $wrapper.find('input[name="existing_file_' + field_id + '"]');
        if($existing_input.length === 0){
            $('<input type="hidden" name="existing_file_' + field_id + '" value="' + file_url.replace('<?= base_url() ?>', '') + '">').appendTo($wrapper);
        } else {
            $existing_input.val(file_url.replace('<?= base_url() ?>', ''));
        }
        
        $wrapper.find('input[type="file"]').prop('required', false);
        
        set_validation_messages();
    }

    window.show_pdf_popup = function(pdfUrl) {
        $('#pdfModal').modal('show');
        document.getElementById('pdfViewer').src = '';
        document.getElementById('downloadPdfBtn').href = '#';
        document.getElementById('downloadPdfBtn').removeAttribute('download');
        
        $.ajax({
            url: pdfUrl,
            type: 'GET',
            dataType: 'JSON',
            success: function(response) {
                if (response && response.fileurl) {
                    document.getElementById('pdfViewer').src = response.fileurl + '#toolbar=0&navpanes=0&scrollbar=1&view=FitH';
                    document.getElementById('downloadPdfBtn').href = response.fileurl;
                    document.getElementById('downloadPdfBtn').setAttribute('download', response.filename || 'document.pdf');
                }
            },
            error: function(response) {
                Swal.fire({
                    title: "Gagal memuat PDF",
                    text: response.responseText || "Terjadi kesalahan",
                    icon: "warning",
                    customClass: 'swal-custom'
                });
                $('#pdfModal').modal('hide');
            }
        });
    }

    $('#pdfModal').on('hidden.bs.modal', function () {
        document.getElementById('pdfViewer').src = '';
    });

</script>