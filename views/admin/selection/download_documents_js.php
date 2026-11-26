<script src="<?php echo base_url() ?>js/sweet-alert.min.js?v=<?=VERSION?>"></script>
<script>
    $(document).ready(function(){
        const check_all = $("#select-all-applicant");
        const select_program = $("#program");
        const select_period = $("#period");
        const download_button = $("#download-documents");
        const progress_dialog = $("#progress-dialog");
        const search_input = $("#search-data");
        const entries_select = $("#entries-per-page");

        var all_user = [];
        var filtered_user = [];
        var current_page = 1;
        var per_page = 10;
        var selected_users = {};

        function render_table() {
            const table_body = $("tbody.applicant-list");
            const total_entries = filtered_user.length;

            if (total_entries === 0) {
                const msg = (all_user.length === 0) ? 'Please select program' : 'No matching records found';
                table_body.html('<tr><td width="100%" colspan="5" class="text-center">' + msg + '</td></tr>');
                check_all.prop('disabled', true);
                check_all.prop('checked', false);
                $(".pagination-section").addClass('hide');
                show_download_button();
                return;
            }

            const items_per_page = (per_page === -1) ? total_entries : per_page;
            const total_pages = Math.ceil(total_entries / items_per_page) || 1;

            if (current_page > total_pages) current_page = total_pages;
            if (current_page < 1) current_page = 1;

            const start_index = (current_page - 1) * items_per_page;
            const end_index = Math.min(start_index + items_per_page, total_entries);
            const page_items = filtered_user.slice(start_index, end_index);

            let table_rows = '';
            let all_page_checked = page_items.length > 0;

            for (let i = 0; i < page_items.length; i++) {
                const item = page_items[i];
                const is_checked = !!selected_users[item.user_grantee_id];
                if (!is_checked) {
                    all_page_checked = false;
                }

                const url_params = {
                    user_grantee_id: item.user_grantee_id,
                    category_id: item.category_id,
                    grants_id: item.grants_id,
                    country_id: item.country_id,
                    grantee_id: item.grantee_id,
                    grantee_grant_id: item.grantee_grant_id,
                    period_id: item.period_id,
                };

                const query_params = new URLSearchParams(url_params);
                const query_string = query_params.toString();

                table_rows += '<tr>';
                    table_rows += '<td>';
                        table_rows += '<input data-program_name="' + (item.program_name || '') +'" data-user_grantee_id="' + item.user_grantee_id +'" data-category_id="' + (item.category_id || '') +'" data-grants_id="' + item.grants_id +'" data-country_id="' + (item.country_id || '') +'" data-grantee_id="' + (item.grantee_id || '') +'" data-grantee_grant_id="' + (item.grantee_grant_id || '') + '" class="checkbox-applicant" type="checkbox" ' + (is_checked ? 'checked' : '') + '/>';
                    table_rows += '</td>';
                    
                    table_rows += '<td>';
                        table_rows += item.full_name || '-';
                    table_rows += '</td>';

                    table_rows += '<td>';
                        table_rows += item.submission_date || '-';
                    table_rows += '</td>';
                    
                    table_rows += '<td>';
                        table_rows += item.period || '-';
                    table_rows += '</td>';

                    table_rows += '<td width="10%" class="text-right">';
                        table_rows += '<a href="<?php echo site_url('document/download_documents/'); ?>'+ item.user_grantee_id +'/'+ item.grants_id +'?' + query_string +'" class="btn btn-primary download-single-document" href="#">Download</a>';
                    table_rows += '</td>';
                table_rows += '</tr>';
            }

            table_body.html(table_rows);

            check_all.prop('disabled', false);
            check_all.prop('checked', all_page_checked);

            $("#page-start").text(total_entries > 0 ? (start_index + 1) : 0);
            $("#page-end").text(end_index);
            $("#total-entries").text(total_entries);
            $(".pagination-section").removeClass('hide');

            render_pagination(current_page, total_pages);
            show_download_button();
        }

        function render_pagination(page, total_pages) {
            if (total_pages <= 1) {
                $("#pagination-controls").html('');
                return;
            }

            let pagination_html = '<ul class="pagination pagination-sm m-0">';

            if (page === 1) {
                pagination_html += '<li class="disabled"><span>&laquo; Previous</span></li>';
            } else {
                pagination_html += '<li><a href="#" class="page-link" data-page="' + (page - 1) + '">&laquo; Previous</a></li>';
            }

            let start_page = Math.max(1, page - 2);
            let end_page = Math.min(total_pages, page + 2);

            if (start_page > 1) {
                pagination_html += '<li><a href="#" class="page-link" data-page="1">1</a></li>';
                if (start_page > 2) {
                    pagination_html += '<li class="disabled"><span>...</span></li>';
                }
            }

            for (let p = start_page; p <= end_page; p++) {
                if (p === page) {
                    pagination_html += '<li class="active"><span>' + p + ' <span class="sr-only">(current)</span></span></li>';
                } else {
                    pagination_html += '<li><a href="#" class="page-link" data-page="' + p + '">' + p + '</a></li>';
                }
            }

            if (end_page < total_pages) {
                if (end_page < total_pages - 1) {
                    pagination_html += '<li class="disabled"><span>...</span></li>';
                }
                pagination_html += '<li><a href="#" class="page-link" data-page="' + total_pages + '">' + total_pages + '</a></li>';
            }

            if (page === total_pages) {
                pagination_html += '<li class="disabled"><span>Next &raquo;</span></li>';
            } else {
                pagination_html += '<li><a href="#" class="page-link" data-page="' + (page + 1) + '">Next &raquo;</a></li>';
            }

            pagination_html += '</ul>';
            $("#pagination-controls").html(pagination_html);
        }

        $(document).on('click', '#pagination-controls a.page-link', function(e){
            e.preventDefault();
            let target_page = parseInt($(this).data('page'));
            if (target_page && target_page !== current_page) {
                current_page = target_page;
                render_table();
            }
        });

        select_program.on('change', function(){
            let program_id = $(this).val();
            search_input.val('');
            selected_users = {};
            current_page = 1;

            if (!program_id) {
                all_user = [];
                filtered_user = [];
                select_period.html('<option value="">Select Period</option>');
                $(".search-filter-section").addClass('hide');
                $(".pagination-section").addClass('hide');
                check_all.prop('disabled', true);
                check_all.prop('checked', false);
                $("tbody.applicant-list").html('<tr><td width="100%" colspan="5" class="text-center">Please select program</td></tr>');
                show_download_button();
                return;
            }

            $.ajax({
                url : '<?php echo site_url('admin/selection/get_user_by_program/'); ?>' + program_id,
                type : 'GET',
                dataType : 'JSON',
                success : function(r) {
                    let response = r.data_grantee;
                    if (response && response.length > 0) {
                        all_user = response;
                        filtered_user = response;
                        $(".search-filter-section").removeClass('hide');
                        render_table();
                    } else {
                        all_user = [];
                        filtered_user = [];
                        $(".search-filter-section").addClass('hide');
                        $(".pagination-section").addClass('hide');
                        check_all.prop('disabled', true);
                        check_all.prop('checked', false);
                        $("tbody.applicant-list").html('<tr><td width="100%" colspan="5" class="text-center">Please select program</td></tr>');
                        show_download_button();
                    }

                    select_period.html('');
                    select_period.append('<option value="">Select Period</option>');
                    if (r.periods) {
                        $.each(r.periods, function(id, val) {
                            select_period.append('<option value="' + val.id + '">' + val.fiscal_year + '</option>');
                        });
                    }
                }, error : function (response) {
                    console.error(response);
                    select_period.html('');
                    select_period.append('<option value="">Select Period</option>');
                }
            });
        });

        select_period.on('change', function(){
            let program_id = select_program.val();
            let period_id = $(this).val();
            search_input.val('');
            selected_users = {};
            current_page = 1;

            if (!program_id) {
                return;
            }

            let url = '<?php echo site_url('admin/selection/get_user_by_program/'); ?>' + program_id;
            if (period_id) {
                url += '/' + period_id;
            }

            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                success : function(r) {
                    let response = r.data_grantee;
                    if (response && response.length > 0) {
                        all_user = response;
                        filtered_user = response;
                        $(".search-filter-section").removeClass('hide');
                        render_table();
                    } else {
                        all_user = [];
                        filtered_user = [];
                        $(".search-filter-section").addClass('hide');
                        $(".pagination-section").addClass('hide');
                        check_all.prop('disabled', true);
                        check_all.prop('checked', false);
                        $("tbody.applicant-list").html('<tr><td width="100%" colspan="5" class="text-center">Please select Period</td></tr>');
                        show_download_button();
                    }
                }, error : function (response) {
                    console.error(response);
                }
            });
        });

        search_input.on('input', function(){
            let search_value = $(this).val();
            if (search_value && search_value.trim() !== '') {
                filtered_user = search_data(search_value);
            } else {
                filtered_user = all_user;
            }
            current_page = 1;
            render_table();
        });

        entries_select.on('change', function(){
            let val = $(this).val();
            if (val === 'all') {
                per_page = -1;
            } else {
                per_page = parseInt(val, 10);
            }
            current_page = 1;
            render_table();
        });

        check_all.on('click', function(){
            let is_checked = $(this).prop('checked');
            let visible_checkboxes = $("tbody.applicant-list .checkbox-applicant");
            visible_checkboxes.each(function(){
                let user_grantee_id = $(this).data('user_grantee_id');
                $(this).prop('checked', is_checked);
                if (is_checked) {
                    let found = all_user.find(u => u.user_grantee_id == user_grantee_id);
                    if (found) {
                        selected_users[user_grantee_id] = found;
                    }
                } else {
                    delete selected_users[user_grantee_id];
                }
            });

            show_download_button();
        });

        $(document).on('change', '.checkbox-applicant', function(){
            let user_grantee_id = $(this).data('user_grantee_id');
            let is_checked = $(this).prop('checked');
            if (is_checked) {
                let found = all_user.find(u => u.user_grantee_id == user_grantee_id);
                if (found) {
                    selected_users[user_grantee_id] = found;
                }
            } else {
                delete selected_users[user_grantee_id];
            }

            let all_page_checked = true;
            let visible_checkboxes = $("tbody.applicant-list .checkbox-applicant");
            if (visible_checkboxes.length > 0) {
                visible_checkboxes.each(function(){
                    if (!$(this).prop('checked')) {
                        all_page_checked = false;
                    }
                });
                check_all.prop('checked', all_page_checked);
            }

            show_download_button();
        });

        download_button.on('click', function(e){
            e.preventDefault();
            
            $(this).prop('disabled', true);
            $(this).text("Downloading...");
            
            const button_download_single_document = $(document).find('.download-single-document');

            button_download_single_document.addClass('disabled');
            progress_dialog.modal('show');
            let users_grantee_data = [];
            
            let hide_personal_information = $("#checbox-hide-personal-info").prop('checked');
            for (let id in selected_users) {
                let item = selected_users[id];
                let new_data = {
                    program_name : item.program_name,
                    user_grantee_id : item.user_grantee_id,
                    category_id : item.category_id,
                    grants_id : item.grants_id,
                    country_id : item.country_id,
                    grantee_id : item.grantee_id,
                    grantee_grant_id : item.grantee_grant_id,
                    hide_personal_information : hide_personal_information ? 1 : 0
                };
                users_grantee_data.push(new_data);
            }

            if (users_grantee_data.length === 0) {
                progress_dialog.modal('hide');
                download_button.prop('disabled', false);
                download_button.text("Download Selected");
                alert("Please select applicant before click download");
                return false;
            }
            
            $.post('<?php echo site_url('document/download_user_grantee_documents/'); ?>', { data : users_grantee_data }, function(response) {
                let file = JSON.parse(response);
                download_button.prop('disabled', false);
                download_button.text("Download Selected");
                check_all.prop("checked", false);
                button_download_single_document.removeClass('disabled');
                selected_users = {};
                $(document).find('.checkbox-applicant').prop("checked", false);

                var link = document.createElement('a');
                link.href = file.fileurl;
                link.download = file.filename;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                progress_dialog.modal('hide');
                show_download_button();
            }).fail(function(error) {
                download_button.prop('disabled', false);
                download_button.text("Download Selected");
                button_download_single_document.removeClass('disabled');
                progress_dialog.modal('hide');
                show_download_button();
                console.error(error);
            });
        });

        $(document).on('click', '.download-single-document', function(e){
            e.preventDefault();
            progress_dialog.modal('show');
            let url = $(this).attr('href');
            let hide_personal_information = $("#checbox-hide-personal-info").prop('checked');
            if (hide_personal_information) {
                url += '&hide_personal_information=1';
            }
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'JSON',
                success : function(response) {
                    var link = document.createElement('a');
                    link.href = response.fileurl;
                    link.download = response.filename;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    progress_dialog.modal('hide');
                }, error : function(response) {
                    progress_dialog.modal('hide');
                   
                    Swal.fire({
                        title: "Failed to download the document",
                        text: response.responseText,
                        icon: "warning",
                        customClass: 'swal-custom'
                    });
                }
            });
        });

        function show_download_button()
        {
            let count = Object.keys(selected_users).length;
            if (count > 0) {
                download_button.removeClass('hide');
            } else {
                download_button.addClass('hide');
            }
        }

        function search_data(search_value) {
            const q = search_value.toLowerCase().trim();
            if (!q) return all_user;
            return all_user.filter(item => {
                let first_name = (item.first_name || '').toLowerCase();
                let middle_name = (item.middle_name || '').toLowerCase();
                let last_name = (item.last_name || '').toLowerCase();
                let full_name = (item.full_name || '').toLowerCase();
                let combined = `${first_name} ${middle_name} ${last_name}`.trim();
                let period = (item.period !== null && item.period !== undefined ? String(item.period) : '').toLowerCase();
                let submission_date = (item.submission_date || '').toLowerCase();

                return full_name.includes(q) ||
                       first_name.includes(q) ||
                       middle_name.includes(q) ||
                       last_name.includes(q) ||
                       combined.includes(q) ||
                       period.includes(q) ||
                       submission_date.includes(q);
            });
        }
    });
</script>