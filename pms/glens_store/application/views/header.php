<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$result = $this->user_model->getAllSettings();
?>

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <title><?php echo $title; ?></title>
        <!-- Favicon -->
        <link rel="shortcut icon" href="<?=base_url()?>public/img/logoup.png">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <link rel="stylesheet" href="<?php echo base_url().'public/for_login/font-awesome.min.css' ?>">
        <link rel="stylesheet" href="<?php echo base_url().'public/for_login/css/main.css' ?>">
        <link rel="stylesheet" href="<?php echo base_url().'public/for_login/bot/bootstrap.min.css' ?>"> 
        <script src='https://www.google.com/recaptcha/api.js'></script>

        <script src="<?php echo base_url().'public/for_login/jquery.min.js' ?>"></script>	
        <script src="<?php echo base_url().'public/for_login/bootstrap.min.js' ?>"></script>	
        <script src="<?php echo base_url().'public/for_login/js/main.js' ?>"></script>
    </head>
    <body>
