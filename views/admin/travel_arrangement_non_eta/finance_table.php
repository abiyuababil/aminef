<div class="table-responsive" style="margin-top:15px;">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th width="35" class="text-center">#</th>
                <th>Periode</th>
                <th>Program</th>
                <th>Grantee Name</th>
                <th>Status</th>
                <th>Created At</th>
                <th width="255" class="text-right">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($finance_rows)): ?>
                <?php $no = $paging['start_row']; ?>
                <?php foreach ($finance_rows as $row): ?>
                    <tr>
                        <td class="text-center"><?php echo $no; ?></td>
                        <td><?php echo htmlspecialchars((string) ($row->period_fiscal_year ?? '-'), ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars((string) ($row->program_name ?? 'N/A'), ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                            <a href="<?php echo site_url('admin/grantee/edit/' . $row->user_grantee_id . '/' . $row->grant_id); ?>" class="text-primary">
                                <?php echo htmlspecialchars((string) get_full_name($row, 'US'), ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        </td>
                        <td><?php echo format_status_travel_arrangement_non_eta($row->status, $row->type); ?></td>
                        <td><?php echo $row->created_at ? date('d M Y', strtotime($row->created_at)) : 'N/A'; ?></td>
                        <td class="text-right" style="white-space:nowrap;">
                            <?php if ($row->type === 'arranged_by_aminef' && in_array((int)$row->status, [TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_APPROVED, TRAVEL_ARRANGEMENT_NON_ETA_FLIGHT_PROPOSAL_TICKET_SENT], true)): ?>
                            <a href="<?php echo site_url('admin/travel_arrangement_non_eta/download_approval/' . $row->id); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-success btn-xs">
                                <i class="fa fa-download"></i> Download Approval
                            </a>
                            <?php endif; ?>
                            <a href="<?php echo site_url('admin/travel_arrangement_non_eta/view/' . $row->id); ?>" class="btn btn-primary btn-xs">
                                <i class="fa fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    <?php $no++; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">No data available</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="clearfix">
    <div class="pull-left">
        <?php if ((int) $paging['total_rows'] > 0): ?>
            Showing <?php echo (int) $paging['start_row']; ?> to <?php echo (int) $paging['end_row']; ?> of <?php echo number_format((int) $paging['total_rows']); ?> entries
        <?php endif; ?>
    </div>
    <div class="pull-right">
        <?php echo $paging['html']; ?>
    </div>
</div>
