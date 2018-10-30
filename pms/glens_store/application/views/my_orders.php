<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $title = "My Orders"; ?>
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
    
    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>My Orders</h2>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Page title area -->
    
    <?php if($allOrders): ?>
    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                
                <div class="col-md-12">
                    <div class="product-content-right">
                        <div class="woocommerce">
                            <form method="post" action="#">
                                <table cellspacing="0" class="shop_table cart">
                                    <thead>
                                        <tr>                                         
                                            <th class="">Order #</th>
                                            <th class="">Total Items</th>
                                            <th class="">Total Amount</th>
                                            <th class="">Pickup Date</th>
                                            <th class="">Status</th>
                                            <th class=""></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <?php foreach($allOrders as $get): ?>
                                        <tr class="cart_item">
                                            <td class="">
                                            <?= $get->ref ?>
                                            </td>
                                            <td class="">
                                            <?= $get->quantity ?>
                                            </td>                          
                                            <td class="">
                                            Php <?= number_format($get->totalMoneySpent, 2) ?>
                                            </td>
                                            <td class=" ">
                                                <?= date('jS M, Y', strtotime($get->pick_date)) ?>
                                            </td>
                                            <td class="">
                                            <?=  str_replace("_", " ", $get->status)?>
                                            </td>
                                            <td class="">
                                            
                                            </td>
                                        </tr>
                                        <?php ?>
                                        <?php endforeach; ?>
                                         <!-- table div end-->   
                                    </tbody>
                                </table>
                            </form>
                        </div>                        
                    </div>                    
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
      <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">

    <br><br><br><br><br><br>
    <hr>
                        <h4>No Orders Found</h4>
    <hr>                    
    <br><br><br><br><br><br>                    
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Page title area -->
    <?php endif; ?>


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