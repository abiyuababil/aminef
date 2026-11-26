<div class="table-responsive">
    <table id="summary-interview-table" class="table table-striped table-hover" data-url="<?php echo site_url('admin/panelist/summary_details_data') . '?type=interview&id=' . $id ?>">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Grants</th>
                <th>Period</th>
                <th>Interview Status</th>
                <th>Interview Date</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if (!isset($rows) || !$rows) {
            echo '<tr><td colspan="7" class="text-center">No interview records found.</td></tr>';
        } else {
            $no = 1;
            foreach ($rows as $r) {
                $applicant = trim(trim($r->first_name . ' ' . $r->middle_name) . ' ' . $r->last_name);
                $grant_name = isset($r->grant_name) ? $r->grant_name : (isset($r->grantee_grant_id) ? $r->grantee_grant_id : '');
                $period = isset($r->period_fiscal_year) ? $r->period_fiscal_year : (isset($r->period_id) ? $r->period_id : '');
                $rr = isset($r->rank_recommendation) ? $r->rank_recommendation : '';
                if ($rr === '2' || $rr === 2) {
                    $rr = 'HR';
                } elseif ($rr === '1' || $rr === 1) {
                    $rr = 'R';
                } elseif ($rr === '0' || $rr === 0) {
                    $rr = 'NR';
                }
                $interview_date = '';
                if (isset($r->date) && $r->date) {
                    $interview_date = date('d M Y', strtotime($r->date));
                } elseif (isset($r->interview_date) && $r->interview_date) {
                    $interview_date = date('d M Y', strtotime($r->interview_date));
                }
                $score = isset($r->score) ? $r->score : '';
                echo '<tr>';
                echo '<td>' . $no++ . '</td>';
                echo '<td>' . html_escape($applicant) . '</td>';
                echo '<td>' . html_escape($grant_name) . '</td>';
                echo '<td>' . html_escape($period) . '</td>';
                $badge_class = $rr ? get_badge_status($rr) : '';
                $status_display = $rr ? html_escape($rr) : '-';
                echo '<td><span class="' . $badge_class . '" style="cursor:default;">' . $status_display . '</span></td>';
                echo '<td>' . html_escape($interview_date) . '</td>';
                $interview_id = isset($r->id) ? $r->id : '';
                $period_id = isset($r->period_id) ? $r->period_id : '';
                if ($score !== '' && $interview_id !== '') {
                    echo '<td><a href="#" class="interview-score" data-id="' . $interview_id . '" data-period_id="' . $period_id . '">' . html_escape($score) . '</a></td>';
                } else {
                    echo '<td>-</td>';
                }
                echo '</tr>';
            }
        }
        ?>
        </tbody>
    </table>
</div>
