 <?php
   extract($_GET); 
   $cms->db_query("delete from #_cart where id = '".$id."' ");
   if($_SESSION['crtmsg']) echo $_SESSION['crtmsg']; unset($_SESSION['crtmsg']);
 
   $ssid=session_id(); 
    $cartArr=$cms->getOfferProduct($ssid,$current_store_user_id);  
   //echo "Preview: <br/><pre>"; print_r($cartArr);echo "</pre><br/>";
   $check=$cms->db_query("select * from #_cart where  ssid = '".session_id()."' ");
	   if(mysql_num_rows($check)){ 
	    if($_SESSION['crtmsg']!=""){
		 $_SESSION['crtmsg'];    unset($_SESSION['crtmsg']); 
		}?>
  
   <h2>Items In Your Cart For Shipping Area <?=$_SESSION[pincode]?></h2>
 
  <div class="cart_main_div">
  
  <table width="100%" border="0" class="CSSTableGenerator">
  
  <tr>
    <th align="left" width="30%" >Product</th>
    <th align="left" width="10%">Quantity</th>
	<th align="left" width="15%">Orginal Price</th>
    <th align="left">Amount</th>
	<th align="left" width="10%">Shipping</th>
    <th align="left" width="6%">Color</th>
    <th align="left" width="6%">Dimension</th>
    
    <th align="left" width="5%">Action</th>
  </tr>
  
  <?php 
	$total  = 0; 
	while($res = $cms->db_fetch_array($check)){ @extract($res);
		$pprice = $cms->getPriceSize($proid,$current_store_user_id,$dsize);
		$total = $total+($qty*$pprice);  ?>
		<tr><td>
         <?=$cat_id?><a href="<?=$urls?>"><?=$cms->getSingleresult("select title from #_products_user where pid='".$proid."' ")?></a>   
		<span><?=$cms->getSingleresult("select pcode from #_products_user where pid='".$proid."' "); 
		$img = $cms->getSingleresult("select image1 from #_products_user where pid='".$proid."' ");
		?></span><img style="display:none" src="<?=$cms->getImageSrc($img)?>" width="80" height="72"  alt="" align="right"/> </td>
		<td><input name="iid[]" id="quantity" value="<?=$id?>" type="hidden"/>
		<input name="qty[]" id="quantity" value="<?=$qty?>" type="text" size="3" class="quantity-field2 qty"/></td>
		<td><?php $pr = $cms->getBothPriceSize($proid,$current_store_user_id,$dsize); echo $cms->price_format($pr[0])?> </td>
		<td><?=$cms->price_format($qty*$pprice)?><?php if($qty>1)echo " ($qty * $pprice)"; ?>   </td>

		<td>Rs.<?php echo $shipCharge =  $cms->getShippingProd($proid,$current_store_user_id,$qty); ?>  
		
		<?php if($qty>1) echo " ($qty * $shipCharge)"; ?>   </td>

		<td><?php if($color){?><span id="clr" style="background-color:#<?=$color?>; width:20px; height:20px; display:block; 
        margin:0 auto; border-radius:3px; box-shadow:inset 0 0 2px #666;"></span><?php }else{ ?> <span>NA </span><?php }?> </td>
		<td><?php if($dsize){ ?><?=$dsize?> <?php }else{ ?><span> NA </span><?php } ?></td>
		
		<td><span >
		 <img alt="<?=$id?>" class="Delcartp" title="<?=$dsize?>" src="<?=SITE_PATH?>images/delete-icon.png" height="16" width="16" /> 
        </span>    </td>
		</tr><?php
			$total_dis_amount=$total_dis_amount+$diss[discount_amount];
		}
		$_SESSION['total'] = $total;
		$link  = SITE_PATH;  
		//echo"<pre>";print_r($cartArr);	echo"</pre>";			 
	?>
    <tr><td colspan="8"><div class="cart_main_div2_3">Total Price :<?=$cms->price_format($cartArr[totalCost])?> </div>
	  <div class="cart_main_div2_3"><?php 
		if($cartArr[comboSavng]) echo "<p>Combo Saving ".$cms->price_format($cartArr[totalCost])."</p>";
		if($cartArr[periodSaving]) echo "<p>Period Offer Saving ".$cms->price_format($cartArr[periodSaving])."</p>";
		 
		if($cartArr[overAlldiscount]) echo "<p>Discount On Overall Purchase ".$cms->price_format($cartArr[overAlldiscount])."</p>";
		$tottalsave = $cartArr[comboSavng]+$cartArr[periodSaving]+$cartArr[hotdealSaving]+$cartArr[overAlldiscount]+$total_dis_amount;
		//echo "<p>Over All Saving ".$cms->price_format($tottalsave)."</p>";
	  ?>
	   </div>
	   <div class="cart_main_div2_3">Shipping Charge :<?=($cms->price_format($cartArr[allshipping]))?$cms->price_format($cartArr[allshipping]):'0'?>
	   <?php if($cartArr[extraShipCharge]){?>
	   (Rs. <?=$cartArr[extraShipCharge]?> Extra for <?=$_SESSION[pincode]?> area ) 
	    <?php } ?>
	   </div>
      <div class="cart_main_div2_4"><b>Total Discount :<?=($cms->price_format($tottalsave))?$cms->price_format($tottalsave):'0'?> </b></div></td></tr>
 </table> 
     
     
</div>
<div class="cart-main_page_button">

  <div class="cart-main_page_button-left">
  <a href="<?=$link?>" style="text-decoration:none">
    <input type="button" name="continue" id="continue_shop" value="Continue Shopping" class="continue_shop-cls mem_login " /></a>
	<input type="submit" name="update" value="Update Shopping" class="continue_shop-cls mem_login" />
	
  </div>
  
  <div class="cart-main_page_button-right">
    <div class="cart-main_page_button-right_paidamt">Total Amount to Paid = <span><?=$cms->price_format($cartArr[paynet])?></span> 
	<?php
	$shipFreeAmount = $cms->getSingleresult("select shipFreeAmount from fz_shipping where store_user_id = '$current_store_user_id'");
     if($shipFreeAmount){
	  ?>
     <p><span>Free Shipping on shop Rs. <?=$shipFreeAmount?> </span></p> <?php }?>
    </div>
	    <a  href="<?=SITE_PATH?>checkout" name="checkout" id="sign" class="checkout_cls">Proceed to Checkout</a>   
	  <!-- <input type="button" name="submit" id="checkout" value="Proceed to Checkout" class="checkout_cls" /> -->	 
 	<?php
		}else{?>
		  <div class="no_product-incart" align="center">
          <p>Your Shopping cart is empty<?php  $url=$cms->geturl();$new_url = str_replace("cart","",$url);?></p>
        <a href="<?=$new_url?>" style="text-decoration:none"> <button type="button" name="continue_shop-cart" id="continue_shop-cart" class="continue_shop-cls mem_login">Start your Shopping</button></a>
          </div>
		<?php
		} ?>
  </div>
  
</div>
<div id="modal" style="display:none;" class="modal-example-content" <?php if($_SESSION[userid]) echo 'style="display:none"';?>>
        <div class="modal-example-header" >
            <button type="button" class="close" onclick="$.fn.custombox('close');">&times;</button>
            <h4>Please Login first</h4>
        </div>  
        <div class="modal-example-body">
            <div><a href="<?=SITE_PATH."checkout"?>?type=guest">Login as a Guest</a></div>
            <div><a href="<?=SITE_PATH."user-login"?>">Login as a User</a></div>
        </div>
    </div>
    </div>
 