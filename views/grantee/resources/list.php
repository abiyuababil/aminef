<link href="<?php echo base_url('css/resources-manage.css?v='.time()); ?>" rel="stylesheet">
<div class="resources-manage-wrapper" style="background:#f0f3f6;">
    <div class="page-title">Resources</div>
    <?php if (!$resource_categories) { ?>
        <div class="alert alert-danger"><i class="fa fa-info-circle"></i> No resources available.</div>
    <?php } else { ?>
        <div class="category-nav-container">
            <div class="category-nav" id="categoryNavList">
                <?php foreach ($resource_categories as $index => $category) { ?>
                    <button class="category-tab <?php echo $index==0?'active':''; ?>" data-id="<?php echo $category->id; ?>" data-name="<?php echo htmlspecialchars($category->name, ENT_QUOTES); ?>" onclick="selectCategory('<?php echo $category->id; ?>')"><?php echo htmlspecialchars($category->name); ?></button>
                <?php } ?>
            </div>
        </div>
        <div class="toolbar-header">
            <div class="category-name-badge">
                <span id="activeCategoryName"><?php echo $resource_categories ? htmlspecialchars($resource_categories[0]->name) : ''; ?></span>
                <span style="font-size:12px;font-weight:normal;color:#64748b;" id="summaryBadge"></span>
            </div>
            <div class="toolbar-right-actions">
                <div class="search-box">
                    <span class="search-icon">🔍</span>
                    <input type="text" class="search-input" id="searchResourceInput" placeholder="Search resources..." oninput="filterResources()">
                </div>
            </div>
        </div>
        <div id="categoryContentArea"></div>
    <?php } ?>
</div>
