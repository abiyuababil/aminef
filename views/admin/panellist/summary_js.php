<script>
    (function ($) {
        $(document).ready(function () {
            $(document).on('click', '.score-detail', function (e) {
                e.preventDefault();
                let reviewId = $(this).data('id');
                let $modal = $('#reviewDetailModal');
                if (!$modal.length) {
                    $('body').append('\n<div class="modal fade" id="reviewDetailModal" tabindex="-1" role="dialog">\n  <div class="modal-dialog modal-lg" role="document">\n    <div class="modal-content">\n      <div class="modal-header">\n        <h4 class="modal-title">Detail Score</h4>\n        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\n      </div>\n      <div class="modal-body">\n        <div class="review-detail-content">Loading...</div>\n      </div>\n      <div class="modal-footer">\n        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>\n      </div>\n    </div>\n  </div>\n</div>\n');
                    $modal = $('#reviewDetailModal');
                }
                let $content = $modal.find('.review-detail-content');
                $content.html('<p>Loading...</p>');
                $.ajax({
                    url: '<?php echo site_url('admin/selection_review/get_detail_score_readonly') ?>/' + reviewId,
                    method: 'GET',
                    dataType: 'json',
                    success: function (r) {
                        $content.html(r);
                        $modal.modal('show');
                    },
                    error: function () {
                        $content.html('<div class="alert alert-danger">Failed to load detail score.</div>');
                        $modal.modal('show');
                    }
                });
            });

            $(document).on('click', '.summary-count', function (e) {
                e.preventDefault();
                let panellistId = $(this).data('id');
                let type = $(this).data('type');
                let $modal = $('#summaryDetailsModal');
                let $content = $modal.find('#summary-details-content');
                $content.html('<p>Loading...</p>');
                let title = '';
                if (type === 'pdo') {
                    title = 'PDO Global';
                } else if (type === 'mentoring') {
                    title = 'Mentoring list';
                } else {
                    title = type.charAt(0).toUpperCase() + type.slice(1) + ' list';
                }
                $modal.find('.modal-title').text(title);

                $.ajax({
                    url: '<?php echo site_url('admin/panelist/summary_view') ?>',
                    method: 'GET',
                    data: { id: panellistId, type: type },
                    dataType: 'json',
                    success: function (resp) {
                        if (resp.success) {
                            $content.html(resp.html);

                            let $filters = $('#summary-filters');
                            let $programSelect = $('#summary-filter-program');
                            let $periodSelect = $('#summary-filter-period');
                            $programSelect.empty();
                            $periodSelect.empty();

                            let programs = {};
                            let periods = {};

                            let $table = $content.find('table');
                            if ($table.length) {
                                $table.find('tbody tr').each(function () {
                                    let $tds = $(this).find('td');
                                    let grant = $.trim($tds.eq(2).text());
                                    let period = $.trim($tds.eq(3).text());
                                    if (grant.length) programs[grant] = true;
                                    if (period.length) periods[period] = true;
                                });

                                $programSelect.append($('<option>').val('').text('All Programs'));
                                Object.keys(programs).sort().forEach(function (p) {
                                    $programSelect.append($('<option>').val(p).text(p));
                                });

                                $periodSelect.append($('<option>').val('').text('All Periods'));
                                Object.keys(periods).sort().forEach(function (p) {
                                    $periodSelect.append($('<option>').val(p).text(p));
                                });

                                $filters.show();
                            } else {
                                $filters.hide();
                            }

                            if (type == 'pdo') {
                                $filters.hide();
                            } else {
                                $filters.show();
                            }

                            var dt = null;
                            function applySummaryFilters() {
                                let selProgram = $programSelect.val();
                                let selPeriod = $periodSelect.val();
                                
                                if (dt) {
                                    var esc = (typeof $.fn.dataTable.util !== 'undefined' && typeof $.fn.dataTable.util.escapeRegex === 'function') ? $.fn.dataTable.util.escapeRegex : function (q) { return q.replace(/[.*+?^${}()|[\\]\\]/g, '\\\\$&'); };
                                    var progSearch = selProgram ? '^' + esc(selProgram) + '$' : '';
                                    var periodSearch = selPeriod ? '^' + esc(selPeriod) + '$' : '';
                                    
                                    dt.column(2).search(progSearch, true, false);
                                    dt.column(3).search(periodSearch, true, false);
                                    dt.draw();

                                    return;
                                }

                                $table.find('tbody tr').each(function () {
                                    let $tds = $(this).find('td');
                                    let grant = $.trim($tds.eq(2).text());
                                    let period = $.trim($tds.eq(3).text());
                                    let show = true;
                                    if (selProgram && selProgram.length && grant !== selProgram) show = false;
                                    if (selPeriod && selPeriod.length && period !== selPeriod) show = false;
                                    $(this).toggle(show);
                                });

                            }

                            $programSelect.off('change').on('change', function () { applySummaryFilters(); });
                            $periodSelect.off('change').on('change', function () { applySummaryFilters(); });
                            $('#summary-filter-clear').off('click').on('click', function (e) { e.preventDefault(); $programSelect.val(''); $periodSelect.val(''); applySummaryFilters(); });

                            if ($table.length && $.fn.DataTable) {
                                if ($.fn.dataTable.isDataTable($table)) {
                                    $table.DataTable().destroy();
                                }
                                dt = $table.DataTable({
                                    processing: false,
                                    serverSide: false,
                                    responsive: true,
                                    paging: true,
                                    pageLength: 25,
                                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
                                    columnDefs: [
                                        { orderable: false, targets: 0 },
                                        { searchable: false, targets: 0 }
                                    ]
                                });
                                // re-apply filters after datatable init
                                applySummaryFilters();
                            }
                            try {
                                if (typeof $.fn.topbox !== 'undefined') {
                                    $content.find('.lightbox').topbox();
                                }
                            } catch (e) {
                            }
                        } else {
                            $content.html('<div class="alert alert-warning">No data found</div>');
                        }
                        $modal.modal('show');
                    },
                    error: function () {
                        $content.html('<div class="alert alert-danger">An error occurred while fetching details.</div>');
                        $modal.modal('show');
                    }
                });
            });

            $(document).on('click', '.interview-score', function (e) {
                e.preventDefault();
                let interviewId = $(this).data('id');
                let periodId = $(this).data('period_id');
                let $modal = $('#interviewDetailModal');
                if (!$modal.length) {
                    $('body').append('\n<div class="modal fade" id="interviewDetailModal" tabindex="-1" role="dialog">\n  <div class="modal-dialog modal-lg" role="document">\n    <div class="modal-content">\n      <div class="modal-header">\n        <h4 class="modal-title">Interview Detail</h4>\n        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\n      </div>\n      <div class="modal-body">\n        <div class="interview-detail-content">Loading...</div>\n      </div>\n      <div class="modal-footer">\n        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>\n      </div>\n    </div>\n  </div>\n</div>\n');
                    $modal = $('#interviewDetailModal');
                }
                let $content = $modal.find('.interview-detail-content');
                $content.html('<p>Loading...</p>');
                $.ajax({
                    url: '<?php echo site_url('admin/set_interview/get_detail_interview_score_readonly') ?>/' + interviewId + '/' + periodId,
                    method: 'GET',
                    dataType: 'json',
                    success: function (r) {
                        if (r && r.template) {
                            $content.html(r.template);
                        } else {
                            $content.html('<div class="alert alert-warning">No detail available.</div>');
                        }
                        $modal.modal('show');
                    },
                    error: function () {
                        $content.html('<div class="alert alert-danger">Failed to load interview detail.</div>');
                        $modal.modal('show');
                    }
                });
            });
        });
    })(jQuery);
</script>