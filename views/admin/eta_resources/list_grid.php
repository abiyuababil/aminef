<?php
// Hierarchical tree mode
$folder_tree = isset($folder_tree) ? $folder_tree : [];
$files_by_folder = isset($files_by_folder) ? $files_by_folder : [];
$all_files = isset($all_files) ? $all_files : (isset($data) ? $data : []);
$resource_category_id = isset($resource_category_id) ? $resource_category_id : null;

// Fallback: if not tree mode (legacy), build flat fallback
if (empty($folder_tree) && !empty($resource_folders)) {
    $folder_tree = $resource_folders;
    // ensure children property
    foreach ($folder_tree as $f) { if (!isset($f->children)) $f->children = []; }
}
if (empty($files_by_folder) && !empty($data)) {
    // data is current folder files only (legacy) – treat as direct if no tree
    $files_by_folder[0] = $data;
}

$total_files = 0;
if (!empty($files_by_folder)) {
    foreach ($files_by_folder as $list) $total_files += count($list);
}
$total_folders = isset($all_folders) ? count($all_folders) : count($folder_tree);

function rm_file_badge_class($filepath) {
    $ext = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));
    if (in_array($ext, ['jpg','jpeg','png','gif','bmp','webp','svg','tif','tiff'])) return 'file-badge-img';
    if (in_array($ext, ['mp4','m4v','mov','webm','ogv','avi','mkv'])) return 'file-badge-vid';
    if (in_array($ext, ['mp3','wav','m4a','ogg','oga','flac'])) return 'file-badge-aud';
    switch ($ext) {
        case 'pdf': return '';
        case 'doc': case 'docx': case 'ppt': case 'pptx': return 'file-badge-doc';
        case 'xls': case 'xlsx': case 'xsl': case 'csv': return 'file-badge-xls';
        case 'zip': case 'rar': case '7z': return 'file-badge-zip';
        case 'txt': return 'file-badge-office';
        default: return 'file-badge-file';
    }
}
function rm_file_badge_label($filepath) {
    $ext = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));
    if (in_array($ext, ['jpg','jpeg','png','gif','bmp','webp','svg','tif','tiff'])) return 'IMG';
    if (in_array($ext, ['mp4','m4v','mov','webm','ogv','avi','mkv'])) return 'VID';
    if (in_array($ext, ['mp3','wav','m4a','ogg','oga','flac'])) return 'AUD';
    switch ($ext) {
        case 'pdf': return 'PDF';
        case 'doc': case 'docx': return 'DOC';
        case 'ppt': case 'pptx': return 'PPT';
        case 'xls': case 'xlsx': case 'xsl': return 'XLS';
        case 'csv': return 'CSV';
        case 'txt': return 'TXT';
        case 'zip': case 'rar': case '7z': return 'ZIP';
        default: return strtoupper($ext ?: 'FILE');
    }
}
function rm_render_file_row($row) {
    $badge_class = rm_file_badge_class($row->filepath);
    $badge_label = rm_file_badge_label($row->filepath);
    $added = !empty($row->created_at) ? date('d F Y H:i:s', strtotime($row->created_at)) : '-';
    $downloads = isset($row->download_counter) ? (int)$row->download_counter : 0;
    $is_active = !empty($row->is_active);
    $status_class = $is_active ? 'active' : 'inactive';
    $status_text = $is_active ? 'Active' : 'Inactive';
    $escaped_name = htmlspecialchars($row->filename, ENT_QUOTES);
    $escaped_filepath = htmlspecialchars($row->filepath, ENT_QUOTES);
    $dl_url = site_url($row->filepath);
    $escaped_url = htmlspecialchars($dl_url, ENT_QUOTES);
    $file_ext = strtolower(pathinfo($row->filepath, PATHINFO_EXTENSION));
    $is_audio = in_array($file_ext, ['mp3', 'wav', 'm4a', 'ogg']);
    $can_edit = has_permission('resources', 'edit');
    $can_delete = has_permission('resources', 'delete');
    $rfid = empty($row->resource_folder_id) ? 0 : (int)$row->resource_folder_id;
    ob_start();
?>
    <div class="file-row-item" data-id="<?php echo (int)$row->id; ?>" data-name="<?php echo $escaped_name; ?>" data-filepath="<?php echo $escaped_filepath; ?>" data-filename="<?php echo $escaped_name; ?>" data-url="<?php echo $escaped_url; ?>" data-is_active="<?php echo $is_active?1:0; ?>" data-resource_folder_id="<?php echo $rfid; ?>" data-resource_category_id="<?php echo (int)$row->resource_category_id; ?>">
        <div class="file-row-left">
            <button type="button" class="pdf-badge file-badge-clickable <?php echo $badge_class; ?>" onclick="openResourcePreview(<?php echo (int)$row->id; ?>)" title="Preview"><?php echo $badge_label; ?></button>
            <div class="file-meta-info">
                <button type="button" class="file-name-link" onclick="openResourcePreview(<?php echo (int)$row->id; ?>)" title="Preview"><span class="file-name-text"><?php echo $escaped_name; ?></span></button>
                <div class="file-submeta">
                    <span>Added: <?php echo $added; ?></span>
                    <span>Downloaded: <?php echo $downloads; ?> times</span>
                    <span class="badge-status-pill <?php echo $status_class; ?>"><?php echo $status_text; ?></span>
                </div>
                <?php if ($is_audio) { ?>
                    <audio class="file-audio-preview" controls preload="metadata" src="<?php echo $dl_url; ?>" style="width:100%;max-width:360px;height:36px;margin-top:6px;">Your browser does not support the audio element.</audio>
                <?php } ?>
            </div>
        </div>
        <div class="file-row-actions">
            <button type="button" class="btn-action-preview" onclick="openResourcePreview(<?php echo (int)$row->id; ?>)">Preview</button>
            <a class="btn-action-download" href="<?php echo $dl_url; ?>" download>Download</a>
            <?php if ($can_edit) { ?>
                <button type="button" class="btn-action-edit" onclick="openUploadModal(<?php echo (int)$row->id; ?>)">Edit</button>
            <?php } ?>
            <?php if ($can_delete) { ?>
                <a class="btn-action-delete" href="<?php echo site_url('admin/eta_resources/delete/'.$row->id); ?>" onclick="return confirm('Are you sure you want to delete &quot;<?php echo addslashes($row->filename); ?>&quot;?')">Delete</a>
            <?php } ?>
        </div>
    </div>
<?php
    return ob_get_clean();
}
function rm_render_folder_node($folder, $files_by_folder, $depth = 0) {
    $fid = (int)$folder->id;
    $parent_id = empty($folder->parent_id) ? 0 : (int)$folder->parent_id;
    $direct_files = isset($files_by_folder[$fid]) ? $files_by_folder[$fid] : [];
    $escaped_name = htmlspecialchars($folder->name, ENT_QUOTES);
    $can_add = has_permission('resources', 'add');
    $can_edit = has_permission('resources', 'edit');
    $can_delete = has_permission('resources', 'delete');
    ob_start();
?>
    <div class="folder-block collapsed" id="folder-block-<?php echo $fid; ?>" data-folder-id="<?php echo $fid; ?>" data-parent-id="<?php echo $parent_id; ?>" data-name="<?php echo $escaped_name; ?>">
        <div class="folder-block-header" onclick="toggleFolder(<?php echo $fid; ?>)">
            <div class="folder-header-left">
                <span class="chevron-icon">▼</span>
                <span class="folder-title"><?php echo $escaped_name; ?></span>
                <span class="folder-count">(<?php echo count($direct_files); ?> files<?php echo !empty($folder->children) ? ', '.count($folder->children).' subfolders' : ''; ?>)</span>
            </div>
            <div class="folder-header-actions" onclick="event.stopPropagation()">
                <?php if ($can_add) { ?>
                    <button type="button" class="btn-folder-action" onclick="openUploadModal(null, <?php echo $fid; ?>)">Upload to this Folder</button>
                    <button type="button" class="btn-folder-action" onclick="openFolderModal(null, <?php echo $fid; ?>)">Add Subfolder</button>
                <?php } ?>
                <?php if ($can_edit) { ?>
                    <button type="button" class="btn-folder-action" onclick="openFolderModal(<?php echo $fid; ?>)">Rename</button>
                <?php } ?>
                <?php if ($can_delete) { ?>
                    <a class="btn-folder-delete" href="<?php echo site_url('admin/eta_resources/delete_folder/'.$fid); ?>" onclick="return confirm('Delete folder &quot;<?php echo addslashes($folder->name); ?>&quot;? Files and subfolders inside will also be removed.')" style="text-decoration:none;display:inline-block;">Delete</a>
                <?php } ?>
            </div>
        </div>
        <div class="folder-files-container">
            <?php
                foreach ($direct_files as $f) {
                    echo rm_render_file_row($f);
                }
                if (!empty($folder->children)) {
                    foreach ($folder->children as $child) {
                        echo rm_render_folder_node($child, $files_by_folder, $depth+1);
                    }
                }
                if (empty($direct_files) && empty($folder->children)) {
                    echo '<div style="padding:12px;text-align:center;color:#94a3b8;font-size:12.5px;font-style:italic;">Folder is empty.</div>';
                }
            ?>
        </div>
    </div>
<?php
    return ob_get_clean();
}
?>

<?php if (empty($folder_tree) && empty($files_by_folder[0])) { ?>
    <div class="empty-state">No files or folders in this category yet. Click <strong>"Upload Resource"</strong> to upload directly, or <strong>"Add Folder"</strong> to create a sub-folder.</div>
<?php } else { ?>
    <?php
        // Direct files
        $direct = isset($files_by_folder[0]) ? $files_by_folder[0] : [];
        if (!empty($direct)) {
            echo '<div class="direct-files-container">';
            foreach ($direct as $f) {
                echo rm_render_file_row($f);
            }
            echo '</div>';
        }
        // Folder tree
        foreach ($folder_tree as $root) {
            echo rm_render_folder_node($root, $files_by_folder, 0);
        }
    ?>
<?php } ?>

<script>
// expose counts and flat folder list for selects
window._rm_counts = { files: <?php echo (int)$total_files; ?>, folders: <?php echo (int)$total_folders; ?> };
window._rm_folders = <?php echo json_encode(array_map(function($f){ return ['id'=>(int)$f->id,'parent_id'=> empty($f->parent_id)?0:(int)$f->parent_id,'name'=>$f->name,'resource_category_id'=>(int)$f->resource_category_id]; }, isset($all_folders)?$all_folders:[])); ?>;
if (document.getElementById('summaryBadge')) {
    document.getElementById('summaryBadge').innerText = '('+ window._rm_counts.files +' files, '+ window._rm_counts.folders +' folders)';
}
if (typeof rebuildFolderSelects === 'function') rebuildFolderSelects();
</script>
