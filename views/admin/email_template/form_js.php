<script>
    // var allEditors = document.querySelectorAll('.editor');
    // for (var i = 0; i < allEditors.length; ++i) {
    //     ClassicEditor.create(allEditors[i]), {minHeight: '300px'};
    // }
    
    // $('.editor').summernote();
    tinymce.init({
        selector: '.editor',
        plugins: 'link table lists',
        toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | link | numlist bullist',
        extended_valid_elements: 'table[border|cellspacing|cellpadding|width|style]',
        contenteditable: true,
        spellchecker: false,
        table_default_attributes: {
            border: '0'  // Mengatur default border tabel menjadi 0
        },
        table_default_styles: {
            'border': '0'  // Mengatur default style border tabel menjadi 0
        }
    });

     // Add merge field to tinymce
    $('.add_merge_field').on('click', function(e) {
        e.preventDefault();
        // tinymce.activeEditor.execCommand('mceInsertContent', false, $(this).text());
        // var text_value = $(".editor").val();
        // var add_text = $(this).html();

        // $(".editor").val(text_value + " " + add_text);
    });
</script>