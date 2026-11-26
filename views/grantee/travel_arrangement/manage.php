
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header text-center">Travel Arrangement Applications</h1>
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
        <a href="<?= base_url('grantee/travel_arrangement/form') ?>" class="btn btn-primary" style="float:right"><i class="fa fa-plus"></i> New Arrangement</a>
        <?php if (!empty($history_count)) { ?>
        <a href="<?= base_url('grantee/travel_arrangement/history') ?>" class="btn btn-default" style="float:right; margin-right:8px"><i class="fa fa-history"></i> History</a>
        <?php } ?>
    </div>

    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th width="35" class="text-center">#</th>
                        <th>Travel Purpose</th>
                        <th>Type</th>
                        <th>Status</th>
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
                        <td><?= date('d M Y H:i:s', strtotime($row->created_at)) ?></td>
                        <td class="text-right">
                            <a href="<?= base_url('grantee/travel_arrangement/form/' . $row->id) ?>" class="btn btn-info btn-xs">Open</a>
                            <?php if($row->status == TRAVEL_ARRANGEMENT_NON_ETA_STATUS_DRAFT): ?>
                            <a href="<?= base_url('grantee/travel_arrangement/delete/' . $row->id) ?>" 
                               class="btn btn-danger btn-xs" 
                               onclick="return confirm('Are you sure you want to delete this application?')">Delete</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php $no++; } } else { ?>
                    <tr>
                        <td colspan="6" class="text-center" style="padding: 20px;">No applications found</td>
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
