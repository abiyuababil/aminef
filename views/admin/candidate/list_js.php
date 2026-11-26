<script>
    const SITE_URL = '<?php echo site_url(); ?>';
    $(".succesfully").click(function () {
        var id = $(this).data('id');
        $("#mdl_info").modal();
        $('#btn-successful').attr("onclick", "succesfully(" + id + ")");
        event.preventDefault();
    });

    $("#list-nominee").on('click', '.btn-section', function (e) {
        e.preventDefault();
        $("#list-nominee").find('tr').each(function () {
            $(this).removeClass('tr-active');
        });
        $(this).closest('tr').addClass("tr-active");
    });

    $(document).click(function (event) {
        if (!$(event.target).is(".btn-section")) {
            $("#list-nominee").find('tr').each(function () {
                $(this).removeClass('tr-active');
            });
        }
    });

    function succesfully(grantee_grant_id) {
        $('#btn-successful').html('<img src="<?php echo base_url() ?>/img/loading.gif">').prop('disabled', true);
        $.ajax({
            url: "<?= base_url(); ?>admin/candidate/successfully",
            method: "POST",
            dataType: 'JSON',
            data: {
                grantee_grant_id: grantee_grant_id,
            }
        })
            .success(function (data) {
                window.location.href = data.redirect;
            })
    }

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

    $('.hide_menu').click(function () {
        var id = $(this).data('id')
        var value = $(this).data('value')
        var section = $(this).data('section')
        Swal.fire({
            title: "Are you sure?",
            // text    : "Once submitted, data cannot be changed.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes",
            customClass: 'swal-interview'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Loading...',
                    text: 'Please wait while we process your request.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,  // Menghilangkan tombol "OK"
                    didOpen: () => {
                        Swal.showLoading();  // Memunculkan loading spinner
                    }
                });
                $.ajax({
                    url: "<?= base_url(); ?>admin/candidate/hide_menu",
                    method: "POST",
                    dataType: 'JSON',
                    data: {
                        grantee_grant_id: id,
                        value: value,
                        section: section
                    }
                })
                    .success(function (data) {
                        if (data.status) {
                            location.reload();
                        }
                    })
            }
        });
    })


    // function showReason(element) {
    //     var note = $(element).data('note')
    //     // var raw = $(element).data('attach')
    //     var raw  = $(element).attr('data-attach');
    //     let files = [];

    //     if (raw) {
    //         try {
    //             files = JSON.parse(raw);
    //         } catch {
    //             raw = raw.replace(/^\[|\]$/g,'').replace(/"/g,'');
    //             files = raw.includes(',') ? raw.split(',') : [raw];
    //         }
    //     }
    //     files = Array.isArray(files) ? files : [files];

    //     let attachHtml = '';

    //     if (files.length && files[0].trim() !== '') {
    //         let links = files.map(f => {
    //             let file = f.trim();
    //             let name = file.split('/').pop();
    //             return `<a href="<?= base_url() ?>${file}" target="_blank">${name}</a>`;
    //         }).join(', ');

    //         attachHtml = `<div class="mt-2 pull"> ${links}</div>`;
    //     }
        
    //     // var url = '';
    //     // var show = 'd-none';
    //     // if (attach) {
    //     //     url = '<?= base_url() ?>' + attach
    //     //     show = ''
    //     // }
    //     Swal.fire({
    //         title: 'View Note',
    //         html: `
    //             <div>
    //                 <textarea class="form-control" readonly rows="6" style="resize: none;">`+ note + `</textarea>    
    //             </div>
    //             ${attachHtml}
    //         `,
    //         width: '600px',
    //         showConfirmButton: false,
    //         showCancelButton: false,
    //         cancelButtonText: 'Close',
    //         customClass: {
    //             popup: 'custom-swal-width'
    //         }
    //     });
    // }


    // Fungsi untuk konversi status ke badge
    function badgeStatus(status) {
        if (status === 'done') {
            return '<span class="badge badge-success">Done</span>';
        } else {
            return '<span class="badge badge-danger">Not Done</span>';
        }
    }

    // Event saat modal mau dibuka
    $('#modal_status').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // tombol yang klik

        // Ambil data dari tombol
        var dataItems = {
            "Transportation PDO": button.data('pdot'),
            "Accommodation PDO": button.data('pdoa'),
            "Transportation Visa Interview": button.data('visat'),
            "Accommodation Visa Interview": button.data('visaa'),
            "Transportation Domestic": button.data('domestict'),
            "Accommodation Domestic": button.data('domestica'),
            "Transportation International": button.data('intera')
        };

        var listHtml = '';
        $.each(dataItems, function (label, value) {
            listHtml += '<li class="list-group-item d-flex justify-content-between align-items-center">'
                + label + badgeStatus(value) + '</li>';
        });

        $('#status_list').html(listHtml);
    });

    function show_download_modal() {
        $('#modalDownloadNominee').modal('show');
    }
</script>