<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $title ?>
            <?php if(isset($remaining_budget) && isset($remaining_budget->id)) { ?>
                <a href="javascript:;" onclick="confirmDelete(<?= $remaining_budget->id ?>)" class="btn btn-danger btn-sm pull-right" title="Delete Committed Budget">
                    <i class="fa fa-trash"></i> Delete
                </a>
            <?php } ?>
        </h1>
    </div>
</div>
<?php if (isset($notif_success) && $notif_success != '') { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $notif_success ?>
    </div>
<?php } ?>

<form id="form" role="form" method="POST" enctype="multipart/form-data">
    <?php if(isset($remaining_budget) && isset($remaining_budget->id)) { ?>
        <input type="hidden" name="id" value="<?= $remaining_budget->id ?>">
    <?php } ?>
    <div class="row">
        <div class="col-lg-4">
            <div class="form-group">
                <label>Fiscal Year <small class="text-danger">*</small></label>
                <select class="form-control" name="fiscal_year" required>
                    <?php
                    $current_year = date('Y');
                    $limit_year = 1952;
                    $default_year = isset($remaining_budget) && isset($remaining_budget->fiscal_year) ? $remaining_budget->fiscal_year : $current_year;
                    for ($year = $current_year; $year >= $limit_year; $year--) {
                        $selected = '';
                        if ($default_year == $year) {
                            $selected = 'selected="selected"';
                        }
                        ?>
                        <option value="<?php echo $year ?>" <?php echo $selected ?>><?php echo $year ?></option>
                    <?php
                }
                ?>
                </select>
            </div>
            <div class="form-group">
                <label>Name <small class="text-danger">*</small></label>
                <input type="text" class="form-control" name="name" value="<?= isset($remaining_budget) && isset($remaining_budget->name) ? $remaining_budget->name : '' ?>" required>
            </div>
            <div class="form-group">
                <label>Grants <small class="text-danger">*</small></label>
                <select class="form-control formselect2" name="user_grantee_grant" required>
                    <option value="">-- Select Grants --</option>
                    <?php if(isset($program_available)) { 
                        foreach( $program_available as $program) { 
                            $selected = '';
                            if (isset($remaining_budget) && isset($remaining_budget->user_grantee_grant_id) && $remaining_budget->user_grantee_grant_id == $program->id) {
                                $selected = 'selected="selected"';
                            }
                    ?>
                        <option <?= $selected ?> value="<?= $program->id?>"><?= $program->name ?> <?= $this->session->userdata('active_country') == AMERICAN_DATABASE ? ' - ' . $program->year : '' ?> </option>
                    <?php } 
                    } ?>
                </select>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <h4>Budget Details</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Kategori</th>
                        <th class="text-right">Total Budget (USD)</th>
                        <th class="text-right">Total Payment (USD)</th>
                        <th class="text-right">Remaining (USD)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Grant Cost</strong></td>
                        <td>
                            <input type="text" class="form-control currency-usd text-right" name="grant_cost" id="grant_cost" value="<?= isset($remaining_budget) ? format_money($remaining_budget->grant_cost, 'USD') : '' ?>" required>
                        </td>
                        <td>
                            <input type="text" class="form-control currency-usd text-right" name="grant_cost_payment" id="grant_cost_payment" value="<?= isset($grant_cost_payment) ? format_money($grant_cost_payment, 'USD') : format_money(0, 'USD') ?>" required>
                        </td>
                        <td>
                            <input type="text" class="form-control currency-usd text-right" name="grant_cost_remaining" id="grant_cost_remaining" value="<?= isset($grant_cost_remaining) ? format_money($grant_cost_remaining, 'USD') : format_money(0, 'USD') ?>" readonly>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Grant Supporting</strong></td>
                        <td>
                            <input type="text" class="form-control currency-usd text-right" name="grant_supporting" id="grant_supporting" value="<?= isset($remaining_budget) ? format_money($remaining_budget->grant_supporting, 'USD') : '' ?>" required>
                        </td>
                        <td>
                            <input type="text" class="form-control currency-usd text-right" name="grant_supporting_payment" id="grant_supporting_payment" value="<?= isset($grant_supporting_payment) ? format_money($grant_supporting_payment, 'USD') : format_money(0, 'USD') ?>" required>
                        </td>
                        <td>
                            <input type="text" class="form-control currency-usd text-right" name="grant_supporting_remaining" id="grant_supporting_remaining" value="<?= isset($grant_supporting_remaining) ? format_money($grant_supporting_remaining, 'USD') : format_money(0, 'USD') ?>" readonly>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>International Travel</strong></td>
                        <td>
                            <input type="text" class="form-control currency-usd text-right" name="international_travel" id="international_travel" value="<?= isset($remaining_budget) ? format_money($remaining_budget->international_travel, 'USD') : '' ?>" required>
                        </td>
                        <td>
                            <input type="text" class="form-control currency-usd text-right" name="international_travel_payment" id="international_travel_payment" value="<?= isset($international_travel_payment) ? format_money($international_travel_payment, 'USD') : format_money(0, 'USD') ?>" required>
                        </td>
                        <td>
                            <input type="text" class="form-control currency-usd text-right" name="international_travel_remaining" id="international_travel_remaining" value="<?= isset($international_travel_remaining) ? format_money($international_travel_remaining, 'USD') : format_money(0, 'USD') ?>" readonly>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group" style="margin-bottom:10px">
                <div style="margin-bottom:10px;">
                    <a href="<?php echo site_url('admin/remaining_budget/manage') ?>" class="btn btn-default">Back</a>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Modal Delete Confirmation -->
<div class="modal fade" id="confirm-delete-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Delete Committed Budget?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this committed budget? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a href="#" id="confirm-delete-btn" class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>
</div>

