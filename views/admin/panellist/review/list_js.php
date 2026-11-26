<script>

    function add_filter() {
        var html = $('#template-filter').html();
        $('#wrap-filter').append(html);
    }

    function remove_filter(el) {
        $(el).parent().remove();
    }

    function submitFilter(e) {
        if (e.keyCode == 13) {
            $('#frm_manage').submit();
            return false;
        }
    }

    $(document).ready(function(){
        $('#review-pdf-modal').on('shown.bs.modal', function () {
            $("#review-modal").modal('hide');
            $("#loading-pdf").removeClass('hide');
            $('#pdf-iframe').attr('src', 'about:blank');
            $('#pdf-iframe').addClass('hide');
            var pdf_url = $(".btn-view-pdf").attr('href');
            var form_url = $(".btn-view-form").attr('href');
            $('#pdf-iframe').attr('src', pdf_url);
            $('#pdf-iframe').on('load', function() {
                $(this).removeClass('hide');
                $("#loading-pdf").addClass('hide');
            });
        });

        // $(".select-view").on('click', function(e){
        //     e.preventDefault();
        //     $(".btn-view-pdf").attr('href', $(this).data('pdfurl'));
        //     $(".btn-view-form").attr('href', $(this).data('formurl'));
        // });
    });

</script>