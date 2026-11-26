<script>
var currentCategoryId = null;
$(document).ready(function(){
    let stored = localStorage.getItem('grantee_resource_category_id');
    let firstId = $('.category-tab:first').data('id');
    currentCategoryId = stored || firstId;
    if (currentCategoryId) selectCategory(currentCategoryId);
});
function selectCategory(catId){
    currentCategoryId = catId;
    localStorage.setItem('grantee_resource_category_id', catId);
    $('#searchResourceInput').val('');
    $('.category-tab').removeClass('active');
    $('.category-tab[data-id="'+catId+'"]').addClass('active');
    let name = $('.category-tab[data-id="'+catId+'"]').data('name');
    if (name) $('#activeCategoryName').text(name);
    loadCategoryTree(catId);
}
function loadCategoryTree(category_id){
    $('#categoryContentArea').html('<div style="padding:40px;text-align:center;color:#94a3b8;"><i class="fa fa-spinner fa-spin"></i> Loading...</div>');
    $.ajax({
        url: '<?php echo site_url('grantee/eta_resources/get_list_ajax'); ?>?resource_category_id='+category_id+'&mode=tree',
        type: 'GET', dataType:'JSON',
        success: function(res){ if(res.success) $('#categoryContentArea').html(res.html); },
        error: function(xhr){ alert('Failed to load resources: '+xhr.responseText); }
    });
}
function filterResources(){
    let q = $('#searchResourceInput').val().toLowerCase();
    if (!q) { $('.file-row-item').show(); $('.folder-block').show(); return; }
    $('.file-row-item').each(function(){
        let n=($(this).data('name')||'').toString().toLowerCase();
        if(n.indexOf(q)>-1) $(this).show(); else $(this).hide();
    });
    $('.folder-block').each(function(){
        let anyVisible = $(this).find('.file-row-item:visible').length>0;
        if(q && !anyVisible) $(this).hide(); else { $(this).show(); if(anyVisible) $(this).removeClass('collapsed'); }
    });
    let directVisible = $('.direct-files-container .file-row-item:visible').length;
    if(q && directVisible===0) $('.direct-files-container').hide(); else $('.direct-files-container').show();
}
function toggleFolder(folderId){
    let el=document.getElementById('folder-block-'+folderId);
    if(el) el.classList.toggle('collapsed');
}
function update_download_counter(resource_id){
    $.ajax({ url: '<?php echo site_url('grantee/eta_resources/update_download_counter'); ?>/'+resource_id, type:'GET', dataType:'JSON' });
}
</script>
