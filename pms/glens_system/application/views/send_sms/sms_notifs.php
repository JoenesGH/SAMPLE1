<?php
defined('BASEPATH') OR exit('');
?>

<div class="pwell hidden-print">   
    <div class="row">
        <div class="col-sm-12">
            <!-- sort and co row-->
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-2 form-inline hidden form-group-sm">
                        <button class="btn btn-primary btn-sm" id='createItem'>Send Custom SMS</button>
                    </div>

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
                            <option value="totalPrice-DESC">Top Customer</option>
                            <option value="cust_name-ASC">Customer Name (A-Z)</option>        
                            <option value="cust_name-DESC">Customer Name (Z-A)</option>                         
                        </select>
                    </div>

                    <div class="col-sm-3 form-inline form-group-sm">
                        <label for='itemSearch'><i class="fa fa-search"></i></label>
                        <input type="search" id="itemSearch" class="form-control" placeholder="Search Customer">
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
                   
                    <button class="close cancelAddItem">&times;</button><br>
                    <form name="addNewItemForm" id="addNewItemForm" role="form">
                        <div class="text-center errMsg" id='addCustErrMsg'></div>
                        
                        <br>
                        
                
                        <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="itemName">MESSAGE</label>
                                <input type="text" id="itemName" name="itemName" placeholder="" maxlength="80"
                                    class="form-control" onchange="checkField(this.value, 'itemNameErr')">
                                <span class="help-block errMsg" id="itemNameErr"></span>
                            </div>
                        </div>

                       
                        <br>
                        <div class="row text-center">
                            <div class="col-sm-6 form-group-sm">
                                <button class="btn btn-primary btn-sm" id="addNewItem">Send</button>
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

<!--modal to edit item-->
<div id="editItemModal" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 class="text-center">Send SMS Notification</h4>
                <div id="editItemFMsg" class="text-center"></div>
            </div>
            <div class="modal-body">
                <form role="form">                   
                    <div class="row text-center">
                        <div class="col-sm-6 form-group-sm ">
                            <label for="itemNameEdit">Customer Full Name</label>
                            <input type="text" id="itemNameEdit"  autofocus class="form-control checkField text-center" readonly>
                            <span class="help-block errMsg" id="itemNameEditErr"></span>
                        </div>
                        <div class="col-sm-6 form-group-sm ">
                            <label for="itemMobileEdit">Mobile</label>
                            <input type="text" id="itemMobileEdit" autofocus class="form-control checkField text-center">
                            <span class="help-block errMsg" id="itemMobileEditErr"></span>
                        </div>
                    </div>
                    <br>
                    <div class="row text-center">
                            <div class="col-sm-12 form-group-sm">
                            <label for="itemSmsEdit" class="">Message</label>
                            <textarea class="form-control" id="itemSmsEdit"  rows='4'></textarea>
                            <span class="help-block errMsg" id="itemSmsEditErr"></span>
                        </div>
                    </div>             
                    <input type="hidden" id="itemIdEdit">
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="editItemSubmit">Send</button>
                <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!--end of modal-->
<script src="<?=base_url()?>public/js/sms_notifs.js"></script>