<style>
/* Modal Header */
.modal-header {
    padding: 16px 22px;
    background: #f8f9fa;
    border-bottom: 1px solid #e5e5e5;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.modal-header h4 {
    margin: 0;
    font-size: 15px;
    font-weight: 600;
    color: #333;
}
.modal-header .close-btn {
    background: none;
    border: none;
    font-size: 20px;
    color: #888;
    cursor: pointer;
    line-height: 1;
    padding: 0;
}
.modal-header .close-btn:hover {
    color: #333;
}

/* Modal Body */
.modal-body {
    padding: 16px 18px;
    max-height: 72vh;
    overflow-y: auto;
    font-size: 12px;
}

/* Grantee Context Bar */
.grantee-bar {
    background: #f0f4f8;
    border: 1px solid #d0deea;
    border-radius: 3px;
    padding: 8px 12px;
    margin-bottom: 14px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: #333;
}
.badge-submitted {
    background: #e8f5e9;
    color: #7c7e7c;
    border: 1px solid #c8e6c9;
    padding: 2px 8px;
    border-radius: 3px;
    font-size: 11px;
    font-weight: 600;
}

/* Sub Header Bar */
.sub-header-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}
.btn-redirect {
    color: #20639b;
    text-decoration: none;
    font-size: 11px;
    font-weight: 600;
    padding: 4px 10px;
    border: 1px solid #bcdbeb;
    border-radius: 3px;
    background: #fbfdff;
}
.btn-redirect:hover {
    background: #eef5fa;
    text-decoration: underline;
}

/* Recommender Card */
.recommender-card {
    border: 1px solid #e0e0e0;
    border-radius: 3px;
    background: #fafafa;
    padding: 12px;
    margin-bottom: 12px;
}
.recommender-card-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 6px;
    margin-bottom: 8px;
    border-bottom: 1px solid #eee;
}
.recommender-card-footer {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    padding-top: 6px;
    margin-top: 8px;
    border-top: 1px solid #eee;
}
.rec-badge {
    background: #e2e8f0;
    color: #475569;
    font-size: 10px;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 2px;
}

/* Table inside Card */
.table-rec {
    width: 100%;
    border-collapse: collapse;
    font-size: 12px;
}
.table-rec td {
    padding: 4px;
    vertical-align: middle;
}
.lbl {
    width: 120px;
    color: #666;
    font-weight: 600;
}
.val {
    color: #333;
}
.link-input {
    width: 100%;
    font-size: 11px;
    font-family: monospace;
    padding: 4px 6px;
    border: 1px solid #ccc;
    background: #fff;
    border-radius: 2px;
    color: #555;
}
.btn-copy {
    background: #fff;
    border: 1px solid #ccc;
    border-radius: 2px;
    font-size: 11px;
    padding: 3px 10px;
    cursor: pointer;
    color: #444;
    white-space: nowrap;
}
.btn-copy:hover {
    background: #f0f0f0;
}

/* Info Note */
.info-note {
    background: #fffbe6;
    border: 1px solid #ffe58f;
    border-radius: 3px;
    padding: 9px 12px;
    font-size: 11px;
    color: #874d00;
    line-height: 1.4;
    margin-top: 10px;
}

/* Modal Footer */
.modal-footer {
    padding: 10px 18px;
    background: #f8f9fa;
    border-top: 1px solid #e5e5e5;
    display: flex;
    justify-content: flex-end;
    gap: 8px;
}

.btn-add {
    background-color: #0284c7;
    color: #fff;
    border: none;
    padding: 6px 12px;
    font-size: 12px;
    font-weight: 600;
    border-radius: 4px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: background 0.15s ease;
}

.btn-add:hover {
    background-color: #0369a1;
}
.btn-cancel {
    background: #fff;
    border: 1px solid #ccc;
    color: #555;
    font-size: 12px;
    padding: 6px 14px;
    border-radius: 3px;
    cursor: pointer;
}
.btn-trigger {
    background: #5cb85c;
    border: 1px solid #4cae4c;
    color: #fff;
    font-size: 12px;
    font-weight: 600;
    padding: 6px 16px;
    border-radius: 3px;
    cursor: pointer;
}
.btn-trigger:hover {
    background: #449d44;
}

.action-btn {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
    color: #475569;
    transition: all 0.15s ease;
}

.action-btn:hover {
    background: #f8fafc;
    color: #0f172a;
}

.action-btn.btn-edit.active {
    background-color: #0284c7;
    border-color: #0284c7;
    color: #ffffff;
}

.action-btn.btn-exclude {
    color: #b45309;
    border-color: #f59e0b;
}

.action-btn.btn-exclude:hover {
    background-color: #fffbeb;
}

.action-btn.btn-reinstate {
    color: #047857;
    border-color: #10b981;
}

.action-btn.btn-reinstate:hover {
    background-color: #ecfdf5;
}

.action-btn.btn-delete-rec:hover {
    border-color: #fca5a5;
    color: #dc2626;
    background-color: #fef2f2;
}

.rec-name {
    font-weight: 600;
    color: #0f172a;
    display: block;
}

.rec-name.excluded-text {
    text-decoration: line-through;
    color: #94a3b8;
}

.rec-sub {
    font-size: 11.5px;
    color: #64748b;
    margin-top: 2px;
}

#email-recommendation-cards {
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    overflow: hidden;
}


#email-recommendation-cards table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
    font-size: 13px;
}

#email-recommendation-cards thead {
    background-color: #f8fafc;
}

#email-recommendation-cards  th {
    padding: 10px 14px;
    color: #475569;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.2px;
    border-bottom: 1px solid #e2e8f0;
}

#email-recommendation-cards  th.text-right, td.text-right {
    text-align: right;
}

#email-recommendation-cards tbody tr.main-row {
    border-bottom: 1px solid #edf1f4;
    transition: background 0.1s;
}

#email-recommendation-cards tbody tr.main-row:hover {
    background-color: #f8fafc;
}

#email-recommendation-cards tbody tr.main-row.active-editing {
    background-color: #f0f9ff;
}

#email-recommendation-cards tbody tr.row-excluded {
    background-color: #fafafa;
}

#email-recommendation-cards td {
    padding: 12px 14px;
    vertical-align: middle;
    color: #334155;
}


/* Accordion Row Style */
.accordion-row {
    display: none;
    background-color: #f8fafc;
    border-bottom: 1px solid #cbd5e1;
}

.accordion-row.open {
    display: table-row;
    animation: fadeIn 0.15s ease-out;
}

.accordion-td {
    padding: 0 !important;
}

.accordion-content {
    padding: 16px 20px;
    border-left: 3px solid #0284c7;
    background: #f8fafc;
}

.accordion-header-title {
    font-size: 12.5px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}


/* Form Fields Grid */
.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px 14px;
}

.form-group-modal {
    display: flex;
    flex-direction: column;
}

.form-group-modal label {
    font-size: 11.5px;
    font-weight: 600;
    color: #475569;
    margin-bottom: 4px;
}

.form-group-modal label .req {
    color: #dc2626;
}

.form-group-modal input, .form-group-modal select {
    padding: 6px 10px;
    font-size: 12px;
    border: 1px solid #cbd5e1;
    border-radius: 4px;
    outline: none;
    background-color: #fff;
    color: #1e293b;
}

.form-group-modal input:focus, .form-group-modal select:focus {
    border-color: #0284c7;
    box-shadow: 0 0 0 1px #0284c7;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 8px;
    margin-top: 14px;
}
</style>

<div class="modal fade" id="send-email-recommendation-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4>Letter of Recommendation Status</h4>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <button class="btn-add" id="btnAddRecommender" onclick="toggleAddAccordion()">+ Add Recommender</button>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 24px; line-height: 1; padding: 0 4px; margin: 0; background: none; border: none; cursor: pointer;">&times;</button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <!-- Loading State -->
                <div id="email-recommendation-loading" style="text-align: center; padding: 30px; display: none;">
                    <i class="fa fa-spinner fa-spin fa-2x" style="color: #20639b;"></i>
                    <p style="margin-top: 10px; color: #666;">Loading recommender data...</p>
                </div>

                <!-- Error State -->
                <div id="email-recommendation-error" class="alert alert-warning" style="display: none;"></div>

                <!-- Content Area -->
                <div id="email-recommendation-content" style="display: none;">
                    <!-- Add Recommender Form Container -->
                    <div id="add-recommender-card" style="display: none; margin-bottom: 14px; border: 1px solid #cbd5e1; border-left: 3px solid #0284c7; background: #f8fafc; border-radius: 4px; padding: 16px 20px;">
                        <div class="accordion-header-title">
                            <span>Add New Recommender</span>
                        </div>
                        <form onsubmit="handleAddSubmit(event)">
                            <div class="form-grid" id="add-recommender-grid">
                                <div class="form-group-modal">
                                    <label>Prefix</label>
                                    <select id="add_prefix">
                                        <option value="">Select Prefix</option>
                                        <option value="Dr.">Dr.</option>
                                        <option value="Prof.">Prof.</option>
                                        <option value="Mr.">Mr.</option>
                                        <option value="Ms.">Ms.</option>
                                        <option value="Mrs.">Mrs.</option>
                                    </select>
                                </div>
                                <div class="form-group-modal">
                                    <label>First Name <span class="req">*</span></label>
                                    <input type="text" id="add_firstName" required>
                                </div>
                                <div class="form-group-modal">
                                    <label>Last Name <span class="req">*</span></label>
                                    <input type="text" id="add_lastName" required>
                                </div>
                                <div class="form-group-modal">
                                    <label>Institution <span class="req">*</span></label>
                                    <input type="text" id="add_institution" required>
                                </div>
                                <div class="form-group-modal">
                                    <label>Position / Title <span class="req">*</span></label>
                                    <input type="text" id="add_position" required>
                                </div>
                                <div class="form-group-modal">
                                    <label>Relationship <span class="req">*</span></label>
                                    <input type="text" id="add_relationship" required>
                                </div>
                                <div class="form-group-modal">
                                    <label>Telephone <span class="req">*</span></label>
                                    <input type="tel" id="add_telephone" required>
                                </div>
                                <div class="form-group-modal">
                                    <label>Email <span class="req">*</span></label>
                                    <input type="email" id="add_email" required>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="button" class="btn btn-secondary" onclick="toggleAddAccordion()">Cancel</button>
                                <button type="submit" class="btn btn-success" id="btn-submit-add-rec">Save & Send</button>
                            </div>
                        </form>
                    </div>

                    <!-- Recommender Cards Container -->
                    <div id="email-recommendation-cards"></div>
                </div>
            </div>
        </div>
    </div>
</div>