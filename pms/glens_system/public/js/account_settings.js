'use strict';

$(document).ready(function(){
    checkDocumentVisibility(checkLogin);//check document visibility in order to confirm user's log in status
	
	
    //load all admin once the page is ready
    //function header: laad_(url)
    laad_();
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //reload the list of admin when fields are changed
    $("#adminListSortBy, #adminListPerPage").change(function(){
        displayFlashMsg("Please wait...", spinnerClass, "", "");
        laad_();
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //load and show page when pagination link is clicked
    $("#allAdmin").on('click', '.lnp', function(e){
        e.preventDefault();
		
        displayFlashMsg("Please wait...", spinnerClass, "", "");

        laad_($(this).attr('href'));

        return false;
    });
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //Check to ensure the password and retype password fields are the same
    $("#passwordDup").on('keyup change focusout focus focusin', function(){
        var orig = $("#passwordOrig").val();
        var dup = $("#passwordDup").val();
        
        if(dup !== orig){
            //show error
            $("#passwordDupErr").addClass('fa');
            $("#passwordDupErr").addClass('fa-times');
            $("#passwordDupErr").removeClass('fa-check');
            $("#passwordDupErr").css('color', 'red');
            $("#passwordDupErr").html("");
        }
        
        else{
            //show success
            $("#passwordDupErr").addClass('fa');
            $("#passwordDupErr").addClass('fa-check');
            $("#passwordDupErr").removeClass('fa-times');
            $("#passwordDupErr").css('color', 'green');
            $("#passwordDupErr").html("");
        }
    });
    
   
    
    //handles the updating of admin details
    $("#editAdminSubmit").click(function(e){
        e.preventDefault();
        
        if(formChanges("editAdminForm")){
            //reset all error msgs in case they are set
            changeInnerHTML(['firstNameEditErr', 'lastNameEditErr', 'emailEditErr', 'roleEditErr', 'mobile1Err', 'mobile2Err', 'passwordOrigErr', 'passwordDupErr'], "");

            var firstName = $("#firstNameEdit").val();
            var lastName = $("#lastNameEdit").val();
            var email = $("#emailEdit").val();
            var mobile1 = $("#mobile1Edit").val();
            var mobile2 = $("#mobile2Edit").val();
            var role = $("#roleEdit").val();
            var adminId = $("#adminId").val();
            var passwordOrig = $("#passwordOrig").val();
            var passwordDup = $("#passwordDup").val();

            //ensure all required fields are filled
            if(!firstName || !lastName || !email || !role || !mobile1 || !passwordOrig || !passwordDup){
                !firstName ? changeInnerHTML('firstNameEditErr', "required") : "";
                !lastName ? changeInnerHTML('lastNameEditErr', "required") : "";
                !email ? changeInnerHTML('emailEditErr', "required") : "";
                !mobile1 ? changeInnerHTML('mobile1EditErr', "required") : "";
                !role ? changeInnerHTML('roleEditErr', "required") : "";
                !passwordOrig ? changeInnerHTML('passwordOrigErr', "required") : "";
                !passwordDup ? changeInnerHTML('passwordDupErr', 'required') : "";

                return;
            }

            if(!adminId){
                $("#fMsgEdit").text("An unexpected error occured while trying to update administrator's details");
                return;
            }

            //display message telling user action is being processed
            $("#fMsgEditIcon").attr('class', spinnerClass);
            $("#fMsgEdit").text(" Updating details...");

            //make ajax request if all is well
            $.ajax({
                method: "POST",
                url: appRoot+"account_settings/update",
                data: {firstName:firstName, lastName:lastName, email:email, role:role, mobile1:mobile1, mobile2:mobile2, adminId:adminId,
                passwordOrig:passwordOrig, passwordDup:passwordDup}
            }).done(function(returnedData){
                $("#fMsgEditIcon").removeClass();//remove spinner

                if(returnedData.status === 1){
                    $("#fMsgEdit").css('color', 'green').text(returnedData.msg);

                    //reset the form and close the modal
                    setTimeout(function(){
                        $("#fMsgEdit").text("");
                        $("#editAdminModal").modal('hide');
                    }, 1000);

                    //reset all error msgs in case they are set
                    changeInnerHTML(['firstNameEditErr', 'lastNameEditErr', 'emailEditErr', 'roleEditErr', 'mobile1Err', 'mobile2Err', 'passwordOrigErr', 'passwordDupErr'], "");

                    //refresh admin list table
                    laad_();

                }

                else{
                    //display error message returned
                    $("#fMsgEdit").css('color', 'red').html(returnedData.msg);

                    //display individual error messages if applied
                    $("#firstNameEditErr").html(returnedData.firstName);
                    $("#lastNameEditErr").html(returnedData.lastName);
                    $("#emailEditErr").html(returnedData.email);
                    $("#mobile1EditErr").html(returnedData.mobile1);
                    $("#mobile2EditErr").html(returnedData.mobile2);
                    $("#roleEditErr").html(returnedData.role);
                    $("#passwordOrigErr").text(returnedData.passwordOrig);
                    $("#passwordDupErr").text(returnedData.passwordDup);
                }
            }).fail(function(){
                    if(!navigator.onLine){
                        $("#fMsgEdit").css('color', 'red').html("Network error! Pls check your network connection");
                    }
                });
        }
        
        else{
            $("#fMsgEdit").html("No changes were made");
        }
    });
    

    
    //When the toggle on/off button is clicked to change the account status of an admin (i.e. suspend or lift suspension)
    $("#allAdmin").on('click', '.suspendAdmin', function(){
        var ElemId = $(this).attr('id');
        
        var adminId = ElemId.split("-")[1];//get the adminId
        
        //show spinner
        $("#"+ElemId).html("<i class='"+spinnerClass+"'</i>");
        
        if(adminId){
            $.ajax({
                url: appRoot+"account_settings/suspend",
                method: "POST",
                data: {_aId:adminId}
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
    
    
    /*
    ******************************************************************************************************************************
    ******************************************************************************************************************************
    ******************************************************************************************************************************
    ******************************************************************************************************************************
    ******************************************************************************************************************************
    */
    
    
    
    //to launch the modal to allow for the editing of admin info
    $("#allAdmin").on('click', '.editAdmin', function(){
        
        var adminId = $(this).attr('id').split("-")[1];
        
        $("#adminId").val(adminId);
        
        //get info of admin with adminId and prefill the form with it
        //alert($(this).siblings(".adminEmail").children('a').html());
        var firstName = $(this).siblings(".firstName").html();
        var lastName = $(this).siblings(".lastName").html();
        var role = $(this).siblings(".adminRole").html();
        var email = $(this).siblings(".adminEmail").children('a').html();
        var mobile1 = $(this).siblings(".adminMobile1").html();
        var mobile2 = $(this).siblings(".adminMobile2").html();
        
        //prefill the form fields
        $("#firstNameEdit").val(firstName);
        $("#lastNameEdit").val(lastName);
        $("#emailEdit").val(email);
        $("#mobile1Edit").val(mobile1);
        $("#mobile2Edit").val(mobile2);
        $("#roleEdit").val(role);
        
        $("#editAdminModal").modal('show');
    });
    
});



/*
***************************************************************************************************************************************
***************************************************************************************************************************************
***************************************************************************************************************************************
***************************************************************************************************************************************
***************************************************************************************************************************************
*/

/**
 * laad_ = "Load all administrators"
 * @returns {undefined}
 */
function laad_(url){
   // var orderBy = $("#adminListSortBy").val().split("-")[0];
  //  var orderFormat = $("#adminListSortBy").val().split("-")[1];
  //  var limit = $("#adminListPerPage").val();
    
    $.ajax({
        type:'get',
        url: url ? url : appRoot+"account_settings/laad_/",
        data: {},
     }).done(function(returnedData){
            hideFlashMsg();
			
            $("#allAdmin").html(returnedData.adminTable);
        });
}

