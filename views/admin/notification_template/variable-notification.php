
<div class="col-lg-12" style="font-size:12px">
    <div class="col-lg-6">
        <p>Grantee Fullname <span class="pull-right"><a href="#" class="add_merge_field">{full_name_grantee}</a></span></p>
        <?php if($this->session->userdata('active_country') == AMERICAN_DATABASE) : ?>
            <p>First Name <span class="pull-right"><a href="#" class="add_merge_field">{first_name}</a></span></p>
            <p>Middle Name <span class="pull-right"><a href="#" class="add_merge_field">{middle_name}</a></span></p>
            <p>Last Name <span class="pull-right"><a href="#" class="add_merge_field">{last_name}</a></span></p>
        <?php endif; ?>
        <p>Fiscal Year <span class="pull-right"><a href="#" class="add_merge_field">{fiscal_year}</a></span></p>
        <p>Program Name <span class="pull-right"><a href="#" class="add_merge_field">{program_name}</a></span></p>
        <p>Status <span class="pull-right"><a href="#" class="add_merge_field">{status}</a></span></p>
        <p>Document Name <span class="pull-right"><a href="#" class="add_merge_field">{document_name}</a></span></p>
        <p>Status <span class="pull-right"><a href="#" class="add_merge_field">{status}</a></span></p>
    </div>
</div>