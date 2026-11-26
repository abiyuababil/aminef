<style>
.hero{
    background:linear-gradient(135deg,#0b3b82,#174ea6);
    color:#fff;
    border-radius:8px
}
.card{
    background-color: #fff;
    border:none;
    border-radius:8px;
    box-shadow:0 8px 24px rgba(0,0,0,.08)
}
.nav-pills .nav-link.active{
    background:#0b3b82
}
.stat{
    display:flex;
    justify-content: space-between;
    padding:.75rem 0;
    border-bottom:1px solid #fff
}
.timeline{
    display:flex;
    justify-content:space-between;
    gap:10px
}
.timeline .step{
    text-align:center;
    flex:1
}
.dot{
    width:18px;
    height:18px;
    background:#0d6efd;
    border-radius:50%;
    margin:auto
    }
</style>
<div class="row" style="padding-bottom:50px;">
    <div class="col-lg-8" style="padding-top:50px;">
        <div class="hero p-5 mb-4">
            <span class="badge badge-success">OPEN FOR APPLICATION</span>
            <h1 class="mt-3">Duolingo English Test - <?= $period->year ?></h1>

            <p><?= $period->term_name ?></p>
            <p>
                <span>Period : </span>
                <strong><?= date('d M Y', strtotime($period->start_date)) ?> (<?= date('H:i', strtotime($period->start_date)) ?> WIB) - <?= date('d M Y', strtotime($period->end_date)) ?> (<?= date('H:i', strtotime($period->end_date)) ?> WIB)</strong>
            </p>
            <!-- <p>Study for a master's degree in the United States with full funding.</p> -->
            <div class="d-flex gap-2">
                <a 
                    onclick="return confirm('Are you sure to choose this and already read thorough the details?');" 
                    href="<?php echo base_url('det/registration/apply/'. $period->id);?>" 
                    class="btn btn-default">Apply Now
                </a>
            </div>
        </div>
        <?php if($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?= $this->session->flashdata('error') ?>
            </div>
        <?php } ?>
        <?php $this->session->unset_userdata('error');?>

        <div class="card p-4 mb-4">
            <h3>Information</h3>
            <hr />
            <?= $period->info_text ?>
        </div>
    </div>
    <!-- <div class="col-lg-4" style="padding-top:50px;">
        <div class="card p-4">
            <div class="stat"><span>Status</span><span class="badge badge-success">Open</span></div>
            <div class="stat"><span>Period</span><strong><?= date('d M Y', strtotime($period->start_date)) ?> - <?= date('d M Y', strtotime($period->end_date)) ?></strong></div>
        </div>
    </div> -->
</div>