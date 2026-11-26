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
    <link href="<?php echo base_url() ?>css/sb-admin-2.css?v=<?=time()?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/morris.css?v=<?=VERSION?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/font-awesome.min.css?v=<?=VERSION?>" rel="stylesheet">
    <link href="<?php echo base_url() ?>css/select2.min.css?v=<?=VERSION?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url() ?>css/select2-bootstrap-theme.min.css?v=<?=VERSION?>"/>    
    <link href="<?php echo base_url() ?>css/aminef.css?v=<?= time() ?>" rel="stylesheet">
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
            height: 270px !important;
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


    .user-avatar-note {
        align-items: center;
        background: #fff;
        border: 2px solid #5bc0de;
        border-radius: 999px;
        color: #5bc0de;
        display: inline-flex;
        font-size: 14px;
        font-weight: 700;
        height: 38px;
        justify-content: center;
        width: 38px;
    }
    </style>
</head>

<body class="admin-layout">
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top navbarheader" role="navigation" style="margin-bottom: 0">
            <?php echo $navbar ?>
        </nav>

        <div id="page-wrapper">
            <?php echo $breadcrumb ?>
            <?php echo $content ?>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <div id="offcanvasNote" class="offcanvasNote"></div>

    <div class="modal fade" id="mdl_note_withdraw" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reason Withdraw</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Attachment</label>
                            <label for="temp_attachment_withdraw" class="withdraw-attachment-area">
                                <input type="file" id="temp_attachment_withdraw" name="temp_attachment_withdraw" class="hide" onchange="show_preview_attachment(this, 'attachment_withdraw', 'attachment_withdraw')">
                                <input type="text" id="attachment_withdraw" name="attachment_withdraw" class="hide">
                                <i class="fa fa-cloud-upload"></i>
                            </label>
                            <div class="col-md-12 text-center">
                                <a class="uploaded_attachment_admin btn-link hide" style="cursor: pointer;" target="_blank"><b>View Uploaded Attachment</b></a>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label>Reason</label>
                            <textarea class="form-control" name="note_withdraw" id="note_withdraw" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-12 text-right">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="button" id="btn-save-note-withdraw" class="btn btn-primary success">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade text-center" id="mdl_info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p>Are you sure ?</p>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                    <button type="button" id="btn-successful" class="btn btn-success success">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-center" id="mdl_info_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p>Are you sure <br /> to delete <b><?= isset($title) && $title ? $title : '' ?></b>?</p>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                    <a href="<?= site_url('admin/grantee/delete/' . $this->Grantee_ent_model->id) ?>" id="submit" class="btn btn-success success">Yes</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        (function() {
            function sync_admin_header_offset() {
                var header = document.querySelector('.navbarheader');
                if (!header) {
                    return;
                }

                document.body.style.setProperty('--admin-header-offset', header.offsetHeight + 'px');
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', sync_admin_header_offset);
            } else {
                sync_admin_header_offset();
            }

            window.addEventListener('load', sync_admin_header_offset);
            window.addEventListener('resize', sync_admin_header_offset);
        })();
    </script>
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
    <!-- <div class="modal fade" id="mdl_pic" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select PIC</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?= base_url('admin/candidate/set_pic')?>">
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="hidden" name="grantee_grant_id_for_pic" id="grantee_grant_id_for_pic">
                                <select name="pic" class="form-control selectpicker" id="selectpickerPic" data-live-search="true">
                                <option value="">-- Select PIC --</option>
                                    <?php foreach($pics as $pic) { ?>
                                        <option value="<?= $pic->id ?>"><?= $pic->full_name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-12 text-right">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary success">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> -->



<div class="modal fade" id="interview-modal" tabindex="-1" role="dialog" aria-labelledby="interview-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title" id="interview-modal-label">Select view detail Applicant</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="row">
                    <div class="col-md-6">
                        <a href="#" class="btn btn-link btn-view-pdf">
                            <i class="fa fa-file-pdf-o" style="font-size: 50pt;"></i>
                            <br>
                            View PDF
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="" class="btn btn-link btn-view-form-application">
                            <i class="fa fa-file-text-o" style="font-size: 50pt;"></i>
                            <br>
                            View Application
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="interview-pdf-modal" tabindex="-1" role="dialog" aria-labelledby="interview-modal-pdf-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title" id="interview-modal-pdf-label">
                    View PDF <a type="button" class="btn btn-warning pull-right" data-dismiss="modal" style="margin-top: -5px !important;">Close</a>
                </h5>
            </div>
            <div class="modal-body">
                <div class="alert alert-info text-center hide" id="loading-pdf"><i class="fa fa-spinner fa-spin"></i> Loading pdf, please wait.</div>
                <iframe id="pdf-iframe" class="hide"></iframe>
            </div>
        </div>
    </div>
</div>
    <script src="<?php echo base_url() ?>js/jquery.min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/bootstrap.min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/metisMenu.min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/raphael-min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/morris.min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/sb-admin-2.js?v=<?=time()?>"></script>
    <script src="<?php echo base_url() ?>js/select2.min.js?v=<?=VERSION?>"></script>
    <script src="<?php echo base_url() ?>js/aminef.js?v=<?=time()?>"></script>
    <script src="<?php echo base_url() ?>js/ckeditor.js?v=<?=VERSION?>"></script>
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

            // $(document).on('input', '.auto-capitalize', function () {
            //     let cursorPos = this.selectionStart;
            //     let oldLength = this.value.length;

            //     this.value = toTitleCase(this.value);

            //     let newLength = this.value.length;
            //     this.selectionEnd = this.selectionStart = cursorPos + (newLength - oldLength);
            // });
            $(document).on('blur', '.auto-capitalize', function () {
                var activeCountry = <?= $this->session->userdata('active_country') ?? 1 ?>;
                let setting = activeCountry === 2 
                    ? this.value.replace(/\b\w/g, c => c.toUpperCase()) 
                    : this.value.replace(/\b\w/g, c => c.toUpperCase()).replace(/\B\w/g, c => c.toLowerCase());
                
                setting = setting.replace(/\bFnu\b/gi, 'FNU');
                this.value = setting;
            });

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
            })

            $("input:radio.radio-group:checked").trigger("click");

            // for education group purpose
            $(document).on('change', '.select-education-group', function(){
                var selectedVal = $(this).val();
                var $container = $(this).closest('.education-group-container');
                var visibleLevels = [];
                if (selectedVal === 'S3') {
                    visibleLevels = ['S1/D4', 'S2', 'S3'];
                } else if (selectedVal === 'S2') {
                    visibleLevels = ['S1/D4', 'S2'];
                } else if (selectedVal === 'S1/D4') {
                    visibleLevels = ['S1/D4'];
                }

                $container.find('.education-level-card').each(function() {
                    var lvl = $(this).data('level');
                    if (visibleLevels.indexOf(lvl) !== -1) {
                        $(this).slideDown(200);
                        $(this).find('input, select, textarea').not('.choosefile[type=file]').prop('disabled', false);
                    } else {
                        $(this).slideUp(200);
                        $(this).find('input, select, textarea').prop('disabled', true);
                    }
                });
            });
            $('.select-education-group').trigger('change');
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

        function upload_files_before_save(fileInput, uploadType, $btn, callback) {
            if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
                callback(null);
                return;
            }

            $btn.html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop('disabled', true);

            let formData = new FormData();
            for (let i = 0; i < fileInput.files.length; i++) {
                formData.append(uploadType + '[]', fileInput.files[i]);
            }
            formData.append('type', uploadType);

            var siteUrl = typeof SITE_URL !== 'undefined' ? SITE_URL : '<?= site_url(); ?>';
            $.ajax({
                url: siteUrl + 'admin/grantee/save_file',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'JSON',
                success: function(response) {
                    if (response && response.status && response.files) {
                        let paths = [];
                        response.files.forEach(function(file) {
                            paths.push(file.filepath);
                        });
                        callback(paths);
                    } else {
                        $btn.html('Save').prop('disabled', false);
                        alert(response && response.message ? response.message : 'Failed to upload your file, please try again');
                    }
                },
                error: function(xhr, status, error) {
                    $btn.html('Save').prop('disabled', false);
                    alert('Failed to upload your file, please try again');
                    console.error(error);
                }
            });
        }

        function open_modal_note_reject(grantee_grant_id, section)
        {
            $("#mdl_note_reject").find('#temp_attachment_reject').val('');
            $("#mdl_note_reject").find('#attachment_reject').val('');
            $("#mdl_note_reject").find('#note_reject').val('');
            $("#mdl_note_reject").find('.uploaded_attachment_admin').addClass('hide').html('');
            $("#btn-save-note").html('Save').prop('disabled', false);
            $("#mdl_note_reject").modal();
            $("#mdl_info").modal('toggle');  
            $("#btn-save-note").attr("onclick", "reject("+ grantee_grant_id +", \'"+ section +"\')"); 
        }

        function open_modal_note_drop(grantee_grant_id, section)
        {
            $("#mdl_note_drop").find('#temp_attachment').val('');
            $("#mdl_note_drop").find('#attachment_drop').val('');
            $("#mdl_note_drop").find('#note_drop').val('');
            $("#mdl_note_drop").find('.uploaded_attachment_admin').addClass('hide').html('');
            $("#btn-save-note-drop").html('Save').prop('disabled', false);
            $("#mdl_note_drop").modal();
            $("#mdl_info").modal('toggle');  
            $("#btn-save-note-drop").attr("onclick", "drop("+ grantee_grant_id +", \'"+ section +"\')"); 
        }

        function open_modal_note_withdraw(grantee_grant_id, section)
        {
            $("#mdl_note_withdraw").find('#temp_attachment_withdraw').val('');
            $("#mdl_note_withdraw").find('#attachment_withdraw').val('');
            $("#mdl_note_withdraw").find('#note_withdraw').val('');
            $("#mdl_note_withdraw").find('.uploaded_attachment_admin').addClass('hide').html('');
            $("#btn-save-note-withdraw").html('Save').prop('disabled', false);
            $("#mdl_note_withdraw").modal();
            $("#mdl_info").modal('toggle');  
            $("#btn-save-note-withdraw").attr("onclick", "withdraw("+ grantee_grant_id +", \'"+ section +"\')"); 
        }

        function reject(grantee_grant_id, section) {
            let $btn = $('#btn-save-note');
            let fileInput = document.getElementById('temp_attachment_reject') || $('#mdl_note_reject').find('input[type="file"]')[0];

            upload_files_before_save(fileInput, 'attachment_reject', $btn, function(paths) {
                $btn.html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop('disabled', true);
                var note = $("#note_reject").val();
                let attachment = paths ? JSON.stringify(paths) : ($("#attachment_reject").val() || $("#attachment_withdraw").val());
                $.ajax({
                    url: "<?= base_url(); ?>admin/"+section+"/reject",
                    method: "POST",
                    dataType: 'JSON',
                    data: {
                        grantee_grant_id: grantee_grant_id,
                        note: note,
                        attachment: attachment,
                    }
                })
                .success(function(data){
                    window.location.href = data.redirect;
                })
                .error(function(){
                    $btn.html('Save').prop('disabled', false);
                    alert('Failed to process request, please try again');
                });
            });
        }

        function drop(grantee_grant_id, section) {
            let $btn = $('#btn-save-note-drop');
            let fileInput = document.getElementById('temp_attachment') || $('#mdl_note_drop').find('input[type="file"]')[0];

            upload_files_before_save(fileInput, 'attachment_drop', $btn, function(paths) {
                $btn.html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop('disabled', true);
                var note = $("#note_drop").val();
                let dataSection = $("#data_section").val();
                let attachment = paths ? JSON.stringify(paths) : $("#attachment_drop").val();
                $.ajax({
                    url: "<?= base_url(); ?>admin/"+section+"/drop",
                    method: "POST",
                    dataType: 'JSON',
                    data: {
                        grantee_grant_id: grantee_grant_id,
                        note: note,
                        data_section: dataSection,
                        attachment: attachment
                    }
                })
                .success(function(data){
                    window.location.href = data.redirect;
                })
                .error(function(){
                    $btn.html('Save').prop('disabled', false);
                    alert('Failed to process request, please try again');
                });
            });
        }

        function withdraw(grantee_grant_id, section) {
            let $btn = $('#btn-save-note-withdraw');
            let fileInput = document.getElementById('temp_attachment_withdraw') || $('#mdl_note_withdraw').find('input[type="file"]')[0];

            upload_files_before_save(fileInput, 'attachment_withdraw', $btn, function(paths) {
                $btn.html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop('disabled', true);
                let note = $("#note_withdraw").val();
                let attachment_withdraw = paths ? JSON.stringify(paths) : $("#attachment_withdraw").val();
                let dataSection = $("#data_section").val();
                $.ajax({
                    url: "<?= base_url(); ?>admin/"+section+"/withdraw",
                    method: "POST",
                    dataType: 'JSON',
                    data: {
                        grantee_grant_id: grantee_grant_id,
                        attachment_withdraw: attachment_withdraw,
                        note: note,
                        data_section: dataSection
                    }
                })
                .success(function(data){
                    window.location.href = data.redirect;
                })
                .error(function(){
                    $btn.html('Save').prop('disabled', false);
                    alert('Failed to process request, please try again');
                });
            });
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
        function show_mdl_confirm_withdraw(id, key) {
            $("#mdl_info").modal();   
            $('#btn-successful').attr("onclick","open_modal_note_withdraw("+ id +", \'"+ key +"\')");  
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
        
        var isReadOnlyEditor = '<?= isset($isReadOnlyEditor) && $isReadOnlyEditor ? 1 : 0 ?>';
        tinymce.init({
            selector: '.editor',
            plugins: 'link table lists',
            toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | link | fontsizeselect | numlist bullist',
            contenteditable: true,
            spellchecker: false,
            readonly: isReadOnlyEditor == 1 ? true : false,
        });

        tinymce.init({
            selector: '.editor-full',
            plugins: 'link table lists',
            toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | link | fontsizeselect | numlist bullist',
            contenteditable: true,
            spellchecker: false,
            readonly: isReadOnlyEditor == 1 ? true : false,
            height: '65vh'
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

        $(document).on('click', '.notification-item, .item-notif', function(e){
            e.preventDefault();

            const notificationId = $(this).data('id');
            const $notificationItem = $(this);
            const BASEURL = '<?php echo base_url() ?>';
            const isAdmin = $(this).data('is_admin') !== undefined ? $(this).data('is_admin') : 1;

            $.ajax({
                url: BASEURL + 'notification/mark_as_read_ajax/' + notificationId + '/' + isAdmin,
                method: 'GET',
                dataType: 'json',
                success: function(response){
                    if(response.status === 'success'){
                        $notificationItem.removeClass('unread');

                        var $badge = $('#notificationCount');
                        if ($badge.length) {
                            var count = parseInt($badge.text());
                            count--;
                            if (count <= 0) {
                                $badge.remove();
                            } else {
                                $badge.text(count);
                            }
                        }

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

        $(document).ready(function(){
            $(document).on("keydown", 'input', function(e) {
                let form = $(this).closest('form');
                if (form.length > 0) {
                    let method = form.attr('method');
                    if (method == 'POST' && e.key == 'Enter') {
                        e.preventDefault();
                    }
                }
            });
        });

        $('#filter-program').on('change', function () {
            setTimeout(function () {
                $('#frm_manage').submit();
            }, 100);
            // let searchbox_program = $('.select2-container--open .select2-search__field');

            // searchbox_program.off('keydown').on('keydown', function (e) {
            //     if (e.key === 'Enter') {
            //         e.preventDefault(); 
            //         let highlighted = $('.select2-results__option--highlighted');
            //         if (highlighted.length) {
            //             highlighted.trigger('mouseup');
            //         }

            //         setTimeout(function () {
            //             $('#frm_manage').submit();
            //         }, 100);
            //     }
            // });
        });
        
        function show_preview_attach(element, type, upload_type) {
            const files = element.files;
            const $modal = $(element).closest('.modal');
            const $preview = $modal.length ? $modal.find('.uploaded_attachment_admin') : $('.uploaded_attachment_admin');

            if (!files || !files.length) {
                $preview.addClass('hide').html('');
                return;
            }

            let html = '';
            for (let i = 0; i < files.length; i++) {
                let file_url = URL.createObjectURL(files[i]);
                html += `
                    <div>
                        <a href="${file_url}" target="_blank">
                            <b><i class="fa fa-paperclip"></i> ${files[i].name}</b>
                        </a>
                    </div>
                `;
            }

            $preview.removeAttr('href').removeAttr('target').removeClass('hide').html(html);
        }

        function render_data_upload_attach(response, upload_type) {
            let html = '';
            let paths = [];
            response.files.forEach(function(file) {
                let file_url = SITE_URL + file.filepath;
                paths.push(file.filepath);

                html += `
                    <div>
                        <a href="${file_url}" target="_blank">
                            <b><i class="fa fa-paperclip"></i> ${file.filename}</b>
                        </a>
                    </div>
                `;
            });

            $(".uploaded_attachment_admin")
                .removeClass('hide')
                .html(html);
            
            $("input[name='" + upload_type + "']").val(JSON.stringify(paths));
        }

        function show_preview_attach_edit(element, type, upload_type) {
            const files = element.files;
            $('#new_attachments_preview').remove();
            if (!files || !files.length) return;

            let html = '<div id="new_attachments_preview" class="mt-2 text-center">';
            for (let i = 0; i < files.length; i++) {
                let file_url = URL.createObjectURL(files[i]);
                html += `
                    <div class="new-att-item mb-1">
                        <a href="${file_url}" target="_blank">
                            <b><i class="fa fa-paperclip"></i> ${files[i].name}</b>
                        </a>
                    </div>
                `;
            }
            html += '</div>';
            $('#old_attachments').after(html);
        }

        $(document).on('click', '.btn-edit-note', function () {

            let id   = $(this).data('id');
            let type = $(this).data('type'); // drop / withdraw

            $('#mdl_edit_note').data('id', id);
            $('#mdl_edit_note').data('type', type);

            $('#note_drop_edit').val('');
            $('.uploaded_attachment').addClass('hide');
            $('#attachment_drop_edit').val('');
            $('#temp_attachment_edit').val('');
            $('#new_attachments_preview').remove();
            $('#btn-save-note-drop-edit').html('Save').prop('disabled', false);

            $.get(SITE_URL + 'admin/grantee/get_note/' + id + '/' + type, function(res){

                if(!res.status) {
                    alert('Failed load data');
                    return;
                }

                $('#note_drop_edit').val(res.note);

                render_old_attachments(res.attachments);

                $('#mdl_edit_note').modal('show');
            },'json');
        });

        function render_old_attachments(files) {

            if(!files || !files.length) return;

            let html = '';
            files.forEach(function(file){
                html += `
                    <div class="att-item mb-1" data-path="${file}">
                        <a href="${SITE_URL + file}" target="_blank">
                            <i class="fa fa-paperclip"></i> ${file.split('/').pop()}
                        </a>
                        <span class="text-danger ml-1 remove-att"><i class="fa fa-trash fa-fw"></i></span>
                    </div>
                `;
            });

            $('#old_attachments').html(html);
            syncAttachments();
        }

        $(document).on('click','.remove-att', function(){
            $(this).closest('.att-item').remove();
            syncAttachments();
        });

        function syncAttachments() {
            let arr = [];
            $('#old_attachments .att-item').each(function(){
                arr.push($(this).data('path'));
            });
            $('#attachment_drop_edit').val(JSON.stringify(arr));
        }

        $('#btn-save-note-drop-edit').on('click', function(){
            let $btn = $(this);
            let id   = $('#mdl_edit_note').data('id');
            let type = $('#mdl_edit_note').data('type');
            let fileInput = document.getElementById('temp_attachment_edit') || $('#mdl_edit_note').find('input[type="file"]')[0];

            upload_files_before_save(fileInput, 'attachment_drop_edit', $btn, function(newPaths) {
                $btn.html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop('disabled', true);

                let existingPaths = [];
                try {
                    existingPaths = JSON.parse($('#attachment_drop_edit').val() || '[]');
                } catch(e) {
                    existingPaths = [];
                }

                if (newPaths && newPaths.length > 0) {
                    existingPaths = existingPaths.concat(newPaths);
                }

                var siteUrl = typeof SITE_URL !== 'undefined' ? SITE_URL : '<?= site_url(); ?>';
                $.ajax({
                    url: siteUrl + 'admin/grantee/update_note',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: id,
                        type: type,
                        note: $('#note_drop_edit').val(),
                        attachment: JSON.stringify(existingPaths)
                    },
                    success: function(res){
                        if(res.status){
                            $('#mdl_edit_note').modal('hide');
                            location.reload(); // atau update row
                        } else {
                            $btn.html('Save').prop('disabled', false);
                            alert('Failed update data');
                        }
                    },
                    error: function(){
                        $btn.html('Save').prop('disabled', false);
                        alert('Failed update data');
                    }
                });
            });
        });

        $('#mdl_note_reject').on('hidden.bs.modal', function () {
            $('#temp_attachment_reject').val('');
            $('#attachment_reject').val('');
            $('#note_reject').val('');
            $(this).find('.uploaded_attachment_admin').addClass('hide').html('');
            $('#btn-save-note').html('Save').prop('disabled', false);
        });

        $('#mdl_note_drop').on('hidden.bs.modal', function () {
            $('#temp_attachment').val('');
            $('#attachment_drop').val('');
            $('#note_drop').val('');
            $(this).find('.uploaded_attachment_admin').addClass('hide').html('');
            $('#btn-save-note-drop').html('Save').prop('disabled', false);
        });

        $('#mdl_note_withdraw').on('hidden.bs.modal', function () {
            $('#temp_attachment_withdraw').val('');
            $('#attachment_withdraw').val('');
            $('#note_withdraw').val('');
            $(this).find('.uploaded_attachment_admin').addClass('hide').html('');
            $('#btn-save-note-withdraw').html('Save').prop('disabled', false);
        });

        $('#mdl_edit_note').on('hidden.bs.modal', function () {
            $('#temp_attachment_edit').val('');
            $('#attachment_drop_edit').val('');
            $('#note_drop_edit').val('');
            $('#new_attachments_preview').remove();
            $('#old_attachments').html('');
            $('#btn-save-note-drop-edit').html('Save').prop('disabled', false);
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
                    if(file){
                        $('#attach_revise').attr('href', SITE_URL + file)
                        $('#attach_revise').removeClass('hide')
                    }else{
                        $('#attach_revise').addClass('hide')
                    }
                });

            // ==== SINGLE FILE ====
            } else {
                if(attach){
                    $('#attach_revise').attr('href', SITE_URL + attach)
                    $('#attach_revise').removeClass('hide')
                }else{
                    $('#attach_revise').addClass('hide')
                }
            }
            // if(attach){
            //     $('#attach_revise').attr('href', SITE_URL + attach)
            //     $('#attach_revise').removeClass('hide')
            // }else{
            //     $('#attach_revise').addClass('hide')
            // }
        })


        function showReason(element) {
            var note = $(element).data('note')
            // var raw = $(element).data('attach')
            var raw  = $(element).attr('data-attach');
            let files = [];

            if (raw) {
                try {
                    files = JSON.parse(raw);
                } catch {
                    raw = raw.replace(/^\[|\]$/g,'').replace(/"/g,'');
                    files = raw.includes(',') ? raw.split(',') : [raw];
                }
            }
            files = Array.isArray(files) ? files : [files];

            let attachHtml = '';

            if (files.length && files[0].trim() !== '') {
                let links = files.map(f => {
                    let file = f.trim();
                    let name = file.split('/').pop();
                    return `<a href="<?= base_url() ?>${file}" target="_blank">${name}</a>`;
                }).join(', ');

                attachHtml = `<div class="mt-2 pull"> ${links}</div>`;
            }
            
            // var url = '';
            // var show = 'd-none';
            // if (attach) {
            //     url = '<?= base_url() ?>' + attach
            //     show = ''
            // }
            Swal.fire({
                title: 'View Note',
                html: `
                    <div>
                        <textarea class="form-control" readonly rows="6" style="resize: none;">`+ note + `</textarea>    
                    </div>
                    ${attachHtml}
                `,
                width: '600px',
                showConfirmButton: false,
                showCancelButton: false,
                cancelButtonText: 'Close',
                customClass: {
                    popup: 'custom-swal-width'
                }
            });
        }

        $(document).on('click', '.btn-copy-period', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');

            Swal.fire({
                title: 'Copy Period?',
                text: 'Are you sure you want to copy this period?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });
        
        window.globalFileValidator = function(input) {
            var activeCountry = <?= $this->session->userdata('active_country') ?? 0 ?>;
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
                const ext = file.name.split('.').pop().toLowerCase();
                if(
                    ['heic', 'heif'].includes(ext) ||
                    [
                        'image/heic',
                        'image/heif',
                        'image/heic-sequence',
                        'image/heif-sequence'
                    ].includes(file.type)

                ){
                    showSwal('error', 'HEIC/HEIF images are not supported. Please convert your file before uploading.', false, true, 2000);
                    input.value = '';
                    return false;
                }
            }
            

            // type
            // if (allowedTypes[0] && !allowedTypes.includes(file.type)) {
            //     showSwal('error', 'File type tidak sesuai', false, true, 2000);
            //     input.value = '';
            //     return false;
            // }

            return true;
        };
        document.addEventListener('change', function(e) {
            const target = e.target;

            if (target.type === 'file') {
                const isValid = window.globalFileValidator(target);

                if (!isValid) {
                    e.stopImmediatePropagation(); // ❗ hentikan semua handler lain
                }
            }
        }, true); // 👈 penting: true = capture phase
        
        $(document).on("click", ".open-offcanvas-note", function(e) {
            e.preventDefault();
            let element = $(this);
            $.ajax({
                url : element.data('ajax_url'),
                type : 'GET',
                dataType : 'JSON',
                data : {
                    fullname: element.data('name'),
                    grantname: element.data('grantname'),
                    period: element.data('period'),
                    category: element.data('category') || ''
                },
                success : function(response) {
                    if (response.success) {
                        $(document).find('#offcanvasNote').html(response.html);
                        $('.lightbox').topbox();
                    }
                }, error : function(response) {
                    console.error(response.responseText);
                }
            })
        });

        $("body").on('submit', '#form-note', function (e) {
            e.preventDefault();
            var form = $(this);
            var submit_btn = form.find('[type="submit"]');

            if (form.find('textarea[name="description"]').val().trim() === '') { 
                e.preventDefault();
                return false;    
            }
            
            
            submit_btn.prop('disabled', true);

            var formData = new FormData(this);

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false, 
                dataType: 'json',
                success: function(response){

                    form.find('textarea[name="description"]').val('');
                    form.find('file[name="attachment_note"]').val('');

                    get_notes(response);
                    show_toast_message(response.message || 'Successfully added note', 'success');

                },
                complete: function(){
                    submit_btn.prop('disabled', false);
                }
            });
        });


        function get_notes(data) {
            $.ajax({
                url : '<?php echo site_url('admin/notes/get_list_ajax/') ?>' + data.section + '/' + data.id + '/' + data.section_id,
                type : 'GET',
                dataType : 'JSON'
            }).done(function (response) {
                $('#offcanvasNote').html(response.html);
                $('.lightbox').topbox();

                var selected_id = response.section_id != 0 ? response.section_id : response.grantee_grant_id;
                

                let currentTotal = parseInt(
                    $('.note-total-' + selected_id).attr('data-total')
                ) || 0;

                let totalNotesNow = currentTotal + 1;

                $('.note-total-' + selected_id)
                    .attr('data-total', totalNotesNow)
                    .html('<span class="badge">' + totalNotesNow + '</span>')
                    .removeClass('hide');
            });
        }

        function delete_note(wrapper, id, grantee_grant_id, section_id) {
            if (confirm("Are you sure want to delete this ?")) {
                $.ajax({
                    url : '<?php echo site_url('admin/notes/delete_note/') ?>' + id,
                    type : 'GET',
                    dataType : 'JSON'
                }).done(function (response) {
                    if (response.success === true || response.success == 'true') {
                        $(wrapper).parents('.note-wrapper').remove();
                        
                        var selected_id = section_id ? section_id : grantee_grant_id;
                        var notesTotal = $('.note-total-' + selected_id);

                        var currentTotal = parseInt(notesTotal.attr('data-total')) || 0;
                        var totalNotesNow = Math.max(0, currentTotal - 1);

                        notesTotal.attr('data-total', totalNotesNow);

                        if (totalNotesNow <= 0) {
                            notesTotal.addClass('hide');
                        } else {
                            notesTotal
                                .html('<span class="badge">' + totalNotesNow + '</span>')
                                .removeClass('hide');
                        }
                        show_toast_message(response.message || 'Successfully deleted note', 'success');
                    }
                });
            }
        }

        function toggle_edit_note(id) {
            var exsis_note = $("body").find('[data-note-description="' + id + '"]').text().trim();
            var description = $("body").find('[data-note-edit-textarea="' + id + '"] textarea').val(exsis_note);

            $("body").find('[data-note-edit-textarea="' + id + '"]').toggleClass('hide');
            $("body").find('[data-note-description="' + id + '"]').toggleClass('hide');
            
        }

        // Global function to edit note
        function edit_note(id) {
            var description = $("body").find('[data-note-edit-textarea="' + id + '"] textarea').val();
            if (description !== '') {
                
                $.ajax({
                    url : '<?php echo site_url('admin/notes/edit_note/') ?>',
                    type : 'POST',
                    dataType : 'JSON',
                    data: {
                        id: id,
                        description: description
                    }
                }).done(function (response) {
                    if (response.success === true || response.success == 'true') {
                        show_toast_message(response.message || 'Successfully edit note', 'success');
                        $("body").find('[data-note-description="' + id + '"]').html(nl2br(description));
                    }
                });
                toggle_edit_note(id);
            }
        }

        function preview_note(input) {
            let fileName = input.files.length
                ? input.files[0].name
                : 'Choose Attachment';
            console.log(fileName)
            $('#attachment_label span').text(fileName);
        };


        $(document).on('click', '.select_pic', function (e) {
            $('#selectpickerPic').val(null);
            var id = $(this).data('grantee_grant_id');
            var selected = $(this).data('selected');
            $("#mdl_pic").modal();
            $('#grantee_grant_id_for_pic').val(id);

            $('#selectpickerPic').val(selected);
            $('#selectpickerPic').selectpicker('refresh');
            event.preventDefault();
        });

        $(document).on('click', '.select-view', function(e){
            e.preventDefault();
            $(".btn-view-pdf").attr('href', $(this).data('pdfurl'));
            $(".btn-view-form-application").attr('href', $(this).data('applicationurl'));
        });


        function show_preview_attachment(element, type, upload_type) {
            show_preview_attach(element, type, upload_type);
        }

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
        
    </script>

</body>

</html>