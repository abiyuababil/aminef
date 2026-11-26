<style>
    .custom-swal-width {
        width: 30% !important;
        /* Ubah lebar sesuai kebutuhan Anda */
    }
</style>

<div class="row">
    <div class="col-md-12 mt-4">
        <div id="wrap-filter" class="data-header clearfix form-inline">
            <form method="POST" id="form-filter-grant">
                <div class="pull-left">
                    <div class="form-group" style="width: 500px !important;">
                        <select name="grant_id" id="grant_id" class="form-control" style="border-radius: 0px !important; width:500px !important;" required>
                            <option value="">Select Program</option>
                            <?php foreach ($program_available as $key_p_a => $p_a) { ?>
                                <option value="<?= $p_a->id ?>" <?php echo $this->session->userdata('rank_program') == $p_a->id ? 'selected' : ''; ?>><?= $p_a->name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="period_id" id="fiscal_year" class="form-control" style="border-radius: 0px !important; width:200px !important;" required>
                            <?php
                            $session_periods = $this->session->userdata('program_periods');
                            $selected_period = null;
                            if ($session_periods) {
                                foreach ($session_periods as $p) {
                                    if ($p->id == $period) {
                                        $selected_period = $p->fiscal_year;
                                    }
                                    

                            ?>
                                    <option value="<?php echo $p->id; ?>" <?php echo $p->id == $period ? 'selected' : ''; ?>><?php echo $p->fiscal_year; ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                    <button type="submit" name="action" class="btn btn-primary btn-sm" value="show_data" style="height: 34px; padding-top:7px !important;">Show Data</button>
                </div>
                <?php if (count($data) > 0) { ?>
                    <div class="pull-right">
                        <button type="submit" name="action" class="btn btn-danger btn-sm ml-2" id="button-reset-rank" value="reset_rank" style="height: 34px; padding-top:7px !important; border-radius:0px !important;">Reset Rank</button>
                    </div>
                <?php } ?>
            </form>
        </div>
    </div>

    <div class="col-lg-12 mt-4">
        <b>Program : <?php echo isset($program) ? get_active_grant_name($program) : ' - '; ?> </b> <br>
        <b>Period : <?php echo $selected_period ? $selected_period : ' - '; ?> </b> <br><br>
        <?php if ($this->session->flashdata('info_rank')) { ?>
            <div class="alert alert-success"><i class="fa fa-info-circle"></i> <?php echo $this->session->flashdata('info_rank'); ?></div>
            <?php $this->session->set_flashdata('info_rank', false); ?>
        <?php } ?>
        <form action="<?php echo site_url('admin/new_selection/update_final_rank'); ?>" method="POST" id="form-update-rank">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#home" data-toggle="tab">Principal</a></li>
                <li><a href="#profile" data-toggle="tab">Alternate</a></li>
                <li><a href="#messages" data-toggle="tab">Status not yet chosen</a></li>
                <li class="pull-right"><button type="submit" class="btn btn-success btn-sm" style="height: 34px; padding-top:7px !important; border-radius:0px !important;">Apply Current Sorted Rank</button></li>

            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="home">
                    <div class="alert alert-info mt-4"><i class="fa fa-info-circle"></i> Drag & Drop Row to sort Rank</div>
                    <div class="table-responsive mt-4">
                        <table id="principal_table" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Interview Date</th>
                                    <th>Interview Status</th>
                                    <th>Score</th>
                                    <th>Rank</th>
                                    <th>
                                        <label for="check-all-daily-rank-principle">
                                            <input type="checkbox" id="check-all-daily-rank-principle"> Lock Rank 
                                            <i style="cursor: pointer;" class="fa fa-info-circle" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top" 
                                                title="If the Rank is locked, it will not be affected by changes to the interview status or score updates.">
                                            </i>
                                        </label>
                                    </th>
                                    <th>Final Rank</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $principal_data = array_filter($data, function ($item) {
                                    return $item->status_interview === 'P';
                                });
                                if ($principal_data) {
                                    $no = $paging['start_row'];
                                    

                                    foreach ($principal_data as $row) {
                                        $format = 'ID';
                                        if ($country_id == '2') {
                                            $format = 'US';
                                        }
                                        $fullname = $this->Grantee_ent_model->get_full_name($row, $format);
                                ?>
                                        <tr style="<?= $row->blacklist ? 'background-color:#f59494' : '' ?>">
                                            <td><?php echo $no++ ?></td>
                                            <td>
                                                <a target="_BLANK" href="<?php echo base_url('admin/users_grantee/edit/' . $row->grantee_id); ?>"><?php echo $fullname ?></a>
                                                <?php if ($row->selection_reviews && count($row->selection_reviews) > 0 && has_permission('selection', 'interview')) { ?>
                                                    <div>
                                                        Review Status :
                                                        <?php foreach ($row->selection_reviews as $review) { ?>
                                                            <?php if ($review->rank_recommendation != '') { ?>
                                                                <span class="badge <?= $review->rank_recommendation ? get_badge_status($review->rank_recommendation) : '' ?>" data-toggle="tooltip" data-placement="right" title="<?= $review->panellist_name ?>" style="cursor:default;">
                                                                    <?= $review->rank_recommendation != '' ? $review->rank_recommendation : '-' ?>
                                                                </span>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>
                                            </td>
                                            <td><?= $row->interview_date ? date('d M Y H:i', strtotime($row->interview_date)) : '-' ?></td>
                                            <td class="text-left">
                                                <?php $status_reject = [STATUS_NEW_SELECTION_WITHDRAW, STATUS_REVIEW_REJECT, STATUS_INTERVIEW_REJECT, STATUS_NEW_SELECTION_DECLINED];
                                                if (in_array($row->status_id, $status_reject)) { ?>
                                                    <button type="button" data-attach='<?= $row->attachment_withdraw ?>' data-note="<?= $row->note_selection ?>" onclick="showReason(this)" class="btn btn-primary btn-xs mt-2">View</button>
                                                <?php } else { ?>
                                                    <?php foreach ($row->data_interview as $interview) { ?>
                                                        <?php if ($interview->rank_recommendation != '') { ?>
                                                            <span class="<?= $interview->rank_recommendation ? 'badge badge-success' : 'badge badge-danger' ?>" data-toggle="tooltip" data-placement="right" title="<?= $interview->panellist_name ?>" style="cursor:default;">
                                                                <?= $interview->rank_recommendation != '' ? get_msg_status($interview->rank_recommendation) : '-' ?>
                                                            </span>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </td>
                                            <td><?= $row->score_interview ? $row->score_interview : '-' ?></td>
                                            <td><?= $row->rank_interview_date ? $row->rank_interview_date : '-' ?></td>
                                            <td>
                                                <input <?php echo $row->daily_rank_lock == 1 ? 'checked' : ''; ?> type="checkbox" name="final_rank_principal[<?php echo $row->id; ?>][daily_rank_lock]" class="daily-rank-lock-principle" value="1">
                                                <input type="hidden" name="final_rank_principal[<?php echo $row->id; ?>][daily_rank]" value="<?php echo $row->rank_interview_date != null ? preg_replace('/\D/', '', $row->rank_interview_date) : null; ?>">
                                                <input type="hidden" name="final_rank_principal[<?php echo $row->id; ?>][daily_rank_status]" value="<?php echo $row->daily_rank_lock == 1 && $row->daily_rank_status != null ? $row->daily_rank_status : $row->status_interview; ?>">
                                            </td>
                                            <td class="field_final_rank">
                                                <span><?php echo $row->final_rank; ?></span>
                                                <input type="hidden" class="grantee_grant_id" name="final_rank_principal[<?php echo $row->id; ?>][id]" value="<?= $row->id ? $row->id : '-' ?>">
                                                <input type="hidden" class="final_rank" name="final_rank_principal[<?php echo $row->id; ?>][final_rank]" value="<?php echo $row->final_rank != null ? preg_replace('/\D/', '', $row->final_rank) : null; ?>">
                                            </td>
                                            <td class="text-right">
                                                <a class="btn btn-primary btn-sm" href="<?php echo site_url('admin/selection/interview/form/' . $row->id) ?>" target="_blank">Interview Selection</a>
                                            </td>
                                        </tr>
                                <?php }
                                } else { ?>
                                    <tr ><td colspan="8">No data available in this section.</td></tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane" id="profile">
                    <div class="alert alert-info mt-4"><i class="fa fa-info-circle"></i> Drag & Drop Row to sort Rank</div>
                    <div class="table-responsive mt-4">
                        <table id="alternate_table" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Interview Date</th>
                                    <th>Interview Status</th>
                                    <th>Score</th>
                                    <th>Rank</th>
                                    <th>
                                        <label for="check-all-daily-rank-principle">
                                            <input type="checkbox" id="check-all-daily-rank-alternate"> Lock Rank 
                                            <i style="cursor: pointer;" class="fa fa-info-circle" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top" 
                                                title="If the Rank is locked, it will not be affected by changes to the interview status or score updates.">
                                            </i>
                                        </label>
                                    </th>
                                    <th>Final Rank</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $alternate_data = array_filter($data, function ($item) {
                                    return $item->status_interview === 'A';
                                });
                                if ($alternate_data) {
                                    $no = $paging['start_row'];
                                    

                                    foreach ($alternate_data as $row) {
                                        $format = 'ID';
                                        if ($country_id == '2') {
                                            $format = 'US';
                                        }
                                        $fullname = $this->Grantee_ent_model->get_full_name($row, $format);
                                ?>
                                        <tr style="<?= $row->blacklist ? 'background-color:#f59494' : '' ?>">
                                            <td><?php echo $no++ ?></td>
                                            <td>
                                                <a target="_BLANK" href="<?php echo base_url('admin/users_grantee/edit/' . $row->grantee_id); ?>"><?php echo $fullname ?></a>
                                                <?php if ($row->selection_reviews && count($row->selection_reviews) > 0 && has_permission('selection', 'interview')) { ?>
                                                    <div>
                                                        Review Status :
                                                        <?php foreach ($row->selection_reviews as $review) { ?>
                                                            <?php if ($review->rank_recommendation != '') { ?>
                                                                <span class="badge <?= $review->rank_recommendation ? get_badge_status($review->rank_recommendation) : '' ?>" data-toggle="tooltip" data-placement="right" title="<?= $review->panellist_name ?>" style="cursor:default;">
                                                                    <?= $review->rank_recommendation != '' ? $review->rank_recommendation : '-' ?>
                                                                </span>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>
                                            </td>
                                            <td><?= $row->interview_date ? date('d M Y H:i', strtotime($row->interview_date)) : '-' ?></td>
                                            <td class="text-left">
                                                <?php $status_reject = [STATUS_NEW_SELECTION_WITHDRAW, STATUS_REVIEW_REJECT, STATUS_INTERVIEW_REJECT, STATUS_NEW_SELECTION_DECLINED];
                                                if (in_array($row->status_id, $status_reject)) { ?>
                                                    <button type="button" data-attach='<?= $row->attachment_withdraw ?>' data-note="<?= $row->note_selection ?>" onclick="showReason(this)" class="btn btn-primary btn-xs mt-2">View</button>
                                                <?php } else { ?>
                                                    <?php foreach ($row->data_interview as $interview) { ?>
                                                        <?php if ($interview->rank_recommendation != '') { ?>
                                                            <span class="<?= $interview->rank_recommendation ? 'badge badge-success' : 'badge badge-danger' ?>" data-toggle="tooltip" data-placement="right" title="<?= $interview->panellist_name ?>" style="cursor:default;">
                                                                <?= $interview->rank_recommendation != '' ? get_msg_status($interview->rank_recommendation) : '-' ?>
                                                            </span>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </td>
                                            <td><?= $row->score_interview ? $row->score_interview : '-' ?></td>
                                            <td><?= $row->rank_interview_date ? $row->rank_interview_date : '-' ?></td>
                                            <td>
                                                <input <?php echo $row->daily_rank_lock == 1 ? 'checked' : ''; ?> type="checkbox" name="final_rank_alternate[<?php echo $row->id; ?>][daily_rank_lock]" class="daily-rank-lock-alternate" value="1">
                                                <input type="hidden" name="final_rank_alternate[<?php echo $row->id; ?>][daily_rank]" value="<?php echo $row->rank_interview_date != null ? preg_replace('/\D/', '', $row->rank_interview_date) : null; ?>">
                                                <input type="hidden" name="final_rank_alternate[<?php echo $row->id; ?>][daily_rank_status]" value="<?php echo $row->daily_rank_lock == 1 && $row->daily_rank_status != null ? $row->daily_rank_status : $row->status_interview; ?>">
                                            </td>
                                            <td class="field_final_rank">
                                                <span><?php echo format_final_rank_status($row); ?></span>
                                                <input type="hidden" class="grantee_grant_id" name="final_rank_alternate[<?php echo $row->id; ?>][id]" value="<?= $row->id ? $row->id : '-' ?>">
                                                <input type="hidden" class="final_rank" name="final_rank_alternate[<?php echo $row->id; ?>][final_rank]" value="<?php echo $row->final_rank != null ? preg_replace('/\D/', '', $row->final_rank) : null; ?>">
                                            </td>
                                            <td class="text-right">
                                                <a class="btn btn-primary btn-sm" href="<?php echo site_url('admin/selection/interview/form/' . $row->id) ?>" target="_blank">Interview Selection</a>
                                            </td>
                                        </tr>
                                <?php }
                                } else { ?>
                                    <tr ><td colspan="8">No data available in this section.</td></tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane" id="messages">
                    <div class="table-responsive mt-4">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Interview Date</th>
                                    <th>Interview Status</th>
                                    <th>Score</th>
                                    <th>Rank</th>
                                    <th>
                                        <label for="check-all-daily-rank-unchoses_status">
                                            <input type="checkbox" id="check-all-daily-rank-unchoses_status"> Lock Rank 
                                            <i style="cursor: pointer;" class="fa fa-info-circle" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top" 
                                                title="If the Rank is locked, it will not be affected by changes to the interview status or score updates.">
                                            </i>
                                        </label>
                                    </th>
                                    <th>Final Rank</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $selections = array_filter($data, function ($item) {
                                    return !in_array($item->status_interview, ['A','P']);
                                });
                                if ($selections) {
                                    $no = $paging['start_row'];
                                    

                                    foreach ($selections as $row) {
                                        $format = 'ID';
                                        if ($country_id == '2') {
                                            $format = 'US';
                                        }
                                        $fullname = $this->Grantee_ent_model->get_full_name($row, $format);
                                ?>
                                        <tr style="<?= $row->blacklist ? 'background-color:#f59494' : '' ?>">
                                            <td><?php echo $no++ ?></td>
                                            <td>
                                                <a target="_BLANK" href="<?php echo base_url('admin/users_grantee/edit/' . $row->grantee_id); ?>"><?php echo $fullname ?></a>
                                                <?php if ($row->selection_reviews && count($row->selection_reviews) > 0 && has_permission('selection', 'interview')) { ?>
                                                    <div>
                                                        Review Status :
                                                        <?php foreach ($row->selection_reviews as $review) { ?>
                                                            <?php if ($review->rank_recommendation != '') { ?>
                                                                <span class="badge <?= $review->rank_recommendation ? get_badge_status($review->rank_recommendation) : '' ?>" data-toggle="tooltip" data-placement="right" title="<?= $review->panellist_name ?>" style="cursor:default;">
                                                                    <?= $review->rank_recommendation != '' ? $review->rank_recommendation : '-' ?>
                                                                </span>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>
                                            </td>
                                            <td><?= $row->interview_date ? date('d M Y H:i', strtotime($row->interview_date)) : '-' ?></td>
                                            <td class="text-left">
                                                <?php $status_reject = [STATUS_NEW_SELECTION_WITHDRAW, STATUS_REVIEW_REJECT, STATUS_INTERVIEW_REJECT, STATUS_NEW_SELECTION_DECLINED];
                                                if (in_array($row->status_id, $status_reject)) { ?>
                                                    <button type="button" data-attach='<?= $row->attachment_withdraw ?>' data-note="<?= $row->note_selection ?>" onclick="showReason(this)" class="btn btn-primary btn-xs mt-2">View</button>
                                                <?php } else { ?>
                                                    <?php foreach ($row->data_interview as $interview) { ?>
                                                        <?php if ($interview->rank_recommendation != '') { ?>
                                                            <span class="<?= $interview->rank_recommendation ? 'badge badge-success' : 'badge badge-danger' ?>" data-toggle="tooltip" data-placement="right" title="<?= $interview->panellist_name ?>" style="cursor:default;">
                                                                <?= $interview->rank_recommendation != '' ? get_msg_status($interview->rank_recommendation) : '-' ?>
                                                            </span>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </td>
                                            <td><?= $row->score_interview ? $row->score_interview : '-' ?></td>
                                            <td><?= $row->rank_interview_date ? $row->rank_interview_date : '-' ?></td>
                                            <td>
                                                <input <?php echo $row->daily_rank_lock == 1 ? 'checked' : ''; ?> type="checkbox" name="final_rank_unchosen_status[<?php echo $row->id; ?>][daily_rank_lock]" class="daily-rank-lock-unchoses_status" value="1">
                                                <input type="hidden" name="final_rank_unchosen_status[<?php echo $row->id; ?>][daily_rank]" value="<?php echo $row->rank_interview_date != null ? preg_replace('/\D/', '', $row->rank_interview_date) : null; ?>">
                                                <input type="hidden" name="final_rank_unchosen_status[<?php echo $row->id; ?>][daily_rank_status]" value="<?php echo $row->daily_rank_lock == 1 && $row->daily_rank_status != null ? $row->daily_rank_status : $row->status_interview; ?>">
                                            </td>
                                            <td class="field_final_rank">
                                                <span><?php echo format_final_rank_status($row); ?></span>
                                                <input type="hidden" class="grantee_grant_id" name="final_rank_unchosen_status[<?php echo $row->id; ?>][id]" value="<?= $row->id ? $row->id : '-' ?>">
                                                <input type="hidden" class="final_rank" name="final_rank_unchosen_status[<?php echo $row->id; ?>][final_rank]" value="<?php echo $row->final_rank != null ? preg_replace('/\D/', '', $row->final_rank) : null; ?>">
                                            </td>
                                            <td class="text-right">
                                                <a class="btn btn-primary btn-sm" href="<?php echo site_url('admin/selection/interview/form/' . $row->id) ?>" target="_blank">Interview Selection</a>
                                            </td>
                                        </tr>
                                <?php }
                                } else { ?>
                                    <tr ><td colspan="8">No data available in this section.</td></tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>