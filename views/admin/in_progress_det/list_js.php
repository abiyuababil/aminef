<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    const BASE_URL = '<?= base_url() ?>';
    var add_cupon = <?= !is_null($this->session->flashdata('add_cupon')) ? 1 : 0 ?>;
    var send_tnc = <?= !is_null($this->session->flashdata('send_tnc')) ? 1 : 0 ?>;
    var update_agreement = <?= !is_null($this->session->flashdata('update_agreement')) ? 1 : 0 ?>;
    var bulk_action = <?= !is_null($this->session->flashdata('bulk_action')) ? 1 : 0 ?>;

    var SaveToast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true
    });
    
    $(document).ready(function() {

        if(add_cupon){
            setTimeout(function() {
                SaveToast.fire({icon: 'success', title: 'Coupon Code has been saved'});
            }, 500);
        }
        if(send_tnc){
            setTimeout(function() {
                SaveToast.fire({icon: 'success', title: 'Successfully send email'});
            }, 500);
        }
        if(update_agreement){
            setTimeout(function() {
                SaveToast.fire({icon: 'success', title: 'Successfully update status Agreement'});
            }, 500);
        }
        if(bulk_action){
            setTimeout(function() {
                SaveToast.fire({icon: 'success', title: 'Successfully update status Application'});
            }, 500);
        }

        // $('.dateRangePicker').on('apply.daterangepicker', function(ev, picker) {
        //     $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        // });

        // $('.dateRangePicker').on('cancel.daterangepicker', function(ev, picker) {
        //     $(this).val('');
        // });

        $(".datepicker").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "mm/dd/yy",
        });

        $(".datetime").datetimepicker({
            format: 'mm/dd/yyyy hh:ii',
            autoclose: true,
            todayBtn: true
        });

        // $( ".dateRangePicker" ).daterangepicker({
        //     autoUpdateInput: false,
        //     locale: {
        //         // format: 'DD-MMM-YYYY',
        //         cancelLabel: 'Clear'
        //     }
        // });
        $(".dateRangePicker").each(function () {
            const $this = $(this);

            const startDate = $this.attr('data-start-date');
            const endDate = $this.attr('data-end-date');

            // Default tanggal yang SELALU valid
            let start = moment().startOf('day');
            let end = moment().startOf('day');

            const parsedStart = moment(startDate, 'YYYY-MM-DD HH:mm:ss', true);
            const parsedEnd = moment(endDate, 'YYYY-MM-DD HH:mm:ss', true);

            // Kalau DB punya tanggal valid, pakai tanggal dari DB
            if (parsedStart.isValid() && parsedEnd.isValid()) {
                start = parsedStart;
                end = parsedEnd;

                $this.val(
                    start.format('MM/DD/YYYY') +
                    ' - ' +
                    end.format('MM/DD/YYYY')
                );
            } else {
                // DB kosong → input tetap kosong
                $this.val('');
            }

            $this.daterangepicker({
                autoUpdateInput: false,

                startDate: start,
                endDate: end,

                locale: {
                    format: 'MM/DD/YYYY',
                    cancelLabel: 'Clear'
                }
            });
        });

        function update_application(element, value = null, extraData = {}) {
            var $element = $(element);

            var data = {
                value: value !== null ? value : $element.val(),
                id: $element.data('id'),
                field: $element.data('field'),
                ...extraData
            };

            $.ajax({
                url: "<?= base_url(); ?>admin/testing_det/update_application",
                method: "POST",
                data: data
            }).success(function(data) {
                console.log(data);
                show_toast('Successfully Update!');
            });
        }
        
        $(".input_data").not(".dateRangePicker").not(".datetime").blur(function() {
            update_application(this);
        });
        
        $(".dateRangePicker").on('apply.daterangepicker', function(ev, picker) {

            var $this = $(this);

            var displayValue =
                picker.startDate.format('MM/DD/YYYY') +
                ' - ' +
                picker.endDate.format('MM/DD/YYYY');

            // tampilkan di input
            $this.val(displayValue);

            // update ke backend
            update_application(this, displayValue, {
                testing_date: picker.startDate.format('YYYY-MM-DD'),
                testing_date_end: picker.endDate.format('YYYY-MM-DD')
            });
        });
        
        $(".dateRangePicker").on('cancel.daterangepicker', function(ev, picker) {

            var $this = $(this);

            $this.val('');

            update_application(this, '', {
                testing_date: '',
                testing_date_end: ''
            });
        });
        $(".dateRangePicker").on('change', function() {
            if ($(this).val().trim() === '') {
                update_application(this, '', {
                    testing_date: null,
                    testing_date_end: null
                });
            }
        });

        $(".datepicker").on('change', function() {
            update_application(this);
        });

        $(".datetime").on('changeDate', function(e) {
            var value = e.date
                ? moment(e.date).format('YYYY-MM-DD HH:mm:ss')
                : null;

            update_application(this, value);
        });
        $(".datetime").on('change', function() {
            if ($(this).val().trim() === '') {
                update_application(this, null);
            }
        });

        function show_toast(msg, type = 'success') {
            if (window.Swal && Swal.fire) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500,
                    icon: type === 'error' ? 'error' : 'success',
                    title: msg,
                    showClass: { popup: '' },
                    hideClass: { popup: '' }
                });
                return;
            }
            console.log((type || 'info') + ': ' + msg);
        }

    });

    $(".succesfully").click(function () {
        var id = $(this).data('id');
        $("#mdl_info").modal();
        $('#btn-successful').attr("onclick", "succesfully(" + id + ")");
        event.preventDefault();
    });

    function succesfully(grantee_grant_id) {
        $('#btn-successful').html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop('disabled', true);
        $.ajax({
            url: "<?= base_url(); ?>admin/on_going/successfully",
            method: "POST",
            dataType: 'JSON',
            data: {
                grantee_grant_id: grantee_grant_id,
            }
        })
            .success(function (data) {
                window.location.href = data.redirect;
            })
    }

    function add_filter() {
        var html = $('#template-filter').html();
        $('#wrap-filter').append(html);
    }

    function remove_filter(el) {
        $(el).parent().remove();
    }

    function submitFilter(e) {
        if (e.keyCode == 13) {
            $('#frm_manage').submit();
            return false;
        }
    }

    function show_download_modal(el) {
        var section = $(el).data('section');
        var url = "<?php echo site_url('admin/in_progress_det/download_excel?section=&') ?>";
        $('.field-alumni').prop('checked', true);
        $('.text-validation').removeClass('d-block').addClass('d-none');
        $('#text-validation-period').removeClass('d-block').addClass('d-none');
        $('#form-download-excel').attr('action', url);
        $('#section').val(section);
        $('#modalDownloadDET').modal('show');
    }

    $('#modalDownloadDET').on('show.bs.modal', function () {
        $.fn.modal.Constructor.prototype.enforceFocus = function () {
            $('.select2').select2({
                theme: 'bootstrap'
            });
        };
    });

    $('#select_period').change(function () {
        let periodId = $(this).val();
        $('.add_fields').html('');
        if (!periodId) {
            $('.field_row').addClass('hide');
            return;
        }
        $('#text-validation-period').removeClass('d-block').addClass('d-none');
        $.ajax({
            async: false,
            type: 'GET',
            url: '<?php echo site_url('admin/in_progress_det/get_all_field/') ?>' + periodId,
            dataType: 'JSON',
            success: function (data) {
                $('.field_row').removeClass('hide');
                $('.add_fields').append(data.html);
                if ($('#sel-all').is(':checked')) {
                    $('.field-alumni').prop('checked', true);
                }
            }
        });
    });

    $('#sel-all').on('change click', function () {
        $('.field-alumni').prop('checked', this.checked);
    });

    const form_download_excel = $("#form-download-excel");
    const progress_dialog = $("#progress-dialog");
    form_download_excel.off('submit').on('submit', function (e) {
        e.preventDefault();

        var periodVal = $('#select_period').val();
        var section = $('#section').val();
        if (!periodVal) {
            $('#text-validation-period').removeClass('d-none').addClass('d-block');
            return false;
        } else {
            $('#text-validation-period').removeClass('d-block').addClass('d-none');
        }

        if ($('.field-alumni:checked').length === 0) {
            $('#text-validation-field').removeClass('d-none').addClass('d-block');
            return false;
        } else {
            $('#text-validation-field').removeClass('d-block').addClass('d-none');
        }

        progress_dialog.modal('show');
        $('#modalDownloadDET').modal('hide');

        const form_data = new FormData(this);
        form_data.append('section', section);

        const post_url = $(this).attr('action') || '<?php echo site_url('admin/in_progress_det/download_excel/'); ?>';

        $.ajax({
            type: 'POST',
            url: post_url,
            data: form_data,
            processData: false,
            contentType: false,
            success: function (response) {
                let file;
                try {
                    file = (typeof response === 'object') ? response : JSON.parse(response);
                } catch (err) {
                    progress_dialog.modal('hide');
                    alert('Download failed: invalid server response');
                    return false;
                }

                if (!file || file.fileurl === null) {
                    progress_dialog.modal('hide');
                    alert('Data not available');
                    return false;
                }

                var link = document.createElement('a');
                link.href = file.fileurl;
                link.download = file.filename;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                progress_dialog.modal('hide');
            },
            error: function (error) {
                progress_dialog.modal('hide');
                alert('Download failed');
            }
        });
    });

    $('.select2').select2({
        theme: 'bootstrap',
        placeholder: 'Select Active Grant',
        maximumSelectionLength: 2,
        width: '100%'
    });

    
    $(document).on('click', '.add_coupon', function (e) {
        
        var id = $(this).data('application');
        var coupon = $(this).data('coupon');
        var testing_date = $(this).data('testing');
        var testing_date_end = $(this).data('testing-end');
        $("#mdl_add_coupon").modal();
        $('#application_id_coupon').val(id);
        $('#coupon_det').val(coupon);

        $('#selectpickerPic').val(coupon);


        if (testing_date && testing_date_end) {

            var picker = $('#testing_date_det').data('daterangepicker');

            picker.setStartDate(moment(testing_date));
            picker.setEndDate(moment(testing_date_end));

            $('#testing_date_det').val(
                moment(testing_date).format('MM/DD/YYYY') +
                ' - ' +
                moment(testing_date_end).format('MM/DD/YYYY')
            );

        } else {
            $('#testing_date_det').val('');
        }
        event.preventDefault();
    });

    $(document).on('click', '.send_tnc', function (e) {
        
        var id = $(this).data('application');
        Swal.fire({
            title: "Are you sure to send email ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, send",
            customClass: 'swal-custom'
            }).then((result) => {
            if (result.isConfirmed) {
                showSwal('loading', 'Please wait while we process your request.');
                $.ajax({
                    type: 'POST',
                    url: '<?php echo site_url('admin/testing_det/send_email_tnc'); ?>',
                    dataType: 'JSON',
                    data: {
                        application_id : id
                    },
                    success: function (response) {
                        Swal.close(); 
                        location.reload();
                    },
                    error: function (error) {
                        console.log('Failed send email');
                    }
                });
                
            }
        });
        
        
        event.preventDefault();
    });

    $(document).on('click', '.btn-review', function () {

        var $btn = $(this);

        var application_id      = $btn.data('application');
        var agreement           = $btn.data('agreement');
        var status_agreement    = $btn.data('status_agreement');
        var note_agreement      = $btn.data('note_agreement');
        var upload_date         = $btn.data('agreement_upload_date');
        var fullname            = $btn.data('fullname');
        let ext                 = agreement.split('.').pop();
        let download_icon       = '<?php echo base_url('assets/images/icons/download icon.png'); ?>';

        // Preview
        $('#agreementName').text(fullname)

        if (ext == 'jpg' || ext == 'png' || ext == 'jpeg') {
            $('#agreementPreview iframe').addClass('hide');
            $('#agreementPreview img').attr('src', BASE_URL + agreement).removeClass('hide');
        }else if(ext == 'pdf'){
            $('#agreementPreview img').addClass('hide');
            $('#agreementPreview iframe').attr('src', BASE_URL + agreement).removeClass('hide');
        }else{
            $('#agreementPreview iframe').addClass('hide');
            $('#agreementPreview img').attr('src', download_icon).removeClass('hide');

        }

        // Download
        $('#btnDownloadAgreement').attr('href', BASE_URL + agreement);

        // Hidden input
        $('#application_id_agreement').val(application_id);

        // Upload Date
        $('#agreementUploadDate').text(upload_date ? upload_date : '-');

        // Status
        if (status_agreement == 'approve') {

            $('#agreementStatus')
                .removeClass()
                .addClass('label label-success')
                .text('Approved');

        } else if (status_agreement == 'revise') {

            $('#agreementStatus')
                .removeClass()
                .addClass('label label-warning')
                .text('Revision');

        } else {

            $('#agreementStatus')
                .removeClass()
                .addClass('label label-info')
                .text('Waiting Approval');

        }

        // Note
        $('#revisionNote').val(note_agreement);

        // Reset Radio
        $('input[name=decision]').prop('checked', false);
        $('.decision-card').removeClass('active');

        if (status_agreement == 'approve') {

            $('input[name=decision][value=approve]')
                .prop('checked', true)
                .closest('.decision-card')
                .addClass('active');

            $('#revisionBox').hide();

        } else if (status_agreement == 'revise') {

            $('input[name=decision][value=revise]')
                .prop('checked', true)
                .closest('.decision-card')
                .addClass('active');

            $('#revisionBox').show();

        } else {

            $('#revisionBox').hide();

        }

    });


    $('.decision-card').click(function(){
        $('.decision-card').removeClass('active');
        $(this).addClass('active');
        $(this).find('input').prop('checked',true).trigger('change');
    });

    $('input[name=decision]').change(function(){
        if($(this).val()=='revise'){
            $('#revisionBox').slideDown();
        }else{
            $('#revisionBox').slideUp();
        }
    });
    
	$("#frm-action-bulk a").click(function () {
		if ($('.chk-row:checked').length == 0) {
			alert("You haven't select any item");
			return;
		}

		var action = $(this).attr('data-action');
		if (confirm('Are you sure want to ' + action + '?')){
            showSwal('loading', 'Please wait while we process your request.');
            var ids = $('.chk-row:checked').map(function () {
                return this.value;
            }).get();

            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/submitted_det/action_bulk_submitted') ?>',
                dataType: 'JSON',
                data: {
                    // note    : note,
                    ids : ids,
                    action : action
                },
                success: function(r) {
                    if(r.success){
                        location.reload();
                    }
                }
            });

        }
            
	});

    function handleWithdrawnFileSelect(event) {
      const file = event.target.files[0];
      const display = $('#withdrawnFileNameDisplay');
      let html = '';
      if (file) {
        let file_url = URL.createObjectURL(file);
        display.html(`<a href="${file_url}" target="_blank"><i class="fa fa-paperclip"></i> ` + file.name + `</a>`).css('display', 'block')
        // display.innerText = 'Attached: ' + file.name;
        // display.style.display = 'block';
      } else {
        display.html('').css('display', 'none')
        // display.innerText = '';
        // display.style.display = 'none';
      }
    }

    $(document).on('click', '.btn-withdrawn', function () {
        var application_id = $(this).data('application');
        var fullname       = $(this).data('fullname');

        $('#withdrawnApplicationId').val(application_id);
        $('#wGranteeTitle').text(fullname || '-');

        // reset form fields
        $('#withdrawnNote').val('');
        $('#withdrawnFile').val('');
        $('#withdrawnFileNameDisplay').hide().text('');

        $('#withdrawnModal').modal('show');
    });

    function confirmWithdrawn() {
        var note = $('#withdrawnNote').val().trim();
        if (!note) {
            Swal.fire({ icon: 'warning', title: 'Note is required', text: 'Please enter a withdrawal reason before submitting.' });
            return;
        }

        var appId = $('#withdrawnApplicationId').val();
        if (!appId) {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Application ID not found.' });
            return;
        }

        var formData = new FormData();
        formData.append('application_id', appId);
        formData.append('note_withdrawn', note);

        var fileInput = document.getElementById('withdrawnFile');
        if (fileInput.files.length > 0) {
            formData.append('attach_withdrawn', fileInput.files[0]);
        }

        $('#withdrawnModal').modal('hide');
        showSwal('loading', 'Please wait while we process your request.');

        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/testing_det/withdrawn_application'); ?>',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {
                Swal.close();
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Withdrawn Successfully',
                        text: 'The application has been marked as withdrawn.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(function () {
                        location.reload();
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Failed', text: response.message || 'Failed to process withdrawal.' });
                }
            },
            error: function () {
                Swal.close();
                Swal.fire({ icon: 'error', title: 'Error', text: 'Server error. Please try again.' });
            }
        });
    }

    function approveScore() {

        var appId = $('#application_id').val();
        if (!appId) {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Application ID not found.' });
            return;
        }

        var formData = new FormData();
        formData.append('application_id', appId);

        $('#scoreModal').modal('hide');
        showSwal('loading', 'Please wait while we process your request.');

        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/testing_det/approve_score_application'); ?>',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function (response) {
                Swal.close();
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Approve Successfully',
                        text: 'The application has been approved.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(function () {
                        location.reload();
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Failed', text: response.message || 'Failed to process approve.' });
                }
            },
            error: function () {
                Swal.close();
                Swal.fire({ icon: 'error', title: 'Error', text: 'Server error. Please try again.' });
            }
        });
    }

    $(document).on('click', '.btn-score-report', function () {
        var application_id  = $(this).data('application');
        var fullname        = $(this).data('fullname');
        var score           = $(this).data('score');
        var testDate        = $(this).data('testdate');
        var fileName        = $(this).data('basename');
        var fileUrl        = $(this).data('filename');
        
        document.getElementById('application_id').value = application_id;
        document.getElementById('mGranteeName').innerText = fullname;
        document.getElementById('mScore').innerText = score + ' / 160.00';
        document.getElementById('mTestDate').innerText = testDate;
        document.getElementById('mFileLink').innerText = ' ' + fileName;
        document.getElementById('mFileLink').href = fileUrl;
        document.getElementById('scoreModal').style.display = 'flex';

        $('#scoreModal').modal('show');
    });


    function openScoreModal(data) {
        document.getElementById('mGranteeTitle').innerText = data.granteeName;
        // document.getElementById('mPeriodTitle').innerText = data.periodInfo;
        document.getElementById('mSubmittedDate').innerText = data.submittedDate;
        document.getElementById('mDeadlineDate').innerText = data.deadlineDate;
        document.getElementById('mCouponCode').innerText = data.couponCode;
        document.getElementById('mTestSchedule').innerText = data.testSchedule;
        
        document.getElementById('mScoreP').innerText = data.overallScore + ' / 160.00';
        document.getElementById('mCompletionDate').innerText = data.completionDate;
        document.getElementById('mReportDocLink').href = data.fileUrl;
        $('#scoreModalParticipant').modal('show');
    }
    
    // $('.chk-all').on('change', function () {
    //     $('.chk-row').prop('checked', $(this).is(':checked'));
    //     updateSelectedCount();
    // });

    // $(document).on('change', '.chk-row', function () {
    //     updateSelectedCount();


    //     $('.chk-all').prop(
    //         'checked',
    //         $('.chk-row').length === $('.chk-row:checked').length
    //     );
    // });
    // function updateSelectedCount() {
    //     var total = $('.chk-row:checked').length;

    //     if(total > 0){
    //         $('#selected-count').text(total)
    //         $('.info-selected').removeClass('hide');
    //     }else{
    //         $('#selected-count').text(total)
    //         $('.info-selected').addClass('hide');
    //     }
    // }
    
</script>