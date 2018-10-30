<?php defined('BASEPATH') OR exit('') ?>

<div class='col-sm-6'>
    <?= isset($range) && !empty($range) ? $range : ""; ?>
</div>

<div class='col-sm-6 text-right'><b>| Items Total Price:</b> Php <?=$cum_total ? number_format($cum_total, 2) : '0.00'?> |</div>

<div class='col-xs-12'>
    <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading">Items</div>
        <?php if($allItems): ?>
        <div class="table table-responsive">
            <table class="table table-bordered table-striped" style="background-color: #f5f5f5">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">ITEM<br>CODE</th>
                        <th class="text-center">ITEM<br>NAME</th>
                        <th class="text-center">BATCH<br>NUMBER</th>
                        <th class="text-center">DATE<br>EXPIRE</th>  
                        <th class="text-center"></th>                         
                        <th class="text-center">QUANTITY<br>IN STOCK</th>
                        <th class="text-center">UNIT<br>PRICE</th>
                        <th class="text-center">Sell<br>PRICE</th>
                        <th class="text-center">ACTIVE<br>POPUP</th>
                        <th class="text-center">UPDATE<br>QUANTITY</th>
                        <th class="text-center">PREVIEW</th>
                        <th class="text-center">EDIT</th>
                 <!--   <th class="text-center">DELETE</th>  -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($allItems as $get): ?>
                    <tr>
<!-- id -->             <input type="hidden" value="<?=$get->id?>" class="curItemId">                        
<!-- # -->              <th class="itemSN"><?=$sn?>.</th>                      
<!-- code -->           <td><span id="itemCode-<?=$get->id?>"><?=$get->code?></span></td>                       
<!-- name -->           <td><p align="center"><span id="itemName-<?=$get->id?>"><?=$get->name?></span></p> 
<!-- new -->            <span><?=$get->dateAdded == date('Y-m-d') ? '<p align="center"><span class="label 
                        bg-primary">New</span></p>' : ($get->dateAdded  ? '' : '')?></span>
                        </td>
<!-- batch # -->        <td><span id="itemBatch-<?=$get->id?>"><?=$get->batch_number?></span></td>
<!-- date expire -->    <td>                      
                        <span class="hidden" id="itemDex-<?=$get->id?>"><?=$get->date_expire?></span>
                        <p class="<?=$get->date_expire <= 0000-00-00 ? 'hidden' : ($get->date_expire  ? '' : '')?>" align="center"><span ><?= date('jS M, Y', strtotime($get->date_expire))?></span></p> 
                         <span class="<?=$get->date_expire <= 0000-00-00 ? 'hidden' : ($get->date_expire  ? '' : '')?>" id="itemDex-<?=$get->id?>"><?=$get->date_expire <= date('Y-m-d') ? '<p align="center"><span class="label label-danger">Expired</span></p>' : ($get->date_expire  ? '' : '')?></span>
                        <br>
                        </td>
                        <!--  <td>
                            <span id="itemDesc-<?=$get->id?>" data-toggle="tooltip" title="<?=$get->description?>" data-placement="auto">
                                <?=word_limiter($get->description, 15)?>
                            </span>
                        </td> -->
                        <td class="text-center"></td>
<!-- quantity -->       <td class="<?=$get->quantity == 0 ? 'bg-danger' : ($get->quantity <= 50 ? 'bg-warning' : '')?>">
                        <p align="center"><span><?=$get->quantity?></span>/<span><?=$get->unit?></span></p>           
                        <?=$get->quantity == 0 ? '<p align="center"><span class="label label-danger">Out Of Stock</span></p>' :  
                        ($get->quantity <= 50 ? '<p align="center"><span class="label label-warning">Warning</span></p>' : '<p align="center"><span class="label label-info">Load</span></p>')?>
<!-- sell price -->     <td>Php <span id="itemUnit-<?=$get->id?>"><?=number_format($get->sellPrice, 2)?>
                        </span></td>                       
<!-- price -->          <td>Php <span id="itemPrice-<?=$get->id?>"><?=number_format($get->unitPrice, 2)?>
                        </span></td>
<!-- Popup Button -->   <td class="text-center suspendAdmin text-success" id="sus-<?=$get->id?>">
                            <?php if($get->notif === "1"): ?>
                            <i class="fa fa-toggle-on pointer"></i>
                            <?php else: ?>
                            <i class="fa fa-toggle-off pointer"></i>
                            <?php endif; ?>
                        </td>

<!-- Manage QTY -->    <td class="text-center"><a class="pointer updateStock" id="stock-<?=$get->id?>">Manage<br>Quantity</a></td>
                        <td><a class="pointer viewStock" id="stock-<?=$get->id?>"><p align="center"><i class="glyphicon glyphicon-eye-open"></i></p></a></td>
                        <td class="text-center text-primary">
                            <span class="editItem" id="edit-<?=$get->id?>"><i class="fa fa-pencil pointer"></i> </span>
                        </td>
<!--<td class="text-center"><i class="fa fa-trash text-danger delItem pointer"></i></td>-->
<!---------------------------------------------------------------------------------------------------->
<!-- to get info edit stock -->
<!-- category -->
<span class="hidden" id="itemECategory-<?=$get->id?>"><?=$get->category?></span>
<!-- Sell price -->
<span class="hidden" id="itemSUnit-<?=$get->id?>"><?=number_format($get->sellPrice, 2)?></span>
<!-- end to get info edit stock -->
<!---------------------------------------------------------------------------------------------------->
<!-- to get info view stock -->
<!-- qty -->
<span class="hidden" id="itemQuantity-<?=$get->id?>"><?=$get->quantity?></span>
<!-- munit -->
<span class="hidden" id="itemUnit-<?=$get->id?>"><?=$get->unit?></span>
<!-- category -->
<span class="hidden" id="itemCategory-<?=$get->id?>"><?=$get->cats?></span>
<!-- total sold -->
<span class="hidden" id="itemSold-<?=$get->id?>"><?=number_format($this->genmod->gettablecol('transactions', 'SUM(totalPrice)', 'itemCode', $get->code), 2)?></span>
<!-- date add -->
<span class="hidden" id="itemDateAdded-<?=$get->id?>"><?=$get->dateAdded?></span>
<!-- date update -->
<span class="hidden" id="itemLastUpdate-<?=$get->id?>"><?=$get->lastUpdated?></span>
<!-- description -->
<span class="hidden" id="itemDesc-<?=$get->id?>"><?=$get->description?></span>
<!-- prescription -->
<span class="hidden" id="itemPrescription-<?=$get->id?>"><?=$get->prescription?></span>
<!-- end to get info view stock -->
                    </tr>
                    <?php $sn++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- table div end-->
        <?php else: ?>
        <ul><li>No items</li></ul>
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



<!--- POPUP WARNING --->
<div class='modal fade' id='no_stock' role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class='modal-header'>
                <button class="close" data-dismiss='modal'>&times;</button>
                  <h4 class="text-center"><i class="ion-android-warning text-danger"></i></h4>
                <h4 class="text-center text-danger">Warning</h4>
           
   <div class='col-xs-12'>
    <div class="panel panel-danger">
        <!-- Default panel contents -->
        <div class="panel-heading bg-danger text-center" >Items List</div>
        <?php if($PWarning): ?>
        <div class="table table-responsive">
            <table class="table table-bordered table-striped" style="background-color: #f5f5f5">
                <thead>
                    <tr>
                       <th>#</th>
                        <th>ITEM CODE</th>
                        <th>ITEM NAME</th>
                        <th>Batch #</th>                         
                        <th>QTY IN STOCK</th>
                        <th>UNIT PRICE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($PWarning as $get): ?>
                    <tr>
                        <input type="hidden" value="<?=$get->id?>" class="curItemId">
                        <th class="itemSN"><?=$sn2?>.</th>
                        <td><span id="itemCode-<?=$get->id?>"><?=$get->code?></td>

                        <td><p align="center"><span id="itemName-<?=$get->id?>"><?=$get->name?> </span> </p> 
                        <span><?=$get->dateAdded == date('Y-m-d') ? '<p align="center"><span class="label bg-primary">New</span></p>' : ($get->dateAdded  ? '' : '')?></span>
                        </td>
                        
                        <td><span id="itemBatch-<?=$get->id?>"><?=$get->batch_number?></span></td>
                        <a class="hidden"><span id="itemDesc-<?=$get->id?>"><?=$get->description?></span></a>
<!-- quantity -->       <td class=" <?=$get->quantity == 0 ? 'bg-danger' : ($get->quantity <= 50 ? 'bg-warning' : '')?>">
                        <p align="center"> <span id="itemQuantity-<?=$get->id?>"><?=$get->quantity?></span> </p>           
                        <?=$get->quantity == 0 ? '<p align="center"><span class="label label-danger">Out Of Stock</span></p>' :  
                        ($get->quantity <= 50 ? '<p align="center"><span class="label label-warning">Warning</span></p>' : '<p align="center"><span class="label label-info">Load</span></p>')?>

<a class="hidden"><span><?=$get->quantity <= 50, $get->notif == 1 ? '<script>$("#no_stock").modal("show");</script> ' : ($get->quantity << 1 ? '' : '')?></span></a>

                       
                        <td>Php <span id="itemPrice-<?=$get->id?>"><?=number_format($get->unitPrice, 2)?></span></td>
                       
                    </tr>
                    <?php $sn2++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- table div end-->
        <?php else: ?>
        <ul><li>No items</li></ul>
        <?php endif; ?>
    </div>
    <!--- panel end-->
      
    </div>
    <!--- panel end-->
</div>
        </div>
    </div>
</div>
<!--- end of POPUP WARNING --->


