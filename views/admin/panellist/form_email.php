
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $title ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<?php if($this->session->flashdata('error')) { ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= $this->session->flashdata('error') ?>
    </div>
<?php } ?>
<?php $this->session->unset_userdata('error');?>
<div class="row">
    <div class="tab-content">
        <div id="info" class="tab-pane fade active in">
            <form role="form" method="POST">
                <div class="col-lg-12">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Name" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                        </div>
                        <!-- <div class="form-group">
                            <input type="checkbox" style="cursor:pointer;" class="form-check-input" id="chck" value="1" name="with_bank_info">
                            <label style="cursor:pointer;" class="form-check-label" for="chck"> Need to input Bank Information</label>
                        </div> -->

                        <div class="form-group">
                            <a href="<?php echo site_url('admin/panellist/manage') ?>" class="btn btn-default">Back</a>
                            <button type="submit" class="btn btn-success">Send</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>