
<?php
if (!function_exists('format_travel_history_date')) {
    // strtotime('0000-00-00') returns a negative timestamp (truthy!),
    // so explicitly reject zero-dates and pre-1970 timestamps.
    function format_travel_history_date($value, $format = 'd M Y') {
        if (empty($value)) {
            return 'N/A';
        }
        $ts = strtotime($value);
        if ($ts === false || $ts <= 0) {
            return 'N/A';
        }
        return date($format, $ts);
    }
}
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header text-center">Travel Arrangement History</h1>
    </div>
</div>

<div class="panel-body">
    <?php if($this->session->flashdata('success')) { ?>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?= $this->session->flashdata('success') ?>
        </div>
    <?php } ?>
    <?php $this->session->unset_userdata('success');?>

    <?php if($this->session->flashdata('error')) { ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?= $this->session->flashdata('error') ?>
        </div>
    <?php } ?>
    <?php $this->session->unset_userdata('error');?>

    <div class="col-lg-12 mb-3">
        <a href="<?= base_url('grantee/travel_arrangement/manage') ?>" class="btn btn-primary" style="float:right"><i class="fa fa-arrow-left"></i> Back to Active</a>
    </div>

    <div class="col-lg-12">
        <div class="alert alert-info">
            <i class="fa fa-info-circle"></i>
            Showing arrangements older than H+30 days after departure date
            (or after return date for roundtrip). Self arrangements appear
            here 30 days after their created date.
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th width="35" class="text-center">#</th>
                        <th>Travel Purpose</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Departure Date</th>
                        <th>Return Date</th>
                        <th>Created Date</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($data){ $no = isset($paging['start_row']) ? $paging['start_row'] : 1; foreach($data as $row) { ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?= html_escape($row->travel_purposes) . (in_array(strtolower(trim((string)$row->travel_purposes)), ['other', 'others'], true) && !empty($row->travel_purposes_other) ? ' (' . html_escape($row->travel_purposes_other) . ')' : '') ?></td>
                        <td><?= ucwords(str_replace('_', ' ', $row->type)) ?></td>
                        <td>
                            <?= format_status_travel_arrangement_non_eta($row->status, $row->type) ?>
                        </td>
                        <td><?= format_travel_history_date($row->departure_date) ?></td>
                        <td><?= format_travel_history_date($row->return_departure_date) ?></td>
                        <td><?= format_travel_history_date($row->created_at, 'd M Y H:i:s') ?></td>
                        <td class="text-right">
                            <a href="<?= base_url('grantee/travel_arrangement/form/' . $row->id) ?>" class="btn btn-info btn-xs">Open</a>
                        </td>
                    </tr>
                    <?php $no++; } } else { ?>
                    <tr>
                        <td colspan="8" class="text-center" style="padding: 20px;">No history found</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <?php if(isset($paging['html'])): ?>
        <div class="pull-left">
            Showing <?php echo $paging['start_row'] ?> to <?php echo $paging['end_row'] ?>
            of <?php echo number_format($paging['total_rows']) ?> entries
        </div>
        <?php echo $paging['html'] ?>
        <?php endif; ?>
    </div>
</div>
