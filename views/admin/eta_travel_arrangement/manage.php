<style>
    .eta-manage-page .eta-filter-toolbar { background:#fff; border:1px solid #e2e8f0; border-radius:6px; padding:12px 4px; margin-left:0; margin-right:0; margin-bottom:16px; }
    .eta-manage-page .eta-filter-toolbar label { font-size:13px; color:#64748b; font-weight:600; }
    .eta-manage-page .eta-filter-toolbar hr { display:none; }
</style>

<div class="container-fluid eta-manage-page">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?php echo $page_title; ?>
                <button 
                    class="btn btn-primary pull-right"
                    data-toggle="modal"
                    data-target="#modal_setting_eta"
                >
                    <i class="fa fa-gear"></i>
                </button>
            </h1>
        </div>
    </div>


    <div class="modal fade" id="modal_setting_eta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Setting Period</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Select Period</label>
                                <select id="period_setting" class="form-control formselect2" data-placeholder="-- Select Period --">
                                    <option value="">-- Select Period --</option>
                                    <?php foreach($periods as $period) { ?>
                                        <option value="<?php echo $period->id ?>"><?php echo $period->fiscal_year; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-12 text-right">
                            <button type="button" class="btn btn-success btn-setting-period">Save</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row eta-filter-toolbar">
        <div class="col-md-4">
            <div class="form-group">
                <label>Period</label>
                <select id="eta_period" class="form-control formselect2" data-placeholder="-- Select Period --">
                    <option value="">-- Select Period --</option>
                    <?php foreach($periods as $period) { ?>
                        <option value="<?php echo $period->id ?>"><?php echo $period->fiscal_year; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-4 hide">
            <div class="form-group">
                <label>Program</label>
                <select id="eta_program" class="form-control formselect2" data-placeholder="-- Select Program --">
                    <option value="">-- Select Program --</option>
                    <?php 
                    $saved_program = get_option('eta_travel_arrangement_program', null);
                    if (!empty($programs)) {
                        foreach ($programs as $prog) {
                            $label = preg_replace('/\s*\(.*?\)\s*/', '', $prog->name . ' - ' . $prog->year);
                            $selected = ($saved_program == $prog->id) ? 'selected' : '';
                            echo '<option value="' . $prog->id . '" ' . $selected . ' data-period="' . $prog->year . '">' . htmlspecialchars($label) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
    </div>
    <div id="grantees_wrap"></div>
</div>

<script>
    const is_tba = <?= json_encode(has_permission('eta_travel_arrangement', 'tba_eta_travel_arrangement')) ?>;
    const is_aminef_staff = <?= json_encode(has_permission('eta_travel_arrangement', 'internal_travel_arrangement')) ?>;
    const is_administrator = <?= json_encode(isset($is_administrator) ? (bool)$is_administrator : (bool)$this->session->userdata('is_administrator')) ?>;
    const eta_current_user_id = <?= json_encode((int)$this->session->userdata('user_id')) ?>;
    const eta_saved_program = <?= json_encode(get_option('eta_travel_arrangement_program', null)) ?>;
</script>

<script type="application/json" id="eta_staffs"><?= json_encode($staffs ?? []) ?></script>

<?php $this->load->view('admin/eta_travel_arrangement/proposed_flights_modals'); ?>

