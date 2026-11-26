<script>
    function submitFilter(e, form) {
        if (e.keyCode == 13) {
            $('#' + form).submit();
            return false;
        }
    }

    $('#is_unlimited_grant_cost').change(function() {
        if (this.checked) {
            $("input[name='grant_cost']").val('0').attr('readonly', true);
        } else {
            val = $("input[name='grant_cost']").data('value');
            $("input[name='grant_cost']").val(val).attr('readonly', false);
        }
    });
    $('#is_unlimited_grant_supporting').change(function() {
        if (this.checked) {
            $("input[name='grant_supporting']").val('0').attr('readonly', true);
        } else {
            val = $("input[name='grant_supporting']").data('value');
            $("input[name='grant_supporting']").val(val).attr('readonly', false);
        }
    });

    $('#is_unlimited_international_travel').change(function() {
        if (this.checked) {
            $("input[name='international_travel']").val('0').attr('readonly', true);
        } else {
            val = $("input[name='international_travel']").data('value');
            $("input[name='international_travel']").val(val).attr('readonly', false);
        }
    });

    $("#btn-memo").click(function(){
        var fd = new FormData();
        var files = $('#memo_budget_revision')[0].files;
        var period_id = $('#period_id').val();


        // Check file selected or not
        if(files.length > 0 ){
        fd.append(period_id,files[0]);
            $.ajax({
                url: '<?php echo site_url('admin/user_grantee_grant/memo_budget_revision') ?>',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    location.reload();
                },
            });
        }else{
        alert("Please select a file.");
        }
    })

    $("#form_memo_budget").on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        $("#btn-memo-budget").html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop('disabled', true); 
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            enctype: 'multipart/form-data',
            processData: false,
            dataType: 'JSON',
            success: function(response) {
                $("#no-memo").addClass('hide');

                //add uploaded file into table memo budget
                var html = '<tr>' +
                            '<td><a target="_blank" href="'+ response.fileurl +'">' + response.filename + '</a></td>' +
                            '<td>' + response.is_active + '</td>' +
                            '<td>' + response.uploaded_date + '</td>' +
                            '<td><button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#mdl_memo_period" data-memo_id="' + response.success +'" data-memo_status="' + response.is_active + '">Edit</button> <button type="button" class="btn btn-danger btn-xs" onclick="delete_memo_period(this, ' + response.success +')" data-memo_id="' + response.success +'" >Delete</button></td>' +
                            '</tr>';
                $("#list_memo").append(html);
                
                //close modal
                $("#mdl_memo_budget_create").modal('hide');

                //clear all input of modal
                $('#memo_budget').val('').change();

                //set select is active = yes
                $('#is_active').val(1).change();

                $("#btn-memo-budget").html('Save').prop('disabled', false);
                show_toast_message(response.message || 'Successfully added', 'success');
            },
            error: function(response) {
                
            }
        });
    });

    $("#form").on('submit', function(e) { 
        var grant_cost           = $("#grant_cost").val();
        var international_travel = $("#international_travel").val();
        var settling_allowance   = $("#settling_allowance").val();
        var technology_allowance = $("#technology_allowance").val();
        var travel_allowance     = $("#travel_allowance").val();

        var is_unlimited_grant_cost = $("#is_unlimited_grant_cost").is(":checked");
        var is_unlimited_international_travel = $("#is_unlimited_international_travel").is(":checked");
        if(settling_allowance == ''){
            settling_allowance = 0
        }
        if(technology_allowance == ''){
            technology_allowance = 0
        }
        if(travel_allowance == ''){
            travel_allowance = 0
        }


        var allowance_grant_cost = parseInt(settling_allowance) + parseInt(technology_allowance);
        var invalid_cost = true;
        var invalid_travel = true;
        var message = "";

        if(is_unlimited_grant_cost == true || (grant_cost >= allowance_grant_cost)) {
            invalid_cost = false;
        }


        if(is_unlimited_grant_cost == true || (parseInt(grant_cost) >= parseInt(travel_allowance))) {
            invalid_travel = false;
        }

        if(invalid_cost || invalid_travel){
            if(invalid_cost){
                message = "Settling in Allowance & Technology Allowance cannot be more than the Grant Cost";
            }else{
                message = 'Travel Allowance cannot be more than the Grant Cost';
            }
            alert(message)
            e.preventDefault()
        }
    });

    function delete_memo_period(el, memo_id){
        if (confirm("Are you sure want to delete this ?")){
            $.ajax({
                type: 'GET',
                url: '<?php echo site_url('admin/user_grantee_grant/delete_memo_period/') ?>'+ memo_id,
                dataType: 'JSON',
                async: false,
                success: function(response) {
                    if(response.success){
                        $(el).closest('tr').remove();
                        show_toast_message(response.message || 'Successfully deleted', 'success');
                    }
                }
            });
        }
    }
    
    $('#mdl_memo_period').on('show.bs.modal', function(event) {
        $.fn.modal.Constructor.prototype.enforceFocus = function() {

            var button = $(event.relatedTarget);
            var memoID = button.data('memo_id');
            var memoStatus = button.data('memo_status');
            
            if (typeof currentMemoGrants !== 'undefined') {
                var data = currentMemoGrants[memoID];
                var baseUrl = window.location.origin;
                $('#memo_id').val(memoID);
                if (data) {
                    memoStatus = data.is_active;
                }
                $('#edit_memo_is_active').val(memoStatus);
            }
        };
    });

    $("#third_party_payment_add_record, #third_party_payment_edit_record").change(function() {
        var action = $(this).data('action');
        var sub_category = 'select[name="'+action+'[items][0][sub_category]"]';
        var payment_item = 'select[name="'+action+'[items][0][item]"]';
        var category = 'select[name="'+action+'[category_id]"]';
        if(this.value == 1){
            $(".category_payment").addClass("hide")
            $(category).val('');
            $(sub_category).empty();
            $(sub_category).append('<option value="">-- Select Sub Category --</option>');
            get_sub_category('Third Party',sub_category,payment_item,action);
        }else{
            $(".category_payment").removeClass("hide")
            $(sub_category).empty();
            $(sub_category).append('<option value="">-- Select Sub Category --</option>');
            get_sub_category('',sub_category,payment_item,action);
        }
    });

    $('#select_category_add, #select_category_edit').on('change', function() {
        var action = $(this).data('action');
        var sub_category = 'select[name="'+action+'[items][0][sub_category]"]';
        var payment_item = 'select[name="'+action+'[items][0][item]"]';

        $(sub_category).empty();
        $(sub_category).append('<option value="">-- Select Sub Category --</option>');
        get_sub_category($(this).val(),sub_category,payment_item,action);
    });

    function get_sub_category(category_type,select_sub_category,payment_item,param) {
        if(param == 'add_record'){
            $('#wrap-request-record0').find('.request-item-record0').each(function(){
                if($(this).attr('id')!='request-item-record-0'){
                    $(this).remove();
                }
                
                $(payment_item).empty();
                $(payment_item).append('<option value="">-- Select Item --</option>');
            });
        }else if(param == 'edit_record'){
            $('#wrap-request-record-edit0').find('.request-item-record-edit').each(function(){
                if($(this).attr('id')!='request-item-record-edit-0'){
                    $(this).remove();
                }
                
                $(payment_item).empty();
                $(payment_item).append('<option value="">-- Select Item --</option>');
                $('input[name="edit_record[items][0][nominal]"]').val('');
                $('input[name="edit_record[items][0][nominal_idr]"]').val('');
            });
        }
        

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
            }
        });
    }

    $("#end_date").on("change", function() {
        var selectedDate = new Date($(this).val());
        selectedDate.setMonth(selectedDate.getMonth() + 18); // Tambah 18 bulan
        
        // var formattedDate = selectedDate.getDate() + " " + selectedDate.toLocaleString('default', { month: 'short' }) + " " + selectedDate.getFullYear();
        var formattedDate = selectedDate.getFullYear();
        
        $("#departure_date").val(formattedDate).trigger('change');
    });

    // $("#fiscal_year").change(function () {
    //     departureDate = (parseInt(this.value) + 2)
    //     $("#departure_date").val(departureDate).trigger('change');
    // })

    $(document).ready(function() {
        $(".datetime").datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            autoclose: true,
        });

        const departureYear = $("#departure_date").val();
        if(departureYear == ''){
            $("#fiscal_year").trigger('change');
        }

        $("#sortable tbody").sortable({
            cursor: "move",
            placeholder: "sortable-placeholder",
            helper: function(e, tr) {
                let $originals = tr.children();
                let $helper = tr.clone();
                $helper.children().each(function(index) {
                    $(this).width($originals.eq(index).width());
                });
                return $helper;
            },
            update: function(event, ui) {
                let sorted_ids = [];
                $("#sortable tbody").find('tr').each(function(index) {
                    let row = $(this);
                    let row_number = index + 1;
                    row.find('td:first').text(row_number); 
                    row.data('sort', row_number); 
                    let current_id = row.data('id');
                    let sort = row_number;
                    sorted_ids.push({ id: current_id, sort: sort });
                });
                
                $.ajax({
                    url: "<?php echo site_url('admin/user_grantee_grant/sort_interview_question'); ?>",
                    type: "POST",
                    data: {
                        rows: sorted_ids
                    },
                    success: function(response) {},
                    error: function(xhr, status, error) {}
                });
            }
        }).disableSelection();

        $(document).on('click', '.add-interview-question', function(){
            $("input[type!='radio']:not([name='grant_id']):not([name='period_id'])").each(function() {
                $(this).val('');
            });
            $('input[name="status"]').prop("checked", true).val(1);
            $('input[name="able_to_comment"]').prop("checked", true).val(1);
            $(".initial_scores").html('');
            let editor = tinymce.get('interview-question');
            if (editor) {
                editor.setContent("");
            } 
        });

        $(document).on('click', '.edit-interview-question', function(e){
            e.preventDefault();
            let element = $(this);
            $('input[name="id"]').val(element.data('id'));
            let editor = tinymce.get('interview-question');
            if (editor) {
                let questionContent = JSON.parse(element.data('question'));
                editor.setContent(questionContent);
            } 
            $('input[name="weighting_score"]').val(element.data('weighting_score'));
            $('input[name="max_score"]').val(element.data('max_score'));
            $('input[name="min_score"]').val(element.data('min_score'));
            if (element.data('status') == 1) {
                $('input[name="status"]').val(element.data('status')).prop('checked', true);
            } else {
                $('input[name="status"]').val(element.data('status')).prop('checked', false);
            }

            if (element.data('able_to_comment') == 1) {
                $('input[name="able_to_comment"]').val(element.data('able_to_comment')).prop('checked', true);
            } else {
                $('input[name="able_to_comment"]').val(element.data('able_to_comment')).prop('checked', false);
            }

            let scoring_type = element.data('scoring_type');

            if (scoring_type == 0) {
                $('input[name="scoring_type"][value="0"]').prop('checked', true).trigger('change');
            } else if (scoring_type == 1) {
                $('input[name="scoring_type"][value="1"]').prop('checked', true).trigger('change');
            }


            $(".score-rating").html(''); 
            $(this).closest('tr').find('li.rate_score').each(function() {
                let rate = $(this).data('initial_rate');
                let score = $(this).data('initial_score');

                let new_element = '<div class="rows">' +
                    '<div class="col-md-6">' +
                    '<div class="form-group">' +
                    '<label>Grade</label>' +
                    '<input type="text" class="form-control" name="rate[]" required value="' + rate + '">' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-5">' +
                    '<div class="form-group">' +
                    '<label>Score</label>' +
                    '<input type="number" class="form-control" name="score[]" required value="' + score + '">' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-1 pl-0">' +
                    '<div class="form-group">' +
                    '<label>&nbsp;</label>' +
                    '<a class="btn btn-danger remove-grade-score"><i class="fa fa-times-circle"></i></a>' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                $(".score-rating").append(new_element);
            });
        });

        $(document).on('click', 'input[name="status"]', function() {
            if ($(this).is(':checked')) {
                $(this).val('1');
            } else {
                $(this).val('');
            }
        });

        $(document).on('click', 'input[name="able_to_comment"]', function() {
            if ($(this).is(':checked')) {
                $(this).val('1');
            } else {
                $(this).val('');
            }
        });

        $(document).on('click', '.add-review-question', function(){
            var section = $(this).data('section');
            $(".initial_scores").html('');
            $(".add-grade-score").click();
            $("input:not([type='radio']):input:not([name='grant_id']):not([name='period_id'])").val('');
            $('input[name="status"]').prop("checked", true).val(1);
            let editor = tinymce.get('review-question');
            if (editor) {
                editor.setContent("");
            } 

            if(section == 'eligibility'){
                $('#scoring_type_review').val(1);
                $("#grade_score_section").addClass('hide');
                $("#grade_score_section")
                    .find(':input')
                    .prop('required', false);

            } else {
                $('#scoring_type_review').val(0);
                $("#grade_score_section").removeClass('hide');
                $("#grade_score_section")
                    .find(':input')
                    .prop('required', true);
            }
        });

        $(document).on('click', '.edit-review-question', function(e){
            e.preventDefault();
            
            let element = $(this);
            $('input[name="id"]').val(element.data('id'));
            
            tinymce.activeEditor.setContent(element.data('question'));
            let editor = tinymce.get('review-question');
            if (editor) {
                let questionContent = JSON.parse(element.data('question'));
                editor.setContent(questionContent);
            } 
            
            if (element.data('status') == 1) {
                $('input[name="status"]').val(element.data('status')).prop('checked', true);
            } else {
                $('input[name="status"]').val(element.data('status')).prop('checked', false);
            }

            if (element.data('section') == 'eligibility') {
                $('#scoring_type_review').val(1);
                $("#grade_score_section").addClass('hide');
                $("#grade_score_section")
                    .find(':input')
                    .prop('required', false);

            } else {
                $('#scoring_type_review').val(0);
                $("#grade_score_section").removeClass('hide');
                $("#grade_score_section")
                    .find(':input')
                    .prop('required', true);
            }

            $(".initial_scores").html('');
            $(this).closest('tr').find('li').each(function() {
                let grade = $(this).data('initial_grade');
                let score = $(this).data('initial_score');

                let new_element = '<div class="rows">' +
                    '<div class="col-md-6">' +
                    '<div class="form-group">' +
                    '<label>Grade</label>' +
                    '<input type="text" class="form-control" name="grade[]" required value="' + grade + '">' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-5">' +
                    '<div class="form-group">' +
                    '<label>Score</label>' +
                    '<input type="number" class="form-control" name="score[]" required value="' + score + '">' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-1 pl-0">' +
                    '<div class="form-group">' +
                    '<label>&nbsp;</label>' +
                    '<a class="btn btn-danger remove-grade-score"><i class="fa fa-times-circle"></i></a>' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                $(".initial_scores").append(new_element);
            });
            
        });

        $(document).on('click', '.add-grade-score', function(e){
            e.preventDefault();
            let list_score = $(document).find('.remove-grade-score');
            let is_first = list_score.length > 0 ? false : true;
            let is_disabled = is_first ? 'disabled' : '';

            let new_element = '<div class="rows">' +
                                '<div class="col-md-6">' +
                                    '<div class="form-group">' +
                                        '<label>Grade</label>' +
                                        '<input type="text" class="form-control" name="grade[]" required>' +
                                    '</div>' +
                                '</div>' +
                                '<div class="col-md-5">' +
                                    '<div class="form-group">' +
                                        '<label>Score</label>' +
                                        '<input type="number" class="form-control" name="score[]" required>' +
                                    '</div>' +
                                '</div>' +
                                '<div class="col-md-1 pl-0">' +
                                    '<div class="form-group">' +
                                        '<label>&nbsp;</label>' +
                                        '<a class="btn btn-danger remove-grade-score" ' + is_disabled + '><i class="fa fa-times-circle"></i></a>' +
                                    '</div>' +
                                '</div>' +
                            '</div>';
            
            $(".initial_scores").append(new_element);
        });

        $(document).on('click', '.remove-grade-score', function(e){
            e.preventDefault();
            $(this).closest('.rows').remove();
        });

        $("#review_table tbody").sortable({
            cursor: "move",
            placeholder: "sortable-placeholder",
            helper: function(e, tr) {
                let $originals = tr.children();
                let $helper = tr.clone();
                $helper.children().each(function(index) {
                    $(this).width($originals.eq(index).width());
                });
                return $helper;
            },
            update: function(event, ui) {
                let sorted_ids = [];
                $("#review_table tbody").find('tr').each(function(index) {
                    let row = $(this);
                    let row_number = index + 1;
                    row.find('td:first').text(row_number); 
                    row.data('sort', row_number); 
                    let current_id = row.data('id');
                    let sort = row_number;
                    sorted_ids.push({ id: current_id, sort: sort });
                });
                
                $.ajax({
                    url: "<?php echo site_url('admin/user_grantee_grant/sort_review_question'); ?>",
                    type: "POST",
                    data: {
                        rows: sorted_ids
                    },
                    success: function(response) {},
                    error: function(xhr, status, error) {}
                });
            }
        }).disableSelection();

        $(document).on('focusin', function(e) {
            if ($(e.target).closest(".tox-dialog").length) {
                e.stopImmediatePropagation();
            }
        });

        $(document).on('click', '.add-evaluation-question', function(){
            $("input:not([name='grant_id']):not([name='period_id'])").val('');
            $('input[name="status"]').prop("checked", true).val(1);
            $(".initial_scores").html('');
            let editor = tinymce.get('evaluation-question');
            if (editor) {
                editor.setContent("");
            } 
        });

        $(document).on('click', '.edit-evaluation-question', function(e){
            e.preventDefault();
            let element = $(this);
            $('input[name="id"]').val(element.data('id'));
            let editor = tinymce.get('evaluation-question');
            if (editor) {
                let questionContent = JSON.parse(element.data('question'));
                editor.setContent(questionContent);
            } 
            if (element.data('status') == 1) {
                $('input[name="status"]').val(element.data('status')).prop('checked', true);
            } else {
                $('input[name="status"]').val(element.data('status')).prop('checked', false);
            }
            if (element.data('is_required') == 1) {
                $('input[name="is_required"]').val(element.data('is_required')).prop('checked', true);
            } else {
                $('input[name="is_required"]').val(element.data('is_required')).prop('checked', false);
            }

            let type = element.data('type');

            if (type == 'separator') {
                $(".is_required").addClass('hide');
            } else {
                $(".is_required").removeClass('hide');
            }

            if (type == '') {
                type = 'textarea';
            }

            $('#question_type').val(type).change();

            let options = element.data('options');
 
            if (typeof options === 'string') {
                options = JSON.parse(options);
                options = JSON.parse(options);
            }
            
            $(".list-options").empty();

            if (typeof options == "object") {
                options.forEach(function(option) {
                let new_element = '<div class="row mb-2">' +
                                    '<div class="col-md-11">' +
                                        '<input type="text" name="options[]" value="' + option + '" id="select_options_input" class="form-control" placeholder="Enter new option">' +
                                    '</div>' +
                                    '<div class="col-md-1 p-0">' +
                                        '<button class="btn btn-danger remove-option"><i class="fa fa-times"></i></button>' +
                                    '</div>' +
                                '</div>';
                    $(".list-options").append(new_element);
                });
            }
            
            
            if (element.data('multiple') == 1) {
                $('input[name="multiple"]').val(element.data('multiple')).prop('checked', true);
            } else {
                $('input[name="multiple"]').val(element.data('multiple')).prop('checked', false);
            }
        });

        $(document).on('click', 'input[name="status"]', function() {
            if ($(this).is(':checked')) {
                $(this).val('1');
            } else {
                $(this).val('0');
            }
        });

        $(document).on('click', 'input[name="is_required"]', function() {
            if ($(this).is(':checked')) {
                $(this).val('1');
            } else {
                $(this).val('0');
            }
        });

        $(document).on('click', 'input[name="multiple"]', function() {
            if ($(this).is(':checked')) {
                $(this).val('1');
            } else {
                $(this).val('0');
            }
        });

        $("#evaluation_table tbody").sortable({
            cursor: "move",
            placeholder: "sortable-placeholder",
            helper: function(e, tr) {
                let $originals = tr.children();
                let $helper = tr.clone();
                $helper.children().each(function(index) {
                    $(this).width($originals.eq(index).width());
                });
                return $helper;
            },
            update: function(event, ui) {
                let sorted_ids = [];
                $("#evaluation_table tbody").find('tr').each(function(index) {
                    let row = $(this);
                    let row_number = index + 1;
                    row.find('td:first').text(row_number); 
                    row.data('sort', row_number); 
                    let current_id = row.data('id');
                    let sort = row_number;
                    sorted_ids.push({ id: current_id, sort: sort });
                });

                $.ajax({
                    url: "<?php echo site_url('admin/user_grantee_grant/sort_evaluation_question'); ?>",
                    type: "POST",
                    data: {
                        rows: sorted_ids
                    },
                    success: function(response) {},
                    error: function(xhr, status, error) {}
                });
            }
        }).disableSelection();
    });

    // manage question evaluation properties
    $(document).ready(function() {
        const evaluation_templates = $(".evaluation_templates");
        evaluation_templates.on('click', function(){
            evaluation_templates.removeClass('active');

            $(this).addClass('active');

            let element_data = $(this).data('value');
            
            $('input[name="period_evaluation_template"]').val(element_data);
        });

        const question_type = $('#question_type');
        const select_option_attribute = $('#options');

        question_type.change(function() {
            const selected_type = $(this).val();
            if (selected_type == 'separator') {
                $(".is_required").addClass('hide');
            } else {
                $(".is_required").removeClass('hide');
            }
            switch(selected_type) {
                case 'checkbox' : 
                    select_option_attribute.removeClass('hide');
                    break;
                default :
                    select_option_attribute.addClass('hide');
                    break;
            }

        });

        $(document).on('click', '#add_select_option_button', function(e){
            e.preventDefault();
            let list_score = $(document).find('.remove-option');
            let is_first = list_score.length > 0 ? false : true;
            let is_disabled = is_first ? 'disabled' : '';

            let new_element = '<div class="row mb-2">' +
                                    '<div class="col-md-11">' +
                                        '<input type="text" name="options[]" id="select_options_input" class="form-control" placeholder="Enter new option">' +
                                    '</div>' +
                                    '<div class="col-md-1 p-0">' +
                                        '<button class="btn btn-danger remove-option" ' + is_disabled + '><i class="fa fa-times"></i></button>' +
                                    '</div>' +
                                '</div>';
            $(".list-options").append(new_element);
        });

        $(document).on('click', '.remove-option', function(e){
            e.preventDefault();
            $(this).closest('.row').remove();
        });

        tinymce.init({
            selector: '.editor_email',
            plugins: 'link textcolor advlist table lists', // Pastikan plugin textcolor dan advlist digunakan
            toolbar: 'undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | link | numlist bullist | table | fontsizeselect',
            fontsize_formats: '8pt 10pt 12pt 14pt 16pt 18pt 24pt 36pt 48pt 72pt', // Definisikan ukuran font
            extended_valid_elements: 'p[style|class],span[style|class],div[style|class],u,table[border|cellspacing|cellpadding|width|style|class]',
            formats: {
                underline: { inline: 'u' },
                alignleft: { selector: 'p,div,h1,h2,h3,h4,h5,h6,td,th', styles: { textAlign: 'left' } },
                aligncenter: { selector: 'p,div,h1,h2,h3,h4,h5,h6,td,th', styles: { textAlign: 'center' } },
                alignright: { selector: 'p,div,h1,h2,h3,h4,h5,h6,td,th', styles: { textAlign: 'right' } },
                alignjustify: { selector: 'p,div,h1,h2,h3,h4,h5,h6,td,th', styles: { textAlign: 'justify' } }
            },
            content_style: `
                .text-center { text-align: center; }
            `,
            contenteditable: true,
            spellchecker: false,
            inline_styles: true,
            forced_root_block: false,
            forced_root_block_attrs: {},
            force_br_newlines: true,
            force_p_newlines: false,
            convert_newlines_to_brs: true
        });



        $(".scoring_type").on('change', function(e){
            let val = $(this).val();
            if (val == 0) {
                $("#weighting_score_section").removeClass('hide');
                $("#rating_score_section").addClass('hide');
            } else {
                $("#weighting_score_section").addClass('hide');
                $("#rating_score_section").removeClass('hide');
            }
        });

        $(".scoring_type_review").on('change', function(e){
            let val = $(this).val();
            if (val == 0) {
                $("#grade_score_section").removeClass('hide');
                $("#grade_score_section")
                    .find(':input')
                    .prop('required', true);
            } else {
                $("#grade_score_section").addClass('hide');
                $("#grade_score_section")
                    .find(':input')
                    .prop('required', false);
            }
        });

        $(document).on('click', '.add-score-rating', function(e){
            e.preventDefault();
            let list_score = $(document).find('.remove-grade-score');
            let is_first = list_score.length > 0 ? false : true;
            let is_disabled = is_first ? 'disabled' : '';

            let new_element = '<div class="rows">' +
                                '<div class="col-md-6">' +
                                    '<div class="form-group">' +
                                        '<label>Rate</label>' +
                                        '<input type="text" class="form-control" name="rate[]" required>' +
                                    '</div>' +
                                '</div>' +
                                '<div class="col-md-5">' +
                                    '<div class="form-group">' +
                                        '<label>Score</label>' +
                                        '<input type="number" class="form-control" name="score[]" required>' +
                                    '</div>' +
                                '</div>' +
                                '<div class="col-md-1 pl-0">' +
                                    '<div class="form-group">' +
                                        '<label>&nbsp;</label>' +
                                        '<a class="btn btn-danger remove-grade-score" ' + is_disabled + '><i class="fa fa-times-circle"></i></a>' +
                                    '</div>' +
                                '</div>' +
                            '</div>';
            
            $(".score-rating").append(new_element);
        });

        // payment record grantee

        $(document).on('click', '.add-more-grantee', function(e){
            e.preventDefault();

            let row_number = $(document).find('.row-grantee');
            row_number = Number(row_number.length);
            
            var period_id = $('#period_id').val();
            var grant_id = $('#grant_id').val();
            var status = $('#select-status').val();
            var category = $('.payment_category').val();
            let selected_opt_grantee = $('#select-grantee').find('option:selected');
            var grant_id = grant_id;
            
            var grantee_name = selected_opt_grantee.data('grantee_name');
            var grantee_grant_id = selected_opt_grantee.data('grantee_grant_id');
            var user_grantee_id = $('#select-grantee').val();
            
            if(user_grantee_id == '' || user_grantee_id == null){
                alert('Please Select Grantee.')
                return false
            }
            if(category == '' || category == null){
                alert('Please Select Category.')
                return false
            }

            // var getOption = function () {
            //     var tmp = null;
            //     $.ajax({
            //         'async': false,
            //         type: 'POST',
            //         url: '<?php echo site_url('admin/payment_item/get_data_grantee') ?>',
            //         data: {
            //             'period_id': period_id,
            //             'grant_id':grant_id,
            //             'status': status

            //         },
            //         dataType: 'html',
            //         success: function(data) {
            //             tmp = data;
            //         }
            //     });
            //     return tmp;
            // }();

            var getOptionBankInfo = function () {
                var tmp = null;
                $.ajax({
                    'async': false,
                    type: 'POST',
                    url: '<?php echo site_url('admin/grantee/get_bank_info/'); ?>' + user_grantee_id,
                    data: {
                        'period_id': period_id,
                        'grant_id':grant_id,
                        'status': status

                    },
                    dataType: 'html',
                    success: function(data) {
                        tmp = data;
                    }
                });
                return tmp;
            }();


            // var labelGrantee = row_number == 0 ? '<label>Grantee</label><br />' : '';
            // var labelBank = row_number == 0 ? '<label>Bank</label>' : '';
            // var labelIdr = row_number == 0 ? '<label>Nominal IDR</label>' : '';
            // var labelUSD = row_number == 0 ? '<label>Nominal USD</label>' : '';
            // var labelProof = row_number == 0 ? '<label>Proof of Expense</label>' : '';
            // var labelDeparture = row_number == 0 ? '<label>Departure Date</label>' : '';
            var labelGrantee = row_number == 0 ? '<th>Grantee</th>' : '';
            var labelBank = row_number == 0 ? '<th>Bank</th>' : '';
            var labelIdr = row_number == 0 ? '<th>Nominal IDR</th>' : '';
            var labelUSD = row_number == 0 ? '<th>Nominal USD</th>' : '';
            var labelProof = row_number == 0 ? '<th>Proof of Expense</th>' : '';
            var labelDeparture = ((row_number == 0) && (category == 'Grant Cost' || category == 'International Travel')) ? '<th>Start Date</th>' : '';
            if(row_number == 0){
                var headerRow = '<tr>' +
                                    labelGrantee + labelBank + labelIdr + labelUSD + labelDeparture + labelProof +
                                '</tr>';
                $('.table-list-grantee thead').html(headerRow);
            }

            let field_departure_date = '';
            if(category == 'Grant Cost' || category == 'International Travel'){
                field_departure_date = '<td><input style="background-color:#fff" type="text" class="form-control departure-date datepicker" readonly name="add_record[grantee]['+ row_number +'][departure_date]"></td>';
            }

            let html = '<tr class="row-grantee">' +
                                '<td>' +
                                    '<label class="my-2">'+ grantee_name +'</label>' +
                                    '<input type="hidden" name="add_record[grantee]['+ row_number +'][user_grantee_id]" value="'+ user_grantee_id +'">' +
                                '</td>' +
                                '<td>' +
                                    '<select class="form-control select2 grantee-bank-info" name="add_record[grantee]['+ row_number +'][grantee_bank_id]" id="grantee-bank-info' + row_number + '">' +
                                        '<option></option>' +
                                    '</select>' +
                                    '<input type="hidden" class="grantee_grant_id" name="add_record[grantee]['+ row_number +'][grantee_grant_id]" value="'+ grantee_grant_id +'">' +
                                '</td>' +
                                '<td><input type="text" class="form-control currency-idr" name="add_record[grantee]['+ row_number +'][nominal_idr]"></td>' +
                                '<td><input type="text" class="form-control currency-idr" name="add_record[grantee]['+ row_number +'][nominal]"></td>' +
                                field_departure_date +
                                '<td><input type="file" class="form-control" name="proof_of_payment_'+ row_number +'"></td>' +
                                '<td><button type="button" class="btn btn-danger btn-sm remove-grantee"><i class="fa fa-times-circle"></i></button></td>' +
                        '</tr>';

            // let html = '<div class="row row-grantee">' +
            //                 '<div class="col-md-2">' +
            //                     '<div class="form-group">' +
            //                         labelGrantee +
            //                         // '<select class="form-control select2 select-grantee" name="add_record[grantee]['+ row_number +'][user_grantee_id]" required>' +
            //                         //     '<option value="">Select Grantee</option>' +
            //                         // '</select>' +
            //                         '<label class="my-3">'+ grantee_name +'</label>' +
            //                         '<input type="hidden" name="add_record[grantee]['+ row_number +'][user_grantee_id]" value="'+ user_grantee_id +'">' +
            //                     '</div>' +
            //                 '</div>' +
            //                 '<div class="col-md-2">' +
            //                     '<div class="form-group">' +
            //                         labelBank +
            //                         '<select class="form-control select2 grantee-bank-info" name="add_record[grantee]['+ row_number +'][grantee_bank_id]" id="grantee-bank-info' + row_number + '">' +
            //                             '<option></option>' +
            //                         '</select>' +
            //                         '<input type="hidden" class="grantee_grant_id" name="add_record[grantee]['+ row_number +'][grantee_grant_id]" value="'+ grantee_grant_id +'">' +
            //                     '</div>' +
            //                 '</div>' +
            //                 '<div class="col-lg-2">' +
            //                     '<div class="form-group">' +
            //                         labelIdr +
            //                         '<input type="text" class="form-control currency-idr ini" name="add_record[grantee]['+ row_number +'][nominal_idr]">' +
            //                     '</div>' +
            //                 '</div>' +
            //                 '<div class="col-lg-2">' +
            //                     '<div class="form-group">' +
            //                         labelUSD +
            //                         '<input type="text" class="form-control currency-idr" name="add_record[grantee]['+ row_number +'][nominal]">' +
            //                     '</div>' +
            //                 '</div>' +
            //                 '<div class="col-md-2">' +
            //                     '<div class="form-group">' +
            //                         '<input type="text" class="form-control departure-date datepicker" name="edit_record[grantee]['+ row_number +'][departure_date]">' +
            //                     '</div>' +
            //                 '</div>' +
            //                 '<div class="col-lg-2">' +
            //                     '<div class="form-group">' +
            //                         labelProof +
            //                         '<input type="file" name="proof_of_payment_'+ row_number +'" class="form-control" style="display: inline;" onchange="change_status_paid()">' +
            //                     '</div>' +
            //                 '</div>' +
            //                 '<div class="col-md-1">' +
            //                     '<button class="btn btn-danger remove-grantee"><i class="fa fa-times-circle"></i></button>' +
            //                 '</div>' +
            //             '</div>';
            
            $('.table-list-grantee tbody').append(html);
            $(".select2").select2();
            let newSelectBankInfo = $('.list-grantee .row-grantee:last .grantee-bank-info');
            newSelectBankInfo.empty().append("<option value=''>Select Bank Account</option>");
            if(getOptionBankInfo){
                getOptionBankInfo = JSON.parse(getOptionBankInfo);
                $.each(getOptionBankInfo, function(id, val) {
                    newSelectBankInfo.append('<option value="' + val.id + '">' + val.bank_name + ' - ' + val.account_number + ' - ' + val.currency +'</option>');
                });
            }
            $( ".datepicker" ).datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "dd M yy",
                yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
            });
            // $('#select-status').val('').trigger('change')
            // let newSelect = $('.list-grantee .row-grantee:last .select-grantee');
            // newSelect.empty().append("<option value=''>Select Grantee</option>");
            // if(getOption){
            //     getOption = JSON.parse(getOption);
            //     $.each(getOption, function(id, val) {
            //         newSelect.append('<option value="' + val.id + '" data-grantee_grant_id="' + val.grantee_grant_id+ '">' + val.first_name + ' ' + (val.middle_name ?? '') + val.last_name + '</option>');
            //     });
            // }
        });

        $(document).on('click', '.edit-add-more-grantee', function(e){
            e.preventDefault();
            let row_number = $(document).find('.row-grantee-edit');
                row_number = Number(row_number.length);
                
            var period_id = $('#period_id').val();
            var grant_id = $('#grant_id').val();
            var status = $('#select-status-edit').val();
            let selected_opt_grantee = $('#select-grantee-edit').find('option:selected');
            var grant_id = grant_id;
            var category = $('#category').val();
            
            var grantee_name = selected_opt_grantee.data('grantee_name');
            var grantee_grant_id = selected_opt_grantee.data('grantee_grant_id');
            var user_grantee_id = $('#select-grantee-edit').val();
            
            if(user_grantee_id == '' || user_grantee_id == null){
                alert('Please Select Grantee.')
                return false
            }

            var getOptionBankInfo = function () {
                var tmp = null;
                $.ajax({
                    'async': false,
                    type: 'POST',
                    url: '<?php echo site_url('admin/grantee/get_bank_info/'); ?>' + user_grantee_id,
                    data: {
                        'period_id': period_id,
                        'grant_id':grant_id,
                        'status': status

                    },
                    dataType: 'html',
                    success: function(data) {
                        tmp = data;
                    }
                });
                return tmp;
            }();


            // var getOption = function () {
            //     var tmp = null;
            //     $.ajax({
            //         'async': false,
            //         type: 'POST',
            //         url: '<?php echo site_url('admin/payment_item/get_data_grantee') ?>',
            //         data: {
            //             'period_id': period_id,
            //             'grant_id':grant_id,
            //             'status': status

            //         },
            //         dataType: 'html',
            //         success: function(data) {
            //             tmp = data;
            //         }
            //     });
            //     return tmp;
            // }();
            // let html = '<div class="row row-grantee-edit">' +
            //                 '<div class="col-md-2">' +
            //                     '<div class="form-group">' +
            //                         '<label class="my-3">'+ grantee_name +'</label>' +
            //                         '<input type="hidden" name="edit_record[grantee]['+ row_number +'][user_grantee_id]" value="'+ user_grantee_id +'">' +
            //                         // '<select class="form-control select2 select-grantee" name="edit_record[grantee]['+ row_number +'][user_grantee_id]" required>' +
            //                         //     '<option value="">Select Grantee</option>' +
            //                         //     <?php foreach($users_grantee as $grantee){ ?>
            //                         //         '<option value="<?php echo $grantee->id; ?>" data-grantee_grant_id="<?php echo $grantee->grantee_grant_id; ?>"><?php echo get_full_name($grantee); ?></option>' +
            //                         //      <?php } ?>
            //                         // '</select>' +
            //                     '</div>' +
            //                 '</div>' +
            //                 '<div class="col-md-2">' +
            //                     '<div class="form-group">' +
            //                         '<select class="form-control select2 grantee-bank-info" name="edit_record[grantee]['+ row_number +'][grantee_bank_id]" id="grantee-bank-info' + row_number + '">' +
            //                             '<option></option>' +
            //                         '</select>' +
            //                         '<input type="hidden" class="grantee_grant_id" name="edit_record[grantee]['+ row_number +'][grantee_grant_id]" value="'+ grantee_grant_id +'">' +
            //                     '</div>' +
            //                 '</div>' +
            //                 '<div class="col-md-2">' +
            //                     '<div class="form-group">' +
            //                         '<input type="text" class="form-control currency-idr" name="edit_record[grantee]['+ row_number +'][nominal_idr]">' +
            //                     '</div>' +
            //                 '</div>' +
            //                 '<div class="col-md-2">' +
            //                     '<div class="form-group">' +
            //                         '<input type="text" class="form-control currency-idr" name="edit_record[grantee]['+ row_number +'][nominal]">' +
            //                     '</div>' +
            //                 '</div>' +
            //                 '<div class="col-md-3">' +
            //                     '<div class="form-group">' +
            //                         '<input type="file" name="proof_of_payment_'+ row_number +'" class="form-control" style="display: inline;" onchange="change_status_paid()">' +
            //                     '</div>' +
            //                 '</div>' +
            //                 '<div class="col-md-1">' +
            //                     '<button class="btn btn-danger remove-grantee remove-grantee-edit' + row_number + '" data-is_edit="1"><i class="fa fa-times-circle"></i></button>' +
            //                 '</div>' +
            //             '</div>';


            let field_departure_date = '';
            if(category == 'Grant Cost' || category == 'International Travel'){
                field_departure_date = '<td><input style="background-color:#fff" type="text" class="form-control departure-date datepicker" readonly name="edit_record[grantee]['+ row_number +'][departure_date]"></td>';
            }

            let html = '<tr class="row-grantee-edit">' +
                                '<td>' +
                                    '<label class="my-3">'+ grantee_name +'</label>' +
                                    '<input type="hidden" name="edit_record[grantee]['+ row_number +'][user_grantee_id]" value="'+ user_grantee_id +'">' +
                                '</td>' +
                                '<td>' +
                                    '<select class="form-control select2 grantee-bank-info" name="edit_record[grantee]['+ row_number +'][grantee_bank_id]" id="grantee-bank-info' + row_number + '">' +
                                        '<option></option>' +
                                    '</select>' +
                                    '<input type="hidden" class="grantee_grant_id" name="edit_record[grantee]['+ row_number +'][grantee_grant_id]" value="'+ grantee_grant_id +'">' +
                                '</td>' +
                                '<td><input type="text" class="form-control currency-idr" name="edit_record[grantee]['+ row_number +'][nominal_idr]"></td>' +
                                '<td><input type="text" class="form-control currency-idr" name="edit_record[grantee]['+ row_number +'][nominal]"></td>' +
                                field_departure_date +
                                '<td><input type="file" name="proof_of_payment_'+ row_number +'" class="form-control" style="display: inline;" onchange="change_status_paid()"></td>' +
                                '<td><button class="btn btn-danger remove-grantee remove-grantee-edit' + row_number + '" data-is_edit="1"><i class="fa fa-times-circle"></i></button></td>' +
                        '</tr>';
            
            $('.table-list-grantee-edit tbody').append(html);
            $(".select2").select2();
            let newSelectBankInfo = $('.list-grantee-edit .row-grantee-edit:last .grantee-bank-info');
            newSelectBankInfo.empty().append("<option value=''>Select Bank Account</option>");
            if(getOptionBankInfo){
                getOptionBankInfo = JSON.parse(getOptionBankInfo);
                $.each(getOptionBankInfo, function(id, val) {
                    newSelectBankInfo.append('<option value="' + val.id + '">' + val.bank_name + ' - ' + val.account_number + ' - ' + val.currency + '</option>');
                });
            }
            $( ".datepicker" ).datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "dd M yy",
                yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
            });
            // let newSelect = $('.list-grantee .row-grantee:last .select-grantee');
            // newSelect.empty().append("<option value=''>Select Grantee</option>");
            // if(getOption){
            //     getOption = JSON.parse(getOption);
            //     $.each(getOption, function(id, val) {
            //         newSelect.append('<option value="' + val.id + '" data-grantee_grant_id="' + val.grantee_grant_id+ '">' + val.first_name + ' ' + (val.middle_name ?? '') + val.last_name + '</option>');
            //     });
            // }
        });

        $(document).on('click', '.remove-grantee', function(e) {
            e.preventDefault();
            var deleted = $("#delete_detail_payment_record_grantee").val();
            var deleted_payment = $("#delete_payment_record_grantee").val();
            if (confirm("Are you sure want to delete this ?")){
                var is_edit = $(this).data('is_edit');
                var classRow = is_edit ? '.row-grantee-edit' : '.row-grantee';
                $(this).closest(classRow).remove();
                var id = $(this).data('id');
                var payment_id = $(this).data('payment_id');
                if(id){
                    if (deleted == '') {
                        $("#delete_detail_payment_record_grantee").val(id);
                    } else {
                        var join_id = deleted + ',' + id;
                        var join_payment_id = deleted + ',' + id;
                        $("#delete_detail_payment_record_grantee").val(join_id);
                    }
                    
                    if (deleted_payment == '') {
                        $("#delete_payment_record_grantee").val(payment_id);
                    } else {
                        var join_payment_id = deleted + ',' + payment_id;
                        $("#delete_payment_record_grantee").val(join_payment_id);
                    }
                }

            }

        });

        $(document).on('change', '.select-grantee-input', function(e){
            e.preventDefault();
            let element = $(this);

            let selected_opt = $(this);
            let bank_id = $(this).data('bank');
            let data_id = selected_opt.data('grantee_grant_id');

            $(this).closest('.row-grantee').find('.grantee_grant_id').val(data_id);

            $.ajax({
                url : '<?php echo site_url('admin/grantee/get_bank_info/'); ?>' + $(this).val(),
                type : 'GET',
                dataType : 'JSON',
                success:function(response) {
                    let html = '<option value="">Select Bank Account</option>';
                        for(let i =0; i < response.length; i++) {
                            let selected = bank_id == response[i].id ? 'selected' : '';
                            html += '<option ' + selected + ' value="' + response[i].id + '">' + response[i].bank_name + ' - ' + response[i].account_number + '</option>';
                        }

                        element.closest('.row-grantee-edit').find('.grantee-bank-info').html(html);

                        // $('.grantee-bank-info').select2();
                }
            });
        });

        $('.payment_category').on('change', function() {
            var sub_category = 'select[name="add_record[sub_category]"]';
            var payment_item = 'select[name="add_record[payment_items]"]';

            $(sub_category).empty();
            $(sub_category).append('<option value="">-- Select Sub Category --</option>');
            // if($(this).val() != ''){
                get_sub_category($(this).val(),sub_category, payment_item, 'add_record');
            // }
        });

        $('.payment_category_edit').on('change', function() {
            var sub_category = 'select[name="edit_record[sub_category]"]';
            var payment_item = 'select[name="edit_record[items][0][item]"]';

            $(sub_category).empty();
            $(sub_category).append('<option value="">-- Select Sub Category --</option>');
            // if($(this).val() != ''){
                get_sub_category($(this).val(),sub_category, payment_item, 'edit_record');
            // }
        });

        $('.payment_sub_category').on('change', function() {
            var category_type = $('select[name="add_record[category]"]').val();
            var sub_category = $(this).val();
            var payment_item = 'select[name="add_record[payment_items]"]';
            
            $(payment_item).empty();
            $(payment_item).append('<option value="">-- Select Item --</option>');
            // if($(this).val() != ''){
                get_payment_item(category_type,sub_category,payment_item,'add_record');
            // }
        });

        $('.payment_sub_category_edit').on('change', function() {
            var category_type = $('select[name="edit_record[category]"]').val();
            var sub_category = $(this).val();
            var payment_item = 'select[name="edit_record[payment_items]"]';
            
            $(payment_item).empty();
            $(payment_item).append('<option value="">-- Select Item --</option>');
            // if($(this).val() != ''){
                get_payment_item(category_type,sub_category,payment_item,'edit_record');
            // }
        });

        $('#form_payment_grantee').on('submit', function (event) {
            let all_valid = true;

            $(this).find('[required]').each(function () {
                if (!$(this).val().trim()) {
                    all_valid = false;
                }
            });

            if (!all_valid) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Incomplete Form',
                    text: 'Please fill out all required fields!',
                    confirmButtonText: 'OK'
                });
            } else {
                $('#btn-submit-payment-grantee').prop('disabled', true);
            }
        });

        $('#mdl_add_record_grantee').on('shown.bs.modal', function () {
            $('.select2').select2({
                theme: 'bootstrap',
                dropdownParent: $('#mdl_add_record_grantee')
            });
            $('.modal-footer').removeClass('hide');
        });

        $('#mdl_edit_record_grantee').on('show.bs.modal', function(event) {
            $.fn.modal.Constructor.prototype.enforceFocus = function() {
                var button = $(event.relatedTarget);
                var recordId = button.data('record_id');
                var mode = button.data('mode');
                $("#delete_detail_payment_record_grantee").val('');
                $("#delete_payment_record_grantee").val('');

                if (typeof currentUserReviews !== 'undefined') {
                    var data = currentUserReviews[recordId];
                    var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                    var payment_date = new Date(data.payment_date);
                    $('#payment_id_record').val(data.id);
                    $('#payment_date_record').val((payment_date.getDate() < 10 ? '0' + payment_date.getDate() : payment_date.getDate()) + ' ' + monthNames[payment_date.getMonth()] + ' ' + payment_date.getFullYear()).attr('autocomplete', 'off');
                    $('#description_record').val(data.description);
                    $('#category').val(data.category);
                    $('#memo_budget_payment_grantee').val(data.user_grantee_grant_memo_id);
                    // Hide inactive memo options, but keep the currently assigned one visible & enabled so it POSTs
                    var selectMemoGrant = $('#memo_budget_payment_grantee');
                    selectMemoGrant.find('option.memo-budget-inactive').prop('hidden', true).prop('disabled', true).hide();
                    if (data.user_grantee_grant_memo_id) {
                        var currentMemoGrant = selectMemoGrant.find('option[value="' + data.user_grantee_grant_memo_id + '"]');
                        currentMemoGrant.prop('hidden', false).prop('disabled', true).show();
                    }
                    selectMemoGrant.val(data.user_grantee_grant_memo_id);
                    $('#bank_info_id').val(data.bank_info_id);
                    
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo site_url('admin/payment_item/get_sub_category') ?>',
                        data: {
                            'category_type': data.category
                        },
                        dataType: 'JSON',
                        success: function(r) {
                            $('#sub_category').empty();
                            $('#sub_category').append('<option value="">-- Select Sub Category --</option>');
                            $.each(r, function(id, val) {
                                $('#sub_category').append('<option value="' + val.id + '">' + val.name + '</option>');
                            });
                            $('#sub_category').val(data.sub_category_id);
                        }
                    });


                    $.ajax({
                        type: 'POST',
                        url: '<?php echo site_url('admin/payment_item/get_payment_item') ?>',
                        data: {
                            'category_type': data.category,
                            'sub_category': data.sub_category_id,
                        },
                        dataType: 'JSON',
                        success: function(r) {
                            $.each(r, function(id, val) {
                                $('#payment_item').append('<option value="' + val.id + '">' + val.payment_item + '</option>');
                            });
                            $('#payment_item').val(data.payment_item)

                            $('.select2').select2({
                                theme: 'bootstrap'
                            });
                        }
                    });


                    // get_payment_item(data.category,data.sub_category_id,'#payment_item','edit_record');
                    // console.log(data)

                    $('#release_type').val(data.release_type);
                    $('#admin_note_record').val(data.admin_note);
                    $('#finance_note_record').val(data.finance_note);
                    $('#record_status_grantee').val(data.status);
                    $('#hide-total-payment-record').val(data.total_nominal);
                    $("#edit_record_grantee_priority").val(data.priority);
                    $("#user_grantee_grant_memo_id").val(data.user_grantee_grant_memo_id);

                    if (data.deadline_date != null) {
                        $('#edit_record_deadline_date').datepicker("setDate", new Date(data.deadline_date));
                    } else {
                        $('#edit_record_deadline_date').val('');
                    }
                    if (data.proof != null) {
                        $('#btn_proof').attr('href', '<?php echo base_url() ?>' + data.proof).show();
                    } else {
                        $('#btn_proof').attr('href', '').hide();
                    }

                    let is_finance = '<?php echo $this->session->userdata('role') == 'finance' ? true : false; ?>';
                    if (is_finance || data.proof !== null) {
                        $('.proof-of-transfer').removeClass('hide');    
                    } else {
                        $('.proof-of-transfer').addClass('hide');
                    }

                    if (is_finance || data.invoice !== null) {
                        $('.upload-invoice').removeClass('hide');    
                    } else {
                        $('.upload-invoice').addClass('hide');
                    }

                    if (data.invoice != null) {
                        $('#btn_invoice').attr('href', '<?php echo base_url() ?>' + data.invoice).show();
                    } else {
                        $('#btn_invoice').attr('href', '').hide();
                    }
                    if(data.notify_finance == 1){
                        $('#edit_notify_finance').attr('checked', 'checked');
                    }
                    if(data.notify_admin == 1){
                        $('#edit_notify_admin').attr('checked', 'checked');
                    }
                    if(data.notify_grantee == 1){
                        $('#edit_notify_grantee').attr('checked', 'checked');
                    }

                    $('.table-list-grantee-edit thead').html('');
                    $('.table-list-grantee-edit tbody').html('');

                    for (var i = 0; i < data.items.length; i++) {
                        var html = append_edit_record_grantee(i, data.category);
                        $('.table-list-grantee-edit tbody').append(html);
                    }
                    $( ".datepicker" ).datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: "dd M yy",
                        yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
                    });
                    
                    // setoption_payment_record('select-grantee', false,data);
                    set_payment_item_category('select-grantee', false);

                    $.each(data.items, function(key, value) {
                        $('#grantee-name' + key).text(data.full_name[key]);
                        $('#select-grantee-input' + key).val(data.user_grantee_id[key]).attr('data-bank', data.bank_info_id[key]).trigger('change');
                        $('#grantee_grant_id_edit_' + key).val(data.grantee_grant_id[key]);
                        $('#nominal_edit' + key).val(value.nominal);
                        $('#nominal_idr_edit' + key).val(value.nominal_idr);
                        $('#id' + key).val(value.id);
                        $('.remove-grantee-edit' + key).attr('data-id', value.id).attr('data-payment_id', value.payment_record_id);
                        if(value.proof_of_payment){
                            $('#proof_of_payment_' + key).attr('href', SITE_URL + value.proof_of_payment);
                        }else{
                            $('#proof_of_payment_' + key).addClass('d-none')
                            $('#delete_proof_of_payment_' + key).addClass('d-none')
                        }
                        if(data.proof_of_transfers[key]){
                            $('#proof_of_transfer_' + key).attr('href', SITE_URL + data.proof_of_transfers[key]);
                        }else{
                            $('#proof_of_transfer_' + key).addClass('d-none')
                            $('#delete_proof_of_transfer' + key).addClass('d-none')
                        }
                        $('#grantee-bank-info' + key).val(data.bank_info_id[key])
                        if (data.departure_date[key] != null) {
                            $('#grantee-departure-date' + key).datepicker("setDate", new Date(data.departure_date[key]));
                        } else {
                            $('#grantee-departure-date' + key).val('');
                        }
                    });
                    $('.select2').select2({
                        theme: 'bootstrap'
                    });
                }

                do_format_input_currency();
                $('.lightbox').topbox();
                
                if(mode == 'view'){
                    $('.form-control-view').prop('disabled', true)
                    $('.modal-footer, .hide-view, .edit-add-more-grantee').addClass('hide')
                    $('#modalLabelEditGrantee').text('View Bulk Grantee Payment')
                    $('.grantee-departure-date').css('background-color', '#eee')
                }else{
                    $('.form-control-view').prop('disabled', false)
                    $('.modal-footer, .hide-view, .edit-add-more-grantee').removeClass('hide')
                    $('#modalLabelEditGrantee').text('Edit Bulk Grantee Payment')
                    $('.grantee-departure-date').css('background-color', '#fff')
                }
            };
        });

        const openModal = new URLSearchParams(window.location.search).get('open_modal');
        const recordId = new URLSearchParams(window.location.search).get('record_id');

        if(openModal == 1 && recordId){
            $('.btn-edit-payment[data-record_id="'+recordId+'"]').trigger('click');
        }
    });
        
    function show_preview(element, type) {
        const file = element.files[0];
        
        if (file){
            let reader = new FileReader();
            let filename = file.name;
            let ext = filename.split('.').pop();
            let pdf_icon = '<?php echo base_url('assets/images/icons/pdf.svg'); ?>';
            reader.onload = function(event){
                if(ext != 'pdf') {
                    $('#preview_image_' + type).attr('src', event.target.result);
                } else if(ext == 'pdf') {
                    $('#preview_image_' + type).attr('src', pdf_icon);
                }
                
            }

            reader.readAsDataURL(file);
        }
    }

    function get_payment_item(category_type, sub_category, payment_item, param){
            if(param == 'add_record'){
                // $('#wrap-request-record-grantee-0').find('.request-item-record0').each(function(){
                //     if($(this).attr('id')!='request-item-record-0'){
                //         $(this).remove();
                //     }
                    
                //     $(payment_item).empty();
                //     $(payment_item).append('<option value="">-- Select Item --</option>');
                // });
                $(payment_item).empty();
                $(payment_item).append('<option value="">-- Select Item --</option>');
            }else if(param == 'edit_record'){
                // $('#wrap-request-record-edit-grantee-0').find('.request-item-record-edit').each(function(){
                //     if($(this).attr('id')!='request-item-record-edit-0'){
                //         $(this).remove();
                //     }
                    
                //     $(payment_item).empty();
                //     $(payment_item).append('<option value="">-- Select Item --</option>');
                //     $('input[name="edit_record[items][0][nominal]"]').val('');
                //     $('input[name="edit_record[items][0][nominal_idr]"]').val('');
                // });
                $(payment_item).empty();
                $(payment_item).append('<option value="">-- Select Item --</option>');
            }
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/payment_item/get_payment_item') ?>',
                data: {
                    'category_type': category_type,
                    'sub_category': sub_category,
                },
                dataType: 'JSON',
                success: function(r) {
                    $.each(r, function(id, val) {
                        $(payment_item).append('<option value="' + val.id + '">' + val.payment_item + '</option>');
                    });

                    $('.select2').select2({
                        theme: 'bootstrap'
                    });
                }
            });
        }

        function add_item_record_grantee(i) {
            var name_class = '.request-item-record' + i;
            var warp_request = '#wrap-request-record-grantee-' + i;
            var category_type = $('select[name="add_record[category]"]').val();
            var sub_category = $('select[name="add_record[sub_category]"]').val();
            
            if(category_type == ''){
                alert('Please Select Category');
                return false;
            }else if(sub_category == ''){
                alert('Please Select Sub Category');
                return false;
            }

            var idx = $(name_class).length;
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/payment_item/add_item_record') ?>',
                data:{
                    'idx':idx,
                    'i':i,
                    'category_type': category_type,
                    'sub_category': sub_category,
                },
                dataType: 'JSON',
                success: function(r) {
                    var html = r;
                    $(warp_request).append(html);
                    $('.select2').select2({
                        theme: 'bootstrap'
                    });
                }
            });
        }

        function edit_item_record_grantee(i) {
            var name_class = '.request-item-record' + i;
            var warp_request = '#wrap-request-record-edit-grantee-' + i;
            var category_type = $('select[name="edit_record[category]"]').val();
            var sub_category = $('select[name="edit_record[sub_category]"]').val();
            
            if(category_type == ''){
                alert('Please Select Category');
                return false;
            }else if(sub_category == ''){
                alert('Please Select Sub Category');
                return false;
            }

            var idx = $(name_class).length;
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/payment_item/add_edit_item_record') ?>',
                data:{
                    'idx':idx,
                    'i':i,
                    'category_type': category_type,
                    'sub_category': sub_category,
                },
                dataType: 'JSON',
                success: function(r) {
                    var html = r;
                    html = html.replace(/form="form"/g, "");
                    $(warp_request).append(html);
                    $('.select2').select2({
                        theme: 'bootstrap'
                    });
                }
            });
        }

        function append_edit_record_grantee(i, category) {
            var name_class = '.request-item-record-edit' + i;
            var warp_request = '#wrap-request-record-edit-grantee-' + i;
            var idx = $(name_class).length;
            var html = '';


            var labelGrantee = i == 0 ? '<th>Grantee</th>' : '';
            var labelBank = i == 0 ? '<th>Bank</th>' : '';
            var labelIdr = i == 0 ? '<th>Nominal IDR</th>' : '';
            var labelUSD = i == 0 ? '<th>Nominal USD</th>' : '';
            var labelProof = i == 0 ? '<th>Proof of Expense</th>' : '';
            var labelProofTransfer = i == 0 ? '<th>Proof of Transfer</th>' : '';
            var labelDeparture = ((i == 0) && (category == 'Grant Cost' || category == 'International Travel')) ? '<th>Start Date</th>' : '';
            if(i == 0){
                var headerRow = '<tr>' +
                                    labelGrantee + labelBank + labelIdr + labelUSD + labelDeparture + labelProof + labelProofTransfer +
                                '</tr>';
                $('.table-list-grantee-edit thead').html(headerRow);
            }

            let field_departure_date = '';
            if(category == 'Grant Cost' || category == 'International Travel'){
                field_departure_date = '<td><input type="text" class="form-control form-control-view grantee-departure-date datepicker" id="grantee-departure-date' + i + '" readonly name="edit_record[grantee]['+ i +'][departure_date]"></td>';
            }

            html += '<tr class="row-grantee-edit">' +
                                '<td>' +
                                    '<label class="my-3" id="grantee-name'+ i +'"></label>' +
                                    '<input type="hidden" class="form-control select-grantee-input" name="edit_record[grantee][' + i + '][user_grantee_id]" required id="select-grantee-input' + i + '">' +
                                '</td>' +
                                '<td>' +
                                    '<select class="form-control form-control-view grantee-bank-info" name="edit_record[grantee][' + i + '][grantee_bank_id]" id="grantee-bank-info' + i + '">' +
                                    '</select>' +
                                    '<input type="hidden" id="grantee_grant_id_edit_'+ i +'" class="grantee_grant_id" name="edit_record[grantee][' + i + '][grantee_grant_id]" value="">' +
                                '</td>' +
                                '<td><input type="text" id="nominal_idr_edit' + i + '" class="form-control form-control-view record-payment-nominal-idr currency-idr" name="edit_record[grantee][' + i + '][nominal_idr]"></td>' +
                                '<td>' +
                                    '<input type="text" id="nominal_edit' + i + '" class="record-payment-nominal form-control form-control-view currency-usd" name="edit_record[grantee][' + i + '][nominal]">' +
                                    '<input type="hidden" id="id' + i + '" class="form-control form-control-view" name="edit_record[grantee][' + i + '][id]">' +
                                '</td>' +
                                field_departure_date +
                                '<td>' +
                                    '<input type="file" name="proof_of_payment_'+ i +'" class="form-control form-control-view hide-view" style="display: inline;">' +
                                    '<br><a class="btn lightbox btn-xs btn-primary mt-1" id="proof_of_payment_'+ i +'" target="_blank">View</a>' +
                                    '<a class="hide-view btn btn-xs btn-danger mt-1" id="delete_proof_of_payment_'+ i +'" onclick="remove_payment_item_proof(this, '+ i +', 1);return false;"><i class="fa fa-times"></i></a>' +
                                '</td>' +
                                '<td>' +
                                    '<input type="file" name="proof_of_transfer_'+ i +'" class="form-control form-control-view hide-view" style="display: inline;">' +
                                    '<br><a class="btn lightbox btn-xs btn-primary mt-1" id="proof_of_transfer_'+ i +'" target="_blank">View</a>' +
                                    '<a class="hide-view btn btn-xs btn-danger mt-1" id="delete_proof_of_transfer'+ i +'" onclick="remove_payment_item_proof_of_transfer(this, '+ i +', 1);return false;"><i class="fa fa-times"></i></a>' +
                                '</td>' +
                                '<td><button class="btn btn-danger remove-grantee remove-grantee-edit' + i + '" data-is_edit="1"><i class="fa fa-times-circle"></i></button></td>' +
                        '</tr>';

            $( ".datepicker" ).datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "dd M yy",
                yearRange: "<?php echo date('Y') - 150 ?>:<?php echo date('Y') + 20 ?>"
            });

            // html = '<div id="request-item-record-edit-' + i + ' payment-item-'+ idx +'" class="row request-item-record-edit mt-3" style="padding:10px">'
            // html += '<div class="col-lg-12 mb-0 payment-item-section" style="background-color:#e9eef4;padding:10px;">'
            // html += '<div class="row row-grantee-edit">'

            // html += '<div class="col-lg-2">'
            // html += '<div class="form-group">'
            // if(i == 0){
            //     html += '<label>Grantee</label><br />'
            // }
            // html += '<label class="my-3" id="grantee-name'+ i +'"></label>'
            // html += '<input type="hidden" class="form-control select-grantee-input" name="edit_record[grantee][' + i + '][user_grantee_id]" required id="select-grantee-input' + i + '">'
            // html += '<div class="text-danger invalid-tooltip record-payment-item-validation hide" style="display: block;">Grantee is Required</div>'
            // html += '</div>'
            // html += '</div>'

            // html += '<div class="col-lg-2">'
            // html += '<div class="form-group">'
            // if(i == 0){
            // html += '<label>Bank</label>'
            // }
            // // html += '<input id="grantee-bank-info' + i + '">'
            // html += '<select class="form-control form-control-view grantee-bank-info" name="edit_record[grantee][' + i + '][grantee_bank_id]" id="grantee-bank-info' + i + '">'
            // html += '</select>'
            // html += '<input type="hidden" id="grantee_grant_id_edit_'+ i +'" class="grantee_grant_id" name="edit_record[grantee][' + i + '][grantee_grant_id]" value="">'
            // html += '</div>'
            // html += '</div>'

            // html += '<div class="col-lg-2">'
            // html += '<div class="form-group">'
            // if(i == 0){
            // html += '<label>Nominal IDR</label>'
            // }
            // html += '<input type="text" id="nominal_idr_edit' + i + '" class="form-control form-control-view record-payment-nominal-idr currency-idr" name="edit_record[grantee][' + i + '][nominal_idr]">'
            // html += '<div class="text-danger invalid-tooltip record-payment-nominal-idr-validation hide" style="display: block;">Nominal is Required</div>'
            // html += '</div>'
            // html += '</div>'

            // html += '<div class="col-lg-2">'
            // html += '<div class="form-group">'
            // if(i == 0){
            // html += '<label>Nominal USD</label>'
            // }
            // html += '<input type="text" id="nominal_edit' + i + '" class="record-payment-nominal form-control form-control-view currency-usd" name="edit_record[grantee][' + i + '][nominal]">'
            // html += '<input type="hidden" id="id' + i + '" class="form-control form-control-view" name="edit_record[grantee][' + i + '][id]">'
            // html += '<div class="text-danger invalid-tooltip record-payment-nominal-validation hide" style="display: block;">Nominal is Required</div>'
            // html += '<div class="text-danger invalid-tooltip record-payment-nominal-decimal-validation hide" style="display: block;">Please enter a valid value. The two nearest valid values are 0 and 1.</div>  '
            // html += '</div>'
            // html += '</div>'

            // html += '<div class="col-lg-3">'
            // html += '<div class="form-group">'
            // if(i == 0){
            // html += '<label>Proof of Expense</label>'
            // }
            // html += '<input type="file" name="proof_of_payment_'+ i +'" class="form-control form-control-view hide-view" style="display: inline;">'
            // html += '<br><a class="btn lightbox btn-xs btn-primary mt-1" id="proof_of_payment_'+ i +'" target="_blank">View</a>'
            // // html += '<a class="hide-view btn btn-xs btn-danger mt-1" id="delete_proof_of_payment_'+ i +'" onclick="remove_payment_item_proof(this, '+ i +', 1);return false;"><i class="fa fa-times"></i></a>'
            // html += '</div>'
            // html += '</div>'


            // html += '<div class="col-md-1">'
            // html += '<button class="btn btn-danger remove-grantee remove-grantee-edit' + i + '" data-is_edit="1"><i class="fa fa-times-circle"></i></button>'
            // html += '</div>'

            // html += '</div>'
            // html += '</div>'
            // html += '</div>'

            return html;

        }

        // function setoption_payment_record(ddlID, isFirstOptionEmpty,data) {
        //     var arr = function () {
        //         var tmp = null;
        //         $.ajax({
        //             'async': false,
        //             type: 'POST',
        //             url: '<?php echo site_url('admin/payment_item/get_data_grantee') ?>',
        //             data: {
        //                 'period_id': data.period_id,
        //                 'grant_id': grant_id,
        //             },
        //             dataType: 'html',
        //             success: function(data) {
        //                 tmp = data;
        //             }
        //         });
        //         return tmp;
        //     }();
            
        //     arr = JSON.parse(arr);
            
        //     set_payment_item_category(ddlID, isFirstOptionEmpty, arr);
        // }

        function set_payment_item_category(ddlID, isFirstOptionEmpty) {
            clearDDL(ddlID);

            if (isFirstOptionEmpty) {
                $('.' + ddlID).append("<option value=''>All</option>");
            }
            
            // console.log(arr);
            // for (var i = 0; i < arr.length; i++) {
                var fullname = '<option value="">Select Grantee</option>' +
                                        <?php foreach($users_grantee as $grantee){ ?>
                                            '<option value="<?php echo $grantee->id; ?>" data-grantee_grant_id="<?php echo htmlspecialchars(get_full_name($grantee), ENT_QUOTES, 'UTF-8'); ?></option>' +
                                         <?php } ?>
                
                $('.' + ddlID).append(fullname);
            // }
        }

    $('#select-status, #select-status-edit').change(function(){
        var is_edit = $(this).data('is_edit')
        var selectGranteeClass = is_edit ? '.select-grantee-edit' : '.select-grantee';
        // $(selectGranteeClass).empty();
        // $(selectGranteeClass).append("<option value=''>Select Grantee</option>");
        var period_id = $(this).data('period');
        var grant_id = $('#grant_id').val();
        var status = $(this).val()


        var $selectGrantee = $(selectGranteeClass);
        $selectGrantee.selectpicker('destroy'); // destroy dulu

        $selectGrantee.empty().append("<option value=''>Select Grantee</option>");
        
        var getOption = function () {
            var tmp = null;
            $.ajax({
                'async': false,
                type: 'POST',
                url: '<?php echo site_url('admin/payment_item/get_data_grantee') ?>',
                data: {
                    'period_id': period_id,
                    'grant_id': grant_id,
                    'status': status

                },
                dataType: 'html',
                success: function(data) {
                    tmp = data;
                }
            });
            return tmp;
        }();


        // tambahkan opsi baru
        if(getOption){
            getOption = JSON.parse(getOption);
            $.each(getOption, function(id, val) {
                $selectGrantee.append('<option value="' + val.id + '" data-grantee_grant_id="' + val.grantee_grant_id+ '" data-grantee_name="' + val.first_name + ' ' + (val.middle_name ? (val.middle_name + ' ') : '') + val.last_name + '">' + val.first_name + ' ' + (val.middle_name ? (val.middle_name + ' ') : '') + val.last_name + '</option>');
            });
        }

        $selectGrantee.selectpicker('refresh'); // hidupkan lagi selectpicker


        // if(getOption){
        //     getOption = JSON.parse(getOption);
        //     $.each(getOption, function(id, val) {
        //         $(selectGranteeClass).append('<option value="' + val.id + '" data-grantee_grant_id="' + val.grantee_grant_id+ '" data-grantee_name="' + val.first_name + ' ' + (val.middle_name ? (val.middle_name + ' ') : '') + val.last_name + '">' + val.first_name + ' ' + (val.middle_name ? (val.middle_name + ' ') : '') + val.last_name + '</option>');
        //     });
        // }

    });


    // BULK

    $('#select_category_add_bulk, #select_category_edit_bulk').on('change', function() {
        var action = $(this).data('action');
        var sub_category = 'select[name="'+action+'[sub_category]"]';
        var payment_item = 'select[name="'+action+'[item]"]';
        
        $(sub_category).empty();
        $(sub_category).append('<option value="">-- Select Sub Category --</option>');
        get_sub_category_bulk($(this).val(),sub_category,payment_item,action);
    });

    function get_sub_category_bulk(category_type,select_sub_category,payment_item,param) {
        if(param == 'add_record_bulk'){
            $('#wrap-request-record0').find('.request-item-record0').each(function(){
                if($(this).attr('id')!='request-item-record-0'){
                    $(this).remove();
                }
                
                $(payment_item).empty();
                $(payment_item).append('<option value="">-- Select Item --</option>');
            });
        }else if(param == 'edit_record_bulk'){
            $(payment_item).empty();
            $(payment_item).append('<option value="">-- Select Item --</option>');
        }
        

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
            }
        });
    }
    
    function select_payment_item_record_bulk(i) {
        var sub_category = 'select_sub_category_record_bulk_'+i;
        var payment_item = 'select_payment_item_record_bulk_'+i;
        $('#' + payment_item).html('');
        $('#' + payment_item).append('<option value="">-- Select Item --</option>');
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/request_payment/get_payment_item_by_sub_category') ?>/' + $('#' + sub_category).val(),
            dataType: 'JSON',
            success: function(r) {
                $.each(r, function(id, val) {
                    if ($('#' + payment_item + ' option[value="' + val.id + '"]').length === 0) {
                        $('#' + payment_item).append('<option value="' + val.id + '">' + val.payment_item + '</option>');
                    }
                });
            }
        });

        $("#" + sub_category).closest('div').find('.record-payment-sub-category-validation-bulk').addClass('hide');
    }

    function select_payment_item_record_bulk_edit(i) {
        var sub_category = 'sub_category_bulk';
        var payment_item = 'payment_item_bulk';
        $('#' + payment_item).html('');
        $('#' + payment_item).append('<option value="">-- Select Item --</option>');
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url('admin/request_payment/get_payment_item_by_sub_category') ?>/' + $('#' + sub_category).val(),
            dataType: 'JSON',
            success: function(r) {
                $.each(r, function(id, val) {
                    if ($('#' + payment_item + ' option[value="' + val.id + '"]').length === 0) {
                        $('#' + payment_item).append('<option value="' + val.id + '">' + val.payment_item + '</option>');
                    }
                });
            }
        });

        $("#" + sub_category).closest('div').find('.record-payment-sub-category-validation-bulk').addClass('hide');
    }
    // END BULK



    // ============================ PAYMENT GRANT BULK ============================
    $(document).on('click', '.add-more-data-payment', function(e){
        e.preventDefault();
        
        const paymentFor = $('input[name="add_record_bulk[payment_for]"]:checked');
        const isChecked = paymentFor.length > 0;
        const selectPaymentFor = paymentFor.val() == 'panellist' ? $('#panellist_id_bulk') : $('#hotel_id_bulk');

        if(!isChecked){
            alert('Please Select Data.')
            return false
        }
        
        if(paymentFor.val() == 'panellist'){
            if(selectPaymentFor.val() == '' || selectPaymentFor.val() == null){
                alert('Please select Panelist.')
                return false
            }
        }else{
            if(selectPaymentFor.val() == '' || selectPaymentFor.val() == null){
                alert('Please select vendor.')
                return false
            }
        }

        let row_number = $(document).find('.row-payment-grant');
        row_number = Number(row_number.length);

        const labelPayment = paymentFor.val() == 'panellist' ? 'Panelist' : 'Vendor';
        
        let selected_opt = selectPaymentFor.find('option:selected');
        
        var paymentForName = selected_opt.attr('data-name');
        var paymentForId = selected_opt.attr('data-id');


        var labelGrantee = row_number == 0 ? '<label>'+ labelPayment +'</label><br />' : '';
        var labelIdr = row_number == 0 ? '<label>Nominal IDR</label>' : '';
        var labelUSD = row_number == 0 ? '<label>Nominal USD</label>' : '';
        var labelProof = row_number == 0 ? '<label>Proof of Transfer</label>' : '';
        var labelProofExpense = row_number == 0 ? '<label>Proof of Expense</label>' : '';

        let html = '<div class="row row-payment-grant">' +
                        '<div class="col-md-3">' +
                            '<div class="form-group">' +
                                labelGrantee +
                                '<label class="my-3">'+ paymentForName +'</label>' +
                                '<input type="hidden" name="add_record_bulk[_item]['+ row_number +'][id]" form="form_payment_bulk" value="'+ paymentForId +'">' +
                            '</div>' +
                        '</div>' +
                        '<div class="col-lg-2">' +
                            '<div class="form-group">' +
                                labelIdr +
                                '<input form="form_payment_bulk" type="text" class="form-control currency-idr ini" name="add_record_bulk[_item]['+ row_number +'][nominal_idr]">' +
                            '</div>' +
                        '</div>' +
                        '<div class="col-lg-2">' +
                            '<div class="form-group">' +
                                labelUSD +
                                '<input form="form_payment_bulk" type="text" class="form-control currency-idr" name="add_record_bulk[_item]['+ row_number +'][nominal]">' +
                            '</div>' +
                        '</div>' +
                        '<div class="col-lg-2">' +
                            '<div class="form-group">' +
                                labelProof +
                                '<input type="file" form="form_payment_bulk" name="proof_record_'+ row_number +'" class="form-control" style="display: inline;">' +
                            '</div>' +
                        '</div>' +
                        '<div class="col-lg-2">' +
                            '<div class="form-group">' +
                            labelProofExpense +
                                '<input type="file" form="form_payment_bulk" name="proof_of_expense_'+ row_number +'" class="form-control" style="display: inline;">' +
                            '</div>' +
                        '</div>' +
                        '<div class="col-md-1">' +
                            '<button class="btn btn-danger remove-data-payment"><i class="fa fa-times-circle"></i></button>' +
                        '</div>' +
                    '</div>';
        
        $('.list-data-payment-grant').append(html);
    });

    $(document).on('click', '.edit-add-more-data-payment', function(e){
        e.preventDefault();
        
        const paymentFor = $('input[name="edit_record_bulk[payment_for]"]:checked');
        const isChecked = paymentFor.length > 0;
        const selectPaymentFor = paymentFor.val() == 'panellist' ? $('#panellist_id_bulk_edit') : $('#hotel_id_bulk_edit');

        if(!isChecked){
            alert('Please Select Data.')
            return false
        }
        
        if(paymentFor.val() == 'panellist'){
            if(selectPaymentFor.val() == '' || selectPaymentFor.val() == null){
                alert('Please select Panelist.')
                return false
            }
        }else{
            if(selectPaymentFor.val() == '' || selectPaymentFor.val() == null){
                alert('Please select vendor.')
                return false
            }
        }

        let row_number = $(document).find('.row-payment-grant-edit');
        row_number = Number(row_number.length);

        const labelPayment = paymentFor.val() == 'panellist' ? 'Panelist' : 'Vendor';
        
        let selected_opt = selectPaymentFor.find('option:selected');
        
        var paymentForName = selected_opt.attr('data-name');
        var paymentForId = selected_opt.attr('data-id');


        var labelGrantee = row_number == 0 ? '<label>'+ labelPayment +'</label><br />' : '';
        var labelIdr = row_number == 0 ? '<label>Nominal IDR</label>' : '';
        var labelUSD = row_number == 0 ? '<label>Nominal USD</label>' : '';
        var labelProof = row_number == 0 ? '<label>Proof of Transfer</label>' : '';
        var labelProofExpense = row_number == 0 ? '<label>Proof of Expense</label>' : '';

        let html = '<div class="row row-payment-grant-edit">' +
                        '<div class="col-md-3">' +
                            '<div class="form-group">' +
                                labelGrantee +
                                '<label class="my-3">'+ paymentForName +'</label>' +
                                '<input type="hidden" name="edit_record_bulk[_item]['+ row_number +'][id]" form="form_payment_bulk" value="'+ paymentForId +'">' +
                            '</div>' +
                        '</div>' +
                        '<div class="col-lg-2">' +
                            '<div class="form-group">' +
                                labelIdr +
                                '<input form="form_payment_bulk" type="text" class="form-control currency-idr ini" name="edit_record_bulk[_item]['+ row_number +'][nominal_idr]">' +
                            '</div>' +
                        '</div>' +
                        '<div class="col-lg-2">' +
                            '<div class="form-group">' +
                                labelUSD +
                                '<input form="form_payment_bulk" type="text" class="form-control currency-idr" name="edit_record_bulk[_item]['+ row_number +'][nominal]">' +
                            '</div>' +
                        '</div>' +
                        '<div class="col-lg-2">' +
                            '<div class="form-group">' +
                                labelProof +
                                '<input type="file" form="form_payment_bulk" name="proof_record_'+ row_number +'" class="form-control" style="display: inline;">' +
                            '</div>' +
                        '</div>' +
                        '<div class="col-lg-2">' +
                            '<div class="form-group">' +
                            labelProofExpense +
                                '<input type="file" form="form_payment_bulk" name="proof_of_expense_'+ row_number +'" class="form-control" style="display: inline;">' +
                            '</div>' +
                        '</div>' +
                        '<div class="col-md-1">' +
                            '<button class="btn btn-danger remove-data-payment remove-data-payment-edit'+ row_number +'" data-is_edit="1"><i class="fa fa-times-circle"></i></button>' +
                        '</div>' +
                    '</div>';
        
        $('.list-data-payment-grant-edit').append(html);
    });

    $(document).on('click', '.remove-data-payment', function(e) {
        e.preventDefault();
        var deleted = $("#delete_detail_payment_record_bulk").val();
        var deleted_payment = $("#delete_payment_record_bulk").val();
        if (confirm("Are you sure want to delete this ?")){
            var is_edit = $(this).data('is_edit');
            var classRow = is_edit ? '.row-payment-grant-edit' : '.row-payment-grant';
            $(this).closest(classRow).remove();
            var id = $(this).data('id');
            var payment_id = $(this).data('payment_id');
            if(id){
                if (deleted == '') {
                    $("#delete_detail_payment_record_bulk").val(id);
                } else {
                    var join_id = deleted + ',' + id;
                    var join_payment_id = deleted + ',' + id;
                    $("#delete_detail_payment_record_bulk").val(join_id);
                }
                
                if (deleted_payment == '') {
                    $("#delete_payment_record_bulk").val(payment_id);
                } else {
                    var join_payment_id = deleted + ',' + payment_id;
                    $("#delete_payment_record_bulk").val(join_payment_id);
                }
            }

        }

    });

    // VALIDATION BULK
    $("#btn-submit-record-bulk, #btn-submit-record-edit-bulk").on('click', function() {
        $(this).addClass("hide");

        $(".btn-submit-record-disabled-bulk").each(function(){
            $(this).removeClass('hide');
        });
        var action = $(this).data('action');
        var payment_date = $(".payment-date-record-bulk").val();
        if (payment_date == '') {
            var dt = $("#payment_date_bulk").val();
            payment_date = dt;
        }
        
        var invalid = false;
        if (payment_date == '') {
            $(".payment-date-record-bulk-validation").removeClass('hide');
            invalid = true;
        }

        if(action == 'create'){
            const isChecked = $('input[name="add_record_bulk[payment_for]"]:checked').length > 0;
            if (!isChecked) {
                $(".paymentfor-validation-bulk").removeClass('hide');
                invalid = true;
            }
        }

        if (action != 'create') {
            var status = $("#record_status_bulk").val();
            var action_category = "edit_record_bulk";
        }else{
            var action_category = "add_record_bulk";
            var status = $("#record_status_add_bulk").val();
        }

        var active_country = <?= $this->session->userdata('active_country') ?>;
        if(active_country = 1)
        {
            var category = 'select[name="'+action_category+'[category_id]"]';
            var sub_category = 'select[name="'+action_category+'[sub_category]"]';
            var payment_item = 'select[name="'+action_category+'[item]"]';
            var memo = 'select[name="'+action_category+'[user_grantee_grant_memo_id]"]';
            var record_status = 'select[name="'+action_category+'[record_status]"]';
            var third_party = $("#third_party_payment_" + action_category).val();

            if($(record_status).val() == 8 && $(memo).val() == ''){
                $(".memo-bulk-validation").removeClass('hide');
                invalid = true;
            }
            if($(category).val() == '' && third_party == 0){
                $(".category-validation-" + action_category).removeClass('hide');
                invalid = true;
            }
            if($(sub_category).val() == ''){
                $(".sub-category-validation-" + action_category).removeClass('hide');
                invalid = true;
            }
            if($(payment_item).val() == ''){
                $(".item-category-validation-" + action_category).removeClass('hide');
                invalid = true;
            }


        }

        if (invalid == true) {
            $(".btn-submit-record-disabled-bulk").each(function(){
            $(this).addClass('hide');
            });

            $(this).removeClass("hide");
            return false;
        }

    });

    $("#third_party_payment_add_record_bulk, #third_party_payment_edit_record_bulk").change(function() {
        var action = $(this).data('action');
        var sub_category = 'select[name="'+action+'[sub_category]"]';
        var payment_item = 'select[name="'+action+'[item]"]';
        var category = 'select[name="'+action+'[category_id]"]';
        if(this.value == 1){
            $(".category_payment_bulk").addClass("hide")
            $(category).val('');
            $(sub_category).empty();
            $(sub_category).append('<option value="">-- Select Sub Category --</option>');
            get_sub_category_bulk('Third Party',sub_category,payment_item,action);
        }else{
            $(".category_payment_bulk").removeClass("hide")
            $(sub_category).empty();
            $(sub_category).append('<option value="">-- Select Sub Category --</option>');
            // get_sub_category_bulk('',sub_category,payment_item,action);
        }
    });

    $(document).ready(function () {
        $('#mdl_add_record_bulk').on('show.bs.modal', function(event) {
            $(".radio-for").prop('disabled', false);
            $('.modal-footer').removeClass('hide');
            $('#third_party_payment_add_record_bulk').trigger('change');
        });


        $('#mdl_edit_record_bulk').on('show.bs.modal', function(event) {
            $.fn.modal.Constructor.prototype.enforceFocus = function() {
                var button = $(event.relatedTarget);
                var recordId = button.data('record_id');
                var mode = button.data('mode');
                $("#delete_detail_payment_record_bulk").val('');
                $("#delete_payment_record_bulk").val('');

                if (typeof currentPaymentBulk !== 'undefined') {
                    var data = currentPaymentBulk[recordId];
                    var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                    var payment_date = new Date(data.payment_date);
                    $('#payment_id_bulk').val(data.id);
                    $('#payment_date_bulk').val((payment_date.getDate() < 10 ? '0' + payment_date.getDate() : payment_date.getDate()) + ' ' + monthNames[payment_date.getMonth()] + ' ' + payment_date.getFullYear()).attr('autocomplete', 'off');
                    $('#description_bulk').val(data.description);
                    $('#edit_record_priority_bulk').val(data.priority);
                    $('#record_status_bulk').val(data.status);
                    $('#admin_note_bulk').val(data.admin_note);
                    $('#finance_note_bulk').val(data.finance_note);
                    $('#select_category_edit_bulk').val(data.category);
                    $('#user_grantee_grant_memo_id_bulk').val(data.user_grantee_grant_memo_id);
                    // Hide inactive memo options, but keep the currently assigned one visible & enabled so it POSTs
                    var selectMemoBulk = $('#user_grantee_grant_memo_id_bulk');
                    selectMemoBulk.find('option.memo-budget-inactive').prop('hidden', true).prop('disabled', true).hide();
                    if (data.user_grantee_grant_memo_id) {
                        var currentMemoBulk = selectMemoBulk.find('option[value="' + data.user_grantee_grant_memo_id + '"]');
                        currentMemoBulk.prop('hidden', false).prop('disabled', true).show();
                    }
                    selectMemoBulk.val(data.user_grantee_grant_memo_id);
                    $('#release_type').val(data.release_type);
                    $('#third_party_payment_edit_record_bulk').val(data.third_party_payment).trigger('change');
                    
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo site_url('admin/payment_item/get_sub_category') ?>',
                        data: {
                            'category_type': data.category
                        },
                        dataType: 'JSON',
                        success: function(r) {
                            $('#sub_category_bulk').empty();
                            $('#sub_category_bulk').append('<option value="">-- Select Sub Category --</option>');
                            $.each(r, function(id, val) {
                                $('#sub_category_bulk').append('<option value="' + val.id + '">' + val.name + '</option>');
                            });
                            $('#sub_category_bulk').val(data.payment_sub_category_id);
                        }
                    });


                    $.ajax({
                        type: 'POST',
                        url: '<?php echo site_url('admin/payment_item/get_payment_item') ?>',
                        data: {
                            'category_type': data.category,
                            'sub_category': data.payment_sub_category_id,
                        },
                        dataType: 'JSON',
                        success: function(r) {
                            $.each(r, function(id, val) {
                                $('#payment_item_bulk').append('<option value="' + val.id + '">' + val.payment_item + '</option>');
                            });
                            $('#payment_item_bulk').val(data.payment_item)

                            $('.select2').select2({
                                theme: 'bootstrap'
                            });
                        }
                    });
                    var panelist_id = data.payment_for == 'panellist' ? data.panellist_id : data.vendor_id;
                    $('.paymentfor-input').val(data.payment_for)

                    if(data.payment_for == 'vendor'){
                        $("#radio-vendor-bulk").prop("checked", true).trigger('change');
                        select_hotel(0,'edit', panelist_id);
                        select_panellist(0, 'edit', panelist_id);
                        // $('#panellist_id_edit').val('');
                        // $('#hotel_id_edit').val(data.vendor_id).trigger('change');
                    }else if(data.payment_for == 'panellist'){
                        $("#radio-panellist-bulk").prop("checked", true).trigger('change');
                        select_hotel(0,'edit', panelist_id);
                        select_panellist(0, 'edit', panelist_id);
                        // $('#hotel_id_edit').val('');
                        // $('#panellist_id_edit').val(data.panellist_id).trigger('change');
                    }else if(data.payment_for == 'grantee') {

                    }else{
                        $("#radio-grantee").prop("checked", false);
                        $("#radio-panellist-bulk").prop("checked", false);
                        $("#radio-vendor-bulk").prop("checked", false);
                        $(".sec-vendor").addClass('hide')
                        $(".sec-panellist").addClass('hide')
                    }
                    

                    $('#wrap-request-record-edit-bulk').html('');

                    for (var i = 0; i < data.items.length; i++) {
                        var html = append_edit_record_bulk(i, data.payment_for);
                        $('#wrap-request-record-edit-bulk').append(html);
                    }

                    $.each(data.items, function(key, value) {
                        $('#payment-name-' + key).text(data.payment_name[key]);
                        // $('#select-grantee-input' + key).val(data.user_grantee_id[key]).attr('data-bank', data.bank_info_id[key]).trigger('change');
                        $('#payment-bulk-id-' + key).val(data.payment_grant_id_for[key]);
                        $('#payment-nominal-' + key).val(value.nominal);
                        $('#payment-nominal-idr-' + key).val(value.nominal_idr);
                        $('#payment_record_grant_id-' + key).val(value.payment_record_grant_id);
                        $('#payment_item_record_grant_id-' + key).val(value.id);
                        $('.remove-data-payment-edit' + key).attr('data-id', value.id).attr('data-payment_id', value.payment_record_grant_id);
                        if(data.proofs){
                            if(data.proofs[key] != null){
                                $('#proof_record_' + key).attr('href', SITE_URL + data.proofs[key]);
                            }else{
                                $('#proof_record_' + key).addClass('d-none')
                            }
                        }
                        if(data.proof_expenses){
                            if(data.proof_expenses[key] != null){
                                $('#proof_of_expense_' + key).attr('href', SITE_URL + data.proof_expenses[key]);
                            }else{
                                $('#proof_of_expense_' + key).addClass('d-none')
                            }
                        }
                    });
                    $('.select2').select2({
                        theme: 'bootstrap'
                    });
                }

                do_format_input_currency();
                $('.lightbox').topbox();
                
                if(mode == 'view'){
                    $('.form-control-view').prop('disabled', true)
                    $('.modal-footer, .hide-view, .edit-add-more-data-payment').addClass('hide')
                    $('#modalLabelEditPanelist').text('View Bulk Panelist Payment')
                }else{
                    $('.form-control-view').prop('disabled', false)
                    $('.modal-footer, .hide-view, .edit-add-more-data-payment').removeClass('hide')
                    $('#modalLabelEditPanelist').text('Edit Bulk Panelist Payment')
                    $(".radio-for").prop('disabled', true);
                }
                $('.selectpicker').selectpicker('refresh');
            };
        });
    })

    function append_edit_record_bulk(i, payFor) {
            const label = payFor == 'panellist' ? 'Panelist' : 'Vendor';
            var html = '';

            // html = '<div id="request-item-record-edit-' + i + ' payment-item-'+ idx +'" class="row request-item-record-edit mt-3" style="padding:10px">'
            // html += '<div class="col-lg-12 mb-0 payment-item-section" style="background-color:#e9eef4;padding:10px;">'

            var labelGrantee = i == 0 ? '<label>'+ label +'</label><br />' : '';
            var labelIdr = i == 0 ? '<label>Nominal IDR</label>' : '';
            var labelUSD = i == 0 ? '<label>Nominal USD</label>' : '';
            var labelProof = i == 0 ? '<label>Proof of Transfer</label>' : '';
            var labelProofExpense = i == 0 ? '<label>Proof of Expense</label>' : '';
            html += '<div class="row row-payment-grant-edit">' +
                        '<div class="col-md-3">' +
                            '<div class="form-group">' +
                                labelGrantee +
                                '<label class="my-3" id="payment-name-'+i+'"></label>' +
                                '<input type="hidden" form="form_payment_bulk" name="edit_record_bulk[_item]['+ i +'][id]" form="form_payment_bulk" id="payment-bulk-id-'+i+'">' +
                                '<input type="hidden" form="form_payment_bulk" name="edit_record_bulk[_item]['+ i +'][payment_record_grant_id]" form="form_payment_bulk" id="payment_record_grant_id-'+i+'">' +
                                '<input type="hidden" form="form_payment_bulk" name="edit_record_bulk[_item]['+ i +'][payment_item_record_grant_id]" form="form_payment_bulk" id="payment_item_record_grant_id-'+i+'">' +
                            '</div>' +
                        '</div>' +
                        '<div class="col-lg-2">' +
                            '<div class="form-group">' +
                                labelIdr +
                                '<input form="form_payment_bulk" type="text" class="form-control form-control-view currency-idr ini" form="form_payment_bulk" name="edit_record_bulk[_item]['+ i +'][nominal_idr]" id="payment-nominal-idr-'+i+'">' +
                            '</div>' +
                        '</div>' +
                        '<div class="col-lg-2">' +
                            '<div class="form-group">' +
                                labelUSD +
                                '<input form="form_payment_bulk" type="text" class="form-control form-control-view currency-idr" form="form_payment_bulk" name="edit_record_bulk[_item]['+ i +'][nominal]" id="payment-nominal-'+i+'">' +
                            '</div>' +
                        '</div>' +
                        '<div class="col-lg-2">' +
                            '<div class="form-group">' +
                                labelProof +
                                '<input type="file" form="form_payment_bulk" name="proof_record_'+ i +'" class="form-control form-control-view" style="display: inline;">' +
                                '<br><a class="btn lightbox btn-sm btn-primary mt-1" id="proof_record_'+ i +'" target="_blank">View</a>'+
                            '</div>' +
                        '</div>' +
                        '<div class="col-lg-2">' +
                            '<div class="form-group">' +
                            labelProofExpense +
                                '<input type="file" form="form_payment_bulk" name="proof_of_expense_'+ i +'" class="form-control form-control-view" style="display: inline;">' +
                                '<br><a class="btn lightbox btn-sm btn-primary mt-1" id="proof_of_expense_'+ i +'" target="_blank">View</a>'+
                            '</div>' +
                        '</div>' +
                        '<div class="col-md-1 hide-view">' +
                            '<button class="btn btn-danger remove-data-payment remove-data-payment-edit'+ i +'" data-is_edit="1"><i class="fa fa-times-circle"></i></button>' +
                        '</div>' +
                    '</div>';

            return html;

        }

    

    function remove_payment_item_proof(element, idx, edit = 0)
    {
        if (confirm("Are you sure you want to remove this file?")) {
            var file_input = element.closest('div').querySelector('input[type="file"]');
            
            if (file_input) {
                file_input.value = '';
            }
            $("#proof_of_payment_" + idx).remove();
            $("#delete_proof_of_payment_" + idx).addClass('d-none');

            if (idx != undefined) {
                element.closest('div').insertAdjacentHTML('beforeend', '<input form="form_edit_bulk_grantee" type="hidden" name="edit_record[grantee]['+idx+'][remove_proof]" value="1">');
            }
        }
    }

    function remove_payment_item_proof_of_transfer(element, idx, edit = 0)
    {
        if (confirm("Are you sure you want to remove this file?")) {
            var file_input = element.closest('div').querySelector('input[type="file"]');
            
            if (file_input) {
                file_input.value = '';
            }
            $("#proof_of_transfer_" + idx).remove();
            $("#delete_proof_of_transfer" + idx).addClass('d-none');

            if (idx != undefined) {
                element.closest('div').insertAdjacentHTML('beforeend', '<input form="form_edit_bulk_grantee" type="hidden" name="edit_record[grantee]['+idx+'][remove_proof_transfer]" value="1">');
            }
        }
    }

    $(document).on('click', '.button-copy-file-document', function(e){
        const period_id = $(this).data('period');
        const doc = $(this).data('document');

        $('#document_copy_file').val(doc);
        $('#mdl_select_period_copy').modal(); 
    });


    // submission on going
    $(document).on('click', '.add-submission-ongoing', function(){
        $("input:not([name='grant_id']):not([name='period_id'])").val('');
        $(".initial_submission_ongoing").html('');
        $(".add-type-document").click();
        let editor = tinymce.get('semester');
        if (editor) {
            editor.setContent("");
        } 
    });


    $(document).on('click', '.add-type-document', function(e){
        e.preventDefault();
        let list_score = $(document).find('.remove-submission-ongoing');
        let is_first = list_score.length > 0 ? false : true;
        let is_disabled = is_first ? 'disabled' : '';

        let new_element = '<div class="rows">' +
                            '<div class="col-md-6">' +
                                '<div class="form-group">' +
                                    '<label>Type of Document</label>' +
                                    '<input type="text" class="form-control" name="type_of_document[]" required>' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-md-4">' +
                                '<div class="form-group">' +
                                    '<label>Submission Deadline</label>' +
                                    '<input type="text" class="form-control" name="deadline[]" required>' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-md-1 pl-0">' +
                                '<div class="form-group">' +
                                    '<label>&nbsp;</label>' +
                                    '<a class="btn btn-danger remove-submission-ongoing" ' + is_disabled + '><i class="fa fa-times-circle"></i></a>' +
                                '</div>' +
                            '</div>' +
                        '</div>';
        
        $(".initial_submission_ongoing").append(new_element);
    });

    $(document).on('click', '.remove-submission-ongoing', function(e){
        e.preventDefault();
        $(this).closest('.rows').remove();
    });

    $(document).on('click', '.edit-submission-ongoing', function(e){
        e.preventDefault();
        
        let element = $(this);
        $('input[name="id"]').val(element.data('id'));
        
        tinymce.activeEditor.setContent(element.data('semester'));
        let editor = tinymce.get('semester');
        if (editor) {
            let semesterContent = JSON.parse(element.data('semester'));
            editor.setContent(semesterContent);
        } 

        $(".initial_submission_ongoing").html('');
        $(this).closest('tr').find('li').each(function() {
            let type_of_document = $(this).data('type_of_document');
            let deadline = $(this).data('deadline');

            let new_element = '<div class="rows">' +
                '<div class="col-md-6">' +
                '<div class="form-group">' +
                '<label>Type of Document</label>' +
                '<input type="text" class="form-control" name="type_of_document[]" required value="' + type_of_document + '">' +
                '</div>' +
                '</div>' +
                '<div class="col-md-5">' +
                '<div class="form-group">' +
                '<label>Deadline</label>' +
                '<input type="text" class="form-control" name="deadline[]" required value="' + deadline + '">' +
                '</div>' +
                '</div>' +
                '<div class="col-md-1 pl-0">' +
                '<div class="form-group">' +
                '<label>&nbsp;</label>' +
                '<a class="btn btn-danger remove-submission-ongoing"><i class="fa fa-times-circle"></i></a>' +
                '</div>' +
                '</div>' +
                '</div>';

            $(".initial_submission_ongoing").append(new_element);
        });
        
    });

    $(document).ready(function () {
        $("#submission_ongoing_table tbody").sortable({
            cursor: "move",
            placeholder: "sortable-placeholder",
            helper: function(e, tr) {
                let $originals = tr.children();
                let $helper = tr.clone();
                $helper.children().each(function(index) {
                    $(this).width($originals.eq(index).width());
                });
                return $helper;
            },
            update: function(event, ui) {
                let sorted_ids = [];
                $("#submission_ongoing_table tbody").find('tr').each(function(index) {
                    let row = $(this);
                    let row_number = index + 1;
                    row.find('td:first').text(row_number); 
                    row.data('sort', row_number); 
                    let current_id = row.data('id');
                    let sort = row_number;
                    sorted_ids.push({ id: current_id, sort: sort });
                });
                
                $.ajax({
                    url: "<?php echo site_url('admin/user_grantee_grant/sort_submission_ongoing'); ?>",
                    type: "POST",
                    data: {
                        rows: sorted_ids
                    },
                    success: function(response) {},
                    error: function(xhr, status, error) {}
                });
            }
        }).disableSelection();
    })

</script>

<!-- submission category -->
 <script>
    $(document).ready(function() {
        $("#pdo_format").trigger('change');
        $('#use_grant_page_for_submission').change(function() {
            var isChecked = $(this).is(':checked');
            var periodId = '<?= $period_id ?>';
            
            $.ajax({
                url: '<?= site_url("admin/user_grantee_grant/toggle_grant_page_submission") ?>',
                type: 'POST',
                data: {
                    period_id: periodId,
                    use_grant_page_for_submission: isChecked ? 1 : 0
                },
                success: function(response) {
                    if (response.success) {
                        alert('Grant page submission setting updated successfully');
                    } else {
                        alert('Error updating grant page submission setting');
                        $('#use_grant_page_for_submission').prop('checked', !isChecked);
                    }
                },
                error: function() {
                    alert('Error updating grant page submission setting');
                    $('#use_grant_page_for_submission').prop('checked', !isChecked);
                }
            });
        });

        $('#copy_grant_id').on('change', function(){
            let grant_id = $(this).val();
            $.ajax({
                url : '<?php echo site_url('world/all_period/'); ?>/' + grant_id,
                type : 'GET',
                dataType : 'JSON',
                success : function(response)
                {
                    if (response.length > 0) {
                        $('.select-period-section').removeClass('hide');
                    } else {
                        $('.select-period-section').addClass('hide');
                    }

                    $('#period_id').empty();
                    $('#period_id').append(
                        $('<option>', {
                            value: '',
                            text: '-- Select Period --'
                        })
                    );
                    
                    $.each(response, function(index, item){
                        $('#period_id').append(
                            $('<option>', {
                                value: item.id,
                                text: item.fiscal_year
                            })
                        );
                    });
                },
                error : function (response)
                {

                }
            })
        });

        $('#copy_submission_ongoing_id').on('change', function(){
            let grant_id = $(this).val();
            $.ajax({
                url : '<?php echo site_url('world/all_period/'); ?>/' + grant_id,
                type : 'GET',
                dataType : 'JSON',
                success : function(response)
                {
                    if (response.length > 0) {
                        $('.select-period-sub-ongoing-section').removeClass('hide');
                    } else {
                        $('.select-period-sub-ongoing-section').addClass('hide');
                    }

                    $('#period_id_submission_ongoing').empty();
                    $('#period_id_submission_ongoing').append(
                        $('<option>', {
                            value: '',
                            text: '-- Select Period --'
                        })
                    );
                    
                    $.each(response, function(index, item){
                        $('#period_id_submission_ongoing').append(
                            $('<option>', {
                                value: item.id,
                                text: item.fiscal_year
                            })
                        );
                    });
                },
                error : function (response)
                {

                }
            })
        });
    });

    var isReadOnlyEditor = '<?= $is_pdo_global ? 1 : 0 ?>';
    tinymce.init({
        selector: '.editor_pdo',
        plugins: 'link table',
        toolbar: isReadOnlyEditor
            ? false
            : 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | link | fontsizeselect',
        spellchecker: false,
        // readonly: isReadOnlyEditor == 1 ? true : false,
        setup: function (editor) {
            editor.on('init', function () {

                if (isReadOnlyEditor) {
                    // console.log(editor);
                    

                    editor.on('BeforeExecCommand', function (e) {
                        e.preventDefault();
                    });

                    editor.on('keydown', function (e) {
                        e.preventDefault();
                    });

                    editor.on('paste', function (e) {
                        e.preventDefault();
                    });

                    editor.on('drop', function (e) {
                        e.preventDefault();
                    });
                }

            });
        }
    });

    $('#pdo_format').change(function(){
        var value = $(this).val()
        if(value == 'hybrid'){
            $('#section_offline, #section_online').removeClass('hide')
        }

        if(value == 'offline'){
            $('#section_offline').removeClass('hide')
            $('#section_online').addClass('hide')
        }

        if(value == 'online'){
            $('#section_offline').addClass('hide')
            $('#section_online').removeClass('hide')
        }
    })


    $(document).on('click', '.btn-noaction', function(e) {
        e.stopPropagation();
        e.preventDefault();

    });

    $(document).on('click', '.button-copy-template-email', function(e){
        const period_id = $(this).data('period');
        const template = $(this).data('template');

        $('#template_name').val(template);
        $('#mdl_copy_template').modal(); 
    });

    // When Period / Fiscal Year is selected
    $('#copy_period_id_sof').on('change', function() {
        const selectedFy = $(this).val();
        const $grantSelect = $('#copy_grant_id_sof');
        $grantSelect.empty().append('<option value="">--Select Grant--</option>');
        $('#sourceInfoBox').hide();

        if (!selectedFy) {
            return;
        }

        $.ajax({
            url: '<?= site_url("admin/user_grantee_grant/get_grants_by_fiscal_year"); ?>',
            type: 'GET',
            dataType: 'json',
            data: {
                fiscal_year: selectedFy
            },
            beforeSend: function() {
                $grantSelect.prop('disabled', true);
            },
            success: function(response) {

                if (response.status && response.data && response.data.length > 0) {
                    response.data.forEach(function(g) {
                        var countFos = g.total_fos ? ' (' + g.total_fos + ' FOS)' : '(empty FOS)';
                        $grantSelect.append(
                            $('<option></option>')
                                .val(g.id)
                                .data('total-fos', g.total_fos)
                                .data('grant-name', g.grant_name)
                                .text(g.grant_name + ' ' + countFos)
                        );
                    });

                }

            },
            error: function(xhr) {
                console.error(xhr.responseText);
            },
            complete: function() {
                $grantSelect.prop('disabled', false);
            }
        });
    });

    // When Grant is selected
    $('#copy_grant_id_sof').on('change', function() {
        const grantId = $(this).val();
        const selectedOption = $(this).find('option:selected');
        const totalFos = selectedOption.data('total-fos');
        const grantName = selectedOption.data('grant-name');
        const periodName = $('#copy_period_id_sof').val();

        if (grantId && totalFos !== undefined) {
            $('#sourceFosCount').text(totalFos || 0);
            $('#sourceGrantName').text(grantName);
            $('#sourcePeriodName').text(periodName);
            $('#sourceInfoBox').show();
        } else {
            $('#sourceInfoBox').hide();
        }
    });

    $('#btnApplyCopy').on('click', function() {
        const periodId = '<?= isset($period_id) ? $period_id : 0 ?>';
        const fiscalYear = $('#copy_period_id_sof').val();
        const periodIdFrom = $('#copy_grant_id_sof').val();
        const strategy = $('input[name="copyStrategy"]:checked').val() || 'replace';

        if (!fiscalYear) {
            alert('Please select a Period/Fiscal Year.');
            $('#copy_period_id_sof').focus();
            return;
        }

        if (!periodIdFrom) {
            alert('Please select a Source Program / Grant.');
            $('#copy_grant_id_sof').focus();
            return;
        }

        const $btn = $(this);
        $btn.prop('disabled', true).text('Applying...');

        $.ajax({
            url: '<?= base_url("admin/user_grantee_grant/load_english_test_score_default") ?>',
            type: 'GET',
            data: {
                period_id: periodId,
                fiscal_year: fiscalYear,
                period_from: periodIdFrom,
                strategy: strategy
            },
            dataType: 'json',
            success: function(resp) {
                $btn.prop('disabled', false).text('Apply');

                if (resp && resp.length > 0) {
                    // Close modal
                    $('#mdlCopySofGrantee').modal('hide');
                    show_toast_message('Successfully copy default English Test Scores ' + resp.length + ' items applied.');
                    location.reload();
                } else {
                    alert('No FOS found.');
                }
            },
            error: function() {
                $btn.prop('disabled', false).text('Apply');
                alert('Failed to fetch load from source.');
            }
        });
    });

    $('#btnApplyLoad').on('click', function() {
        const periodId = '<?= isset($period_id) ? $period_id : 0 ?>';
        const strategy = $('input[name="loadStrategy"]:checked').val() || 'replace';

        const $btn = $(this);
        $btn.prop('disabled', true).text('Loading...');

        $.ajax({
            url: '<?= base_url("admin/user_grantee_grant/load_english_test_score_default") ?>',
            type: 'GET',
            data: {
                period_id: periodId,
                strategy: strategy
            },
            dataType: 'json',
            success: function(resp) {
                $btn.prop('disabled', false).text('Load Default');

                if (resp && resp.length > 0) {
                    // Close modal
                    $('#mdlLoadSofGrantee').modal('hide');
                    show_toast_message('Successfully load default English Test Scores ' + resp.length + ' items applied.');
                    location.reload();
                } else {
                    alert('No FOS found.');
                }
            },
            error: function() {
                $btn.prop('disabled', false).text('Load Default');
                alert('Failed to fetch load from source.');
            }
        });
    });
</script>