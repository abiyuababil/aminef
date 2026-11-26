<div class="table-responsive">
    <table id="summary-pdo-table" class="table table-striped table-hover" data-url="<?php echo site_url('admin/panelist/summary_details_data') . '?type=pdo&id=' . $id ?>">
        <thead>
            <tr>
                <th>#</th>
                <th>Grants</th>
                <th>Period</th>
                <th>Agenda</th>
                <th>Participants</th>
                <th>Final Biosketch of Speakers</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $CI = &get_instance();
        if (!isset($rows)) {
            $rows = $CI->Panellists_model->get_pdo_by_panellist($id);
        }
        if ($rows) {
            $no = 1;
            foreach ($rows as $r) {
                $CI = &get_instance();
                $grants_display = '';
                if (!empty($r->user_grantee_grant_id)) {
                    $grant_ids = array_filter(array_map('trim', explode(',', $r->user_grantee_grant_id)));
                    $grant_names = [];
                    foreach ($grant_ids as $gid) {
                        $g = get_row_db('am_user_grantee_grant', ['id' => $gid]);
                        if ($g) $grants_display .= $g->name . '<br/>';
                    }
                }

                $period = isset($r->fiscal_year) ? $r->fiscal_year : '';
                $created = isset($r->created_at) ? $r->created_at : (isset($r->created_date) ? $r->created_date : '');

                $agenda_btn = $r->agenda ? '<a href="' . base_url($r->agenda) . '" class="btn btn-primary lightbox">View</a>' : '';
                $participant_btn = $r->participant ? '<a href="' . base_url($r->participant) . '" class="btn btn-primary lightbox">View</a>' : '';
                $biosketch_btn = $r->final_biosketch_of_speakers ? '<a href="' . base_url($r->final_biosketch_of_speakers) . '" class="btn btn-primary lightbox">View</a>' : '';

                echo '<tr>';
                echo '<td>' . $no++ . '</td>';
                echo '<td>' . $grants_display . '</td>';
                echo '<td>' . html_escape($period) . '</td>';
                echo '<td>' . $agenda_btn . '</td>';
                echo '<td>' . $participant_btn . '</td>';
                echo '<td>' . $biosketch_btn . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="6" class="text-center">No PDO records found.</td></tr>';
        }
        ?>
        </tbody>
    </table>
</div>
