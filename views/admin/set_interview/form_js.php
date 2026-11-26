<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<script>
    const SITE_URL = '<?php echo site_url(); ?>';
    $(document).ready(function() {
        $(".select_show").trigger("change");
        $('.input_time').timepicker({
            timeFormat: 'h:mm p',
            interval: 15,
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });
        $('.element_score').each(function() {
            var scoreValue = $(this).val(); // Get the value of the input field
            var index = $(this).data('index'); // Get the index from the data-index attribute
            // Check if the value is null or empty
            if (scoreValue !== '') {
                // Add the d-none class to the corresponding Prorate button
                $('.btn-prorate-' + index).addClass('d-none');
            }
        });

        $('.select2').select2({
            theme: 'bootstrap'
        });

        $(".datetime").datetimepicker({
            format: 'dd M yy hh:ii',
            autoclose: true,
        });
        $(".datepicker").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd M yy",
            yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
        });
        if ($('.datepicker').val() == '') {
            // $('.datepicker').datepicker('setDate', new Date());
        }

        var countInterviews = <?= count($interviews) ?>;
        if (countInterviews > 0) {
            for (var i = 0; i < countInterviews; i++) {
                get_panellist(i);
            }
        }

        $(".detail-interview-score").on('click', function(e) {
            e.preventDefault();
            let id = $(this).data('interview_id');
            let period_id = $(this).data('period_id');
            let interview_id = $(this).data('interview_id');
            $.ajax({
                url: '<?php echo site_url('admin/set_interview/get_detail_interview_score/'); ?>' + id + '/' + period_id,
                type: 'GET',
                dataType: 'JSON',
                success: function(response) {
                    $("#detail-score").html(response.template);
                    tinymce.init({
                        selector: '#detail-score textarea',
                        // readonly: true
                    });
                    recalculate_score();

                    $('.btn-download-score').attr("href", "<?= site_url('admin/set_interview/download_interview_score/') ?>" + interview_id + "/" + period_id)

                    $('.score').on('change', function() {
                        var score_value = parseFloat($(this).val().replace(',', '.'));
                        var min_value = parseFloat($(this).attr('min'));
                        var max_value = parseFloat($(this).attr('max'));
                        $(this).val(function(index, value) {
                            value = value.replace(',', '.');
                            return parseFloat(value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')).toFixed(2);
                        });

                        if (score_value < min_value || score_value > max_value) {
                            Swal.fire({
                                icon: "error",
                                title: "Score must be between " + min_value + " and " + max_value,
                                showConfirmButton: false,
                                timer: 2000
                            });
                            $(this).val($(this).data('oldValue'));
                        }

                        recalculate_score();
                    });
                },
                error: function(response) {
                    console.error(response);
                }
            });
        });
    });

    function recalculate_score() {
            var total_score = 0;

            $(document).find('tr.scoring-row').each(function() {
                let input_score = $(this).find('input.score');
                let select_rate = $(this).find('select.rate-score');
                let score = 0;

                if (select_rate.length == 0) {
                    let input_value = parseFloat(input_score.val());
                    if (!isNaN(input_value)) {
                        score = input_value;
                    }
                } else {
                    let selected_rate = select_rate.find('option:selected');
                    let selected_score = selected_rate.data('initial_score');
                     
                    if (selected_rate.length && undefined != selected_score) {
                        let initial_score = Number(selected_score);
                        if (!isNaN(initial_score)) {
                            score = initial_score;
                            $(this).find('input.score').val(score);
                        } else {
                            score = 0;
                        }
                    } else {
                        let input_value = parseFloat(input_score.val());
                        if (!isNaN(input_value)) {
                            score = input_value;
                        } else {
                            score = 0;
                        }
                    }
                }
                
                let weighting_score = parseFloat(input_score.data('weighting_score'));
                if (isNaN(weighting_score) || weighting_score == 0) {
                    weighting_score = 1;
                }
                
                if (!isNaN(score)) {
                    var row_total_score = score * parseFloat(weighting_score);
                    let total_score_input = $(this).find('input.total_score');
                    total_score += row_total_score;

                    total_score_input.val(row_total_score.toLocaleString('en', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                } else {
                    let total_score_input = $(this).find('input.total_score');
                    total_score_input.val(0);
                }
            });

            $("#total").text(total_score.toLocaleString('en', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $("#total_score").val(total_score.toLocaleString('en', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
    }

    $(document).on('change','.rate-score', function(){
        recalculate_score();
    });

    $("#btn-decline").click(function() {
        $("#mdl_info_decline").modal();
        event.preventDefault();
    });

    $("#btn-present").click(function() {
        $("#mdl_info_present").modal();
        event.preventDefault();
    });

    function heighlyRecommended() {
        event.preventDefault();
        if (confirm("Are you sure want to Highly Recommended this ?")) {
            var btn = $("<input>").attr("type", "hidden").attr("name", "btn").val("heighly_recommended");
            $("#form").append(btn);
            $("#form").submit();
        }

    }

    function recommended() {
        event.preventDefault();
        if (confirm("Are you sure want to Recommended this ?")) {
            var btn = $("<input>").attr("type", "hidden").attr("name", "btn").val("recommended");
            $("#form").append(btn);
            $("#form").submit();
        }

    }

    function notRecommended() {
        event.preventDefault();
        if (confirm("Are you sure want to Non Recommended this ?")) {
            var btn = $("<input>").attr("type", "hidden").attr("name", "btn").val("not_recommended");
            $("#form").append(btn);
            $("#form").submit();
        }

    }

    function get_panellist(key) {
        var idx = $('#panellis_' + key).val();
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/selection_review/get_panellist') ?>/' + idx,
            dataType: 'JSON',
            success: function(r) {
                $('#field_of_study_' + key).val(r.field_of_study_name);
                $('#email_' + key).val(r.email);
                $('#tel_' + key).val(r.telp);
                $('#home_institution_' + key).val(r.home_institution);
                $('#bank_info_' + key).val(r.bank_info);
                $('#beneficiary_name_' + key).val(r.beneficiary_name);
                $('#account_number_' + key).val(r.account_number);
                $('#status_panellist_id_' + key).val(r.status_panellist_name);
                if (r.status_panellist_name == null) {
                    $('#status_panellist_id_' + key).attr('placeholder', '');
                }
            }
        });
    }

    function add_interview() {
        var idx = $('.interview-item').length;
        $('.add-load').show();
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/set_interview/getPartial') ?>/' + idx,
            dataType: 'JSON',
            success: function(r) {
                var html = r;
                $('#w-interview').append(html);
                $('.select2').select2({
                    theme: 'bootstrap'
                });
                $('.add-load').hide();
                $(".datepicker").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: "dd M yy",
                    yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
                });
            }
        });
    }

    function hideButtonProrate(element) {
        const value = $(element).val();
        const index = $(element).data('index');
        if (value !== '') {
            $('.btn-prorate-' + index).addClass('d-none');
        } else {
            $('.btn-prorate-' + index).removeClass('d-none');
        }
    }

    function del_item(el, item_class) {
        if (confirm("Are you sure want to delete this ?"))
            $(el).closest('.' + item_class).remove();
    }

    function del_item_interview(el, item_class, interview_id) {
        if (confirm("Are you sure want to delete this ?"))
            $(el).closest('.' + item_class).remove();
        var delete_field = $("#delete_interview").val();
        if (delete_field == '') {
            $("#delete_interview").val(interview_id);
        } else {
            $("#delete_interview").val(delete_field + "," + interview_id);
        }
    }

    function submit_form(element) {
        $('#buttonValue').val(element.value);
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/selection_review/get_rank_recomendation') ?>',
            data: $("#form").serialize(),
            dataType: 'JSON',
            success: function(r) {
                console.log(r)
                if (r == <?= NOT_RECOMMENDED ?>) {
                    $("#mdl_note_reject_selection").modal();
                } else {
                    $("#form").submit();
                }
            }
        });
    }

    function emptyValue(object) {
        $(object).closest('.form-group').find('.datepicker').val('');
    }

    function emptyValueTime(object) {
        $(object).closest('.form-group').find('.input_time').val('');
    }

    function prorate_interview(el) {
        var dataIndex = $(el).data('index');
        var excludedId = 'score_' + dataIndex;
        $('.add-load-prorate-' + dataIndex).show();
        if (confirm("Are you sure?")) {
            var values = [];
            $('input.element_score').each(function() {
                if (this.id !== excludedId) {
                    values.push($(this).val());
                }
            });

            let length = values.length;
            let sum = values.map(Number).reduce((total, num) => total + num, 0);

            let result = sum / length
            $('#score_' + dataIndex).val(result.toFixed(2));
            $('.add-load-prorate-' + dataIndex).hide();
        } else {
            $('.add-load-prorate-' + dataIndex).hide();
        }

        // var grantee_grant_id = $(el).data('grantee_grant_id');
        // var id               = $(el).data('id');
        // var index            = $(el).data('index');
        // if (confirm("Are you sure?")){
        //     $('.add-load-prorate-'+index).show();
        //     $.ajax({
        //         type: 'POST',
        //         url: '<?php echo site_url('admin/set_interview/prorate_interview') ?>',
        //         data: {
        //             'grantee_grant_id': grantee_grant_id,
        //             'id': id,
        //             'index': index
        //         },
        //         dataType: 'JSON',
        //         success: function(r) {
        //             $('#score_'+index).val(r);
        //             $('.add-load-prorate-'+index).hide();
        //         }
        //     });
        // }
    }

    function show_preview(element, type, upload_type) {
        const file = element.files[0];
        // const filetype = file.name.split('.').pop();
        // const allowed_extensions = ['jpg', 'jpeg', 'png', 'pdf', 'docx', 'doc'];

        // const is_valid_extension = allowed_extensions.some(function(extension) {
        //     return filetype.toLowerCase().endsWith(extension);
        // });

        // if (is_valid_extension > 0) {

        // } else {
        //     let current_src = $('#preview_image_' + type).attr('src');
        //     $('#preview_image_' + type).attr('src', current_src);
        // }
        $('#btn-save-note-withdraw').html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop('disabled', true);
        let formData = new FormData();
        formData.append(upload_type, file);
        formData.append('type', upload_type);

        $.ajax({
            url: SITE_URL + 'admin/grantee/save_file',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function(response) {
                if (response.status) {
                    render_data_upload_attach(response, upload_type);
                    // let file_url = SITE_URL + response.filepath;
                    // $(".uploaded_attachment").attr('href', file_url).removeClass('hide').html('<b> <i class="fa fa-paperclip"></i> ' + response.filename) + '</b>';
                    // $("input[name='" + upload_type + "']").val(response.filepath);
                } else {
                    $(".uploaded_attachment").addClass('hide');
                    alert('Failed to upload your file, please try again');
                }

                $('#btn-save-note-withdraw').html('Save').prop('disabled', false);
            },
            error: function(xhr, status, error) {
                $('#btn-save-note-withdraw').html('Save').prop('disabled', false);
                console.error(error);
            }
        });
    }

    $(document).on('change', '.single-checkbox', function() {
        $(this).closest('div').find('.single-checkbox').not(this).each(function() {
            $(this).prop('checked', false);
        });
    });

    $(document).on('click', "#submit-score", function(e) {
        e.preventDefault();

        var is_valid = check_required_fields();
        if (!is_valid) {
                var first_required_field = $("form :input[required]").filter(function() {
                    return !this.value;
                }).first();
                first_required_field.focus();
                return;
            }
        Swal.fire({
            title: "Are you sure you want to submit this assessment?",
            text: "Once submitted, data cannot be changed.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, submit",
            customClass: 'swal-interview'
        }).then((result) => {
            if (result.isConfirmed) {
                $("form").submit();
            }
        });
    });

    $('.single-checkbox').change(function() {
        $(this).closest('div').find('.single-checkbox').not(this).each(function() {
            $(this).prop('checked', false);
        });
    });

    function check_required_fields() {
        var is_valid = true;
        $("form input[required]").each(function() {
            
            if ($(this).val() == '') {
                console.log($(this));
                is_valid = false;
                $(this).closest('div').find('small').removeClass('hide');
                return false;
            } else {
                $(this).closest('div').find('small').addClass('hide');
            }
        });
        
        $("form textarea[required]").each(function() {
            let editor = tinymce.get($(this).attr('id'));
            let content = editor ? editor.getContent() : $(this).val(); 

            if (!content.trim()) {
                is_valid = false;
                $(this).closest('div').find('small').removeClass('hide');
            } else {
                $(this).closest('div').find('small').addClass('hide'); 
            }
        });

        let checkbox_list = $(".checkbox-list");
        if (checkbox_list.length > 0) {
            checkbox_list.each(function() {
                let current_checkbox = $(this);
                var current_checkbox_invalid = true;
                if (current_checkbox.hasClass('required')) {
                    let chechboxes = current_checkbox.find('input[type="checkbox"]');
                    chechboxes.each(function() {
                        if ($(this).is(':checked') && current_checkbox_invalid == true) {
                           current_checkbox_invalid = false;
                        }
                    });
                } else {
                    current_checkbox_invalid = false;
                }

                if (current_checkbox_invalid == true) {
                    $(this).find('small').removeClass('hide');
                    is_valid = false;
                }

            });
        }

        if (is_valid == false) {
            Swal.fire({
                title: "Please complete the form.",
                icon: "error",
                customClass: 'swal-custom'
            });
        }

        return is_valid;
    }

    $('.lock_interview_check').change(function() {
        var isChacked = 0;
        var id = $(this).data('id');
        if($(this).is(':checked')) {
            isChacked = 1;
        } else {
            isChacked = 0;
        }
        Swal.fire({
            title: 'Loading...',
            text: 'Please wait while we process your request.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,  // Menghilangkan tombol "OK"
            didOpen: () => {
                Swal.showLoading();  // Memunculkan loading spinner
        }
        });
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/set_interview/set_lock_interview') ?>',
            dataType: 'JSON',
            data:{
                lock_interview: isChacked,
                id: id
            },
            success: function(r) {
                location.reload();
            }
        });
    });

    function show_hide_transportation(obj, section, index){
        if($(obj).val() == 'No' || $(obj).val() == ''){
            $('.section-transportation-'+section+'-'+index).addClass('hide');
        }else{
            $('.section-transportation-'+section+'-'+index).removeClass('hide');
        }

        if($(obj).val() == 'Reimbursement'){
            $('#label_eticket_'+section+'_'+index).html('Receipt')
        }else{
            $('#label_eticket_'+section+'_'+index).html('E-Ticket')
        }

    }

    function show_hide_accomodation(obj, section, index){
        if($(obj).val() == 'No' || $(obj).val() == ''){
            $('.section-accomodation-'+section+'-'+index).addClass('hide');
        }else{
            $('.section-accomodation-'+section+'-'+index).removeClass('hide');
        }

        if($(obj).val() == 'Reimbursement'){
            $('#label_voucher_hotel_'+section+'_'+index).html('Receipt')
        }else{
            $('#label_voucher_hotel_'+section+'_'+index).html('Hotel Voucher')
        }

    }


    $('.enable_biosketch').change(function() {
        var isChacked = 0;
        var id = $(this).data('id');
        if($(this).is(':checked')) {
            isChacked = 1;
        } else {
            isChacked = 0;
        }
        Swal.fire({
            title: 'Loading...',
            text: 'Please wait while we process your request.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,  // Menghilangkan tombol "OK"
            didOpen: () => {
                Swal.showLoading();  // Memunculkan loading spinner
        }
        });
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/set_interview/enable_biosketch') ?>',
            dataType: 'JSON',
            data:{
                enable_biosketch: isChacked,
                id: id
            },
            success: function(r) {
                location.reload();
            }
        });
    });
</script>