<?php
$default_tab_active = 'class="active"';
$default_content_active = 'active in';
$pid = $this->input->get('pid');
if ($pid != '') {
    $default_tab_active = '';
    $default_content_active = '';
}
?>
<style>
    .panel-default .panel-heading-departure{
        background-color: rgb(236 240 244);
        color: #000;
        /* border-radius: 8px;
        border-top-left-radius: 8px !important;
        border-top-right-radius: 8px !important; */
        padding: 20px;
    }

    .panel-collapse{
        border: 1px solid rgb(236 240 244);
    }
    .listbox{
        border:1px solid #ddd;
        border-radius:8px;
        height:420px;
        display:flex;
        flex-direction:column
    }

    .header{
        padding:10px 15px;
        background:#fafafa;
        border-bottom:1px solid #eee;
        font-weight:bold
    }
    .search{
        padding:10px
    }
    .items{
        overflow:auto;
        flex:1;
        padding:8px}.term{padding:10px;
        border-radius:6px;
        cursor:pointer;
        margin-bottom:4px
    }
    .term.selected{
        background:#d9edf7
    }
    .actions{
        text-align:center;
        padding-top:150px
    }
    .actions .btn{
        margin:6px 0;
        width:60px
    }
    .badge-count{float:right}

</style>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?= $data->year ?? 'Add Fiscal Year' ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="row">
    <form id="form" role="form" method="POST" enctype="multipart/form-data">
        <div id="hidden"></div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Fiscal Year</label>
                                <input type="text" class="form-control" name="year" value="<?= $data->year ?? '' ?>" required>
                                <?php if($data->id) { ?>
                                    <input type="hidden" name="id" value="<?= $data->id ?>">
                                <?php } ?>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <div class="form-group">
                                    <label> Is Active </label>
                                    <input type="checkbox" value="1" name="is_active_fiscal_year" <?= (!isset($data->id)) || $data->is_active == 1 ? "checked" : "" ?>>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-5">
                                <div class="listbox">
                                    <div class="header">Available <span class="badge badge-count" id="ac"></span></div>
                                    <div class="search"><input id="sa" class="form-control" placeholder="Search..."></div>
                                    <div class="items" id="available">
                                        <?php foreach($available_terms as $a_term) { ?>
                                            <div class="term" data-id="<?= $a_term->id ?>"><?= $a_term->name ?> - <?= $a_term->year ?></div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 actions">
                                <button type="button" class="btn btn-success" id="right"><i class="fa fa-angle-right"></i></button><br>
                                <button type="button" class="btn btn-success" id="allright"><i class="fa fa-angle-double-right"></i></button><br>
                                <button type="button" class="btn btn-default" id="left"><i class="fa fa-angle-left"></i></button><br>
                                <button type="button" class="btn btn-default" id="allleft"><i class="fa fa-angle-double-left"></i></button>
                            </div>
                            <div class="col-md-5">
                                <div class="listbox">
                                    <div class="header">Assigned <span class="badge badge-count" id="cc"></span></div>
                                    <div class="search"><input id="sb" class="form-control" placeholder="Search..."></div>
                                    <div class="items" id="assigned">
                                        <?php foreach($selected_terms as $s_term) { ?>
                                            <div class="term" data-id="<?= $s_term->id ?>"><?= $s_term->name ?> - <?= $s_term->year ?></div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-12" id="grantee-container">
                                <?php foreach ($grantees as $key => $term): ?>
                                <div 
                                    class="panel-group grantee-panel" 
                                    id="grantee_<?= $term['term_id'] ?>"
                                    data-term="<?= $term['term_id'] ?>"
                                    id="accordion_<?= $term['term_id'] ?>" 
                                    role="tablist" 
                                    aria-multiselectable="true"
                                >
                                    <div class="panel panel-default">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion_<?= $term['term_id'] ?>" href="#collapse_<?= $term['term_id'] ?>" aria-expanded="true" aria-controls="collapse_<?= $term['term_id'] ?>">
                                            <div class="panel-heading panel-heading-departure text-left" role="tab" id="<?= $key ?>">
                                                <h4 class="panel-title">
                                                    <?= $term['term'] ?>
                                                </h4>
                                            </div>
                                        </a>
                                        <div id="collapse_<?= $term['term_id'] ?>" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'support_letter' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="<?= $key ?>">
                                            <div class="panel-body">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                        </tr>
                                                    </thead>
    
                                                    <tbody>
                                                    <?php foreach ($term['grantees'] as $g): ?>
                                                        <tr>
                                                            <td><?= $g->first_name . ' ' . $g->last_name ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                    </tbody>
    
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <a href="<?= site_url('admin/settings_elt/manage') ?>" class="btn btn-default">Back</a>
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>