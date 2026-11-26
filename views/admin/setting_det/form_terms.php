<style>
	.mrl {
		margin-left: 8px !important;
	}
	.label-check {
		cursor:pointer;
	}

    .period-row { 
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 10px;
        border-left: 4px solid #013473;
        position: relative;
    }

    .panel-default .panel-heading{
        background-color: rgb(236 240 244);
        color: #000;
        /* border-radius: 8px;
        border-top-left-radius: 8px !important;
        border-top-right-radius: 8px !important; */
        padding: 20px;
    }

    .panel-collapse{
        border: 1px solid rgb(236 240 244);
    }
</style>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?php echo $title ?></h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->


<?php if($this->session->flashdata('success')) { ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= $this->session->flashdata('success') ?>
    </div>
<?php } ?>
<?php $this->session->unset_userdata('success');?>

<div class="row">
    <div class="col-lg-12 mb-5">
        <form role="form" method="POST" enctype="multipart/form-data">
            <div class="panel-body">
                <div class="form-group">
                    <label>Terms Name</label>
                    <input type="text" name="name" class="form-control" value="<?php echo (isset($terms->name)) ? $terms->name : '' ?>" required>
                    <?php if($terms->id){ ?>
                        <input type="hidden" name="id" value="<?php echo $terms->id ?>">
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label class="form-label fw-semibold">Agreement Template</label>
                    <input type="file" class="form-control" accept=".pdf" name="agreement_template" <?= isset($terms->agreement_template) ? '' : 'required' ?>>
                    <input type="hidden" id="agreement_template_delete" name="agreement_template_delete" value="0">
                    <?php if(isset($terms->agreement_template) && $terms->agreement_template != '') { ?>
                        <a href="<?= base_url($terms->agreement_template) ?>" class="lightbox agreement_template"><?= file_name($terms->agreement_template) ?></a> 
                        <a href="javascript:void(0)" class="delete_agreement_template ml-2"><i class="fa fa-trash text-danger"></i></a> 
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label> Is Active </label>
                    <input type="checkbox" value="1" name="is_active" <?= (!isset($terms->id)) || $terms->is_active == 1 ? "checked" : "" ?>>
                </div>
                <hr />
            </div>

            <a href="<?php echo $btn_back ?>" class="btn btn-default">Back</a>
            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </div>
</div>