<div class="table-responsive">
    <table id="summary-review-table" class="table table-striped table-hover" data-url="<?php echo site_url('admin/panelist/summary_details_data') . '?type=review&id=' . $id ?>">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Grants</th>
                <th>Period</th>
                <th>Review Status</th>
                <th>Review Start Date</th>
                <th>Review End Date</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if (!isset($rows) || !$rows) {
            echo '<tr><td colspan="8" class="text-center">No review records found.</td></tr>';
        } else {
            $no = 1;
            foreach ($rows as $r) {
                $applicant = trim(trim($r->first_name . ' ' . $r->middle_name) . ' ' . $r->last_name);
                $grant_name = isset($r->grant_name) ? $r->grant_name : (isset($r->grantee_grant_id) ? $r->grantee_grant_id : '');
                $period = isset($r->period_fiscal_year) ? $r->period_fiscal_year : (isset($r->period_id) ? $r->period_id : '');
                $status = isset($r->rank_recommendation) ? $r->rank_recommendation : (isset($r->status) ? $r->status : '');
                $start_date = isset($r->date) ? date('d M Y', strtotime($r->date)) : '';
                $end_date = isset($r->end_date) ? date('d M Y', strtotime($r->end_date)) : '';
                $score = isset($r->score) ? $r->score : '';
                echo '<tr>';
                echo '<td>' . $no++ . '</td>';
                echo '<td>' . html_escape($applicant) . '</td>';
                echo '<td>' . html_escape($grant_name) . '</td>';
                echo '<td>' . html_escape($period) . '</td>';
                echo '<td>' . html_escape($status) . '</td>';
                echo '<td>' . html_escape($start_date) . '</td>';
                echo '<td>' . html_escape($end_date) . '</td>';
                $review_id = isset($r->id) ? $r->id : '';
                $period_id = isset($r->period_id) ? $r->period_id : '';
                $score_display = $score !== '' ? html_escape($score) : '-';
                echo '<td><a href="javascript:;" class="score-detail" data-id="' . $review_id . '" data-period_id="' . $period_id . '">' . $score_display . '</a></td>';
                echo '</tr>';
            }
            }
        
        ?>
        </tbody>
    </table>
</div>
