    <?php
        //check user level
	    $dataLevel = $this->userlevel->checkLevel($role);
      $result = $this->user_model->getAllSettings();
      $site_title = $result->site_title;
    ?>
        <nav class="navbar navbar-inverse">
            <div class="container">
              <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="<?php echo site_url();?>shop/home">Home</a>
                </div>
            
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                 <!-- <ul class="nav navbar-nav">
                    <?php
                        if($dataLevel == 'is_admin'){ //Check user level if is Admin
                            echo'
                            <li><a href="'.site_url().'shop/settings">Setings</a></li>
                            ';
                        }
                    ?> -->
                  </ul>
                  <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $first_name; ?> <span class="caret"></span></a>
                      <ul class="dropdown-menu">
                        <li><a href="<?php echo site_url();?>shop/profile"><?php echo $email; ?></a></li>
                        <li><a href="<?php echo site_url();?>shop/changeuser">Edit Profile</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?php echo base_url().'shop/logout' ?>">Log Out</a></li>
                      </ul>
                    </li>
                  </ul>
                </div><!-- /.navbar-collapse -->
              </div><!-- /.container-fluid -->
            </div>
        </nav>
