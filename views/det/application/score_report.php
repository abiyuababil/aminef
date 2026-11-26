<style>
    .font-weight-bold {
      font-weight: 700;
    }
    
    .card {
      background-color: #ffffff;
      border-radius: 6px;
      border: 1px solid #dbe2ea;
      box-shadow: 0 1px 3px rgba(0,0,0,0.04);
      max-width: 900px;
      margin: 0 auto;
      padding: 24px 30px;
    }

    .instructions-box {
      background-color: #f8fafc;
      border-left: 4px solid #0077b6;
      padding: 14px 18px;
      border-radius: 4px;
      font-size: 13px;
      color: #334155;
      line-height: 1.5;
      margin-bottom: 24px;
    }

    .form-grid-2 {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      font-size: 13px;
      font-weight: 600;
      margin-bottom: 6px;
      color: #334155;
    }

    /* input[type="number"], input[type="date"] {
      width: 100%;
      padding: 9px 12px;
      font-size: 13px;
      border: 1px solid #cbd5e1;
      border-radius: 4px;
      outline: none;
      transition: border-color 0.2s;
      line-height: 0;
    }

    input[type="number"]:focus, input[type="date"]:focus {
      border-color: #0077b6;
    } */

    .file-input-container {
      border: 2px dashed #cbd5e1;
      padding: 20px;
      text-align: center;
      border-radius: 6px;
      background-color: #f8fafc;
      cursor: pointer;
      display: block;
    }

    .file-input-container input[type="file"] {
      display: none;
    }

    .file-label-text {
      font-size: 13px;
      color: #475569;
      cursor: pointer;
    }

    .file-chosen-name {
      font-size: 14px;
      font-weight: 600;
      color: #0077b6;
      margin-top: 8px;
    }

    .btn-submit {
      background-color: #4CAF50;
      color: #ffffff;
      padding: 10px 22px;
      font-size: 13px;
      font-weight: bold;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }

    .btn-submit:hover {
      background-color: #43a047;
    }

    /* File Card Styling */
    .file-preview-card {    display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 1rem;
      flex-wrap: wrap;
      border: 1px solid #dee2e6;
      border-radius: 6px;
      background-color: #ffffff;
      padding: 0.75rem 1rem;
      transition: border-color 0.15s ease, background-color 0.15s ease;
    }
    .file-preview-card:hover {
      border-color: #cbd5e1;
      background-color: #fcfdfe;
    }
    .file-badge-icon {
      width: 40px;
      height: 40px;
      border-radius: 6px;
      background-color: #fee2e2;
      color: #dc2626;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.25rem;
      flex-shrink: 0;
    }

    .btn-action-preview {
      font-weight: 500;
      padding: 0.35rem 0.75rem;
      border-radius: 4px;
      display: inline-flex;
      align-items: center;
      gap: 5px;
    }
    .file-info-left {
      display: flex;
      gap: 1rem;
      align-items: center;
    }
</style>

<div class="row">
    <div class="col-lg-12 text-center">
        <h2 style="color:#0089d1">Duolingo English Test - Score Report</h2>
    </div>
</div>


<div class="container mt-5">
      <div class="card">
        <div class="instructions-box">
          <?php if($application->score_file) : ?>
          <h4 class="font-weight-bold">Score Report Submitted</h4>
          You submitted your official scores on <strong><?= $application->score_file_upload_date ? date('d/m/Y', strtotime($application->score_file_upload_date)) : '' ?></strong> at <strong><?= $application->score_file_upload_date ? date('H:i:s', strtotime($application->score_file_upload_date)) : '' ?> WIB</strong>.
          <?php else :  ?>
            Please input your official test scores and upload the official score report downloaded from your Duolingo English Test account. Once submitted, the scores will be verified by the AMINEF administrator.
          <?php endif; ?>
        </div>

        <form id="scoreForm" onsubmit="handleSubmit(event)">
            <input type="hidden" name="application_id" id="application_id" value="<?= $application->id ?>">
          <!-- Overall Score & Test Completion Date -->
          <div class="form-grid-2">
            <div>
              <label for="overall_score">Overall Score <span class="text-danger">*</span></label>
              <input <?= $application->score_file ? 'disabled' : '' ?> class="form-control" type="number" id="overall_score" name="overall_score" min="10" max="160" step="0.1" placeholder="e.g. 125.5" required value="<?= $application->score ?? '' ?>">
            </div>
            <div>
              <label for="test_date">Test Completion Date <span class="text-danger">*</span></label>
              <input <?= $application->score_file ? 'disabled' : '' ?> class="form-control" type="date" id="test_date" name="test_date_complete" required value="<?= !empty($application->test_date_complete) ? date('Y-m-d', strtotime($application->test_date_complete)) : '' ?>">
            </div>
          </div>

          <!-- Score Report File Upload -->
          <div class="form-group">
            <label>Score Report <span class="text-danger">*</span></label>
            <?php if($application->score_file) : ?>
            <div class="file-preview-card">
              <!-- File Info Left -->
              <div class="file-info-left">
                <div class="file-badge-icon">
                  <i class="fa fa-file-o"></i>
                </div>
                <div>
                  <div class="font-weight-bold">
                    <?= basename($application->score_file) ?>
                  </div>
                  <div class="text-muted small">
                    Uploaded
                  </div>
                </div>
              </div>

              <!-- Actions Right -->
              <div class="d-flex align-items-center gap-2">
                <a href="<?= base_url($application->score_file)?>" target="_blank" class="lightbox btn btn-outline-secondary btn-action-preview">
                  <i class="fa fa-eye"></i> View
                </a>
                <a href="<?= base_url($application->score_file)?>" download class="btn btn-outline-primary btn-action-preview">
                  <i class="fa fa-download"></i> Download
                </a>
              </div>
            </div>
            <?php endif; ?>
            <?php if(!$application->score_file) : ?>
            <label class="file-input-container" for="score_file">
              <i class="fa fa-cloud-upload" style="font-size: 26px; color: #0077b6; margin-bottom: 6px;"></i>
              <div class="file-label-text">Click here to browse and upload your PDF certificate (max 5 MB)</div>
              <div id="fileNameDisplay" class="file-chosen-name"></div>
              <input type="file" id="score_file" name="score_file" accept=".pdf" onchange="handleFileChange(event)">
            </label>
            <?php endif; ?>
          </div>

          <?php if(!$application->score_file) : ?>
          <div style="margin-top: 24px; text-align: right;">
            <button type="submit" class="btn-submit">
              <i class="fa fa-paper-plane"></i> Submit Score Report
            </button>
          </div>
          <?php endif; ?>
        </form>
      </div>
</div>