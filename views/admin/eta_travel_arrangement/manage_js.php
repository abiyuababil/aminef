<script>
    const base_url = "<?= base_url() ?>";

    function unformat_price(value, currency) {
        if (!value) return '';
        value = String(value).trim();
        currency = String(currency || 'USD').toUpperCase();
        value = value.replace(/[^0-9.,-]/g, '');
        
        if (currency === 'IDR') {
            const dotCount = (value.match(/\./g) || []).length;
            const commaCount = (value.match(/,/g) || []).length;
            
            if (dotCount > 0 && commaCount > 0) {
                const lastDotIdx = value.lastIndexOf('.');
                const lastCommaIdx = value.lastIndexOf(',');
                if (lastCommaIdx > lastDotIdx) {
                    value = value.replace(/\./g, '').replace(/,/g, '.');
                } else {
                    value = value.replace(/,/g, '');
                }
            } else if (dotCount > 1) {
                value = value.replace(/\./g, '');
            } else if (commaCount > 1) {
                value = value.replace(/,/g, '');
            } else if (dotCount === 1) {
                const parts = value.split('.');
                if (parts[1].length >= 3) {
                    value = value.replace(/\./g, '');
                }
            } else if (commaCount === 1) {
                const parts = value.split(',');
                if (parts[1].length >= 3) {
                    value = value.replace(/,/g, '');
                } else {
                    value = value.replace(/,/g, '.');
                }
            }
        } else {
            const dotCount = (value.match(/\./g) || []).length;
            const commaCount = (value.match(/,/g) || []).length;
            
            if (dotCount > 0 && commaCount > 0) {
                const lastDotIdx = value.lastIndexOf('.');
                const lastCommaIdx = value.lastIndexOf(',');
                if (lastDotIdx > lastCommaIdx) {
                    value = value.replace(/,/g, '');
                } else {
                    value = value.replace(/\./g, '').replace(/,/g, '.');
                }
            } else if (commaCount > 1) {
                value = value.replace(/,/g, '');
            } else if (dotCount > 1) {
                value = value.replace(/\./g, '');
            } else if (commaCount === 1) {
                const parts = value.split(',');
                if (parts[1].length >= 3) {
                    value = value.replace(/,/g, '');
                } else {
                    value = value.replace(/,/g, '.');
                }
            } else if (dotCount === 1) {
                const parts = value.split('.');
                if (parts[1].length >= 3) {
                    value = value.replace(/\./g, '');
                }
            }
        }
        return value;
    }

    function currency_symbol(code) {
        if (!code) return '';
        code = String(code).toUpperCase();
        switch (code) {
            case 'USD': return '$';
            case 'IDR': return 'Rp';
            default: return code;
        }
    }

    function formatCurrencyValue(value, currency) {
        if (value === null || value === undefined || value === '') return '';
        let unformatted = unformat_price(value, currency);
        let num = Number(unformatted);
        if (isNaN(num)) return value;
        const locales = { 'USD': 'en-US', 'IDR': 'id-ID' };
        const locale = locales[currency] || 'en-US';
        const opts = {
            style: 'currency',
            currency: currency || 'USD',
            minimumFractionDigits: currency === 'IDR' ? 0 : 2,
            maximumFractionDigits: currency === 'IDR' ? 0 : 2
        };
        try {
            return new Intl.NumberFormat(locale, opts).format(num);
        } catch (e) {
            const symbol = currency_symbol(currency);
            return symbol + ' ' + num.toLocaleString();
        }
    }

    function formatPriceOnTyping(value, currency) {
        if (!value) return '';
        currency = String(currency || 'USD').toUpperCase();
        
        let cleaned = unformat_price(value, currency);
        if (cleaned === '' || cleaned === '-') return cleaned;
        
        let parts = cleaned.split('.');
        let integerPart = parts[0];
        let decimalPart = parts.length > 1 ? parts[1] : null;
        
        let num = Number(integerPart);
        if (isNaN(num)) return value;
        
        let formattedInt = '';
        if (currency === 'IDR') {
            formattedInt = num.toLocaleString('id-ID');
        } else {
            formattedInt = num.toLocaleString('en-US');
        }
        
        let result = formattedInt;
        if (decimalPart !== null) {
            if (currency === 'IDR') {
                result += ',' + decimalPart;
            } else {
                result += '.' + decimalPart;
            }
        }
        
        const symbol = currency_symbol(currency);
        if (symbol) {
            return symbol + ' ' + result;
        }
        return result;
    }

    function formatInputCurrency(input_el, currency) {
        const el = input_el[0];
        if (!el) return;
        const originalVal = input_el.val();
        
        let selectionStart = el.selectionStart;
        let selectionEnd = el.selectionEnd;
        
        const originalBeforeCursor = originalVal.substring(0, selectionStart);
        const originalDigitsBeforeCursor = (originalBeforeCursor.match(/\d/g) || []).length;
        
        const formattedVal = formatPriceOnTyping(originalVal, currency);
        
        if (originalVal === formattedVal) {
            return;
        }
        
        input_el.val(formattedVal);
        
        let newCursorPosition = 0;
        let digitCount = 0;
        for (let i = 0; i < formattedVal.length; i++) {
            if (/\d/.test(formattedVal[i])) {
                digitCount++;
                if (digitCount === originalDigitsBeforeCursor) {
                    newCursorPosition = i + 1;
                    break;
                }
            }
        }
        
        if (newCursorPosition === 0) {
            newCursorPosition = formattedVal.length;
        }
        
        el.setSelectionRange(newCursorPosition, newCursorPosition);
    }
    
    function get_field_display_name(field_name) {
        const field_map = {
            'passport_file': 'Passport',
            'ticket_file': 'Ticket',
            'domestic_ticket_file': 'Ticket',
            'invoice_file': 'Invoice',
            'domestic_invoice_file': 'Invoice',
            'proof_of_payment_file': 'Proof of Payment',
            'domestic_proof_of_payment_file': 'Proof of Payment',
            'accommodation_proposed_file': 'Proposed Accommodation',
            'accommodation_invoice_file': 'Invoice',
            'accommodation_proof_of_payment_file': 'Proof of Payment',
            'voucher_accommodation': 'Voucher Accommodation'
        };
        return field_map[field_name] || 'File';
    }
    
    function updateSelectedCount(section_body_el) {
        var total = section_body_el.find('.eta-row-checkbox:checked').length;

        if(total > 0){
            section_body_el.find('.selected-count').text(total)
            section_body_el.find('.info-selected').removeClass('hide');
        }else{
            section_body_el.find('.selected-count').text(total)
            section_body_el.find('.info-selected').addClass('hide');
        }
    }
    
    $(function () {
        $('#eta_period').select2({ theme: 'bootstrap', placeholder: $('#eta_period').data('placeholder') || '-- Select Period --' });
        $('#eta_program').select2({ theme: 'bootstrap', placeholder: '-- Select Program --', width: '100%' });

        $(document).on('input', 'input[data-field="rate_in_usd"], input[data-field="final_rate"]', function() {
            const el = $(this);
            const row_el = el.closest('tr');
            const currency = (row_el.find('.approved-flight-label span').attr('data-flight-currency') || el.attr('data-rate-currency') || 'USD');
            formatInputCurrency(el, currency);
        });

        $(document).on('input', '#proposed_flight_price', function() {
            const el = $(this);
            const currency = $('#proposed_flight_currency').val() || 'USD';
            formatInputCurrency(el, currency);
        });

        $(document).on('change', '#proposed_flight_currency', function() {
            const el = $('#proposed_flight_price');
            const currency = $(this).val() || 'USD';
            formatInputCurrency(el, currency);
        });

        function auto_select_program(period_val) {
            if (!period_val) return;
            const period_year = $('#eta_period option[value="' + period_val + '"]').text().trim();
            if (!period_year) return;
            $('#eta_program option').each(function() {
                if ($(this).data('period') == period_year) {
                    if ($('#eta_program').val() !== $(this).val()) {
                        $('#eta_program').val($(this).val()).trigger('change');
                    }
                    return false;
                }
            });
        }

        $('#eta_period').on('change', function () {
            auto_select_program($(this).val());
            const program = $('#eta_program').val();
            const period = $(this).val();
            if (!program || !period) {
                $('#grantees_wrap').empty();
                return;
            }

            $.get(base_url + 'admin/eta_travel_arrangement/get_grantee_data', { period: period, program: program }, function (html) {
                $('#grantees_wrap').html(html);
                init_eta_datepickers();
                populate_travel_agent_options();
                load_saved_sections();
                setTimeout(function() {
                    $('.section-status-button-action button:not(.btn-sync)').prop('disabled', true);
                }, 200);
                update_flight_counts();
                window.eta_current_program = program;
                $('.lightbox').topbox();

                try {
                    const qTab = getQueryParam('tab');
                    const qSection = getQueryParam('section');
                    if (qTab) {
                        const tabMap = { 'international': 'international_ticket', 'domestic': 'domestic_ticket', 'accommodation': 'accommodation_venue' };
                        const tabId = tabMap[qTab] || qTab;
                        const tabLink = $('a[href="#' + tabId + '"]');
                        if (tabLink.length) {
                            try { tabLink.tab('show'); } catch (e) { tabLink.trigger('click'); }
                        }
                    }

                    if (qSection) {
                        setTimeout(function() {
                            const target = $('.eta-section[data-db-id="' + qSection + '"]');
                            if (target.length) {
                                target.removeClass('collapsed');
                                target.find('.eta-section-body').show();
                                target.find('.section-status-button-action').removeClass('hide');
                                $('html, body').animate({ scrollTop: target.offset().top - 100 }, 300);
                            }
                        }, 200);
                    }
                } catch (e) {
                    console.error('Error applying query params:', e);
                }
            }, 'html').fail(function () {
                show_toast('Failed to load grantees', 'error');
            });
        });

        function init_eta_datepickers() {
            if (typeof flatpickr !== 'undefined') {
                $('.datepicker').each(function () {
                    if (!$(this).data('flatpickr-initialized')) {
                        const initial = $(this).val();
                        let default_date = null;
                        if (initial) {
                            const parsed = new Date(initial);
                            if (!isNaN(parsed)) default_date = parsed;
                        }
                        flatpickr(this, { dateFormat: 'F j Y', defaultDate: default_date });
                        $(this).data('flatpickr-initialized', true);
                    }
                });
            } else if ($.fn.datepicker) {
                $('.datepicker').each(function () {
                    if (!$(this).data('datepicker-initialized')) {
                        $(this).datepicker({
                            changeMonth: true,
                            changeYear: true,
                            dateFormat: 'MM d yy'
                        });
                        $(this).data('datepicker-initialized', true);
                    }
                });
            }
        }

        init_eta_datepickers();

        function apply_section_filters(section) {
            var searchVal = (section.find('.eta-search-filter').val() || '').toLowerCase().trim();
            var statusVal = section.find('.eta-status-filter').val() || '';

            section.find('tbody tr[data-grantee]').each(function() {
                var row = $(this);
                
                // 1. Status check
                var status = row.find('.eta-status-label').attr('data-status') || '';
                var statusMatch = true;
                if (statusVal === 'blank') {
                    statusMatch = (status === '');
                } else if (statusVal !== '') {
                    statusMatch = (status === statusVal);
                }

                // 2. Search check (grantee name, status text, from airport, to airport, travel agent name)
                var searchMatch = true;
                if (searchVal !== '') {
                    // Grantee Name
                    var granteeName = (row.find('.td-name').text() || row.find('td').eq(1).text() || '').toLowerCase();
                    
                    // Status text
                    var statusText = (row.find('.eta-status-label').text() || '').toLowerCase();
                    
                    // From
                    var fromAirport = (row.find('input[data-field="departure_airport_us"]').val() || row.find('input[data-field="domestic_departure_airport"]').val() || '').toLowerCase();
                    
                    // To
                    var toAirport = (row.find('input[data-field="arrival_airport_indonesia"]').val() || row.find('input[data-field="domestic_arrival_airport"]').val() || '').toLowerCase();
                    
                    // Travel Agent
                    var travelAgent = '';
                    var agentSelect = row.find('select[data-field="travel_agent_id"]');
                    if (agentSelect.length && agentSelect.val()) {
                        travelAgent = (agentSelect.find('option:selected').text() || '').toLowerCase();
                    }

                    searchMatch = (
                        granteeName.indexOf(searchVal) !== -1 ||
                        statusText.indexOf(searchVal) !== -1 ||
                        fromAirport.indexOf(searchVal) !== -1 ||
                        toAirport.indexOf(searchVal) !== -1 ||
                        travelAgent.indexOf(searchVal) !== -1
                    );
                }

                row.toggle(statusMatch && searchMatch);
            });

            section.find('tbody .eta-row-checkbox:not(:visible)').prop('checked', false);
            section.find('.eta-select-all').prop('checked', false);
        }

        $(document).on('change', '.eta-status-filter', function() {
            var section = $(this).closest('.eta-section');
            apply_section_filters(section);
        });

        $(document).on('input keyup', '.eta-search-filter', function() {
            var section = $(this).closest('.eta-section');
            apply_section_filters(section);
        });

        function get_memo_budget_options(selected_id) {
            const memo_budgets_json = $('#eta_memo_budgets');
            let options = '<option value="">- Select Memo Budget -</option>';
            if (!memo_budgets_json.length) return options;
            try {
                const memos = JSON.parse(memo_budgets_json.text());
                if (Array.isArray(memos)) {
                    memos.forEach(function(memo) {
                        const sel = (selected_id && memo.id == selected_id) ? 'selected' : '';
                        const label = (memo.file_name || 'Memo #' + memo.id) + ' (' + (memo.year || '') + ')';
                        options += '<option value="' + memo.id + '" ' + sel + '>' + $('<span>').text(label).html() + '</option>';
                    });
                }
            } catch(e) {}
            return options;
        }

        function get_category_options(tab, selected_id) {
            let options = '<option value="">- Select -</option>';
            
                const cat_select_el = $('.eta-section-category[data-tab="' + tab + '"]');
            if (cat_select_el.length && cat_select_el.find('option').length > 1) {
                cat_select_el.find('option').each(function() {
                    if ($(this).val()) {
                        const sel = (selected_id && $(this).val() == selected_id) ? 'selected' : '';
                        options += '<option value="' + $(this).val() + '" ' + sel + '>' + $(this).text() + '</option>';
                    }
                });
                return options;
            }
            
            const categories_json = $('#eta_categories');
            if (!categories_json.length) return options;
            try {
                const categories = JSON.parse(categories_json.text());
                if (Array.isArray(categories)) {
                    categories.forEach(function(cat) {
                        if (cat.type === tab) {
                            const sel = (selected_id && cat.id == selected_id) ? 'selected' : '';
                            options += '<option value="' + cat.id + '" ' + sel + '>' + $('<span>').text(cat.name).html() + '</option>';
                        }
                    });
                }
            } catch(e) {}
            return options;
        }

        let section_counter = 0;

        const eta_approved_statuses = [
            <?= ETA_TRAVEL_STATUS_ISSUED ?>,
            <?= ETA_TRAVEL_STATUS_BOOKED ?>,
            <?= ETA_TRAVEL_STATUS_BOOK_TICKET ?>,
            <?= ETA_TRAVEL_STATUS_PROCEED_TO_ISSUED ?>
        ];

        function is_approved_eta_status(status) {
            return eta_approved_statuses.indexOf(Number(status)) !== -1;
        }

        function format_datetime_for_db(date) {
            function pad(n) { return n < 10 ? '0' + n : '' + n; }
            return date.getFullYear() + '-' + pad(date.getMonth() + 1) + '-' + pad(date.getDate()) +
                ' ' + pad(date.getHours()) + ':' + pad(date.getMinutes()) + ':' + pad(date.getSeconds());
        }

        function refresh_set_approval_button(section_el) {
            if (typeof is_administrator === 'undefined' || !is_administrator) return;
            const btn = section_el.find('.btn-set-approval-section');
            if (!btn.length) return;

            let approved = false;
            section_el.find('tbody tr[data-grantee] .eta-status-label').each(function() {
                const st = $(this).attr('data-status');
                if (st && is_approved_eta_status(st)) { approved = true; return false; }
            });
            if (!approved) { btn.hide(); return; }

            const approved_by = section_el.attr('data-approved-by') || '';
            const approved_at = section_el.attr('data-approved-at') || '';
            btn.toggle(approved_by === '' || approved_at === '');
        }

        function check_and_toggle_empty_alert(tab) {
            const container = $('.eta-sections-container[data-tab="' + tab + '"]');
            const section_count = container.find('.eta-section').length;
            const alert_el = container.find('.eta-empty-alert');
            
            if (section_count === 0) {
                if (!alert_el.length) {
                    const alert_html = '<div class="alert alert-info eta-empty-alert" role="alert"><i class="fa fa-info-circle"></i> No data available</div>';
                    container.html(alert_html);
                }
            } else {
                alert_el.remove();
            }
        }

        function create_section(tab, category_name, flight_type, db_id, category_id, collapsed, memo_budget_id, note, approved_by, approved_at) {
            if (tab === 'accommodation') {
                create_section_accommodation(category_name, db_id, category_id, collapsed, memo_budget_id, note, approved_by, approved_at);
                return;
            }
            section_counter++;
            const idx = section_counter;
            const tpl_id = tab === 'international' ? '#eta_intl_tpl' : '#eta_dom_tpl';
            let table_html = $(tpl_id).html();

            $('.eta-sections-container[data-tab="' + tab + '"]').find('.eta-empty-alert').remove();

            table_html = table_html.replace(/eta_file_/g, 'eta_file_s' + idx + '_');

            const safe_label = $('<span>').text(category_name + ' - ' + flight_type).html();
            const safe_cat = $('<span>').text(category_name).html();
            const safe_ft = $('<span>').text(flight_type).html();
            const cls = collapsed ? 'eta-section collapsed' : 'eta-section';

            const cat_options_html = get_category_options(tab, category_id);

            const memo_options = get_memo_budget_options(memo_budget_id || '');
            const note_val = note ? $('<span>').text(note).html() : '';

            const section_html =
                '<div class="' + cls + '" data-section="' + idx + '" data-db-id="' + (db_id || '') + '" data-approved-by="' + (approved_by || '') + '" data-approved-at="' + (approved_at || '') + '" data-category="' + safe_cat + '" data-flight-type="' + safe_ft + '" data-category-id="' + (category_id || '') + '">' +
                            '<div class="eta-section-header">' +
                                '<h5 style="margin: 0;"><i class="fa fa-chevron-down eta-collapse-icon"></i>' + safe_label + '</h5>' +
                                '<div style="display:flex; gap:6px; align-items:center;">' +
                                    '<button type="button" class="btn btn-xs btn-warning btn-set-approval-section" title="Set Approval" style="display:none;"><i class="fa fa-check-circle"></i> Set Approval</button>' +
                                    '<button type="button" class="btn btn-xs btn-success btn-download-section" title="Download Excel">Download Excel</button>' +
                                    '<button type="button" class="btn btn-xs btn-danger btn-remove-section" title="Remove section"><i class="fa fa-times"></i></button>' +
                                '</div>' +
                            '</div>' +
                    '<div class="eta-section-body">' +
                        '<div class="row mb-3">' +
                            '<div class="col-md-6 mb-4">' +
                                '<label><strong>Category</strong></label>' +
                                '<select class="form-control eta-edit-category">' + cat_options_html + '</select>' +
                            '</div>' +
                            '<div class="col-md-6 mb-4">' +
                                '<label><strong>Flight Type</strong></label>' +
                                '<select class="form-control form-control-sm eta-edit-flight-type">' +
                                    '<option value="Roundtrip" ' + (flight_type === 'Roundtrip' ? 'selected' : '') + '>Roundtrip</option>' +
                                    '<option value="One Way" ' + (flight_type === 'One Way' ? 'selected' : '') + '>One Way</option>' +
                                '</select>' +
                            '</div>' +
                            '<div class="col-md-6 mb-4">' +
                                '<label><strong>Memo Budget</strong></label>' +
                                '<select class="form-control eta-section-memo-budget">' + memo_options + '</select>' +
                            '</div>' +
                            '<div class="col-md-12 mb-4">' +
                                '<label><strong>Note</strong></label>' +
                                '<textarea class="form-control eta-section-note" rows="2" placeholder="Add note...">' + note_val + '</textarea>' +
                            '</div>' +
                        '</div>' +
                        '<div class="mb-3 mt-4 section-status-button-action" style="display: flex; gap: 10px; align-items: center;">' +
                            '<button type="button" class="btn btn-sm mr-1 btn-find-flights" style="background:#0284c7;color:#fff;border-color:#0284c7;"><i class="fa fa-search"></i> Find Flights</button>' +
                            '<button type="button" class="btn btn-sm mr-1 btn-find-other-flights" style="background:#0284c7;color:#fff;border-color:#0284c7;"><i class="fa fa-search-plus"></i> Find Other Flight Options</button>' +
                            '<button type="button" class="btn btn-sm mr-1 btn-notify-grantee" style="background:#0284c7;color:#fff;border-color:#0284c7;"><i class="fa fa-bell"></i> Notify Grantee</button>' +
                            '<button type="button" class="btn btn-sm mr-1 btn-proceed-book" style="background:#0284c7;color:#fff;border-color:#0284c7;display:none;"><i class="fa fa-shopping-cart"></i> Book Ticket</button>' +
                            '<button type="button" class="btn btn-sm mr-1 btn-issued-ticket" style="background:#0284c7;color:#fff;border-color:#0284c7;display:none;"><i class="fa fa-ticket"></i> Proceed to Issue</button>' +
                            '<button type="button" class="btn btn-sm btn-proceed-issue" style="background:#0284c7;color:#fff;border-color:#0284c7;"><i class="fa fa-check-circle"></i> Proceed to Issue</button>' +
                            '<button type="button" class="btn btn-sm btn-success btn-generate-pdf" style="display:none;"><i class="fa fa-file-pdf-o"></i> Download Approval</button>' +
                            '<button type="button" class="btn btn-sm btn-success btn-sync" style="display:none;"><i class="fa fa-repeat"></i> Sync</button>' +
                            '<div style="margin-left:auto;display:flex;align-items:center;gap:15px;">' +
                                '<div style="display:flex;align-items:center;gap:6px;">' +
                                    '<i class="fa fa-search" style="color:#888;font-size:14px;"></i>' +
                                    '<input type="text" class="form-control input-sm eta-search-filter" placeholder="Search..." style="width:180px;">' +
                                '</div>' +
                                '<div style="display:flex;align-items:center;gap:6px;">' +
                                    '<i class="fa fa-filter" style="color:#888;font-size:14px;"></i>' +
                                    '<select class="form-control input-sm eta-status-filter" style="width:180px;">' + get_status_filter_options_html(!is_tba) + '</select>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                        '<div class="mb-3 mt-4 section-selected" style="display: flex; gap: 10px; align-items: center;">' +
                            '<strong class="badge badge-info info-selected hide"><span class="selected-count">0</span> selected</strong>' +
                        '</div>' +
                        table_html +
                    '</div>' +
                '</div>';

            $('.eta-sections-container[data-tab="' + tab + '"]').append(section_html);
            
            const section_el = $('.eta-section[data-section="' + idx + '"]');
            section_el.find('tr').each(function() {
                $(this).find('.approved-flight-label span').text('No selection').removeAttr('data-flight-id').removeAttr('data-flight-description').removeAttr('data-flight-name').removeAttr('data-flight-price').removeAttr('data-travel-id');
                $(this).find('input[data-field="rate_in_usd"]').val('');
                $(this).find('input[data-field="departure_date"], input[data-field="returning_date"], input[data-field="domestic_departure_airport"], input[data-field="domestic_arrival_airport"]').val('');
                $(this).find('input[data-field="arrival_airport_indonesia"]').val('Jakarta (CGK)');
            });
            
            populate_section_travel_data(idx, db_id, tab, safe_label);
            
            setTimeout(function() {
                update_flight_counts();
                apply_tba_restrictions($('.eta-section[data-section="' + idx + '"]'));
                apply_aminef_staff_restrictions($('.eta-section[data-section="' + idx + '"]'));
                $('.eta-section[data-section="' + idx + '"]').find('.section-status-button-action button:not(.btn-sync)').prop('disabled', true);
                refresh_set_approval_button($('.eta-section[data-section="' + idx + '"]'));
            }, 100);
            
            init_eta_datepickers();
        }

        function create_section_accommodation(category_name, db_id, category_id, collapsed, memo_budget_id, note, approved_by, approved_at) {
            section_counter++;
            const idx = section_counter;
            let table_html = $('#eta_accom_tpl').html();

            $('.eta-sections-container[data-tab="accommodation"]').find('.eta-empty-alert').remove();

            table_html = table_html.replace(/eta_file_/g, 'eta_file_s' + idx + '_');

            const safe_cat = $('<span>').text(category_name).html();
            const cls = collapsed ? 'eta-section collapsed' : 'eta-section';

            const cat_options_html = get_category_options('accommodation', category_id);

            const memo_options = get_memo_budget_options(memo_budget_id || '');
            const note_val = note ? $('<span>').text(note).html() : '';

            const section_html =
                '<div class="' + cls + '" data-section="' + idx + '" data-db-id="' + (db_id || '') + '" data-approved-by="' + (approved_by || '') + '" data-approved-at="' + (approved_at || '') + '" data-category="' + safe_cat + '" data-tab="accommodation" data-flight-type="" data-category-id="' + (category_id || '') + '">' +
                        '<div class="eta-section-header">' +
                            '<h5 style="margin: 0;"><i class="fa fa-chevron-down eta-collapse-icon"></i>' + safe_cat + '</h5>' +
                            '<div style="display:flex; gap:6px; align-items:center;">' +
                                '<button type="button" class="btn btn-xs btn-warning btn-set-approval-section" title="Set Approval" style="display:none;"><i class="fa fa-check-circle"></i> Set Approval</button>' +
                                '<button type="button" class="btn btn-xs btn-success btn-download-section" title="Download Excel">Download Excel</button>' +
                                '<button type="button" class="btn btn-xs btn-danger btn-remove-section" title="Remove section"><i class="fa fa-times"></i></button>' +
                            '</div>' +
                        '</div>' +
                    '<div class="eta-section-body">' +
                        '<div class="row mb-3">' +
                            '<div class="col-md-6 mb-4">' +
                                '<label><strong>Category</strong></label>' +
                                '<select class="form-control eta-edit-category">' + cat_options_html + '</select>' +
                            '</div>' +
                            '<div class="col-md-6 mb-4">' +
                                '<label><strong>Memo Budget</strong></label>' +
                                '<select class="form-control eta-section-memo-budget">' + memo_options + '</select>' +
                            '</div>' +
                            '<div class="col-md-12 mb-4">' +
                                '<label><strong>Note</strong></label>' +
                                '<textarea class="form-control eta-section-note" rows="2" placeholder="Add note...">' + note_val + '</textarea>' +
                            '</div>' +
                        '</div>' +
                        '<div class="mb-3 mt-4 section-status-button-action" style="display: flex; gap: 10px; align-items: center;">' +
                            '<button type="button" class="btn btn-sm mr-1 btn-find-flights" style="background:#0284c7;color:#fff;border-color:#0284c7;"><i class="fa fa-search"></i> Find Accommodation</button>' +
                            '<button type="button" class="btn btn-sm mr-1 btn-find-other-flights" style="background:#0284c7;color:#fff;border-color:#0284c7;"><i class="fa fa-search-plus"></i> Find Other Accommodation</button>' +
                            '<button type="button" class="btn btn-sm mr-1 btn-proceed-book" style="background:#0284c7;color:#fff;border-color:#0284c7;display:none;"><i class="fa fa-shopping-cart"></i> Proceed to Book</button>' +
                            // '<button type="button" class="btn btn-sm mr-1 btn-issued-ticket" style="background:#0284c7;color:#fff;border-color:#0284c7;display:none;"><i class="fa fa-ticket"></i> Proceed to Issue</button>' +
                            '<button type="button" class="btn btn-sm btn-proceed-issue" style="background:#0284c7;color:#fff;border-color:#0284c7;"><i class="fa fa-check-circle"></i> Proceed to Issue</button>' +
                            // '<button type="button" class="btn btn-sm btn-success btn-generate-pdf" style="display:none;"><i class="fa fa-file-pdf-o"></i> Download Approval</button>' +
                            '<button type="button" class="btn btn-sm btn-success btn-sync" style="display:none;"><i class="fa fa-repeat"></i> Sync</button>' +
                            '<div style="margin-left:auto;display:flex;align-items:center;gap:15px;">' +
                                '<div style="display:flex;align-items:center;gap:6px;">' +
                                    '<i class="fa fa-search" style="color:#888;font-size:14px;"></i>' +
                                    '<input type="text" class="form-control input-sm eta-search-filter" placeholder="Search..." style="width:180px;">' +
                                '</div>' +
                                '<div style="display:flex;align-items:center;gap:6px;">' +
                                    '<i class="fa fa-filter" style="color:#888;font-size:14px;"></i>' +
                                    '<select class="form-control input-sm eta-status-filter" style="width:180px;">' + get_status_filter_options_html(!is_tba) + '</select>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                        '<div class="mb-3 mt-4 section-selected" style="display: flex; gap: 10px; align-items: center;">' +
                            '<strong class="badge badge-info info-selected hide"><span class="selected-count">0</span> selected</strong>' +
                        '</div>' +
                        table_html +
                    '</div>' +
                '</div>';

            $('.eta-sections-container[data-tab="accommodation"]').append(section_html);

            const section_el = $('.eta-section[data-section="' + idx + '"]');
            section_el.find('tr').each(function() {
                $(this).find('input[data-field*="date"]').val('');
            });

            populate_section_travel_data(idx, db_id, 'accommodation', safe_cat);

            setTimeout(function() {
                apply_tba_restrictions($('.eta-section[data-section="' + idx + '"]'));
                apply_aminef_staff_restrictions($('.eta-section[data-section="' + idx + '"]'));
                $('.eta-section[data-section="' + idx + '"]').find('.section-status-button-action button:not(.btn-sync)').prop('disabled', true);
                refresh_set_approval_button($('.eta-section[data-section="' + idx + '"]'));
            }, 100);
            
            init_eta_datepickers();
        }

        function get_section_travel_payload() {
            const payload_el = $('#eta_section_travel_data');
            if (!payload_el.length) return {};

            try {
                return JSON.parse(payload_el.text()) || {};
            } catch (e) {
                return {};
            }
        }

        function create_duplicate_section_row(base_row, section_id, travel_record_id, row_index) {
            const new_row = base_row.clone(false);
            new_row.addClass('eta-duplicate-row');
            new_row.find('.eta-row-checkbox').prop('checked', false);

            new_row.find('.eta-file-wrap').each(function() {
                const wrap = $(this);
                const input = wrap.find('.eta-file-input');
                const field = input.data('field');
                if (!field) return;

                const new_input_id = 'eta_file_section_' + section_id + '_' + travel_record_id + '_' + row_index + '_' + field;
                input.attr('id', new_input_id).val('');

                const label = wrap.find('label');
                if (label.length) {
                    label.attr('for', new_input_id);
                }
            });

            return new_row;
        }

        function apply_travel_record_to_row(row_el, grantee_id, grantee_travel, section_idx, db_id, category_name) {
            const travel_record_id = (grantee_travel && grantee_travel.id) ? grantee_travel.id : 0;
            const total_chat = (grantee_travel && grantee_travel.total_notes) ? grantee_travel.total_notes : '';
            if(travel_record_id == 0){
                const remove_el = $('<button/>', { 'type': 'button', 'class': 'btn btn-sm btn-primary btn-xs create-data-travel', 'data-grantee': grantee_id, 'data-section': section_idx, 'data-db': db_id, 'data-category': category_name, title: 'Create Data Travel' }).html('Create Data Travel');
                row_el.find('.td-name').addClass('text-danger');
            }
            row_el.attr('data-travel-arrangement-id', travel_record_id);
            row_el.find('.eta-row-checkbox')
                .attr('data-travel-id', travel_record_id)
                .data('travel-id', travel_record_id);
            row_el.find('.btn-proposed-flight')
                .attr('data-travel-id', travel_record_id)
                .attr('data-section-idx', section_idx)
                .attr('data-db-id', db_id)
                .data('travel-id', travel_record_id)
                .data('section-idx', section_idx)
                .data('db-id', db_id);
            row_el.find('.approved-flight-label span').attr('data-travel-id', travel_record_id);
            row_el.find('.approved-flight-attachment').attr('data-travel-id', travel_record_id);
            row_el.find('.btn-chat')
                .attr('data-ajax_url', '<?php echo site_url('admin/notes/get_list_ajax/eta_travel/') ?>' + grantee_id + '/' + travel_record_id)
                .attr('data-category', category_name)
                .attr('data-total', total_chat)
                .attr('data-travel', travel_record_id);
            row_el.find('.btn-chat').find('.span-note-travel')
                .addClass('note-total-' + travel_record_id)
                .attr('data-total', total_chat);
            row_el.find('.btn-chat').find('.badge')
                .html(total_chat);
                
            const urlParams = new URLSearchParams(window.location.search);
            const openChat = urlParams.get('open_chat');

            if (openChat) {
                // row_el.find('.btn-chat[data-travel="' + openChat + '"]').trigger('click');
                const $chatButton = row_el.find('.btn-chat[data-travel="' + openChat + '"]')
                
                if ($chatButton.length) {
                    $chatButton.trigger('click');
                    row_el.closest('.eta-section[data-section="' + section_idx + '"]').removeClass('collapsed');
                }
            }


            const file_fields = ['invoice_file', 'domestic_invoice_file', 'proof_of_payment_file', 'domestic_proof_of_payment_file', 'accommodation_proposed_file', 'accommodation_invoice_file', 'accommodation_proof_of_payment_file', 'voucher_accommodation'];
            file_fields.forEach(function(field) {
                const wrap_el = row_el.find('.eta-file-wrap').filter(function() {
                    return $(this).find('.eta-file-input').data('field') === field;
                }).first();
                if (wrap_el.length) {
                    wrap_el.find('.eta-file-download, .eta-file-remove').remove();
                    if (!wrap_el.find('.eta-file-placeholder').length) {
                        wrap_el.append('<span class="eta-file-placeholder text-muted small">No file</span>');
                    }
                }
            });

            if (!grantee_travel) {
                return;
            }

            // Set approved flight label attributes from grantee_travel
            if (grantee_travel.approved_flight_id) {
                const app_span = row_el.find('.approved-flight-label span');
                if (app_span.length) {
                    let display_text = strip_html(grantee_travel.approved_flight_description || grantee_travel.approved_flight_name || '');
                    if (display_text.length > 150) {
                        display_text = display_text.substring(0, 150) + '...';
                    }
                    app_span.text(display_text || 'Selected Flight')
                        // .attr('data-flight-id', grantee_travel.approved_flight_id)
                        // .attr('data-flight-name', grantee_travel.approved_flight_name || '')
                        // .attr('data-flight-description', grantee_travel.approved_flight_description || '')
                        // .attr('data-flight-price', grantee_travel.approved_flight_price || '')
                        .attr('data-flight-currency', grantee_travel.approved_flight_currency || 'USD')
                        .css('cursor', 'pointer')
                        .css('text-decoration', 'underline')
                        .css('color', '#007bff')
                        .addClass('approved-flight-clickable');
                }
            } else {
                const app_span = row_el.find('.approved-flight-label span');
                if (app_span.length) {
                    app_span.text('No selection')
                        // .removeAttr('data-flight-id')
                        // .removeAttr('data-flight-name')
                        // .removeAttr('data-flight-description')
                        // .removeAttr('data-flight-price')
                        .removeAttr('data-flight-currency')
                        .css('cursor', '')
                        .css('text-decoration', '')
                        .css('color', '')
                        .removeClass('approved-flight-clickable');
                }
            }

            if (grantee_travel.status) {
                const is_accom = row_el.closest('.eta-sections-container').attr('data-tab') === 'accommodation';
                const label_el = row_el.find('.eta-status-label');
                let status_text = eta_status_map[grantee_travel.status] || '';
                
                if(status_text === 'Ticket Sent' && is_accom){
                    status_text = 'Voucher Sent' || '';
                }  
                
                label_el.text(status_text).attr('data-status', grantee_travel.status).removeClass('text-muted');
            }

            if (grantee_travel.passport_file) {
                const wrap_el = row_el.find('.eta-file-wrap').filter(function() {
                    return $(this).find('.eta-file-input').data('field') === 'passport_file';
                }).first();
                if (wrap_el.length) {
                    wrap_el.find('.eta-file-placeholder').remove();
                    wrap_el.find('.eta-file-download, .eta-file-remove').remove();
                    const grantee_name = row_el.find('td').eq(1).text();
                    const title_text = get_field_display_name('passport_file') + ' - ' + grantee_name;
                    const download_el = $('<a/>', { 'class': 'btn btn-sm btn-primary eta-file-download lightbox', href: base_url + grantee_travel.passport_file, title: title_text }).html('<i class="fa fa-eye"></i>');
                    const remove_el = $('<button/>', { 'type': 'button', 'class': 'btn btn-sm btn-danger eta-file-remove', 'data-field': 'passport_file', 'data-grantee': grantee_id, title: 'Remove' }).html('<i class="fa fa-trash"></i>');
                    wrap_el.append(download_el).append(remove_el);
                    $('.lightbox').topbox();
                }
            }

            const ticket_fields = ['ticket_file', 'domestic_ticket_file'];
            ticket_fields.forEach(function(field) {
                const wrap_el = row_el.find('.eta-ticket-wrap').filter(function() {
                    return $(this).find('.eta-ticket-file-input').data('field') === field;
                }).first();
                if (!wrap_el.length) return;

                let tickets = [];
                if (grantee_travel[field]) {
                    function parse_recursive_tickets(val) {
                        if (!val) return [];
                        if (Array.isArray(val)) {
                            let res = [];
                            val.forEach(function(item) {
                                res = res.concat(parse_recursive_tickets(item));
                            });
                            return res;
                        }
                        if (typeof val === 'string') {
                            const trimmed = val.trim();
                            if ((trimmed.startsWith('[') && trimmed.endsWith(']')) || (trimmed.startsWith('"') && trimmed.endsWith('"'))) {
                                try {
                                    const parsed = JSON.parse(trimmed);
                                    return parse_recursive_tickets(parsed);
                                } catch(e) {}
                            }
                            return [trimmed];
                        }
                        return [String(val)];
                    }
                    tickets = parse_recursive_tickets(grantee_travel[field]);
                    tickets = tickets.filter(function(t){ return t && String(t).trim() !== ''; });
                }
                wrap_el.data('tickets', tickets);
                const pill_el = wrap_el.find('.btn-ticket-pill');
                const count_label = pill_el.find('.ticket-count-label');
                if (tickets.length > 0) {
                    count_label.text(tickets.length + ' Ticket' + (tickets.length > 1 ? 's' : ''));
                    pill_el.addClass('has-tickets');
                } else {
                    count_label.text('0 Tickets');
                    pill_el.removeClass('has-tickets');
                }
            });

            const invoice_fields = ['invoice_file', 'domestic_invoice_file'];
            invoice_fields.forEach(function(field) {
                if (grantee_travel[field]) {
                    const wrap_el = row_el.find('.eta-file-wrap').filter(function() {
                        return $(this).find('.eta-file-input').data('field') === field;
                    }).first();
                    if (wrap_el.length) {
                        wrap_el.find('.eta-file-placeholder').remove();
                        wrap_el.find('.eta-file-download, .eta-file-remove').remove();
                        const grantee_name = row_el.find('td').eq(1).text();
                        const title_text = get_field_display_name(field) + ' - ' + grantee_name;
                        const download_el = $('<a/>', { 'class': 'btn btn-sm btn-primary eta-file-download lightbox', href: base_url + grantee_travel[field], title: title_text }).html('<i class="fa fa-eye"></i>');
                        const remove_el = $('<button/>', { 'type': 'button', 'class': 'btn btn-sm btn-danger eta-file-remove', 'data-field': field, 'data-grantee': grantee_id, title: 'Remove' }).html('<i class="fa fa-trash"></i>');
                        wrap_el.append(download_el).append(remove_el);
                        $('.lightbox').topbox();
                    }
                }
            });

            const proof_fields = ['proof_of_payment_file', 'domestic_proof_of_payment_file'];
            proof_fields.forEach(function(field) {
                if (grantee_travel[field]) {
                    const wrap_el = row_el.find('.eta-file-wrap').filter(function() {
                        return $(this).find('.eta-file-input').data('field') === field;
                    }).first();
                    if (wrap_el.length) {
                        wrap_el.find('.eta-file-placeholder').remove();
                        wrap_el.find('.eta-file-download, .eta-file-remove').remove();
                        const grantee_name = row_el.find('td').eq(1).text();
                        const title_text = get_field_display_name(field) + ' - ' + grantee_name;
                        const download_el = $('<a/>', { 'class': 'btn btn-sm btn-primary eta-file-download lightbox', href: base_url + grantee_travel[field], title: title_text }).html('<i class="fa fa-eye"></i>');
                        const remove_el = $('<button/>', { 'type': 'button', 'class': 'btn btn-sm btn-danger eta-file-remove', 'data-field': field, 'data-grantee': grantee_id, title: 'Remove' }).html('<i class="fa fa-trash"></i>');
                        wrap_el.append(download_el).append(remove_el);
                        $('.lightbox').topbox();
                    }
                }
            });

            if (grantee_travel.accommodation_proposed_file) {
                const wrap_el = row_el.find('.eta-file-wrap').filter(function() {
                    return $(this).find('.eta-file-input').data('field') === 'accommodation_proposed_file';
                }).first();
                if (wrap_el.length) {
                    wrap_el.find('.eta-file-placeholder').remove();
                    wrap_el.find('.eta-file-download, .eta-file-remove').remove();
                    const grantee_name = row_el.find('td').eq(1).text();
                    const title_text = get_field_display_name('accommodation_proposed_file') + ' - ' + grantee_name;
                    const download_el = $('<a/>', { 'class': 'btn btn-sm btn-primary eta-file-download lightbox', href: base_url + grantee_travel.accommodation_proposed_file, title: title_text }).html('<i class="fa fa-eye"></i>');
                    const remove_el = $('<button/>', { 'type': 'button', 'class': 'btn btn-sm btn-danger eta-file-remove', 'data-field': 'accommodation_proposed_file', 'data-grantee': grantee_id, title: 'Remove' }).html('<i class="fa fa-trash"></i>');
                    wrap_el.append(download_el).append(remove_el);
                    $('.lightbox').topbox();
                }
            }

            if (grantee_travel.accommodation_invoice_file) {
                const wrap_el = row_el.find('.eta-file-wrap').filter(function() {
                    return $(this).find('.eta-file-input').data('field') === 'accommodation_invoice_file';
                }).first();
                if (wrap_el.length) {
                    wrap_el.find('.eta-file-placeholder').remove();
                    wrap_el.find('.eta-file-download, .eta-file-remove').remove();
                    const grantee_name = row_el.find('td').eq(1).text();
                    const title_text = get_field_display_name('accommodation_invoice_file') + ' - ' + grantee_name;
                    const download_el = $('<a/>', { 'class': 'btn btn-sm btn-primary eta-file-download lightbox', href: base_url + grantee_travel.accommodation_invoice_file, title: title_text }).html('<i class="fa fa-eye"></i>');
                    const remove_el = $('<button/>', { 'type': 'button', 'class': 'btn btn-sm btn-danger eta-file-remove', 'data-field': 'accommodation_invoice_file', 'data-grantee': grantee_id, title: 'Remove' }).html('<i class="fa fa-trash"></i>');
                    wrap_el.append(download_el).append(remove_el);
                    $('.lightbox').topbox();
                }
            }

            if (grantee_travel.accommodation_proof_of_payment_file) {
                const wrap_el = row_el.find('.eta-file-wrap').filter(function() {
                    return $(this).find('.eta-file-input').data('field') === 'accommodation_proof_of_payment_file';
                }).first();
                if (wrap_el.length) {
                    wrap_el.find('.eta-file-placeholder').remove();
                    wrap_el.find('.eta-file-download, .eta-file-remove').remove();
                    const grantee_name = row_el.find('td').eq(1).text();
                    const title_text = get_field_display_name('accommodation_proof_of_payment_file') + ' - ' + grantee_name;
                    const download_el = $('<a/>', { 'class': 'btn btn-sm btn-primary eta-file-download lightbox', href: base_url + grantee_travel.accommodation_proof_of_payment_file, title: title_text }).html('<i class="fa fa-eye"></i>');
                    const remove_el = $('<button/>', { 'type': 'button', 'class': 'btn btn-sm btn-danger eta-file-remove', 'data-field': 'accommodation_proof_of_payment_file', 'data-grantee': grantee_id, title: 'Remove' }).html('<i class="fa fa-trash"></i>');
                    wrap_el.append(download_el).append(remove_el);
                    $('.lightbox').topbox();
                }
            }

            if (grantee_travel.voucher_accommodation) {
                const wrap_el = row_el.find('.eta-file-wrap').filter(function() {
                    return $(this).find('.eta-file-input').data('field') === 'voucher_accommodation';
                }).first();
                if (wrap_el.length) {
                    wrap_el.find('.eta-file-placeholder').remove();
                    wrap_el.find('.eta-file-download, .eta-file-remove').remove();
                    const grantee_name = row_el.find('td').eq(1).text();
                    const title_text = get_field_display_name('voucher_accommodation') + ' - ' + grantee_name;
                    const download_el = $('<a/>', { 'class': 'btn btn-sm btn-primary eta-file-download lightbox', href: base_url + grantee_travel.voucher_accommodation, title: title_text }).html('<i class="fa fa-eye"></i>');
                    const remove_el = $('<button/>', { 'type': 'button', 'class': 'btn btn-sm btn-danger eta-file-remove', 'data-field': 'voucher_accommodation', 'data-grantee': grantee_id, title: 'Remove' }).html('<i class="fa fa-trash"></i>');
                    wrap_el.append(download_el).append(remove_el);
                    $('.lightbox').topbox();
                }
            }

            const clear_fields = [
                'departure_date',
                'returning_date',
                'rate_in_usd',
                'final_rate',
                'note',
                'travel_agent_id',
                'ticket_file',
                'domestic_ticket_file',
                'invoice_file',
                'domestic_invoice_file',
                'proof_of_payment_file',
                'domestic_proof_of_payment_file',
                'accommodation_proposed_file',
                'accommodation_invoice_file',
                'accommodation_proof_of_payment_file',
                'voucher_accommodation'
            ];
            clear_fields.forEach(function(field) {
                const input_el = row_el.find('[data-field="' + field + '"]');
                if (input_el.length && !grantee_travel[field]) {
                    input_el.val('');
                }
            });

            Object.keys(grantee_travel).forEach(function(field) {
                const value = grantee_travel[field];
                if (!value) return;

                const input_el = row_el.find('[data-field="' + field + '"]');
                if (input_el.length) {
                    if (input_el.is('input[type="file"]')) {
                        return;
                    } else if (input_el.hasClass('datepicker')) {
                        const formatted = format_date_for_display(value);
                        input_el.val(formatted);
                    } else if (input_el.hasClass('eta-travel-agent')) {
                        input_el.val(value);
                    } else if (field === 'rate_in_usd' || field === 'final_rate') {
                        const currency = row_el.find('.approved-flight-label span').attr('data-flight-currency') || 'USD';
                        input_el.val(formatCurrencyValue(value, currency));
                        input_el.attr('data-rate-currency', currency);
                    }else if(field === 'note') {
                        const note = grantee_travel[field].replace(/<[^>]*>/g, '');
                        input_el.val(note);
                    } else {
                        input_el.val(value);
                    }
                }
            });

            // If final_rate is still empty, and there is an approved flight price, populate final_rate with the approved flight price
            const final_rate_input = row_el.find('input[data-field="final_rate"]');
            if (final_rate_input.length && (!final_rate_input.val() || final_rate_input.val() === '')) {
                const app_span = row_el.find('.approved-flight-label span');
                const flight_price = app_span.attr('data-flight-price');
                const flight_currency = app_span.attr('data-flight-currency') || 'USD';
                if (flight_price) {
                    final_rate_input.val(formatCurrencyValue(flight_price, flight_currency));
                    final_rate_input.attr('data-rate-currency', flight_currency);
                }
            }
        }

        function sort_section_rows_by_travel_id(section_el) {
            if (!section_el || !section_el.length) return;

            const tbody = section_el.find('tbody').first();
            if (!tbody.length) return;

            const rows = tbody.children('tr[data-grantee]').get();
            rows.sort(function(a, b) {
                const row_a = $(a);
                const row_b = $(b);
                const status_a = row_a.find('.eta-status-label').attr('data-status') || '';
                const status_b = row_b.find('.eta-status-label').attr('data-status') || '';
                const priority_a = status_sort_priority.hasOwnProperty(status_a) ? status_sort_priority[status_a] : 50;
                const priority_b = status_sort_priority.hasOwnProperty(status_b) ? status_sort_priority[status_b] : 50;
                if (priority_a !== priority_b) return priority_a - priority_b;

                const id_a = parseInt(row_a.attr('data-travel-arrangement-id') || '0', 10);
                const id_b = parseInt(row_b.attr('data-travel-arrangement-id') || '0', 10);

                if (id_a === id_b) {
                    const grantee_a = parseInt(row_a.attr('data-grantee') || '0', 10);
                    const grantee_b = parseInt(row_b.attr('data-grantee') || '0', 10);
                    return grantee_a - grantee_b;
                }

                return id_a - id_b;
            });

            $.each(rows, function(_, row) {
                tbody.append(row);
            });
        }

        function populate_section_travel_data(section_idx, db_id, tab, category_name) {
            const travel_data_json = $('#eta_travel_data');
            if (!travel_data_json.length) return;

            try {
                const travel_data = JSON.parse(travel_data_json.text()) || {};
                const section_travel_data = get_section_travel_payload();
                const section_el = $('.eta-section[data-section="' + section_idx + '"]');
                if (!section_el.length) return;

                section_el.find('tbody tr.eta-duplicate-row').remove();
                
                let syncData = [];

                section_el.find('tbody tr').not('.eta-duplicate-row').each(function() {
                    const row_el = $(this);
                    const grantee_id = row_el.data('grantee');
                    if (!grantee_id) return;

                    let records = [];
                    if (section_travel_data[db_id] && section_travel_data[db_id][grantee_id]) {
                        records = section_travel_data[db_id][grantee_id];
                    } else if (travel_data[grantee_id] && travel_data[grantee_id][db_id]) {
                        records = [travel_data[grantee_id][db_id]];
                    }

                    if (!Array.isArray(records)) {
                        records = records ? [records] : [];
                    }

                    apply_travel_record_to_row(row_el, grantee_id, records[0] || null, section_idx, db_id, category_name);

                    let record_id = records[0] && records[0].id ? records[0].id : 0;
                    if (record_id == 0) {
                        syncData.push({
                            grantee_id: grantee_id,
                            db_id: db_id,
                            section_idx: section_idx,
                            category_name: category_name
                        });
                    }
                    
                    if (records.length > 1) {
                        let insert_after = row_el;
                        records.slice(1).forEach(function(record, index) {
                            const new_row = create_duplicate_section_row(row_el, db_id, record && record.id ? record.id : 0, index + 1);
                            insert_after.after(new_row);
                            apply_travel_record_to_row(new_row, grantee_id, record, section_idx, db_id, category_name);
                            insert_after = new_row;
                        });
                    }
                });

                const action_wrap_am = section_el.find('.section-status-button-action');
                const btnSync = action_wrap_am.find('.btn-sync');

                if (syncData.length > 0) {
                    btnSync
                        .show()
                        .prop('disabled', false)
                        .data('sync-data', syncData);
                } else {
                    btnSync.hide().removeData('sync-data');
                }

                sort_section_rows_by_travel_id(section_el);
            } catch (e) {}
        }

        function format_date_for_display(date_str) {
            if (!date_str) return '';
            const date = new Date(date_str);
            if (isNaN(date)) return date_str;
            return new Intl.DateTimeFormat('en-US', { year: 'numeric', month: 'long', day: 'numeric' }).format(date);
        }

        const tba_na_html = '<span class="eta-tba-na" title="You don\'t have permission to view this information" style="cursor:help;"><span class="text-muted">N/A</span></span>';

        function apply_tba_view_only_file(wrap) {
            wrap.find('label').hide();
            wrap.find('.eta-file-input, .eta-file-remove, .eta-file-placeholder').hide();

            if (wrap.find('.eta-file-download').length) {
                wrap.find('.eta-file-download').show();
                return;
            }

            wrap.html(tba_na_html);
        }

        function apply_tba_restrictions(section_el) {
            if (typeof is_tba === 'undefined' || !is_tba) return;

            const tba_view_only_fields = ['invoice_file', 'domestic_invoice_file', 'proof_of_payment_file', 'domestic_proof_of_payment_file'];
            const accommodation_file = ['accommodation_invoice_file', 'accommodation_proof_of_payment_file'];

            section_el.find('tbody tr[data-grantee]').each(function() {
                const row_el = $(this);
                const status = row_el.find('.eta-status-label').attr('data-status');

                if (String(status) === String(<?= ETA_TRAVEL_STATUS_ISSUED ?>) || String(status) === String(<?= ETA_TRAVEL_STATUS_REFUNDED ?>)) {
                    row_el.find('[data-field="final_rate"]').prop('disabled', true);
                }

                if (String(status) === String(<?= ETA_TRAVEL_STATUS_CHANGE_FLIGHT ?>)) {
                    try {
                        row_el.find('textarea[data-field="note"], input[data-field="note"]').prop('disabled', true);
                        row_el.find('[data-field]').prop('disabled', true);
                        row_el.find('.eta-row-checkbox').prop('checked', false).prop('disabled', true);
                        row_el.find('.btn-proposed-flight, .btn-add-travel-agent, .eta-file-remove, .btn-delete-eta').prop('disabled', true).addClass('disabled');
                        row_el.find('.eta-file-wrap label').css({'pointer-events':'none','opacity':0.6});
                    } catch (e) {}
                    return;
                    }

                    row_el.find('.eta-row-checkbox').show();
                    row_el.find('.eta-select-all').show();

                row_el.find('input[data-field="departure_airport_us"], input[data-field="arrival_airport_indonesia"], input[data-field="domestic_departure_airport"], input[data-field="domestic_arrival_airport"]').prop('disabled', true);
                row_el.find('input[data-field="departure_date"], input[data-field="returning_date"]').prop('disabled', true);
                const excludedStatus = [
                                        '<?= ETA_TRAVEL_STATUS_REFUNDED ?>',
                                        '<?= ETA_TRAVEL_STATUS_ISSUED ?>',
                                        '<?= ETA_TRAVEL_STATUS_PROCEED_TO_ISSUED ?>',
                                        '<?= ETA_TRAVEL_STATUS_BOOK_TICKET ?>',
                                    ];

                if (!excludedStatus.includes(status)) {

                    const app_span = row_el.find('.approved-flight-label span');
                    let is_approved = false;
                    if (app_span.length) {
                        const fid = app_span.attr('data-flight-id');
                        const fdesc = app_span.attr('data-flight-description');
                        const fname = app_span.attr('data-flight-name');
                        const ftext = (app_span.text() || '').trim();
                        if ((fid && fid !== '0') || (fname && fname.trim() !== '') || (fdesc && fdesc.trim() !== '') || (ftext && ftext.toLowerCase() !== 'no selection' && ftext !== '')) {
                            is_approved = true;
                        }
                    }

                    const rate_td = row_el.find('input[data-field="rate_in_usd"]').closest('td');
                    rate_td.html(tba_na_html);
                    const file_fields = ['ticket_file', 'domestic_ticket_file'];
                    file_fields.forEach(function(field) {
                        const wrap = row_el.find('.eta-file-wrap').filter(function() {
                            return $(this).find('.eta-file-input').data('field') === field;
                        });
                        if (wrap.length) {
                            wrap.html(tba_na_html);
                        }
                    });
                } else if (status == '<?= ETA_TRAVEL_STATUS_ISSUED?>') {
                    row_el.find('input[data-field="rate_in_usd"]').prop('disabled', true);
                } else if (status == '<?= ETA_TRAVEL_STATUS_REFUNDED?>') {
                    row_el.find('.btn-add-mini').remove();
                }

                tba_view_only_fields.forEach(function(field) {
                    const wrap = row_el.find('.eta-file-wrap').filter(function() {
                        return $(this).find('.eta-file-input').data('field') === field;
                    });

                    if (wrap.length) {
                        apply_tba_view_only_file(wrap);
                    }
                });

                if (!status || status === '') {
                    row_el.remove();
                }

                accommodation_file.forEach(function(field) {
                    const wrap = row_el.find('.eta-file-wrap').filter(function() {
                        return $(this).find('.eta-file-input').data('field') === field;
                    });
                    if (!wrap.length) return;
                    
                    wrap.find('label').hide();
                    wrap.find('.eta-file-input').hide();
                    wrap.find('.eta-file-remove').hide();
                    if (!wrap.find('.eta-file-download').length) {
                        wrap.find('.eta-file-placeholder').remove();
                        wrap.append(tba_na_html);
                    }
                });
            });

            section_el.find('.eta-select-all').show();
            const action_wrap = section_el.find('.section-status-button-action');
            action_wrap.find('.btn-find-flights, .btn-find-other-flights, .btn-proceed-issue').hide();
            if (!action_wrap.find('.btn-refund').length) {
                action_wrap.prepend('<button type="button" class="btn btn-sm mr-1 btn-refund" style="background:#cd4f46;color:#fff;border-color:#F44336;display:inline-block;"><i class="fa fa-undo"></i> Refund</button>');
            } else {
                action_wrap.find('.btn-refund').show();
            }

            if (!action_wrap.find('.btn-send-ticket').length) {
                const is_accom = section_el.attr('data-tab') === 'accommodation';
                const btn_text = is_accom ? 'Send Voucher' : 'Send Ticket';
                action_wrap.prepend('<button type="button" class="btn btn-sm mr-1 btn-send-ticket" style="background:#0284c7;color:#fff;border-color:#0284c7;display:inline-block;"><i class="fa fa-envelope"></i> ' + btn_text + '</button>');
            } else {
                action_wrap.find('.btn-send-ticket').show();
            }

            if (!action_wrap.find('.btn-booked').length) {
                const is_accom = section_el.attr('data-tab') === 'accommodation';
                if(!is_accom){
                    action_wrap.prepend('<button type="button" class="btn btn-sm mr-1 btn-booked" style="background:#0284c7;color:#fff;border-color:#0284c7;"><i class="fa fa-check"></i> Booked</button>');
                }
            }

            if (!action_wrap.find('.btn-notify-program').length) {
                action_wrap.prepend('<button type="button" class="btn btn-sm mr-1 btn-notify-program" style="background:#0284c7;color:#fff;border-color:#0284c7;"><i class="fa fa-bell"></i> Notify Program</button>');
            }

            section_el.find('.eta-edit-category').prop('disabled', true);
            section_el.find('.eta-edit-flight-type').prop('disabled', true);
            section_el.find('.eta-section-memo-budget').prop('disabled', true);
            section_el.find('.eta-section-note').prop('readonly', true);
            section_el.find('.btn-remove-section').hide();
            section_el.find('select[data-field="accommodation_approval_status"]').prop('disabled', true);
        }

        
        function apply_aminef_staff_restrictions(section_el) {
            // return false;
            if (typeof is_aminef_staff === 'undefined' || !is_aminef_staff) return;

            section_el.find('.btn-proceed-issue').hide();
            section_el.find('.btn-proceed-book, .btn-issued-ticket').show();

            const action_wrap_am = section_el.find('.section-status-button-action');
            if (!action_wrap_am.find('.btn-change-flight').length) {
                action_wrap_am.find('.btn-generate-pdf').before(' <span style="color:#999;margin:0 4px;">|</span> <button type="button" class="btn btn-sm btn-danger btn-change-flight"><i class="fa fa-repeat"></i> Change Flight</button>');
            }

            const col_config = {
                '<?= ETA_TRAVEL_STATUS_NEW_REQUEST ?>': {
                    'grantee_name': 'read', 'status': 'read', 'passport_file': 'read',
                    'departure_airport_us': 'edit', 'arrival_airport_indonesia': 'edit',
                    'domestic_departure_airport': 'edit', 'domestic_arrival_airport': 'edit',
                    'departure_date': 'edit', 'returning_date': 'edit',
                    'proposed_flight': 'edit',
                    'rate_in_usd': 'read_or_zero', 'final_rate': 'read', 'travel_agent_id': 'read_or_na'
                },
                '<?= ETA_TRAVEL_STATUS_REVISION ?>': {
                    'grantee_name': 'read', 'status': 'read', 'passport_file': 'read',
                    'departure_airport_us': 'edit', 'arrival_airport_indonesia': 'edit',
                    'domestic_departure_airport': 'edit', 'domestic_arrival_airport': 'edit',
                    'departure_date': 'edit', 'returning_date': 'edit',
                    'proposed_flight': 'edit',
                    'rate_in_usd': 'read_or_zero', 'final_rate': 'read', 'travel_agent_id': 'read_or_na'
                },
                '<?= ETA_TRAVEL_STATUS_ISSUED?>': {
                    'grantee_name': 'read', 'status': 'read', 'passport_file': 'read',
                    'departure_airport_us': 'edit', 'arrival_airport_indonesia': 'edit',
                    'domestic_departure_airport': 'edit', 'domestic_arrival_airport': 'edit',
                    'departure_date': 'edit', 'returning_date': 'edit',
                    'proposed_flight': 'edit',
                    'approved_flights': 'read', 'rate_in_usd': 'read_or_zero', 'travel_agent_id': 'read_or_na',
                    'final_rate': 'read',
                    'ticket_file': 'view_file', 'domestic_ticket_file': 'view_file',
                    'invoice_file': 'view_file', 'domestic_invoice_file': 'view_file',
                    'proof_of_payment_file': 'view_file', 'domestic_proof_of_payment_file': 'view_file'
                },
                '<?= ETA_TRAVEL_STATUS_REFUNDED?>': {
                    'grantee_name': 'read', 'status': 'read', 'passport_file': 'read',
                    'departure_airport_us': 'edit', 'arrival_airport_indonesia': 'edit',
                    'domestic_departure_airport': 'edit', 'domestic_arrival_airport': 'edit',
                    'departure_date': 'edit', 'returning_date': 'edit',
                    'proposed_flight': 'edit',
                    'approved_flights': 'read', 'rate_in_usd': 'read_or_zero', 'travel_agent_id': 'read_or_na',
                    'final_rate': 'read',
                    'ticket_file': 'view_file', 'domestic_ticket_file': 'view_file',
                    'invoice_file': 'view_file', 'domestic_invoice_file': 'view_file',
                    'proof_of_payment_file': 'view_file', 'domestic_proof_of_payment_file': 'view_file'
                }
            };

            const all_input_fields = ['departure_airport_us', 'arrival_airport_indonesia', 'domestic_departure_airport', 'domestic_arrival_airport', 'departure_date', 'returning_date', 'rate_in_usd', 'final_rate'];
            const all_select_fields = ['travel_agent_id'];
            const all_file_fields = ['ticket_file', 'domestic_ticket_file', 'invoice_file', 'domestic_invoice_file', 'proof_of_payment_file', 'domestic_proof_of_payment_file'];
            const file_accommodation_proposed_file = ['accommodation_proposed_file', 'accommodation_invoice_file', 'accommodation_proof_of_payment_file', 'voucher_accommodation'];

            section_el.find('tbody tr[data-grantee]').each(function() {
                const row_el = $(this);
                const status = row_el.find('.eta-status-label').attr('data-status');

                if (String(status) === String(<?= ETA_TRAVEL_STATUS_CHANGE_FLIGHT ?>)) {
                    try {
                        row_el.find('[data-field]').prop('disabled', true);
                        row_el.find('textarea[data-field="note"]').prop('disabled', true);
                        row_el.find('.eta-row-checkbox').prop('disabled', true).prop('checked', false);
                        row_el.find('.btn-proposed-flight, .btn-add-travel-agent, .eta-file-remove, .btn-delete-eta').prop('disabled', true).addClass('disabled');
                        row_el.find('.eta-file-wrap label').css({'pointer-events':'none','opacity':0.6});
                    } catch (e) {}
                    return;
                }

                const allowed = col_config[status] || col_config['<?= ETA_TRAVEL_STATUS_NEW_REQUEST ?>'];

                all_input_fields.forEach(function(field) {
                    const el = row_el.find('[data-field="' + field + '"]');
                    if (!el.length) return;
                    if (!allowed[field]) {
                        el.closest('td').html(tba_na_html);
                    } else if (allowed[field] === 'read') {
                        el.prop('disabled', true);
                    } else if (allowed[field] === 'read_or_na') {
                        if (el.val()) {
                            el.prop('disabled', true);
                        } else {
                            el.closest('td').html(tba_na_html);
                        }
                    } else if (allowed[field] === 'read_or_zero') {
                        if (!el.val()) {
                            if (field === 'rate_in_usd') {
                                const currency = row_el.find('.approved-flight-label span').attr('data-flight-currency') || 'USD';
                                el.val(formatCurrencyValue('0', currency));
                                el.attr('data-rate-currency', currency);
                            } else {
                                el.val('0');
                            }
                        }
                        el.prop('disabled', true);
                    }
                });

                all_select_fields.forEach(function(field) {
                    const el = row_el.find('[data-field="' + field + '"]');
                    if (!el.length) return;
                    if (!allowed[field]) {
                        el.closest('td').html(tba_na_html);
                    } else if (allowed[field] === 'read') {
                        el.prop('disabled', true);
                    } else if (allowed[field] === 'read_or_na') {
                        const val = el.val();
                        if (val) {
                            el.prop('disabled', true);
                        } else {
                            el.closest('td').html(tba_na_html);
                        }
                    }
                });


                if (!allowed['proposed_flight']) {
                    row_el.find('.btn-proposed-flight').closest('td').html(tba_na_html);
                }

                all_file_fields.forEach(function(field) {
                    const wrap = row_el.find('.eta-file-wrap').filter(function() {
                        return $(this).find('.eta-file-input').data('field') === field;
                    });
                    if (!wrap.length) return;

                    // Ticket fields: if not allowed for this status, show N/A (as originally intended). If view_file, allow viewing via pill without add button.
                    if (field === 'ticket_file' || field === 'domestic_ticket_file') {
                        if (!allowed[field]) {
                            wrap.html(tba_na_html);
                        } else if (allowed[field] === 'view_file') {
                            wrap.find('.btn-add-mini').remove();
                            wrap.find('.eta-ticket-file-input').hide();
                        }
                        return;
                    }

                    if (!allowed[field]) {
                        wrap.html(tba_na_html);
                    } else if (allowed[field] === 'view_file') {
                        wrap.find('label').hide();
                        wrap.find('.eta-file-input').hide();
                        wrap.find('.eta-file-remove').hide();
                        if (!wrap.find('.eta-file-download').length) {
                            wrap.find('.eta-file-placeholder').remove();
                            wrap.append(tba_na_html);
                        }
                    }
                });

                file_accommodation_proposed_file.forEach(function(field) {
                    const wrap = row_el.find('.eta-file-wrap').filter(function() {
                        return $(this).find('.eta-file-input').data('field') === field;
                    });
                    if (!wrap.length) return;
                    
                    wrap.find('label').hide();
                    wrap.find('.eta-file-input').hide();
                    wrap.find('.eta-file-remove').hide();
                    if (!wrap.find('.eta-file-download').length) {
                        wrap.find('.eta-file-placeholder').remove();
                        wrap.append(tba_na_html);
                    }
                });
            });

            var category_travel = section_el.closest('.eta-sections-container').data('tab');


            if(category_travel !== 'accommodation'){
                section_el.find('.section-status-button-action').each(function() {
                    const action_wrap = $(this);
                    if (!action_wrap.find('.btn-generate-pdf').length) {
                        action_wrap.append('<button type="button" class="btn btn-sm btn-primary btn-generate-pdf">Download Approval</button>');
                    } else {
                        action_wrap.find('.btn-generate-pdf').show();
                    }
                });
            }
        }

        function load_saved_sections() {
            const sections_json = $('#eta_saved_sections');
            if (!sections_json.length) return;
            try {
                const sections = JSON.parse(sections_json.text());
                if (Array.isArray(sections)) {
                    sections.forEach(function (section) {
                        create_section(section.tab, section.category_name || '', section.flight_type, section.id, section.category_id, true, section.memo_budget_id || '', section.note || '', section.approved_by || '', section.approved_at || '');
                    });

                    setTimeout(function() {
                        ['international', 'domestic', 'accommodation'].forEach(function(tab) {
                            check_and_toggle_empty_alert(tab);
                        });
                        populate_travel_agent_options();
                    }, 100);
                }
            } catch (e) {}
        }

        function populate_travel_agent_options(section_idx = null) {
            const agents_json = $('#eta_travel_agents');
            if (!agents_json.length) return;
            try {
                const agents = JSON.parse(agents_json.text());
                if (Array.isArray(agents)) {
                    let select_els;
                    if (section_idx) {
                        select_els = $('.eta-section[data-section="' + section_idx + '"] .eta-travel-agent');
                    } else {
                        select_els = $('.eta-travel-agent');
                    }
                    select_els.each(function() {
                        const select_el = $(this);
                        const current_value = select_el.val();
                        select_el.empty().append('<option value="">-- Select Agent --</option>');
                        agents.forEach(function(agent) {
                            const selected = (current_value && current_value == agent.id) ? 'selected' : '';
                            select_el.append('<option value="' + agent.id + '" ' + selected + '>' + $('<span>').text(agent.name).html() + '</option>');
                        });
                    });
                }
            } catch (e) {}
        }

        let eta_trigger_travel_select = null;

        $(document).on('click', '.btn-add-travel-agent', function (event) {
            event.stopPropagation();
            eta_trigger_travel_select = $(this).closest('td,div').find('.eta-travel-agent');
            $('#travel_agent_name').val('');
            $('#travel_agent_email').val('');
            $('#modalAddTravelAgent').modal('show');
            setTimeout(function() { $('#travel_agent_name').focus(); }, 200);
        });

        $(document).on('click', '#btn_save_travel_agent', function () {
            const btn = $(this);
            const name = $('#travel_agent_name').val().trim();
            const email = $('#travel_agent_email').val().trim();
            if (!name) { $('#travel_agent_name').focus(); return; }
            btn.prop('disabled', true);

            $.post(base_url + 'admin/eta_travel_arrangement/add_travel_agent', { name: name, email: email }, function (response) {
                btn.prop('disabled', false);
                if (response && response.success) {
                    const agents_el = $('#eta_travel_agents');
                    let agents = [];
                    try { agents = JSON.parse(agents_el.text()); } catch (e) { agents = []; }
                    agents.push({ id: response.id, name: response.name });
                    agents_el.text(JSON.stringify(agents));
                    populate_travel_agent_options();
                    show_toast('Travel agent added');
                    $('#modalAddTravelAgent').modal('hide');
                    if (eta_trigger_travel_select && eta_trigger_travel_select.length) {
                        eta_trigger_travel_select.val(response.id).trigger('change');
                    }
                } else {
                    show_toast(response.message || 'Failed to add agent', 'error');
                }
            }, 'json').fail(function () {
                btn.prop('disabled', false);
                show_toast('Error adding agent', 'error');
            });
        });

        $(document).on('keypress', '#travel_agent_name, #travel_agent_email', function (event) {
            if (event.which === 13) {
                event.preventDefault();
                $('#btn_save_travel_agent').click();
            }
        });

        $(document).on('click', '.eta-section-header', function (event) {
            if ($(event.target).closest('.btn-remove-section').length) return;
            $(this).closest('.eta-section').toggleClass('collapsed');
        });

        $(document).on('click', '.btn-cat-add', function () {
            const tab = $(this).data('tab');
            $('#add_cat_tab').val(tab);
            $('#add_cat_name').val('');
            $('#modalAddCategory').modal('show');
        });

        $(document).on('click', '#btn_save_cat', function () {
            const tab = $('#add_cat_tab').val();
            const name = $('#add_cat_name').val();
            if (!name || !name.trim()) {
                $('#add_cat_name').focus();
                return;
            }

            $.ajax({
                url: base_url + 'admin/eta_travel_arrangement/add_category',
                method: 'POST',
                data: { name: name.trim(), type: tab },
                dataType: 'json',
                success: function (response) {
                    if (response && response.success) {
                        const safe_name = $('<span>').text(response.name).html();
                        const new_option_el = $('<option value="' + response.id + '">' + safe_name + '</option>');
                        if (tab === 'accommodation') {
                            $('.eta-section-category[data-tab="accommodation"]').append(new_option_el).val('');
                        } else {
                            $('.eta-section-category[data-tab="' + tab + '"]').append(new_option_el).val('');
                        }
                        $('#modalAddCategory').modal('hide');
                        show_toast('Category "' + response.name + '" added');
                    } else {
                        show_toast(response.message || 'Failed to add category', 'error');
                    }
                },
                error: function () {
                    show_toast('Error adding category', 'error');
                }
            });
        });

        $(document).on('keypress', '#add_cat_name', function (event) {
            if (event.which === 13) {
                event.preventDefault();
                $('#btn_save_cat').click();
            }
        });

        $(document).on('click', '.btn-add-section', function (event) {
            event.preventDefault();
            const tab = $(this).data('tab');
            const cat_select_el = $('.eta-section-category[data-tab="' + tab + '"]:first');
            const category_id = cat_select_el.val();
            const category_name = cat_select_el.find('option:selected').text().trim();
            const period_id = $('#eta_period').val();
            const program_id = $('#eta_program').val();

            let flight_type = '';
            if (tab !== 'accommodation') {
                const ft_select_el = $('.eta-section-flight-type[data-tab="' + tab + '"]:first');
                flight_type = ft_select_el.val();
                if (!category_id || !flight_type) {
                    show_toast('Please select Category and Flight Type first', 'error');
                    return;
                }
            } else {
                if (!category_id) {
                    show_toast('Please select Category first', 'error');
                    return;
                }
            }

            $.ajax({
                url: base_url + 'admin/eta_travel_arrangement/save_section',
                method: 'POST',
                data: {
                    program_id: program_id,
                    period_id: period_id,
                    tab: tab,
                    category_id: category_id,
                    flight_type: flight_type,
                },
                dataType: 'json',
                success: function (response) {
                    if (response && response.success) {
                        if (response.travel_data) {
                            const travel_data_el = $('#eta_travel_data');
                            if (travel_data_el.length) {
                                try {
                                    let travel_data = JSON.parse(travel_data_el.text());
                                    Object.keys(response.travel_data).forEach(function(grantee_id) {
                                        if (!travel_data[grantee_id]) {
                                            travel_data[grantee_id] = {};
                                        }
                                        Object.assign(travel_data[grantee_id], response.travel_data[grantee_id]);
                                    });
                                    travel_data_el.text(JSON.stringify(travel_data));
                                } catch(e) {
                                    console.error('Error merging travel data:', e);
                                }
                            }
                        }
                        create_section(tab, category_name, flight_type, response.id, category_id, false, '', '');
                        populate_travel_agent_options();
                        update_flight_counts();
                        show_toast('Section created');
                        cat_select_el.val('');
                        if (tab !== 'accommodation') {
                            const ft_select_el = $('.eta-section-flight-type[data-tab="' + tab + '"]:first');
                            ft_select_el.val('');
                        }
                    } else {
                        show_toast('Failed to create section', 'error');
                    }
                },
                error: function () {
                    show_toast('Error creating section', 'error');
                }
            });
        });

        $(document).on('click', '.btn-remove-section', function (event) {
            event.stopPropagation();
            const btn = $(this);
            swal_confirm('Remove this section?').then(function(confirmed) {
                if (!confirmed) return;
                const section_el = btn.closest('.eta-section');
                const db_id = section_el.data('db-id');
                const tab = section_el.closest('.eta-sections-container').data('tab');
                if (db_id) {
                    $.post(base_url + 'admin/eta_travel_arrangement/delete_section', { id: db_id }, function (response) {
                        if (response && response.success) {
                            show_toast('Section removed');
                        }
                    });
                }
                section_el.remove();

                setTimeout(function() {
                    check_and_toggle_empty_alert(tab);
                }, 100);
            });
        });

        $(document).on('click', '.btn-download-section', function (event) {
            event.stopPropagation();
            const section_el = $(this).closest('.eta-section');
            const db_id = section_el.data('db-id') || 0;
            if (!db_id) {
                show_toast('Section must be saved before downloading', 'error');
                return;
            }
            
            // Set the section ID
            $('#download_excel_section_id').val(db_id);
            
            // Check all checkboxes by default
            $('#modalDownloadExcelETA .excel-field-checkbox').prop('checked', true);
            $('#excel_select_all').prop('checked', true);
            
            // Open modal
            $('#modalDownloadExcelETA').modal('show');
        });

        // Toggle all checkboxes
        $(document).on('change', '#excel_select_all', function () {
            $('#modalDownloadExcelETA .excel-field-checkbox').prop('checked', this.checked);
        });

        // Uncheck "Select All" if one checkbox is unchecked, check it if all are checked
        $(document).on('change', '#modalDownloadExcelETA .excel-field-checkbox', function () {
            if (!this.checked) {
                $('#excel_select_all').prop('checked', false);
            } else {
                const total = $('#modalDownloadExcelETA .excel-field-checkbox').length;
                const checked = $('#modalDownloadExcelETA .excel-field-checkbox:checked').length;
                if (total === checked) {
                    $('#excel_select_all').prop('checked', true);
                }
            }
        });

        // Submit form
        $(document).on('click', '#btn-submit-download-excel', function (event) {
            event.preventDefault();
            const checked_count = $('#modalDownloadExcelETA .excel-field-checkbox:checked').length;
            if (checked_count === 0) {
                alert('Please select at least one field to download.');
                return;
            }
            
            const form = $('#formDownloadExcelETA');
            const db_id = $('#download_excel_section_id').val();
            
            form.attr('action', base_url + 'admin/eta_travel_arrangement/download_excel?section_id=' + db_id);
            form.submit();
            
            $('#modalDownloadExcelETA').modal('hide');
        });

        $(document).on('click', '.btn-set-approval-section', function (event) {
            event.stopPropagation();
            const section_el = $(this).closest('.eta-section');
            const db_id = section_el.data('db-id') || 0;
            if (!db_id) {
                show_toast('Section must be saved before setting approval', 'error');
                return;
            }

            $('#set_approval_section_id').val(db_id);

            const staff_select = $('#set_approval_approved_by').empty().append('<option value="">- Select Staff -</option>');
            const staffs_json = $('#eta_staffs');
            try {
                const staffs = JSON.parse(staffs_json.text());
                if (Array.isArray(staffs)) {
                    staffs.forEach(function(staff) {
                        const selected = (staff.id && String(staff.id) === String(eta_current_user_id)) ? 'selected' : '';
                        staff_select.append('<option value="' + staff.id + '" ' + selected + '>' + $('<span>').text(staff.full_name || '').html() + '</option>');
                    });
                }
            } catch(e) {}

            const dt_input = $('#set_approval_approved_at');
            const now_str = format_datetime_for_db(new Date());
            let approval_picker = dt_input.data('eta-approval-picker');
            if (typeof flatpickr !== 'undefined') {
                if (approval_picker) {
                    approval_picker.setDate(now_str, true);
                } else {
                    approval_picker = flatpickr(dt_input[0], { enableTime: true, time_24hr: true, dateFormat: 'Y-m-d H:i:S', defaultDate: now_str });
                    dt_input.data('eta-approval-picker', approval_picker);
                }
            } else {
                dt_input.val(now_str);
            }

            $('#modalSetApprovalETA').data('section-el', section_el).modal('show');
        });

        $(document).on('click', '#btn-submit-set-approval', function () {
            const btn = $(this);
            const section_id = $('#set_approval_section_id').val() || 0;
            const approved_by = $('#set_approval_approved_by').val() || '';

            let approved_at = '';
            const dt_input = $('#set_approval_approved_at');
            const approval_picker = dt_input.data('eta-approval-picker');
            if (approval_picker && approval_picker.input) {
                approved_at = approval_picker.input.value;
            } else {
                approved_at = dt_input.val();
            }

            if (!section_id) { show_toast('Section ID missing', 'error'); return; }
            if (!approved_by) { show_toast('Please select approver', 'error'); return; }
            if (!approved_at) { show_toast('Please select approval date', 'error'); return; }

            btn.prop('disabled', true);

            $.post(base_url + 'admin/eta_travel_arrangement/set_section_approval', {
                section_id: section_id,
                approved_by: approved_by,
                approved_at: approved_at
            }, function (response) {
                btn.prop('disabled', false);
                if (response && response.success) {
                    const section_el = $('#modalSetApprovalETA').data('section-el');
                    if (section_el && section_el.length) {
                        section_el.attr('data-approved-by', approved_by).attr('data-approved-at', approved_at);
                        refresh_set_approval_button(section_el);
                    }
                    $('#modalSetApprovalETA').modal('hide');
                    show_toast('Section approval saved');
                } else {
                    show_toast((response && response.message) || 'Failed to save approval', 'error');
                }
            }, 'json').fail(function () {
                btn.prop('disabled', false);
                show_toast('Failed to save approval', 'error');
            });
        });

        $(document).on('change', '.eta-edit-category', function () {
            const section_el = $(this).closest('.eta-section');
            const db_id = section_el.data('db-id');
            const category_id = $(this).val();
            const option_el = $(this).find('option:selected');
            const category_name = option_el.text();

            if (!db_id || !category_id) return;

            $.post(base_url + 'admin/eta_travel_arrangement/update_section', {
                id: db_id,
                category_id: category_id
            }, function (response) {
                if (response && response.success) {
                    section_el.attr('data-category', category_name).attr('data-category-id', category_id);
                    const flight_type = section_el.attr('data-flight-type');
                    const header_label = flight_type ? category_name + ' - ' + flight_type : category_name;
                    section_el.find('.eta-section-header h5').html('<i class="fa fa-chevron-down eta-collapse-icon"></i>' + $('<span>').text(header_label).html());
                    show_toast('Category updated');
                } else {
                    show_toast('Failed to update category', 'error');
                }
            }).fail(function () {
                show_toast('Failed to update category', 'error');
            });
        });

        $(document).on('change', '.eta-edit-flight-type', function () {
            const section_el = $(this).closest('.eta-section');
            const db_id = section_el.data('db-id');
            const flight_type = $(this).val();

            if (!db_id || !flight_type) return;

            $.post(base_url + 'admin/eta_travel_arrangement/update_section', {
                id: db_id,
                flight_type: flight_type
            }, function (response) {
                if (response && response.success) {
                    section_el.attr('data-flight-type', flight_type);
                    const category_name = section_el.attr('data-category');
                    const header_label = category_name + ' - ' + flight_type;
                    section_el.find('.eta-section-header h5').html('<i class="fa fa-chevron-down eta-collapse-icon"></i>' + $('<span>').text(header_label).html());
                    show_toast('Flight type updated');
                } else {
                    show_toast('Failed to update flight type', 'error');
                }
            }).fail(function () {
                show_toast('Failed to update flight type', 'error');
            });
        });

        $(document).on('change', '.eta-section-memo-budget', function () {
            const section_el = $(this).closest('.eta-section');
            const db_id = section_el.data('db-id');
            const memo_budget_id = $(this).val();

            if (!db_id) return;

            $.post(base_url + 'admin/eta_travel_arrangement/update_section', {
                id: db_id,
                memo_budget_id: memo_budget_id
            }, function (response) {
                if (response && response.success) {
                    show_toast('Memo budget updated');
                } else {
                    show_toast('Failed to update memo budget', 'error');
                }
            }).fail(function () {
                show_toast('Failed to update memo budget', 'error');
            });
        });

        let note_timer = null;
        $(document).on('input', '.eta-section-note', function () {
            const textarea_el = $(this);
            const section_el = textarea_el.closest('.eta-section');
            const db_id = section_el.data('db-id');
            const note_val = textarea_el.val();

            if (!db_id) return;

            clearTimeout(note_timer);
            note_timer = setTimeout(function () {
                $.post(base_url + 'admin/eta_travel_arrangement/update_section', {
                    id: db_id,
                    note: note_val
                }, function (response) {
                    if (response && response.success) {
                        show_toast('Note saved');
                    } else {
                        show_toast('Failed to save note', 'error');
                    }
                }).fail(function () {
                    show_toast('Failed to save note', 'error');
                });
            }, 500);
        });

        const eta_status_map = {
            <?= ETA_TRAVEL_STATUS_NEW_REQUEST ?>: 'New Request',
            <?= ETA_TRAVEL_STATUS_REVISION ?>: 'Revision',
            <?= ETA_TRAVEL_STATUS_ISSUED ?>: 'Ticket Sent',
            <?= ETA_TRAVEL_STATUS_REFUNDED ?>: 'Ticket Refunded',
            <?= ETA_TRAVEL_STATUS_GRANTEE_NOTIFIED ?>: 'Grantee Notified',
            <?= ETA_TRAVEL_STATUS_PENDING_REVIEW ?>: 'Pending Review',
            <?= ETA_TRAVEL_STATUS_BOOKED ?>: 'Booked',
            <?= ETA_TRAVEL_STATUS_BOOK_TICKET ?>: 'Proceed To Book',
            <?= ETA_TRAVEL_STATUS_CHANGE_FLIGHT ?>: 'Change Flight',
            <?= ETA_TRAVEL_STATUS_PROCEED_TO_ISSUED ?>: 'Proceed to Issue'
        };

        const status_sort_priority = {
            '<?= ETA_TRAVEL_STATUS_NEW_REQUEST ?>': 0,
            '<?= ETA_TRAVEL_STATUS_PENDING_REVIEW ?>': 1,
            '<?= ETA_TRAVEL_STATUS_GRANTEE_NOTIFIED ?>': 2,
            '<?= ETA_TRAVEL_STATUS_REVISION ?>': 3,
            '<?= ETA_TRAVEL_STATUS_BOOK_TICKET ?>': 4,
            '<?= ETA_TRAVEL_STATUS_BOOKED ?>': 5,
            '<?= ETA_TRAVEL_STATUS_PROCEED_TO_ISSUED ?>': 6,
            '<?= ETA_TRAVEL_STATUS_ISSUED ?>': 7,
            '': 8,
            '<?= ETA_TRAVEL_STATUS_REFUNDED ?>': 99,
            '<?= ETA_TRAVEL_STATUS_CHANGE_FLIGHT ?>': 99,
        };

        function get_status_filter_options_html(include_blank) {
            var html = '<option value="">All Status</option>';
            if (include_blank) {
                html += '<option value="blank">Blank</option>';
            }
            html += '<option value="<?= ETA_TRAVEL_STATUS_NEW_REQUEST ?>">New Request</option>';
            html += '<option value="<?= ETA_TRAVEL_STATUS_PENDING_REVIEW ?>">Pending Review</option>';
            html += '<option value="<?= ETA_TRAVEL_STATUS_GRANTEE_NOTIFIED ?>">Grantee Notified</option>';
            html += '<option value="<?= ETA_TRAVEL_STATUS_REVISION ?>">Revision</option>';
            html += '<option value="<?= ETA_TRAVEL_STATUS_BOOK_TICKET ?>">Proceed To Book</option>';
            html += '<option value="<?= ETA_TRAVEL_STATUS_BOOKED ?>">Booked</option>';
            html += '<option value="<?= ETA_TRAVEL_STATUS_PROCEED_TO_ISSUED ?>">Proceed to Issue</option>';
            html += '<option value="<?= ETA_TRAVEL_STATUS_ISSUED ?>">Ticket Sent</option>';
            html += '<option value="<?= ETA_TRAVEL_STATUS_REFUNDED ?>">Ticket Refunded</option>';
            html += '<option value="<?= ETA_TRAVEL_STATUS_CHANGE_FLIGHT ?>">Change Flight</option>';
            return html;
        }

        function set_status_for_checked(section_el, status_value, ids_override) {
            let checked_els;
            if (Array.isArray(ids_override)) {
                checked_els = $();
                ids_override.forEach(function(id) {
                    const cb = section_el.find('.eta-row-checkbox').filter(function() { return $(this).data('grantee') == id; }).first();
                    if (cb.length) checked_els = checked_els.add(cb);
                });
                if (checked_els.length === 0) {
                    show_toast('Please select at least one grantee', 'error');
                    return;
                }
            } else {
                checked_els = section_el.find('.eta-row-checkbox:checked:visible');
                if (checked_els.length === 0) {
                    show_toast('Please select at least one grantee', 'error');
                    return;
                }
            }

            const section_db_id = section_el.closest('.eta-section').data('db-id') || 0;

            const ids = [];
            checked_els.each(function() {
                const grantee_grant_id = $(this).data('grantee');
                const travel_id = $(this).data('travel-id');
                if (travel_id) {
                    ids.push({ grantee_grant_id: grantee_grant_id, travel_arrangement_id: travel_id });
                } else {                    
                    ids.push({ grantee_grant_id: grantee_grant_id });
                }
            });

            $.post(base_url + 'admin/eta_travel_arrangement/make_action_status', {
                section_id: section_db_id,
                ids: JSON.stringify(ids),
                status: status_value
            }, function (response) {
                if (response && response.success) {
                    let status_text = eta_status_map[status_value] || status_value;
                    checked_els.each(function () {
                        const row_el = $(this).closest('tr');
                        const is_accom = row_el.closest('.eta-sections-container').attr('data-tab') === 'accommodation';
                        const label_el = row_el.find('.eta-status-label');
                
                        if(status_text === 'Ticket Sent' && is_accom){
                            status_text = 'Voucher Sent' || '';
                        }  
                        label_el.text(status_text).attr('data-status', status_value).removeClass('text-muted');
                        $(this).prop('checked', false);
                    });
                    section_el.closest('.eta-section').find('.section-status-button-action').find('button:not(.btn-sync)').prop('disabled', true);
                    if (is_approved_eta_status(status_value)) {
                        section_el.closest('.eta-section')
                            .attr('data-approved-by', typeof eta_current_user_id !== 'undefined' ? eta_current_user_id : '')
                            .attr('data-approved-at', format_datetime_for_db(new Date()));
                    }
                    refresh_set_approval_button(section_el.closest('.eta-section'));
                    try { sort_section_rows_by_travel_id(section_el.closest('.eta-section')); } catch (e) {}
                    show_toast('Status updated to ' + status_text);
                } else {
                    show_toast(response.message || 'Failed to update status', 'error');
                }
            }, 'json').fail(function () {
                show_toast('Failed to update status', 'error');
            });
        }

        $(document).on('click', '.btn-find-flights', function () {
            const btn = $(this);
            const is_accom = btn.closest('.eta-sections-container').attr('data-tab') === 'accommodation';
            const msg = is_accom ? 'Set selected grantees to Find Accommodation?' : 'Set selected grantees to New Request?';
            swal_confirm(msg).then(function(confirmed) {
                if (!confirmed) return;
                set_status_for_checked(btn.closest('.eta-section'), <?= ETA_TRAVEL_STATUS_NEW_REQUEST ?>);
            });
        });

        $(document).on('click', '.btn-find-other-flights', function () {
            const btn = $(this);
            const is_accom = btn.closest('.eta-sections-container').attr('data-tab') === 'accommodation';
            const msg = is_accom ? 'Set selected grantees to Revision (Find Other Accommodation)?' : 'Set selected grantees to Revision (Find Other Flight Options)?';
            swal_confirm(msg).then(function(confirmed) {
                if (!confirmed) return;
                set_status_for_checked(btn.closest('.eta-section'), <?= ETA_TRAVEL_STATUS_REVISION ?>);
            });
        });

        $(document).on('click', '.btn-proceed-issue', function () {
            const btn = $(this);
            const section_el = btn.closest('.eta-section');
            const checked_els = section_el.find('.eta-row-checkbox:checked:visible');
            const eligible_ids = [];

            checked_els.each(function() {
                const row_el = $(this).closest('tr');
                const app_span = row_el.find('.approved-flight-label span');
                let is_approved = false;
                if (app_span.length) {
                    const fid = app_span.attr('data-flight-id');
                    const fdesc = app_span.attr('data-flight-description');
                    const fname = app_span.attr('data-flight-name');
                    const ftext = (app_span.text() || '').trim();
                    if ((fid && fid !== '0') || (fname && fname.trim() !== '') || (fdesc && fdesc.trim() !== '') || (ftext && ftext.toLowerCase() !== 'no selection' && ftext !== '')) {
                        is_approved = true;
                    }
                }
                if (is_approved) {
                    eligible_ids.push($(this).data('grantee'));
                }
            });

            if (eligible_ids.length === 0) {
                show_toast('No selected grantees have an approved flight', 'error');
                return;
            }

            const msg = 'Only selected grantees with an approved flight will be processed. Continue?';
            swal_confirm(msg).then(function(confirmed) {
                if (!confirmed) return;
                set_status_for_checked(section_el, <?= ETA_TRAVEL_STATUS_ISSUED?>, eligible_ids);
            });
        });

        $(document).on('click', '.btn-notify-program', function () {
            const btn = $(this);
            swal_confirm('Notify program for selected grantees?').then(function(confirmed) {
                if (!confirmed) return;
                set_status_for_checked(btn.closest('.eta-section'), <?= ETA_TRAVEL_STATUS_PENDING_REVIEW ?>);
            });
        });

        $(document).on('click', '.btn-book-ticket', function () {
            const btn = $(this);
            swal_confirm('Mark selected grantees as Booked?').then(function(confirmed) {
                if (!confirmed) return;
                set_status_for_checked(btn.closest('.eta-section'), <?= ETA_TRAVEL_STATUS_BOOKED ?>);
            });
        });

        $(document).on('click', '.btn-booked', function () {
            const btn = $(this);
            swal_confirm('Mark selected grantees as Booked?').then(function(confirmed) {
                if (!confirmed) return;
                set_status_for_checked(btn.closest('.eta-section'), <?= ETA_TRAVEL_STATUS_BOOKED ?>);
            });
        });

        $(document).on('click', '.btn-notify-grantee', function () {
            const btn = $(this);
            const msg = 'Set selected grantees to Grantee Notified?';
            swal_confirm(msg).then(function(confirmed) {
                if (!confirmed) return;
                set_status_for_checked(btn.closest('.eta-section'), <?= ETA_TRAVEL_STATUS_GRANTEE_NOTIFIED ?>);
            });
        });

        $(document).on('click', '.btn-proceed-book', function () {
            const btn = $(this);
            const is_accom = btn.closest('.eta-sections-container').attr('data-tab') === 'accommodation';
            const msg = is_accom ? 'Set selected grantees to Proceed to Book Accommodation?' : 'Set selected grantees to Proceed To Book?';
            swal_confirm(msg).then(function(confirmed) {
                if (!confirmed) return;
                set_status_for_checked(btn.closest('.eta-section'), <?= ETA_TRAVEL_STATUS_BOOK_TICKET ?>);
            });
        });

        $(document).on('click', '.btn-issued-ticket', function () {
            const btn = $(this);
            swal_confirm('Mark selected grantees as Proceed to Issue?').then(function(confirmed) {
                if (!confirmed) return;
                set_status_for_checked(btn.closest('.eta-section'), <?= ETA_TRAVEL_STATUS_PROCEED_TO_ISSUED ?>);
            });
        });

        $(document).on('click', '.btn-refund', function () {
            const btn = $(this);
            const is_accom = btn.closest('.eta-sections-container').attr('data-tab') === 'accommodation';
            const msg = is_accom ? 'Refund voucher and mark selected grantees as Voucher Sent?' : 'Refund ticket and mark selected grantees as Ticket Refunded?';
            swal_confirm(msg).then(function(confirmed) {
                if (!confirmed) return;
                set_status_for_checked(btn.closest('.eta-section'), <?= ETA_TRAVEL_STATUS_REFUNDED ?>);
            });
        });

        $(document).on('click', '.btn-send-ticket', function () {
            const btn = $(this);
            const is_accom = btn.closest('.eta-sections-container').attr('data-tab') === 'accommodation';
            const msg = is_accom ? 'Send voucher and mark selected grantees as Voucher Sent?' : 'Send ticket and mark selected grantees as Ticket Sent?';
            swal_confirm(msg).then(function(confirmed) {
                if (!confirmed) return;
                set_status_for_checked(btn.closest('.eta-section'), <?= ETA_TRAVEL_STATUS_ISSUED ?>);
            });
        });

        $(document).on('click', '.btn-generate-pdf', function (e) {
            e.preventDefault();
            const btn = $(this);
            const section_el = btn.closest('.eta-section');
            const section_db_id = section_el.data('db-id') || 0;
            if (!section_db_id) {
                show_toast('Section must be saved before generating PDF', 'error');
                return;
            }
            const table_el = section_el.find('table').first();
            const ids = table_el.find('.eta-row-checkbox:checked:visible').map(function() { return $(this).data('travel-id'); }).get().filter(function(v){ return v && v !== 0; });
            if (!ids || ids.length === 0) {
                show_toast('Please select at least one grantee', 'error');
                return;
            }
            const url = base_url + 'admin/eta_travel_arrangement/generate_pdf?section_id=' + section_db_id + '&ids=' + encodeURIComponent(ids.join(','));
            window.open(url, '_blank');
        });

        $(document).on('click', '.btn-change-flight', function (e) {
            e.preventDefault();
            if (typeof is_aminef_staff === 'undefined' || !is_aminef_staff) {
                return; // silently ignore clicks from non-aminef-staff
            }
            const btn = $(this);
            const section_el = btn.closest('.eta-section');
            const section_db_id = section_el.data('db-id') || 0;
            if (!section_db_id) {
                show_toast('Section must be saved before initiating Change Flight', 'error');
                return;
            }
            const checked_els = section_el.find('.eta-row-checkbox:checked:visible');
            if (checked_els.length === 0) {
                show_toast('Please select at least one grantee', 'error');
                return;
            }
            
            let allIssued = true;
            const ids = [];
            checked_els.each(function() {
                const st = $(this).closest('tr').find('.eta-status-label').attr('data-status') || '';
                if (String(st) !== String(<?= ETA_TRAVEL_STATUS_ISSUED?>)) { allIssued = false; return false; }
                ids.push($(this).data('grantee'));
            });
            if (!allIssued) {
                show_toast('Only Ticket Sent rows can be changed', 'error');
                return;
            }

            $('#change_flight_section_id').val(section_db_id);
            $('#modalChangeFlight').data('ids', ids).modal('show');
        });

        const save_url = base_url + 'admin/eta_travel_arrangement/save_field';
        const delete_url = base_url + 'admin/eta_travel_arrangement/delete_by_grantee';
        const delete_file_url = base_url + 'admin/eta_travel_arrangement/delete_file';

        $(document).on('click', '#btn_submit_change_flight', function () {
            const btn = $(this);
            const note = $('#change_flight_note').val() || '';
            const section_id = $('#change_flight_section_id').val() || 0;
            const ids = $('#modalChangeFlight').data('ids') || [];
            if (!ids || ids.length === 0) {
                show_toast('No grantees selected', 'error');
                return;
            }
            btn.prop('disabled', true);
            $.post(base_url + 'admin/eta_travel_arrangement/change_flight', {
                section_id: section_id,
                ids: JSON.stringify(ids),
                note: note
            }, function (resp) {
                btn.prop('disabled', false);
                if (resp && resp.success) {
                    const created = resp.created || {};
                    ids.forEach(function (gid) {
                        try {
                            const section_wrap = $('.eta-section[data-db-id="' + section_id + '"]').first();
                            const oldRow = section_wrap.length ? section_wrap.find('tr[data-grantee="' + gid + '"]').first() : $('tr[data-grantee="' + gid + '"]').first();
                            if (oldRow.length) {
                                    const label_el = oldRow.find('.eta-status-label');
                                    label_el.text(eta_status_map[<?= ETA_TRAVEL_STATUS_CHANGE_FLIGHT ?>] || 'Change Flight').attr('data-status', <?= ETA_TRAVEL_STATUS_CHANGE_FLIGHT ?>).removeClass('text-muted');
                                        oldRow.find('.eta-row-checkbox').prop('checked', false);

                                            try {
                                        const noteInput = oldRow.find('textarea[data-field="note"], input[data-field="note"]');
                                        if (noteInput.length) {
                                            noteInput.val(note).prop('disabled', true);
                                        }
                                    } catch (e) {}

                                    try {
                                        oldRow.find('[data-field]').prop('disabled', true);
                                        oldRow.find('.eta-row-checkbox').prop('disabled', true);
                                        oldRow.find('.btn-proposed-flight, .btn-add-travel-agent, .eta-file-remove, .btn-delete-eta').prop('disabled', true).addClass('disabled');
                                        oldRow.find('.eta-file-wrap label').css({'pointer-events':'none','opacity':0.6});
                                    } catch (e) {}

                                    try {
                                        const td = $('#eta_travel_data');
                                        if (td.length) {
                                            let travel_data = JSON.parse(td.text() || '{}');
                                            if (!travel_data[gid]) travel_data[gid] = {};
                                            travel_data[gid][section_id] = travel_data[gid][section_id] || {};
                                            const existing_travel_id = oldRow.attr('data-travel-arrangement-id') || oldRow.find('.btn-proposed-flight').data('travel-id') || null;
                                            if (existing_travel_id) travel_data[gid][section_id].id = existing_travel_id;
                                            travel_data[gid][section_id].status = <?= ETA_TRAVEL_STATUS_CHANGE_FLIGHT ?>;
                                            travel_data[gid][section_id].note = note;
                                            td.text(JSON.stringify(travel_data));
                                        }
                                    } catch (e) {}

                                const newRow = oldRow.clone(false);
                                newRow.find('.eta-row-checkbox').prop('checked', false);

                                const createdRow = created[gid] || null;
                                const newId = createdRow ? createdRow.id : 0;

                                newRow.find('.btn-proposed-flight').attr('data-travel-id', newId).data('travel-id', newId);
                                try {
                                    const _icon = (typeof is_tba !== 'undefined' && is_tba) ? 'fa-plus' : 'fa-list';
                                    newRow.find('.btn-proposed-flight').html('<i class="fa ' + _icon + '"></i> Propose Flight');
                                } catch (e) {}
                                if (newId) newRow.attr('data-travel-arrangement-id', newId);
                                newRow.find('.approved-flight-label span').text('No selection').removeAttr('data-flight-id data-flight-description data-flight-name data-flight-price data-travel-id').attr('data-travel-id', newId);

                                try {
                                    const oldDep = oldRow.find('input[data-field="departure_date"]').val() || '';
                                    const oldRet = oldRow.find('input[data-field="returning_date"]').val() || '';
                                    newRow.find('input[data-field="departure_date"]').val(oldDep);
                                    newRow.find('input[data-field="returning_date"]').val(oldRet);
                                } catch (e) {}

                                newRow.find('input[data-field="rate_in_usd"], input[data-field="final_rate"]').val('').removeAttr('data-rate-currency');
                                newRow.find('select[data-field="travel_agent_id"]').val('');

                                newRow.find('.eta-file-wrap').each(function () {
                                    const wrap = $(this);
                                    wrap.find('.eta-file-download, .eta-file-remove').remove();
                                    if (!wrap.find('.eta-file-placeholder').length) {
                                        wrap.append('<span class="eta-file-placeholder text-muted small">No file</span>');
                                    }
                                    const input = wrap.find('.eta-file-input');
                                    input.val('');
                                    const field = input.data('field');
                                    const new_input_id = 'eta_file_new_' + newId + '_' + field;
                                    input.attr('id', new_input_id);
                                    const label = wrap.find('label');
                                    if (label.length) label.attr('for', new_input_id);
                                });

                                try {
                                    newRow.find('[data-field]').prop('disabled', false);
                                    newRow.find('textarea[data-field="note"], input[data-field="note"]').val('');
                                    newRow.find('.eta-row-checkbox').prop('disabled', false).prop('checked', false);
                                    newRow.find('.btn-proposed-flight, .btn-add-travel-agent, .eta-file-remove, .btn-delete-eta').prop('disabled', false).removeClass('disabled');
                                    newRow.find('.eta-file-input').prop('disabled', false);
                                    newRow.find('.eta-file-wrap label').css({'pointer-events':'auto','opacity':''});
                                } catch (e) {}

                                const newStatusVal = (createdRow && createdRow.status) ? createdRow.status : <?= ETA_TRAVEL_STATUS_NEW_REQUEST ?>;
                                newRow.find('.eta-status-label').text(eta_status_map[newStatusVal] || 'New Request').attr('data-status', newStatusVal).removeClass('text-muted');

                                const tbody = oldRow.closest('tbody');
                                tbody.append(newRow);
                                sort_section_rows_by_travel_id(section_wrap);
                                init_eta_datepickers();
                                populate_travel_agent_options();

                                try {
                                    const td = $('#eta_travel_data');
                                    if (td.length) {
                                        let travel_data = JSON.parse(td.text());
                                        if (!travel_data[gid]) travel_data[gid] = {};
                                        travel_data[gid][section_id] = createdRow || {};
                                        td.text(JSON.stringify(travel_data));
                                    }
                                } catch (e) {}
                            }
                        } catch (e) { console.error(e); }
                    });

                    $('#modalChangeFlight').modal('hide');
                    $('#change_flight_note').val('');
                    show_toast('Change Flight created and set to New Request');
                    $('.section-status-button-action').find('button:not(.btn-sync)').prop('disabled', true);
                } else {
                    show_toast(resp.message || 'Failed to process change flight', 'error');
                }
            }, 'json').fail(function () {
                btn.prop('disabled', false);
                show_toast('Failed to process request', 'error');
            });
        });

        function show_toast(msg, type = 'success') {
            if (window.Swal && Swal.fire) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500,
                    icon: type === 'error' ? 'error' : 'success',
                    title: msg,
                    showClass: { popup: '' },
                    hideClass: { popup: '' }
                });
                return;
            }
            console.log((type || 'info') + ': ' + msg);
        }

        function swal_confirm(message, opts = {}) {
            if (window.Swal && Swal.fire) {
                const cfg = {
                    title: opts.title || 'Confirm',
                    text: message,
                    icon: opts.icon || 'warning',
                    showCancelButton: true,
                    confirmButtonText: opts.confirmButtonText || 'Yes',
                    cancelButtonText: opts.cancelButtonText || 'Cancel'
                };
                return Swal.fire(cfg).then(function(result) { return !!(result && result.isConfirmed); });
            }
            return Promise.resolve(confirm(message));
        }

        function save_field(grantee_id, field, value, file, trigger_el) {
            let eta_travel_arrangement_section_id = 0;
            let section_el = null;
            let am_travel_arrangement_id = 0;
            if (trigger_el && trigger_el.length) {
                section_el = trigger_el.closest('.eta-section');
                if (section_el.length) {
                    eta_travel_arrangement_section_id = section_el.data('db-id') || 0;
                }
                const row_el = trigger_el.closest('tr');
                if (row_el.length) {
                    am_travel_arrangement_id = row_el.data('travel-arrangement-id') || 0;
                }
            }
            
            if (file) {
                const form_data = new FormData();
                form_data.append('grantee_grant_id', grantee_id);
                form_data.append('field', field);
                form_data.append('file', file);
                form_data.append('eta_travel_arrangement_section_id', eta_travel_arrangement_section_id);
                form_data.append('am_travel_arrangement_id', am_travel_arrangement_id);

                let label_el;
                if (trigger_el && trigger_el.length) {
                    label_el = trigger_el.closest('.eta-file-wrap').find('label');
                } else {
                    const file_wrap = $('tr[data-grantee="' + grantee_id + '"] .eta-file-wrap').filter(function() {
                        return $(this).find('.eta-file-input').data('field') === field;
                    }).first();
                    label_el = file_wrap.find('label');
                }
                
                if (label_el && label_el.length) {
                    label_el.data('original-text', label_el.html());
                    label_el.addClass('eta-file-label-loading');
                    label_el.html('<i class="fa fa-circle-notch fa-spin"></i> Uploading ...');
                }

                $.ajax({
                    url: save_url,
                    method: 'POST',
                    data: form_data,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (label_el && label_el.length) {
                            label_el.removeClass('eta-file-label-loading');
                            label_el.html(label_el.data('original-text') || 'Choose File');
                        }
                        
                        show_toast('Saved file ' + field);
                        if (response && response.success && response.data && response.data[field]) {
                            const path = response.data[field];
                            let wrap_el;
                            if (trigger_el && trigger_el.length) {
                                wrap_el = trigger_el.closest('.eta-file-wrap');
                            } else if (section_el && section_el.length) {
                                wrap_el = section_el.find('tr[data-grantee="' + grantee_id + '"] .eta-file-wrap').filter(function () {
                                    return $(this).find('.eta-file-input').data('field') === field;
                                }).first();
                            } else {
                                wrap_el = $('tr[data-grantee="' + grantee_id + '"] .eta-file-wrap').filter(function () {
                                    return $(this).find('.eta-file-input').data('field') === field;
                                }).first();
                            }
                            
                            if (wrap_el.length) {
                                wrap_el.find('.eta-file-placeholder').remove();
                                wrap_el.find('.eta-file-download, .eta-file-remove').remove();
                                const row_el = wrap_el.closest('tr');
                                const grantee_name = row_el.find('td').eq(1).text();
                                const title_text = get_field_display_name(field) + ' - ' + grantee_name;
                                const download_el = $('<a/>', { 'class': 'btn btn-sm btn-primary eta-file-download lightbox', href: base_url + path, title: title_text }).html('<i class="fa fa-eye"></i>');
                                const remove_el = $('<button/>', { 'type': 'button', 'class': 'btn btn-sm btn-danger eta-file-remove', 'data-field': field, 'data-grantee': grantee_id, title: 'Remove' }).html('<i class="fa fa-trash"></i>');
                                wrap_el.append(download_el).append(remove_el);
                                $('.lightbox').topbox();
                                
                                const tba_view_only = ['invoice_file', 'domestic_invoice_file', 'proof_of_payment_file', 'domestic_proof_of_payment_file'];
                                if (typeof is_tba !== 'undefined' && is_tba && tba_view_only.indexOf(field) !== -1) {
                                    apply_tba_view_only_file(wrap_el);
                                }
                            }
                            
                            if (response.complete_record) {
                                const travel_data_el = $('#eta_travel_data');
                                if (travel_data_el.length) {
                                    try {
                                        let travel_data = JSON.parse(travel_data_el.text());
                                        if (!travel_data[grantee_id]) {
                                            travel_data[grantee_id] = {};
                                        }
                                        if (eta_travel_arrangement_section_id > 0) {
                                            travel_data[grantee_id][eta_travel_arrangement_section_id] = response.complete_record;
                                        } else {
                                            if (!travel_data[grantee_id][0]) {
                                                travel_data[grantee_id][0] = {};
                                            }
                                            Object.assign(travel_data[grantee_id][0], response.complete_record);
                                        }
                                        travel_data_el.text(JSON.stringify(travel_data));
                                    } catch(e) {
                                        console.error('Error updating travel data JSON:', e);
                                    }
                                }
                            }
                        }
                    },
                    error: function () {
                        if (label_el && label_el.length) {
                            label_el.removeClass('eta-file-label-loading');
                            label_el.html(label_el.data('original-text') || 'Choose File');
                        }
                        
                        show_toast('Failed to save file ' + field, 'error');
                    }
                });
            } else {
                $.post(save_url, { grantee_grant_id: grantee_id, field: field, value: value, eta_travel_arrangement_section_id: eta_travel_arrangement_section_id, am_travel_arrangement_id: am_travel_arrangement_id }, function (response) {
                    show_toast('Saved ' + field);

                    if (response && response.success) {
                        try {
                            const row_el = (trigger_el && trigger_el.length) ? trigger_el.closest('tr') : $('tr[data-grantee="' + grantee_id + '"]').first();
                            const currency = (row_el.find('.approved-flight-label span').attr('data-flight-currency') || (trigger_el && trigger_el.attr('data-rate-currency')) || 'USD');

                            if (field === 'rate_in_usd' || field === 'final_rate') {
                                let rawVal = null;
                                if (response.complete_record && response.complete_record[field] !== undefined) {
                                    rawVal = response.complete_record[field];
                                } else if (response.data && response.data[field] !== undefined) {
                                    rawVal = response.data[field];
                                } else {
                                    rawVal = value;
                                }

                                const input_el = (trigger_el && trigger_el.length) ? trigger_el : row_el.find('input[data-field="' + field + '"]');
                                if (input_el && input_el.length) {
                                    input_el.val(formatCurrencyValue(rawVal, currency));
                                    input_el.attr('data-rate-currency', currency);
                                }
                            }
                        } catch (e) {
                            console.error('Formatting error:', e);
                        }

                        const travel_data_el = $('#eta_travel_data');
                        if (travel_data_el.length) {
                            try {
                                let travel_data = JSON.parse(travel_data_el.text());
                                if (!travel_data[grantee_id]) {
                                    travel_data[grantee_id] = {};
                                }

                                if (response && response.complete_record) {
                                    if (eta_travel_arrangement_section_id > 0) {
                                        travel_data[grantee_id][eta_travel_arrangement_section_id] = response.complete_record;
                                    } else {
                                        if (!travel_data[grantee_id][0]) {
                                            travel_data[grantee_id][0] = {};
                                        }
                                        Object.assign(travel_data[grantee_id][0], response.complete_record);
                                    }
                                } else if (response && response.data) {
                                    if (eta_travel_arrangement_section_id > 0) {
                                        travel_data[grantee_id][eta_travel_arrangement_section_id] = travel_data[grantee_id][eta_travel_arrangement_section_id] || {};
                                        Object.assign(travel_data[grantee_id][eta_travel_arrangement_section_id], response.data);
                                    } else {
                                        travel_data[grantee_id][0] = travel_data[grantee_id][0] || {};
                                        Object.assign(travel_data[grantee_id][0], response.data);
                                    }
                                }

                                travel_data_el.text(JSON.stringify(travel_data));
                            } catch(e) {
                                console.error('Error updating travel data JSON:', e);
                            }
                        }
                    }
                }).fail(function () {
                    show_toast('Failed to save ' + field, 'error');
                });
            }
        }

        $(document).on('change', '.eta-autosave', function () {
            const el = $(this);
            const grantee_id = el.data('grantee');
            const field = el.data('field');
            let val = el.is(':checkbox') ? (el.is(':checked') ? 1 : 0) : el.val();

            if (field === 'rate_in_usd' || field === 'final_rate') {
                const row_el = el.closest('tr');
                const currency = (row_el.find('.approved-flight-label span').attr('data-flight-currency') || el.attr('data-rate-currency') || 'USD');
                val = unformat_price(val, currency);
            }

            if (el.hasClass('datepicker') && val) {
                const date_obj = parse_date(val);
                if (date_obj) {
                    val = format_date_to_yyyy_mm_dd(date_obj);
                }
            }

            if (field === 'returning_date') {
                const section_el = el.closest('.eta-section');
                if (section_el.length) {
                    section_el.find('tr[data-grantee]').each(function() {
                        const return_date_inputs = $(this).find('input[data-field="returning_date"]');
                        if (return_date_inputs.length) {
                            return_date_inputs.val(el.val());
                        }
                    });
                }
            }

            save_field(grantee_id, field, val, null, el);
        });

        function parse_date(date_str) {
            if (!date_str) return null;
            
            if (/^\d{4}-\d{2}-\d{2}$/.test(date_str)) {
                return new Date(date_str + 'T00:00:00Z');
            }
            
            const month_names = ['January', 'February', 'March', 'April', 'May', 'June',
                              'July', 'August', 'September', 'October', 'November', 'December'];
            for (let i = 0; i < month_names.length; i++) {
                const regex = new RegExp('^' + month_names[i] + ' (\\d{1,2}) (\\d{4})$');
                const match = date_str.match(regex);
                if (match) {
                    return new Date(match[2], i, parseInt(match[1]));
                }
            }
            
            const parts = date_str.split(' ');
            if (parts.length === 3) {
                const month_names_3 = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                const month_idx = month_names_3.indexOf(parts[0]);
                if (month_idx !== -1) {
                    const day = parseInt(parts[1]);
                    let year = parseInt(parts[2]);
                    if (year < 100) {
                        year += year < 50 ? 2000 : 1900;
                    }
                    return new Date(year, month_idx, day);
                }
            }
            
            const date = new Date(date_str);
            return isNaN(date.getTime()) ? null : date;
        }

        function format_date_to_yyyy_mm_dd(date_obj) {
            const year = date_obj.getFullYear();
            const month = String(date_obj.getMonth() + 1).padStart(2, '0');
            const day = String(date_obj.getDate()).padStart(2, '0');
            return year + '-' + month + '-' + day;
        }

        function getQueryParam(name) {
            try {
                const params = new URLSearchParams(window.location.search);
                return params.get(name);
            } catch (e) {
                return null;
            }
        }

        $(document).on('change', '.eta-file-input:not(.eta-ticket-file-input)', function () {
            const el = $(this);
            const grantee_id = el.data('grantee');
            const field = el.data('field');
            const file = this.files[0];
            if (!file) return;
            save_field(grantee_id, field, null, file, el);
        });

        $(document).on('click', '.eta-file-remove', function (event) {
            event.preventDefault();
            const btn_el = $(this);
            const field = btn_el.data('field');
            const grantee_id = btn_el.data('grantee');
            const section_el = btn_el.closest('.eta-section');
            const section_id = section_el.length ? section_el.data('db-id') || 0 : 0;

            swal_confirm('Remove this uploaded file?').then(function(confirmed) {
                if (!confirmed) return;
                $.post(delete_file_url, { grantee_grant_id: grantee_id, field: field }, function (response) {
                    if (response && response.success) {
                        show_toast('File removed');

                        let wrap_el;
                        if (btn_el && btn_el.length) {
                            wrap_el = btn_el.closest('.eta-file-wrap');
                        } else if (section_el && section_el.length) {
                            wrap_el = section_el.find('tr[data-grantee="' + grantee_id + '"] .eta-file-wrap').filter(function () {
                                return $(this).find('.eta-file-input').data('field') === field;
                            }).first();
                        } else {
                            wrap_el = $('tr[data-grantee="' + grantee_id + '"] .eta-file-wrap').filter(function () {
                                return $(this).find('.eta-file-input').data('field') === field;
                            }).first();
                        }

                        if (wrap_el.length) {
                            wrap_el.find('.eta-file-download, .eta-file-remove').remove();
                            wrap_el.find('.eta-file-placeholder').remove();
                            wrap_el.find('.eta-file-input').val('');

                            if (field === 'passport_file') {
                                const row_el = wrap_el.closest('tr');
                                const profile_passport = row_el.data('profile-passport');
                                if (profile_passport) {
                                    const grantee_name = row_el.find('td').eq(1).text();
                                    const title_text = 'Passport - ' + grantee_name;
                                    const download_el = $('<a/>', { 'class': 'btn btn-sm btn-primary eta-file-download lightbox', href: base_url + profile_passport, title: title_text }).html('<i class="fa fa-eye"></i>');
                                    wrap_el.append(download_el);
                                    $('.lightbox').topbox();
                                } else {
                                    wrap_el.append('<span class="eta-file-placeholder text-muted small">No file</span>');
                                }
                            } else {
                                wrap_el.append('<span class="eta-file-placeholder text-muted small">No file</span>');
                            }

                            const tba_view_only = ['invoice_file', 'domestic_invoice_file', 'proof_of_payment_file', 'domestic_proof_of_payment_file'];
                            if (typeof is_tba !== 'undefined' && is_tba && tba_view_only.indexOf(field) !== -1) {
                                apply_tba_view_only_file(wrap_el);
                            }

                            const travel_data_el = $('#eta_travel_data');
                            if (travel_data_el.length) {
                                try {
                                    let travel_data = JSON.parse(travel_data_el.text());
                                    if (travel_data[grantee_id]) {
                                        if (section_id > 0 && travel_data[grantee_id][section_id]) {
                                            travel_data[grantee_id][section_id][field] = null;
                                        } else if (section_id === 0 && travel_data[grantee_id][0]) {
                                            travel_data[grantee_id][0][field] = null;
                                        }
                                        travel_data_el.text(JSON.stringify(travel_data));
                                    }
                                } catch(e) {
                                    console.error('Error updating travel data JSON:', e);
                                }
                            }
                        }
                    } else {
                        show_toast('Failed to remove file', 'error');
                    }
                }).fail(function () { show_toast('Failed to remove file', 'error'); });
            });
        });

        /* =============================================
           TICKET MULTI-UPLOAD HANDLERS
           ============================================= */

        // Helper: refresh pill count and floating menu from wrap_el.data('tickets')
        function refresh_ticket_ui(wrap_el) {
            const tickets = wrap_el.data('tickets') || [];
            const pill_el = wrap_el.find('.btn-ticket-pill');
            const count_label = pill_el.find('.ticket-count-label');
            if (tickets.length > 0) {
                count_label.text(tickets.length + ' Ticket' + (tickets.length > 1 ? 's' : ''));
                pill_el.addClass('has-tickets');
            } else {
                count_label.text('0 Tickets');
                pill_el.removeClass('has-tickets');
            }
            // If floating menu is visible for this wrap, re-render list
            const menu = $('#ticketFloatingMenu');
            if (menu.is(':visible') && menu.data('wrap-el') && menu.data('wrap-el').is(wrap_el)) {
                render_ticket_menu_list(wrap_el);
            }
        }

        // Helper: render list items inside #ticketMenuList
        function render_ticket_menu_list(wrap_el) {
            const tickets = wrap_el.data('tickets') || [];
            const menu_list = $('#ticketMenuList');
            const field = wrap_el.find('.eta-ticket-file-input').data('field');
            const grantee_id = wrap_el.find('.btn-ticket-pill').data('grantee');
            menu_list.empty();
            if (tickets.length === 0) {
                menu_list.html('<div class="text-muted text-center" style="padding:16px 12px; font-size:12px; font-style:italic;">No tickets uploaded</div>');
                return;
            }
            $.each(tickets, function(i, file_path) {
                const file_name = file_path.split('/').pop();
                const row = $('<div class="ticket-item-row"></div>');
                const info = $('<div class="ticket-item-info"></div>');
                
                const ext = file_name.split('.').pop().toLowerCase();
                let icon_class = 'fa fa-file-text-o text-secondary';
                if (ext === 'pdf') {
                    icon_class = 'fa fa-file-pdf-o text-danger';
                } else if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                    icon_class = 'fa fa-file-image-o text-success';
                }
                const file_icon = $('<i class="ticket-item-icon"></i>').addClass(icon_class);

                const name_link = $('<a class="ticket-item-name lightbox" target="_blank"></a>')
                    .attr('href', base_url + file_path)
                    .attr('title', file_name)
                    .text(file_name);

                const actions = $('<div class="ticket-item-actions"></div>');
                const view_btn = $('<a class="btn-ticket-view lightbox" target="_blank" title="View ticket"><i class="fa fa-eye"></i></a>')
                    .attr('href', base_url + file_path);
                actions.append(view_btn);

                if (typeof is_tba !== 'undefined' && is_tba) {
                    const del_btn = $('<button type="button" class="btn-ticket-delete" title="Delete this ticket"><i class="fa fa-trash"></i></button>')
                        .data('file-path', file_path)
                        .data('field', field)
                        .data('grantee', grantee_id)
                        .data('wrap-el', wrap_el);
                    actions.append(del_btn);
                }

                info.append(file_icon).append(name_link);
                row.append(info).append(actions);
                menu_list.append(row);
            });
            $('.lightbox').topbox();
        }

        // btn-add-mini: trigger the hidden file input
        $(document).on('click', '.btn-add-mini', function(e) {
            e.stopPropagation();
            $(this).closest('.eta-ticket-wrap').find('.eta-ticket-file-input').trigger('click');
        });

        // eta-ticket-file-input: upload each selected file one by one
        $(document).on('change', '.eta-ticket-file-input', function() {
            const input_el = $(this);
            const field = input_el.data('field');
            const grantee_id = input_el.data('grantee');
            const files = this.files;
            if (!files || files.length === 0) return;

            const wrap_el = input_el.closest('.eta-ticket-wrap');
            const section_el = wrap_el.closest('.eta-section');
            const row_el = wrap_el.closest('tr');
            const eta_travel_arrangement_section_id = section_el.length ? (section_el.data('db-id') || 0) : 0;
            const am_travel_arrangement_id = row_el.length ? (row_el.data('travel-arrangement-id') || 0) : 0;

            const pill_el = wrap_el.find('.btn-ticket-pill');
            const count_label = pill_el.find('.ticket-count-label');
            count_label.html('<i class="fa fa-circle-notch fa-spin"></i>');

            let files_arr = Array.from(files);
            let upload_index = 0;

            function upload_next() {
                if (upload_index >= files_arr.length) {
                    input_el.val('');
                    refresh_ticket_ui(wrap_el);
                    return;
                }
                const file = files_arr[upload_index];
                upload_index++;

                const form_data = new FormData();
                form_data.append('grantee_grant_id', grantee_id);
                form_data.append('field', field);
                form_data.append('file', file);
                form_data.append('eta_travel_arrangement_section_id', eta_travel_arrangement_section_id);
                form_data.append('am_travel_arrangement_id', am_travel_arrangement_id);

                $.ajax({
                    url: save_url,
                    method: 'POST',
                    data: form_data,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        const new_tickets = response && (response.tickets !== undefined ? response.tickets : (response.data && response.data.tickets !== undefined ? response.data.tickets : null));
                        if (response && response.success && new_tickets) {
                            wrap_el.data('tickets', new_tickets);
                            refresh_ticket_ui(wrap_el);

                            const travel_data_el = $('#eta_travel_data');
                            if (travel_data_el.length) {
                                try {
                                    let travel_data = JSON.parse(travel_data_el.text());
                                    if (!travel_data[grantee_id]) travel_data[grantee_id] = {};
                                    if (eta_travel_arrangement_section_id > 0) {
                                        if (!travel_data[grantee_id][eta_travel_arrangement_section_id]) travel_data[grantee_id][eta_travel_arrangement_section_id] = {};
                                        travel_data[grantee_id][eta_travel_arrangement_section_id][field] = JSON.stringify(new_tickets);
                                    } else {
                                        if (!travel_data[grantee_id][0]) travel_data[grantee_id][0] = {};
                                        travel_data[grantee_id][0][field] = JSON.stringify(new_tickets);
                                    }
                                    travel_data_el.text(JSON.stringify(travel_data));
                                } catch(e) {}
                            }
                        }
                        show_toast('Uploaded: ' + file.name);
                        upload_next();
                    },
                    error: function() {
                        show_toast('Failed to upload: ' + file.name, 'error');
                        upload_next();
                    }
                });
            }
            upload_next();
        });

        // btn-ticket-pill: show/hide floating menu
        $(document).on('click', '.btn-ticket-pill', function(e) {
            e.stopPropagation();
            const pill_el = $(this);
            const wrap_el = pill_el.closest('.eta-ticket-wrap');
            const menu = $('#ticketFloatingMenu');

            // If already open for this pill, close it
            if (menu.is(':visible') && menu.data('wrap-el') && menu.data('wrap-el').is(wrap_el)) {
                menu.hide().removeData('wrap-el');
                return;
            }

            menu.data('wrap-el', wrap_el);
            render_ticket_menu_list(wrap_el);

            // Temporarily display off-screen to measure actual rendered dimensions
            menu.css({
                display: 'block',
                visibility: 'hidden',
                position: 'fixed',
                top: '-9999px',
                left: '-9999px'
            });

            const rect = pill_el[0].getBoundingClientRect();
            const menu_w = menu.outerWidth() || 320;
            const menu_h = menu.outerHeight() || 160;
            const win_w = $(window).width();
            const win_h = $(window).height();

            let top = rect.bottom + 4;
            let left = rect.left;

            // If overflows bottom of viewport, position above the pill button
            if (top + menu_h > win_h - 10) {
                const top_above = rect.top - menu_h - 4;
                if (top_above >= 10) {
                    top = top_above;
                } else {
                    top = Math.max(10, win_h - menu_h - 10);
                }
            }

            // If overflows right edge of viewport, shift left
            if (left + menu_w > win_w - 10) {
                left = Math.max(10, win_w - menu_w - 10);
            }

            menu.css({
                top: Math.round(top) + 'px',
                left: Math.round(left) + 'px',
                visibility: 'visible'
            });
        });

        // Close floating menu on scroll or resize
        $(window).on('scroll.ticketMenu resize.ticketMenu', function() {
            const menu = $('#ticketFloatingMenu');
            if (menu.is(':visible')) {
                menu.hide().removeData('wrap-el');
            }
        });
        $(document).on('scroll', '.eta-tables-wrapper, .table-responsive, .tab-pane', function(e) {
            const menu = $('#ticketFloatingMenu');
            if (menu.is(':visible') && !$(e.target).closest('#ticketFloatingMenu').length) {
                menu.hide().removeData('wrap-el');
            }
        });

        // Close floating menu on close button click
        $(document).on('click', '#btnCloseTicketMenu', function(e) {
            e.stopPropagation();
            $('#ticketFloatingMenu').hide().removeData('wrap-el');
        });

        // Close floating menu on outside click
        $(document).on('click', function(e) {
            const menu = $('#ticketFloatingMenu');
            if (menu.is(':visible') && !$(e.target).closest('#ticketFloatingMenu, .btn-ticket-pill, .swal2-container').length) {
                menu.hide().removeData('wrap-el');
            }
        });

        // Delete individual ticket from floating menu
        $(document).on('click', '.btn-ticket-delete', function(e) {
            e.stopPropagation();
            const btn = $(this);
            const file_path = btn.data('file-path');
            const field = btn.data('field');
            const grantee_id = btn.data('grantee');
            const wrap_el = btn.data('wrap-el');
            const section_el = wrap_el.closest('.eta-section');
            const row_el = wrap_el.closest('tr');
            const eta_travel_arrangement_section_id = section_el.length ? (section_el.data('db-id') || 0) : 0;
            const am_travel_arrangement_id = row_el.length ? (row_el.data('travel-arrangement-id') || 0) : 0;

            swal_confirm('Remove this ticket file?').then(function(confirmed) {
                if (!confirmed) return;
                $.post(delete_file_url, {
                    grantee_grant_id: grantee_id,
                    field: field,
                    file_path: file_path,
                    eta_travel_arrangement_section_id: eta_travel_arrangement_section_id,
                    am_travel_arrangement_id: am_travel_arrangement_id
                }, function(response) {
                    if (response && response.success) {
                        const updated_tickets = (response.tickets !== undefined)
                            ? response.tickets
                            : ((response.data && response.data.tickets !== undefined) ? response.data.tickets : []);
                        wrap_el.data('tickets', updated_tickets);
                        refresh_ticket_ui(wrap_el);

                        const travel_data_el = $('#eta_travel_data');
                        if (travel_data_el.length) {
                            try {
                                let travel_data = JSON.parse(travel_data_el.text());
                                if (travel_data[grantee_id]) {
                                    const val_to_store = updated_tickets.length > 0 ? JSON.stringify(updated_tickets) : null;
                                    if (eta_travel_arrangement_section_id > 0 && travel_data[grantee_id][eta_travel_arrangement_section_id]) {
                                        travel_data[grantee_id][eta_travel_arrangement_section_id][field] = val_to_store;
                                    } else if (travel_data[grantee_id][0]) {
                                        travel_data[grantee_id][0][field] = val_to_store;
                                    }
                                    travel_data_el.text(JSON.stringify(travel_data));
                                }
                            } catch(e) {}
                        }

                        show_toast('Ticket removed');
                    } else {
                        show_toast('Failed to remove ticket', 'error');
                    }
                }).fail(function() { show_toast('Failed to remove ticket', 'error'); });
            });
        });

        $(document).on('click', '.btn-delete-eta', function () {
            const btn = $(this);
            swal_confirm('Delete saved travel arrangement for this grantee?').then(function(confirmed) {
                if (!confirmed) return;
                const id = btn.data('id');
                $.post(delete_url, { grantee_grant_id: id }, function (response) {
                    if (response && response.success) {
                        show_toast('Deleted');
                        const target_row = $('tr[data-grantee="' + id + '"]');
                        target_row.find('input[type=text], select').val('');
                        target_row.find('.eta-row-checkbox').prop('checked', false);
                        target_row.find('.eta-status-label').text('').attr('data-status', '').addClass('text-muted');
                        target_row.find('a').remove();
                        target_row.find('.eta-ticket-wrap').data('tickets', []);
                        target_row.find('.btn-ticket-pill').removeClass('has-tickets').find('.ticket-count-label').text('0 files');
                    } else {
                        show_toast('Delete failed', 'error');
                    }
                }).fail(function () { show_toast('Delete failed', 'error'); });
            });
        });

        $(document).on('change', '.eta-select-all', function () {
            const is_checked = $(this).is(':checked');
            const table_el = $(this).closest('table');
            table_el.find('.eta-row-checkbox:not(:disabled):visible').prop('checked', is_checked);

            const section_body_el = $(this).closest('.eta-section-body');
            updateSelectedCount(section_body_el);
            
            const section_body = table_el.closest('.eta-section-body');
            const action_section = section_body.find('.section-status-button-action');
            
            (function() {
                const checked_rows = table_el.find('.eta-row-checkbox:checked:visible').closest('tr');
                const any_checked = checked_rows.length > 0;

                if (any_checked) {
                    let allBlank = true;
                    let allPendingReview = true;
                    checked_rows.each(function() {
                        const st = $(this).find('.eta-status-label').attr('data-status') || '';
                        if (st !== '') { allBlank = false; }
                        if (String(st) !== String(<?= ETA_TRAVEL_STATUS_PENDING_REVIEW ?>)) { allPendingReview = false; }
                    });
                    action_section.find('.btn-find-flights').prop('disabled', !allBlank);
                    action_section.find('.btn-find-other-flights').prop('disabled', allBlank);
                    action_section.find('.btn-proceed-issue').prop('disabled', !allPendingReview);
                } else {
                    action_section.find('.btn-find-flights').prop('disabled', true);
                    action_section.find('.btn-find-other-flights, .btn-proceed-issue').prop('disabled', true);
                }
            })();
            (function() {
                const gen_btn = action_section.find('.btn-generate-pdf');
                if (typeof is_aminef_staff === 'undefined' || !is_aminef_staff) {
                    gen_btn.hide();
                    return;
                }
                const checked_rows = table_el.find('.eta-row-checkbox:checked:visible').closest('tr');
                if (checked_rows.length === 0) {
                    gen_btn.prop('disabled', true);
                    return;
                }
                let allApproved = true;
                checked_rows.each(function() {
                    const st = $(this).find('.eta-status-label').attr('data-status') || '';
                    if (String(st) !== String(<?= ETA_TRAVEL_STATUS_ISSUED?>)) { allApproved = false; return false; }
                });
                gen_btn.prop('disabled', !allApproved);
            })();
            (function() {
                const change_btn = action_section.find('.btn-change-flight');
                const checked_rows = table_el.find('.eta-row-checkbox:checked:visible').closest('tr');
                if (checked_rows.length === 0) { change_btn.prop('disabled', true); return; }
                let allIssued = true;
                checked_rows.each(function() {
                    const st = $(this).find('.eta-status-label').attr('data-status') || '';
                    if (String(st) !== String(<?= ETA_TRAVEL_STATUS_ISSUED?>)) { allIssued = false; return false; }
                });
                change_btn.prop('disabled', !allIssued);
            })();
            (function() {
                const notify_grantee = action_section.find('.btn-notify-grantee');
                if (typeof is_aminef_staff === 'undefined' || !is_aminef_staff) {
                    notify_grantee.hide();
                    return;
                }
                const checked_rows = table_el.find('.eta-row-checkbox:checked:visible').closest('tr');
                if (checked_rows.length === 0) {
                    notify_grantee.prop('disabled', true);
                    return;
                }
                let all_pending_review = true;
                checked_rows.each(function() {
                    const st = $(this).find('.eta-status-label').attr('data-status') || '';
                    if (String(st) !== String(<?= ETA_TRAVEL_STATUS_PENDING_REVIEW ?>) &&
                        String(st) !== String(<?= ETA_TRAVEL_STATUS_GRANTEE_NOTIFIED ?>)) { all_pending_review = false; }
                });
                notify_grantee.prop('disabled', !all_pending_review);
            })();
            (function() {
                const proceed_book_btn = action_section.find('.btn-proceed-book');
                if (typeof is_aminef_staff === 'undefined' || !is_aminef_staff) {
                    proceed_book_btn.hide();
                    return;
                }
                const checked_rows = table_el.find('.eta-row-checkbox:checked:visible').closest('tr');
                if (checked_rows.length === 0) {
                    proceed_book_btn.prop('disabled', true);
                    return;
                }
                let all_pending_review = true;
                checked_rows.each(function() {
                    const st = $(this).find('.eta-status-label').attr('data-status') || '';
                    if (String(st) !== String(<?= ETA_TRAVEL_STATUS_PENDING_REVIEW ?>)) { all_pending_review = false; return false; }
                });
                proceed_book_btn.prop('disabled', !all_pending_review);
            })();
            (function() {
                const booked_btn = action_section.find('.btn-booked');
                if (typeof is_tba === 'undefined' || !is_tba) {
                    booked_btn.hide();
                    return;
                }
                const checked_rows = table_el.find('.eta-row-checkbox:checked:visible').closest('tr');
                if (checked_rows.length === 0) {
                    booked_btn.prop('disabled', true);
                    return;
                }
                let all_book_ticket = true;
                checked_rows.each(function() {
                    const st = $(this).find('.eta-status-label').attr('data-status') || '';
                    if (String(st) !== String(<?= ETA_TRAVEL_STATUS_BOOK_TICKET ?>)) { all_book_ticket = false; return false; }
                });
                booked_btn.prop('disabled', !all_book_ticket);
            })();
            (function() {
                const issued_ticket_btn = action_section.find('.btn-issued-ticket');
                if (typeof is_aminef_staff === 'undefined' || !is_aminef_staff) {
                    issued_ticket_btn.hide();
                    return;
                }
                const checked_rows = table_el.find('.eta-row-checkbox:checked:visible').closest('tr');
                if (checked_rows.length === 0) {
                    issued_ticket_btn.prop('disabled', true);
                    return;
                }
                let allPendingReview = true;
                checked_rows.each(function() {
                    const st = $(this).find('.eta-status-label').attr('data-status') || '';
                    if (String(st) !== String(<?= ETA_TRAVEL_STATUS_PENDING_REVIEW ?>)) { allPendingReview = false; }
                });
                issued_ticket_btn.prop('disabled', !allPendingReview);
            })();
            (function() {
                const refund_btn = action_section.find('.btn-refund');
                if (typeof is_tba === 'undefined' || !is_tba) {
                    refund_btn.hide();
                    return;
                }
                const checked_rows = table_el.find('.eta-row-checkbox:checked:visible').closest('tr');
                if (checked_rows.length === 0) {
                    refund_btn.prop('disabled', true);
                    return;
                }
                let all_have_ticket = true;
                const is_accom = table_el.closest('.eta-section').attr('data-tab') === 'accommodation';
                const target_fields = is_accom 
                    ? ['accommodation_proof_of_payment_file', 'accommodation_invoice_file']
                    : ['ticket_file', 'domestic_ticket_file'];

                checked_rows.each(function() {
                    const row_el = $(this);
                    let has_ticket_file = false;
                    
                    row_el.find('.eta-file-wrap').each(function() {
                        const st = row_el.find('.eta-status-label').attr('data-status') || '';
                        if (
                            String(st) === String(<?= ETA_TRAVEL_STATUS_BOOK_TICKET ?>) ||
                            String(st) === String(<?= ETA_TRAVEL_STATUS_ISSUED ?>)
                        ){ 
                            has_ticket_file = true;
                            return false;
                        }
                    });

                    if (!has_ticket_file) { all_have_ticket = false; return false; }
                });
                refund_btn.prop('disabled', !all_have_ticket);
            })();
            (function() {
                const send_ticket_btn = action_section.find('.btn-send-ticket');
                if (typeof is_tba === 'undefined' || !is_tba) {
                    send_ticket_btn.hide();
                    return;
                }
                const checked_rows = table_el.find('.eta-row-checkbox:checked:visible').closest('tr');
                if (checked_rows.length === 0) {
                    send_ticket_btn.prop('disabled', true);
                    return;
                }
                let all_have_ticket = true;
                const is_accom = table_el.closest('.eta-section').attr('data-tab') === 'accommodation';
                const target_fields = is_accom 
                    ? ['accommodation_proof_of_payment_file', 'accommodation_invoice_file']
                    : ['ticket_file', 'domestic_ticket_file'];

                checked_rows.each(function() {
                    const row_el = $(this);
                    let has_ticket_file = false;
                    if (!is_accom) {
                        row_el.find('.eta-ticket-wrap').each(function() {
                            const field = $(this).find('.eta-ticket-file-input').data('field');
                            if (field === 'ticket_file' || field === 'domestic_ticket_file') {
                                const tickets = $(this).data('tickets') || [];
                                if (tickets.length > 0) {
                                    has_ticket_file = true;
                                    return false;
                                }
                            }
                        });
                    } else {
                        row_el.find('.eta-file-wrap').each(function() {
                            const st = row_el.find('.eta-status-label').attr('data-status') || '';
                            if (
                                String(st) === String(<?= ETA_TRAVEL_STATUS_BOOK_TICKET ?>) ||
                                String(st) === String(<?= ETA_TRAVEL_STATUS_ISSUED ?>)
                            ){ 
                                has_ticket_file = true;
                                return false;
                            }
                        });
                    }
                    if (!has_ticket_file) { all_have_ticket = false; return false; }
                });
                send_ticket_btn.prop('disabled', !all_have_ticket);
            })();
            (function() {
                const notify_btn = action_section.find('.btn-notify-program');
                if (typeof is_tba === 'undefined' || !is_tba) {
                    notify_btn.hide();
                    return;
                }
                const checked_rows = table_el.find('.eta-row-checkbox:checked:visible').closest('tr');
                if (checked_rows.length === 0) {
                    notify_btn.prop('disabled', true);
                    return;
                }
                let allNewRequest = true;
                checked_rows.each(function() {
                    const st = $(this).find('.eta-status-label').attr('data-status') || '';
                    if (String(st) !== String(<?= ETA_TRAVEL_STATUS_NEW_REQUEST ?>)) { allNewRequest = false; return false; }
                });
                notify_btn.prop('disabled', !allNewRequest);
            })();
        });

        $(document).on('change', '.eta-row-checkbox', function () {
            const table_el = $(this).closest('table');
            const total = table_el.find('.eta-row-checkbox:visible').length;
            const checked = table_el.find('.eta-row-checkbox:checked:visible').length;
            table_el.find('.eta-select-all').prop('checked', total === checked && total > 0);
            
            const section_body_el = $(this).closest('.eta-section-body');
            updateSelectedCount(section_body_el);
            
            const section_body = table_el.closest('.eta-section-body');
            const action_section = section_body.find('.section-status-button-action');
            
            (function() {
                const checked_rows = table_el.find('.eta-row-checkbox:checked:visible').closest('tr');
                const any_checked = checked_rows.length > 0;

                if (any_checked) {
                    let allBlank = true;
                    let allPendingReview = true;
                    checked_rows.each(function() {
                        const st = $(this).find('.eta-status-label').attr('data-status') || '';
                        if (st !== '') { allBlank = false; }
                        if (String(st) !== String(<?= ETA_TRAVEL_STATUS_PENDING_REVIEW ?>)) { allPendingReview = false; }
                    });
                    action_section.find('.btn-find-flights').prop('disabled', !allBlank);
                    action_section.find('.btn-find-other-flights').prop('disabled', allBlank);
                    action_section.find('.btn-proceed-issue').prop('disabled', !allPendingReview);
                } else {
                    action_section.find('.btn-find-flights').prop('disabled', true);
                    action_section.find('.btn-find-other-flights, .btn-proceed-issue').prop('disabled', true);
                }
            })();
            (function() {
                const gen_btn = action_section.find('.btn-generate-pdf');
                if (typeof is_aminef_staff === 'undefined' || !is_aminef_staff) {
                    gen_btn.hide();
                    return;
                }
                const checked_rows = table_el.find('.eta-row-checkbox:checked:visible').closest('tr');
                if (checked_rows.length === 0) {
                    gen_btn.prop('disabled', true);
                    return;
                }
                let allApproved = true;
                checked_rows.each(function() {
                    const st = $(this).find('.eta-status-label').attr('data-status') || '';
                    if (String(st) !== String(<?= ETA_TRAVEL_STATUS_ISSUED?>)) { allApproved = false; return false; }
                });
                gen_btn.prop('disabled', !allApproved);
            })();
            
            (function() {
                const change_btn = action_section.find('.btn-change-flight');
                const checked_rows = table_el.find('.eta-row-checkbox:checked:visible').closest('tr');
                if (checked_rows.length === 0) { change_btn.prop('disabled', true); return; }
                let allIssued = true;
                checked_rows.each(function() {
                    const st = $(this).find('.eta-status-label').attr('data-status') || '';
                    if (String(st) !== String(<?= ETA_TRAVEL_STATUS_ISSUED?>)) { allIssued = false; return false; }
                });
                change_btn.prop('disabled', !allIssued);
            })();
            (function() {
                const notify_grantee_btn = action_section.find('.btn-notify-grantee');
                if (typeof is_aminef_staff === 'undefined' || !is_aminef_staff) {
                    notify_grantee_btn.hide();
                    return;
                }
                const checked_rows = table_el.find('.eta-row-checkbox:checked:visible').closest('tr');
                if (checked_rows.length === 0) {
                    notify_grantee_btn.prop('disabled', true);
                    return;
                }
                let all_pending_review = true;
                checked_rows.each(function() {
                    const st = $(this).find('.eta-status-label').attr('data-status') || '';
                    if (String(st) !== String(<?= ETA_TRAVEL_STATUS_PENDING_REVIEW ?>) &&
                        String(st) !== String(<?= ETA_TRAVEL_STATUS_GRANTEE_NOTIFIED ?>)) { all_pending_review = false; }
                });
                notify_grantee_btn.prop('disabled', !all_pending_review);
            })();
            (function() {
                const proceed_book_btn = action_section.find('.btn-proceed-book');
                if (typeof is_aminef_staff === 'undefined' || !is_aminef_staff) {
                    proceed_book_btn.hide();
                    return;
                }
                const checked_rows = table_el.find('.eta-row-checkbox:checked:visible').closest('tr');
                if (checked_rows.length === 0) {
                    proceed_book_btn.prop('disabled', true);
                    return;
                }
                let all_pending_review = true;
                checked_rows.each(function() {
                    const st = $(this).find('.eta-status-label').attr('data-status') || '';
                    if (String(st) !== String(<?= ETA_TRAVEL_STATUS_PENDING_REVIEW ?>)) { all_pending_review = false; return false; }
                });
                proceed_book_btn.prop('disabled', !all_pending_review);
            })();
            (function() {
                const booked_btn = action_section.find('.btn-booked');
                if (typeof is_tba === 'undefined' || !is_tba) {
                    booked_btn.hide();
                    return;
                }
                const checked_rows = table_el.find('.eta-row-checkbox:checked:visible').closest('tr');
                if (checked_rows.length === 0) {
                    booked_btn.prop('disabled', true);
                    return;
                }
                let all_book_ticket = true;
                checked_rows.each(function() {
                    const st = $(this).find('.eta-status-label').attr('data-status') || '';
                    if (String(st) !== String(<?= ETA_TRAVEL_STATUS_BOOK_TICKET ?>)) { all_book_ticket = false; return false; }
                });
                booked_btn.prop('disabled', !all_book_ticket);
            })();
            (function() {
                const issued_ticket_btn = action_section.find('.btn-issued-ticket');
                if (typeof is_aminef_staff === 'undefined' || !is_aminef_staff) {
                    issued_ticket_btn.hide();
                    return;
                }
                const checked_rows = table_el.find('.eta-row-checkbox:checked:visible').closest('tr');
                if (checked_rows.length === 0) {
                    issued_ticket_btn.prop('disabled', true);
                    return;
                }
                let allPendingReview = true;
                checked_rows.each(function() {
                    const st = $(this).find('.eta-status-label').attr('data-status') || '';
                    if (
                        String(st) !== String(<?= ETA_TRAVEL_STATUS_PENDING_REVIEW ?>) &&
                        String(st) !== String(<?= ETA_TRAVEL_STATUS_BOOKED ?>)
                    ){ 
                        allPendingReview = false; 
                    }
                });
                issued_ticket_btn.prop('disabled', !allPendingReview);

                // let allBook = true;
                // checked_rows.each(function() {
                //     const st = $(this).find('.eta-status-label').attr('data-status') || '';
                //     if (String(st) !== String(<?= ETA_TRAVEL_STATUS_BOOKED ?>)) { allBook = false; }
                // });
                // issued_ticket_btn.prop('disabled', !allBook);
            })();
            (function() {
                const refund_btn = action_section.find('.btn-refund');
                if (typeof is_tba === 'undefined' || !is_tba) {
                    refund_btn.hide();
                    return;
                }
                const checked_rows = table_el.find('.eta-row-checkbox:checked:visible').closest('tr');
                if (checked_rows.length === 0) {
                    refund_btn.prop('disabled', true);
                    return;
                }
                let all_have_ticket = true;
                const is_accom = table_el.closest('.eta-section').attr('data-tab') === 'accommodation';
                const target_fields = is_accom 
                ? ['accommodation_proof_of_payment_file', 'accommodation_invoice_file']
                : ['ticket_file', 'domestic_ticket_file'];
                
                checked_rows.each(function() {
                    const row_el = $(this);
                    let has_ticket_file = false;
                    
                    row_el.find('.eta-file-wrap').each(function() {
                        const st = row_el.find('.eta-status-label').attr('data-status') || '';
                        if (
                            String(st) === String(<?= ETA_TRAVEL_STATUS_BOOKED ?>)||
                            String(st) === String(<?= ETA_TRAVEL_STATUS_ISSUED ?>)
                        ){ 
                            has_ticket_file = true;
                            return false;
                        }
                    });
                    if (!has_ticket_file) { all_have_ticket = false; return false; }
                });
                refund_btn.prop('disabled', !all_have_ticket);
            })();
            (function() {
                const send_ticket_btn = action_section.find('.btn-send-ticket');
                if (typeof is_tba === 'undefined' || !is_tba) {
                    send_ticket_btn.hide();
                    return;
                }
                const checked_rows = table_el.find('.eta-row-checkbox:checked:visible').closest('tr');
                if (checked_rows.length === 0) {
                    send_ticket_btn.prop('disabled', true);
                    return;
                }
                let all_have_ticket = true;
                const is_accom = table_el.closest('.eta-section').attr('data-tab') === 'accommodation';
                const target_fields = is_accom 
                ? ['accommodation_proof_of_payment_file', 'accommodation_invoice_file']
                : ['ticket_file', 'domestic_ticket_file'];
                
                checked_rows.each(function() {
                    const row_el = $(this);
                    let has_ticket_file = false;
                    if (!is_accom) {
                        row_el.find('.eta-ticket-wrap').each(function() {
                            const field = $(this).find('.eta-ticket-file-input').data('field');
                            if (field === 'ticket_file' || field === 'domestic_ticket_file') {
                                const tickets = $(this).data('tickets') || [];
                                if (tickets.length > 0) {
                                    has_ticket_file = true;
                                    return false;
                                }
                            }
                        });
                    } else {
                        row_el.find('.eta-file-wrap').each(function() {
                            const st = row_el.find('.eta-status-label').attr('data-status') || '';
                            if (
                                String(st) === String(<?= ETA_TRAVEL_STATUS_BOOK_TICKET ?>)||
                                String(st) === String(<?= ETA_TRAVEL_STATUS_ISSUED ?>)
                            ){ 
                                has_ticket_file = true;
                                return false;
                            }
                        });
                    }
                    if (!has_ticket_file) { all_have_ticket = false; return false; }
                });
                send_ticket_btn.prop('disabled', !all_have_ticket);
            })();
            (function() {
                const notify_btn = action_section.find('.btn-notify-program');
                if (typeof is_tba === 'undefined' || !is_tba) {
                    notify_btn.hide();
                    return;
                }
                const checked_rows = table_el.find('.eta-row-checkbox:checked:visible').closest('tr');
                if (checked_rows.length === 0) {
                    notify_btn.prop('disabled', true);
                    return;
                }
                let allNewRequest = true;
                checked_rows.each(function() {
                    const st = $(this).find('.eta-status-label').attr('data-status') || '';
                    if (
                        String(st) !== String(<?= ETA_TRAVEL_STATUS_NEW_REQUEST ?>) &&
                        String(st) !== String(<?= ETA_TRAVEL_STATUS_REVISION ?>)
                    ){ 
                        allNewRequest = false; return false; 
                    }
                });
                notify_btn.prop('disabled', !allNewRequest);
            })();
        });

        tinymce.init({
            selector: '#proposed_flight_editor',
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright | bullist numlist outdent indent | removeformat | help',
            menubar: 'file edit view insert format tools table help',
            height: 50
        });

        function update_flight_counts() {
            const btns = $('.btn-proposed-flight');
            const id_map = {};

            btns.each(function() {
                const travel_id = $(this).data('travel-id');
                if (travel_id && travel_id !== 0) {
                    id_map[travel_id] = true;
                }
            });

            const travel_ids = Object.keys(id_map);
            if (travel_ids.length === 0) return;

            $.ajax({
                url: base_url + 'admin/eta_travel_arrangement/get_batch_flight_data',
                type: 'GET',
                data: { travel_arrangement_ids: travel_ids.join(',') },
                dataType: 'json',
                success: function(response) {
                    if (!response.success || !response.data) return;

                    btns.each(function() {
                        const btn_el = $(this);
                        const travel_id = btn_el.data('travel-id');
                        const grantee_id = btn_el.data('grantee');
                        const row_el = btn_el.closest('tr');

                        if (!travel_id || travel_id === 0) return;

                        const info = response.data[travel_id];
                        if (!info) return;

                        apply_flight_info_to_button(btn_el, grantee_id, row_el, info);
                    });
                }
            });
        }

        function apply_flight_info_to_button(btn_el, grantee_id, row_el, info) {
            const icon = (typeof is_tba !== 'undefined' && is_tba) ? 'fa-plus' : 'fa-list';
            if (info.total > 0) {
                btn_el.html(`<i class="fa ${icon}"></i> ${info.total} Propose Flight`);
            } else {
                btn_el.html(`<i class="fa ${icon}"></i> Propose Flight`);
            }

            const app_attachment = row_el.find(`.approved-flight-attachment[data-grantee="${grantee_id}"]`);
            const app_span = row_el.find(`.approved-flight-label span[data-grantee="${grantee_id}"]`);
                    if (app_span.length) {
                        const rate_input = row_el.find('input[data-field="rate_in_usd"]');
                        if (info.selected > 0 && info.selected_flight) {
                            const flight = info.selected_flight;
                            let display_text = strip_html(flight.description || flight.name || '');
                            if (display_text.length > 150) {
                                display_text = display_text.substring(0, 150) + '...';
                            }
                                app_span.text(display_text)
                                .attr('data-flight-id', flight.id)
                                .attr('data-flight-name', flight.name || '')
                                .attr('data-flight-description', flight.description || '')
                                .attr('data-flight-price', flight.price || '')
                                .attr('data-flight-attachment', flight.attachment_file || '')
                                .attr('data-flight-currency', flight.currency || 'USD')
                                .attr('data-flight-option', flight.option_index || '')
                                .css('cursor', 'pointer')
                                .css('text-decoration', 'underline')
                                .css('color', '#007bff')
                                .addClass('approved-flight-clickable');

                            if (rate_input.length) {
                                if (flight.price) {
                                    rate_input.val(formatCurrencyValue(flight.price, flight.currency || 'USD'));
                                    rate_input.attr('data-rate-currency', flight.currency || 'USD');
                                } else {
                                    rate_input.val('');
                                    rate_input.removeAttr('data-rate-currency');
                                }
                            }

                            if(flight.attachment_file){
                                app_attachment.attr('href', base_url + flight.attachment_file).removeClass('hide')
                            }else{
                                app_attachment.addClass('hide');
                            }
                        } else {
                            app_span.text('No selection')
                                .removeAttr('data-flight-id')
                                .removeAttr('data-flight-name')
                                .removeAttr('data-flight-description')
                                .removeAttr('data-flight-price')
                                .removeAttr('data-flight-currency')
                                .removeAttr('data-flight-option')
                                .css('cursor', 'default')
                                .css('text-decoration', 'none')
                                .css('color', '')
                                .removeClass('approved-flight-clickable');

                            if (rate_input.length) {
                                rate_input.val('');
                                rate_input.removeAttr('data-rate-currency');
                            }
                        }
                    }
        }

        function update_single_flight_count(travel_id) {
            if (!travel_id) return;
            $.ajax({
                url: base_url + 'admin/eta_travel_arrangement/get_batch_flight_data',
                type: 'GET',
                data: { travel_arrangement_ids: travel_id },
                dataType: 'json',
                success: function(response) {
                    if (!response.success || !response.data) return;
                    const info = response.data[travel_id];
                    if (!info) return;

                    $('.btn-proposed-flight').filter(function() {
                        return $(this).data('travel-id') == travel_id;
                    }).each(function() {
                        const btn_el = $(this);
                        const grantee_id = btn_el.data('grantee');
                        const row_el = btn_el.closest('tr');
                        apply_flight_info_to_button(btn_el, grantee_id, row_el, info);
                    });
                }
            });
        }
        
        function strip_html(html) {
            const div_el = document.createElement('div');
            div_el.innerHTML = html;
            return (div_el.textContent || div_el.innerText || '').trim();
        }

        function pf_reset_form() {
            $('#proposedFlightModal').removeData('editing-flight-id');
            if (typeof tinymce !== 'undefined' && tinymce.get('proposed_flight_editor')) {
                tinymce.get('proposed_flight_editor').setContent('');
            }
            $('#proposed_flight_price').val('');
            $('#proposed_flight_currency').val('USD');
            $('#attachment_file').val('');
            $('#proposed_flight_attachment').val('');
            $('.uploaded_attachment').attr('href', '#').attr('target', '_blank').removeClass('lightbox').html('<b><i class="fa fa-eye"></i></b>').addClass('hide');
            $('.remove_uploaded_attachment').addClass('hide');
            $('.edit_uploaded_attachment').addClass('hide');
            $('.upload-name-file').addClass('hide').html('');
            $('.icon-upload').removeClass('hide');
            $('.pf-upload-hint').removeClass('hide');
            $('#pf_form_title').text('Add Flight');
            $('#btn-add-proposed-flight').html('<i class="fa fa-plus"></i> Add Flight Option');
            $('#pf_cancel_edit').hide();
        }

        $(document).on('click', '#pf_cancel_edit', function(event) {
            event.preventDefault();
            pf_reset_form();
        });

        $(document).on('click', '.btn-proposed-flight', function(event) {
            event.preventDefault();
            const travel_id = $(this).data('travel-id');
            const grantee_id = $(this).data('grantee');
            const section_idx = $(this).data('section-idx');
            const db_id = $(this).data('db-id');
            const grantee_name = $(this).closest('tr').find('td').eq(1).contents().filter(function() {
                return this.nodeType === 3;
            }).first().text().trim();
            const section_el = $(this).closest('.eta-section');
            const section_category = section_el.data('category') || '';
            const section_flight_type = section_el.data('flight-type') || '';
            let travel_category = section_category;
            if (section_flight_type) {
                travel_category = (section_category ? section_category + ' - ' : '') + section_flight_type;
            }
            
            if (!travel_id || travel_id === 0) {
                show_toast('Please save the grantee information first (e.g. set departure airport) before proposing flights.', 'error');
                return;
            }
            
            if (typeof is_tba !== 'undefined' && is_tba) {
                $('#proposedFlightModal').data('travel-id', travel_id).data('grantee-id', grantee_id).data('grantee-name', grantee_name).removeData('editing-flight-id');
                $('#pf_grantee_name').text(grantee_name || '-');
                $('#pf_travel_category').text(travel_category || '-');

                pf_reset_form();
                
                load_proposed_flights(travel_id);
                
                $('#proposedFlightModal').modal('show');
            } else {
                $('#approvedFlightModal').data('travel-id', travel_id).data('grantee-id', grantee_id).data('grantee-name', grantee_name).data('section-idx', section_idx).data('db-id', db_id);
                $('#apf_grantee_name').text(grantee_name || '-');

                const row_el = $(this).closest('tr');
                const from_airport = row_el.find('input[data-field="departure_airport_us"]').val() || '';
                const to_airport = row_el.find('input[data-field="arrival_airport_indonesia"]').val() || '';
                let route_text = '-';
                if (from_airport || to_airport) {
                    route_text = (from_airport || '?') + ' \u2192 ' + (to_airport || '?');
                }
                $('#apf_route').text(route_text);

                load_proposed_flights_for_selection(travel_id);
                
                $('#approvedFlightModal').modal('show');
            }
        });

        function load_proposed_flights(travel_id) {
            $.ajax({
                url: base_url + 'admin/eta_travel_arrangement/get_proposed_flights',
                type: 'GET',
                data: { travel_arrangement_id: travel_id },
                dataType: 'json',
                success: function(response) {
                    if (response.success && response.data) {
                        display_proposed_flights(response.data);
                    }
                },
                error: function() {
                    console.error('Failed to load proposed flights');
                }
            });
        }

        function display_proposed_flights(flights) {
            const list_el = $('#proposed_flights_list');
            list_el.empty();
            $('#pf_options_count').text(flights.length);

            if (flights.length === 0) {
                list_el.html('<div class="empty-options-state">No flight quotation options added yet.<br>Use the form on the left to add one.</div>');
                return;
            }

            flights.forEach(function(flight, index) {
                const currency = flight.currency || 'USD';
                const price_display = flight.price
                    ? `<span class="saved-card-price">${formatCurrencyValue(flight.price, currency)}</span>`
                    : '<span class="saved-card-price text-muted">-</span>';
                const attachment_name = flight.attachment_file
                    ? $('<div>').text(flight.attachment_file.split('/').pop()).html()
                    : '';
                const attachment_display = flight.attachment_file ? `
                    <div class="saved-attachment-wrap">
                        <a href="${base_url}${flight.attachment_file}" target="_blank" class="saved-attachment-link lightbox" title="View Attachment">
                            <i class="fa fa-paperclip"></i> ${attachment_name}
                        </a>
                    </div>
                ` : '';
                const item_el = $(`
                    <div class="proposed-flight-item saved-option-card" data-flight-id="${flight.id}" data-flight-price="${flight.price || ''}">
                        <div class="saved-card-header">
                            <span class="saved-card-badge">Option #${index + 1}</span>
                            ${price_display}
                        </div>
                        <div class="saved-itinerary-preview flight-text">${flight.description || ''}</div>
                        <div class="saved-card-footer">
                            ${attachment_display}
                            <div class="saved-card-actions">
                                <button type="button" class="btn-card-action btn-edit btn-edit-proposed-flight" title="Edit">
                                    <i class="fa fa-pencil"></i> Edit
                                </button>
                                <button type="button" class="btn-card-action btn-delete btn-delete-proposed-flight" title="Delete">
                                    <i class="fa fa-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                `);

                item_el.attr('data-flight-name', flight.name || '')
                    .attr('data-flight-currency', currency)
                    .attr('data-flight-description', flight.description || '')
                    .attr('data-flight-attachment', flight.attachment_file || '');

                list_el.append(item_el);
            });

            $('.lightbox').topbox();
        }

        $(document).on('click', '#btn-add-proposed-flight', function() {
            const travel_id = $('#proposedFlightModal').data('travel-id');
            const editing_flight_id = $('#proposedFlightModal').data('editing-flight-id');
            const grantee_id = $('#proposedFlightModal').data('grantee-id');
            const editor_content = tinymce.get('proposed_flight_editor').getContent();
            const currency_val = $('#proposed_flight_currency').val() || 'USD';
            const price_raw = unformat_price($('#proposed_flight_price').val(), currency_val);
            
            if (!editor_content.trim()) {
                show_toast('Please enter the proposed flight details.', 'error');
                return;
            }
            
            if (!price_raw || price_raw === '') {
                show_toast('Please enter the price.', 'error');
                return;
            }

            const form_data = new FormData();
            form_data.append('description', editor_content);
            form_data.append('price', price_raw);
            form_data.append('currency', currency_val);
            form_data.append('grantee_grant_id', grantee_id);

            const file_input = $('#proposed_flight_attachment')[0];
            if (file_input.files && file_input.files[0]) {
                form_data.append('file', file_input.files[0]);
            } else {
                form_data.append('attachment_file', $('#attachment_file').val());
            }
            
            if (editing_flight_id) {
                form_data.append('id', editing_flight_id);
                $.ajax({
                    url: base_url + 'admin/eta_travel_arrangement/update_proposed_flight',
                    type: 'POST',
                    data: form_data,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            pf_reset_form();
                            
                            load_proposed_flights(travel_id);
                            update_single_flight_count(travel_id);
                            
                            show_toast('Proposed flight updated successfully');
                        } else {
                            show_toast('Failed to update proposed flight', 'error');
                        }
                    },
                    error: function() {
                        show_toast('Error while updating proposed flight', 'error');
                    }
                });
            } else {
                form_data.append('travel_arrangement_id', travel_id);
                $.ajax({
                    url: base_url + 'admin/eta_travel_arrangement/add_proposed_flight',
                    type: 'POST',
                    data: form_data,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            pf_reset_form();
                            
                            load_proposed_flights(travel_id);
                            update_single_flight_count(travel_id);
                            
                            show_toast('Proposed flight added successfully');
                        } else {
                            show_toast('Failed to add proposed flight', 'error');
                        }
                    },
                    error: function() {
                        show_toast('Error while adding proposed flight', 'error');
                    }
                });
            }
        });

        $(document).on('click', '.btn-delete-proposed-flight', function() {
            const el = $(this);
            const flight_id = el.closest('.proposed-flight-item').data('flight-id');
            const travel_id = $('#proposedFlightModal').data('travel-id');

            swal_confirm('Are you sure you want to delete this proposed flight?').then(function(confirmed) {
                if (!confirmed) return;

                $.ajax({
                    url: base_url + 'admin/eta_travel_arrangement/delete_proposed_flight',
                    type: 'POST',
                    data: { id: flight_id },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            load_proposed_flights(travel_id);
                            update_single_flight_count(travel_id);
                            show_toast('Proposed flight deleted successfully');
                        } else {
                            show_toast('Failed to delete proposed flight', 'error');
                        }
                    },
                    error: function() {
                        show_toast('Error while deleting proposed flight', 'error');
                    }
                });
            });
        });

        $(document).on('click', '.btn-edit-proposed-flight', function(event) {
            event.preventDefault();
            const item_el = $(this).closest('.proposed-flight-item');
            const flight_id = item_el.data('flight-id');
            const flight_content = item_el.find('.flight-text').html();
            const flight_price = item_el.data('flight-price');
            const flight_currency = item_el.data('flight-currency') || 'USD';
            const flight_attachment = item_el.attr('data-flight-attachment') || '';
            
            $('#proposedFlightModal').data('editing-flight-id', flight_id);
            
            $('#pf_form_title').text('Edit Option');
            $('#btn-add-proposed-flight').html('<i class="fa fa-check"></i> Update Option');
            $('#pf_cancel_edit').show();
            
            if (typeof tinymce !== 'undefined' && tinymce.get('proposed_flight_editor')) {
                tinymce.get('proposed_flight_editor').setContent(flight_content);
            }
            $('#proposed_flight_currency').val(flight_currency || 'USD');
            const price_input_el = $('#proposed_flight_price');
            price_input_el.val(flight_price || '');
            if (flight_price) {
                price_input_el.val(formatCurrencyValue(flight_price, flight_currency || 'USD'));
            }

            $('#attachment_file').val(flight_attachment);
            $('#proposed_flight_attachment').val('');
            if (flight_attachment) {
                var fileName = flight_attachment.split('/').pop();
                $('.uploaded_attachment').attr('href', base_url + flight_attachment).attr('target', '_blank').addClass('lightbox').html('<b><i class="fa fa-eye"></i></b>').removeClass('hide');
                $('.remove_uploaded_attachment').removeClass('hide');
                $('.edit_uploaded_attachment').removeClass('hide');
                $('.icon-upload').addClass('hide');
                $('.upload-name-file').removeClass('hide').html(`<b>${fileName}</b>`);
                $('.pf-upload-hint').addClass('hide');
            } else {
                $('.uploaded_attachment').attr('href', '#').removeClass('lightbox').addClass('hide');
                $('.remove_uploaded_attachment').addClass('hide');
                $('.edit_uploaded_attachment').addClass('hide');
                $('.upload-name-file').addClass('hide').html('');
                $('.icon-upload').removeClass('hide');
                $('.pf-upload-hint').removeClass('hide');
            }
            
            $('#proposedFlightModal .pf-form-panel').animate({ scrollTop: 0 }, 200);
            
            if (typeof tinymce !== 'undefined' && tinymce.get('proposed_flight_editor')) {
                tinymce.get('proposed_flight_editor').focus();
            }
        });

        $(document).on('change', '#proposed_flight_attachment', function () {
            const file_input = this;
            const file = file_input.files[0];
            if (!file) return;

            const objectUrl = URL.createObjectURL(file);
            $('.uploaded_attachment')
                .attr('href', objectUrl)
                .attr('target', '_blank')
                .addClass('lightbox')
                .html(`<b><i class="fa fa-eye"></i></b>`)
                .removeClass('hide');
            $('.upload-name-file').removeClass('hide').html(`<b>${file.name}</b>`)
            $('.pf-upload-hint').addClass('hide');
            $('.remove_uploaded_attachment').removeClass('hide');
            $('.edit_uploaded_attachment').removeClass('hide');
            $('.icon-upload').addClass('hide');

            // Initialize topbox for the local preview
            $('.lightbox').topbox();
        });

        $(document).on('dragover dragenter', '#proposedFlightModal .pf-upload-dropzone', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).addClass('pf-dragover');
        });

        $(document).on('dragleave dragend', '#proposedFlightModal .pf-upload-dropzone', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).removeClass('pf-dragover');
        });

        $(document).on('drop', '#proposedFlightModal .pf-upload-dropzone', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).removeClass('pf-dragover');
            const dt = e.originalEvent && e.originalEvent.dataTransfer;
            if (dt && dt.files && dt.files.length) {
                const input = document.getElementById('proposed_flight_attachment');
                if (input) {
                    input.files = dt.files;
                    $(input).trigger('change');
                }
            }
        });

        $(document).on('click', '#proposedFlightModal .uploaded_attachment', function (e) {
            e.stopPropagation();
        });

        $(document).on('click', '.remove_uploaded_attachment', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $('#attachment_file').val('');
            $('#proposed_flight_attachment').val('');
            $('.uploaded_attachment').attr('href', '#').attr('target', '_blank').removeClass('lightbox').html('<b><i class="fa fa-eye"></i></b>').addClass('hide');
            $('.remove_uploaded_attachment').addClass('hide');
            $('.edit_uploaded_attachment').addClass('hide');
            $('.upload-name-file').addClass('hide').html('');
            $('.pf-upload-hint').removeClass('hide');
            $('.icon-upload').removeClass('hide');
            show_toast('Attachment removed from proposed flight details');
        });

        function load_proposed_flights_for_selection(travel_id) {
            $.ajax({
                url: base_url + 'admin/eta_travel_arrangement/get_proposed_flights',
                type: 'GET',
                data: { travel_arrangement_id: travel_id },
                dataType: 'json',
                success: function(response) {
                    if (response.success && response.data) {
                        display_proposed_flights_for_selection(response.data);
                    }
                },
                error: function() {
                    console.error('Failed to load proposed flights for selection');
                }
            });
        }

        function update_approved_selection_cards() {
            $('#approved_flights_selection_list .approved-flight-selection-item').each(function() {
                $(this).toggleClass('selected', $(this).find('.flight-selection-checkbox').is(':checked'));
            });
        }

        function display_proposed_flights_for_selection(flights) {
            const list_el = $('#approved_flights_selection_list');
            const save_btn = $('#btn-save-approved-flights');
            list_el.empty();

            if (flights.length === 0) {
                list_el.html('<div class="apf-empty">No proposed flights available</div>');
                save_btn.prop('disabled', true);
                return;
            }

            save_btn.prop('disabled', false);

            flights.forEach(function(flight, index) {
                const is_checked = (flight.is_selected == 1 || flight.is_selected === true);
                const currency = flight.currency || 'USD';
                const price_display = flight.price
                    ? `<span class="option-price">${formatCurrencyValue(flight.price, currency)}</span>`
                    : '<span class="option-price">-</span>';
                const attachment_name = flight.attachment_file
                    ? $('<div>').text(flight.attachment_file.split('/').pop()).html()
                    : '';
                const attachment_footer = flight.attachment_file ? `
                    <div class="option-footer">
                        <a href="${base_url}${flight.attachment_file}" target="_blank" class="attachment-link lightbox" title="View Attachment">
                            <i class="fa fa-paperclip"></i> ${attachment_name}
                        </a>
                    </div>
                ` : '';
                const safeName = $('<div>').text(flight.name || '').html();
                const item_el = $(`
                    <div class="approved-flight-selection-item flight-option-card${is_checked ? ' selected' : ''}"
                        data-flight-id="${flight.id}" data-flight-price="${flight.price || ''}" data-flight-name="${safeName}" data-flight-currency="${currency}" data-flight-option="${index + 1}">
                        <input type="radio" name="approved_flight_option" class="option-radio flight-selection-checkbox"
                            data-flight-id="${flight.id}" value="${flight.id}" ${is_checked ? 'checked' : ''}>
                        <div class="option-main">
                            <div class="option-header-row">
                                <span class="option-label-badge">Proposed Option #${index + 1}</span>
                                ${price_display}
                            </div>
                            <div class="flight-raw-text flight-description">${flight.description || ''}</div>
                            ${attachment_footer}
                        </div>
                    </div>
                `);

                item_el.attr('data-flight-description', flight.description || '');

                item_el.find('.attachment-link').on('click', function(e) {
                    e.stopPropagation();
                });

                item_el.on('click', function(event) {
                    if ($(event.target).is('a') || $(event.target).is('a *')) return;
                    $(this).find('.flight-selection-checkbox').prop('checked', true);
                    update_approved_selection_cards();
                });

                list_el.append(item_el);
            });

            update_approved_selection_cards();
            $('.lightbox').topbox();
        }

        $(document).on('click', '#btn-save-approved-flights', function() {
            const travel_id = $('#approvedFlightModal').data('travel-id');
            const grantee_id = $('#approvedFlightModal').data('grantee-id');
            const section_idx = $('#approvedFlightModal').data('section-idx');
            const db_id = $('#approvedFlightModal').data('db-id');
            const selected_ids = [];
            let selected_price = null;
            let selected_currency = null;

            $('#approved_flights_selection_list .flight-selection-checkbox:checked').each(function() {
                selected_ids.push($(this).data('flight-id'));
                const item_el = $(this).closest('.approved-flight-selection-item');
                selected_price = item_el.data('flight-price');
                selected_currency = item_el.data('flight-currency') || 'USD';
            });
            
            $.ajax({
                url: base_url + 'admin/eta_travel_arrangement/batch_update_proposed_flight_selection',
                type: 'POST',
                data: {
                    travel_arrangement_id: travel_id,
                    ids: selected_ids.join(','),
                    is_selected: 1
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        show_toast('Approved flights updated successfully');
                        
                        if (selected_price && grantee_id && travel_id) {
                            let rate_input_el;
                            let final_rate_input_el;
                            if (section_idx && db_id) {
                                const section_el = $('.eta-section[data-section="' + section_idx + '"][data-db-id="' + db_id + '"]');
                                rate_input_el = section_el.find('input[data-field="rate_in_usd"][data-grantee="' + grantee_id + '"]');
                                // final_rate_input_el = section_el.find('input[data-field="final_rate"][data-grantee="' + grantee_id + '"]');
                            } else {
                                rate_input_el = $('input[data-field="rate_in_usd"][data-grantee="' + grantee_id + '"]');
                                // final_rate_input_el = $('input[data-field="final_rate"][data-grantee="' + grantee_id + '"]');
                            }
                            if (rate_input_el.length) {
                                rate_input_el.val(formatCurrencyValue(selected_price, selected_currency));
                                rate_input_el.attr('data-rate-currency', selected_currency);
                            }
                            // if (final_rate_input_el.length) {
                            //     final_rate_input_el.val(formatCurrencyValue(selected_price, selected_currency));
                            //     final_rate_input_el.attr('data-rate-currency', selected_currency);
                            // }

                            const sel_item = $('#approved_flights_selection_list .flight-selection-checkbox:checked').closest('.approved-flight-selection-item');
                            if (sel_item && sel_item.length) {
                                const f_id = sel_item.data('flight-id');
                                const f_name = sel_item.data('flight-name') || '';
                                const f_desc = sel_item.data('flight-description') || '';
                                const f_price = sel_item.data('flight-price') || '';
                                const f_currency = sel_item.data('flight-currency') || 'USD';
                                const f_option = sel_item.data('flight-option') || '';

                                let display_text = strip_html(f_desc || f_name || '');
                                if (display_text.length > 150) {
                                    display_text = display_text.substring(0, 150) + '...';
                                }

                                let row_el;
                                if (section_idx && db_id) {
                                    const section_el = $('.eta-section[data-section="' + section_idx + '"][data-db-id="' + db_id + '"]');
                                    row_el = section_el.find('tr[data-grantee="' + grantee_id + '"]');
                                } else {
                                    row_el = $('tr[data-grantee="' + grantee_id + '"]');
                                }

                                if (row_el && row_el.length) {
                                    const app_span = row_el.find('.approved-flight-label span');
                                    if (app_span.length) {
                                        app_span.text(display_text)
                                            .attr('data-flight-id', f_id)
                                            .attr('data-flight-name', f_name)
                                            .attr('data-flight-description', f_desc)
                                            .attr('data-flight-price', f_price)
                                            .attr('data-flight-currency', f_currency)
                                            .attr('data-flight-option', f_option)
                                            .css('cursor', 'pointer')
                                            .css('text-decoration', 'underline')
                                            .css('color', '#007bff')
                                            .addClass('approved-flight-clickable');
                                    }
                                }
                            }

                            $.post(base_url + 'admin/eta_travel_arrangement/save_field', {
                                grantee_grant_id: grantee_id,
                                field: 'rate_in_usd',
                                value: selected_price,
                                eta_travel_arrangement_section_id: db_id || 0,
                                am_travel_arrangement_id: travel_id
                            });

                            // $.post(base_url + 'admin/eta_travel_arrangement/save_field', {
                            //     grantee_grant_id: grantee_id,
                            //     field: 'final_rate',
                            //     value: selected_price,
                            //     eta_travel_arrangement_section_id: db_id || 0,
                            //     am_travel_arrangement_id: travel_id
                            // });
                        }
                            
                            update_single_flight_count(travel_id);
                        
                        $('#approvedFlightModal').modal('hide');
                    } else {
                        show_toast('Failed to update approved flights', 'error');
                    }
                },
                error: function() {
                    show_toast('Error while updating approved flights', 'error');
                }
            });
        });

        $(document).on('keydown', function(event) {
            if (event.key === 'Escape') {
                $('#proposedFlightModal').modal('hide');
                $('#approvedFlightModal').modal('hide');
                $('#approvedFlightDetailModal').modal('hide');
            }
        });
        
        $(document).on('click', '.approved-flight-clickable', function(event) {
            event.preventDefault();
            const label_el = $(this);
            const row_el = label_el.closest('tr');
            const desc = label_el.attr('data-flight-description') || '';
            const price = label_el.attr('data-flight-price') || '';
            const attachment = label_el.attr('data-flight-attachment') || '';
            const currency = label_el.attr('data-flight-currency') || 'USD';
            const name = label_el.attr('data-flight-name') || '';
            const option_no = label_el.attr('data-flight-option') || '';

            const grantee_name = (row_el.find('.btn-chat').data('name') || row_el.find('td').eq(1).contents().filter(function() {
                return this.nodeType === 3;
            }).first().text().trim() || '-');

            const from_airport = row_el.find('input[data-field="departure_airport_us"], input[data-field="domestic_departure_airport"]').first().val() || '';
            const to_airport = row_el.find('input[data-field="arrival_airport_indonesia"], input[data-field="domestic_arrival_airport"]').first().val() || '';
            let route_text = '-';
            if (from_airport || to_airport) {
                route_text = (from_airport || '?') + ' \u2192 ' + (to_airport || '?');
            }

            const attachment_display = attachment ? `
                <a href="${base_url}${attachment}" target="_blank" class="afd-attachment-link lightbox">
                    <i class="fa fa-paperclip"></i> ${$('<div>').text(attachment.split('/').pop()).html()}
                </a>
            ` : '';

            const safeName = $('<div>').text(name).html();
            let contentHtml = desc || '';
            if (!contentHtml && safeName) {
                contentHtml = safeName;
            }

            $('#approvedFlightDetailModal .afd-detail-grantee').text(grantee_name || '-');
            $('#approvedFlightDetailModal .afd-detail-route').text(route_text);
            $('#approvedFlightDetailModal .afd-detail-option-label').text(option_no ? 'Proposed Option #' + option_no : 'Proposed Option');
            $('#approvedFlightDetailModal .afd-detail-content').html(contentHtml);
            $('#approvedFlightDetailModal .afd-detail-price').text(price ? formatCurrencyValue(price, currency) : '-');
            $('#approvedFlightDetailModal .afd-detail-attachment').html(attachment_display);
            $('#approvedFlightDetailModal .afd-attachment-row').css('display', attachment ? 'flex' : 'none');
            $('#approvedFlightDetailModal').modal('show');
            $('.lightbox').topbox();
        });

        $(document).on('click', '.create-data-travel', function (event) {
            event.stopPropagation();
            const btn = $(this);
            swal_confirm('Create data travel?').then(function(confirmed) {
                if (!confirmed) return;
                const db_id = btn.data('db');
                const grantee_id = btn.data('grantee');
                const row_el = btn.closest('tr');
                if (db_id) {
                    $.post(base_url + 'admin/eta_travel_arrangement/add_data_travel', { grantee_grant_id: grantee_id, section_id: db_id }, function (response) {
                        if (response && response.success) {
                            show_toast('Successfuly Add Data Travel');

                            row_el.attr('data-travel-arrangement-id', response.travel_id);
                            row_el.find('.eta-row-checkbox')
                                .attr('data-travel-id', response.travel_id)
                                .data('travel-id', response.travel_id);
                            row_el.find('.btn-proposed-flight')
                                .attr('data-travel-id', response.travel_id)
                                .data('travel-id', response.travel_id);
                            row_el.find('.approved-flight-label span').attr('data-travel-id', response.travel_id);
                            row_el.find('.btn-chat')
                                .attr('data-ajax_url', '<?php echo site_url('admin/notes/get_list_ajax/eta_travel/') ?>' + grantee_id + '/' + response.travel_id);
                            row_el.find('.btn-chat').find('.span-note-travel')
                                .addClass('note-total-' + response.travel_id);
                            row_el.find('.td-name').removeClass('text-danger');
                            btn.remove();
                        }
                    });
                }
            });
        });

        $(document).on('click', '.btn-sync', function () {
            const syncData = $(this).data('sync-data');
            if (!syncData || syncData.length === 0) return;
            const btn = $(this);
            
            swal_confirm('Sync all missing data travel in this section?').then(function(confirmed) {
                if (!confirmed) return;
                btn.prop('disabled', true);
                let completed = 0;
                let successCount = 0;

                syncData.forEach(function(item) {
                    $.post(base_url + 'admin/eta_travel_arrangement/add_data_travel', { 
                        grantee_grant_id: item.grantee_id, 
                        section_id: item.db_id 
                    }, function (response) {
                        if (response && response.success) {
                            successCount++;
                            const row_el = $('.eta-section[data-section="' + item.section_idx + '"]')
                                .find('tr[data-grantee="' + item.grantee_id + '"]');
                            if (row_el.length) {
                                row_el.attr('data-travel-arrangement-id', response.travel_id);
                                row_el.find('.eta-row-checkbox')
                                    .attr('data-travel-id', response.travel_id)
                                    .data('travel-id', response.travel_id);
                                row_el.find('.btn-proposed-flight')
                                    .attr('data-travel-id', response.travel_id)
                                    .data('travel-id', response.travel_id);
                                row_el.find('.approved-flight-label span').attr('data-travel-id', response.travel_id);
                                row_el.find('.btn-chat')
                                    .attr('data-ajax_url', '<?php echo site_url('admin/notes/get_list_ajax/eta_travel/') ?>' + item.grantee_id + '/' + response.travel_id);
                                row_el.find('.btn-chat').find('.span-note-travel')
                                    .addClass('note-total-' + response.travel_id);
                                row_el.find('.td-name').removeClass('text-danger');
                                row_el.find('.create-data-travel').remove();
                            }
                        }
                    }).always(function() {
                        completed++;
                        if (completed === syncData.length) {
                            btn.hide().removeData('sync-data');
                            show_toast('Successfully synced ' + successCount + ' data travel');
                            $('#eta_period').trigger('change');
                        }
                    });
                });
            });
        });

        $(document).on('click', '.btn-setting-period', function () {
            var selectPeriod = $('#period_setting').val();
            const btn = $(this);

            if(selectPeriod){
                btn.prop('disabled', true);
                $.post(base_url + 'admin/eta_travel_arrangement/setting_period', { 
                    period: selectPeriod
                }, function (response) {
                    if (response && response.success) {
                        show_toast('Successfully set period');
                        $('#eta_period').val(response.period).trigger('change');
                        $('#modal_setting_eta').modal('hide');
                        btn.prop('disabled', false);
                    }
                });
            }else{
                show_toast('Please Select Period', 'error');
            }

        });

        setTimeout(function() {
            try {
                const optionPeriod = '<?= get_option('setting_period_eta') ?>';
                const qPeriod = getQueryParam('period') || optionPeriod;
                const qProgram = getQueryParam('program');
                if (qProgram) {
                    $('#eta_program').val(qProgram);
                } else if (qPeriod && typeof eta_saved_program !== 'undefined' && eta_saved_program) {
                    $('#eta_program').val(eta_saved_program);
                }
                if (qPeriod) {
                    $('#eta_period').val(qPeriod).trigger('change');
                }
                $('#period_setting').val(optionPeriod).trigger('change');

            } catch (e) {
                console.error('Error applying initial query params:', e);
            }
        }, 100);
        
    });
</script>
