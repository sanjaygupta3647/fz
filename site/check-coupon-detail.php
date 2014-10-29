<? if($items[3])
	{  
	  $qry = $cms->db_query("SELECT noOfDays,amount,noOfMessage FROM #_plans_hosting where pid ='".$_SESSION[planID]."'  ");
	  $res = $cms->db_fetch_array($qry);
	  $qry_sms = $cms->db_query("SELECT amount FROM #_sms_pack where pid ='".$_SESSION[sms_pack]."'  ");
	  $res_sms = $cms->db_fetch_array($qry_sms);
      $qry_var1 = $cms->db_query("SELECT voucherCode,pinfor,validtillamount,status FROM #_gift_voucher where voucherCode ='".$cms->encryptcode($items[3])."'");
	  $res1 = $cms->db_fetch_array($qry_var1);
	  $voucher=$cms->decryptcode($res1['voucherCode']);
	   if($_SESSION[planID]){
		  $dueAmount=$res[amount]-$res1['amount'];
	   }else{
		  $dueAmount=$res_sms[amount]-$res1['amount'];
	   }
	 if($status=$res1['status']=='Inactive'){
	   echo $er= '1';
	   }
	   else if($voucher==$items[3]){?> 
	   <p class="green_p cpn">Discount for Coupon = Rs.<?=$res1['amount']?> /-</p>  
	   <p class="green_p cpn">Payable Amount = Rs.<?=$dueAmount?></p> 
	   <?php
	 				 
	  }else{ 
	     echo "0"; 
	  } 	
	} 
	
	 
?>

