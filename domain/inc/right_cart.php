 
 <div id="cd-shadow-layer"></div>
 <span id="cd-cart-trigger_id2">
<?php 

$check=$cms->db_query("select * from #_cart where  ssid = '".session_id()."' and store_user_id='$current_store_user_id' ");
	   if(mysql_num_rows($check)){ 
	    if($_SESSION['crtmsg']!=""){
		 $_SESSION['crtmsg'];    unset($_SESSION['crtmsg']); 
		}?>
	<div id="cd-cart" class="rightside_sideshow">
		<h2>Cart</h2>
		<ul class="cd-cart-items">
		<?php 
		$total  = 0; 
		while($res = $cms->db_fetch_array($check))
						{
						 @extract($res);
						// $pprice = $cms->getPriceSize($proid,$current_store_user_id,$dzise);  
						  $pprice=$price;
						 $total = $total+($qty*$pprice);  
						?>
			<li>
				<span class="cd-qty"><?=$qty?></span> <a href="<?=$urls?>"><?=$cms->getSingleresult("select title from #_products_user where pid='".$proid."' ")?><?php
				if($dsize){?>(<?=$dsize?>) <?php } ?></a>
				<div class="cd-price"><?=$cms->price_format($pprice)?>/-</div>
				<a href="#0" class="cd-item-remove cd-img-replace Delcartp" alt="<?=$proid?>" title="<?=$dsize?>">Remove</a>
			</li>
    <?php } ?> 
		</ul> 
		<div class="cd-cart-total"><?php 
			  $ssid=session_id(); 
             $cartArr=$cms->getOfferProduct($ssid,$current_store_user_id);
			 if($cartArr[comboSavng]) echo "<p>Combo Saving ".$cms->price_format($cartArr[totalCost])."</p>";
		if($cartArr[periodSaving]) echo "<p>Period Offer Saving ".$cms->price_format($cartArr[periodSaving])."</p>";
		 
		if($cartArr[overAlldiscount]) echo "<p>Discount On Overall Purchase ".$cms->price_format($cartArr[overAlldiscount])."</p>";
		$tottalsave = $cartArr[comboSavng]+$cartArr[periodSaving]+$cartArr[hotdealSaving]+$cartArr[overAlldiscount]+$total_dis_amount;
		
		?><p>Shipping Charge :<?=($cms->price_format($cartArr[allshipping]))?$cms->price_format($cartArr[allshipping]):'0'?>/- </p>
           <p><b>Total Discount :<?=$cms->price_format($tottalsave)?> </b></p>
			<p>Total <span><?=$cms->price_format($total)?>/-</span></p>
			<p>Net Pay <span><?=$cms->price_format($cartArr[paynet])?>/-</span></p>
		</div>  
		<a href="#modal" name="checkout" id="sign" class="checkout-btn checkout_cls checkout_kart">Checkout</a>

		<p class="cd-go-to-cart"><a href="<?=SITE_PATH.'cart'?>">Go to cart page</a></p>
		<?php } ?>
	</div>
	
 </span>