<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $title = "ORDER PLACED"; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php echo "$title";?> | PointUP PharmaStore</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?=base_url()?>public/img/logoup.png">
    <?php include('includes/css.php');?>
  </head>
  <body>
    
<!--  branding area --> 
    <?php include('includes/branding.php');?>
<!-- End site branding area -->  
    
<!-- navbar header -->
    <?php include('includes/navbar_header.php');?>
<!-- end navbar header -->

                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                
    
    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Thank You! your order has been placed!</h2>
                    </div>
                    <div class="text-center">
                        <input type="submit"  onclick='document.location="<?= site_url('Shop/') ?>"'  value="Continue to shooping">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                
   

<!-- footer top area -->
    <?php include('includes/footer_top.php');?>
<!-- end footer top area -->

<!-- footer -->
    <?php include('includes/footer.php');?>
<!-- end footer -->

<!-- script -->
    <?php include('includes/script.php');?>
<!-- script -->   

  </body>
</html>