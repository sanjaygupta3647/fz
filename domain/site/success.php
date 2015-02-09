<?php   
if((!$_SESSION[userid]) and ($_GET[type]!='guest')){ 
$redpath = SITE_PATH."login";
$cms->redir($redpath,true);die;
}    
$ShippingDay1 = $cms->getSingleresult("select day1 from #_shipping_area_store where pincode='".$_SESSION[pincode]."' and store_user_id = '".$current_store_user_id."' and status = 'Active'");
$ShippingDay2 = $cms->getSingleresult("select day2 from #_shipping_area_store where pincode='".$_SESSION[pincode]."' and  store_user_id = '".$current_store_user_id."' and status = 'Active'");
 if($cms->is_post_back()){  
       $cms->db_query("delete from #_cart where `ssid`='".session_id()."' "); 
	   $redpath = SITE_PATH."index";
	    session_destroy();
	   $cms->redir($redpath,true);die;  
		}
$orderid=$_SESSION['orderid'];	 
$orderid = $cms->getSingleresult("select orderid from #_order_summary where `ssid`='".session_id()."' ORDER BY pid DESC limit 1");
$rsAdmin2=$cms->db_query("select * from #_shipping_address where orderid='$orderid'");
$result=$cms->db_fetch_array($rsAdmin2);
extract($result); 
$sql = " select * from  #_order_summary where uid = '".$pid."'";
$query = $cms->db_query($sql);
$res =$cms->db_fetch_array($query);
?>
<?=$er?>
<div class="success_order">
<h2 class="order-confirmh2">Order Confirmation !</h2>
<div class="success_order_div">
<div class="order_confirmed">
<div class="order_confirmed_left">
<h2>Successfully Confirmed</h2>
<p>Dear User Your Order has been Confirmed. It will be Delivered in <?=$cms->calShippTime($current_store_user_id,$_SESSION[pincode])?>.</p>
</div>
<div class="order_confirmed_right">
<div class="order_confirmed_right_title"><h2>User Information</h2><span class="black_arrow"></span></div>
<div class="usr_info_text">
<p>Name   <span>:<?=$name?> </span></p>
<p>Email  <span>:<?=$email?></span></p>
<p>Mobile <span>: +91<?=$mob?></span></p>
</div>
</div>
</div>
<div class="order_summary">
<h2>Your Order Id is : <?=$orderid?></h2>
<span>Track Your Order with the help of your transaction id</span>
<div class="order_summary_tablediv">
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <thead>
  
    <th width="5%" align="left" valign="top">S.no.</th>
    <th width="12%" align="left" valign="top">Product</th>
    <th width="27%" align="left" valign="top">Name</th>
    <th width="13%" align="left" valign="top">Price</th>
    <th width="14%" align="left" valign="top">Status</th>
    <th width="14%" align="left" valign="top">Quantity</th>
    <th width="15%" align="left" valign="top">Total</th>
  <tr>
  <?php if($orderid){  
  $check=$cms->db_query("SELECT * FROM #_orders_detail WHERE orderid ='$orderid'"); 
		if(mysql_num_rows($check)){ 
		$total  = 0;
		    $i=1;
			while($res2 = $cms->db_fetch_array($check)){
				extract($res2); 
				$total = $total+($qty*$amount);
				$img = $cms->getSingleresult("select image1 from #_products_user where pid='".$proid."' ");
				$title = $cms->getSingleresult("select title from #_products_user where pid='".$proid."' ");
				$status = $cms->getSingleresult("select status from #_order_summary where uid = '".$_SESSION[userid]."'"); 
		?>
    <td align="center" valign="top"><?=$i?></td>
    <td align="center" valign="top"><img src="<?=$cms->getImageSrc($img)?>" width="95" height="40"  alt=""/></td>
    <td align="left"   valign="center"><?=$title?> </td>
    <td align="center" valign="top"><?=$amount?></td>
    <td align="center" valign="top"><?=$status?></td>
    <td align="center" valign="top"><?=$qty?></td>
    <td align="center" valign="top"><?=$cms->price_format($qty*$amount)?><?php if($qty>1)echo " ($qty * $amount)"; ?></td>
  </tr>  <?php $i++; $_SESSION['total'] = $total;
			$link = SITE_PATH."".$items[0];  } }else{ echo "NO Record!"; } } ?>
  
</table>

</div>
</div>
<div class="order_total">
<div class="order_total_left">
<div class="order_total_left_title"><h2>Shipping Information</h2><span class="black_arrow"></span></div>
<div class="order_total_left_info_text">
<p><strong><?=$name?> </strong></p>
<p><?=$address?></p> 
<!--<p><?=$city?></p> -->
<p><?=$city?> - <?=$zipcode?></p>
<p><?=$state?></p>
</div>

</div>
<div class="order_total_right">
<div class="order_total_right1">
<div class="order_total_right1_left">
<p>Total Amount</p>
<p>Available Discount</p>
<p>Shipping Charges</p>
<br />
<p><strong>Payable Amount</strong></p>
</div>
<div class="order_total_right1_right">
<p><?php $ship=$cms->db_query("select * from #_order_summary where  orderid ='$orderid'"); 
		 $shipcharge=$cms->db_fetch_array($ship);@extract($shipcharge); 
		 $totaldiscount=$comboSavng+$periodSaving+$hotdealSaving+$overAlldiscount;
		 $payableAmount=($totalCost-$totaldiscount)+$shipping;
         echo $totalCost=$cms->price_format($totalCost);
		 ?></p>
<p><?=$cms->price_format($totaldiscount)?></p>
<p><?=$cms->price_format($shipping)?></p>
<br /><br />
<p><strong><?=$cms->price_format($payableAmount)?></strong></p>
</div>
</div>
<div class="order_total_right2">
<form name="" action="" method="post">
<input type="submit" name="success_orderbtn" id="success_orderbtn" value="Home" class="success_orderbtn_cls"/>
</form>
</div>
</div>
</div>
</div>
</div>