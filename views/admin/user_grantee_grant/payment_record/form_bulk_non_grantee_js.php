<style>
.panel-primary .panel-title {
    display: flex;
    align-items: center;
}
.panel-primary .panel-title a {
    flex: 1;
    display: flex;
    align-items: center;
}
.panel-primary .panel-title a .collapse-icon {
    transition: transform .2s ease;
}
.panel-primary .panel-title a.collapsed .collapse-icon {
    transform: rotate(-90deg);
}
.panel-primary .panel-title a .subtotal {
    margin-left: auto;
}
.panel-primary .panel-title .remove-setup-non-grantee {
    margin-left: 10px;
    margin-right: 6px;
}
#mdl_add_record_bulk .modal-dialog {
    width: 96%;
    max-width: none;
}
.vendor-table-wrap {
    overflow-x: auto;
    border: 1px solid #dcdfe6;
    border-radius: 6px;
    background: #fff;
    box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    margin-bottom: 12px;
}
.vendor-table-non-grantee {
    width: 100%;
    min-width: 1920px;
    margin-bottom: 0;
    /* border-collapse: separate; */
    border-spacing: 0;
}
.vendor-table-non-grantee thead th {
    text-align: left;
    vertical-align: middle;
    white-space: nowrap;
    background: #f1f5f9;
    color: #334155;
    font-size: 12px;
    font-weight: 700;
    /* text-transform: uppercase; */
    letter-spacing: 0.5px;
    padding: 10px 8px;
    border-top: none;
    border-bottom: 2px solid #cbd5e1;
    border-right: 1px solid #e2e8f0;
}
.vendor-table-non-grantee thead th:first-child {
    position: sticky;
    left: 0;
    z-index: 4;
    background: #e2e8f0;
    box-shadow: 3px 0 6px -2px rgba(0,0,0,0.12);
}
.vendor-table-non-grantee thead th:last-child {
    position: sticky;
    right: 0;
    z-index: 4;
    background: #e2e8f0;
    text-align: center;
    box-shadow: -3px 0 6px -2px rgba(0,0,0,0.12);
}
.vendor-table-non-grantee tbody td {
    padding: 6px 8px !important;
    vertical-align: middle !important;
    border-top: none;
    border-bottom: 1px solid #e2e8f0;
    border-right: 1px solid #f1f5f9;
    background: #fff;
}
.vendor-table-non-grantee tbody tr:hover td {
    background-color: #f8fafc;
}
.vendor-table-non-grantee tbody td:first-child {
    position: sticky;
    left: 0;
    z-index: 3;
    background: #fff;
    box-shadow: 3px 0 6px -2px rgba(0,0,0,0.08);
}
.vendor-table-non-grantee tbody tr:hover td:first-child {
    background-color: #f8fafc;
}
.vendor-table-non-grantee tbody td:last-child {
    position: sticky;
    right: 0;
    z-index: 3;
    background: #fff;
    text-align: center;
    box-shadow: -3px 0 6px -2px rgba(0,0,0,0.08);
}
.vendor-table-non-grantee tbody tr:hover td:last-child {
    background-color: #f8fafc;
}
.vendor-table-non-grantee .form-control {
    height: 32px;
    font-size: 12px;
    padding: 4px 8px;
    border-radius: 4px;
    border: 1px solid #cbd5e1;
}
.vendor-table-non-grantee .form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.15);
}
.vendor-table-non-grantee .select2-container {
    width: 100% !important;
}
.vendor-table-non-grantee .select2-container .select2-selection--single {
    height: 32px !important;
    border: 1px solid #cbd5e1 !important;
    border-radius: 4px !important;
}
.vendor-table-non-grantee .select2-container .select2-selection--single .select2-selection__rendered {
    line-height: 30px !important;
    font-size: 12px !important;
    padding-left: 8px !important;
    padding-right: 20px !important;
}
.vendor-table-non-grantee .select2-container .select2-selection--single .select2-selection__arrow {
    height: 30px !important;
    right: 4px !important;
}
/* Virtual Account styling */
.vendor-table-non-grantee td.va-disabled-cell {
    background-color: #f8fafc !important;
}
.vendor-table-non-grantee .form-control.va-disabled-field {
    background-color: #f1f5f9 !important;
    border-color: #e2e8f0 !important;
    color: #94a3b8 !important;
    cursor: not-allowed !important;
    box-shadow: none !important;
    text-align: center !important;
}
.vendor-row-non-grantee.va-row input[data-field="vendor_name"] {
    border-color: #10b981;
    background-color: #f0fdf4;
}
.vendor-row-non-grantee.va-row input[data-field="vendor_name"]:focus {
    border-color: #059669;
    box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
}
.vendor-field-non-grantee.vendor-field-plain-text {
    border: none;
    background: transparent;
    box-shadow: none;
    padding: 6px 0;
    cursor: default;
    height: auto;
}
.vendor-proof-upload input[type="file"] {
    font-size: 11px;
    max-width: 170px;
}
.vendor-proof-upload .file-for-testing {
    font-size: 10px;
    color: #64748b;
    display: block;
}
.va-info-hint {
    display: inline-block;
    margin-left: 10px;
    font-size: 12px;
    color: #2563eb;
    background: #eff6ff;
    padding: 3px 8px;
    border-radius: 4px;
    border: 1px solid #bfdbfe;
    font-weight: normal;
}
</style>
<script>


    function vendorSelectOptionsNonGrantee(selectedId = '') {
        let options = '<option value="">-- Select Vendor --</option>';
        <?php foreach($vendors as $vendor) { ?>
            options += `<option
                data-vendor_name="<?= htmlspecialchars($vendor->name, ENT_QUOTES); ?>"
                data-vendor_id="<?= $vendor->id; ?>"
                data-vendor_address="<?= htmlspecialchars($vendor->address, ENT_QUOTES); ?>"
                data-vendor_beneficiary_name="<?= htmlspecialchars($vendor->beneficiary_name, ENT_QUOTES); ?>"
                data-vendor_bank_name="<?= htmlspecialchars($vendor->bank_name, ENT_QUOTES); ?>"
                data-vendor_bank_address="<?= htmlspecialchars($vendor->bank_address, ENT_QUOTES); ?>"
                data-vendor_account_number="<?= htmlspecialchars($vendor->account_number, ENT_QUOTES); ?>"
                data-vendor_swift_code="<?= htmlspecialchars($vendor->swift_code, ENT_QUOTES); ?>"
                data-vendor_routing_number="<?= htmlspecialchars($vendor->routing_number, ENT_QUOTES); ?>"
                value="<?= $vendor->id; ?>"
                ${selectedId !== '' && <?= $vendor->id ?> == selectedId ? "selected" : ""}><?= htmlspecialchars($vendor->name, ENT_QUOTES); ?></option>`;
        <?php } ?>
        options += `<option value="0" data-vendor_name="Other" ${selectedId !== '' && selectedId == 0 ? "selected" : ""}>Other</option>`;
        return options;
    }

    let vendorRowSeqNonGrantee = 0;

    function bindVendorRowSelectNonGrantee($select){
        $select.off('.vendorRowNonGrantee');
        $select.on('change.vendorRowNonGrantee', function(){
            let $row = $(this).closest("tr");
            let selectedOpt = $(this).find("option:selected");
            let vendorName = selectedOpt.attr('data-vendor_name');
            let vendorId = $(this).val();
            let isEmpty = vendorId === '' || vendorId === null;
            let paymentMethod = $row.find('.payment-method-select-non-grantee').val();

            if (paymentMethod === 'va') {
                if (!isEmpty && vendorName !== 'Other') {
                    $row.find('.vendor-field-non-grantee[data-field="vendor_name"]').val(vendorName);
                    $row.find(".vendor-id-hidden-non-grantee").val(vendorId);
                } else {
                    $row.find(".vendor-id-hidden-non-grantee").val('0');
                }
                updatePaymentMethodRow($row);
                return;
            }

            let $fields = $row.find(".vendor-field-non-grantee");
            if (!isEmpty && vendorName !== 'Other') {
                $fields.each(function(){
                    let attrKey = $(this).attr('data-field');
                    $(this).val(selectedOpt.attr('data-' + attrKey) || '')
                           .prop('readonly', false)
                           .prop('disabled', false);
                });
                $row.find(".vendor-id-hidden-non-grantee").val(vendorId);
            } else if (isEmpty) {
                $fields.val('')
                    .prop('disabled', true)
                    .prop('readonly', false);
                $row.find(".vendor-id-hidden-non-grantee").val('');
            } else {
                $fields.val('')
                    .prop('disabled', false)
                    .prop('readonly', false);
                $row.find(".vendor-id-hidden-non-grantee").val('0');
            }
            updatePaymentMethodRow($row);
        });
    }

    function updatePaymentMethodRow($row, forcedMode = null) {
        let paymentMethod = $row.find('.payment-method-select-non-grantee').val();
        let vendorId = $row.find('.vendor-id-hidden-non-grantee').val();
        let $nameField = $row.find('.vendor-field-non-grantee[data-field="vendor_name"]');
        let $bankFields = $row.find('.vendor-field-non-grantee').not('[data-field="vendor_name"]');
        let isViewMode = (forcedMode === 'view') || ($('#mdl_add_record_bulk').data('current-mode') === 'view');

        if (paymentMethod === 'va') {
            $row.addClass('va-row');
            // 1. Name is editable and enabled (unless in pure view mode)
            $nameField
                .prop('disabled', isViewMode)
                .prop('readonly', false)
                .removeClass('vendor-field-plain-text va-disabled-field')
                .attr('placeholder', 'Enter Name / VA Recipient');
            $nameField.closest('td').removeClass('va-disabled-cell');

            // 2. All bank details fields are disabled for VA
            $bankFields.each(function() {
                let $f = $(this);
                if ($f.val() !== '') {
                    $f.data('prev-val', $f.val());
                }
                $f.val('')
                  .prop('disabled', true)
                  .prop('readonly', true)
                  .addClass('va-disabled-field')
                  .attr('placeholder', '-');
                $f.closest('td').addClass('va-disabled-cell');
            });

            // Ensure vendor_id has at least '0' (Other) so validation passes when user inputs name
            if (vendorId === '' || vendorId === null) {
                $row.find('.vendor-id-hidden-non-grantee').val('0');
            }
        } else {
            $row.removeClass('va-row');
            $bankFields.each(function() {
                $(this).removeClass('va-disabled-field')
                       .attr('placeholder', '');
                $(this).closest('td').removeClass('va-disabled-cell');
            });
            $nameField.attr('placeholder', '');

            if (isViewMode) {
                $row.find('.vendor-field-non-grantee').prop('disabled', true);
                return;
            }

            let $vendorSelect = $row.find('.vendor-select-non-grantee');
            let selectedVendorId = $vendorSelect.val();
            let selectedOpt = $vendorSelect.find('option:selected');

            if (selectedVendorId && selectedVendorId !== '0' && selectedVendorId !== '') {
                // Predefined vendor
                $row.find('.vendor-field-non-grantee').each(function() {
                    let attrKey = $(this).attr('data-field');
                    $(this).val(selectedOpt.attr('data-' + attrKey) || '')
                           .prop('readonly', false)
                           .prop('disabled', false);
                });
                $row.find('.vendor-id-hidden-non-grantee').val(selectedVendorId);
            } else if (selectedVendorId === '0' || vendorId === '0') {
                // Other vendor
                $row.find('.vendor-field-non-grantee').each(function() {
                    let prev = $(this).data('prev-val');
                    if (prev !== undefined && $(this).val() === '') {
                        $(this).val(prev);
                    }
                    $(this).prop('disabled', false)
                           .prop('readonly', false);
                });
                $row.find('.vendor-id-hidden-non-grantee').val('0');
            } else {
                // Empty vendor
                $row.find('.vendor-field-non-grantee')
                       .val('')
                       .prop('disabled', true)
                       .prop('readonly', false);
                $row.find('.vendor-id-hidden-non-grantee').val('');
            }
        }
    }

    $(document).on('change', '.payment-method-select-non-grantee', function(){
        let $row = $(this).closest('.vendor-row-non-grantee');
        updatePaymentMethodRow($row);
    });

    $(document).on('input', '.vendor-row-non-grantee input[data-field="vendor_name"]', function(){
        let $row = $(this).closest('.vendor-row-non-grantee');
        let pm = $row.find('.payment-method-select-non-grantee').val();
        if (pm === 'va') {
            let $hidden = $row.find('.vendor-id-hidden-non-grantee');
            if ($hidden.val() === '') {
                $hidden.val('0');
            }
        }
    });

    function recordDeletePaymentNonGrantee(id) {
        if(id == undefined || id == null || id === '' || isNaN(id)) return;
        var deleted = $("#delete_payment_non_grantee").val();
        if(deleted == ''){
            $("#delete_payment_non_grantee").val(id);
        }else{
            var join_id = deleted + ',' + id;
            $("#delete_payment_non_grantee").val(join_id);
        }
    }

    $(document).on("input", ".setup-idr-non-grantee, .setup-usd-non-grantee", function(){
      let $setupBlock = $(this).closest(".setup-block-non-grantee");
      updateSubtotalNonGrantee($setupBlock);
    });

    function updateGlobalTotalNonGrantee(){
      let globalIdr = 0, globalUsd = 0;
      $(".setup-block-non-grantee").each(function(){
        globalIdr += parseIDR($(this).find(".subtotal-idr-non-grantee").text()) || 0;
        globalUsd += parseUSD($(this).find(".subtotal-usd-non-grantee").text()) || 0;
      });
      $("#global-idr-non-grantee").text(formatIDR(globalIdr));
      $("#global-usd-non-grantee").text(formatUSD(globalUsd));
    }

    function updateSubtotalNonGrantee($setupBlock){
      let idrTotal = 0, usdTotal = 0;
      $setupBlock.find("tbody tr").each(function(){
        let idr = parseIDR($(this).find(".setup-idr-non-grantee").val()) || 0;
        let usd = parseUSD($(this).find(".setup-usd-non-grantee").val()) || 0;
        idrTotal += idr;
        usdTotal += usd;
      });
      let $vendorLength = $setupBlock.find(".vendor-row-non-grantee").length;

      let countVendor = $vendorLength == 0 ? 1 : $vendorLength;
      $setupBlock.find(".subtotal-idr-non-grantee").text(formatIDR(idrTotal*countVendor));
      $setupBlock.find(".subtotal-usd-non-grantee").text(formatUSD(usdTotal*countVendor));
      updateGlobalTotalNonGrantee();
    }

    $('.select-category-non-grantee').on('change', function() {
        var sub_category = '.select-sub-category-non-grantee';

        $(sub_category).empty();
        $(sub_category).append('<option value="">Select Sub Category</option>');
        get_sub_category_non_grantee($(this).val(),sub_category);
        // $(this).closest('div').find('.payment-category-record-validation').addClass('hide');
    });

    function get_sub_category_non_grantee(category_type,select_sub_category,callback) {
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
                if (typeof callback === 'function') callback();
            }
        });
    }

    let setupIndexNonGrantee = 0;
    $("#add-setup-non-grantee").click(function(){
      let panelId = $('.collapse-payment-non-grantee').length;

      let setupHtml = `
      <div class="panel panel-primary setup-block-non-grantee">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#setup-accordion-non-grantee" href="#setup-non-grantee${panelId}">
              <span class="glyphicon glyphicon-chevron-down collapse-icon" style="margin-right:5px;"></span>
              Setup Payment Item
              <span class="subtotal">
                Subtotal: <span class="subtotal-idr-non-grantee">0</span> | <span class="subtotal-usd-non-grantee">0</span>
              </span>
            </a>
            <button type="button" class="btn btn-danger btn-xs hide-view remove-setup-non-grantee">
              <span class="glyphicon glyphicon-remove"></span>
            </button>
          </h4>
        </div>
        <div id="setup-non-grantee${panelId}" class="collapse-payment-non-grantee panel-collapse collapse in" data-panelid="${panelId}" style="border:1px solid #337ab7;">
          <div class="panel-body">
            <h5><strong>Payment Items</strong></h5>
            <table class="table table-bordered setup-payment-table-non-grantee">
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
            <button class="btn btn-info btn-sm hide-view add-setup-item-non-grantee" type="button">
              <span class="glyphicon glyphicon-plus"></span> Add Payment Item
            </button>

            <hr>
            <h5><strong>Third Party</strong></h5>
            <div class="vendor-table-wrap">
                <table class="table table-bordered vendor-table-non-grantee">
                  <thead>
                    <tr>
                      <th>Vendor</th>
                      <th>Payment Method</th>
                      <th>Vendor Name</th>
                      <th>Beneficiary Name (As listed on the bank account)</th>
                      <th>Beneficiary Address: [Building/Street, City, State/Province + Postal Code, Country]</th>
                      <th>Bank Name</th>
                      <th>Bank Address: [Building/Street, City, State/Province + Postal Code, Country]</th>
                      <th>Account Number</th>
                      <th>SWIFT Code</th>
                      <th>Routing or ABA Number (for U.S. Banks)</th>
                      <th>Grantee</th>
                      <th>Proof of Transfer/Invoice</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
            </div>

            <div style="margin-top:10px;">
                <button class="btn btn-primary btn-sm add-vendor" type="button">
                    <span class="glyphicon glyphicon-plus"></span> Add Third Party
                </button>
            </div>
          </div>
        </div>
      </div>`;

      $("#setup-accordion-non-grantee .panel-collapse.collapse.in").collapse('hide');
      $("#setup-accordion-non-grantee").append(setupHtml);
      $('.selectpicker').selectpicker('refresh');
      setupIndexNonGrantee++;
    });

    $(document).on("click", ".remove-setup-non-grantee", function(){
      if (confirm("Are you sure want to delete this ?")){

        let setupBlock = $(this).closest('.setup-block-non-grantee');
        let removeVendor = setupBlock.find('.remove-vendor');
        removeVendor.each(function(){
          var paymentId = $(this).data('paymentid');
          recordDeletePaymentNonGrantee(paymentId);
        });
        $(this).closest(".setup-block-non-grantee").remove();
        updateGlobalTotalNonGrantee();
      }
    });

    $(document).on("click", ".add-setup-item-non-grantee", function(){
        let $tbody = $(this).closest(".setup-block-non-grantee").find(".setup-payment-table-non-grantee tbody");
        let category    = $('.select-category-non-grantee').val(),
            sub_category= $('.select-sub-category-non-grantee').val();

        let trIndex = $(this).closest(".setup-block-non-grantee").find($('.tr-payment-item-non-grantee')).length;
        let panelId = $(this).closest(".setup-block-non-grantee").find($('.collapse-payment-non-grantee')).data('panelid');
        // load Payment Items
        let getPaymentItems = getSyncData("<?= site_url('admin/payment_item/get_payment_item'); ?>", {
            category_type: category, sub_category, country_id: 2
        });

        if(sub_category == '') return alert("Please add select sub category!");

        let rowHtml = `
            <tr class="tr-payment-item-non-grantee">
                <td>
                    <select class="form-control setup-payment-item-non-grantee select2" name="setup[${panelId}][${trIndex}][payment_item]">
                        <option value=''>Select Payment Item</option>
                        ${JSON.parse(getPaymentItems).map(v => `<option value="${v.id}">${v.payment_item}</option>`).join('')}
                        <option value="__add_new__" data-category="category_id_record_bulk" data-subcategory="payment_sub_category_id_record_bulk" data-select="setup-payment-item-non-grantee"> <span class="glyphicon glyphicon-plus"></span> Add Payment Item</option>
                    </select>
                </td>
                <td><input type="text" class="form-control setup-idr-non-grantee convert-setup-idr" name="setup[${panelId}][${trIndex}][nominal_idr]"></td>
                <td><input type="text" class="form-control setup-usd-non-grantee convert-setup-usd" name="setup[${panelId}][${trIndex}][nominal_usd]"></td>
                <td class="text-left">
                    <button type="button" class="hide-view btn btn-danger btn-sm pull-right remove-item-non-grantee"><span class="glyphicon glyphicon-trash"></span></button>
                </td>
            </tr>`;
        $tbody.append(rowHtml);
        $(".select2").select2({
          templateResult: function (data) {
              if (data.id === '__add_new__') {
                  return $('<span> <span class="glyphicon glyphicon-plus"></span> Add Payment Item</span>');
              }
              return data.text;
          }
        });

        // $('.select2').on('select2:select', function (e) {
        //     let id = e.params.data.id;
        //     console.log('Selected ID:', id);

        //     if (id === '__add_new__') {
        //         // reset selection biar gak kepilih
        //         $(this).val(null).trigger('change');

        //         // buka modal
        //         $('#modalAddPaymentItem').modal({
        //             backdrop: 'static',
        //             keyboard: false
        //         });
        //     }
        // });
    });

    $(document).on("click", ".remove-item-non-grantee", function(){
      if (confirm("Are you sure want to delete this ?")){
        $(this).closest("tr").remove();
        updateSubtotalNonGrantee($(this).closest(".setup-block-non-grantee"));
        updateGlobalTotalNonGrantee()
      }
    });
    
    $(document).on("click", ".add-vendor", function(){
        let $setupBlock = $(this).closest(".setup-block-non-grantee");
        let panelId = $setupBlock.find('.collapse-payment-non-grantee').data('panelid');

        let $setupRows = $setupBlock.find(".setup-payment-table-non-grantee tbody tr");
        if($setupRows.length === 0) return alert("Please add at least 1 payment item!");

        let uniqueKey = 'new_' + Date.now() + '_' + (++vendorRowSeqNonGrantee);

        let vendorRow = `
        <tr class="vendor-row-non-grantee" data-uniquekey="${uniqueKey}">
            <td>
                <input type="hidden" class="vendor-id-hidden-non-grantee"
                    name="add_record[vendor][${panelId}][${uniqueKey}][vendor_id]"
                    value="">
                <select class="form-control-view form-control select-vendor-non-grantee select2 vendor-select-non-grantee" id="select-vendor-non-grantee-${panelId}-${uniqueKey}" style="min-width:160px;">
                    ${vendorSelectOptionsNonGrantee('')}
                </select>
            </td>
            <td>
                <select class="form-control select2 payment-method-select-non-grantee" name="add_record[vendor][${panelId}][${uniqueKey}][payment_method]" style="min-width:140px;">
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="va">Virtual Account</option>
                </select>
            </td>
            <td>
                <input type="text" class="form-control vendor-field-non-grantee" data-field="vendor_name" name="add_record[vendor][${panelId}][${uniqueKey}][vendor_name]" value="" disabled placeholder="">
            </td>
            <td>
                <input type="text" class="form-control vendor-field-non-grantee" data-field="vendor_beneficiary_name" name="add_record[vendor][${panelId}][${uniqueKey}][third_party_beneficiary_name]" value="" disabled>
            </td>
            <td>
                <input type="text" class="form-control vendor-field-non-grantee" data-field="vendor_address" name="add_record[vendor][${panelId}][${uniqueKey}][vendor_address]" value="" disabled>
            </td>
            <td>
                <input type="text" class="form-control vendor-field-non-grantee" data-field="vendor_bank_name" name="add_record[vendor][${panelId}][${uniqueKey}][third_party_bank_name]" value="" disabled>
            </td>
            <td>
                <input type="text" class="form-control vendor-field-non-grantee" data-field="vendor_bank_address" name="add_record[vendor][${panelId}][${uniqueKey}][third_party_bank_address]" value="" disabled>
            </td>
            <td>
                <input type="text" class="form-control vendor-field-non-grantee" data-field="vendor_account_number" name="add_record[vendor][${panelId}][${uniqueKey}][third_party_account_number]" value="" disabled>
            </td>
            <td>
                <input type="text" class="form-control vendor-field-non-grantee" data-field="vendor_swift_code" name="add_record[vendor][${panelId}][${uniqueKey}][third_party_swift_code]" value="" disabled>
            </td>
            <td>
                <input type="text" class="form-control vendor-field-non-grantee" data-field="vendor_routing_number" name="add_record[vendor][${panelId}][${uniqueKey}][third_party_routing_number]" value="" disabled>
            </td>
            <td>
                <select class="form-control select2 select-grantee" name="add_record[vendor][${panelId}][${uniqueKey}][user_grantee_id]" style="min-width:150px;">
                    <option value="0">Select Grantee</option>
                    <?php foreach($user_grantee as $grantee) { ?>
                        <option value="<?php echo $grantee->user_id; ?>"><?php echo get_full_name($grantee, $grantee->country_id == AMERICAN_DATABASE ? 'US' : 'ID'); ?></option>
                    <?php } ?>
                </select>
            </td>
            <td>
                <div class="vendor-proof-upload <?php echo $hide_upload_transfer; ?>">
                    <input type="file" name="proof_record_${panelId}_${uniqueKey}">
                    <small class="file-for-testing">File Size Max 5MB</small>
                </div>
                <div id="preview-edit-uploaded-transfer-grant" class="transfer-file">
                </div>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm pull-right remove-vendor"><span class="glyphicon glyphicon-trash"></span></button>
            </td>
        </tr>
        `;
        $setupBlock.find(".vendor-table-non-grantee tbody").append(vendorRow);
        $setupBlock.find('.select2').select2();
        bindVendorRowSelectNonGrantee($setupBlock.find('#select-vendor-non-grantee-' + panelId + '-' + uniqueKey));
        let $newRow = $setupBlock.find(".vendor-row-non-grantee[data-uniquekey='" + uniqueKey + "']");
        updatePaymentMethodRow($newRow);
        updateSubtotalNonGrantee($setupBlock);
        $('.lightbox').topbox();
    });

    $(document).on("click", ".remove-vendor", function(){
        let $setupBlock = $(this).closest(".setup-block-non-grantee");
      if (confirm("Are you sure want to delete this ?")){
        var paymentId = $(this).data('paymentid');
        recordDeletePaymentNonGrantee(paymentId);
        $(this).closest("tr").remove();
        updateSubtotalNonGrantee($setupBlock);
      }
    });

    $("#btn-submit-record-bulk, #btn-submit-record-edit-bulk").on('click', function() {
        $(this).addClass("hide");

        $(".btn-submit-record-disabled-bulk").each(function(){
            $(this).removeClass('hide');
        });
        var action = $(this).data('action');
        var payment_date = $(".payment-date-record-bulk").val();
        
        var invalid = false;
        if (payment_date == '' || payment_date == undefined) {
            $(".payment-date-record-bulk-validation").removeClass('hide');
            invalid = true;
        }

        let emptyVendorRow = false;
        let vaEmptyName = false;
        $(".vendor-row-non-grantee").each(function(){
            let $row = $(this);
            let vendorId = $row.find(".vendor-id-hidden-non-grantee").val();
            let pm = $row.find('.payment-method-select-non-grantee').val();
            let vendorName = $row.find('input[data-field="vendor_name"]').val().trim();

            if (pm === 'va') {
                // VA: vendor_id must be set (at least '0') and name must be filled
                if (vendorId === '') {
                    $row.find('.vendor-id-hidden-non-grantee').val('0');
                }
                if (!vendorName) {
                    vaEmptyName = true;
                    return false;
                }
            } else {
                if (vendorId === '') {
                    emptyVendorRow = true;
                    return false;
                }
            }
        });
        if (emptyVendorRow) {
            alert("Please select a vendor for each Third Party row!");
            invalid = true;
        }
        if (vaEmptyName) {
            alert("Please fill in the Name field for each Virtual Account row!");
            invalid = true;
        }


        if (invalid == true) {
            $(".btn-submit-record-disabled-bulk").each(function(){
            $(this).addClass('hide');
            });

            $(this).removeClass("hide");
            return false;
        }

    });
    
    function removeValidation(field) {
        $("."+field+"-validation").addClass('hide');
    };


    $('#mdl_add_record_bulk').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var mode = button.data('mode');
        var grant_id = <?= $grant_id ?? '' ?>;
        var $modal = $(this);
        let record_id = button.data('record_id');
        let $container= $modal.find('.section');
        let $modalBody= $modal.find('.modal-body');
        let $footer= $modal.find('.modal-footer');
        let $paymentItemSection= $modal.find('#setup-accordion-non-grantee');

        $modal.find('input[type="text"]:not(.date-default), input[type="number"], input[type="hidden"], textarea').val('');
        $modal.find('select').val('').trigger('change');
        $modal.find('input[type="checkbox"], input[type="radio"]').prop('checked', false);
        $('.vendor-table-non-grantee tbody').html('');
        $('#grant_id_bulk_non').val(grant_id);

        if(mode == 'view' || mode == 'edit') {
          $container.addClass('hide')
          $footer.addClass('hide')
          $modalBody.append('<div class="text-center spinner-modal"><i class="fa fa-spinner fa-spin"></i> Loading...</div>');

          $.ajax({
            url: "<?= site_url('admin/user_grantee_grant/get_bulk_payment_non_grantee_us') ?>/" + record_id,
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
                    var deadline_date = new Date(res.data.general.deadline_date);
                    var notify_date = res.data.notify_date && res.data.notify_date !== '0000-00-00 00:00:00' && res.data.notify_date !== '00-00-0000 00:00:00' ? new Date(res.data.notify_date) : null;

                    $('#bulk_id_non_grantee').val(res.data.id);
                    $('#payment_date_record_bulk').val((payment_date.getDate() < 10 ? '0' + payment_date.getDate() : payment_date.getDate()) + ' ' + monthNames[payment_date.getMonth()] + ' ' + payment_date.getFullYear());
                    $('#deadline_date_record_bulk').val((deadline_date.getDate() < 10 ? '0' + deadline_date.getDate() : deadline_date.getDate()) + ' ' + monthNames[deadline_date.getMonth()] + ' ' + deadline_date.getFullYear());
                    $('#description_record_bulk').val(res.data.general.description);
                    $('#priority_record_bulk').val(res.data.general.priority);
                    $('#admin_note_record_bulk').val(res.data.general.admin_note);
                    $('#memo_record_bulk').val(res.data.general.user_grantee_grant_memo_id);
                    $('#category_id_record_bulk').val(res.data.general.category);
                    get_sub_category_non_grantee(res.data.general.category, '#payment_sub_category_id_record_bulk', function() {
                        $('#payment_sub_category_id_record_bulk')
                            .val(res.data.general.payment_sub_category_id)
                            .trigger('change');
                    });
                    $('#status_record_bulk').val(res.data.general.status);
                    $('#finance_note_record_bulk').val(res.data.general.finance_note);
                    $('#notify_date_non').val(notify_date && !isNaN(notify_date.getTime()) ? (notify_date.getDate() < 10 ? '0' + notify_date.getDate() : notify_date.getDate()) + ' ' + monthNames[notify_date.getMonth()] + ' ' + notify_date.getFullYear() : '');
                    // if(res.data.general.proof != null){
                    //   $('#label-view-proof')
                    //     .attr('href', BASEURL + res.data.general.proof).find("label")
                    //     .removeClass("label-default")
                    //     .addClass("label-primary")
                    //     .text("View Proof");
                    // }else{
                    //   $("#label-view-proof")
                    //       .attr("href", "javascript:void(0);")
                    //       .on("click", function(){ return false; })
                    //       .find("label")
                    //       .removeClass("label-primary")
                    //       .addClass("label-default")
                    //       .text("Not Uploaded yet");
                    // }

                    let html = renderPaymentPanelNon(res.data);
                    $paymentItemSection.html(html);

                    // reinit select2 / selectpicker
                    $container.find('.selectpicker').selectpicker('refresh');
                    $container.find(".vendor-select-non-grantee").each(function(){
                        bindVendorRowSelectNonGrantee($(this));
                    });
                    $container.find('.select2').select2({
                      templateResult: function (data) {
                        if (!data || typeof data !== 'object') return '';

                        if (data.id === '__add_new__') {
                            return $('<span style="color:#337ab7;"> <span class="glyphicon glyphicon-plus"></span> Add Payment Item</span>');
                        }

                        return data.text || '';
                      }
                    });
                    $modalBody.find(".setup-block-non-grantee").each(function(){
                      updateSubtotalNonGrantee($(this));
                    });
                    // Apply VA field state for each vendor row
                    $modalBody.find(".vendor-row-non-grantee").each(function(){
                        let forceMode = (mode === 'view') ? 'view' : null;
                        updatePaymentMethodRow($(this), forceMode);
                    });
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
              $('.form-control-view').prop('disabled', true)
              $('.modal-footer, .hide-view, .edit-add-more-data-payment').addClass('hide')
              $('#exampleModalLabelGrantee').text('View Bulk Grantee')
              $footer.addClass('hide')
          }else{
              $('.form-control-view').prop('disabled', false)
              $('.modal-footer, .hide-view, .edit-add-more-data-payment').removeClass('hide')
              $('#exampleModalLabelVendor').text('Edit Bulk Non-Grantee Payments');
              $(".radio-for").prop('disabled', true);
          }
          lockSelect2('#sub_category_bulk')
          lockSelect2('#disbursment')
          // $('#sub_category_bulk, #disbursment').prop('disabled', true)
        }else if(mode == 'add'){
          $modal.find('form')[0].reset();
          $paymentItemSection.html('');
          $('#exampleModalLabelVendor').text('Add Bulk Non-Grantee Payments');
          $('.form-control-view').prop('disabled', false);
          $('.modal-footer, .hide-view, .edit-add-more-data-payment').removeClass('hide')
          updateSubtotalNonGrantee($modalBody.find(".setup-block-non-grantee"));
          $('#status_record_bulk').val(1);
        }


            
    });



    function renderPaymentPanelNon(data){  
      let html = '';
      data.setups.forEach(function(setup, idx){
          let sub_category = data.general.payment_sub_category_id
              category = data.general.category;
          let panelId = idx;

          html += `

          <div class="panel panel-primary setup-block-non-grantee">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#setup-accordion-non-grantee" href="#setup-non-grantee${panelId}">
                  <span class="glyphicon glyphicon-chevron-down collapse-icon" style="margin-right:5px;"></span>
                  Setup Payment Item
                  <span class="subtotal">
                    Subtotal: <span class="subtotal-idr-non-grantee">0</span> | <span class="subtotal-usd-non-grantee">0</span>
                  </span>
                </a>
                <button type="button" class="btn btn-danger btn-xs hide-view remove-setup-non-grantee">
                  <span class="glyphicon glyphicon-remove"></span>
                </button>
              </h4>
            </div>
            <div id="setup-non-grantee${panelId}" class="collapse-payment-non-grantee panel-collapse collapse in" data-panelid="${panelId}" style="border:1px solid #337ab7;">
              <div class="panel-body">
                <!-- Payment Item Table -->
                <h5><strong>Payment Items</strong></h5>
                <table class="table table-bordered setup-payment-table-non-grantee">
                  <thead>
                    <tr>
                      <th>Payment Item</th>
                      <th>Nominal IDR</th>
                      <th>Nominal USD</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>`;
                  
                  // load Payment Items
                  let getPaymentItems = getSyncData("<?= site_url('admin/payment_item/get_payment_item'); ?>", {
                      category_type: category, sub_category, country_id: 2
                  });

                  // return false
                  setup.items.forEach(function(item, inItem){
                      html += `
                      <tr class="tr-payment-item-non-grantee">
                        <td>
                            <select class="form-control setup-payment-item-non-grantee select2" name="setup[${panelId}][${inItem}][payment_item]">
                                <option value=''>Select Payment Item</option>
                                ${JSON.parse(getPaymentItems).map(v => `<option value="${v.id}" ${v.id == item.item_id ? "selected" : ""}>${v.payment_item}</option>`).join('')}
                                <option value="__add_new__" data-category="category_id_record_bulk" data-subcategory="payment_sub_category_id_record_bulk" data-select="setup-payment-item-non-grantee"> <span class="glyphicon glyphicon-plus"></span> Add Payment Item</option>
                            </select>
                        </td>
                        <td><input type="text" class="form-control setup-idr-non-grantee convert-setup-idr" name="setup[${panelId}][${inItem}][nominal_idr]" value="${item.idr}"></td>
                        <td><input type="text" class="form-control setup-usd-non-grantee convert-setup-usd" name="setup[${panelId}][${inItem}][nominal_usd]" value="${item.usd}"></td>
                        <td class="text-left">
                            <button type="button" class="hide-view btn btn-danger btn-sm pull-right remove-item-non-grantee"><span class="glyphicon glyphicon-trash"></span></button>
                        </td>
                    </tr>`;
                  });
          html += `
                  </tbody>
                </table>`;


          html +=`
                <button class="btn btn-info btn-sm hide-view add-setup-item-non-grantee" type="button">
                  <span class="glyphicon glyphicon-plus"></span> Add Payment Item
                </button>

                <hr>
                <h5><strong>Third Party</strong></h5>
                <div class="vendor-table-wrap">
                <table class="table table-bordered vendor-table-non-grantee">
                  <thead>
                    <tr>
                      <th>Vendor</th>
                      <th>Payment Method</th>
                      <th>Vendor Name</th>
                      <th>Beneficiary Name (As listed on the bank account)</th>
                      <th>Beneficiary Address: [Building/Street, City, State/Province + Postal Code, Country]</th>
                      <th>Bank Name</th>
                      <th>Bank Address: [Building/Street, City, State/Province + Postal Code, Country]</th>
                      <th>Account Number</th>
                      <th>SWIFT Code</th>
                      <th>Routing or ABA Number (for U.S. Banks)</th>
                      <th>Grantee</th>
                      <th>Proof of Transfer/Invoice</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>`;


                setup.vendors.forEach(function(vendor){
                      let proofHtml = vendor.proof 
                          ? `<a href="${BASEURL + vendor.proof}" class="lightbox"><label class="label label-primary" disabled>View Proof</label></a>`
                          : '';
                      let isVA = vendor.payment_method === 'va';
                      let uniqueKey = vendor.vendor_id == 0 ? ('other_' + Date.now() + '_' + (++vendorRowSeqNonGrantee)) : vendor.vendor_id;
                      // For VA: name is always editable; bank fields are greyed out
                      // For Bank Transfer: follow vendor_id logic (predefined = readonly, Other = editable)
                      let readOnlyName = (!isVA && vendor.vendor_id != 0) ? 'readonly' : '';
                      let readOnlyBank = (isVA || vendor.vendor_id != 0) ? 'readonly' : '';
                      let vendorFieldClass = (isVA || vendor.vendor_id != 0) ? 'vendor-field-plain-text' : '';
                      let vaDisabledClass = isVA ? 'va-disabled-field' : '';
                      html += `
                      <tr class="vendor-row-non-grantee ${isVA ? 'va-row' : ''}" data-uniquekey="${uniqueKey}">
                        <td>
                            <input type="hidden" class="vendor-id-hidden-non-grantee"
                                name="add_record[vendor][${panelId}][${uniqueKey}][vendor_id]"
                                value="${vendor.vendor_id}">
                            <input type="hidden" name="add_record[vendor][${panelId}][${uniqueKey}][payment_id]" value="${vendor.payment_id}">
                            <select class="form-control-view form-control select-vendor-non-grantee select2 vendor-select-non-grantee" id="select-vendor-non-grantee-${panelId}-${uniqueKey}" style="min-width:160px;">
                                ${vendorSelectOptionsNonGrantee(vendor.vendor_id)}
                            </select>
                        </td>
                        <td>
                            <select class="form-control select2 payment-method-select-non-grantee" name="add_record[vendor][${panelId}][${uniqueKey}][payment_method]" style="min-width:140px;">
                                <option ${vendor.payment_method === "bank_transfer" ? "selected" : ""} value="bank_transfer">Bank Transfer</option>
                                <option ${vendor.payment_method === "va" ? "selected" : ""} value="va">Virtual Account</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control vendor-field-non-grantee ${isVA ? '' : vendorFieldClass}" data-field="vendor_name" name="add_record[vendor][${panelId}][${uniqueKey}][vendor_name]" value="${vendor.vendor_name}" ${readOnlyName} placeholder="${isVA ? 'Enter Name / VA Recipient' : ''}">
                        </td>
                        <td class="${isVA ? 'va-disabled-cell' : ''}">
                            <input type="text" class="form-control vendor-field-non-grantee ${vendorFieldClass} ${isVA ? vaDisabledClass : ''}" data-field="vendor_beneficiary_name" name="add_record[vendor][${panelId}][${uniqueKey}][third_party_beneficiary_name]" value="${isVA ? '' : vendor.beneficiary_name}" ${readOnlyBank} placeholder="${isVA ? '-' : ''}">
                        </td>
                        <td class="${isVA ? 'va-disabled-cell' : ''}">
                            <input type="text" class="form-control vendor-field-non-grantee ${vendorFieldClass} ${isVA ? vaDisabledClass : ''}" data-field="vendor_address" name="add_record[vendor][${panelId}][${uniqueKey}][vendor_address]" value="${isVA ? '' : vendor.vendor_address}" ${readOnlyBank} placeholder="${isVA ? '-' : ''}">
                        </td>
                        <td class="${isVA ? 'va-disabled-cell' : ''}">
                            <input type="text" class="form-control vendor-field-non-grantee ${vendorFieldClass} ${isVA ? vaDisabledClass : ''}" data-field="vendor_bank_name" name="add_record[vendor][${panelId}][${uniqueKey}][third_party_bank_name]" value="${isVA ? '' : vendor.bank_name}" ${readOnlyBank} placeholder="${isVA ? '-' : ''}">
                        </td>
                        <td class="${isVA ? 'va-disabled-cell' : ''}">
                            <input type="text" class="form-control vendor-field-non-grantee ${vendorFieldClass} ${isVA ? vaDisabledClass : ''}" data-field="vendor_bank_address" name="add_record[vendor][${panelId}][${uniqueKey}][third_party_bank_address]" value="${isVA ? '' : vendor.bank_address}" ${readOnlyBank} placeholder="${isVA ? '-' : ''}">
                        </td>
                        <td class="${isVA ? 'va-disabled-cell' : ''}">
                            <input type="text" class="form-control vendor-field-non-grantee ${vendorFieldClass} ${isVA ? vaDisabledClass : ''}" data-field="vendor_account_number" name="add_record[vendor][${panelId}][${uniqueKey}][third_party_account_number]" value="${isVA ? '' : vendor.account_number}" ${readOnlyBank} placeholder="${isVA ? '-' : ''}">
                        </td>
                        <td class="${isVA ? 'va-disabled-cell' : ''}">
                            <input type="text" class="form-control vendor-field-non-grantee ${vendorFieldClass} ${isVA ? vaDisabledClass : ''}" data-field="vendor_swift_code" name="add_record[vendor][${panelId}][${uniqueKey}][third_party_swift_code]" value="${isVA ? '' : vendor.swift_code}" ${readOnlyBank} placeholder="${isVA ? '-' : ''}">
                        </td>
                        <td class="${isVA ? 'va-disabled-cell' : ''}">
                            <input type="text" class="form-control vendor-field-non-grantee ${vendorFieldClass} ${isVA ? vaDisabledClass : ''}" data-field="vendor_routing_number" name="add_record[vendor][${panelId}][${uniqueKey}][third_party_routing_number]" value="${isVA ? '' : vendor.routing_number}" ${readOnlyBank} placeholder="${isVA ? '-' : ''}">
                        </td>
                        <td>
                            <select class="form-control select2 select-grantee" name="add_record[vendor][${panelId}][${uniqueKey}][user_grantee_id]" style="min-width:150px;">
                                <option value="0">Select Grantee</option>
                                <?php foreach($user_grantee as $grantee) { ?>
                                    <option value="<?php echo $grantee->user_id; ?>" ${ <?= $grantee->user_id ?> == vendor.user_grantee_id ? "selected" : ""}><?php echo get_full_name($grantee, $grantee->country_id == AMERICAN_DATABASE ? 'US' : 'ID'); ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <div class="vendor-proof-upload <?php echo $hide_upload_transfer; ?>">
                                <input type="file" name="proof_record_${panelId}_${uniqueKey}">
                                <small class="file-for-testing">File Size Max 5MB</small>
                            </div>
                            <div class="transfer-file">
                                ${proofHtml}
                            </div>
                        </td>
                        <td>
                            <button type="button" class="hide-view btn btn-danger btn-sm pull-right remove-vendor" data-paymentid="${vendor.payment_id}"><span class="glyphicon glyphicon-trash"></span></button>
                        </td>
                      </tr>
                      `;
                  });

                html +=`
                  </tbody>
                </table>
                </div>

                <div style="margin-top:10px;">
                    <button class="btn btn-primary btn-sm add-vendor" type="button">
                        <span class="glyphicon glyphicon-plus"></span> Add Third Party
                    </button>
                </div>
              </div>
            </div>
          </div>`;
      });
      return html;
    }

</script>