<?php
defined('BASEPATH') OR exit('');
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title><?= $pageTitle ?></title>
        
        <!-- Favicon -->
        <link rel="shortcut icon" href="<?=base_url()?>public/images/logoup.png">
        <!-- favicon ends -->
        
        <!-- LOAD FILES -->
        <?php if((stristr($_SERVER['HTTP_HOST'], "localhost") !== FALSE) || (stristr($_SERVER['HTTP_HOST'], "192.168.") !== FALSE)|| (stristr($_SERVER['HTTP_HOST'], "127.0.0.") !== FALSE)): ?>
        <link rel="stylesheet" href="<?=base_url()?>public/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?=base_url()?>public/bootstrap/css/bootstrap-theme.min.css" media="screen">
        <link rel="stylesheet" href="<?=base_url()?>public/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?=base_url()?>public/font-awesome/css/font-awesome-animation.min.css">
        <link rel="stylesheet" href="<?=base_url()?>public/ext/select2/select2.min.css">

        <script src="<?=base_url()?>public/js/jquery.min.js"></script>
        <script src="<?=base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?=base_url()?>public/ext/select2/select2.min.js"></script>

        <?php else: ?>
        
        <link rel="stylesheet" href="<?=base_url()?>public/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?=base_url()?>public/bootstrap/css/bootstrap-theme.min.css" media="screen">
        <link rel="stylesheet" href="<?=base_url()?>public/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?=base_url()?>public/font-awesome/css/font-awesome-animation.min.css">
        <link rel="stylesheet" href="<?=base_url()?>public/ext/select2/select2.min.css">
        
        <script src="<?=base_url()?>public/js/jquery.min.js"></script>
        <script src="<?=base_url()?>public/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?=base_url()?>public/ext/select2/select2.min.js"></script>

        <?php endif; ?>
        
        <!-- custom CSS -->
        <link rel="stylesheet" href="<?= base_url() ?>public/css/main.css">
        <link rel="stylesheet" href="<?= base_url() ?>public/css/form.css">
        <link rel="stylesheet" href="<?=base_url()?>public/Ionicons/css/ionicons.css">
        <link rel="stylesheet" href="<?=base_url()?>public/Ionicons/css/ionicons.min.css">
        <link rel="stylesheet" href="<?=base_url()?>public/datepicker/DateTimePicker.css">
        <!-- custom JS -->
        <script src="<?= base_url() ?>public/js/main.js"></script>
        <script src="<?= base_url() ?>public/datepicker/DateTimePicker.js"></script>
        
        <!-- 
        <style type="text/css">
        
            p
            {
                margin-left: 20px;
            }
        
        </style>
        <script type="text/javascript">
        
            $(document).ready(function() 
            {
                var bIsPopup = displayPopup();
            
                $("#dtBox").DateTimePicker(
                {
                    isPopup: bIsPopup,
                
                    addEventHandlers: function()
                    {
                        var dtPickerObj = this;
                    
                        $(window).resize(function()
                        {
                            bIsPopup = displayPopup();
                            dtPickerObj.setIsPopup(bIsPopup);
                        });
                    }
                });
            });
        
            function displayPopup()
            {
                if($(document).width() >= 768)
                    return false;
                else
                    return true;
            }
        
        </script>
        <div id="dtBox"></div>
        -->


        

        <!-- ionic CSS -->
        <style>
          .step i {
          -webkit-transition: opacity .3s;
          -moz-transition: opacity .3s;
          -ms-transition: opacity .3s;
          -o-transition: opacity .3s;
           transition: opacity .3s;
                  }

          .step:hover i { opacity: .3; }

          .size-12 { font-size: 12px; }
          .size-13 { font-size: 13px; }
          .size-14 { font-size: 14px; }
          .size-16 { font-size: 16px; }
          .size-15 { font-size: 15px; }
          .size-18 { font-size: 18px; }
          .size-21 { font-size: 21px; }
          .size-24 { font-size: 24px; }
          .size-32 { font-size: 32px; }
          .size-48 { font-size: 48px; }
          .size-64 { font-size: 64px; }
          .size-96 { font-size: 96px; }
                }
        </style>
        <!-- ionic CSS -->
    </head>

    <body>
        <nav class="navbar navbar-default hidden-print">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarCollapse" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?=base_url()?>" style="margin-top:-0px">
                        <img src="<?=base_url()?>public/images/flogo.png" alt="logo" class="img-responsive" width="73px">
                    </a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="nav navbar-nav navbar-left visible-xs">
                        <li class="<?= $pageTitle == 'Dashboard' ? 'active' : '' ?>">
                            <a href="<?= site_url('dashboard') ?>">
                                <i class="fa fa-home"></i>
                                Dashboard
                            </a>
                        </li>
                        
                        <li class="<?= $pageTitle == 'Transactions' ? 'active' : '' ?>">
                            <a href="<?= site_url('transactions') ?>">
                                <i class="fa fa-exchange"></i>
                                Transactions
                            </a>
                        </li>
                        
                        <li class="<?= $pageTitle == 'Items' ? 'active' : '' ?>">
                            <a href="<?= site_url('items') ?>">
                                <i class="fa fa-cart-plus"></i>
                                Inventory Items
                            </a>
                        </li>


                        <?php if($this->session->admin_role === "Super"):?>                        
                        <li class="<?= $pageTitle == 'Administrators' ? 'active' : '' ?>">
                            <a href="<?= site_url('administrators') ?>">
                                <i class="fa fa-user"></i>
                                Admin Management
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a>
                            <b><?=$this->session->admin_name?></b>
                            </a>
                        </li>

                 <!--       <li class="dropdown">
                            <a href="<?= site_url('trashs') ?>">
                        <span class="step size-21">
                            <i class="icon ion-trash-b"></i>
                        </span>
                        <span class="label 
                        bg-primary"><?=$trashbin?></span>
                            </a>
                        </li> -->
                         
                       
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="ion-ios-contact-outline navbarIcons"></i>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-menu-header text-center">
                                    <strong>Account</strong>
                                </li>
                                <li class="divider"></li>
                                <!---<li>
                                    <a href="#">
                                        <i class="fa fa-gear fa-fw"></i> 
                                        Settings
                                    </a>
                                </li>
                                <li class="divider"></li>--->
                              <!--  <li><a href="<?= site_url('events') ?>"><i class="fa fa-tasks"></i> Log</a></li> -->
                                  <?php if($this->session->admin_role === "Super"):?> 
                                <li><a href="<?= site_url('Account_settings') ?>"><i class="fa fa-gear fa-fw"></i> My Account</a></li>
                                  <?php endif; ?>                               
                                <li><a href="<?= site_url('logout') ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>

                                
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>



        <div class="container-fluid hidden-print">
            <div class="row content">
                <!-- Left sidebar -->
                <div class="col-sm-2 sidenav hidden-xs mySideNav">
                    <br>
                    <ul class="nav nav-pills nav-stacked pointer">
                        <li class="<?= $pageTitle == 'Dashboard' ? 'active' : '' ?>">
                            <a href="<?= site_url('dashboard') ?>">
                            	<span class="step size-15">
                                <i class="ion-podium"></i>
                                Dashboard
                            </span>
                            </a>
                        </li>
                        <li class="<?= $pageTitle == 'Transactions' ? 'active' : '' ?><?= $pageTitle == 'Transactions | Reserved' ? 'active' : '' ?>">
                            <a href="<?= site_url('transactions') ?>">
                            	<span class="step size-15">
                                <i class="ion-android-walk"></i>
                                Walk-In Trans..
                            </span>
                            </a>
                        </li>

                        <li class="<?= $pageTitle == 'Online Transactions' ? 'active' : '' ?><?= $pageTitle == 'Transactions | Reserved' ? 'active' : '' ?>">
                            <a href="<?= site_url('transactions_reserve') ?>">
                            	<span class="step size-15">
                                <i class="ion-android-cart"></i>
                                Online Trans..
                            </span>
                            </a>
                        </li>

                        <li class="<?= $pageTitle == 'Items' ? 'active' : '' ?>">
                            <a href="<?= site_url('items') ?>">
                            	<span class="step size-15">
                                <i class="ion-ios-medkit-outline"></i>
                                Stock
                            </span>
                            </a>
                        </li>

                 <!--       <li class="<?= $pageTitle == 'Category' ? 'active' : '' ?>">
                            <a href="<?= site_url('cats') ?>">
                            	<span class="step size-15">
                                <i class="fa ion-filing"></i>
                                Category
                               </span>
                            </a>
                        </li> -->

                        <li class="<?= $pageTitle == 'Reports' ? 'active' : '' ?>">
                            <a href="<?= site_url('All_reports') ?>">
                            	<span class="step size-15">
                                <i class="ion-ios-printer-outline"></i>
                                Reports
                            </span>
                            </a>
                        </li>

                        <li class="<?= $pageTitle == 'SMS' ? 'active' : '' ?>">
                            <a href="<?= site_url('Sms_notifs') ?>">
                            	<span class="step size-15">
                                <i class="ion-ios-email-outline"></i>
                                SMS
                            </span>
                            </a>
                        </li>
                     
                        <?php if($this->session->admin_role === "Super"):?>
                             <!--
                        <li class="<?= $pageTitle == 'Database' ? 'active' : '' ?>">
                            <a href="<?= site_url('dbmanagement') ?>">
                                <i class="fa fa-database"></i>
                                Database Management
                            </a>
                        </li>
                        -->

                        <li class="<?= $pageTitle == 'Administrators' ? 'active' : '' ?>">
                            <a href="<?= site_url('administrators') ?>">
                            	<span class="step size-15">
                                <i class="fa fa-user"></i>
                                Users
                            </span>
                            </a>
                        </li>
                        <?php endif; ?>
                        <!--<li class="<?= $pageTitle == 'Customer' ? 'active' : '' ?>">
                            <a href="<?= site_url('Customer_managements') ?>">
                            	<span class="step size-15">
                                <i class="ion-person-stalker"></i>
                                Customer's
                            </span>
                            </a>
                        </li>-->

                    </ul>
                    <br>
                </div>
                <!-- Left sidebar ends -->
                <br>

                <!-- Main content -->
                <div class="col-sm-10">
                    <?= isset($pageContent) ? $pageContent : "" ?>
                </div>
                <!-- Main content ends -->
            </div>
        </div>

        <footer class="container-fluid text-center hidden-print">
            <p>
                <i class="fa fa-copyright"></i>
                Copyright <a href="#">PointUp</a> (2018)
            </p>
            <p>
                LOCAL SOFTWARE DEVELOPER & COMPUTER MAINTENANCE TEAM
            </p>
        </footer>

        <!--Modal to show flash message-->
        <div id="flashMsgModal" class="modal fade" role="dialog" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" id="flashMsgHeader">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <center><i id="flashMsgIcon"></i> <font id="flashMsg"></font></center>
                    </div>
                </div>
            </div>
        </div>
        <!--Modal end-->

        <!--modal to display transaction receipt when a transaction's ref is clicked on the transaction list table -->
        <div class="modal fade" role='dialog' data-backdrop='static' id="transReceiptModal">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header hidden-print">
                        <button class="close" data-dismiss='modal'>&times;</button>
                        <h4 class="text-center">Transaction Receipt</h4>
                    </div>
                    <div class="modal-body" id='transReceipt'></div>
                </div>
            </div>
        </div>
        <!-- End of modal-->
        
        
        <!--Login Modal-->
        <div class="modal fade" role='dialog' data-backdrop='static' id='logInModal'>
            <div class="modal-dialog">
                <!-- Log in div below-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close closeLogInModal">&times;</button>
                        <h1 class="text-center"><img src="<?=base_url()?>public/images/lock.gif" alt="logo" height="100px"></h1>
                        <h4 class="text-center">Log In</h4>
                        <div id="logInModalFMsg" class="text-center errMsg"></div>
                    </div>
                    <div class="modal-body">
                        <form name="logInModalForm">
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <label for='logInModalEmail' class="control-label">E-mail</label>
                                    <input type="email" id='logInModalEmail' class="form-control checkField" placeholder="E-mail" autofocus>
                                    <span class="help-block errMsg" id="logInModalEmailErr"></span>
                                </div>
                                <div class="col-sm-12 form-group">
                                    <label for='logInPassword' class="control-label">Password</label>
                                    <input type="password" id='logInModalPassword'class="form-control checkField" placeholder="Password">
                                    <span class="help-block errMsg" id="logInModalPasswordErr"></span>
                                </div>
                            </div>
                            
                            <div class="row">
                                <!--<div class="col-sm-6 pull-left">
                                    <input type="checkbox" class="control-label" id='remMe'> Remember me
                                </div>-->
                                <div class="col-sm-4"></div>
                                <div class="col-sm-2 pull-right">
                                    <button id='loginModalSubmit' class="btn btn-primary">Log in</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- End of log in div-->
            </div>
        </div>
        <!---end of Login Modal-->
    </body>
</html>
