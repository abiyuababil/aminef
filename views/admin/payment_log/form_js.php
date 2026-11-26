<script>
    $(".payment-log").click(function(e){
        var payment_id = $(this).data('log')
        var payment_type = $(this).data('type')
        $("#model-payment-log tbody").html("");
        $('#email-recommendation-loading').show();
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('admin/request_payment/get_payment_log') ?>',
            dataType: 'JSON',
            data:{id: payment_id, type: payment_type},
            success: function(r) {
                if (r.status){
                    for (let i = 0; i<r.data.length;i++){
                        var action = r.data[i].old_data != null || r.data[i].new_data != null ? "<a data-old_data='"+ JSON.stringify(r.data[i].old_data) +"' data-new_data='"+ JSON.stringify(r.data[i].new_data) +"' class='btn btn-primary btn-xs view-detail-log'><i class='fa fa-eye'></i> View Detail</a>" : '';
                        var created_at = "<td>" + r.data[i].created_at + " " + action + "</td>"; 
                        var old_status = "<td>" + r.data[i].old_status + "</td>"; 
                        var new_status = "<td>" + r.data[i].new_status + "</td>"; 
                        var notes = "<td>Payment status : " + r.data[i].new_status + "</td>"; 
                        var created_by = "<td>" + r.data[i].created_by + "</td>"; 
                        
                        $("#model-payment-log tbody").append(`<tr>${created_at}${old_status}${new_status}${notes}${created_by}${action}</tr>`)
                        $('#email-recommendation-loading').hide();
                    }
                }
            }
        })
    });

    $(document).on('click', '.view-detail-log', function(e){
        let element = $(this);
        let old_data = JSON.parse(element.data('old_data'));
        let new_data = JSON.parse(element.data('new_data'));
        old_data = JSON.parse(old_data);
        new_data = JSON.parse(new_data);
        // old data
        let element_old_data = '';
        if (old_data != null) {
            element_old_data += '<table class="table table-striped">';
                //date period
                if (old_data.payment.from_date !== undefined) {
                    element_old_data += '<tr>';
                        element_old_data += '<td class="text-left" width="35%">';
                            element_old_data += 'Date Period';
                        element_old_data += '</td>';
                        element_old_data += '<td class="text-left">';
                            element_old_data += old_data.payment.from_date;
                        element_old_data += '</td>';
                    element_old_data += '</tr>';
                }

                //to
                if (old_data.payment.to_date !== undefined) {
                    element_old_data += '<tr>';
                        element_old_data += '<td class="text-left" width="35%">';
                            element_old_data += 'To';
                        element_old_data += '</td>';
                        element_old_data += '<td class="text-left">';
                            element_old_data += old_data.payment.to_date;
                        element_old_data += '</td>';
                    element_old_data += '</tr>';
                }

                //payment status
                if (new_data.payment.payment_status !== undefined) {
                    element_old_data += '<tr>';
                        element_old_data += '<td class="text-left" width="35%">';
                            element_old_data += 'Payment Status';
                        element_old_data += '</td>';
                        element_old_data += '<td class="text-left">';
                            element_old_data += old_data.payment.payment_status;
                        element_old_data += '</td>';
                    element_old_data += '</tr>';
                }

                //reminder date
                if (old_data.payment.toberelease_date !== undefined) { 
                    element_old_data += '<tr>';
                        element_old_data += '<td class="text-left" width="35%">';
                            element_old_data += 'Reminder Date';
                        element_old_data += '</td>';
                        element_old_data += '<td class="text-left">';
                            element_old_data += old_data.payment.toberelease_date;
                        element_old_data += '</td>';
                    element_old_data += '</tr>';
                }

                //To be Released Note
                if (old_data.payment.release_note !== undefined) {
                    element_old_data += '<tr>';
                        element_old_data += '<td class="text-left" width="35%">';
                            element_old_data += 'To be Released Note';
                        element_old_data += '</td>';
                        element_old_data += '<td class="text-left">';
                            element_old_data += old_data.payment.release_note;
                        element_old_data += '</td>';
                    element_old_data += '</tr>';
                }

                //release date
                if (old_data.payment.release_date) {
                    element_old_data += '<tr>';
                        element_old_data += '<td class="text-left" width="35%">';
                            element_old_data += 'Release Date';
                        element_old_data += '</td>';
                        element_old_data += '<td class="text-left" width="35%">';
                            element_old_data += old_data.payment.release_date;
                        element_old_data += '</td>';
                    element_old_data += '</tr>';
                }

                // payment date
                if (old_data.payment.payment_date !== undefined) {
                    element_old_data += '<tr>';
                        element_old_data += '<td class="text-left" width="35%">';
                            element_old_data += 'Payment Date';
                        element_old_data += '</td>';
                        element_old_data += '<td class="text-left">';
                            element_old_data += old_data.payment.payment_date;
                        element_old_data += '</td>';
                    element_old_data += '</tr>';
                }

                // description
                if (old_data.payment.description !== undefined) {
                    element_old_data += '<tr>';
                        element_old_data += '<td class="text-left" width="35%">';
                            element_old_data += 'Description';
                        element_old_data += '</td>';
                        element_old_data += '<td class="text-left">';
                            element_old_data += old_data.payment.description;
                        element_old_data += '</td>';
                    element_old_data += '</tr>';
                }

                // admin note
                if (old_data.payment.admin_note !== undefined) {
                    element_old_data += '<tr>';
                        element_old_data += '<td class="text-left" width="35%">';
                            element_old_data += 'Admin Note';
                        element_old_data += '</td>';
                        element_old_data += '<td class="text-left">';
                            element_old_data += old_data.payment.admin_note;
                        element_old_data += '</td>';
                    element_old_data += '</tr>';
                }

                // proof of expense
                if (old_data.payment.proof_expense !== undefined) {
                    element_old_data += '<tr>';
                        element_old_data += '<td class="text-left" width="35%">';
                            element_old_data += 'Proof of Expense';
                        element_old_data += '</td>';
                        element_old_data += '<td class="text-left">';
                            if (old_data.payment.proof_expense != null) {
                                element_old_data += '<a href="<?php echo site_url(); ?>'+ old_data.payment.proof_expense + '" target="_blank">View</a>';
                            }
                        element_old_data += '</td>';
                    element_old_data += '</tr>';
                }

                // status
                if (old_data.payment.status !== undefined) {
                    element_old_data += '<tr>';
                        element_old_data += '<td class="text-left" width="35%">';
                            element_old_data += 'Status';
                        element_old_data += '</td>';
                        element_old_data += '<td class="text-left">';
                            element_old_data += old_data.payment.status;
                        element_old_data += '</td>';
                    element_old_data += '</tr>';
                }

                // proof of transfer
                if (old_data.payment.proof !== undefined) {
                    element_old_data += '<tr>';
                        element_old_data += '<td class="text-left" width="35%">';
                            element_old_data += 'Proof of Transfer';
                        element_old_data += '</td>';
                        element_old_data += '<td class="text-left">';
                            if (old_data.payment.proof !== null) {
                                element_old_data += '<a href="<?php echo site_url(); ?>'+ old_data.payment.proof + '" target="_blank">View</a>';
                            }
                        element_old_data += '</td>';
                    element_old_data += '</tr>';
                }

                // finance note
                if (old_data.payment.finance_note !== undefined) {
                    element_old_data += '<tr>';
                        element_old_data += '<td class="text-left" width="35%">';
                            element_old_data += 'Finance Note';
                        element_old_data += '</td>';
                        element_old_data += '<td class="text-left">';
                            element_old_data += old_data.payment.finance_note;
                        element_old_data += '</td>';
                    element_old_data += '</tr>';
                }
            element_old_data += '</table>';

            // payment items
            if (old_data.payment_items.length > 0) {
                element_old_data += '<div class="accordion" id="old-data">';
                for(let i = 0; i < old_data.payment_items.length; i++) { 
                        element_old_data += '<div class="card">';
                            element_old_data += '<div class="card-header" id="heading-'+ old_data.payment_items[i].id +'">';
                            element_old_data += '<h5 class="mb-0 text-left">';
                                element_old_data += '<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse-'+ old_data.payment_items[i].id +'" aria-expanded="true" aria-controls="collapse-'+ old_data.payment_items[i].id +'">';
                                element_old_data += old_data.payment_items[i].payment_sub_category;
                                element_old_data += '</button>';
                            element_old_data += '</h5>';
                            element_old_data += '</div>';
                            element_old_data += '<div id="collapse-'+ old_data.payment_items[i].id +'" class="collapse" aria-labelledby="heading-'+ old_data.payment_items[i].id +'" data-parent="#old-data">';
                            
                            element_old_data += '<div class="card-body text-left pl-4">';
                                element_old_data += '<div>';
                                    element_old_data += '<label>Payment Item : </label> ';
                                    element_old_data += old_data.payment_items[i].payment_name;
                                element_old_data += '</div>';
                                element_old_data += '<div>';
                                    element_old_data += '<label>Nominal IDR : </label> ';
                                    element_old_data += old_data.payment_items[i].nominal_idr;
                                element_old_data += '</div>';
                                element_old_data += '<div>';
                                    element_old_data += '<label>Nominal USD : </label> ';
                                    element_old_data += old_data.payment_items[i].nominal;
                                element_old_data += '</div>';
                            element_old_data += '</div>';
                            element_old_data += '</div>';
                        element_old_data += '</div>';
                }
                element_old_data += '</div>';
            }
        }

        // new data
        let table_data = '';
        if (new_data != null) { 
            element_new_data = '<table class="table table-striped">';
                //date period
                if (new_data.payment.from_date !== undefined) {
                    element_new_data += '<tr>';
                        element_new_data += '<td class="text-left" width="35%">';
                            element_new_data += 'Date Period';
                        element_new_data += '</td>';
                        element_new_data += '<td class="text-left">';
                            if (old_data != null && new_data.payment.from_date != old_data.payment.from_date) {
                                table_data = '<b class="text-success">'+ new_data.payment.from_date +'</b>';
                            } else {
                                table_data = new_data.payment.from_date
                            }
                            element_new_data += table_data;
                        element_new_data += '</td>';
                    element_new_data += '</tr>';
                }

                //to
                if (new_data.payment.to_date !== undefined) {
                    element_new_data += '<tr>';
                        element_new_data += '<td class="text-left" width="35%">';
                            element_new_data += 'To';
                        element_new_data += '</td>';
                        element_new_data += '<td class="text-left">';
                            if (old_data != null && new_data.payment.to_date != old_data.payment.to_date) {
                                table_data = '<b class="text-success">'+ new_data.payment.to_date +'</b>';
                            } else {
                                table_data = new_data.payment.to_date;
                            }
                            element_new_data += table_data;
                        element_new_data += '</td>';
                    element_new_data += '</tr>';
                }

                //payment status
                if (new_data.payment.payment_status !== undefined) {
                    element_new_data += '<tr>';
                        element_new_data += '<td class="text-left" width="35%">';
                            element_new_data += 'Payment Status';
                        element_new_data += '</td>';
                        element_new_data += '<td class="text-left">';
                            if (old_data != null && new_data.payment.payment_status != old_data.payment.payment_status) {
                                table_data = '<b class="text-success">'+ new_data.payment.payment_status +'</b>';
                            } else {
                                table_data = new_data.payment.payment_status;
                            }
                            element_new_data += table_data;
                        element_new_data += '</td>';
                    element_new_data += '</tr>';
                }

                //reminder date
                if (new_data.payment.toberelease_date !== undefined) { 
                    element_new_data += '<tr>';
                        element_new_data += '<td class="text-left" width="35%">';
                            element_new_data += 'Reminder Date';
                        element_new_data += '</td>';
                        element_new_data += '<td class="text-left">';
                            if (old_data != null && new_data.payment.toberelease_date != old_data.payment.toberelease_date) {
                                table_data = '<b class="text-success">'+ new_data.payment.toberelease_date +'</b>';
                            } else {
                                table_data = new_data.payment.toberelease_date;
                            }
                            element_new_data += table_data;
                        element_new_data += '</td>';
                    element_new_data += '</tr>';
                }

                //To be Released Note
                if (new_data.payment.release_note !== undefined) {
                    element_new_data += '<tr>';
                        element_new_data += '<td class="text-left" width="35%">';
                            element_new_data += 'To be Released Note';
                        element_new_data += '</td>';
                        element_new_data += '<td class="text-left">';
                            if (old_data != null && new_data.payment.release_note != old_data.payment.release_note) {
                                table_data = '<b class="text-success">'+ new_data.payment.release_note +'</b>';
                            } else {
                                table_data = new_data.payment.release_note;
                            }
                            element_new_data += table_data;
                        element_new_data += '</td>';
                    element_new_data += '</tr>';
                }

                //release date
                if (new_data.payment.release_date) {
                    element_new_data += '<tr>';
                        element_new_data += '<td class="text-left" width="35%">';
                            element_new_data += 'Release Date';
                        element_new_data += '</td>';
                        element_new_data += '<td class="text-left" width="35%">';
                            if (old_data != null && new_data.payment.release_date != old_data.payment.release_date) {
                                table_data = '<b class="text-success">'+ new_data.payment.release_date +'</b>';
                            } else {
                                table_data = new_data.payment.release_date;
                            }
                            element_new_data += table_data;
                        element_new_data += '</td>';
                    element_new_data += '</tr>';
                }

                // payment date
                if (new_data.payment.payment_date !== undefined) {
                    element_new_data += '<tr>';
                        element_new_data += '<td class="text-left" width="35%">';
                            element_new_data += 'Payment Date';
                        element_new_data += '</td>';
                        element_new_data += '<td class="text-left">';
                            if (old_data != null && new_data.payment.payment_date != old_data.payment.payment_date) {
                                table_data = '<b class="text-success">'+ new_data.payment.payment_date +'</b>';
                            } else {
                                table_data = new_data.payment.payment_date;
                            }
                            element_new_data += table_data;
                        element_new_data += '</td>';
                    element_new_data += '</tr>';
                }

                // description
                if (new_data.payment.description !== undefined) {
                    element_new_data += '<tr>';
                        element_new_data += '<td class="text-left" width="35%">';
                            element_new_data += 'Description';
                        element_new_data += '</td>';
                        element_new_data += '<td class="text-left">';
                            if (old_data != null && new_data.payment.description != old_data.payment.description) {
                                table_data = '<b class="text-success">'+ new_data.payment.description +'</b>';
                            } else {
                                table_data = new_data.payment.description;
                            }
                            element_new_data += table_data;
                        element_new_data += '</td>';
                    element_new_data += '</tr>';
                }

                // admin note
                if (new_data.payment.admin_note !== undefined) {
                    element_new_data += '<tr>';
                        element_new_data += '<td class="text-left" width="35%">';
                            element_new_data += 'Admin Note';
                        element_new_data += '</td>';
                        element_new_data += '<td class="text-left">';
                            if (old_data != null && new_data.payment.admin_note != old_data.payment.admin_note) {
                                table_data = '<b class="text-success">'+ new_data.payment.admin_note +'</b>';
                            } else {
                                table_data = new_data.payment.admin_note;
                            }
                            element_new_data += table_data;
                        element_new_data += '</td>';
                    element_new_data += '</tr>';
                }

                // proof of expense
                if (new_data.payment.proof_expense !== undefined) {
                    element_new_data += '<tr>';
                        element_new_data += '<td class="text-left" width="35%">';
                            element_new_data += 'Proof of Expense';
                        element_new_data += '</td>';
                        element_new_data += '<td class="text-left">';
                            if (new_data.payment.proof_expense !== null) {
                                element_new_data += '<a href="<?php echo site_url(); ?>'+ new_data.payment.proof_expense + '" target="_blank">View</a>';
                            }
                        element_new_data += '</td>';
                    element_new_data += '</tr>';
                }

                // status
                if (new_data.payment.status !== undefined) {
                    element_new_data += '<tr>';
                        element_new_data += '<td class="text-left" width="35%">';
                            element_new_data += 'Status';
                        element_new_data += '</td>';
                        element_new_data += '<td class="text-left">';
                            if (old_data != null && new_data.payment.status != old_data.payment.status) {
                                table_data = '<b class="text-success">'+ new_data.payment.status +'</b>';
                            } else {
                                table_data = new_data.payment.status;
                            }
                            element_new_data += table_data;
                        element_new_data += '</td>';
                    element_new_data += '</tr>';
                }

                // proof of transfer
                if (new_data.payment.proof !== undefined) {
                    element_new_data += '<tr>';
                        element_new_data += '<td class="text-left" width="35%">';
                            element_new_data += 'Proof of Transfer';
                        element_new_data += '</td>';
                        element_new_data += '<td class="text-left">';
                            if (new_data.payment.proof !== null) {
                                element_new_data += '<a href="<?php echo site_url(); ?>'+ new_data.payment.proof + '" target="_blank">View</a>';
                            }
                        element_new_data += '</td>';
                    element_new_data += '</tr>';
                }

                // finance note
                if (new_data.payment.finance_note !== undefined) {
                    element_new_data += '<tr>';
                        element_new_data += '<td class="text-left" width="35%">';
                            element_new_data += 'Finance Note';
                        element_new_data += '</td>';
                        element_new_data += '<td class="text-left">';
                            if (old_data != null && new_data.payment.finance_note != old_data.payment.finance_note) {
                                table_data = '<b class="text-success">'+ new_data.payment.finance_note +'</b>';
                            } else {
                                table_data = new_data.payment.finance_note;
                            }
                            element_new_data += table_data;
                        element_new_data += '</td>';
                    element_new_data += '</tr>';
                }
            element_new_data += '</table>';

            //payment items
            if (new_data.payment_items.length > 0) {
                element_new_data += '<div class="accordion" id="new-data">';
                for(let i = 0; i < new_data.payment_items.length; i++) { 
                        element_new_data += '<div class="card">';
                            element_new_data += '<div class="card-header" id="newdata-heading-'+ new_data.payment_items[i].id +'">';
                            element_new_data += '<h5 class="mb-0 text-left">';
                                element_new_data += '<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#newdata-collapse-'+ new_data.payment_items[i].id +'" aria-expanded="true" aria-controls="newdata-collapse-'+ new_data.payment_items[i].id +'">';
                                element_new_data += new_data.payment_items[i].payment_sub_category;
                                element_new_data += '</button>';
                            element_new_data += '</h5>';
                            element_new_data += '</div>';
                            element_new_data += '<div id="newdata-collapse-'+ new_data.payment_items[i].id +'" class="collapse" aria-labelledby="newdata-heading-'+ new_data.payment_items[i].id +'" data-parent="#new-data">';
                            element_new_data += '<div class="card-body text-left pl-4">';
                                element_new_data += '<div>';
                                    element_new_data += '<label>Payment Item : </label> ';
                                    element_new_data += new_data.payment_items[i].payment_name;
                                element_new_data += '</div>';
                                element_new_data += '<div>';
                                    element_new_data += '<label>Nominal IDR : </label> ';
                                    element_new_data += new_data.payment_items[i].nominal_idr;
                                element_new_data += '</div>';
                                element_new_data += '<div>';
                                    element_new_data += '<label>Nominal USD : </label> ';
                                    element_new_data += new_data.payment_items[i].nominal;
                                element_new_data += '</div>';
                            element_new_data += '</div>';
                            element_new_data += '</div>';
                        element_new_data += '</div>';
                }
                element_new_data += '</div>';
            }
        }

        $("#old-data").html(element_old_data);
        $("#new-data").html(element_new_data);
        $("#modal-payment-log").modal('hide');
        $("#mdl_detail_log").modal('show');
        
    });

    $('#mdl_detail_log').on('hidden.bs.modal', function () {
        $("#modal-payment-log").modal('show');
    });
</script>