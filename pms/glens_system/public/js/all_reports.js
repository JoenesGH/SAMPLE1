'use strict';


$(document).ready(function(){
    $("#selItemDefault").select2();
    
    
    checkDocumentVisibility(checkLogin);//check document visibility in order to confirm user's log in status

    //INITIALISE datepicker on the "From date" and "To date" fields
    $('#datePair .date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        assumeNearbyYear: true,
        todayBtn: 'linked',
        todayHighlight: true,
        endDate: 'today'
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //INITIALISE datepair on the "From date" and "To date" fields
    $("#datePair").datepair();
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //WHEN "GENERATE REPORT" BUTTON IS CLICKED FROM THE MODAL
    $("#clickToGen").click(function(e){
        e.preventDefault();
        
        var fromDate = $("#transFrom").val();
        var toDate = $("#transTo").val();
        
        if(!fromDate){
            $("#transFromErr").html("Select date to start from");
            
            return;
        }
        
        /*
         * remove any error msg, hide modal, launch window to display the report in
         */
        
        $("#transFromErr").html("");
        $("#reportModal").modal('hide');

        var strWindowFeatures = "width=1000,height=500,scrollbars=yes,resizable=yes";

        window.open(appRoot+"transactions/report/"+fromDate+"/"+toDate, 'Print', strWindowFeatures);
    });
});


//WHEN "GENERATE STOCK REPORT" BUTTON IS CLICKED FROM THE MODAL
    $("#ClickToGenerateStock").click(function(e){
        var strWindowFeatures = "width=1000,height=500,scrollbars=yes,resizable=yes";
        window.open(appRoot+"all_reports/items_report/", 'Print', strWindowFeatures);
    });

//WHEN "GENERATE STOCK REPORT" BUTTON IS CLICKED FROM THE MODAL
    $("#ClickToGeneratecancelorder").click(function(e){
        var strWindowFeatures = "width=1000,height=500,scrollbars=yes,resizable=yes";
        window.open(appRoot+"all_reports/cancel_report/", 'Print', strWindowFeatures);
    });


