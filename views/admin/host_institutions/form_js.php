<script>
function add_contact_person() {
    var index = $('.contact-person').length;
    var html = '<div class="contact-person">' +
                    '<div class="row">' +
                        '<div class="col-md-12">' +
                            '<a href="javascript:;" onclick="delete_contact_person(this)" data-id="" class="btn btn-danger  pull-right" style="margin-bottom:10px;">' +
                                '<i class="fa fa-trash fa-fw"></i>' +
                            '</a>' +
                        '</div>' +
                    '</div>' +
                    '<div class="row contact_person">' +
                        '<div class="col-md-6">' +
                            '<div class="form-group">' +
                                '<label>Name</label>' +
                                '<input required class="form-control" placeholder="Name" name="contact_person[' + index + '][name]" type="text">' +
                            '</div>' +
                        '</div>' +
                        '<div class="col-md-6">' +
                            '<div class="form-group">' +
                                '<label>Email</label>' +
                                '<input required class="form-control" placeholder="Email" name="contact_person[' + index + '][email]" type="email">' +
                            '</div>' +
                        '</div>' +
                        '<div class="col-md-6">' +
                            '<div class="form-group">' +
                                '<label>Phone Number</label>' +
                                '<input required class="form-control" placeholder="Phone Number" name="contact_person[' + index + '][phone_number]" type="text">' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                    '<hr>' +
                '</div>';
    $('.contact_person_section').append(html);
}

function delete_contact_person(el) {
    if (confirm('Are you sure you want to delete this contact person?')) {
        var id = $(el).data('id');
        if (id) {
            $.ajax({
                url: '<?= base_url() ?>admin/host_institutions/delete_contact_person',
                method: 'POST',
                dataType: 'json',
                data: { id: id },
                success: function(response) {
                    if (response.success) {
                        $(el).closest('.contact-person').remove();
                        showSwal('success', 'Successfully deleted', false, true, 1500);
                    } else {
                        alert('Failed to delete contact person.');
                    }
                },
                error: function() {
                    alert('An error occurred while deleting contact person.');
                }
            });
        } else {
            $(el).closest('.contact-person').remove();
        }
    }
}

function delete_proposal(el) {
    if (confirm('Are you sure you want to delete the proposal?')) {
        var id = $(el).data('id');
        if (id) {
            $.ajax({
                url: '<?= base_url() ?>admin/host_institutions/delete_proposal',
                method: 'POST',
                dataType: 'json',
                data: { id: id },
                success: function(response) {
                    if (response.success) {
                        $(el).closest('.form-group').find('a.btn-info').remove();
                        $(el).remove();
                        showSwal('success', 'Successfully deleted', false, true, 1500);
                    } else {
                        alert('Failed to delete proposal.');
                    }
                },
                error: function() {
                    alert('An error occurred while deleting proposal.');
                }
            });
        }
    }
}
</script>