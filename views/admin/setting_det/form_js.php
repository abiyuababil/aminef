<script>
    $('.delete_agreement_template').on('click', function() {
        if (confirm('Are you sure you want to delete the agreement template?')) {
            $('#agreement_template_delete').val(1);
            $('.agreement_template').remove();
            $(this).remove();
        }
    });
</script>