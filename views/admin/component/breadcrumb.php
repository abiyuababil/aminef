            <div class="row">
                <div class="col-lg-12">
					<ol class="breadcrumb">
					<?php
					$no = 1;
					foreach($crumbs as $text => $url) {
						$active_class = '';
						$link = '<a href="'.$url.'">'.$text.'</a>';
						if ($no == count($crumbs))
						{
							$active_class = 'class="active"';
							$link = $text;
						}
					?>
					  <li <?php echo $active_class ?>><?php echo $link ?></li>
					<?php
						$no++;
					}
					?>
					</ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
