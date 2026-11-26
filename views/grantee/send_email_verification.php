
<div class="row" style="margin-top:5%">
    <div class="col-md-4 col-md-offset-4">
        <div style="margin-top:10px">
            <?php if (isset($err_message) && $err_message != '') { ?>
            <div class="alert alert-danger alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <?php echo $err_message ?>
            </div>
            <?php } ?>
            <?php if (isset($success_message) && $success_message != '') { ?>
            <div class="alert alert-success alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <?php echo $success_message ?>
            </div>
            <?php } ?>
        </div>
        <div class="row">
                <div class="col-md-6" style="margin-left:-15px;"><img src="<?= base_url() ?>css/images/logo-aminef-2.png" width="130"></div>
                <div class="col-md-6"><img src="<?= base_url() ?>css/images/logo-fulbright-2.png" width="200"></div>
        </div>
        <div class="login-panel panel panel-default" style="margin-top:15%;">
            <div class="panel-body">
                <form role="form" method="POST">
                    <fieldset>
                        <div class="form-group">
                            <label>Email</label>
                            <textarea name="email" id="email" class="form-control" rows="9"></textarea>
                        </div>
                        <input type="submit" class="btn btn-lg btn-block" value="Send" style="background-color:#0089d1;color:#ffff;">
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>

