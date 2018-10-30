<?php defined('BASEPATH') OR exit('') ?>

<?= isset($range) && !empty($range) ? $range : ""; ?>
<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">REEEEE</div>
    <?php if($allTransactions): ?>
    <div class="table table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Total Items</th>
                    <th>Total Amount</th>
                    <th>Amount Tendered</th>
                    <th>Change Due</th>
                    <th>Mode of Payment</th>
                    <th>Staff</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($allTransactions as $get): ?>
                <tr>
                    <th><?= $sn ?>.</th>
                    <td><?= $get->quantity ?></td>
                    <td>Php <?= number_format($get->totalMoneySpent, 2) ?></td>
                    <td>Php <?= number_format($get->amountTendered, 2) ?></td>
                    <td>Php <?= number_format($get->changeDue, 2) ?></td>
                    <td><?=  str_replace("_", " ", $get->modeOfPayment)?></td>
                    <td><?=$get->staffName?></td>
                    <td><?= date('jS M, Y h:ia', strtotime($get->transDate)) ?></td>
                </tr>
                <?php $sn++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<!-- table div end-->
    <?php else: ?>
        <ul><li>to data</li></ul>
    <?php endif; ?>
    
    <!--Pagination div-->
    <div class="col-sm-12 text-center">
        <ul class="pagination">
            <?= isset($links) ? $links : "" ?>
        </ul>
    </div>
</div>
<!-- panel end-->