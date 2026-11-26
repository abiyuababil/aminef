<style>
    .list-group {
        z-index: 10;
        display: none;
        color: red;
        top: 400px;
    }

    .password-show {
        position: absolute;
        right: 30px;
        cursor: pointer;
        color: #cacaca;
        width: 40px;
        line-height: 38px;
        text-align: center;
        z-index: 2;
    }
</style>

<div class="row eta-auth-row">
    <div class="col-md-8 col-md-offset-2 eta-auth">
        <div class="row">
            <div class="col-md-6 text-left"><img src="<?= base_url() ?>css/images/logo-aminef-2.png" width="130"></div>
            <div class="col-md-6 text-right"><img src="<?= base_url() ?>css/images/logo-fulbright-2.png" width="200">
            </div>
        </div>
        <div style="margin-top:10px">
            <?php if (isset($err_message)) { ?>
                <div class="alert alert-danger alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <?php echo $err_message ?>
                </div>
            <?php } ?>
            <?php if (isset($success_message)) { ?>
                <div class="alert alert-success alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <?php echo $success_message ?>
                </div>
            <?php } ?>
        </div>
        <div class="login-panel panel panel-default">
            <div class="panel-body">
                <div class="header mb-3" style="margin-bottom:20px; text-align: center;">
                    <h4>Register</h4>
                </div>
                <form role="form" method="POST">
                    <fieldset>
                        <div class="form-group">
                            <input required class="form-control" placeholder="Email" name="email"
                                type="email" autofocus value="<?php echo (isset($email) ? $email : '') ?>">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input required class="form-control" placeholder="Institution Name" name="institution_name"
                                        type="text" value="<?php echo (isset($institution_name) ? $institution_name : '') ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input required class="form-control" placeholder="Phone Number" name="phone_number"
                                        type="text" value="<?php echo (isset($phone_number) ? $phone_number : '') ?>">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <textarea required class="form-control" placeholder="Address" name="address"
                                rows="3"><?php echo (isset($address) ? $address : '') ?></textarea>
                        </div>

                        <div class="form-group">
                            <input required class="form-control" placeholder="Password" name="password" id="password"
                                type="password" value="" autocomplete="new-password">
                            <i class="fa fa-eye password-show" style="top: 266px;"></i>
                        </div>
                        <div class="form-group">
                            <input required class="form-control" placeholder="Confirm Password" name="password_confirmation" id="password_confirmation"
                                name="password_confirmation" type="password" value="">
                            <i class="fa fa-eye password-show" style="top: 326px;"></i>
                        </div>

                        <div class="form-group list-group" id="d1">
                            <span id="d12"><i class="fa fa-times" aria-hidden="true"></i> One Uppercase Letter</span> <br>
                            <span id="d15"><i class="fa fa-times" aria-hidden="true"></i> One Number</span> <br>
                            <span id="d16"><i class="fa fa-times" aria-hidden="true"></i> 8 Characters Long</span> <br>
                        </div>

                        <div class="text-center" style="background-color:#efefef;padding:20px; margin-bottom:15px;">
                            <p class="text-left" style="margin-bottom:0">
                                <input type="checkbox" class="form-check-input" id="agree" required> I agree to the <a
                                    href="javascript:;" data-toggle="modal" data-target="#myModal">Privacy Policy</a>
                                of AMINEF. <br>

                            </p>
                        </div>

                        <input type="submit" disabled class="btn btn-lg btn-block btn-subpas" value="Register"
                            style="background-color:#0089d1;color:#ffff">
                    </fieldset>
                </form>
            </div>
        </div>
        <p class="text-center" style="color:#ffff; margin-top: 20px;">
            Already have an account? <a href="<?= base_url() ?>host/login" style="color:red; text-decoration:underline;">Login Here</a>
        </p>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Privacy Policy</h4>
            </div>
            <div class="modal-body">
                <p>At www.aminef.or.id, accessible from http://www.aminef.or.id, one of our main priorities is the privacy of our visitors. This Privacy Policy document contains types of information that is collected and recorded by www.aminef.or.id and how we use it.</p>
                <p>If you have additional questions or require more information about our Privacy Policy, do not hesitate to contact us.</p>
                <p>This Privacy Policy only applies to our online activities and is valid for visitors to our website in relation to the information they share and/or collect on www.aminef.or.id. This policy does not apply to any information collected offline or through channels other than this website.</p>
                <h2>Consent</h2>
                <p>By using our website, you hereby consent to our Privacy Policy and agree to its terms.</p>
                <h2>Information we collect</h2>
                <p>Personal information that you are asked to provide, and the reasons why you are asked to provide it, will be made clear to you at the point we ask you to provide your personal information.</p>
                <p>If you contact us directly, we may receive additional information about you such as your name, email address, phone number, the contents of the message and/or attachments you may send us, and any other information you may choose to provide.</p>
                <p>When you register for an Account, we may ask for your contact information, including items such as name, company name, address, email address, and phone number.</p>
                <h2>How we use your information</h2>
                <p>We use the information we collect in various ways, including to:</p>
                <ul>
                    <li>Provide, operate, and maintain our website</li>
                    <li>Improve, personalize, and expand our website</li>
                    <li>Understand and analyze how you use our website</li>
                    <li>Develop new products, services, features, and functionality</li>
                    <li>Communicate with you, either directly or through one of our partners, including for customer service, to provide you with updates and other information relating to the website, and for marketing and promotional purposes</li>
                    <li>Send you emails</li>
                    <li>Detect and prevent fraud</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>