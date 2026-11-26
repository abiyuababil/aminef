<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default mt-4" style="background-color: white !important;">
            <div class="accordion" id="accordion_example">
                <?php 
                    $i = 0;
                    foreach($programs['active_grant'] as $program) {
                ?>
                <div class="card">
                    <div class="card-header bg-primary text-white" id="heading_one" style="border-bottom: 2px solid #ddd;">
                        <button class="bg-primary btn-link text-white" style="color: white !important; text-decoration:none; width:100% !important; text-align:left !important;" type="button" data-toggle="collapse" data-target="#collapse_<?php echo $program->id; ?>"  <?php echo $i == 0 ? 'aria-expanded="true"' : ''; ?> aria-controls="collapse_<?php echo $program->id; ?>">
                            <h5><?php echo $program->active_grant_name;  ?> (<?= $program->fiscal_year ?>)</h5>
                        </button>
                        <?php 
                            $condition_where = [
                                'user_grantee_grant_id' => $program->grant_id,
                                'is_active'             => 1,
                                'sort'                  => 1,
                                'category_name'         => 'Application'
                            ];

                            if ($program && (bool) $program->use_period_grant_page === true) {
                                $condition_where['period_id'] = $program->period_id;
                            } else {
                                $condition_where['period_id'] = null;
                            }
                            $categories = $this->User_grantee_grant_category_model->get_data($condition_where);

                            $params = [
                                'category_id' => $categories[0]->id,
                                'grants_id' => $program->grant_id,
                                'country_id' => $program->country,
                                'grantee_id' => $program->user_grantee_id,
                                'grantee_grant_id' => $program->id,
                            ];

                            $query_params = http_build_query($params);
                        ?>
                        <a class="btn btn-info pull-right mt-1 mr-2 btn-download" style="position: absolute; right:15px;" download href="<?php echo base_url('document/download_documents/' . $this->Grantee_ent_model->id . '/' . $program->grant_id . '?' . $query_params); ?>">Download</a>
                    </div>
                    <div id="collapse_<?php echo $program->id; ?>" class="collapse <?php echo $i == 0 ? 'in' : ''; ?>" aria-labelledby="heading_one" <?php echo $i == 0 ? 'aria-expanded="true"' : ''; ?> data-parent="#accordion_example">
                        <div class="card-body p-4" style="background-color: white; position: relative; z-index: 1;">
                            <div id="iframe_container_<?php echo $program->id; ?>" 
                                 class="iframe_container" 
                                 data-src="<?php echo base_url('document/pdf/' . $this->Grantee_ent_model->id . '/' . $program->grant_id . '?' . $query_params); ?>"
                                 style="width: 100%; height: 1000px;">
                                <div class="text-center">
                                    <p><i class="fa fa-circle-o-notch fa spin"></i> Loading document...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $i++; } ?>
            </div>
        </div>
    </div>
</div>
