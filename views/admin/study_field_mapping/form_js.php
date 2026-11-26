<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<script>
    const SITE_URL = '<?php echo site_url(); ?>';
    $(document).ready(function(){
        if ($("#fiscal_year").val()) {
            $("#fiscal_year").trigger('change');
        }
    });

    $("#fiscal_year").change(function() {
        var grants = '#grants';
        var load = '#load-grants';
        var dataGrant = [<?= isset($data) && !empty($data->user_grantee_grant_id) ? $data->user_grantee_grant_id : (isset($data) && !empty($data->grant_id) ? $data->grant_id : '') ?>];
        if(this.value == ''){
            $(grants).html('');
            return false;
        }
        $(load).show();
        $(grants).html('');
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/study_field_mapping/get_active_grant') ?>/' + this.value,
            dataType: 'JSON',
            success: function(r) {
                $.each(r, function(id, val) {
                    var selected = '';
                    if(jQuery.inArray(parseInt(val.id), dataGrant) !== -1) {
                        selected = 'selected';
                    }
                    $(grants).append('<option '+selected+' value="' + val.id + '">' + val.name + '</option>');
                });
                $(load).hide();
                $(".validation-error-fiscal").css('display', 'none');
                if (typeof $.fn.select2 !== 'undefined') {
                    $(grants).trigger('change.select2');
                }
            },
            error: function() {
                $(load).hide();
            }
        });
    });
    
    // Data Master Hierarki FOS dari am_study_fields_2
    const fosHierarchy = <?php echo json_encode(isset($fos_hierarchy) ? $fos_hierarchy : []); ?>;

    const $tbody = $('#tableBody');


    // ==========================================================
    // 1. RENDER TABEL FOS
    // ==========================================================
    function renderFosList() {
        $tbody.empty();

        if (!fosHierarchy || fosHierarchy.length === 0) {
            $tbody.html(`
                <tr>
                    <td colspan="2" style="text-align: center; padding: 20px; color: #888;">
                        No Field of Study data available.
                    </td>
                </tr>
            `);
            return;
        }

        $.each(fosHierarchy, function(pIdx, group) {

            // Baris Parent
            const $pRow = $(`
                <tr class="parent-row">
                    <td style="text-align: center;">
                        <input type="checkbox"
                            class="parent-checkbox"
                            data-pidx="${pIdx}">
                    </td>
                    <td>${group.parent}</td>
                </tr>
            `);

            $tbody.append($pRow);


            // Baris Child
            if (group.children && group.children.length > 0) {

                $.each(group.children, function(index, child) {

                    const $cRow = $(`
                        <tr class="child-row">
                            <td style="text-align: center;">
                                <input type="checkbox"
                                    class="child-checkbox"
                                    data-pidx="${pIdx}"
                                    value="${child.id}"
                                    ${child.active ? 'checked' : ''}>
                            </td>

                            <td style="padding-left: 28px; color: #334155;">
                                <span class="tree-branch">└──</span>
                                ${child.name}
                            </td>
                        </tr>
                    `);

                    $tbody.append($cRow);
                });
            }
        });

        syncParentStates();
    }


    // ==========================================================
    // 2. SINKRONISASI CHECKBOX PARENT & CHILD
    // ==========================================================
    function syncParentStates() {

        $('.parent-checkbox').each(function() {

            const $pBox = $(this);
            const pIdx = $pBox.data('pidx');

            const $children = $(`.child-checkbox[data-pidx="${pIdx}"]`);

            if ($children.length === 0) {
                return;
            }

            const checkedCount = $children.filter(':checked').length;

            $pBox.prop('checked', checkedCount === $children.length);

            // jQuery tidak punya .prop('indeterminate') secara khusus
            // tapi tetap bisa menggunakan prop
            $pBox.prop(
                'indeterminate',
                checkedCount > 0 && checkedCount < $children.length
            );
        });


        // Header toggle
        const $allChildren = $('.child-checkbox');

        if ($allChildren.length > 0) {

            const totalChecked = $allChildren.filter(':checked').length;
            const $headerToggle = $('#headerToggle');

            if ($headerToggle.length) {

                $headerToggle.prop(
                    'checked',
                    totalChecked === $allChildren.length
                );

                $headerToggle.prop(
                    'indeterminate',
                    totalChecked > 0 &&
                    totalChecked < $allChildren.length
                );
            }
        }
    }


    // ==========================================================
    // 3. PARENT CHECKBOX → CHECK / UNCHECK CHILD
    // ==========================================================
    $tbody.on('change', '.parent-checkbox', function() {

        const pIdx = $(this).data('pidx');
        const checked = $(this).prop('checked');

        $(`.child-checkbox[data-pidx="${pIdx}"]`)
            .prop('checked', checked);

        syncParentStates();
    });


    // ==========================================================
    // 4. CHILD CHECKBOX
    // ==========================================================
    $tbody.on('change', '.child-checkbox', function() {
        syncParentStates();
    });


    // ==========================================================
    // 5. CHECK ALL
    // ==========================================================
    $('#btnCheckAll').on('click', function() {

        $('.parent-checkbox, .child-checkbox, #headerToggle')
            .prop('checked', true)
            .prop('indeterminate', false);

        syncParentStates();
    });


    // ==========================================================
    // 6. UNCHECK ALL
    // ==========================================================
    $('#btnUncheckAll').on('click', function() {

        $('.parent-checkbox, .child-checkbox, #headerToggle')
            .prop('checked', false)
            .prop('indeterminate', false);

        syncParentStates();
    });


    // ==========================================================
    // 7. HEADER TOGGLE
    // ==========================================================
    $('#headerToggle').on('change', function() {

        const checked = $(this).prop('checked');

        $('.parent-checkbox, .child-checkbox')
            .prop('checked', checked)
            .prop('indeterminate', false);

        syncParentStates();
    });


    // ==========================================================
    // 8. FILTER / SEARCH FOS
    // ==========================================================
    $('#searchFos').on('keyup', function() {

        const val = $(this).val().toLowerCase().trim();

        $('.child-row').each(function() {

            const $row = $(this);
            const text = $row.text().toLowerCase();

            $row.toggle(text.indexOf(val) > -1);
        });


        // Tampilkan parent jika memiliki child yang visible
        $('.parent-row').each(function() {

            const $row = $(this);
            const pIdx = $row.find('.parent-checkbox').data('pidx');

            const $children = $(`.child-row`).filter(function() {
                return $(this)
                    .find('.child-checkbox')
                    .data('pidx') == pIdx;
            });

            const visibleChildren = $children.filter(':visible').length;

            $row.toggle(
                visibleChildren > 0 || val === ''
            );
        });
    });


    // ==========================================================
    // 9. COPY DARI EXISTING MAPPING (MODAL #mdlCopySof)
    // ==========================================================
    let existingMappingsData = <?php echo json_encode(isset($existing_mappings) ? $existing_mappings : []); ?>;

    function populateCopyPeriods() {
        const $periodSelect = $('#copy_period_id');
        $periodSelect.empty().append('<option value="">--Select Period--</option>');
        $('#copy_grant_id').empty().append('<option value="">--Select Grant--</option>');
        $('#sourceInfoBox').hide();

        if (existingMappingsData && existingMappingsData.length > 0) {
            existingMappingsData.forEach(function(item) {
                $periodSelect.append(
                    $('<option></option>')
                        .val(item.fiscal_year)
                        .text(item.fiscal_year)
                );
            });
        }
    }

    // Populate on load
    populateCopyPeriods();

    // Reload mapping options when modal opens to ensure fresh data
    $('#mdlCopySof').on('show.bs.modal', function() {
        $.ajax({
            url: '<?= base_url("admin/study_field_mapping/get_existing_mappings") ?>',
            type: 'GET',
            dataType: 'json',
            success: function(resp) {
                if (resp && resp.length > 0) {
                    existingMappingsData = resp;
                    const curPeriod = $('#copy_period_id').val();
                    const curGrant = $('#copy_grant_id').val();
                    populateCopyPeriods();
                    if (curPeriod) {
                        $('#copy_period_id').val(curPeriod).trigger('change');
                        if (curGrant) {
                            $('#copy_grant_id').val(curGrant).trigger('change');
                        }
                    }
                }
            }
        });
    });

    // When Period / Fiscal Year is selected
    $('#copy_period_id').on('change', function() {
        const selectedFy = $(this).val();
        const $grantSelect = $('#copy_grant_id');
        $grantSelect.empty().append('<option value="">--Select Grant--</option>');
        $('#sourceInfoBox').hide();

        if (!selectedFy) {
            return;
        }

        const foundPeriod = existingMappingsData.find(function(item) {
            return String(item.fiscal_year) === String(selectedFy);
        });

        if (foundPeriod && foundPeriod.grants && foundPeriod.grants.length > 0) {
            foundPeriod.grants.forEach(function(g) {
                $grantSelect.append(
                    $('<option></option>')
                        .val(g.grant_id)
                        .data('total-fos', g.total_fos)
                        .data('grant-name', g.grant_name)
                        .text(g.grant_name + ' (' + g.total_fos + ' FOS)')
                );
            });
        }
    });

    // When Grant is selected
    $('#copy_grant_id').on('change', function() {
        const grantId = $(this).val();
        const selectedOption = $(this).find('option:selected');
        const totalFos = selectedOption.data('total-fos');
        const grantName = selectedOption.data('grant-name');
        const periodName = $('#copy_period_id').val();

        if (grantId && totalFos !== undefined) {
            $('#sourceFosCount').text(totalFos);
            $('#sourceGrantName').text(grantName);
            $('#sourcePeriodName').text(periodName);
            $('#sourceInfoBox').show();
        } else {
            $('#sourceInfoBox').hide();
        }
    });

    // When "Apply Mapping" button is clicked in modal
    $('#btnApplyCopy').on('click', function() {
        const fiscalYear = $('#copy_period_id').val();
        const grantId = $('#copy_grant_id').val();
        const strategy = $('input[name="copyStrategy"]:checked').val() || 'replace';

        if (!fiscalYear) {
            alert('Please select a Period/Fiscal Year.');
            $('#copy_period_id').focus();
            return;
        }

        if (!grantId) {
            alert('Please select a Source Program / Grant.');
            $('#copy_grant_id').focus();
            return;
        }

        const $btn = $(this);
        $btn.prop('disabled', true).text('Applying...');

        $.ajax({
            url: '<?= base_url("admin/study_field_mapping/get_mapped_fos") ?>',
            type: 'GET',
            data: {
                fiscal_year: fiscalYear,
                grant_id: grantId
            },
            dataType: 'json',
            success: function(resp) {
                $btn.prop('disabled', false).text('Apply Mapping');

                if (resp && resp.length > 0) {
                    const fosSet = new Set(
                        $.map(resp, function(id) {
                            return Number(id);
                        })
                    );

                    if (strategy === 'replace') {
                        // Uncheck all first
                        $('.child-checkbox').prop('checked', false);
                    }

                    // Check items from source
                    let appliedCount = 0;
                    $('.child-checkbox').each(function() {
                        const fosId = Number($(this).val());
                        if (fosSet.has(fosId)) {
                            $(this).prop('checked', true);
                            appliedCount++;
                        }
                    });

                    // Sync parent checkboxes and header toggle
                    syncParentStates();

                    // Close modal
                    $('#mdlCopySof').modal('hide');

                    const grantName = $('#copy_grant_id option:selected').data('grant-name') || 'selected grant';
                    show_toast_message('FOS mapping successfully copied from ' + grantName + ' (' + fiscalYear + '): ' + resp.length + ' items applied.');
                } else {
                    alert('No FOS mapping found for the selected period and grant.');
                }
            },
            error: function() {
                $btn.prop('disabled', false).text('Apply Mapping');
                alert('Failed to fetch mapping from source.');
            }
        });
    });


    // ==========================================================
    // 10. FORM SUBMIT
    // ==========================================================
    $('#form').on('submit', function(e) {

        const $btn = $('.btn-submit');


        // Disable button + loading
        $btn.prop('disabled', true);
        $btn.html(
            '<i class="fa fa-spinner fa-spin"></i> Loading...'
        );


        // Ambil semua FOS yang checked
        const checkedFos = [];

        $('.child-checkbox:checked').each(function() {

            checkedFos.push(
                parseInt($(this).val(), 10)
            );
        });


        // Simpan sebagai JSON
        $('#fos_ids_json').val(
            JSON.stringify(checkedFos)
        );

        // Form tetap submit normal
    });


    // ==========================================================
    // 11. INISIALISASI
    // ==========================================================
    renderFosList();
</script>