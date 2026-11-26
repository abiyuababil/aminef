        <div class="row">
            <div class="col-md-6 col-md-offset-3">
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
                    <div class="panel-heading">
                        <img src="<?php echo base_url('css/images/logo.png') ?>">
                    </div>
                    <div class="panel-body">
						<form role="form" method="POST">
                            <div class="row">
                            <div class="col-md-6">
                                    <fieldset>
                                        <div class="form-group">
                                            <input class="form-control" autocomplete="off" placeholder="E-mail" name="email" type="email" value="<?php echo (isset($email)) ? $email : '' ?>" autofocus required>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" autocomplete="off" placeholder="Password" name="password" type="password" value="" required>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" autocomplete="off" placeholder="Confirm Password" name="password_confirm" type="password" value="">
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <fieldset>
                                        
                                        <div class="form-group">
                                            <input class="form-control" placeholder="Full Name" name="name" type="text" value="<?php echo (isset($name)) ? $name : '' ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control datepicker" placeholder="Date of Birth" name="birth_date" id="birth_date" type="text" value="<?php echo (isset($birth_date)) ? $birth_date : '' ?>" required>
                                        </div>
										<div class="form-group">
											<select class="form-control" name="program">
												<option value="">-- Select Country --</option>
													<?php
													if($program)
													{
														foreach($program as $sl) {
															$selected = '';
															if (isset($this->Country_model->id) && $this->Country_model->id == $sl->id)
																$selected = 'selected="selected"';
													?>
														<option value="<?php echo $sl->id ?>" <?php echo $selected ?>><?php echo $sl->name ?></option>
													<?php
														}
													}
													?>
											</select>
							
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-md-12">
                                    <input type="submit" class="btn btn-lg btn-success btn-block" value="REGISTER">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
        <br><br><br>
        <div class="row">
            <div class="col-md-6 col-md-offset-3 nestedcolor">
                <div align="center" class="doublecolor">
                    Already have an account? Please <a href="<?php echo site_url('user/login') ?>">Sign in</a>
                </div>
            </div>
        </div>
