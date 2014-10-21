<?php
			$metaTitle = $cms->getSingleresult("select meta_title from #_meta_info where url='member-login' and store_user_id = '0'");
			$metaIntro = $cms->getSingleresult("select meta_description from #_meta_info where url='member-login' and store_user_id = '0'");
			$metaKeyword = $cms->getSingleresult("select meta_keyword from #_meta_info where url='member-login' and store_user_id = '0'") ; 
			
			$noOfMessage = $cms->getSingleresult("select noOfMessage from #_store_detail  where store_user_id ='".$_SESSION[ren_store_id]."' ");
			$currentUse = $cms->getSingleresult("select count(*) from #_message_stats  where store_id ='".$_SESSION[ren_store_id]."' ");
		    $remmsg = $noOfMessage-$currentUse;
			$name = $cms->getSingleresult("select name from #_store_user where  pid = '".$_SESSION[ren_store_id]."'"); 
			$sms_pack_name = $cms->getSingleresult("select sms_pack from fz_sms_pack where  pid = '".$_POST[sms_pack]."'");
			$sms_pack = $_POST[sms_pack];
			$_SESSION[sms_pack]=$sms_pack;
			$qry = $cms->db_query("SELECT * from #_sms_pack where pid ='$sms_pack'  ");
			$res = $cms->db_fetch_array($qry);   
if($cms->is_post_back()){
			//$brandId = $cms->getSingleresult("select pid from #_brand where brand_owner ='".$_SESSION[uid]."' "); 
			$err = 0;
			if($_SESSION[ren_store_id]==''){
				$err = 1;
				$errms .= "Previous session expired,please go for first step again! <br/>";
			}
			if($_POST[sms_pack]==''){
				$err = 1;
				$errms .= "Previous session expired,please go for first step again! <br/>";
			} 
			if($_POST[log]==''){
				$err = 1; 
				$errms .= "Previous session expired,please go for first step again! <br/>";
			} 
			if($_POST[tamount]==''){
				$err = 1; 
				$errms .= "Previous session expired,please go for first step again! <br/>";
			}  
			 
			if($err!=1){ 
				 if($sms_pack){ 
						$total_amount=$cms->price_format($res[amount]) ;  
						//$no_OfMessage= $res[noOfMessage]; 
						$qry_var = $cms->db_query("SELECT voucherCode,amount,pid FROM #_gift_voucher where voucherCode ='".$cms->encryptcode($_POST[voucherCode])."' ");
						$arr3 = $cms->db_fetch_array($qry_var);
						$voucher=$cms->decryptcode($arr3[voucherCode]); 
						$user = $cms->db_query("SELECT plan_id,noOfDays,noOfMessage,store_user_id FROM #_store_detail where store_user_id='".$_SESSION[ren_store_id]."' ");
						$data = $cms->db_fetch_array($user);
						$arr3[sms_planid] =$_SESSION[sms_pack];
						$arr3[type]="sms_renewal";
						$arr3[coupon_id] =$arr3[pid];
						$arr3[coupon_amount]=$arr3[amount];	  
						$arr3[total_amount] = $res[amount];
						$arr3[user_id]=$data[store_user_id]; 
					       
						if($remmsg<0){
							$noOfDays=0; 
                        }else{
							$noOfDays=$remmsg;
						} 
						$total_msg=$noOfMessage + $res[qty] ;
						//$cms->sqlquery("rs","voucher_log",$arr3);
						$cms->sqlquery("rs","reg_renewal_sms",$arr3);
						$cms->sqlquery("rs","renewal_sms",$arr3);
						if($voucher==$_POST[voucherCode]){
						$cms->db_query("update #_gift_voucher set status='Inactive' where voucherCode ='".$cms->encryptcode($_POST[voucherCode])."' ");     
							   }  
						$cms->db_query("update #_store_detail set noOfMessage='$total_msg' where store_user_id ='".$arr3[user_id]."' ");  
						$_POST = false;
						$_SESSION[mess_registration] = "Thank you for successfull Renewal Your SMS Plan on fizzkart.com!"; 
						$cms->renewal_sms($arr3[user_id]); 
						$number = $cms->getSingleresult("select mobile from #_store_user where  pid = '".$_SESSION[ren_store_id]."'"); 
						$mess= "Thank you for successfull Renewal Your Web Hosting on fizzkart.com!";
						$cms->sendSms($number,$mess,0); 
						$red = SITE_PATH."message";
                        unset($_SESSION[sms_pack]);
				        header("location: ".$red);die; 
						 
				   }
			} 
 }

	?>
 
<div class="cl"></div>
 
<div class="contentarea">
  <div class="renew_submit-main">
    <div class="renew_submit-div1">
      <p><strong>Plan  Name :</strong><b><?=$sms_pack_name?></b></p> 
    </div>
	<form action="" method="post" autocomplete="off" >
		 <input type="hidden" value="log" name="log"  />
          <input type="hidden" name="sms_pack" value="<?=$sms_pack?>" />
		  <input type="hidden" name="tamount"  value="<?=$res[amount]?>">
    <div class="renew_submit-div2">
     <input type="checkbox" name="vaucher"   id="vaucher" />     
      <span>Do You Have Voucher Code ?</span> </div>
    <div class="renew_submit-div3" id="renew_submit-div3" style="display:none">
    <div class="field_div">
     <div class="autoUpdate"> <input type="text" name="voucherCode" value=""  lang="R" id="vaucher_copon" placeholder="Enter Your Voucher Code here" /><span id="txtHint2"><?=$er?>  </span></div>  
        <!--<input type="text" name="voucher_field" id="voucher_field" placeholder="Enter Your Voucher Code here" /> -->
      </div>
      <div class="validate_div" style="display:none"> <a href="Javascript:void(0)">Validate Coupon</a> </div>
      <div class="status_div">
	    <p class="red_p1 cpn"  hidden="hidden"> Coupon Allrady Used!</p>
        <p class="red_p cpn"  hidden="hidden">Invalid Coupon Code!</p>
        <p class="green_p cpn" hidden="hidden">Valid Coupon Code!</p>
      </div>
	 </div>
      <div class="discount_allow-div" id="dis-calc"> 
      </div>
    
    <div class="renew_submit-div4">
    <p id="defaltshow">Payable Amount = Rs.<?=$res[amount]?> /-</p>
	<br>
    <p align="left">
	
    <input type="submit" name="proceed_pay" id="proceed_pay" value="Proceed to Pay" />
	 </p>
	</form>
	</div>
    </div>
  </div> 
  
 
