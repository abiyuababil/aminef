<!-- <div class="alert alert-info">
    <i class="fa fa-info-circle"></i> <strong>Self Arrangement</strong> - You arrange your own flights and submit flight
    proposals for approval. After your trip, you can submit receipts and tickets for reimbursement.
</div> -->
<style>
    #flight-option-view-modal .modal-dialog,
    #flight-option-modal .modal-dialog {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        margin: 0;
        width: 600px;
        max-width: calc(100% - 30px);
    }
    /* #international-upload-container,
    #domestic-upload-container,
    #other-upload-container {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        align-items: stretch;
    } */
    /* #international-flight-section .flight-option-item,
    #domestic-flight-section .flight-option-item,
    #other-flight-section .flight-option-item {
        background: #fff;
        border: 1px solid #dfe7ef;
        border-radius: 6px;
        border-left-width: 1px;
        box-shadow: none;
        transform: none;
        width: calc((100% - 32px) / 3);
        min-width: 0;
        margin-bottom: 0;
        display: flex;
        align-items: stretch;
    } */
    #international-flight-section .flight-option-item > .form-group,
    #domestic-flight-section .flight-option-item > .form-group,
    #other-flight-section .flight-option-item > .form-group,
    #accommodation-flight-section .flight-option-item > .form-group {
        width: 100%;
        display: flex;
        flex-direction: column;
        padding: 14px;
    }
    #international-flight-section .flight-option-preview,
    #domestic-flight-section .flight-option-preview,
    #other-flight-section .flight-option-preview,
    #accommodation-flight-section .flight-option-preview {
        margin-top: auto;
    }
    /* @media (max-width: 991px) {
        #international-flight-section .flight-option-item,
        #domestic-flight-section .flight-option-item,
        #other-flight-section .flight-option-item {
            width: calc((100% - 16px) / 2);
        }
    }
    @media (max-width: 767px) {
        #international-flight-section .flight-option-item,
        #domestic-flight-section .flight-option-item,
        #other-flight-section .flight-option-item {
            width: 100%;
        }
    } */
    #international-flight-section .flight-option-item:hover,
    #domestic-flight-section .flight-option-item:hover,
    #other-flight-section .flight-option-item:hover,
    #accommodation-flight-section .flight-option-item:hover {
        box-shadow: none;
        transform: none;
    }
    #international-flight-section .flight-option-summary,
    #domestic-flight-section .flight-option-summary,
    #other-flight-section .flight-option-summary,
    #accommodation-flight-section .flight-option-summary {
        background: transparent;
        border: 0;
        border-radius: 0;
        padding: 0;
        margin-top: 0;
    }
    #international-flight-section .flight-option-price-text,
    #domestic-flight-section .flight-option-price-text,
    #other-flight-section .flight-option-price-text,
    #accommodation-flight-section .flight-option-price-text {
        font-weight: 400;
        color: #0e6ba8;
    }
    #international-flight-section .flight-option-description-text,
    #domestic-flight-section .flight-option-description-text,
    #other-flight-section .flight-option-description-text,
    #accommodation-flight-section .flight-option-description-text {
        display: block;
        margin-top: 0;
        margin-bottom: 10px;
        padding-left: 10px;
        border-left: 3px solid #dfe7ef;
        color: #4f5f6f;
        font-weight: 400;
        white-space: pre-wrap;
    }
    #international-flight-section .flight-option-description-text.is-clamped,
    #domestic-flight-section .flight-option-description-text.is-clamped,
    #other-flight-section .flight-option-description-text.is-clamped,
    #accommodation-flight-section .flight-option-description-text.is-clamped {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;
        white-space: normal;
    }
    #international-flight-section .flight-option-description-toggle,
    #domestic-flight-section .flight-option-description-toggle,
    #other-flight-section .flight-option-description-toggle,
    #accommodation-flight-section .flight-option-description-toggle {
        display: none;
        margin-top: -4px;
        margin-bottom: 10px;
        padding: 0;
        border: 0;
        background: transparent;
        color: #0e6ba8;
        font-size: 12px;
        font-weight: 400;
        text-decoration: underline;
    }
    #international-flight-section .flight-option-description-toggle:hover,
    #international-flight-section .flight-option-description-toggle:focus,
    #domestic-flight-section .flight-option-description-toggle:hover,
    #domestic-flight-section .flight-option-description-toggle:focus,
    #other-flight-section .flight-option-description-toggle:hover,
    #other-flight-section .flight-option-description-toggle:focus,
    #accommodation-flight-section .flight-option-description-toggle:hover,
    #accommodation-flight-section .flight-option-description-toggle:focus {
        color: #0a537f;
        outline: none;
    }
    #international-flight-section .flight-option-item.is-selected,
    #domestic-flight-section .flight-option-item.is-selected,
    #other-flight-section .flight-option-item.is-selected,
    #accommodation-flight-section .flight-option-item.is-selected {
        background: #edf9f0;
        border-color: #28a745;
        /* box-shadow: inset 0 0 0 1px #b9e3c4; */
    }
    #international-flight-section .flight-option-item.is-selected .flight-option-price-text,
    #domestic-flight-section .flight-option-item.is-selected .flight-option-price-text,
    #other-flight-section .flight-option-item.is-selected .flight-option-price-text,
    #accommodation-flight-section .flight-option-item.is-selected .flight-option-price-text {
        color: #1f7a34;
    }
    #international-flight-section .flight-option-item.is-selected .flight-option-description-text,
    #domestic-flight-section .flight-option-item.is-selected .flight-option-description-text,
    #other-flight-section .flight-option-item.is-selected .flight-option-description-text,
    #accommodation-flight-section .flight-option-item.is-selected .flight-option-description-text {
        color: #4f5f6f;
        border-left-color: #7bc48d;
    }
    #international-flight-section .flight-option-item.is-selected .flight-option-selected-note,
    #domestic-flight-section .flight-option-item.is-selected .flight-option-selected-note,
    #other-flight-section .flight-option-item.is-selected .flight-option-selected-note,
    #accommodation-flight-section .flight-option-item.is-selected .flight-option-selected-note {
        color: #1f7a34;
        background: transparent;
        border: 0;
        padding: 0;
        border-radius: 0;
    }
    #international-flight-section .flight-option-header-main,
    #domestic-flight-section .flight-option-header-main,
    #other-flight-section .flight-option-header-main,
    #accommodation-flight-section .flight-option-header-main {
        display: flex;
        align-items: baseline;
        gap: 6px;
        flex-wrap: wrap;
    }
    #international-flight-section .flight-option-header-main label,
    #domestic-flight-section .flight-option-header-main label,
    #other-flight-section .flight-option-header-main label,
    #accommodation-flight-section .flight-option-header-main label {
        display: inline-flex;
        align-items: center;
        line-height: 20px;
    }
    #international-flight-section .flight-option-header,
    #domestic-flight-section .flight-option-header,
    #other-flight-section .flight-option-header,
    #accommodation-flight-section .flight-option-header {
        margin-bottom: 6px;
    }
    #international-flight-section .flight-option-selected-note,
    #domestic-flight-section .flight-option-selected-note,
    #other-flight-section .flight-option-selected-note,
    #accommodation-flight-section .flight-option-selected-note {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        line-height: 20px;
    }

    /* Type Selector */
    .type-selector-box {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 16px;
        border-radius: 6px;
        margin-bottom: 20px;
        transition: border-color 0.2s ease;
    }
    .type-selector-box.validation-error {
        border: 1px solid #ef4444;
        box-shadow: 0 0 0 1px #ef4444;
    }
    .type-selector-title {
        font-size: 13px;
        font-weight: bold;
        color: #475569;
        margin-bottom: 10px;
    }


    /* Dynamic Options Block (Hidden by default) */
    .category-block {
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        overflow: hidden;
        background: #fff;
        margin-bottom: 20px;
    }
    .category-header {
        background-color: #f8fafc;
        padding: 12px 16px;
        font-size: 14px;
        font-weight: bold;
        color: #1e293b;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .btn-add-item {
        background-color: #ffffff;
        border: 1px solid #cbd5e1;
        color: #17425f;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-add-item:hover { background-color: #f1f5f9; }

    .category-block table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .category-block th, .category-block td { padding: 12px 16px; border-bottom: 1px solid #e2e8f0; text-align: left; }
    .category-block th { background-color: #ffffff; color: #64748b; font-weight: 600; font-size: 12px; }
    .category-block tr:last-child td { border-bottom: none; }
    .price-text { font-weight: bold; color: #1e293b; }
    .doc-link { color: #2563eb; text-decoration: none; font-weight: 500; }
    .btn-remove { background: none; border: none; color: #ef4444; cursor: pointer; font-weight: bold; }
    .category-block tbody tr.option-row { cursor: pointer; }
    .category-block tr.option-row.is-selected { background-color: #f0fdf4; }
</style>
<div class="mb-4 text-right">
    <?= !empty($current_status) && $attachments ? format_status_travel_arrangement_non_eta($current_status, $application->type ?? null) : ''; ?>
</div>

<div class="row mb-3">
    <div class="col-lg-12">
        <div class="panel-body">
            <div class="form-group">
                <label><strong>Travel Purpose <span class="text-danger">*</span></strong></label>
                <?php if(isset($current_status) && $current_status != TRAVEL_ARRANGEMENT_NON_ETA_STATUS_DRAFT) : ?>
                    <div>
                        <?= isset($application) && $application->travel_purposes ? html_escape($application->travel_purposes) : '' ?>
                        <input type="hidden" id="travel_purposes" name="travel_purposes" value="<?= html_escape($application->travel_purposes) ?>">
                        <?php if (!empty($application->travel_purposes) && in_array(strtolower(trim($application->travel_purposes)), ['other', 'others'], true) && !empty($application->travel_purposes_other)): ?>
                            <div style="margin-top: 6px; padding: 10px 14px; background: #f8fafc; border: 1px solid #e2e8f0; border-left: 3px solid #0e6ba8; border-radius: 4px;">
                                <strong>Other Purpose:</strong>
                                <div style="margin-top: 4px;"><?= nl2br(html_escape($application->travel_purposes_other)) ?></div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else : ?>
                    <select class="form-control select2" data-live-search="true" id="travel_purposes" name="travel_purposes" required <?= isset($current_status) && $current_status != TRAVEL_ARRANGEMENT_NON_ETA_STATUS_DRAFT ? 'disabled' : '' ?>>
                        <option></option>
                        <?php 
                            foreach(get_all_db('am_travel_purpose', ['is_active' => true]) as $travel_purpose) : 
                            $selected = '';
                            if ($travel_purpose->name == $application->travel_purposes) {
                                $selected = 'selected="selected"';
                            }
                        ?>
                            <option <?= $selected ?> value="<?= $travel_purpose->name ?>"><?= $travel_purpose->name ?></option>
                        <?php  endforeach;?>
                    </select>
                <?php endif; ?>
            </div>
            <?php 
                $is_other_selected = isset($application) && in_array(strtolower(trim((string)$application->travel_purposes)), ['other', 'others'], true);
                $is_draft = !isset($current_status) || $current_status == TRAVEL_ARRANGEMENT_NON_ETA_STATUS_DRAFT;
            ?>
            <div class="form-group" id="wrapper_travel_purposes_other" style="<?= ($is_other_selected && $is_draft) ? '' : 'display: none;' ?>">
                <label for="travel_purposes_other"><strong>Please Specify Travel Purpose <span class="text-danger">*</span></strong></label>
                <input type="text" id="travel_purposes_other" name="travel_purposes_other" class="form-control" placeholder="Please describe the purpose of your travel and any relevant details." <?= $is_draft ? '' : 'disabled' ?> value="<?= isset($application) && $application->travel_purposes_other ? html_escape($application->travel_purposes_other) : '' ?>">
                <!-- <textarea id="travel_purposes_other" name="travel_purposes_other" class="form-control editor" rows="4" placeholder="Please describe the purpose of your travel and any relevant details." <?php //$is_draft ? '' : 'disabled' ?>><?php //isset($application) && $application->travel_purposes_other ? html_escape($application->travel_purposes_other) : '' ?></textarea> -->
            </div>
        </div>
    </div>
</div>
<?php

$international_attachments = [];
$domestic_attachments = [];
$other_attachments = [];
$accommodation_attachments = [];
$receipt_attachments = [];
if (isset($attachments) && is_array($attachments)) {
    foreach ($attachments as $att) {
        $international_attachments = array_filter($attachments, function ($a) {
            return $a->ref_type == 'flight_proposal_international';
        });

        $domestic_attachments = array_filter($attachments, function ($a) {
            return $a->ref_type == 'flight_proposal_domestic';
        });

        $other_attachments = array_filter($attachments, function ($a) {
            return $a->ref_type == 'flight_proposal_other';
        });

        $accommodation_attachments = array_filter($attachments, function ($a) {
            return $a->ref_type == 'flight_proposal_accommodation';
        });

        $receipt_attachments = array_values(array_filter($attachments, function ($a) {
            return $a->ref_type == 'flight_reimbursement_request_receipt_and_ticket';
        }));
    }
}

$can_edit_flight_proposal = isset($current_status) && in_array($current_status, [TRAVEL_ARRANGEMENT_NON_ETA_STATUS_DRAFT, TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_DECLINED]);

$can_edit_flight_reimbursment = isset($current_status) && in_array($current_status, [TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_APPROVED, TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_TICKET_SENT]);

if (!function_exists('render_travel_flight_option_groups')) {
    function render_travel_flight_option_groups($type, $attachments, $can_edit)
    {
        $has_attachments = !empty($attachments);
        $rows = $has_attachments ? array_values($attachments) : [];

        foreach ($rows as $idx => $att) {
            $i = $idx + 1;
            $option_name = $type . '_option_' . $i;
            $title = $att && isset($att->title) ? $att->title : '';
            $description = $att && isset($att->description) ? $att->description : '';
            $price = $att && isset($att->price) ? $att->price : '';
            $currency = $att && isset($att->currency) ? strtoupper(trim($att->currency)) : 'USD';
            if (!in_array($currency, ['IDR', 'USD'], true)) {
                $currency = 'USD';
            }
            $formatted_price = null;
            if ($price !== '' && $price !== null) {
                $normalized_price = function_exists('unformat_money') ? unformat_money($price, $currency) : (is_numeric($price) ? (float)$price : null);
                if ($normalized_price !== null) {
                    $formatted_price = function_exists('format_money')
                        ? format_money($normalized_price, $currency)
                        : number_format($normalized_price, 2);
                }
            }
            $attachment_id = $att && isset($att->id) ? (int)$att->id : 0;
            $attachment_file_name = $att && isset($att->file_name) ? $att->file_name : '';
            $is_selected_class = ($att && isset($att->is_selected) && $att->is_selected) ? 'is-selected' : '';
            $has_file = $att && isset($att->file_path) && $att->file_path;
            $preview_url = $has_file
                ? base_url(preg_match('/\.(jpg|jpeg|png)$/i', $att->file_path) ? $att->file_path : 'assets/images/icons/pdf.svg')
                : base_url('assets/images/icons/add-file.png');
            $file_url = $has_file ? base_url($att->file_path) : '';
            ?>
            <div class="upload-group flight-option-item <?= $is_selected_class ?>" data-index="<?= $i ?>" data-type="<?= $type ?>">
                <div class="form-group" style="position:relative; margin-bottom:0;">
                    <div class="flight-option-header">
                        <div class="flight-option-header-main">
                            <label id="label-<?= $option_name ?>"><strong>Option <?= $i ?></strong></label>
                            <?php if ($att && isset($att->is_selected) && $att->is_selected): ?>
                                <span class="flight-option-selected-note">
                                    <i class="fa fa-check-circle"></i> Selected
                                </span>
                            <?php endif; ?>
                        </div>
                        <?php if ($can_edit): ?>
                            <div class="flight-option-actions">
                                <button type="button" class="btn btn-info btn-xs edit-flight-option"><i class="fa fa-pencil"></i> Edit</button>
                                <button class="btn btn-danger btn-xs remove-option" type="button"><i class="fa fa-trash"></i> Remove</button>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="flight-option-summary">
                        <span class="flight-option-description-text <?= $description ? 'is-clamped' : 'hide' ?>"><?= $description ? nl2br(html_escape($description)) : '' ?></span>
                        <button type="button" class="flight-option-description-toggle">Read more</button>
                        <div class="flight-option-summary-row">
                            <span class="flight-option-price-text"><?= $formatted_price ? html_escape($formatted_price) : '<span class="text-muted">-</span>' ?></span>
                        </div>
                    </div>

                    <div class="flight-option-preview">
                        <a href="<?= $file_url ? $file_url : '#' ?>" id="preview_link_<?= $option_name ?>" <?= $can_edit ? '' : 'class="lightbox"' ?> aria-haspopup="dialog">
                            <img id="preview_image_<?= $option_name ?>" class="flight-option-thumb" src="<?= $preview_url ?>" width="100" style="min-height:60px;object-fit:contain;">
                        </a>
                        <a href="<?= $file_url ? $file_url : '#' ?>" id="button_download_<?= $option_name ?>" download class="btn btn-primary btn-xs <?= $has_file ? '' : 'hide' ?> flight-option-download-btn">
                            <i class="fa fa-download fa-fw"></i>
                        </a>
                    </div>

                    <input type="hidden" name="<?= $type ?>_option_id_<?= $i ?>" class="flight-option-id" value="<?= $attachment_id ?>">
                    <input type="hidden" name="<?= $type ?>_title_<?= $i ?>" class="flight-option-title" value="<?= html_escape($title) ?>">
                    <input type="hidden" name="<?= $type ?>_description_<?= $i ?>" class="flight-option-description" value="<?= html_escape($description) ?>">
                    <input type="hidden" name="<?= $type ?>_price_<?= $i ?>" class="flight-option-price" value="<?= html_escape($price) ?>">
                    <input type="hidden" name="<?= $type ?>_currency_<?= $i ?>" class="flight-option-currency" value="<?= html_escape($currency) ?>">
                    <input type="hidden" class="flight-option-existing-file-name" value="<?= html_escape($attachment_file_name) ?>">

                    <input type="file" class="custom-file-input hide" name="<?= $option_name ?>" id="file_<?= $option_name ?>" accept=".pdf,.jpg,.jpeg,.png">
                </div>
            </div>
            <?php
        }
    }
}

if (!function_exists('render_row_travel_flight_option_groups')) {
    function render_row_travel_flight_option_groups($type, $attachments, $can_edit)
    {
        $has_attachments = !empty($attachments);
        $rows = $has_attachments ? array_values($attachments) : [];
        $displayDescription = $type === 'accommodation' || $type === 'other' ? 'hide' : '';

        if($rows){
            foreach ($rows as $idx => $att) {
                $i = $idx + 1;
                $option_name = $type . '_option_' . $i;
                $title = $att && isset($att->title) ? $att->title : '';
                $description = $att && isset($att->description) ? $att->description : '';
                $price = $att && isset($att->price) ? $att->price : '';
                $currency = $att && isset($att->currency) ? strtoupper(trim($att->currency)) : 'USD';
                if (!in_array($currency, ['IDR', 'USD'], true)) {
                    $currency = 'USD';
                }
                $formatted_price = null;
                if ($price !== '' && $price !== null) {
                    $normalized_price = function_exists('unformat_money') ? unformat_money($price, $currency) : (is_numeric($price) ? (float)$price : null);
                    if ($normalized_price !== null) {
                        $formatted_price = function_exists('format_money')
                            ? format_money($normalized_price, $currency)
                            : number_format($normalized_price, 2);
                    }
                }
                $attachment_id = $att && isset($att->id) ? (int)$att->id : 0;
                $is_selected_class = ($att && isset($att->is_selected) && $att->is_selected) ? 'is-selected' : '';
                $files = function_exists('parse_flight_option_files') ? parse_flight_option_files($att) : [];
                $has_files = !empty($files);
                $file_names_str = implode(', ', array_column($files, 'file_name'));
                ?>
    
                <tr class="option-row upload-group flight-option-item <?= $is_selected_class ?>" data-index="<?= $i ?>" data-type="<?= $type ?>">
                    <td class="<?= $displayDescription ?>"><span class="flight-option-description-text <?= $description ? 'is-clamped' : 'hide' ?>"><?= $description ? nl2br(html_escape($description)) : '' ?></span></td>
                    <td><span class="flight-option-price-text"><?= $formatted_price ? html_escape($formatted_price) : '<span class="text-muted">-</span>' ?></span></td>
                    <td class="flight-option-attachments-cell">
                        <div class="flight-option-files-list" style="display:flex; flex-direction:column; gap:6px;">
                            <?php if ($has_files): ?>
                                <?php foreach ($files as $f_idx => $file): 
                                    $f_url = base_url($file['file_path']);
                                    $f_name = !empty($file['file_name']) ? $file['file_name'] : file_name($f_url);
                                    $is_img = preg_match('/\.(jpg|jpeg|png)$/i', $file['file_path']);
                                    $is_pdf = preg_match('/\.pdf$/i', $file['file_path']);
                                    $icon = $is_pdf ? 'fa-file-pdf-o text-danger' : ($is_img ? 'fa-file-image-o text-primary' : 'fa-file-o text-muted');
                                ?>
                                    <div class="flight-option-file-badge" style="display:inline-flex; align-items:center; gap:6px;">
                                        <a href="<?= $f_url ?>" <?= $can_edit ? '' : 'class="lightbox"' ?> aria-haspopup="dialog" target="_blank" style="font-size:12px; color:#0e6ba8; word-break:break-all;">
                                            <i class="fa <?= $icon ?>"></i> <?= html_escape($f_name) ?>
                                        </a>
                                        <a href="<?= $f_url ?>" download class="btn btn-primary btn-xs" style="padding:1px 5px;" title="Download">
                                            <i class="fa fa-download fa-fw"></i>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span class="text-muted" style="font-size:12px;">No file selected</span>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <?php if ($att && isset($att->is_selected) && $att->is_selected): ?>
                            <span class="flight-option-selected-note">
                                <i class="fa fa-check-circle"></i> Selected
                            </span>
                        <?php endif; ?>
                        <?php if ($can_edit): ?>
                            <button type="button" class="btn btn-info btn-xs edit-flight-option"><i class="fa fa-pencil"></i></button>
                            <button class="btn btn-danger btn-xs remove-option" type="button"><i class="fa fa-trash"></i></button>
                        <?php endif; ?>
    
                        <input type="hidden" name="<?= $type ?>_option_id_<?= $i ?>" class="flight-option-id" value="<?= $attachment_id ?>">
                        <input type="hidden" name="<?= $type ?>_title_<?= $i ?>" class="flight-option-title" value="<?= html_escape($title) ?>">
                        <input type="hidden" name="<?= $type ?>_description_<?= $i ?>" class="flight-option-description" value="<?= html_escape($description) ?>">
                        <input type="hidden" name="<?= $type ?>_price_<?= $i ?>" class="flight-option-price" value="<?= html_escape($price) ?>">
                        <input type="hidden" name="<?= $type ?>_currency_<?= $i ?>" class="flight-option-currency" value="<?= html_escape($currency) ?>">
                        <input type="hidden" name="<?= $type ?>_existing_files_<?= $i ?>" class="flight-option-existing-files" value="<?= html_escape(json_encode($files)) ?>">
                        <input type="hidden" class="flight-option-existing-file-name" value="<?= html_escape($file_names_str) ?>">
    
                        <input type="file" class="custom-file-input hide" name="<?= $option_name ?>[]" id="file_<?= $option_name ?>" accept=".pdf,.jpg,.jpeg,.png" multiple>
                    </td>
                </tr>
                <?php
            }
        }else{
            echo '
            <tr class="tr-empty">
                <td colspan="5" style="text-align:center; color:#94a3b8; font-style:italic; padding:20px;">
                    No options added yet. Click "+ Add Option" above.
                </td>
            </tr>';
        }

    }
}

?>

<div class="panel-group" id="accordion-self" role="tablist" aria-multiselectable="true">

    <div class="panel panel-default">
        <div class="panel-heading text-left" role="tab" id="headingFlightProposal">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion-self" href="#collapseFlightProposal"
                    aria-expanded="true" aria-controls="collapseFlightProposal">
                    Travel Proposal <span style="float:right;margin-left:20px;"><i class="fa fa-chevron-down"
                            aria-hidden="true"></i></span>
                </a>
            </h4>
        </div>
        <div id="collapseFlightProposal" class="panel-collapse collapse <?php echo ($current_status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_APPROVED || $current_status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_TICKET_SENT) ? '' : 'in'; ?>" role="tabpanel"
            aria-labelledby="headingFlightProposal" aria-expanded="<?php echo ($current_status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_APPROVED || $current_status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_TICKET_SENT) ? 'false' : 'true'; ?>">
            <div class="panel-body">
                <?php if (in_array($current_status, [TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_APPROVED, TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_REIMBURSEMENT_SUBMITTED, TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_TICKET_SENT])) { ?>
                    <div class="alert alert-success">
                        <i class="fa fa-check-circle"></i> Your flight proposal has been approved. Below are the selected international and domestic flights.
                    </div>
                <?php } ?>
                <form id="form-flight-proposal" method="POST" enctype="multipart/form-data" novalidate>
                    <input type="hidden" name="form_type" value="flight_proposal">
                    <input type="hidden" name="application_id" value="<?= isset($id) ? $id : '' ?>">
                    <input type="hidden" name="grantee_grant_id" value="<?= $grantee_grant->id ?>">
                    <?php if($application->status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_DECLINED) { ?>
                        <div class="alert alert-danger">
                            <i class="fa fa-info-circle"></i> <strong>Note Revision</strong> : <br /> <?= $application->note ?>
                        </div>
                    <?php } ?>
                    
                    <?php if ($can_edit_flight_proposal): ?>
                    <div class="type-selector-box" id="typeSelectorBox">
                        <label>Select Travel</label>
                        <div class="radio-group">
                            <label class="radio-inline">
                                <input type="radio" class="type_flight" name="type_flight" value="International" <?php echo $application->type_flight == 'International' ? 'checked' : '' ?> required>
                                International Flight
                            </label>
                            <label class="radio-inline">
                                <input type="radio" class="type_flight" name="type_flight" value="Domestic" <?php echo $application->type_flight == 'Domestic' ? 'checked' : '' ?> required>
                                Domestic Flight
                            </label>
                            <label class="radio-inline">
                                <input type="radio" class="type_flight" name="type_flight" value="Other" <?php echo $application->type_flight == 'Other' ? 'checked' : '' ?> required>
                                Other Transportation (Bus, Train, Etc)
                            </label>
                            <label class="radio-inline">
                                <input type="radio" class="type_flight" name="type_flight" value="Accommodation" <?php echo $application->type_flight == 'Accommodation' ? 'checked' : '' ?> required>
                                Accommodation
                            </label>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div style="padding:0px !important;" class="flight-section <?= $application->type_flight == 'International' ? '' : 'hidden' ?>" id="international-flight-section">
                        <div class="category-block" id="categoryBlock">
                            <div class="category-header">
                                <span>International Flight</span>
                                <?php if ($can_edit_flight_proposal): ?>
                                    <button type="button" class="btn-add-item add-option" data-type="international">
                                        <i class="fa fa-plus"></i> Add Flight Option
                                    </button>
                                <?php endif; ?>
                            </div>
                            <div style="overflow-x: auto;">
                                <table>
                                    <thead>
                                        <tr>
                                            <th style="width: 160px;">Description</th>
                                            <th style="width: 140px;">Price</th>
                                            <th style="width: 160px;">Attachment</th>
                                            <th style="width: 80px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="upload-container" id="international-upload-container">
                                        <?php render_row_travel_flight_option_groups('international', $international_attachments, $can_edit_flight_proposal); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div style="padding:0px !important;" class="flight-section <?= $application->type_flight == 'Domestic' ? '' : 'hidden' ?>" id="domestic-flight-section">
                        <div class="category-block" id="categoryBlock">
                            <div class="category-header">
                                <span>Domestic Flight</span>
                                <?php if ($can_edit_flight_proposal): ?>
                                    <button type="button" class="btn-add-item add-option" data-type="domestic">
                                        <i class="fa fa-plus"></i> Add Flight Option
                                    </button>
                                <?php endif; ?>
                            </div>
                            <div style="overflow-x: auto;">
                                <table>
                                    <thead>
                                        <tr>
                                            <th style="width: 160px;">Description</th>
                                            <th style="width: 140px;">Price</th>
                                            <th style="width: 160px;">Attachment</th>
                                            <th style="width: 80px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="upload-container" id="domestic-upload-container">
                                        <?php render_row_travel_flight_option_groups('domestic', $domestic_attachments, $can_edit_flight_proposal); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div style="padding:0px !important;" class="flight-section <?= $application->type_flight == 'Accommodation' ? '' : 'hidden' ?>" id="accommodation-flight-section">
                        <div class="category-block" id="categoryBlock">
                            <div class="category-header">
                                <span>Accommodation</span>
                                <?php if ($can_edit_flight_proposal): ?>
                                    <button type="button" class="btn-add-item add-option" data-type="accommodation">
                                        <i class="fa fa-plus"></i> Add Option
                                    </button>
                                <?php endif; ?>
                            </div>
                            <div style="overflow-x: auto;">
                                <table>
                                    <thead>
                                        <tr>
                                            <!-- <th style="width: 160px;">Accommodation Detail</th> -->
                                            <th style="width: 140px;">Price</th>
                                            <th style="width: 160px;">Attachment</th>
                                            <th style="width: 80px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="upload-container" id="accommodation-upload-container">
                                        <?php render_row_travel_flight_option_groups('accommodation', $accommodation_attachments, $can_edit_flight_proposal); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div style="padding:0px !important;" class="flight-section <?= $application->type_flight == 'Other' ? '' : 'hidden' ?>" id="other-flight-section">
                        <div class="category-block" id="categoryBlock">
                            <div class="category-header">
                                <span>Other Transportation (Bus, Train, Etc)</span>
                                <?php if ($can_edit_flight_proposal): ?>
                                    <button type="button" class="btn-add-item add-option" data-type="other">
                                        <i class="fa fa-plus"></i> Add Option
                                    </button>
                                <?php endif; ?>
                            </div>
                            <div style="overflow-x: auto;">
                                <table>
                                    <thead>
                                        <tr>
                                            <!-- <th style="width: 160px;">Description</th> -->
                                            <th style="width: 140px;">Price</th>
                                            <th style="width: 160px;">Attachment</th>
                                            <th style="width: 80px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="upload-container" id="other-upload-container">
                                        <?php render_row_travel_flight_option_groups('other', $other_attachments, $can_edit_flight_proposal); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="flight-option-modal" tabindex="-1" role="dialog" aria-labelledby="flightOptionModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="flightOptionModalLabel">Travel Option</h4>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="flight-option-modal-type" value="">
                                    <input type="hidden" id="flight-option-modal-index" value="">

                                    <div class="form-group" id="fg-description">
                                        <label id="label-description" for="flight-option-description">Description <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="flight-option-description" rows="4" placeholder="Travel details, transit, baggage, and notes"></textarea>
                                    </div>
                                    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 12px;">
                                        <div class="form-group">
                                            <label for="flight-option-currency">Currency <span class="text-danger">*</span></label>
                                            <select class="form-control" id="flight-option-currency">
                                                <option value="IDR">IDR</option>
                                                <option value="USD" selected>USD</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="flight-option-price">Price <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="flight-option-price" placeholder="e.g. 1250 or 1250.00">
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom:0;">
                                        <label>Attachments <span class="text-danger">*</span></label>
                                        <div>
                                            <input type="file" id="flight-option-modal-file-input" multiple accept=".pdf,.jpg,.jpeg,.png" class="hide">
                                            <button type="button" class="btn btn-primary btn-sm" id="flight-option-file-btn"><i class="fa fa-upload"></i> Choose file(s)</button>
                                            <span id="flight-option-file-count" class="text-muted" style="margin-left:10px;">No file selected</span>
                                        </div>
                                        <small class="text-muted">Supported format: PDF, JPG, JPEG, PNG (You can upload more than 1 file)</small>

                                        <div id="flight-option-modal-file-list" style="margin-top: 10px; max-height: 180px; overflow-y: auto; display: flex; flex-direction: column; gap: 6px;">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-primary" id="flight-option-modal-save">Save Option</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="flight-option-view-modal" tabindex="-1" role="dialog" aria-labelledby="flightOptionViewModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="flightOptionViewModalLabel">Flight Option Detail</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group" id="fg-description-detail">
                                        <div style="font-weight:600; margin-bottom:4px;">Description</div>
                                        <div id="flight-option-view-description" style="padding:10px 12px; min-height:80px; background:#f8fbff; border:1px solid #e5eef6; border-radius:4px;"></div>
                                    </div>
                                    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 12px;">
                                        <div class="form-group">
                                            <div style="font-weight:600; margin-bottom:4px;">Currency</div>
                                            <div id="flight-option-view-currency" style="padding:10px 12px; background:#f8fbff; border:1px solid #e5eef6; border-radius:4px;"></div>
                                        </div>
                                        <div class="form-group">
                                            <div style="font-weight:600; margin-bottom:4px;">Price</div>
                                            <div id="flight-option-view-price" style="padding:10px 12px; background:#f8fbff; border:1px solid #e5eef6; border-radius:4px;"></div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom:0;">
                                        <div style="font-weight:600; margin-bottom:4px;">Attachments</div>
                                        <div id="flight-option-view-attachments-container" style="padding:10px 12px; background:#f8fbff; border:1px solid #e5eef6; border-radius:4px; display: flex; flex-direction: column; gap: 6px;">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-right">
                        <?php if ($can_edit_flight_proposal): ?>
                            <button type="submit" name="action" value="draft" class="btn btn-default">
                                <i class="fa fa-save"></i> Save as Draft
                            </button>
                            <button type="submit" name="action" value="submit" class="btn btn-primary">
                                <i class="fa fa-paper-plane"></i> Submit Travel Proposal
                            </button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php if (isset($current_status) && in_array($current_status, [TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_APPROVED, TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_REIMBURSEMENT_SUBMITTED, TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_TICKET_SENT, TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_PAYMENT_IN_PROGRESS, TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_PAYMENT_RELEASE])): ?>
        <div class="panel panel-default">
            <div class="panel-heading text-left" role="tab" id="headingReimbursement">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion-self" href="#collapseReimbursement"
                        aria-expanded="<?php echo ($current_status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_APPROVED || $current_status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_TICKET_SENT) ? 'true' : 'false'; ?>" aria-controls="collapseReimbursement" class="<?php echo ($current_status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_APPROVED || $current_status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_TICKET_SENT) ? '' : 'collapsed'; ?>">
                        Travel Reimbursement Request <span style="float:right;margin-left:20px;"><i
                                class="fa fa-chevron-down" aria-hidden="true"></i></span>
                    </a>
                </h4>
            </div>
            <div id="collapseReimbursement" class="panel-collapse collapse <?php echo ($current_status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_APPROVED || $current_status == TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_TICKET_SENT) ? 'in' : ''; ?>" role="tabpanel"
                aria-labelledby="headingReimbursement">
                <div class="panel-body">
                    <form id="form-reimbursement" method="POST" enctype="multipart/form-data" novalidate>
                        <input type="hidden" name="form_type" value="flight_reimbursement">
                        <input type="hidden" name="application_id" value="<?= isset($id) ? $id : '' ?>">
                        <input type="hidden" name="grantee_grant_id" value="<?= $grantee_grant->id ?>">

                        <!-- Receipt Option Modal -->
                        <div class="modal fade" id="receipt-option-modal" tabindex="-1" role="dialog" aria-labelledby="receiptOptionModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="receiptOptionModalLabel">Receipt & Ticket</h4>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" id="receipt-modal-index" value="">

                                        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 12px;">
                                            <div class="form-group">
                                                <label for="receipt-modal-currency">Currency <span class="text-danger">*</span></label>
                                                <select class="form-control" id="receipt-modal-currency">
                                                    <option value="IDR">IDR</option>
                                                    <option value="USD" selected>USD</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="receipt-modal-price">Price <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="receipt-modal-price" placeholder="e.g. 1250 or 1250.00">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Attachment <span class="text-danger">*</span></label>
                                            <div>
                                                <button type="button" class="btn btn-primary btn-sm" id="receipt-modal-file-btn"><i class="fa fa-upload"></i> Choose file</button>
                                                <span id="receipt-modal-file-name" class="text-muted" style="margin-left:10px;">No file selected</span>
                                            </div>
                                            <small class="text-muted">Supported format: PDF, JPG, JPEG, PNG (single file containing receipt &amp; e-ticket)</small>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-primary" id="receipt-modal-save">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="category-block" id="receiptCategoryBlock">
                            <div class="category-header">
                                <span><?= $application->type_flight == 'International' ? 'International' : 'Domestic' ?> Flight Receipt and Ticket</span>
                                <?php if ($can_edit_flight_reimbursment): ?>
                                    <button type="button" class="add-receipt-option btn-add-item">
                                        <i class="fa fa-plus"></i> Add Option
                                    </button>
                                <?php endif; ?>
                            </div>
                            <div style="overflow-x: auto;">
                                <table>
                                    <thead>
                                        <tr>
                                            <th style="width: 160px;">Price</th>
                                            <th style="width: 100px;">Currency</th>
                                            <th style="width: 160px;">Attachment</th>
                                            <th style="width: 100px; text-align: right;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="receipt-upload-container" class="upload-container">
                                    <?php if (!empty($receipt_attachments)) {
                                        foreach ($receipt_attachments as $idx => $ra) { 
                                            $i = $idx + 1;
                                            $preview_url = base_url(preg_match('/\.(jpg|jpeg|png)$/i', $ra->file_path) ? $ra->file_path : 'assets/images/icons/pdf.svg');
                                            $file_url = base_url($ra->file_path);
                                            $has_file = !empty($ra->file_path);
                                            $formatted_price = isset($ra->price) && $ra->price !== null ? format_money((float)$ra->price, $ra->currency ?? 'USD') : '';
                                            ?>
                                            <tr class="upload-group" data-index="<?= $i ?>">
                                                <td>
                                                    <span class="receipt-price-text"><?= $formatted_price ? html_escape($formatted_price) : '<span class="text-muted">-</span>' ?></span>
                                                    <input type="hidden" class="receipt-option-id" name="receipt_option_id_<?= $i ?>" value="<?= $ra->id ?>">
                                                    <input type="hidden" class="receipt-price" name="receipt_price_<?= $i ?>" value="<?= isset($ra->price) && $ra->price !== null ? format_money((float)$ra->price, $ra->currency ?? 'USD', false) : '' ?>">
                                                    <input type="hidden" class="receipt-currency" name="receipt_currency_<?= $i ?>" value="<?= isset($ra->currency) ? $ra->currency : 'USD' ?>">
                                                    <input type="hidden" class="receipt-existing-file-name" value="<?= $has_file ? basename($ra->file_path) : '' ?>">
                                                    <input type="file" class="custom-file-input hide" name="receipt_option_<?= $i ?>" id="file_receipt_option_<?= $i ?>" accept=".pdf,.jpg,.jpeg,.png">
                                                </td>
                                                <td><span class="receipt-currency-text"><?= isset($ra->currency) ? html_escape($ra->currency) : 'USD' ?></span></td>
                                                <td>
                                                    <a href="<?= $file_url ?>" id="preview_link_receipt_option_<?= $i ?>" class="lightbox" aria-haspopup="dialog" style="display: inline-flex; align-items: center; gap: 6px;">
                                                        <img id="preview_image_receipt_option_<?= $i ?>" class="flight-option-thumb hide" src="<?= $preview_url ?>" style="max-height: 36px; max-width: 36px; object-fit: contain;">
                                                        <span class="receipt-preview-filename" style="font-size:12px; color:#2563eb;"><?= $has_file ? file_name($file_url) : '<span class="text-muted">No file</span>' ?></span>
                                                    </a>
                                                    <a href="<?= $file_url ?>" id="button_download_receipt_option_<?= $i ?>" download class="btn btn-primary btn-xs ml-2 <?= $has_file ? '' : 'hide' ?>">
                                                        <i class="fa fa-download fa-fw"></i>
                                                    </a>
                                                </td>
                                                <td style="text-align: right;">
                                                    <?php if ($can_edit_flight_reimbursment): ?>
                                                        <button type="button" class="btn btn-info btn-xs edit-receipt-option"><i class="fa fa-pencil"></i></button>
                                                        <button class="btn btn-danger btn-xs remove-option" type="button"><i class="fa fa-trash"></i></button>
                                                    <?php else: ?>
                                                        <span style="color: #ccc;"><i class="fa fa-lock"></i></span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php }
                                    } else { ?>
                                        <tr id="receipt-empty-row">
                                            <td colspan="5" style="text-align:center; color:#94a3b8; font-style:italic; padding:20px;">No options added yet. Click "+ Add Option" above.</td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>



                        <?php if ($can_edit_flight_reimbursment): ?>
                            <div class="text-right">
                                <button type="submit" name="action" value="draft" class="btn btn-default">
                                    <i class="fa fa-save"></i> Save as Draft
                                </button>
                                <button type="submit" name="action" value="submit" class="btn btn-primary">
                                    <i class="fa fa-paper-plane"></i> Submit Reimbursement Request
                                </button>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="panel panel-default">
            <div class="panel-heading text-left" role="tab" id="headingReimbursement">
                <h4 class="panel-title">
                    <span style="color: #ccc;">
                        <i class="fa fa-lock"></i> Flight Reimbursement Request <small>(Available after Flight Proposal is
                            approved)</small>
                    </span>
                </h4>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    var currentStatus = <?= $current_status ?? TRAVEL_ARRANGEMENT_NON_ETA_STATUS_DRAFT ?>;
</script>