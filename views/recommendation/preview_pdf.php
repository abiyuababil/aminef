<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Letter of Reference / Recommendation</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }

    body {
      background-color: #f8fafc;
      color: #334155;
      padding-bottom: 60px;
    }

    /* Top Navbar */
    .top-navbar {
      background-color: #ffffff;
      border-bottom: 1px solid #e2e8f0;
      padding: 16px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: relative;
      overflow: hidden;
    }

    .brand-group {
      display: flex;
      align-items: center;
      gap: 24px;
    }

    .brand-group .logo-aminef {
      font-size: 24px;
      font-weight: 800;
      color: #0b3954;
      letter-spacing: -0.5px;
      line-height: 1;
    }

    .brand-group .logo-aminef span {
      display: block;
      font-size: 9px;
      font-weight: 600;
      color: #64748b;
      letter-spacing: 0.5px;
      margin-top: 2px;
    }

    .brand-divider {
      width: 1px;
      height: 32px;
      background-color: #cbd5e1;
    }

    .brand-group .logo-fulbright {
      font-size: 20px;
      font-weight: 700;
      color: #0284c7;
      line-height: 1.1;
    }

    .brand-group .logo-fulbright small {
      display: block;
      font-size: 15px;
      font-weight: 400;
      color: #0284c7;
    }

    /* Main Container */
    .container {
      max-width: 900px;
      margin: 32px auto;
      padding: 0 20px;
    }

    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 24px;
    }

    .page-title {
      font-size: 20px;
      font-weight: 700;
      color: #0f172a;
    }

    .page-subtitle {
      font-size: 13px;
      color: #64748b;
      margin-top: 4px;
    }

    .badge-portal {
      background-color: #0284c7;
      color: #ffffff;
      font-size: 11px;
      font-weight: 600;
      padding: 4px 10px;
      border-radius: 4px;
    }

    /* Info Cards */
    .card {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      padding: 20px 24px;
      margin-bottom: 24px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .card-title {
      font-size: 12px;
      font-weight: 700;
      text-transform: uppercase;
      color: #475569;
      letter-spacing: 0.5px;
      margin-bottom: 16px;
      border-bottom: 1px solid #f1f5f9;
      padding-bottom: 8px;
    }

    .grid-info {
      display: grid;
      grid-template-columns: 180px 1fr;
      row-gap: 10px;
      font-size: 13px;
    }

    .info-label {
      color: #64748b;
    }

    .info-value {
      color: #0f172a;
      font-weight: 600;
    }

    /* Guidelines Section */
    .intro-paragraph {
      font-size: 13.5px;
      line-height: 1.6;
      color: #334155;
      margin-bottom: 16px;
    }

    .guidelines-box {
      background-color: #f8fafc;
      border-left: 4px solid #0284c7;
      padding: 16px 20px;
      margin-bottom: 20px;
      border-radius: 0 6px 6px 0;
    }

    .guidelines-title {
      font-size: 13px;
      font-weight: 600;
      color: #0f172a;
      margin-bottom: 10px;
    }

    .guidelines-list {
      padding-left: 20px;
      font-size: 13px;
      color: #334155;
      line-height: 1.6;
    }

    .guidelines-list ol {
      padding-left: 18px;
      margin-top: 6px;
      list-style-type: lower-alpha;
    }

    .guidelines-list li {
      margin-bottom: 6px;
    }

    /* Upload Area */
    .upload-box {
      border: 2px dashed #cbd5e1;
      border-radius: 8px;
      padding: 28px;
      text-align: center;
      background-color: #fafbfc;
      margin-top: 14px;
    }

    .upload-icon {
      font-size: 32px;
      color: #0284c7;
      margin-bottom: 8px;
    }

    .upload-text {
      font-size: 13px;
      color: #64748b;
      margin-bottom: 12px;
    }

    .file-input {
      font-size: 12px;
      color: #334155;
    }

    /* Signature & Certification */
    .certification-text {
      font-size: 13.5px;
      line-height: 1.6;
      color: #334155;
      margin-bottom: 14px;
    }

    .legal-clause {
      background-color: #f1f5f9;
      border-radius: 6px;
      padding: 14px 16px;
      font-size: 13px;
      font-weight: 500;
      color: #1e293b;
      font-style: italic;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 16px;
    }

    .form-label {
      display: block;
      font-size: 13px;
      font-weight: 600;
      color: #334155;
      margin-bottom: 6px;
    }

    .form-input {
      width: 100%;
      max-width: 450px;
      padding: 8px 12px;
      font-size: 13px;
      border: 1px solid #cbd5e1;
      border-radius: 6px;
      outline: none;
      background-color: #ffffff;
    }

    .form-input:focus {
      border-color: #0284c7;
      box-shadow: 0 0 0 2px rgba(2, 132, 199, 0.15);
    }

    .warning-note {
      font-size: 12.5px;
      color: #b91c1c;
      margin-bottom: 8px;
      font-weight: 500;
    }

    .submit-prompt {
      font-size: 13px;
      color: #475569;
      margin-bottom: 24px;
    }

    /* Action Buttons */
    .action-row {
      display: flex;
      justify-content: flex-end;
      align-items: center;
      gap: 10px;
      margin-top: 10px;
    }

    .btn {
      padding: 9px 20px;
      font-size: 13px;
      font-weight: 600;
      border-radius: 6px;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      text-decoration: none;
      transition: all 0.15s ease-in-out;
    }

    .btn-submit {
      background-color: #1d5f8a;
      color: #ffffff;
      border: 1px solid #1d5f8a;
    }

    .btn-submit:hover {
      background-color: #164e72;
      border-color: #164e72;
    }

    .btn-preview {
      background-color: #0284c7;
      color: #ffffff;
      border: 1px solid #0284c7;
    }

    .btn-preview:hover {
      background-color: #0369a1;
      border-color: #0369a1;
    }

    .btn-save {
      background-color: #ffffff;
      color: #475569;
      border: 1px solid #cbd5e1;
    }

    .btn-save:hover {
      background-color: #f1f5f9;
      color: #1e293b;
      border-color: #94a3b8;
    }

    /* Saved View Components */
    .session-saved-notice {
      display: flex;
      align-items: center;
      gap: 10px;
      color: #047857;
      font-size: 14px;
      font-weight: 600;
      margin-bottom: 18px;
    }

    .session-saved-notice .icon-check {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 22px;
      height: 22px;
      background-color: #d1fae5;
      color: #059669;
      border-radius: 50%;
      font-size: 13px;
    }

    .alert-banner {
      background-color: #fffbeb;
      border: 1px solid #fde68a;
      border-left: 4px solid #f59e0b;
      border-radius: 6px;
      padding: 16px;
      margin-bottom: 24px;
    }

    .alert-heading {
      font-size: 13px;
      font-weight: 700;
      color: #92400e;
      margin-bottom: 4px;
      letter-spacing: 0.3px;
    }

    .alert-body {
      font-size: 13px;
      color: #78350f;
      line-height: 1.5;
    }

    /* PDF Preview View */
    #previewView {
      display: none;
      position: fixed;
      inset: 0;
      background-color: #525659;
      z-index: 9999;
      overflow-y: auto;
    }

    .pdf-viewer-bar {
      position: sticky;
      top: 0;
      background-color: #323639;
      color: #f1f5f9;
      padding: 10px 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 8px rgba(0,0,0,0.3);
      z-index: 100;
    }

    .pdf-toolbar-left {
      font-size: 13px;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 16px;
    }

    .pdf-toolbar-actions {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .btn-pdf-action {
      background-color: transparent;
      border: 1px solid #4b5563;
      color: #f3f4f6;
      padding: 6px 14px;
      font-size: 12px;
      font-weight: 500;
      border-radius: 4px;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: all 0.15s ease;
    }

    .btn-pdf-action:hover {
      background-color: #4b5563;
    }

    .btn-pdf-return {
      background-color: #dc2626;
      border-color: #dc2626;
    }

    .btn-pdf-return:hover {
      background-color: #b91c1c;
      border-color: #b91c1c;
    }

    /* A4 Simulation Sheet */
    .pdf-sheet {
      width: 210mm;
      min-height: 297mm;
      margin: 30px auto;
      border-radius: 2px;
      color: #1e293b;
      box-sizing: border-box;
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
      padding: 4mm 0mm;
    }

    .doc-header {
      border-bottom: 2px solid #0284c7;
      padding-bottom: 16px;
      margin-bottom: 24px;
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
    }

    .doc-main-title {
      font-size: 20px;
      font-weight: 800;
      color: #0b3954;
      line-height: 1.2;
    }

    .doc-sub-title {
      font-size: 12px;
      font-weight: 600;
      color: #0284c7;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-top: 4px;
    }

    .doc-section-title {
      font-size: 12px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: #1e3a8a;
      background-color: #f1f5f9;
      padding: 6px 10px;
      margin-top: 18px;
      margin-bottom: 12px;
      border-left: 3px solid #0284c7;
    }

    .doc-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 12.5px;
      margin-bottom: 10px;
    }

    .doc-table td {
      padding: 6px 8px;
      vertical-align: top;
      border-bottom: 1px solid #f1f5f9;
    }

    .doc-table td.col-lbl {
      width: 220px;
      color: #64748b;
      font-weight: 500;
    }

    .doc-table td.col-val {
      color: #0f172a;
      font-weight: bold;
    }
  </style>
</head>
<body>

    <div class="pdf-sheet">
        <div class="doc-header">
        <div>
            <h1 class="doc-main-title"><b><?= htmlspecialchars($grantee->grant_name ?? '-') ?>: Recommendation</b></h1>
            <p class="doc-sub-title"><b>AMINEF &bull; Official Reference Record</b></p>
        </div>
        </div>

        <div class="doc-section-title"><b>Applicant &amp; Program Details</b></div>
        <table class="doc-table">
        <tr>
            <td class="col-lbl">Applicant Name</td>
            <td class="col-val"><?= htmlspecialchars($grantee_name) ?></td>
        </tr>
        <tr>
            <td class="col-lbl">Program Name</td>
            <td class="col-val"><?= htmlspecialchars($grantee->grant_name ?? '-') ?></td>
        </tr>
        <tr>
            <td class="col-lbl">Program Year</td>
            <td class="col-val"><?= htmlspecialchars($grantee->fiscal_year ?? $grantee->period_name) ?></td>
        </tr>
        </table>

        <div class="doc-section-title"><b>Recommender Information</b></div>
        <table class="doc-table">
        <tr>
            <td class="col-lbl">Recommender Name</td>
            <td class="col-val"><?= htmlspecialchars($request->recommender_name ?: '-') ?></td>
        </tr>
        <tr>
            <td class="col-lbl">Institution</td>
            <td class="col-val"><?= htmlspecialchars($request->institution ?: '-') ?></td>
        </tr>
        <tr>
            <td class="col-lbl">Position / Title</td>
            <td class="col-val"><?= htmlspecialchars($request->position ?: '-') ?></td>
        </tr>
        <tr>
            <td class="col-lbl">Relationship to Applicant</td>
            <td class="col-val"><?= htmlspecialchars($request->relationship ?: '-') ?></td>
        </tr>
        <tr>
            <td class="col-lbl">Contact Email</td>
            <td class="col-val"><?= htmlspecialchars($request->recommender_email ?: '-') ?></td>
        </tr>
        </table>

        <div class="doc-section-title"><b>Submission &amp; Electronic Certification</b></div>
        <table class="doc-table">
        <tr>
            <td class="col-lbl">Certification Clause</td>
            <td class="col-val" style="font-weight: 400; font-style: italic;">
            "I certify that all the information in my recommendation is accurate and true and that I am the person submitting the recommendation."
            </td>
        </tr>
        <tr>
            <td class="col-lbl">Typed Legal Name (Signature)</td>
            <td class="col-val" id="previewSignatureName"><?= $request->legal_name ?? '-' ?></td>
        </tr>
        <tr>
            <td class="col-lbl">Attached Document</td>
            <td class="col-val"><?= $request->file_path ? $request->file_name : '-' ?></td>
        </tr>
        </table>
    </div>
</body>