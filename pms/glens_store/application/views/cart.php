<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $title = "PRODUCTS"; ?>
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
                        <h2>My Cart</h2>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Page title area -->
    
    
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
                                            
                                            <th class="product-thumbnail">&nbsp;</th>
                                            <th class="product-name">Product</th>
                                            <th class="product-price">Price</th>
                                            <th class="product-quantity">Avail Qty</th>
                                            <th class="product-quantity">Quantity</th>
                                            <th class="product-subtotal">Total</th>
                                            <th class="product-subtotal">Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                 <?php 
                  if(isset($cart) && is_array($cart) && count($cart)){
                  $i=1;
                  foreach ($cart as $key => $data) { 
                 ?>
                                        <tr class="cart_item">
                                         
                                            <td class="thumb">
                                                <img style="width:60px; height:60px"   src="<?php echo "http://localhost/pms/glens_system"; ?>/images/<?php echo $data['image'] ?>"    alt="<?php echo $data['id'] ?>">
                                            </td>

                                            <td class="name">
                                                <?php echo $data['name'] ?> 
                                            <br>    
                                                <?php echo $data['prescription'] == "prescription" ? '<span class="label label-danger">Prescription slip required</span>' : ''?>
                                            </td>

                                            <td class="price">
                                                Php <span class="price<?php echo $data['rowid'] ?>"><?php echo $data['price'] ?></span> 
                                            </td>

                                            <td class="price">
                                                <span><?php echo $data['aqty'] ?></span> 
                                            </td>

                                            <td class="qnt-count col-md-1">
                                                <div class="quantity buttons_added">
                                                    <input class="quantity text-center qty<?php echo $data['rowid'] ?> form-control" onclick="javascript:updateproduct('<?php echo $data['rowid'] ?>')" type="number" min="1" max="<?php echo $data['aqty'] ?>"  value="<?php echo $data['qty'] ?>">
                                                </div>
                                            </td>

                                            <td class="total">
                                                Php <span class="subtotal subtotal<?php echo $data['rowid'] ?>"><?php echo $data['subtotal'] ?></span> 
                                            </td>

                                            <td class="delete">
                                                <i class="icon-delete" onclick="javascript:deleteproduct('<?php echo $data['rowid'] ?>')"><i class="ion-trash-b"></i></i> 
                                            </td>
                                        </tr>
                 <?php
                  $i++;
                    } }
                ?>
                                        <tr>
                                            <td class="actions" colspan="5">
                                                <div class="coupon">
                                                    <label for="coupon_code">Total:</label>
                                                    <td class="">Php <span class="grandtotal">0</span> </td>
                                                    <td><a  onclick="javascript:deleteproduct('all')"><input type="submit" value="Clear ALL" class="button"></a></td>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>

                            <div class="cart-collaterals">

                            <div class="cart_totals ">
                                <h2>Cart Totals</h2> 

                                <table cellspacing="0">
                                    <tbody>
                                        <tr class="cart-subtotal">
                                            <th>Cart Subtotal</th>
                                            <td class="">Total <span class="grandtotal">0</span> </td>
                                        </tr>

                                <!--        <tr class="shipping">
                                            <th>Vat</th>
                                            <td>%12</td>
                                        </tr> -->

                                        <tr class="order-total">
                                            <th>Order Total</th>
                                            <td class="">Total <span class="grandtotal">0</span> </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>

     <a href="<?php echo site_url('Shop/review') ?>"><input type="submit" value="review orders" class="button "></a>
         
                <!--   <a href="<?php echo site_url('Shop/billing_view') ?>"><input type="submit" value="Procced Checkout" class="button"></a>  -->
                               
                                 
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

    <script type="text/javascript">
function deleteproduct(rowid)
{
var answer = confirm ("Are you sure you want to delete?");
if (answer)
{
        $.ajax({
                type: "POST",
                url: "<?php echo site_url('Shop/remove');?>",
                data: "rowid="+rowid,
                success: function (response) {
                    $(".rowid"+rowid).remove(".rowid"+rowid); 
                    $(".cartcount").text(response);  
                    var total = 0;
                    $('.subtotal').each(function(){
                        total += parseInt($(this).text());
                        $('.grandtotal').text(total);
                        window.location.reload();
                    });              
                }
            });
      }
}

var total = 0;
$('.subtotal').each(function(){
    total += parseInt($(this).text());
    $('.grandtotal').text(total);
});


function updateproduct(rowid)
{
var qty = $('.qty'+rowid).val();
var price = $('.price'+rowid).text();
var subtotal = $('.subtotal'+rowid).text();
    $.ajax({
            type: "POST",
            url: "<?php echo site_url('Shop/update_cart');?>",
            data: "rowid="+rowid+"&qty="+qty+"&price="+price+"&subtotal="+subtotal,
            success: function (response) {
                    $('.subtotal'+rowid).text(response);
                    var total = 0;
                    $('.subtotal').each(function(){
                        total += parseInt($(this).text());
                        $('.grandtotal').text(total);
                    });    
            }
        });
}
</script>
  </body>
</html>