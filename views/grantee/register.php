		<style>
			.list-group {
				z-index:10;
				display:none; 
				/* position:absolute;  */
				color:red;
				top:400px;
			}
		</style>
		
		<div class="row" style="margin-top:5%">
            <div class="col-md-4 col-md-offset-4">
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
                <div class="row">
                        <div class="col-md-6" style="margin-left:-15px;"><img src="<?= base_url() ?>css/images/logo-aminef-2.png" width="130"></div>
                        <div class="col-md-6"><img src="<?= base_url() ?>css/images/logo-fulbright-2.png" width="200"></div>
                </div>
                <div class="login-panel panel panel-default" style="margin-top:15%;">
                    <div class="panel-body">
                        <div class="header mb-3" style="margin-bottom:20px">
                            <h3 class="panel-title text-center" style="color:#0089d1;"><i class="fa fa-clipboard fa-3x"></i></h3>
                            <h3 class="panel-title text-center">Register</h3>
                        </div>
						<form role="form" method="POST">
                            <fieldset>
                                <div class="form-group">
                                    <input required class="form-control" placeholder="First Name" name="first_name" type="text" autofocus value="<?php echo (isset($first_name) ? $first_name : '') ?>">
									<input type="checkbox" value="1" autocomplete="off" name="dont_have_first_name" class="dont_have_first_name form-check-input" id="dont_have_first_name5" <?= $dont_have_first_name == 1 ? "checked" : "" ?>>
									<label class="is_unlimited_label" for="dont_have_first_name5" style="font-weight:400 !important;">I do not have a first/given name</label>
                                </div>
                                <div class="form-group">
                                    <input required class="form-control" placeholder="Last Name" name="last_name" type="text" value="<?php echo (isset($last_name) ? $last_name : '') ?>">
                                </div>
                                <div class="form-group">
                                    <input required class="form-control datepicker" name="birth_date" placeholder="Date of Birth" readonly style="background-color:#fff" value="<?php echo (isset($birth_date)) ? $birth_date : '' ?>">
                                </div>
                                <div class="form-group">
                                    <input required class="form-control" placeholder="Email" name="email" type="text" value="<?php echo (isset($email) ? $email : '') ?>">
                                </div>
                                <div class="form-group password-group">
                                    <input required class="form-control" placeholder="Password" name="password" id="password" type="password" value="" autocomplete="new-password">
                                    <i class="fa fa-eye password-show"></i>
                                </div>
                                <div class="form-group password-group">
                                    <input required class="form-control" placeholder="Confirm Password" name="password_confirm" type="password" value="">
                                    <i class="fa fa-eye password-show"></i>
                                </div>
                                <!-- <div class="form-group">
									<input type="checkbox" class="form-check-input" id="chk-offline">
									<label class="form-check-label" for="chk-offline"> Previously Registered Offline</label>
                                </div>
                                <div class="form-group hide form-offline">
                                    <input class="form-control datepickeror" placeholder="Offline Register Date" name="offline_register_date" type="text" value="">
                                    <a href="javascript:;" onclick="emptyValue(this)" class="btn btn-secondary" style="position:absolute;top:557px;right:30px;color:#cacaca">X</a>
                                </div> -->
								<div class="form-group list-group" id="d1">
									<span id="d12"><i class="fa fa-times" aria-hidden="true"></i> One Upper Case Letter</span> <br>
									<span id="d15"><i class="fa fa-times" aria-hidden="true"></i> One Number</span> <br>
									<span id="d16"><i class="fa fa-times" aria-hidden="true"></i> Length 8 Char</span> <br>
								</div>
                                <div class="text-center" style="background-color:#efefef;padding:20px;">
                                    <p class="text-left" style="margin-bottom:0">
									  <input type="checkbox" class="form-check-input" id="agree" required> By clicking Register, I agree to the AMINEF <br>
									  &nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" data-toggle="modal" data-target="#myModal">Privacy Policy</a>.
									</p>
                                </div>
                                
								<input type="submit" disabled class="btn btn-lg btn-block btn-subpas" value="Register" style="background-color:#0089d1;color:#ffff">
                            </fieldset>
                        </form>
                    </div>
                </div>
                <p class="text-center" style="color:#ffff">Already have an account? Please <a href="<?= base_url() ?>grantee/" style="color:red;">Login</a></p>
            </div>
        </div>

		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">AMINEF Privacy Policy</h4>
			  </div>
			  <div class="modal-body">

				<p>At www.aminef.or.id, accessible from http://www.aminef.or.id, one of our main priorities is the privacy of our visitors. This Privacy Policy document contains types of information that is collected and recorded by www.aminef.or.id and how we use it.</p>

				<p>If you have additional questions or require more information about our Privacy Policy, do not hesitate to contact us.</p>

				<p>This Privacy Policy applies only to our online activities and is valid for visitors to our website with regards to the information that they shared and/or collect in www.aminef.or.id. This policy is not applicable to any information collected offline or via channels other than this website.</p>

				<h2>Consent</h2>

				<p>By using our website, you hereby consent to our Privacy Policy and agree to its terms.</p>

				<h2>Information we collect</h2>

				<p>The personal information that you are asked to provide, and the reasons why you are asked to provide it, will be made clear to you at the point we ask you to provide your personal information.</p>
				<p>If you contact us directly, we may receive additional information about you such as your name, email address, phone number, the contents of the message and/or attachments you may send us, and any other information you may choose to provide.</p>
				<p>When you register for an Account, we may ask for your contact information, including items such as name, company name, address, email address, and telephone number.</p>

				<h2>How we use your information</h2>

				<p>We use the information we collect in various ways, including to:</p>

				<ul>
				<li>Provide, operate, and maintain our website</li>
				<li>Improve, personalize, and expand our website</li>
				<li>Understand and analyze how you use our website</li>
				<li>Develop new products, services, features, and functionality</li>
				<li>Communicate with you, either directly or through one of our partners, including for customer service, to provide you with updates and other information relating to the website, and for marketing and promotional purposes</li>
				<li>Send you emails</li>
				<li>Find and prevent fraud</li>
				</ul>

				<h2>Log Files</h2>

				<p>www.aminef.or.id follows a standard procedure of using log files. These files log visitors when they visit websites. All hosting companies do this and a part of hosting services' analytics. The information collected by log files include internet protocol (IP) addresses, browser type, Internet Service Provider (ISP), date and time stamp, referring/exit pages, and possibly the number of clicks. These are not linked to any information that is personally identifiable. The purpose of the information is for analyzing trends, administering the site, tracking users' movement on the website, and gathering demographic information.</p>

				<h2>Cookies and Web Beacons</h2>

				<p>Like any other website, www.aminef.or.id uses 'cookies'. These cookies are used to store information including visitors' preferences, and the pages on the website that the visitor accessed or visited. The information is used to optimize the users' experience by customizing our web page content based on visitors' browser type and/or other information.</p>

				<p>For more general information on cookies, please read <a href="https://www.cookieconsent.com/">more on the Cookie Consent website</a>.</p>



				<h2>Advertising Partners Privacy Policies</h2>

				<P>You may consult this list to find the Privacy Policy for each of the advertising partners of www.aminef.or.id.</p>

				<p>Third-party ad servers or ad networks uses technologies like cookies, JavaScript, or Web Beacons that are used in their respective advertisements and links that appear on www.aminef.or.id, which are sent directly to users' browser. They automatically receive your IP address when this occurs. These technologies are used to measure the effectiveness of their advertising campaigns and/or to personalize the advertising content that you see on websites that you visit.</p>

				<p>Note that www.aminef.or.id has no access to or control over these cookies that are used by third-party advertisers.</p>

				<h2>Third Party Privacy Policies</h2>

				<p>www.aminef.or.id's Privacy Policy does not apply to other advertisers or websites. Thus, we are advising you to consult the respective Privacy Policies of these third-party ad servers for more detailed information. It may include their practices and instructions about how to opt-out of certain options. </p>

				<p>You can choose to disable cookies through your individual browser options. To know more detailed information about cookie management with specific web browsers, it can be found at the browsers' respective websites.</p>

			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div>
		  </div>
		</div>
