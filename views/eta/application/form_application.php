<?php if (!isset($is_admin)) { ?>
    <style>
        #page-wrapper {
            padding: 50px !important;
        }

        /* .btn {
            font-size: 18px;
        } */

        .select2 {
            border-radius: 0px !important;
            width: 100% !important;
            height: 35px !important;
            padding-top: 2px !important;
        }

        span.select2.select2-container {
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

        label:not(.btn,.swal2-checkbox) {
            all: unset;      
            all: revert; 
            display: inline-flex !important;   
            align-items: flex-start;
            max-width: 100%;
        }

        label .label-text {
            display: inline-block;
            flex: 0 1 auto;
            min-width: 0;
            word-break: break-word;
        }

        label p {
            padding: 0px;
            margin: 0px;
        }

        label i {
            margin-left: 8px !important;
            margin-top: 3px;
            flex-shrink: 0;
        }

        .ui-tooltip {
            max-width: 1000px;
            width: max-content;
            white-space: normal;
            text-align: left;
            padding: 8px 12px;
            line-height: 1.5;
        }
    </style>
<?php } ?>
<style>
    .text-desc {
        font-size: 18px;
    }

    .form-check .form-check-input {
        float: left;
        margin-left: -1.5em;
    }

    .eta-question-label {
        all: unset;
        all: revert;
        display: inline-flex !important;
        align-items: flex-start;
        max-width: 100%;
    }

    .eta-question-label .label-text {
        display: inline-block;
        flex: 0 1 auto;
        min-width: 0;
        word-break: break-word;
    }

    .eta-question-label .hint-icon {
        margin-left: 8px !important;
        margin-top: 3px;
        flex-shrink: 0;
    }
</style>
<div class="row mt-5">
    <div class="col-lg-12" id="pdf-status-container">
        <?php if (isset($submission_id)) { ?>
            <?php echo get_eta_application_status($submission_id, base_url('eta/application/pdf/' . $submission_id)); ?>
        <?php } ?>
    </div>
    <div class="col-lg-12">
        <?php if ($this->session->flashdata('error_submit_panel')) { ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?= $this->session->flashdata('error_submit_panel') ?>
            </div>
            <?php $this->session->unset_userdata('error_submit_panel'); ?>
        <?php } ?>
        <?php if ($this->session->flashdata('success_submit_panel')) { ?>
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?= $this->session->flashdata('success_submit_panel') ?>
            </div>
            <?php $this->session->unset_userdata('success_submit_panel'); ?>
        <?php } ?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <h1 class="text-primary"><?= $data_form->title ?></h1>
                <div class="text-desc" style="border-bottom: 1px solid #ddd;"><?= $data_form->description ?></div>
            </div>
            <input type="hidden" value="<?= $data_form->id ?>" name="eta_host_school_application_id">
            <?php if (!empty($submission_id)) { ?>
                <input type="hidden" value="<?= $submission_id ?>" name="submission_id">
            <?php } ?>
            <?php
            if (!function_exists('format_field_label')) {
                function format_field_label($name) {
                    if (empty($name)) return '';
                    $text = trim($name);
                    $text = preg_replace('/<\/(p|div)>\s*<(p|div)[^>]*>/i', '<br>', $text);
                    $text = preg_replace('/^<(p|div)[^>]*>/i', '', $text);
                    $text = preg_replace('/<\/(p|div)>$/i', '', $text);
                    $text = nl2br($text);
                    return $text;
                }
            }
            foreach ($data as $key => $row) {
                $value_other = isset($data_submission['other_' . $row->id]) ? $data_submission['other_' . $row->id] : '';
                ?>
                <div class="form-group">
                    <label class="eta-question-label">
                        <span class="label-text">
                            <?= format_field_label($row->name) ?> <?= $row->is_required ? '<small class="text-danger">*</small>' : '' ?>
                        </span>
                        <?php if (isset($row->hint) && $row->hint) : ?>
                            <i class="fa fa-info-circle mrl text-danger hint-icon" data-toggle="tooltip" data-placement="top" title="<?= htmlspecialchars($row->hint, ENT_QUOTES) ?>" style="cursor:pointer"></i>
                        <?php endif; ?>
                    </label>
                    <?= render_component_form_panellists(
                        $row,
                        (isset($_POST[$row->id]) ? $_POST[$row->id] : (isset($data_submission[$row->id]) ? $data_submission[$row->id] : '')),
                        isset($is_preview) || (isset($status) && $status == 1) ? 'disabled' : '',
                        $value_other
                    ) ?>
                </div>
            <?php } ?>

            <?php if (!isset($is_preview) && (!isset($status) || $status != 1)) { ?>
                <hr />
                <div class="form-group">
                    <button id="btn-submit" class="btn btn-success">Kirim Pengajuan</button>
                </div>
            <?php } ?>
        </form>
    </div>
</div>

<div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="height: 95vh; margin: 1.5vh auto;">
        <div class="modal-content" style="height: 100%;">
            <div class="modal-header">
                <h4 class="modal-title" id="pdfModalLabel">Pratinjau Pengajuan</h4>
                <a id="downloadPdfBtn" href="#" download class="btn btn-danger btn-xs pull-right hide"><i class="fa fa-file-pdf-o"></i> Unduh PDF</a>
            </div>
            <div class="modal-body" style="height: calc(100% - 50px); padding: 0;">
                <iframe id="pdfViewer" src="" style="width: 100%; height: 100%; border: none;"></iframe>
            </div>
        </div>
    </div>
</div></div>
