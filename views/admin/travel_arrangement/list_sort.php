
<div class="row mt-5">
    <div class="col-lg-12">
        <h1 style="font-size: 36px;;"><?= get_full_name($grantee_grant) ?></h1>
        <h3 class="page-header">
            <?= $grantee_grant->grant_name ?>
        </h3>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-6">

        <div class="cf nestable-lists">
            <div class="dd" id="nestable">
                <?= sort_travel_arrangement($grantee_grant->id, 0, 1, 'side', true) ?>
            </div>

        </div>
        <div class="nestable-output"></div>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
