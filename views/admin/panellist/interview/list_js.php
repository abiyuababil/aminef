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
        $('#interview-pdf-modal').on('shown.bs.modal', function () {
            $("#interview-modal").modal('hide');
            $("#loading-pdf").removeClass('hide');
            $('#pdf-iframe').addClass('hide');
            var pdf_url = $(".btn-view-pdf").attr('href');
            $('#pdf-iframe').attr('src', pdf_url);
            $('#pdf-iframe').on('load', function() {
                $(this).removeClass('hide');
                $("#loading-pdf").addClass('hide');
                $('#pdf-iframe').removeClass('hide');
            });
        });

        $('#interview-pdf-modal').on('hidden.bs.modal', function () {
            $('#pdf-iframe').attr('src', '');
        });

        // $(document).on('click', '.select-view', function(e){
        //     e.preventDefault();
        //     $(".btn-view-pdf").attr('href', $(this).data('pdfurl'));
        //     $(".btn-view-form-application").attr('href', $(this).data('applicationurl'));
        // });
    });

    $(".accordion-toggle").on('click', function(){
        let index = $(this).data('index');

        let interview_date = $(this).data('date');
        let panellist_id = '<?php echo $this->session->userdata('panellist_id'); ?>';
        let pdf_url = '<?php echo site_url('panelist/interview/pdf_application/'); ?>';
        let form_url = '<?php echo site_url('panelist/interview/form_application/'); ?>';

        if ($('#table-row-' + index).hasClass('hide')) {
            $('#table-row-' + index).removeClass('hide');
        } else {
            $('#table-row-' + index).addClass('hide');
        }
        
        $.ajax({
            url : '<?php echo site_url('panellist/interview/ajax_get_grantee'); ?>',
            type : 'GET',
            data: {
                interview_date: interview_date,
                panellist_id: panellist_id
            },
            dataType : 'JSON',
            success : function(response) {
                let table = '';
                if (response.data != null) {
                    let no = 1;
                    
                    for (let i = 0; i < response.data.length; i++) {
                        table += '<tr>';
                            table += '<td>' + no++ + '</td>';
                            table += '<td>' + response.data[i].name + '</td>';
                            table += '<td>' + response.data[i].grant_name + '</td>';
                            table += '<td>' + response.data[i].fiscal_year + '</td>';
                            table += '<td>' + response.data[i].interview_time + '</td>';
                            table += '<td>' + (response.data[i].score == null ? '' : response.data[i].score) + '</td>';
                            table += '<td>' + response.data[i].status + '</td>';
                            table += '<td class="text-right">';
                                table += '<a class="btn btn-primary select-view" data-pdfurl="'+ pdf_url + response.data[i].program_id + '/' + response.data[i].id + '" data-applicationurl="'+ form_url + response.data[i].program_id + '/' + response.data[i].id + '" data-toggle="modal" data-target="#interview-modal">View</a>';
                            table += '</td>'
                        table += '</td>';
                    }
                }

                $("#interview-data-rows-" + index).html(table);
            }, error : function(response) {
                console.error(response.responseText);
            }
        });
    });

</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
