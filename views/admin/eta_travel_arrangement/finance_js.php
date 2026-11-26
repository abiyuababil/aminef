<?php if ($active_tab !== 'accommodation'): ?>
<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<?php echo $this->load->view('admin/request_payment/form_js', null, true); ?>
<script>
    window.eta_finance_rows = <?php echo json_encode($finance_rows, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>;
    window.eta_finance_selected_flights = <?php echo json_encode($selected_flights, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>;
    window.eta_finance_config = {
        base_url: <?php echo json_encode(base_url(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
        site_url: <?php echo json_encode(site_url(''), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
        save_field_url: <?php echo json_encode(site_url('admin/eta_travel_arrangement/save_field'), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
        active_tab: <?php echo json_encode($active_tab, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
        status_labels: {
            '1': <?php echo json_encode(eta_travel_status_label(1), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
            '2': <?php echo json_encode(eta_travel_status_label(2), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
            '3': <?php echo json_encode(eta_travel_status_label(3,$active_tab), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
            '4': <?php echo json_encode(eta_travel_status_label(4), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
            '7': <?php echo json_encode(eta_travel_status_label(7), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>
        }
    };
    function toggleAccordion(id){ var el=document.getElementById(id); if(el) el.classList.toggle('active'); }
    function downloadBatchApproval(section_id, ids_str){ if(!ids_str){ alert('No grantees in this section'); return; } var url=window.eta_finance_config.base_url+'admin/eta_travel_arrangement/generate_pdf?section_id='+section_id+'&ids='+encodeURIComponent(ids_str); window.open(url,'_blank'); }
    function closeDetailModal(){ var m=document.getElementById('detailModal'); if(m) m.style.display='none'; }
    $(function(){
        var finance_rows_by_id = {};
        var selected_flights_by_id = window.eta_finance_selected_flights || {};
        var modal_state = { travel_id:null, invoice_field:null, proof_field:null };
        (window.eta_finance_rows||[]).forEach(function(row){ finance_rows_by_id[String(row.id)]=row; });
        function escape_html(v){ return $('<div>').text(v==null?'':String(v)).html(); }
        function format_date(v,show_time){
            if(!v) return '-';
            var d=new Date(v); if(Number.isNaN(d.getTime())) return v;
            if(show_time) return d.toLocaleString('en-GB',{day:'2-digit',month:'short',year:'numeric',hour:'2-digit',minute:'2-digit',second:'2-digit',hour12:false});
            return d.toLocaleDateString('en-GB',{day:'2-digit',month:'short',year:'numeric'});
        }
        function format_currency(v,curr){
            if(v===null||v===undefined||v===''||isNaN(Number(v))) return '-';
            var a=Number(v);
            if(curr==='IDR') return 'Rp. '+a.toLocaleString('en-US',{maximumFractionDigits:0});
            if(curr==='USD'||!curr) return '$'+a.toLocaleString('en-US',{minimumFractionDigits:2, maximumFractionDigits:2});
            return a.toLocaleString('en-US',{minimumFractionDigits:2,maximumFractionDigits:2})+' '+curr;
        }
        function build_full_name(row){ return [row.prefix_name,row.first_name,row.middle_name,row.last_name].filter(function(p){return p&&String(p).trim()!=='';}).join(' ')||'-'; }
        function build_file_link(path,label,lightbox){
            if(!path) return '<span class="text-muted small">No file</span>';
            var cls=lightbox?'btn btn-sm btn-primary lightbox':'btn btn-sm btn-primary';
            if(lightbox) return '<a class="'+cls+'" href="'+window.eta_finance_config.base_url+String(path).replace(/^\//,'')+'">'+escape_html(label)+'</a>';
            return '<a class="'+cls+'" href="'+window.eta_finance_config.base_url+String(path).replace(/^\//,'')+'" target="_blank" rel="noopener noreferrer">'+escape_html(label)+'</a>';
        }
        function parse_ticket_paths(raw){
            var out=[];
            function push_value(v){
                if(v===null||v===undefined) return;
                if(Array.isArray(v)){ v.forEach(push_value); return; }
                if(typeof v!=='string'){
                    if(typeof v==='number'&&isFinite(v)){ v=String(v); } else { return; }
                }
                var s=v.trim();
                if(s===''||s==='null'||s==='NULL'||s==='undefined') return;
                var first=s.charAt(0), last=s.charAt(s.length-1);
                if((first==='['&&last===']')||(first==='"'&&last==='"')){
                    try{ push_value(JSON.parse(s)); return; }
                    catch(e){ /* bukan JSON valid, perlakukan sebagai path biasa */ }
                }
                out.push(s);
            }
            push_value(raw);
            var seen={}, res=[];
            out.forEach(function(p){ if(!seen[p]){ seen[p]=true; res.push(p); } });
            return res;
        }
        function ticket_basename(path){
            var s=String(path).split('?')[0].split('#')[0];
            var parts=s.split('/');
            var base=parts[parts.length-1]||s;
            try{ return decodeURIComponent(base); }catch(e){ return base; }
        }
        function build_ticket_links(paths){
            if(!paths||!paths.length) return '<span class="text-muted small">No file</span>';
            if(paths.length===1){
                var href=window.eta_finance_config.base_url+String(paths[0]).replace(/^\//,'');
                return '<a class="btn btn-sm btn-primary lightbox" href="'+href+'">View</a>';
            }
            var html='<ul class="ticket-list">';
            paths.forEach(function(p){
                var href=window.eta_finance_config.base_url+String(p).replace(/^\//,'');
                html+='<li><a class="lightbox ticket-link" href="'+href+'">'+escape_html(ticket_basename(p))+'</a></li>';
            });
            return html+'</ul>';
        }
        function build_upload_control(path,view_label,target){
            var html='<div class="finance-file-actions">';
            html+=build_file_link(path,view_label,true);
            html+=' <label class="btn btn-sm btn-success mb-0" for="'+target+'">Upload</label>';
            html+='</div>'; return html;
        }
        function normalize_flight_description(desc){
            if(!desc) return '';
            var n=String(desc);
            n=n.replace(/<br\s*\/?>/gi,'\n'); n=n.replace(/<\/p>\s*<p>/gi,'\n\n'); n=n.replace(/<\/li>\s*<li>/gi,'\n'); n=n.replace(/<li>/gi,'- '); n=n.replace(/<\/li>/gi,'');
            return $('<div>').html(n).text().trim();
        }
        function init_lightbox(scope){ if(typeof $.fn.topbox==='undefined') return; var links=scope?scope.find('.lightbox'):$('.lightbox'); if(links.length) links.topbox(); }
        function build_selected_flights(tid){
            var flights=selected_flights_by_id[String(tid)]||[];
            if(!flights.length) return '-';
            return flights.map(function(f){
                var name=(f.name||'').trim();
                var desc=normalize_flight_description(f.description||'');
                if(name&&desc) return name+'\n'+desc;
                return name||desc;
            }).filter(Boolean).join('\n\n')||'-';
        }
        function render_detail_modal(){
            var row=finance_rows_by_id[String(modal_state.travel_id)];
            if(!row) return;
            var is_intl=window.eta_finance_config.active_tab==='international';
            var is_accom=window.eta_finance_config.active_tab==='accommodation';
            var from_value='-';
            var to_value='-';
            if(is_accom){ from_value='-'; to_value='-'; }
            else if(is_intl){ from_value=row.departure_airport_us||row.nearest_international_airport||'-'; to_value=row.arrival_airport_indonesia||'-'; }
            else { from_value=row.domestic_departure_airport||'-'; to_value=row.domestic_arrival_airport||'-'; }
            var passport_path=row.passport_file||row.img_passport||'';
            var ticket_field=is_intl?'ticket_file':'domestic_ticket_file';
            if(is_accom) ticket_field='voucher_accommodation';
            var selected_flights=selected_flights_by_id[String(modal_state.travel_id)]||[];
            var selected_first=selected_flights.length?selected_flights[0]:null;
            var proposed_rate=selected_first&&selected_first.price?selected_first.price:row.rate_in_usd;
            var proposed_currency=selected_first&&selected_first.currency?selected_first.currency:(row.grantee_currency||'USD');
            var status_text=window.eta_finance_config.status_labels[String(row.status||'')]||(is_accom?'Voucher Sent':'Ticket Sent');
            var period_label=row.period_fiscal_year||row.period_name||row.period_id||'-';
            $('#modalGranteeHeading').text(build_full_name(row));
            $('#modalPeriodHeading').text(period_label);
            $('#modalStatusBadge').text(status_text);
            $('#modalOrigin').text(from_value);
            $('#modalDestination').text(to_value);
            $('#modalDepDate').text(format_date(row.departure_date||row.checkin_date||''));
            var retVal = row.returning_date||row.checkout_date||'';
            $('#modalRetDate').text(format_date(retVal));
            if((row.flight_type||'').trim()==='One Way'){ $('#modalRetDateRow').hide(); } else { $('#modalRetDateRow').show(); }
            $('#modalAgent').text(row.travel_agent_name||'-');
            $('#modalProposedRate').text(format_currency(proposed_rate, proposed_currency));
            $('#modalFinalRate').text(format_currency(row.final_rate, proposed_currency));
            $('#modalApprovedFlightsText').text(build_selected_flights(modal_state.travel_id));
            $('#modalNoteText').text(row.section_note||row.note||'-');
            $('#modalRequestedBy').text((row.requested_name||'-') + (row.requested_at?', '+format_date(row.requested_at,true):''));
            $('#modalApprovedBy').text((row.approved_name||'-') + (row.approved_at?', '+format_date(row.approved_at,true):''));
            var invoice_path=row[modal_state.invoice_field]||'';
            var proof_path=row[modal_state.proof_field]||'';
            if(passport_path) $('#modalPassportCell').html(build_file_link(passport_path,'View',true));
            else $('#modalPassportCell').html('<span class="text-muted small">No file</span>');
            var ticket_paths=parse_ticket_paths(row[ticket_field]);
            if(ticket_paths.length>1){ $('#modalTicketRow').addClass('detail-row-stacked'); }
            else { $('#modalTicketRow').removeClass('detail-row-stacked'); }
            $('#modalTicketCell').html(build_ticket_links(ticket_paths));
            if(modal_state.invoice_field){
                $('#modalInvoiceCell').html(build_upload_control(invoice_path,'View','finance_invoice_upload'));
            } else {
                $('#modalInvoiceCell').html(build_file_link(invoice_path,'View',true));
            }
            if(modal_state.proof_field){
                $('#modalProofCell').html(build_upload_control(proof_path,'View','finance_proof_upload'));
            } else {
                $('#modalProofCell').html(build_file_link(proof_path,'View',true));
            }
            var approval_url='admin/eta_travel_arrangement/generate_pdf?section_id='+row.section_id+'&ids='+row.id;
            $('#modalApprovalCell').html(build_file_link(approval_url,'View',false));
            var memo_url=row.memo_budget_url||'';
            if(memo_url) $('#modalMemoCell').html(build_file_link(memo_url,'View Memo Budget',true));
            else $('#modalMemoCell').html('');
            $('#finance_invoice_upload').val('');
            $('#finance_proof_upload').val('');
            init_lightbox($('#detailModal'));
        }
        function upload_finance_file(field_name,file,input_selector){
            var row=finance_rows_by_id[String(modal_state.travel_id)];
            if(!row||!file) return;
            var fd=new FormData();
            fd.append('grantee_grant_id', row.grantee_grant_id);
            fd.append('eta_travel_arrangement_section_id', row.section_id);
            fd.append('field', field_name);
            fd.append('file', file);
            fd.append('am_travel_arrangement_id', modal_state.travel_id);
            $(input_selector).prop('disabled',true);
            $.ajax({
                url: window.eta_finance_config.save_field_url,
                type:'POST', data:fd, processData:false, contentType:false,
                success:function(resp){
                    if(!resp||!resp.success||!resp.data||!resp.data[field_name]){ alert('Failed to upload file'); return; }
                    finance_rows_by_id[String(modal_state.travel_id)][field_name]=resp.data[field_name];
                    render_detail_modal();
                },
                error:function(xhr){
                    var msg='Failed to upload file';
                    if(xhr.responseJSON&&xhr.responseJSON.message) msg=xhr.responseJSON.message;
                    alert(msg);
                },
                complete:function(){ $(input_selector).prop('disabled',false).val(''); }
            });
        }
        $(document).on('click','.js-finance-detail',function(){
            modal_state.travel_id=$(this).data('travel-id');
            modal_state.invoice_field=$(this).data('invoice-field');
            modal_state.proof_field=$(this).data('proof-field');
            render_detail_modal();
            $('#detailModal').css('display','flex');
        });
        window.closeDetailModal=closeDetailModal;
        $(document).on('click','#detailModal',function(e){ if(e.target===this) closeDetailModal(); });
        $('#finance_invoice_upload').on('change',function(){ if(this.files&&this.files[0]) upload_finance_file(modal_state.invoice_field,this.files[0],'#finance_invoice_upload'); });
        $('#finance_proof_upload').on('change',function(){ if(this.files&&this.files[0]) upload_finance_file(modal_state.proof_field,this.files[0],'#finance_proof_upload'); });
        init_lightbox($(document));
        $(document).on('click','.js-finance-add-payment',function(e){
            e.preventDefault();
            var user_id=$(this).data('user-id');
            var grantee_grant_id=$(this).data('grantee-grant-id');
            var travel_id=$(this).data('travel-id');
            var url=window.eta_finance_config.base_url+'admin/request_payment/request_form/'+user_id+'/'+grantee_grant_id+'?travel_arrangement_id='+travel_id;
            $.get(url,function(res){
                if(!res||!res.success){ alert('Failed to load payment form'); return; }
                var action=window.eta_finance_config.base_url+'admin/request_payment/request_save';
                var raw=String(res.html||'');
                var scripts=[];
                raw=raw.replace(/<script\b[^>]*>([\s\S]*?)<\/script>/gi,function(m,code){ scripts.push(code||''); return ''; });
                var container=$('<div id="modal_payment_container"></div>');
                container.html(raw);
                $('body').append(container);
                var modal=container.find('.modal').first();
                if(modal.length===0) modal=container.children().first();
                var form=modal.find('form#form');
                if(form.length===0){
                    form=$('<form id="form" method="post" enctype="multipart/form-data" action="'+action+'"></form>');
                    var body=modal.find('.modal-body');
                    var foot=modal.find('.modal-footer');
                    if(body.length){ body.after(form); form.append(body); if(foot.length) form.append(foot); }
                    else if(modal.find('.modal-content').length){ var c=modal.find('.modal-content'); c.prepend(form); form.append(c.children().not(form)); }
                    else { modal.append(form); form.append(modal.children().not(form)); }
                } else { form.attr('action',action).attr('method','post').attr('enctype','multipart/form-data'); }
                try{
                    modal.find('.select2').each(function(){ if(!$(this).data('select2')) $(this).select2({theme:'bootstrap', templateResult:function(data){ if(data.id==='__add_new__') return $('<span style="color:#337ab7;"> <span class="glyphicon glyphicon-plus"></span> '+data.text+'</span>'); return data.text; }}); });
                    if($.fn.datepicker) modal.find('.datepicker').datepicker({changeMonth:true, changeYear:true, dateFormat:'dd M yy', yearRange:'<?php echo date('Y')-150 ?>:<?php echo date('Y')+20 ?>'});
                }catch(e){}
                var sc=scripts.join('\n');
                var cleaned=sc.replace(/^\s*<script[^>]*>/i,'').replace(/<\/script>\s*$/i,'').replace(/<script\b[^>]*>[\s\S]*?<\/script>/gi,'\n');
                if(cleaned.trim()){ var se=document.createElement('script'); se.type='text/javascript'; try{ se.textContent=cleaned;}catch(err){ try{ se.appendChild(document.createTextNode(cleaned));}catch(ee){ se.text=cleaned; } } document.body.appendChild(se); }
                form=modal.find('form#form');
                if(travel_id){
                    if(form.find('input[name="travel_arrangement_id"]').length===0) form.append('<input type="hidden" name="travel_arrangement_id" value="'+travel_id+'" />');
                    else form.find('input[name="travel_arrangement_id"]').val(travel_id);
                }
                if(form.find('input[name="add_travel[user_id]"]').length===0) form.append('<input type="hidden" name="add_travel[user_id]" value="'+user_id+'" />');
                else form.find('input[name="add_travel[user_id]"]').val(user_id);
                if(form.find('input[name="add_travel[grantee_grant_id]"]').length===0) form.append('<input type="hidden" name="add_travel[grantee_grant_id]" value="'+grantee_grant_id+'" />');
                else form.find('input[name="add_travel[grantee_grant_id]"]').val(grantee_grant_id);
                if(form.find('input[name="add_travel[category]"]').length===0) form.append('<input type="hidden" name="add_travel[category]" value="International Travel" />');
                else form.find('input[name="add_travel[category]"]').val('International Travel');
                try{
                    var usp=new URL(window.location.href).searchParams;
                    var src=usp.get('source');
                    if(src){ if(form.find('input[name="add_travel[source_data]"]').length===0) form.append('<input type="hidden" name="add_travel[source_data]" value="'+src+'" />'); else form.find('input[name="add_travel[source_data]"]').val(src); }
                }catch(e){}
                try{ modal.modal('show'); }catch(e){ $('#mdl_add_travel').modal('show'); }
                form.on('submit',function(ev){
                    ev.preventDefault();
                    var fd=new FormData(this);
                    $.ajax({url:$(this).attr('action'),type:'POST',data:fd,processData:false,contentType:false,
                        success:function(data){
                            if(!data||!data.success){ alert('Failed to save payment'); return; }
                            finance_rows_by_id[String(travel_id)].payment_record_id=data.payment_id;
                            var btn=$('button.js-finance-add-payment[data-travel-id="'+travel_id+'"]');
                            if(btn.length){
                                var href=window.eta_finance_config.base_url+'admin/request_payment/edit/'+user_id+'/'+grantee_grant_id+'?pid=travel&payment_id='+data.payment_id;
                                var vb=$('<a class="btn btn-success btn-sm js-finance-view-payment" href="'+href+'" target="_blank" rel="noopener noreferrer">View Payment</a>');
                                btn.replaceWith(vb);
                            }
                            $('#mdl_add_travel').modal('hide'); setTimeout(function(){ $('#modal_payment_container').remove(); },300);
                        }, error:function(){ alert('Failed to save payment'); }
                    });
                });
                $(document).find('.modal-header').find('button').remove();
            },'json').fail(function(){ alert('Failed to load payment form'); });
        });
    });
</script>
<?php endif; ?>
