 <div class="mainmenu-area">
        <div class="container">
            <div class="row">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div> 
                <div class="navbar-collapse collapse">
                   <ul class="nav navbar-nav">
                        <li class="<?php echo "$title" == 'HOME' ? 'active' : '' ?>"><a href="<?php echo site_url('Shop/home');?>"><i class="fa fa-home"></i><span class="menulist"> HOME</span></a></li>
                        <li class="<?php echo "$title" == 'PRODUCTS' ? 'active' : '' ?>"><a href="<?php echo site_url('Shop/');?>"><i class="fa fa-shopping-cart"></i><span class="menulist"> STORE</span></a></li>
                        <li><a href="#"><i class="fa fa-globe"></i><span class="menulist"> ABOUT US</span></a></li>
                   </ul>
               </div>
            </div>
        </div>
 </div> 
