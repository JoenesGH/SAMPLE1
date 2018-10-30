<?php
    $default = "path/to/defava.png"; // Set a Default Avatar
    $emailavatar = md5(strtolower(trim($email)));
    $gravurl = "";
    $imageProfile = '<img src="http://www.gravatar.com/avatar/'.$emailavatar.'?d='.$default.'&s=140&r=g&d=mm" class="img-circle" alt="">';
?>

<div class="container well col-md-12">
	<div class="row">
           <div class="col-md-3" >
		    <?php echo $imageProfile; ?>
          </div>
        <div class="col-md-7">
            <h3><i class="fa fa-user-circle" aria-hidden="true"></i> <?php echo $first_name ." ". $last_name; ?></h3>
            <h5><i class="fa fa-envelope-o" aria-hidden="true"></i> <?php echo $email; ?></h5>
            <h5><i class="fa fa-sign-in" aria-hidden="true"></i> <?php echo $last_login; ?></h5>
        </div>
    </div>
</div>