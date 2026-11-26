<script>
    const year = <?= $detail_grant->year ?>;
    $('.payment_category_support').on('change', function() {
        var sub_category = '#select_sub_category_record_support';

        $(sub_category).empty();
        $(sub_category).append('<option value="">-- Select Sub Category --</option>');
        get_sub_category_support($(this).val(),sub_category);

        refreshDiffPaymentItems();
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

        refreshDiffPaymentItems();
    });

    function refreshDiffPaymentItems() {
        var category_type = $('.payment_category_support').val();
        var sub_category = $('#select_sub_category_record_support').val();
        if (!category_type || !sub_category) {
            $('.grantee-card-diff').find('.diff-payment-item').each(function(){
                $(this).empty().append('<option value="">Select Payment Item</option>');
            });
            return;
        }
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/payment_item/get_payment_item') ?>',
            data: { category_type, sub_category, country_id: 2 },
            dataType: 'JSON',
            success: function(items) {
                $('.grantee-card-diff').find('.diff-payment-item').each(function(){
                    var $select = $(this);
                    var currentVal = $select.val();
                    $select.empty().append('<option value="">Select Payment Item</option>');
                    $.each(items, function(id, val) {
                        $select.append('<option value="' + val.id + '">' + val.payment_item + '</option>');
                    });
                    $select.append('<option value="__add_new__" data-category="payment_category_support" data-subcategory="select_sub_category_record_support" data-select="diff-payment-item"> <span class="glyphicon glyphicon-plus"></span> Add Payment Item</option>');
                    if (currentVal) {
                        var exists = false;
                        $.each(items, function(id, val) {
                            if (val.id == currentVal) exists = true;
                        });
                        if (exists) $select.val(currentVal).trigger('change');
                    }
                });
            }
        });
    }

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

    // Radio toggle amount type
    $(document).on('change', 'input[name="add_record[amount_type]"]', function() {
        if ($(this).val() === 'different') {
            $('#setup-wrapper-support').addClass('hide');
            $('#setup-wrapper-support-different').removeClass('hide');
            $('#add-setup-support').addClass('hide');
            $('#setup-accordion-support').html('');
        } else {
            $('#setup-wrapper-support').removeClass('hide');
            $('#setup-wrapper-support-different').addClass('hide');
            $('#add-setup-support').removeClass('hide');
            $('#grantee-list-different').html('');
        }
        updateGlobalTotalSupport();
        updateGlobalTotalDifferent();
    });

    // ================ DIFFERENT AMOUNT MODE ================

    $(document).on("click", ".add-grantee-support-diff", async function(){
        let status = $('#select-status-support-diff').val();
        let grant_id = $('#grant_id_bulk_support').val();
        let year = $('#year').val();
        let category = $('.payment_category_support').val();
        let sub_category = $('#select_sub_category_record_support').val();

        if(!status){
            return Swal.fire("Warning", "Please select a status!", "warning");
        }

        if(!category || !sub_category){
            return Swal.fire("Warning", "Please select category and sub category first!", "warning");
        }

        showSwal('loading', 'Please wait while we process your request.');

        let getAllGrantee = await getAsyncData("<?= site_url('world/get_grantee_by_status/'); ?>" + status, {
            period_id: null, grant_id: grant_id, year: year
        });

        let grantees = [];
        try {
            grantees = JSON.parse(getAllGrantee);
        } catch(e) {
            Swal.close();
            return Swal.fire("Error", "Failed to load grantee data.", "error");
        }

        if(!grantees.length){
            Swal.close();
            return Swal.fire("Info", "No grantee found for this status.", "info");
        }

        let $container = $('#grantee-list-different');
        let panelIndex = $container.find('.grantee-card-diff').length;

        for (const g of grantees) {
            const exists = $container.find(`.grantee-check-diff[value="${g.user_grantee_id}"]`).length > 0;
            if (exists) continue;

            let getOptionBankInfo = await getAsyncData("<?= site_url('admin/grantee/get_bank_info/'); ?>" + g.user_grantee_id, {
                period_id: null, grant_id: grant_id, status: status
            });

            let bankInfoList = [];
            try {
                bankInfoList = JSON.parse(getOptionBankInfo);
            } catch(e) {
                bankInfoList = [];
            }

            let panelId = `diffGrantee${panelIndex}`;

            let granteeCard = `
            <div class="panel panel-info grantee-card-diff" data-grantee_grant_id="${g.id}" data-user_id="${g.user_grantee_id}">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <input type="checkbox" class="grantee-check-diff" checked
                            name="add_record[grantee][0][${g.id}][user_id]"
                            value="${g.user_grantee_id}">
                            <a data-toggle="collapse" href="#${panelId}">
                                <strong>${g.full_name}</strong>
                                <i class="fa fa-chevron-up diff-collapse-icon" style="font-size:11px;margin-left:5px;"></i>
                            </a>
                            <div class="pull-right">
                                <button type="button" class="btn btn-danger btn-xs remove-grantee-diff">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </button>
                            </div>
                        </h4>
                    </div>
                    <div id="${panelId}" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <div class="row" style="margin-bottom:10px;">
                            <div class="col-sm-4">
                                <label style="font-weight:normal;font-size:12px;">Bank Info</label>
                                <select class="form-control input-sm select2 grantee-bank-info-diff"
                                    name="add_record[grantee][0][${g.id}][bank_info_id]">
                                    <option value="">Select Bank Info</option>
                                    ${bankInfoList.map(v => `
                                        <option value="${v.id}" ${(v.id == '' || v.id == 0) ? "selected" : ""}>${v.bank_name} - ${v.account_number}</option>
                                    `).join('')}
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label style="font-weight:normal;font-size:12px;">Proof of Expense</label>
                                <input type="file" id="proof_expense_diff_${g.id}" name="proof_expense_diff_${g.id}" class="form-control input-sm">
                            </div>
                            <div class="col-sm-4">
                                <label style="font-weight:normal;font-size:12px;">Proof of Transfer</label>
                                <input type="file" id="proof_diff_${g.id}" name="proof_diff_${g.id}" class="form-control input-sm">
                            </div>
                        </div>
                        <table class="table table-bordered diff-payment-table">
                            <thead>
                                <tr>
                                    <th style="min-width:200px;">Payment Item</th>
                                    <th style="min-width:120px;">Nominal IDR</th>
                                    <th style="min-width:120px;">Nominal USD</th>
                                    <th style="width:50px;">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <button class="btn btn-info btn-sm add-diff-item" type="button">
                            <span class="glyphicon glyphicon-plus"></span> Add Payment Item
                        </button>
                        <div class="diff-subtotal pull-right" style="margin-top:5px;">
                            Subtotal: <span class="diff-subtotal-idr">0</span> | <span class="diff-subtotal-usd">0</span>
                        </div>
                    </div>
                </div>
            </div>`;

            $container.append(granteeCard);
            $container.find('.select2').select2();
            panelIndex++;
        }

        Swal.close();
        updateGlobalTotalDifferent();
    });

    // Add payment item to specific grantee (different mode)
    $(document).on("click", ".add-diff-item", function(){
        let $card = $(this).closest('.grantee-card-diff');
        let grantee_grant_id = $card.data('grantee_grant_id');
        let $tbody = $card.find('.diff-payment-table tbody');
        let trIndex = $tbody.find('.tr-diff-item').length;
        let category = $('.payment_category_support').val();
        let sub_category = $('#select_sub_category_record_support').val();

        let getPaymentItems = getSyncData("<?= site_url('admin/payment_item/get_payment_item'); ?>", {
            category_type: category, sub_category, country_id: 2
        });

        let rowHtml = `
            <tr class="tr-diff-item">
                <td>
                    <select class="form-control diff-payment-item select2"
                        name="different_setup[${grantee_grant_id}][${trIndex}][payment_item]">
                        <option value=''>Select Payment Item</option>
                        ${JSON.parse(getPaymentItems).map(v => `<option value="${v.id}">${v.payment_item}</option>`).join('')}
                        <option value="__add_new__" data-category="payment_category_support" data-subcategory="select_sub_category_record_support" data-select="diff-payment-item"> <span class="glyphicon glyphicon-plus"></span> Add Payment Item</option>
                    </select>
                </td>
                <td><input type="text" class="form-control diff-idr convert-setup-idr" name="different_setup[${grantee_grant_id}][${trIndex}][nominal_idr]"></td>
                <td><input type="text" class="form-control diff-usd convert-setup-usd" name="different_setup[${grantee_grant_id}][${trIndex}][nominal_usd]"></td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm remove-diff-item"><span class="glyphicon glyphicon-trash"></span></button>
                </td>
            </tr>`;
        $tbody.append(rowHtml);
        $card.find('.select2').select2({
            templateResult: function(data) {
                if (data.id === '__add_new__') {
                    return $('<span style="color:#337ab7;"> <span class="glyphicon glyphicon-plus"></span> Add Payment Item</span>');
                }
                return data.text;
            }
        });
        updateSubtotalDifferent($card);
    });

    // Remove grantee (different mode)
    $(document).on("click", ".remove-grantee-diff", function(){
        if (confirm("Are you sure want to delete this ?")){
            $(this).closest(".grantee-card-diff").remove();
            updateGlobalTotalDifferent();
        }
    });

    // Remove payment item (different mode)
    $(document).on("click", ".remove-diff-item", function(){
        if (confirm("Are you sure want to delete this ?")){
            let $card = $(this).closest('.grantee-card-diff');
            $(this).closest("tr").remove();
            updateSubtotalDifferent($card);
        }
    });

    // Update subtotal different mode
    $(document).on("input", ".diff-idr, .diff-usd", function(){
        let $card = $(this).closest('.grantee-card-diff');
        updateSubtotalDifferent($card);
    });

    // Checkbox change different mode
    $(document).on("change", ".grantee-check-diff", function(){
        updateGlobalTotalDifferent();
    });

    function updateSubtotalDifferent($card){
        let idrTotal = 0, usdTotal = 0;
        $card.find('.diff-payment-table tbody tr').each(function(){
            let idr = parseIDR($(this).find(".diff-idr").val()) || 0;
            let usd = parseUSD($(this).find(".diff-usd").val()) || 0;
            idrTotal += idr;
            usdTotal += usd;
        });
        $card.find(".diff-subtotal-idr").text(formatIDR(idrTotal));
        $card.find(".diff-subtotal-usd").text(formatUSD(usdTotal));
        updateGlobalTotalDifferent();
    }

    function updateGlobalTotalDifferent(){
        let globalIdr = 0, globalUsd = 0;
        $(".grantee-card-diff").each(function(){
            let checked = $(this).find(".grantee-check-diff").is(":checked");
            if(checked){
                globalIdr += parseIDR($(this).find(".diff-subtotal-idr").text()) || 0;
                globalUsd += parseUSD($(this).find(".diff-subtotal-usd").text()) || 0;
            }
        });
        $("#global-idr-different").text(formatIDR(globalIdr));
        $("#global-usd-different").text(formatUSD(globalUsd));
    }

    // Toggle collapse icon
    $(document).on('show.bs.collapse', '#grantee-list-different .panel-collapse', function(){
        $(this).closest('.grantee-card-diff').find('.diff-collapse-icon')
            .removeClass('fa-chevron-down').addClass('fa-chevron-up');
    });
    $(document).on('hide.bs.collapse', '#grantee-list-different .panel-collapse', function(){
        $(this).closest('.grantee-card-diff').find('.diff-collapse-icon')
            .removeClass('fa-chevron-up').addClass('fa-chevron-down');
    });

    // ================ END DIFFERENT AMOUNT MODE ================

    // Tambah Setup Panel
    $("#add-setup-support").click(function(){
      let setupIndex = $('.collapse-payment-support').length;
      let panelId = setupIndex;

      let setupHtml = `
      <div class="panel panel-primary setup-block-support">
        <div class="panel-heading">
          <h4 class="panel-title">
            <button type="button" class="btn btn-danger btn-xs pull-left hide-view remove-setup-support" style="margin-right:10px;">
              <span class="glyphicon glyphicon-remove"></span>
            </button>   
            <a data-toggle="collapse" data-parent="#setup-accordion-support" href="#setupSupport${panelId}">
              Payment Item
              <span class="pull-right subtotal-support">
                Subtotal: <span class="subtotal-idr-support">0</span> | <span class="subtotal-usd-support">0</span>
              </span>
            </a>
          </h4>
        </div>
        <div id="setupSupport${panelId}" class="collapse-payment-support panel-collapse collapse in" data-panelid="${panelId}" style="border:1px solid #337ab7;">
          <div class="panel-body">
            <!-- Payment Item Table -->
            <table class="table table-bordered setup-payment-table-support">
              <thead>
                <tr>
                  <th>Payment Item</th>
                  <th>Nominal IDR</th>
                  <th>Nominal USD</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
            <button class="btn btn-info btn-sm hide-view add-setup-support-item" type="button">
              <span class="glyphicon glyphicon-plus"></span> Add Payment Item
            </button>

            <hr>

            <!-- Grantee Selection -->
            <h5><strong>Select Grantee</strong></h5>
            <div class="form-inline">
                <select class="form-control-view form-control select-status-support" id="select-status-support-${panelId}" name="add_record[status_grantee]">
                    <option value="">-- Select Status --</option>
                    <option value="<?= STATUS_FINALIST ?>">Finalist</option>
                    <option value="<?= STATUS_NEW_GRANTEE ?>">Incoming Grantee</option>
                    <option value="<?= STATUS_VISA_APPLICATION ?>">Visa Application</option>
                    <option value="<?= CURRENT_GRANTEE ?>">Current Grantee</option>
                </select>
                <select class="form-control-view form-control select-grantee-support selectpicker hide" id="select-grantee-support-${panelId}" data-live-search="true">
                    <option value="">-- Select Grantee --</option>
                    <?php foreach ($user_grantee as $grantee) { ?>
                        <option value="<?php echo $grantee->user_grantee_id; ?>" data-grantee_grant_id="<?php echo $grantee->grantee_grant_id; ?>" data-grantee_name="<?php echo get_full_name($grantee, 'US'); ?>"><?php echo get_full_name($grantee, 'US'); ?></option>
                    <?php } ?>
                </select>
                <button class="btn btn-primary btn-sm add-grantee-support" type="button">
                    <span class="glyphicon glyphicon-plus"></span> Add Grantee
                </button>
            </div>

            <!-- Grantee Container -->
            <div class="grantee-container-support" style="margin-top:15px;"></div>
          </div>
        </div>
      </div>`;

      $("#setup-accordion-support").append(setupHtml);
      $('.selectpicker').selectpicker('refresh');
      setupIndex++;
    });

    // Hapus Setup Block
    $(document).on("click", ".remove-setup-support", function(){
      if (confirm("Are you sure want to delete this ?")){

        let setupBlock = $(this).closest('.setup-block-support');
        let removeGrantee = setupBlock.find('.remove-grantee-support-support');
        removeGrantee.each(function(){
          var paymentId = $(this).data('paymentid');
          recordDeletePaymentSupport(paymentId);
        });
        $(this).closest(".setup-block-support").remove();
        updateGlobalTotalSupport();
      }
    });

    // Tambah Payment Item
    $(document).on("click", ".add-setup-support-item", function(){
        let $tbody = $(this).closest(".setup-block-support").find("tbody");
        let category    = $('.payment-category-record-support').val(),
            sub_category= $('#select_sub_category_record_support').val(),
            selectedOpt = $('#select-grantee-support option:selected'),
            grantee_grant_id = $(this).data('granteegrantid');

        let trIndex = $(this).closest(".setup-block-support").find($('.tr-payment-item-support')).length;
        let panelId = $(this).closest(".setup-block-support").find($('.collapse-payment-support')).data('panelid');
        // load Payment Items
        let getPaymentItems = getSyncData("<?= site_url('admin/payment_item/get_payment_item'); ?>", {
            category_type: category, sub_category, country_id: 2
        });
        let rowHtml = `
            <tr class="tr-payment-item-support">
                <td>
                    <select class="form-control setup-payment-item-support select2" name="setup[${panelId}][${trIndex}][payment_item]">
                        <option value=''>Select Payment Item</option>
                        ${JSON.parse(getPaymentItems).map(v => `<option value="${v.id}">${v.payment_item}</option>`).join('')}
                        <option value="__add_new__" data-category="payment_category_support" data-subcategory="select_sub_category_record_support" data-select="setup-payment-item-support"> <span class="glyphicon glyphicon-plus"></span> Add Payment Item</option>
                    </select>
                </td>
                <td><input type="text" class="form-control setup-idr convert-setup-idr" name="setup[${panelId}][${trIndex}][nominal_idr]"></td>
                <td><input type="text" class="form-control setup-usd convert-setup-usd" name="setup[${panelId}][${trIndex}][nominal_usd]"></td>
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

    // Hapus Payment Item
    $(document).on("click", ".remove-item-support", function(){
      if (confirm("Are you sure want to delete this ?")){
        $(this).closest("tr").remove();
        updateSubtotalSupport($(this).closest(".setup-block-support"));
        updateGlobalTotalSupport()
      }
    });

    $(document).on("click", ".add-grantee-support", async function(){
        showSwal('loading', 'Please wait while we process your request.');

        let $setupBlock = $(this).closest(".setup-block-support");
        let panelId = $setupBlock.find('.collapse-payment-support').data('panelid');
        let period_id   = $('#period_id').val(),
            grant_id    = $('#grant_id_bulk').val(),
            status      = $('#select-status-support-'+panelId).val(),
            category    = 'Grant Cost',
            sub_category= $('#sub_category_bulk').val(),
            year = $('#year').val();

        if(!status){
            Swal.close();
            return Swal.fire("Warning", "Please select a status!", "warning");
        }

        // get semua grantee berdasarkan status
        let getAllGrantee = await getAsyncData("<?= site_url('world/get_grantee_by_status/'); ?>" + status, {
            period_id : null, grant_id : grant_id, year : year
        });

        let grantees = [];
        try {
            grantees = JSON.parse(getAllGrantee);
        } catch(e) {
            Swal.close();
            return Swal.fire("Error", "Failed to load grantee data.", "error");
        }

        if(!grantees.length){
            Swal.close();
            return Swal.fire("Info", "No grantee found for this status.", "info");
        }

        let $setupRows = $setupBlock.find(".setup-payment-table-support tbody tr");
        if($setupRows.length === 0){
            Swal.close();
            return Swal.fire("Warning", "Please add at least 1 payment item!", "warning");
        }

        let granteeCard = '';

        // loop grantee
        for (const g of grantees) {
            //skip jika grantee sudah ada di panel
            const exists = $setupBlock.find(`.grantee-check-support[value="${g.user_grantee_id}"]`).length > 0;
            if (exists) {
                console.log(`Skip grantee ${g.full_name} (already exists in panel ${panelId})`);
                continue;
            }

            let getOptionBankInfo = await getAsyncData("<?= site_url('admin/grantee/get_bank_info/'); ?>" + g.user_grantee_id, {
                period_id, grant_id, status
            });

            let bankInfoList = [];
            try {
                bankInfoList = JSON.parse(getOptionBankInfo);
            } catch(e) {
                bankInfoList = [];
            }

            granteeCard += `
                <div class="panel panel-info grantee-card-support">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-sm-1">
                                <input type="checkbox" class="grantee-check-support" name="add_record[grantee][${panelId}][${g.id}][user_id]" value="${g.user_grantee_id}">
                            </div>
                            <div class="col-sm-2">
                                <strong>${g.full_name}</strong>
                            </div>

                            <div class="col-sm-2">
                                <select class="form-control select2 grantee-bank-info"
                                    name="add_record[grantee][${panelId}][${g.id}][bank_info_id]">
                                    <option value="">Select Bank Info</option>
                                    ${bankInfoList.map(v => `
                                        <option value="${v.id}" ${(v.id == '' || v.id == 0) ? "selected" : ""}>${v.bank_name} - ${v.account_number}</option>
                                    `).join('')}
                                </select>
                            </div>

                            <div class="col-sm-3">
                                <input type="file" id="proof_expense_${g.id}" name="proof_expense_${g.id}" class="form-control">
                            </div>

                            <div class="col-sm-3">
                                <input type="file" id="proof_${g.id}" name="proof_${g.id}" class="form-control">
                            </div>

                            <div class="col-sm-1 text-right">
                                <button type="button" class="btn btn-danger btn-xs hide-view remove-grantee-support">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        Swal.close();

        if (!granteeCard.trim()) {
            return Swal.fire("Info", "All selected grantees already exist in this panel.", "info");
        }

        let $container = $setupBlock.find(".grantee-container-support");
        if ($container.find(".grantee-check-support-all").length === 0) {
            $container.prepend(`
                <div class="mb-2">
                    <label>
                        <input type="checkbox" class="grantee-check-support-all"> Select All
                    </label>
                </div>
                <table class="table" style="margin-bottom:0px;">
                    <thead>
                        <tr>
                            <th width="9%">#</th>
                            <th width="17%" width="22%">Grantee Name</th>
                            <th width="17%">Bank Info</th>
                            <th width="25%">Proof of Expense</th>
                            <th>Proof of Transfer</th>
                        </tr>
                    </thead>
                </table>

            `);
        }
        $container.append(granteeCard);

        // append hasil
        // $setupBlock.find(".grantee-container-support").append(granteeCard);
        let allChecked = $container.find(".grantee-check-support").length === 
                        $container.find(".grantee-check-support:checked").length;
        $container.find(".grantee-check-support-all").prop("checked", allChecked);

        // update subtotal 
        updateSubtotalSupport($setupBlock);
    });

    // Hapus Grantee
    $(document).on("click", ".remove-grantee-support", function(){
      element = $(this);
      if (confirm("Are you sure want to delete this ?")){
        var paymentId = $(this).data('paymentid');
        recordDeletePaymentSupport(paymentId);

        var container = element.closest(".setup-block-support");

        $(this).closest(".grantee-card-support").remove();
        updateSubtotalSupport(container);
        
      }
    });


    function recordDeletePaymentSupport(id) {
        var deleted = $("#delete_payment_support").val();
        if(deleted == ''){
            $("#delete_payment_support").val(id);
        }else{
            var join_id = deleted + ',' + id;
            $("#delete_payment_support").val(join_id);
        }
    }

    // Update Subtotal saat nominal berubah
    $(document).on("input", ".setup-idr, .setup-usd", function(){
      let $setupBlock = $(this).closest(".setup-block-support");
      updateSubtotalSupport($setupBlock);
    });
    
    // jika klik checkbox individual
    $(document).on("change", ".grantee-check-support", function(){
      let $setupBlock = $(this).closest(".setup-block-support");

      let allChecked = $setupBlock.find(".grantee-check-support").length === 
                      $setupBlock.find(".grantee-check-support:checked").length;
      $setupBlock.find(".grantee-check-support-all").prop("checked", allChecked);

      updateSubtotalSupport($setupBlock);
    });

    // jika klik "Select All"
    $(document).on("change", ".grantee-check-support-all", function(){
      let $setupBlock = $(this).closest(".setup-block-support");
      let checked = $(this).is(":checked");

      $setupBlock.find(".grantee-check-support").prop("checked", checked);
      updateSubtotalSupport($setupBlock);
    });


    // Hitung Subtotal per setup
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

    // Hitung Total Global semua setup
    function updateGlobalTotalSupport(){
      let globalIdr = 0, globalUsd = 0;
      $(".setup-block-support").each(function(){
        globalIdr += parseIDR($(this).find(".subtotal-idr-support").text()) || 0;
        globalUsd += parseUSD($(this).find(".subtotal-usd-support").text()) || 0;
      });
      $("#global-idr-support").text(formatIDR(globalIdr));
      $("#global-usd-support").text(formatUSD(globalUsd));
    }


    // edit payment old
    $('#mdl_add_record_support').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var mode = button.data('mode');
        var grant_id = <?= $grant_id ?? '' ?>;
        var $modal = $(this);
        let record_id = button.data('record_id');
        let $container= $modal.find('.section_uss');
        let $modalBody= $modal.find('.modal-body');
        let $footer= $modal.find('.modal-footer');
        let $paymentItemSection= $modal.find('#setup-accordion-support');

        $modal.find('input[type="text"]:not(.date-default), input[type="number"], input[type="hidden"], textarea').val('');
        $modal.find('select').val('').trigger('change');
        $modal.find('input[type="checkbox"], input[type="radio"]').prop('checked', false);
        $('#grantee-container-support').html('');
        $('#grant_id_bulk_support').val(grant_id);

        if(mode == 'view' || mode == 'edit') {
          $container.addClass('hide')
          $footer.addClass('hide')
          $modalBody.append('<div class="text-center spinner-modal"><i class="fa fa-spinner fa-spin"></i> Loading...</div>');

          $.ajax({
            url: "<?= site_url('admin/payment_record/get_bulk_payment_support') ?>/" + record_id,
            type: "GET",
            dataType: "json",
            success: function(res){
                if(res.success){
                    // render isi panel dari data
                    Swal.close(); 
                    $container.removeClass('hide')
                    if(mode == 'edit'){
                      $footer.removeClass('hide')
                    }
                    $modalBody.find('.spinner-modal').remove();


                    var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                    var payment_date = new Date(res.data.general.payment_date);
                    var notify_date = res.data.general.notify_date ? new Date(res.data.general.notify_date) : '';
                    var deadline_date = res.data.general.deadline_date ? new Date(res.data.general.deadline_date) : '';

                    $('#payment_date_support').val( payment_date ? (payment_date.getDate() < 10 ? '0' + payment_date.getDate() : payment_date.getDate()) + ' ' + monthNames[payment_date.getMonth()] + ' ' + payment_date.getFullYear() : '');
                    $('.payment_category_support').val(res.data.general.category).trigger('change');
                    get_sub_category_support(
                        res.data.general.category,
                        '#select_sub_category_record_support',
                        res.data.general.sub_category_id
                    );
                    $('#year').val(year);
                    $('#grant_id_bulk_support').val(res.data.general.grant_id);
                    $('#bulk_id_support').val(res.data.id);
                    $('#description_support').val(res.data.general.description);
                    $('#admin_note_support').val(res.data.general.admin_note);
                    $('#deadline_date_support').val( deadline_date ? (deadline_date.getDate() < 10 ? '0' + deadline_date.getDate() : deadline_date.getDate()) + ' ' + monthNames[deadline_date.getMonth()] + ' ' + deadline_date.getFullYear() : '');
                    $('#priority_support').val(res.data.general.priority);
                    $('#status_support').val(res.data.general.status);
                    $('#user_grantee_grant_memo_id_support').val(res.data.general.user_grantee_grant_memo_id);
                    $('#notify_grantee_support').prop('checked', res.data.general.notify_grantee == 1);

                    
                    if(res.data.general.proof != null){
                      $('#label-view-proof')
                        .attr('href', BASEURL + res.data.general.proof).find("label")
                        .removeClass("label-default")
                        .addClass("label-primary")
                        .text("View Proof");
                    }else{
                      $("#label-view-proof")
                          .attr("href", "javascript:void(0);")
                          .on("click", function(){ return false; })
                          .find("label")
                          .removeClass("label-primary")
                          .addClass("label-default")
                          .text("Not Uploaded yet");
                    }

                    let amountType = res.data.general.amount_type || 'same';
                    $(`input[name="add_record[amount_type]"][value="${amountType}"]`).prop('checked', true).trigger('change');

                    if (amountType === 'different') {
                        let diffHtml = renderDifferentPaymentPanelSupport(res.data);
                        $('#grantee-list-different').html(diffHtml);
                    } else {
                        let html = renderPaymentPanelSupport(res.data);
                        $paymentItemSection.html(html);

                        res.data.setups.forEach(function(setup, idx){
                            setup.items.forEach(function(item, inItem){
                                let name = `setup[${idx}][${inItem}][payment_item]`;
                                $(`select[name="${name}"]`).val(item.item_id).trigger('change')
                            });
                        });
                    }

                    // reinit select2 / selectpicker
                    $container.find('.selectpicker').selectpicker('refresh');
                    $container.find('.select2').select2();
                    $modalBody.find(".setup-block-support").each(function(){
                      updateSubtotalSupport($(this));
                    });
                    updateGlobalTotalDifferent();
                    $('.lightbox').topbox();
                } else {
                    $container.html('<div class="alert alert-danger">Failed to load data</div>');
                }
            },
            error: function(){
                $container.html('<div class="alert alert-danger">Error loading data</div>');
            }
          });

              
          if(mode == 'view'){
              $('.form-control-view').prop('disabled', true);
              $('.form-control-view-diff').prop('disabled', true);
              $('.modal-footer, .hide-view, .edit-add-more-data-payment').addClass('hide')
              $('#exampleModalLabelGrantee').text('View Bulk Grant Support')
              $footer.addClass('hide')
              $('input[name="add_record[amount_type]"]').prop('disabled', true);
          }else{
              $('.form-control-view').prop('disabled', false);
              $('.form-control-view-diff').prop('disabled', false);
              $('.modal-footer, .hide-view, .edit-add-more-data-payment').removeClass('hide')
              $('#exampleModalLabelGrantee').text('Edit Bulk Grant Support')
              $(".radio-for").prop('disabled', true);
              $('input[name="add_record[amount_type]"]').prop('disabled', false);
          }
          lockSelect2('#sub_category_bulk')
          lockSelect2('#disbursment')

          $('#sub_category_bulk, #disbursment').addClass('readonly-selectpicker');
        }else if(mode == 'add'){
            $modal.find('form')[0].reset();
            // $('#payment_date_support').val('');
            $('.payment_category_support').val('');
            $('.select_sub_category_record_support').val('');
            $('#bulk_id_support').val('');
            $('#description_support').val('');
            $('#admin_note_support').val('');
            $('#deadline_date_support').val('');
            $('#priority_support').val('');
            $('#status_support').val('');
            $('#notify_grantee_support').prop('checked', false);

            // reset to same amount default
            $('input[name="add_record[amount_type]"][value="same"]').prop('checked', true).trigger('change');

            // kosongkan wrap grantee
            $paymentItemSection.html('');
            $('#grantee-list-different').html('');
            $('#exampleModalLabelGrantee').text('Add Bulk Grant Support');
            $('.form-control-view').prop('disabled', false);
            $('.form-control-view-diff').prop('disabled', false);
            $('.modal-footer, .hide-view, .edit-add-more-data-payment').removeClass('hide')
            $('input[name="add_record[amount_type]"]').prop('disabled', false);
            updateSubtotalSupport($modalBody.find(".setup-block-support"));
            updateGlobalTotalDifferent();
            $('#status_support').val(5);
            $('#grant_id_bulk_support').val(grant_id);
            $('#year').val(year);
            $('#sub_category_bulk, #disbursment').removeClass('readonly-selectpicker');
        }


            
    });
    // end edit payment bulk old


    function renderDifferentPaymentPanelSupport(data){
        let html = '';
        data.setups.forEach(function(setup, idx){
            let selectedGrantees = setup.grantees || [];
            let category = data.general.category || $('.payment_category_support').val();
            let sub_category = data.general.sub_category_id || $('#select_sub_category_record_support').val();

            selectedGrantees.forEach(function(g, i){
                let getOptionBankInfo = getSyncData("<?= site_url('admin/grantee/get_bank_info/'); ?>" + g.user_id);
                let bankInfoList = [];
                try { bankInfoList = JSON.parse(getOptionBankInfo); } catch(e) {}

                let proofExpenseHtml = g.proof_expense
                    ? `<a href="${BASEURL + g.proof_expense}" class="lightbox"><label class="label label-primary" disabled>View Proof Expense</label></a>`
                    : '';
                let proofHtml = g.proof
                    ? `<a href="${BASEURL + g.proof}" class="lightbox"><label class="label label-primary" disabled>View Proof</label></a>`
                    : '';

                let itemsHtml = `<table class="table table-bordered diff-payment-table"><thead><tr><th style="min-width:200px;">Payment Item</th><th style="min-width:120px;">Nominal IDR</th><th style="min-width:120px;">Nominal USD</th><th style="width:50px;">Action</th></tr></thead><tbody>`;
                if (g.items) {
                    g.items.forEach(function(item, inItem){
                        let getPaymentItems = getSyncData("<?= site_url('admin/payment_item/get_payment_item'); ?>", {
                            category_type: category, sub_category: sub_category, country_id: 2
                        });
                        itemsHtml += `
                        <tr class="tr-diff-item">
                            <td>
                                <select class="form-control diff-payment-item select2 form-control-view-diff"
                                    name="different_setup[${g.grantee_grant_id}][${inItem}][payment_item]">
                                    <option value=''>Select Payment Item</option>
                                    ${JSON.parse(getPaymentItems).map(v => `<option value="${v.id}" ${v.id == item.item_id ? 'selected' : ''}>${v.payment_item}</option>`).join('')}
                                </select>
                            </td>
                            <td><input type="text" class="form-control diff-idr convert-setup-idr form-control-view-diff" name="different_setup[${g.grantee_grant_id}][${inItem}][nominal_idr]" value="${item.idr}"></td>
                            <td><input type="text" class="form-control diff-usd convert-setup-usd form-control-view-diff" name="different_setup[${g.grantee_grant_id}][${inItem}][nominal_usd]" value="${item.usd}"></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm remove-diff-item hide-view"><span class="glyphicon glyphicon-trash"></span></button>
                            </td>
                        </tr>`;
                    });
                }
                itemsHtml += `</tbody></table>
                <button class="btn btn-info btn-sm add-diff-item hide-view" type="button">
                    <span class="glyphicon glyphicon-plus"></span> Add Payment Item
                </button>
                <div class="diff-subtotal pull-right" style="margin-top:5px;">
                    Subtotal: <span class="diff-subtotal-idr">0</span> | <span class="diff-subtotal-usd">0</span>
                </div>`;

                let panelId = `diffGranteeEdit${i}`;
                html += `
                <div class="panel panel-info grantee-card-diff" data-grantee_grant_id="${g.grantee_grant_id}" data-user_id="${g.user_id}">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <input type="checkbox" class="grantee-check-diff form-control-view-diff" checked
                                name="add_record[grantee][0][${g.grantee_grant_id}][user_id]"
                                value="${g.user_id}">
                            <input type="hidden" name="add_record[grantee][0][${g.grantee_grant_id}][payment_id]" value="${g.payment_id}">
                            <a data-toggle="collapse" href="#${panelId}">
                                <strong>${g.grantee_name}</strong>
                                <i class="fa fa-chevron-up diff-collapse-icon" style="font-size:11px;margin-left:5px;"></i>
                            </a>
                            <div class="pull-right">
                                <button type="button" class="btn btn-danger btn-xs remove-grantee-diff hide-view">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </button>
                            </div>
                        </h4>
                    </div>
                    <div id="${panelId}" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <div class="row" style="margin-bottom:10px;">
                                <div class="col-sm-4">
                                    <label style="font-weight:normal;font-size:12px;">Bank Info</label>
                                    <select class="form-control input-sm select2 grantee-bank-info-diff form-control-view-diff"
                                        name="add_record[grantee][0][${g.grantee_grant_id}][bank_info_id]">
                                        <option value="">Select Bank Info</option>
                                        ${bankInfoList.map(v => `
                                            <option value="${v.id}" ${v.id == g.bank_info_id ? 'selected' : ''}>
                                                ${v.bank_name} - ${v.account_number}
                                            </option>
                                        `).join('')}
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label style="font-weight:normal;font-size:12px;">Proof of Expense</label>
                                    <input type="file" id="proof_expense_diff_${g.grantee_grant_id}" name="proof_expense_diff_${g.grantee_grant_id}" class="form-control input-sm">
                                    ${proofExpenseHtml}
                                </div>
                                <div class="col-sm-4">
                                    <label style="font-weight:normal;font-size:12px;">Proof of Transfer</label>
                                    <input type="file" id="proof_diff_${g.grantee_grant_id}" name="proof_diff_${g.grantee_grant_id}" class="form-control input-sm">
                                    ${proofHtml}
                                </div>
                            </div>
                            ${itemsHtml}
                        </div>
                    </div>
                </div>`;
            });
        });
        return html;
    }

    function renderPaymentPanelSupport(data){  
        // return false
        let html = '';
        data.setups.forEach(function(setup, idx){
            let panelId = idx;
            let selectedGrantees = setup.grantees || [];


            html += `

            <div class="panel panel-primary setup-block-support">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <button type="button" class="btn btn-danger btn-xs pull-left hide-view remove-setup-support" style="margin-right:10px;">
                    <span class="glyphicon glyphicon-remove"></span>
                  </button>
                  <a data-toggle="collapse" data-parent="#setup-accordion-support" href="#setupSupport${panelId}">
                    Payment Item
                    <span class="pull-right subtotal">
                      Subtotal: <span class="subtotal-idr-support">0</span> | <span class="subtotal-usd-support">0</span>
                    </span>
                  </a>
                </h4>
              </div>
              <div id="setup${panelId}" class="collapse-payment-support panel-collapse collapse in" data-panelid="${panelId}"style="border:1px solid #337ab7;">
                <div class="panel-body">
                  <!-- Payment Item Table -->
                  <table class="table table-bordered setup-payment-table-support">
                    <thead>
                      <tr>
                        <th>Payment Item</th>
                        <th>Nominal IDR</th>
                        <th>Nominal USD</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>`;

                    let category    = $('.payment-category-record-support').val(),
                        sub_category= $('#select_sub_category_record_support').val(),
                        selectedOpt = $('#select-grantee-support option:selected'),
                        grantee_grant_id = $(this).data('granteegrantid');
                    // load Payment Items
                    let getPaymentItems = getSyncData("<?= site_url('admin/payment_item/get_payment_item'); ?>", {
                        category_type: category, sub_category, country_id: 2
                    });
                    setup.items.forEach(function(item, inItem){

                        // let trIndex = $(this).closest(".setup-block-support").find($('.tr-payment-item-support')).length;
                        html += `
                      <tr class="tr-payment-item-support">
                          <td>
                              <select class="form-control setup-payment-item-support select2" data-selected="${item.item_id}" name="setup[${panelId}][${inItem}][payment_item]">
                                  <option value=''>Select Payment Item</option>
                              </select>
                          </td>
                          <td><input type="text" class="form-control setup-idr convert-setup-idr" name="setup[${panelId}][${inItem}][nominal_idr]" value="${item.idr}"></td>
                          <td><input type="text" class="form-control setup-usd convert-setup-usd" name="setup[${panelId}][${inItem}][nominal_usd]" value="${item.usd}"></td>
                          <td class="text-center">
                              <button type="button" class="hide-view btn btn-danger btn-sm hide-view remove-item-support"><span class="glyphicon glyphicon-trash"></span></button>
                          </td>
                      </tr>`;
                    });
            html += `
                    </tbody>
                  </table>`;


            html +=`
                  <button class="btn btn-info btn-sm hide-view add-setup-support-item" type="button">
                    <span class="glyphicon glyphicon-plus"></span> Add Payment Item
                  </button>

                  <hr>

                  <!-- Grantee Selection -->
                  <h5><strong>Select Grantee</strong></h5>
                  <div class="form-inline">
                      <select class="form-control-view form-control select-status-support" id="select-status-support-${panelId}" name="add_record[status_grantee]">
                          <option value="">-- Select Status --</option>
                          <option value="<?= STATUS_FINALIST ?>">Finalist</option>
                          <option value="<?= STATUS_NEW_GRANTEE ?>">Incoming Grantee</option>
                          <option value="<?= STATUS_VISA_APPLICATION ?>">Visa Application</option>
                          <option value="<?= CURRENT_GRANTEE ?>">Current Grantee</option>
                      </select>
                      <select class="form-control-view form-control select-grantee-support selectpicker hide" id="select-grantee-support-${panelId}" data-live-search="true">
                          <option value="">-- Select Grantee --</option>
                          <?php foreach ($user_grantee as $grantee) { ?>
                              <option value="<?php echo $grantee->user_grantee_id; ?>" data-grantee_grant_id="<?php echo $grantee->grantee_grant_id; ?>" data-grantee_name="<?php echo get_full_name($grantee, 'US'); ?>"><?php echo get_full_name($grantee, 'US'); ?></option>
                          <?php } ?>
                      </select>
                      <button class="btn btn-primary btn-sm add-grantee-support" type="button">
                          <span class="glyphicon glyphicon-plus"></span> Add Grantee
                      </button>
                  </div>

                  <!-- Grantee Container -->
                  <div class="grantee-container-support" style="margin-top:15px;">`;
                  
                  if (selectedGrantees.length) {
                    html += `
                        <div class="panel panel-default mb-2 p-2 border">
                            <div class="checkbox mb-2">
                                <label><input type="checkbox" class="grantee-check-support-all"> <strong>Select All</strong></label>
                            </div>
                        </div>
                        <table class="table" style="margin-bottom:0px;">
                            <thead>
                                <tr>
                                    <th width="9%">#</th>
                                    <th width="17%" width="22%">Grantee Name</th>
                                    <th width="17%">Bank Info</th>
                                    <th width="25%">Proof of Expense</th>
                                    <th>Proof of Transfer</th>
                                </tr>
                            </thead>
                        </table>
                    `;
                  }

                  // ========================
                  // ONLY SHOW SAVED GRANTEES
                  // ========================
                  selectedGrantees.forEach((g, i) => {
                      let getOptionBankInfo = getSyncData("<?= site_url('admin/grantee/get_bank_info/'); ?>" + g.user_id);
                      let bankInfoList = [];
                      try {
                          bankInfoList = JSON.parse(getOptionBankInfo);
                      } catch (e) {}

                      let proofExpenseHtml = g.proof_expense 
                          ? `<a href="${BASEURL + g.proof_expense}" class="lightbox"><label class="label label-primary" disabled>View Proof Expense</label></a>`
                          : '';
                      let proofHtml = g.proof 
                          ? `<a href="${BASEURL + g.proof}" class="lightbox"><label class="label label-primary" disabled>View Proof</label></a>`
                          : '';

                      html += `
                      <div class="panel panel-info grantee-card-support">
                        <div class="panel-heading">
                          <div class="row align-items-center">
                            <div class="col-sm-1">
                              <input type="checkbox" class="grantee-check-support" checked
                                name="add_record[grantee][${panelId}][${g.grantee_grant_id}][user_id]"
                                value="${g.user_id}">
                              <input type="hidden" name="add_record[grantee][${panelId}][${g.grantee_grant_id}][payment_id]" value="${g.payment_id}">
                            </div>
                            <div class="col-sm-2">
                              <strong>${g.grantee_name}</strong>
                            </div>
                            <div class="col-sm-2">
                              <select class="form-control select2 grantee-bank-info"
                                name="add_record[grantee][${panelId}][${g.grantee_grant_id}][bank_info_id]">
                                <option value="">Select Bank Info</option>
                                ${bankInfoList.map(v => `
                                    <option value="${v.id}" ${v.id == g.bank_info_id ? 'selected' : ''}>
                                      ${v.bank_name} - ${v.account_number}
                                    </option>
                                `).join('')}
                              </select>
                            </div>
                            <div class="col-sm-3">
                              <input type="file" id="proof_expense_${g.grantee_grant_id}" name="proof_expense_${g.grantee_grant_id}" class="form-control">
                              ${proofExpenseHtml}
                            </div>
                            <div class="col-sm-3">
                              <input type="file" id="proof_${g.grantee_grant_id}" name="proof_${g.grantee_grant_id}" class="form-control">
                              ${proofHtml}
                            </div>
                            <div class="col-sm-1 text-right">
                              <button type="button" class="btn btn-danger btn-xs hide-view remove-grantee-support">
                                <span class="glyphicon glyphicon-remove"></span>
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>`;
                  });

                  html +=`
                  </div>
                </div>
              </div>
            </div>`;
        });
        return html;
    }

</script>