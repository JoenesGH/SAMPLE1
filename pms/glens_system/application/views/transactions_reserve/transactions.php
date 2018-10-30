<?php
defined('BASEPATH') OR exit('');

$current_items = [];

if(isset($items) && !empty($items)){    
    foreach($items as $get){
        $current_items[$get->code] = $get->name;
    }
}
?>

<style href="<?=base_url('public/ext/datetimepicker/bootstrap-datepicker.min.css')?>" rel="stylesheet"></style>

<script>
    var currentItems = <?=json_encode($current_items)?>;
</script>

<div class="pwell hidden-print">   
    <div class="row">
        <div class="col-sm-12">
            <!--- Row to create new transaction-->
            <div class="row">

            </div>
            <br>
            <!--- End of row to create new transaction-->
            <!---form to create new transactions--->
            <div class="row collapse" id="newTransDiv">
                <!---div to display transaction form--->
                <div class="col-sm-12" id="salesTransFormDiv">
                    <div class="well">
                        <form name="salesTransForm" id="salesTransForm" role="form">
                            <div class="text-center errMsg" id='newTransErrMsg'></div>
                            <br>

                            <div class="row">
                                <div class="col-sm-12">
                                    <!--Cloned div comes here--->
                                    <div id="appendClonedDivHere"></div>
                                    <!--End of cloned div here--->
                                    
                                    <!--- Text to click to add another item to transaction-->
                                    <div class="row">
                                        <div class="col-sm-2 text-primary pointer">
                                            <button class="btn btn-primary btn-sm" id="clickToClone"><i class="fa fa-plus"></i> Add item</button>
                                        </div>
                                        
                                        <br class="visible-xs">
                                        
                                        <div class="col-sm-2 form-group-sm">
                                            <input type="text" id="barcodeText" class="form-control" placeholder="item code" autofocus>
                                            <span class="help-block errMsg" id="itemCodeNotFoundMsg"></span>
                                        </div>
                                    </div>
                                    <!-- End of text to click to add another item to transaction-->
                                    <br>
                                    
                                    <div class="row">
                                        <div class="col-sm-3 form-group-sm">
                                            <label for="vat">VAT(%)</label>
                                            <input type="number" min="0" id="vat" class="form-control" value="12">
                                        </div>
                                        
                                        <div class="col-sm-3 form-group-sm">
                                            <label for="discount">Discount(%)</label>
                                            <input type="number" min="0" id="discount" class="form-control" value="0">
                                        </div>
                                        
                                        <div class="col-sm-3 form-group-sm">
                                            <label for="discount">Discount(value)</label>
                                            <input type="number" min="0" id="discountValue" class="form-control" value="0">
                                        </div>
                                        
                                        <div class="col-sm-3 form-group-sm">
                                            <label for="modeOfPayment">Mode of Payment</label>
                                            <select class="form-control checkField" id="modeOfPayment">
                                                <option value="Cash">Cash</option>
                                            <!--    <option value="POS">POS</option>  -->
                                            <!--    <option value="Cash and POS">Cash and POS</option> -->
                                            </select>
                                            <span class="help-block errMsg" id="modeOfPaymentErr"></span>
                                        </div>
                                    </div>
                                        
                                    <div class="row">
                                        <div class="col-sm-4 form-group-sm">
                                            <label for="cumAmount">Cumulative Amount</label>
                                            <span id="cumAmount" class="form-control">0.00</span>
                                        </div>
                                        
                                        <div class="col-sm-4 form-group-sm">
                                            <div class="cashAndPos hidden">
                                                <label for="cashAmount">Cash</label>
                                                <input type="text" class="form-control" id="cashAmount">
                                                <span class="help-block errMsg"></span>
                                            </div>

                                            <div class="cashAndPos hidden">
                                                <label for="posAmount">POS</label>
                                                <input type="text" class="form-control" id="posAmount">
                                                <span class="help-block errMsg"></span>
                                            </div>

                                            <div id="amountTenderedDiv">
                                                <label for="amountTendered" id="amountTenderedLabel">Amount Tendered</label>
                                                <input type="text" class="form-control" id="amountTendered">
                                                <span class="help-block errMsg" id="amountTenderedErr"></span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-4 form-group-sm">
                                            <label for="changeDue">Change Due</label>
                                            <span class="form-control" id="changeDue"></span>
                                        </div>
                                    </div>
                                        
                                    <div class="row">
                                        <div class="col-sm-4 form-group-sm">
                                            <label for="custName">Customer Name</label>
                                            <input type="text" id="custName" class="form-control" placeholder="Name (Optional)">
                                        </div>
                                        
                                        <div class="col-sm-4 form-group-sm">
                                            <label for="custPhone">Customer Phone</label>
                                            <input type="number" id="custPhone" class="form-control" placeholder="Phone Number (Optional)">
                                        </div>
                                        
                                        <div class="col-sm-4 form-group-sm">
                                            <label for="custEmail">Customer Email</label>
                                            <input type="email" id="custEmail" class="form-control" placeholder="E-mail Address (Optional)">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div class="row">
                                <div class="col-sm-2 form-group-sm">
                               <!--   <button class="btn btn-primary btn-sm" id='useScanner'>Use Barcode Scanner</button>  -->
                                 </div>
                                <br class="visible-xs">
                                <div class="col-sm-6"></div>
                                <br class="visible-xs">
                                <div class="col-sm-4 form-group-sm">
                                    <button type="button" class="btn btn-primary btn-sm" id="confirmSaleOrder">Confirm Order</button>
                                    <button type="button" class="btn btn-warning btn-sm" id="cancelSaleOrder">Clear Order</button>
                                    <button type="button" class="btn btn-danger btn-sm" id="hideTransForm">Close</button>
                                </div>
                            </div>
                        </form><!-- end of form-->
                    </div>
                </div>
                <!-- end of div to display transaction form-->
            </div>
            <!--end of form-->
    
            <br><br>
            <!-- sort and co row-->
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-3 form-inline form-group-sm">
                        <label for="transListPerPage">Per Page</label>
                        <select id="transListPerPage" class="form-control">
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
                    </div>

                    <div class="col-sm-5 form-group-sm form-inline">
                        <label for="transListSortBy">Sort by</label>
                        <select id="transListSortBy" class="form-control">
                            <option value="transId-DESC">date(Latest First)</option>
                            <option value="transId-ASC">date(Oldest First)</option>
                            <option value="quantity-DESC">Quantity (Highest first)</option>
                            <option value="quantity-ASC">Quantity (Lowest first)</option>
                            <option value="totalPrice-DESC">Total Price (Highest first)</option>
                            <option value="totalPrice-ASC">Total Price (Lowest first)</option>
                            <option value="totalMoneySpent-DESC">Total Amount Spent (Highest first)</option>
                            <option value="totalMoneySpent-ASC">Total Amount Spent (Lowest first)</option>
                        </select>
                    </div>

                    <div class="col-sm-4 form-inline form-group-sm">
                        <label for='transSearch'><i class="fa fa-search"></i></label>
                        <input type="search" id="transSearch" class="form-control" placeholder="Search Transactions">
                    </div>
                </div>
            </div>
            <!-- end of sort and co div-->
        </div>
    </div>
    
    <hr>
    
    <!-- transaction list table-->
    <div class="row">
        <!-- Transaction list div-->
        <div class="col-sm-12" id="transListTable"></div>
        <!-- End of transactions div-->
    </div>
    <!-- End of transactions list table-->
</div>


<div class="row hidden" id="divToClone">
    <div class="col-sm-4 form-group-sm">
        <label>Item</label>
        <select class="form-control selectedItemDefault" onchange="selectedItem(this)"></select>
    </div>

    <div class="col-sm-2 form-group-sm itemAvailQtyDiv">
        <label>Available Quantity</label>
        <span class="form-control itemAvailQty">0</span>
    </div>

    <div class="col-sm-2 form-group-sm">
        <label>Unit Price</label>
        <span class="form-control itemUnitPrice">0.00</span>
    </div>

    <div class="col-sm-1 form-group-sm itemTransQtyDiv">
        <label>Quantity</label>
        <input type="number" min="0" class="form-control itemTransQty" value="0">
        <span class="help-block itemTransQtyErr errMsg"></span>
    </div>

    <div class="col-sm-2 form-group-sm">
        <label>Total Price</label>
        <span class="form-control itemTotalPrice">0.00</span>
    </div>
    
    <br class="visible-xs">
    
    <div class="col-sm-1">
        <button class="close retrit">&times;</button>
    </div>
    
    <br class="visible-xs">
</div>

<!--modal to edit item-->
<div id="edittransModal" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 class="text-center">Action</h4>
                <div id="editItemFMsg" class="text-center"></div>
            </div>
            <div class="modal-body">
                <form role="form">

                     <div class="row">
                        <div class="col-sm-6 form-group-sm">
                                <label for="custNameEdit">Customer Name</label>
                                <input type="text" id="custNameEdit" name="custNameEdit" class="form-control" readonly>
                                <span class="help-block errMsg" id="custNameEditErr"></span>
                        </div>
                        <div class="col-sm-6 form-group-sm">
                                <label for="mobileEdit">Mobile</label>
                                <input type="text" id="mobileEdit" name="mobileEdit" class="form-control">
                                <span class="help-block errMsg" id="mobileEditErr"></span>
                        </div>
                     </div>
                     <hr>
                     <div class="row">
                         <div class="col-sm-12 form-group-sm">
                            <label for="StatusEdit">Select Action To Proceed</label>
                            <select id="StatusEdit" name="StatusEdit" class="form-control checkField">
                                <option value="Ready" selected>Ready</option>
                            </select>
                            <span class="help-block errMsg" id="StatusEditErr"></span>
                        </div>
                    </div>
                               
                    <input type="hidden" id="itemIdEdit">
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="editItemSubmit">Proceed</button>
                <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!---End of copy of div to clone when adding more items to sales transaction---->


<!--modal to edit ready item-->
<div id="edittransModal2" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 class="text-center">Action</h4>
                <div id="editItemFMsg2" class="text-center"></div>
            </div>
            <div class="modal-body">
                <form role="form">

                     <div class="row">
                        <div class="col-sm-6 form-group-sm">
                                <label for="custNameEdit">Customer Name</label>
                                <input type="text" id="custNameEdit2" name="custNameEdit2" class="form-control" readonly>
                                <span class="help-block errMsg" id="custNameEditErr2"></span>
                        </div>
                        <div class="col-sm-6 form-group-sm">
                                <label for="mobileEdit2">Mobile</label>
                                <input type="text" id="mobileEdit2" name="mobileEdit2" class="form-control">
                                <span class="help-block errMsg" id="mobileEditErr2"></span>
                        </div>
                     </div>
                     <hr>
                     <div class="row">
                         <div class="col-sm-12 form-group-sm">
                            <label for="StatusEdit2">Select Action To Proceed</label>
                            <select id="StatusEdit2" name="StatusEdit2" class="form-control checkField">
                                <option value="Approved">Approved</option>
                                <option value="Cancel">Cancel</option>
                            </select>
                            <span class="help-block errMsg" id="StatusEditErr2"></span>
                        </div>
                    </div>
                               
                    <input type="hidden" id="itemIdEdit2">
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="editItemSubmit2">Proceed</button>
                <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!---End of copy of div to clone when adding more items to sales ready---->

<script src="<?=base_url()?>public/js/transactions_reserve.js"></script>
