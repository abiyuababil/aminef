<style>
.panel-vendor .panel-title {
    display: flex;
    align-items: center;
}
.panel-vendor .panel-title a .collapse-icon {
    transition: transform .2s ease;
}
.panel-vendor .panel-title a.collapsed .collapse-icon {
    transform: rotate(-90deg);
}
.panel-vendor .panel-title .remove-vendor {
    margin-left: auto;
    margin-right: 6px;
}
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
</style>
<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<script>
    const BASEURL = '<?php echo base_url() ?>';

    $( ".datepicker" ).datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd M yy",
        yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
    });


    $(".datepicker-notification").datepicker({
        minDate: 1 // 1 = besok
    });


    $('input[name="add_record[payment_date]"]').on('change', function(){
        let val = $(this).val();
        if (val) {
            let date = new Date(val);
            date.setDate(date.getDate() + 7); 

            let options = { day: '2-digit', month: 'short', year: 'numeric' };
            let deadline = date.toLocaleDateString('en-GB', options).replace(',', '');

            $('input[name="add_record[deadline_date]"]').val(deadline);
        }
    });

    function recordDeletePaymentNonGrantee(id) {
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
      let $vendorLength = $setupBlock.find(".panel-vendor").length;

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
            <h5><strong>Select Third Party</strong></h5>
            <div class="form-inline">
                <select class="form-control-view form-control select-vendor-non-grantee selectpicker" id="select-vendor-non-grantee-${panelId}" data-live-search="true">
                    <option value="">-- Select Third Party --</option>
                        <?php foreach($vendors as $vendor) { ?>
                            <option 
                                data-vendor_name="<?= $vendor->name; ?>" 
                                data-vendor_id="<?= $vendor->id; ?>" 
                                data-vendor_address="<?= $vendor->address; ?>" 
                                data-vendor_beneficiary_name="<?= $vendor->beneficiary_name; ?>" 
                                data-vendor_bank_name="<?= $vendor->bank_name; ?>" 
                                data-vendor_bank_address="<?= $vendor->bank_address; ?>" 
                                data-vendor_account_number="<?= $vendor->account_number; ?>" 
                                data-vendor_swift_code="<?= $vendor->swift_code; ?>" 
                                data-vendor_routing_number="<?= $vendor->routing_number; ?>" 
                                value="<?= $vendor->id; ?>"><?= $vendor->name; ?></option>
                        <?php } ?>
                    <option value="0" data-vendor_name="Other">Other</option>
                </select>
                <button class="btn btn-primary btn-sm add-vendor" type="button">
                    <span class="glyphicon glyphicon-plus"></span> Add Third Party
                </button>
            </div>

            <div class="vendor-container" style="margin-top:15px;"></div>
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
                <td class="text-center">
                    <button type="button" class="hide-view btn btn-danger btn-sm hide-view remove-item-non-grantee"><span class="glyphicon glyphicon-trash"></span></button>
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
    
    // $(document).on("click", ".add-vendor", function(){
    //     let $setupBlock = $(this).closest(".setup-block-non-grantee");
    //     let panelId = $(this).closest(".setup-block-non-grantee").find($('.collapse-payment-non-grantee')).data('panelid');
    //     let period_id   = $('#period_id').val(),
    //         grant_id    = $('#grant_id').val(),
    //         status      = $('#select-status').val(),
    //         category    = $('.select-category-non-grantee').val(),
    //         sub_category= $('.select-sub-category-non-grantee').val(),
    //         selectedOpt = $('#select-vendor-non-grantee-'+panelId+' option:selected'),
    //         vendor_id     = $('#select-vendor-non-grantee-'+panelId).val(),
    //         vendorName= selectedOpt.data('vendor_name')
    //         vendorAddress= vendorName == 'Other' ? '' : selectedOpt.data('vendor_address'), 
    //         vendorBeneficiary= vendorName == 'Other' ? '' : selectedOpt.data('vendor_beneficiary_name'), 
    //         vendorBankName= vendorName == 'Other' ? '' : selectedOpt.data('vendor_bank_name'), 
    //         vendorBankAddress= vendorName == 'Other' ? '' : selectedOpt.data('vendor_bank_address'), 
    //         vendorAccountNumber= vendorName == 'Other' ? '' : selectedOpt.data('vendor_account_number'), 
    //         vendorSwiftCode= vendorName == 'Other' ? '' : selectedOpt.data('vendor_swift_code'), 
    //         vendorRoutingNumber= vendorName == 'Other' ? '' : selectedOpt.data('vendor_routing_number');
    //         uniqueKey = vendorName == 'Other' ? ('other_' + Date.now()) : vendor_id;


    //     if(!vendor_id) return alert("Please select a vendor!");

    //     let $setupRows = $setupBlock.find(".setup-payment-table-non-grantee tbody tr");
    //     if($setupRows.length === 0) return alert("Please add at least 1 payment item!");
        
    //     let readOnlyField = vendorName == 'Other' ? '' : 'readonly';

    //     let vendorCard = `
    //         <hr />
    //         <div class="panel-body panel-vendor">
    //           <input type="hidden"
    //               name="add_record[vendor][${panelId}][${uniqueKey}][vendor_id]"
    //               value="${vendor_id}">
    //           <div class="form-group row">
    //           <div class="col-lg-12">
    //           <button class="btn btn-danger btn-sm remove-vendor">✖</button>
    //           </div>
    //           </div>
    //           <div class="form-group row">
    //               <div class="col-lg-6">
    //                   <label>Name</label>
    //                   <input type="text" class="form-control" name="add_record[vendor][${panelId}][${uniqueKey}][vendor_name]" value="${vendorName}" ${readOnlyField}>
    //               </div>
    //               <div class="col-lg-6">
    //                   <label>Address</label>
    //                   <input type="text" class="form-control" name="add_record[vendor][${panelId}][${uniqueKey}][vendor_address]" value="${vendorAddress}" ${readOnlyField}>
    //               </div>
    //           </div>
    //           <div class="form-group row">
    //               <div class="col-lg-6">
    //                   <label>Beneficiary Name</label>
    //                   <input type="text" class="form-control" name="add_record[vendor][${panelId}][${uniqueKey}][third_party_beneficiary_name]" value="${vendorBeneficiary}" ${readOnlyField}>
    //               </div>
    //               <div class="col-lg-6">
    //                   <label>Bank Name</label>
    //                   <input type="text" class="form-control" name="add_record[vendor][${panelId}][${uniqueKey}][third_party_bank_name]" value="${vendorBankName}" ${readOnlyField}>
    //               </div>
    //           </div>
    //           <div class="form-group row">
    //               <div class="col-lg-6">
    //                   <label>Bank Address</label>
    //                   <input type="text" class="form-control" name="add_record[vendor][${panelId}][${uniqueKey}][third_party_bank_address]" value="${vendorBankAddress}" ${readOnlyField}>
    //               </div>
    //               <div class="col-lg-6">
    //                   <label>Account Number</label>
    //                   <input type="text" class="form-control" name="add_record[vendor][${panelId}][${uniqueKey}][third_party_account_number]" value="${vendorAccountNumber}" ${readOnlyField}>
    //               </div>
    //           </div>
    //           <div class="form-group row">
    //               <div class="col-lg-6">
    //                   <label>SWIFT Code</label>
    //                   <input type="text" class="form-control" name="add_record[vendor][${panelId}][${uniqueKey}][third_party_swift_code]" value="${vendorSwiftCode}" ${readOnlyField}>
    //               </div>
    //               <div class="col-lg-6">
    //                   <label>Routing Number</label>
    //                   <input type="text" class="form-control" name="add_record[vendor][${panelId}][${uniqueKey}][third_party_routing_number]" value="${vendorRoutingNumber}" ${readOnlyField}>
    //               </div>
    //           </div>
    //           <div class="form-group row">
    //             <div class="col-lg-6">
    //                 <label>Grantee</label>
    //                 <select class="form-control select2 select-grantee" name="add_record[vendor][${panelId}][${uniqueKey}][user_grantee_id]">
    //                     <option value="0">Select Grantee</option>
    //                     <?php foreach($user_grantee as $grantee) { ?>
    //                         <option value="<?php echo $grantee->user_id; ?>"><?php echo get_full_name($grantee, $grantee->country_id == AMERICAN_DATABASE ? 'US' : 'ID'); ?></option>
    //                     <?php } ?>
    //                 </select>
    //             </div>
    //             <div class="col-lg-6">
    //                 <label>Proof of Transfer</label>
    //                 <div class="<?php echo $hide_upload_transfer; ?>">
    //                     <input type="file" name="proof_record_${panelId}_${uniqueKey}">
    //                     <small class="file-for-testing">File Size Max 5MB</small>
    //                 </div>
    //                 <div id="preview-edit-uploaded-transfer-grant" class="transfer-file">
    //                 </div>
    //             </div>
    //           </div>
    //         </div>
    //         `;
    //     // $("#vendorTable"+panelId+" tbody").append(vendorCard);
    //     $setupBlock.find(".vendor-container").append(vendorCard);
    //     $setupBlock.find('.select2').select2();
    //     updateSubtotalNonGrantee($(this).closest($setupBlock));
    //     $('.lightbox').topbox();
    // });

    $(document).on("click", ".add-vendor", function(){
      let $setupBlock = $(this).closest(".setup-block-non-grantee");
      let panelId = $setupBlock.find('.collapse-payment-non-grantee').data('panelid');

      let selectedOpt = $('#select-vendor-non-grantee-'+panelId+' option:selected');
      let vendor_id   = $('#select-vendor-non-grantee-'+panelId).val();
      let vendorName  = selectedOpt.data('vendor_name');

      if(!vendor_id) return alert("Please select a vendor!");

      let $setupRows = $setupBlock.find(".setup-payment-table-non-grantee tbody tr");
      if($setupRows.length === 0) return alert("Please add at least 1 payment item!");

      // 👉 kalau OTHER → buka modal
      if(vendorName === 'Other'){
          $('#modalVendorOther').data('panelId', panelId);
          $('#modalVendorOther').data('$setupBlock', $setupBlock);
          $('#modalVendorOther').modal('show');
          return;
      }

      // 👉 kalau bukan OTHER → langsung add
      addVendorToTable({
          panelId,
          vendor_id,
          vendorName,
          vendorAddress: selectedOpt.data('vendor_address'),
          vendorBeneficiary: selectedOpt.data('vendor_beneficiary_name'),
          vendorBankName: selectedOpt.data('vendor_bank_name'),
          vendorBankAddress: selectedOpt.data('vendor_bank_address'),
          vendorAccountNumber: selectedOpt.data('vendor_account_number'),
          vendorSwiftCode: selectedOpt.data('vendor_swift_code'),
          vendorRoutingNumber: selectedOpt.data('vendor_routing_number'),
          $setupBlock
      });
  });

  $(document).on("click", ".remove-vendor", function(){
      let $setupBlock = $(this).closest(".setup-block-non-grantee");
    if (confirm("Are you sure want to delete this ?")){
      var paymentId = $(this).data('paymentid');
      recordDeletePaymentNonGrantee(paymentId);
      $(this).closest(".panel-vendor").remove();
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
                      <td class="text-center">
                          <button type="button" class="hide-view btn btn-danger btn-sm hide-view remove-item-non-grantee"><span class="glyphicon glyphicon-trash"></span></button>
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
              <h5><strong>Select Third Party</strong></h5>
              <div class="form-inline">
                  <select class="form-control-view form-control select-vendor-non-grantee selectpicker" id="select-vendor-non-grantee-${panelId}" data-live-search="true">
                      <option value="">-- Select Third Party --</option>
                          <?php foreach($vendors as $vendor) { ?>
                              <option 
                                  data-vendor_name="<?= $vendor->name; ?>" 
                                  data-vendor_id="<?= $vendor->id; ?>" 
                                  data-vendor_address="<?= $vendor->address; ?>" 
                                  data-vendor_beneficiary_name="<?= $vendor->beneficiary_name; ?>" 
                                  data-vendor_bank_name="<?= $vendor->bank_name; ?>" 
                                  data-vendor_bank_address="<?= $vendor->bank_address; ?>" 
                                  data-vendor_account_number="<?= $vendor->account_number; ?>" 
                                  data-vendor_swift_code="<?= $vendor->swift_code; ?>" 
                                  data-vendor_routing_number="<?= $vendor->routing_number; ?>" 
                                  value="<?= $vendor->id; ?>"><?= $vendor->name; ?></option>
                          <?php } ?>
                      <option value="0" data-vendor_name="Other">Other</option>
                  </select>
                  <button class="btn btn-primary btn-sm add-vendor" type="button">
                      <span class="glyphicon glyphicon-plus"></span> Add Third Party
                  </button>
              </div>

              <div class="vendor-container" style="margin-top:15px;">`;


              setup.vendors.forEach(function(vendor){
                    let proofHtml = vendor.proof 
                        ? `<a href="${BASEURL + vendor.proof}" class="lightbox"><label class="label label-primary" disabled>View Proof</label></a>`
                        : '';
                    let readOnlyField = vendor.vendor_id == 0 ? '' : 'readonly';
                    let uniqueKey = vendor.vendor_id == 0 ? ('other_' + crypto.randomUUID()) : vendor.vendor_id;
                    let vendorId = 'vendor-' + panelId + '-' + uniqueKey;
                    html += `
                    <div class="panel panel-info panel-vendor">
                      <div class="panel-heading">
                          <h4 class="panel-title" style="font-size:13px;">
                               <a data-toggle="collapse" href="#${vendorId}"><span class="glyphicon glyphicon-chevron-down collapse-icon" style="margin-right:5px;"></span><span class="vendor-title-name">${vendor.vendor_name}</span></a>
                               <button class="btn btn-danger btn-xs remove-vendor" data-paymentid="${vendor.payment_id}">✖</button>
                          </h4>
                      </div>
                      <div id="${vendorId}" class="panel-collapse collapse">
                          <div class="panel-body">
                              <input type="hidden"
                                  name="add_record[vendor][${panelId}][${uniqueKey}][vendor_id]"
                                  value="${vendor.vendor_id}">
                              <input type="hidden" name="add_record[vendor][${panelId}][${uniqueKey}][payment_id]" value="${vendor.payment_id}">
                              <div class="form-group row">
                                  <div class="col-lg-6">
                                      <label>Name</label>
                                      <input type="text" class="form-control" name="add_record[vendor][${panelId}][${uniqueKey}][vendor_name]" value="${vendor.vendor_name}" ${readOnlyField} oninput="$(this).closest('.panel-vendor').find('.vendor-title-name').text(this.value)">
                                   </div>
                                   <div class="col-lg-6">
                                      <label>Address</label>
                                      <input type="text" class="form-control" name="add_record[vendor][${panelId}][${uniqueKey}][vendor_address]" value="${vendor.vendor_address}" ${readOnlyField}>
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <div class="col-lg-6">
                                      <label>Beneficiary Name</label>
                                      <input type="text" class="form-control" name="add_record[vendor][${panelId}][${uniqueKey}][third_party_beneficiary_name]" value="${vendor.beneficiary_name}" ${readOnlyField}>
                                  </div>
                                  <div class="col-lg-6">
                                      <label>Bank Name</label>
                                      <input type="text" class="form-control" name="add_record[vendor][${panelId}][${uniqueKey}][third_party_bank_name]" value="${vendor.bank_name}" ${readOnlyField}>
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <div class="col-lg-6">
                                      <label>Bank Address</label>
                                      <input type="text" class="form-control" name="add_record[vendor][${panelId}][${uniqueKey}][third_party_bank_address]" value="${vendor.bank_address}" ${readOnlyField}>
                                  </div>
                                  <div class="col-lg-6">
                                      <label>Account Number</label>
                                      <input type="text" class="form-control" name="add_record[vendor][${panelId}][${uniqueKey}][third_party_account_number]" value="${vendor.account_number}" ${readOnlyField}>
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <div class="col-lg-6">
                                      <label>SWIFT Code</label>
                                      <input type="text" class="form-control" name="add_record[vendor][${panelId}][${uniqueKey}][third_party_swift_code]" value="${vendor.swift_code}" ${readOnlyField}>
                                  </div>
                                  <div class="col-lg-6">
                                      <label>Routing Number</label>
                                      <input type="text" class="form-control" name="add_record[vendor][${panelId}][${uniqueKey}][third_party_routing_number]" value="${vendor.routing_number}" ${readOnlyField}>
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <div class="col-lg-6">
                                      <label>Grantee</label>
                                      <select class="form-control select2 select-grantee" name="add_record[vendor][${panelId}][${uniqueKey}][user_grantee_id]">
                                          <option value="0">Select Grantee</option>
                                          <?php foreach($user_grantee as $grantee) { ?>
                                              <option value="<?php echo $grantee->user_id; ?>" ${<?= $grantee->user_id ?> == vendor.user_grantee_id ? "selected" : ""}><?php echo get_full_name($grantee, $grantee->country_id == AMERICAN_DATABASE ? 'US' : 'ID'); ?></option>
                                          <?php } ?>
                                      </select>
                                  </div>
                                  <div class="col-lg-6">
                                      <label>Proof of Transfer</label>
                                      <div class="<?php echo $hide_upload_transfer; ?>">
                                          <input type="file" name="proof_record_${panelId}_${uniqueKey}">
                                          <small class="file-for-testing">File Size Max 5MB</small>
                                      </div>
                                      <div id="preview-edit-uploaded-transfer-grant" class="transfer-file">
                                          ${proofHtml}
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                    </div>
                    `;
                });

              html +=`
              </div>
            </div>
          </div>
        </div>`;
    });
    return html;
  }

  $(document).on("click", ".save-other-vendor", function(){
      let modal = $('#modalVendorOther');

      let panelId = modal.data('panelId');
      let $setupBlock = modal.data('$setupBlock');

      let vendorName = $('#other_name').val();
      let uniqueKey = 'other_' + Date.now();

      addVendorToTable({
          panelId,
          vendor_id: 0,
          vendorName,
          vendorAddress: $('#other_address').val(),
          vendorBeneficiary: $('#other_beneficiary').val(),
          vendorBankName: $('#other_bank').val(),
          vendorBankAddress: '',
          vendorAccountNumber: $('#other_account').val(),
          vendorSwiftCode: '',
          vendorRoutingNumber: '',
          $setupBlock,
          isOther: true,
          uniqueKey
      });

      modal.modal('hide');
  });

  function addVendorToTable(data){
      let {
          panelId,
          vendor_id,
          vendorName,
          vendorAddress,
          vendorBeneficiary,
          vendorBankName,
          vendorBankAddress,
          vendorAccountNumber,
          vendorSwiftCode,
          vendorRoutingNumber,
          $setupBlock,
          isOther = false,
          uniqueKey = vendor_id
      } = data;

      let readOnlyField = isOther ? '' : 'readonly';
      let vendorId = 'vendor-' + panelId + '-' + uniqueKey;

      let panel = `
      <div class="panel panel-info panel-vendor">
          <div class="panel-heading">
              <h4 class="panel-title" style="font-size:13px;">
                  <a data-toggle="collapse" href="#${vendorId}"><span class="glyphicon glyphicon-chevron-down collapse-icon" style="margin-right:5px;"></span><span class="vendor-title-name">${vendorName}</span></a>
                  <button class="btn btn-danger btn-xs remove-vendor">✖</button>
              </h4>
          </div>
          <div id="${vendorId}" class="panel-collapse collapse">
              <div class="panel-body">
                  <input type="hidden"
                      name="add_record[vendor][${panelId}][${uniqueKey}][vendor_id]"
                      value="${vendor_id}">
                  <input type="hidden"
                      name="add_record[vendor][${panelId}][${uniqueKey}][payment_id]"
                      value="">
                  <div class="form-group row">
                      <div class="col-lg-6">
                          <label>Name</label>
                          <input type="text" class="form-control"
                              name="add_record[vendor][${panelId}][${uniqueKey}][vendor_name]"
                              value="${vendorName}" ${readOnlyField}
                              oninput="$(this).closest('.panel-vendor').find('.vendor-title-name').text(this.value)">
                      </div>
                      <div class="col-lg-6">
                          <label>Address</label>
                          <input type="text" class="form-control"
                              name="add_record[vendor][${panelId}][${uniqueKey}][vendor_address]"
                              value="${vendorAddress}" ${readOnlyField}>
                      </div>
                  </div>
                  <div class="form-group row">
                      <div class="col-lg-6">
                          <label>Beneficiary Name</label>
                          <input type="text" class="form-control"
                              name="add_record[vendor][${panelId}][${uniqueKey}][third_party_beneficiary_name]"
                              value="${vendorBeneficiary}" ${readOnlyField}>
                      </div>
                      <div class="col-lg-6">
                          <label>Bank Name</label>
                          <input type="text" class="form-control"
                              name="add_record[vendor][${panelId}][${uniqueKey}][third_party_bank_name]"
                              value="${vendorBankName}" ${readOnlyField}>
                      </div>
                  </div>
                  <div class="form-group row">
                      <div class="col-lg-6">
                          <label>Bank Address</label>
                          <input type="text" class="form-control"
                              name="add_record[vendor][${panelId}][${uniqueKey}][third_party_bank_address]"
                              value="${vendorBankAddress}" ${readOnlyField}>
                      </div>
                      <div class="col-lg-6">
                          <label>Account Number</label>
                          <input type="text" class="form-control"
                              name="add_record[vendor][${panelId}][${uniqueKey}][third_party_account_number]"
                              value="${vendorAccountNumber}" ${readOnlyField}>
                      </div>
                  </div>
                  <div class="form-group row">
                      <div class="col-lg-6">
                          <label>SWIFT Code</label>
                          <input type="text" class="form-control"
                              name="add_record[vendor][${panelId}][${uniqueKey}][third_party_swift_code]"
                              value="${vendorSwiftCode}" ${readOnlyField}>
                      </div>
                      <div class="col-lg-6">
                          <label>Routing Number</label>
                          <input type="text" class="form-control"
                              name="add_record[vendor][${panelId}][${uniqueKey}][third_party_routing_number]"
                              value="${vendorRoutingNumber}" ${readOnlyField}>
                      </div>
                  </div>
                  <div class="form-group row">
                      <div class="col-lg-6">
                          <label>Grantee</label>
                          <select class="form-control select2 select-grantee"
                              name="add_record[vendor][${panelId}][${uniqueKey}][user_grantee_id]">
                              <option value="0">Select Grantee</option>
                              <?php foreach($user_grantee as $grantee) { ?>
                                  <option value="<?php echo $grantee->user_id; ?>"><?php echo get_full_name($grantee, $grantee->country_id == AMERICAN_DATABASE ? 'US' : 'ID'); ?></option>
                              <?php } ?>
                          </select>
                      </div>
                      <div class="col-lg-6">
                          <label>Proof of Transfer</label>
                          <div class="<?php echo $hide_upload_transfer; ?>">
                              <input type="file" name="proof_record_${panelId}_${uniqueKey}">
                              <small class="file-for-testing">File Size Max 5MB</small>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      `;

      $setupBlock.find(".vendor-container").append(panel);
      $setupBlock.find('.select2').select2();
      $setupBlock.find(".panel-vendor .panel-collapse.collapse.in").collapse('hide');
      $setupBlock.find("#" + vendorId).collapse('show');
      updateSubtotalNonGrantee($setupBlock);
  }

</script>