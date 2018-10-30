'use strict';

$(document).ready(function(){
    checkDocumentVisibility(checkLogin);//check document visibility in order to confirm user's log in status
	
    //load all items once the page is ready
    lilt();
    
    
    
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
    

    //reload items list table when events occur
    $("#itemsListPerPage, #itemsListSortBy").change(function(){
        displayFlashMsg("Please wait...", spinnerClass, "", "");
        lilt();
    });
    

    
    //TO DELETE AN ITEM (The item will be marked as "deleted" instead of removing it totally from the db)
    $("#itemsListTable").on('click', '.delItem', function(e){
        e.preventDefault();
        
        //get the item id
        var itemId = $(this).parents('tr').find('.curItemId').val();
        var itemRow = $(this).closest('tr');//to be used in removing the currently deleted row
        
        if(itemId){
            var confirm = window.confirm("Are you sure you want to delete Supplier? This cannot be undone.");
            
            if(confirm){
                displayFlashMsg('Please wait...', spinnerClass, 'black');
                
                $.ajax({
                    url: appRoot+"supps/delete",
                    method: "POST",
                    data: {i:itemId}
                }).done(function(rd){
                    if(rd.status === 1){
                        //remove item from list, update items' SN, display success msg
                        $(itemRow).remove();

                        //update the SN
                        resetItemSN();

                        //display success message
                        changeFlashMsgContent('Supplier deleted', '', 'green', 1000);
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
        url: url ? url : appRoot+"events/lilt/",
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