
<div class="col-lg-12" style="font-size:12px">
    <div class="col-lg-6">
        <p>Grantee Fullname <span class="pull-right"><a href="#" class="add_merge_field">{full_name_grantee}</a></span></p>
        <p>Grantee Name <span class="pull-right"><a href="#" class="add_merge_field">{grantee_name}</a></span></p>
        <?php if($this->session->userdata('active_country') == AMERICAN_DATABASE) : ?>
            <p>First Name <span class="pull-right"><a href="#" class="add_merge_field">{first_name}</a></span></p>
            <p>Middle Name <span class="pull-right"><a href="#" class="add_merge_field">{middle_name}</a></span></p>
            <p>Last Name <span class="pull-right"><a href="#" class="add_merge_field">{last_name}</a></span></p>
        <?php endif; ?>
        <p>Fiscal Year <span class="pull-right"><a href="#" class="add_merge_field">{fiscal_year}</a></span></p>
        <p>Program Name <span class="pull-right"><a href="#" class="add_merge_field">{program_name}</a></span></p>
        <p>Status <span class="pull-right"><a href="#" class="add_merge_field">{status}</a></span></p>
        <p>Travel Purpose <span class="pull-right"><a href="#" class="add_merge_field">{travel_purpose}</a></span></p>
        <p>Category Travel <span class="pull-right"><a href="#" class="add_merge_field">{category}</a></span></p>
        <p>Period/Fiscal Year <span class="pull-right"><a href="#" class="add_merge_field">{period}</a></span></p>
        <p>Sender Name <span class="pull-right"><a href="#" class="add_merge_field">{sender_name}</a></span></p>
        <p>Chat Message <span class="pull-right"><a href="#" class="add_merge_field">{chat_message}</a></span></p>
    </div>
</div>