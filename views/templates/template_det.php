<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url() ?>favicon.png">

    <title><?php echo isset($page_title) ? $page_title : 'AMINEF Grantee' ?></title>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-VGTCZ0LBFX"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-VGTCZ0LBFX');
    </script>

    <link href="<?php echo base_url() ?>css/bootstrap.min.css?v=<?=VERSION?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/bootstrap-4-utilities.css?v=<?=VERSION?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/metisMenu.min.css?v=<?=VERSION?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/sb-admin-2.css?v=<?=VERSION?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/morris.css?v=<?=VERSION?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/font-awesome.min.css?v=<?=VERSION?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/select2.min.css?v=<?=VERSION?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url() ?>css/select2-bootstrap-theme.min.css?v=<?=VERSION?>"/>
    <link href="<?php echo base_url() ?>css/bootstrap-datetimepicker.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/aminef.css?v=<?= time() ?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/topbox.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/jquery.timepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/jquery-ui.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/flatpickr.min.css" rel="stylesheet">
    <?php echo isset($style) ? $style : '' ?>
    
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

        .custom-file-input {
            display: none !important;
        }

        .custom-file-label {
            display: inline-block;
            padding: 8px 20px;
            font-size: 16px;
            font-weight: 500;
            color: #fff;
            background-color: #007bff;
            border: 1px solid #007bff;
            border-radius: 5px;
            cursor: pointer;
        }

        .custom-file-label:hover {
            background-color: #0056b3;
        }

        .custom-file-label:active {
            background-color: #004080;
        }

        .swal2-popup {
            width: 500px !important;
            font-size: 12pt !important;
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

        .swal-custom {
            height: 250px !important;
            font-size: 9pt !important;
        }

        .my-ok-button {
            margin-bottom: 20px; /* Ubah sesuai kebutuhan */
        }
        
        .grantee-layout .grantee-header-corner {
            left: 0;
            opacity: 0.9;
            pointer-events: none;
            position: absolute;
            top: 0;
            transform: scaleX(-1);
            width: 60px;
            z-index: 0;
        }

        .grantee-layout .navbarheader > :not(.grantee-header-corner) {
            position: relative;
            z-index: 1;
        }

        @media (max-width: 767px) {
            .grantee-layout .grantee-header-corner {
                opacity: 0.55;
                width: 42px;
            }
        }
    </style>
</head>

<body class="grantee-layout">
    <?php $current_active_grant = $this->session->userdata('active_grant'); ?>
    <div id="wrapper" style="background-color:#fff">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top navbarheader" role="navigation" style="margin-bottom: 0;">
            <img class="img-responsive grantee-header-corner" width="60" src="<?php echo base_url('css/images/aminef-heading-vector.jpg') ?>" style="position: absolute;top: 0;transform: scaleX(-1);">
            <?php echo $navbar ?>
        </nav>

        <div id="page-wrapper" style='background-color:#ecf0f5'>
            <?php echo $content ?>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <div class="modal fade" style="width: 100%!important; height: 100% !important;" id="progress-dialog" tabindex="-1" role="dialog" aria-labelledby="progress-dialog" aria-hidden="true">
        <div class="modal-dialog" role="document" style="width: 100% !important; height: 100% !important;">
            <div class="modal-body text-center">
                <div class="col-md-12" style="margin-top: 15%;">
                    <center><div class="loading"></div></center>
                </div>
                <div class="col-md-12">
                    <center><b style="color: white;">Downloading, please wait</b></center>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" style="width: 100%!important; height: 100% !important;" id="progress-dialog-upload" tabindex="-1" role="dialog" aria-labelledby="progress-dialog" aria-hidden="true">
        <div class="modal-dialog" role="document" style="width: 100% !important; height: 100% !important;">
            <div class="modal-body text-center">
                <div class="col-md-12" style="margin-top: 15%;">
                    <center><div class="loading"></div></center>
                </div>
                <div class="col-md-12">
                    <center><b style="color: white;">Uploading, please wait</b></center>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url() ?>js/jquery.min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/bootstrap.min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/metisMenu.min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/raphael-min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/morris.min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/sb-admin-2.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/select2.min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/bootstrap-datetimepicker.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/sweet-alert.min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/topbox.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/jquery.timepicker.min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/tinymce/tinymce.min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/flatpickr.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/aminef.js?v=<?=time()?>"></script>
    <?php echo isset($script) ? $script : '' ?>
    <script>
        $(document).ready(function() {
            const showKeywords = [
                'preview',
                'view',
                'go'
            ];
            let activeStatus = '<?= $this->session->userdata('status') ?>';
            
            if(activeStatus == 24){
                $('.form-control').prop('disabled', true).css('background-color', '#eee');
                $('input[type="radio"]').prop('disabled', true);
                $('.btn').addClass('hide');
                $('.btn').each(function () {
                    const text = $(this).text().trim().toLowerCase();

                    const isShow = showKeywords.some(k => text.includes(k));

                    if (isShow) {
                        $(this).removeClass('hide');
                    }
                });
                $('.enable-alumni').prop('disabled', false).removeClass('hide').css('background-color', '#fff');
                $('.btn-enable-alumni').prop('disabled', false).removeClass('hide');

                
            }
            $('.auto-capitalize').each(function () {
                var activeCountry = <?= $this->session->userdata('active_country') ?? 1 ?>;
                let setting = activeCountry === 2 
                    ? this.value.replace(/\b\w/g, c => c.toUpperCase()) 
                    : this.value.replace(/\b\w/g, c => c.toUpperCase()).replace(/\B\w/g, c => c.toLowerCase());
                
                setting = setting.replace(/\bFnu\b/gi, 'FNU');
                this.value = setting;
            });
            
            function toTitleCase(str) {
                return str.replace(/\w\S*/g, function(txt){
                    return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                });
            }

            $(document).on('blur', '.auto-capitalize', function () {
                var activeCountry = <?= $this->session->userdata('active_country') ?? 1 ?>;
                let setting = activeCountry === 2 
                    ? this.value.replace(/\b\w/g, c => c.toUpperCase()) 
                    : this.value.replace(/\b\w/g, c => c.toUpperCase()).replace(/\B\w/g, c => c.toLowerCase());
                
                setting = setting.replace(/\bFnu\b/gi, 'FNU');
                this.value = setting;
            });
            
            const progress_dialog = $("#progress-dialog");

            $('.select_multiselect').select2();
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
                        return '<?php echo site_url('world/field_of_study') ?>' + (parent_id ? '/' + parent_id : '') + '?have_other=' + ($(this).hasClass('have_other') ? 1 : 0) + '&grant_id=' + grant_id + '&period_id=' + period_id;
                    },
                    dataType: 'json'
                }
            });
            $('.lightbox').topbox();
            $('input[type="text"], input[type="email"]').attr('autocomplete','new-password');
            $(".have_other").change(function() {
                if ($(this).is('input[type="checkbox"]')){
                    if ($(this).is(':checked') && $(this).val() == 'Other'){
                        $(".text-other-" + $(this).data('show')).show();
                    }else if (!$(this).is(':checked') && $(this).val() == 'Other'){
                        $(".text-other-" + $(this).data('show')).hide();
                    }
                }else {
                    if (Array.isArray($(this).val())){
                        if ($(this).val().includes("Other")){
                            $(".text-other-" + $(this).data('show')).show();
                        }else{
                            $(".text-other-" + $(this).data('show')).hide();
                        }
                    } else{
                        // show other
                        if ($(this).val() == 'Other'){
                            $(".text-other-" + $(this).data('show')).show();
                        } else {
                            $(".text-other-" + $(this).data('show')).hide();
                        }
                    }
                }
            })

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

            $(document).on('click', ".btn-download", async function(e){
                e.preventDefault();
                progress_dialog.modal('show');
                $.ajax({
                    url : $(this).attr('href'),
                    type : 'GET',
                    dataType : 'JSON',
                    success : function(response) {
                        var link = document.createElement('a');
                        link.href = response.fileurl;
                        link.download = response.filename;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                        progress_dialog.modal('hide');
                    }, error : function(response) {
                        console.error(response);
                        progress_dialog.modal('hide');
                   
                        Swal.fire({
                            title: "Failed to download the document",
                            text: response.responseText,
                            icon: "warning"
                        });
                    }
                });
            });

            
        });

        function emptyValueSubmission(object){
            var datepickerForm = $(object).closest('.form-group').find('.datepicker');
            $(object).closest('.form-group').find('.datepicker').val('');
            submission_onblur(datepickerForm)
        }
        function emptyValueSubmissionDateTime(object){
            var datetimepickerForm = $(object).closest('.form-group').find('.datetime');
            $(object).closest('.form-group').find('.datetime').val('');
            submission_onblur(datetimepickerForm)
        }
    
        $(document).on('keypress', '.input_number', function(event) {
            if(event.which < 48 || event.which > 57) {
                event.preventDefault();
            }
        });
        
        tinymce.init({
            selector: '.editor',
            plugins: 'link table',
            toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | link | fontsizeselect',
            contenteditable: true,
            spellchecker: false,
            readonly: false
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
    </script>

    <script>
        function initSelect2(r) {
            let state_tag = $(r).find(".select2-state");
            let elemet_id_state = state_tag.data('multiple-step-id');
            if(elemet_id_state) {
                $('.select2-state_' + elemet_id_state).select2({
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
                $('.select2-state_' + elemet_id_state).on('select2:select', function () {
                    $(this).attr('data-value', $(this).val());
                    $(this).trigger('blur');
                    let key_of_unique = $(this).data('select_key_country');
                    $(".select2-city[data-select_key_country='"+key_of_unique+"']").val(null).trigger('change').trigger('blur');
                });
            }

            let city_tag = $(r).find(".select2-city");
            let elemet_id_city = city_tag.data('multiple-step-id');
            if(elemet_id_city) {
                $('.select2-city_' + elemet_id_city).select2({
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
                $('.select2-city_' + elemet_id_city).on('select2:select', function () {
                    $(this).trigger('blur');
                });
            }

            let parent_study_tag = $(r).find(".select2-parent-field-of-study");
            let parent_study_id = parent_study_tag.data('multiple-step-id');
            if(parent_study_id) {
                $('.select2-parent-field-of-study_' + parent_study_id).select2({
                    placeholder: "Select Field of Study"
                });
                $('.select2-parent-field-of-study_' + parent_study_id).on('select2:select', function () {
                    $(this).trigger('blur');
                    let key_of_unique = $(this).data('select_key_state_of_study');
                    $(".select2-field-of-study[data-select_key_state_of_study='"+key_of_unique+"']").val(null).trigger('change').trigger('blur');
                });
            }

            let study_tag = $(r).find(".select2-field-of-study");
            let study_id = study_tag.data('multiple-step-id');
            if(study_id) {
                $('.select2-field-of-study_' + study_id).select2({
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
                $('.select2-field-of-study_' + study_id).on('select2:select', function () {
                    $(this).trigger('blur');
                });
            }
        }
        
        $(document).ready(function() {
            
            function load_iframe(container) {
                if (!container.hasClass('loaded')) {
                    var src = container.data('src');
                    var iframe = $('<iframe>', {
                        src: src,
                        style: 'width: 100%; height: 1000px;',
                        frameborder: '0'
                    });
                    container.html(iframe);
                    container.addClass('loaded');
                }
            }
            <?php if(!$hide_js) { ?>

            <?php if(!isset($hide_js)){ ?>
            $('.collapse').on('show.bs.collapse', function () {
                $('.collapse.in').collapse('hide');
            });

            $('.collapse').on('shown.bs.collapse', function () {
                var container = $(this).find('.iframe_container');
                load_iframe(container);
            });
            <?php } ?>

            var first_collapse = $('.collapse.in');
            if (first_collapse.length) {
                var container = first_collapse.find('.iframe_container');
                load_iframe(container);
            }
            <?php } ?>
        });

        $(".flatpickrTime").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });

        async function checkActiveGrant() {
            const current_grant = <?= (int)$current_active_grant ?>;
            var activeCountry = <?= $this->session->userdata('grantee_country_id') ?? 0 ?>;
            if(activeCountry == 1 && current_grant != 0){
                let response = await fetch('<?= site_url('world/get_current_grant') ?>');
                let data = await response.json();
                let resultResponse = parseInt(data.active_grant);
                let granteeId = parseInt(data.user_grantee);
                

                if (current_grant !== resultResponse) {
                    Swal.fire({
                        text: "You switched away from the active program while filling out the form. Data cannot be saved or submitted.",
                        icon: "warning",
                        customClass: 'swal-custom',
                        customClass: {
                            confirmButton: 'my-ok-button'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '<?= site_url('grantee/programs/list/')?>' + granteeId;
                        }
                    });
                } else {
                    return true
                }
            }
        }
        

        // validate indo change grant
        document.addEventListener("visibilitychange", async function() {
            if (document.visibilityState === 'visible') {
                let isChanged = await checkActiveGrant();
                if (isChanged === false || isChanged === undefined) {
                    return false;
                }
            }
        });

        $('.span-note').click(function(){
            var note = $(this).data('note');
            var attach = $(this).data('attach');
            $('.note-note').val(note)


            if (typeof attach === 'string') {
                try {
                    attach = JSON.parse(attach);
                } catch (e) {
                }
            }
            
            if (Array.isArray(attach)) {
                
                let html = '';
                attach.forEach(function (file, i) {
                    $('#attach_revise').attr('href', SITE_URL + file)
                    $('#attach_revise').removeClass('hide')
                });

            // ==== SINGLE FILE ====
            } else {
                $('#attach_revise').attr('href', SITE_URL + attach)
                $('#attach_revise').removeClass('hide')
            }
        })
        
        $('.notification-item').on('click', function(e){
            e.preventDefault();

            const notificationId = $(this).data('id');
            const $notificationItem = $(this);
            const BASEURL = '<?php echo base_url() ?>';

            $.ajax({
                url: '<?php echo base_url('notification/mark_as_read_ajax/'); ?>' + notificationId + '/' + 0,
                method: 'GET',
                dataType: 'json',
                success: function(response){
                    if(response.status === 'success'){
                        $notificationItem.removeClass('unread');
                        if (response.url) {
                            window.location.href = BASEURL + response.url;
                        }
                    } else {
                        console.error('Failed to mark notification as read:', response.message);
                    }
                    
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', error);
                }
            });
        });

        window.globalFileValidator = function(input) {

            var activeCountry = <?= $this->session->userdata('grantee_country_id') ?? 0 ?>;
            const file = input.files[0];
            if (!file) return true;

            const maxMB = $(input).data('max') || 5;
            const allowedTypes = ($(input).data('type') || '').split('|');

            // size
            if (file.size > maxMB * 1024 * 1024) {
                showSwal('error', false, `File Size Max ${maxMB}MB`, true, 2000);
                input.value = '';
                return false;
            }
            
            if(activeCountry == 1){
                if(file.type == 'application/pdf'){
                    let readerText = new FileReader();
                    readerText.onload = function(event) {
                        var fileContent = event.target.result;
                        if (fileContent.includes('/Encrypt')) {
                            showSwal('error', 'This PDF file is password-protected or encrypted. Please upload an unprotected file.', false, true, 2000);
                            input.value = '';
                        }
                    }
                    readerText.readAsText(file.slice(0, 50000));
                }
            }

            return true;
        };
        document.addEventListener('change', function(e) {
            const target = e.target;

            if (target.type === 'file') {
                const isValid = window.globalFileValidator(target);

                if (!isValid) {
                    e.stopImmediatePropagation();
                }
            }
        }, true);

    </script>

</body>

</html>