<?php
defined('BASEPATH') OR exit('');
?>

<hr>
<hr>

<div class="panel panel-primary">
    <div class="panel-heading text-center">MY ACCOUNTS</div>
    <?php if($allAdministrators):?>
    <div class="table table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>FULL NAME</th>
                    <th>E-MAIL</th>
                    <th>MOBILE</th>
                    <th>WORK</th>
                    <th>ROLE</th>
                    <th>DATE CREATED</th>
                    <th>LAST LOG IN</th>
                    <th class="text-center">EDIT</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($allAdministrators as $get):?>
                    <tr>
                        <td class="adminName"><?=$get->first_name ." ". $get->last_name?></td>
                        <td class="hidden firstName"><?=$get->first_name?></td>
                        <td class="hidden lastName"><?=$get->last_name?></td>
                        <td class="adminEmail"><?=mailto($get->email)?></td>
                        <td class="adminMobile1"><?=$get->mobile1?></td>
                        <td class="adminMobile2"><?=$get->mobile2?></td>
                        <td class="adminRole"><?=ucfirst($get->role)?></td>
                        <td><?=date('jS M, Y h:i:sa', strtotime($get->created_on))?></td>
                        <td>
                            <?=$get->last_login === "0000-00-00 00:00:00" ? "---" : date('jS M, Y h:i:sa', strtotime($get->last_login))?>
                        </td>
                        <td class="text-center editAdmin text-primary"  id="edit-<?=$get->id?>">
                            <i class="fa fa-pencil pointer"></i>
                        </td>
                    </tr>
                    <?php ?>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
    <?php else:?>
 <!--    No Administrative Accounts -->
    <?php endif; ?>
</div>

<hr>
<hr>
