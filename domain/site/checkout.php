<?php   
if((!$_SESSION[userid]) and ($_GET[type]!='guest')){ 
	$redpath = SITE_PATH."user-login";
	$cms->redir($redpath,true);die;
}  
$ssid=session_id(); 
$cartArr=$cms->getOfferProduct($ssid,$current_store_user_id);  
//echo "Preview: <br/><pre>"; print_r($cartArr);echo "</pre><br/>";
if($cms->is_post_back()){ 
	$checkShipping = $cms->getSingleresult("select count(*) from #_shipping_area_store where pincode = '".$_POST[zipcode]."'
			  and store_user_id = '".$current_store_user_id."' and status = 'Active'"); 
		$_SESSION[pincode]=$_POST[zipcode];	  
	if($checkShipping){
		$getPid=(int)$cms->getSingleresult("select pid from #_order_summary ");
		$getPid = $getPid+1; 
		$arr[orderid]=$getPid.$cms->generateOrderid();
		$arr[submitdate] = date("Y-m-d h:i:s"); 
		$arr[ssid] = session_id();
		$arr[status] = 'pending';
		$arr[paynet] = $cartArr['paynet'];
		$arr[totalCost] = $cartArr['totalCost'];
		$arr[comboSavng] = $cartArr['comboSavng'];
		$arr[periodSaving] = $cartArr['periodSaving'];
		$arr[hotdealSaving] = $cartArr['hotdealSaving'];
		$arr[overAlldiscount] = $cartArr['overAlldiscount'];
		$arr[shipping] = $cartArr['allshipping'];
		$arr[store_id] = $current_store_id;
		$arr[uid] = $_SESSION['userid']; 
		if($arr[paynet]){
		$cms->sqlquery("rs","order_summary",$arr);  
		}
		$rsAdmin_pros = $cms->db_query("select * from #_cart where `ssid`='".session_id()."' and store_user_id = '".$current_store_id."'");	
		while($arrAdmin_pros = $cms->db_fetch_array($rsAdmin_pros)){@extract($arrAdmin_pros);  			
			$arr2 = array();
			$arr2[proid] = $proid; 				 
			$arr2[qty] = $qty;
			$arr2[comboid] = $comboid;
			$arr2[urls] = $urls;
			$arr2[submitdate] = date("Y-m-d h:i:s");
			$arr2[amount] = $price;
			$arr2[ssid] = session_id();
			$arr2[store_id] = $current_store_id;
			$arr2[status] = "pending";
			$arr2[orderid] = $arr[orderid];
			$arr2[uid] = $_SESSION['userid']; 
			$rsAdmin_orde = $cms->db_query("select * from #_orders_detail where `proid`='".$arr2[proid]."' and `orderid`='".$arr[orderid]."' ");
			if(!mysql_num_rows($rsAdmin_orde)){
				if($arr2[amount]){
				$cms->sqlquery("rs","orders_detail",$arr2);
	        	}
			} 
		} 
		$cms->db_query("delete from #_cart where `ssid`='".session_id()."' and store_user_id = '".$current_store_id."' "); 
		$_POST[orderid] = $arr[orderid];
		$insert = $cms->sqlquery("rs","shipping_address",$_POST);			 
		if($insert){ 
		    $_SESSION['orderid']=$arr[orderid];
			include "mailer_html.php";
			$redpath = SITE_PATH."success"; 
			$cms->redir($redpath,true);die;
		}
	}else{
		$err = '<p style="color:red">Shipping for this area code is not available!</p>';
	} 		
}
		  
 
$rsAdmin_pros1 = $cms->db_query("select qty from #_cart where `ssid`='".session_id()."' and store_user_id = '".$current_store_id."'");
while($res = $cms->db_fetch_array( $rsAdmin_pros1)){ 
	$qty=$qty+$res[qty];
}  
if($_SESSION[userid]){
	
	 $shipping = $cms->getSingleresult("select zipcode from #_members where pid='".$_SESSION[userid]."'"); 
	 if($shipping==$_SESSION[pincode]){
		 $rsAdmin2=$cms->db_query("select * from #_members where pid='".$_SESSION[userid]."'");
		 $result=$cms->db_fetch_array($rsAdmin2);
		 extract($result); 
	 }
}
?>

  <?=$er?>
 
  <div class="checkout_order">
<h2>Fill Your Shipping Address :</h2>
<div class="checkout_order_div">
<div class="checkout_order_left">
<h1>Enter your shipping details :</h1>
<form name="" method="post" action="" onsubmit="return formvalid(this);">
<div class="checkout_fields">
<div class="checkout_fields1">
<div class="checkout_fields_left">Name :</div>
<div class="checkout_fields_right"><input type="text" name="name" id="checkout_name" title="Name" lang="R" value="<?=$fname." ".$lname?>" class="check_input_field" placeholder="Enter your Name" /></div>
</div>
<div class="checkout_fields1">
<div class="checkout_fields_left">Pin Code :</div>
<div class="checkout_fields_right">
<?php $zipcode  = ($_POST[zipcode])?$_POST[zipcode]:$_SESSION[pincode];?>
<input type="text" name="zipcode" id="checkout_name" title="Zipcode" lang="R" value="<?=$zipcode?>"  class="check_input_field" placeholder="6 Digit Pin code" />
 <?=$err?> 
</div>
</div>
<div class="checkout_fields1">
<div class="checkout_fields_left">Address :</div>
<div class="checkout_fields_right"><textarea lang="R" title="Shipping Address" placeholder="Enter your Address" class="check_textarea_field" cols="5" rows="5" name="address"><?=nl2br($address)?></textarea></div>
</div>
<div class="checkout_fields1">
 <div class="checkout_fields_left">Email Id :</div>
<div class="checkout_fields_right"><input type="text" name="email" title="Email" id="email" value="<?=$email?>"   lang="RisEmail" class="check_input_field" placeholder="Enter Your Email Addres" /></div>
</div> 
<div class="checkout_fields1">
<div class="checkout_fields_left">City :</div>
<div class="checkout_fields_right">
<?php  $sql_city1="select pid,city from #_city where country_id='80'";
	  $sql_city1_query=$cms->db_query($sql_city1);
	  ?>
	  <input type="hidden" name="country_id" value="80" />
<select class="check_select_field" lang="R" title="City" name="city" >
<option value="">Select</option>
        <?php while($city_array=$cms->db_fetch_array($sql_city1_query)){  ?>
        <option value="<?php echo $city_array['city']; ?>" <? if($city==$city_array['city'])echo 'selected="selected"'; ?>><?php echo $city_array['city']; ?></option>
        <?php }?>
      </select>
</div>
</div>
<div class="checkout_fields1">
<div class="checkout_fields_left">State :</div>
<div class="checkout_fields_right"><input type="text" name="state" id="checkout_name" class="check_input_field" placeholder="Enter your State"  title="State" lang="R"  value="<?=$state?>" /></div>
</div>
<div class="checkout_fields1">
<div class="checkout_fields_left">Phone :</div>
<div class="checkout_fields_right"><input type="text" name="mob" id="checkout_name" title="Mobile" lang="R"  value="<?=$mob?>"  class="check_input_field" placeholder="Enter your Mobile No." /></div>
</div>
<div class="checkout_fields1">
<div class="checkout_fields_left">&nbsp;</div>
<div class="checkout_fields_right">
<input type="checkbox" name="t_s" title="Terms & Condition" lang="R" /> Please Accept Terms & Conditions 
<a href="<?=SITE_PATH?>ms_file/page/terms-of-use" rel="popuprel" class="inline_popup" w='500px' h='650px' target="_blank">Terms & Condition</a>
</div>
</div>
</div>
 
</div>
<div class="checkout_order_right">
<div class="right_check_text">
<div class="right_check_text_title">
<h3>Order Summary</h3><span class="black_right_arrow"></span>
</div>
<div class="right_check_text_info">
<div class="right_check_text_info_left">
<p><?=$cms->getSingleresult("select count(*) from #_cart where  ssid = '".session_id()."' and  store_user_id = '".$current_store_user_id."'")?></p>
<p><?=$cms->price_format($cartArr[totalCost])?></p>
<p><?=$cms->price_format($cartArr[paynet])?></p>
</div>
<div class="right_check_text_info_right">
<p>Purchased Items :</p>
<p>Total Amount :</p>
<p>Payable Amount :</p>
</div>
</div>
</div>

<div class="right_check_text"  style="display:none;">
<div class="right_check_text_title">
<!--<a href="Javascript:void(0)">Change address</a> -->
<h3>Shipping Address</h3><span class="black_right_arrow"></span>
</div>
<div class="right_check_text_info">
<div class="right_check_text_info_right">
<p><?=$fname." ".$lname?></p>
<p><?=nl2br($address)?></p>
<p><?=$city?></p>
<p><?=$state?>,
 <?=$zipcode?>.</p>
</div>
</div>
</div>
<div class="purchase_button">
<input type="submit"  class="sub_but check_proceed_cls" name="submit" id="checkoutcnf" value="Save & Continue"  />
</form>
</div>
</div>
</div>
</div>
 