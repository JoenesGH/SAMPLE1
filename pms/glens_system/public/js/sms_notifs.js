'use strict';

$(document).ready(function(){
    checkDocumentVisibility(checkLogin);//check document visibility in order to confirm user's log in status
	
    //load all items once the page is ready
    lilt();
    

    
    /**
     * Toggle the form to add a new item
     */
    $("#createItem").click(function(){
        $("#itemsListDiv").toggleClass("col-sm-8", "col-sm-12");
        $("#createNewItemDiv").toggleClass('hidden');
        $("#itemName").focus();
    });
    
     
    
    $(".cancelAddItem").click(function(){
        //reset and hide the form
        document.getElementById("addNewItemForm").reset();//reset the form
        $("#createNewItemDiv").addClass('hidden');//hide the form
        $("#itemsListDiv").attr('class', "col-sm-12");//make the table span the whole div
    });
    

    
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
                url: appRoot+"SCategory/itemsearch",
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
        var itemName = $("#itemName-"+itemId).html();
        var itemMobile = $("#itemMobile-"+itemId).html();
        var itemSms = $("#itemSms-"+itemId).html();
    
        
        //prefill form with info
        $("#itemIdEdit").val(itemId);
        $("#itemNameEdit").val(itemName);
        $("#itemMobileEdit").val(itemMobile);
        $("#itemSmsEdit").val(itemSms);
       
        
       
        
        //remove all error messages that might exist
        $("#editItemFMsg").html("");
        $("#itemNameEditErr").html("");
        $("#itemMobileEditErr").html("");
        $("#itemSmsEditErr").html("");
     
     
        
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
        var itemMobile = $("#itemMobileEdit").val();
        var itemSms = $("#itemSmsEdit").val();
       
       
        var itemId = $("#itemIdEdit").val();
        
        
        if(!itemName || !itemMobile || !itemSms || !itemId){
            !itemName ? $("#itemNameEditErr").html("Select the right customer name on the list") : "";
            !itemMobile ? $("#itemMobileEditErr").html("Mobile cannot be empty") : "";
            !itemSms ? $("#itemSmsEditErr").html("Messages cannot be empty") : "";       
            !itemId ? $("#editItemFMsg").html("Unknown item") : "";
            return;
        }
        
        $("#editItemFMsg").css('color', 'black').html("<i class='"+spinnerClass+"'></i> Processing your request....");
        
        $.ajax({
            method: "POST",
            url: appRoot+"sms_notifs/edit",
            data: {itemName:itemName, itemMobile:itemMobile, itemSms:itemSms,  _itransId:itemId}
        }).done(function(returnedData){
            if(returnedData.status === 1){
                $("#editItemFMsg").css('color', 'green').html("Successfully SMS Sent");
                
                setTimeout(function(){
                    $("#editItemModal").modal('hide');
                }, 1000);
                
                lilt();
            }
            
            else{
                $("#editItemFMsg").css('color', 'red').html("One or more required fields are empty or not properly filled");
                
                $("#itemNameEditErr").html(returnedData.itemName);

                $("#itemMobileEditErr").html(returnedData.itemMobile);

                $("#itemSmsEditErr").html(returnedData.itemSms);
               
               
            }
        }).fail(function(){
            $("#editItemFMsg").css('color', 'red').html("Unable to process your request at this time. Please check your internet connection and try again");
        });
    });
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
        url: url ? url : appRoot+"sms_notifs/lilt/",
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