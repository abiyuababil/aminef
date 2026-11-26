
<script>
    const able_to_input_comment = $('#able_to_input_comment').val();
    <?php //if (isset($interview_scores) && $interview_scores) { ?>
        tinymce.init({
            selector: '.editor',
            readonly: able_to_input_comment == 0 ? true : false,
            setup: function (editor) {
                editor.on('blur', function () {
                    // Trigger TinyMCE to save data ke textarea
                    tinymce.triggerSave();

                    // Ambil data dari form dan kirim via AJAX
                    let form = $('#' + editor.getElement().form.id);
                    let formData = form.serialize();

                    $.ajax({
                        url: '<?= base_url('panellist/interview/autosave')?>',
                        type: 'POST',
                        data: formData,
                        success: function (response) {
                            console.log('Autosave sukses dari TinyMCE:', response);
                        },
                        error: function () {
                            console.error('Gagal autosave dari TinyMCE.');
                        }
                    });
                });
            }
        });
    <?php //} ?>
    $(document).ready(function(){
        tinymce.init({
            selector: '.editor',
            readonly: able_to_input_comment == 0 ? true : false,
            setup: function (editor) {
                editor.on('blur', function () {
                    // Trigger TinyMCE to save data ke textarea
                    tinymce.triggerSave();

                    // Ambil data dari form dan kirim via AJAX
                    let form = $('#' + editor.getElement().form.id);
                    let formData = form.serialize();

                    $.ajax({
                        url: '<?= base_url('panellist/interview/autosave')?>',
                        type: 'POST',
                        data: formData,
                        success: function (response) {
                            console.log('Autosave sukses dari TinyMCE:', response);
                        },
                        error: function () {
                            console.error('Gagal autosave dari TinyMCE.');
                        }
                    });
                });
            }
        });
        
        recalculate_score();
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


        $('.score').on('input', function() {
                // Replace commas with periods
            this.value = this.value.replace(/,/g, '.');
            // Allow only numbers and one decimal point
            this.value = this.value.replace(/[^0-9.]/g, '');
            // Ensure only one decimal point
            if ((this.value.match(/\./g) || []).length > 1) {
                this.value = this.value.slice(0, -1);
            }
        });

        $('.rate-score').on('change', function(){
            recalculate_score();
        });

        $('.score').on('change', function() {
            var score_value = parseFloat($(this).val().replace(',','.'));
            var min_value = parseFloat($(this).attr('min'));
            var max_value = parseFloat($(this).attr('max'));
            $(this).val(function(index, value) {
                value = value.replace(',', '.');
                // return parseFloat(value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')).toFixed(2);
                return value === '' || value === '.'  ? '' : parseFloat(value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')).toFixed(2)
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

        $(window).scroll(function(){
            var scroll = $(window).scrollTop();
            if (scroll == 0) {
                $('.header-interview').css({
                        'position': 'relative',
                        'z-index': '26',
                        'background-color': '#fff',
                        'top': '0'
                });
            } else {
                $('.header-interview').css({
                        'position': 'fixed',
                        'z-index': '26',
                        'background-color': '#fff',
                        'top': '-15px'
                });
            }
        });

        $("#submit-score").on('click', function(e){
            e.preventDefault();
            
            var is_valid = check_required_fields();

            <?php 
                $date_interview = new DateTime($grantee_grant->date_interview);
                $current_date = new DateTime(); 

                $date_interview_formatted = $date_interview->format('Y-m-d');
                $current_date_formatted = $current_date->format('Y-m-d');
                
                $able_to_input_scores = $current_date_formatted <= $date_interview_formatted;
                
                if ($able_to_input_scores) { ?>
                    if (!is_valid) {
                        var first_required_field = $("form :input[required]").filter(function() {
                                    return !this.value;
                                }).first();
                            first_required_field.focus();
                        return;
                    }
            <?php } ?>
            Swal.fire({
                title   : "Are you sure you want to submit this assessment?",
                text    : "Once submitted, data cannot be changed.",
                icon    : "warning",
                showCancelButton    : true,
                confirmButtonColor  : "#3085d6",
                cancelButtonColor   : "#d33",
                confirmButtonText   : "Yes, submit",
                customClass         : 'swal-interview'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("form").submit();
                }
            });
        });

        $('.single-checkbox').change(function() {
            $(this).closest('div').find('.single-checkbox').not(this).each(function(){
                $(this).prop('checked', false);
            });
        });

        function check_required_fields() {
            var is_valid = true;
            $("form input[required]").each(function() {
                
                if ($(this).val() == '') {
                    is_valid = false;
                    $(this).closest('div').find('small').removeClass('hide');
                    return false;
                } else {
                    $(this).closest('div').find('small').addClass('hide');
                }
            });

            $("form select[required]").each(function() {
                
                if ($(this).val() == '') {
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

            if ($("#rank_recommendation").val() == '') {
                Swal.fire({
                    title: "Please select Interview Result",
                    icon: "error",
                    customClass: 'swal-custom'
                });
                    
                is_valid = false;
                
                return false; 
            } 

            return is_valid;
        }

        $('.autosavepanelist').on('blur', function () {
            tinymce.triggerSave();

            let form = $(this).closest('form');
            let formData = form.serialize();

            $.ajax({
                url: '<?= base_url('panellist/interview/autosave')?>',
                type: 'POST',
                data: formData,
                success: function (response) {
                    console.log('Autosave sukses', response);
                },
                error: function () {
                    console.error('Gagal autosave dari input.');
                }
            });
        });

        $('#btn-save').on('click', function () {
            tinymce.triggerSave();

            let form = $(this).closest('form');
            let formData = form.serialize();

            $.ajax({
                url: '<?= base_url('panellist/interview/autosave')?>',
                type: 'POST',
                data: formData,
                success: function (response) {
                    showSwal('success', 'All changes saved automatically.', false, true, 1500)
                    console.log('Autosave sukses', response);
                },
                error: function () {
                    console.error('Gagal autosave dari input.');
                }
            });

        });

    });

    
</script>