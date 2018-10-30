<?php
    $default = "path/to/defava.png"; // Set a Default Avatar
    $emailavatar = md5(strtolower(trim($email)));
    $gravurl = "";
    $imageProfile = '<img style="width:21px;height:21px;border-radius:50%;border: 2px solid #FCE4EC" src="http://www.gravatar.com/avatar/'.$emailavatar.'?d='.$default.'&s=140&r=g&d=mm" class="img-circle" alt="">';
?>

<div class="site-branding-area" id="scroll">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="logo">
                        <h1><a href="./"><img src="<?=base_url()?>public/img/logo1.png"></a></h1>
                    </div>
                </div>
                 
                <div class="col-sm-6">
                    <div class="shopping-item">
                        <a href="<?php echo site_url('Shop/myOrder');?>">
                            <span class="cart-amunt"> (<?=$readyItems?>) My Orders &nbsp;</span>
                        </a>
                    </div>
                   
                    <div class="shopping-item">
                       <a data-toggle="<?php echo $role == 1 ? 'dropdown' : ''?>"  href="<?php echo $role == 1 ? '' : site_url('Shop/profile')  ?>" > 
                             <?php echo $role == 1 ? $imageProfile : '<i class="fa fa-user">'?>
                             <span class="cart-amunt"> <?php echo $role == 1 ? $first_name : 'My Account'?> &nbsp;</span>
                                                                      </i>
                       </a>
                       <ul class="dropdown-menu">
                        <li><a style="color:#ff6a80" href="<?php echo site_url();?>shop/profile"><?php echo $email; ?></a></li>
                        <li><a style="color:#ff6a80" href="<?php echo site_url();?>shop/changeuser">Edit Profile</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a style="color:#ff6a80" href="<?php echo base_url().'shop/logout' ?>">Log Out</a></li>
                      </ul>
                    </div>

                    <div class="shopping-item">
                            <a href="<?php echo site_url('Shop/MyCart');?>" > 
                                <i class="fa fa-shopping-cart">
                                    <span class="cart-amunt">&nbsp;Cart</span> <span class="product-count"><?php echo count($this->cart->contents());  ?></span>
                                </i>
                            </a>
                    <div class="modal fade bs-example-modal-lg displaycontent" id="exampleModal" tabindex="-1" >
                    </div>
                </div>
            </div>
        </div>
</div> 
<!-- End site branding area -->  