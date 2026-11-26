<script>

    const BASEURL = '<?php echo base_url() ?>';
    // let setupIndex = 0;

    // Tambah Setup Panel
    $("#add-setup").click(function(){
      let setupIndex = $('.collapse-payment').length;
      let panelId = setupIndex;

      let setupHtml = `
      <div class="panel panel-primary setup-block">
        <div class="panel-heading">
          <h4 class="panel-title">
            <button type="button" class="btn btn-danger btn-xs pull-left hide-view remove-setup" style="margin-right:10px;">
              <span class="glyphicon glyphicon-remove"></span>
            </button>
            <a data-toggle="collapse" data-parent="#setup-accordion" href="#setup${panelId}">
              Payment Item
              <span class="pull-right subtotal">
                Subtotal: <span class="subtotal-idr">0</span> | <span class="subtotal-usd">0</span>
              </span>
            </a>
          </h4>
        </div>
        <div id="setup${panelId}" class="collapse-payment panel-collapse collapse in" data-panelid="${panelId}" style="border:1px solid #337ab7;">
          <div class="panel-body">
            <!-- Payment Item Table -->
            <table class="table table-bordered setup-payment-table">
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
            <button class="btn btn-info btn-sm hide-view add-setup-item" type="button">
              <span class="glyphicon glyphicon-plus"></span> Add Payment Item
            </button>

            <hr>

            <!-- Grantee Selection -->
            <h5><strong>Select Grantee</strong></h5>
            <div class="form-inline">
                <select class="form-control-view form-control select-status" id="select-status-${panelId}" name="add_record[status_grantee]">
                    <option value="">-- Select Status --</option>
                    <option value="<?= STATUS_FINALIST ?>">Finalist</option>
                    <option value="<?= STATUS_NEW_GRANTEE ?>">Incoming Grantee</option>
                    <option value="<?= STATUS_VISA_APPLICATION ?>">Visa Application</option>
                    <option value="<?= CURRENT_GRANTEE ?>">Current Grantee</option>
                    <option value="<?= STATUS_SET_TO_ALUMNI ?>">Alumni</option>
                </select>
                <select class="form-control-view form-control select-grantee selectpicker hide" id="select-grantee-${panelId}" data-live-search="true">
                    <option value="">-- Select Grantee --</option>
                    <?php foreach ($user_grantee as $grantee) { ?>
                        <option value="<?php echo $grantee->user_grantee_id; ?>" data-grantee_grant_id="<?php echo $grantee->grantee_grant_id; ?>" data-grantee_name="<?php echo get_full_name($grantee, 'US'); ?>"><?php echo get_full_name($grantee, 'US'); ?></option>
                    <?php } ?>
                </select>
                <button class="btn btn-primary btn-sm add-grantee" type="button">
                    <span class="glyphicon glyphicon-plus"></span> Add Grantee
                </button>
            </div>

            <!-- Grantee Container -->
            <div class="grantee-container" style="margin-top:15px;"></div>
          </div>
        </div>
      </div>`;

      $("#setup-accordion").append(setupHtml);
      $('.selectpicker').selectpicker('refresh');
      setupIndex++;
    });

    // Hapus Setup Block
    $(document).on("click", ".remove-setup", function(){
      if (confirm("Are you sure want to delete this ?")){

        let setupBlock = $(this).closest('.setup-block');
        let removeGrantee = setupBlock.find('.remove-grantee');
        removeGrantee.each(function(){
          var paymentId = $(this).data('paymentid');
          recordDeletePayment(paymentId);
        });
        $(this).closest(".setup-block").remove();
        updateGlobalTotal();
      }
    });

    // Tambah Payment Item
    $(document).on("click", ".add-setup-item", function(){
        let $tbody = $(this).closest(".setup-block").find("tbody");
        let category    = 'Grant Cost',
            sub_category= $('#sub_category_bulk').val(),
            selectedOpt = $('#select-grantee option:selected'),
            grantee_grant_id = $(this).data('granteegrantid');

        let trIndex = $(this).closest(".setup-block").find($('.tr-payment-item')).length;
        let panelId = $(this).closest(".setup-block").find($('.collapse-payment')).data('panelid');
        // load Payment Items
        let getPaymentItems = getSyncData("<?= site_url('admin/payment_item/get_payment_item'); ?>", {
            category_type: category, sub_category, country_id: 2
        });
        let rowHtml = `
            <tr class="tr-payment-item">
                <td>
                    <select class="form-control setup-payment-item select2" name="setup[${panelId}][${trIndex}][payment_item]">
                        <option value=''>Select Payment Item</option>
                        ${JSON.parse(getPaymentItems).map(v => `<option value="${v.id}">${v.payment_item}</option>`).join('')}
                        <option value="__add_new__" data-category="grant_cost" data-subcategory="sub_category_bulk" data-select="setup-payment-item"> <span class="glyphicon glyphicon-plus"></span> Add Payment Item</option>
                    </select>
                </td>
                <td><input type="text" class="form-control setup-idr convert-setup-idr" name="setup[${panelId}][${trIndex}][nominal_idr]"></td>
                <td><input type="text" class="form-control setup-usd convert-setup-usd" name="setup[${panelId}][${trIndex}][nominal_usd]"></td>
                <td class="text-center">
                    <button type="button" class="hide-view btn btn-danger btn-sm hide-view remove-item"><span class="glyphicon glyphicon-trash"></span></button>
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
    $(document).on("click", ".remove-item", function(){
      if (confirm("Are you sure want to delete this ?")){
        $(this).closest("tr").remove();
        updateSubtotal($(this).closest(".setup-block"));
        updateGlobalTotal()
      }
    });


    $(document).on("change", "#disbursment", function(){
      let disbursment = $(this).val();
      let notify_date = $('#add_notify_date_cost');
      let req_ = $('.req-notify');
      
      if(disbursment == '1st Disbursement' || disbursment == 'Final Payment'){
        notify_date.attr('required', false).attr('disabled', true);
        req_.addClass('hide');
      }else{
        notify_date.attr('required', true).attr('disabled', false);
        req_.removeClass('hide');
      }
    });

    // Tambah Grantee
    // $(document).on("click", ".add-grantee", function(){
    //     let $setupBlock = $(this).closest(".setup-block");
    //     let panelId = $(this).closest(".setup-block").find($('.collapse-payment')).data('panelid');
    //     let period_id   = $('#period_id').val(),
    //         grant_id    = $('#grant_id').val(),
    //         status      = $('#select-status').val(),
    //         category    = 'Grant Cost',
    //         sub_category= $('#sub_category_bulk').val(),
    //         selectedOpt = $('#select-grantee-'+panelId+' option:selected'),
    //         user_id     = $('#select-grantee-'+panelId).val(),
    //         disbursment = $('#disbursment').val(),
    //         granteeName= selectedOpt.data('grantee_name'),
    //         grantee_grant_id = selectedOpt.data('grantee_grant_id');

    //     if(!user_id) return alert("Please select a grantee!");

    //     let $setupRows = $setupBlock.find(".setup-payment-table tbody tr");
    //     if($setupRows.length === 0) return alert("Please add at least 1 payment item!");

    //     // let rowsHtml = "";
    //     $setupRows.each(function(){
    //         let itemText = $(this).find(".setup-payment-item option:selected").text();
    //         let idr = $(this).find(".setup-idr").val();
    //         let usd = $(this).find(".setup-usd").val();

    //         // rowsHtml += `
    //         // <tr>
    //         // <td>${itemText}</td>
    //         // <td>${idr}</td>
    //         // <td>${usd}</td>
    //         // </tr>`;
    //     });

    //     // load Bank Info khusus grantee
    //     let getOptionBankInfo = getSyncData("<?= site_url('admin/grantee/get_bank_info/'); ?>" + user_id, {
    //         period_id, grant_id, status
    //     });

    //     let granteeCard = `
    //     <div class="panel panel-info grantee-card">
    //         <div class="panel-heading">
    //             <div class="row">
    //             <!-- Grantee name -->
    //             <div class="col-sm-4">
    //                 <strong>${granteeName}</strong>
    //                 <input type="hidden" name="add_record[grantee][${panelId}][${grantee_grant_id}][user_id]" value="${user_id}">
    //             </div>

    //             <!-- Bank select -->
    //             <div class="col-sm-3">
    //                 <select class="form-control select2 grantee-bank-info"
    //                 name="add_record[grantee][${panelId}][${grantee_grant_id}][bank_info_id]">
    //                 <option value="">Select Bank Info</option>
    //                 ${JSON.parse(getOptionBankInfo).map(v => `
    //                     <option value="${v.id}" ${(v.id == '' || v.id == 0) ? "selected" : ""}>${v.bank_name} - ${v.account_number}</option>
    //                 `).join('')}
    //                 </select>
    //             </div>

    //             <div class="col-sm-3">
    //               <input type="file" id="proof" name="proof_${grantee_grant_id}" class="form-control">
    //             </div>

    //             <!-- Remove button -->
    //             <div class="col-sm-2 text-right">
    //                 <button type="button" class="btn btn-danger btn-xs hide-view remove-grantee">
    //                 <span class="glyphicon glyphicon-remove"></span>
    //                 </button>
    //             </div>
    //             </div>
    //         </div>
    //     </div>
    // `;

    //     $setupBlock.find(".grantee-container").append(granteeCard);
    //     updateSubtotal($(this).closest($setupBlock));
    // });




    $(document).on("click", ".add-grantee", async function(){
        showSwal('loading', 'Please wait while we process your request.');

        let $setupBlock = $(this).closest(".setup-block");
        let panelId = $setupBlock.find('.collapse-payment').data('panelid');
        let period_id   = $('#period_id').val(),
            grant_id    = $('#grant_id_bulk').val(),
            status      = $('#select-status-'+panelId).val(),
            category    = 'Grant Cost',
            sub_category= $('#sub_category_bulk').val(),
            disbursment = $('#disbursment').val();

        if(!status){
            Swal.close();
            return Swal.fire("Warning", "Please select a status!", "warning");
        }

        // get semua grantee berdasarkan status
        let getAllGrantee = await getAsyncData("<?= site_url('world/get_grantee_by_status/'); ?>" + status, {
            period_id : null, grant_id : grant_id
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

        let $setupRows = $setupBlock.find(".setup-payment-table tbody tr");
        if($setupRows.length === 0){
            Swal.close();
            return Swal.fire("Warning", "Please add at least 1 payment item!", "warning");
        }

        let granteeCard = '';

        // loop grantee
        for (const g of grantees) {
            //skip jika grantee sudah ada di panel
            const exists = $setupBlock.find(`.grantee-check[value="${g.user_grantee_id}"]`).length > 0;
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
                <div class="panel panel-info grantee-card">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-sm-1">
                                <input type="checkbox" class="grantee-check" name="add_record[grantee][${panelId}][${g.id}][user_id]" value="${g.user_grantee_id}">
                            </div>
                            <div class="col-sm-3">
                                <strong>${g.full_name}</strong>
                            </div>

                            <div class="col-sm-3">
                                <select class="form-control select2 grantee-bank-info"
                                    name="add_record[grantee][${panelId}][${g.id}][bank_info_id]">
                                    <option value="">Select Bank Info</option>
                                    ${bankInfoList.map(v => `
                                        <option value="${v.id}" ${(v.id == '' || v.id == 0) ? "selected" : ""}>${v.bank_name} - ${v.account_number}</option>
                                    `).join('')}
                                </select>
                            </div>

                            <div class="col-sm-3">
                                <input type="file" id="proof_${g.id}" name="proof_${g.id}" class="form-control">
                            </div>

                            <div class="col-sm-2 text-right">
                                <button type="button" class="btn btn-danger btn-xs hide-view remove-grantee">
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

        let $container = $setupBlock.find(".grantee-container");
        if ($container.find(".grantee-check-all").length === 0) {
            $container.prepend(`
                <div class="mb-2">
                    <label>
                        <input type="checkbox" class="grantee-check-all"> Select All
                    </label>
                </div>
                <table class="table" style="margin-bottom:0px;">
                    <thead>
                        <tr>
                            <th width="9%">#</th>
                            <th width="25%" width="22%">Grantee Name</th>
                            <th width="25%">Bank Info</th>
                            <th>Proof of Transfer</th>
                        </tr>
                    </thead>
                </table>

            `);
        }
        $container.append(granteeCard);

        // append hasil
        // $setupBlock.find(".grantee-container").append(granteeCard);
        let allChecked = $container.find(".grantee-check").length === 
                        $container.find(".grantee-check:checked").length;
        $container.find(".grantee-check-all").prop("checked", allChecked);

        // update subtotal 
        updateSubtotal($setupBlock);
    });

    function getAsyncData(url, data = {}) {
        return $.ajax({
            url: url,
            type: 'POST',
            data: data,
            dataType: 'text',
        });
    }


    // Hapus Grantee
    $(document).on("click", ".remove-grantee", function(){
      element = $(this);
      if (confirm("Are you sure want to delete this ?")){
        var paymentId = $(this).data('paymentid');
        recordDeletePayment(paymentId);

        var container = element.closest(".setup-block");

        $(this).closest(".grantee-card").remove();
        updateSubtotal(container);
        
      }
    });


    function recordDeletePayment(id) {
        var deleted = $("#delete_payment").val();
        if(deleted == ''){
            $("#delete_payment").val(id);
        }else{
            var join_id = deleted + ',' + id;
            $("#delete_payment").val(join_id);
        }
    }

    // Update Subtotal saat nominal berubah
    $(document).on("input", ".setup-idr, .setup-usd", function(){
      let $setupBlock = $(this).closest(".setup-block");
      updateSubtotal($setupBlock);
    });
    
    // jika klik checkbox individual
    $(document).on("change", ".grantee-check", function(){
      let $setupBlock = $(this).closest(".setup-block");

      let allChecked = $setupBlock.find(".grantee-check").length === 
                      $setupBlock.find(".grantee-check:checked").length;
      $setupBlock.find(".grantee-check-all").prop("checked", allChecked);

      updateSubtotal($setupBlock);
    });

    // jika klik "Select All"
    $(document).on("change", ".grantee-check-all", function(){
      let $setupBlock = $(this).closest(".setup-block");
      let checked = $(this).is(":checked");

      $setupBlock.find(".grantee-check").prop("checked", checked);
      updateSubtotal($setupBlock);
    });


    // Hitung Subtotal per setup
    function updateSubtotal($setupBlock){
      let idrTotal = 0, usdTotal = 0;

      // ambil hanya grantee yang dicentang
      let $checkedGrantees = $setupBlock.find(".grantee-card").has(".grantee-check:checked");
      let countGrantee = $checkedGrantees.length;

      // kalau tidak ada yang dicentang, bisa default ke 1 atau 0 tergantung kebutuhan
      if (countGrantee === 0) countGrantee = 1;

      $setupBlock.find("tbody tr").each(function(){
        let idr = parseIDR($(this).find(".setup-idr").val()) || 0;
        let usd = parseUSD($(this).find(".setup-usd").val()) || 0;
        idrTotal += idr;
        usdTotal += usd;
      });
      // let $granteeLength = $setupBlock.find(".grantee-card").length;

      // let countGrantee = $granteeLength == 0 ? 1 : $granteeLength;
      $setupBlock.find(".subtotal-idr").text(formatIDR(idrTotal*countGrantee));
      $setupBlock.find(".subtotal-usd").text(formatUSD(usdTotal*countGrantee));
      updateGlobalTotal();
    }

    // Hitung Total Global semua setup
    function updateGlobalTotal(){
      let globalIdr = 0, globalUsd = 0;
      $(".setup-block").each(function(){
        globalIdr += parseIDR($(this).find(".subtotal-idr").text()) || 0;
        globalUsd += parseUSD($(this).find(".subtotal-usd").text()) || 0;
      });
      $("#global-idr").text(formatIDR(globalIdr));
      $("#global-usd").text(formatUSD(globalUsd));
    }

    // Parsing input sesuai format (misal IDR pakai titik ribuan dan koma desimal)
    // function parseIDR(val) {
    //   if (!val) return 0;
    //   return parseFloat(val.replace(/\./g, "").replace(",", "."));
    // }

    // function parseUSD(val) {
    //   if (!val) return 0;
    //   return parseFloat(val.replace(",", "")); // US pakai titik desimal
    // }

    function lockSelect2(selector) {
      // $(selector).on('select2:opening.select2lock select2:unselecting.select2lock', function(e) {
      //     e.preventDefault();
      // });
      $(selector).on('select2:opening.select2lock', function (e) {
        e.preventDefault(); // mencegah dropdown dibuka
      });

      // Nonaktifkan ketik di search bar, tapi tetap bisa fokus
      $(selector).next('.select2-container').find('.select2-selection').css({
        'background-color': '#f5f5f5',
        'pointer-events': 'none'
      });
    }

    function unlockSelect2(selector) {

      $(selector).off('.select2lock');
      $(selector).next('.select2-container').find('.select2-selection').css({
        'background-color': '',
        'pointer-events': ''
      });
    }


    // edit payment old
    $('#mdl_bulk_grantee').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var mode = button.data('mode');
        var grant_id = <?= $grant_id ?? '' ?>;
        var $modal = $(this);
        let record_id = button.data('record_id');
        let $container= $modal.find('.section_uss');
        let $modalBody= $modal.find('.modal-body');
        let $footer= $modal.find('.modal-footer');
        let $paymentItemSection= $modal.find('#setup-accordion');

        $modal.find('input[type="text"], input[type="number"], input[type="hidden"], textarea').val('');
        $modal.find('select').val('').trigger('change');
        $modal.find('input[type="checkbox"], input[type="radio"]').prop('checked', false);
        $('#grantee-container').html('');
        $('#grant_id_bulk').val(grant_id);

        if(mode == 'view' || mode == 'edit') {
          $container.addClass('hide')
          $footer.addClass('hide')
          $modalBody.append('<div class="text-center spinner-modal"><i class="fa fa-spinner fa-spin"></i> Loading...</div>');

          $.ajax({
            url: "<?= site_url('admin/request_payment/get_bulk_payment') ?>/" + record_id,
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
                    var from_date = new Date(res.data.general.from_date);
                    var to_date = new Date(res.data.general.to_date);
                    var notify_date = res.data.general.notify_date ? new Date(res.data.general.notify_date) : '';
                    var release_date = res.data.general.release_date ? new Date(res.data.general.release_date) : '';

                    $('#disbursment').val(res.data.general.payment_name).trigger('change');
                    $('#sub_category_bulk').val(res.data.general.payment_sub_category_id);
                    $('#add_from_date').val((from_date.getDate() < 10 ? '0' + from_date.getDate() : from_date.getDate()) + ' ' + monthNames[from_date.getMonth()] + ' ' + from_date.getFullYear());
                    $('#add_to_date').val((to_date.getDate() < 10 ? '0' + to_date.getDate() : to_date.getDate()) + ' ' + monthNames[to_date.getMonth()] + ' ' + to_date.getFullYear());
                    $('#add_notify_date_cost').val( notify_date ? (notify_date.getDate() < 10 ? '0' + notify_date.getDate() : notify_date.getDate()) + ' ' + monthNames[notify_date.getMonth()] + ' ' + notify_date.getFullYear() : '');
                    $('#release_note').val(res.data.general.release_note);
                    $('#user_grantee_grant_memo_id').val(res.data.general.user_grantee_grant_memo_id);
                    $('#add_deadline_date').val(res.data.general.deadline_date);
                    $('#add_record_priority_bulk').val(res.data.general.priority);
                    $('#record_status_grantee').val(res.data.general.payment_status);
                    $('#grant_id_bulk').val(res.data.general.grant_id);
                    $('#bulk_id').val(res.data.id);
                    $('#add_release_date_bulk').val( release_date ? (release_date.getDate() < 10 ? '0' + release_date.getDate() : release_date.getDate()) + ' ' + monthNames[release_date.getMonth()] + ' ' + release_date.getFullYear() : '');
                    
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

                    let html = renderPaymentPanel(res.data);
                    $paymentItemSection.html(html);

                    // reinit select2 / selectpicker
                    $container.find('.selectpicker').selectpicker('refresh');
                    $container.find('.select2').select2({
                      templateResult: function (data) {
                        if (!data || typeof data !== 'object') return '';

                        if (data.id === '__add_new__') {
                            return $('<span style="color:#337ab7;"> <span class="glyphicon glyphicon-plus"></span> Add Payment Item</span>');
                        }

                        return data.text || '';
                      }
                    });
                    $modalBody.find(".setup-block").each(function(){
                      updateSubtotal($(this));
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
              $('#exampleModalLabelGrantee').text('Edit Bulk Grantee')
              $(".radio-for").prop('disabled', true);
          }
          lockSelect2('#sub_category_bulk')
          lockSelect2('#disbursment')

          $('#sub_category_bulk, #disbursment').addClass('readonly-selectpicker');
          // $('#sub_category_bulk, #disbursment').prop('disabled', true)
        }else if(mode == 'add'){
            $('#disbursment').val('');
            $('#sub_category_bulk').val('');
            $('#release_note').val('');
            $('#user_grantee_grant_memo_id').val('');
            $('#add_deadline_date').val('');
            $('#add_record_priority').val('');
            $('#record_status_grantee').val('');

            // kosongkan wrap grantee
            $paymentItemSection.html('');
            $('#exampleModalLabelGrantee').text('Add Bulk Grantee');
            $('.form-control-view').prop('disabled', false);
            $('.modal-footer, .hide-view, .edit-add-more-data-payment').removeClass('hide')
            updateSubtotal($modalBody.find(".setup-block"));
            unlockSelect2('#sub_category_bulk');
            unlockSelect2('#disbursment');
            $('#record_status_grantee').val(1);
            $('#sub_category_bulk, #disbursment').removeClass('readonly-selectpicker');
        }


            
    });

    // end edit payment bulk old

    // EDIT PAYMENT BULK

    // END EDIT PAYMENT BULK


    function showLoadSpiner()
    {
        Swal.fire({
            title: 'Loading...',
            text: 'Please wait while we process your request.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false, 
            didOpen: () => {
                Swal.showLoading(); 
            }
        });
    }

    function renderPaymentPanel(data){  
        // return false
        let html = '';
        data.setups.forEach(function(setup, idx){
            let panelId = idx;
            // let getAllGrantee = getSyncData("<?= site_url('world/get_grantee_by_status/'); ?>" + 5,{
            //   period_id : null, grant_id : data.general.grant_id
            // });
            // var grantees = JSON.parse(getAllGrantee)
            let selectedGrantees = setup.grantees || [];


            html += `

            <div class="panel panel-primary setup-block">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <button type="button" class="btn btn-danger btn-xs pull-left hide-view remove-setup" style="margin-right:10px;">
                    <span class="glyphicon glyphicon-remove"></span>
                  </button>
                  <a data-toggle="collapse" data-parent="#setup-accordion" href="#setup${panelId}">
                    Payment Item
                    <span class="pull-right subtotal">
                      Subtotal: <span class="subtotal-idr">0</span> | <span class="subtotal-usd">0</span>
                    </span>
                  </a>
                </h4>
              </div>
              <div id="setup${panelId}" class="collapse-payment panel-collapse collapse in" data-panelid="${panelId}"style="border:1px solid #337ab7;">
                <div class="panel-body">
                  <!-- Payment Item Table -->
                  <table class="table table-bordered setup-payment-table">
                    <thead>
                      <tr>
                        <th>Payment Item</th>
                        <th>Nominal IDR</th>
                        <th>Nominal USD</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>`;

                    let category    = 'Grant Cost',
                        sub_category= $('#sub_category_bulk').val(),
                        selectedOpt = $('#select-grantee option:selected'),
                        grantee_grant_id = $(this).data('granteegrantid');
                    // load Payment Items
                    let getPaymentItems = getSyncData("<?= site_url('admin/payment_item/get_payment_item'); ?>", {
                        category_type: category, sub_category, country_id: 2
                    });
                    setup.items.forEach(function(item, inItem){

                        // let trIndex = $(this).closest(".setup-block").find($('.tr-payment-item')).length;
                        html += `
                      <tr class="tr-payment-item">
                          <td>
                              <select class="form-control setup-payment-item select2" name="setup[${panelId}][${inItem}][payment_item]">
                                  <option value=''>Select Payment Item</option>
                                  ${JSON.parse(getPaymentItems).map(v => `<option value="${v.id}" ${v.id == item.item_id ? "selected" : ""}>${v.payment_item}</option>`).join('')}
                                  <option value="__add_new__" data-category="grant_cost" data-subcategory="sub_category_bulk" data-select="setup-payment-item"> <span class="glyphicon glyphicon-plus"></span> Add Payment Item</option>
                              </select>
                          </td>
                          <td><input type="text" class="form-control setup-idr convert-setup-idr" name="setup[${panelId}][${inItem}][nominal_idr]" value="${item.idr}"></td>
                          <td><input type="text" class="form-control setup-usd convert-setup-usd" name="setup[${panelId}][${inItem}][nominal_usd]" value="${item.usd}"></td>
                          <td class="text-center">
                              <button type="button" class="hide-view btn btn-danger btn-sm hide-view remove-item"><span class="glyphicon glyphicon-trash"></span></button>
                          </td>
                      </tr>`;
                    });
            html += `
                    </tbody>
                  </table>`;


            html +=`
                  <button class="btn btn-info btn-sm hide-view add-setup-item" type="button">
                    <span class="glyphicon glyphicon-plus"></span> Add Payment Item
                  </button>

                  <hr>

                  <!-- Grantee Selection -->
                  <h5><strong>Select Grantee</strong></h5>
                  <div class="form-inline">
                      <select class="form-control-view form-control select-status" id="select-status-${panelId}" name="add_record[status_grantee]">
                          <option value="">-- Select Status --</option>
                          <option value="<?= STATUS_FINALIST ?>">Finalist</option>
                          <option value="<?= STATUS_NEW_GRANTEE ?>">Incoming Grantee</option>
                          <option value="<?= STATUS_VISA_APPLICATION ?>">Visa Application</option>
                          <option value="<?= CURRENT_GRANTEE ?>">Current Grantee</option>
                          <option value="<?= STATUS_SET_TO_ALUMNI ?>">Alumni</option>
                      </select>
                      <select class="form-control-view form-control select-grantee selectpicker hide" id="select-grantee-${panelId}" data-live-search="true">
                          <option value="">-- Select Grantee --</option>
                          <?php foreach ($user_grantee as $grantee) { ?>
                              <option value="<?php echo $grantee->user_grantee_id; ?>" data-grantee_grant_id="<?php echo $grantee->grantee_grant_id; ?>" data-grantee_name="<?php echo get_full_name($grantee, 'US'); ?>"><?php echo get_full_name($grantee, 'US'); ?></option>
                          <?php } ?>
                      </select>
                      <button class="btn btn-primary btn-sm add-grantee" type="button">
                          <span class="glyphicon glyphicon-plus"></span> Add Grantee
                      </button>
                  </div>

                  <!-- Grantee Container -->
                  <div class="grantee-container" style="margin-top:15px;">`;
                  
                  if (selectedGrantees.length) {
                    html += `
                        <div class="panel panel-default mb-2 p-2 border">
                            <div class="checkbox mb-2">
                                <label><input type="checkbox" class="grantee-check-all"> <strong>Select All</strong></label>
                            </div>
                        </div>
                        <table class="table" style="margin-bottom:0px;">
                            <thead>
                                <tr>
                                    <th width="9%">#</th>
                                    <th width="25%" width="22%">Grantee Name</th>
                                    <th width="25%">Bank Info</th>
                                    <th>Proof of Transfer</th>
                                </tr>
                            </thead>
                        </table>
                    `;
                  }

                  // =============================
                  // SHOW ALL GRANTEES & CHECKED
                  // =============================
                  // for (const g of grantees) {
                  //     let getOptionBankInfo = getSyncData("<?= site_url('admin/grantee/get_bank_info/'); ?>" + g.user_grantee_id);

                  //     let bankInfoList = [];
                  //     try {
                  //         bankInfoList = JSON.parse(getOptionBankInfo);
                  //     } catch (e) {
                  //         bankInfoList = [];
                  //     }
                  //     let isChecked = selectedGrantees.some(sel => {
                  //         if (typeof sel === 'object' && sel !== null) {
                  //             return sel.user_id == g.user_grantee_id;
                  //         } else {
                  //             return sel == g.user_grantee_id; // kalau cuma array of string
                  //         }
                  //     }) ? 'checked' : '';

                  //     let matched = selectedGrantees.find(sel => {
                  //         if (typeof sel === 'object' && sel !== null) {
                  //             return sel.user_id == g.user_grantee_id;
                  //         } else {
                  //             return false;
                  //         }
                  //     });

                  //     let proofHtml = '';
                  //     let paymentId = '';
                  //     let bankInfoId = '';
                  //     if (matched && matched.proof) {
                  //         proofHtml = `<a href="${BASEURL + matched.proof}" class="lightbox"><label class="label label-primary" disabled>View Proof</label></a>`;
                  //     }
                  //     if (matched && matched.payment_id) {
                  //         paymentId = `<input type="hidden" name="add_record[grantee][${panelId}][${g.id}][payment_id]" value="${matched.payment_id}">`;
                  //     }
                  //     if (matched) {
                  //       bankInfoId = matched.bank_info_id
                  //     }

                  //     html += `
                  //         <div class="panel panel-info grantee-card">
                  //             <div class="panel-heading">
                  //                 <div class="row align-items-center">
                  //                     <div class="col-sm-1">
                  //                         <input type="checkbox" class="grantee-check" ${isChecked}
                  //                             name="add_record[grantee][${panelId}][${g.id}][user_id]"
                  //                             value="${g.user_grantee_id}">
                  //                             ${paymentId}
                                              
                                          
                                          
                  //                     </div>
                  //                     <div class="col-sm-3">
                  //                         <strong>${g.full_name}</strong>
                  //                     </div>
                  //                     <div class="col-sm-3">
                  //                         <select class="form-control select2 grantee-bank-info"
                  //                             name="add_record[grantee][${panelId}][${g.id}][bank_info_id]">
                  //                             <option value="">Select Bank Info</option>
                  //                             ${bankInfoList.map(v => `
                  //                                 <option value="${v.id}" ${bankInfoId == v.id ? 'selected' : ''}>
                  //                                     ${v.bank_name} - ${v.account_number}
                  //                                 </option>
                  //                             `).join('')}
                  //                         </select>
                  //                     </div>
                  //                     <div class="col-sm-3">
                  //                         <input type="file" id="proof_${g.id}" name="proof_${g.id}" class="form-control">
                  //                         ${proofHtml}
                  //                     </div>
                  //                     <div class="col-sm-2 text-right">
                  //                         <button type="button" class="btn btn-danger btn-xs hide-view remove-grantee">
                  //                             <span class="glyphicon glyphicon-remove"></span>
                  //                         </button>
                  //                     </div>
                  //                 </div>
                  //             </div>
                  //         </div>
                  //     `;
                  // }


                  // ========================
                  // ONLY SHOW SAVED GRANTEES
                  // ========================
                  selectedGrantees.forEach((g, i) => {
                      let getOptionBankInfo = getSyncData("<?= site_url('admin/grantee/get_bank_info/'); ?>" + g.user_id);
                      let bankInfoList = [];
                      try {
                          bankInfoList = JSON.parse(getOptionBankInfo);
                      } catch (e) {}

                      let proofHtml = g.proof 
                          ? `<a href="${BASEURL + g.proof}" class="lightbox"><label class="label label-primary" disabled>View Proof</label></a>`
                          : '';

                      html += `
                      <div class="panel panel-info grantee-card">
                        <div class="panel-heading">
                          <div class="row align-items-center">
                            <div class="col-sm-1">
                              <input type="checkbox" class="grantee-check" checked
                                name="add_record[grantee][${panelId}][${g.grantee_grant_id}][user_id]"
                                value="${g.user_id}">
                              <input type="hidden" name="add_record[grantee][${panelId}][${g.grantee_grant_id}][payment_id]" value="${g.payment_id}">
                            </div>
                            <div class="col-sm-3">
                              <strong>${g.grantee_name}</strong>
                            </div>
                            <div class="col-sm-3">
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
                              <input type="file" id="proof_${g.grantee_grant_id}" name="proof_${g.grantee_grant_id}" class="form-control">
                              ${proofHtml}
                            </div>
                            <div class="col-sm-2 text-right">
                              <button type="button" class="btn btn-danger btn-xs hide-view remove-grantee">
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


    $(document).on("change", ".select-status", function(){
      value = $(this).val();
      
      if(value == 24){
        $('#record_status_grantee').val(2).addClass('readonly-select');
      }else{
        $('#record_status_grantee').val('').removeClass('readonly-select');
      }
    })

</script>