<?php 
$applications = get_all_db('am_user_grantee_category', ['user_grantee_grant_id' => $up->grant_id, 'is_active' => 1]);
$grouped = [];

foreach ($applications as $row) {
    $key = $row->is_new_grantee; // group key
    $grouped[$key][] = $row;
}

$grouped_applications = $grouped;

?>

<div class="panel-body">
    <div class="row">
        <div class="col-sm-3">
            <div class="panel-group" id="accordion<?= $up->id ?>">
                <?php foreach ($grouped_applications as $is_new_grantee => $items): ?>
                    
                    <?php $collapseId = 'collapse_'.$up->id.'_'.$is_new_grantee; ?>

                    <div class="panel panel-primary">
                        <div class="panel-heading"
                            data-toggle="collapse"
                            data-parent="#accordion<?= $up->id ?>"
                            href="#<?= $collapseId ?>"
                            style="cursor:pointer;">

                            <a class="collapsed pull-right"
                            data-toggle="collapse"
                            data-parent="#accordion<?= $up->id ?>"
                            href="#<?= $collapseId ?>">
                                <div class="accordion-icon"></div>
                            </a>

                            <h4 class="panel-title">
                                <?= get_category_grant_page_name($is_new_grantee); ?>
                            </h4>
                        </div>

                        <div id="<?= $collapseId ?>" class="panel-collapse collapse">
                            <ul class="list-group">

                                <?php foreach ($items as $item): ?>
                                <li class="list-group-item">
                                    <a class="btn-section"
                                    data-section="submission"
                                    data-sub_section="<?= $item->id ?>"
                                    data-grantee_grant_id="<?= $up->grantee_grant_id ?>"
                                    data-up="<?= $up->id ?>"
                                    href="#">
                                        <?= $item->name ?>
                                    </a>
                                </li>
                                <?php endforeach; ?>

                            </ul>
                        </div>
                    </div>

                <?php endforeach; ?>
                </div>

        </div>

        <div class="col-sm-9 html-section<?= $up->id ?>">
            <div class="alert alert-info text-center hide" id="loading-spinner<?= $up->id ?>"><i class="fa fa-spinner fa-spin"></i> Loading, please wait.</div>
        </div>
    </div>
</div>