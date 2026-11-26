<style>
  #alert-active_grant-changed{
    position: fixed;
    top: 75px;
    right: 10px;
    z-index: 1001;
    font-weight: bold;
    border: none;
    outline: none;
    display:none;
  }
  
  .am-program-list {
    display: flex;
    flex-direction: column;
    gap: 14px;
    padding: 24px 0 50px;
  }
  .am-program-item {
    display: block;
    text-decoration: none !important;
    color: inherit !important;
  }
  .am-program-card {
    background: #fff;
    border-radius: 12px;
    border: 2px solid #e0e7f0;
    padding: 18px 22px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    transition: box-shadow 0.18s, border-color 0.18s;
  }
  .am-program-card:hover {
    box-shadow: 0 4px 14px rgba(59,125,221,0.15);
    border-color: #93b7e8;
  }
  .am-program-card.is-active {
    border-color: #3b7ddd;
    background: #f0f6ff;
  }
  .am-program-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 12px;
  }
  .am-program-title {
    font-weight: 700;
    font-size: 15px;
    color: #1a2e4e;
    line-height: 1.3;
  }
  .am-program-subtitle {
    font-size: 12px;
    color: #888;
    margin-top: 3px;
  }
  .am-badge-active {
    background: #dbeafe;
    color: #1d4ed8;
    font-size: 11px;
    font-weight: 700;
    padding: 3px 11px;
    border-radius: 20px;
    white-space: nowrap;
    flex-shrink: 0;
  }
  /* Progress bar */
  .am-progress-wrap {
    margin-top: 14px;
  }
  .am-progress-label {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 12px;
    color: #666;
    margin-bottom: 5px;
  }
  .am-progress-label .am-prog-text {
    font-weight: 600;
    color: #1a2e4e;
  }
  .am-progress-bar-bg {
    background: #e8edf5;
    border-radius: 99px;
    height: 7px;
    overflow: hidden;
  }
  .am-progress-bar-fill {
    height: 100%;
    border-radius: 99px;
    background: linear-gradient(90deg, #3b7ddd, #60a5fa);
    transition: width 0.4s;
  }
  .am-progress-bar-fill.full {
    background: linear-gradient(90deg, #16a34a, #4ade80);
  }
  /* Steps pills */
  .am-steps-list {
    display: flex;
    flex-wrap: wrap;
    gap: 7px;
    margin-top: 12px;
  }
  .am-step-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    padding: 4px 10px 4px 7px;
    border-radius: 20px;
    border: 1px solid transparent;
    font-weight: 500;
  }
  .am-step-pill.step-done {
    background: #dcfce7;
    color: #15803d;
    border-color: #bbf7d0;
  }
  .am-step-pill.step-progress {
    background: #dbeafe;
    color: #1d4ed8;
    border-color: #bfdbfe;
  }
  .am-step-pill.step-revise {
    background: #fef3c7;
    color: #92400e;
    border-color: #fde68a;
  }
  .am-step-pill.step-rejected {
    background: #fee2e2;
    color: #991b1b;
    border-color: #fecaca;
  }
  .am-step-pill.step-pending {
    background: #f3f4f6;
    color: #6b7280;
    border-color: #e5e7eb;
  }
  .am-step-pill.step-readonly {
    background: #f3f4f6;
    color: #6b7280;
    border-color: #e5e7eb;
  }
  .am-step-pill[title] {
    cursor: pointer;
  }
  a.am-step-pill-link {
    text-decoration: none !important;
  }
  /* ===== Indonesian Program Cards (unchanged) ===== */
  .program-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    padding: 30px;
    gap: 20px;
  }
  .program-card {
    background: white;
    border-radius: 10px;
    padding: 20px;
    width: 350px;
    text-align: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: transform 0.2s, box-shadow 0.2s;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    min-height: 200px;
  }
  .program-card:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    text-decoration: none;
    cursor: pointer;
  }
  .program-icon {
    font-size: 40px;
    margin-bottom: 15px;
    color: #003366;
    min-height: 90px;
  }
  .program-title {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-align: center;
    min-height: 1em;
    font-weight: bold;
    color: #333;
    padding-top: 8px;
    line-height: 1.2;
  }
  @media (max-width: 768px) {
    .program-card { width: 45%; }
  }
  @media (max-width: 480px) {
    .program-card { width: 90%; }
  }
  .program-card.active {
    border: 2px solid #007bff;
    background-color: #e6f0ff;
    box-shadow: 0 4px 12px rgba(0,123,255,0.3);
  }
</style>
<!-- alert -->
<?php  if ($this->session->userdata('grantee_active_country') == AMERICAN_DATABASE) { ?>
  <?php if (!is_null($this->session->flashdata('select_program_alert'))) : ?>
  <div class="alert alert-success" id="alert-active_grant-changed" style="width:410px">
    <span class="text-alert"><?= $this->session->flashdata('select_program_alert') ?></span>
  </div>
  <?php $this->session->unset_userdata('select_program_alert');?>
  <?php endif; ?>
  <div class="row">
    <div class="col-lg-12" style="border-bottom: 2px solid #013473;color:#013473;">
    <?php $active_grant_name = $this->session->userdata('active_grant_name') ? $this->session->userdata('active_grant_name') : '' ?>
      <h2 class="page-header text-center">Active Program <?= $active_grant_name ? ': '.$active_grant_name : '' ?></h2>
    </div>
  </div>
  <div class="row" style="padding-bottom:50px;">
    <div class="am-program-list">
      <?php foreach ($active_grant as $key => $grant) { 
        $is_valid_application = is_valid_application($grant);
        if (!$is_valid_application) {
          continue;
        }
        $grant_setting     = get_grantee_setting($grant->id);
        $fiscal_year       = !empty($grant_setting->fiscal_year) ? $grant_setting->fiscal_year : '';
        $category_label    = !empty($grant->category_grant) ? label_category_type($grant->category_grant) : '';
        $subtitle_parts    = array_filter([$fiscal_year, $category_label]);
        $subtitle          = implode(' · ', $subtitle_parts);
        $is_active_grant   = $this->session->userdata('active_grant') == $grant->id;

        $categories = get_all_db(
          'am_user_grantee_category',
          ['user_grantee_grant_id' => $grant->grant_id, 'is_active' => 1],
          [], '', null, [],
          ['field' => 'sort', 'order' => 'ASC']
        );

        $cat_statuses = get_all_db(
          'am_grantee_grant_category_status',
          ['grantee_grant_id' => $grant->id]
        );
        $status_map = [];
        foreach ($cat_statuses as $cs) {
          $status_map[$cs->category_id] = $cs->status;
        }

        $total_steps = 0;
        $done_steps  = 0;
        foreach ($categories as $cat) {
          if (!empty($cat->is_readonly)) continue;
          $total_steps++;
          $st = isset($status_map[$cat->id]) ? (int)$status_map[$cat->id] : 0;
          if ($st === DOCUMENT_COMPLETED || $st === DOCUMENT_ARRIVED) {
            $done_steps++;
          }
        }
        $progress_pct = $total_steps > 0 ? round(($done_steps / $total_steps) * 100) : 0;
        $is_all_done  = $total_steps > 0 && $done_steps === $total_steps;
      ?>
        <div class="am-program-item" onclick="window.location='<?= site_url('grantee/programs/set_active_grant/'.$grant->id.'/'.$grant->user_grantee_id) ?>'" style="cursor:pointer;">
          <div class="am-program-card <?= $is_active_grant ? 'is-active' : '' ?>">
            <div class="am-program-header">
              <div>
                <div class="am-program-title"><?= htmlspecialchars($grant->active_grant_name) ?></div>
                <?php if ($subtitle) { ?>
                <div class="am-program-subtitle"><?= htmlspecialchars($subtitle) ?></div>
                <?php } ?>
              </div>
              <?php if ($is_active_grant) { ?>
              <span class="am-badge-active">Active</span>
              <?php } ?>
            </div>

            <?php if ($total_steps > 0) { ?>
            <div class="am-progress-wrap">
              <div class="am-progress-label">
                <span>Steps Progress</span>
                <span class="am-prog-text"><?= $done_steps ?>/<?= $total_steps ?> completed</span>
              </div>
              <div class="am-progress-bar-bg">
                <div class="am-progress-bar-fill <?= $is_all_done ? 'full' : '' ?>" style="width:<?= $progress_pct ?>%;"></div>
              </div>
            </div>

            <div class="am-steps-list" onclick="event.stopPropagation();">
              <?php foreach ($categories as $cat) {
                $is_readonly = !empty($cat->is_readonly);
                $st = isset($status_map[$cat->id]) ? (int)$status_map[$cat->id] : 0;
                if ($is_readonly) {
                  $pill_class = 'step-readonly';
                  $icon       = '<i class="fa fa-eye"></i>';
                  $tooltip    = 'title="Read-only step — no submission required"';
                } elseif ($st === DOCUMENT_COMPLETED || $st === DOCUMENT_ARRIVED) {
                  $pill_class = 'step-done';
                  $icon       = '<i class="fa fa-check-circle"></i>';
                  $tooltip    = '';
                } elseif ($st === DOCUMENT_SUBMITTED) {
                  $pill_class = 'step-progress';
                  $icon       = '<i class="fa fa-clock-o"></i>';
                  $tooltip    = '';
                } elseif ($st === DOCUMENT_NEED_REVISION) {
                  $pill_class = 'step-revise';
                  $icon       = '<i class="fa fa-exclamation-circle"></i>';
                  $tooltip    = '';
                } elseif ($st === DOCUMENT_WITHDRAW || $st === DOCUMENT_PERMIT_REJECT) {
                  $pill_class = 'step-rejected';
                  $icon       = '<i class="fa fa-times-circle"></i>';
                  $tooltip    = '';
                } else {
                  $pill_class = 'step-pending';
                  $icon       = '<i class="fa fa-circle-o"></i>';
                  $tooltip    = '';
                }
                $cat_url = site_url('grantee/submission/category/'.$cat->id);
              ?>
              <a href="<?= $cat_url ?>" class="am-step-pill-link am-step-pill <?= $pill_class ?>" onclick="event.stopPropagation()" <?= $tooltip ?>><?= $icon ?> <?= htmlspecialchars($cat->name) ?></a>
              <?php } ?>
            </div>
            <?php } ?>

          </div>
        </div>
      <?php } ?>
    </div>
  </div>
<?php } else { ?>
  <?php if (!is_null($this->session->flashdata('select_program_alert'))) : ?>
  <div class="alert alert-success" id="alert-active_grant-changed" style="width:410px">
    <span class="text-alert"><?= $this->session->flashdata('select_program_alert') ?></span>
  </div>
  <?php $this->session->unset_userdata('select_program_alert');?>
  <?php endif; ?>
  <div class="row">
    <div class="col-lg-12" style="border-bottom: 2px solid #013473;color:#013473;">
    <?php $active_grant_name = $this->session->userdata('active_grant_name') ? $this->session->userdata('active_grant_name') : '' ?>
      <h2 class="page-header text-center">Active Program <?= $active_grant_name ? ': '.$active_grant_name : '' ?></h2>
    </div>
  </div>
  <div class="row" style="padding-bottom:50px;">
    <div class="program-container">
      <?php foreach ($active_grant as $key => $grant) { 
        $is_valid_application = is_valid_application($grant);
        if (!$is_valid_application) {
          continue;
        } 
        $image_url = base_url($grant->image) 
      ?>
        <a href="<?php echo site_url('grantee/programs/set_active_grant/'.$grant->id.'/'.$grant->user_grantee_id) ?>">
          <div class="program-card <?= $this->session->userdata('active_grant') == $grant->id ? 'active' : ''?>">
            <div class="program-icon">
              <?php if($grant->image){ ?>
                <img src="<?= $image_url ?>" style="width: 90px;height: 90px;object-fit: contain;">
              <?php } ?>
            </div>
            <?php
               $year_of_period = !empty($grant->fiscal_year) ? '('.$grant->fiscal_year.')' : '';    
            ?>
            <div class="program-title"><?php echo $grant->active_grant_name;?> <?= $year_of_period ?></div>
          </div>
        </a>
      <?php } ?>
    </div>
  </div>
<?php } ?>
