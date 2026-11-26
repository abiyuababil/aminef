<script>
/**
 * Replace ids inside .html-section to avoid accordion ID collision.
 * Call this after you insert HTML into .html-section (or .html-section{up}).
 */
function fixAccordionInsideHtmlSection(containerSelector) {
    // default container is .html-section
    var $container = containerSelector ? $(containerSelector) : $('.html-section');
    
    $container.find('.panel-group').each(function(i, el){
        var $pg = $(el);
        console.log($pg)
        // generate unique id
        var newId = 'accordion_dynamic_' + Date.now() + '_' + i;
        $pg.attr('id', newId);

        // fix data-parent attributes that reference an id
        $pg.find('[data-parent]').each(function(){
            // If data-parent references '#accordion' or similar, override with newId
            $(this).attr('data-parent', '#' + newId);
        });

        // Fix hrefs that point to collapse IDs and the target collapse div ids
        // find all anchors inside this panel-group with href starting with '#'
        $pg.find('a[href^="#"]').each(function(j){
            var $a = $(this);
            var oldHref = $a.attr('href');
            if(!oldHref) return;

            if(oldHref.indexOf('#') === 0){
                // create new collapse id suffix to avoid duplication
                var oldId = oldHref.substring(1);
                var newCollapseId = oldId + '_dyn_' + i + '_' + j + '_' + Date.now();

                // update anchor href
                $a.attr('href', '#' + newCollapseId);

                // update the corresponding collapse div id if exists inside container
                var $target = $pg.find('#' + oldId);
                if($target.length){
                    $target.attr('id', newCollapseId);
                } else {
                    // also try to update any element in the loaded html (scoped search)
                    $pg.find('[id="'+ oldId +'"]').attr('id', newCollapseId);
                }

                // Also update aria-controls if present
                if($a.attr('aria-controls')){
                    $a.attr('aria-controls', newCollapseId);
                }
            }
        });
    });
}

// Example: your existing click handler with fix call included
// $(document).on('click', '.btn-section', function(e){
//     e.preventDefault();

//     const section = $(this).data('section');
//     const grantee_grant_id = $(this).data('grantee_grant_id');
//     const sub_section = $(this).data('sub_section') ?? 0;
//     const up = $(this).data('up') ?? 0;
//     var container = '.html-section' + up;

//     $(container).html('<div class="alert alert-info text-center" id="loading-spinner'+ up +'"><i class="fa fa-spinner fa-spin"></i> Loading, please wait.</div>');

//     $.ajax({
//         type: 'GET',
//         url: '<?= site_url("world/get_section_alumni") ?>/' + section + '/' + grantee_grant_id + '/' + sub_section,
//         success: function(r) {
            
//             $(container).html(r);

//             // Fix accordion IDs inside the newly loaded HTML only
//             fixAccordionInsideHtmlSection(container);

//             // disable fields for alumni view if needed
//             $(container).find('.warp-alumni-page').find('.form-control').prop('disabled', true).css('background-color', '#eee');
//             $(container).find('.warp-alumni-page').find('.grant-alumni').prop('disabled', true);
//             $(container).find('.warp-alumni-page').find('.radio-nominee').prop('disabled', true);
//         },
//         complete: function() {
//             $('#loading-spinner' + up).addClass('hide');
//         },
//         error: function() {
//             $(container).html('<div class="text-danger">Failed load data.</div>');
//         }
//     });

//     return false;
// });
// 

const showKeywords = [
  'preview',
  'view',
  'go'
];

$(document).on('click', '.btn-section', function (e) {
    e.preventDefault();

    const section = $(this).data('section');
    const id = $(this).data('grantee_grant_id');
    const sub = $(this).data('sub_section') ?? 0;

    let urlRequest = "<?= site_url("world/get_section_alumni") ?>/"
        + section + "/" + id + "/" + sub;

    // loader
    $('.html-section').html('<div class="p-3 text-center">Loading...</div>');
    $.ajax({
        url: urlRequest,
        type: "GET",
        dataType: "json",
        success: function (res) {

            if (!res.url) {
                $('.html-section').html('<div class="alert alert-danger">Invalid response.</div>');
                return;
            }

            // Ambil URL yang nanti akan dipakai untuk button
            let fullPageUrl = res.url;
            let fullPageUrl_Btn = fullPageUrl.split('?')[0];

            // Load view ke dalam container
            $('.html-section').load(fullPageUrl, function(response, status) {

                if (status === "error") {
                    $('.html-section').html(
                        `<div class="alert alert-danger">
                            Error loading content.<br>
                            URL: ${fullPageUrl}
                        </div>`
                    );
                    return;
                }

                // Sisipkan tombol "Open Full Page"
                let buttonHtml = `
                    <div class="p-2 mb-2">
                        <a href="${fullPageUrl_Btn}" target="_blank" class="btn btn-primary btn-sm">
                            Go to Page
                        </a>
                    </div>
                    <hr />
                `;

                // Sisipkan tombol di atas view
                $('.html-section').prepend(buttonHtml);
                $('.html-section').find('.form-control').prop('disabled', true).css('background-color', '#eee');
                $('.html-section').find('.grant-alumni').prop('disabled', true);
                $('.html-section').find('.radio-nominee').prop('disabled', true);
                $('.html-section').find('input[type="file"]').prop('disabled', true);
                $('.html-section').find('.btn').addClass('hide');
                $('.html-section').find('.TriSea-technologies-Switch').addClass('hide');
                $('.html-section .btn').each(function () {
                    const text = $(this).text().trim().toLowerCase();

                    const isShow = showKeywords.some(k => text.includes(k));

                    if (isShow) {
                        $(this).removeClass('hide');
                    }
                });

            });

            window.history.replaceState({}, "", "?section=" + section + "&sub=" + sub);
        },
        error: function (xhr) {
            $('.html-section').html('<div class="alert alert-danger">Request failed.</div>');
            console.error(xhr.responseText);
        }
    });
});

</script>
