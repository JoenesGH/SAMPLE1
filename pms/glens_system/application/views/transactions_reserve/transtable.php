<?php defined('BASEPATH') OR exit('') ?>

<?= isset($range) && !empty($range) ? $range : ""; ?>
<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Online Customer Reserved</div>
    <?php if($allTransactions): ?>
    <div class="table table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Transaction No</th>
                    <th>Total Items</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Customer</th>
                    <th>Pickup Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($allTransactions as $get): ?>
                <tr>
                    <input type="hidden" value="<?=$get->ref?>" class="curItemId">
                    <th class="<?=$get->status == 'Cancel' ? 'bg-danger' : ''?>"><?= $sn ?>.</th>
                    <td class="<?=$get->status == 'Cancel' ? 'bg-danger' : ''?>"><a class="pointer vtr" title="Click to view receipt"><?= $get->ref ?></a></td>
                    <td class="<?=$get->status == 'Cancel' ? 'bg-danger' : ''?>"><?= $get->quantity ?></td>
                    <td class="<?=$get->status == 'Cancel' ? 'bg-danger' : ''?>">Php <?= number_format($get->totalMoneySpent, 2) ?></td>
                    <td class="<?=$get->status == 'Cancel' ? 'bg-danger' : ''?>"><?=  str_replace("_", " ", $get->status)?></td>
                    <td class="<?=$get->status == 'Cancel' ? 'bg-danger' : ''?>"><?=$get->cust_name?> - <?=$get->cust_phone?> - <?=$get->cust_email?></td>
                    <td class="<?=$get->status == 'Cancel' ? 'bg-danger' : ''?>"><?= date('jS M, Y', strtotime($get->pick_date)) ?></td>
                    
                    <!--For Modal Click Action Button -->
                    <td class="hidden"><span id="mobile-<?=$get->ref?>"><?=$get->cust_phone?></span></td>
                    <td class="hidden"><span id="custName-<?=$get->ref?>"><?=$get->cust_name?></span></td>
                    <td class="hidden"><span id="custName2-<?=$get->ref?>"><?=$get->cust_name?></span></td>
                    <td class="hidden"><span id="Status-<?=$get->ref?>"><?=$get->status?></span></td>
                    <!--For Modal Click Ready Button -->
                    <td class="hidden"><span id="mobile2-<?=$get->ref?>"><?=$get->cust_phone?></span></td>
                    <td class="hidden"><span id="custName2-<?=$get->ref?>"><?=$get->cust_name?></span></td>
                    <td class="hidden"><span id="Status2-<?=$get->ref?>"><?=$get->status?></span></td>


                    <td class="text-center <?=$get->status == 'Cancel' ? 'bg-danger' : ''?>">
                            <?php if($get->status === "Pending"): ?>
                            <span class="editItem" id="edit-<?=$get->ref?>"><i class="fa fa-pencil pointer"></i> </span>
                            <?php else: ?>
                            <?php endif; ?>

                            <?php if($get->status === "Ready"): ?>
                            <span class="editItem2" id="edit-<?=$get->ref?>"><i class="fa fa-pencil pointer"></i> </span>
                            <?php else: ?>
                            <?php endif; ?>

                            <?php if($get->status === "Approved"): ?>
                            <i>Done</i>
                            <?php else: ?>
                            <?php endif; ?>

                            <?php if($get->status === "Cancel"): ?>
                            <i>Cancel</i>
                            <?php else: ?>
                            <?php endif; ?>
                    </td>
                </tr>
                <?php $sn++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<!-- table div end-->
    <?php else: ?>
        <ul><li>No Transactions</li></ul>
    <?php endif; ?>
    
    <!--Pagination div-->
    <div class="col-sm-12 text-center">
        <ul class="pagination">
            <?= isset($links) ? $links : "" ?>
        </ul>
    </div>
</div>
<!-- panel end-->



