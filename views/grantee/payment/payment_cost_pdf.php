<table class="table table-bordered" width="100%" style="background-color: #fff;margin-top:-20px;">
    <?php
        if ($grantee_payment) {
            foreach ($grantee_payment as $i => $row) { ?>
            
                    <tr>
                        <?php 
                            $total = [];
                            foreach ($row['items'] as $key => $item) { 
                            array_push($total, $item['nominal']);
                            }
                        ?>
                        <?php 
                            $prefix = 'th';
                            if(($i+1) == 1){
                                $prefix = 'st';
                            }else if(($i+1) == 2){
                                $prefix = 'nd';
                            }else if(($i+1) == 3){
                                $prefix = 'rd';
                            }
                        ?>
                        <!-- <th style="background-color:#ebebeb"><?= $row['method']; ?> Method</th> -->
                        <th style="background-color:#ebebeb"><?= $row['payment_name'] ?></th>
                        <th class="text-right" style="background-color:#ebebeb"><b><?= format_money(array_sum($total), 'USD') ?></b></th>
                    </tr>
                    <tr>
                        <!-- <td width="15%"></td> -->
                        <td width="60%" colspan=2><?= date('d-M-Y', strtotime($row['from_date'])) ?> - <?= date('d-M-Y', strtotime($row['to_date'])) ?></td>
                    </tr>
                    <?php if($row['payment_status'] == 1 && !empty($row['toberelease_date'])) { ?>
                    <tr>
                        <!-- <td></td> -->
                        <td colspan=2>
                            To be released : <?= date('d-M-Y', strtotime($row['toberelease_date'])); ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="2">
                            Note : <?php echo $row['release_note']; ?>
                        </td>
                    </tr>
                    <?php if($row['items']) { ?>
                        <?php foreach ($row['items'] as $key => $item) { ?>
                            <tr>
                                <!-- <td></td> -->
                                <td><?= $item['payment_item'] ?></td>
                                <td class="text-right"><?= format_money($item['nominal'], 'USD') ?></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
    <?php } } ?>
</table>