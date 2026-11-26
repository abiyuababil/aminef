
<?php
$default_tab_active = 'class="active"';
$default_content_active = 'active in';

$guideline_non_eta = get_option('guideline_non_eta');
$has_guideline_non_eta = trim(strip_tags((string)$guideline_non_eta)) !== '';
?>

<style>
    .select2 {
        width:100% !important;
    }
    .panel-default .panel-heading {
        background-color: rgba(5, 47, 87, 0.92);
        color: #fff;
        padding: 15px 20px;
    }
    .panel-title a {
        display: block;
        text-decoration: none;
        color: #fff;
    }
    .panel-title a:hover {
        color: #ddd;
    }
    .option-card {
        border: 1px solid #ddd;
        padding: 12px 15px;
        margin-right: 10px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #fff;
        display: inline-block;
    }
    .option-card:hover {
        border-color: #0089d1;
    }
    .option-card.selected {
        border-color: #0089d1;
        background: #f0f9ff;
    }
    .option-card input[type="radio"] {
        display: none;
    }
    .option-icon {
        font-size: 20px;
        color: #0089d1;
        margin-right: 10px;
        display: inline-block;
        vertical-align: middle;
    }
    .option-title {
        font-size: 14px;
        font-weight: bold;
        color: #333;
        display: inline-block;
        vertical-align: middle;
    }
    .section-content {
        display: none;
        animation: fadeIn 0.3s ease;
    }
    .section-content.active {
        display: block;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .flight-section {
        background: #f9f9f9;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .flight-section h4 {
        color: #333;
        font-weight: bold;
        margin-bottom: 20px;
    }
    .upload-group {
        background: #fff;
        /* border: 1px solid #e0e0e0; */
        border-radius: 6px;
        padding: 15px;
        margin-bottom: 15px;
    }
    .upload-group label {
        font-weight: 600;
        color: #333;
    }
    .flight-option-item {
        padding: 16px;
        cursor: pointer;
        /* border-left: 4px solid transparent;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease; */
    }
    .flight-option-item:hover {
        box-shadow: 0 3px 10px rgba(5, 47, 87, 0.08);
        transform: translateY(-1px);
    }
    .flight-option-item.is-selected {
        border-color: #c9dcee;
        border-left-color: #1f6fa5;
        background-color: #f2f8fd;
    }
    .flight-option-selected-note {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 10px;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        color: #0f5e92;
        background: #e6f2fb;
        border: 1px solid #c8e0f2;
    }
    .flight-option-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }
    .flight-option-header label {
        margin-bottom: 0;
    }
    .flight-option-summary {
        background: #f8fbff;
        border: 1px solid #e5eef6;
        border-radius: 6px;
        padding: 10px 12px;
        margin-top: 8px;
    }
    .flight-option-main-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }
    .flight-option-summary-row {
        display: block;
        margin-bottom: 6px;
    }
    .flight-option-summary-row:last-child {
        margin-bottom: 0;
    }
    .flight-option-title-text {
        font-weight: 600;
        color: #2c3a46;
        display: block;
        overflow-wrap: anywhere;
    }
    .flight-option-price-text {
        color: #0e6ba8;
        font-weight: 600;
        white-space: nowrap;
    }
    .flight-option-actions {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }
    .flight-option-lock {
        color: #9ca8b3;
    }
    .flight-option-preview {
        margin-top: 10px;
        position: relative;
        width: 100px;
        height: 100px;
    }
    .flight-option-thumb {
        width: 100px;
        height: 100px;
        min-height: 100px !important;
        max-height: 100px;
        object-fit: cover !important;
        border: 1px solid #dbe6f0;
        border-radius: 4px;
        background: #fff;
    }
    .flight-option-download-btn {
        position: absolute;
        top: 0;
        right: -28px;
    }
    .custom-file-input {
        display: none !important;
    }
    .upload-button {
        display: inline-block;
        cursor: pointer;
        padding: 6px 12px !important;
        margin: 0 !important;
        color:white !important;
        font-weight: normal !important;
    }
    .placeholder-content {
        text-align: center;
        padding: 60px 20px;
        color: #888;
    }
    .placeholder-content i {
        font-size: 64px;
        color: #ddd;
        margin-bottom: 20px;
    }
    .loading-spinner {
        text-align: center;
        padding: 40px;
    }
    .loading-spinner i {
        font-size: 32px;
        color: #0089d1;
    }
    #international-upload-container img,
    #domestic-upload-container img {
        cursor: pointer;
    }
    @media (max-width: 767px) {
        .flight-option-header {
            align-items: flex-start;
            flex-direction: column;
        }
        .flight-option-actions {
            width: 100%;
        }
        .flight-option-main-row {
            align-items: flex-start;
            flex-direction: column;
            gap: 6px;
        }
    }
    .preview-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        align-items: center;
        justify-content: center;
        min-height: 100vh;
    }
    .preview-modal.show {
        display: flex;
    }
    .preview-modal-content {
        position: relative;
        background-color: #fff;
        padding: 0;
        border-radius: 8px;
        max-width: 90vw;
        max-height: 90vh;
        width: auto;
        height: auto;
        overflow: auto;
        margin: auto;
    }
    .preview-modal-close {
        position: absolute;
        top: 10px;
        right: 15px;
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        z-index: 10000;
        background: white;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .preview-modal-close:hover {
        color: #000;
    }
    .preview-modal img,
    .preview-modal iframe {
        max-width: 100%;
        max-height: 100%;
        width: auto;
        height: auto;
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header text-center"><?= $title ?></h1>
    </div>
</div>

<?php if ($has_guideline_non_eta) : ?>
<div class="row" style="margin-bottom: 10px;">
    <div class="col-lg-12 text-right">
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#popupGuideline">
            <i class="fa fa-info-circle"></i> Guideline
        </button>
    </div>
</div>
<?php endif; ?>

<div class="row">
    <?php if ($success = $this->session->flashdata('success')) : ?>
        <?= show_alert('success', $success); ?>
    <?php endif; ?>
</div>
<?php $this->session->unset_userdata('success'); ?>

<input type="hidden" name="grantee_grant_id" id="grantee_grant_id" value="<?= $grantee_grant->id ?>">

<div class="row" style="margin-bottom: 20px;">
    <div class="col-lg-12">
        <label class="option-card <?php echo (isset($application) && $application->type == 'self_arrangement' || empty($application)) ? 'selected' : (!empty($application) ? 'hide' : ''); ?>" id="card-self">
            <input type="radio" name="arrangement_type" value="self" id="arrangement_self" checked>
            <span class="option-icon"><i class="fa fa-user"></i></span>
            <span class="option-title">Self Arrangement</span>
        </label>
        <label class="option-card <?php echo (isset($application) && $application->type == 'arranged_by_aminef') ? 'selected' : (!empty($application) ? 'hide' : ''); ?>" id="card-aminef">
            <input type="radio" name="arrangement_type" value="aminef" id="arrangement_aminef">
            <span class="option-icon"><i class="fa fa-building"></i></span>
            <span class="option-title">Arranged By AMINEF</span>
        </label>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div id="tab-content-container">
            <div class="loading-spinner">
                <i class="fa fa-circle-o-notch fa-spin"></i>
                <p>Loading...</p>
            </div>
        </div>
    </div>
</div>

<div id="preview-modal" class="preview-modal">
    <div class="preview-modal-content">
        <span class="preview-modal-close" id="preview-modal-close">&times;</span>
        <div id="preview-modal-body"></div>
    </div>
</div>

<?php if ($has_guideline_non_eta) : ?>
<div id="popupGuideline" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-info-circle"></i> Guideline</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <?= $guideline_non_eta ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
