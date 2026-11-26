<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">View Reports</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <form id="frm_manage" method="GET">
            <div class="data-header clearfix form-inline">
                <div class="pull-left">
                    Grants: 
                    <select name="program" id="" class="form-control" onchange="document.forms.frm_manage.submit()">
                        <option value="">All</option>
                        
                        <?php foreach ($grants as $key => $value) {
                            $selected = '';
                            if ($value->id == $this->input->get('program')) {
                                $selected = 'selected';
                            }
                        ?>
                            <option value="<?=   $value->id?>" <?= $selected; ?>><?=$value->name?> <?php echo $value->year ? ' - ' . $value->year : ''; ?></option>
                        <?php }?>
                    </select>
                    Fiscal Years: 
                    <select name="fiscal_year" id="" class="form-control" onchange="document.forms.frm_manage.submit()">
                        <option value="current_last" <?= $paging['fiscal_year'] === 'current_last' ? 'selected' : ''; ?>><?= date('Y') ?> & <?= date('Y') - 1 ?></option>
                        <option value="" <?= $paging['fiscal_year'] === '' ? 'selected' : ''; ?>>All</option>
                        <?php for($i = date("Y");$i>1900;$i--):?>
                            <?php $selected = $i == $paging['fiscal_year'] ? 'selected' : '';?>
                            <option value="<?= $i?>" <?=$selected;?>><?=$i?></option>
                        <?php endfor;?>
                    </select>
                    Show :
                    <select class="form-control input-sm" name="limit" onchange="document.forms.frm_manage.submit()">
                        <?php
                        foreach ($limit_options as $lo) {
                                $selected = '';
                                if ($lo == $paging['limit']) $selected = 'selected';
                        ?>
                            <option value="<?php echo $lo ?>" <?php echo $selected ?>><?php echo $lo ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="30"><input type="checkbox" class="chk-all"></th>
                            <th width="35" class="text-center">#</th>
                            <th>Grant</th>
                            <th>Fiscal Years</th>
                            <th>Grantee Reports</th>
                            <th width="200" class="text-center">Summary Reports</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data) {
                            $no = $paging['start_row'];
                            foreach ($data as $row) {
                                foreach ($row->fiscal_year as $key_fiscal_year => $fiscal_year) {
                        ?>
                        
                                <tr>
                                    <?php if ($key_fiscal_year == 0) : ?>
                                    <td rowspan="<?= count($row->fiscal_year);?>"><input type="checkbox" class="chk-row" name="ids[]" value="<?php echo $row->staff_id ?>"></td>
                                    <td rowspan="<?= count($row->fiscal_year);?>"><?= $no ?></td>
                                    <td rowspan="<?= count($row->fiscal_year);?>"><?= $row->name ?></td>
                                    <?php endif;?>
                                    <td><?= $fiscal_year['fiscal_year']; ?></td>
                                    <td><a href="<?= site_url('admin/report/detail_report/'.$row->id.'/'.$fiscal_year['fiscal_year']) ?>" class="btn btn-primary btn-xs">View Reports</a></td>
                                    <td>
                                        <?php 
                                            if (count($row->category_report) > 0) :
                                            foreach($row->category_report as $key => $value) :
                                        ?>
                                            <a href="<?= site_url('admin/user_grantee_grant/view_result_period/'.$row->id.'/'.$fiscal_year['fiscal_year'].'/'.$value['id']) ?>" class="btn btn-primary btn-xs">Aminef <?= $value['name']?></a>
                                        <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </td>
                                </tr>
                        <?php
                            }
                            $no++;   
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
            <div class="pull-left">
                Showing <?php echo $paging['start_row'] ?> to <?php echo $paging['end_row'] ?> of <?php echo $paging['total_rows'] ?> entries
            </div>
            <!-- /.pagination info -->
            <?php echo $paging['html'] ?>
            <!-- /.pagination -->
            <input type="hidden" name="sort_by" value="<?php echo $sort_by ?>">
            <input type="hidden" name="sort" value="<?php echo $sort ?>">
        </form>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
