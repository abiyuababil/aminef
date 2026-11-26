<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">
            <?php echo $title ?>
            <a href="<?= base_url('admin/user_grantee_grant/download_excel_report/'.$grant_id.'/'.$fiscal_year.'/'.$report_id)?>" class="btn btn-primary pull-right mb-2">Export to Excel</a>
        </h3>
    </div>
    <div class="col-md-12">
        <div class="col-md-6">
                Report Result : <?= $report_name ?> <?= $fiscal_year ?>
            <hr>
            <?php //echo '<pre>';print_r($get_question);die;?>
            <?php foreach($get_question as $key=>$value): $options = json_decode($value['options']); ?>
                <?php if($value['type'] == 'checkbox' || $value['type'] == 'multiselect' || $value['type'] == 'select' || $value['type'] == 'radio') { ?>
                <div class="form-group">
                    <b><?= $value['name']; ?></b>
                    <hr>
                        <?php foreach($options as $option) :  ?>
                            <?php 
                                $total_question = $value['total_question'] ?? 0;
                                $total_percentase = $value['percentase'][$option]['total'] ?? 0;

                                $percentase = ($total_question > 0) ? round(($total_percentase / $total_question) * 100) : 0;
                            ?>
                            <div class="col-md-12 option-survey" data-period-id="<?= $period_id ?>" data-option="<?= $option;?>" data-option-type="<?= $value['type'] ?>" data-custom-fields-id="<?= $value['id']?>">
                                <?= $option; ?> <span style="float:right"><?= $value['percentase'][$option]['total'] ?>/<?= $value['total_question'] ?></span>
                                <!-- <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="<?= $percentase ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $percentase ?>%;">
                                        <span class="sr-only"><?= $percentase ?>% Complete</span>
                                    </div>
                                </div>   -->
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: <?= $percentase ?>%;" aria-valuenow="<?= $percentase ?>" aria-valuemin="0" aria-valuemax="100"><?= $percentase ?>%</div>
                                </div>    
                            </div>
                        <?php endforeach; ?>
                </div>
                <?php } ?>


                <?php if($value['type'] == 'multiple choice grid') { ?>
                <div class="form-group">
                    <b><?= $value['name']; ?></b>
                    <hr>
                    <canvas id="<?= $value['id'] ?>" style="width:100%;max-width:600px"></canvas>
                </div>
                <?php } ?>
            <?php endforeach; ?>
        </div>
        <div class="col-md-6">
            Text Questions Result
            <hr>
            <?php foreach($get_question as $key=>$value): ?>
                <?php if($value['type'] == 'text' || $value['type'] == 'input' || $value['type'] == 'date' || $value['type'] == 'datetime') { ?>
                <div class="form-group">
                    <b><?= $value['name']; ?></b><br />
                    <a href="#" data-question="<?= $value['name'] ?>" data-toggle="modal" data-target="#modal_answer" data-period-id="<?= $period_id ?>" data-option-type="<?= $value['type'] ?>" data-custom-fields-id="<?= $value['id']?>">View All Answers</a>
                    <hr>
                </div>
                <?php } ?>
            <?php endforeach; ?>
            <img src="<?php echo base_url() ?>/img/loading.gif" class="result-loading" style="display:none;">
            <table class="table table-result">
                <thead>
                    <tr>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody class="data-body">
                    <tr>
                        <td>
                            Not Found
                        </td>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<div class="modal fade" id="modal_answer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <img src="<?php echo base_url() ?>/img/loading.gif" class="result-loading" id="spinner">
            <table class="table table-result-text" width="100%">
                <tbody class="data-body-text">
                    <tr>
                        <td>
                            Not Found
                        </td>

                    </tr>
                </tbody>
            </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

<?php foreach($get_question as $key=>$value): 
    $label = $value['column_options'] ? json_decode($value['column_options']) : ''; 
    $options = $value['options'] ? json_decode($value['options']) : ''; 
?>
    <?php if($value['type'] == 'multiple choice grid') { ?>
        <script>
            // CHART
            var xValues = JSON.parse(`<?php echo safe_parse_json(json_encode($options)); ?>`);
            var data_baru = [<?php echo $value['data_bar']; ?>];
            var chrart_name = `<?= $value['id'] ?>`;

            new Chart(chrart_name, {
            type: "bar",
            data: {
                labels: xValues,
                datasets: data_baru
                },
            options: {
                scales: {
                y: {
                    beginAtZero: true
                }
                }
            },
            });
        </script>
    <?php } ?>
<?php endforeach; ?>