<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url() ?>favicon.png">

    <title><?php echo isset($page_title) ? $page_title : 'AMINEF Admin' ?></title>
    
    <!-- Google tag (gtag.js) -->
    <!-- <script async src="https://www.googletagmanager.com/gtag/js?id=G-6YMNMY5N5L"></script> -->
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-6YMNMY5N5L');
    </script>

    <link href="<?php echo base_url() ?>css/bootstrap.min.css?v=<?=VERSION?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/bootstrap-4-utilities.css?v=<?=VERSION?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/metisMenu.min.css?v=<?=VERSION?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/sb-admin-2.css?v=<?=VERSION?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/morris.css?v=<?=VERSION?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/font-awesome.min.css?v=<?=VERSION?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/select2.min.css?v=<?=VERSION?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url() ?>css/select2-bootstrap-theme.min.css?v=<?=VERSION?>"/>    
    <link href="<?php echo base_url() ?>css/aminef.css?v=<?=VERSION?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/topbox.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/bootstrap-datetimepicker.css?v=<?=VERSION?>" rel="stylesheet">    
    <link href="<?php echo base_url() ?>css/jquery-ui.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/summernote/summernote.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/daterangepicker.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/jquery.timepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/flatpickr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/bootstrap-select-1.13.14/dist/css/bootstrap-select.min.css?v=<?=VERSION?>"/>    
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.6/css/intlTelInput.css"> -->
    <?php echo isset($style) ? $style : '' ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .select2 {
            border-radius: 0px !important;
            width: 100% !important;
            height: 35px !important;
            padding-top: 2px !important;
            /* border: 1px solid #ccc; */
        }

        span.select2.select2-container{
            border-radius: 0px !important;
            width: 100% !important;
            height: 34px !important;
            padding-top: 2px !important;
            /* border: 1px solid #ccc; */
        }

        .select2-selection.select2-selection--single {
            border-radius: 0px !important;
            width: 100% !important;
            height: 34px !important;
            padding-top: 2px !important;
            border: 1px solid #ccc;
        }

        .select2-selection__arrow {
            margin-top: 5px !important;
        }

        @keyframes loading {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
        .loading {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: loading 1s linear infinite;
        }
        .intl-tel-input {
            display:block !important;
        }

        .swal-custom {
            height: 250px !important;
            font-size: 9pt !important;
        }

        .swal-reset-rank {
            height: 350px !important;
            font-size: 9pt !important;
        }

        #mdl_detail_log .modal-body {
            max-height: 600px; 
            overflow-y: auto;
        }

        .role-name {
            position: absolute;
            top: 20px;
            right: 0px;
            
        }

        .role-name > small {
            background-color: orange;
            border-radius: 3px;
            padding: 2px 5px 2px 5px;
            font-weight: bold;
        }

        .swal-interview {
            height: 300px !important;
            font-size: 9pt !important;
        }

        .select2-search__field {
            width: 100% !important;
        }
    </style>
</head>

<body>
    <div class="row">
        <?php echo $content ?>
    </div>

    <script src="<?php echo base_url() ?>js/jquery.min.js?v=<?=VERSION?>"></script>
    <!-- <script src="<?php echo base_url() ?>js/bootstrap.min.js?v=<?=VERSION?>"></script> -->
    <script src="<?php echo base_url() ?>js/metisMenu.min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/raphael-min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/morris.min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/sb-admin-2.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/select2.min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/aminef.js?v=<?=VERSION?>"></script>
    <!-- <script src="<?php echo base_url() ?>js/ckeditor.js?v=<?=VERSION?>"></script> -->
    <script src="<?php echo base_url() ?>js/topbox.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/bootstrap-datetimepicker.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/tinymce/tinymce.min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/jquery.timepicker.min.js?v=<?=VERSION?>"></script>
    <!-- <script src="https://cdn.tiny.cloud/1/<?= TINYMCE_KEY ?>/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script> -->
    <script src="<?php echo base_url() ?>assets/summernote/summernote.js"></script>
    <script src="<?= base_url() ?>js/intlTelInput.min.js"></script>
    <script src="<?= base_url() ?>js/jquery.nestable.js"></script>
    <script src="<?php echo base_url() ?>js/sweet-alert.min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>assets/bootstrap-select-1.13.14/dist/js/bootstrap-select.min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/flatpickr.js?v=<?=VERSION?>"></script>
    <?php echo isset($script) ? $script : '' ?>
    <script>
        $(document).ready(function() {
            $('.lightbox').topbox();
            $('input[type="text"], input[type="email"], input[type="password"]').attr('autocomplete','new-password');
            $(".have_other").change(function() {
                if ($(this).is('input[type="checkbox"]')){
                    if ($(this).is(':checked') && $(this).val() == 'Other'){
                        $(".text-other-" + $(this).data('id')).show();
                    }else if (!$(this).is(':checked') && $(this).val() == 'Other'){
                        $(".text-other-" + $(this).data('id')).hide();
                    }
                }else {
                    if (Array.isArray($(this).val())){
                        if ($(this).val().includes("Other")){
                            $(".text-other-" + $(this).data('id')).show();
                        }else{
                            $(".text-other-" + $(this).data('id')).hide();
                        }
                    } else{
                        // show other
                        if ($(this).val() == 'Other'){
                            $(".text-other-" + $(this).data('id')).show();
                        } else {
                            $(".text-other-" + $(this).data('id')).hide();
                        }
                    }
                }
            })
            // for radio group purpose
            $(".radio-group").click(function(){
                var get_parent_id = $(this).closest('div').attr('id');
                var data_show = $(this).data('show');
                // hide other than this class 
                    $("#"+get_parent_id+" .show-group[data-element!='"+data_show+"']").addClass('hide');
                    $("#"+get_parent_id+" .show-group[data-element='"+data_show+"']").removeClass('hide');
                });

                // unified handler for inputs with data-show (radios and declare checkboxes)
                $(document).on('change', 'input[data-show]', function() {
                    var $el = $(this);
                    var data_show = $el.data('show');
                    var get_parent_id = $el.closest('div').attr('id');

                    if ($el.is(':checkbox')) {
                        var $target = $("#"+get_parent_id+" .show-group[data-element='"+data_show+"']");
                        if ($el.is(':checked')) {
                            $target.removeClass('hide');
                            $target.find(':input').prop('disabled', false);
                        } else {
                            $target.addClass('hide');
                            $target.find(':input').prop('disabled', true);
                        }
                    } else {
                        var $all = $("#"+get_parent_id+" .show-group");
                        $all.addClass('hide');
                        $all.find(':input').prop('disabled', true);
                        var $showTarget = $("#"+get_parent_id+" .show-group[data-element='"+data_show+"']");
                        $showTarget.removeClass('hide');
                        $showTarget.find(':input').prop('disabled', false);
                    }
                });

                $("input[data-show]:checked").trigger("change");
                // ensure hidden show-groups have their inputs disabled on load
                $(".show-group.hide").find(':input').prop('disabled', true);
            $(".formselect2").select2();
            $(".select_multiselect").select2({
                closeOnSelect: false
            });
            $(".select_multiselect_score").select2({
                closeOnSelect: false
            });
            $('.select2-country').select2({
                placeholder: "Select a country",
            });
            $('.select2-state').select2({
                placeholder: "Select a state",
                ajax: {
                    url: function (params) {
                        let key_of_unique = $(this).data('select_key_country');
                        let country_id = $(".select2-country[data-select_key_country='"+key_of_unique+"']").val();
                        return '<?php echo site_url('world/data_state') ?>' + (country_id ? '/' + country_id : '');
                    },
                    dataType: 'json'
                }
            });
            $('.select2-city').select2({
                placeholder: "Select a city",
                ajax: {
                    url: function (params) {
                        let key_of_unique = $(this).data('select_key_country');
                        let state_id = $(".select2-state[data-select_key_country='"+key_of_unique+"']").val();
                        return '<?php echo site_url('world/data_city') ?>' + (state_id ? '/' + state_id : '');
                    },
                    dataType: 'json'
                }
            });
            $('.select2-parent-field-of-study').select2({
                placeholder: "Select Field of Study",
            });
            $('.select2-field-of-study').select2({
                placeholder: "Select Specialization",
                ajax: {
                    url: function (params) {
                        let key_of_unique = $(this).data('select_key_state_of_study');
                        let parent_id = $(".select2-parent-field-of-study[data-select_key_state_of_study='"+key_of_unique+"']").val();
                        let grant_id = $(this).data('grant-id') || '';
                        let period_id = $(this).data('period-id') || '';
                        return '<?php echo site_url('world/field_of_study') ?>' + (parent_id ? '/' + parent_id : '') + '?grant_id=' + grant_id + '&period_id=' + period_id;
                    },
                    dataType: 'json'
                }
            });
        });
    </script>

    <?php if(!isset($is_alumni_page)) { ?>
    <script>
        // for default status
        $(".default_status").click(function(){
            var id = $(this).data('id');
            var section = $(this).data('section');
            $("#mdl_info").modal();   
            $('#btn-successful').attr("onclick","default_status("+ id +", \'"+ section +"\')"); 
            event.preventDefault();
        });

        // for previous status
        $(".previous_status").click(function(){
            var id = $(this).data('id');
            var section = $(this).data('section');
            $("#mdl_info").modal();   
            $('#btn-successful').attr("onclick","previous_status("+ id +", \'"+ section +"\')"); 
            event.preventDefault();
        });

        // for confirm reject
        $(".reject").click(function(){
            var id = $(this).data('id');
            var section = $(this).data('section');
            $("#mdl_info").modal();   
            $('#btn-successful').attr("onclick","open_modal_note_reject("+ id +", \'"+ section +"\')"); 
            event.preventDefault();
        });

        // for confirm drop
        $(".drop").click(function(){
            var id = $(this).data('id');
            var section = $(this).data('section');
            $("#mdl_info").modal();   
            $('#btn-successful').attr("onclick","open_modal_note_drop("+ id +", \'"+ section +"\')"); 
            event.preventDefault();
        });

        // for confirm withdraw
        $(".withdraw").click(function(){
            var id = $(this).data('id');
            var section = $(this).data('section');
            $("#mdl_info").modal();   
            $('#btn-successful').attr("onclick","open_modal_note_withdraw("+ id +", \'"+ section +"\')"); 
            event.preventDefault();
        });

        $('.select2').select2({
            theme: 'bootstrap'
        });

        function open_modal_note_reject(grantee_grant_id, section)
        {
            $("#mdl_note_reject").modal();
            $("#mdl_info").modal('toggle');  
            $("#btn-save-note").attr("onclick", "reject("+ grantee_grant_id +", \'"+ section +"\')"); 
        }

        function open_modal_note_drop(grantee_grant_id, section)
        {
            $("#mdl_note_drop").modal();
            $("#mdl_info").modal('toggle');  
            $("#btn-save-note-drop").attr("onclick", "drop("+ grantee_grant_id +", \'"+ section +"\')"); 
        }

        function open_modal_note_withdraw(grantee_grant_id, section)
        {
            $("#mdl_note_withdraw").modal();
            $("#mdl_info").modal('toggle');  
            $("#btn-save-note-withdraw").attr("onclick", "withdraw("+ grantee_grant_id +", \'"+ section +"\')"); 
        }

        function reject(grantee_grant_id, section) {
            $('#btn-save-note').html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop( 'disabled', true );
            var note = $("#note_reject").val();
            $.ajax({
                    url: "<?= base_url(); ?>admin/"+section+"/reject",
                    method: "POST",
                    dataType: 'JSON',
                    data: {
                        grantee_grant_id: grantee_grant_id,
                        note: note,
                    }
                })
                .success(function(data){
                    window.location.href = data.redirect;
                })
        }

        function drop(grantee_grant_id, section) {
            $('#btn-save-note-drop').html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop( 'disabled', true );
            var note = $("#note_drop").val();
            let dataSection = $("#data_section").val();
            $.ajax({
                    url: "<?= base_url(); ?>admin/"+section+"/drop",
                    method: "POST",
                    dataType: 'JSON',
                    data: {
                        grantee_grant_id: grantee_grant_id,
                        note: note,
                        data_section: dataSection
                    }
                })
                .success(function(data){
                    window.location.href = data.redirect;
                })
        }

        function withdraw(grantee_grant_id, section) {
            $('#btn-save-note-withdraw').html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop( 'disabled', true );
            let note = $("#note_withdraw").val();
            let attachment_withdraw = $("#attachment_withdraw").val();
            let dataSection = $("#data_section").val();
            $.ajax({
                    url: "<?= base_url(); ?>admin/"+section+"/withdraw",
                    method: "POST",
                    dataType: 'JSON',
                    data: {
                        grantee_grant_id: grantee_grant_id,
                        attachment_withdraw : attachment_withdraw,
                        note: note,
                        data_section: dataSection
                    }
                })
                .success(function(data){
                    window.location.href = data.redirect;
                })
        }

        function previous_status(grantee_grant_id, section) {
            $('#btn-successful').html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop( 'disabled', true );
            var note = $("#note_reject").val();
            $.ajax({
                    url: "<?= base_url(); ?>admin/"+section+"/previous_status",
                    method: "POST",
                    dataType: 'JSON',
                    data: {
                        grantee_grant_id: grantee_grant_id,
                        note: note,
                    }
                })
                .success(function(data){
                    window.location.href = data.redirect;
                })
        }

        function default_status(grantee_grant_id, section) {
            $('#btn-successful').html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop( 'disabled', true );
            var note = $("#note_reject").val();
            $.ajax({
                    url: "<?= base_url(); ?>admin/"+section+"/default_status",
                    method: "POST",
                    dataType: 'JSON',
                    data: {
                        grantee_grant_id: grantee_grant_id,
                        note: note,
                    }
                })
                .success(function(data){
                    window.location.href = data.redirect;
                })
        }

        function show_mdl_confirm(user_id, grant_id, key, functionName) {
            $("#mdl_info").modal();   
            $('#btn-successful').attr("onclick",""+functionName+"("+ user_id +", "+grant_id+", \'"+ key +"\')"); 
            event.preventDefault();
        }

        function show_mdl_confirm_reject(id, key) {
            $("#mdl_info").modal();   
            $('#btn-successful').attr("onclick","open_modal_note_reject("+ id +", \'"+ key +"\')");  
            event.preventDefault();
        }

        function formatText(text) {
            return text.replace(/_/g, ' ') // Mengganti _ dengan spasi
            .replace(/\b\w/g, function(char) { // Membuat huruf pertama setiap kata kapital
                return char.toUpperCase();
            });
        }
    
        $(document).on('keypress', '.input_number', function(event) {
            if(event.which < 48 || event.which > 57) {
                event.preventDefault();
            }
        });
        
        var isReadOnlyEditor = '<?= $isReadOnlyEditor ? 1 : 0 ?>';
        tinymce.init({
            selector: '.editor',
            plugins: 'link table',
            toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | link | fontsizeselect',
            contenteditable: true,
            spellchecker: false,
            readonly: isReadOnlyEditor == 1 ? true : false
        });

        if ( window.history.replaceState ) { 
            window.history.replaceState( null, null, window.location.href ); 
        } 

        function emptyValue(object) {
            $(object).closest('.form-group').find('.datepicker').val('');
        }

        function emptyValueRow(object) {
            $(object).closest('.row').find('.datepicker').val('');
        }

        function emptyTimeValueRow(object) {
            $(object).closest('.row').find('.flatpickrTime').val('');
        }
        
        function remove_error(error_element) {
            $('.' + error_element).addClass('hide');
        }

        $(".flatpickrTime").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });
        
        $(".flatpickrDateTime").flatpickr({
            altInput: true,
            altFormat: "F j, Y H:i",
            enableTime: true,
            dateFormat: "Y-m-d H:i",
        });
    </script>
    <?php } ?>

</body>

</html>