<?php
			$metaTitle = $cms->getSingleresult("select meta_title from #_meta_info where url='member-login' and store_user_id = '0'");
			$metaIntro = $cms->getSingleresult("select meta_description from #_meta_info where url='member-login' and store_user_id = '0'");
			$metaKeyword = $cms->getSingleresult("select meta_keyword from #_meta_info where url='member-login' and store_user_id = '0'");
			
		 	$plan_id = $cms->getSingleresult("select plan_id from #_store_detail where  pid = '".$_SESSION[ren_store_id]."'");
			$type = $cms->getSingleresult("select type from #_store_user where  pid = '".$_SESSION[ren_store_id]."'");
			$noOfDays = $cms->getSingleresult("select noOfDays from #_store_detail where  store_user_id = '".$_SESSION[ren_store_id]."'"); 
			$amount = $cms->getSingleresult("select amount from #_store_detail where  store_user_id = '".$_SESSION[ren_store_id]."'");
			
			$numOfProducts = $cms->getSingleresult("select t1.noOfProducts from #_plans as t1, #_store_detail as t2 where t2.pid ='".$_SESSION[ren_store_id]."' and t1.pid= t2.plan_id");
			$total = $cms->getSingleresult("select count(*) from #_products_user where store_user_id ='".$_SESSION[ren_store_id]."' ");
			
			$noOfMessage = $cms->getSingleresult("select noOfMessage from #_store_detail  where store_user_id ='".$_SESSION[ren_store_id]."' ");
			$currentUse = $cms->getSingleresult("select count(*) from #_message_stats  where store_id ='".$_SESSION[ren_store_id]."' ");
		    $remmsg = $noOfMessage-$currentUse;
			$name = $cms->getSingleresult("select name from #_store_user where  pid = '".$_SESSION[ren_store_id]."'"); 
			
if($cms->is_post_back()){
			//$brandId = $cms->getSingleresult("select pid from #_brand where brand_owner ='".$_SESSION[uid]."' "); 
			$err = 0;
			if($_SESSION[ren_store_id]==''){
				$err = 1;
				$errms .= "Previous session expired,please go for first step again! <br/>";
			}
			if($_POST[plan_ID]==''){
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
			  
			 
			 $plan_ID = $_POST[plan_ID];
			 $_SESSION[planID]=$plan_ID;
			 $qry = $cms->db_query("SELECT pid,noOfDays,noOfMessage,amount FROM `#_plans_hosting` where pid ='$plan_ID'  ");
			 $res = $cms->db_fetch_array($qry);
			if($err!=1){ 
				 if($plan_ID){
					    $create_date = $cms->getSingleresult("select create_date from #_store_detail where  store_user_id = '".$_SESSION[ren_store_id]."'");
			            $reCreate_date = $cms->getSingleresult("select create_date from #_reg_renewal where user_id = '".$_SESSION[ren_store_id]."' order by pid desc limit 1");
                        if($reCreate_date){
							$create_date=$reCreate_date;
						} 
						$qry = $cms->db_query("SELECT pid,noOfDays,noOfMessage,amount FROM `#_plans_hosting` where pid ='$plan_ID'  ");
						$res = $cms->db_fetch_array($qry);
						$no_OfDays=$res[noOfDays];
						$total_amount=$cms->price_format($res[amount]) ;  
						$no_OfMessage= $res[noOfMessage]; 
						$qry_var = $cms->db_query("SELECT voucherCode,amount,pid FROM #_gift_voucher where voucherCode ='".$cms->encryptcode($_POST[voucherCode])."' ");
						$arr3 = $cms->db_fetch_array($qry_var);
						$voucher=$cms->decryptcode($arr3[voucherCode]); 
						$user = $cms->db_query("SELECT plan_id,noOfDays,noOfMessage,store_user_id FROM #_store_detail where store_user_id='".$_SESSION[ren_store_id]."' ");
						$data = $cms->db_fetch_array($user);
						$arr3[plan_id] =$data[plan_id];
						$arr3[type]="renewal";
						$arr3[coupon_id] =$arr3[pid];
						$arr3[coupon_amount]=$arr3[amount];	  
						$arr3[total_amount] = $res[amount];
						$arr3[user_id]=$data[store_user_id];
						$noOfDays=$data[noOfDays];
						$noOfMessage=$data[noOfMessage]; 
					    $RemainDays=$noOfDays-$cms->getRemainDays($create_date);  
						if($RemainDays<0){
							$noOfDays=0; 
                        }else{
							$noOfDays=$RemainDays;
						}	
						$total_day=$noOfDays + $no_OfDays;
						$total_msg=$noOfMessage + $no_OfMessage;
						//$cms->sqlquery("rs","voucher_log",$arr3);
						$cms->sqlquery("rs","reg_renewal",$arr3);
						$cms->sqlquery("rs","renewal_sms",$arr3);
						if($voucher==$_POST[voucherCode]){
						$cms->db_query("update #_gift_voucher set status='Inactive' where voucherCode ='".$cms->encryptcode($_POST[voucherCode])."' ");     
							   }  
						$cms->db_query("update #_store_detail set noOfDays='$total_day',noOfMessage='$total_msg',amount='".$arr3[total_amount]."' where store_user_id ='".$arr3[user_id]."' ");  
						$_POST = false;
						$_SESSION[mess_registration] = "Thank you for successfull Renewal Your Web Hosting on fizzkart.com!"; 
						$cms->renewal_hosting($arr3[user_id]); 
						$number = $cms->getSingleresult("select mobile from #_store_user where  pid = '".$_SESSION[ren_store_id]."'"); 
						$mess= "Thank you for successfull Renewal Your Web Hosting on fizzkart.com!";
						$cms->sendSms($number,$mess,0); 
						$red = SITE_PATH."message";
				        header("location: ".$red);die; 
						 
				   }
			} 
 }

	?>
 
<div class="cl"></div>
 
<div class="contentarea">
  <div class="renew_submit-main">
    <div class="renew_submit-div1">
      <p><strong>Customer Name :</strong><b><?=$name?></b></p>
      <p><strong>Plan you have choosed :</strong><?=$res[noOfDays]. ' Days /'.$cms->price_format($res[amount])?> / <?=$res[noOfMessage]?> Message</p>
    </div>
	<form action="" method="post" autocomplete="off" >
		 <input type="hidden" value="log" name="log"  />
          <input type="hidden" name="plan_ID" value="<?=$plan_ID?>" />
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
	<input type="hidden" name="tamount" value="<?=$res[amount]?>"><br>
    <p align="left">
    <input type="submit" name="proceed_pay" id="proceed_pay" value="Proceed to Pay" />
	 </p>
	</form>
	</div>
    </div>
  </div> 
  
 
