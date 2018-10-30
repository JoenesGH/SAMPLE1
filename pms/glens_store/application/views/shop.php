<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $title = "PRODUCTS"; ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php echo "$title";?> | PointUP PharmaStore</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?=base_url()?>public/img/logoup.png">
    <?php include('includes/css.php');?>
  </head>
  <body>
    
<!--  branding area --> 
    <?php include('includes/branding.php');?>
<!-- End site branding area -->  
 
<!-- navbar header -->
    <?php include('includes/navbar_header.php');?>
<!-- end navbar header -->

    <div class="container" style="margin-top:7px;">
    <div class="row">
      <div class="col-sm-3">
        <div class="form-group">
          <input type="text" name="searchFor" placeholder="Search..." class="" id="searchKey" onchange="sendRequest();">
        </div>
      </div>

      <div class="col-sm-3 hidden">
        <div class="form-group">
          <select class="form-control" id="limitRows" onchange="sendRequest();">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
          </select>
        </div>
      </div>
    </div>

    
   <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
            <?php 
                foreach ($allitems as $key => $items) {
                    ?>
                <div class="col-md-3 col-sm-6">
                    <div class="single-shop-product">
                         <div class="product-upper">
                           <img class="image<?=$items->id;?>" rel="<?=$items->image;?>" src="<?php echo "http://localhost/pms/glens_system"; ?>/images/<?=$items->image;?>" alt="<?=$items->id;?>">
                        </div>
                        <div class="hidden code-label code<?=$items->id;?>" rel="<?=$items->code;?>"><?=$items->code;?></div>
                        <h2 class="name<?=$items->id;?>" rel="<?=$items->id;?>"><?=$items->name;?></h2>
                        <div class="product-carousel-price">
                            Php <ins class="price-label price<?=$items->id;?>" rel="<?=$items->unitPrice;?>"><?=$items->unitPrice;?></ins>
                        </div> 
                        <div class="product-carousel-price">
                            Avail Qty <ins class="aqty-label aqty<?=$items->id;?>" rel="<?=$items->quantity;?>"><?=$items->quantity;?></ins>
                        </div> 
                        <div>
                          <span class="prescription-label hidden prescription<?=$items->id;?>" rel="<?=$items->prescription;?>"></span>
                        </div>
                        <div class="product-option-shop">
                            <a class="add_to_cart_button" data-quantity="1" data-product_sku="" data-product_id="70" rel="nofollow" onclick="javascript:addtocart(<?=$items->id;?>)"><i class="fa fa-shopping-cart"></i> Add to Cart</a>
                        </div>
                        <div  style="margin-top:7px;">
                        <span id="result-<?=$items->id;?>"></span>  
                        </div>              
                    </div>
                </div>
            <?php }
            ?>          
           </div>

        </div>
    </div>
    <div class="text-center">
    <?php echo $pagination; ?>
    </div>
  </div>  

<br>

<!-- footer top area -->
    <?php include('includes/footer_top.php');?>
<!-- end footer top area -->

<!-- footer -->
    <?php include('includes/footer.php');?>
<!-- end footer -->
   
<!-- script -->
    <?php include('includes/script.php');?>
<!-- script -->

    <script type="text/javascript">
    function addtocart(p_id)
    {
        var price = $('.price'+p_id).attr('rel');
        var aqty = $('.aqty'+p_id).attr('rel');
        var prescription = $('.prescription'+p_id).attr('rel');
        var image = $('.image'+p_id).attr('rel');
        var name  = $('.name'+p_id).text();
        var code  = $('.code'+p_id).text();
        var id    = $('.name'+p_id).attr('rel');
     
            $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('Shop/add');?>",
                    data: "id="+id+"&image="+image+"&name="+name+"&code="+code+"&price="+price+"&aqty="+aqty+"&prescription="+prescription,
                    success: function (response) {
                       $(".product-count").text(response);

                  $('#result-'+id+'').html("<div class='alert alert-success alert-dismissible'><i class='icon fa fa-check'></i> Successfully Add</div>");
                    setTimeout(function(){
                  $('#result-'+id+'').html('');
                  },2000);             

                    }
                });
    }


  function MyCart()
  {
      $.ajax({
                  type: "POST",
                  url: "<?php echo site_url('Shop/MyCart');?>",
                  data: "",
                  success: function (response) {
                  $(".displaycontent").html(response);
                  }
              });
  }

</script>



<script type="text/javascript">
    var sendRequest = function(){
      var searchKey = $('#searchKey').val();
      var limitRows = $('#limitRows').val();
      window.location.href = '<?=base_url('shop/index')?>?query='+searchKey+'&limitRows='+limitRows+'&orderField='+curOrderField+'&orderDirection='+curOrderDirection;
    }


    var getNamedParameter = function (key) {
            if (key == undefined) return false;

            var url = window.location.href;
            //console.log(url);
            var path_arr = url.split('?');
            if (path_arr.length === 1) {
                return null;
            }
            path_arr = path_arr[1].split('&');
            path_arr = remove_value(path_arr, "");
            var value = undefined;
            for (var i = 0; i < path_arr.length; i++) {
                var keyValue = path_arr[i].split('=');
                if (keyValue[0] == key) {
                    value = keyValue[1];
                    break;
                }
            }

            return value;
        };


        var remove_value = function (value, remove) {
            if (value.indexOf(remove) > -1) {
                value.splice(value.indexOf(remove), 1);
                remove_value(value, remove);
            }
            return value;
        };


        var curOrderField, curOrderDirection;
        $('[data-action="sort"]').on('click', function(e){
          curOrderField = $(this).data('title');
          curOrderDirection = $(this).data('direction');
          sendRequest();
        });


        $('#searchKey').val(decodeURIComponent(getNamedParameter('query')||""));
        $('#limitRows option[value="'+getNamedParameter('limitRows')+'"]').attr('selected', true);

        var curOrderField = getNamedParameter('orderField')||"";
        var curOrderDirection = getNamedParameter('orderDirection')||"";
        var currentSort = $('[data-action="sort"][data-title="'+getNamedParameter('orderField')+'"]');
        if(curOrderDirection=="ASC"){
          currentSort.attr('data-direction', "DESC").find('i.glyphicon').removeClass('glyphicon-triangle-bottom').addClass('glyphicon-triangle-top'); 
        }else{
          currentSort.attr('data-direction', "ASC").find('i.glyphicon').removeClass('glyphicon-triangle-top').addClass('glyphicon-triangle-bottom');  
        }

  </script>


  </body>
</html>