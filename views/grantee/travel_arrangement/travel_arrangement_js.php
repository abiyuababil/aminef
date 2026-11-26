<script>
const BASE_URL = '<?= base_url() ?>';

function show_preview_modal(content_html) {
    const $modal = $('#preview-modal');
    const $modal_body = $('#preview-modal-body');

    $modal_body.html(content_html);
    $modal.addClass('show');
}

function close_preview_modal() {
    const $modal = $('#preview-modal');
    const $modal_body = $('#preview-modal-body');

    $modal.removeClass('show');
    setTimeout(function() {
        $modal_body.html('');
    }, 300);
}

function show_preview_travel(element, type) {
    if (!element || !element.files || element.files.length === 0) return;

    const file = element.files[0];
    const filetype = (file.name.split('.').pop() || '').toLowerCase();
    const allowed_extensions = ['jpg', 'jpeg', 'png', 'pdf'];

    if (!allowed_extensions.includes(filetype)) {
        const $input = $(element);
        const $container = $input.closest('.form-group');

        $container.find('.travel-inline-error[data-error-key="invalid-file-type"]').remove();
        $container.append('<p class="text-required text-danger travel-inline-error" data-error-key="invalid-file-type">Supported format: JPG, PNG, PDF.</p>');
        $input.val('');
        return false;
    }

    const reader = new FileReader();
    reader.onload = function(e) {
        const fileDataUrl = e.target.result;
        let preview_url;
        const $previewLink = $('#preview_link_' + type);
        const $previewImage = $('#preview_image_' + type);

        if (['jpg', 'jpeg', 'png'].includes(filetype)) {
            preview_url = fileDataUrl;
            $previewImage.attr('src', preview_url);
            $previewLink.attr('href', preview_url)
                .attr('data-preview-type', 'image')
                .attr('data-preview-url', preview_url);
        } else if (filetype === 'pdf') {
            preview_url = BASE_URL + 'assets/images/icons/pdf.svg';
            $previewImage.attr('src', preview_url);

            $previewLink.attr('href', '#')
                .attr('data-preview-type', 'pdf')
                .attr('data-preview-url', fileDataUrl);
        } else {
            preview_url = BASE_URL + 'assets/images/icons/document-filetype.png';
            $previewImage.attr('src', preview_url);
            $previewLink.attr('href', fileDataUrl)
                .attr('data-preview-type', 'other')
                .attr('target', '_blank');
        }

        $('#button_download_' + type).addClass('hide');
    };
    reader.readAsDataURL(file);
}

$(document).ready(function() {
    const default_type = $('.option-card.selected input[type="radio"]').val() || 'self';
    load_tab_content(default_type);
    let is_choosing_flight_option_file = false;


    $('.option-card').on('click', function() {
        $('.option-card').removeClass('selected');
        $(this).addClass('selected');
        $(this).find('input[type="radio"]').prop('checked', true);

        let selected_val = $(this).find('input[type="radio"]').val();
        load_tab_content(selected_val);
    });

    function escape_html(value) {
        return $('<div>').text(value || '').html();
    }

    function normalize_money_value(amount, currency = 'USD') {
        if (amount === null || amount === undefined || amount === '') {
            return null;
        }

        let value = String(amount).trim();

        // Remove currency symbols and spaces
        value = value.replace(/[^\d.,-]/g, '');

        if (!value) {
            return null;
        }

        currency = (currency || 'USD').toUpperCase();

        if (currency === 'IDR') {
            if (value.includes(',')) {
                // Comma = decimal separator: 15.000,00 or 15000,50
                value = value.replace(/\./g, '');
                value = value.replace(',', '.');
            } else if (/^\d+\.\d{1,2}$/.test(value)) {
                // Raw DB/code float like 15000.00
            } else {
                // Dot = thousand separator: 15.000
                value = value.replace(/\./g, '');
            }
        } else if (currency === 'USD') {
            if (value.includes(',') && value.includes('.')) {
                value = value.replace(/,/g, '');
            } else if (value.includes(',')) {
                if (/,\d{3}/.test(value)) {
                    value = value.replace(/,/g, '');
                } else {
                    value = value.replace(',', '.');
                }
            }
        }

        const parts = value.split('.');
        if (parts.length > 2) {
            value = parts[0] + '.' + parts.slice(1).join('');
        }

        const parsed = parseFloat(value);

        return Number.isNaN(parsed) ? null : parsed;
    }

    function format_money_client(amount, currency) {
        currency = (currency || 'USD').toUpperCase();
        const parsed = normalize_money_value(amount, currency);
        if (parsed === null) {
            return null;
        }

        if (currency === 'IDR') {
            return 'Rp. ' + parsed.toLocaleString('id-ID', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        if (currency === 'USD') {
            return '$' + parsed.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        return parsed.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function format_money_input(amount, currency, withDecimals = true) {
        currency = (currency || 'USD').toUpperCase();
        const parsed = normalize_money_value(amount, currency);
        if (parsed === null) {
            return null;
        }

        const minFraction = withDecimals ? 2 : 0;
        const maxFraction = 2;

        if (currency === 'IDR') {
            return parsed.toLocaleString('id-ID', {
                minimumFractionDigits: minFraction,
                maximumFractionDigits: maxFraction
            });
        }

        return parsed.toLocaleString('en-US', {
            minimumFractionDigits: minFraction,
            maximumFractionDigits: maxFraction
        });
    }

    function ensure_inline_validation_styles() {
        if ($('#travel-inline-validation-style').length) {
            return;
        }

        $('<style id="travel-inline-validation-style">'
            + '.travel-input-error{border-color:#dc3545 !important;box-shadow:0 0 0 0.2rem rgba(220,53,69,.15);}'
            + '.tox-tinymce.travel-input-error,.select2-container .select2-selection.travel-input-error{border-color:#dc3545 !important;box-shadow:0 0 0 0.2rem rgba(220,53,69,.15) !important;}'
            + '.travel-inline-error{margin-top:6px;margin-bottom:0;}'
            + '.travel-form-alert{margin-bottom:15px;}'
            + '.flight-option-item.has-travel-error,.upload-group.has-travel-error{border-color:#dc3545 !important;box-shadow:inset 0 0 0 1px rgba(220,53,69,.15);}'
            + '</style>').appendTo('head');
    }

    function get_editor_text(field_id) {
        if (typeof tinymce === 'undefined') {
            return '';
        }

        const editor = tinymce.get(field_id);
        if (!editor) {
            return '';
        }

        return (editor.getContent({ format: 'text' }) || '').trim();
    }

    function get_field_container($field) {
        const $form_group = $field.closest('.form-group');
        return $form_group.length ? $form_group : $field.parent();
    }

    function set_field_state($field, has_error) {
        if (!$field || !$field.length) {
            return;
        }

        if ($field.is(':radio')) {
            const field_name = $field.attr('name');
            if (field_name) {
                $field.closest('form').find('input[name="' + field_name + '"]').toggleClass('travel-input-error', has_error);
            }
        } else {
            $field.toggleClass('travel-input-error', has_error);
        }

        if ($field.hasClass('select2-hidden-accessible')) {
            $field.next('.select2-container').find('.select2-selection').toggleClass('travel-input-error', has_error);
        }

        const field_id = $field.attr('id');
        if (field_id && typeof tinymce !== 'undefined') {
            const editor = tinymce.get(field_id);
            if (editor && editor.getContainer) {
                $(editor.getContainer()).toggleClass('travel-input-error', has_error);
            }
        }
    }

    function clear_error_by_key($container, error_key) {
        if (!$container || !$container.length) {
            return;
        }

        $container.find('.travel-inline-error[data-error-key="' + error_key + '"]').remove();
    }

    function set_container_error($container, message, error_key) {
        if (!$container || !$container.length) {
            return;
        }

        clear_error_by_key($container, error_key);
        $container.append('<p class="text-required text-danger travel-inline-error" data-error-key="' + escape_html(error_key) + '">' + escape_html(message) + '</p>');
    }

    function set_field_error($field, message, error_key) {
        const key = error_key || $field.attr('name') || $field.attr('id') || 'field';
        set_field_state($field, true);
        set_container_error(get_field_container($field), message, key);
    }

    function clear_field_error($field, error_key) {
        const key = error_key || $field.attr('name') || $field.attr('id') || 'field';
        set_field_state($field, false);
        clear_error_by_key(get_field_container($field), key);
    }

    function clear_form_errors($form) {
        $form.find('.travel-inline-error').remove();
        $form.find('.travel-form-alert').remove();
        $form.find('.travel-input-error').removeClass('travel-input-error');
        $form.find('.has-travel-error').removeClass('has-travel-error');
        $form.find('.tox-tinymce').removeClass('travel-input-error');
        $form.find('.select2-selection').removeClass('travel-input-error');
    }

    function show_form_error($form, message) {
        if (!message) {
            return;
        }

        $form.find('.travel-form-alert').remove();
        $form.prepend('<div class="alert alert-danger travel-form-alert">' + escape_html(message) + '</div>');
    }

    function focus_field($field) {
        if (!$field || !$field.length) {
            return;
        }

        const field_id = $field.attr('id');
        if (field_id && typeof tinymce !== 'undefined') {
            const editor = tinymce.get(field_id);
            if (editor) {
                editor.focus();
                return;
            }
        }

        $field.focus();
    }

    function focus_first_error($form) {
        const $field = $form.find('.travel-input-error:enabled:visible').first();
        if ($field.length) {
            focus_field($field);
        }
    }

    function get_field_value($field) {
        if ($field.is('textarea')) {
            const field_id = $field.attr('id');
            if (field_id) {
                const editor_text = get_editor_text(field_id);
                if (editor_text !== '') {
                    return editor_text;
                }
            }
        }

        return ($field.val() || '').toString().trim();
    }

    function is_field_visible_for_validation($field) {
        if ($field.is(':disabled') || $field.attr('type') === 'hidden' || $field.attr('type') === 'file') {
            return false;
        }

        const $container = get_field_container($field);
        return !$container.length || $container.is(':visible');
    }

    function validate_required_fields($form, action) {
        let is_valid = true;
        const handled_radio_names = {};

        if (action !== 'submit') {
            return true;
        }

        $form.find('[required]').each(function() {
            const $field = $(this);

            if (!is_field_visible_for_validation($field)) {
                return;
            }

            if ($field.is(':radio')) {
                const field_name = $field.attr('name');
                if (!field_name || handled_radio_names[field_name]) {
                    return;
                }

                handled_radio_names[field_name] = true;
                if (!$form.find('input[name="' + field_name + '"]:checked').length) {
                    set_field_error($field, 'This field is required.', field_name);
                    is_valid = false;
                }
                return;
            }

            if (get_field_value($field) === '') {
                set_field_error($field, 'This field is required.');
                is_valid = false;
            }
        });

        return is_valid;
    }

    function validate_travel_purposes() {
        const $field = $('#travel_purposes');

        if (!$field.length || $field.is(':disabled') || !$field.prop('required')) {
            return true;
        }

        const tpVal = get_field_value($field);
        if (tpVal === '') {
            set_field_error($field, 'This field is required.', 'travel_purposes');
            return false;
        }

        clear_field_error($field, 'travel_purposes');

        const isOther = ['other', 'others'].includes(tpVal.toLowerCase());
        if (isOther) {
            const $otherField = $('#travel_purposes_other');
            if ($otherField.length && !$otherField.is(':disabled')) {
                const otherVal = get_field_value($otherField);
                if (otherVal === '') {
                    set_field_error($otherField, 'This field is required.', 'travel_purposes_other');
                    return false;
                }
                clear_field_error($otherField, 'travel_purposes_other');
            }
        }

        return true;
    }

    function validate_flight_option_modal() {
        let is_valid = true;
        const $modal = $('#flight-option-modal');
        const $description = $('#flight-option-description');
        const $price = $('#flight-option-price');
        const $currency = $('#flight-option-currency');
        const valid_existing_count = (typeof modal_flight_existing_files !== 'undefined')
            ? modal_flight_existing_files.filter(f => f && f.file_path && f.file_path.trim() !== '').length
            : 0;
        const total_files = valid_existing_count
            + (typeof modal_flight_new_files !== 'undefined' ? modal_flight_new_files.length : 0);
        const file_name = ($('#flight-option-file-name').text() || '').trim();
        const type = $('#flight-option-modal-type').val();

        $modal.find('.travel-inline-error').remove();
        $modal.find('.travel-input-error').removeClass('travel-input-error');
        $modal.find('.tox-tinymce').removeClass('travel-input-error');

        if(type !== 'accommodation' && type !== 'other'){
            if (get_modal_description_text() === '') {
                set_field_error($description, 'This field is required.', 'flight-option-description');
                is_valid = false;
            }
        }

        const curr = ($currency.val() || 'USD').toUpperCase();
        const parsedPrice = normalize_money_value($price.val(), curr);
        if (parsedPrice === null || parsedPrice <= 0) {
            set_field_error($price, 'This field is required.', 'flight-option-price');
            is_valid = false;
        }

        if (($currency.val() || '').trim() === '') {
            set_field_error($currency, 'This field is required.', 'flight-option-currency');
            is_valid = false;
        }

        if (total_files === 0) {
            set_container_error($('#flight-option-modal-file-list').closest('.form-group'), 'This field is required.', 'flight-option-file');
            $('#flight-option-file-btn').addClass('travel-input-error');
            is_valid = false;
        }

        return is_valid;
    }

    function validate_flight_option_sections($form, action) {
        let is_valid = true;

        if (action !== 'submit' || !$form.is('#form-flight-proposal')) {
            return true;
        }

        let has_any_group = false;

        ['international', 'domestic', 'other', 'accommodation'].forEach(function(type) {
            const $container = $('#' + type + '-upload-container');
            const $groups = $container.find('.upload-group');

            clear_error_by_key($container, type + '_upload_container');

            if (!$groups.length) {
                return;
            }

            has_any_group = true;

            $groups.each(function() {
                const $group = $(this);
                const group_index = $group.data('index');
                const error_key = type + '_option_' + group_index;
                const file_input = document.getElementById('file_' + type + '_option_' + group_index);

                let existing_count = 0;
                try {
                    const parsed = JSON.parse($group.find('.flight-option-existing-files').val() || '[]');
                    existing_count = Array.isArray(parsed) ? parsed.filter(f => f && f.file_path && f.file_path.trim() !== '').length : 0;
                } catch (e) {}

                const has_file = existing_count > 0
                    || !!(file_input && file_input.files && file_input.files.length > 0);
                const errors = [];

                $group.removeClass('has-travel-error');
                clear_error_by_key($group.find('.form-group').first(), error_key);

                if(type !== 'accommodation' && type !== 'other'){
                    if (!($group.find('.flight-option-description').val() || '').trim()) {
                        errors.push('Description is required');
                    }
                }
                if (!($group.find('.flight-option-price').val() || '').trim()) {
                    errors.push('Price is required');
                }
                if (!($group.find('.flight-option-currency').val() || '').trim()) {
                    errors.push('Currency is required');
                }
                if (!has_file) {
                    errors.push('Attachment is required');
                }

                if (errors.length) {
                    $group.addClass('has-travel-error');
                    set_container_error($group.find('.form-group').first(), errors.join('. ') + '.', error_key);
                    is_valid = false;
                }
            });
        });

        if (!has_any_group) {
            show_form_error($form, 'Please add at least one International or Domestic flight option.');
            is_valid = false;
        }

        return is_valid;
    }

    function validate_reimbursement_sections($form, action) {
        let is_valid = true;

        if (action !== 'submit' || !$form.is('#form-reimbursement')) {
            return true;
        }

        const $container = $('#receipt-upload-container');
        const $groups = $container.find('.upload-group');

        clear_error_by_key($container, 'receipt_upload_container');

        if (!$groups.length) {
            set_container_error($container, 'This field is required.', 'receipt_upload_container');
            return false;
        }

        $groups.each(function() {
            const $group = $(this);
            const group_index = $group.data('index');
            const error_key = 'receipt_option_' + group_index;
            const file_input = document.getElementById('file_receipt_option_' + group_index);
            const href = ($group.find('a[aria-haspopup="dialog"]').first().attr('href') || '').trim();
            const has_existing_file = href !== '' && href !== '#';
            const has_file = has_existing_file || !!(file_input && file_input.files && file_input.files[0]);

            $group.removeClass('has-travel-error');
            clear_error_by_key($group.find('.form-group').first(), error_key);

            if (!has_file) {
                // $group.addClass('has-travel-error');
                // set_container_error($group.find('.form-group').first(), 'This field is required.', error_key);
                const $fileField = $group.find('input.custom-file-input');
                set_field_error($fileField, 'This field is required.', error_key);
                is_valid = false;
            }

            // Validate Final Price per option
            const $priceField = $group.find('input.receipt-price');
            const $currencyField = $group.find('select.receipt-currency');
            if ($priceField.length) {
                var currency = $currencyField.val();
                const priceVal = ($priceField.val() || '').trim();
                clear_field_error($priceField, 'receipt_price_' + group_index);
                if (priceVal === '') {
                    set_field_error($priceField, 'This field is required.', 'receipt_price_' + group_index);
                    is_valid = false;
                } else {
                    var cleanVal;
                    if (currency === 'IDR') {
                        cleanVal = priceVal
                            .replace(/\./g, '')
                            .replace(',', '.');
                    } else {
                        cleanVal = priceVal
                            .replace(/,/g, '');
                    }
                    
                    if (isNaN(cleanVal) || parseFloat(cleanVal) < 0) {
                        set_field_error($priceField, 'Please enter a valid price.', 'receipt_price_' + group_index);
                        is_valid = false;
                    }
                }
            }

            // Validate Currency per option
            if ($currencyField.length) {
                const currencyVal = ($currencyField.val() || '').trim();
                clear_field_error($currencyField, 'receipt_currency_' + group_index);
                if (currencyVal === '') {
                    set_field_error($currencyField, 'This field is required.', 'receipt_currency_' + group_index);
                    is_valid = false;
                } else if (['IDR', 'USD'].indexOf(currencyVal.toUpperCase()) === -1) {
                    set_field_error($currencyField, 'Currency must be IDR or USD.', 'receipt_currency_' + group_index);
                    is_valid = false;
                }
            }
        });

        return is_valid;
    }

    function build_flight_option_group(type, index) {
        const option_key = type + '_option_' + index;
        return `
            <div class="upload-group flight-option-item" data-index="${index}" data-type="${type}">
                <div class="form-group" style="position:relative; margin-bottom:0;">
                    <div class="flight-option-header">
                        <label id="label-${option_key}"><strong>Option ${index}</strong></label>
                        <div class="flight-option-actions">
                            <button type="button" class="btn btn-info btn-xs edit-flight-option"><i class="fa fa-pencil"></i> Edit</button>
                            <button class="btn btn-danger btn-xs remove-option" type="button"><i class="fa fa-trash"></i> Remove</button>
                        </div>
                    </div>
                    <div class="flight-option-summary">
                        <span class="flight-option-description-text hide"></span>
                        <button type="button" class="flight-option-description-toggle">Read more</button>
                        <div class="flight-option-summary-row">
                            <span class="flight-option-price-text"><span class="text-muted">-</span></span>
                        </div>
                    </div>
                    <div class="flight-option-preview">
                        <a href="#" id="preview_link_${option_key}" aria-haspopup="dialog">
                            <img id="preview_image_${option_key}" class="flight-option-thumb" src="${BASE_URL}assets/images/icons/add-file.png" width="100" style="min-height:60px;object-fit:contain;">
                        </a>
                        <a href="#" id="button_download_${option_key}" download class="btn btn-primary btn-xs hide flight-option-download-btn">
                            <i class="fa fa-download fa-fw"></i>
                        </a>
                    </div>
                    <input type="hidden" name="${type}_option_id_${index}" class="flight-option-id" value="0">
                    <input type="hidden" name="${type}_title_${index}" class="flight-option-title" value="">
                    <input type="hidden" name="${type}_description_${index}" class="flight-option-description" value="">
                    <input type="hidden" name="${type}_price_${index}" class="flight-option-price" value="">
                    <input type="hidden" name="${type}_currency_${index}" class="flight-option-currency" value="USD">
                    <input type="hidden" class="flight-option-existing-file-name" value="">
                    <input type="file" class="custom-file-input hide" name="${option_key}" id="file_${option_key}" accept=".pdf,.jpg,.jpeg,.png">
                </div>
            </div>`;
    }

    function build_row_flight_option_group(type, index) {
        const option_key = type + '_option_' + index;
        const displayDescription = type === 'accommodation' || type === 'other' ? 'hide' : '';
        return `
            <tr class="option-row upload-group flight-option-item" data-index="${index}" data-type="${type}">
                <td class="${displayDescription}"><span class="flight-option-description-text"></span></td>
                <td><span class="flight-option-price-text"><span class="text-muted">-</span></span></td>
                <td class="flight-option-attachments-cell">
                    <div class="flight-option-files-list" style="display:flex; flex-direction:column; gap:6px;">
                        <span class="text-muted" style="font-size:12px;">No file selected</span>
                    </div>
                </td>
                <td>
                    <button type="button" class="btn btn-info btn-xs edit-flight-option"><i class="fa fa-pencil"></i></button>
                    <button class="btn btn-danger btn-xs remove-option" type="button"><i class="fa fa-trash"></i></button>

                    <input type="hidden" name="${type}_option_id_${index}" class="flight-option-id" value="0">
                    <input type="hidden" name="${type}_title_${index}" class="flight-option-title" value="">
                    <input type="hidden" name="${type}_description_${index}" class="flight-option-description" value="">
                    <input type="hidden" name="${type}_price_${index}" class="flight-option-price" value="">
                    <input type="hidden" name="${type}_currency_${index}" class="flight-option-currency" value="USD">
                    <input type="hidden" name="${type}_existing_files_${index}" class="flight-option-existing-files" value="[]">
                    <input type="hidden" class="flight-option-existing-file-name" value="">
                    <input type="file" class="custom-file-input hide" name="${option_key}[]" id="file_${option_key}" accept=".pdf,.jpg,.jpeg,.png" multiple>
                </td>
            </tr>`;
    }

    function render_row_attachments_cell($group, existing_files, new_files) {
        let $cell = $group.find('.flight-option-attachments-cell .flight-option-files-list');
        if (!$cell.length) {
            $group.find('.flight-option-attachments-cell').html('<div class="flight-option-files-list" style="display:flex; flex-direction:column; gap:6px;"></div>');
            $cell = $group.find('.flight-option-attachments-cell .flight-option-files-list');
        }
        $cell.empty();

        const all_files = [];
        (existing_files || []).forEach(function(f) {
            if (f && f.file_path && f.file_path.trim() !== '') {
                all_files.push({
                    name: f.file_name || f.file_path.split('/').pop(),
                    url: BASE_URL + f.file_path,
                    is_existing: true
                });
            }
        });
        (new_files || []).forEach(function(f) {
            if (f && f.name) {
                all_files.push({
                    name: f.name,
                    url: URL.createObjectURL(f),
                    is_existing: false
                });
            }
        });

        if (all_files.length === 0) {
            $cell.html('<span class="text-muted" style="font-size:12px;">No file selected</span>');
            return;
        }

        all_files.forEach(function(file) {
            const ext = (file.name.split('.').pop() || '').toLowerCase();
            const is_img = ['jpg', 'jpeg', 'png'].includes(ext);
            const is_pdf = ext === 'pdf';
            const icon = is_pdf ? 'fa-file-pdf-o text-danger' : (is_img ? 'fa-file-image-o text-primary' : 'fa-file-o text-muted');

            const item = $(`
                <div class="flight-option-file-badge" style="display:inline-flex; align-items:center; gap:6px;">
                    <a href="${file.url}" target="_blank" aria-haspopup="dialog" style="font-size:12px; color:#0e6ba8; word-break:break-all;">
                        <i class="fa ${icon}"></i> ${escape_html(file.name)}
                    </a>
                    ${file.is_existing && file.url !== '#' ? `
                    <a href="${file.url}" download class="btn btn-primary btn-xs" style="padding:1px 5px;" title="Download">
                        <i class="fa fa-download fa-fw"></i>
                    </a>` : ''}
                </div>
            `);
            $cell.append(item);
        });
    }

    let modal_flight_existing_files = [];
    let modal_flight_new_files = [];

    function render_modal_flight_file_list() {
        const $container = $('#flight-option-modal-file-list');
        $container.empty();

        const total_count = modal_flight_existing_files.length + modal_flight_new_files.length;
        if (total_count === 0) {
            $('#flight-option-file-count').text('No file selected');
            $container.html('<span class="text-muted" style="font-size:12px; font-style:italic;">No files attached yet.</span>');
            return;
        }

        $('#flight-option-file-count').text(total_count + ' file' + (total_count > 1 ? 's' : '') + ' selected');

        // Existing files
        modal_flight_existing_files.forEach(function(file, idx) {
            const ext = (file.file_name.split('.').pop() || '').toLowerCase();
            const icon = ext === 'pdf' ? 'fa-file-pdf-o text-danger' : (['jpg','jpeg','png'].includes(ext) ? 'fa-file-image-o text-primary' : 'fa-file-o text-muted');
            const file_url = file.file_path ? (BASE_URL + file.file_path) : '#';

            const item = $(`
                <div class="flight-option-modal-file-item" style="display:flex; align-items:center; justify-content:space-between; padding:6px 10px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:4px;">
                    <div style="display:flex; align-items:center; gap:8px; overflow:hidden;">
                        <i class="fa ${icon}"></i>
                        <a href="${file_url}" target="_blank" style="font-size:13px; color:#0e6ba8; text-decoration:underline; text-overflow:ellipsis; overflow:hidden; white-space:nowrap;" onclick="event.stopPropagation();">
                            ${escape_html(file.file_name)}
                        </a>
                        <span class="label label-default" style="font-size:10px;">Existing</span>
                    </div>
                    <button type="button" class="btn btn-link btn-xs text-danger remove-modal-flight-file" data-type="existing" data-idx="${idx}" style="padding:0 4px;" title="Remove file">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            `);
            $container.append(item);
        });

        // New files
        modal_flight_new_files.forEach(function(file, idx) {
            const ext = (file.name.split('.').pop() || '').toLowerCase();
            const icon = ext === 'pdf' ? 'fa-file-pdf-o text-danger' : (['jpg','jpeg','png'].includes(ext) ? 'fa-file-image-o text-primary' : 'fa-file-o text-muted');
            const size_kb = (file.size / 1024).toFixed(1) + ' KB';

            const item = $(`
                <div class="flight-option-modal-file-item" style="display:flex; align-items:center; justify-content:space-between; padding:6px 10px; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:4px;">
                    <div style="display:flex; align-items:center; gap:8px; overflow:hidden;">
                        <i class="fa ${icon}"></i>
                        <span style="font-size:13px; color:#1e293b; text-overflow:ellipsis; overflow:hidden; white-space:nowrap;">
                            ${escape_html(file.name)}
                        </span>
                        <span class="text-muted" style="font-size:11px;">(${size_kb})</span>
                        <span class="label label-success" style="font-size:10px;">New</span>
                    </div>
                    <button type="button" class="btn btn-link btn-xs text-danger remove-modal-flight-file" data-type="new" data-idx="${idx}" style="padding:0 4px;" title="Remove file">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            `);
            $container.append(item);
        });
    }

    function refresh_flight_option_summary($group) {
        const description = $group.find('.flight-option-description').val();
        const price = $group.find('.flight-option-price').val();
        let currency = ($group.find('.flight-option-currency').val() || 'USD').toUpperCase();
        if (['IDR', 'USD'].indexOf(currency) === -1) {
            currency = 'USD';
        }
        const formatted_price = format_money_client(price, currency);

        $group.find('.flight-option-description-text')
            .html(description ? escape_html(description).replace(/\n/g, '<br>') : '')
            .toggleClass('hide', !description)
            .toggleClass('is-clamped', !!description);
        $group.find('.flight-option-price-text').html(formatted_price ? escape_html(formatted_price) : '<span class="text-muted">-</span>');

        sync_flight_option_description_toggle($group);
    }

    function sync_flight_option_description_toggle($group) {
        const $description = $group.find('.flight-option-description-text');
        const $toggle = $group.find('.flight-option-description-toggle');

        if (!$description.length || !$toggle.length) {
            return;
        }

        if ($description.hasClass('hide')) {
            $toggle.hide().text('Read more');
            return;
        }

        $description.addClass('is-clamped');
        $toggle.text('Read more');

        window.requestAnimationFrame(function() {
            const element = $description.get(0);
            if (!element) {
                return;
            }

            if (element.scrollHeight <= element.clientHeight + 1) {
                $toggle.hide();
                return;
            }

            $toggle.show();
        });
    }

    function renumber_flight_options(type) {
        const container = $('#' + type + '-upload-container');
        container.find('.upload-group').each(function(idx) {
            const new_index = idx + 1;
            const option_key = type + '_option_' + new_index;

            $(this).attr('data-index', new_index).data('index', new_index);
            $(this).attr('data-type', type).data('type', type);
            $(this).find('label[id^="label-"]').attr('id', 'label-' + option_key).html('<strong>Option ' + new_index + '</strong>');

            $(this).find('.flight-option-id').attr('name', type + '_option_id_' + new_index);
            $(this).find('.flight-option-title').attr('name', type + '_title_' + new_index);
            $(this).find('.flight-option-description').attr('name', type + '_description_' + new_index);
            $(this).find('.flight-option-price').attr('name', type + '_price_' + new_index);
            $(this).find('.flight-option-currency').attr('name', type + '_currency_' + new_index);
            $(this).find('.flight-option-existing-files').attr('name', type + '_existing_files_' + new_index);

            $(this).find('input[type="file"]').attr('name', option_key + '[]').attr('id', 'file_' + option_key);
            $(this).find('a[aria-haspopup="dialog"]').attr('id', 'preview_link_' + option_key);
            $(this).find('img[id^="preview_image_"]').attr('id', 'preview_image_' + option_key);
            $(this).find('a[download]').attr('id', 'button_download_' + option_key);
        });
    }

    function open_flight_option_modal(type, index) {
        const $group = $('#' + type + '-upload-container').find('.upload-group[data-index="' + index + '"]');
        const description = $group.find('.flight-option-description').val() || '';
        const price = $group.find('.flight-option-price').val() || '';
        let currency = ($group.find('.flight-option-currency').val() || 'USD').toUpperCase();
        if (['IDR', 'USD'].indexOf(currency) === -1) {
            currency = 'USD';
        }

        $('#flight-option-modal-type').val(type);
        $('#flight-option-modal-index').val(index);
        if (typeof tinymce !== 'undefined' && tinymce.get('flight-option-description')) {
            tinymce.get('flight-option-description').setContent(description || '');
        } else {
            $('#flight-option-description').val(description);
        }

        const formatted_price = price ? (format_money_input(price, currency) || price) : '';
        $('#flight-option-currency').val(currency).data('previous-currency', currency);
        $('#flight-option-price').val(formatted_price);

        // Load existing files (only server-persisted files with valid file_path)
        modal_flight_existing_files = [];
        const raw_existing = $group.find('.flight-option-existing-files').val();
        if (raw_existing) {
            try {
                const parsed = JSON.parse(raw_existing);
                if (Array.isArray(parsed)) {
                    modal_flight_existing_files = parsed.filter(f => f && f.file_path && f.file_path.trim() !== '');
                }
            } catch (e) {}
        }

        // Load new files in row's file input
        modal_flight_new_files = [];
        const file_input = document.getElementById('file_' + type + '_option_' + index);
        if (file_input && file_input.files && file_input.files.length) {
            for (let i = 0; i < file_input.files.length; i++) {
                modal_flight_new_files.push(file_input.files[i]);
            }
        }

        $('#flight-option-modal-file-input').val('');
        render_modal_flight_file_list();
        $('#flight-option-modal').find('.travel-inline-error').remove();
        $('#flight-option-modal').find('.travel-input-error').removeClass('travel-input-error');
        $('#flight-option-modal').find('.tox-tinymce').removeClass('travel-input-error');
        // $('#flight-option-file-name').text(file_name);
        
        if(type === 'accommodation') {
            $('#flightOptionModalLabel').html('Accommodation Reimbursement');
            $('#label-description').html('Accommodation Detail <span class="text-danger">*</span>');
            $('#fg-description').addClass('hide');
        }else if(type === 'other') {
            $('#flightOptionModalLabel').html('Travel Option');
            $('#label-description').html('Description <span class="text-danger">*</span>');
            $('#fg-description').addClass('hide');
        }else{
            $('#flightOptionModalLabel').html('Travel Option');
            $('#label-description').html('Description <span class="text-danger">*</span>');
            $('#fg-description').removeClass('hide');
        }
        $('#flight-option-modal').modal('show');
    }

    function get_flight_option_file_name(type, index, $group) {
        const $row = $group && $group.length ? $group : $('#' + type + '-upload-container').find('.upload-group[data-index="' + index + '"]');
        const existing_file_name = ($row.find('.flight-option-existing-file-name').val() || '').trim();
        const file_input = document.getElementById('file_' + type + '_option_' + index);

        if (file_input && file_input.files && file_input.files.length) {
            return Array.from(file_input.files).map(f => f.name).join(', ');
        }
        return existing_file_name || 'No file selected';
    }

    function open_flight_option_view_modal(type, index) {
        const $group = $('#' + type + '-upload-container').find('.upload-group[data-index="' + index + '"]');
        if (!$group.length) return;

        const description = ($group.find('.flight-option-description').val() || '').trim() || '-';
        const raw_price = ($group.find('.flight-option-price').val() || '').trim();
        let currency = (($group.find('.flight-option-currency').val() || 'USD') + '').toUpperCase();
        if (['IDR', 'USD'].indexOf(currency) === -1) {
            currency = 'USD';
        }
        const formatted_price = format_money_client(raw_price, currency) || '-';

        if(type === 'accommodation'){
            $('#flightOptionViewModalLabel').html('Accommodation Reimbursement Detail');
            $('#fg-description-detail').addClass('hide');
        }else if(type === 'other'){
            $('#flightOptionViewModalLabel').html('Flight Option Detail');
            $('#fg-description-detail').addClass('hide');
        }else{
            $('#fg-description-detail').removeClass('hide');
            $('#flightOptionViewModalLabel').html('Flight Option Detail');
        }

        $('#flight-option-view-description').html(escape_html(description).replace(/\n/g, '<br>'));
        $('#flight-option-view-price').text(formatted_price);
        $('#flight-option-view-currency').text(currency);

        const $container = $('#flight-option-view-attachments-container');
        $container.empty();

        const files = [];
        const raw_existing = $group.find('.flight-option-existing-files').val();
        if (raw_existing) {
            try {
                const parsed = JSON.parse(raw_existing);
                if (Array.isArray(parsed)) {
                    parsed.forEach(f => {
                        if (f && f.file_path && f.file_path.trim() !== '') {
                            files.push({
                                name: f.file_name || f.file_path.split('/').pop(),
                                url: BASE_URL + f.file_path
                            });
                        }
                    });
                }
            } catch (e) {}
        }

        const file_input = document.getElementById('file_' + type + '_option_' + index);
        if (file_input && file_input.files && file_input.files.length) {
            for (let i = 0; i < file_input.files.length; i++) {
                const f = file_input.files[i];
                files.push({
                    name: f.name,
                    url: URL.createObjectURL(f)
                });
            }
        }

        if (files.length === 0) {
            $container.html('<span class="text-muted" style="font-size:12px;">No attachments</span>');
        } else {
            files.forEach(function(f) {
                const ext = (f.name.split('.').pop() || '').toLowerCase();
                const is_pdf = ext === 'pdf';
                const is_img = ['jpg', 'jpeg', 'png'].includes(ext);
                const icon = is_pdf ? 'fa-file-pdf-o text-danger' : (is_img ? 'fa-file-image-o text-primary' : 'fa-file-o text-muted');

                const item = $(`
                    <div style="display:flex; align-items:center; justify-content:space-between; padding:6px 10px; background:#fff; border:1px solid #dfe7ef; border-radius:4px;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <i class="fa ${icon}"></i>
                            <a href="${f.url}" target="_blank" style="font-size:13px; color:#0e6ba8; word-break:break-all;">
                                ${escape_html(f.name)}
                            </a>
                        </div>
                        ${f.url && f.url !== '#' ? `
                        <a href="${f.url}" download class="btn btn-primary btn-xs" style="padding:2px 8px;" title="Download">
                            <i class="fa fa-download fa-fw"></i> Download
                        </a>` : ''}
                    </div>
                `);
                $container.append(item);
            });
        }

        $('#flight-option-view-modal').modal('show');
    }

    function cleanup_pending_flight_option() {
        const type = $('#flight-option-modal-type').val();
        const index = $('#flight-option-modal-index').val();
        if (!type || !index) return;

        const $group = $('#' + type + '-upload-container').find('.upload-group[data-index="' + index + '"]');
        if ($group.length && $group.attr('data-pending') === '1') {
            const file_input = document.getElementById('file_' + type + '_option_' + index);
            let existing_count = 0;
            try {
                const parsed = JSON.parse($group.find('.flight-option-existing-files').val() || '[]');
                existing_count = Array.isArray(parsed) ? parsed.filter(f => f && f.file_path && f.file_path.trim() !== '').length : 0;
            } catch (e) {}

            const has_selected_file = (file_input && file_input.files && file_input.files.length > 0) || existing_count > 0;

            if (has_selected_file) {
                let currency = (($('#flight-option-currency').val() || 'USD') + '').toUpperCase();
                if (['IDR', 'USD'].indexOf(currency) === -1) {
                    currency = 'USD';
                }
                const raw_price = ($('#flight-option-price').val() || '').trim();
                const formatted_price = raw_price ? (format_money_input(raw_price, currency) || raw_price) : '';
                let description = ($('#flight-option-description').val() || '').trim();
                if (typeof tinymce !== 'undefined' && tinymce.get('flight-option-description')) {
                    description = (tinymce.get('flight-option-description').getContent({ format: 'text' }) || '').trim();
                }

                $group.find('.flight-option-description').val(description);
                $group.find('.flight-option-price').val(formatted_price);
                $group.find('.flight-option-currency').val(currency);
                refresh_flight_option_summary($group);
                $group.removeClass('hide').attr('data-pending', '0');
                return;
            }

            $group.remove();
            renumber_flight_options(type);
        }
    }

    function get_modal_description_text() {
        let description = ($('#flight-option-description').val() || '').trim();
        if (typeof tinymce !== 'undefined' && tinymce.get('flight-option-description')) {
            description = (tinymce.get('flight-option-description').getContent({ format: 'text' }) || '').trim();
        }
        return description;
    }

    function persist_modal_fields_to_group(type, index) {
        if (!type || !index) return;

        const $group = $('#' + type + '-upload-container').find('.upload-group[data-index="' + index + '"]');
        if (!$group.length) return;

        const description = get_modal_description_text();
        let currency = (($('#flight-option-currency').val() || 'USD') + '').toUpperCase();
        if (['IDR', 'USD'].indexOf(currency) === -1) {
            currency = 'USD';
        }
        const raw_price = ($('#flight-option-price').val() || '').trim();
        const formatted_price = raw_price ? (format_money_input(raw_price, currency) || raw_price) : '';

        $group.find('.flight-option-description').val(description);
        $group.find('.flight-option-price').val(formatted_price);
        $group.find('.flight-option-currency').val(currency);
        refresh_flight_option_summary($group);
    }

    $(document).on('change', '.trigger-roundtrip', function() {
        if ($(this).val() === '1') {
            $('#roundtrip-fields').removeClass('hidden').hide().fadeIn();
        } else {
            $('#roundtrip-fields').fadeOut(function() {
                $(this).addClass('hidden');
            });

            $('#form-flight-details').find('[name="return_departure_from"], [name="return_departure_date"], [name="return_arrival"]').each(function() {
                clear_field_error($(this));
            });
        }

        clear_field_error($(this), 'roundtrip');
    });

    $(document).on('change', '.select2-airport-us, .select2-airport-id', function() {
        let input_name = $(this).attr('name');
        let other_input_id = '#' + input_name + '_other';

        if ($(this).val() === 'other') {
            $(other_input_id).removeClass('hidden').hide().fadeIn().focus();
        } else {
            $(other_input_id).fadeOut(function() {
                $(this).addClass('hidden');
            });
            $(other_input_id).val('');
        }
    });

    $(document).on('click', '.add-option', function() {
        let type = $(this).data('type');
        let container = $('#' + type + '-upload-container');
        let index = container.find('.upload-group').length + 1;

        if (type === 'receipt') {
            let description = '<p class="text-muted" style="font-size: 12px;">Please upload your flight receipt and e-ticket in a single PDF or image file</p>';
            let new_option = `
                <tr class="upload-group" data-index="${index}">
                    <td>
                        <select class="form-control receipt-currency" name="receipt_currency_${index}" id="receipt_currency_${index}" required>
                            <option value="IDR">IDR</option>
                            <option value="USD" selected>USD</option>
                        </select>
                    </td>
                    <td>
                        <p class="text-muted" style="font-size: 11px; margin-bottom: 5px;">Please upload your flight receipt and e-ticket in a single PDF or image file</p>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <a href="#" id="preview_link_${type}_option_${index}" class="lightbox" aria-haspopup="dialog" style="display: flex; align-items: center; gap: 4px;">
                                <img id="preview_image_${type}_option_${index}" class="flight-option-thumb hide" src="${BASE_URL}assets/images/icons/add-file.png" style="max-height: 40px; max-width: 40px; object-fit: contain;">
                                <span class="flight-option-preview-filename" style="font-size:12px; color:#2563eb; word-break: break-all;">Preview</span>
                            </a>
                            <a href="#" id="button_download_${type}_option_${index}" download class="btn btn-primary btn-xs flight-option-download-btn hide">
                                <i class="fa fa-download fa-fw"></i>
                            </a>
                        </div>
                        <input type="file" class="custom-file-input hide" name="${type}_option_${index}" id="file_${type}_option_${index}" accept=".pdf,.jpg,.jpeg,.png">
                        <div style="margin-top: 5px;">
                            <label class="btn btn-default btn-xs upload-button" style="margin: 0;" for="file_${type}_option_${index}">Choose file</label>
                        </div>
                    </td>
                    <td>
                        <button class="btn btn-danger btn-xs remove-option" type="button"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>`;
            container.append(new_option);
        } else {
            $('#form-flight-proposal').find('.travel-form-alert').remove();
            // container.append(build_flight_option_group(type, index));
            container.append(build_row_flight_option_group(type, index));
            container.find('.upload-group[data-index="' + index + '"]')
                .attr('data-pending', '1')
                .addClass('hide');
            open_flight_option_modal(type, index);
        }

        $(this).focus();
    });

    $(document).on('click', '.edit-flight-option', function() {
        const $group = $(this).closest('.upload-group');
        open_flight_option_modal($group.data('type'), parseInt($group.data('index'), 10));
    });

    $(document).on('click', '.flight-option-item', function(e) {
        if (
            is_choosing_flight_option_file
            || $('#flight-option-modal').hasClass('in')
            || $(e.target).closest('.flight-option-actions, a, button, input, label, .upload-button, .flight-option-preview, .flight-option-description-toggle').length
        ) {
            return;
        }

        const type = $(this).data('type');
        const index = parseInt($(this).data('index'), 10);
        if (!type || !index) {
            return;
        }

        open_flight_option_view_modal(type, index);
    });

    $(document).on('click', '#flight-option-file-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $('#flight-option-modal-file-input').val('').trigger('click');
    });

    $(document).on('change', '#flight-option-modal-file-input', function(e) {
        if (!this.files || !this.files.length) return;

        const allowed_extensions = ['jpg', 'jpeg', 'png', 'pdf'];
        let has_invalid = false;

        for (let i = 0; i < this.files.length; i++) {
            const file = this.files[i];
            const ext = (file.name.split('.').pop() || '').toLowerCase();
            if (!allowed_extensions.includes(ext)) {
                has_invalid = true;
                continue;
            }

            const exists = modal_flight_new_files.some(f => f.name === file.name && f.size === file.size)
                || modal_flight_existing_files.some(f => f.file_name === file.name);
            if (!exists) {
                modal_flight_new_files.push(file);
            }
        }

        if (has_invalid) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid file type',
                text: 'Supported format: JPG, PNG, PDF.',
                confirmButtonText: 'OK'
            });
        }

        render_modal_flight_file_list();
        $('#flight-option-file-btn').removeClass('travel-input-error');
        clear_error_by_key($('#flight-option-modal-file-list').closest('.form-group'), 'flight-option-file');
    });

    $(document).on('click', '.remove-modal-flight-file', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const type = $(this).data('type');
        const idx = parseInt($(this).data('idx'), 10);

        if (type === 'existing') {
            modal_flight_existing_files.splice(idx, 1);
        } else if (type === 'new') {
            modal_flight_new_files.splice(idx, 1);
        }

        render_modal_flight_file_list();
    });

    $(document).on('click', '#flight-option-modal-save', function() {
        const type = $('#flight-option-modal-type').val();
        const index = $('#flight-option-modal-index').val();

        if (!validate_flight_option_modal()) {
            return;
        }

        let description = ($('#flight-option-description').val() || '').trim();
        if (typeof tinymce !== 'undefined' && tinymce.get('flight-option-description')) {
            description = (tinymce.get('flight-option-description').getContent({ format: 'text' }) || '').trim();
            tinymce.get('flight-option-description').save();
        }
        let currency = (($('#flight-option-currency').val() || 'USD') + '').toUpperCase();
        if (['IDR', 'USD'].indexOf(currency) === -1) {
            currency = 'USD';
        }
        const raw_price = ($('#flight-option-price').val() || '').trim();
        const formatted_price = raw_price ? (format_money_input(raw_price, currency) || raw_price) : '';
        $('#flight-option-price').val(formatted_price);

        const $group = $('#' + type + '-upload-container').find('.upload-group[data-index="' + index + '"]');
        const $trEmpty = $('#' + type + '-upload-container').find('.tr-empty');
        $trEmpty.remove();

        $group.find('.flight-option-description').val(description);
        $group.find('.flight-option-price').val(formatted_price);
        $group.find('.flight-option-currency').val(currency);

        // Update existing files in row (only keep those with valid file_path)
        const valid_existing = modal_flight_existing_files.filter(f => f && f.file_path && f.file_path.trim() !== '');
        $group.find('.flight-option-existing-files').val(JSON.stringify(valid_existing));
        const file_names_str = valid_existing.map(f => f.file_name).concat(modal_flight_new_files.map(f => f.name)).join(', ');
        $group.find('.flight-option-existing-file-name').val(file_names_str);

        // Update row's file input using DataTransfer
        try {
            const dt = new DataTransfer();
            modal_flight_new_files.forEach(f => dt.items.add(f));
            const file_input = document.getElementById('file_' + type + '_option_' + index);
            if (file_input) {
                file_input.files = dt.files;
            }
        } catch (e) {
            console.error('DataTransfer error:', e);
        }

        render_row_attachments_cell($group, valid_existing, modal_flight_new_files);

        refresh_flight_option_summary($group);
        $group.removeClass('hide').attr('data-pending', '0');
        $group.removeClass('has-travel-error');
        clear_error_by_key($group.find('.form-group').first(), type + '_option_' + index);
        clear_error_by_key($('#' + type + '-upload-container'), type + '_upload_container');

        $('#flight-option-modal').modal('hide');
    });

    $(document).on('hidden.bs.modal', '#flight-option-modal', function() {
        cleanup_pending_flight_option();
        $('#flight-option-modal-type').val('');
        $('#flight-option-modal-index').val('');
        if (typeof tinymce !== 'undefined' && tinymce.get('flight-option-description')) {
            tinymce.get('flight-option-description').setContent('');
            tinymce.get('flight-option-description').save();
        } else {
            $('#flight-option-description').val('');
        }
        $('#flight-option-price').val('');
        $('#flight-option-currency').val('USD').data('previous-currency', 'USD');
        $('#flight-option-modal-file-input').val('');
        modal_flight_existing_files = [];
        modal_flight_new_files = [];
        render_modal_flight_file_list();
        $('#flight-option-file-btn').removeClass('travel-input-error');
        $('#flight-option-modal').find('.travel-inline-error').remove();
        $('#flight-option-modal').find('.travel-input-error').removeClass('travel-input-error');
        $('#flight-option-modal').find('.tox-tinymce').removeClass('travel-input-error');
    });

    $(document).on('click', '.remove-option', function() {
        let group = $(this).closest('.upload-group');
        let container = group.closest('.upload-container');
        let type = container.attr('id').replace('-upload-container', '');

        if (type === 'receipt' && container.find('.upload-group').length <= 1) {
            Swal.fire({
                icon: 'warning',
                title: 'Cannot Remove',
                text: 'At least one option is required.',
                confirmButtonText: 'OK'
            });
            return;
        }

        group.remove();

        if (type === 'receipt') {
            renumber_receipt_options();
            if (container.find('.upload-group').length === 0) {
                container.html('<tr id="receipt-empty-row"><td colspan="5" style="text-align:center;color:#94a3b8;font-style:italic;padding:20px;">No options added yet. Click "+ Add Option" above.</td></tr>');
            }
        } else {
            renumber_flight_options(type);
            if (container.find('.upload-group').length === 0) {
                container.html('<tr><td colspan="5" style="text-align:center; color:#94a3b8; font-style:italic; padding:20px;">No options added yet. Click "+ Add Option" above.</td></tr>');
            }
        }
    });

    /* =============================================
       RECEIPT MODAL HANDLERS
    ============================================= */
    let is_choosing_receipt_file = false;

    function open_receipt_modal(index) {
        const $group = $('#receipt-upload-container').find('.upload-group[data-index="' + index + '"]');
        const price  = $group.find('.receipt-price').val() || '';
        let currency = ($group.find('.receipt-currency').val() || 'USD').toUpperCase();
        if (['IDR', 'USD'].indexOf(currency) === -1) currency = 'USD';

        const file_input = document.getElementById('file_receipt_option_' + index);
        const existing   = ($group.find('.receipt-existing-file-name').val() || '').trim();
        const file_name  = (file_input && file_input.files && file_input.files[0])
            ? file_input.files[0].name
            : (existing || 'No file selected');

        const formatted_price = price ? (format_money_input(price, currency) || price) : '';
        $('#receipt-modal-index').val(index);
        $('#receipt-modal-price').val(formatted_price);
        $('#receipt-modal-currency').val(currency).data('previous-currency', currency);
        $('#receipt-modal-file-name').text(file_name);
        $('#receipt-option-modal').find('.travel-inline-error').remove();
        $('#receipt-option-modal').find('.travel-input-error').removeClass('travel-input-error');
        $('#receipt-option-modal').modal('show');
    }

    function renumber_receipt_options() {
        $('#receipt-upload-container').find('.upload-group').each(function(idx) {
            const n = idx + 1;
            $(this).attr('data-index', n);
            $(this).find('strong[id^="label-receipt_option_"]').attr('id', 'label-receipt_option_' + n).text('Receipt ' + n);
            $(this).find('.receipt-option-id').attr('name', 'receipt_option_id_' + n);
            $(this).find('.receipt-price').attr('name', 'receipt_price_' + n);
            $(this).find('.receipt-currency').attr('name', 'receipt_currency_' + n);
            $(this).find('input[type="file"]').attr('name', 'receipt_option_' + n).attr('id', 'file_receipt_option_' + n);
            $(this).find('a[id^="preview_link_receipt"]').attr('id', 'preview_link_receipt_option_' + n);
            $(this).find('img[id^="preview_image_receipt"]').attr('id', 'preview_image_receipt_option_' + n);
            $(this).find('a[id^="button_download_receipt"]').attr('id', 'button_download_receipt_option_' + n);
        });
    }

    // Add new receipt option via modal
    $(document).on('click', '.add-receipt-option', function() {
        const $container = $('#receipt-upload-container');
        $container.find('#receipt-empty-row').remove();

        const index = $container.find('.upload-group').length + 1;
        const new_row = `
            <tr class="upload-group" data-index="${index}" data-pending="1">
                <td>
                    <input type="hidden" class="receipt-option-id" name="receipt_option_id_${index}" value="0">
                    <input type="hidden" class="receipt-price" name="receipt_price_${index}" value="">
                    <input type="hidden" class="receipt-currency" name="receipt_currency_${index}" value="USD">
                    <input type="hidden" class="receipt-existing-file-name" value="">
                    <input type="file" class="custom-file-input hide" name="receipt_option_${index}" id="file_receipt_option_${index}" accept=".pdf,.jpg,.jpeg,.png">
                    <span class="receipt-price-text"><span class="text-muted">-</span></span>
                </td>
                <td><span class="receipt-currency-text">USD</span></td>
                <td>
                    <a href="#" id="preview_link_receipt_option_${index}" aria-haspopup="dialog" style="display:inline-flex;align-items:center;gap:6px;">
                        <img id="preview_image_receipt_option_${index}" class="flight-option-thumb hide" src="${BASE_URL}assets/images/icons/add-file.png" style="max-height:36px;max-width:36px;object-fit:contain;">
                        <span class="receipt-preview-filename" style="font-size:12px;color:#2563eb;">No file</span>
                    </a>
                    <a href="#" id="button_download_receipt_option_${index}" download class="btn btn-primary btn-xs ml-2 hide">
                        <i class="fa fa-download fa-fw"></i>
                    </a>
                </td>
                <td style="text-align:right;">
                    <button type="button" class="btn btn-info btn-xs edit-receipt-option"><i class="fa fa-pencil"></i></button>
                    <button class="btn btn-danger btn-xs remove-option" type="button"><i class="fa fa-trash"></i></button>
                </td>
            </tr>`;
        $container.append(new_row);
        open_receipt_modal(index);
    });

    // Edit receipt option via modal
    $(document).on('click', '.edit-receipt-option', function() {
        const index = parseInt($(this).closest('.upload-group').data('index'), 10);
        open_receipt_modal(index);
    });

    // Choose file inside receipt modal
    $(document).on('click', '#receipt-modal-file-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const index = $('#receipt-modal-index').val();
        if (!index) return;
        is_choosing_receipt_file = true;
        $('#file_receipt_option_' + index).trigger('click');
    });

    // File selected for receipt via modal
    $(document).on('change', 'input[type="file"][name^="receipt_option_"]', function(e) {
        e.stopPropagation();
        is_choosing_receipt_file = false;

        const modal_index = $('#receipt-modal-index').val();
        if (!modal_index) return; // not triggered from modal

        const file = this.files && this.files[0] ? this.files[0] : null;
        if (!file) return;

        const ext = (file.name.split('.').pop() || '').toLowerCase();
        if (!['jpg','jpeg','png','pdf'].includes(ext)) {
            Swal.fire({ icon: 'error', title: 'Invalid file type', text: 'Supported format: JPG, PNG, PDF.', confirmButtonText: 'OK' });
            this.value = '';
            return;
        }

        $('#receipt-modal-file-name').text(file.name);

        // Update preview thumbnail in row
        const reader = new FileReader();
        reader.onload = function(ev) {
            const preview_src = ['jpg','jpeg','png'].includes(ext)
                ? ev.target.result
                : BASE_URL + 'assets/images/icons/pdf.svg';
            const $img  = $('#preview_image_receipt_option_' + modal_index);
            const $link = $('#preview_link_receipt_option_' + modal_index);
            // $img.attr('src', preview_src).removeClass('hide');
            $link.attr('href', ev.target.result)
                 .attr('data-preview-type', ext === 'pdf' ? 'pdf' : 'image')
                 .attr('data-preview-url', ev.target.result);
            $('#receipt-upload-container .upload-group[data-index="' + modal_index + '"] .receipt-preview-filename').text(file.name);
            $('#button_download_receipt_option_' + modal_index).addClass('hide');
        };
        reader.readAsDataURL(file);
    });

    // Keep modal when choosing file
    $(document).on('hidden.bs.modal', '#receipt-option-modal', function() {
        if (is_choosing_receipt_file) return;

        const index = $('#receipt-modal-index').val();
        if (index) {
            const $group = $('#receipt-upload-container').find('.upload-group[data-index="' + index + '"]');
            if ($group.length && $group.attr('data-pending') === '1') {
                $group.remove();
                renumber_receipt_options();
                if ($('#receipt-upload-container').find('.upload-group').length === 0) {
                    $('#receipt-upload-container').html('<tr id="receipt-empty-row"><td colspan="5" style="text-align:center;color:#94a3b8;font-style:italic;padding:20px;">No options added yet. Click \"+ Add Option\" above.</td></tr>');
                }
            }
        }
        $('#receipt-modal-index').val('');
        $('#receipt-modal-price').val('');
        $('#receipt-modal-currency').val('USD').data('previous-currency', 'USD');
        $('#receipt-modal-file-name').text('No file selected');
    });

    // Save receipt modal
    $(document).on('click', '#receipt-modal-save', function() {
        const index = $('#receipt-modal-index').val();
        if (!index) return;

        const raw_price = $('#receipt-modal-price').val().trim();
        const currency  = ($('#receipt-modal-currency').val() || 'USD').toUpperCase();
        const price     = format_money_input(raw_price, currency) || raw_price;
        $('#receipt-modal-price').val(price);

        const file_input = document.getElementById('file_receipt_option_' + index);
        const $group     = $('#receipt-upload-container').find('.upload-group[data-index="' + index + '"]');
        const existing   = ($group.find('.receipt-existing-file-name').val() || '').trim();
        const has_file   = !!(file_input && file_input.files && file_input.files[0]) || !!existing;

        let errors = false;
        $('#receipt-option-modal').find('.travel-inline-error').remove();
        $('#receipt-modal-price, #receipt-modal-file-btn').removeClass('travel-input-error');

        if (!price) {
            $('#receipt-modal-price').addClass('travel-input-error')
                .after('<p class="text-danger travel-inline-error" style="font-size:12px;margin-top:4px;">Price is required.</p>');
            errors = true;
        }
        if (!has_file) {
            $('#receipt-modal-file-btn').addClass('travel-input-error')
                .after('<p class="text-danger travel-inline-error" style="font-size:12px;margin-top:4px;">Please choose a file.</p>');
            errors = true;
        }
        if (errors) return;

        // Persist values to row hidden fields
        $group.find('.receipt-price').val(price);
        $group.find('.receipt-currency').val(currency);

        // Update display cells
        const formatted = (typeof format_money_client === 'function')
            ? (format_money_client(price, currency) || price + ' ' + currency)
            : price + ' ' + currency;
        $group.find('.receipt-price-text').text(formatted);
        $group.find('.receipt-currency-text').text(currency);

        $group.removeClass('hide').attr('data-pending', '0');
        $('#receipt-option-modal').modal('hide');
    });

    function load_tab_content(type) {
        let url = '';
        let status = parseInt('<?= isset($current_status) ? $current_status : 1 ?>');
        let application_id = '<?= isset($id) ? $id : '' ?>';

        if (type === 'self') {
            url = '<?= base_url("grantee/travel_arrangement/self_arrangement/") . (isset($id) ? $id : '') ?>';
        } else if (type === 'aminef') {
            url = '<?= base_url("grantee/travel_arrangement/aminef_arrangement/") ?>' + application_id + '?status=' + status;
        }

        $('#tab-content-container').html('<div class="loading-spinner"><i class="fa fa-circle-o-notch fa-spin"></i><p>Loading...</p></div>');

        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                $('#tab-content-container').html(response);
                initialize_content();
                open_pid_section(type);
                $('.lightbox').topbox();
            },
            error: function(xhr, status, error) {
                console.error('Error loading content:', error);
                $('#tab-content-container').html('<div class="alert alert-danger">Failed to load content. Please try again.</div>');
            }
        });
    }

    function open_pid_section(type) {
        let urlParams = new URLSearchParams(window.location.search);
        let pid = urlParams.get('pid');
        if (!pid) {
            return;
        }

        let selector = null;
        if (type === 'self') {
            if (pid === 'flight-proposal') {
                selector = '#collapseFlightProposal';
            } else if (pid === 'flight-reimbursement') {
                selector = '#collapseReimbursement';
            }
        } else if (type === 'aminef') {
            if (pid === 'flight-details') {
                selector = '#collapseFlightDetails';
            } else if (pid === 'tba-flight-proposal') {
                selector = '#collapseTbaFlightProposal';
            } else if (pid === 'ticket') {
                selector = '#collapseTicket';
            }
        }

        if (selector && $(selector).length) {
            $(selector).collapse('show');
            $('html, body').animate({
                scrollTop: $(selector).offset().top - 100
            }, 300);
        }
    }

    function initialize_content() {
        ensure_inline_validation_styles();
        $('#form-flight-details, #form-flight-proposal, #form-reimbursement').attr('novalidate', 'novalidate');

        if ($('.datepicker').length > 0) {
            $('.datepicker').datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true
            });
        }

        if ($('.select2-airport-us, .select2-airport-id').length > 0) {
            $('.select2-airport-us, .select2-airport-id').select2({
                placeholder: "Select Airport",
                allowClear: true
            });
        }

        // var initTravelPurposesOtherEditor = function() {
        //     if (!$('#travel_purposes_other').length) {
        //         return;
        //     }
        //     var isDisabled = $('#travel_purposes_other').is(':disabled');
        //     if (typeof tinymce !== 'undefined') {
        //         var existing = tinymce.get('travel_purposes_other');
        //         if (existing) {
        //             try {
        //                 var existingEl = existing.getElement ? existing.getElement() : null;
        //                 if (!existingEl || !$.contains(document.documentElement, existingEl)) {
        //                     tinymce.remove(existing);
        //                     existing = null;
        //                 }
        //             } catch (e) {
        //                 try { tinymce.remove(existing); } catch (er) {}
        //                 existing = null;
        //             }
        //         }
        //         if (!existing) {
        //             tinymce.init({
        //                 selector: '#travel_purposes_other',
        //                 height: 220,
        //                 menubar: false,
        //                 plugins: 'link lists paste',
        //                 toolbar: 'undo redo | bold italic underline | bullist numlist | link',
        //                 branding: false,
        //                 readonly: isDisabled,
        //                 setup: function(editor) {
        //                     editor.on('change keyup input', function() {
        //                         tinymce.triggerSave();
        //                         clear_field_error($('#travel_purposes_other'), 'travel_purposes_other');
        //                     });
        //                 }
        //             });
        //         }
        //     } else {
        //         $.getScript(BASE_URL + 'js/tinymce/tinymce.min.js')
        //             .done(function() {
        //                 $.getScript(BASE_URL + 'js/tinymce/jquery.tinymce.min.js')
        //                     .done(function() {
        //                         initTravelPurposesOtherEditor();
        //                     });
        //             });
        //     }
        // };

        function toggle_travel_purposes_other() {
            var val = ($('#travel_purposes').val() || '').toString().trim().toLowerCase();
            var isOther = (val === 'other' || val === 'others');
            if (isOther) {
                $('#wrapper_travel_purposes_other').show();
                //initTravelPurposesOtherEditor();
            } else {
                $('#wrapper_travel_purposes_other').hide();
                clear_field_error($('#travel_purposes_other'), 'travel_purposes_other');
            }
        }

        if ($('#travel_purposes').length && $('#travel_purposes').is('select')) {
            $('#travel_purposes').select2({
                placeholder: "Select Travel Purpose",
                theme: 'bootstrap'
            });

            $(document).on('change', '#travel_purposes', function() {
                clear_field_error($(this), 'travel_purposes');
                toggle_travel_purposes_other();
            });

            toggle_travel_purposes_other();
        }

        if ($('#flight-option-description').length) {
            var initFlightOptionDescriptionEditor = function() {
                if (typeof tinymce !== 'undefined') {
                    var existing = tinymce.get('flight-option-description');
                    if (existing) {
                        try {
                            var existingEl = existing.getElement ? existing.getElement() : null;
                            if (!existingEl || !$.contains(document.documentElement, existingEl)) {
                                tinymce.remove(existing);
                                existing = null;
                            }
                        } catch (e) {
                            try { tinymce.remove(existing); } catch (er) {}
                            existing = null;
                        }
                    }
                    if (!existing) {
                        tinymce.init({
                            selector: '#flight-option-description',
                            height: 180,
                            menubar: false,
                            plugins: 'link lists paste',
                            toolbar: 'undo redo | bold italic underline | bullist numlist | link',
                            branding: false,
                            setup: function(editor) {
                                var placeholder = 'Please input your flight itinerary.';

                                function togglePlaceholder() {
                                    var body = editor.getBody();
                                    var isEmpty = !editor.getContent({ format: 'text' }).trim();

                                    if (isEmpty && !editor.hasFocus()) {
                                        body.setAttribute('data-placeholder', placeholder);
                                        body.classList.add('tinymce-placeholder');
                                    } else {
                                        body.classList.remove('tinymce-placeholder');
                                    }
                                }

                                editor.on('init', function() {
                                    editor.dom.addStyle(`
                                        body.tinymce-placeholder:before {
                                            content: attr(data-placeholder);
                                            position: absolute;
                                            color: #999;
                                            pointer-events: none;
                                            font-style: italic;
                                        }
                                    `);

                                    togglePlaceholder();
                                });

                                editor.on('focus', function() {
                                    togglePlaceholder();
                                });

                                editor.on('blur change keyup SetContent', function() {
                                    editor.save();
                                    togglePlaceholder();
                                });
                            }
                        });
                    }
                } else {
                    $.getScript(BASE_URL + 'js/tinymce/tinymce.min.js')
                        .done(function() {
                            $.getScript(BASE_URL + 'js/tinymce/jquery.tinymce.min.js')
                                .done(function() {
                                    initFlightOptionDescriptionEditor();
                                });
                        });
                }
            };
            initFlightOptionDescriptionEditor();
        }
    }

    $(document).on('click', 'a[id^="preview_link_"]', function(e) {
        e.preventDefault();
        e.stopPropagation();

        const $link = $(this);
        const has_lightbox_class = $link.hasClass('lightbox');
        const href = $link.attr('href');

        const has_file = href && href !== '' && href !== '#';

        if (!has_file) {
            const image_id = $link.find('img').attr('id');
            const type_and_num = image_id.replace('preview_image_', '');
            const file_input_id = '#file_' + type_and_num;
            is_choosing_flight_option_file = true;
            $(file_input_id).click();
            return;
        }

        if (has_lightbox_class && typeof $.fn.topbox === 'function') {
            $link.topbox();
            $link[0].click();
        } else {
            const preview_type = $link.attr('data-preview-type');
            const preview_url = $link.attr('data-preview-url');

            if (preview_type === 'image' && preview_url) {
                const modal_content = '<img src="' + preview_url + '" style="max-width: 100%; max-height: 100%; width: auto; height: auto;">';
                show_preview_modal(modal_content);
            } else if (preview_type === 'pdf' && preview_url) {
                const modal_content = '<iframe src="' + preview_url + '" style="width:100%; height:80vh; border:none;"></iframe>';
                show_preview_modal(modal_content);
            } else if (href) {
                window.open(href, '_blank');
            }
        }
    });

    $(document).on('click', '#preview-modal-close', function() {
        close_preview_modal();
    });

    $(document).on('click', '#preview-modal', function(e) {
        if ($(e.target).attr('id') === 'preview-modal') {
            close_preview_modal();
        }
    });

    $(document).on('click', '.flight-option-description-toggle', function(e) {
        e.preventDefault();
        e.stopPropagation();

        const $toggle = $(this);
        const $description = $toggle.siblings('.flight-option-description-text');

        if (!$description.length) {
            return;
        }

        if ($description.hasClass('is-clamped')) {
            $description.removeClass('is-clamped');
            $toggle.text('Show less');
            return;
        }

        $description.addClass('is-clamped');
        $toggle.text('Read more');
    });

    $(document).on('change', 'input[type="file"][name*="_option_"]', function(e) {
        e.stopPropagation();
        is_choosing_flight_option_file = false;

        // receipt_option files are handled by the dedicated receipt modal handler
        if ($(this).attr('name') && $(this).attr('name').indexOf('receipt_option_') === 0) {
            return;
        }

        $(this).removeClass('travel-input-error');
        $(this).closest('.form-group').find('.travel-inline-error[data-error-key="invalid-file-type"]').remove();

        let type_and_num = $(this).attr('name') || '';

        const match = /^([a-z]+)_option_(\d+)(?:\[\])?$/.exec(type_and_num);
        if (match) {
            const type = match[1];
            const index = match[2];
            const $group = $('#' + type + '-upload-container').find('.upload-group[data-index="' + index + '"]');
            $group.removeClass('has-travel-error');
            clear_error_by_key($group.find('.form-group').first(), type + '_option_' + index);
            clear_error_by_key($('#' + type + '-upload-container'), type + '_upload_container');
            return;
        }

        if (typeof show_preview_travel === 'function') {
            show_preview_travel(this, type_and_num);
        }

        return;
    });

    $(document).on('input change', '#tab-content-container input, #tab-content-container textarea, #tab-content-container select', function() {
        const $field = $(this);

        if ($field.is(':radio')) {
            clear_field_error($field, $field.attr('name'));
            return;
        }

        clear_field_error($field);
    });

    function handleFormSubmit(form, url) {
        const $form = $(form);
        const clicked_btn = $form.find('button[type="submit"]:focus');
        const action = clicked_btn.length > 0 ? (clicked_btn.attr('value') || 'submit') : 'submit';
        
        if (typeof tinymce !== 'undefined') {
            try { tinymce.triggerSave(); } catch (e) { }
        }

        clear_form_errors($form);

        const has_travel_purposes_error = !validate_travel_purposes();
        const has_required_errors = !validate_required_fields($form, action);
        const has_flight_option_errors = !validate_flight_option_sections($form, action);
        const has_reimbursement_errors = !validate_reimbursement_sections($form, action);

        if (has_travel_purposes_error || has_required_errors || has_flight_option_errors || has_reimbursement_errors) {
            focus_first_error($form);
            if (has_travel_purposes_error) {
                const tpVal = ($('#travel_purposes').val() || '').toString().trim().toLowerCase();
                if (['other', 'others'].includes(tpVal) && get_field_value($('#travel_purposes_other')) === '') {
                    focus_field($('#travel_purposes_other'));
                } else {
                    focus_field($('#travel_purposes'));
                }
            }
            return;
        }

        const form_data = new FormData(form);
        form_data.append('action', action);
        const tpVal = get_field_value($('#travel_purposes'));
        const isOther = ['other', 'others'].includes(tpVal.toLowerCase());
        const tpOtherVal = isOther ? get_field_value($('#travel_purposes_other')) : '';

        form_data.append('travel_purposes', tpVal);
        form_data.append('travel_purposes_other', tpOtherVal);

        const $all_submit_buttons = $form.find('button[type="submit"]');
        const $btn = (clicked_btn && clicked_btn.length) ? clicked_btn : $all_submit_buttons.first();
        const original_btn_text = $btn.html();

        $btn.prop('disabled', true).html('<i class="fa fa-circle-o-notch fa-spin"></i> Submitting...');

        $.ajax({
            url: url,
            type: 'POST',
            data: form_data,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                $btn.prop('disabled', false).html(original_btn_text);
                if (response.status === 'success' || response.status === 'warning') {
                    Swal.fire({
                        icon: response.status === 'success' ? 'success' : 'warning',
                        title: response.status === 'success' ? 'Success' : 'Warning',
                        text: response.message,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = '<?= base_url("grantee/travel_arrangement/manage") ?>';
                    });
                } else {
                    show_form_error($form, response.message || 'An error occurred. Please try again.');
                }
            },
            error: function() {
                $btn.prop('disabled', false).html(original_btn_text);
                show_form_error($form, 'An error occurred. Please try again.');
            }
        });
    }

    $(document).on('submit', '#form-flight-proposal', function(e) {
        e.preventDefault();
        handleFormSubmit(this, '<?= base_url("grantee/travel_arrangement/submit_flight_proposal") ?>');
    });

    $(document).on('submit', '#form-reimbursement', function(e) {
        e.preventDefault();
        handleFormSubmit(this, '<?= base_url("grantee/travel_arrangement/submit_flight_reimbursement") ?>');
    });

    $(document).on('submit', '#form-flight-details', function(e) {
        e.preventDefault();
        handleFormSubmit(this, '<?= base_url("grantee/travel_arrangement/submit_flight_details") ?>');
    });

    $(document).on('change', '#form-tba-flight-selection input[type="radio"]', function() {
        const group_name = $(this).attr('name');
        const $form = $('#form-tba-flight-selection');

        $form.find('input[name="' + group_name + '"]').closest('.tba-proposal-card').removeClass('is-selected');
        $(this).closest('.tba-proposal-card').addClass('is-selected');
    });

    $(document).on('submit', '#form-tba-flight-selection', function(e) {
        e.preventDefault();

        const $form = $(this);
        const form_data = new FormData(this);
        const $button = $form.find('button[type="submit"]');
        const original_text = $button.html();

        $button.prop('disabled', true).html('<i class="fa fa-circle-o-notch fa-spin"></i> Submitting...');

        $.ajax({
            url: '<?= base_url("grantee/travel_arrangement/submit_tba_flight_selection") ?>',
            type: 'POST',
            data: form_data,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                $button.prop('disabled', false).html(original_text);

                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        confirmButtonText: 'OK'
                    }).then(function() {
                        window.location.reload();
                    });
                    return;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message,
                    confirmButtonText: 'OK'
                });
            },
            error: function() {
                $button.prop('disabled', false).html(original_text);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred. Please try again.',
                    confirmButtonText: 'OK'
                });
            }
        });
    });

    if ($('#popupGuideline').length) {
        $('#popupGuideline').modal('show');
    }

    $(document).on('change', '.type_flight', function () {
        if ($(this).val() === 'International') {
            $('#international-flight-section').removeClass('hidden');
            $('#domestic-flight-section').addClass('hidden');
            $('#other-flight-section').addClass('hidden');
            $('#accommodation-flight-section').addClass('hidden');
        } else if ($(this).val() === 'Domestic'){
            $('#domestic-flight-section').removeClass('hidden');
            $('#international-flight-section').addClass('hidden');
            $('#other-flight-section').addClass('hidden');
            $('#accommodation-flight-section').addClass('hidden');
        } else if ($(this).val() === 'Accommodation'){
            $('#accommodation-flight-section').removeClass('hidden');
            $('#domestic-flight-section').addClass('hidden');
            $('#international-flight-section').addClass('hidden');
            $('#other-flight-section').addClass('hidden');
        }else{
            $('#other-flight-section').removeClass('hidden');
            $('#domestic-flight-section').addClass('hidden');
            $('#international-flight-section').addClass('hidden');
            $('#accommodation-flight-section').addClass('hidden');
        }
    });

    $(document).on('change', '.type_flight_aminef', function () {
        var selected = $(this).val();
        if (selected === 'International') {
            $('#panel-international-flight').removeClass('hide').show();
            $('#panel-domestic-flight').addClass('hide').hide();
            $('#panel-car-rental').addClass('hide').hide();
            $('#panel-accommodation').addClass('hide').hide();
            $('#collapseChildDetailInter').collapse('show');
        } else if (selected === 'Domestic') {
            $('#panel-domestic-flight').removeClass('hide').show();
            $('#panel-international-flight').addClass('hide').hide();
            $('#panel-car-rental').addClass('hide').hide();
            $('#panel-accommodation').addClass('hide').hide();
            $('#collapseChildDetailDom').collapse('show');
        } else if (selected === 'Other') {
            $('#panel-car-rental').removeClass('hide').show();
            $('#panel-international-flight').addClass('hide').hide();
            $('#panel-domestic-flight').addClass('hide').hide();
            $('#panel-accommodation').addClass('hide').hide();
            $('#collapseChildDetailCar').collapse('show');
        } else if (selected === 'Accommodation') {
            $('#panel-accommodation').removeClass('hide').show();
            $('#panel-car-rental').addClass('hide').show();
            $('#panel-international-flight').addClass('hide').hide();
            $('#panel-domestic-flight').addClass('hide').hide();
            $('#collapseChildDetailAccomm').collapse('show');
        }
    });

    initCurrencyFormatter('.receipt-price', '.receipt-currency');
    initCurrencyFormatter('#flight-option-price', '#flight-option-currency');
    initCurrencyFormatter('#receipt-modal-price', '#receipt-modal-currency');
    
    $(document).on('click', '#show_domestic_flight', function() {
        const $section = $('#domestic_flight_section');

        if ($section.hasClass('hide')) {
            $section.removeClass('hide').hide().fadeIn(300);
        } else {
            $section.fadeOut(300, function() {
                $(this).addClass('hide');
            });
        }
    });
});
</script>
