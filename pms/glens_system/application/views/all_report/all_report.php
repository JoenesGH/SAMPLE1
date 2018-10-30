<?php
defined('BASEPATH') OR exit('');
$current_items = [];
if(isset($items) && !empty($items)){    
    foreach($items as $get){
        $current_items[$get->code] = $get->name;
    }
}
?>
<style href="<?=base_url('public/ext/datetimepicker/bootstrap-datepicker.min.css')?>" rel="stylesheet"></style>

<script>
    var currentItems = <?=json_encode($current_items)?>;
</script>

<div class="row latestStuffs">
    <div class="col-sm-6">
        <div class="panel panel-info">
            <div class="panel-body latestStuffsBody" style="background-color: #777">
                <div class="pull-left"><i class="fa fa-exchange"></i></div>
                <div class="pull-right">
                    <div>SALES</span></div>
                    <div class="latestStuffsText">Customer Transaction</div>
                </div>
            </div>
          <div class="panel-footer text-center"  data-toggle='modal' data-target='#reportModal' style="color:#777"><b>Generate</b></div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-info">
            <div class="panel-body latestStuffsBody" style="background-color: #777">
                <div class="pull-left"><i class="ion-ios-medkit-outline"></i></div>
                <div class="pull-right">
                    <div>ALL Stock</div>
                    <div class="latestStuffsText pull-right">Stock Reports</div>
                </div>
            </div>
            <div class="panel-footer text-center" id='ClickToGenerateStock'  style="color:#777"><b>Generate</b></div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="panel panel-info">
            <div class="panel-body latestStuffsBody" style="background-color: #777">
                <div class="pull-left"><i class="ion-android-people"></i></div>
                <div class="pull-right">
                    <div>Top Customer</div>
                    <div class="latestStuffsText pull-right">Promo</div>
                </div>
            </div>
            <div class="panel-footer text-center" onclick='document.location="<?= site_url('Sms_notifs') ?>"'  style="color:#777"><b>Generate</b></div>
        </div>
    </div>

     <div class="col-sm-6">
        <div class="panel panel-info">
            <div class="panel-body latestStuffsBody" style="background-color: #777">
                <div class="pull-left"><i class="ion-android-people"></i></div>
                <div class="pull-right">
                    <div>Canceled Order</div>
                    <div class="latestStuffsText pull-right">ALL canceled Order</div>
                </div>
            </div>
            <div class="panel-footer text-center" id='ClickToGeneratecancelorder'  style="color:#777"><b>Generate</b></div>
        </div>
    </div>


<div class="modal fade" id='reportModal' data-backdrop='static' role='dialog'>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="close" data-dismiss='modal'>&times;</div>
                <h4 class="text-center">Invoice Report</h4>
            </div>           
            <div class="modal-body">
                <div class="row" id="datePair">
                    <div class="col-sm-6 form-group-sm">
                        <label class="control-label">From Date</label>                                    
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span><i class="ion-android-calendar"></i></span>
                            </div>
                            <input type="text" id='transFrom' class="form-control date start" placeholder="YYYY-MM-DD">
                        </div>
                        <span class="help-block errMsg" id='transFromErr'></span>
                    </div>

                    <div class="col-sm-6 form-group-sm">
                        <label class="control-label">To Date</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span><i class="ion-android-calendar"></i></span>
                            </div>
                            <input type="text" id='transTo' class="form-control date end" placeholder="YYYY-MM-DD">
                        </div>
                        <span class="help-block errMsg" id='transToErr'></span>
                    </div>
                </div>
            </div>            
            <div class="modal-footer">
                <button class="btn btn-success" id='clickToGen'>Generate</button>
                <button class="btn btn-danger" data-dismiss='modal'>Close</button>
            </div>
        </div>
    </div>
</div>




<script src="<?=base_url()?>public/js/all_reports.js"></script>
<script src="<?=base_url('public/ext/datetimepicker/bootstrap-datepicker.min.js')?>"></script>
<script src="<?=base_url('public/ext/datetimepicker/jquery.timepicker.min.js')?>"></script>
<script src="<?=base_url()?>public/ext/datetimepicker/datepair.min.js"></script>
<script src="<?=base_url()?>public/ext/datetimepicker/jquery.datepair.min.js"></script>










