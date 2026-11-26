<?php
$folder_tree = isset($folder_tree) ? $folder_tree : [];
$files_by_folder = isset($files_by_folder) ? $files_by_folder : [];
$all_files = isset($all_files) ? $all_files : (isset($data) ? $data : []);
if (empty($folder_tree) && !empty($resource_folders)) {
    $folder_tree = $resource_folders;
    foreach ($folder_tree as $f) { if (!isset($f->children)) $f->children = []; }
}
if (empty($files_by_folder) && !empty($data)) {
    $files_by_folder[0] = $data;
}
$total_files = 0;
if (!empty($files_by_folder)) foreach ($files_by_folder as $list) $total_files += count($list);
$total_folders = isset($all_folders) ? count($all_folders) : count($folder_tree);

function gr_file_badge_class($filepath) {
    $ext = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));
    if (in_array($ext, ['jpg','jpeg','png','gif','bmp','webp'])) return 'file-badge-img';
    switch ($ext) {
        case 'pdf': return '';
        case 'doc': case 'docx': return 'file-badge-doc';
        case 'xls': case 'xlsx': return 'file-badge-xls';
        case 'zip': return 'file-badge-zip';
        default: return 'file-badge-file';
    }
}
function gr_file_badge_label($filepath) {
    $ext = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));
    if (in_array($ext, ['jpg','jpeg','png','gif','bmp','webp'])) return 'IMG';
    switch ($ext) {
        case 'pdf': return 'PDF';
        case 'doc': case 'docx': return 'DOC';
        case 'xls': case 'xlsx': return 'XLS';
        case 'zip': return 'ZIP';
        default: return strtoupper($ext ?: 'FILE');
    }
}
function gr_render_file_row($row) {
    $badge_class = gr_file_badge_class($row->filepath);
    $badge_label = gr_file_badge_label($row->filepath);
    $added = !empty($row->created_at) ? date('d F Y', strtotime($row->created_at)) : '-';
    $added_full = !empty($row->created_at) ? date('d F Y H:i:s', strtotime($row->created_at)) : '-';
    $escaped_name = htmlspecialchars($row->filename, ENT_QUOTES);
    $dl_url = site_url($row->filepath);
    ob_start();
?>
    <div class="file-row-item" data-name="<?php echo $escaped_name; ?>" data-id="<?php echo (int)$row->id; ?>">
        <div class="file-row-left">
            <span class="pdf-badge <?php echo $badge_class; ?>"><?php echo $badge_label; ?></span>
            <div class="file-meta-info">
                <span class="file-name-text"><?php echo $escaped_name; ?></span>
                <div class="file-submeta">
                    <span>Added: <?php echo $added_full; ?></span>
                    <span><i class="fa fa-calendar-o"></i> <?php echo $added; ?></span>
                </div>
            </div>
        </div>
        <div class="file-row-actions">
            <a class="btn-action-download" href="<?php echo $dl_url; ?>" download onclick="update_download_counter(<?php echo (int)$row->id; ?>)">Download</a>
        </div>
    </div>
<?php return ob_get_clean(); }
function gr_render_folder_node($folder, $files_by_folder, $depth=0) {
    $fid=(int)$folder->id;
    $direct = isset($files_by_folder[$fid]) ? $files_by_folder[$fid] : [];
    $escaped = htmlspecialchars($folder->name, ENT_QUOTES);
    ob_start();
?>
    <div class="folder-block collapsed" id="folder-block-<?php echo $fid; ?>" data-name="<?php echo $escaped; ?>">
        <div class="folder-block-header" onclick="toggleFolder(<?php echo $fid; ?>)">
            <div class="folder-header-left">
                <span class="chevron-icon">▼</span>
                <span class="folder-title"><?php echo $escaped; ?></span>
                <span class="folder-count">(<?php echo count($direct); ?> files<?php echo !empty($folder->children) ? ', '.count($folder->children).' subfolders' : ''; ?>)</span>
            </div>
        </div>
        <div class="folder-files-container">
            <?php foreach ($direct as $f) echo gr_render_file_row($f);
                  if (!empty($folder->children)) foreach ($folder->children as $ch) echo gr_render_folder_node($ch, $files_by_folder, $depth+1);
                  if (empty($direct) && empty($folder->children)) echo '<div style="padding:12px;text-align:center;color:#94a3b8;font-size:12.5px;font-style:italic;">Folder is empty.</div>';
            ?>
        </div>
    </div>
<?php return ob_get_clean(); } ?>

<?php if (empty($folder_tree) && empty($files_by_folder[0])) { ?>
    <div class="empty-state">There are no files or directories in this section.</div>
<?php } else { ?>
    <?php $direct = isset($files_by_folder[0]) ? $files_by_folder[0] : [];
          if (!empty($direct)) { echo '<div class="direct-files-container">'; foreach ($direct as $f) echo gr_render_file_row($f); echo '</div>'; }
          foreach ($folder_tree as $root) echo gr_render_folder_node($root, $files_by_folder, 0);
    ?>
<?php } ?>
<script>
window._rm_counts = { files: <?php echo (int)$total_files; ?>, folders: <?php echo (int)$total_folders; ?> };
if (document.getElementById('summaryBadge')) document.getElementById('summaryBadge').innerText = '('+ window._rm_counts.files +' files, '+ window._rm_counts.folders +' folders)';
</script>
