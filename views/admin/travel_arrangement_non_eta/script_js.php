<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<script>
    const base_url = "<?= base_url() ?>";

function select_payment_item_travel(i) {
    let sub_category = 'select_sub_category_travel_' + i;
    let payment_item = 'select_payment_item_travel_' + i;
    $('#' + payment_item).html('');
    $('#' + payment_item).append('<option value="">-- Select Item --</option>');
    $.ajax({
        type: 'GET',
        url: '<?php echo site_url('admin/request_payment/get_payment_item_by_sub_category') ?>/' + $('#' + sub_category).val(),
        dataType: 'JSON',
        success: function(r) {
            $.each(r, function(id, val) {
                if ($('#' + payment_item + ' option[value="' + val.id + '"]').length === 0) {
                    $('#' + payment_item).append('<option value="' + val.id + '">' + val.payment_item + '</option>');
                }
            });
        }
    });
    $("#" + sub_category).closest('div').find('.travel-payment-sub-category-validation').addClass('hide');
}

function initializeSelect2() {
    $('#select_sub_category_travel_0').select2();
    $('#select_payment_item_travel_0').select2();
}

function add_item_travel(i) {
    var name_class = '.request-item-travel' + i;
    var warp_request = '#wrap-request-travel' + i;
    var idx = $(name_class).length;

    $.ajax({
        type: 'GET',
        url: '<?php echo site_url('admin/request_payment/add_item_travel') ?>?idx=' + idx + '&i=' + i,
        dataType: 'JSON',
        success: function(r) {
            var html = r;
            $(warp_request).append(html);
            $('.select2').select2({
        theme: 'bootstrap'
});
        }
    });
}

function remove_attachment(button) {
    $(button).closest('.payment-attachment').remove();
}

function remove_file(button, type = undefined, idx = undefined, form_name = undefined) {
    if (confirm("Are you sure you want to remove this file?")) {
        let file_input = button.closest('div').querySelector('input[type="file"]');

        if (file_input) {
            file_input.value = '';
        }

        if (type !== undefined) {
            $('.' + type + '-file').addClass('hide');
            $('.' + type + '-no-file').removeClass('hide');
        }

        let attr_form_name = '';
        if (form_name != undefined) {
            attr_form_name = 'form="'+ form_name +'"';
        }

        if (idx != undefined) {
            button.closest('div').insertAdjacentHTML('beforeend', '<input '+ attr_form_name +' type="hidden" name="remove_' + type + '['+idx+']" value="1">');
        } else {
            button.closest('div').insertAdjacentHTML('beforeend', '<input '+ attr_form_name +' type="hidden" name="remove_' + type + '" value="1">');
        }
    }
}

function add_more_attachment(element) {
    let attachment_button = $(element);
    let attachment_section = attachment_button.data('type');

    let count = $('.additional-' + attachment_section + ' .payment-attachment').length;
    let fileInputId = 'proof-of-expense-' + count;

    let html = `
        <div class="payment-attachment">
            <div class="col-md-12">
                <div class="form-group">
                    <button class="btn btn-danger btn-xs pull-right btn-action-remove-unuploaded" type="button" onclick="remove_attachment(this);">
                        <i class="fa fa-times"></i>
                    </button>
                    <input type="file" id="${fileInputId}" name="${attachment_button.data('input_name')}">
                    <small class="file-for-testing">File Size Max 5MB</small>
                </div>
            </div>
        </div>`;

    $('.additional-' + attachment_section).append(html);
}

function update_to_release(event) {
    let modal = $(event).data("modal");
    $("#" + modal + " .status").val("2");
}

$(document).ready(function() {
    $(".status").val("5");
    let urlParams = new URLSearchParams(window.location.search);
    let urlPid = urlParams.get('pid');
    let serverPid = $('.nav.nav-pills').data('active-tab') || 'flight-proposal';

    let pid;
    if (serverPid === 'flight-reimbursement' || serverPid === 'payment') {
        pid = serverPid;
    } else {
        pid = urlPid || serverPid;
    }

    $('[href="#' + pid + '"]').tab('show');
    $('[href="#' + pid + '"]').closest('li').addClass('active');

    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd M yy",
        yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
    });

    let is_editable = $('.btn-approve').length > 0;

    if (!is_editable) {
        $('.flight-option').addClass('disabled');
    }

    $('.flight-option').on('click', function() {
        if (!is_editable) {
            return;
        }

        let ref_type = $(this).data('ref-type');
        let checkbox = $(this).find('.attachment-checkbox');

        $('.flight-option[data-ref-type="' + ref_type + '"]').each(function() {
            $(this).removeClass('is-selected');
            $(this).find('.attachment-checkbox').prop('checked', false);
        });

        $(this).addClass('is-selected');
        checkbox.prop('checked', true);
    });

    if (is_editable) {
        let total_intl = $('.flight-option-intl').length;
        let total_dom = $('.flight-option-dom').length;

        if (total_intl === 1) {
            $('.flight-option-intl').first().trigger('click');
        }
        if (total_dom === 1) {
            $('.flight-option-dom').first().trigger('click');
        }
    }

    $('.flight-option-description-text').each(function() {
        let $description = $(this);
        let $toggle = $description.siblings('.flight-option-description-toggle');

        if (!$toggle.length || $description.hasClass('hide')) {
            return;
        }

        if (this.scrollHeight <= this.clientHeight + 1) {
            $toggle.hide().text('Read more');
            return;
        }

        $toggle.show().text('Read more');
    });

    $(document).on('click', '.flight-option-description-toggle', function(e) {
        e.preventDefault();
        e.stopPropagation();

        let $toggle = $(this);
        let $description = $toggle.siblings('.flight-option-description-text');

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

    $('.btn-approve').on('click', function() {
        let id = $(this).data('id');

        let selected_intl = $('input[name="international_attachment"]:checked').val() || null;
        let selected_dom = $('input[name="domestic_attachment"]:checked').val() || null;

        let total_intl = $('.flight-option-intl').length;
        let total_dom = $('.flight-option-dom').length;

        let validation_error = false;

        if (total_intl > 1 && !selected_intl) {
            validation_error = true
        }

        if (total_dom > 1 && !selected_dom) {
            validation_error = true;
        }

        if (validation_error) {
            Swal.fire({
                icon: 'warning',
                title: 'Please select one option for International and Domestic Flights',
                confirmButtonText: 'Close',
            });
            return;
        }

        Swal.fire({
            icon: 'question',
            title: 'Confirm Approval',
            text: 'Are you sure you want to approve this application?',
            showCancelButton: true,
            confirmButtonText: 'Yes, Approve',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                update_status(id, 'approve');
            }
        });
    });

    $('.btn-reject').on('click', function() {
        let id = $(this).data('id');

            Swal.fire({
                icon: 'warning',
                title: 'Reject Flight Proposal',
                width: '700px',
                html: `
                    <div style="text-align:center;width:100%;">
                        <label for="reject_note"><strong>Rejection Note</strong></label>
                        <textarea id="reject_note"></textarea>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Reject',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#dc3545',

                didOpen: () => {
                    tinymce.init({
                        selector: '#reject_note',
                        width: 662,
                        height: 200,
                        menubar: false,
                        branding: false,
                        plugins: 'lists link',
                        toolbar: 'undo redo | bold italic underline | bullist numlist | link'
                    });
                },

                preConfirm: () => {
                    const content = tinymce.get('reject_note').getContent();

                    if (!content || content.replace(/<[^>]*>/g, '').trim() === '') {
                        Swal.showValidationMessage('Rejection note is required.');
                        return false;
                    }

                    return content;
                },

                willClose: () => {
                    const editor = tinymce.get('reject_note');
                    if (editor) {
                        editor.remove();
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    update_status(id, 'reject', result.value);
                }
            });
        // Swal.fire({
        //     icon: 'question',
        //     title: 'Confirm Rejection',
        //     text: 'Are you sure you want to reject this application?',
        //     showCancelButton: true,
        //     confirmButtonText: 'Yes, Reject',
        //     cancelButtonText: 'Cancel',
        //     confirmButtonColor: '#dc3545',
        // }).then((result) => {
        //     if (result.isConfirmed) {
        //         update_status(id, 'reject');
        //     }
        // });
    });

    $('.btn-cancelled').on('click', function() {
        let id = $(this).data('id');

        Swal.fire({
            icon: 'warning',
            title: 'Cancel Travel Proposal',
            width: '700px',
            html: `
                <div style="text-align:center;width:100%;">
                    <label for="reject_note"><strong>Cancelled Note</strong></label>
                    <textarea id="reject_note"></textarea>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Submit',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#dc3545',

            didOpen: () => {
                tinymce.init({
                    selector: '#reject_note',
                    width: 662,
                    height: 200,
                    menubar: false,
                    branding: false,
                    plugins: 'lists link',
                    toolbar: 'undo redo | bold italic underline | bullist numlist | link'
                });
            },

            preConfirm: () => {
                const content = tinymce.get('reject_note').getContent();

                if (!content || content.replace(/<[^>]*>/g, '').trim() === '') {
                    Swal.showValidationMessage('Cancelled note is required.');
                    return false;
                }

                return content;
            },

            willClose: () => {
                const editor = tinymce.get('reject_note');
                if (editor) {
                    editor.remove();
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                update_status(id, 'cancel', result.value);
            }
        });
    });

    function update_status(id, action, note = '') {
        let form_data = {
            id: id,
            note: note,
            action: action
        };

        let selected_intl = $('input[name="international_attachment"]:checked').val();
        let selected_dom = $('input[name="domestic_attachment"]:checked').val();

        if (selected_intl) {
            form_data.international_attachment = selected_intl;
        }
        if (selected_dom) {
            form_data.domestic_attachment = selected_dom;
        }
        var icon = (action === 'reject') ? 'error' : 'success';
        var title = (action === 'reject') ? 'Rejected' : 'Success';

        $.ajax({
            url: '<?= site_url('admin/travel_arrangement_non_eta/update_status') ?>',
            type: 'POST',
            data: form_data,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: icon,
                        title: title,
                        text: response.message,
                        confirmButtonText: 'close',
                    }).then(() => {
                        window.location.href = window.location.pathname + window.location.search.split('&')[0] + '?pid=flight-proposal';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Failed to update status',
                        confirmButtonText: 'close',
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while updating the status',
                    confirmButtonText: 'close',
                });
            }
        });
    }
    
    $('.btn-create-payment').on('click', function() {
        let application_id = $(this).data('application-id');
        let grantee_grant_id = $(this).data('grantee-grant-id');
        let user_id = $(this).data('user-id');

        // Populate modal form
        $('#travel_arrangement_application_id').val(application_id);
        $('#payment_grantee_grant_id').val(grantee_grant_id);
        $('#payment_user_id').val(user_id);

        loadBankInfo(user_id);

        loadMemoBudget(grantee_grant_id);

        loadSubCategories();

        $('.additional-proof-of-expense').empty();
        if (typeof receiptAttachmentsData !== 'undefined' && receiptAttachmentsData.length > 0) {
            $.each(receiptAttachmentsData, function(i, att) {
                let paths = [];
                let names = [];

                if (typeof att.file_path === 'string' && (att.file_path.trim().startsWith('[') || att.file_path.trim().startsWith('{'))) {
                    try {
                        let parsed = JSON.parse(att.file_path);
                        if (Array.isArray(parsed)) {
                            paths = parsed;
                        } else if (typeof parsed === 'string') {
                            paths = [parsed];
                        }
                    } catch (e) {
                        paths = [att.file_path];
                    }
                } else if (Array.isArray(att.file_path)) {
                    paths = att.file_path;
                } else if (att.file_path) {
                    paths = [att.file_path];
                }

                if (typeof att.file_name === 'string' && (att.file_name.trim().startsWith('[') || att.file_name.trim().startsWith('{'))) {
                    try {
                        let parsedN = JSON.parse(att.file_name);
                        if (Array.isArray(parsedN)) {
                            names = parsedN;
                        } else if (typeof parsedN === 'string') {
                            names = [parsedN];
                        }
                    } catch (e) {
                        names = [att.file_name];
                    }
                } else if (Array.isArray(att.file_name)) {
                    names = att.file_name;
                } else if (att.file_name) {
                    names = [att.file_name];
                }

                $.each(paths, function(idx, p) {
                    if (!p) return;
                    let cleanPath = p.replace(/^\.?\//, '');
                    let fileUrl = base_url + cleanPath;
                    let fileName = (names && names[idx]) ? names[idx] : p.split('/').pop();

                    let itemHtml = '<div class="payment-attachment" style="margin-bottom: 5px;">' +
                        '<div class="col-md-12">' +
                        '<div class="form-group" style="margin-bottom: 5px;">' +
                        '<a href="' + fileUrl + '" target="_blank" class="lightbox">' +
                        '<label class="label label-primary" style="cursor:pointer; margin-right: 6px;"><i class="fa fa-eye"></i> View Proof</label>' +
                        '</a>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                    $('.additional-proof-of-expense').append(itemHtml);
                });
            });
            $('.lightbox').topbox();
        }

        $('#mdl_add_travel_arrangement_payment').modal('show');
    });

    function loadBankInfo(user_id) {
        $.ajax({
            url: '<?= base_url('admin/request_payment/get_bank_info') ?>',
            type: 'GET',
            data: { user_id: user_id },
            dataType: 'json',
            success: function(data) {
                let bankSelect = $('#payment_bank_info_id');
                bankSelect.empty().append('<option value="">Select Bank Account</option>');
                $.each(data, function(i, bank) {
                    bankSelect.append('<option value="' + bank.id + '">' + bank.bank_name + ' (' + bank.currency + ') - ' + bank.account_number + '</option>');
                });
            }
        });
    }

    function loadMemoBudget(grantee_grant_id) {
        $.ajax({
            url: '<?= base_url('admin/request_payment/get_memo_budget') ?>',
            type: 'GET',
            data: { grantee_grant_id: grantee_grant_id },
            dataType: 'json',
            success: function(data) {
                let memoBudgetSelect = $('select[name="add_travel[user_grantee_grant_memo_id]"]');
                if (memoBudgetSelect.length) {
                    memoBudgetSelect.empty().append('<option value="">Select Memo Budget</option>');
                    if (data && data.length > 0) {
                        $.each(data, function(i, memo) {
                            if(memo.is_active === 'No') { return }
                            memoBudgetSelect.append('<option value="' + memo.id + '">' + memo.file_name + '</option>');
                        });
                    }
                }
            }
        });
    }

    function loadSubCategories() {
        $.ajax({
            url: '<?= base_url('admin/request_payment/get_sub_categories_and_items') ?>',
            type: 'GET',
            data: { category: 'International Travel' },
            dataType: 'json',
            success: function(data) {
                window.paymentItems = data.items;
                window.paymentSubCategories = data.sub_categories;

                let firstSelect = $('#select_sub_category_travel_0');
                firstSelect.empty().append('<option value="">-- Select Sub Category --</option>');
                $.each(data.sub_categories, function(i, item) {
                    firstSelect.append('<option value="' + item.id + '">' + item.name + '</option>');
                });

                // Initialize select2
                initializeSelect2();
            }
        });
    }

    $('#btn-submit-travel').on('click', function(e) {
        e.preventDefault();

        let form_data = new FormData();
        let travel_arrangement_application_id = $('#travel_arrangement_application_id').val();

        form_data.append('travel_arrangement_application_id', travel_arrangement_application_id);

        $('#mdl_add_travel_arrangement_payment').find('input, select, textarea').each(function() {
            let name = $(this).attr('name');
            let type = $(this).attr('type');
            let value = $(this).val();

            if (type === 'file') {
                if (this.files && this.files.length > 0) {
                    if (name === 'add_proof_travel' || name === 'add_proof_of_conversion_travel') {
                        form_data.append(name, this.files[0]);
                    }
                    else if (name === 'add_proof_expense_travel' || name === 'proof_of_expenses[]') {
                        for (let i = 0; i < this.files.length; i++) {
                            form_data.append('proof_of_expenses[]', this.files[i]);
                        }
                    }
                }
            }
            
            else if (name && name !== 'btn' &&
                name !== 'travel_arrangement_application_id' &&
                name !== 'grantee_grant_id' &&
                name !== 'user_id') {
                form_data.append(name, value);
            }
        });

        $.ajax({
            url: '<?= site_url('admin/travel_arrangement_non_eta/save_payment') ?>',
            type: 'POST',
            data: form_data,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#mdl_add_travel_arrangement_payment').modal('hide');
                    window.location.href = window.location.pathname + window.location.search.split('&')[0] + '?pid=payment';
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Failed to save payment',
                        confirmButtonText: 'OK',
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while saving payment: ' + error,
                    confirmButtonText: 'OK',
                });
            }
        });
    });

    $('.btn-view-payment').on('click', function() {
        let payment_id = $(this).data('payment-id');
        let user_id = $(this).data('user-id');
        let grantee_grant_id = $(this).data('grantee-grant-id');
        let category = $(this).data('cat') === 'Grant Supporting' ? 'support' : 'travel';

        window.location.href = '<?= base_url('admin/request_payment/edit/') ?>' + user_id + '/' + grantee_grant_id + '?payment_id=' + payment_id + '&pid=' + category;
    });

    $('.travel-payment-sub-category').on('change', function() {
        $(this).closest('div').find('.travel-payment-sub-category-validation').addClass('hide');
    });

    $('.btn-flight-option-detail').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        let description = $(this).data('description') || '-';
        let price = $(this).data('price') || '-';
        let currency = $(this).data('currency') || '-';

        $('#flight-option-detail-price').text(price);
        $('#flight-option-detail-currency').text(currency);
        $('#flight-option-detail-description').text(description);
        $('#flight-option-detail-modal').modal('show');
    });
});

$('.payment_category_support').on('change', function() {
    var sub_category = '#select_sub_category_record_support';

    $(sub_category).empty();
    $(sub_category).append('<option value="">-- Select Sub Category --</option>');
    get_sub_category_support($(this).val(),sub_category);
});

function get_sub_category_support(category_type,select_sub_category, selected_id = null) {
    $.ajax({
        type: 'POST',
        url: '<?php echo site_url('admin/payment_item/get_sub_category') ?>',
        data: {
            'category_type': category_type
        },
        dataType: 'JSON',
        success: function(r) {

            $.each(r, function(id, val) {
                $(select_sub_category).append('<option value="' + val.id + '">' + val.name + '</option>');
            });

            if (selected_id) {
                $(select_sub_category).val(selected_id).trigger('change');
            }
        }
    });
}

$('.payment_sub_category_support').on('change', function() {
    var category_type = $('.payment_category_support').val();
    var sub_category = $(this).val();
    var payment_item = '.setup-payment-item-support';
    
    $(payment_item).empty();
    $(payment_item).append('<option value="">-- Select Item --</option>');
    get_payment_item_support(category_type,sub_category,payment_item);
    $(this).closest('div').find('.payment-sub-category-record-validation').addClass('hide');
});

function get_payment_item_support(category_type, sub_category, payment_item, callback = null){

    $.ajax({
        type: 'POST',
        url: '<?php echo site_url('admin/payment_item/get_payment_item') ?>',
        data: {
            'category_type': category_type,
            'sub_category': sub_category,
        },
        dataType: 'JSON',
        success: function(r) {

            $(payment_item).each(function(){

                let $select = $(this);
                let selected = $select.data('selected'); // ambil dari attribute

                $select.empty().append('<option value="">Select Payment Item</option>');

                $.each(r, function(id, val) {
                    $select.append('<option value="' + val.id + '">' + val.payment_item + '</option>');
                });
                $select.append('<option value="__add_new__" data-category="payment_category_support" data-subcategory="select_sub_category_record_support" data-select="setup-payment-item-support"> <span class="glyphicon glyphicon-plus"></span> Add Payment Item</option>');

                if(selected){
                    $select.val(selected).trigger('change');
                }
            });
            $(".select2").select2({
                templateResult: function (data) {
                    if (data.id === '__add_new__') {
                        return $('<span style="color:#337ab7;"> <span class="glyphicon glyphicon-plus"></span> Add Payment Item</span>');
                    }
                    return data.text;
                }
            });

            if(callback) callback();
        }
    });
}

$(document).on("click", ".add-setup-support-item", function(){
    let $tbody = $(this).closest(".setup-block-support").find("tbody");
    let category    = $('.payment-category-record-support').val(),
        sub_category= $('#select_sub_category_record_support').val(),
        selectedOpt = $('#select-grantee-support option:selected'),
        grantee_grant_id = $(this).data('granteegrantid');

    let trIndex = $(this).closest(".setup-block-support").find($('.tr-payment-item-support')).length;

    // load Payment Items
    let getPaymentItems = getSyncData("<?= site_url('admin/payment_item/get_payment_item'); ?>", {
        category_type: category, sub_category, country_id: 2
    });
    let rowHtml = `
        <tr class="tr-payment-item-support">
            <td>
                <select class="form-control setup-payment-item-support select2" name="add_travel[items][${trIndex}][item]">
                    <option value=''>Select Payment Item</option>
                    ${JSON.parse(getPaymentItems).map(v => `<option value="${v.id}">${v.payment_item}</option>`).join('')}
                    <option value="__add_new__" data-category="payment_category_support" data-subcategory="select_sub_category_record_support" data-select="setup-payment-item-support"> <span class="glyphicon glyphicon-plus"></span> Add Payment Item</option>
                </select>
            </td>
            <td><input type="text" class="form-control setup-idr convert-setup-idr" name="add_travel[items][${trIndex}][nominal_idr]"></td>
            <td><input type="text" class="form-control setup-usd convert-setup-usd" name="add_travel[items][${trIndex}][nominal]"></td>
            <td class="text-center">
                <button type="button" class="hide-view btn btn-danger btn-sm hide-view remove-item-support"><span class="glyphicon glyphicon-trash"></span></button>
            </td>
        </tr>`;
    $tbody.append(rowHtml);
    $(".select2").select2({
        templateResult: function (data) {
            if (data.id === '__add_new__') {
                return $('<span style="color:#337ab7;"> <span class="glyphicon glyphicon-plus"></span> Add Payment Item</span>');
            }
            return data.text;
        }
    });
});

$(document).on("click", ".remove-item-support", function(){
    if (confirm("Are you sure want to delete this ?")){
    $(this).closest("tr").remove();
    updateSubtotalSupport($(this).closest(".setup-block-support"));
    updateGlobalTotalSupport()
    }
});

function updateSubtotalSupport($setupBlock){
    let idrTotal = 0, usdTotal = 0;

    // ambil hanya grantee yang dicentang
    let $checkedGrantees = $setupBlock.find(".grantee-card-support").has(".grantee-check-support:checked");
    let countGrantee = $checkedGrantees.length;

    // kalau tidak ada yang dicentang, bisa default ke 1 atau 0 tergantung kebutuhan
    if (countGrantee === 0) countGrantee = 1;

    $setupBlock.find("tbody tr").each(function(){
    let idr = parseIDR($(this).find(".setup-idr").val()) || 0;
    let usd = parseUSD($(this).find(".setup-usd").val()) || 0;
    idrTotal += idr;
    usdTotal += usd;
    });
    // let $granteeLength = $setupBlock.find(".grantee-card-support").length;

    // let countGrantee = $granteeLength == 0 ? 1 : $granteeLength;
    $setupBlock.find(".subtotal-idr-support").text(formatIDR(idrTotal*countGrantee));
    $setupBlock.find(".subtotal-usd-support").text(formatUSD(usdTotal*countGrantee));
    updateGlobalTotalSupport();
}

function updateGlobalTotalSupport(){
    let globalIdr = 0, globalUsd = 0;
    $(".setup-block-support").each(function(){
    globalIdr += parseIDR($(this).find(".subtotal-idr-support").text()) || 0;
    globalUsd += parseUSD($(this).find(".subtotal-usd-support").text()) || 0;
    });
    $("#global-idr-support").text(formatIDR(globalIdr));
    $("#global-usd-support").text(formatUSD(globalUsd));
}

$(document).on("input", ".setup-idr, .setup-usd", function(){
    let $setupBlock = $(this).closest(".setup-block-support");
    updateSubtotalSupport($setupBlock);
});
</script>
