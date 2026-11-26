<link rel="stylesheet" href="https://cdn.datatables.net/2.3.8/css/dataTables.dataTables.css" />
<script src="https://cdn.datatables.net/2.3.8/js/dataTables.js"></script>
<style>
    /* Modern status badges */
    .status-badge {
        display: inline-block;
        padding: 4px 10px;
        font-size: 11px;
        font-weight: 600;
        border-radius: 30px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-align: center;
        white-space: nowrap;
    }
    .status-active { background-color: #e3f2fd; color: #0d47a1; }
    .status-pending { background-color: #fff3e0; color: #e65100; }
    .status-danger { background-color: #ffebee; color: #c62828; }
    .status-success { background-color: #e8f5e9; color: #2e7d32; }
    .status-default { background-color: #f5f5f5; color: #616161; }
    
    /* Modern table styling */
    #grantee-stats-table {
        border-collapse: separate;
        border-spacing: 0;
        border: 1px solid #eaedf1;
        border-radius: 8px;
        overflow: hidden;
        width: 100% !important;
    }
    #grantee-stats-table thead th {
        background-color: #f8fafc;
        color: #475569;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
        border-top: none;
        padding: 12px 16px;
    }
    #grantee-stats-table tbody td {
        padding: 12px 16px;
        vertical-align: middle;
        color: #334155;
        border-bottom: 1px solid #e2e8f0;
        font-size: 13px;
    }
    #grantee-stats-table tbody tr:last-child td {
        border-bottom: none;
    }
    #grantee-stats-table tbody tr:hover {
        background-color: #f8fafc;
    }
    #grantee-stats-chart .clickable-cell {
        transition: background-color 0.15s ease;
    }
    #grantee-stats-chart .clickable-cell:hover {
        background-color: #e2e8f0;
        cursor: pointer;
    }
    .fiscal-badge {
        font-weight: 500;
        color: #475569;
        background-color: #f1f5f9;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 12px;
    }

    .dt-length label {
        margin-left: 8px;
    }

    .table-bordered,
    .table-bordered th,
    .table-bordered td {
        border: 2px solid #ddd !important;
    }
</style>
<script>
    var site_url = '<?php echo base_url() ?>';

    function fetchStats(programId, degree) {
        var period = $('select[name="period"]').val() || '';

        var params = {
            program_id: programId,
            period: period
        };
        // if (label) params.label = label;

        $.getJSON(site_url + 'admin/dashboard/ajax_grantee_stats', params, function(resp){
            renderChart(programId, resp.counts, degree);
            
            // Update total count labels/badges
            var formattedTotal = (resp.counts.applicant || 0).toLocaleString('en-US');
            $('#total-count-' + programId).text(formattedTotal);
            // $('#total-badge-' + programId).text(formattedTotal + ' Applicants').show();
            
            if (resp.list) {
                renderList(programId, resp.list);
            }
        });
    }
    
    function renderChart(programId, counts, degree) {
        var data = [];
        var labels = {
            application_submitted: 'Application Submitted',
            application_rejected: 'Application Rejected',
            review_rejected: 'Review Rejected',
            review_passed: 'Review Passed',
            interview_rejected: 'Interview Rejected',
            interview_passed: 'Interview Passed',
            eec: 'EEC',
            eec_alternate: 'EEC Alternate',
            nominee_attrition_p: 'Nominee Principal',
            nominee_attrition_a: 'Nominee Alternate',
            upgrade: 'upgrade',
            nominee_p: 'nominee_p',
            nominee_a: 'nominee_a',
            final_placement: 'final_placement',
            success: 'success',
            unsuccess: 'unsuccess',
            interviewee: 'Interviewee',
            selection_withdraw: 'Selection Withdraw',
            selection_rejected: 'Selection Rejected',
            ffsb: 'FFSB',
            departure: 'Departure',
            ongoing: 'Ongoing',
            returning: 'Returning',
            reject_eec_p: 'Reject EEC',
            reject_eec_a: 'Reject EEC Alternate',
            reject_ffsb_p: 'Reject FFSB',
            reject_ffsb_a: 'Reject FFSB Alternate',
            final_placement_p: 'Final Placement Principal',
            final_placement_a: 'Final Placement Alternate',
        };

        for (var key in labels) {
            data.push({label: labels[key], value: counts[key] || 0, key: key});
        }

        var chartContainer = $('#grantee-stats-chart-' + programId);
        chartContainer.empty();
        
        var countsMap = {};
        data.forEach(function(d){ countsMap[d.key] = d.value; });



        if(degree){
            // EEC
            var chartContainerEec = $('#grantee-stats-eec-' + programId);
            chartContainerEec.empty();
    
            var tableHtmlEec = '<div style="overflow-x:auto"><table class="table table-bordered" id="grantee-eec-grid-' + programId + '">';
            tableHtmlEec += '<thead>';
            tableHtmlEec += '<tr style="background:#013473;color:#fff;font-weight:700;text-align:center">';
            tableHtmlEec += '<th rowspan="2" style="vertical-align: middle; padding:8px;">EEC</th>';
            tableHtmlEec += '<th colspan="2">Attrition</th>';
            tableHtmlEec += '</tr>';
            
            tableHtmlEec += '<tr style="background:#0b3b70;color:#fff;font-weight:600;text-align:center">';
            tableHtmlEec += '<th rowspan="2" style="vertical-align: middle; padding:8px;">Number</th>';
            tableHtmlEec += '<th rowspan="2" style="vertical-align: middle; padding:8px;">Percentage</th>';
            tableHtmlEec += '</tr>';
            tableHtmlEec += '</thead>';
            
            var eec = countsMap['eec'] || 0;
            var reject = countsMap['reject_eec_p'] || 0;

            var cells = [
                { key: 'eec', val: eec, clickable: true },
                { key: 'reject_eec_p', val: reject, clickable: true },
                {
                    key: 'eec_percentage',
                    val: eec > 0 ? Math.ceil((reject / eec) * 100) : 0,
                    clickable: false,
                    isPercentage: true
                },
            ];

            // Data row (numbers)
            tableHtmlEec += '<tbody><tr style="text-align:center;font-weight:700">';
            cells.forEach(function(c){
                var val = (c.val !== undefined && c.val !== null) ? c.val.toLocaleString('en-US') : 0;
                if (c.clickable) {
                    tableHtmlEec += '<td class="clickable-cell" data-key="' + c.key + '" style="padding:10px; cursor:pointer">' + val + '</td>'; 
                } else if (c.isPercentage) {
                    tableHtmlEec += '<td style="padding:10px; background-color:#f1f5f9; color:#0f172a;">' + val + '%</td>'; 
                } else {
                    tableHtmlEec += '<td style="padding:10px; background-color:#fafafa;">' + val + '</td>'; 
                }
            });
    
            tableHtmlEec += '</tr></tbody>';
            tableHtmlEec += '</table></div>';
    
            chartContainerEec.html(tableHtmlEec);
            chartContainerEec.off('click', '.clickable-cell').on('click', '.clickable-cell', function(){
                var key = $(this).data('key');
                if (key) {
                    fetchList(programId, key);
                }
            });

            // FSB
            var chartContainerFsb = $('#grantee-stats-fsb-' + programId);
            chartContainerFsb.empty();
    
            var tableHtmlFsb = '<div style="overflow-x:auto"><table class="table table-bordered" id="grantee-fsb-grid-' + programId + '">';
            tableHtmlFsb += '<thead>';
            tableHtmlFsb += '<tr style="background:#013473;color:#fff;font-weight:700;text-align:right">';
            tableHtmlFsb += '<th rowspan="2" style="vertical-align: middle; padding:8px;">FFSB</th>';
            tableHtmlFsb += '<th colspan="2">Attrition</th>';
            tableHtmlFsb += '<th colspan="2" style="vertical-align: middle; padding:8px;">Placement</th>';
            tableHtmlFsb += '</tr>';
            
            tableHtmlFsb += '<tr style="background:#0b3b70;color:#fff;font-weight:600;text-align:center">';
            tableHtmlFsb += '<th style="vertical-align: middle; padding:8px;">Number</th>';
            tableHtmlFsb += '<th style="vertical-align: middle; padding:8px;">Percentage</th>';
            tableHtmlFsb += '<th style="vertical-align: middle; padding:8px;">Number</th>';
            tableHtmlFsb += '<th style="vertical-align: middle; padding:8px;">Percentage</th>';
            tableHtmlFsb += '</tr>';
            tableHtmlFsb += '</thead>';
            
            var eec = countsMap['eec'] || 0;
            var reject = countsMap['reject_ffsb_p'] || 0;
            var finalPlacement = countsMap['final_placement_p'] || 0;

            var cells = [
                { key: 'eec', val: eec, clickable: true },
                { key: 'reject_ffsb_p', val: reject, clickable: true },
                {
                    key: 'eec_percentage',
                    val: eec > 0 ? Math.ceil((reject / eec) * 100) : 0,
                    clickable: false,
                    isPercentage: true
                },

                { key: 'final_placement_p', val: finalPlacement, clickable: true },
                {
                    key: 'final_placement_percentage',
                    val: eec > 0 ? Math.ceil((finalPlacement / eec) * 100) : 0,
                    clickable: false,
                    isPercentage: true
                },
            ];

            // Data row (numbers)
            tableHtmlFsb += '<tbody><tr style="text-align:center;font-weight:700">';
            cells.forEach(function(c){
                var val = (c.val !== undefined && c.val !== null) ? c.val.toLocaleString('en-US') : 0;
                if (c.clickable) {
                    tableHtmlFsb += '<td class="clickable-cell" data-key="' + c.key + '" style="padding:10px; cursor:pointer">' + val + '</td>'; 
                } else if (c.isPercentage) {
                    tableHtmlFsb += '<td style="padding:10px; background-color:#f1f5f9; color:#0f172a;">' + val + '%</td>'; 
                } else {
                    tableHtmlFsb += '<td style="padding:10px; background-color:#fafafa;">' + val + '</td>'; 
                }
            });
    
            tableHtmlFsb += '</tr></tbody>';
            tableHtmlFsb += '</table></div>';
    
            chartContainerFsb.html(tableHtmlFsb);
            chartContainerFsb.off('click', '.clickable-cell').on('click', '.clickable-cell', function(){
                var key = $(this).data('key');
                if (key) {
                    fetchList(programId, key);
                }
            });


            // RESUME
            var chartContainerResume = $('#grantee-stats-resume-' + programId);
            chartContainerResume.empty();
    
            var tableHtmlResume = '<div style="overflow-x:auto"><table class="table table-bordered" id="grantee-resume-grid-' + programId + '">';
            tableHtmlResume += '<thead>';
            tableHtmlResume += '<tr style="background:#013473;color:#fff;font-weight:700;text-align:right">';
            tableHtmlResume += '<th></th>';
            tableHtmlResume += '<th>Process</th>';
            tableHtmlResume += '<th>Principal</th>';
            tableHtmlResume += '<th>Alternate</th>';
            tableHtmlResume += '<th>Total</th>';
            tableHtmlResume += '</tr>';
            tableHtmlResume += '</thead>';
            tableHtmlResume += '<tbody>';
            
            var rowsResume = [
                {
                    no: 1,
                    rows: [
                        {
                            label: 'EEC',
                            principalKey: 'eec',
                            alternateKey: 'eec_alternate'
                        },
                        {
                            label: '1st Attrition',
                            principalKey: 'reject_eec_p',
                            alternateKey: 'reject_eec_a'
                        },
                        {
                            label: '1st Upgrade',
                            principalKey: 'upgrade',
                            alternateKey: '1steec_alternate_upgrade'
                        }
                    ]
                },
                {
                    no: 2,
                    rows: [
                        {
                            label: 'FFSB',
                            principalKey: 'ffsb',
                            alternateKey: 'eec_alternate'
                        },
                        {
                            label: '2nd Attrition',
                            principalKey: 'reject_ffsb_p',
                            alternateKey: 'reject_ffsb_a'
                        },
                        {
                            label: '2nd Upgrade',
                            principalKey: 'upgrade',
                            alternateKey: '2ndffsb_alternate_upgrade'
                        }
                    ]
                },
                {
                    no: 3,
                    rows: [
                        {
                            label: 'Final Placement',
                            principalKey: 'final_placement_p',
                            alternateKey: 'final_placement_a'
                        }
                    ]
                }
            ];
            rowsResume.forEach(function(group) {

                group.rows.forEach(function(row, index) {

                    tableHtmlResume += '<tr style="text-align:left;font-weight:700">';

                    // Nomor hanya di baris pertama setiap grup
                    if (index === 0) {
                        tableHtmlResume += '<td rowspan="' + group.rows.length + '" style="vertical-align:top;">' + group.no + '</td>';
                    }

                    var principal = countsMap[row.principalKey] || 0;
                    var alternate = countsMap[row.alternateKey] || 0;

                    var cells = [
                        { val: row.label },
                        { key: row.principalKey, val: principal, clickable: true },
                        { key: row.alternateKey, val: alternate, clickable: true },
                        { val: principal + alternate, isTotal: true }
                    ];

                    cells.forEach(function(cell) {
                        var val = typeof cell.val === 'number'
                            ? cell.val.toLocaleString('en-US')
                            : cell.val;

                        if (cell.clickable) {
                            tableHtmlResume += '<td class="clickable-cell" data-key="' + cell.key + '">' + val + '</td>';
                        } else if (cell.isTotal) {
                            tableHtmlResume += '<td style="background:#f1f5f9;">' + val + '</td>';
                        } else {
                            tableHtmlResume += '<td>' + val + '</td>';
                        }
                    });

                    tableHtmlResume += '</tr>';
                });

            });
    
            tableHtmlResume += '</tbody>';
            tableHtmlResume += '</table></div>';
    
            chartContainerResume.html(tableHtmlResume);
            chartContainerResume.off('click', '.clickable-cell').on('click', '.clickable-cell', function(){
                var key = $(this).data('key');
                if (key) {
                    fetchList(programId, key);
                }
            });
        }



        var tableHtml = '<div style="overflow-x:auto"><table class="table table-bordered" id="grantee-stats-grid-' + programId + '">';

        // Merged headers according to the screenshot layout
        tableHtml += '<thead>';
        tableHtml += '<tr style="background:#013473;color:#fff;font-weight:700;text-align:center">';
        tableHtml += '<th colspan="3">Total Applicant</th>';
        tableHtml += '<th colspan="3">Preliminary Review</th>';
        tableHtml += '<th colspan="4">Interview Process</th>';
        tableHtml += '<th colspan="3">EEC</th>';
        tableHtml += '<th colspan="3">FSB</th>';
        tableHtml += '<th colspan="7">Nominee</th>';
        tableHtml += '<th rowspan="3" style="vertical-align: middle; background:#013473;">Final Placement</th>';
        tableHtml += '<th colspan="3">Return</th>';
        tableHtml += '</tr>';

        tableHtml += '<tr style="background:#0b3b70;color:#fff;font-weight:600;text-align:center">';
        // Total Applicant subheaders (rowspan=2)
        tableHtml += '<th rowspan="2" style="vertical-align: middle; padding:8px;">Submitted</th>';
        tableHtml += '<th rowspan="2" style="vertical-align: middle; padding:8px;">Rejected</th>';
        tableHtml += '<th rowspan="2" style="vertical-align: middle; padding:8px; background-color:#0d4585;">Total</th>';

        // Preliminary Review subheaders (rowspan=2)
        tableHtml += '<th rowspan="2" style="vertical-align: middle; padding:8px;">Review Reject</th>';
        tableHtml += '<th rowspan="2" style="vertical-align: middle; padding:8px;">Review Passed</th>';
        tableHtml += '<th rowspan="2" style="vertical-align: middle; padding:8px; background-color:#0d4585;">Total</th>';
        
        // Interview Process subheaders (rowspan=2)
        tableHtml += '<th rowspan="2" style="vertical-align: middle; padding:8px;">Interview Reject</th>';
        tableHtml += '<th rowspan="2" style="vertical-align: middle; padding:8px;">Interview Passed</th>';
        tableHtml += '<th rowspan="2" style="vertical-align: middle; padding:8px;">Interview Withdras</th>';
        tableHtml += '<th rowspan="2" style="vertical-align: middle; padding:8px; background-color:#0d4585;">Total</th>';
        
        // EEC subheaders (rowspan=2)
        tableHtml += '<th rowspan="2" style="vertical-align: middle; padding:8px;">Principal</th>';
        tableHtml += '<th rowspan="2" style="vertical-align: middle; padding:8px;">Alternate</th>';
        tableHtml += '<th rowspan="2" style="vertical-align: middle; padding:8px; background-color:#0d4585;">Total</th>';
        
        // FSB subheader
        tableHtml += '<th colspan="3">FSB Approved</th>';
        
        // Nominee subheaders
        tableHtml += '<th colspan="3">Nominee Attrition</th>';
        tableHtml += '<th rowspan="2" style="vertical-align: middle; padding:8px;">Upgrade</th>';
        tableHtml += '<th colspan="3">Current Nominee</th>';
        
        // Return subheaders (rowspan=2)
        tableHtml += '<th rowspan="2" style="vertical-align: middle; padding:8px;">Success</th>';
        tableHtml += '<th rowspan="2" style="vertical-align: middle; padding:8px;">Unsuccess</th>';
        tableHtml += '<th rowspan="2" style="vertical-align: middle; padding:8px; background-color:#0d4585;">Total</th>';
        tableHtml += '</tr>';

        tableHtml += '<tr style="background:#0f4c8a;color:#fff;font-weight:600;text-align:center">';
        // FSB Approved subheaders
        tableHtml += '<th style="padding:6px;">Principal</th>';
        tableHtml += '<th style="padding:6px;">Alternate</th>';
        tableHtml += '<th style="padding:6px; background-color:#125ba6;">Total</th>';
        
        // Nominee Attrition subheaders
        tableHtml += '<th style="padding:6px;">Principal</th>';
        tableHtml += '<th style="padding:6px;">Alternate</th>';
        tableHtml += '<th style="padding:6px; background-color:#125ba6;">Total</th>';
        
        // Current Nominee subheaders
        tableHtml += '<th style="padding:6px;">Principal</th>';
        tableHtml += '<th style="padding:6px;">Alternate</th>';
        tableHtml += '<th style="padding:6px; background-color:#125ba6;">Total</th>';
        tableHtml += '</tr>';
        tableHtml += '</thead>';

        // Define cells with exact mappings and computed totals
        var cells = [
            // Total Applicant
            {key: 'application_submitted', val: countsMap['application_submitted'], clickable: true},
            {key: 'application_rejected', val: countsMap['application_rejected'], clickable: true},
            {key: 'preliminary_review_total', val: (countsMap['application_submitted'] || 0) + (countsMap['application_rejected'] || 0), clickable: false, isTotal: true},

            // Preliminary Review
            {key: 'review_rejected', val: countsMap['review_rejected'], clickable: true},
            {key: 'review_passed', val: countsMap['review_passed'], clickable: true},
            {key: 'preliminary_review_total', val: (countsMap['review_rejected'] || 0) + (countsMap['review_passed'] || 0), clickable: false, isTotal: true},

            // Interview Process
            {key: 'interview_rejected', val: countsMap['interview_rejected'], clickable: true},
            {key: 'interview_passed', val: countsMap['interview_passed'], clickable: true},
            {key: 'selection_withdraw', val: countsMap['selection_withdraw'], clickable: true},
            {key: 'interview_process_total', val: (countsMap['interview_rejected'] || 0) + (countsMap['interview_passed'] || 0) + (countsMap['selection_withdraw'] || 0), clickable: false, isTotal: true},

            // EEC
            {key: 'eec', val: countsMap['eec'], clickable: true},
            {key: 'eec_alternate', val: countsMap['eec_alternate'], clickable: true},
            {key: 'eec_total', val: (countsMap['eec'] || 0) + (countsMap['eec_alternate'] || 0), clickable: false, isTotal: true},

            // FSB Approved
            {key: 'eec', val: countsMap['eec'], clickable: true}, 
            {key: 'eec_alternate', val: countsMap['eec_alternate'], clickable: true},
            {key: 'fsb_approved_total', val: (countsMap['eec'] || 0) + (countsMap['eec_alternate'] || 0), clickable: false, isTotal: true},

            // Nominee Attrition
            {key: 'nominee_attrition_p', val: countsMap['nominee_attrition_p'], clickable: true},
            {key: 'nominee_attrition_a', val: countsMap['nominee_attrition_a'], clickable: true},
            {key: 'nominee_attrition_total', val: (countsMap['nominee_attrition_p'] || 0) + (countsMap['nominee_attrition_a'] || 0), clickable: false, isTotal: true},

            // Upgrade
            {key: 'upgrade', val: countsMap['upgrade'], clickable: true},

            // Current Nominee
            {key: 'nominee_p', val: countsMap['nominee_p'], clickable: true},
            {key: 'nominee_a', val: countsMap['nominee_a'], clickable: true},
            {key: 'current_nominee_total', val: (countsMap['nominee_p'] || 0) + (countsMap['nominee_a'] || 0), clickable: false, isTotal: true},

            // Final Placement
            {key: 'final_placement', val: countsMap['final_placement'], clickable: true},

            // Return
            {key: 'success', val: countsMap['success'], clickable: true},
            {key: 'unsuccess', val: countsMap['unsuccess'], clickable: true},
            {key: 'return_total', val: (countsMap['success'] || 0) + (countsMap['unsuccess'] || 0), clickable: false, isTotal: true}
        ];

        // Data row (numbers)
        tableHtml += '<tbody><tr style="text-align:center;font-weight:700">';
        cells.forEach(function(c){
            var val = (c.val !== undefined && c.val !== null) ? c.val.toLocaleString('en-US') : 0;
            if (c.clickable) {
                tableHtml += '<td class="clickable-cell" data-key="' + c.key + '" style="padding:10px; cursor:pointer">' + val + '</td>'; 
            } else if (c.isTotal) {
                tableHtml += '<td style="padding:10px; background-color:#f1f5f9; color:#0f172a;">' + val + '</td>'; 
            } else {
                tableHtml += '<td style="padding:10px; background-color:#fafafa;">' + val + '</td>'; 
            }
        });

        tableHtml += '</tr></tbody>';
        tableHtml += '</table></div>';

        chartContainer.html(tableHtml);

        // Activate click on table values / cells
        chartContainer.off('click', '.clickable-cell').on('click', '.clickable-cell', function(){
            var key = $(this).data('key');
            if (key) {
                fetchList(programId, key);
            }
        });
    }

    function fetchList(programId, label) {
        showSwal('loading', 'Please wait while we process your request.');
        var period = $('select[name="period"]').val() || '';
        var params = {
            program_id: programId,
            period: period,
            label: label
        };
        $.getJSON(site_url + 'admin/dashboard/ajax_grantee_stats', params, function(resp){
            if (resp.list) {
                renderList(programId, resp.list);
            }
            Swal.close(); 
        });
    }

    function getStatusBadge(statusName) {
        if (!statusName || statusName === '-') return '-';
        var lower = statusName.toLowerCase();
        var className = 'status-default';
        if (lower.includes('accept') || lower.includes('pass') || lower.includes('success') || lower.includes('verified')) {
            className = 'status-success';
        } else if (lower.includes('reject') || lower.includes('decline') || lower.includes('withdraw')) {
            className = 'status-danger';
        } else if (lower.includes('waiting') || lower.includes('pending') || lower.includes('new') || lower.includes('submit')) {
            className = 'status-pending';
        } else if (lower.includes('ongoing') || lower.includes('active')) {
            className = 'status-active';
        }
        return '<span class="status-badge ' + className + '">' + statusName + '</span>';
    }

    function renderList(programId, list) {
        var tbody = $('#grantee-stats-table-' + programId + ' tbody');
        tbody.empty();
        var tableSelector = '#grantee-stats-table-' + programId;
        if ($.fn.dataTable && $.fn.dataTable.isDataTable(tableSelector)) {
            $(tableSelector).DataTable().clear().destroy();
        }
        tbody.empty();

        if (!list || list.length == 0) {
            tbody.append('<tr><td colspan="5" class="text-center">No records</td></tr>');
            return;
        }

        list.forEach(function(r, idx){
            var url = site_url + 'admin/users_grantee/edit/' + (r.user_grantee_id);
            var fiscal = r.fiscal_year || r.fiscal || r.period || '-';
            var status = r.status_name || r.status || '-';
            
            var tr = '<tr>';
            tr += '<td>' + (idx+1) + '</td>';
            tr += '<td><a href="' + url + '" target="_blank"><strong>' + (r.fullname || '') + '</strong></a></td>';
            tr += '<td>' + (r.program_name || '') + '</td>';
            tr += '<td><span class="fiscal-badge">' + fiscal + '</span></td>';
            tr += '<td>' + getStatusBadge(status) + '</td>';
            tr += '</tr>';
            tbody.append(tr);
        });

        $(tableSelector).DataTable({
            paging: true,
            searching: true,
            ordering: false,
            info: true,
            pageLength: 10,
            destroy: true
        });
    }

    function downloadExcel() {
        var period = $('select[name="period"]').val() || '';
        var params = [];
        if (period) params.push('period=' + encodeURIComponent(period));
        var url = site_url + 'admin/dashboard/export_grantee_excel' + (params.length ? '?' + params.join('&') : '');
        window.location = url;
    }

    $(function(){
        // Fetch stats for initially expanded accordion
        $('.panel-collapse.in, .panel-collapse.show').each(function(){
            var programId = $(this).attr('id').replace('collapse-', '');
            var isDegree = $(this).data('degree') || false;
            fetchStats(programId, isDegree);
        });

        // Dynamic toggle/lazy load logic for accordion collapse
        $('.panel-collapse').on('show.bs.collapse', function () {
            var programId = $(this).attr('id').replace('collapse-', '');
            var isDegree = $(this).data('degree') || false;
            $('#heading-' + programId).find('.fa-chevron-down').removeClass('fa-chevron-down').addClass('fa-chevron-up');
            fetchStats(programId, isDegree);
        }).on('hide.bs.collapse', function () {
            var programId = $(this).attr('id').replace('collapse-', '');
            var isDegree = $(this).data('degree') || false;
            $('#heading-' + programId).find('.fa-chevron-up').removeClass('fa-chevron-up').addClass('fa-chevron-down');
        });

        // Global export excel button
        $('#btn-export-csv').on('click', function(e){
            e.preventDefault();
            downloadExcel();
        });

        // Local program export excel buttons
        $(document).on('click', '.btn-export-excel', function(e){
            e.preventDefault();
            var isDegree = $(this).data('degree') == true ? 1 : 0;
            var programId = $(this).data('program-id');
            var period = $('select[name="period"]').val() || '';
            var url = site_url + 'admin/dashboard/export_grantee_excel?program_id=' + encodeURIComponent(programId) + '&degree=' + isDegree;
            if (period) {
                url += '&period=' + encodeURIComponent(period);
            }
            window.location = url;
        });
    });
</script>