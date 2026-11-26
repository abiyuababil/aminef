<div class="row">
	<div class="col-lg-12">
		<h1><?= get_full_name($grantee_grant) ?></h1>
		<h3 class="page-header"><?= $page_title ?></h3>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row mb-5">
	<form role="form" method="POST" enctype="multipart/form-data">
		<?php $this->load->view('admin/nominee/submission_plan/form_input') ?>
	</form>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->