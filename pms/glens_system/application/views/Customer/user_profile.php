<?php
$user_id=$this->session->userdata('user_id');
if(!$user_id){
  redirect('Customer/login_view');
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Customer</title>
    <link rel="stylesheet" href="<?=base_url()?>public/bootstrap/css/bootstrap.min.css">
  </head>
  <body>

<div class="container">
  <div class="row">
    <div class="col-md-4">

      <table class="table table-bordered table-striped">


        <tr>
          <th colspan="2"><h4 class="text-center">User Info</h3></th>

        </tr>
          <tr>
            <td>User Name</td>
            <td><?php echo $this->session->userdata('user_name'); ?></td>
          </tr>
          <tr>
            <td>User Email</td>
            <td><?php echo $this->session->userdata('user_email');  ?></td>
          </tr>
          <tr>
            <td>User Age</td>
            <td><?php echo $this->session->userdata('user_age');  ?></td>
          </tr>
          <tr>
            <td>User Mobile</td>
            <td><?php echo $this->session->userdata('user_mobile');  ?></td>
          </tr>
      </table>


    </div>
  </div>
<a href="<?php echo base_url('customer/user_logout');?>" >  <button type="button" class="btn-primary">Logout</button></a>
<a href="<?php echo base_url('store/');?>" >  <button type="button" class="btn-primary">Continue to ShOP..</button></a>
<a href="<?php echo base_url('store/billing_view');?>" >  <button type="button" class="btn-primary">Cart</button></a>
<a href="<?php echo base_url('');?>" >  <button type="button" class="btn-primary">My Order</button></a>
</div>
  </body>
</html>
