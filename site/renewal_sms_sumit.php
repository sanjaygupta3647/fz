<?php
$regMode =  $cms->getSingleresult("select registrationBy from fz_setting "); 
$metaTitle = $cms->getSingleresult("select meta_title from #_meta_info where url='member-login' and store_user_id = '0'");
$metaIntro = $cms->getSingleresult("select meta_description from #_meta_info where url='member-login' and store_user_id = '0'");
$metaKeyword = $cms->getSingleresult("select meta_keyword from #_meta_info where url='member-login' and store_user_id = '0'") ;  
if($_POST[sms_pack]){
	$_SESSION[sms_pack] = $_POST[sms_pack];
} 

$qry = $cms->db_query("SELECT * from #_sms_pack where pid ='".$_SESSION[sms_pack]."'  ");
$res = $cms->db_fetch_array($qry); 
if($_POST[proceed_pay]){
	//$brandId = $cms->getSingleresult("select pid from #_brand where brand_owner ='".$_SESSION[uid]."' "); 
	$err = 0;
	if($_SESSION[ren_store_id]==''){
		$err = 1;
		$errms .= "Previous session expired,please go for first step again! <br/>";
	}
	if($_SESSION[sms_pack]==''){
		$err = 1;
		$errms .= "Previous session expired,please go for first step again! <br/>";
	}
	if($regMode=='coupon'){
		if(!$_POST[vaucher]){
			$err = 1; $errms .= "Registration is allowed only with coupon!  <br/>";
		}
	} 
	if($_POST[vaucher]){
	$qry_var = $cms->db_query("SELECT voucherCode,pinfor,validtill,status,amount,pid FROM #_gift_voucher where voucherCode ='".$cms->encryptcode($_POST[voucherCode])."' and generatedByadmin='0' ");
	 if(mysql_num_rows($qry_var)){
			$arr3 = $cms->db_fetch_array($qry_var);
			$today = date("Y-m-d");
			if($arr3['validtill']!='0000-00-00'){
			  if($today>$arr3['validtill']){
				 $err = 1;
				 $errms .= "Sorry this coupon is expired now!"; 
			  }
			}
			if($arr3['status']=='Inactive'){ 
			 $err = 1;  $errms .= "Sorry this coupon is expired now!"; 
			}

		}else{
			$err = 1; $errms .= "Sorry invalid coupon code!<br/>";
		}
		if(!$err){
			$dueAmount=$res[amount]-$arr3['amount'];
			if($arr3['pinfor']=='freeshop'){
				$arr3['amount'] = $res[amount]; 
				$dueAmount = 0;
			}
			
			$couponLog[voucherCode]=$_POST[voucherCode];
			$couponLog[plan_id] = $_SESSION[sms_pack]; 
			$couponLog[voucherValue] =$arr3['amount'];
			$couponLog[status]="SMS_renewal";
			$couponLog[user_id] =$_SESSION[ren_store_id];  
			$couponLog[generatedByadmin]=0;
			$couponLog[total_amont] = $res[amount]; 
			$couponLog[due_amount]=$dueAmount; 
			$couponLog[trans_status]="sucsess"; 
			if($regMode=='coupon' && $dueAmount>0){ 
				$err = 1;
				$errms .= "Renewal is allowed only with coupon!  <br/>";
			}
			if(!$err){
				$cms->sqlquery("rs","voucher_log",$couponLog);  
				$couponreg = mysql_insert_id();
				if($arr3['validtill']=='0000-00-00'){  
					$cms->db_query("update #_gift_voucher set status='Inactive' where voucherCode ='".$cms->encryptcode($_POST[voucherCode])."' ");
				}
			}
		}
	} 
	if($err!=1){  
		$user = $cms->db_query("SELECT plan_id,noOfDays,noOfMessage,store_user_id FROM #_store_detail where store_user_id='".$_SESSION[ren_store_id]."' ");
		$data = $cms->db_fetch_array($user);

		/** Main Renual Code **/ 
		$ren[sms_planid] =$_SESSION[sms_pack];
		$ren[type]="sms_renewal"; 
		$ren[total_amount] = $res[amount];
		$ren[user_id]=$_SESSION[ren_store_id];
		$cms->sqlquery("rs","reg_renewal_sms",$ren);
		/** Main Renual Code **/  

		$noOfMessage = $cms->getSingleresult("select noOfMessage from #_store_detail  where store_user_id ='".$_SESSION[ren_store_id]."' "); 
		$total_msg=$noOfMessage + $res[qty] ;
		//$cms->sqlquery("rs","voucher_log",$arr3);
		 
		 
		$cms->db_query("update #_store_detail set noOfMessage='$total_msg' where store_user_id ='".$_SESSION[ren_store_id]."' ");  
		$_POST = false;
		$_SESSION[mess_registration] = "Thank you for successfull Renewal Your SMS Plan on fizzkart.com!"; 
		$cms->renewal_sms($_SESSION[ren_store_id]); 
		$number = $cms->getSingleresult("select mobile from #_store_user where  pid = '".$_SESSION[ren_store_id]."'"); 
		$mess= "Thank you for successfull Renewal Your Web Hosting on fizzkart.com!";
		$cms->sendSms($number,$mess,0); 
		$red = SITE_PATH."message";
		unset($_SESSION[sms_pack]);
		header("location: ".$red);die;   
	} 
 }

	?>
 
<div class="cl"></div>
 
<div class="contentarea">
  <div class="renew_submit-main">
    <div class="renew_submit-div1">
	   <?php if($errms!="") {?><p style="color:red"><?=$errms?> </p> <?php }?>
      <p><strong>Plan  Name :</strong><b><?=$res[sms_pack]?></b></p> 
    </div>
	<form action="" method="post" autocomplete="off" >
		 <input type="hidden" value="log" name="log"  />
          <input type="hidden" name="sms_pack" value="<?=$_SESSION[sms_pack]?>" />
		  <input type="hidden" name="tamount"  value="<?=$res[amount]?>">
    <div class="renew_submit-div2">
     <input type="checkbox" name="vaucher" <?=($regMode=='coupon')?'checked':''?>   id="vaucher" />     
      <span>Do You Have Voucher Code ?</span> </div>
    <div class="renew_submit-div3" id="renew_submit-div3" <?=($regMode=='coupon')?'':'style="display:none"'?>>
    <div class="field_div">
     <div class="autoUpdate"> <input type="text" name="voucherCode" value=""  lang="R" id="vaucher_copon" placeholder="Enter Your Voucher Code here" /><span id="txtHint2"><?=$er?>  </span></div>  
        <!--<input type="text" name="voucher_field" id="voucher_field" placeholder="Enter Your Voucher Code here" /> -->
      </div>
       
      <div class="status_div">
	    
      </div>
	 </div>
      <div class="discount_allow-div" id="dis-calc"> 
      </div>
    
    <div class="renew_submit-div4">
     
    <p align="left">
	
    <input type="submit" name="proceed_pay" id="proceed_pay" value="Proceed to Pay" />
	 </p>
	</form>
	</div>
    </div>
  </div> 
  
 
