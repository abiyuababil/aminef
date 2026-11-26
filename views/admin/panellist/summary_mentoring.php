<div class="table-responsive">
    <table id="summary-mentoring-table" class="table table-striped table-hover" data-url="<?php echo site_url('admin/panelist/summary_details_data') . '?type=mentoring&id=' . $id ?>">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Grants</th>
                <th>Period</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if (!isset($rows) || !$rows) {
            echo '<tr><td colspan="7" class="text-center">No mentoring records found.</td></tr>';
        } else {
            $no = 1;
            foreach ($rows as $r) {
                $grantee_name = trim(trim($r->first_name . ' ' . $r->middle_name) . ' ' . $r->last_name);
                $grant_name = isset($r->grant_name) ? $r->grant_name : (isset($r->grantee_grant_id) ? $r->grantee_grant_id : '');
                $period = isset($r->period_fiscal_year) ? $r->period_fiscal_year : (isset($r->period_id) ? $r->period_id : '');
                $start_date = isset($r->date) && $r->date ? date('d M Y', strtotime($r->date)) : '-';
                $end_date = isset($r->end_date) && $r->end_date ? date('d M Y', strtotime($r->end_date)) : '-';
                $status = isset($r->status) ? $r->status : '-';
                echo '<tr>';
                echo '<td>' . $no++ . '</td>';
                echo '<td>' . html_escape($grantee_name) . '</td>';
                echo '<td>' . html_escape($grant_name) . '</td>';
                echo '<td>' . html_escape($period) . '</td>';
                echo '<td>' . html_escape($start_date) . '</td>';
                echo '<td>' . html_escape($end_date) . '</td>';
                echo '<td>' . html_escape($status) . '</td>';
                echo '</tr>';
            }
        }
        ?>
        </tbody>
    </table>
</div>
