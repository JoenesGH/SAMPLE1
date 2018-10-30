<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $title = "REVIEW ORDER"; ?>
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
                        <h2>Review Orders</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                
                <div class="col-md-12">
                    <div class="product-content-right">
                        <div class="woocommerce">


<?php
        $grand_total = 0;
        // Calculate grand total.
        if ($cart = $this->cart->contents()):
        foreach ($cart as $data):
        $grand_total = $grand_total + $data['subtotal'];
        endforeach;
        endif;
        ?>      

                            <form name="billing" method="post" action="<?php echo site_url('Shop/save_order') ?>" >

                                <div id="customer_details" class="col2-set">
                                    <div class="col-1">
                                        <div class="woocommerce-billing-fields">
                                            <h3>Billing Details</h3>
                                            
                                          
                                            <input class="hidden" type="text" value="<?php echo $grand_total; ?>" name="grand_total" class="input-text " required=""/>
   

                                            <label class="" for="billing_first_name">Full Name:
                                            </label>                                            
                                            <input type="text" class="input-text " value="<?php echo $first_name; ?>" name="name" required=""/>

                                            <label class="" for="billing_first_name">Address:
                                            </label>                                           
                                            <input type="text" class="input-text " value="<?php echo $address; ?>" name="address" required=""/>

                                            <label class="" for="billing_first_name">Phone Number:
                                            </label>                                           
                                            <input type="text" class="input-text " value="<?php echo $mobile; ?>" name="phone" required=""/>

                                            <div class="clear"></div>

                                            <label class="hidden" for="billing_email">Email Address:
                                            </label>                                           
                                            <input type="hidden" class="input-text " value="<?php echo $email; ?>" name="email" required=""/>

                                            <div class="clear"></div>


                                            <div class="clear"></div>

                                            <div class="create-account">
                                                <p>Select The pickup date</p>
                                            <label class="" for="billing_email">Date Pickup:
                                            </label>                                           
                                            <input type="date" class="input-text " name="pdate" required=""/>
                                                <div class="clear"></div>
                                            </div>

                                            <p id="order_comments_field" class="form-row notes hidden">
                                                <label class="" for="order_comments">Order Notes</label>
                                                <textarea cols="5" rows="2" placeholder="Notes about your order, e.g. special notes for delivery." id="order_comments" class="input-text " name="order_comments"></textarea>
                                            </p>

                                        </div>
                                    </div>

                                    

                                </div>

                                <h3 id="order_review_heading">Your order</h3>

                                <div id="order_review" style="position: relative;">

                                    <table class="shop_table">
                                        <thead>
                                            <tr>
                                                <th class=""></th>
                                                <th class="">Product</th>
                                                <th class="">Price</th>
                                                <th class="">Qty</th>
                                                <th class="">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                               <?php 
                  if(isset($cart) && is_array($cart) && count($cart)){
                  $i=1;
                  foreach ($cart as $key => $data) { 
                  ?>
                                            <tr class="cart_item">
                                                <td>
                                                    <img style="width:60px; height:60px"   src="<?php echo "http://localhost/pms/glens_system"; ?>/images/<?php echo $data['image'] ?>"    alt="<?php echo $data['id'] ?>">
                                                </td>
                                                <td>
                                                    <?php echo $data['name'] ?> 
                                                <br>    
                                                    <?php echo $data['prescription'] == "prescription" ? '<span class="label label-danger">Prescription slip required</span>' : ''?>
                                                </td>
                                                <td>
                                                Php <span class="price<?php echo $data['rowid'] ?>"><?php echo $data['price'] ?></span> 
                                                </td>
                                                <td>
                                                    <?php echo $data['qty'] ?>
                                                </td>
                                                <td>
                                                     Php <span class="subtotal subtotal<?php echo $data['rowid'] ?>"><?php echo $data['subtotal'] ?></span>
                                                </td>

                                            </tr>
                                                <?php
                  $i++;
                    } }
                ?>
                                        </tbody>
                                        <tfoot>

                                            <tr class="cart-subtotal">
                                                <th></th>
                                                <td>
                                                </td>
                                                <td>
                                                </td>
                                                <td>
                                                </td>
                                                <td>Php <span class="grandtotal">0</span>
                                                </td>
                                            </tr>

                                        </tfoot>
                                    </table>

<?=$grand_total << 1 ? '<input type="submit" data-value="Place order" value="Place order" id="place_order" name="woocommerce_checkout_place_order" class="button alt">' : ($grand_total  ? '' : '')?>

                                    
                                </div>
                            </form>

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