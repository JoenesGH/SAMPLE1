<div class="container">
<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <h2>Settings</h2>
        <h5>Hello <span><?php echo $first_name; ?></span>.</h5>
        <hr>
        <?php
        $fattr = array('class' => 'form-signin');
        echo form_open(site_url().'shop/settings/', $fattr); 
        
        function tz_list() {
            $zones_array = array();
            $timestamp = time();
            foreach(timezone_identifiers_list() as $key => $zone) {
              date_default_timezone_set($zone);
              $zones_array[$key]['zone'] = $zone;
            }
            return $zones_array;
        }
        ?>
        
        <?php echo '<input type="hidden" name="id" value="'.$id.'">'; ?>
        <div class="form-group">
        <span>Site Title</span>
          <?php echo form_input(array('name'=>'site_title', 'id'=> 'site_title', 'placeholder'=>'Site Title', 'class'=>'form-control', 'value' => set_value('site_title', $site_title))); ?>
          <?php echo form_error('site_title');?>
        </div>
        
        <div class="form-group">
        <span>Timezone</span>
        <select name="timezone" id="timezone" class="form-control">
            <option value="<?php echo $timezonevalue; ?>"><?php echo $timezone; ?></option>
          <?php foreach(tz_list() as $t) { ?>
            <option value="<?php echo $t['zone']; ?>"> <?php echo $t['zone']; ?></option>
          <?php } ?>
        </select>
        </div>
        
        <div class="form-group">
        <span>Recaptcha</span>
        <select name="recaptcha" id="recaptcha" class="form-control">
            <option value="no">No</option>
            <option value="yes">Yes</option>
        </select>
        </div>
        <?php echo form_submit(array('value'=>'Save', 'name'=>'submit', 'class'=>'btn btn-primary btn-block')); ?>
        <?php echo form_close(); ?>
    </div>
</div>
</div>