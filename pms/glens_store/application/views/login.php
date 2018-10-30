<br>
<br>

<div class="col-lg-4 col-lg-offset-4">
    <h2>Welcome Back!</h2>
    <h5>Please Login.</h5>
    <?php $fattr = array('class' => 'form-signin');
         echo form_open(site_url().'shop/login/', $fattr); ?>
    <div class="form-group">
      <?php echo form_input(array(
          'name'=>'email', 
          'id'=> 'email', 
          'placeholder'=>'Email', 
          'class'=>'form-control', 
          'value'=> set_value('email'))); ?>
      <?php echo form_error('email') ?>
    </div>
    <div class="form-group">
      <?php echo form_password(array(
          'name'=>'password', 
          'id'=> 'password', 
          'placeholder'=>'Password', 
          'class'=>'form-control', 
          'value'=> set_value('password'))); ?>
      <?php echo form_error('password') ?>
    </div>
    <?php if($recaptcha == 'yes'){ ?>
    <div style="text-align:center;" class="form-group">
        <div style="display: inline-block;"><?php echo $this->recaptcha->render(); ?></div>
    </div>
    <?php
    }
    echo form_submit(array('value'=>'Let me in!', 'class'=>'btn btn-lg btn-primary btn-block')); ?>
    <?php echo form_close(); ?>
    <br>
    <button onclick='document.location="<?= site_url('shop') ?>"' class="btn btn-lg btn-primary btn-block" >Home</button>
    <hr>
    <p>Not registered? <a href="<?php echo site_url();?>shop/register">Register</a></p>
    <p>Forgot your password? <a href="<?php echo site_url();?>shop/forgot">Forgot Password</a></p>
</div>