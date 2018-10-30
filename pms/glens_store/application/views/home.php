<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $title = "HOME"; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php echo "$title";?> | PointUp Pharmastore</title>
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
    
    <div class="slider-area">
            <!-- Slider -->
            <div class="block-slider block-slider4">
                <ul class="" id="bxslider-home4">
                    <li>
                        <img src="<?=base_url()?>public/img/h4-slide.png" alt="Slide">
                        <div class="caption-group">
                         <h2 class="caption title">
                                No More <span class="primary"><strong> Waiting</strong></span>
                            </h2>
                            <br>
                            <h4 class="caption subtitle">Reserve Onine.Pick Up in Store</h4>
                            <a class="caption button-radius" href="<?php echo site_url('Shop/');?>"><span class="icon"></span>Shop now</a>
                        </div>
                    </li>
                    <li><img src="<?=base_url()?>public/img/h4-slide2.png" alt="Slide">
                        <div class="caption-group">
                            <h2 class="caption title">
                               <span class="primary"><strong> Avail Discount Coupon</strong></span>
                            </h2>
                            <br>
                            <h4 class="caption subtitle">For every purchase of more than 1,000 pesos</h4>
                            <a class="caption button-radius" href="<?php echo site_url('Shop/');?>"><span class="icon"></span>Shop now</a>
                        </div>
                    </li>
                    <li><img src="<?=base_url()?>public/img/h4-slide3.png" alt="Slide">
                        <div class="caption-group">
                            <h2 class="caption title">
                             <span class="primary"><strong>Trust It 100%</strong></span>
                            </h2>
                            <br>
                            <h4 class="caption subtitle">Safe & Secure Medicines</h4>
                            <a class="caption button-radius" href="<?php echo site_url('Shop/');?>"><span class="icon"></span>Shop now</a>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- ./Slider -->
    </div> <!-- End slider area -->
     
     <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Step by Step Guide of Product Reservation</h2>
                                    <div class="promo-area">
                                        <div class="zigzag-bottom"></div>
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-md-3 col-sm-6">
                                                        <div class="single-promo promo1">
                                                            <span class="step">1</span>
                                                             <p>Register to our Website</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-sm-6">
                                                        <div class="single-promo promo2">
                                                            <span class="step">2</span>
                                                                <p>Log-in to our Website</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-sm-6">
                                                        <div class="single-promo promo1">
                                                            <span class="step">3</span>
                                                                <p>Add Product to Cart</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-sm-6">
                                                        <div class="single-promo promo2">
                                                            <span class="step">4</span>
                                                         <p>Click Cart for Check-Out</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="promo-area">
                                        <div class="zigzag-bottom"></div>
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-md-3 col-sm-6">
                                                        <div class="single-promo promo1">
                                                            <span class="step">5</span>
                                                            <p>Check your Order</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-sm-6">
                                                        <div class="single-promo promo2">
                                                            <span class="step">6</span>
                                                            <p>Set Date for Pick-Up</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-sm-6">
                                                        <div class="single-promo promo1">
                                                            <span class="step">7</span>
                                                            <p>Confirm the Reservation</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-sm-6">
                                                        <div class="single-promo promo2">
                                                            <span class="step">8</span>
                                                            <p>Wait for SMS Notification</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


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