            <div class="row">
                <div class="col-lg-12">
					<h1 class="page-header" style="border-bottom:none;">My Program</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			<form role="form" method="POST">
            <div class="row" style="margin-bottom:10px">
			  <?php 
			  //var_dump($programs);
			  if ($programs) { ?>
				<?php
				foreach ($programs as $program) {
				
				?>
                <div class="col-lg-12">
					<div class="bs-example panel-green" data-example-id="simple-pagination"> 
						<h3><?php echo $program->name ?></h3>
					</div>
					
					<div class="jumbotron">
						<div class="col-lg-12">	
							<div class="row" style="white-space: pre-line;width:100%;padding-bottom: 20px;margin-bottom: 20px;">
								<?php 
								 echo htmlspecialchars($program->full_desc);
								?>
								
							</div>
							<?php /*
							<div class="row"><span class="detleft" style="min-height:30px;font-weight: bold;">University</span> <span class="detright" style="min-height:30px;"><?php echo $program->university ?></span> </div>
							 <div class="row"><span class="detleft" style="min-height:30px;font-weight: bold;">Country</span> <span class="detright"><?php if($program->country_id == 1){echo "Indonesia";}
								else{echo "America";}
							?></span> </div>
							*/ ?>
						</div>
					</div>
					
				</div>	
                <!-- /.col-lg-12 -->
				<?php } ?>
			  <?php }
				else{
					echo "<p style='margin-left:20px;'>Your Program is currently Not Active, Pleas Select a Program below that you want to apply</p>";
					//var_dump($program);
					if ($program) { 
						foreach ($program as $progr) { 
						?>
						<div class="col-lg-12">	
							<div class="panel panel-primary">
								<div class="panel-heading ">
									<?php echo $progr->name ?>
								</div>
								<div class="panel-body">
									<?php echo $progr->short_desc ?><br><br>
										
										<a href="<?php echo site_url('program/join_program/'.$progr->id) ?>" class="btn btn-success" id="jointhisprogram">
											<i class="fa fa-plus"></i> Join this program
										</a>
									
								</div>
							   							   
							</div>
						</div>
						<?php
						
						}
					}
				}
				?>
            </div>
            <!-- /.row -->
			</form>