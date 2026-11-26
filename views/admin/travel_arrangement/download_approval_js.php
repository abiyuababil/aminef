<?php
$current_main_js = isset($main_tab) ? $main_tab : 'non_eta';
?>
<script>
function handleFiscalChangeDownload(select) {
    var form = document.forms.frm_download_non_eta;
    if (!form) return;
    var prog = document.getElementById('program_select');
    if (select.value === 'All') {
        if (prog) {
            prog.disabled = true;
            prog.innerHTML = '<option value="0">Select fiscal year first</option>';
        }
        form.submit();
    } else {
        if (prog) prog.disabled = false;
        // reset program to 0 to reload programs for this fiscal year
        if (prog) prog.value = '0';
        form.submit();
    }
}
(function(){
    var fy = document.getElementById('fiscal_year_select');
    var prog = document.getElementById('program_select');
    if (fy && prog && fy.value === 'All') {
        prog.disabled = true;
    }
})();
function toggleDownloadAccordion(id) {
    var el = document.getElementById(id);
    if (el) el.classList.toggle('active');
}
function closeDownloadDetailModal() {
    var m = document.getElementById('detailModal');
    if (m) m.style.display = 'none';
}
</script>
<?php if ($current_main_js === 'eta'): ?>
<?php
// COPY (bukan reuse) dari finance international popup.
// Flatten grouped rows untuk kebutuhan detail modal di halaman ini saja.
$flat_rows = [];
if (!empty($grouped_rows) && is_array($grouped_rows)) {
    foreach ($grouped_rows as $sec_rows) {
        foreach ((array) $sec_rows as $r) {
            $flat_rows[] = $r;
        }
    }
}
$js_active_tab = isset($active_tab) ? $active_tab : 'international';
$js_selected = isset($selected_flights) ? $selected_flights : [];
?>
<script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
<?php echo $this->load->view('admin/request_payment/form_js', null, true); ?>
<script>
// Copy mandiri untuk Download Approval (ETA) - tidak load finance_js agar finance tidak ikut berubah.
window.eta_download_rows = <?php echo json_encode($flat_rows, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>;
window.eta_download_selected_flights = <?php echo json_encode($js_selected, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>;
window.eta_download_config = {
    base_url: <?php echo json_encode(base_url(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
    site_url: <?php echo json_encode(site_url(''), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
    save_field_url: <?php echo json_encode(site_url('admin/eta_travel_arrangement/save_field'), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
    active_tab: <?php echo json_encode($js_active_tab, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
    status_labels: {
        '1': <?php echo json_encode(eta_travel_status_label(1), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
        '2': <?php echo json_encode(eta_travel_status_label(2), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
        '3': <?php echo json_encode(eta_travel_status_label(3, $js_active_tab), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
        '4': <?php echo json_encode(eta_travel_status_label(4), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
        '7': <?php echo json_encode(eta_travel_status_label(7), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>
    }
};
function downloadBatchApproval(section_id, ids_str){
    if(!ids_str){ alert('No grantees in this section'); return; }
    var url = window.eta_download_config.base_url + 'admin/travel_arrangement/download_approval/eta?section_id=' + section_id + '&ids=' + encodeURIComponent(ids_str);
    window.open(url,'_blank');
}
window.downloadBatchApproval = downloadBatchApproval;
function closeDownloadDetailModal(){ var m=document.getElementById('detailModal'); if(m) m.style.display='none'; }
window.closeDetailModal = closeDownloadDetailModal;
$(function(){
    var download_rows_by_id = {};
    var selected_flights_by_id = window.eta_download_selected_flights || {};
    var modal_state = { travel_id:null, invoice_field:null, proof_field:null };
    (window.eta_download_rows||[]).forEach(function(row){ download_rows_by_id[String(row.id)]=row; });
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
        if(lightbox) return '<a class="'+cls+'" href="'+window.eta_download_config.base_url+String(path).replace(/^\//,'')+'">'+escape_html(label)+'</a>';
        return '<a class="'+cls+'" href="'+window.eta_download_config.base_url+String(path).replace(/^\//,'')+'" target="_blank" rel="noopener noreferrer">'+escape_html(label)+'</a>';
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
            var href=window.eta_download_config.base_url+String(paths[0]).replace(/^\//,'');
            return '<a class="btn btn-sm btn-primary lightbox" href="'+href+'">View</a>';
        }
        var html='<ul class="ticket-list">';
        paths.forEach(function(p){
            var href=window.eta_download_config.base_url+String(p).replace(/^\//,'');
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
    function render_download_detail_modal(){
        var row=download_rows_by_id[String(modal_state.travel_id)];
        if(!row) return;
        var is_intl=window.eta_download_config.active_tab==='international';
        var is_accom=window.eta_download_config.active_tab==='accommodation';
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
        var status_text=window.eta_download_config.status_labels[String(row.status||'')]||(is_accom?'Voucher Sent':'Ticket Sent');
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
        if(is_accom){
            var proposed_accom_path=row.accommodation_proposed_file||'';
            if(proposed_accom_path) $('#modalProposedAccomCell').html(build_file_link(proposed_accom_path,'View',true));
            else $('#modalProposedAccomCell').html('<span class="text-muted small">No file</span>');
            $('#modalProposedAccomRow').show();
        } else {
            $('#modalProposedAccomRow').hide();
        }
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
        var approval_url='admin/travel_arrangement/download_approval/eta?section_id='+row.section_id+'&ids='+row.id;
        $('#modalApprovalCell').html(build_file_link(approval_url,'View',false));
        var memo_url=row.memo_budget_url||'';
        if(memo_url) $('#modalMemoCell').html(build_file_link(memo_url,'View Memo Budget',true));
        else $('#modalMemoCell').html('');
        $('#finance_invoice_upload').val('');
        $('#finance_proof_upload').val('');
        init_lightbox($('#detailModal'));
    }
    function upload_download_file(field_name,file,input_selector){
        var row=download_rows_by_id[String(modal_state.travel_id)];
        if(!row||!file) return;
        var fd=new FormData();
        fd.append('grantee_grant_id', row.grantee_grant_id);
        fd.append('eta_travel_arrangement_section_id', row.section_id);
        fd.append('field', field_name);
        fd.append('file', file);
        fd.append('am_travel_arrangement_id', modal_state.travel_id);
        $(input_selector).prop('disabled',true);
        $.ajax({
            url: window.eta_download_config.save_field_url,
            type:'POST', data:fd, processData:false, contentType:false,
            success:function(resp){
                if(!resp||!resp.success||!resp.data||!resp.data[field_name]){ alert('Failed to upload file'); return; }
                download_rows_by_id[String(modal_state.travel_id)][field_name]=resp.data[field_name];
                render_download_detail_modal();
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
        render_download_detail_modal();
        $('#detailModal').css('display','flex');
    });
    $(document).on('click','#detailModal',function(e){ if(e.target===this) closeDownloadDetailModal(); });
    $('#finance_invoice_upload').on('change',function(){ if(this.files&&this.files[0]) upload_download_file(modal_state.invoice_field,this.files[0],'#finance_invoice_upload'); });
    $('#finance_proof_upload').on('change',function(){ if(this.files&&this.files[0]) upload_download_file(modal_state.proof_field,this.files[0],'#finance_proof_upload'); });
    init_lightbox($(document));
});
</script>
<?php endif; ?>
