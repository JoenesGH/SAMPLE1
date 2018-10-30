<?php
defined('BASEPATH') OR exit('');
?>

<div class="pwell hidden-print">   
    <div class="row">
        <div class="col-sm-12">
            <!-- sort and co row-->
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-2 form-inline form-group-sm">
                        <button class="btn btn-primary btn-sm" id='createItem'><i class="ion-android-add"></i> Add New Item</button>
                    </div>

                    <div class=""> 
                        <button class="btn btn-primary btn-sm" onclick='document.location="<?= site_url('cats') ?>"' ><i class="ion-android-add"></i> Category</button>
                    </div>
                    <br>
                    <div class="col-sm-3 form-inline form-group-sm">
                        <label for="itemsListPerPage">Show</label>
                        <select id="itemsListPerPage" class="form-control">
                            <option value="1">1</option>
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <label>per page</label>
                    </div>

                    <div class="col-sm-4 form-group-sm form-inline">
                        <label for="itemsListSortBy">Sort by</label>
                        <select id="itemsListSortBy" class="form-control">
                            <option value="name-ASC">Item Name (A-Z)</option>
                            <option value="code-ASC">Item Code (Ascending)</option>
                            <option value="unitPrice-DESC">Unit Price (Highest first)</option>
                            <option value="quantity-DESC">Quantity (Highest first)</option>
                            <option value="name-DESC">Item Name (Z-A)</option>
                            <option value="code-DESC">Item Code (Descending)</option>
                            <option value="unitPrice-ASC">Unit Price (lowest first)</option>
                            <option value="quantity-ASC">Quantity (lowest first)</option>
                        </select>                       
                    </div>

                    <div class="col-sm-3 form-inline form-group-sm">
                        <label for='itemSearch'><i class="fa fa-search"></i></label>
                        <input type="search" id="itemSearch" class="form-control" placeholder="Search Items">
                    </div>
                </div>
            </div>
            <!-- end of sort and co div-->
        </div>
    </div>
    
    <hr>
    
    <!-- row of adding new item form and items list table-->
    <div class="row">
        <div class="col-sm-12">
            <!--Form to add/update an item-->
            <div class="col-sm-4 hidden" id='createNewItemDiv'>
                <div class="well">
            <!--     <button class="btn btn-info btn-xs pull-left" id="useBarcodeScanner"><i class="ion-ios-barcode-outline"></i> Use Scanner</button> -->
                    <button class="close cancelAddItem">&times;</button><br>
                    <form name="addNewItemForm" id="addNewItemForm" role="form">
                        <div class="text-center errMsg" id='addCustErrMsg'></div>
                        
                        <br>
                        <div class="row text-center">
                           <img id="item-image" src="" class="mb-3" style="max-width:50%;border-radius:5%;"> 
                        </div>
                        <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="itemCode">Image <small>(max-size: 1024x768)</small></label>
                                <input type="file" id="item-image-file" name="itemImage" class="form-control">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="itemCode">Item Code</label>
                                <input type="text" id="itemCode" name="itemCode" placeholder="Item Code" maxlength="80"
                                    class="form-control" onchange="checkField(this.value, 'itemCodeErr')" autofocus>
                                <!--<span class="help-block"><input type="checkbox" id="gen4me"> auto-generate</span>-->
                                <span class="help-block errMsg" id="itemCodeErr"></span>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="itemName">Item Name</label>
                                <input type="text" id="itemName" name="itemName" placeholder="Item Name" maxlength="80"
                                    class="form-control" onchange="checkField(this.value, 'itemNameErr')">
                                <span class="help-block errMsg" id="itemNameErr"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="itemBatch">Batch #</label>
                                <input type="text" id="itemBatch" name="itemBatch" placeholder="Batch #" maxlength="80"
                                    class="form-control" onchange="checkField(this.value, 'itemBatchErr')">
                                <span class="help-block errMsg" id="itemBatchErr"></span>
                            </div>
                        </div>
                        
                        <div class="row">
                        <div class="col-sm-6 form-group-sm">
                            <label for="prescription">Types of drugs</label>
                            <div class="input-group">
                              <div class="input-group-addon">
                                <span><i class="ion-ios-medkit-outline"></i></span>
                              </div>
                            <select id="prescription" name="prescription" class="form-control checkField"  onchange="checkField(this.value, 'prescriptionErr')">
                                <option value="">---</option>
                                <option value="otc">Over the counter</option>
                                <option value="prescription">Prescription</option>
                            </select>
                            </div>
                            <span class="help-block errMsg" id="prescriptionErr"></span>
                        </div>

                        <div class="col-sm-6 form-group-sm">
                            <label for="category">Category</label>                         
                            <div class="input-group">
                               <div class="input-group-addon">
                                <span><i class="ion-android-menu"></i></span>
                               </div>
                            <select id="category" name="category" class="form-control checkField"  onchange="checkField(this.value, 'categoryErr')">
                                <option value="">---</option>
                                <?php if($Category): ?>
                                <?php foreach($Category as $get): ?>
                                <option value="<?=$get->id?>"><?=$get->name?></option>
                                <?php ?>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <option value=""> No Category </option>
                                <?php endif; ?>
                            </select>
                            </div>
                            <span class="help-block errMsg" id="categoryErr"></span>
                        </div>       
                       </div> 
                                              
                         <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="itemDex">Date Expire</label>
                             <div class="input-group">
                               <div class="input-group-addon">
                                <span><i class="ion-android-calendar"></i></span>
                                </div>
                               <input type="date" id="itemDex" name="itemDex" class="form-control" >
              <!--             <input type="text" id="itemDex" name="itemDex" class="form-control" data-field="date" readonly>  -->
                               </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-8 form-group-sm">
                                <label for="itemQuantity">Quantity</label>
                                <input type="number" id="itemQuantity" name="itemQuantity" placeholder="Available Quantity"
                                    class="form-control" min="0" onchange="checkField(this.value, 'itemQuantityErr')">
                                <span class="help-block errMsg" id="itemQuantityErr"></span>
                            </div>
                       

                         <div class="col-sm-4 form-group-sm">
                            <label for="unit">M-Unit</label>                         
                            <select id="unit" name="unit" class="form-control checkField">
                                <option value="">---</option>
                                <option value="Pc">Pc</option>
                                <option value="Box">Box</option>
                                <option value="Battle">Battle</option>
                            </select>
                            <span class="help-block errMsg" id="unitErr"></span>
                        </div> 
                        </div>      

                        <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="unitPrice">(₱)Sell Price</label>
                                <input type="number" id="itemPrice" name="itemPrice" placeholder="(₱)Sell Price" class="form-control"
                                    onchange="checkField(this.value, 'itemPriceErr')">
                                <span class="help-block errMsg" id="itemPriceErr"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="unitUnit">(₱)Unit Price</label>
                                <input type="number" id="itemUnit" name="itemUnit" placeholder="(₱)Unit Price" class="form-control"
                                    onchange="checkField(this.value, 'itemUnitErr')">
                                <span class="help-block errMsg" id="itemUnitErr"></span>
                            </div>
                        </div>

                       <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="itemDescription" class="">Item Description (Optional)</label>
                                <textarea class="form-control" id="itemDescription" name="itemDescription" rows='4'
                                    placeholder="Optional Item Description"></textarea>
                            </div>
                        </div>
                        <br>
                       
                        <br>
                        <div class="row text-center">
                            <div class="col-sm-6 form-group-sm">
                                <button class="btn btn-primary btn-sm" id="addNewItem">Add Item</button>
                            </div>

                            <div class="col-sm-6 form-group-sm">
                                <button type="reset" id="cancelAddItem" class="btn btn-danger btn-sm cancelAddItem" form='addNewItemForm'>Cancel</button>
                            </div>
                        </div>
                    </form><!-- end of form-->
                </div>
            </div>
            
            <!--- Item list div-->
            <div class="col-sm-12" id="itemsListDiv">
                <!-- Item list Table-->
                <div class="row">
                    <div class="col-sm-12" id="itemsListTable"></div>
                </div>
                <!--end of table-->
            </div>
            <!--- End of item list div-->

        </div>
    </div>
    <!-- End of row of adding new item form and items list table-->
</div>

<!--modal to update stock-->
<div id="updateStockModal" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 class="text-center">Update Stock</h4>
                <div id="stockUpdateFMsg" class="text-center"></div>
            </div>
            <div class="modal-body">
                <form name="updateStockForm" id="updateStockForm" role="form">
                    <div class="row">
                        
                        
                        <div class="col-sm-4 form-group-sm">
                            <label>Item Code</label>
                            <input type="text" readonly id="stockUpdateItemCode" class="form-control">
                        </div>

                        <div class="col-sm-4 form-group-sm">
                            <label>Item Name</label>
                            <input type="text" readonly id="stockUpdateItemName" class="form-control">
                        </div>
                        
                        <div class="col-sm-4 form-group-sm">
                            <label>Quantity in Stock</label>
                            <input type="text" readonly id="stockUpdateItemQInStock" class="form-control">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-6 form-group-sm">
                            <label for="stockUpdateType">Update Type</label>
                            <select id="stockUpdateType" class="form-control checkField">
                                <option value="">---</option>
                                <option value="newStock">New Stock</option>
                                <option value="deficit">Deficit</option>
                            </select>
                            <span class="help-block errMsg" id="stockUpdateTypeErr"></span>
                        </div>
                        
                        <div class="col-sm-6 form-group-sm">
                            <label for="stockUpdateQuantity">Quantity</label>
                            <input type="number" id="stockUpdateQuantity" placeholder="Update Quantity"
                                class="form-control checkField" min="0">
                            <span class="help-block errMsg" id="stockUpdateQuantityErr"></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12 form-group-sm">
                            <label for="stockUpdateDescription" class="">Description</label>
                            <textarea class="form-control checkField" id="stockUpdateDescription" placeholder="Update Description"></textarea>
                            <span class="help-block errMsg" id="stockUpdateDescriptionErr"></span>
                        </div>
                    </div>
                    
                    <input type="hidden" id="stockUpdateItemId">
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="stockUpdateSubmit">Update</button>
                <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!--end of modal-->

<!--modal to edit item-->
<div id="editItemModal" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 class="text-center">Edit Item</h4>
                <div id="editItemFMsg" class="text-center"></div>
            </div>
            <div class="modal-body">
                <form role="form">
                    <div class="row">

                        <div class="col-sm-4 form-group-sm">
                            <label for="itemCode">Item Code</label>
                            <input type="text" id="itemCodeEdit" class="form-control">
                            <span class="help-block errMsg" id="itemCodeEditErr"></span>
                        </div>

                        <div class="col-sm-4 form-group-sm">
                            <label for="itemNameEdit">Item Name</label>
                            <input type="text" id="itemNameEdit" placeholder="Item Name" autofocus class="form-control checkField">
                            <span class="help-block errMsg" id="itemNameEditErr"></span>
                        </div>

                        <div class="col-sm-4 form-group-sm">
                            <label for="unitPrice">Sell Price</label>
                            <input type="text" id="itemPriceEdit" name="itemPrice" placeholder="Sell Price" class="form-control checkField">
                            <span class="help-block errMsg" id="itemPriceEditErr"></span>
                        </div>

                        <div class="col-sm-4 form-group-sm">
                            <label for="unitUnit">Unit Price</label>
                            <input type="text" id="itemUnitEdit" name="itemUnit" placeholder="Unit Price" class="form-control checkField">
                            <span class="help-block errMsg" id="itemUnitEditErr"></span>
                        </div>

                        <div class="col-sm-4 form-group-sm">
                            <label for="itemBatch">Batch #</label>
                            <input type="text" id="itemBatchEdit" name="itemBatch" placeholder="Batch #" class="form-control checkField">
                            <span class="help-block errMsg" id="itemBatchEditErr"></span>
                        </div> 

                        <div class="col-sm-4 form-group-sm">
                            <label for="itemPrescription">Types of drugs</label>
                            <div class="input-group">
                              <div class="input-group-addon">
                                <span><i class="ion-ios-medkit-outline"></i></span>
                              </div>
                            <select id="itemPrescriptionEdit" name="itemPrescription" class="form-control checkField">
                                <option value="otc">Over the counter</option>
                                <option value="prescription">Prescription</option>
                            </select>
                        </div>
                            <span class="help-block errMsg" id="prescriptionEditErr"></span>
                        </div>

                        <div class="col-sm-4 form-group-sm">
                            <label for="itemCategory">Category</label>
                            <div class="input-group">
                              <div class="input-group-addon">
                                <span><i class="ion-android-menu"></i></span>
                              </div>
                               <select id="itemCategoryEdit" name="itemCategory" class="form-control checkField">
                                <?php if($Category): ?>
                                <?php foreach($Category as $get): ?>
                                <option value="<?=$get->id?>"><?=$get->name?></option>
                                <?php ?>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <option value=""> No Category </option>
                                <?php endif; ?>
                               </select>
                            </div>
                            <span class="help-block errMsg" id="itemCategoryEditErr"></span>
                        </div>

                         <div class="col-sm-4 form-group-sm">
                            <label for="itemDex">Date Expire (YY-MM-DD) </label>
                            <div class="input-group">
                            <div class="input-group-addon">
                                <span><i class="ion-android-calendar"></i></span>
                            </div>
                            <input type="date" id="itemDexEdit" autofocus class="form-control checkField">
         <!--              <input type="text" id="itemDexEdit" autofocus class="form-control checkField" data-field="date">  -->
                        </div>
                        </div>
                        
                    </div>
                    
                   
                    <input type="hidden" id="itemIdEdit">
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="editItemSubmit">Save</button>
                <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!--end of modal-->

<!--modal view dialog-->  
<div id="viewStockModal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="height:auto">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Product Details</h4>
              </div>
              <div class="modal-body">
                     <p align="center"><img class="profile_pic"></p>
                     <h4><b>Item Code </b>: <input readonly id="stockViewItemCode"></h4>
                     <h4><b>Item Name </b>: <input readonly id="stockViewItemName"></h4>
                     <h4><b>Item Batch</b>: <input readonly id="stockViewItemBatch"></h4>
                     <h4><b>Item Category</b>: <input readonly id="stockViewCategory"></h4>
                     <h4><b>Date Expire</b>: <input readonly id="stockViewItemDex"></h4>
                     <h4><b>Item Quantity</b>: <input readonly id="stockViewItemQInStock"></h4>
                     <h4><b>Per</b>: <input readonly id="stockViewItemUnit"></h4>
                     <h4><b>Item Sell Price</b>: <input readonly id="stockViewItemPrice"></h4>
                     <h4><b>Item Unit Price</b>: <input readonly id="stockViewItemSUnit"></h4>
                     <h4><b>Types of drugs</b>: <input readonly id="stockViewPrescription"></h4>
                     <h4><b>Item Total Sold</b>: <input readonly id="stockViewItemSold"></h4>
                     <h4><b>Item Item Decription</b>: <input readonly id="stockViewItemDesc"></h4>
                     <hr>
                     <h4><b>Item Date Add</b>: <input readonly id="stockViewItemDateadd"></h4>
                     <h4><b>Item Last Update</b>: <input readonly id="stockViewItemDateupdate"></h4>
                    </div><br>
             <div class="modal-footer"> 
    </div>  
  </div>
</div>
<!--end of modal-dialog-->
<script src="<?=base_url()?>public/js/items.js"></script>  