<script>
    const able_to_input_comment = $('#able_to_input_comment').val();
    $(document).ready(function(){
        recalculate_score();
        function recalculate_score()
        {
            var total_score = 0;
            let select = $(document).find('.select_grade');
            select.each(function(){
                let grade_score = parseFloat($(this).val());
                if (isNaN(grade_score)) {
                    grade_score = 0;
                }
                let total_score_input = $(this).closest('tr').find('input.total_score');
                    total_score_input.val(grade_score.toLocaleString('en', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                    total_score += parseFloat(grade_score);
            });

            $("#total").text(total_score.toLocaleString('en', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
        }

        $('.select_grade').on('change', function(){
            recalculate_score();
        });

        $(window).scroll(function(){
            var scroll = $(window).scrollTop();
            if (scroll == 0) {
            $('.header-review').css({
                    'position': 'relative',
                    'z-index': '26',
                    'background-color': '#fff',
                    'top': '0'
            });
            } else {
            $('.header-review').css({
                    'position': 'fixed',
                    'z-index': '26',
                    'background-color': '#fff',
                    'top': '-31px'
            });
            }
        });

        

        $("#submit-score").on('click', function(e){
            e.preventDefault();
            
            var is_valid = check_required_fields();

            if (!is_valid) {
                var requiredSelects = $('select[required]');
    
                // Cari elemen pertama dengan value 0
                var firstSelectWithValueZero = requiredSelects.filter(function() {
                    return $(this).val() == 0;
                }).first();
                firstSelectWithValueZero.focus();

                if (is_valid == false) {
                    Swal.fire({
                        title: "Please complete the form.",
                        icon: "error",
                        customClass: 'swal-custom'
                    });
                }
                return;
            }
                
            if ($("#rank_recommendation").val() == '') {
                Swal.fire({
                    title: "Please select Review Result",
                    icon: "error",
                    customClass: 'swal-custom'
                });
                
                is_valid = false;
            
                return false; 
            } 
            
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

        function check_required_fields() {
            var is_valid = true;
                
            // if ($("#rank_recommendation").val() == '') {
            //     Swal.fire({
            //         title: "Please select Review Result",
            //         icon: "error",
            //         customClass: 'swal-custom'
            //     });
                
            //     is_valid = false;
            
            //     return false; 
            // } 

            $(".select_grade[required]").each(function(){
                if ($(this).val() == 0) {
                    is_valid = false;

                    return false;
                }
            });
            
            return is_valid;
        }
        
        var isReadOnlyEditor = '<?= $isReadOnlyEditor ? 1 : 0 ?>';
        if(isReadOnlyEditor == 1){
            $('.autosavepanelist').addClass('readonly-select');
        }else{
            $('.autosavepanelist').removeClass('readonly-select');
        }
        tinymce.init({
            selector: '.editor_panelist',
            plugins: 'link table',
            toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | link | fontsizeselect',
            contenteditable: true,
            spellchecker: false,
            readonly: able_to_input_comment == 1 ? false : true,
            setup: function (editor) {
                editor.on('blur', function () {
                    // Trigger TinyMCE to save data ke textarea
                    tinymce.triggerSave();

                    // Ambil data dari form dan kirim via AJAX
                    let form = $(editor.getElement()).closest('form');
                    let formData = form.serialize();

                    $.ajax({
                        url: '<?= base_url('panellist/review/autosave')?>',
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

        $('.autosavepanelist').on('blur', function () {
            tinymce.triggerSave();

            let form = $(this).closest('form');
            let formData = form.serialize();

            $.ajax({
                url: '<?= base_url('panellist/review/autosave')?>',
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
                url: '<?= base_url('panellist/review/autosave')?>',
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
