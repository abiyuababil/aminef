

<script>
    $(document).ready(function () {

        var excelData = [];

        var $tableBody = $('#table-body');
        var $searchInput = $('#search-input');
        var $clearSearchBtn = $('#clear-search');
        var $recordCountEl = $('#record-count');
        var $noResultsEl = $('#no-results');
        var $periodId = $('#period_id_spesification').val();

        /**
         * Load data from database
         */
        function loadData() {

            $.ajax({
                url: '<?php echo site_url("grantee/grants/get_data_field_of_study"); ?>',
                type: 'GET',
                data: {
                    period_id: $periodId
                },
                dataType: 'json',
                beforeSend: function () {
                    $tableBody.html(
                        '<tr>' +
                            '<td colspan="9" class="text-center py-5 text-slate-500">' +
                                'Loading...' +
                            '</td>' +
                        '</tr>'
                    );
                },
                success: function (response) {

                    if (!response.success) {
                        $tableBody.html(
                            '<tr>' +
                                '<td colspan="9" class="text-center py-5 text-red-500">' +
                                    'Failed to load data.' +
                                '</td>' +
                            '</tr>'
                        );

                        return;
                    }

                    excelData = response.data || [];

                    renderTable($searchInput.val());
                },
                error: function (xhr) {

                    console.error(xhr.responseText);

                    $tableBody.html(
                        '<tr>' +
                            '<td colspan="9" class="text-center py-5 text-red-500">' +
                                'An error occurred while loading data.' +
                            '</td>' +
                        '</tr>'
                    );
                }
            });
        }


        /**
         * Render table
         */
        function renderTable(filterTerm) {
            
            if(excelData.length === 0){
                $('.show_hide_study').addClass('hide')
            }

            filterTerm = filterTerm || '';

            var term = $.trim(filterTerm).toLowerCase();

            var filtered = $.grep(excelData, function (item) {

                if (!term) {
                    return true;
                }

                return (
                    String(item.field || '').toLowerCase().indexOf(term) !== -1 ||
                    String(item.gre || '').toLowerCase().indexOf(term) !== -1 ||
                    String(item.considerations || '').toLowerCase().indexOf(term) !== -1 ||
                    String(item.toeflIbt120 || '').toLowerCase().indexOf(term) !== -1 ||
                    String(item.toeflIie || '').toLowerCase().indexOf(term) !== -1
                );
            });

            $recordCountEl.text(filtered.length);

            $tableBody.empty();

            if (filtered.length === 0) {

                $noResultsEl.removeClass('hidden');

                return;
            }

            $noResultsEl.addClass('hidden');


            $.each(filtered, function (idx, row) {

                var rowClass = (idx % 2 === 0)
                    ? 'bg-white'
                    : 'bg-slate-50/70';

                var stickyBgClass = (idx % 2 === 0)
                    ? 'bg-white'
                    : 'bg-[#f8fafc]';

                var $tr = $('<tr>', {
                    'class':
                        rowClass +
                        ' hover:bg-sky-50/60 transition-colors border-b border-slate-200'
                });


                // Field of Study
                $('<td>', {
                    'class':
                        'py-3 px-4 font-bold text-slate-900 border-r border-slate-200 sticky-col ' +
                        stickyBgClass,
                    'text': row.field || ''
                }).appendTo($tr);


                // TOEFL IIE
                // $('<td>', {
                //     'class':
                //         'py-3 px-3.5 text-center border-r border-slate-200 text-slate-800 font-medium cell-preserve-break leading-snug',
                //     'text': row.toeflIie || ''
                // }).appendTo($tr);


                // TOEFL ITP
                $('<td>', {
                    'class':
                        'py-3 px-3 text-center border-r border-slate-200 text-slate-800 font-semibold',
                    'text': row.toeflItp || ''
                }).appendTo($tr);


                // TOEFL iBT 120
                $('<td>', {
                    'class':
                        'py-3 px-3 text-center border-r border-slate-200 text-slate-900 font-bold bg-sky-50/30',
                    'text': row.toeflIbt120 || ''
                }).appendTo($tr);


                // TOEFL iBT 1-6
                $('<td>', {
                    'class':
                        'py-3 px-3 text-center border-r border-slate-200 text-slate-700 font-medium',
                    'text': row.toeflIbt16 || ''
                }).appendTo($tr);


                // IELTS
                $('<td>', {
                    'class':
                        'py-3 px-3 text-center border-r border-slate-200 text-slate-800 font-semibold',
                    'text': row.ielts || ''
                }).appendTo($tr);


                // Duolingo
                $('<td>', {
                    'class':
                        'py-3 px-3 text-center border-r border-slate-200 text-slate-700',
                    'text': row.duolingo || ''
                }).appendTo($tr);


                // GRE
                // $('<td>', {
                //     'class':
                //         'py-3 px-4 border-r border-slate-200 text-slate-800 leading-snug cell-preserve-break min-w-[260px]',
                //     'text': row.gre || ''
                // }).appendTo($tr);


                // Additional Considerations
                // $('<td>', {
                //     'class':
                //         'py-3 px-4 text-slate-700 leading-relaxed cell-preserve-break min-w-[420px]',
                //     'text': row.considerations || ''
                // }).appendTo($tr);


                $tableBody.append($tr);
            });
        }


        /**
         * Search
         */
        $searchInput.on('input', function () {

            var val = $(this).val();

            $clearSearchBtn.toggleClass(
                'hidden',
                !val
            );

            renderTable(val);
        });


        /**
         * Clear search
         */
        $clearSearchBtn.on('click', function () {

            $searchInput.val('');

            $(this).addClass('hidden');

            renderTable('');

            $searchInput.focus();
        });


        /**
         * Initial load
         */
        loadData();

    });
</script>