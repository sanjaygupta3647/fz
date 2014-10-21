<?php   
if(!$_SESSION[userid]){ 
$redpath = SITE_PATH."login";
$cms->redir($redpath,true);die;
}
if($cms->is_post_back()){ 
	    $check=$cms->getSingleresult("select count(*) from #_order_summary ");
		 if($check){
		 $getPid=$cms->getSingleresult("select pid from #_order_summary order by pid desc limit 0, 1");
		 }else{
		 $getPid = 0;
		 }
		 if(!$getPid){ 
				$arr[orderid] = date('dmY').'1001';
				
		 }else{			 
				$suff = $getPid+1001;
				$arr[orderid] = date('dmY').$suff;
		 }
		 $arr[submitdate] = date("Y-m-d h:i:s");
		 $_POST[submitdate] = date("Y-m-d h:i:s");
		 $arr[ssid] = session_id();
		 $arr[status] = 'pending';
		 $arr[amount] = $_SESSION['total'];
		 $arr[store_id] = $current_store_id;
		 $arr[uid] = $_SESSION['userid'];
		 $_POST[uid] = $_SESSION['userid'];
		
	 
		 $cms->sqlquery("rs","order_summary",$arr); 
		 //$getorderid = mysql_insert_id();
		 $_POST[orderid] = $arr[orderid];
		 if($arr[orderid]){ 
		 $rsAdmin_pros = $cms->db_query("select * from #_cart where `ssid`='".session_id()."' and store_user_id = '".$current_store_id."'");	
			while($arrAdmin_pros = $cms->db_fetch_array($rsAdmin_pros))
			{
				@extract($arrAdmin_pros);  
				$arr2 = array();
				$arr2[proid] = $proid; 				 
				$arr2[qty] = $qty;
				$arr2[urls] = $urls;
				$arr2[submitdate] = date("Y-m-d h:i:s");
				$arr2[amount] = $price;
				$arr2[ssid] = session_id();
				$arr2[store_id] = $current_store_id;
				$arr2[status] = "pending";
				$arr2[orderid] = $arr[orderid];
				$arr2[uid] = $_SESSION['userid'];
				$rsAdmin_orde = $cms->db_query("select * from #_orders_detail where `proid`='".$proid."' and `orderid`='".$arr[orderid]."' ");
				if(!mysql_num_rows($rsAdmin_orde)){
					$cms->sqlquery("rs","orders_detail",$arr2);
					$_SESSION['orderid']=$arr2[orderid];
				}
			} 
			$_POST[orderid] = $arr[orderid];
			$cms->db_query("delete from #_cart where `ssid`='".session_id()."' "); 
			$insert = $cms->sqlquery("rs","shipping_address",$_POST);			 
			if($insert){ 
			include "mailer_html.php";
			$redpath = SITE_PATH."success";
			//session_destroy();
			$cms->redir($redpath,true);die;
			}
		 }
		  
}
$rsAdmin2=$cms->db_query("select * from #_members where pid='".$_SESSION[userid]."'");
$result=$cms->db_fetch_array($rsAdmin2);
extract($result);
?>
 <?=$er?>
  <form  method="post" action="" onSubmit="return formvalid(this);"  >
  <input type="hidden" name="store_id" value="<?=$current_store_user_id?>" />
  <table width="50%" border="0" class="CSSTableGenerator" cellspacing="1" cellpadding="0"> 
  <tr style="color: #333333; height:30px;"><th align="left" colspan="2"> <h2>Please Fill The Shipping Detail</h2></th></tr> 
  <tr><td width="30%" align="left">Name:</td><td align="left"><input class="othr_flds" type="text" name="name" id="" title="Name" lang="R" value="<?=$fname." ".$lname?>" rel="Enter Name"></td></tr>
  <tr><td width="30%" align="left">Email:</td><td align="left"><input class="othr_flds" type="text" title="Email" name="email" id="email" value="<?=$email?>"   lang="RisEmail" ></td></tr>

   <tr><td width="30%" align="left">Mobile:</td><td align="left"><input class="othr_flds" type="text" name="mob"   title="Mobile" lang="R"  value="<?=$mob?>" ></td></tr>
    <tr><td width="30%" align="left">City:</td><td align="left">
	<?php  $sql_city1="select pid,city from #_city where country_id='80'";
	  $sql_city1_query=$cms->db_query($sql_city1);
	  ?>
	  <input type="hidden" name="country_id" value="80" />
	  <div class="label">
      <select class="nonzero select input_border othr_flds" lang="R" title="City" name="city" >
        <option value="">Select</option>
        <?php while($city_array=$cms->db_fetch_array($sql_city1_query)){  ?>
        <option value="<?php echo $city_array['city']; ?>" <? if($city==$city_array['city'])echo 'selected="selected"'; ?>><?php echo $city_array['city']; ?></option>
        <?php }?>
      </select>
    </div> </td></tr>
	<tr><td width="30%" align="left">State:</td><td align="left">
	<input class="othr_flds" type="text" name="state"   title="state" lang="R"  value="<?=$state?>" ></td></tr>
	<tr><td width="30%" align="left">Address:</td><td align="left">
	<textarea class="othr_flds" id=""  name="address"><?=nl2br($address)?></textarea></td></tr>

	<tr><td width="30%" align="left">Zipcode:</td><td align="left">
	<input class="othr_flds " type="text" name="zipcode" title="Zipcode" lang="R" value="<?=$zipcode?>" ></td></tr>

	<tr><td width="30%" align="left">Terms & Condition:</td><td align="left">
	<input   type="checkbox" name="t_s" title="Terms & Condition" lang="R"  > Please Accept Terms & Conditions 
	<a href="<?=SITE_PATH?>ms_file/page/terms-of-use" rel="popuprel" class="inline_popup" w='500px' h='650px' >Terms & Condition</a></td></tr>

	<tr><td width="30%" align="left">&nbsp;</td><td align="left">
	<input type="submit" class="sub_but" style="color:#FFFFFF; font-weight:bold;  background-color:#999999" name="submit" id="checkoutcnf" value="Confirm"></td></tr>
  </table>  
      
	 
   
    
 
<<<<<<< .mine
  </form>
=======
  <div class="checkout_order">
<h2>Fill Your Shipping Address :</h2>
<div class="checkout_order_div">
<div class="checkout_order_left">
<h1>Enter your shipping details :</h1>
<form name="" method="post" action="">
<div class="checkout_fields">
<div class="checkout_fields1">
<div class="checkout_fields_left">Name :</div>
<div class="checkout_fields_right"><input type="text" name="checkout_name" id="checkout_name" class="check_input_field" placeholder="Enter your Name" /></div>
</div>
<div class="checkout_fields1">
<div class="checkout_fields_left">Pin Code :</div>
<div class="checkout_fields_right"><input type="text" name="checkout_name" id="checkout_name" class="check_input_field" placeholder="6 Digit Pin code" /></div>
</div>
<div class="checkout_fields1">
<div class="checkout_fields_left">Address :</div>
<div class="checkout_fields_right"><textarea placeholder="Enter your Address" class="check_textarea_field" cols="5" rows="5"></textarea></div>
</div>
<div class="checkout_fields1">
<div class="checkout_fields_left">Landmark :</div>
<div class="checkout_fields_right"><input type="text" name="checkout_name" id="checkout_name" class="check_input_field" placeholder="Your Landmark" /></div>
</div>
<div class="checkout_fields1">
<div class="checkout_fields_left">City :</div>
<div class="checkout_fields_right">
<select class="check_select_field">
<option value="New Delhi">New Delhi</option>
<option value="Ghaziabad">Ghaziabad</option>
<option value="Sonepat">Sonepat</option>
<option value="Banaras">Banaras</option>
<option value="Ilahabad">Ilahabad</option>
</select>
</div>
</div>
<div class="checkout_fields1">
<div class="checkout_fields_left">State :</div>
<div class="checkout_fields_right"><input type="text" name="checkout_name" id="checkout_name" class="check_input_field" placeholder="Enter your State" /></div>
</div>
<div class="checkout_fields1">
<div class="checkout_fields_left">Phone :</div>
<div class="checkout_fields_right"><input type="text" name="checkout_name" id="checkout_name" class="check_input_field" placeholder="Enter your Mobile No." /></div>
</div>
</div>
</form>
</div>
<div class="checkout_order_right">
<div class="right_check_text">
<div class="right_check_text_title">
<h3>Order Summary</h3><span class="black_right_arrow"></span>
</div>
<div class="right_check_text_info">
<div class="right_check_text_info_left">
<p>2</p>
<p>Rs. 5999</p>
<p>Rs. 5999frjuyutyu</p>
</div>
<div class="right_check_text_info_right">
<p>Purchased Items :</p>
<p>Total Amount :</p>
<p>Payable Amount :</p>
</div>
</div>
</div>

<div class="right_check_text">
<div class="right_check_text_title">
<a href="Javascript:void(0)">Change address</a>
<h3>Shipping Address</h3><span class="black_right_arrow"></span>
</div>
<div class="right_check_text_info">
<div class="right_check_text_info_right">
<p>Devesh Srivastava</p>
<p>S/O Siddhesh Srivastava</p>
<p>T./7 Sector 12, Noida</p>
<p>Gautam Buddha Nagar,
Uttar Pradesh,  201301.</p>
</div>
</div>
>>>>>>> .r261
</div>
<div class="purchase_button">
<input type="button" name="check_proceed" id="check_proceed" value="Save & Continue" class="check_proceed_cls"/>
</div>
</div>
</div>
</div>
 