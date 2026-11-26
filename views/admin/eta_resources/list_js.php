<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<script>
var currentCategoryId = null;

$(document).ready(function(){
    <?php if (has_permission('resources', 'add') || has_permission('resources', 'edit')) { ?>
        Dropzone.options.fileDropzone = {
            addRemoveLinks:true,
            addPreview:true,
            dictRemoveFile: "Remove File",
            dictDefaultMessage: "Drop file here to upload",
            paramName: "file",
            success: function(file, response) {
                try {
                    let obj = typeof response === 'string' ? JSON.parse(response) : response;
                    $("#filePathInput").val(obj.filepath);
                    $("#currentFileNameText").text(file.name);
                    $("#currentFileInfo").show();
                } catch(e) { console.error(e); }
            },
            error: function(file, response) {
                console.error(response);
            }
        };
    <?php } ?>

    // init category from localStorage or first tab
    let stored = localStorage.getItem('eta_resource_category_id');
    let firstId = $('.category-tab:first').data('id');
    currentCategoryId = stored || firstId;
    if (!currentCategoryId && firstId) currentCategoryId = firstId;
    if (currentCategoryId) {
        selectCategory(currentCategoryId);
    }

    // file form submit keeps is_active boolean mapping already via select 1/0
});

function selectCategory(catId) {
    currentCategoryId = catId;
    localStorage.setItem('eta_resource_category_id', catId);
    $('#searchResourceInput').val('');
    $('.category-tab').removeClass('active');
    $('.category-tab[data-id="'+catId+'"]').addClass('active');
    let name = $('.category-tab[data-id="'+catId+'"]').data('name');
    if (name) $('#activeCategoryName').text(name);
    loadCategoryTree(catId);
}

function loadCategoryTree(category_id) {
    $('#categoryContentArea').html('<div style="padding:40px;text-align:center;color:#94a3b8;"><i class="fa fa-spinner fa-spin"></i> Loading...</div>');
    $.ajax({
        url: '<?php echo site_url('admin/eta_resources/get_list_ajax'); ?>?resource_category_id='+category_id+'&mode=tree',
        type: 'GET',
        dataType: 'JSON',
        success: function(response) {
            if (response.success) {
                $('#categoryContentArea').html(response.html);
                // _rm_folders set by inline script in html, rebuild selects
                rebuildFolderSelects();
            }
        },
        error: function(xhr){ alert('Failed to load resources: '+xhr.responseText); }
    });
}

function rebuildFolderSelects() {
    let catId = currentCategoryId;
    let folders = window._rm_folders || [];
    // Build hierarchical options with indent
    function buildOptions(selectId, selectedId) {
        let $sel = $(selectId);
        if (!$sel.length) return;
        $sel.empty();
        $sel.append('<option value="0">'+ (selectId==='#folderParentSelect' ? '-- Root / Main --' : ($('#activeCategoryName').text()+' (Root / Main)')) +'</option>');
        // Build tree map
        let byId = {};
        folders.forEach(f=>{ f.children=[]; byId[f.id]=f; });
        let roots = [];
        folders.forEach(f=>{
            if (f.parent_id && byId[f.parent_id]) byId[f.parent_id].children.push(f);
            else roots.push(f);
        });
        function addOpts(nodes, depth){
            nodes.sort((a,b)=> a.name.localeCompare(b.name));
            nodes.forEach(n=>{
                let prefix = depth>0 ? '—'.repeat(depth)+' ' : '';
                // For file destination, prefix with arrow
                if (selectId==='#formFolderSelect' && depth>0) prefix = '↳ '+'—'.repeat(depth-1)+' ';
                let opt = $('<option>').val(n.id).text(prefix+n.name);
                if (String(selectedId)===String(n.id)) opt.prop('selected', true);
                $sel.append(opt);
                if (n.children.length) addOpts(n.children, depth+1);
            });
        }
        addOpts(roots, 0);
        if (selectedId!==null && selectedId!==undefined) $sel.val(selectedId);
    }
    // Defer to ensure _rm_folders available
    setTimeout(()=>{
        // keeps current selection if editing
        let currentFolderVal = $('#formFolderSelect').data('selected') || 0;
        buildOptions('#formFolderSelect', currentFolderVal);
        buildOptions('#folderParentSelect', $('#folderParentSelect').data('selected') || '');
    }, 50);
    // Also rebuild immediately generic
    let sel1 = $('#formFolderSelect');
    if (sel1.length && !sel1.data('selected')) {
        // populate quickly if not editing
        let html = '<option value="0">'+$('#activeCategoryName').text()+' (Root / Main)</option>';
        // flat fallback if tree not ready
        if (folders.length && !window._rm_folders_built) {
            // will be rebuilt after timeout
        }
    }
}

function filterResources() {
    let q = $('#searchResourceInput').val().toLowerCase();
    if (!q) {
        $('.file-row-item').show();
        $('.folder-block').show();
        $('.folder-block .folder-block').show();
        // clear empty hints
        return;
    }
    $('.file-row-item').each(function(){
        let name = ($(this).data('name')||'').toString().toLowerCase();
        let fp = ($(this).data('filepath')||'').toString().toLowerCase();
        if (name.indexOf(q)>-1 || fp.indexOf(q)>-1) $(this).show(); else $(this).hide();
    });
    // hide folder-blocks with no visible children
    $('.folder-block').each(function(){
        let $block = $(this);
        let hasVisibleFile = $block.find('> .folder-files-container > .file-row-item:visible').length > 0;
        let hasVisibleSub = $block.find('> .folder-files-container > .folder-block:visible').length > 0;
        // check if any nested visible
        let anyVisible = $block.find('.file-row-item:visible').length > 0;
        if (q && !anyVisible && !$block.find('> .folder-files-container > .file-row-item').length && $block.find('.file-row-item').length===0) {
            // keep folders with name match?
            let fname = ($block.data('name')||'').toString().toLowerCase();
            if (fname.indexOf(q)>-1) $block.show();
            else $block.hide();
        } else if (q && !anyVisible) {
            $block.hide();
        } else {
            $block.show();
            // expand if has match
            if (anyVisible) $block.removeClass('collapsed');
        }
    });
    // direct files container visibility
    let directVisible = $('.direct-files-container .file-row-item:visible').length;
    if (q && directVisible===0) $('.direct-files-container').hide(); else $('.direct-files-container').show();
}

function toggleFolder(folderId){
    let el = document.getElementById('folder-block-'+folderId);
    if (el) el.classList.toggle('collapsed');
}

function openFolderModal(folderId, parentHint){
    let isEdit = folderId !== null && folderId !== undefined;
    let catId = currentCategoryId;
    $('#folderResourceCategoryId').val(catId);
    $('#folderParentSelect').data('selected', '');
    if (isEdit) {
        let $el = $('#folder-block-'+folderId);
        let name = $el.data('name') || '';
        let parentId = $el.data('parent-id') || '';
        $('#modalFolderHeading').text('Rename Folder');
        $('#folderNameInput').val(name);
        $('#folderIdInput').val(folderId);
        $('#folderParentSelect').data('selected', parentId);
        rebuildFolderSelects();
        // prevent selecting self as parent
        setTimeout(()=>{
            $('#folderParentSelect option[value="'+folderId+'"]').prop('disabled', true);
            // also disable descendants
            // simple: will be validated server side
        }, 100);
    } else {
        $('#modalFolderHeading').text(parentHint ? 'Add Subfolder' : 'Add New Folder to '+$('#activeCategoryName').text());
        $('#folderNameInput').val('');
        $('#folderIdInput').val('');
        let parentVal = parentHint || '';
        $('#folderParentSelect').data('selected', parentVal);
        rebuildFolderSelects();
        setTimeout(()=>{
            if (parentVal) $('#folderParentSelect').val(parentVal);
        }, 100);
    }
    // rebuild options before show
    if (window._rm_folders) rebuildFolderSelects();
    $('#folderModal').modal('show');
}

function openUploadModal(fileId, defaultFolderId){
    let catId = currentCategoryId;
    $('#fileResourceCategoryId').val(catId);
    $('#fileForm')[0].reset();
    $('#filePathInput').val('');
    $('#fileIdInput').val('');
    $('#currentFileInfo').hide();
    $('#fileInputHint').hide();
    if (Dropzone.instances.length>0){
        Dropzone.instances.forEach(dz=>dz.removeAllFiles(true));
    }
    // ensure folder selects built
    $('#formFolderSelect').data('selected', defaultFolderId||0);
    rebuildFolderSelects();
    setTimeout(()=>{
        if (defaultFolderId) $('#formFolderSelect').val(defaultFolderId);
    }, 100);

    if (fileId) {
        // edit mode: pull from DOM
        let $row = $('.file-row-item[data-id="'+fileId+'"]');
        if ($row.length) {
            let name = $row.data('filename') || $row.data('name');
            let is_active = $row.data('is_active');
            let folderId = $row.data('resource_folder_id') || 0;
            let filepath = $row.data('filepath');
            $('#modalFileTitle').text('Edit Resource Document');
            $('#formDocTitleInput').val(name);
            $('#fileIdInput').val(fileId);
            $('#filePathInput').val(filepath);
            $('#formDocStatusSelect').val(is_active==1?1:0);
            $('#formFolderSelect').data('selected', folderId);
            rebuildFolderSelects();
            setTimeout(()=> $('#formFolderSelect').val(folderId), 120);
            $('#currentFileNameText').text(filepath ? filepath.split('/').pop() : '');
            $('#currentFileInfo').show();
            $('#fileInputHint').show();
        } else {
            // fallback fetch via ajax detail
            $.getJSON('<?php echo site_url('admin/eta_resources/detail'); ?>/'+fileId, function(res){
                if(res.success){
                    // parse html fallback? just open empty
                }
            });
            $('#modalFileTitle').text('Edit Resource Document');
        }
    } else {
        $('#modalFileTitle').text('Upload Resource Document');
        $('#formDocTitleInput').val('');
        $('#formDocStatusSelect').val(1);
        $('#formFolderSelect').val(defaultFolderId||0);
    }
    $('#fileModal').modal('show');
}

// legacy compat shims
function show_upload_form(cat, folder){ openUploadModal(null, folder); }
function show_create_folder_form(cat, fid, el){
    if (el && el.data && el.data('id')) openFolderModal(el.data('id'));
    else openFolderModal(null, el?el.data('parent_id'):null);
}
function load_tab(catId){ selectCategory(catId); }
function open_folder(fid, catId){
    // in tree mode just expand folder
    let el = document.getElementById('folder-block-'+fid);
    if (el){ el.classList.remove('collapsed'); el.scrollIntoView({behavior:'smooth', block:'center'}); }
}

// ---------- Preview (popup lightbox-style) ----------
function rm_escape_html(s){ return String(s==null?'':s).replace(/[&<>"']/g, function(c){ return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]; }); }
function rm_youtube_embed(url){
    var m = url.match(/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([\w-]{6,})/i);
    return m ? 'https://www.youtube.com/embed/'+m[1]+'?autoplay=1&rel=0' : null;
}
function rm_vimeo_embed(url){
    var m = url.match(/vimeo\.com\/(?:video\/)?(\d+)/i);
    return m ? 'https://player.vimeo.com/video/'+m[1]+'?autoplay=1' : null;
}
// ---------- Office preview client-side (tanpa Google viewer) ----------
var _rm_script_cache = {};
function rm_load_script(src){
    if (_rm_script_cache[src]) return _rm_script_cache[src];
    _rm_script_cache[src] = new Promise(function(resolve, reject){
        var s = document.createElement('script');
        s.src = src; s.async = true;
        s.onload = function(){ resolve(); };
        s.onerror = function(){ reject(new Error('Gagal memuat '+src)); };
        document.head.appendChild(s);
    });
    return _rm_script_cache[src];
}
function rm_office_loading_html(){
    return '<div class="preview-fallback"><p><i class="fa fa-spinner fa-spin"></i> Memuat pratinjau dokumen...</p></div>';
}
function rm_office_error_html(name, url, detail){
    return '<div class="preview-fallback"><p><strong>'+rm_escape_html(name)+'</strong></p>'
        + '<p>Gagal menampilkan pratinjau.'+(detail ? ' ('+rm_escape_html(detail)+')' : '')+'</p>'
        + '<p><a class="btn btn-success btn-sm" href="'+rm_escape_html(url)+'" download><i class="fa fa-download"></i> Download untuk melihat</a></p></div>';
}
function rm_render_docx_preview(url, name){
    var $body = $('#resourcePreviewBody');
    $body.html(rm_office_loading_html());
    rm_load_script('https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.6.0/mammoth.browser.min.js').then(function(){
        return fetch(url, {credentials: 'same-origin'});
    }).then(function(res){
        if (!res.ok) throw new Error('HTTP '+res.status);
        return res.arrayBuffer();
    }).then(function(buf){
        return mammoth.convertToHtml({arrayBuffer: buf});
    }).then(function(result){
        var warn = '';
        if (result.messages && result.messages.length) {
            warn = '<p class="office-note">Sebagian format mungkin tidak tampil persis seperti aslinya.</p>';
        }
        $body.html('<div class="office-doc-wrap">'+warn+result.value+'</div>');
    }).catch(function(err){
        $body.html(rm_office_error_html(name, url, err && err.message));
    });
}
function rm_render_sheet_preview(url, name, ext){
    var $body = $('#resourcePreviewBody');
    $body.html(rm_office_loading_html());
    var MAX_ROWS = 200, MAX_COLS = 50;
    rm_load_script('https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js').then(function(){
        return fetch(url, {credentials: 'same-origin'});
    }).then(function(res){
        if (!res.ok) throw new Error('HTTP '+res.status);
        if (ext === 'csv') return res.text().then(function(t){ return {text: t}; });
        return res.arrayBuffer().then(function(b){ return {buf: b}; });
    }).then(function(data){
        var wb = data.text !== undefined
            ? XLSX.read(data.text, {type: 'string'})
            : XLSX.read(data.buf, {type: 'array'});
        if (!wb.SheetNames.length) throw new Error('Workbook kosong');
        var out = '';
        wb.SheetNames.forEach(function(sn, idx){
            var ws = wb.Sheets[sn];
            var rows = XLSX.utils.sheet_to_json(ws, {header: 1, defval: '', blankrows: false});
            var totalRows = rows.length;
            var maxCols = rows.reduce(function(m, r){ return Math.max(m, r.length); }, 0);
            var shown = rows.slice(0, MAX_ROWS).map(function(r){ return r.slice(0, MAX_COLS); });
            out += '<div class="office-sheet-name">Sheet: '+rm_escape_html(sn)+' ('+totalRows+' baris'+(maxCols ? ', '+maxCols+' kolom' : '')+')</div>';
            if (!shown.length || !shown[0].length) {
                out += '<p class="office-note">Sheet kosong.</p>';
                return;
            }
            out += '<table class="office-sheet-table"><tbody>';
            shown.forEach(function(r){
                out += '<tr>';
                r.forEach(function(c){ out += '<td>'+rm_escape_html(c === null || c === undefined ? '' : String(c))+'</td>'; });
                out += '</tr>';
            });
            out += '</tbody></table>';
            if (totalRows > MAX_ROWS || maxCols > MAX_COLS) {
                out += '<p class="office-note">Menampilkan '+Math.min(totalRows, MAX_ROWS)+' baris pertama. Download file untuk melihat seluruhnya.</p>';
            }
        });
        $body.html('<div class="office-doc-wrap">'+out+'</div>');
    }).catch(function(err){
        $body.html(rm_office_error_html(name, url, err && err.message));
    });
}
function openResourcePreview(fileId){
    var $row = $('.file-row-item[data-id="'+fileId+'"]');
    if (!$row.length) return;
    var name = $row.data('filename') || $row.data('name') || 'Preview';
    var filepath = ($row.data('filepath') || '').toString();
    var url = ($row.data('url') || filepath).toString();
    $('#resourcePreviewTitle').text(name);
    $('#resourcePreviewDownload').attr('href', url);
    var $body = $('#resourcePreviewBody');
    var lowerUrl = url.toLowerCase().split('?')[0].split('#')[0];
    var ext = lowerUrl.indexOf('.') > -1 ? lowerUrl.split('.').pop() : '';
    var yt = rm_youtube_embed(url), vm = rm_vimeo_embed(url);
    var html = '';
    var imgExt = ['jpg','jpeg','png','gif','bmp','webp','svg','tif','tiff'];
    var videoExt = ['mp4','m4v','mov','webm','ogv','avi','mkv'];
    var audioExt = ['mp3','wav','m4a','ogg','oga','flac'];
    var officeExt = ['doc','docx','ppt','pptx'];
    var sheetExt = ['xls','xlsx','xsl','csv'];
    if (yt || vm) {
        // video (YouTube/Vimeo) pakai iframe
        html = '<iframe src="'+rm_escape_html(yt||vm)+'" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>';
    } else if (imgExt.indexOf(ext) > -1) {
        // image pakai lightbox-style <img>
        html = '<img src="'+rm_escape_html(url)+'" alt="'+rm_escape_html(name)+'">';
    } else if (ext === 'pdf') {
        // PDF pakai lightbox-style iframe
        html = '<iframe src="'+rm_escape_html(url)+'"></iframe>';
    } else if (videoExt.indexOf(ext) > -1) {
        // video lokal pakai <video> dalam popup iframe-style
        html = '<video controls autoplay playsinline preload="metadata" src="'+rm_escape_html(url)+'">Your browser does not support the video tag.</video>';
    } else if (audioExt.indexOf(ext) > -1) {
        html = '<div class="preview-fallback"><p><strong>'+rm_escape_html(name)+'</strong></p><audio controls autoplay preload="metadata" src="'+rm_escape_html(url)+'" style="width:100%;">Your browser does not support the audio element.</audio><p style="margin-top:10px;"><a href="'+rm_escape_html(url)+'" download>Download audio</a></p></div>';
    } else if (ext === 'txt') {
        html = '<iframe src="'+rm_escape_html(url)+'"></iframe>';
    } else if (ext === 'docx') {
        // Word modern: render langsung di browser via mammoth.js
        $body.html(rm_office_loading_html());
        $('#resourcePreviewModal').modal('show');
        rm_render_docx_preview(url, name);
        return;
    } else if (sheetExt.indexOf(ext) > -1) {
        // Spreadsheet: render langsung di browser via SheetJS
        $body.html(rm_office_loading_html());
        $('#resourcePreviewModal').modal('show');
        rm_render_sheet_preview(url, name, ext);
        return;
    } else if (officeExt.indexOf(ext) > -1) {
        // .doc lama / .ppt / .pptx: tidak bisa dirender di browser
        html = '<div class="preview-fallback"><p><strong>'+rm_escape_html(name)+'</strong></p><p>Pratinjau langsung tidak tersedia untuk file .'+rm_escape_html(ext)+'.</p><p><a class="btn btn-success btn-sm" href="'+rm_escape_html(url)+'" download><i class="fa fa-download"></i> Download untuk melihat</a></p></div>';
    } else {
        html = '<div class="preview-fallback"><p><strong>'+rm_escape_html(name)+'</strong></p><p>Pratinjau tidak tersedia untuk tipe file ini (.'+rm_escape_html(ext||'?')+').</p><p><a class="btn btn-success btn-sm" href="'+rm_escape_html(url)+'" download><i class="fa fa-download"></i> Download untuk melihat</a></p></div>';
    }
    $body.html(html);
    $('#resourcePreviewModal').modal('show');
}
$(document).on('hidden.bs.modal', '#resourcePreviewModal', function(){ $('#resourcePreviewBody').html(''); });
</script>
