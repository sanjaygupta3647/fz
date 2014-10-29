<? if($items[3])
	{  
	   
	  $qry = $cms->db_query("SELECT noOfDays,amount,noOfMessage FROM #_plans_hosting where pid ='".$_SESSION[planID]."'  ");
	  $res = $cms->db_fetch_array($qry);
	  $qry_sms = $cms->db_query("SELECT amount FROM #_sms_pack where pid ='".$_SESSION[sms_pack]."'  ");
	  $res_sms = $cms->db_fetch_array($qry_sms);
	  $err = 0;
      $qry_var1 = $cms->db_query("SELECT voucherCode,amount,pinfor,validtill,status FROM #_gift_voucher where voucherCode ='".$cms->encryptcode($items[3])."' and generatedByadmin='0'");
	  if(mysql_num_rows($qry_var1)){
		  $res1 = $cms->db_fetch_array($qry_var1);
		  $voucher=$cms->decryptcode($res1['voucherCode']);
		  $today = date("Y-m-d");
		  
		  if($res1['validtill']!='0000-00-00'){
				if($today>$res1['validtill']){
					$err = 1;
					echo '<p class="red_p1 cpn">Sorry this coupon is expired now!</p>';
				}
		  }
		  if($res1['status']=='Inactive'){ 
					$err = 1;
					echo '<p class="red_p1 cpn">Sorry this coupon is expired now!</p>'; 
		  }
	  }else{
					$err = 1;
					echo '<p class="red_p1 cpn">Sorry invalid coupon code!</p>'; 
	  }
      if($err == 0){
		  if($_SESSION[planID]){
			  $dueAmount=$res[amount]-$res1['amount'];
			  if($res1['pinfor']=='freeshop'){
				$dueAmount = 0;
				$dis =  $res['amount']; 
			  }else{
				$dis = $res1['amount'];
			  }
		   }else{
			  $dueAmount=$res_sms[amount]-$res1['amount'];
			  if($res1['pinfor']=='freeshop'){
				$dueAmount = $res_sms[amount];
				$dis = $res_sms['amount'];
			  }else{
				$dis = $res1['amount'];
			  }
		   }
		    
		   
		   ?>
		   <p>Discount for Coupon = Rs.<?=$dis?> /-</p>  
	       <p>Payable Amount = Rs.<?=$dueAmount?></p><?php 
	  
	  }


	   
	
	 	
	} 
	
	 
?>

