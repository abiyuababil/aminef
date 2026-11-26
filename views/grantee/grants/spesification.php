<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
    theme: {
    extend: {
        colors: {
        aminef: {
            navy: '#002e6e',
            navyDark: '#001e47',
            tabBlue: '#003a80',
            activeCyan: '#00b5e2',
            activeCyanHover: '#00a0c9',
            lightBg: '#edf2f7',
        }
        },
        fontFamily: {
        sans: ['Inter', 'sans-serif'],
        }
    }
    }
}
</script>
<style>
/* Custom clean scrollbars */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}
::-webkit-scrollbar-track {
    background: #f1f5f9;
}
::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}
::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Sticky column styling for table scroll */
.sticky-col {
    position: sticky;
    left: 0;
    z-index: 20;
}
.sticky-header {
    position: sticky;
    top: 0;
    z-index: 30;
}
.sticky-corner {
    position: sticky;
    top: 0;
    left: 0;
    z-index: 40;
}

/* Preserve raw line breaks from Excel */
.cell-preserve-break {
    white-space: pre-line;
    word-break: break-word;
}
</style>
<style>
    .nav-pills>li+li {
        margin-left: 0px;
    }

    .tab-pane {
        background-color: white;
    }

    .begin_button {
        float: right;
    }


    .nav-pills > li {
        background-color: #013473;
        border: 1px solid #ed3123;
        padding: 0;
    }

    .nav-pills > li > a {
        color: white;
        width: 100%;
        border-radius: 0 !important;
        margin: 0 !important;
    }

    /* Hover seluruh tab */
    .nav-pills > li:hover {
        background-color: #00b7f1 !important;
    }

    .nav-pills > li:hover > a {
        background-color: #00b7f1 !important;
        color: white;
    }

    /* Active */
    .nav-pills > li.active,
    .nav-pills > li.active > a,
    .nav-pills > li.active > a:focus,
    .nav-pills > li.active > a:hover {
        background-color: #00b7f1 !important;
        color: white;
    }
    
    .container-content ul {
        list-style-type: disc;
        padding-left: 3.5rem;
        margin-top: 1rem;
        margin-bottom: 1rem;
    }

    .container-content ol {
        list-style-type: decimal;
        padding-left: 1.5rem;
        margin-top: 1rem;
        margin-bottom: 1rem;
    }

    .container-content li {
        display: list-item;
        margin-bottom: 0.5rem;
    }

</style>
<?php 
    $notif = $this->session->userdata('alert_validation');
    if (isset($notif) && $notif != '') { ?>
    <div class="row">
        <div class="col-lg-12" style="margin-top:30px;">
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo $notif ?>
        </div>
        </div>
    </div>
<?php }  $this->session->unset_userdata('alert_validation');?>

<form autocomplete="new-password" id="form" role="form" method="POST" enctype="multipart/form-data">
    <input type="hidden" id="period_id_spesification" value="<?= $period_id ?>">
    <div class="row">
        <div class="col-lg-12" style="margin-bottom:10px; margin-top:30px;">
            <h2><b><?= $this->User_grantee_grant_model->name; ?></b></h2>
            <div class="tab-content" style="width: 100%;">
                <ul class="nav nav-pills nav-spec">
                    <li style="width: 11%;" class="active"><a data-toggle="tab" href="#activity" aria-expanded="true">Activity</a></li>
                    <li style="width: 11%;"><a data-toggle="tab" href="#grant_length" aria-expanded="true">Grant Length</a></li>
                    <li style="width: 11%;"><a data-toggle="tab" href="#spesific_requirement" aria-expanded="true">Specific Requirements</a></li>
                    <li style="width: 11%;"><a data-toggle="tab" href="#general_requirement" aria-expanded="true">General Requirements</a></li>
                    <li style="width: 13%;"><a data-toggle="tab" href="#submission_requirement" aria-expanded="true">Submission Requirements</a></li>
                    <?php //if($this->User_grantee_grant_model->is_degree) : ?>
                    <li class="show_hide_study" style="width: 10%;"><a data-toggle="tab" href="#field_of_study" aria-expanded="true">Field of Study</a></li>
                    <?php //endif; ?>
                    <li style="width: 10%;"><a data-toggle="tab" href="#deadline_note" aria-expanded="true">Deadline</a></li>
                    <li style="width: 11%;"><a data-toggle="tab" href="#aminef" aria-expanded="true">AMINEF</a></li>
                    <li style="width: 11%;"><a data-toggle="tab" href="#contact_information" aria-expanded="true">Support</a></li>
                    <li style="width: 11%;"><a data-toggle="tab" href="#how_to_apply" aria-expanded="true">How to Apply</a></li>

                </ul>
            </div>
            <div class="tab-content container-content" style="width: 100%;">
                <div id="activity" class="tab-pane fade active in">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?= $this->User_grantee_grant_model->activity; ?>
                        </div>
                    </div>
                </div>
                <div id="grant_length" class="tab-pane fade">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?= $this->User_grantee_grant_model->grant_length; ?>
                        </div>
                    </div>
                </div>
                <div id="spesific_requirement" class="tab-pane fade">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?= $this->User_grantee_grant_model->spesific_requirement; ?>
                        </div>
                    </div>
                </div>
                <div id="general_requirement" class="tab-pane fade">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?= $this->User_grantee_grant_model->general_requirement; ?>
                        </div>
                    </div>
                </div>
                <div id="submission_requirement" class="tab-pane fade">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?= $this->User_grantee_grant_model->submission_requirement; ?>
                        </div>
                    </div>
                </div>

                <?php //if($this->User_grantee_grant_model->is_degree) : ?>
                <div id="field_of_study" class="tab-pane fade show_hide_study">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="bg-white rounded-b-lg border border-slate-200 shadow-sm p-4 md:p-6 space-y-4">

                                <!-- Exact Disclaimer Notice from Excel File -->
                                <?php if($this->User_grantee_grant_model->field_of_study) : ?>
                                <div class="bg-sky-50/80 border-l-4 border-[#00b5e2] p-4 rounded-r-lg text-slate-700">
                                    <p class="text-base md:text-[13px] leading-relaxed">
                                        <?= $this->User_grantee_grant_model->field_of_study; ?>
                                    </p>
                                </div>
                                <?php endif; ?>

                                <!-- Filter & Total Counts -->
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-1">
                                    <div class="relative max-w-sm w-full">
                                        <i class="fa-solid fa fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                                        <input 
                                            type="text" 
                                            id="search-input"
                                            placeholder="Search field of study or requirements..." 
                                            class="w-full pl-8 pr-8 py-3 text-lg bg-slate-50 border border-slate-300 rounded focus:outline-none focus:border-[#00b5e2] focus:bg-white focus:ring-1 focus:ring-[#00b5e2] transition placeholder:text-slate-400"
                                        />
                                        <button id="clear-search" class="hidden absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-base">
                                        <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Responsive Table Container -->
                                <div class="overflow-x-auto border border-slate-200 rounded shadow-xs max-h-[640px]">
                                    <table class="w-full text-left border-collapse text-base md:text-[13px]">
                                        <thead>
                                        <tr class="bg-slate-100/95 text-slate-800 font-semibold border-b border-slate-200 text-base uppercase tracking-wider">
                                            <th class="py-3 px-4 font-bold border-r border-slate-200 sticky-corner bg-slate-100 min-w-[200px]">FIELD OF STUDY</th>
                                            <!-- <th class="py-3 px-3.5 text-center border-r border-slate-200 whitespace-nowrap min-w-[130px] sticky-header bg-slate-100">TOEFL (IIE)</th> -->
                                            <th class="py-3 px-3 text-center border-r border-slate-200 whitespace-nowrap min-w-[120px] sticky-header bg-slate-100">TOEFL ITP<br><span class="text-[10px] font-normal normal-case text-slate-500">(310-677)</span></th>
                                            <th class="py-3 px-3 text-center border-r border-slate-200 whitespace-nowrap min-w-[120px] sticky-header bg-slate-100">TOEFL iBT<br><span class="text-[10px] font-normal normal-case text-slate-500">(0-120)</span></th>
                                            <th class="py-3 px-3 text-center border-r border-slate-200 whitespace-nowrap min-w-[110px] sticky-header bg-slate-100">TOEFL iBT<br><span class="text-[10px] font-normal normal-case text-slate-500">(1-6)</span></th>
                                            <th class="py-3 px-3 text-center border-r border-slate-200 whitespace-nowrap min-w-[100px] sticky-header bg-slate-100">IELTS<br><span class="text-[10px] font-normal normal-case text-slate-500">(0-9)</span></th>
                                            <th class="py-3 px-3 text-center border-r border-slate-200 whitespace-nowrap min-w-[130px] sticky-header bg-slate-100">Duolingo/DET<br><span class="text-[10px] font-normal normal-case text-slate-500">(10-160)</span></th>
                                            <!-- <th class="py-3 px-4 border-r border-slate-200 min-w-[260px] sticky-header bg-slate-100">GRE</th>
                                            <th class="py-3 px-4 min-w-[420px] sticky-header bg-slate-100">Additional Considerations</th> -->
                                        </tr>
                                        </thead>
                                        <tbody id="table-body" class="divide-y divide-slate-200 bg-white">
                                        <!-- Rendered via JavaScript -->
                                        </tbody>
                                    </table>
                                
                                    <div id="no-results" class="hidden p-10 text-center text-slate-400">
                                        <i class="fa-solid fa-filter-circle-xmark text-2xl mb-2"></i>
                                        <p>No matching field of study found.</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <?php //endif; ?>

                <div id="deadline_note" class="tab-pane fade">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?= $this->User_grantee_grant_model->deadline_note; ?>
                        </div>
                    </div>
                </div>
                <div id="how_to_apply" class="tab-pane fade">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?= $this->User_grantee_grant_model->how_to_apply; ?>
                            <?php if($this->User_grantee_grant_model->form_ofline != '') { ?>
                            <a href="<?= base_url($this->User_grantee_grant_model->form_ofline) ?>" class="btn btn-info" download>Download Form</a>
                            <?php } ?>
                        </div>
                    </div>
                        
                    <div class="mt-5">
                        <?php if(!$is_registered) { ?>
                            <?php if(!$is_complate_filed_required) { ?>
                                <a onclick="return confirm('To submit your application, please complete your profile');" href="<?php echo base_url('grantee/profile/form/'. $this->User_grantee_grant_model->id);?>" class="btn btn-success begin_button">BEGIN APPLICATION PROCESS</a>
                            <?php }else { ?>
                                <a onclick="return confirm('Are you sure to choose this program and already read thorough the details?');" href="<?php echo base_url('grantee/grants/begin_program/'. $this->User_grantee_grant_model->id.'/'.$period_id);?>" class="btn btn-success begin_button">BEGIN APPLICATION PROCESS</a>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
                <div id="aminef" class="tab-pane fade">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?= $this->User_grantee_grant_model->aminef; ?>
                        </div>
                    </div>
                </div>
                <div id="contact_information" class="tab-pane fade">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?= $this->User_grantee_grant_model->contact_information; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>