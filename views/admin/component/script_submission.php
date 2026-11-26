<script>
    $(document).ready(function() {
        $(document).on('change', 'select.form-control, input.form-control, input.autosave, select.select2, select.autosave, textarea.autosave, textarea.form-control', function() {
            applyConditionalVisibility();
        });

        applyConditionalVisibility();
    });
</script>