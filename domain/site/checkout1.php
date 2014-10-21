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
				}
			} 
			$_POST[orderid] = $arr[orderid];
			$cms->db_query("delete from #_cart where `ssid`='".session_id()."' "); 
			$insert = $cms->sqlquery("rs","shipping_address",$_POST);			 
			if($insert){ 
			include "mailer_html.php";
			$redpath = SITE_PATH."success";
			session_destroy();
			$cms->redir($redpath,true);die;
			}
		 }
		  
}
$rsAdmin2=$cms->db_query("select * from #_members where pid='".$_SESSION[userid]."'");
$result=$cms->db_fetch_array($rsAdmin2);
extract($result);
?>

  <?=$er?>
 
  <div class="checkout_order">
<h2>Fill Your Shipping Address :</h2>
<div class="checkout_order_div">
<div class="checkout_order_left">

</div>
<div class="checkout_order_right"></div>
</div>
</div>
 