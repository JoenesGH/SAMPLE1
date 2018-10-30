<?php
defined('BASEPATH') OR exit('');
?>

 <!-- Admin list -->
            <div class="row">
                <div class="col-sm-12" id="allAdmin"></div>
            </div>
 <!-- Admin list ends -->



<!--- Modal for editing admin details --->
<div class='modal fade' id='editAdminModal' role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class='modal-header'>
                <button class="close" data-dismiss='modal'>&times;</button>
                <h4 class="text-center">Update Info</h4>
                <div class="text-center">
                    <i id="fMsgEditIcon"></i>
                    <span id="fMsgEdit"></span>
                </div>
            </div>
            <div class="modal-body">
                <form id='editAdminForm' name='editAdminForm' role='form'>
                    <div class="row">
                        <div class="form-group-sm col-sm-6">
                            <label for='firstNameEdit' class="control-label">First Name</label>
                            <input type="text" id='firstNameEdit' class="form-control checkField" placeholder="First Name">
                            <span class="help-block errMsg" id="firstNameEditErr"></span>
                        </div>
                        <div class="form-group-sm col-sm-6">
                            <label for='lastNameEdit' class="control-label">Last Name</label>
                            <input type="text" id='lastNameEdit' class="form-control checkField" placeholder="Last Name">
                            <span class="help-block errMsg" id="lastNameEditErr"></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group-sm col-sm-6">
                            <label for='emailEdit' class="control-label">Email</label>
                            <input type="email" id='emailEdit' class="form-control checkField" placeholder="Email">
                            <span class="help-block errMsg" id="emailEditErr"></span>
                        </div>
                        <div class="form-group-sm col-sm-6">
                            <label for='roleEdit' class="control-label">Role</label>
                            <select class="form-control checkField" id='roleEdit'>
                                <option value=''>----</option>
                                <option value='Super'>Super</option>
                                <option value='Basic'>Basic</option>
                            </select>
                            <span class="help-block errMsg" id="roleEditErr"></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group-sm col-sm-6">
                            <label for='mobile1Edit' class="control-label">Phone Number</label>
                            <input type="tel" id='mobile1Edit' class="form-control checkField" placeholder="Phone Number">
                            <span class="help-block errMsg" id="mobile1EditErr"></span>
                        </div>
                        <div class="form-group-sm col-sm-6">
                            <label for='mobile2Edit' class="control-label">Other Number</label>
                            <input type="tel" id='mobile2Edit' class="form-control" placeholder="Other Number (optional)">
                            <span class="help-block errMsg" id="mobile2EditErr"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group-sm col-sm-6">
                            <label for="passwordOrig" class="control-label">Password:</label>
                            <input type="password" class="form-control checkField" id="passwordOrig" placeholder="Password">
                            <span class="help-block errMsg" id="passwordOrigErr"></span>
                        </div>
                        <div class="form-group-sm col-sm-6">
                            <label for="passwordDup" class="control-label">Retype Password:</label>
                            <input type="password" class="form-control checkField" id="passwordDup" placeholder="Retype Password">
                            <span class="help-block errMsg" id="passwordDupErr"></span>
                        </div>
                    </div>

                    
                    
                    <input type="hidden" id="adminId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="reset" form="editAdminForm" class="btn btn-warning pull-left">Reset Form</button>
                <button type='button' id='editAdminSubmit' class="btn btn-primary">Update</button>
                <button type='button' class="btn btn-danger" data-dismiss='modal'>Close</button>
            </div>
        </div>
    </div>
</div>
<!--- end of modal to edit admin details --->
<script src="<?=base_url()?>public/js/account_settings.js"></script>