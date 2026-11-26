<div class="row" style="padding:30px 0">
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h3 style="margin:0"><?php echo $this->User_model->full_name() ?></h3>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-3 col-lg-3" align="center">
            <?php
            $user_pic = base_url('img/alumni-no-photo.jpg');
            if ($this->User_model->img_photo)
                $user_pic = base_url($this->User_model->img_photo);
            ?>
            <img alt="User Pic" src="<?php echo $user_pic ?>" class="img-circle img-responsive">
          </div>
          
          <div class="col-md-9 col-lg-9"> 
            <table class="table table-user-information" style="margin-bottom:0">
              <tbody>
              <?php
              if ($user_programs) {
                foreach ($user_programs as $up) {
                    $program = $programs[$up->program_id];
                    $sf = $study_fields[$up->study_field_id];
                    if($this->User_model->country_id == 1) {
                        $sf = $this->User_model->source == 2 ? $study_fields2[$up->study_field_id] : $study_fields[$up->study_field_id];
                    }
                    $sf_name = $up->is_final_placement ? $sf->name : $up->study_field_inputs;
              ?>
                <tr>
                  <td colspan="2"><h4><?php echo $program->name ?></h4></td>
                </tr>
                <?php if ($this->User_model->is_not_empty($sf->name)) { ?>
                <tr>
                  <td width="150">Field of Study:</td>
                  <td><?php echo $sf_name ?></td>
                </tr>
                <?php } ?>
                <?php if ($this->User_model->is_not_empty($up->home_institution)) { ?>
                <tr>
                  <td>Home Institution:</td>
                  <td><?php echo $up->home_institution ?></td>
                </tr>
                <?php } ?>
                <?php if ($this->User_model->is_not_empty($up->host_institution)) { ?>
                <tr>
                  <td>Host Institution:</td>
                  <td><?php echo $up->host_institution ?></td>
                </tr>
                <?php } ?>
                <?php if ($this->User_model->is_not_empty($up->year_departure) && $up->year_departure != 0) { ?>
                <tr>
                  <td>Year:</td>
                  <td><?php echo $up->year_departure ?></td>
                </tr>
                <?php } ?>
                <?php if ($this->User_model->is_not_empty($up->dissertation_title)) { ?>
                <tr>
                  <td>Project Title:</td>
                  <td><?php echo $up->dissertation_title ?></td>
                </tr>
                <?php } ?>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
              <?php
                }
              }
              
              $has_publication_title = false;
              if ($info && isset($info['publications']) && !empty($info['publications'])) {
                  foreach ($info['publications'] as $pub) {
                      if (!empty($pub->title)) {
                          $has_publication_title = true;
                          break;
                      }
                  }
              }
              if ($has_publication_title) {
              ?>
                <tr>
                  <td colspan="2"><h4>Publications</h4></td>
                </tr>
                <?php foreach ($info['publications'] as $pub) { ?>
                  <?php if (!empty($pub->link) || !empty($pub->title)) { ?>
                  <tr>
                    <td colspan="2">
                      <?php if (!empty($pub->link)) { ?>
                        <a href="javascript:;" onclick="notify_outlink(this)" data-target="<?php echo $pub->link ?>"><?php echo $pub->title ?></a>
                      <?php } else { ?>
                        <?php echo $pub->title ?>
                      <?php } ?>
                    </td>
                  </tr>
                  <?php } ?>
                <?php } ?>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
              <?php
              }
              
              $has_other_update_title = false;
              if ($info && isset($info['other_updates']) && !empty($info['other_updates'])) {
                  foreach ($info['other_updates'] as $pub) {
                      if (!empty($pub->title)) {
                          $has_other_update_title = true;
                          break;
                      }
                  }
              }
              if ($has_other_update_title) {
              ?>
                <tr>
                  <td colspan="2"><h4>Other Updates</h4></td>
                </tr>
                <?php foreach ($info['other_updates'] as $pub) { ?>
                  <?php if (!empty($pub->link) || !empty($pub->title)) { ?>
                  <tr>
                    <td colspan="2">
                      <?php if (!empty($pub->link)) { ?>
                        <a href="javascript:;" onclick="notify_outlink(this)" data-target="<?php echo $pub->link ?>"><?php echo $pub->title ?></a>
                      <?php } else { ?>
                        <?php echo $pub->title ?>
                      <?php } ?>
                    </td>
                  </tr>
                  <?php } ?>
                <?php } ?>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
              <?php
              }
              
              $current_institution = '';
              if ($this->User_model->of_department) {
                  $tmp = explode("\n", $this->User_model->of_department);
                  $current_institution = trim($tmp[0]);
              }
              ?>
                <tr>
                  <td width="150">Current Institution:</td>
                  <td><?php echo $current_institution ?></td>
                </tr>
                <tr>
                  <td>Last Modified:</td>
                  <td><?php echo $this->User_model->date_modified ? date('m/d/Y', strtotime($this->User_model->date_modified)) : '' ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <a href="https://www.aminef.or.id/" class="btn btn-warning" style="background-color:#EE3424; border-color:#EE3424;">Back to Home</a>
    <a href="<?php echo $back_url ?>" class="btn btn-warning" style="background-color:#EE3424; border-color:#EE3424;">Back to Alumni Directory</a>
  </div>
</div>

<div id="notifyModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Leave AMINEF</h4>
      </div>
      <div class="modal-body text-center">
        <h4 class="text-danger">Are you sure want to leave AMINEF website?</h4>
        <p>You will redirected to below link:</p>
        <p id="gotolink"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <a id="yes-link" href="#" class="btn btn-primary" target="_blank">Yes</a>
      </div>
    </div>
  </div>
</div>
