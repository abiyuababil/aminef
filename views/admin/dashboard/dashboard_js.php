<script>
    jQuery(document).ready(function ($) {
        $('#program-filter').selectpicker();
        // load_submitted_grantees();

        $('#program-filter').on('changed.bs.select', function () {
            load_submitted_grantees();
        });

        function load_submitted_grantees() {
            $('#submitted-grantees-table').show();

            var program_filter = $('#program-filter').val() || 'all';

            $.ajax({
                url: '<?php echo site_url("admin/dashboard/get_submitted_grantees") ?>',
                type: 'GET',
                data: {
                    program: program_filter
                },
                dataType: 'json',
                beforeSend: function () {
                    // show global loading alert, hide table and no-data alert
                    $('#submitted-grantees-table').hide();
                    $('#no-data-alert').hide();
                    $('#loading-alert').show();
                },
                success: function (response) {
                    var tbody = $('#grantees-table tbody');
                    tbody.empty();

                    if (response && response.data && response.data.length > 0) {
                        $.each(response.data, function (index, grantee) {
                            var sections_html = '';

                            

                            if (grantee.submitted_categories && grantee.submitted_categories.length > 0) {
                                

                                $.each(grantee.submitted_categories, function (i, category) {
                                    var file_info_html = '';
                                    if (category.submission_files) {
                                        file_info_html += '<div class="file-info-section">';
                                        file_info_html += '<div class="file-list">';
                                        if (category.submission_files.fields && category.submission_files.fields.length > 0) {
                                            $.each(category.submission_files.fields, function (file_index, field) {
                                                var field_name = field.complete_name || field.name || 'Unnamed Field';
                                                var file = field.file;
                                                if (file && file.filepath) {
                                                    var url = file.filepath || '#';
                                                    var file_url = url ? '<?php echo base_url(); ?>' + url : '#';
                                                    var file_name = file.filename || field_name;
                                                    var file_ext = (url && url.split('.').length > 1) ? url.split('.').pop().toLowerCase() : '';
                                                    var is_image = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'].includes(file_ext);
                                                    var is_pdf = file_ext === 'pdf';
                                                    var file_icon = is_image ? 'fa-image' : (is_pdf ? 'fa-file-pdf-o' : 'fa-file');
                                                    var file_class = is_image || is_pdf ? 'lightbox' : '';

                                                    file_info_html += '<div class="file-item">';
                                                    file_info_html += '<i class="fa ' + file_icon + ' file-icon"></i>';
                                                    file_info_html += '<div class="file-details">';
                                                    file_info_html += '<a href="' + file_url + '" class="' + file_class + '" data-title="' + file_name + '" ' + (is_image || is_pdf ? '' : 'download') + '>' + field_name + '</a>';
                                                    file_info_html += '</div>';
                                                    file_info_html += '</div>';
                                                } else {
                                                    file_info_html += '<div class="file-item no-file">';
                                                    file_info_html += '<i class="fa fa-file-o file-icon text-muted"></i>';
                                                    file_info_html += '<div class="file-details">';
                                                    file_info_html += '<span class="field-name">' + field_name + '</span>';
                                                    file_info_html += '</div>';
                                                    file_info_html += '</div>';
                                                }
                                            });
                                        } else {
                                            file_info_html += '<div class="no-files p-4 text-warning">No file fields</div>';
                                        }

                                        file_info_html += '</div></div>';
                                    }

                                    sections_html += '<div class="category-card">';

                                    sections_html += '<div class="category-header">';
                                    sections_html += '<h4 class="category-title">';
                                    sections_html += category.name;
                                    sections_html += '<span class="document-status-info '+ category.document_status_badge +'">' + category.document_status_name + '</span>';
                                    sections_html += '</h4>';
                                    
                                    sections_html += '</div>';

                                    sections_html += '<div class="category-body">';
                                    sections_html += '<div class="category-files">';
                                    sections_html += file_info_html;
                                    sections_html += '</div>';
                                    sections_html += '<div class="category-actions">';

                                    if (category.document_status_id != <?php echo DOCUMENT_COMPLETED; ?>) {
                                        sections_html += '<button class="btn btn-sm btn-success btn-section-action mr-2" ' +
                                            'data-action="complete" ' +
                                            'data-user-id="' + grantee.user_grantee_id + '" ' +
                                            'data-grantee-grant-id="' + grantee.id_grantee_grant + '" ' +
                                            'data-grant-id="' + grantee.grant_id + '" ' +
                                            'data-category-id="' + category.id + '" ' +
                                            'data-document="' + category.name + '">';
                                        sections_html += 'Verified';
                                        sections_html += '</button>';
                                    }

                                    let disable_revise = category.document_status_id == <?php echo DOCUMENT_NEED_REVISION; ?> ? 'disabled' : ''; 
                                    sections_html += '<button ' + disable_revise + ' class="btn btn-sm btn-warning btn-section-action" ' +
                                        'data-action="revise" ' +
                                        'data-user-id="' + grantee.user_grantee_id + '" ' +
                                        'data-grantee-grant-id="' + grantee.id_grantee_grant + '" ' +
                                        'data-grant-id="' + grantee.grant_id + '" ' +
                                        'data-category-id="' + category.id + '" ' +
                                        'data-document="' + category.name + '">';
                                    sections_html += 'Revise';
                                    sections_html += '</button>';

                                    sections_html += '</div></div></div>';
                                });
                                sections_html += '</div>';
                            } else {
                                return true; 
                            }

                            var first_category = grantee.submitted_categories[0];
                            var withdraw_btn = '<div class="withdraw-row-action">' +
                                '<button class="btn btn-sm btn-primary btn-section-action" ' +
                                'data-action="withdraw" ' +
                                'data-user-id="' + grantee.user_grantee_id + '" ' +
                                'data-grantee-grant-id="' + grantee.id_grantee_grant + '" ' +
                                'data-grant-id="' + grantee.grant_id + '" ' +
                                'data-category-id="' + first_category.id + '" ' +
                                'data-document="' + first_category.name + '">' +
                                '<i class="fa fa-undo"></i> Withdraw' +
                                '</button></div>';

                            var row = '<tr class="grantee-table-row">' +
                                '<td class="grantee-name-cell">' + (grantee.fullname || '-') + withdraw_btn + '</td>' +
                                '<td><div class="grantee-sections-cell">' + sections_html + '</div></td>' +
                                '</tr>';
                            tbody.append(row);
                        });

                        if (tbody.find('tr').length > 0) {
                            $('#submitted-grantees-table').show();
                            $('#no-data-alert').hide();
                        } else {
                            $('#submitted-grantees-table').hide();
                            $('#no-data-alert').show();
                        }
                    } else {
                        $('#submitted-grantees-table').hide();
                        $('#no-data-alert').show();
                    }

                    // hide loading alert
                    $('#loading-alert').hide();

                    if ($('#submitted-grantees-table').is(':visible')) {
                        $('html, body').animate({
                            scrollTop: $('#submitted-grantees-table').offset().top - 50
                        }, 500);
                    }
                    $('.lightbox').topbox();
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    console.error('Response:', xhr.responseText);
                    // hide loading and show no-data alert
                    $('#loading-alert').hide();
                    $('#submitted-grantees-table').hide();
                    $('#no-data-alert').show();
                    alert('Error loading data: ' + error);
                }
            });
        }

        $(document).on('click', '.btn-section-action', function () {
            if ($(this).is(':disabled')) {
                return;
            }

            var action = $(this).data('action');
            var user_id = $(this).data('user-id');
            var grantee_grant_id = $(this).data('grantee-grant-id');
            var grant_id = $(this).data('grant-id');
            var category_id = $(this).data('category-id');
            var document = $(this).data('document');
            var status_url = 'admin/new_grantee';

            if (action == 'complete') {
                accept_submission_document_modal(user_id, grantee_grant_id, grant_id, category_id, status_url, document );
            } else if (action == 'revise') {
                revise_submission_document_modal(user_id, grantee_grant_id, grant_id, category_id, status_url, document);
            } else if (action == 'withdraw') {
                withdraw_submission_document_modal(user_id, grantee_grant_id, grant_id, category_id, status_url, document);
            }
        });



        $(document).on('click', '.load_section', function (e) {
            e.preventDefault();

            var $this = $(this);
            $('.load_section').removeClass('selected').closest('li').removeClass('active');

            if ($this.closest('li').length) {
                $this.closest('li').addClass('active');
            } else {
                $this.addClass('selected');
            }

            const section = $this.data('section');
            load_section(section);
        });


        function load_section(section) {
            $('#section-submitted, #section-upcoming, #section-report, #section-travel_arrangement, #section-leave').hide();
            $('#grantees-table tbody, #upcoming-table tbody, #report-table tbody, #travel-table tbody, #travel-non-eta-table tbody, #leave-table tbody').empty();
            $('#loading-alert, #loading-alert-upcoming, #loading-alert-report, #loading-alert-travel, #loading-alert-travel-non-eta, #loading-alert-leave').hide();
            $('#no-data-alert, #no-data-alert-upcoming, #no-data-alert-report, #no-data-alert-travel, #no-data-alert-travel-non-eta, #no-data-alert-leave').hide();

            if (section === 'submitted') {
                load_submitted_grantees();
                $('#section-submitted').show();
            } else if (section === 'upcoming') {
                load_upcoming_disbursements();
                $('#section-upcoming').show();
            } else if (section === 'report') {
                load_upcoming_reports();
                $('#section-report').show();
            } else if (section === 'travel_arrangement') {
                $('#travel-arrangement-tabs li').removeClass('active');
                $('#travel-arrangement-tabs li:first-child').addClass('active');
                $('#travel-tab-eta').show();
                $('#travel-tab-non_eta').hide();
                load_upcoming_travel_arrangements();
                $('#section-travel_arrangement').show();
            } else if (section === 'leave') {
                load_grantee_leaves();
                $('#section-leave').show();
            }
        }
        
        function load_upcoming_reports() {
            $.ajax({
                url: '<?php echo site_url("admin/dashboard/get_upcoming_reports") ?>',
                type: 'GET',
                dataType: 'json',
                beforeSend: function () {
                    $('#report-grantees-table').hide();
                    $('#no-data-alert-report').hide();
                    $('#loading-alert-report').show();
                },
                success: function (response) {
                    var tbody = $('#report-table tbody');
                    tbody.empty();

                    if (response && response.data && response.data.length > 0) {
                        $.each(response.data, function (index, report) {
                            var row = '<tr>' +
                                '<td>' + (report.fullname || '-') + '</td>' +
                                '<td>' + (report.program_name || '-') + '</td>' +
                                '<td>' + (report.report_name || '-') + '</td>' +
                                '<td>' + (report.report_date || '-') + '</td>' +
                                '<td>' + (report.report_end_date || '-') + '</td>' +
                                '</tr>';
                            tbody.append(row);
                        });

                        if (tbody.find('tr').length > 0) {
                            $('#report-grantees-table').show();
                            $('#no-data-alert-report').hide();
                        } else {
                            $('#report-grantees-table').hide();
                            $('#no-data-alert-report').show();
                        }
                    } else {
                        $('#report-grantees-table').hide();
                        $('#no-data-alert-report').show();
                    }

                    $('#loading-alert-report').hide();
                },
                error: function () {
                    $('#loading-alert-report').hide();
                    $('#report-grantees-table').hide();
                    $('#no-data-alert-report').show();
                }
            });
        }

        function load_upcoming_disbursements() {
            $.ajax({
                url: '<?php echo site_url("admin/dashboard/get_upcoming_disbursements") ?>',
                type: 'GET',
                dataType: 'json',
                beforeSend: function () {
                    // show global loading alert, hide table and no-data alert
                    $('#upcoming-grantees-table').hide();
                    $('#no-data-alert-upcoming').hide();
                    $('#loading-alert-upcoming').show();
                },
                success: function (response) {
                    var tbody = $('#upcoming-table tbody');
                    tbody.empty();

                    if (response && response.data && response.data.length > 0) {
                        $.each(response.data, function (index, grantee) {
                            var sections_html = '';
                            var detail_btn = '<a target="_blank" class="btn btn-xs btn-primary" href="'+ grantee.url +'">Detail</a>';

                            var row = '<tr class="grantee-table-row">' +
                                '<td>' + (grantee.fullname || '-')  + '</td>' +
                                '<td>'+ grantee.program_name +'</td>' +
                                '<td>'+ grantee.payment_name +'</td>' +
                                '<td>'+ grantee.processing_date +'</td>' +
                                '<td>'+ grantee.total_nominal +'</td>' +
                                '<td>'+ detail_btn +'</td>' +
                                '</tr>';
                            tbody.append(row);
                        });

                        if (tbody.find('tr').length > 0) {
                            $('#upcoming-grantees-table').show();
                            $('#no-data-alert-upcoming').hide();
                        } else {
                            $('#upcoming-grantees-table').hide();
                            $('#no-data-alert-upcoming').show();
                        }
                    } else {
                        $('#upcoming-grantees-table').hide();
                        $('#no-data-alert-upcoming').show();
                    }

                    // hide loading alert
                    $('#loading-alert-upcoming').hide();

                    if ($('#submitted-grantees-table').is(':visible')) {
                        $('html, body').animate({
                            scrollTop: $('#submitted-grantees-table').offset().top - 50
                        }, 500);
                    }
                    $('.lightbox').topbox();
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    console.error('Response:', xhr.responseText);
                    // hide loading and show no-data alert
                    $('#loading-alert-upcoming').hide();
                    $('#submitted-grantees-table').hide();
                    $('#no-data-alert-upcoming').show();
                    alert('Error loading data: ' + error);
                }
            });
        }

        function load_upcoming_travel_arrangements(page) {
            page = page || 1;
            var period = $('#travel-filter-period').val() || '';
            var status = $('#travel-filter-status').val() || '';
            var category = $('#travel-filter-category').val() || '';
            var limit = $('#travel-filter-limit').val() || 10;

            $.ajax({
                url: '<?php echo site_url("admin/dashboard/get_upcoming_travel_arrangements") ?>',
                type: 'GET',
                data: {
                    page: page,
                    limit: limit,
                    period: period,
                    status: status,
                    category: category
                },
                dataType: 'json',
                beforeSend: function () {
                    $('#travel-arrangements-table').hide();
                    $('#travel-pagination-row').hide();
                    $('#no-data-alert-travel').hide();
                    $('#loading-alert-travel').show();
                },
                success: function (response) {
                    var tbody = $('#travel-table tbody');
                    tbody.empty();

                    window._travel_data = {};

                    if (response && response.data && response.data.length > 0) {
                        $.each(response.data, function (index, travel) {
                            window._travel_data[String(travel.id)] = travel;

                            var category = travel.category || '';
                            var url_note = '<?php echo site_url('admin/notes/get_list_ajax/eta_travel/'); ?>' + travel.grantee_grant_id + '/' + travel.id;
                            var status_html = '<span class="eta-status-label" data-status="' + (travel.status || '') + '">' + (travel.status_label || '') + '</span>';
                            var detail_url = '<?php echo site_url("admin/eta_travel_arrangement") ?>?period=' + (travel.period_id || '') + '&tab=' + (travel.tab || '') + '&section=' + (travel.section_id || '');
                            var detail_btn = '<a class="btn btn-primary btn-sm" href="' + detail_url + '" target="_blank">Detail</a>';
                            var chat_btn = '<a href="#" data-grantname="" data-period="'+travel.period+'" data-name="'+travel.fullname+'" data-category="'+travel.category+'" data-id="" data-ajax_url="'+url_note+'"  class="open-offcanvas-note btn btn-xs btn-warning btn-chat">' +
                                                '<i class="fa fa-comments"></i> Chat ' +
                                                '<span class="span-note-travel note-total-'+travel.id+'" data-total="'+(travel.total_notes || '')+'">' +
                                                    '<span class="badge">'+(travel.total_notes || '')+'</span>' +
                                                '</span>' +
                                            '</a>';

                            var row = '<tr>' +
                                '<td>' + (travel.period || '-') + '</td>' +
                                '<td>' + (travel.fullname || '-') + '</td>' +
                                '<td>' + (category || '-') + '</td>' +
                                '<td>' + status_html + '</td>' + 
                                '<td>' + chat_btn + '</td>' + 
                                '<td class="text-right">' + detail_btn + '</td>' +
                                '</tr>';
                            tbody.append(row);
                        });

                        if (tbody.find('tr').length > 0) {
                            $('#travel-arrangements-table').show();
                            $('#no-data-alert-travel').hide();
                        } else {
                            $('#travel-arrangements-table').hide();
                            $('#no-data-alert-travel').show();
                        }
                    } else {
                        $('#travel-arrangements-table').hide();
                        $('#no-data-alert-travel').show();
                    }

                    render_travel_pagination(response);
                    $('#travel-pagination-row').show();

                    $('#loading-alert-travel').hide();
                },
                error: function () {
                    $('#loading-alert-travel').hide();
                    $('#travel-arrangements-table').hide();
                    $('#travel-pagination-row').hide();
                    $('#no-data-alert-travel').show();
                }
            });
        }

        function render_travel_pagination(response) {
            var total = response.total || 0;
            var page = response.page || 1;
            var limit = response.limit || 10;
            var total_pages = Math.ceil(total / limit);

            var start_row = total > 0 ? ((page - 1) * limit) + 1 : 0;
            var end_row = Math.min(page * limit, total);

            $('#travel-page-info').text('Showing ' + start_row + ' to ' + end_row + ' of ' + total + ' entries');

            if (total_pages <= 1) {
                $('#travel-pagination').html('');
                return;
            }

            var html = '<ul class="pagination">';
            html += '<li class="' + (page <= 1 ? 'disabled' : '') + '"><a href="#" data-page="' + (page - 1) + '">&laquo;</a></li>';
            for (var p = 1; p <= total_pages; p++) {
                html += '<li class="' + (p === page ? 'active' : '') + '"><a href="#" data-page="' + p + '">' + p + '</a></li>';
            }
            html += '<li class="' + (page >= total_pages ? 'disabled' : '') + '"><a href="#" data-page="' + (page + 1) + '">&raquo;</a></li>';
            html += '</ul>';

            $('#travel-pagination').html(html);
        }

        $(document).on('click', '#travel-pagination a', function (e) {
            e.preventDefault();
            if ($(this).parent().hasClass('disabled')) {
                return;
            }
            load_upcoming_travel_arrangements($(this).data('page'));
        });

        function update_travel_filter_btn() {
            var active = false;
            ['#travel-filter-period', '#travel-filter-status', '#travel-filter-category'].forEach(function (sel) {
                var v = $(sel).val();
                if (v !== '' && v !== null && v !== undefined) {
                    active = true;
                }
            });
            var $btn = $('#travel-filter-btn');
            if (active) {
                $btn.text('Reset Filter').attr('data-reset', '1');
            } else {
                $btn.text('Filter').attr('data-reset', '0');
            }
        }

        function update_travel_filter_btn_non_eta() {
            var active = false;
            ['#travel-non-eta-filter-program', '#travel-non-eta-filter-status', '#travel-non-eta-filter-category'].forEach(function (sel) {
                var v = $(sel).val();
                if (v !== '' && v !== null && v !== undefined) {
                    active = true;
                }
            });
            var $btn = $('#travel-non-eta-filter-btn');
            if (active) {
                $btn.text('Reset Filter').attr('data-reset', '1');
            } else {
                $btn.text('Filter').attr('data-reset', '0');
            }
        }

        update_travel_filter_btn();
        update_travel_filter_btn_non_eta();

        $(document).on('click', '#travel-filter-btn', function (e) {
            e.preventDefault();
            if ($(this).attr('data-reset') === '1') {
                $('#travel-filter-period, #travel-filter-status, #travel-filter-category').val('');
                update_travel_filter_btn();
            }
            load_upcoming_travel_arrangements(1);
        });

        $('#travel-filter-period, #travel-filter-status, #travel-filter-category, #travel-filter-limit').on('change', function () {
            update_travel_filter_btn();
            load_upcoming_travel_arrangements(1);
        });

        $('#travel-arrangement-tabs').on('click', 'a', function (e) {
            e.preventDefault();
            $('#travel-arrangement-tabs li').removeClass('active');
            $(this).parent().addClass('active');

            var tab = $(this).data('travel-tab');
            if (tab === 'eta') {
                $('#travel-tab-eta').show();
                $('#travel-tab-non_eta').hide();
            } else {
                $('#travel-tab-eta').hide();
                $('#travel-tab-non_eta').show();
                load_upcoming_travel_arrangements_non_eta(1);
            }
        });

        function load_upcoming_travel_arrangements_non_eta(page) {
            page = page || 1;
            var limit = $('#travel-non-eta-filter-limit').val() || 10;
            var program = $('#travel-non-eta-filter-program').val() || '';
            var period = $('#travel-non-eta-filter-program option:selected').data('period') || '';
            var status = $('#travel-non-eta-filter-status').val() || '';
            var category = $('#travel-non-eta-filter-category').val() || '';

            $.ajax({
                url: '<?php echo site_url("admin/dashboard/get_upcoming_travel_arrangements_non_eta") ?>',
                type: 'GET',
                data: {
                    page: page,
                    limit: limit,
                    program: program,
                    period: period,
                    status: status,
                    category: category
                },
                dataType: 'json',
                beforeSend: function () {
                    $('#travel-non-eta-table-row').hide();
                    $('#travel-non-eta-pagination-row').hide();
                    $('#no-data-alert-travel-non-eta').hide();
                    $('#loading-alert-travel-non-eta').show();
                },
                success: function (response) {
                    var tbody = $('#travel-non-eta-table tbody');
                    tbody.empty();

                    if (response && response.data && response.data.length > 0) {
                        $.each(response.data, function (index, travel) {
                            var url_note = '<?php echo site_url('admin/notes/get_list_ajax/non_eta_travel/'); ?>' + travel.grantee_grant_id + '/' + travel.id;
                            var status_html = travel.status_html || '';
                            var detail_url = '<?php echo site_url("admin/travel_arrangement_non_eta/view/"); ?>' + travel.id;
                            var detail_btn = '<a class="btn btn-primary btn-sm" href="' + detail_url + '" target="_blank">Detail</a>';
                            var chat_btn = '<a href="#" data-grantname="' + (travel.program_name || '') + '" data-period="' + (travel.period || '') + '" data-name="' + (travel.fullname || '') + '" data-category="' + (travel.category || '') + '" data-id="" data-ajax_url="' + url_note + '" class="open-offcanvas-note btn btn-xs btn-warning btn-chat">' +
                                                '<i class="fa fa-comments"></i> Chat ' +
                                                '<span class="span-note-travel note-total-' + travel.id + '" data-total="' + (travel.total_notes || '') + '">' +
                                                    '<span class="badge">' + (travel.total_notes || '') + '</span>' +
                                                '</span>' +
                                            '</a>';

                            var program_display = travel.program_name || '-';
                            if (travel.period) {
                                program_display += ' - ' + travel.period;
                            }

                            var row = '<tr>' +
                                '<td>' + program_display + '</td>' +
                                '<td>' + (travel.fullname || '-') + '</td>' +
                                '<td>' + (travel.category || '-') + '</td>' +
                                '<td>' + status_html + '</td>' +
                                '<td>' + chat_btn + '</td>' +
                                '<td class="text-right">' + detail_btn + '</td>' +
                                '</tr>';
                            tbody.append(row);
                        });

                        if (tbody.find('tr').length > 0) {
                            $('#travel-non-eta-table-row').show();
                            $('#no-data-alert-travel-non-eta').hide();
                        } else {
                            $('#travel-non-eta-table-row').hide();
                            $('#no-data-alert-travel-non-eta').show();
                        }
                    } else {
                        $('#travel-non-eta-table-row').hide();
                        $('#no-data-alert-travel-non-eta').show();
                    }

                    render_travel_pagination_non_eta(response);
                    $('#travel-non-eta-pagination-row').show();

                    $('#loading-alert-travel-non-eta').hide();
                },
                error: function () {
                    $('#loading-alert-travel-non-eta').hide();
                    $('#travel-non-eta-table-row').hide();
                    $('#travel-non-eta-pagination-row').hide();
                    $('#no-data-alert-travel-non-eta').show();
                }
            });
        }

        function render_travel_pagination_non_eta(response) {
            var total = response.total || 0;
            var page = response.page || 1;
            var limit = response.limit || 10;
            var total_pages = Math.ceil(total / limit);

            var start_row = total > 0 ? ((page - 1) * limit) + 1 : 0;
            var end_row = Math.min(page * limit, total);

            $('#travel-non-eta-page-info').text('Showing ' + start_row + ' to ' + end_row + ' of ' + total + ' entries');

            if (total_pages <= 1) {
                $('#travel-non-eta-pagination').html('');
                return;
            }

            var html = '<ul class="pagination">';
            html += '<li class="' + (page <= 1 ? 'disabled' : '') + '"><a href="#" data-page="' + (page - 1) + '">&laquo;</a></li>';
            for (var p = 1; p <= total_pages; p++) {
                html += '<li class="' + (p === page ? 'active' : '') + '"><a href="#" data-page="' + p + '">' + p + '</a></li>';
            }
            html += '<li class="' + (page >= total_pages ? 'disabled' : '') + '"><a href="#" data-page="' + (page + 1) + '">&raquo;</a></li>';
            html += '</ul>';

            $('#travel-non-eta-pagination').html(html);
        }

        $(document).on('click', '#travel-non-eta-pagination a', function (e) {
            e.preventDefault();
            if ($(this).parent().hasClass('disabled')) {
                return;
            }
            load_upcoming_travel_arrangements_non_eta($(this).data('page'));
        });

        $('#travel-non-eta-filter-limit').on('change', function () {
            load_upcoming_travel_arrangements_non_eta(1);
        });

        $(document).on('click', '#travel-non-eta-filter-btn', function (e) {
            e.preventDefault();
            if ($(this).attr('data-reset') === '1') {
                $('#travel-non-eta-filter-program, #travel-non-eta-filter-status, #travel-non-eta-filter-category').val('');
                update_travel_filter_btn_non_eta();
            }
            load_upcoming_travel_arrangements_non_eta(1);
        });

        $('#travel-non-eta-filter-program, #travel-non-eta-filter-status, #travel-non-eta-filter-category').on('change', function () {
            update_travel_filter_btn_non_eta();
            load_upcoming_travel_arrangements_non_eta(1);
        });

        function load_grantee_leaves(page) {
            page = page || 1;
            var fiscal_year = $('#leave-filter-fiscal-year').val() || '';
            var program = $('#leave-filter-program').val() || '';
            var category = $('#leave-filter-category').val() || '';
            var status = $('#leave-filter-status').val();
            if (status === null || status === undefined) {
                status = '';
            }
            var keyword = ($('#leave-filter-keyword').val() || '').trim();
            var limit = $('#leave-filter-limit').val() || 10;

            $.ajax({
                url: '<?php echo site_url("admin/dashboard/get_grantee_leaves") ?>',
                type: 'GET',
                data: {
                    page: page,
                    limit: limit,
                    fiscal_year: fiscal_year,
                    program: program,
                    leave_category: category,
                    status: status,
                    q: keyword
                },
                dataType: 'json',
                beforeSend: function () {
                    $('#leave-table-row').hide();
                    $('#leave-pagination-row').hide();
                    $('#no-data-alert-leave').hide();
                    $('#loading-alert-leave').show();
                },
                success: function (response) {
                    var tbody = $('#leave-table tbody');
                    tbody.empty();

                    if (response && response.data && response.data.length > 0) {
                        $.each(response.data, function (index, leave) {
                            var name_link = '<a target="_blank" href="' + (leave.edit_url || '#') + '" class="text-primary" style="cursor: pointer;" title="' + (leave.remaining_leave || '') + '">' + (leave.full_name || '-') + '</a>';
                            var action_btn = '<a href="' + (leave.detail_url || '#') + '" target="_blank" class="btn btn-primary btn-xs mb-2" style="margin-right: 4px;">Action</a>' +
                                '<input data-log="' + leave.id + '" data-toggle="modal" data-target="#modal-payment-log" type="button" class="btn-xs btn btn-default modal-log-leave" value="Open Log" style="font-size:12px;">';

                            var row = '<tr>' +
                                '<td class="text-center">' + leave.no + '</td>' +
                                '<td>' + name_link + '</td>' +
                                '<td>' + (leave.grant_name || '-') + '</td>' +
                                '<td>' + (leave.fiscal_year || '-') + '</td>' +
                                '<td>' + (leave.leave_category || '-') + '</td>' +
                                '<td>' + (leave.total_request ? leave.total_request + ' Day' : '-') + '</td>' +
                                '<td>' + (leave.start_date || '-') + '</td>' +
                                '<td>' + (leave.end_date || '-') + '</td>' +
                                '<td>' + (leave.created_at || '-') + '</td>' +
                                '<td>' + (leave.status_label || '-') + '</td>' +
                                '<td class="text-center" style="white-space:nowrap;">' + action_btn + '</td>' +
                                '</tr>';
                            tbody.append(row);
                        });

                        if (tbody.find('tr').length > 0) {
                            $('#leave-table-row').show();
                            $('#no-data-alert-leave').hide();
                        } else {
                            $('#leave-table-row').hide();
                            $('#no-data-alert-leave').show();
                        }
                    } else {
                        $('#leave-table-row').hide();
                        $('#no-data-alert-leave').show();
                    }

                    render_leave_pagination(response);
                    $('#leave-pagination-row').show();
                    $('#loading-alert-leave').hide();
                },
                error: function () {
                    $('#loading-alert-leave').hide();
                    $('#leave-table-row').hide();
                    $('#leave-pagination-row').hide();
                    $('#no-data-alert-leave').show();
                }
            });
        }

        function render_leave_pagination(response) {
            var total = response.total || 0;
            var page = response.page || 1;
            var limit = response.limit || 10;
            var total_pages = Math.ceil(total / limit);

            var start_row = total > 0 ? ((page - 1) * limit) + 1 : 0;
            var end_row = Math.min(page * limit, total);

            $('#leave-page-info').text('Showing ' + start_row + ' to ' + end_row + ' of ' + total + ' entries');

            if (total_pages <= 1) {
                $('#leave-pagination').html('');
                return;
            }

            var html = '<ul class="pagination">';
            html += '<li class="' + (page <= 1 ? 'disabled' : '') + '"><a href="#" data-page="' + (page - 1) + '">&laquo;</a></li>';
            for (var p = 1; p <= total_pages; p++) {
                html += '<li class="' + (p === page ? 'active' : '') + '"><a href="#" data-page="' + p + '">' + p + '</a></li>';
            }
            html += '<li class="' + (page >= total_pages ? 'disabled' : '') + '"><a href="#" data-page="' + (page + 1) + '">&raquo;</a></li>';
            html += '</ul>';

            $('#leave-pagination').html(html);
        }

        $(document).on('click', '#leave-pagination a', function (e) {
            e.preventDefault();
            if ($(this).parent().hasClass('disabled')) {
                return;
            }
            load_grantee_leaves($(this).data('page'));
        });

        function update_leave_filter_btn() {
            var active = false;
            ['#leave-filter-fiscal-year', '#leave-filter-program', '#leave-filter-category', '#leave-filter-status'].forEach(function (sel) {
                var v = $(sel).val();
                if (v !== '' && v !== null && v !== undefined) {
                    active = true;
                }
            });
            if (($('#leave-filter-keyword').val() || '').trim() !== '') {
                active = true;
            }
            var $btn = $('#leave-filter-btn');
            if (active) {
                $btn.text('Reset Filter').attr('data-reset', '1');
            } else {
                $btn.text('Filter').attr('data-reset', '0');
            }
        }

        update_leave_filter_btn();

        $(document).on('change', '#leave-filter-fiscal-year, #leave-filter-program, #leave-filter-category, #leave-filter-status', function () {
            update_leave_filter_btn();
        });

        $(document).on('input', '#leave-filter-keyword', function () {
            update_leave_filter_btn();
        });

        $(document).on('change', '#leave-filter-fiscal-year', function () {
            var fy = $(this).val();
            $.ajax({
                url: '<?php echo site_url("admin/dashboard/get_leave_grants") ?>',
                type: 'GET',
                data: { fiscal_year: fy },
                dataType: 'json',
                success: function (res) {
                    var $prog = $('#leave-filter-program');
                    $prog.empty();
                    $prog.append('<option value="">All Grants</option>');
                    if (res && res.data) {
                        $.each(res.data, function (i, g) {
                            $prog.append('<option value="' + g.id + '">' + g.name + '</option>');
                        });
                    }
                }
            });
        });

        $(document).on('click', '#leave-filter-btn', function (e) {
            e.preventDefault();
            if ($(this).attr('data-reset') === '1') {
                $('#leave-filter-fiscal-year').val('');
                $('#leave-filter-category').val('');
                $('#leave-filter-status').val('');
                $('#leave-filter-keyword').val('');
                $('#leave-filter-fiscal-year').trigger('change');
                $(this).text('Filter').attr('data-reset', '0');
            }
            load_grantee_leaves(1);
        });

        $(document).on('keypress', '#leave-filter-keyword', function (e) {
            if (e.which === 13) {
                e.preventDefault();
                update_leave_filter_btn();
                load_grantee_leaves(1);
            }
        });

        $('#leave-filter-limit').on('change', function () {
            load_grantee_leaves(1);
        });

        $(document).on('click', '.modal-log-leave', function (e) {
            var data_id = $(this).data('log');
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url("admin/travel_request/get_log_leave") ?>',
                dataType: 'JSON',
                data: {
                    id: data_id,
                    table: 'am_grantee_leaves'
                },
                success: function (r) {
                    $("#model-payment-log tbody").html("");
                    if (r.status) {
                        for (let i = 0; i < r.data.length; i++) {
                            var checkData = null;
                            try {
                                checkData = JSON.parse(r.data[i].old_values);
                            } catch (err) {}
                            if (checkData && checkData.hasOwnProperty('revise_from')) {
                                // skip
                            } else {
                                var action = (r.data[i].old_values != null || r.data[i].new_values != null)
                                    ? "<a data-old_data='" + JSON.stringify(r.data[i].old_values).replace(/'/g, "&apos;").replace(/"/g, "&quot;") + "' data-new_data='" + JSON.stringify(r.data[i].new_values).replace(/'/g, "&apos;").replace(/"/g, "&quot;") + "' class='btn btn-primary btn-xs view-detail-log'><i class='fa fa-eye'></i> View Detail</a>"
                                    : '';

                                var created_at = "<td>" + r.data[i].created_at + "</td>";
                                var event = "<td>" + r.data[i].event + "</td>";
                                var created_by = "<td>" + r.data[i].created_name + "</td>";
                                var pAction = "<td>" + action + "</td>";

                                $("#model-payment-log tbody").append('<tr>' + created_at + event + created_by + pAction + '</tr>');
                            }
                        }
                    }
                }
            });
        });

        $(document).on('click', '.view-detail-log', function (e) {
            let element = $(this);
            let old_data = null;
            let new_data = null;
            try {
                old_data = JSON.parse(element.data('old_data'));
                new_data = JSON.parse(element.data('new_data'));
                if (typeof old_data === 'string') old_data = JSON.parse(old_data);
                if (typeof new_data === 'string') new_data = JSON.parse(new_data);
            } catch (err) {}

            function formatText(str) {
                if (!str) return '';
                return str.replace(/_/g, ' ').replace(/\b\w/g, function (l) { return l.toUpperCase(); });
            }

            var SITE_URL = '<?php echo site_url(); ?>';

            let element_old_data = '';
            if (old_data != null) {
                element_old_data += '<table class="table table-striped">';
                $.each(old_data, function (key, value) {
                    if (key == 'form_upload' && value != '') {
                        value = '<a href="' + SITE_URL + value + '" class="lightbox btn btn-primary btn-xs">View</a>';
                    }
                    if (key == 'status') {
                        if (value == 0) value = 'PENDING';
                        else if (value == 1) value = 'APPROVE';
                        else if (value == 2) value = 'REJECT';
                        else if (value == 3) value = 'CANCEL';
                    }
                    if (key == 'leave_category') {
                        if (value == 1) value = 'Personal Travel';
                        else if (value == 2) value = 'Sick Leave';
                        else if (value == 3) value = 'Emergency Leave';
                        else if (value == 4) value = 'International Research Travel';
                    }
                    if (key == 'grantee_grant_id') return true;

                    element_old_data += '<tr>';
                    element_old_data += '<td class="text-left" width="35%">' + formatText(key) + '</td>';
                    element_old_data += '<td class="text-left">: ' + (value !== null && value !== undefined ? value : '') + '</td>';
                    element_old_data += '</tr>';
                });
                element_old_data += '</table>';
            }

            let element_new_data = '';
            if (new_data != null) {
                element_new_data += '<table class="table table-striped">';
                $.each(new_data, function (key, value) {
                    if (key == 'form_upload' && value != '') {
                        value = '<a href="' + SITE_URL + value + '" class="lightbox btn btn-primary btn-xs">View</a>';
                    }
                    if (key == 'status') {
                        if (value == 0) value = 'PENDING';
                        else if (value == 1) value = 'APPROVE';
                        else if (value == 2) value = 'REJECT';
                        else if (value == 3) value = 'CANCEL';
                    }
                    if (key == 'leave_category') {
                        if (value == 1) value = 'Personal Travel';
                        else if (value == 2) value = 'Sick Leave';
                        else if (value == 3) value = 'Emergency Leave';
                        else if (value == 4) value = 'International Research Travel';
                    }
                    if (key == 'grantee_grant_id') return true;

                    element_new_data += '<tr>';
                    element_new_data += '<td class="text-left" width="35%">' + formatText(key) + '</td>';
                    element_new_data += '<td class="text-left">: ' + (value !== null && value !== undefined ? value : '') + '</td>';
                    element_new_data += '</tr>';
                });
                element_new_data += '</table>';
            }

            $("#old-data").html(element_old_data);
            $("#new-data").html(element_new_data);
            $("#modal-payment-log").modal('hide');
            $("#mdl_detail_log").modal('show');
            if (typeof $.fn.topbox === 'function') {
                $('.lightbox').topbox();
            }
        });

    });

</script>

<script>
    function navigate_tab(step_id) {
        var $modal = $('#submission-detail-modal');
        if ($modal.length) {
            $modal.find('.tabs ul li').removeClass('active');
            $modal.find('.tabs ul li a[href="#step_' + step_id + '"]').parent('li').addClass('active');
            $modal.find('.tab-pane').removeClass('active in');
            $modal.find('#step_' + step_id).addClass('active in');
        }
    }

    function accept_submission_document_modal(user_id, grantee_grant_id, grant_id, category_id, status_url, document) {
        show_note_modal('Verify Document', 'Are you sure this document is verified?', function (note) {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('') ?>' + status_url + '/accept_submission_document',
                data: {
                    note: note || '',
                    user_id: user_id,
                    grantee_grant_id: grantee_grant_id,
                    grant_id: grant_id,
                    document: document,
                    category_id: category_id
                },
                dataType: 'json',
                success: function (r) {
                    if (r && r.err_message == false) {
                        alert('Document verified successfully');
                        location.reload();
                    } else {
                        alert('Error: ' + (r && r.err_message ? r.err_message : 'Failed to verify document'));
                    }
                },
                error: function (xhr, status, error) {
                    var error_msg = 'Error verifying document';
                    try {
                        var response = JSON.parse(xhr.responseText);
                        if (response && response.err_message) {
                            error_msg = response.err_message;
                        }
                    } catch (e) {
                        error_msg = error || 'Unknown error occurred';
                    }
                    alert(error_msg);
                }
            });
        });
    }

    function revise_submission_document_modal(user_id, grantee_grant_id, grant_id, category_id, status_url, document) {
        show_note_modal('Revise Document', 'Are you sure you want to revise this document?', function (note) {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('') ?>' + status_url + '/revise_submission_document',
                data: {
                    note: note || '',
                    user_id: user_id,
                    grantee_grant_id: grantee_grant_id,
                    grant_id: grant_id,
                    document: document,
                    category_id: category_id
                },
                dataType: 'json',
                success: function (r) {
                    if (r && r.err_message == false) {
                        alert('Document revised successfully');
                        location.reload();
                    } else {
                        alert('Error: ' + (r && r.err_message ? r.err_message : 'Failed to revise document'));
                    }
                },
                error: function (xhr, status, error) {
                    var error_msg = 'Error revising document';
                    try {
                        var response = JSON.parse(xhr.responseText);
                        if (response && response.err_message) {
                            error_msg = response.err_message;
                        }
                    } catch (e) {
                        error_msg = error || 'Unknown error occurred';
                    }
                    alert(error_msg);
                }
            });
        });
    }

    function withdraw_submission_document_modal(user_id, grantee_grant_id, grant_id, category_id, status_url, document) {
        show_note_modal('Withdraw Document', 'Are you sure you want to withdraw this document?', function (note) {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('') ?>' + status_url + '/withdraw_submission_document',
                data: {
                    note: note || '',
                    user_id: user_id,
                    grantee_grant_id: grantee_grant_id,
                    grant_id: grant_id,
                    document: document,
                    category_id: category_id
                },
                dataType: 'json',
                success: function (r) {
                    if (r && r.err_message == false) {
                        alert('Document withdrawn successfully');
                        location.reload();
                    } else {
                        alert('Error: ' + (r && r.err_message ? r.err_message : 'Failed to withdraw document'));
                    }
                },
                error: function (xhr, status, error) {
                    var error_msg = 'Error withdrawing document';
                    try {
                        var response = JSON.parse(xhr.responseText);
                        if (response && response.err_message) {
                            error_msg = response.err_message;
                        }
                    } catch (e) {
                        error_msg = error || 'Unknown error occurred';
                    }
                    alert(error_msg);
                }
            });
        });
    }

    function show_note_modal(title, message, callback) {
        // Remove existing modal if any
        $('#note-action-modal').remove();

        var modal_html = '<div class="modal fade" id="note-action-modal" tabindex="-1" role="dialog">' +
            '<div class="modal-dialog" role="document">' +
            '<div class="modal-content">' +
            '<div class="modal-header">' +
            '<button type="button" class="close" data-dismiss="modal">&times;</button>' +
            '<h4 class="modal-title">' + title + '</h4>' +
            '</div>' +
            '<div class="modal-body">' +
            '<p>' + message + '</p>' +
            '<div class="form-group">' +
            '<label for="note-input">Note (optional):</label>' +
            '<textarea class="form-control" id="note-input" rows="4" placeholder="Enter note here..."></textarea>' +
            '</div>' +
            '</div>' +
            '<div class="modal-footer">' +
            '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>' +
            '<button type="button" class="btn btn-primary" id="confirm-action-btn">Confirm</button>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';

        $('body').append(modal_html);

        $('#note-action-modal').modal('show');

        $('#confirm-action-btn').on('click', function () {
            var note = $('#note-input').val();
            $('#note-action-modal').modal('hide');
            if (callback) {
                callback(note);
            }
        });

        $('#note-action-modal').on('hidden.bs.modal', function () {
            $(this).remove();
        });
    }

    function permit_reject_submission_document_modal(user_id, grantee_grant_id, grant_id, category_id, status_url) {
        if (confirm("Are you sure want to Reject Permit this ?")) {
            var note = $('#note_document').val();
            var document = $('#document_modal').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('') ?>' + status_url + '/permit_reject_submission_document',
                data: {
                    note: note,
                    user_id: user_id,
                    grantee_grant_id: grantee_grant_id,
                    grant_id: grant_id,
                    document: document,
                    category_id: category_id
                },
                success: function (r) {
                    if (r.err_message == false) {
                        $('#submission-detail-modal').modal('hide');
                        location.reload();
                    }
                }
            });
        }
    }

    function arrived_submission_document_modal(user_id, grantee_grant_id, grant_id, category_id, status_url) {
        if (confirm("Are you sure want to mark as Arrived this ?")) {
            var note = $('#note_document').val();
            var document = $('#document_modal').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('') ?>' + status_url + '/arrived_submission_document',
                data: {
                    note: note,
                    user_id: user_id,
                    grantee_grant_id: grantee_grant_id,
                    grant_id: grant_id,
                    document: document,
                    category_id: category_id
                },
                success: function (r) {
                    if (r.err_message == false) {
                        $('#submission-detail-modal').modal('hide');
                        location.reload();
                    }
                }
            });
        }
    }
</script>