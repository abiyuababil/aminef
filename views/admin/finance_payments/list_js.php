<script>
var is_multi_grant = <?= !empty($is_multi_grant) ? 'true' : 'false' ?>;
var context_grant_id = '<?= isset($context_grant_id) ? (int) $context_grant_id : '' ?>';
var grant_list = <?= isset($grant_list_json) ? $grant_list_json : '[]' ?>;
var grantees_by_grant = <?= isset($grantees_json) ? $grantees_json : '[]' ?>;

$(document).ready(function() {

    // reusable shared modals post to #form like on payment_grant page.
    $('#mdl_add_record [name]:not([form]), #mdl_edit_record [name]:not([form])').attr('form', 'form');
    $('#mdl_add_record #btn-submit-record, #mdl_edit_record #btn-submit-record-edit').attr('form', 'form');

    // mark bulk forms as finance origin so shared endpoints enforce payments caps.
    $('#mdl_bulk_grantee form, #mdl_add_record_bulk form, #mdl_add_record_support form').each(function() {
        if (!$(this).find('input[name="from_finance"]').length) {
            $(this).append('<input type="hidden" name="from_finance" value="1">');
        }
    });

    if (!grant_list.length) {
        return;
    }

    // build grant dropdown options, preselect given grant.
    function build_grant_options(selected_id) {
        var options = '';
        $.each(grant_list, function(index, grant) {
            var selected = '';
            if (String(grant.id) === String(selected_id)) {
                selected = ' selected';
            }
            var label = $('<span>').text(grant.label).html();
            options += '<option value="' + grant.id + '"' + selected + '>' + label + '</option>';
        });
        return options;
    }

    // refill grantee dropdown with grantees of chosen grant.
    // leaves the select untouched when the grant is unknown.
    function refresh_grantee_dropdown(modal, grant_id) {
        var dropdown = modal.find("select[name='add_record[user_grantee_id]']:not(.is_null)");

        if (!dropdown.length) {
            dropdown = modal.find("select[name='edit_record[user_grantee_id]']:not(.is_null)");
        }
        if (!dropdown.length) {
            return;
        }
        if (!grantees_by_grant || grantees_by_grant[grant_id] === undefined) {
            return;
        }
        var list = grantees_by_grant[grant_id];
        var current_value = dropdown.val();
        var options = '<option value="">Select Grantee</option>';
        $.each(list, function(index, grantee) {
            var name = $('<span>').text(grantee.name).html();
            options += '<option value="' + grantee.user_id + '">' + name + '</option>';
        });
        dropdown.html(options);
        dropdown.val(current_value);
        if (dropdown.val() === null) {
            dropdown.val('');
        }
        // dropdown.trigger('change');
    }

    // filter memo dropdown by grant from a snapshot of server options,
    // so valid options are never destroyed.
    function refresh_memo_dropdown(modal, grant_id) {
        var dropdown = modal.find("select[name='add_record[user_grantee_grant_memo_id]']:not(.is_null)");

        if (!dropdown.length) {
            dropdown = modal.find("select[name='edit_record[user_grantee_grant_memo_id]']:not(.is_null)");
        }

        if (!dropdown.length) {
            return;
        }
        if (!dropdown.data('all-memo-options')) {
            var snapshot = [];
            dropdown.find('option').each(function() {
                snapshot.push({
                    value: $(this).val(),
                    text: $(this).text(),
                    grant: $(this).data('grant-id')
                });
            });
            dropdown.data('all-memo-options', snapshot);
        }
        var current_value = dropdown.val();
        var options = '';
        $.each(dropdown.data('all-memo-options'), function(index, memo_option) {
            var option_grant = memo_option.grant;
            if (memo_option.value === '' || option_grant === undefined || option_grant === null
                || String(option_grant) === '' || String(option_grant) === String(grant_id)) {
                var name = $('<span>').text(memo_option.text).html();
                options += '<option value="' + memo_option.value + '">' + name + '</option>';
            }
        });
        dropdown.html(options);
        dropdown.val(current_value);
        if (dropdown.val() === null) {
            dropdown.val('');
        }
        dropdown.trigger('change');
    }

    // create searchable picker once per modal.
    function ensure_grant_picker(modal, field_name) {
        var picker_row = modal.find('.grant-picker');
        if (!picker_row.length) {
            var modal_body = modal.find('.modal-body').first();
            var picker_html = ''
                + '<div class="form-group row grant-picker">'
                + '<div class="col-lg-12"><div class="alert alert-warning" style="margin-bottom:0;">'
                + '<label style="font-weight:700;">Grant <span class="text-danger">*</span></label>'
                + '<select class="form-control grant-select" style="width:100%;">'
                + build_grant_options(context_grant_id)
                + '</select>'
                + '<small>Payments will be recorded under the selected grant.</small>'
                + '</div></div></div>';
            picker_row = $(picker_html);
            modal_body.prepend(picker_row);
            if (field_name) {
                picker_row.find('.grant-select').attr('name', field_name);
                picker_row.find('.grant-select').attr('form', 'form');
            }
        }
        normalize_grant_picker(modal);
        return picker_row.find('.grant-select');
    }

    // exactly one select2 instance: shared global inits target any
    // .select2 container and spawn nested empty duplicates.
    function normalize_grant_picker(modal) {
        var picker_select = modal.find('.grant-picker .grant-select');
        if (!picker_select.length) {
            return picker_select;
        }
        try {
            if (picker_select.hasClass('select2-hidden-accessible')) {
                picker_select.select2('destroy');
            }
        } catch (ignore) {}
        modal.find('.grant-picker .select2-container').remove();
        picker_select.select2({
            dropdownParent: modal.find('.modal-content'),
            width: '100%'
        });
        return picker_select;
    }

    // grant id for picker: row grant on view/edit, context grant on add.
    function modal_grant_id(button) {
        var button_grant = button ? button.data('grant-id') : undefined;
        if (button_grant !== undefined && button_grant !== null && String(button_grant) !== '') {
            return String(button_grant);
        }
        return String(context_grant_id);
    }

    // single delegated handler survives select2 destroy/init cycles.
    $(document).on('change', '.grant-picker .grant-select', function() {
        var grant_id = $(this).val();
        var target_modal = $(this).closest('.modal');
        var hidden_name = $(this).data('hidden-input');
        if ($(this).prop('disabled')) {
            refresh_grantee_dropdown(target_modal, grant_id);
            refresh_memo_dropdown(target_modal, grant_id);
            return;
        }
        
        if (hidden_name) {
            $('#' + hidden_name).val(grant_id);
        }
        refresh_grantee_dropdown(target_modal, grant_id);
        refresh_memo_dropdown(target_modal, grant_id);
    });

    // apply picker state on show and again on shown, because shared
    // handlers reset modal fields in between.
    function bind_grant_picker(modal_id, hidden_input_id, field_name) {
        var apply_state = function(event) {
            var button = $(event.relatedTarget);
            var mode = button ? button.data('mode') : undefined;
            var modal = $(this);
            var picker_select = ensure_grant_picker(modal, field_name);
            if (hidden_input_id) {
                picker_select.data('hidden-input', hidden_input_id);
            } else {
                picker_select.removeData('hidden-input');
            }
            if (mode === 'add') {
                picker_select.prop('disabled', false);
                picker_select.val(String(context_grant_id));
            } else {
                picker_select.prop('disabled', true);
                picker_select.val(modal_grant_id(button));
            }
            picker_select.trigger('change');
        };
        $(modal_id).on('show.bs.modal', apply_state);
        $(modal_id).on('shown.bs.modal', apply_state);
    }

    // re-normalize after async shared renders that may re-init select2.
    // no change event here so user selections are kept.
    $(document).ajaxComplete(function() {
        $('.modal.in .grant-picker').each(function() {
            var modal = $(this).closest('.modal');
            if (modal.find('.grant-picker .select2-container').length !== 1) {
                normalize_grant_picker(modal);
            }
        });
    });

    // reusable shared modals, picker always visible, locked on view/edit.
    bind_grant_picker('#mdl_bulk_grantee', 'grant_id_bulk', null);
    bind_grant_picker('#mdl_add_record_bulk', 'grant_id_bulk_non', null);
    bind_grant_picker('#mdl_add_record_support', 'grant_id_bulk_support', null);
    bind_grant_picker('#mdl_add_record', null, 'add_record[grant_id]');
    bind_grant_picker('#mdl_edit_record', null, null);

});
</script>
