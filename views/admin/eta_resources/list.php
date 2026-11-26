<link href="<?php echo base_url('css/resources-manage.css?v='.time()); ?>" rel="stylesheet">
<div class="resources-manage-wrapper">
    <div class="page-title">Manage ETA Resources</div>

    <?php if ($this->session->flashdata('info')) { ?>
        <div class="alert alert-success" style="margin-bottom:16px;"><i class="fa fa-info-circle"></i> <?php echo $this->session->flashdata('info'); $this->session->set_flashdata('info', false); ?></div>
    <?php } ?>

    <?php if (!$resource_categories) { ?>
        <div class="alert alert-danger"><i class="fa fa-info-circle"></i> Please add Resource Category.</div>
    <?php } else { ?>
        <!-- Category Tabs (Tanpa Ikon) -->
        <div class="category-nav-container">
            <div class="category-nav" id="categoryNavList">
                <?php foreach ($resource_categories as $index => $category) { ?>
                    <button class="category-tab <?php echo $index==0?'active':''; ?>" data-id="<?php echo $category->id; ?>" data-name="<?php echo htmlspecialchars($category->name, ENT_QUOTES); ?>" onclick="selectCategory('<?php echo $category->id; ?>')"><?php echo htmlspecialchars($category->name); ?></button>
                <?php } ?>
            </div>
        </div>

        <!-- Toolbar -->
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
                <?php if (has_permission('resources', 'add')) { ?>
                    <button type="button" class="btn-toolbar-folder" onclick="openFolderModal(null)">Add Folder</button>
                    <button type="button" class="btn-primary-upload" onclick="openUploadModal(null, 0)">Upload Resource</button>
                <?php } ?>
            </div>
        </div>

        <!-- Content Area -->
        <div id="categoryContentArea"></div>
    <?php } ?>
</div>

<!-- Folder Modal -->
<div class="modal fade" id="folderModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFolderHeading">Add New Folder</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" enctype="multipart/form-data" action="<?php echo site_url('admin/eta_resources/save_folder'); ?>" id="folderForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label style="font-size:13px;font-weight:600;">Parent Folder <small style="font-weight:400;color:#64748b;">(hierarki nested)</small></label>
                        <select class="form-control" id="folderParentSelect" name="parent_id">
                            <option value="">-- Root / Main --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label style="font-size:13px;font-weight:600;">Folder Name *</label>
                        <input type="text" class="form-control" id="folderNameInput" name="name" placeholder="e.g. 01. Pre-Departure Documents" required style="margin-top:4px;">
                        <input type="hidden" id="folderIdInput" name="id">
                    </div>
                    <div class="form-group hide">
                        <input type="hidden" name="resource_category_id" id="folderResourceCategoryId" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- File Modal (Upload / Edit) -->
<div class="modal fade" id="fileModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFileTitle">Upload Resource Document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <form method="POST" action="<?php echo site_url('admin/eta_resources/add_file'); ?>" class="dropzone" id="fileDropzone" enctype="multipart/form-data" style="border:1px dashed #013473;border-radius:10px;">
                    </form>
                    <small style="font-size:11px;color:#64748b;">Drop file here or click. Supports PDF, images, documents, ZIP, and MP3 audio.</small>
                </div>
            </div>
            <form method="POST" enctype="multipart/form-data" id="fileForm">
                <div class="modal-body" style="padding-top:0;">
                    <div class="form-group">
                        <label style="font-size:12.5px;font-weight:600;">Upload Destination</label>
                        <select class="form-control" id="formFolderSelect" name="resource_folder_id" style="margin-top:4px;"></select>
                    </div>
                    <div class="form-group">
                        <label style="font-size:12.5px;font-weight:600;">Document Title / Display Name *</label>
                        <input type="text" class="form-control" id="formDocTitleInput" name="filename" placeholder="File Name" required style="margin-top:4px;">
                    </div>
                    <div class="form-group">
                        <label style="font-size:12.5px;font-weight:600;">Status</label>
                        <select class="form-control" id="formDocStatusSelect" name="is_active" style="margin-top:4px;">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="form-group hide">
                        <input type="hidden" name="id" id="fileIdInput">
                        <input type="hidden" name="filepath" id="filePathInput" required>
                        <input type="hidden" name="resource_category_id" id="fileResourceCategoryId" required>
                    </div>
                    <div id="currentFileInfo" class="current-file-box" style="display:none;">Current file: <strong id="currentFileNameText" style="margin-left:4px;"></strong></div>
                    <span id="fileInputHint" style="font-size:11px;color:#64748b;display:none;">Leave empty to keep existing file (or re-drop new file).</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Preview Modal (lightbox-style: image/PDF via lightbox, video via iframe) -->
<div class="modal fade" id="resourcePreviewModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resourcePreviewTitle" style="font-weight:700;">Preview</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="preview-stage" id="resourcePreviewBody"></div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-success" id="resourcePreviewDownload" href="#" download><i class="fa fa-download"></i> Download</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Hidden fallback for original code expectations -->
<div style="display:none;">
    <input type="hidden" id="legacy_resource_category_id">
</div>
