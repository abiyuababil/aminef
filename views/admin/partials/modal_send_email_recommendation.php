<style>
/* Modal Header */
.modal-header {
    padding: 12px 18px;
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
.modal-body-rec {
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
</style>

<div class="modal fade" id="send-email-recommendation-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4>Recommender Email Notification</h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body-rec">
                <!-- Loading State -->
                <div id="email-recommendation-loading" style="text-align: center; padding: 30px; display: none;">
                    <i class="fa fa-spinner fa-spin fa-2x" style="color: #20639b;"></i>
                    <p style="margin-top: 10px; color: #666;">Loading recommender data...</p>
                </div>

                <!-- Error State -->
                <div id="email-recommendation-error" class="alert alert-warning" style="display: none;"></div>

                <!-- Content Area -->
                <div id="email-recommendation-content" style="display: none;">
                    <!-- Grantee Info Bar -->
                    <div class="grantee-bar">
                        <div>
                            Grantee: <b id="rec-grantee-name">-</b> &bull; 
                            Program: <b id="rec-grantee-program">-</b> (<span id="rec-grantee-period">-</span>)
                        </div>
                        <div>
                            <span class="badge-submitted hide" id="rec-grantee-status">Submitted</span>
                        </div>
                    </div>

                    <!-- Sub-Header & Redirect Link -->
                    <div class="sub-header-bar">
                        <span style="font-weight: 600; color: #444;" id="rec-recipient-count">
                            Target Recipients (0 Recommenders)
                        </span>
                        <a href="<?= base_url(EMAIL_NOTIFY_RECOMMENDER) ?>" 
                            target="_blank" 
                            id="rec-template-link"
                            class="btn-redirect">
                            Configure / View Email Template &rarr;
                        </a>
                    </div>

                    <!-- Recommender Cards Container -->
                    <div id="email-recommendation-cards"></div>

                    <!-- Flow Description Note -->
                    <div class="info-note">
                        <strong>Workflow Note:</strong> Clicking <em>"Trigger &amp; Send Emails"</em> will immediately dispatch notification emails containing each unique link to the recommenders. Submitted recommendations will be automatically attached to the grantee's application record upon completion.
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-cancel" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn-trigger" id="btn-send-email-recommendation">
                    Trigger &amp; Send Emails
                </button>
            </div>
        </div>
    </div>
</div>