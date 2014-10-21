<link rel="stylesheet" href="<?=SITE_PATH?>css/glasscase.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?=SITE_PATH?>css/quick.css" rel="stylesheet" type="text/css" />
<script src="<?=SITE_PATH?>js/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="<?=SITE_PATH?>js/jquery.glasscase.min.js" type="text/javascript"></script>
<script type="text/javascript">
        $(function () {
            //Demo 1
            $("#girlstop").glassCase({'thumbsPosition': 'bottom', 'widthDisplay': '300', 'heightDisplay': '450'});
        });
    </script>
<?php
$prod=$cms->db_query("select * from #_products_user where pid='".$items[2]."' ");
$res=$cms->db_fetch_array($prod); 
?>
<div class="main_quick_view">
  <div class="wrap_quick_view">
    <div class="area_quick_view">
      <div class="area_quick_view_left">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-7">
                <ul id='girlstop' class='fz-start'><?php 
                  $cms->zoomImg($res[image1],$res[title]);
				  $cms->zoomImg($res[image2],$res[title]);
				  $cms->zoomImg($res[image3],$res[title]);
				  $cms->zoomImg($res[image4],$res[title]); ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="area_quick_view_right">
        <h2><?=$res['title']?></h2>
        <small> <?php $ms = $cms->checkoffer($items[2],$items[3]);?>
		<?php
			  if(count($ms)){
				foreach($ms as $val){?>
				 <p style="background:url(<?=SITE_PATH_M?>domain/images/tickmark.png) left top no-repeat; line-height:20px; padding-left:20px; font-size:11px; ">
                <?=$val?>
              </p><?php
				}
			  }
			  ?>	  
        <div class="area_quick_view_right1">
          <div class="area_quick_view_right1_left">
            <div class="view1_2">
			
              <p style="background:url(<?=SITE_PATH_M?>domain/images/tickmark.png) left top no-repeat; line-height:20px; padding-left:20px; font-size:11px;<?=($res[kf1]=="")?'display:none':''?>">
                <?=str_replace('_x000D_','',$cms->removeSlash($res[kf1]))?>
              </p>
              <p style="background:url(<?=SITE_PATH_M?>domain/images/tickmark.png) left top no-repeat; line-height:20px; padding-left:20px; font-size:11px;<?=($res[kf2]=="")?'display:none':''?>">
                <?=str_replace('_x000D_','',$cms->removeSlash($res[kf2]))?>
              </p>
              <p style="background:url(<?=SITE_PATH_M?>domain/images/tickmark.png)  left top no-repeat; line-height:20px; padding-left:20px; font-size:11px;<?=($res[kf3]=="")?'display:none':''?>">
                <?=str_replace('_x000D_','',$cms->removeSlash($res[kf3]))?>
              </p>
            </div>
          </div>
          <div class="area_quick_view_right1_right"> </div>
        </div>
        <div class="area_quick_view_right1">
          <div class="area_quick_view_right1_left pad_top">
             <samp class="sizesuccesshide">
			 <div style="clear:both"></div>
            <?php  $price = $cms->getBothPrice($res['pid'],$current_store_user_id); 
		    ?>
            <p>Price:
              <?php  if($price[1]>0 && $price[1]< $price[0]){ ?>
              <span  style="text-decoration:line-through; padding-right:10px; color:#FF0000">
              <?=$cms->price_format($price[0])?>
              </span>
              <?php } 
			   $cost = $price[0];
				 if($price[1]>0 && $price[1]< $price[0]){
					$cost = $price[1];
				 }?>
              <span>
              <?=$cms->price_format($cost)?>
              </span> <br />
            </p>
			</samp>
			<samp class="sizesuccess"> </samp> 
			Qty: <input type="text"  value="1"  class="tex-field" style="width: 50px;" id="cartQty" name="qty">
          </div>
		  <p style="color:#CC3333"> <span class="cartsuccess1">	  </span></p>
          <div class="area_quick_view_right1_right pad_top">
            <div class="color_boxes_maindiv">
			
			</div> 
				  <?php $clr = @explode(',', $res[color]); 
				$k=1; 
			 if(count($clr)>1){   ?>
				<div class="color_boxes_maindiv"><span class="size_selection-color">Select Your Colour :</span> 
					<?php	
					foreach($clr as $val){ 
					$clrcode = $cms->getSingleresult("select colorcode from #_color where name = '$val' and store_user_id = '$current_store_user_id'");  ?> 
				   <div class="color_boxes">
					<input type="radio" id="checkbox-1-<?=$k?>" name="pcolor" value="<?=$clrcode?>" class="regular-checkbox<?=$k?>" />
					<label for="checkbox-1-<?=$k?>" class="checkbox-1-<?=$k?>"></label>
					<?php //include("color_css.php"); ?>
				 </div>
				<?php $k++;  }  ?> 
				</div>
			<?php } ?>

			<?php $prod_price =$cms->db_query("SELECT dsize FROM #_product_price WHERE  proid ='".$items[2]."' ");
			      mysql_num_rows($prod_price);
					if(mysql_num_rows($prod_price)){ ?>
						 <div class="qty_boxes_maindiv pad_top"><span class="size_selection-color">Select Your Option :</span>
						  <div class="qty_boxes">
							<?php 
						    $i = 1;
							while($pro_p=$cms->db_fetch_array($prod_price)){ 
								?> 
								<div class="qty_commondiv"><input type="radio" <?=($i==1)?'checked':''?>   class="qty_commondiv1" name="size" value="<?=$pro_p[dsize]?>" alt="<?=$res[pid]?>" title="<?=$m?>" />
								<label for="checkbox-1-1" class="qty_commondiv_label"><?=$pro_p[dsize]?></label></div> 
								<?php
							$i++;
							 } ?>
						  </div> 
						</div>
			<?php } ?> 
        </div>
 
        <div class="area_quick_view_right1">
        	<div class="area_quick_view_right1_left">
            <?php if($price[0]!=0){ ?>	<input type="button" style="width:auto;background-color: #B163A3 !important;border-radius: 5px;padding: 5px;" id="addtocart" class="button addtocart" value="Add To Cart" alt="<?=$items[2]?>" > <?php } ?>
            </div>
            <div class="area_quick_view_right1_right"></div>
        </div>
        <div class="area_quick_view_right1"></div>
        <div class="area_quick_view_right1"></div>
      </div>
    </div>
  </div>
</div>
<script>

$(".qty_commondiv1").click(function() {
     var size =$(this).val(); 
	 var getpid = $(this).attr('alt');    
	// var val = $(this).attr('title');
	$.ajax({
	    url : "<?=SITE_PATH?>ms_file/change_price_ajaxd/?proid="+getpid+"&dsize="+size, 
	    success: function(data, textStatus, jqXHR){  
	    //alert('lknklnlk');
	       $(".sizesuccesshide").hide();
	       	$(".sizesuccess").html(data);  
	    },
	    error: function (jqXHR, textStatus, errorThrown){
	 		alert(errorThrown);
	    }
	});
});

$(".addtocart").click(function(){
	var getpid    = $(this).attr('alt');  
    var namecolor = $('input:radio[name=pcolor]:checked').val();
	if(!namecolor) { namecolor  = 0;}
    var size      = $('input:radio[name=size]:checked').val(); 
	if(!size) { size  = 0;} 
	$.ajax({
	    url : "<?=SITE_PATH?>ms_file/addtocart/?prod_id="+getpid+"&dsize="+size+"&color="+namecolor, 
	    success: function(data, textStatus, jqXHR){  
			$(function(){  
				window.parent.$(" #cart").load(" #cart");
				 });  
		        /* $(function(){ $(" #cd-cart").load(" #cd-cart");  });   */
	        	$(".cartsuccess1").html(data);  
				 setTimeout(function(){
				 parent.$.colorbox.close(); return false;
				}, 2000); 
				
				// parent.location.reload();
 	            // window.top.location.href = '<?=$_GET[parent]?>';
				//$("#addtocart"+getpid).hide(); 
	    },
	    error: function (jqXHR, textStatus, errorThrown){
	 		alert(errorThrown);
	    }
	});
});
</script>



