<?php
defined('BASEPATH') OR exit('');
?>

<!DOCTYPE HTML>
<html>
    <head>
         <script src="<?=base_url()?>public2/js/jquery.min.js"></script>
    </head>

    <body>

        //////////////////          MAIN          /////////////////////
        

        <div class="container-fluid hidden-print">
            <div class="row content">
                <!-- Main content -->
                <div class="col-sm-12">
                    <?= isset($pageContent) ? $pageContent : "" ?>
                </div>
                <!-- Main content ends -->
            </div>
        </div>


    </body>
</html>
