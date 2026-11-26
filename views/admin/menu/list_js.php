<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>

<script>

$(document).ready(function()
{
    var timeout;
    $('.dd').on('change', function() {
        clearTimeout(timeout);
        timeout = setTimeout(updateOrderMenu, 2000);
    });
    
    $('#nestable').nestable({
        group: 1
    });

    $('.menu-toggle-activate').dblclick(function(event) {
        event.stopPropagation();
        var status = $(this).data('status');
        var id = $(this).data('id');

        switch (status) {
            case undefined : case 0 :
            $(this).removeClass('menu-toggle-activate_inactive');
            $(this).data('status', 1)
            setMenuActive(id,  1);
            break;
            case 1 :
            $(this).addClass('menu-toggle-activate_inactive');
            $(this).data('status', 0)
            setMenuActive(id,  0);
            break;
        }
    });

    function updateOrderMenu(ignoreMessage) {
        $('.loading').removeClass('loading-hide');
        var shownotif = true;
        var menu = $('.dd').nestable('serialize');

        if (typeof shownotif == 'undefined') {
            var shownotif = true;
        }


        if (typeof ignoreMessage == 'undefined') {
            var ignoreMessage = false;
        }

        $.ajax({
            url: '<?= base_url('admin/menu/save_ordering') ?>',
            type: 'POST',
            dataType: 'JSON',
            data: {
                'menu': menu,
            },
        })
        .done(function(res) {
            if (res.success) {
                if (shownotif) {
                    if (!ignoreMessage) {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Menu has been update",
                        showConfirmButton: false,
                        timer: 1500
                        }).then((result) => {
                            location.reload();
                        });
                    }
                }
            } else {
                if (shownotif) {
                    if (!ignoreMessage) {
                        console.log(res)
                    }
                }
            }
        })
        .fail(function() {
            if (!ignoreMessage) {
                console.log('error')
            }
        })
        .always(function() {
            $('.loading').addClass('loading-hide');
        });
    }

    function setMenuActive(id, status) {
        var data = [];
        
        data.push({
            name: 'status',
            value: status
        });
        data.push({
            name: 'id',
            value: id
        });

        $.ajax({
            url: '<?= base_url('admin/menu/set_status') ?>',
            type: 'POST',
            dataType: 'JSON',
            data: data,
        })
        .done(function(data) {
            if (data.success) {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: data.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    location.reload();
                });
                updateOrderMenu(true)
            }else {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: data.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    location.reload();
                });
            }

        })
        .fail(function() {
            toastr['error']('Error update status');
        });
    }
});
</script>
