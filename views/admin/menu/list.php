<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Menu Management</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <form method="get" class="form-inline menu-filter-bar">
            <div class="form-group mr-2">
                <label for="menu_type_id">Menu Type</label>
                <select name="menu_type_id" id="menu_type_id" class="form-control ml-2">
                    <option value="">All Menu Types</option>
                    <?php foreach ($menu_type_ids as $menu_type_id) : ?>
                        <option value="<?= $menu_type_id ?>" <?= $selected_menu_type_id === $menu_type_id ? 'selected' : '' ?>>
                            <?= $menu_type_id ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="<?= base_url('admin/menu/manage') ?>" class="btn btn-default">Reset</a>
        </form>

        <p class="help-block">
            Drag and drop untuk mengubah urutan `sort` dan relasi `parent` menu. Tree akan menampilkan parent, sub menu, dan sub menu berikutnya jika ada.
        </p>

        <?php if ($menu_tree_html) : ?>
            <div class="cf nestable-lists">
                <div class="dd" id="nestable">
                    <?= $menu_tree_html ?>
                </div>
            </div>
            <div class="nestable-output"></div>
        <?php else : ?>
            <div class="alert alert-info menu-management-empty">
                Tidak ada data menu untuk filter yang dipilih.
            </div>
        <?php endif; ?>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
