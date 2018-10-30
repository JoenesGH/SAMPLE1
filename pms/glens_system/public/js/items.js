'use strict';

$(document).ready(function(){
    checkDocumentVisibility(checkLogin);//check document visibility in order to confirm user's log in status
    
    //load all items once the page is ready
    lilt();
    
    
    
    //WHEN USE BARCODE SCANNER IS CLICKED
    $("#useBarcodeScanner").click(function(e){
        e.preventDefault();
        
        $("#itemCode").focus();
    });
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    /**
     * Toggle the form to add a new item
     */
    $("#createItem").click(function(){
        $("#itemsListDiv").toggleClass("col-sm-8", "col-sm-12");
        $("#createNewItemDiv").toggleClass('hidden');
        $("#itemName").focus();
    });
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    $(".cancelAddItem").click(function(){
        //reset and hide the form
        document.getElementById("addNewItemForm").reset();//reset the form
        $("#createNewItemDiv").addClass('hidden');//hide the form
        $("#itemsListDiv").attr('class', "col-sm-12");//make the table span the whole div
    });
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //execute when 'auto-generate' checkbox is clicked while trying to add a new item
    $("#gen4me").click(function(){
        //if checked, generate a unique item code for user. Else, clear field
        if($("#gen4me").prop("checked")){
            var codeExist = false;
            
            do{
                //generate random string, reduce the length to 10 and convert to uppercase
                var rand = Math.random().toString(36).slice(2).substring(0, 10).toUpperCase();
                $("#itemCode").val(rand);//paste the code in input
                $("#itemCodeErr").text('');//remove the error message being displayed (if any)
                
                //check whether code exist for another item
                $.ajax({
                    type: 'get',
                    url: appRoot+"items/gettablecol/id/code/"+rand,
                    success: function(returnedData){
                        codeExist = returnedData.status;//returnedData.status could be either 1 or 0
                    }
                });
            }
            
            while(codeExist);
            
        }
        
        else{
            $("#itemCode").val("");
        }
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //handles the submission of adding new item
    $("#addNewItemForm").submit(function(e){
        e.preventDefault();
        
        changeInnerHTML(['itemNameErr','itemBatchErr','prescriptionErr','categoryErr','unitErr','itemQuantityErr','itemPriceErr','itemUnitErr','itemCodeErr', 'addCustErrMsg'], "");
        
        var itemName = $("#itemName").val();
        var itemBatch = $("#itemBatch").val();
        var prescription = $("#prescription").val();
        var category = $("#category").val();
        var unit = $("#unit").val();
        var itemDex = $("#itemDex").val();
        var itemQuantity = $("#itemQuantity").val();
        var itemPrice = $("#itemPrice").val().replace(",", "");
        var itemUnit = $("#itemUnit").val().replace(",", "");
        var itemCode = $("#itemCode").val();
        var itemDescription = $("#itemDescription").val();
        
        if(!itemName || !itemBatch || !prescription || !category || !unit || !itemQuantity || !itemPrice || !itemUnit || !itemCode){
            !itemName ? $("#itemNameErr").text("required") : "";
            !itemBatch ? $("#itemBatchErr").text("required") : "";
            !prescription ? $("#prescriptionErr").text("required") : "";
            !category ? $("#categoryErr").text("required") : "";
            !unit ? $("#unitErr").text("required") : "";
            !itemQuantity ? $("#itemQuantityErr").text("required") : "";
            !itemPrice ? $("#itemPriceErr").text("required") : "";
            !itemUnit ? $("#itemUnitErr").text("required") : "";
            !itemCode ? $("#itemCodeErr").text("required") : "";
            
            $("#addCustErrMsg").text("One or more required fields are empty");
            
            return;
        }
        
        displayFlashMsg("Adding Item '"+itemName+"'", "fa fa-spinner faa-spin animated", '', '');
        
        $.ajax({
            type: "post",
            url: appRoot+"items/add",
            data: new FormData(this),
            cache:false,
            contentType: false,
            processData: false,

            success: function(returnedData){
                if(returnedData.status === 1){
                    changeFlashMsgContent(returnedData.msg, "text-success", '', 1500);
                    document.getElementById("addNewItemForm").reset();
                    $('#item-image').attr('src', '');
                    
                    //refresh the items list table
                    lilt();
                    
                    //return focus to item code input to allow adding item with barcode scanner
                    $("#itemCode").focus();
                }
                
                else{
                    hideFlashMsg();
                    
                    //display all errors
                    $("#itemNameErr").text(returnedData.itemName);
                    $("#itemBatchErr").text(returnedData.itemBatch); 
                    $("#prescriptionErr").text(returnedData.prescription); 
                    $("#categoryErr").text(returnedData.category); 
                    $("#unitErr").text(returnedData.unit); 
                    $("#itemPriceErr").text(returnedData.itemPrice);
                    $("#itemUnitErr").text(returnedData.itemUnit);
                    $("#itemCodeErr").text(returnedData.itemCode);
                    $("#itemQuantityErr").text(returnedData.itemQuantity);
                    $("#addCustErrMsg").text(returnedData.msg);
                }
            },

            error: function(returnedData){
                if(!navigator.onLine){
                    changeFlashMsgContent("You appear to be offline. Please reconnect to the internet and try again", "", "red", "");
                }

                else{
                    changeFlashMsgContent("Unable to process your request at this time. Pls try again later!", "", "red", "");
                }
            }
        });
    });
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //reload items list table when events occur
    $("#itemsListPerPage, #itemsListSortBy").change(function(){
        displayFlashMsg("Please wait...", spinnerClass, "", "");
        lilt();
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    $("#itemSearch").keyup(function(){
        var value = $(this).val();
        
        if(value){
            $.ajax({
                url: appRoot+"search/itemsearch",
                type: "get",
                data: {v:value},
                success: function(returnedData){
                    $("#itemsListTable").html(returnedData.itemsListTable);
                }
            });
        }
        
        else{
            //reload the table if all text in search box has been cleared
            displayFlashMsg("Loading page...", spinnerClass, "", "");
            lilt();
        }
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //triggers when an item's "edit" icon is clicked
    $("#itemsListTable").on('click', ".editItem", function(e){
        e.preventDefault();
        
        //get item info
        var itemId = $(this).attr('id').split("-")[1];
        var itemDesc = $("#itemDesc-"+itemId).attr('title');
        var itemName = $("#itemName-"+itemId).html();
        var itemBatch = $("#itemBatch-"+itemId).html();
        var itemPrescription = $("#itemPrescription-"+itemId).html();
        var itemECategory = $("#itemECategory-"+itemId).html();
        var itemDex = $("#itemDex-"+itemId).html();
        var itemPrice = $("#itemPrice-"+itemId).html().split(".")[0].replace(",", "");
        var itemSUnit = $("#itemSUnit-"+itemId).html().split(".")[0].replace(",", "");
        var itemCode = $("#itemCode-"+itemId).html();
        
        //prefill form with info
        $("#itemIdEdit").val(itemId);
        $("#itemNameEdit").val(itemName);
        $("#itemBatchEdit").val(itemBatch);
        $("#itemPrescriptionEdit").val(itemPrescription);
        $("#itemCategoryEdit").val(itemECategory);
        $("#itemDexEdit").val(itemDex);
        $("#itemCodeEdit").val(itemCode);
        $("#itemPriceEdit").val(itemPrice);
        $("#itemUnitEdit").val(itemSUnit);
        $("#itemDescriptionEdit").val(itemDesc);
        
        //remove all error messages that might exist
        $("#editItemFMsg").html("");
        $("#itemNameEditErr").html("");
        $("#itemBatchEditErr").html("");
        $("#itemPrescriptionEditErr").html("");
        $("#itemCategoryEditErr").html(""); 
        $("#itemCodeEditErr").html("");
        $("#itemPriceEditErr").html("");
        $("#itemUnitEditErr").html("");
        
        //launch modal
        $("#editItemModal").modal('show');
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    $("#editItemSubmit").click(function(){
        var itemName = $("#itemNameEdit").val();
        var itemBatch = $("#itemBatchEdit").val();
        var itemPrescription = $("#itemPrescriptionEdit").val();
        var itemCategory = $("#itemCategoryEdit").val();    
        var itemDex = $("#itemDexEdit").val();
        var itemPrice = $("#itemPriceEdit").val();
        var itemUnit = $("#itemUnitEdit").val();
        var itemDesc = $("#itemDescriptionEdit").val();
        var itemId = $("#itemIdEdit").val();
        var itemCode = $("#itemCodeEdit").val();
        
        if(!itemCode || !itemName || !itemBatch || !itemPrescription || !itemCategory || !itemPrice || !itemUnit || !itemId){
            !itemCode ? $("#itemCodeEditErr").html("Item code cannot be empty") : "";
            !itemName ? $("#itemNameEditErr").html("Item name cannot be empty") : "";
            !itemBatch ? $("#itemBatchEditErr").html("Item batch cannot be empty") : "";
            !itemPrescription ? $("#itemPrescriptionEditErr").html("Item Type of drug cannot be empty") : "";
            !itemCategory ? $("#itemCategoryEditErr").html("Item category cannot be empty") : "";    
            !itemPrice ? $("#itemPriceEditErr").html("Item price cannot be empty") : "";
            !itemUnit ? $("#itemUnitEditErr").html("Item unit cannot be empty") : "";
            !itemId ? $("#editItemFMsg").html("Unknown item") : "";
            return;
        }
        
        $("#editItemFMsg").css('color', 'black').html("<i class='"+spinnerClass+"'></i> Processing your request....");
        
        $.ajax({
            method: "POST",
            url: appRoot+"items/edit",
            data: {itemCode:itemCode,itemName:itemName,itemBatch:itemBatch,itemPrescription:itemPrescription,itemCategory:itemCategory,itemDex:itemDex, itemPrice:itemPrice,itemUnit:itemUnit, itemDesc:itemDesc, _iId:itemId, itemCode:itemCode}
        }).done(function(returnedData){
            if(returnedData.status === 1){
                $("#editItemFMsg").css('color', 'green').html("Item successfully updated");
                
                setTimeout(function(){
                    $("#editItemModal").modal('hide');
                }, 1000);
                
                lilt();
            }
            
            else{
                $("#editItemFMsg").css('color', 'red').html("One or more required fields are empty or not properly filled");
                $("#itemNameEditErr").html(returnedData.itemName);
                $("#itemBatchEditErr").html(returnedData.itemBatch);
                $("#itemPrescriptionEditErr").html(returnedData.itemPrescription);
                $("#itemCategoryEditErr").html(returnedData.itemCategory);        
                $("#itemCodeEditErr").html(returnedData.itemCode);
                $("#itemPriceEditErr").html(returnedData.itemPrice);
                $("#itemUnitEditErr").html(returnedData.itemUnit);
            }
        }).fail(function(){
            $("#editItemFMsg").css('color', 'red').html("Unable to process your request at this time. Please check your internet connection and try again");
        });
    });
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //trigers the modal to update stock
    $("#itemsListTable").on('click', '.updateStock', function(){
        //get item info and fill the form with them
        var itemId = $(this).attr('id').split("-")[1];
        var itemName = $("#itemName-"+itemId).html();
        var itemCurQuantity = $("#itemQuantity-"+itemId).html();
        var itemCode = $("#itemCode-"+itemId).html();
        
        $("#stockUpdateItemId").val(itemId);
        $("#stockUpdateItemName").val(itemName);
        $("#stockUpdateItemCode").val(itemCode);
        $("#stockUpdateItemQInStock").val(itemCurQuantity);
        
        $("#updateStockModal").modal('show');
    });

    //trigers the modal to view stock
    $("#itemsListTable").on('click', '.viewStock', function(){
        //get item info and fill the form with them
        var itemId = $(this).attr('id').split("-")[1];
        var itemName = $("#itemName-"+itemId).html();
        var itemBatch = $("#itemBatch-"+itemId).html();
        var category = $("#itemCategory-"+itemId).html();
        var itemDex = $("#itemDex-"+itemId).html();
        var itemDesc = $("#itemDesc-"+itemId).html();
        var itemCurQuantity = $("#itemQuantity-"+itemId).html();
        var itemUnit = $("#itemUnit-"+itemId).html();
        var itemPrice = $("#itemPrice-"+itemId).html();
        var itemSUnit = $("#itemSUnit-"+itemId).html();
        var itemPrescription = $("#itemPrescription-"+itemId).html();
        var itemSold = $("#itemSold-"+itemId).html();
        var itemSale = $("#itemSale-"+itemId).html();
        var itemDateadd = $("#itemDateAdded-"+itemId).html();
        var itemDateupdate = $("#itemLastUpdate-"+itemId).html();
        var itemCode = $("#itemCode-"+itemId).html();
        
        $("#stockViewItemId").val(itemId);
        $("#stockViewItemName").val(itemName);
        $("#stockViewItemBatch").val(itemBatch);
        $("#stockViewCategory").val(category);
        $("#stockViewItemDex").val(itemDex);
        $("#stockViewItemDesc").val(itemDesc);
        $("#stockViewItemCode").val(itemCode);
        $("#stockViewItemQInStock").val(itemCurQuantity);
        $("#stockViewItemUnit").val(itemUnit);
        $("#stockViewItemPrice").val(itemPrice);
        $("#stockViewItemSUnit").val(itemSUnit);
        $("#stockViewPrescription").val(itemPrescription);
        $("#stockViewItemSold").val(itemSold);
        $("#stockViewItemSale").val(itemSale);
        $("#stockViewItemDateadd").val(itemDateadd);
        $("#stockViewItemDateupdate").val(itemDateupdate);
        
        $("#viewStockModal").modal('show');
    });
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //runs when the update type is changed while trying to update stock
    //sets a default description if update type is "newStock"
    $("#stockUpdateType").on('change', function(){
        var updateType = $("#stockUpdateType").val();
        
        if(updateType && (updateType === 'newStock')){
            $("#stockUpdateDescription").val("New items were purchased");
        }
        
        else{
            $("#stockUpdateDescription").val("");
        }
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //handles the updating of item's quantity in stock
    $("#stockUpdateSubmit").click(function(){
        var updateType = $("#stockUpdateType").val();
        var stockUpdateQuantity = $("#stockUpdateQuantity").val();
        var stockUpdateDescription = $("#stockUpdateDescription").val();
        var itemId = $("#stockUpdateItemId").val();
        
        if(!updateType || !stockUpdateQuantity || !stockUpdateDescription || !itemId){
            !updateType ? $("#stockUpdateTypeErr").html("required") : "";
            !stockUpdateQuantity ? $("#stockUpdateQuantityErr").html("required") : "";
            !stockUpdateDescription ? $("#stockUpdateDescriptionErr").html("required") : "";
            !itemId ? $("#stockUpdateItemIdErr").html("required") : "";
            
            return;
        }
        
        $("#stockUpdateFMsg").html("<i class='"+spinnerClass+"'></i> Updating Stock.....");
        
        $.ajax({
            method: "POST",
            url: appRoot+"items/updatestock",
            data: {_iId:itemId, _upType:updateType, qty:stockUpdateQuantity, desc:stockUpdateDescription}
        }).done(function(returnedData){
            if(returnedData.status === 1){
                $("#stockUpdateFMsg").html(returnedData.msg);
                
                //refresh items' list
                lilt();
                
                //reset form
                document.getElementById("updateStockForm").reset();
                
                //dismiss modal after some secs
                setTimeout(function(){
                    $("#updateStockModal").modal('hide');//hide modal
                    $("#stockUpdateFMsg").html("");//remove msg
                }, 1000);
            }
            
            else{
                $("#stockUpdateFMsg").html(returnedData.msg);
                
                $("#stockUpdateTypeErr").html(returnedData._upType);
                $("#stockUpdateQuantityErr").html(returnedData.qty);
                $("#stockUpdateDescriptionErr").html(returnedData.desc);
            }
        }).fail(function(){
            $("#stockUpdateFMsg").html("Unable to process your request at this time. Please check your internet connection and try again");
        });
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //PREVENT AUTO-SUBMISSION BY THE BARCODE SCANNER
    $("#itemCode").keypress(function(e){
        if(e.which === 13){
            e.preventDefault();
            
            //change to next input by triggering the tab keyboard
            $("#itemName").focus();
        }
    });
    
    
    
    //TO DELETE AN ITEM (The item will be marked as "deleted" instead of removing it totally from the db)
    $("#itemsListTable").on('click', '.delItem', function(e){
        e.preventDefault();
        
        //get the item id
        var itemId = $(this).parents('tr').find('.curItemId').val();
        var itemRow = $(this).closest('tr');//to be used in removing the currently deleted row
        
        if(itemId){
            var confirm = window.confirm("Are you sure you want to delete item? This cannot be undone.");
            
            if(confirm){
                displayFlashMsg('Please wait...', spinnerClass, 'black');
                
                $.ajax({
                    url: appRoot+"items/delete",
                    method: "POST",
                    data: {i:itemId}
                }).done(function(rd){
                    if(rd.status === 1){
                        //remove item from list, update items' SN, display success msg
                        $(itemRow).remove();

                        //update the SN
                        resetItemSN();

                        //display success message
                        changeFlashMsgContent('Item deleted', '', 'green', 1000);
                    }

                    else{

                    }
                }).fail(function(){
                    console.log('Req Failed');
                });
            }
        }
    });
});


//When the toggle on/off button is clicked to change the items notif of an items table (i.e. off popup)
    $("#itemsListTable").on('click', '.suspendAdmin', function(){
        var ElemId = $(this).attr('id');
        
        var itemId = ElemId.split("-")[1];//get the itemId
        
        //show spinner
        $("#"+ElemId).html("<i class='"+spinnerClass+"'</i>");
        
        if(itemId){
            $.ajax({
                url: appRoot+"items/suspend",
                method: "POST",
                data: {_aId:itemId}
            }).done(function(returnedData){
                if(returnedData.status === 1){
                    //change the icon to "on" if it's "off" before the change and vice-versa
                    var newIconClass = returnedData._ns === 1 ? "fa fa-toggle-on pointer" : "fa fa-toggle-off pointer";
                    
                    //change the icon
                    $("#sus-"+returnedData._aId).html("<i class='"+ newIconClass +"'></i>");
                    
                }
                
                else{
                    console.log('err');
                }
            });
        }
    });




/**
 * "lilt" = "load Items List Table"
 * @param {type} url
 * @returns {undefined}
 */
function lilt(url){
    var orderBy = $("#itemsListSortBy").val().split("-")[0];
    var orderFormat = $("#itemsListSortBy").val().split("-")[1];
    var limit = $("#itemsListPerPage").val();
    
    
    $.ajax({
        type:'get',
        url: url ? url : appRoot+"items/lilt/",
        data: {orderBy:orderBy, orderFormat:orderFormat, limit:limit},
        
        success: function(returnedData){
            hideFlashMsg();
            $("#itemsListTable").html(returnedData.itemsListTable);
        },
        
        error: function(){
            
        }
    });
    
    return false;
}


/**
 * "vittrhist" = "View item's transaction history"
 * @param {type} itemId
 * @returns {Boolean}
 */
function vittrhist(itemId){
    if(itemId){
        
    }
    
    return false;
}



function resetItemSN(){
    $(".itemSN").each(function(i){
        $(this).html(parseInt(i)+1);
    });
}


$(document).on("change", "#item-image-file", function(event) {
    $("#item-image").attr("src", "");
    var ext = jQuery(this).val().split(".").pop().toLowerCase();

    if(ext === "") {
        jQuery(this).val("");
        jQuery("#item-image").attr("src", "");
    }
    else if (jQuery.inArray(ext, ["gif","png","jpg","jpeg"]) == -1) {
        jQuery(this).val("");
        $("#item-image").attr("alt", "Invalid image format!");
    }
    else if (this.files && this.files[0]){
        var reader = new FileReader();

        reader.onload = function (e){
            $('#item-image').attr('src', e.target.result);
        }

        reader.readAsDataURL(this.files[0]);
    }
});