
<div class="row">
    <!-- <div class="col-lg-12" style="margin-bottom:10px">
        <ul class="nav nav-pills">
            <li id="li_university" <?php echo $default_tab_active ?>><a data-toggle="tab" href="#university" aria-expanded="true">University</a></li>
            <li id="li_allowance"><a data-toggle="tab" href="#allowance" aria-expanded="true">Allowance</a></li>
        </ul>
    </div> -->

    <?php //echo '<pre>';print_r($final_placement);die;?>
    <div class="tab-content">
        <div id="university" class="">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <!-- <div class="panel-body">
                        <p style="font-weight:bold;margin-bottom:25px;"><i class="fa fa-circle mt-5" style="color:#4da6ff;margin-right:5px;"></i> FINAL PLACEMENT</p>
                    </div> -->
                    <div class="panel-body">
                        <div class="row">
                            <?php $this->load->view('admin/partials/field_final_placement') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="allowance" class="tab-pane fade">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <table width="100%">
                                    <tr>
                                        <td width="50%"></td>
                                        <td class="text-center"><label>Aminef Allowance</label></td>
                                        <!-- <td class="text-center"><label>Actual Spend</label></td> -->
                                    </tr>
                                    <tr>
                                        <td><label>Settling in Allowance</label></td>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-addon">$</div>
                                                <input style="z-index: 0" type="text" class="form-control" value="<?= $data_period->settling_allowance ? number_format($data_period->settling_allowance) : '' ?>" readonly>
                                            </div>
                                        </td>
                                        <!-- <td>
                                            <div class="input-group">
                                                <div class="input-group-addon">$</div>
                                                <input style="z-index: 0" class="form-control actual" id="actual-settling" value="<?= $grantee_grant->actual_settling ? number_format($grantee_grant->actual_settling) : '' ?>">
                                            </div>
                                        </td> -->
                                    </tr>
                                    <tr>
                                        <td><label>Computer/Technology Allowance</label></td>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-addon">$</div>
                                                <input style="z-index: 0" type="text" class="form-control" value="<?= $data_period->technology_allowance ? number_format($data_period->technology_allowance) : '' ?>" readonly>
                                            </div>
                                        </td>
                                        <!-- <td>
                                            <div class="input-group">
                                                <div class="input-group-addon">$</div>
                                                <input style="z-index: 0" class="form-control actual" id="actual-technology" value="<?= $grantee_grant->actual_technology ? number_format($grantee_grant->actual_technology) : '' ?>">
                                            </div>
                                        </td> -->
                                    </tr>
                                    <tr>
                                        <td><label>Travel Allowance</label></td>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-addon">$</div>
                                                <input style="z-index: 0" type="text" class="form-control" value="<?= $data_period->travel_allowance ? number_format($data_period->travel_allowance) : '' ?>" readonly>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="30%"><label>Total Allowance</label></td>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-addon">$</div>
                                                <input style="z-index: 0" type="text" class="form-control" id="total-allowance" value="<?= number_format($data_period->settling_allowance + $data_period->technology_allowance + $data_period->travel_allowance) ?>" readonly>
                                            </div>
                                        </td>
                                        <!-- <td>
                                            <div class="input-group">
                                                <div class="input-group-addon">$</div>
                                                <?php 
                                                    $total_actual = $grantee_grant->actual_settling + $grantee_grant->actual_technology; 
                                                ?>
                                                <input style="z-index: 0" type="text" class="form-control" id="actual-total" value="<?= $total_actual != 0 ? number_format($total_actual) : '' ?>" readonly>
                                            </div>
                                        </td> -->
                                    </tr>
                                    <!-- <tr>
                                        <td width="30%"><label>Overpaid</label></td>
                                        <td>
                                            <?php 
                                                $overpaid = $total_actual - ($data_period->settling_allowance + $data_period->technology_allowance); 
                                            ?>
                                            <div class="input-group">
                                                <div class="input-group-addon">$</div>
                                                <input style="z-index: 0" type="text" class="form-control" id="overpaid" value="<?= $overpaid != 0 ? str_replace('-', '', number_format($overpaid)) : '' ?>" readonly>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary" id="btn-allowance">Submit Allowance</button>
                                            <img src="<?php echo base_url() ?>/img/loading.gif" id="load-allowance" style="display:none;">
                                        </td>
                                    </tr> -->
                                </table>
                            </div>
                        </div>
                        <hr>
                        <!-- <div class="row">
                            <div class="col-lg-4">
                                <input type="file" id="input-file" name="invoice_allowance[]" multiple class="form-control">
                                <button class="btn btn-primary mt-2" type="button" id="btn-invoice">Upload Invoice</button>
                                <img src="<?php echo base_url() ?>/img/loading.gif" id="load-upload" style="display:none;">
                            </div>
                        </div> -->
                        <div class="row mt-5">
                            <div class="col-lg-12">
                                <div class="wrap-invoice">
                                    <?php foreach($data_invoice as $key => $d_i) { 
                                            $nameFile = end(explode('/', $d_i->file));
                                            $fileName = end(explode('/', $d_i->file));
                                            if(strlen($fileName) > 15){
                                                $fileName = substr($fileName, 0, 15) . '....';
                                            }
                                    ?>
                                    <div class="col-lg-3 img-col" style="height: 150px;">
                                        <a href="<?= base_url($d_i->file) ?>" class="lightbox"><img height="100" src="<?php echo get_preview($d_i->file); ?>"></a>
                                        <!-- <a href="javascript:;" onclick="del_item(this, 'img-col', <?= $d_i->id ?>)" class="btn btn-danger btn-xs" style="position:absolute; top:25px;">
                                            <i class="fa fa-trash fa-fw text-white"></i>
                                        </a> -->
                                        <a href="<?= base_url($d_i->file) ?>" download title="Click to download" class="btn btn-primary btn-xs" style="position:absolute; top:0; ">
                                            <i class="fa fa-download fa-fw text-white"></i>
                                        </a>
                                        <p class="filename" style="font-size:16px;cursor:pointer;" data-toggle="tooltip" data-placement="left" title="<?= $nameFile ?>"><?= $fileName ?></p>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>