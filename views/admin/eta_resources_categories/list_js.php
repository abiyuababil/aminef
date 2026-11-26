<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<script>
    $(document).ready(function(){
        $(".form").on('click', function(e) {
            e.preventDefault();

            let element = $(this);
            let title = element.data('title');

            if (element.data('action') == 'create') {
                $("#name").val('');
                $("#id").val('');
            }

            let id = element.data('id');
            let name = element.data('name');
            let is_active = element.data('is_active');

            if (Number(id) > 0) {
                $("#name").val(name);
                $("#id").val(id);

                if (is_active == 1) {
                    $("#is_active").prop('checked', true);
                } else {
                    $("#is_active").prop('checked', false);
                }
            }

            $("#mdl_form_resource_category_label").text(title);
           
        });

        $("#sortable tbody").sortable({
            cursor: "move",
            placeholder: "sortable-placeholder",
            helper: function(e, tr) {
                let $originals = tr.children();
                let $helper = tr.clone();
                $helper.children().each(function(index) {
                    $(this).width($originals.eq(index).width());
                });
                return $helper;
            },
            update: function(event, ui) {
                let sorted_ids = [];
                $("#sortable tbody").find('tr').each(function(index) {
                    let row = $(this);
                    let row_number = index + 1;
                    row.find('td:first').text(row_number); 
                    row.data('sort', row_number); 
                    let current_id = row.data('id');
                    let sort = row_number;
                    sorted_ids.push({ id: current_id, sort: sort });
                    
                });
                console.log(sorted_ids);
                $.ajax({
                    url: "<?php echo site_url('admin/resource_categories/sort'); ?>",
                    type: "POST",
                    data: {
                        rows: sorted_ids
                    },
                    success: function(response) {},
                    error: function(xhr, status, error) {}
                });
            }
        }).disableSelection();
    });

</script>