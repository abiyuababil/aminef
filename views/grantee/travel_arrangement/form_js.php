<script>
    // $('.lightbox').topbox();
    const base_url = "<?= base_url() ?>";

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

    function fc_set_reject_mode(enabled) {
        const $reject = $('#fc-btn-reject');

        if (enabled) {
            $reject.data('reject-mode', true).html('Submit Rejection');
            $('#fc-revision-panel').css('display', 'flex');
            $('#fc-btn-confirm').hide();
            $('#fc-btn-cancel-reject').show();
            $('#fc-revision-notes').trigger('focus');
        } else {
            $reject.data('reject-mode', false).html('✕ Not Confirm');
            $('#fc-revision-panel').hide();
            $('#fc-revision-notes').val('');
            $('#fc-btn-confirm').show();
            $('#fc-btn-cancel-reject').hide();
        }
    }

    function reset_flight_confirm_modal() {
        $('#approvedFlightDetailModal').removeData('travel-id');
        $('#fc-route, #fc-agent, #fc-departure, #fc-return').text('-');
        $('#fc-return-wrap').show();
        $('#fc-itinerary').empty();
        $('#fc-price').text('-');
        $('#fc-attachment').html('-');
        fc_set_reject_mode(false);
    }

    $(document).on('click', '.btn-confirm-travel', function (event) {
        event.preventDefault();

        const $btn = $(this);
        const travel_id = $btn.attr('data-travel-id') || '';
        if (!travel_id) {
            return;
        }

        reset_flight_confirm_modal();
        $('#approvedFlightDetailModal').data('travel-id', travel_id);

        const flight_type = ($btn.attr('data-flight-type') || '').trim();
        const is_roundtrip = flight_type.toLowerCase() === 'roundtrip';
        const route_from = ($btn.attr('data-route-from') || '').trim() || 'N/A';
        const route_to = ($btn.attr('data-route-to') || '').trim() || 'N/A';
        const travel_agent = ($btn.attr('data-travel-agent') || '').trim() || 'N/A';
        const departure_date = ($btn.attr('data-departure-date') || '').trim() || 'N/A';
        const return_date = ($btn.attr('data-return-date') || '').trim();

        $('#fc-route').text(route_from + ' → ' + route_to);
        $('#fc-agent').text(travel_agent);
        $('#fc-departure').text(departure_date);

        if (is_roundtrip && return_date) {
            $('#fc-return').text(return_date);
            $('#fc-return-wrap').show();
        } else {
            $('#fc-return-wrap').hide();
        }

        $('#approvedFlightDetailModal').modal('show');

        $.ajax({
            url: base_url + 'grantee/eta_travel_arrangement/get_selected_proposed_flights',
            type: 'GET',
            data: { travel_arrangement_id: travel_id },
            dataType: 'json',
            success: function(response) {
                if (!response.success || !response.data) {
                    return;
                }

                const desc = response.data.description || '';
                const price = response.data.price || '';
                const currency = response.data.currency || 'USD';
                const name = response.data.name || '';
                const attachment = response.data.attachment_file || '';

                const safe_name = $('<div>').text(name).html();
                let content_html = '';
                if (safe_name) {
                    content_html += '<div style="font-weight:700; margin-bottom:8px;">' + safe_name + '</div>';
                }
                content_html += desc || '<span class="text-muted">No flight detail available.</span>';
                $('#fc-itinerary').html(content_html);

                $('#fc-price').text(price !== '' ? formatCurrencyValue(price, currency) : '-');

                if (attachment) {
                    $('#fc-attachment').html(
                        '<a href="' + base_url + attachment + '" target="_blank" class="fc-attachment-link lightbox">'
                        + '<i class="fa fa-paperclip"></i> View Attachment</a>'
                    );
                    if (typeof $.fn.topbox === 'function') {
                        $('.lightbox').topbox();
                    }
                } else {
                    $('#fc-attachment').html('<span class="text-muted">No attachment</span>');
                }
            },
            error: function() {
                console.error('Failed to load proposed flights');
            }
        });
    });

    $(document).on('click', '#fc-btn-confirm', function () {
        const id = $('#approvedFlightDetailModal').data('travel-id');
        if (!id) {
            return;
        }
        fc_set_reject_mode(false);
        updateStatus(id, 'approve');
    });

    $(document).on('click', '#fc-btn-cancel-reject', function () {
        fc_set_reject_mode(false);
    });

    $(document).on('click', '#fc-btn-reject', function () {
        const $btn = $(this);
        const id = $('#approvedFlightDetailModal').data('travel-id');
        if (!id) {
            return;
        }

        if ($btn.data('reject-mode') !== true) {
            fc_set_reject_mode(true);
            return;
        }

        const notes = ($('#fc-revision-notes').val() || '').trim();
        if (notes === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Reason required',
                text: 'Please provide a reason before submitting.',
                confirmButtonText: 'OK'
            });
            return;
        }

        updateStatus(id, 'reject', notes);
    });

    $(document).on('show.bs.modal', '#approvedFlightDetailModal', function () {
        fc_set_reject_mode(false);
    });

    $(document).on('hidden.bs.modal', '#approvedFlightDetailModal', function () {
        reset_flight_confirm_modal();
    });

    function updateStatus(id, action, note='') {
        var form_data = {
            id: id,
            action: action,
            note:note
        };

        $.ajax({
            url: '<?= site_url('grantee/eta_travel_arrangement/update_status') ?>',
            type: 'POST',
            data: form_data,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        confirmButtonText: 'close',
                    }).then(function () {
                        location.reload();
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
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while updating the status',
                    confirmButtonText: 'close',
                });
            }
        });
    }

    // Floating menu for tickets in grantee view
    function render_grantee_ticket_menu_list(tickets) {
        const menu_list = $('#ticketMenuList');
        menu_list.empty();
        if (!tickets || tickets.length === 0) {
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
            const view_btn = $('<a class="btn-ticket-view lightbox" target="_blank" title="View ticket"><i class="fa fa-eye"></i> View</a>')
                .attr('href', base_url + file_path);

            info.append(file_icon).append(name_link);
            actions.append(view_btn);
            row.append(info).append(actions);
            menu_list.append(row);
        });
        if (typeof $.fn.topbox === 'function') {
            $('.lightbox').topbox();
        }
    }

    $(document).on('click', '.btn-ticket-pill', function(e) {
        e.stopPropagation();
        const pill_el = $(this);
        const menu = $('#ticketFloatingMenu');

        // If already open for this pill, close it
        if (menu.is(':visible') && menu.data('pill-el') && menu.data('pill-el').is(pill_el)) {
            menu.hide().removeData('pill-el');
            return;
        }

        let tickets = pill_el.data('tickets');
        if (typeof tickets === 'string') {
            try { tickets = JSON.parse(tickets); } catch(e) { tickets = [tickets]; }
        }
        if (!Array.isArray(tickets)) {
            tickets = tickets ? [tickets] : [];
        }

        menu.data('pill-el', pill_el);
        render_grantee_ticket_menu_list(tickets);

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

        if (top + menu_h > win_h - 10) {
            const top_above = rect.top - menu_h - 4;
            if (top_above >= 10) {
                top = top_above;
            } else {
                top = Math.max(10, win_h - menu_h - 10);
            }
        }

        if (left + menu_w > win_w - 10) {
            left = Math.max(10, win_w - menu_w - 10);
        }

        menu.css({
            top: Math.round(top) + 'px',
            left: Math.round(left) + 'px',
            visibility: 'visible'
        });
    });

    $(window).on('scroll.ticketMenu resize.ticketMenu', function() {
        const menu = $('#ticketFloatingMenu');
        if (menu.is(':visible')) {
            menu.hide().removeData('pill-el');
        }
    });

    $(document).on('scroll', '.eta-tables-wrapper, .table-responsive, .tab-pane', function(e) {
        const menu = $('#ticketFloatingMenu');
        if (menu.is(':visible') && !$(e.target).closest('#ticketFloatingMenu').length) {
            menu.hide().removeData('pill-el');
        }
    });

    $(document).on('click', '#btnCloseTicketMenu', function(e) {
        e.stopPropagation();
        $('#ticketFloatingMenu').hide().removeData('pill-el');
    });

    $(document).on('click', function(e) {
        const menu = $('#ticketFloatingMenu');
        if (menu.is(':visible') && !$(e.target).closest('#ticketFloatingMenu, .btn-ticket-pill').length) {
            menu.hide().removeData('pill-el');
        }
    });

    $(document).ready(function() {
        const urlParams = new URLSearchParams(window.location.search);
        const qTab = urlParams.get('tab');
        const hash = window.location.hash;

        const tabMap = {
            'international': '#international_ticket',
            'international_ticket': '#international_ticket',
            'domestic': '#domestic_ticket',
            'domestic_ticket': '#domestic_ticket',
            'accommodation': '#accommodation_venue',
            'accommodation_venue': '#accommodation_venue',
            'history': '#eta_history',
            'eta_history': '#eta_history'
        };

        let targetTabId = null;
        if (hash && $('.nav-pills a[href="' + hash + '"]').length) {
            targetTabId = hash;
        } else if (qTab && tabMap[qTab]) {
            targetTabId = tabMap[qTab];
        }

        if (targetTabId) {
            const $tabLink = $('.nav-pills a[href="' + targetTabId + '"]');
            if ($tabLink.length) {
                try {
                    $tabLink.tab('show');
                } catch(e) {
                    $tabLink.trigger('click');
                }
            }
        }

        $('.nav-pills a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            const href = $(e.target).attr('href');
            if (href && history.replaceState) {
                history.replaceState(null, null, href);
            }
        });
    });
</script>