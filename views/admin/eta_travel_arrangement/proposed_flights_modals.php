<!-- Modal for adding and managing Proposed Flights -->
<style>
    /* Modal container */
    #proposedFlightModal .modal-dialog {
        width: 95%;
        max-width: 1400px;
    }

    #proposedFlightModal .pf-modal-content {
        border-radius: 8px;
        overflow: hidden;
    }

    /* Header */
    #proposedFlightModal .pf-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 16px 24px;
        background-color: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }

    #proposedFlightModal .pf-header-title {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
    }

    #proposedFlightModal .pf-header-subtitle {
        margin: 2px 0 0;
        font-size: 12px;
        color: #64748b;
    }

    /* Body: two columns, height follows the form column */
    #proposedFlightModal .pf-modal-body {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        height: auto;
        max-height: 85vh;
        padding: 20px 24px;
        overflow-x: hidden;
        overflow-y: auto;
    }

    /* Left column: form (never scrolls internally) */
    #proposedFlightModal .pf-form-panel {
        display: flex;
        flex-direction: column;
        gap: 14px;
        min-width: 0;
        padding-right: 24px;
        border-right: 1px solid #e2e8f0;
    }

    #proposedFlightModal .pf-panel-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex: 0 0 auto;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: #0284c7;
    }

    #proposedFlightModal #pf_cancel_edit {
        font-size: 11px;
        font-weight: 600;
        color: #dc2626;
        text-decoration: none;
    }

    #proposedFlightModal #pf_cancel_edit:hover {
        text-decoration: underline;
    }

    #proposedFlightModal .pf-form-label {
        margin-bottom: 0;
        font-size: 12.5px;
        font-weight: 600;
        color: #334155;
    }

    #proposedFlightModal .pf-price-row {
        display: grid;
        grid-template-columns: 120px 1fr;
        gap: 12px;
    }

    #proposedFlightModal .pf-price-row .form-group {
        margin-bottom: 0;
    }

    #proposedFlightModal .mce-tinymce,
    #proposedFlightModal .tox-tinymce {
        border: 1px solid #cbd5e1 !important;
        border-radius: 6px;
        overflow: hidden;
    }

    /* Attachment dropzone */
    #proposedFlightModal .pf-upload-dropzone {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 4px;
        height: auto;
        margin-bottom: 0;
        padding: 14px;
        text-align: center;
        background-color: #fafbfc;
        border: 1.5px dashed #cbd5e1;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    #proposedFlightModal .pf-upload-dropzone:hover,
    #proposedFlightModal .pf-upload-dropzone.pf-dragover {
        background-color: #f0f9ff;
        border-color: #0284c7;
    }

    #proposedFlightModal .pf-upload-dropzone .pf-upload-icon {
        font-size: 20px;
        color: #94a3b8;
    }

    #proposedFlightModal .pf-upload-dropzone .pf-upload-hint {
        font-size: 12px;
        color: #64748b;
    }

    #proposedFlightModal .pf-upload-dropzone .upload-name-file {
        font-size: 12px;
        color: #334155;
        word-break: break-word;
    }

    #proposedFlightModal .pf-upload-dropzone .uploaded_attachment,
    #proposedFlightModal .pf-upload-dropzone .edit_uploaded_attachment,
    #proposedFlightModal .pf-upload-dropzone .remove_uploaded_attachment {
        position: static;
        top: auto;
        right: auto;
        left: auto;
        margin: 0 4px;
        font-size: 18px;
        transform: none;
    }

    #proposedFlightModal .pf-upload-dropzone .edit_uploaded_attachment {
        color: #dcb835;
    }

    #proposedFlightModal .pf-upload-dropzone .remove_uploaded_attachment {
        color: #dc3545;
    }

    #proposedFlightModal .pf-btn-submit {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 9px 16px;
        font-size: 13px;
        font-weight: 600;
        color: #fff;
        background-color: #0284c7;
        border: none;
        border-radius: 4px;
    }

    #proposedFlightModal .pf-btn-submit:hover,
    #proposedFlightModal .pf-btn-submit:focus {
        color: #fff;
        background-color: #0369a1;
    }

    /* Right column: saved options */
    /* `contain: size` makes this column ignore its content when the grid
       computes the row height, so the row is driven by the form column;
       the column is then stretched to that height and the list scrolls. */
    #proposedFlightModal .pf-preview-panel {
        display: flex;
        flex-direction: column;
        gap: 12px;
        min-width: 0;
        min-height: 0;
        contain: size;
        overflow: hidden;
    }

    #proposedFlightModal .pf-saved-list {
        display: flex;
        flex: 1 1 auto;
        flex-direction: column;
        gap: 12px;
        min-height: 0;
        max-height: none;
        padding-right: 4px;
        overflow-x: hidden;
        overflow-y: auto;
    }

    #proposedFlightModal .saved-option-card {
        display: flex;
        flex-direction: column;
        gap: 8px;
        min-width: 0;
        padding: 12px 14px;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
        transition: all 0.15s ease;
    }

    #proposedFlightModal .saved-option-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.04);
    }

    #proposedFlightModal .saved-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
    }

    #proposedFlightModal .saved-card-badge {
        padding: 2px 8px;
        font-size: 11px;
        font-weight: 700;
        color: #0369a1;
        white-space: nowrap;
        background-color: #e0f2fe;
        border-radius: 4px;
    }

    #proposedFlightModal .saved-card-price {
        font-size: 15px;
        font-weight: 800;
        color: #0284c7;
    }

    #proposedFlightModal .saved-itinerary-preview {
        max-height: 120px;
        margin: 0;
        padding: 8px 10px;
        font-family: inherit;
        font-size: 11.5px;
        line-height: 1.5;
        color: #334155;
        word-break: break-word;
        overflow-wrap: anywhere;
        white-space: normal;
        background-color: #f8fafc;
        border: 1px solid #f1f5f9;
        border-radius: 4px;
        overflow-x: hidden;
        overflow-y: auto;
    }

    #proposedFlightModal .saved-itinerary-preview p {
        margin: 0;
    }

    #proposedFlightModal .saved-itinerary-preview::-webkit-scrollbar {
        width: 5px;
    }

    #proposedFlightModal .saved-itinerary-preview::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }

    #proposedFlightModal .saved-itinerary-preview::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }

    #proposedFlightModal .saved-itinerary-preview::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    #proposedFlightModal .saved-card-footer {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
        padding-top: 4px;
        font-size: 11.5px;
    }

    #proposedFlightModal .saved-attachment-wrap {
        min-width: 0;
        max-width: 100%;
    }

    #proposedFlightModal .saved-attachment-link {
        max-width: 100%;
        font-weight: 600;
        color: #0284c7;
        text-decoration: none;
        word-break: break-word;
        overflow-wrap: anywhere;
    }

    #proposedFlightModal .saved-attachment-link:hover {
        text-decoration: underline;
    }

    #proposedFlightModal .saved-card-actions {
        display: flex;
        gap: 4px;
    }

    #proposedFlightModal .btn-card-action {
        padding: 2px 6px;
        font-size: 12px;
        font-weight: 600;
        background: none;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }

    #proposedFlightModal .btn-card-action.btn-edit {
        color: #0284c7;
    }

    #proposedFlightModal .btn-card-action.btn-edit:hover {
        background-color: #f0f9ff;
    }

    #proposedFlightModal .btn-card-action.btn-delete {
        color: #dc2626;
    }

    #proposedFlightModal .btn-card-action.btn-delete:hover {
        background-color: #fee2e2;
    }

    #proposedFlightModal .empty-options-state {
        padding: 30px;
        font-size: 12.5px;
        text-align: center;
        color: #94a3b8;
        border: 1px dashed #cbd5e1;
        border-radius: 6px;
    }

    /* Mobile: stack the columns */
    @media (max-width: 767px) {
        #proposedFlightModal .pf-modal-body {
            grid-template-columns: 1fr;
            height: auto;
            max-height: 80vh;
            overflow-y: auto;
        }

        #proposedFlightModal .pf-form-panel {
            padding-right: 0;
            padding-bottom: 20px;
            border-right: none;
            border-bottom: 1px solid #e2e8f0;
        }

        #proposedFlightModal .pf-preview-panel {
            min-height: auto;
            contain: none;
            overflow: visible;
        }

        #proposedFlightModal .pf-saved-list {
            flex: none;
            max-height: 320px;
        }
    }
</style>
<div class="modal fade" id="proposedFlightModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content pf-modal-content">
            <div class="modal-header pf-modal-header">
                <div class="pf-header-info">
                    <h4 class="pf-header-title">Manage Proposed Flight</h4>
                    <p class="pf-header-subtitle">Grantee: <strong id="pf_grantee_name">-</strong> &bull; Travel Category: <strong id="pf_travel_category">-</strong></p>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pf-modal-body">
                <!-- Kolom Kiri: Form Input -->
                <div class="pf-form-panel">
                    <div class="pf-panel-title">
                        <span id="pf_form_title">Add Flight</span>
                        <a href="javascript:void(0);" id="pf_cancel_edit" style="display:none;">&#10005; Cancel Edit</a>
                    </div>

                    <div class="form-group">
                        <label for="proposed_flight_editor" class="pf-form-label">Proposed Itinerary</label>
                        <textarea id="proposed_flight_editor" class="form-control" rows="7"></textarea>
                    </div>

                    <div class="pf-price-row">
                        <div class="form-group">
                            <label for="proposed_flight_currency" class="pf-form-label">Currency</label>
                            <select id="proposed_flight_currency" class="form-control">
                                <option value="IDR">IDR (Rp)</option>
                                <option value="USD" selected>USD ($)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="proposed_flight_price" class="pf-form-label">Amount</label>
                            <input type="text" id="proposed_flight_price" class="form-control" placeholder="e.g. 1,964.00" aria-label="Proposed flight price" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="pf-form-label">Attachment / Quotation Document</label>
                        <label for="proposed_flight_attachment" class="file-attachment-area pf-upload-dropzone">
                            <input type="file" id="proposed_flight_attachment" name="proposed_flight_attachment" class="hide">
                            <input type="text" id="attachment_file" name="attachment_file" class="hide">
                            <i class="fa fa-cloud-upload icon-upload pf-upload-icon"></i>
                            <span class="upload-name-file hide"></span>
                            <span class="pf-upload-hint">Click to upload PDF or drag &amp; drop</span>
                            <span class="pf-upload-actions">
                                <a class="uploaded_attachment btn-link lightbox hide" style="cursor: pointer;" target="_blank"><b><i class="fa fa-eye"></i></b></a>
                                <a class="edit_uploaded_attachment btn-link hide" style="cursor: pointer;"><b><i class="fa fa-edit"></i></b></a>
                                <a class="remove_uploaded_attachment btn-link hide" style="cursor: pointer;"><b><i class="fa fa-trash"></i></b></a>
                            </span>
                        </label>
                    </div>

                    <button type="button" id="btn-add-proposed-flight" class="btn pf-btn-submit">
                        <i class="fa fa-plus"></i> Add Flight Option
                    </button>
                </div>

                <!-- Kolom Kanan: Opsi Tersimpan -->
                <div class="pf-preview-panel">
                    <div class="pf-panel-title">
                        <span>Saved Options (<span id="pf_options_count">0</span>)</span>
                    </div>
                    <div class="pf-saved-list" id="proposed_flights_list">
                        <p class="text-muted">Loading...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Modal container */
    #approvedFlightModal .modal-dialog {
        width: 100%;
        max-width: 620px;
    }

    #approvedFlightModal .apf-modal-content {
        border-radius: 8px;
        overflow: hidden;
    }

    /* Header */
    #approvedFlightModal .apf-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 16px 20px;
        background-color: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }

    #approvedFlightModal .apf-header-title {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
    }

    #approvedFlightModal .apf-header-subtitle {
        margin: 2px 0 0;
        font-size: 12px;
        color: #64748b;
    }

    /* Body */
    #approvedFlightModal .apf-modal-body {
        display: flex;
        flex-direction: column;
        gap: 12px;
        max-height: 70vh;
        padding: 20px;
        overflow-y: auto;
    }

    #approvedFlightModal .apf-instruction {
        margin-bottom: 2px;
        font-size: 12px;
        color: #64748b;
    }

    /* Spacing between the option cards */
    #approvedFlightModal #approved_flights_selection_list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    /* Selectable option card */
    #approvedFlightModal .flight-option-card {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        padding: 14px 16px;
        background-color: #ffffff;
        border: 1.5px solid #cbd5e1;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    #approvedFlightModal .flight-option-card:hover {
        background-color: #f8fafc;
        border-color: #0284c7;
    }

    #approvedFlightModal .flight-option-card.selected {
        background-color: #f0f9ff;
        border-color: #0284c7;
        box-shadow: 0 0 0 1px #0284c7;
    }

    #approvedFlightModal .option-radio {
        flex-shrink: 0;
        width: 16px;
        height: 16px;
        margin-top: 3px;
        cursor: pointer;
        accent-color: #0284c7;
    }

    #approvedFlightModal .option-main {
        display: flex;
        flex: 1;
        flex-direction: column;
        gap: 8px;
        min-width: 0;
    }

    #approvedFlightModal .option-header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 6px;
        border-bottom: 1px dashed #e2e8f0;
    }

    #approvedFlightModal .flight-option-card.selected .option-header-row {
        border-bottom-color: #bae6fd;
    }

    #approvedFlightModal .option-label-badge {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: #475569;
    }

    #approvedFlightModal .option-price {
        font-size: 16px;
        font-weight: 800;
        color: #0284c7;
        white-space: nowrap;
    }

    /* Scrollable itinerary text */
    #approvedFlightModal .flight-raw-text {
        max-height: 125px;
        margin: 0;
        padding: 8px 12px;
        font-family: inherit;
        font-size: 12px;
        line-height: 1.55;
        color: #1e293b;
        word-break: break-word;
        white-space: normal;
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 4px;
        overflow-y: auto;
    }

    #approvedFlightModal .flight-raw-text p {
        margin: 0;
    }

    #approvedFlightModal .flight-raw-text::-webkit-scrollbar {
        width: 5px;
    }

    #approvedFlightModal .flight-raw-text::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }

    #approvedFlightModal .flight-raw-text::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }

    #approvedFlightModal .flight-raw-text::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    #approvedFlightModal .flight-option-card.selected .flight-raw-text {
        background-color: #ffffff;
        border-color: #bae6fd;
    }

    #approvedFlightModal .option-footer {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
    }

    #approvedFlightModal .attachment-link {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-weight: 600;
        color: #0284c7;
        text-decoration: none;
        word-break: break-word;
        overflow-wrap: anywhere;
    }

    #approvedFlightModal .attachment-link:hover {
        text-decoration: underline;
    }

    #approvedFlightModal .apf-empty {
        padding: 30px;
        font-size: 12.5px;
        text-align: center;
        color: #94a3b8;
        border: 1px dashed #cbd5e1;
        border-radius: 6px;
    }

    /* Footer */
    #approvedFlightModal .apf-modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 12px 20px;
        background-color: #f8fafc;
        border-top: 1px solid #e2e8f0;
    }

    #approvedFlightModal .apf-btn {
        padding: 7px 16px;
        font-size: 13px;
        font-weight: 600;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    #approvedFlightModal .apf-btn-cancel {
        color: #475569;
        background-color: #ffffff;
        border: 1px solid #cbd5e1;
    }

    #approvedFlightModal .apf-btn-cancel:hover {
        background-color: #f1f5f9;
    }

    #approvedFlightModal .apf-btn-save {
        color: #ffffff;
        background-color: #0284c7;
    }

    #approvedFlightModal .apf-btn-save:hover {
        background-color: #0369a1;
    }

    #approvedFlightModal .apf-btn-save:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
</style>
<div class="modal fade" id="approvedFlightModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content apf-modal-content">
            <div class="modal-header apf-modal-header">
                <div class="apf-header-info">
                    <h4 class="apf-header-title">Select Proposed Flight</h4>
                    <p class="apf-header-subtitle">Grantee: <strong id="apf_grantee_name">-</strong> &bull; Route: <strong id="apf_route">-</strong></p>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body apf-modal-body">
                <div class="apf-instruction">Select one of the proposed flight itineraries below:</div>
                <div id="approved_flights_selection_list">
                    <div class="apf-empty">Loading...</div>
                </div>
            </div>
            <div class="modal-footer apf-modal-footer">
                <button type="button" class="btn apf-btn apf-btn-cancel" data-dismiss="modal">Cancel</button>
                <button type="button" id="btn-save-approved-flights" class="btn apf-btn apf-btn-save">Save</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Modal container */
    #approvedFlightDetailModal .modal-dialog {
        width: 95%;
        max-width: 620px;
    }

    #approvedFlightDetailModal .afd-modal-content {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.1), 0 10px 10px -5px rgba(15, 23, 42, 0.04);
    }

    /* Header */
    #approvedFlightDetailModal .afd-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 24px 24px 16px;
        border-bottom: 1px solid #f1f5f9;
    }

    #approvedFlightDetailModal .afd-header-title {
        margin: 0;
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
    }

    #approvedFlightDetailModal .afd-header-subtitle {
        margin: 4px 0 0;
        font-size: 12px;
        font-weight: 500;
        color: #64748b;
    }

    #approvedFlightDetailModal .afd-header-subtitle strong {
        font-weight: 600;
        color: #334155;
    }

    #approvedFlightDetailModal .afd-close-btn {
        margin: -10px -10px 0 0;
        padding: 4px;
        color: #94a3b8;
        background: none;
        border: none;
        border-radius: 8px;
        line-height: 1;
        opacity: 1;
    }

    #approvedFlightDetailModal .afd-close-btn:hover,
    #approvedFlightDetailModal .afd-close-btn:focus {
        color: #475569;
        background-color: #f1f5f9;
    }

    /* Body */
    #approvedFlightDetailModal .afd-modal-body {
        padding: 24px;
    }

    #approvedFlightDetailModal .afd-status-notice {
        margin-bottom: 16px;
        font-size: 12px;
        font-weight: 500;
        color: #64748b;
    }

    /* Approved option card */
    #approvedFlightDetailModal .afd-option-card {
        padding: 16px;
        background-color: rgba(240, 249, 255, 0.2);
        border: 2px solid rgba(56, 189, 248, 0.8);
        border-radius: 12px;
    }

    #approvedFlightDetailModal .afd-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        padding-bottom: 12px;
        border-bottom: 1px dashed rgba(186, 230, 253, 0.8);
    }

    #approvedFlightDetailModal .afd-card-title-wrap {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        min-width: 0;
    }

    #approvedFlightDetailModal .afd-status-dot {
        display: inline-block;
        width: 10px;
        height: 10px;
        background-color: #10b981;
        border-radius: 50%;
        flex-shrink: 0;
    }

    #approvedFlightDetailModal .afd-option-label {
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #1e293b;
    }

    #approvedFlightDetailModal .afd-selected-badge {
        padding: 2px 8px;
        font-size: 11px;
        font-weight: 600;
        color: #047857;
        background-color: #d1fae5;
        border-radius: 9999px;
        white-space: nowrap;
    }

    #approvedFlightDetailModal .afd-card-price {
        font-size: 18px;
        font-weight: 700;
        color: #0284c7;
        white-space: nowrap;
    }

    #approvedFlightDetailModal .afd-info-block {
        margin-top: 12px;
    }

    #approvedFlightDetailModal .afd-info-label {
        display: block;
        margin-bottom: 4px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #94a3b8;
    }

    #approvedFlightDetailModal .afd-flight-info {
        max-height: 192px;
        padding: 12px;
        font-size: 12px;
        line-height: 1.6;
        color: #334155;
        word-break: break-word;
        overflow-wrap: anywhere;
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        overflow-x: hidden;
        overflow-y: auto;
    }

    #approvedFlightDetailModal .afd-flight-info p {
        margin: 0;
    }

    #approvedFlightDetailModal .afd-flight-info::-webkit-scrollbar {
        width: 5px;
    }

    #approvedFlightDetailModal .afd-flight-info::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }

    #approvedFlightDetailModal .afd-flight-info::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }

    /* Attachment row */
    #approvedFlightDetailModal .afd-attachment-row {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-top: 14px;
        padding-top: 12px;
        border-top: 1px solid #f1f5f9;
        font-size: 12px;
    }

    #approvedFlightDetailModal .afd-attachment-row .fa-paperclip {
        color: #94a3b8;
    }

    #approvedFlightDetailModal .afd-attachment-label {
        font-size: 11px;
        font-weight: 500;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        color: #94a3b8;
    }

    #approvedFlightDetailModal .afd-attachment-link {
        font-weight: 500;
        color: #0284c7;
        text-decoration: none;
        word-break: break-all;
    }

    #approvedFlightDetailModal .afd-attachment-link:hover {
        text-decoration: underline;
    }

    /* Footer */
    #approvedFlightDetailModal .afd-modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 16px 24px;
        background-color: rgba(248, 250, 252, 0.8);
        border-top: 1px solid #f1f5f9;
    }

    #approvedFlightDetailModal .afd-btn-close {
        padding: 8px 16px;
        font-size: 12px;
        font-weight: 500;
        color: #334155;
        background-color: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.05);
    }

    #approvedFlightDetailModal .afd-btn-close:hover,
    #approvedFlightDetailModal .afd-btn-close:focus {
        background-color: #f1f5f9;
    }
</style>
<div class="modal fade" id="approvedFlightDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content afd-modal-content">
            <div class="modal-header afd-modal-header">
                <div>
                    <h3 class="afd-header-title">Selected Flight Itinerary</h3>
                    <p class="afd-header-subtitle">
                        Grantee: <strong class="afd-detail-grantee">-</strong> &bull;
                        Route: <strong class="afd-detail-route">-</strong>
                    </p>
                </div>
                <button type="button" class="close afd-close-btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body afd-modal-body">
                <div class="afd-status-notice">Below are the details of the selected and approved flight option:</div>

                <div class="afd-option-card">
                    <div class="afd-card-header">
                        <div class="afd-card-title-wrap">
                            <span class="afd-status-dot"></span>
                            <span class="afd-option-label afd-detail-option-label">Proposed Option</span>
                            <span class="afd-selected-badge">Selected</span>
                        </div>
                        <div class="afd-card-price afd-detail-price">-</div>
                    </div>

                    <div class="afd-info-block">
                        <label class="afd-info-label">Flight Information</label>
                        <div class="afd-flight-info afd-detail-content flight-description"></div>
                    </div>

                    <div class="afd-attachment-row" style="display: none;">
                        <i class="fa fa-paperclip"></i>
                        <span class="afd-attachment-label">Attachment:</span>
                        <span class="afd-detail-attachment"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer afd-modal-footer">
                <button type="button" class="btn afd-btn-close" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for selecting fields to download as Excel -->
<div class="modal fade" id="modalDownloadExcelETA" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Download Excel</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formDownloadExcelETA" method="POST">
                    <input type="hidden" name="section_id" id="download_excel_section_id">
                    
                    <div class="form-check mb-2">
                        <label>
                            <input class="form-check-input" type="checkbox" id="excel_select_all" checked>
                            <strong>Select All</strong>
                        </label>
                    </div>
                    <hr style="margin-top: 10px; margin-bottom: 15px;">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check" style="margin-bottom: 8px;">
                                <label class="font-weight-normal">
                                    <input class="form-check-input excel-field-checkbox" type="checkbox" name="fields[]" value="Category" checked> Category
                                </label>
                            </div>
                            <div class="form-check" style="margin-bottom: 8px;">
                                <label class="font-weight-normal">
                                    <input class="form-check-input excel-field-checkbox" type="checkbox" name="fields[]" value="Flight Type" checked> Flight Type
                                </label>
                            </div>
                            <div class="form-check" style="margin-bottom: 8px;">
                                <label class="font-weight-normal">
                                    <input class="form-check-input excel-field-checkbox" type="checkbox" name="fields[]" value="Memo Budget" checked> Memo Budget
                                </label>
                            </div>
                            <div class="form-check" style="margin-bottom: 8px;">
                                <label class="font-weight-normal">
                                    <input class="form-check-input excel-field-checkbox" type="checkbox" name="fields[]" value="Note" checked> Note
                                </label>
                            </div>
                            <div class="form-check" style="margin-bottom: 8px;">
                                <label class="font-weight-normal">
                                    <input class="form-check-input excel-field-checkbox" type="checkbox" name="fields[]" value="Grantee Name" checked> Grantee Name
                                </label>
                            </div>
                            <div class="form-check" style="margin-bottom: 8px;">
                                <label class="font-weight-normal">
                                    <input class="form-check-input excel-field-checkbox" type="checkbox" name="fields[]" value="Status" checked> Status
                                </label>
                            </div>
                            <div class="form-check" style="margin-bottom: 8px;">
                                <label class="font-weight-normal">
                                    <input class="form-check-input excel-field-checkbox" type="checkbox" name="fields[]" value="Passport" checked> Passport
                                </label>
                            </div>
                            <div class="form-check" style="margin-bottom: 8px;">
                                <label class="font-weight-normal">
                                    <input class="form-check-input excel-field-checkbox" type="checkbox" name="fields[]" value="From (US)" checked> From (US) / From (ID)
                                </label>
                            </div>
                            <div class="form-check" style="margin-bottom: 8px;">
                                <label class="font-weight-normal">
                                    <input class="form-check-input excel-field-checkbox" type="checkbox" name="fields[]" value="To (ID)" checked> To (ID)
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check" style="margin-bottom: 8px;">
                                <label class="font-weight-normal">
                                    <input class="form-check-input excel-field-checkbox" type="checkbox" name="fields[]" value="Departure Date" checked> Departure Date
                                </label>
                            </div>
                            <div class="form-check" style="margin-bottom: 8px;">
                                <label class="font-weight-normal">
                                    <input class="form-check-input excel-field-checkbox" type="checkbox" name="fields[]" value="Return Date" checked> Return Date
                                </label>
                            </div>
                            <div class="form-check" style="margin-bottom: 8px;">
                                <label class="font-weight-normal">
                                    <input class="form-check-input excel-field-checkbox" type="checkbox" name="fields[]" value="Approved Itinerary" checked> Approved Itinerary
                                </label>
                            </div>
                            <div class="form-check" style="margin-bottom: 8px;">
                                <label class="font-weight-normal">
                                    <input class="form-check-input excel-field-checkbox" type="checkbox" name="fields[]" value="Proposed Rate" checked> Proposed Rate
                                </label>
                            </div>
                            <div class="form-check" style="margin-bottom: 8px;">
                                <label class="font-weight-normal">
                                    <input class="form-check-input excel-field-checkbox" type="checkbox" name="fields[]" value="Final Rate" checked> Final Rate
                                </label>
                            </div>
                            <div class="form-check" style="margin-bottom: 8px;">
                                <label class="font-weight-normal">
                                    <input class="form-check-input excel-field-checkbox" type="checkbox" name="fields[]" value="Travel Agent" checked> Travel Agent
                                </label>
                            </div>
                            <div class="form-check" style="margin-bottom: 8px;">
                                <label class="font-weight-normal">
                                    <input class="form-check-input excel-field-checkbox" type="checkbox" name="fields[]" value="Ticket" checked> Ticket
                                </label>
                            </div>
                            <div class="form-check" style="margin-bottom: 8px;">
                                <label class="font-weight-normal">
                                    <input class="form-check-input excel-field-checkbox" type="checkbox" name="fields[]" value="Invoice" checked> Invoice
                                </label>
                            </div>
                            <div class="form-check" style="margin-bottom: 8px;">
                                <label class="font-weight-normal">
                                    <input class="form-check-input excel-field-checkbox" type="checkbox" name="fields[]" value="Proof of Payment" checked> Proof of Payment
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="btn-submit-download-excel" class="btn btn-success">
                    <i class="fa fa-download"></i> Download
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for manually setting section approval (approved_by / approved_at) -->
<div class="modal fade" id="modalSetApprovalETA" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Set Section Approval</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="set_approval_section_id">
                <div class="form-group">
                    <label><strong>Approved By</strong></label>
                    <select id="set_approval_approved_by" class="form-control">
                        <option value="">- Select Staff -</option>
                    </select>
                </div>
                <div class="form-group">
                    <label><strong>Approved At</strong></label>
                    <input type="text" id="set_approval_approved_at" class="form-control" placeholder="Select date and time">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="btn-submit-set-approval" class="btn btn-success">
                    <i class="fa fa-check"></i> Save
                </button>
            </div>
        </div>
    </div>
</div>
