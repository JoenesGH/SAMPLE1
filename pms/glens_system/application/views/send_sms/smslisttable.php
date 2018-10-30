<?php defined('BASEPATH') OR exit('') ?>

<div class='col-sm-6'>
    <?= isset($range) && !empty($range) ? $range : ""; ?>
</div>

<div class='col-xs-12'>
    <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading">Customer</div>
        <?php if($topCustomer): ?>
        <div class="table table-responsive">
            <table class="table table-bordered table-striped" style="background-color: #f5f5f5">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>FULL NAME</th>
                        <th>MOBILE</th>
                        <th class="text-center">SENS SMS NOTIFICATION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($topCustomer as $get): ?>
                    <tr>
                        
                        <th class="itemSN"><?=$sn?>.</th>
                        <td><span id="itemName-<?=$get->transId?>"><?=$get->cust_name?></span></td>
                        <td><span id="itemMobile-<?=$get->transId?>"><?=$get->cust_phone?></span></td>
                
                        <td class="text-center text-primary">
                            <span class="editItem" id="edit-<?=$get->transId?>"><i class="ion-android-mail"></i> </span>
                        </td>
                    </tr>
                    <?php $sn++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- table div end-->
        <?php else: ?>
        <ul><li>No Result</li></ul>
        <?php endif; ?>
    </div>
    <!--- panel end-->
</div>

<!---Pagination div-->
<div class="col-sm-12 text-center">
    <ul class="pagination">
        <?= isset($links) ? $links : "" ?>
    </ul>
</div>
