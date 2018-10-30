<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $title = "PROFILE"; ?>

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
                
    
    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">                     
                       <div class="container well col-md-12">
                           <div class="row">
  <!--                         <div class="col-md-3" >
                              <?php echo $imageProfile; ?>
                           </div>
                           <div class="col-md-7">                      -->
                           <h3><i class="fa fa-user-circle" aria-hidden="true"></i> <?php echo $first_name ." ". $last_name; ?></h3>
                           <h5><i class="fa fa-envelope-o" aria-hidden="true"></i> <?php echo $email; ?></h5>
             <!--          <h5><i class="fa fa-sign-in" aria-hidden="true"></i> <?php echo $last_login; ?></h5>   -->
                           <h5><i class="ion-android-call" aria-hidden="true"></i> <?php echo $mobile; ?></h5>
                           <h5><i class="ion-ios-location-outline" aria-hidden="true"></i> <?php echo $address; ?></h5>
                        </div>
                    </div>
                    </div>
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